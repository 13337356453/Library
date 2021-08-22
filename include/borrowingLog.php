<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/DBTool.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/classes/Book.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/classes/User.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/tools/Is_Librarian.php';
if (is_librarian()) {

    if (isset($_POST['i']) && isset($_POST['key'])) {
        $status = 300;
        $i = $_POST['i'];
        $key = $_POST['key'];
        $sql = "";
        $db = new DBTool();
        $arr = [];
        switch ($i) {
            case 1:
                $bid = $db->executeQuery("select id from book where name=?", [$key])->fetchAll()[0]['id'];
                $stmt = $db->executeQuery("select * from borrowing_log where book_id=?", [$bid]);
                while ($row = $stmt->fetch()) {
                    $uid = $row['user_id'];
                    $time = $row['time'];
                    $backed = $row['backed'];
                    $user = new User();
                    $user->setAll($uid);
                    $uname = $user->getName();
                    array_push($arr, array($uname, $key, $time, $backed));
                }
                break;
            case 2:
                $uid = $db->executeQuery("select id from user where name=?", [$key])->fetchAll()[0]['id'];
                $stmt = $db->executeQuery("select * from borrowing_log where user_id=?", [$uid]);
                while ($row = $stmt->fetch()) {
                    $bid = $row['book_id'];
                    $time = $row['time'];
                    $backed = $row['backed'];
                    $book = new Book();
                    $book->setAll($bid);
                    $bname = $book->getName();
                    array_push($arr, array($key, $bname, $time, $backed));
                }
                break;
            case 3:
                $stmt = $db->executeQuery("select * from borrowing_log where time=?", [$key]);
                while ($row = $stmt->fetch()) {
                    $bid = $row['book_id'];
                    $uid = $row['user_id'];
                    $backed = $row['backed'];
                    $book = new Book();
                    $user = new User();
                    $book->setAll($bid);
                    $user->setAll($uid);
                    $bname = $book->getName();
                    $uname = $user->getName();
                    array_push($arr, array($uname, $bname, $key, $backed));
                }
                break;
            default:
        }
        if ($arr !== []) $status = 200;
        $db->close();
        $s = array('status' => $status, 'data' => $arr);
        echo json_encode($s);
    } else if (isset($_GET['row']) && isset($_GET['offset'])) {
        $row = (int)$_GET['row'];
        $offset = (int)$_GET['offset'];
        $status = 300;
        $arr = [];
        $db = new DBTool();
        $sql = "select * from borrowing_log order by time desc limit $row,$offset";
        $stmt = $db->executeQuery($sql, []);
        while ($r = $stmt->fetch()) {
            $uid = $r['user_id'];
            $bid = $r['book_id'];
            $time = $r['time'];
            $backed = $r['backed'];
            $book = new Book();
            $book->setAll($bid);
            $bname = $book->getName();
            $user = new User();
            $user->setAll($uid);
            $uname = $user->getName();
            array_push($arr, array($uname, $bname, $time, $backed));
        }
        if ($arr !== []) {
            $status = 200;
        }
        $db->close();
        $s = array('status' => $status, 'data' => $arr);
        echo json_encode($s);
    } else {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>借书日志</title>
            <script src="/js/jquery.min.js"></script>
            <style>
                .clear {
                    clear: both;
                    height: 0;
                    font-size: 1px;
                    line-height: 0;
                }

                .search {
                    width: 40%;
                    float: left;
                    border-bottom: 3px solid #000;
                    font-size: 22px;
                }

                .search input, .search select {
                    font-size: 20px;
                }

                .search input[type='button'] {
                    float: right;
                }

                table {
                    float: left;
                    width: 75%;
                    margin-top: 15px;
                    font-size: 18px;
                    text-align: center;
                }

                #moreLog {
                    width: 100px;
                    height: 40px;
                    font-size: 18px;
                    margin-top: 20px;
                }
            </style>
        </head>
        <body>
        <div id="box">
            <form class="search">
                <p>
                    <label for="key">搜索日志：( by
                        <select>
                            <option value="1">书名</option>
                            <option value="2">用户名</option>
                            <option value="3">时间</option>
                        </select> )</label>
                </p>
                <p><input type="text" id="key"><input type="button" value="搜索"></p>
            </form>
            <div class="logs">
                <table border="1" cellspacing="0" align="center">
                    <thead>
                    <tr>
                        <th>用户名</th>
                        <th>书名</th>
                        <th>时间</th>
                        <th>是否归还</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="clear"></div>
        </div>
        <input type="button" value="查看更多" id="moreLog">
        <div class="clear"></div>
        <script src="/js/boLog.js"></script>
        </body>
        </html>
    <?php }
}?>
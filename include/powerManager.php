<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tools/Get_Id.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/User.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tools/DBTool.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tools/Is_Login.php';

if (is_login()) {

    $id = get_id();
    $user = new User();
    $user->setAll($id);
    $power = $user->getPower();

    if (isset($_POST['need'])) {
        $need = $_POST['need'];
        $remarks = $_POST['remarks'];
        if ($need === 'I want to improve my authority') {
            if ($power) {
                $text = "已经是最高权限";
            } else {
                $db = new DBTool();
                $sql1 = "select * from power_ask where uid=?";
                $stmt = $db->executeQuery($sql1, array($id));
                if (count($stmt->fetchAll()) == 0) {
                    $remarks = htmlspecialchars($remarks);
                    if (strlen($remarks) > 300) {
                        $text = "备注过长";
                    } else {
                        $sql2 = "insert into power_ask (uid,time,remarks) VALUES (?,?,?)";
                        $db->executeUpdate($sql2, array($id, date('Y-m-d'), $remarks));
                        $text = "请求成功，请等待管理员审核";
                    }
                } else {
                    $text = "请不要重复请求";
                }
                $db->close();
            }
        } else if ($need = "I want to hack the website") {
            $text = "你在想屁";
        } else {
            $text = "Please tell your wish";
        }
        echo json_encode(array('text' => $text));
    } else {
        ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title></title>
            <script src="/js/jquery.min.js"></script>
            <style>
                h1 {
                    font-size: 32px;
                }

                table {
                    width: 100%;
                }

                div {
                    text-align: center;
                }

                input {
                    margin: 15px;
                    font-size: 20px;
                }
            </style>
        </head>
        <body>
        <h1>权限设置</h1>
        <table border="1" cellspacing="0">
            <tr>
                <th>当前权限组</th>
                <th>
                    <?php
                    if ($power) echo "图书管理员";
                    else echo "普通用户";
                    ?>
                </th>
            </tr>
        </table>
        <div>
            <input type="button" value="申请提高权限"><br>
            <label for="remarks">备注：</label><br>
            <input type="text" id="remarks">
        </div>
        <script src="/js/powerManager.js"></script>
        </body>
        </html>
    <?php }
} ?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Book.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/DBTool.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/Is_Librarian.php';

if (is_librarian()) {
    $status = 300;
    session_start();
    if (isset($_SESSION['id']) && isset($_POST['bname']) && isset($_POST['amount']) && isset($_POST['info'])) {
        $db = new DBTool();
        $book = new Book();
        $book->setAll($_SESSION['id']);
        $name = $book->getName();
        $bname = $_POST['bname'];
        $amount = $_POST['amount'];
        $info = $_POST['info'];
        $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/img/';

        if (!is_dir($path)) {
            mkdir($path);
        }
        $sql1 = "select * from book where name=? and name!=?";
        $sql2 = "";
        if ($_FILES['img']['error'] > 0) {
            $sql2 = "update book set name=? , amount=? , info=? where id=?";
        } else {
            $fname = $_FILES['img']['name'];
            $suffix = substr(strrchr($fname, '.'), 1);
            $white = ['jpg', 'png', 'gif'];
            $flag = false;
            for ($i = 0; $i < count($white); $i++) {
                if ($white[$i] === $suffix) {
                    $flag = true;
                }
            }
            if ($flag) {
                $fname = time() . mt_rand(10, 100) . ".$suffix";
                move_uploaded_file($_FILES['img']['tmp_name'], $path . $fname);
                $sql2 = "update book set name=? , amount=? , info=? , img='/upload/img/$fname' where id=?";
            } else {
                $text = "不正确的文件类型";
            }
        }
        if (strlen($bname)>255 | strlen($info)>300){
            $text="书名或介绍过长";
        }else {
            $stmt = $db->executeQuery($sql1, array($bname, $name));
            if (count($stmt->fetchall()) === 0) {
                $db->executeUpdate($sql2, array($bname, $amount, $info, $_SESSION['id']));
                $status = 200;
                $text = "修改成功";
            } else {
                $text = "书名重复";
            }
        }
        $db->close();
            echo json_encode(array("status" => $status, 'text' => $text));
    } else if (isset($_GET['name'])) {
        $name = $_GET['name'];
        $db = new DBTool();
        $sql = "select * from book where name=? limit 0,1";
        $stmt = $db->executeQuery($sql, array($name));
        $arr = [];
        $result = $stmt->fetchAll();
        if (count($result) > 0) {
            $status = 200;
            $_SESSION['id'] = $result[0]['id'];
            array_push($arr, $result[0]['name'], $result[0]['amount'], $result[0]['info'], $result[0]['img']);
        } else {
            $text = "没有找到这本书";
        }
        $s = array('status' => $status, 'text' => $text, 'data' => $arr);
        echo json_encode($s);
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
            <link rel="stylesheet" href="/css/userSetting.css">
            <style>
                .clear {
                    clear: both;
                    height: 0;
                    font-size: 1px;
                    line-height: 0;
                }

                #getMsg {
                    font-size: 20px;
                    border-bottom: 3px #000 solid;
                }

                #getMsg input {
                    font-size: 18px;
                    height: 30px;
                }

                #bimg {
                    width: 150px;
                }

                .m {
                    height: 150px;
                }

                textarea {
                    font-size: 18px;
                }

                #save {
                    clear: both;
                }
            </style>
            <script src="/js/jquery.min.js"></script>
        </head>
        <body>
        <h1>修改图书信息</h1>
        <form id="getMsg">
            <label for="name">书名：</label>
            <input type="text" placeholder="请输入书名" id="name"><br><br>
            <input type="button" value="获取信息" id="msg"><br><br>
        </form>
        <h5>请直接修改你要修改的内容</h5>
        <form class="x">
            <div>
                <label>书名：</label>
                <input type="text" name="bname">
            </div>
            <div>
                <label>数量：</label>
                <input type="number" name="amount">
            </div>
            <div class="m">
                <label>介绍：</label>
                <textarea cols="30" rows="6" name="info"></textarea>
            </div>
            <div>
                <label>图片：</label>
                <input type="file" name="img">
                <img src="" id="bimg">
                <div class="clear"></div>
            </div>
            <div>
                <input type="button" value="保存" id="save"> <input type="reset" value="重置">
            </div>

        </form>
        <script src="/js/bookSetting.js"></script>
        </body>
        </html>
    <?php }
}?>
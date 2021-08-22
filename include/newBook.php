<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/tools/DBTool.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/Is_Librarian.php';

if (is_librarian()) {

    if (isset($_POST['name']) && isset($_POST['amount']) && isset($_POST['info'])) {
        $status = 300;
        $name = $_POST['name'];
        $amount = (int)$_POST["amount"];
        $info = $_POST['info'];
        $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/img/';
        if (!is_dir($path)) {
            mkdir($path);
        }
        if ($_FILES['img']['error'] > 0) {
            $text = "上传失败";
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
                if (strlen($name)>255 | strlen($info)>300){
                    $text="书名或介绍过长";
                }else {
                    $db = new DBTool();
                    $sql1 = "select * from book where name=?";
                    $stmt = $db->executeQuery($sql1, array($name));
                    if ($stmt->fetchColumn() == 0) {
                        $sql2 = "insert into book (name,amount,info,img,time) VALUES (?,?,?,?,?)";
                        $db->executeUpdate($sql2, array($name, $amount, $info, '/upload/img/' . $fname, date('Y-m-d')));
                        $status = 200;
                        $text = "添加成功";
                    } else {
                        $text = "这本书已存在";
                    }
                    $db->close();
                }
            } else {
                $text = "不正确的文件类型";
            }
        }
        echo json_encode(array("status" => $status, 'text' => $text));
    } else {
        ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link rel="stylesheet" href="/css/newBook.css">
            <script src="/js/jquery.min.js"></script>
            <title></title>
        </head>
        <body>
        <h1>上架一本新书</h1>
        <form>
            <div>
                <label for="name">书名：</label>
                <input type="text" name="name" id="name" placeholder="书名" required>
            </div>
            <div>
                <label for="amount">数量：</label>
                <input type="number" name="amount" id="amount" required>
            </div>
            <div>
                <label for="info">介绍：</label>
                <textarea id="info" name="info" cols="30" rows="6" placeholder="书籍介绍" required></textarea>
            </div>
            <div>
                <label for="img">图像：</label>
                <input type="file" id="img" name="img" required>
            </div>
            <div><input type="button" value="提交"><input type="reset" value="重置"></div>
        </form>
        <script src="/js/newBook.js"></script>
        </body>
        </html>
    <?php }
}?>

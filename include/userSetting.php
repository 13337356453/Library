<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/User.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tools/Get_Id.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tools/Cipher.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/Is_Login.php';

if (is_login()) {

    $id = get_id();
    $user = new User();
    $user->setAll($id);
    $ci = new Cipher();

    if (isset($_POST['name']) && isset($_POST['pwd'])) {
        $status = 300;
        $name = $_POST['name'];
        $pwd = $_POST['pwd'];
        $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/img/';
        if (!is_dir($path)) {
            mkdir($path);
        }
        if (strlen($name)>20 | strlen($name)<4){
            $text="用户名长度不正确：(6 ~ 20)";
        }elseif (strlen($pwd)>20 | strlen($pwd)<4){
            $text="密码长度不正确：(6 ~ 20)";
        }else {
            if ($_FILES['file']['error'] > 0) {
                $db = new DBTool();
                $sql1 = "select * from user where name=? and id!=?";
                $stmt = $db->executeQuery($sql1, array($name, $id));
                if (count($stmt->fetchAll()) == 0) {
                    $sql2 = "update user set name=? , upwd=? where id=?";
                    $db->executeUpdate($sql2, array($name, $ci->encrypt($pwd), $id));
                    $sql3 = "select * from user where id=? limit 0,1";
                    $stmt = $db->executeQuery($sql3, array($id));
                    while ($row = $stmt->fetch()) {
                        $power = $row['power'];
                    }
                    $s = array("power" => $power, "id" => $id, "name" => $name, "pwd" => $pwd);
                    setcookie('l_info', base64_encode(json_encode($s)), time() + 3600 * 24 * 7, '/');
                    $status = 200;
                    $text = "保存成功";
                } else {
                    $text = "用户名已存在";
                }
                $db->close();
            } else {
                $fname = $_FILES['file']['name'];
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
                    move_uploaded_file($_FILES['file']['tmp_name'], $path . $fname);
                    $sql1 = "select * from user where name=? and id!=?";
                    $db = new DBTool();
                    $stmt = $db->executeQuery($sql1, array($name, $id));
                    if (count($stmt->fetchAll()) == 0) {
                        $sql2 = "update user set name=? , upwd=? ,head=? where id=?";
                        $db->executeUpdate($sql2, array($name, $ci->encrypt($pwd), '/upload/img/' . $fname, $id));
                        $sql3 = "select * from user where id=? limit 0,1";
                        $stmt = $db->executeQuery($sql3, array($id));
                        while ($row = $stmt->fetch()) {
                            $power = $row['power'];
                        }
                        $s = array("power" => $power, "id" => $id, "name" => $name, "pwd" => $pwd);
                        setcookie('l_info', base64_encode(json_encode($s)), time() + 3600 * 24 * 7, '/');
                        $status = 200;
                        $text = "保存成功";
                    } else {
                        $text = "用户名已存在";
                    }
                } else {
                    $text = "不正确的图片类型";
                }
            }
        }
        echo json_encode(array("status" => $status, 'text' => $text));
    } else {
        $name = $user->getName();
        $pwd = $ci->decrypt($user->getUpwd());
        $head = $user->getHead();
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
            <script src="/js/jquery.min.js"></script>
        </head>
        <body>
        <h1>修改你的信息</h1>
        <h5>请直接修改你要修改的内容</h5>
        <form>
            <div>
                <label for="name">用户名：</label>
                <input type="text" value="<?= $name ?>" id="name" name="name" placeholder="用户名">

            </div>
            <div>
                <label for="pwd">密码：</label>
                <input type="password" value="<?= $pwd ?>" id="pwd" name="pwd" placeholder="密码"><img
                        src="/images/show.png" alt="显示密码" id="show_p"><br>
            </div>
            <div>
                <label for="file">头像：</label>
                <input type="file" id="file" name="file">
                <img src="<?= $head ?>" id="head">
            </div>
            <div>
                <input type="button" value="保存"> <input type="reset" value="重置">
            </div>
        </form>
        <script src="/js/userSetting.js"></script>
        </body>
        </html>
    <?php }
}?>
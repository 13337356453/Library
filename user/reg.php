<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tools/Cipher.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/tools/DBTool.php';
if (isset($_POST['name']) && isset($_POST['pwd']) && isset($_POST['pwd_2']) && isset($_POST['captcha'])) {
    session_start();
    $name = $_POST['name'];
    $pwd = $_POST['pwd'];
    $pwd_2 = $_POST['pwd_2'];
    $captcha = strtolower($_POST['captcha']);
    $code = strtolower($_SESSION['captcha']);
    $status = 300;
    if ($captcha === $code) {
        if ($pwd === $pwd_2) {
            if (strlen($name)>20 | strlen($name)<4){
                $text="用户名长度不正确：(6 ~ 20)";
            }elseif (strlen($pwd)>20 | strlen($pwd)<4){
                $text="密码长度不正确：(6 ~ 20)";
            }else {
                $name = htmlspecialchars($name);
                $pwd = htmlspecialchars($pwd);
                $db = new DBTool();
                $sql1 = "select * from user where name=?";
                $stmt = $db->executeQuery($sql1, array($name));
                $ci = new Cipher();
                if (count($stmt->fetchAll()) == 0) {
                    $sql2 = "insert into user (name,upwd) VALUES (?,?)";
                    $db->executeUpdate($sql2, array($name, $ci->encrypt($pwd)));
                    $id = $db->pdo->lastInsertId();
                    if ($id) {
                        $s = array("power" => "0", "id" => $id, "name" => $name, "pwd" => $pwd);
                        setcookie('l_info', base64_encode(json_encode($s)), time() + 3600 * 24 * 7, '/');
                        $status = 200;
                        $text = "注册成功";
                    } else {
                        $text = "注册失败";
                    }
                } else {
                    $text = "用户名已存在";
                }
                $db->close();
            }
        } else $text = "两次输入的密码不一致";
    } else $text = "验证码不正确";
    echo json_encode(array('status' => $status, 'text' => $text));
} else {
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>用户注册</title>
        <link rel="stylesheet" href="/css/index.css">
        <link rel="stylesheet" href="/css/login.css">
        <script src="/js/jquery.min.js"></script>
    </head>
    <body>
    <?php
    include "../top.php";
    ?>
    <div class="box">
        <h2>Register</h2>
        <form>
            <div class="inputBox">
                <input type="text" id="name" required autofocus>
                <label>用户名</label>
            </div>
            <div class="inputBox">
                <input type="password" id="pwd" required>
                <label>密码</label>
            </div>
            <div class="inputBox">
                <input type="password" id="pwd_2" required>
                <label>重复密码</label>
            </div>
            <div class="inputBox">
                <input type="text" id="captcha" required>
                <label>验证码</label>
                <img src="/captcha.php" id="code">
            </div>
            <input type="submit" value="提交" id="reg">
            <input type="reset" value="清空">
        </form>
    </div>
    <script src="/js/reg.js"></script>
    </body>
    </html>
<?php } ?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/tools/Cipher.php";
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/DBTool.php';
if (isset($_POST['name']) && isset($_POST['pwd']) && isset($_POST['captcha'])) {
    session_start();
    $status = 300;
    $name = $_POST['name'];
    $pwd = $_POST['pwd'];
    $captcha = strtolower($_POST['captcha']);
    $code = strtolower($_SESSION['captcha']);
    if ($code === $captcha) {
            $db = new DBTool();
            $sql = "select id,power from user where name=? and upwd=? limit 0,1";
            $ci = new Cipher();
            $stmt = $db->executeQuery($sql, array($name, $ci->encrypt($pwd)));
            $result = $stmt->fetchAll();
            if (!count($result) < 1) {
                $s = array("power" => $result[0]['power'], "id" => $result[0]['id'], "name" => $name, "pwd" => $pwd);
                setcookie('l_info', base64_encode(json_encode($s)), time() + 3600 * 24 * 7, '/');
                $status = 200;
                $text = "登录成功";
            } else {
                $text = "账号或密码错误";
            }
            $db->close();
    } else {
        $text = "验证码错误";
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
        <title>用户登录</title>
        <link rel="stylesheet" href="/css/login.css">
        <link href="../css/index.css" rel="stylesheet" type="text/css">
        <script src="/js/jquery.min.js"></script>
    </head>
    <body>
    <?php
    include "../top.php";
    ?>
    <div class="box">
        <h2>Login</h2>
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
                <input type="text" id="captcha" required>
                <label>验证码</label>
                <img src="/captcha.php" id="code">
            </div>
            <input type="submit" value="登录" id="login">
            <input type="reset" value="清空">
        </form>
    </div>
    <script src="/js/login.js"></script>
    </body>
    </html>
<?php } ?>
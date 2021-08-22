<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/tools/DBTool.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/tools/Cipher.php';
    if (isset($_POST['name']) && isset($_POST['pwd']) && isset($_POST['captcha'])){
        session_start();
        $status = 300;
        $name = $_POST['name'];
        $pwd = $_POST['pwd'];
        $captcha = strtolower($_POST['captcha']);
        $code = strtolower($_SESSION['captcha']);
        if ($code === $captcha) {
            $db=new DBTool();
            $ci=new Cipher();
            $sql="select * from admin where name=? and pwd=?";
            $stmt=$db->executeQuery($sql,[$name,$ci->encrypt($pwd)]);
            if (!count($stmt->fetchAll())<1){
                $s=array("power"=>'admin',"name"=>$name,"pwd"=>$pwd);
                setcookie('l_Ad',base64_encode(json_encode($s)),time()+3600*24*7,'/');
                $status=200;
                $text="登录成功";
            }else {
                $status=300;
                $text="账号或密码错误";
            }
        }else {
            $text = "验证码错误";
        }
        echo json_encode(array("status" => $status, 'text' => $text));
    }else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }
        html {
            height: 100%;
        }
        body {
            background-image: linear-gradient(to bottom right, rgb(114, 135, 254), rgb(130, 88, 186));
        }
        .login-container {
            width: 600px;
            height: 315px;
            margin: 0 auto;
            margin-top: 10%;
            border-radius: 15px;
            box-shadow: 0 10px 50px 0px rbg(59, 45, 159);
            background-color: rgb(95, 76, 194);
        }
        .left-container {
            display: inline-block;
            width: 330px;
            border-top-left-radius: 15px;
            border-bottom-left-radius: 15px;
            padding: 60px;
            background-image: linear-gradient(to bottom right, rgb(118, 76, 163), rgb(92, 103, 211));
        }
        .title {
            color: #fff;
            font-size: 18px;
            font-weight: 200;
        }
        .title span {
            border-bottom: 3px solid rgb(237, 221, 22);
        }
        .input-container {
            padding: 20px 0;
        }
        input {
            border: 0;
            background: none;
            outline: none;
            color: #fff;
            margin: 20px 0;
            display: block;
            width: 100%;
            padding: 5px 0;
            transition: .2s;
            border-bottom: 1px solid rgb(199, 191, 219);
        }
        input:hover {
            border-bottom-color: #fff;
        }
        ::-webkit-input-placeholder {
            color: rgb(199, 191, 219);
        }
        .message-container {
            font-size: 14px;
            transition: .2s;
            color: rgb(199, 191, 219);
            cursor: pointer;
        }
        .message-container:hover {
            color: #fff;
        }
        .right-container {
            width: 145px;
            display: inline-block;
            height: calc(100% - 120px);
            vertical-align: top;
            padding: 60px 0;
        }
        .regist-container {
            text-align: center;
            color: #fff;
            font-size: 18px;
            font-weight: 200;
        }
        .regist-container span {
            border-bottom: 3px solid rgb(237, 221, 22);
        }
        .action-container {
            font-size: 10px;
            color: #fff;
            text-align: center;
            position: relative;
            top: 200px;
        }
        .action-container span {
            border: 1px solid rgb(237, 221, 22);
            padding: 10px;
            display: inline;
            line-height: 20px;
            border-radius: 20px;
            position: absolute;
            bottom: 10px;
            left: calc(72px - 20px);
            transition: .2s;
            cursor: pointer;
        }
        .action-container span:hover {
            background-color: rgb(237, 221, 22);
            color: rgb(95, 76, 194);
        }
    </style>
    <script src="/js/jquery.min.js"></script>
</head>
<body>
<div class="login-container">
    <div class="left-container">
        <div class="title"><span>登录</span></div>
        <div class="input-container">
            <input type="text" name="username" placeholder="用户名">
            <input type="password" name="password" placeholder="密码">
            <input type="text" name="captcha" placeholder="验证码">
            <img src="/captcha.php" id="code">
        </div>
        <div class="message-container">
        </div>
    </div>
    <div class="right-container">
        <div class="regist-container">
        </div>
        <div class="action-container">
            <span>提交</span>
        </div>
    </div>
</div>
<script>
    $("#code").click(function () {
        $("#code").attr("src", "/captcha.php?time=" + new Date().getTime());
    });
    $(".action-container").click(function () {
        $.ajax({
            type: "POST",
            url: "/admin/login.php",
            data: {name: $("input[name='username']").val(), pwd: $("input[name='password']").val(), captcha: $("input[name='captcha']").val()},
            dataType: "json",
            success: function (data) {
                alert(data['text']);
                if (data['status'] == 200) {
                    console.log("200");
                    location.href = "/admin/index.php";
                } else {
                    $("#code").click();
                }
            }
        })
    });
</script>
</body>
</html><?php }?>
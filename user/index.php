<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/tools/Is_Login.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>用户主页</title>
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/user_index.css">
    <script src="/js/jquery.min.js"></script>
</head>
<body>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/top.php";
if (is_login()) {
    ?>
    <div id="box">
        <div id="menu">
            <h2>信息管理</h2>
            <ul>
                <li><a id="msg">修改信息</a></li>
            </ul>
            <h2>书籍管理</h2>
            <ul>
                <li><a id="borrow">借书</a></li>
                <li><a id="history">阅读历史</a></li>
            </ul>
            <h2 id="power">权限管理</h2>
            <h2 id="librarian">图书管理员界面</h2>
            <h2 id="out">退出登录</h2>
        </div>
        <div id="userBody">
            <h2>欢迎来到用户主页</h2>
            <iframe src="">

            </iframe>
        </div>
        <div class="clear"></div>
    </div>
<?php }else { ?>
    <h1 style="text-align: center">你还未登录，将跳转到登录界面</h1>
    <div style="text-align: center" id="msg"></div>
    <h2 style="text-align: center"><a href="/user/login.php">或点击该链接跳转</a></h2>
    <script type="text/javascript">
        var div = document.getElementById("msg");
        var time = 5;
        var timer = setInterval(function () {
            if (time == 0) {
                location.href = "/user/login.php";
            } else {
                div.innerHTML = "将在 " + time + " 秒后跳转";
                time--;
            }
        }, 1000)
    </script>
<?php }
include "../footer.php";
?>
<script src="/js/user.js"></script>
</body>
</html
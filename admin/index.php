<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/Is_Admin.php';
if (!is_admin()){
    header("Location:login.php");
}else {
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>后台管理</title>
        <script src="/js/jquery.min.js"></script>
        <link rel="stylesheet" href="/css/admin.css">
    </head>
    <body>
    <center style="font-size: 25px"><h1>后台管理系统</h1></center>
    <div id="list">
        <button id="1">数据库管理</button>
        <button id="2">权限请求</button>
        <button id="3">网站前台</button>
    </div>
    <div id="main">
        <iframe src=""></iframe>
    </div>
    <script>
        var iframe=$("iframe");
        $("#1").click(function() {
            iframe.attr("src", "/include/sql.php");
        });
        $("#2").click(function () {
            iframe.attr("src", "/include/asks.php");
        });
        $("#3").click(function () {
            location.href='/index.php'
        })
    </script>
    </body>
    </html>
<?php
}
?>
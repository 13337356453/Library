<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/tools/Is_Librarian.php';
if (!is_librarian()) {
    echo "<script>alert('权限不足');location.href='/user/login.php'</script>";
} else {
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="/css/index.css">
        <link rel="stylesheet" href="/css/user_index.css">
        <script src="/js/jquery.min.js"></script>
        <title>图书管理</title>
    </head>
    <body>
    <?php include "../top.php"; ?>
    <div id="box">
        <div id="menu">
            <h2>书籍管理</h2>
            <ul>
                <li><a id="new_b">上架新书</a></li>
                <li><a id="down_b">下架书籍</a></li>
                <li><a id="book_msg">修改图书信息</a></li>
                <li><a id="log">借书日志</a></li>
            </ul>
            <h2>用户管理</h2>
            <ul>
                <li><a id="back_book">还书</a></li>
            </ul>
            <h2 onclick="location.href='javascript:history.go(-1)'">返回</h2>
        </div>
        <div id="li_body">
            <iframe src=""></iframe>
        </div>
        <div class="clear"></div>
    </div>
    <?php include "../footer.php"; ?>
    <script src="/js/librarian.js"></script>
    </body>
    </html>
<?php } ?>

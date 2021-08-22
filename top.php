<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tools/Is_Login.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/classes/User.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/tools/Get_Id.php";
?>
<body>
<link rel="stylesheet" href="/css/top.css">
<div id="top">
    <div id="urlList">
        <a href='/index.php'>首页</a>
        <a href='/list/books.php'>书城</a>
    </div>
    <div id="userBox">
        <?php
        if (is_login()) {
            $user = new User();
            $id = get_id();
            $user->setAll($id);
            echo "<a href='/user/index.php' target='_blank' id='head'><img src='" . $user->getHead() . "' alt='主页'/></a><p>" . $user->getName() . "</p>";
        } else {
            ?>
            <a href="/user/login.php" title="登录" class="u">登录</a>
            <a href="/user/reg.php" title="注册" class="u">注册</a>
            <?php
        }
        ?>
    </div>
</div>
</body>
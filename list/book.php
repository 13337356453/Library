<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/Book.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/User.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/DBTool.php';

if (isset($_GET['id'])) {
    $bId = (int)$_GET['id'];
    if ($bId == 0) {
        $bId = 1;
    }
} else $bId = 1;

//try {
//    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
//} catch (PDOException $e) {
//    die("数据库连接失败：" . $e->getMessage());
//}

$db=new DBTool();
$sql1='update book set visits=visits+1 where id=?';
$db->executeUpdate($sql1,array($bId));

//$sql1='update book set visits=visits+1 where id=?';
//$stmt=$pdo->prepare($sql1);
//$stmt->bindValue(1,$bId);
//$stmt->execute();

$book = new Book();
$book->setAll($bId);
$bName = $book->getName();
$bVisits = $book->getVisits();
$bTime = $book->getTime();
$bAmount = $book->getAmount();
$bImg = $book->getImg();
$bInfo = $book->getInfo();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$bName?></title>
    <script src="/js/jquery.min.js"></script>
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/book.css">
</head>
<body>
<? include "../top.php"; ?>
<div id="intro">
    <div id="bname"><?= $bName ?></div>
    <div id="borrow">借书</div>
    <div id="btime"><?= $bTime ?></div>
    <div class="t">
        <div id="bvisits"><b><?= $bVisits ?></b>人访问过</div>
        <div id="bamount">剩余<b><?= $bAmount ?></b>本</div>
    </div>
</div>
<div id="img">
    <img src="<?= $bImg ?>">
</div>
<div id="info">
    <p><?= $bInfo ?></p>
</div>
<div id="comment">
    <div class="z">
        <form>
            <label for="c">发表你的评论：</label>
            <input type="text" id="c">
            <input type="button" value="提交">
        </form>
    </div>
    <span class="look_all">查看所有评论</span>
    <div class="m">
        <?php
        $sql2 = "select content,user_id from comment where book_id=? order by id desc limit 0,10";
        $stmt=$db->executeQuery($sql2,array($bId));
        while ($row = $stmt->fetch()) {
            $uid = $row['user_id'];
            $content = $row['content'];
            $user = new User();
            $user->setAll($uid);
            $uhead = $user->getHead();
            $uname = $user->getName();
            echo "<div class='c'><img src='$uhead' alt='$uname'><div class='p'><span class='uname'>$uname</span><span class='content'>$content</span></div></div>";
        }
        $db->close();
        ?>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>
<? include "../footer.php"; ?>
<script src="/js/book.js"></script>
</body>
</html>

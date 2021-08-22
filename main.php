<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/DBTool.php';
//try {
//    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
//} catch (Exception $e) {
//    die("数据库连接失败" . $e->getMessage());
//}
$db=new DBTool();
?>
<body>
<link rel="stylesheet" href="/css/main.css">
<div id="main">
    <div>
        <h1>阅读，是一种生活</h1>
    </div>
    <div class="line"><span>新品书籍</span><a href="/list/books.php">更多</a></div>
    <div id="hot" class="i">
        <?php
        $sql1 = "select * from book order by time desc limit 0,5;";
        $stmt = $db->executeQuery($sql1,array());
        while ($row = $stmt->fetch()) {
            echo "<div class='a'><a href='/list/book.php?id=".$row['id']."' target='_blank'><img src='".$row['img']."'/></a><span class='n'>".$row['name']."</span><span class='v'><b>".$row['visits']."</b>人访问过</span></div>";
        }
        ?>
    </div>
    <div class="line"><span>热门书籍</span><a href="/list/books.php">更多</a></div>
    <div id="new" class="i">
        <?php
        $sql2 = "select * from book order by visits desc limit 0,5;";
        $stmt = $db->executeQuery($sql2,array());
        while ($row = $stmt->fetch()) {
            echo "<div class='a'><a href='/list/book.php?id=".$row['id']."' target='_blank'><img src='".$row['img']."'/></a><span class='n'>".$row['name']."</span><span class='v'><b>".$row['visits']."</b>人访问过</span></div>";
        }
        $db->close();
        ?>
    </div>
</div>
</body>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/DBTool.php';

if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
    if ($page == 0) {
        $page = 1;
    }
} else $page = 1;
$db=new DBTool();

$from = ($page - 1) * 30;

$sql = "select * from book order by time desc limit $from,30;";
$stmt = $db->executeQuery($sql,array());

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>书城</title>
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/books.css">
    <script src="/js/jquery.min.js"></script>
</head>
<body>
<?php include "../top.php"; ?>
<div class="l">跳转到第<input type="number" value="1">页&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="跳转"></div>
<div id="box">
    <?php
    while ($row = $stmt->fetch()) {
        echo "<div class='a'><a href='/list/book.php?id=" . $row['id'] . "' target='_blank'><img src='" . $row['img'] . "'/></a><span class='n'>" . $row['name'] . "</span><span class='v'><b>" . $row['visits'] . "</b>人访问过</span></div>";
    }
    ?>
</div>
<div class="clear"></div>
<?php include "../footer.php"; ?>
<script>
    $("[type='button']").click(function () {
        var n = $("[type='number']").val();
        if (n >= 1) {
            location.href = "?page=" + n;
        } else {
            location.href = "?page=1";
        }
    })
</script>
</body>
</html>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/User.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/Book.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tools/Get_Id.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/Is_Login.php';

if (is_login()){

$id = get_id();
$user = new User();
$user->setAll($id);
$bookId = $user->getBook();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="/css/borrowBook.css">
</head>
<body>
<?php
if ($bookId == null) { ?>
    <div class="no_book">
        <h2>目前还没有借书，可到书城去看看</h2>
        <a onclick="parent.location.href='/list/books.php'">点我去书城</a>
    </div>
<?php } else {
    $book=new Book();
    $book->setAll($bookId);
    $borrowTime=$user->getBorrowingTime();
    $bname=$book->getName();
    $bimg=$book->getImg();
    $binfo=$book->getInfo();
    ?>
        <div id="borrowBox">
            <div class="q">
                <p id="bname"><?=$bname?></p>
                <p id="botime">借书时间：<?=$borrowTime?></p>
            </div>
            <div class="bimg">
                <img src="<?=$bimg?>">
            </div>
            <div class="binfo">
                <p><?=$binfo?></p>
            </div>
            <a onclick="parent.location.href='/list/book.php?id=<?=$bookId?>'" >前往图书页面</a>
        </div>
<?php } ?>
</body>
</html>
<?php } ?>

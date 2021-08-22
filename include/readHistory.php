<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/User.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Book.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/Get_Id.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/Is_Login.php';

if (is_login()){

$id=get_id();
$user=new User();
$user->setAll($id);
$history=$user->getHistory();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <style>
        .no_history a {
            text-decoration: underline;
        }
        .no_history a:hover {
            color: red;
            font-weight: 700;
        }
        .a {
            width: 18%;
            height: 240px;
            border: 1px solid #000;
            border-radius: 2px;
            margin-left: 1.5%;
            float: left;
            display: inherit;
        }
        .a img {
            width: 100%;
        }
        .a span {
            display: block;
            color: black;
            font-size: 18px;
            margin-left: 5px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>
<?php
if ($history==null){
    ?>
    <div class="no_history">
        <h1>阅读记录为空</h1>
        <a onclick="parent.location.href='/list/books.php'">点我去书城</a>
    </div>
<?php }else {
    foreach ($history as $bId){
        $book=new Book();
        $book->setAll($bId);
        $img=$book->getImg();
        $name=$book->getName();
        echo "<div class='a'><a onclick='parent.location.href=\"/list/book.php?id=$bId\"'><img src='".$img."'/></a><span class='n'>".$name."</span></div>";
    }
} ?>
</body>
</html>
<?php } ?>
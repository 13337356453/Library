<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/Is_Login.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/Get_Id.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/DBTool.php';

if (isset($_POST["bId"]) && isset($_POST['text'])){
    $status=300;
    $bId=$_POST['bId'];
    $comment=$_POST["text"];
    if (is_login()){
        $uid=get_id();
        $comment=htmlspecialchars($comment);
        if (strlen($comment)>=300){
            $text="评论过长";
        }else {
            $db = new DBTool();
            $sql = "insert into comment (book_id,content,user_id) VALUES (?,?,?)";
            $db->executeUpdate($sql, array($bId, $comment, $uid));
            $status = 200;
            $text = "评论成功";
            $db->close();
        }
    }else{
        $status=400;
        $text="未登录";
    }
    echo json_encode(array("status" => $status, 'text' => $text));
}

?>
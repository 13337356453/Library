<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/User.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/DBTool.php';
if (isset($_GET['id']) && isset($_GET['row']) && isset($_GET['offset'])) {
    $id = $_GET['id'];
    $row = (int)$_GET['row'];
    $offset = (int)$_GET['offset'];
    $status = 300;
    $arr = [];
    $db=new DBTool();
    $sql="select * from comment where book_id=? limit $row,$offset";
    $stmt=$db->executeQuery($sql,array($id));
    while ($r=$stmt->fetch()){
        $uid=$r['user_id'];
        $content=$r['content'];
        $user=new User();
        $user->setAll($uid);
        $head=$user->getHead();
        $name=$user->getName();
        array_push($arr,array($name,$head,$content));
        $user=null;
    }
    if ($arr!==[]){
        $status=200;
    }
    $db->close();
    $s = array('status' => $status, 'data' => $arr);
    echo json_encode($s);
}
?>
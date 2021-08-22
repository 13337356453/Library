<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/DBTool.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/Cipher.php';
function is_login(){
    if (isset($_COOKIE['l_info'])){
        $info=base64_decode($_COOKIE['l_info']);
        $data=json_decode($info);
        $db=new DBTool();
                $ci=new Cipher();
        $stmt=$db->executeQuery('select * from user where id=? and name=? and upwd=?',[$data->id,$data->name,$ci->encrypt($data->pwd)]);
        $result = $stmt->fetchAll();
        $db->close();
        if (!count($result)<1){
            return true;
        }
    }
    return false;
}
?>
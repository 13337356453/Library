<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/tools/DBTool.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/tools/Cipher.php';
function is_admin(){
    if (isset($_COOKIE['l_Ad'])){
        $l=json_decode(base64_decode($_COOKIE['l_Ad']));
        $db=new DBTool();
        $ci=new Cipher();
        $stmt=$db->executeQuery("select * from admin where name=? and pwd=?",[$l->name,$ci->encrypt($l->pwd)]);
        $result=$stmt->fetchAll();
        $db->close();
        if (!count($result)<1){
            return true;
        }
    }
    return false;
}
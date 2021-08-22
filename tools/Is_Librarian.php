<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/Cipher.php';

function is_librarian()
{
    if (isset($_COOKIE['l_info'])){
        $info=base64_decode($_COOKIE['l_info']);
        $data=json_decode($info);
        global $host,$database,$username,$password;
        try{
            $pdo = new PDO("mysql:host=$host;dbname=$database",$username,$password);
        }catch(PDOException $e){
            die("数据库连接失败".$e->getMessage());
        }
        $sql='select * from user where id=? and name=? and upwd=? and power=1';
        $ci=new Cipher();
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(1,$data->id);
        $stmt->bindValue(2,$data->name);
        $stmt->bindValue(3,$ci->encrypt($data->pwd));
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt=null;
        $pdo=null;
        if (!count($result)<1){
            return true;
        }
    }
    return false;
}
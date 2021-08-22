<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';

class DBTool{
    private $dns,$username,$password;
    public $pdo,$stmt;
    function __construct()
    {
        Global $host,$username,$password,$database;
        $this->dns="mysql:host=$host;dbname=$database";
        $this->username=$username;
        $this->password=$password;
    }
    function getConnection(){
        try {
            $pdo=new PDO($this->dns,$this->username,$this->password);
        }catch (PDOException $e){
            die("数据库连接失败：".$e->getMessage());
        }
        return $pdo;
    }

    function executeQuery($sql,$data){
        $this->pdo=$this->getConnection();
        $this->stmt=$this->pdo->prepare($sql);
        for ($i=0;$i<count($data);$i++){
            $this->stmt->bindValue($i+1,$data[$i]);
        }
        $this->stmt->execute();
        return $this->stmt;
    }
    function executeUpdate($sql,$data){
        $this->pdo=$this->getConnection();
        $this->stmt= $this->pdo->prepare($sql);
        for ($i=0;$i<count($data);$i++){
            $this->stmt->bindValue($i+1,$data[$i]);
        }
        $this->stmt->execute();
    }
    function close(){
        $this->stmt=null;
        $this->pdo=null;
    }
}
?>
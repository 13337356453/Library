<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/tools/DBTool.php';

class Book
{
    private $id=0;
    private $name="";
    private $amount=0;
    private $info="";
    private $img="";
    private $visits=0;
    private $time="";
    public function setAll($id){
        $this->setId($id);
        $db=new DBTool();
        $sql="select * from book where id=? limit 0,1";
        $stmt=$db->executeQuery($sql,array($id));
        while ($row=$stmt->fetch()){
            $this->setName($row['name']);
            $this->setAmount($row['amount']);
            $this->setInfo($row['info']);
            $this->setImg($row['img']);
            $this->setVisits($row['visits']);
            $this->setTime($row['time']);
        }
        $db->close();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param string $info
     */
    public function setInfo($info)
    {
        $this->info = $info;
    }

    /**
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param string $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }

    /**
     * @return int
     */
    public function getVisits()
    {
        return $this->visits;
    }

    /**
     * @param int $visits
     */
    public function setVisits($visits)
    {
        $this->visits = $visits;
    }

    /**
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param string $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }



}
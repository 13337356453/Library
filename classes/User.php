<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/tools/DBTool.php';

class User
{
    private $id = 0;
    private $upwd = "";
    private $name = "";
    private $head="images/userhead.png";
    private $book=null;
    private $borrowing_time=null;
    private $history=[];
    private $getHead;
    private $power=0;

    function setAll($uid){
        $this->setid($uid);
        $sql='select * from user where id=? limit 0,1';
        $db=new DBTool();
        $stmt=$db->executeQuery($sql,array($uid));
        while ($row=$stmt->fetch()){
            $this->setUpwd($row['upwd']);
            $this->setName($row['name']);
            $this->setHead($row['head']);
            $this->setBook($row['book']);
            $this->setBorrowingTime($row['borrowing_time']);
            $this->setPower($row['power']);
            if ($row['history']==null){
                $this->setHistory($row['history']);}else{
                $this->setHistory(explode(",", $row['history']));
            }
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
    public function getUpwd()
    {
        return $this->upwd;
    }

    /**
     * @param string $upwd
     */
    public function setUpwd($upwd)
    {
        $this->upwd = $upwd;
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
     * @return string
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * @param string $head
     */
    public function setHead($head)
    {
        $this->head = $head;
    }

    /**
     * @return null
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * @param null $book
     */
    public function setBook($book)
    {
        $this->book = $book;
    }

    /**
     * @return null
     */
    public function getBorrowingTime()
    {
        return $this->borrowing_time;
    }

    /**
     * @param null $borrowing_time
     */
    public function setBorrowingTime($borrowing_time)
    {
        $this->borrowing_time = $borrowing_time;
    }

    /**
     * @return array
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * @param array $history
     */
    public function setHistory($history)
    {
        $this->history = $history;
    }

    /**
     * @return mixed
     */
    public function getGetHead()
    {
        return $this->getHead;
    }

    /**
     * @param mixed $getHead
     */
    public function setGetHead($getHead)
    {
        $this->getHead = $getHead;
    }

    /**
     * @return int
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * @param int $power
     */
    public function setPower($power)
    {
        $this->power = $power;
    }

}

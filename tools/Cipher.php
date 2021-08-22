<?php

class Cipher
{
    private $key='manlu';
    private $n_key=0;
    private $n=21;
    private function getKey(){
        for ($i=0;$i<strlen($this->key);$i++){
            $this->n_key+=ord($this->key[$i]);
        }
    }
    public function encrypt($text){
        $this->getKey();
        $result='';
        for ($i = 0; $i < strlen($text); $i++) {
            $n = ord($text[$i]);
            $result .= ($n + $this->n_key) * $this->n . ".";
        }
        $this->n_key=0;
        return substr($result, 0, strlen($result) - 1);
    }
    public function decrypt($text){
        $this->getKey();
        $result='';
        $a=explode('.',$text);
        foreach ($a as $val){
            $result.=chr((int)$val/$this->n-$this->n_key);
        }
        $this->n_key=0;
        return $result;
    }
}
?>
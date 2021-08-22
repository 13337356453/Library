<?php
    session_start();
    $WIDTH=120;
    $HEIGHT=30;
    $WORDS="ABCDEFGHIJKLMNOPQRSTUVWXYZabdefghijklmnopqrstuvwxyz";
    $img=imagecreatetruecolor($WIDTH,$HEIGHT);
    $bgc=imagecolorallocate($img,255,255,255);
    imagefill($img,0,0,$bgc);
    $captcha="";
    for ($i=0;$i<4;$i++){
        $fontsize=10;
        $fontcolor=imagecolorallocate($img,rand(0,120),rand(0,120),rand(0,120));
        $s=substr($WORDS,mt_rand(0,strlen($WORDS)),1);
        $captcha.=$s;
        $x=($i*120/4)+rand(5,10);
        $y=rand(5,10);
        imagestring($img,5,$x,$y,$s,$fontcolor);
    }
    $_SESSION['captcha']=$captcha;
    for ($i=0;$i<4;$i++){
        $linecolor=imagecolorallocate($img,rand(80,220), rand(80,220),rand(80,220));
        imageline($img,rand(1,99), rand(1,29),rand(1,99), rand(1,29),$linecolor);
    }
    header('content-type:image/jpg');
    imagepng($img);
    imagedestroy($img);
?>

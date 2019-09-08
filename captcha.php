<?php
  session_start();
  $image = imagecreatetruecolor(100, 30);   
  $bgcolor = imagecolorallocate($image,255,255,255); 
  imagefill($image, 0, 0, $bgcolor);
  $captcha_code = "";
  for($i=0;$i<4;$i++){
    $fontsize = 12;    
    $fontcolor = imagecolorallocate($image, rand(0,80),rand(0,80), rand(0,80));     
    $data ='abcdefghigkmnpqrstuvwxy3456789';
    $fontcontent = substr($data, rand(0,strlen($data)),1);
    $captcha_code .= $fontcontent;    
    $x = ($i*100/4)+rand(5,10);
    $y = rand(5,10);
    imagestring($image,$fontsize,$x,$y,$fontcontent,$fontcolor);
  }
  //存到session
  $_SESSION['authcode'] = $captcha_code;
  //8>增加干扰元素，设置雪花点
  for($i=0;$i<200;$i++){
    $pointcolor = imagecolorallocate($image,rand(50,200), rand(50,200), rand(50,200));    
    imagesetpixel($image, rand(1,99), rand(1,29), $pointcolor);
  }
  //9>增加干扰元素，设置横线
  for($i=0;$i<4;$i++){
    $linecolor = imagecolorallocate($image,rand(150,220), rand(150,220),rand(150,220));
    //设置线，两点一线
    imageline($image,rand(1,99), rand(1,29),rand(1,99), rand(1,29),$linecolor);
  }
 
  header('Content-Type: image/png');
  imagepng($image);
  imagedestroy($image);
<?php
	session_start();
    require('library/Db.class.php');
    $name  = $_POST['name'];
    $liyou  = $_POST['liyou'];
    $qq  = $_POST['qq'];
    $tel  = $_POST['tel'];
    $emil  = $_POST['emil'];
    $jishu  = $_POST['jishu'];
    
    $db   = new Db();
    $addtime =time();
    
    $sql="insert into kaifa(addtime,username,qq,tel,email,why,jishu,result) values ($addtime,:username,:qq,:email,:tel,:why,:jishu,1)";
    
    $result=$db->query($sql,array("username"=>$name,"jishu"=>$jishu,"why"=>$liyou,"email"=>$emil,"tel"=>$tel,"qq"=>$qq));
    
    if($result){
    	echo 1;
    	exit;
    }else{
    	echo -1;
    	exit;
    }
    
?>
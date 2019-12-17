<?php
	require('library/Db.class.php');
    $db   = new Db();
    session_start();
    
    $tel=$_POST['tel'];
    $type=$_POST['type'];
    $username=$_POST['username'];
    
    //1表示手机号
    if($type==1){
    	$sql  = "select * from user where tel = :tel";
	    $t = $db->row($sql,array('tel'=>$tel));
	
		if($t){
	        echo 1;
	        exit;
	    }else{
		 	echo -1;
	        exit;
		 }
    }else if($type==2){
    	$sql  = "select * from user where username = :username";
	    $t = $db->row($sql,array('username'=>$username));
	
		if($t){
	        echo 1;
	        exit;
		 }else{
		 	echo -1;
	        exit;
		 }
    }
    

?>
<?php
	require('library/Db.class.php');
    $db   = new Db();
	session_start();
	$newpassword = $_POST['newpassword'];
	$send_email = $_POST['send_email'];
	$old_password = $_POST['old_password'];
	$answer = $_POST['answer'];
	$questionidnew = $_POST['questionidnew'];
	
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	
	if($questionidnew==-1){
		$answer = $user["type_answer"];
	}
	
	if($newpassword==""){
		$newpassword = $user["password"];
	}else{
		$newpassword = md5($newpassword);
	}
	
	if($send_email==""){
		$send_email = $user["email"];
	}
	
	if(md5($old_password)!=$user['password']){
		echo -1;
		exit;
	}else{
		$sql     = "UPDATE user SET password = :password,email = :email,type_answer = :type_answer WHERE id = :user_id";
	    $update  =  $db->query($sql,array("user_id"=>$user_id,"password"=>$newpassword,"email"=>$send_email,"type_answer"=>$answer));
	    if($update !== false){
	    	echo 1;
	    	exit;
	    }else{
	    	echo -2;
	    	exit;
	    }
	}
	
?>
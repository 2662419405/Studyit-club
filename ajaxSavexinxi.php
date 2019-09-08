<?php
	require('library/Db.class.php');
    $db   = new Db();
	session_start();
	$bio = $_POST['bio'];
	$tr_interest = $_POST['tr_interest'];
	$tr_sightml = $_POST['tr_sightml'];
	$user_id = $_SESSION['user']['id'];
	
	$sql="UPDATE user SET aihao = :aihao,jieshao = :jieshao,qianming = :qianming WHERE id = :user_id";
	$update  =  $db->query($sql,array("user_id"=>$user_id,"aihao"=>$tr_interest,"jieshao"=>$bio,"qianming"=>$tr_sightml));
    if($update !== false){
    	echo 1;
    	exit;
    }else{
    	echo -1;
    	exit;
    }
	
	
?>
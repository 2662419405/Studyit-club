<?php
	require('library/Db.class.php');
    $db   = new Db();
	session_start();
	$true_name = $_POST['true_name'];
	$sex = $_POST['sex'];
	$bir = $_POST['bir'];
	$chu = $_POST['chu'];
	$ju = $_POST['ju'];
	$qing = $_POST['qing'];
	$xue = $_POST['xue'];
	$qq = $_POST['qq'];
	$user_id = $_POST['user_id'];
	
	$sql="UPDATE user SET bir = :bir,chusheng = :chusheng,juzhu = :juzhu,qinggan=:qinggan,true_name=:true_name,sex=:sex,qq=:qq,xue=:xue WHERE id = :user_id";
	$update  =  $db->query($sql,array("user_id"=>$user_id,"bir"=>$bir,"sex"=>$sex,"chusheng"=>$chu,"juzhu"=>$ju,"qinggan"=>$qing,"true_name"=>$true_name,"qq"=>$qq,"xue"=>$xue));
    if($update !== false){
    	echo 1;
    	exit;
    }else{
    	echo -1;
    	exit;
    }
	
	
?>
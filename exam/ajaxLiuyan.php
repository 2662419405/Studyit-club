<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	
	$name=$_POST['name'];
	$sendName=$_POST['sendName'];
	$content=$_POST['content'];
	
	$add=time();
	$sql="insert into liuyan (username,addtime,content,name) VALUE (:username,$add,:content,:name)";
	$cha=$db->query($sql,array('username'=>$sendName,'content'=>$content,'name'=>$name));
	
	if($cha){
		echo 1;
		exit;
	}else{
		echo -1;
		exit;
	}
	
	include("bg_view/header.html");
	?>
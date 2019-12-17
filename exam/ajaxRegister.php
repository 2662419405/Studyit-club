<?php
	session_start();
    require('library/Db.class.php');
    $username  = $_POST['username'];
    $pass  = $_POST['pass'];
    $qq  = $_POST['qq'];
    $tel  = $_POST['tel'];
    $emil  = $_POST['emil'];
    
    $db   = new Db();
    $addtime =time();
    
    $sql="insert into user(username,password,addtime,last_addtime,email,tel,qq) values (:username,:password,$addtime,$addtime,:email,:tel,:qq)";
    
    $result=$db->query($sql,array("username"=>$username,"password"=>md5($pass),"email"=>$emil,"tel"=>$tel,"qq"=>$qq));
    
    $sql1  = "select * from user where username = :username";
    $user = $db->row($sql1,array('username'=>$username));
    $db->query("insert into geren(user_id) values(:id)",array('id'=>$user['id']));
    
    if($result){
    	$_SESSION['user']= $user;//把信息存到session中
    	$_SESSION['success']="guan";//控制是否可以跳转到注册页面
    	echo 1;
    	exit;
    }else{
    	echo -1;
    	exit;
    }
    
?>
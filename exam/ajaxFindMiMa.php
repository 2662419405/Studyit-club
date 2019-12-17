<?php
	session_start();
    require('library/Db.class.php');
    $pass  = $_POST['password'];
    $tel = $_POST['tel'];
    $db   = new Db();
    
    $sql="update user set password = :pass where tel = :tel";
    $result=$db->query($sql,array("pass"=>md5($pass),"tel"=>$tel));
    
    $sql1  = "select * from user where tel = :tel";
    $user = $db->row($sql1,array('tel'=>$tel));
    
    if($result){
    	$_SESSION['user']= $user;//把信息存到session中
    	$_SESSION['zhaohui']="guan";//控制是否可以跳转到注册页面
    	echo 1;
    	exit;
    }else{
    	echo -1;
    	exit;
    }
    
?>
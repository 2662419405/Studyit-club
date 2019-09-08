<?php
    session_start();
    require('library/Db.class.php');
    $username  = $_POST['username'];
    $password  = $_POST['password'];
    $authcode  = $_POST['authcode'];
    $memory  = $_POST['memory'];
    
    if($authcode!=$_SESSION['authcode']){
    	echo -2;
    	exit;
    }
    if($memory==1){
        setcookie("username", $username,time()+3600*24*7); 
	    setcookie("password", $password,time()+3600*24*7); 
	    setcookie("memory", $memory,time()+3600*24*7); 
	} else{
	    setcookie('username',$name,time()-3600*24*7);
	    setcookie('password',$password,time()-3600*24*7);
	    setcookie('memory',$memory,time()-3600*24*7);
 	}
    
    $sql  = "select * from user where username = :username and password = :password";
    $db   = new Db();
    $user = $db->row($sql,array('username'=>$username,'password'=>md5($password)));
   if($user){
        $_SESSION['user']= $user;//把信息存到session中
        
        $shi=time();
        $sql_time="update user set last_addtime = $shi where username = :username";
        $db->query($sql_time,array('username'=>$username));
        echo 1;
    }else{
        echo -1;
	}
    

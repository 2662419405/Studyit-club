<?php
	session_start();
    require('library/Db.class.php');
    $username  = $_POST['username'];
    $password  = $_POST['password'];
    
    $db   = new Db();
    
    $sql  = "select * from user where username = :username and password = :password";
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
?>
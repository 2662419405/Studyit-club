<?php
	session_start();
    require('library/Db.class.php');
    $to_id=$_POST['to_id'];
    $db   = new Db();
    
    $dian=$db->query("update geren set zan=zan+1 where user_id=$to_id");
    if($dian){
    	echo "1";
    	exit;
    }
?>
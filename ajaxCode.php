<?php
	session_start();
	$code= $_POST['telement'];
	
	if($code==$_SESSION['dx_code']){
		echo 1;
		exit;
	}else{
		echo -1;
		exit;
	}
    
?>
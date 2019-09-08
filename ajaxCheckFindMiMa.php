<?php
	require('library/Db.class.php');
    $db   = new Db();
	session_start();
	$tel = $_POST['tel'];
	
	$sql  = "select * from user where tel = :tel";
    $user = $db->row($sql,array('tel'=>$tel));
   	if($user){
		//如果存在这个号码
		include 'smsapi.class.php';
    	//接口账号
		$uid = 'sunhang';
		//接口密码
		$pwd = '80a1580da2040d43e6aa990d78a203d1';
		$api = new SmsApi($uid,$pwd);
		$mobile = $tel;
		$yan=$api->randNumber();
    	//短信内容参数
		$contentParam = array(
			'code'  => $yan
		);
		
		//变量模板ID
		$template = '511243';
		
		//发送变量模板短信
		$result = $api->send($mobile,$contentParam,$template);
		
		if($result['stat']=='100')
		{
			$_SESSION['dx_code']=$yan;
			echo 1;
			exit;
		}
		else
		{
			echo '发送失败:'.$result['stat'].'('.$result['message'].')';
			exit;
		}
	}else{
		echo -1;
		exit;
	}
	
?>
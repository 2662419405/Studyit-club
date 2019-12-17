<?php
	require('library/Db.class.php');
    $db   = new Db();
	session_start();
	$content = $_POST['content'];
	$to = $_POST['to'];
	$type = $_POST['type'];
	$lei = $_POST['lei'];
	$cang=$_POST['cang'];
	$addtime = time();
	
	$sql1="insert into tie_main(guan_main,addtime,content,type,hui_type,`from`,`to`,lou) values (:guan_main,$addtime,:content,:type,:hui_type,:from,:to,1)";
	
	$cha1=$db->query($sql1,array('guan_main'=>$cang,'content'=>$content,'type'=>$lei,'hui_type'=>$_SESSION['user']['id'],'from'=>$_SESSION['user']['username'],'to'=>$to));
	
	if($cha1){
		$sql="update tie set hui=hui+1 where guan_main=:main";
		$db->query($sql,array('main'=>$cang));
		$sql1="update user set hui_num=hui_num+1 where id=:id";
		$db->query($sql1,array('id'=>$_SESSION['user']['id']));
		$sql2="update tie set last_admin =:last where guan_main=:main";
		$db->query($sql2,array('last'=>$_SESSION['user']['username'],'main'=>$cang));
		echo "1";
		exit;
	}else{
		echo "2";
		exit;
	}
	
?>

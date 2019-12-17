<?php
	require('library/Db.class.php');
    $db   = new Db();
	session_start();
	$content = $_POST['content'];
	$mainFlag = $_POST['mainFlag'];
	$mainTitle = $_POST['mainTitle'];
	$type = $_POST['type'];
	$addtime = time();
	
	$sql="insert into tie(addtime,last_addtime,guan_main,admin,last_admin,type,te,title) values ($addtime,$addtime,:guan_main,:admin,:last_admin,:type,:te,:title)";
	$cha=$db->query($sql,array('guan_main'=>$addtime.$_SESSION['user']['username'],'admin'=>$_SESSION['user']['username'],'last_admin'=>$_SESSION['user']['username'],'type'=>$type,'te'=>$mainFlag,'title'=>$mainTitle));
	
	$sql1="insert into tie_main(guan_main,addtime,content,hui_type) values (:guan_main,$addtime,:content,:hui_type)";
	
	$cha1=$db->query($sql1,array('guan_main'=>$addtime.$_SESSION['user']['username'],'content'=>$content,'hui_type'=>$_SESSION['user']['id']));
	
	if($cha&&$cha1){
		$sql_id="update user set posts_num=posts_num+1 where id=:id";
		$update=$db->query($sql_id,array('id'=>$_SESSION['user']['id']));
		echo "1";
		exit;
	}else{
		echo "2";
		exit;
	}
	
?>

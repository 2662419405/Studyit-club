<?php
require('library/Db.class.php');
require("library/function.php");
is_login();
session_start();
$username=$_COOKIE['chess_name'];
$db = new Db();
$row=$db->row("select * from tb_room where id = '".$_GET['roomid']."'");
$guest = $row['guest'];//获取查询结果中guest字段的值
$host = $row['host'];//获取查询结果中host字段的值
if($guest == '' && $host == ''){      //如果黑棋玩家和红棋玩家名称都为空
    $db->query("update tb_room set host = '$username',time_host = '".time()."',time = '".time()."' where id = '".$_GET['roomid']."'");
}elseif($guest != '' && $host != ''){//如果黑棋玩家和红棋玩家名称都不为空
    setcookie("message","人满为患！");        //定义Cookie变量message的值
    header("location:index.php");                 //跳转到游戏首页
    exit;        //退出
}elseif($host != '' && $guest == '' && $username != $host){                //如果红棋玩家名称不为空，黑棋玩家名称为空，并且黑棋玩家名称不等于红棋玩家名称
	$db->query("update tb_room set guest = '$username',time_guest = '".time()."',time = '".time()."' where id = '".$_GET['roomid']."'");
}elseif($guest != '' && $host == ''){//如果黑棋玩家名称不为空，红棋玩家名称为空
	$db->query("update tb_room set guest = '',host = '$username',flag = 'host',chess = '".$c."',time_host = '".time()."',time = '".time()."',moved='',eated='',guest_win='0',host_win='0',message_guest= '',message_host='' where id = '".$_GET['roomid']."'");
}else{
    setcookie("message","该昵称已被占用，请更换！");         //定义Cookie变量message的值
    header("location:index.php");                 //跳转到游戏首页
    exit;        //退出
}
header("location:room.php?id=".$_GET['roomid']);      //进入指定ID号的游戏房间
exit;        //退出
?>
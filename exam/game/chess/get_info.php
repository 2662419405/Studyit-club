<?php
require('library/Db.class.php');
require("library/function.php");
is_login();
$db = new Db();
$result=$db->row("select * from tb_room where id= '".$_GET['roomid']."'");
$chess = $result['chess'];       						//获取棋子在棋盘的位置
$flag = $result['flag'];            					//获取用户是主机还是客机
$moved = $result['moved'];       						//获取用户当前移动的棋子位置
$eated = $result['eated'];       						//获取被吃掉的棋子
$guest = $result['guest'];       						//获取客机（黑旗）名称
$host = $result['host'];            					//获取主机（红旗）名称
$guest = iconv("gbk","utf-8",$guest);					//编码转换
$host = iconv("gbk","utf-8",$host);					//编码转换
$time_guest = $result['time_guest'];   				//获取客机（黑旗）登录的时间
$time_host = $result['time_host']; 					//获取主机（红旗）登录的时间
$guest_win = $result['guest_win']; 					//获取客机（黑旗）胜局的次数
$host_win = $result['host_win'];      					//获取主机（红旗）胜局的次数
$message_guest = $result['message_guest'];    			//获取客机（黑旗）方发送的信息
$message_host = $result['message_host'];         		//获取主机（红旗）方发送的信息
$db->query("update tb_room set time = '".time()."' where ID = '".$_GET['roomid']."' limit 1");
echo $chess."|".$flag."|".$moved."|".$eated."|".$guest."|".$host."|".$guest_win."|".$host_win."|".$message_guest."|".$message_host;       					//输出棋盘最新的信息
?>
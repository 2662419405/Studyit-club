<?php
require('library/Db.class.php');
require("library/function.php");
session_start();
is_login();
$db = new Db();
$row=$db->row("select * from tb_room where id = '".$_GET['roomid']."'");
$chess = $row['chess'];//获取chess字段的值
$chess_explode = explode(",", $chess);       //应用逗号分隔符分割结果集
$eated = "";//初始化变量
for($c = "", $i = 0;$i < sizeof($chess_explode);$i++){       //重将定位棋盘中棋子的排列位置
    $new_chess = $chess_explode[$i];      //获取数组（棋子）中的元素
    if($i + 1 == $_GET['from'])             //获取棋子的起始位置，变量i加1，是因为坐标从1开始
        $new_chess = "blank";              //将变量赋予“blank.png”空图像
    if($i + 1 == $_GET['to'])  {           //获取棋子的跳跃的位置，即目的坐标，变量i加1，是因为坐标从1开始
        if($chess_explode[$i] != "blank")  //如果棋盘中棋子的值不等于blank
            $eated = $chess_explode[$i];      //将被吃掉的棋子的元素值赋给变量，例如“006”号棋
        $new_chess = $chess_explode[$_GET['from'] - 1];//将走棋的棋子赋给变量
    }
    $c .= $new_chess.",";              //以逗号为分隔符连接当前各个棋子的棋号
}
if($_GET['site'] == "guest")         //如果当前的玩家为黑棋玩家
    $flag = "host";                //将走棋标志定义为红棋玩家
else                        //如果当前的玩家为红棋玩家
    $flag = "guest";            //将走棋标志定义为黑棋玩家
	$db->query("update tb_room set chess = '$c', flag = '$flag', moved = '".$_GET['from'].",".$_GET['to']."', eated = '$eated' where id = '".$_GET['roomid']."' limit 1");
?>
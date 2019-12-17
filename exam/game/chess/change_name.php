<?php
require('library/Db.class.php');
require("library/function.php");
is_login();
session_start();
$db = new Db();
if($_POST['nick_name'] == ''){          //如果用户名称为空
    setcookie("message", "名字不能为空！");      //弹出提示信息
    header("location:index.php");        //跳转到游戏首页
    exit;                          //退出
}
if(strlen($_POST['nick_name']) > 13){                 //如果用户名长度大于25个字节
    setcookie("message", "玩家名称不能超过13个字符！");       //弹出提示信息
    header("location:index.php");        //跳转到游戏首页
    exit;                          //退出
}
$num=$db->row("select count(*) as 'num' from tb_room where host = '".$_POST['nick_name']."' or guest = '".$_POST['nick_name']."' limit 1");
$num = $row['num'];//获取num字段的值并赋值给变量
if($num!=0){                  //如果用户创建的名称已经存在
    setcookie("message", "该昵称已被占用！");           //弹出提示信息
    header("location:index.php");        //跳转到游戏首页
    exit;                          //退出
}
setcookie("chess_name", $_POST['nick_name']); 

header("location:index.php");           //跳转到游戏首页
?>
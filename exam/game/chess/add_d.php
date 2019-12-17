<?php
session_start();
if($_POST['play_room'] == ''){                   //如果房间名称为空
    setcookie("message", "游戏房间名称不能为空！");         //弹出提示信息
    header("location:index.php");                 //如果房间名称为空，则返回首页
    exit;
}
require('library/Db.class.php');
require("library/function.php");
require("function.php");
is_login();
$db = new Db();
$addtime =time();
$db->query("insert into tb_room(id,name,chess,time)
                              values (NULL,'".$_POST['play_room']."','$c','".$addtime."')");

$id=$db->row("select * from tb_room where time =$addtime");                      //获取INSERT操作产生的ID号
if($id){      //如果id的逻辑值为真
    header("location:join.php?roomid=".$id['id']);               //进入房间
    setcookie("message","中国网络象棋游戏欢迎您的加盟，游戏房间创建成功！");         //弹出提示信息
}
?>
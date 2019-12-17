<?php
require('library/Db.class.php');//连接数据库
require("library/function.php");   //自定义函数

is_login();
$db   = new Db();
$pid  = $_GET['pid'];
$sql  = "SELECT * FROM post where post_type = 2 and pid = :pid  ORDER BY addtime DESC limit 2 ";
$post = $db->query($sql,array('pid'=>$pid));
foreach($post as $vo){
    $vo['avatar']  = $db->single('select avatar from user where id = :user_id',array('user_id'=>$vo['user_id']));
    $lists[] = $vo;
}

/**转发总数**/
$total_forword = $db->single('select count(*) from post where post_type = 2 and pid = :pid',array('pid'=>$pid));
include 'view/forward-layer.php';


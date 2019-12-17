<?php
require('library/Db.class.php');
require("library/function.php");
is_login();
$db = new Db();
$db->query("delete from tb_room where id= '".$_GET['roomid']."'");
header('location:index.php');                    //定位到首页
?>
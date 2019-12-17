<?php
require('library/Db.class.php');
require("library/function.php");
is_login();
$db = new Db();
if($_GET['message'])         //如果成功获取聊天信息
    $db->query("update tb_room set `message_".$_GET['site']."` = '".$_GET['message']."' where id = '".$_GET['roomid']."'");
?>
<?php
require('library/Db.class.php');
require("library/function.php");
require("function.php");
is_login();
$db = new Db();
if(isset($_GET['site']))         //如果site参数被设置
    $db->query("update tb_room set ".$_GET['site']." = '',flag = '".($_GET['site']=='host'?'guest':'host')."', chess='".$c."', moved='',eated='',guest_win='0',host_win='0',message_guest= '',message_host='' where id = '".$_GET['roomid']."'");
header('location:index.php');                    //定位到首页
?>
<?php
require('library/Db.class.php');
require("library/function.php");
is_login();
$db = new Db();
$db->query("update tb_room set chess = '$c',flag = 'host',moved = '',eated = '', guest_win = '".$_GET['guest_win']."', host_win = '".$_GET['host_win']."' where id = '".$_GET['roomid']."'");
?>
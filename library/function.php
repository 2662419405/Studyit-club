<?php
function is_login(){
    session_start(); 
    if(isset($_SESSION['user']['id']) && isset($_SESSION['user']['username'])){
        return true;
    }else{
        echo "<script>window.location.href = 'login.php'</script>";
    }
}

function tranTime($time) {
    $rtime = date("m-d H:i", $time);
    $htime = date("H:i", $time);
    $time = time() - $time;
    if ($time < 60) {
        $str = '刚刚';
    } elseif ($time < 60 * 60) {
        $min = floor($time / 60);
        $str = $min . '分钟前';
    } elseif ($time < 60 * 60 * 24) {
        $h = floor($time / (60 * 60));
        $str = $h . '小时前 ' . $htime;
    } elseif ($time < 60 * 60 * 24 * 3) {
        $d = floor($time / (60 * 60 * 24));
        if ($d == 1)
            $str = '昨天 ' . $rtime;
        else
            $str = '前天 ' . $rtime;
    }
    else {
        $str = $rtime;
    }
    return $str;
}

function ubbReplace($str) {
    $str = str_replace("<", '<；', $str);
    $str = str_replace(">", '>；', $str);
    $str = str_replace("\n", '>；br/>；', $str);
    $str = preg_replace("[\[em_([0-9]*)\]]", "<img src=\"face/$1.gif\" />", $str);
    return $str;
}

function shijian($time){
	if($time<'60'){
		$str=$time."秒";
	}elseif($time>='60'&&$time<'3600'){
		$min = floor($time / 60);
		$sed = $time % 60;
		$str=$min."分".$sed."秒";
	}else{
		$h = floor($time / (60 * 60));
		$min = floor(($time-$h*3600)/60);
		$sed = $time % 60;
		$str=$h."小时".$min."分".$sed."秒";
	}
	return $str;
}

function get_cover_path($avatar){
    if($avatar){
        $path = 'images/'.$avatar;
    }else{
        $path = 'img/avatar.jpg';
    }
    return $path;
}

function get_user_info($user_id){
    $db     = new Db();
    $sql    = 'select * from user where id = :user_id';
    $user   = $db->row($sql,array('user_id'=>$user_id));
    return $user;
}

function is_follow($friend_id){
    $user_id = $_SESSION['user']['id'];
    $sql = 'select status from friends where user_id = :user_id and friend_id =:friend_id';
    $db  = new Db();
    $status = $db->single($sql,array('user_id'=>$user_id,'friend_id'=>$friend_id));
    if($status == 1){
        return true;
    }else{
        return false;
    }
}
?>
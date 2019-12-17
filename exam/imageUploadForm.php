<?php
if (!$_FILES['Filedata']) {
	die ( 'Image data not detected!' );
}
if ($_FILES['Filedata']['error'] > 0) {
	switch ($_FILES ['Filedata'] ['error']) {
		case 1 :
			$error_log = 'The file is bigger than this PHP installation allows';
			break;
		case 2 :
			$error_log = 'The file is bigger than this form allows';
			break;
		case 3 :
			$error_log = 'Only part of the file was uploaded';
			break;
		case 4 :
			$error_log = 'No file was uploaded';
			break;
		default :
			break;
	}
	die ( 'upload error:' . $error_log );
} else {
	$img_data = $_FILES['Filedata']['tmp_name'];
	$size = getimagesize($img_data);
	$file_type = $size['mime'];
	if (!in_array($file_type, array('image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'))) {
		$error_log = 'only allow jpg,png,gif';
		die ( 'upload error:' . $error_log );
	}
	switch($file_type) {
		case 'image/jpg' :
		case 'image/jpeg' :
		case 'image/pjpeg' :
			$extension = 'jpg';
			break;
		case 'image/png' :
			$extension = 'png';
			break;
		case 'image/gif' :
			$extension = 'gif';
			break;
	}	
}
if (!is_file($img_data)) {
	die ( 'Image upload error!' );
}
$save_path = dirname( __FILE__ ).'/images/';
$uinqid = uniqid();
$filename = $save_path . '/' . $uinqid . '.' . $extension;
$result = move_uploaded_file( $img_data, $filename );
if ( ! $result || ! is_file( $filename ) ) {
	die ( 'Image upload error!' );
}
echo 'Image data save successed,file:' . $filename;

require('library/Db.class.php');
session_start();
$user_id = $_SESSION['user']['id'];
$db      = new Db();
$head    = $uinqid . '.' . $extension;
$sql     = "UPDATE user SET avatar = :head WHERE id = :user_id";
$res     = $db->query($sql,array("user_id"=>$user_id,"head"=>$head));
$_SESSION['user']['avatar'] = $head;

exit ();
<?php
    require('library/Db.class.php');   
    require("library/function.php");   
    is_login();
    $db = new Db();
    $user_id = $_SESSION['user']['id'];
    $user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
    
    $post_id   = $_GET['post_id'];
    
	//查询头像    
    $post_info = $db->row("select * from post  where id = :post_id",array('post_id'=>$post_id));
    $post_info['avatar'] = $db->single('select avatar from user where id = :user_id',array('user_id'=>$post_info['user_id']));

	//分页
	$pageSize=8;	
	
	$pageNum=empty($_GET['pageNum'])?1:$_GET['pageNum'];
		$sql="select * from post where pid = :pid order by addtime desc limit ".(($pageNum-1)*$pageSize).",".$pageSize;
		$com_lists = $db->query($sql,array('pid'=>$post_id));
		$toutal = $db->single('select count(*) from post where pid = :pid',array('pid'=>$post_id));
		
	$yeshu=ceil($toutal/$pageSize);

	//最佳图片
    foreach($com_lists as $vo){
        $vo['avatar']  = $db->single('select avatar from user where id = :user_id',array('user_id'=>$vo['user_id']));
        $lists[]       = $vo;
    }
    
    include("css/header.html");
    ?>
<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8" />
	<title>更多评论</title>
	<?php include("css/main.html"); ?>
	<?php include("view/head.php"); ?>
	<?php include("css/footer.html"); ?>
	<?php include("css/header.html"); ?>
	<style type="text/css">
		body{
			background: #FFFFFF;
		}
		#footer{
			margin-top: 20px;
			float: left;
			width: 100%;
		}
		.data {
		     margin: 0!important; 
		}
	</style>
</head>
<body style="background: url(img/body_bg.png) center 35px no-repeat #d4e8fe;">
	<?php include("view/header.php"); ?>
		<div class="main" style="width: 1000px; margin: 100px auto;">
			<div class="left">
				<h4 class="weibo_list_title" style="margin-top: 10px">全部评论</h4>
		        <?php if(!isset($lists)){ ?>
		            <div class="empty">还没有评论哦！</div>
		        <?php }else{ ?>
		            <?php foreach ($lists as $v) { ?>
		            <div class="weibo_list">
		                <div class="weibo_list_top">
		                    <div class="weibo_list_head">
		                        <a>
		                            <img class="avatar" src="<?php echo get_cover_path($v['avatar']) ?>">
		                        </a>
		                    </div>
		                    <ul>
		                        <li><b><?php echo $v['username'] ?></b></li>
		                        <li><span><?php echo tranTime($v['addtime']); ?></span></li>
		                        <li><p><?php echo ubbReplace($v['content']); ?></p>
		                        </li>
		                    </ul>
		                </div>
		            </div>
		            <?php }} ?>
				<?php include_once("view/com_page.php"); ?>
			</div>
			<?php include_once("view/ri.php"); ?>
			<?php include_once("view/right.php"); ?>
		</div>
		<?php include_once("view/footer.php"); ?>
	</body>			
</html>    
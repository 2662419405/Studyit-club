<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	session_start();
	$db = new Db();
	//查看用户id
	$user_id=empty($_GET['id'])?$_SESSION['user']['id']:$_GET['id'];
	$addtime = time();
	
	//分别遍历被访问的信息，和空间信息
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	$geren = $db->row("select * from geren where user_id = :user_id",array('user_id'=>$user_id));
	
	if($user_id!=$_SESSION['user']['id']){
		//如果不是自己访问
		$sql="insert into kong(f,t,addtime)values(:f,:t,$addtime)";
		$db->query($sql,array('f'=>$_SESSION['user']['id'],'t'=>$user_id));
		$db->query("update geren set fang=fang+1 where user_id=$user_id");
	}
	
	//遍历今日被访问次数
	$todaystart = strtotime(date('Y-m-d'.'00:00:00',time()));
	$todayend = strtotime(date('Y-m-d'.'00:00:00',time()+3600*24));
	$jinri_fang = $db->single("select count(*) from kong where t=:t and addtime between :shijian and :jiezhi ",array('t'=>$user_id,'shijian'=>$todaystart,'jiezhi'=>$todayend));
	
	?>

<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8" />
	<title><?php echo $user['username']."的空间";?></title>
	<?php include("css/main.html"); ?>
	<?php include("view/head.php"); ?>
	<?php include("css/footer.html"); ?>
	<?php include("css/geren.html"); ?>	
	<?php include("css/header.html"); ?>	
	<script type="text/javascript" src="highslide/highslide-with-gallery.js"></script>
	<style type="text/css">
		body{
			background: #FFF;
			overflow-x: hidden;
		}
	</style>
</head>
<body>
	<?php include("view/header.php"); ?>
	
	<div class="background-container">
		<div class="layout-head ">
			<div class="layout-head-inner" style="background: no-repeat; height: 250px;">
				<div class="head-info">
					<h1 class="head-title">
						<span class="title-text ui-mr5"><?php echo $user['username']."的空间";?></span>
					</h1>
					<div class="head-description">
						<span class="description-text"><?php echo $geren['title'];?></span>
					</div>
				</div>
				<div class="head-detail">
					<div class="head-detail-name">
						<span class="user-name textoverflow">
							<?php echo $user['username'];?>
						</span>
					</div>
					<div class="head-detail-info clearfix" style="font-size: 16px;">
						<ul class="fff">
							<li>发帖:<?php echo $user['posts_num'];?></li>
							<li>关注:<?php echo $user['follows_num'];?></li>
							<li>粉丝:<?php echo $user['fans_num'];?></li>
						</ul>
					</div>
				</div>
				<div class="layout-shop-item">
					<div class="shop-item cs" style="width: px; height: 32px; left: 150px; top: 252px;">
						<div class="head-nav">
							<ul class="head-nav-menu">
								<li style="display: <?php if($user_id==$_SESSION['user']['id']){echo "inline-block";}else{echo "none";}?>;">
									<span class="arr">
										<a href="geren.php">主页</a>
									</span>
								</li>
								<li>
									<span class="arr">
										<a href="shuoshuo.php?id=<?php echo $user_id;?>">说说</a>
									</span>
								</li>
								<li>
									<span class="arr">
										<a href="zanMe.php?id=<?php echo $user_id;?>">我的赞</a>
									</span>
								</li>
								<li>
									<span class="arr">
										<a href="fenMe.php?id=<?php echo $user_id;?>">粉丝</a>
									</span>
								</li>
								<li>
									<span class="arr">
										<a href="guanMe.php?id=<?php echo $user_id;?>">关注</a>
									</span>
								</li>
								<li>
									<span class="arr">
										<a href="liuyanban.php?id=<?php echo $user_id;?>">留言板</a>
									</span>
								</li>
								<li>
									<span class="arr">
										<a href="dang.php?id=<?php echo $user_id;?>">个人档</a>
									</span>
								</li>
							</ul>
						</div>
					</div>
					<div class="shop-item" style="top: 186px; left: 887px; width: 159px; height: 56px; cursor: pointer;">
						<div class="visit-module">
							<div class="other-info">
								<div class="today-wrapper">
									<p class="visit-today">
										今日访客 
										<span class="count count-margin "><?php echo $jinri_fang;?></span>
									</p>
								</div>
								<div class="count-wrapper">
									<p class="visit-count">
										访问总量
										<span class="count ">
											<?php echo $geren['fang'];?>
										</span>
									</p>
								</div>
							</div>
							<i class="icon-visit icon-star-1">
							</i>
						</div>
					</div>
				</div>
				<div class="actions profile-hd-actions">
					<a id="cancel-follow" href="javascript:;" class="btn-head" id="add_specialcare" style="display: <?php if($user_id==$_SESSION['user']['id']){echo "none";}else{echo "inline-block";}?>;">
						<s class="ui-icon icon_add_care"></s>
						<span class="txt">
							<?php if(is_follow($user_id) == true){
								echo "取消关注";
							}else{
								echo "添加关注";
							}?>
						</span>
					</a>
					<div class="btn-head btn-head-like">
						<a class="lnk-left" style="text-decoration: none;" href="javascript:;" onclick="zan()" title="<?php echo $geren['zan'];?>">
							<s class="ui-icon sp-btn-like"></s>
							<span class="txt good-num">
								<?php echo $geren['zan'];?>
							</span>
							<span class="txt message-num">
							</span>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="layout-nav">
			<div class="layout-nav-inner">
				<div class="head-avatar">
					<img title="进入空间" src="<?php if($user['avatar']==null){echo "img/avatar.jpg";}else{echo "images/".$user['avatar'];}?>" class="user-avatar" value="<?php echo $user['avatar'] ?>">
				</div>
			</div>
		</div>
		<div class="layout-background">
			<div class="layout-body">
				<div class="layout-page clearfix">
					
					
					<div class="bg_mode">
						<div class="box_ml bor">
							<div class="mode_gb">
								<div class="mode_gb_title style_mode_gb_title">
									<div class="bg_mode_gb_title">
										<h3>个人档</h3>
									</div>
								</div>
								<div class="mode_gb_cont">
									<div class="userinfo_mode">
										<div class="info_side bg3 bor3">
											<div class="portrait_container">
												<p class="icon_container">
													<a href="#" class="bor2">
														<img title="进入空间" src="<?php if($user['avatar']==null){echo "img/avatar.jpg";}else{echo "images/".$user['avatar'];}?>" class="user-avatar" value="<?php echo $user['avatar'] ?>">
													</a>
												</p>
												<p class="edit_icon_info">
													<a href="setting.php" class="c_tx" style="display: <?php if($user_id==$_SESSION['user']['id']){echo "inline-block";}else{echo "none";}?>;">修改头像</a>
												</p>
												<div class="counter bbor2">
													<ul class="clearfix">
														<li class="rbor3">
															<a href="#">说说</a>
															<?php echo $user['posts_num'];?>
														</li>
														<li class="rbor3">
															<a href="#">粉丝</a>
															<?php echo $user['fans_num'];?>
														</li>
														<li class="rbor3">
															<a href="#">关注</a>
															<?php echo $user['follows_num'];?>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="info_frame">
											<div class="mod_tab">
												<div class="mode_menu_tag2">
													<ul>
														<li id="feed_tab">
															<a href="javascript:;" id="feed_link">基本资料</a>
														</li>
														<li id="info_tab" class="nowtag">
															<a href="javascript:;" id="info_link">个人信息</a>
														</li>
													</ul>
												</div>
											</div>
											<div class="info_preview" id="content1">
												<div class="preview_title bbor2">
													<h4>基本资料</h4>
												</div>
												<div class="preview_list">
													<ul>
														<li>
															<label>用户名:</label><div class="preview_option">
													<?php if($user['username']==null){echo "未填写";}else{echo $user['username'];} ?>				
															</div>
														</li>
														<li>
															<label>真实姓名:</label><div class="preview_option">
																<?php if($user['true_name']==null){echo "未填写";}else{echo $user['true_name'];} ?>
															</div>
														</li>
														<li>
															<label>性别:</label><div class="preview_option">
																<?php if($user['sex']==0){echo "保密";}else if($user['sex']==1){echo "女";}else{echo "男";} ?>
															</div>
														</li>
														<li>
															<label>生日:</label><div class="preview_option">
																<?php if($user['bir']==null){echo "未填写";}else{echo $user['bir'];} ?>
															</div>
														</li>
														<li>
															<label>出生地:</label><div class="preview_option">
																<?php if($user['chusheng']==null){echo "未填写";}else{echo $user['chusheng'];} ?>
															</div>
														</li>
														<li>
															<label>居住地:</label><div class="preview_option">
																<?php if($user['juzhu']==null){echo "未填写";}else{echo $user['juzhu'];} ?>
															</div>
														</li>
														<li>
															<label>情感状况:</label><div class="preview_option">
																<?php if($user['qinggan']==null){echo "未填写";}else{echo $user['qinggan'];} ?>
															</div>
														</li>
														<li>
															<label>血型:</label><div class="preview_option">
																<?php if($user['xue']==null){echo "未填写";}else{echo $user['xue'];} ?>
															</div>
														</li>
														<li>
															<label>QQ:</label><div class="preview_option">
																<?php if($user['qq']==null){echo "未填写";}else{echo $user['qq'];} ?>
															</div>
														</li>
													</ul>
												</div>
											</div>
											<div id="content2" class="info_preview">
												<div class="preview_title bbor2">
													<h4>个人信息</h4>
												</div>
												<div class="preview_list">
													<ul>
														<li class="ll_li">
															<label>自我介绍:</label><div class="preview_option">
													<?php echo $user['jieshao']?>				
															</div>
														</li>
														<li class="ll_li">
															<label>个性签名:</label><div class="preview_option">
													<?php echo $user['qianming']?>				
															</div>
														</li>
														<li class="ll_li">
															<label>兴趣爱好:</label><div class="preview_option">
														<?php echo $user['aihao']?>			
															</div>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	
	<?php include("view/right.php"); ?>
	<?php include("view/footer.php"); ?>
	<script>
		function zan(){
			var to_id=<?php echo $user_id;?>;
			$.post('ajaxTian.php',{
				to_id:to_id
			},
			function(data){
				console.log(data);
				if(data==1){
					layer.msg('点赞成功',{time:1000},function(){
				            var index = parent.layer.getFrameIndex(window.name);
				            parent.location.reload();
				            parent.layer.close(index); 
				        });
				}else{
					layer.msg('点赞失败');
				}
			})
		}
		
		$('#content2').hide();
		$('#feed_tab').click(function(){
			$('#content1').show();
			$('#content2').hide();
		})
		$('#info_tab').click(function(){
			$('#content2').show();
			$('#content1').hide();
		})
	</script>
</body>
</html>

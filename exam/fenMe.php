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
	
	$na=$user['username'];
	
	//分页
	$pageSize=8;
	$pageNum=empty($_GET['pageNum'])?1:$_GET['pageNum'];
	$sql="select * from friends where friend_id = :user_id and status =1 order by id desc limit ".(($pageNum-1)*$pageSize).",".$pageSize;
	$friends = $db->query($sql,array('user_id'=>$user_id));
	$toutal   = $db->single("select count(*) from friends where friend_id = :user_id and status =1 ",array('user_id'=>$user_id));
	$yeshu=ceil($toutal/$pageSize);

    if(isset($friends)){
	    foreach($friends as $vo){
	        $data = $db->row('select * from user where id = :user_id',array('user_id'=>$vo['user_id']));
	        $lists[] = $data;
	    }
	}
    
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
					
					
					<div class="left1">
				<h4 class="list_title">
					粉丝
					<span><?php echo $toutal?></span>
				</h4>
				<div class="my_fans my_friend">
		            <?php if (!isset($lists)) {
		                echo "还没有粉丝哦！";
		            }else{
		                foreach($lists as $v){
		                	$username=$v['id'];  
		                	?>
		                	<a href="shuoshuo.php?id=<?php echo $username?>" class="aaaa">
		                		<div class="my_fans_list">
			                       	<img class="fl" src="<?php echo get_cover_path($v['avatar']) ?>">
			                        <ul class="fl">
			                            <li><?php echo $v['username'] ?></li>
			                            <li>
			                                <span>关注</span><font><?php echo $v['follows_num'] ?></font><span>|</span>
			                                <span>粉丝</span><font><?php echo $v['fans_num'] ?></font><span>|</span>
			                                <span>帖子</span><font><?php echo $v['posts_num'] ?></font>
			                            </li>
			                            <li><span>注册于：<?php echo date('Y-m-d',$v['addtime']) ?></span>
			                                <span>QQ:<?php echo $v['qq'] ?></span>
			                            </li>
			                        </ul>
			                    </div>
		                	</a>
		                <?php } ?>
		            <?php } ?>
		        </div>
				<div class="ls">
					<?php include_once("view/liuyanbanpage.php"); ?>
				</div>
			</div>
					
				<?php include("view/ri.php"); ?>
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
	</script>
</body>
</html>

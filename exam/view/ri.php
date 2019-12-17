<div class="right">
	<div class="top" style="background: url(img/my_info_bg.png);">
		<a href="shuoshuo.php">
			<img class="info" src="<?php if($_SESSION['user']['avatar']==null){echo "img/avatar.jpg";}else{echo "images/".$_SESSION['user']['avatar'];}?>" value="<?php echo $_SESSION['user']['avatar'] ?>">
		</a>
		<h4><?php echo $_SESSION['user']['username']?></h4>
		<div class="right_hhh">
			<ul title="说说">
				<li><span><?php echo $_SESSION['user']['posts_num'];?></span></li>
				<li>说说</li>
			</ul>
			<ol></ol>
			<ul title="关注">
				<li><span><?php echo $_SESSION['user']['follows_num'];?></span></li>
				<li>关注</li>
			</ul>
			<ol></ol>
			<ul title="粉丝">
				<li><span><?php echo $_SESSION['user']['fans_num'];?></span></li>
				<li>粉丝</li>
			</ul>
		</div>
	</div>
	<div class="dibu">
		<h4>个人资料</h4>
		<p>用户名<span><?php echo $_SESSION['user']['username']?></span></p>
		<p>性别<span><?php if($_SESSION['user']['sex']==0){echo '保密';}
						if($_SESSION['user']['sex']==1){echo '男';} if($_SESSION['user']['sex']==2){echo '女';}?></span></p>
		<p>qq<span><?php echo $_SESSION['user']['qq']?></span></p>
		<p>电子邮箱<span><?php echo $_SESSION['user']['email']?></span></p>
		<p>手机<span><?php echo $_SESSION['user']['tel']?></span></p>
	</div>
</div>
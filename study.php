<?php
	require('library/Db.class.php');
    $db   = new Db();
	session_start();
	$id=$_GET['id'];
	$result=$db->row("select * from study where title=:ti",array('ti'=>$id));
?>
<!DOCTYPE html>
<html lang="zh">
	<head>
		<meta charset="UTF-8" />
		<title><?php echo $id."学习资源";?></title>
		<?php include("css/main.html"); ?>
			<?php include("view/head.php"); ?>
			<?php include("css/footer.html"); ?>
			<?php include("css/study.html"); ?>	
			<style type="text/css">
				body{
					background: rgb(229,229,229);
				}		
			</style>
	</head>
<body>
	<?php include("view/header.php"); ?>
	
	<div id="study">
		<p class="gamePic">
			<img src="img/logo_it.png" alt="IT俱乐部" class="img123"/>
		</p>
		<ul>
			<li class="gameID_cn">
				<?php echo $result['title']."(IT俱乐部提供)";?>
			</li>
			<li class="gameID_zn">
			</li>
			<li class="gameSize">
				大小:
				<span><?php echo $result['size'];?></span>
			</li>
			<li class="gameSize">
				添加时间:
				<span><?php echo date('Y-m-d',$result['addtime'])?></span>
			</li>
			<li class="gameSize">
				添加者:
				<span><?php echo $result['admin']?></span>
			</li>
			<li class="gameSize">
				链接解释:
				<span>暂无</span>
			</li>
		</ul>
		<a href="#" onclick="diu()" class="gameDown down_js">
			<span></span>
			极速下载
		</a>
		<a href="#" onclick="diu()" class="gameDown down_xl">
			<span></span>
			迅雷链接下载
		</a>
		<a target="_blank" href="<?php echo $result['url'];?>" class="gameDown down_bd">
			<span></span>
			网盘下载(提取码:<?php echo $result['get'];?>)
		</a>
		<a href="#" onclick="diu()" class="gameDown down_bd">
			<span></span>
			种子下载
		</a>
		<i class="font_i"></i>
		<p>我们强烈推荐您使用百度云链接下载，如果打不开或者链接挂掉请联系开发人员！</p>
	</div>
	
	<?php include("view/right.php"); ?>
	<?php include("view/footer.php"); ?>
</body>
<script>
	function diu(){
		layer.msg('此链接方式尚未开放',{time:1000})
	}
</script>
</html>
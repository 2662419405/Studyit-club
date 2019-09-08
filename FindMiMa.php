<?php
	require('library/Db.class.php');
    $db   = new Db();
	session_start();
	$tel = $_GET['tel'];
	
	if($_SESSION['zhaohui']=="kai"){
		
    }else{
       echo "<script>window.location.href = 'mima.php'</script>";
    }
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>IT俱乐部-找回密码</title>
		<link rel="shortcut icon" href="ico/it.ico" />
		<link rel="stylesheet" type="text/css" href="css/index.css"/>
		<script src="js/jquery.js"></script>
		<script src="layer/layer.js"></script>
		<?php include("css/reg.html"); ?>
		<?php include("css/mima.html"); ?>
	</head>
	<body style="background-color: #efefef;">
		<div id="content">
			<div id="header" style="margin-bottom: 20px;">
				<div class="jin" style="max-width: 1200px;">
					<div class="left">
						<a href="login.php" class="login" title="登录"><span>登录</span></a>
						<a href="reg.php" class="login" title="注册"><span>注册</span></a>
						<img src="img/logo_it.png" title="IT俱乐部" class="avatar"/>
					</div>
					<div class="nav"></div>
					<h1>找回密码</h1>
				</div>
			</div>
			<div id="main">
				<div id="reg">
					<div class="reg_main">
						<div class="am_auto">
							<img src="img/wubiaoti.png" alt="IT俱乐部" title="IT俱乐部" class="for_i"/>
							<h1 class="hh">重设密码和两步验证</h1>
							<div class="group">
								<p>请您一定要牢记本次密码!</p>
								<p><b>
									注意：本网站目前只开放拥有用户名和手机才能找回密码，请牢记你的密码。
								</b></p>
							</div>
							<div class="group">
								<span class="span_tel">
									<i class="am_ico"><img src="img/mima.jpg" class="for_img"/></i>
								</span>
								<input type="password" class="form_tel" placeholder="请输入你的密码" id="password"/>
							</div>
							<input type="hidden" id="tel" value="<?php echo $tel;?>" />
							<div class="group">
								<span class="span_tel">
									<i class="am_ico"><img src="img/mima.jpg" class="for_img"/></i>
								</span>
								<input type="password" class="form_tel" placeholder="请再次输入你的密码" id="pass"/>
							</div>
							<div class="btn_for">
								<div class="btn am_btn" id="send_id">
									确认密码
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="footer" style="background: url(img/footer-bg.png);">
				<div class="wrap1">
					<img src="img/logo_it.png" title="IT俱乐部" class="img11"/>
					<div class="foorer1">
						在IT俱乐部，<br />
						感受学习的氛围
					</div>
					<div class="info">
						<p class="data">	
							<a href="#">关于我们</a>&nbsp;|
							<a href="#">帮助中心</a>&nbsp;|
							<a href="#">联系我们</a>&nbsp;|
							<a href="#">问题咨询</a>
							<br />
							<a href="#">为何选择我们</a>&nbsp;|
							<a href="#">资源分享</a>&nbsp;|
							<a href="#">项目研发</a>&nbsp;|
							<a href="#">讨论专区</a>
							<br />
							2019-2020 IT club@ Developed by the
							<a href="https://gitee.com/itstusy">there</a>
							<br />
							研发人员:2019年IT俱乐部人员
						</p>
					</div>
				</div>
			</div>
		</div>
	</body>
	<script>
		
		$("#send_id").click(function(){
			
			var password=$("#password").val();
			var newpass=$("#pass").val();
			var tel=$("#tel").val();
			
			if(password.length<4){
				layer.msg('密码不能小于四位',{time:1000});
				return false;
			}
			if(password!=newpass){
				layer.msg('两次密码不一致',{time:1000});
				return false;
			}
			
			$.post('ajaxFindMiMa.php',{
				password:newpass,
				tel:tel
			},function(data){
				console.log(data);
				if(data==1){
					layer.msg('修改成功',{time:1000});
					window.location.href="main.php";
				}else{
					layer.msg('修改失败',{time:1000});
				}
			})
			
		})
		
	</script>
</html>

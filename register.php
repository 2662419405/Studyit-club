<?php
	require('library/Db.class.php');
    $db   = new Db();
	session_start();
	$tel = $_GET['tel'];
	
	if($_SESSION['success']=="kai"){
    }else{
       echo "<script>window.location.href = 'reg.php'</script>";
    }
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>IT俱乐部-注册</title>
		<link rel="shortcut icon" href="ico/it.ico" />
		<link rel="stylesheet" type="text/css" href="css/index.css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="js/jquery.js"></script>
		<script src="layer/layer.js"></script>
		<?php include("css/register.html"); ?>
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
					<h1>注册</h1>
				</div>
			</div>
			<div class="all" style="height: 550px;">
				<div class="reg_main">
					<div>
						<span class="size16">账户注册</span>
						<span class="gray">请注册你的会员名和密码用于登录</span>
					</div>
					<div class="clearall"></div>
					<div class="reg_name size18">
						<span class="red">*</span>
						用户名
					</div>
					<div id="show_1" class="yincang" style="display: none;">
						<div class="formError">
							*最少4个字符
						</div>
					</div>
					<input type="text" name="username" id="username" placeholder="设置用户名" class="reg_input" onblur="chufa(this.value,1)"/>
					<p style="font-size: 0.8em; color: #FF0000; margin-left: 150px; display: none;" id="pl1">用户名已经存在</p>
					<div class="clearall"></div>
					<div class="reg_name size18">
						<span class="red">*</span>
						设置密码
					</div>
					<div id="show_2" class="yincang" style="display: none;">
						<div class="formError">
							请输入密码
							<br />
							*最少4个字符
						</div>
					</div>
					<input type="password" name="password" id="password" placeholder="设置你的登录密码" class="reg_input" onblur="chufa(this.value,2)"/>
					<div class="clearall"></div>
					<div class="reg_name size18">
						<span class="red">*</span>
						确认密码
					</div>
					<div id="show_3" class="yincang" style="display: none;">
						<div class="formError">
							请再输入一次密码
							<br />
							*最少4个字符
							<br />
							*请输入与上面相同的密码
						</div>
					</div>
					<input type="password" name="new_password" id="new_password" placeholder="请再次输入密码" class="reg_input" onblur="chufa(this.value,3)"/>
					<div class="clearall"></div>
					<div class="reg_name size18">
						<span class="red">*</span>
						QQ号码
					</div>
					<input type="hidden" id="tel" value="<?php echo $tel;?>" />
					<div id="show_4" class="yincang" style="display: none;">
						<div class="formError">
							请再输入QQ号码
							<br />
							*最少6个字符
						</div>
					</div>
					<input type="text" name="qq" id="qq" placeholder="QQ号码" class="reg_input" onblur="chufa(this.value,4)"/>
					<div class="clearall"></div>
					<div class="reg_name size18">
						<span class="red">*</span>
						邮箱
					</div>
					<div id="show_5" class="yincang" style="display: none;">
						<div class="formError">
							请再输入邮箱
							<br />
							*符合邮箱的基本规则
						</div>
					</div>
					<input type="text" name="emil" id="emil" placeholder="请输入你的邮箱" class="reg_input" onblur="chufa(this.value,5)"/>
					<div class="clearall"></div>
					<div class="size18 reg_btn login_btn">
						<input type="button" id="btn_send" value="提交"  class="reg_main_input"/>
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
		console.log($('#tel').val());
		//规则验证
		function chufa(val,type){
			if(type==1){
				if(val.length>=4){
					$('#show_1').fadeOut(400);
					$.post('ajaxTel.php',{
						username:val,
						type:2 //表示验证的是手机号
					},function(data){
						if(data==1){
							$('#pl1').fadeIn(400);
						}
						if(data!=1){
							$('#pl1').fadeOut(400);
						}
					})
				}else{
					$('#show_1').fadeIn(400);
				}
			}
			if(type==2){
				if(val.length>=4){
					$('#show_2').fadeOut(400);
				}else{
					$('#show_2').fadeIn(400);
				}
			}
			if(type==3){
				if($('#new_password').val()==$('#password').val()&&val.length>=4){
					$('#show_3').fadeOut(400);
				}else{
					$('#show_3').fadeIn(400);
				}
			}
			if(type==4){
				if($('#qq').val().length>=6){
					$('#show_4').fadeOut(400);
				}else{
					$('#show_4').fadeIn(400);
				}
			}
			if(type==5){ 
				if(/^([0-9A-Za-z\-_\.]+)@([0-9a-z]+\.[a-z]{2,3}(\.[a-z]{2})?)$/g.test($('#emil').val())){
					$('#show_5').fadeOut(400);
				}else{
					$('#show_5').fadeIn(400);
				}
			}
		}
		//点击隐藏掉
		$('.yincang').click(function(){
			$(this).fadeOut(400);
		})
		
		$('#btn_send').click(function(){
			var username=$('#username').val();
			var qq=$('#qq').val();
			var pass=$('#new_password').val();
			var newpass=$('#password').val();
			var emil=$('#emil').val();
			var tel=$('#tel').val();
			if(username<4){
				layer.msg('用户名不正确',{time:1500});
				return false;
			}
			if(newpass<4){
				layer.msg('密码格式不正确',{time:1500});
				return false;
			}
			if(newpass!=pass){
				layer.msg('两次密码不一致',{time:1500});
				return false;
			}
			if(qq<6){
				layer.msg('QQ号不正确',{time:1500});
				return false;
			}
			if(!(/^([0-9A-Za-z\-_\.]+)@([0-9a-z]+\.[a-z]{2,3}(\.[a-z]{2})?)$/g.test($('#emil').val()))){
				layer.msg('邮箱格式不正确',{time:1500});
				return false;
			}
			$.post('ajaxRegister.php',{
				username:username,
				qq:qq,
				pass:pass,
				emil:emil,
				tel:tel
			},function(data){
				console.log(data);
				if(data==1){
					layer.msg('注册成功',{time:2000});
					window.location.href="main.php";
				}else{
					layer.msg('注册失败，稍后再试',{time:2000});
					return false;
				}
			})
		})
	</script>
</html>

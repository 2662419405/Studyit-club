<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	
	?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>IT俱乐部-加入开发</title>
		<link rel="shortcut icon" href="ico/it.ico" />
		<link rel="stylesheet" type="text/css" href="css/index.css"/>
		<script src="js/jquery.js"></script>
		<script src="layer/layer.js"></script>
		<?php include("css/register.html"); ?>
		<?php include("css/main.html"); ?>
		<?php include("css/join_kaifa.html"); ?>
	</head>
	<body style="background-color: #efefef;">
		<?php include("view/header.php"); ?>
		<div id="content">
			<div class="all" style="height: 650px;">
				<div class="reg_main">
					<div style="color: red;">
						<span class="size16">加入开发</span>
						<span class="gray">请根据提示输入下面信息，我们会主动联系你</span>
					</div>
					<div class="clearall"></div>
					<div class="reg_name size18">
						<span class="red">*</span>
						姓名
					</div>
					<div id="show_1" class="yincang" style="display: none;">
						<div class="formError">
							*最少2个字符
						</div>
					</div>
					<input type="text" name="username" id="username" placeholder="设置用户名" class="reg_input" onblur="chufa(this.value,1)"/>
					<div class="clearall"></div>
					<div class="reg_name size18">
						<span class="red">*</span>
						掌握技术
					</div>
					<div id="show_2" class="yincang" style="display: none;">
						<div class="formError">
							请输入主要技术
							<br />
							*最少一门字符
							<br />
							*可以使用, .等方式隔开
						</div>
					</div>
					<input type="text" name="password" id="password" placeholder="请输入你目前掌握的技术" class="reg_input" onblur="chufa(this.value,2)"/>
					<div class="clearall"></div>
					<div class="reg_name size18">
						<span class="red">*</span>
						为何加入
					</div>
					<div id="show_3" class="yincang" style="display: none;">
						<div class="formError">
							请再输入加入理由
							<br />
							*比如擅长的领域
							<br />
							*带来的价值
						</div>
					</div>
					<input type="text" name="new_password" id="new_password" placeholder="请输入你加入我们的理由" class="reg_input" onblur="chufa(this.value,3)"/>
					<div class="clearall"></div>
					<div class="reg_name size18">
						<span class="red">*</span>
						QQ号码
					</div>
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
					<div class="reg_name size18">
						<span class="red">*</span>
						手机
					</div>
					<div id="show_6" class="yincang" style="display: none;">
						<div class="formError">
							*请满足手机基本格式
						</div>
					</div>
					<input type="text" name="tel" id="tel" placeholder="请输入你的手机号码" class="reg_input" onblur="chufa(this.value,6)"/>
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
		//规则验证
		function chufa(val,type){
			if(type==1){
				if(val.length>=2){
					$('#show_1').fadeOut(400);
				}else{
					$('#show_1').fadeIn(400);
				}
			}
			if(type==2){
				if(val.length>=2){
					$('#show_2').fadeOut(400);
				}else{
					$('#show_2').fadeIn(400);
				}
			}
			if(type==3){
				if(val.length>=2){
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
			if(type==6){ 
				if(/^1[34578]\d{9}$/.test($('#tel').val())){
					$('#show_6').fadeOut(400);
				}else{
					$('#show_6').fadeIn(400);
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
			if(username<2){
				layer.msg('用户名过短',{time:1500});
				return false;
			}
			if(newpass<2){
				layer.msg('技术不能为空',{time:1500});
				return false;
			}
			if(pass<2){
				layer.msg('理由不能为空',{time:1500});
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
			if(!(/^1[34578]\d{9}$/.test($('#tel').val()))){
				layer.msg('手机号不正确',{time:1500});
				return false;
			}
			$.post('ajaxJoin.php',{
				name:username,
				qq:qq,
				liyou:pass,
				emil:emil,
				jishu:newpass,
				tel:tel
			},function(data){
				console.log(data);
				if(data==1){
					layer.msg('提交成功',{time:1000},function(){
				            var index = parent.layer.getFrameIndex(window.name);
				            parent.location.reload();
				            parent.layer.close(index); 
				    });
				}else{
					layer.msg('提交失败，请稍后再试',{time:1000});
					return false;
				}
			})
		})
	</script>
</html>

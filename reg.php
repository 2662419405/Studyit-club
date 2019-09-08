<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>IT俱乐部-注册</title>
		<link rel="shortcut icon" href="ico/it.ico" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="css/index.css"/>
		<script src="js/jquery.js"></script>
		<script src="layer/layer.js"></script>
		<?php include("css/reg.html"); ?>
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
			<div id="main">
				<div id="reg">
					<div class="reg_main">
						<div class="am_auto">
							<img src="img/top.png" alt="IT俱乐部" title="IT俱乐部" class="for_i"/>
							<h1 class="hh">欢迎加入IT俱乐部 - 来肝程序!</h1>
							<div class="group">
								<span class="span_tel">
									<i class="am_ico"><img src="img/tel.jpg" class="for_img"/></i>
								</span>
								<input type="text" class="form_tel" placeholder="请输入你的手机号" id="tel_num" onkeyup="checknum(this.value)"/>
								<p class="for_p" id="for_p">此号码已经注册，请选择<a href="mima.php">找回密码</a></p>
							</div>
							<div class="group">
								<p class="for_inpu">这是注册IT俱乐部账号的第一步。首先，你需要提供你的 手机号 。然后，我们社团会给你发一封短信。根据验证手机的验证码继续进行。</p>
							</div>
							<div style="width: 100%; text-align: center;">
								<div style="display: inline-block;">
									<input type="text" placeholder="验证码" class="for100" id="input_yan"/>
									<img src='reg_captcha.php?r=echo rand(); ?>'  class="login_a" id="cap" onclick="document.getElementById('cap').src='reg_captcha.php?r='+Math.random()"/>
								</div>
							</div>
							<div class="btn_for">
								<div class="btn am_btn" id="send_id">
									发送手机验证码
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
		
		var oFor=document.getElementById('for_p');
		oFor.style.display="none";
		var oTel=document.getElementById('tel_num');
		var oSend=document.getElementById('send_id');
		function checknum(val){
			if(!(/^1[3456789]\d{9}$/.test(oTel.value))){
				oTel.style.borderColor='red';
				oTel.style.borderWidth='2px';
				oFor.style.display="none";
		        return false; 
		    }else{
		    	$.post('ajaxTel.php',{
					tel:val,
					type:1 //表示验证的是手机号
				},function(data){
					if(data==1){
						oFor.style.display="block";
					}
					if(data!=1){
						oFor.style.display="none";
					}
				})
		    	oTel.style.borderColor='#ccc';
				oTel.style.borderWidth='1px';
		    }
		}
		
		$("#send_id").click(function(){
			
			if(oSend.innerHTML=="正在签订生死契约"){
				return false;
			}
			
			var te=$("#tel_num").val();
			if(!(/^1[3456789]\d{9}$/.test($("#tel_num").val()))){
				layer.msg('手机号码不正确',{time:1000});
				return false;
			}
			var yanzheng=$('#input_yan').val();
			$.post('ajaxCheckYan.php',{
				yan:yanzheng,
				tel:te
			},function(data){
				if(data==-1){
					layer.msg('验证码不正确',{time:1000});
					document.getElementById('cap').src='reg_captcha.php?r='+Math.random();
					return false;
				}
				else if(data==1){
					oSend.innerHTML="正在签订生死契约";
					oSend.style.backgroundColor='#CCCCCC';
					var pid=$('#tel_num').val();
			        //iframe层
			        layer.open({
			            type: 2,                            //弹出框
			            title: '验证码',                   //标题
			            area:['350px','250px'],             //弹层宽高
			            shade: 0.5,                         //背景透明度
			            content: 'getCheckYan.php?pid='+pid+'&type='+1, //iframe的url
			           	end:function(){
			           		oSend.innerHTML="发送手机验证码";
							oSend.style.backgroundColor='#dd514c';
			           	}
			        });
				}
			})
		})
		
	</script>
</html>

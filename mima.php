<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>IT俱乐部-找回密码</title>
		<link rel="shortcut icon" href="ico/it.ico" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
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
								<p>只需要提供你的注册手机号，IT俱乐部就会向你的手机发送一个验证码，根据提示进行下一步操作。</p>
								<p><b>
									注意：本网站目前只开放手机才能找回密码，请牢记你的密码。
								</b></p>
							</div>
							<div class="group">
								<span class="span_tel">
									<i class="am_ico"><img src="img/tel.jpg" class="for_img"/></i>
								</span>
								<input type="text" class="form_tel" placeholder="请输入你的手机号" id="tel_num"/>
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
		
		var oTel=document.getElementById('tel_num');
		var oSend=document.getElementById('send_id');
		
		$("#send_id").click(function(){
			
			if(oSend.innerHTML=="正在签订生死契约"){
				return false;
			}
			
			var te=$("#tel_num").val();
			if(!(/^1[34578]\d{9}$/.test($("#tel_num").val()))){
				layer.msg('手机号码不正确',{time:1000});
				return false;
			}
			$.post('ajaxCheckFindMiMa.php',{
				tel:te
			},function(data){
				console.log(data);
				if(data==-1){
					layer.msg('用户名或密码不存在',{time:1000});
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
			            content: 'getCheckYan.php?pid='+pid+'&type='+2, //iframe的url
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

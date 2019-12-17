<?php
	//免登陆
	session_start();
	require('library/Db.class.php');
	$db = new Db();
	if(isset($_COOKIE['password'])&&isset($_COOKIE['username'])){
		echo "1";
		$sql  = "select * from user where username = :username";
		$user=$db->row($sql,array('username'=>$_COOKIE['username']));
		$_SESSION['user'] = $user;
		echo "<script>window.location.href='main.php'</script>";
	}
	?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>IT俱乐部-首页</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="ico/it.ico" />
		<link rel="stylesheet" type="text/css" href="css/index.css"/>
		<script src="js/jquery.js"></script>
		<script src="layer/layer.js"></script>
		<script src="js/Move.js" type="text/javascript" charset="utf-8"></script>
		<script>
			window.onload = function() {
				toHead();
				toChecking();
			}

			function toList() {
				var oList = id("list");
				var oBtn = id("btn");
				var aLi = oList.getElementsByTagName("li");
				var aText = getClass('text', oList);
				var oA=id("captcha_img");
				var user = id("username");
				var pass = id("password");
				var chu=0;
				var aStyle = [{
						height: 26,
						width: 246,
						paddingBottom: 5,
						paddingTop: 5,
						paddingLeft: 50,
						paddingRight: 50
					},
					{
						height: 26,
						width: 246,
						paddingBottom: 5,
						paddingTop: 5,
						paddingLeft: 50,
						paddingRight: 50
					},
					{
						height: 26,
						width: 100,
						paddingBottom: 5,
						paddingTop: 5,
						paddingLeft: 50,
						paddingRight: 50
					}
				];
				var i = 0;
				for(i = 0; i < aLi.length; i++) {
					aLi[i].style.zIndex = aLi.length - i;
				}
				starMove(oList, {
					top: 194
				}, 1, function() {
					starMove(aText[0], aStyle[0], 1);
					starMove(aLi[2], {
						top: 85
					}, 1);
					starMove(aLi[1], {
						top: 85
					}, 1, function() {
						starMove(aText[1], aStyle[1], 1);
						starMove(aLi[2], {
							top: 170
						}, 1, function() {
							starMove(aText[2], aStyle[2], 1, function() {
								starMove(oBtn, {
									top: 0
								}, 1);
							});
							var Timeerr=setInterval(function(){
								chu=chu+0.1;
								if(chu>=1){
									clearInterval(Timeerr);
								}
								oA.style.opacity=chu;
							},150);
						});
					});
				});
			}

			function toSubmit() {
				var user = id("username");
				var pass = id("password");
				var yan=id("yan");
				if(yan.value.length<4){
					return false;
				}
				var momery;
				if($("input[type='checkbox']").is(':checked')){
					momery=1;
				}else{
					momery=0;
				}
				$.post('ajaxCheckLogin.php',{
					username: user.value,
					password: pass.value,
					authcode: yan.value,
					memory:momery
				},function(data){
					console.log(data);
					if(data == -2){
						layer.msg('验证码错误',{time:2000});
						document.getElementById('captcha_img').src='captcha.php?r='+Math.random();
						return false;
					}
					if(data == -1) {
						layer.msg('账号或密码错误',{time:2000});
						return false;
					}
					if(data == 1) {
						window.location.href='main.php';
					}
				});
			}

			function toChecking() {
				var oList = id("list");
				var oBtn = id("btn");
				var aText = getClass('text', oList);
				var i = 0;
				aText[aText.length - 1].onpropertychange = function() {
					if(this.value.length > 3) {
						oBtn.innerHTML = "提交";
						oBtn.style.lineHeight = "50px";
						oBtn.onclick = toSubmit;
					}
				};
				aText[aText.length - 1].oninput = function() {
					if(this.value.length > 3) {
						oBtn.innerHTML = "提交";
						oBtn.style.lineHeight = "50px";
						oBtn.onclick = toSubmit;
					}
				};
				for(i = 0; i < aText.length; i++) {
					aText[i].value = "";
					aText[i].index = i;
					aText[i].disabled = false;
					aText[i].onfocus = function() {
						for(i = 0; i <= this.index; i++) {
							if(aText[i].value == "") {
								var iTop = css(aText[i], 'height') + 30 + css(aText[i].parentNode, 'top') - 56;
								starMove(oBtn, {
									top: iTop
								}, 1, function() {
									aText[i].focus();
								});
								return;
							}
						}
					}
					aText[i].onblur = function() {
						for(i = 0; i < aText.length; i++) {
							if(aText[i].value == "") {
								var iTop = css(aText[i], 'height') + 30 + css(aText[i].parentNode, 'top') - 56;
								starMove(oBtn, {
									top: iTop
								}, 0, function() {
									aText[i].focus();
								});
								return;
							}
						}
						if(this.index == aText.length - 1) {
							oBtn.innerHTML = "提交";
							oBtn.style.lineHeight = "50px";
							oBtn.onclick = toSubmit;
						}
					}
				}
			}

			function toHead() {
				var oHead = id("head");
				var oUrl = oHead.children[1];
				var oTitle = oHead.children[0]
				var aTitle = oTitle.innerHTML.split("");
				var iNow = 0;
				var oTimer = null;
				var i = 0;
				for(i = 0; i < aTitle.length; i++) {
					aTitle[i] = "<span>" + aTitle[i] + "</span>";
				}
				oTitle.innerHTML = aTitle.join("");
				aTitle = oTitle.children;
				for(i = 0; i < aTitle.length; i++) {
					aTitle[i].style.left = aTitle[i].offsetLeft + "px";
					aTitle[i].style.top = aTitle[i].offsetTop + "px";
				}
				for(i = 0; i < aTitle.length; i++) {
					aTitle[i].style.position = "absolute";
				}
				oTimer = setInterval(
					function() {
						if(iNow == aTitle.length) {
							clearInterval(oTimer);
							starMove(oUrl, {
								left: 0,
								opacity: 100
							}, 0, function() {
								toList();
							});
						} else {
							starMove(aTitle[iNow], {
								top: 200
							}, 1);
							iNow++;
						}
					},
					50);
			}
		</script>
		<?php include("css/index.html"); ?>
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
					<h1>登录</h1>
				</div>
			</div>
			<div id="main" style="height: 500px;">
				<div class="wrap">
					<div class="forin">
						<img src="img/wubiaoti.png" class="img1"/>
					</div>
				<h2 id="head">
					<strong class="title">欢迎来到——IT俱乐部</strong>
					<span class="url">www.studyit.club</span>
				</h2>
				<div id="list">
					<ul>
						<li>
							<h4 class="listLeft" style="font-size: 16px; ">账号</h4>
							<input type="text" value="" class="text" name="username" disabled="disabled" placeholder="用户名或邮箱" id="username" />
						</li>
						<li>
							<h4 class="listLeft" style="font-size: 16px; ">密码</h4>
							<input type="password" value="" class="text" name="password" disabled="disabled" placeholder="密码" id="password" />
						</li>
						<li>
							<h4 class="listLeft" style="font-size: 15px;">验证码</h4>
							<input type="text" value="" class="text" name="yan" disabled="disabled" placeholder="验证码" id="yan" onKeyPress="if(event.keyCode==13) {toSubmit();}"/>
							<a class="login_A" href="javascript:;" onclick="document.getElementById('captcha_img').src='captcha.php?r='+Math.random()"  ><img src='captcha.php?r=echo rand(); ?>'  class="login_a" id="captcha_img"/></a>
						</li>
					</ul>
					<a href="javascript:;" id="btn">亲，请<br />先写这里</a>
				</div>
			<span class="wang2">
				<input class="inpu_remember" type="checkbox" name="remember"  id="inpu" <?php if(isset($_COOKIE['memory'])==1)echo "checked";?>><label for="inpu">记住本次登录的信息</label>
			</span>
			<span class="wang">
				<a href="mima.php">忘记密码?</a>
			</span>
			<span class="wang1">
				<a href="reg.php">注册</a>
			</span>
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
</html>

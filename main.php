<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	setcookie("chess_name", $_SESSION['user']['username']); 
	
	?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<?php include("css/main.html"); ?>
		<?php include("view/head.php"); ?>
		<?php include("css/footer.html"); ?>
		<title>首页</title>
	</head>
	<body>
		
		<!--
        	作者：2662419405@qq.com
        	时间：2019-05-28
        	描述：切换账号
        -->
		<div id="messageBoardContainer">
			<div id="messageBoard">
				<div class="wrap">
					<h2>
						<span>社团官网公告栏</span>
						<a href="javascript:if(g_fnQuirkyPopupClose){g_fnQuirkyPopupClose()};" title="关闭"></a>
					</h2>
					<div class="content">
						<p class="indent"><span>IT俱乐部创建于2016年12月，经过2019年<a href="join_kaifa.php" style="color:red;">IT俱乐部全体人员</a>数个月的开发，IT俱乐部已经正式完工，很开心和大家一起学习技术^_^！</span></p>
						<p class="indent"><span>欢迎来到IT俱乐部 ,如果同学有更好的建议或者想要一起加入开发者团队的话，可以联系我们:<strong><a href="join_kaifa.php" style="color:#666;">电话</a>、<a href="join_kaifa.php" style="color:#666;">QQ</a>、<a href="join_kaifa.php" style="color:#666;">微信</a>、<a href="join_kaifa.php" style="color:#666;">在线论坛</a></strong> 我们会虚心接受大家的意见，越做越好，并备好果汁或可乐热情款待各位朋友的到来^_^！</span></p>
						<p class="date"><span>IT俱乐部2019年5月28日</span></p>
					</div>
				</div>
				<div class="bg"></div>
			</div>
		</div>
		<a href="javascript:;" id="quirkyPopupShowBtn" style="display:none;" style="z-index: 100;"></a>
		<?php include("view/header.php"); ?>
		<div class="navPusher">
			<div class="hero">
				<div class="hero__container">
					<h1>IT俱乐部开始纳新了。</h1>
					<p>现在就开始正式走进编程世界吧!</p>
					<div class="hero__announcement">
						<span><strong>IT Club正式纳新!</strong>更多信息请查看我们的<a href="chat.php">论坛</a>和<a href="news.php">新闻</a>以了解更多详情</span>
					</div>
					<div class="hero-repl hero-repl--visible">
						<div class="hero-repl__editor">
							<div class="hero-repl__pane hero-repl__pane--left main_left">
								<h3>代码初体验，C语言入门语句</h3>
								<div id="hero-repl-in" class="hero-repl__code ace_editor ace-tomorrow-night ace_dark" style="font-size: 1rem;">
									<div class="ace_scroller" style="left: 0px; right: 0px; bottom: 0px;">
										<div class="ace_content" style="margin-top: 24px; width: 408px; height: 178px; margin-left: 0px; padding: 0px 24px;" id="zhuijiaContent">
											<!--
                                            	作者：2662419405@qq.com
                                            	时间：2019-06-01
                                            	描述：读入语句
                                            -->
										</div>
									</div>
								</div>
							</div>
							<div class="hero-repl__pane hero-repl__pane--right main_right">
								<h3>在这里进行语句的输出</h3>
								<div id="hero-repl-out" class="hero-repl__code ace_editor ace-tomorrow-night ace_dark" style="font-size: 1rem;">
									<div class="ace_scroller" style="left: 0px; right: 0px; bottom: 0px;">
										<div class="ace_content" style="margin-top: 24px; width: 408px; height: 178px; margin-left: 0px; padding: 0px 24px;" id="xianshiContent">
											<!--
                                            	作者：2662419405@qq.com
                                            	时间：2019-06-01
                                            	描述：输出语句
                                            -->
                                            <div id="cang_content" style="display: none;">
                                            	<div class='wenben' style='height:20px'>Welcome To IT Club
                                            	</div>
                                            	<div class='wenben' style='height:20px'>We are family!</div>
                                            	<div class='wenben' style='height:20px'>Hello World</div>
                                            </div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="clearall"></div>
					<h3>IT club</h3>
					<div class="sponsors-tier" style="margin:10px 0;">
						<a href="chat.php" title="论坛中心">
							<div class="own">
								Our own forum
							</div>
							<div style="color:#b7b8b7">Welcome to discuss and study together.</div>
						</a>
					</div>
				</div>
			</div>
			<div class="mainContainer">
				<div class="container" style="background-color:#f6f6f6;padding-bottom:20px">
					<div class="wrapper">
						<div class="gridBlock">
							<div class="blockElement twoByGridBlock get-started">
								<h3>欢迎来到IT俱乐部!</h3>
								<p>这个是我们社团的一个简介，大家可以随便浏览一下，查看游戏，空间以及论坛等</p>
								<p>我们只是一个很小的开发团队， 在业余时间维护这个项目。如果 ITClub 让你感觉对计算机产生了渴望， 让你对程序产生了不一样的思想，那么你的<a href="chat.php">一个赞扬的帖子</a>或者是，<a href="join_kaifa.php">申请</a>称为我们开发者团队的一员，是对我们最大的肯定，也是对我们最大的鼓励！</p>
								<div class="section promoSection">
									<div class="promoRow">
										<div class="pluginRowBlock">
											<div class="pluginWrapper buttonWrapper">
												<a href="join_kaifa.php" class="button">加入开发</a>
											</div>
											<div class="pluginWrapper buttonWrapper">
												<a href="setting.php" class="button">补全信息(个人)</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="container paddingBottom">
					<div class="wrapper productShowcaseSection">
						<div class="sponsor-tiers" id="sponsors">
							<h3>活动信息分析</h3>
							<ul class="active_ul">
								<li>
									<img src="img/save1.jpg" alt="注册人数">
									<span class="span_active1" style="font-size:30px;margin:10px 0;font-weight:500;">0</span>
									<span>注册人数</span>
								</li>
								<li>
									<img src="img/save2.jpg" alt="学员人数">
									<span class="span_active2" style="font-size:30px;margin:10px 0;font-weight:500;">0</span>
									<span>学员人数</span>
								</li>
								<li>
									<img src="img/save3.jpg" alt="网站浏览人数">
									<span class="span_active3" style="font-size:30px;margin:10px 0;font-weight:500;">0</span>
									<span>网站浏览人数</span>
								</li>
								<li>
									<img src="img/save4.jpg" alt="登录人数">
									<span class="span_active4" style="font-size:30px;margin:10px 0;font-weight:500;">0</span>
									<span>登录人数</span>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="wrapper case">
				<div class="section">
					<div class="headline">
						<p class='title'>主要教学内容</p>
					</div>
					<div class="case-wrapper cf" id="case">
						<div class="case-card" style="background: url(img/home_img1.jpg) no-repeat center center;background-size: cover;">
							<div class="logo">
								算法分析C++
							</div>
							<p class="title">算法是所有语言的核心关键</p>
							<p class="detail">算法（Algorithm）是指解题方案的准确而完整的描述，是一系列解决问题的清晰指令，算法代表着用系统的方法描述解决问题的策略机制。也就是说，能够对一定规范的输入，在有限时间内获得所要求的输出。如果一个算法有缺陷，或不适合于某个问题，执行这个算法将不会解决这个问题。</p>
						</div>
						<div class="case-card" style="background: url(img/home_img2.jpg) no-repeat center center;background-size: cover;">
							<div class="logo">
								前段基础
							</div>
							<p class="title">基本的静态页面开发</p>
							<p class="detail">前端开发工程师是Web前端开发工程师的简称。Web前端开发技术是一个先易后难的过程，主要包括三个要素：HTML（标准通用标记语言下的一个应用）、级联样式表和JavaScript。</p>
						</div>
						<div class="case-card" style="background: url(img/home_img4.jpg) no-repeat center center;background-size: cover;">
							<div class="logo">
								JAVA分析
							</div>
							<p class="title">目前最主流的语言</p>
							<p class="detail">ava是一门面向对象编程语言，不仅吸收了C++语言的各种优点，还摒弃了C++里难以理解的多继承、指针等概念，因此Java语言具有功能强大和简单易用两个特征。Java语言作为静态面向对象编程语言的代表，极好地实现了面向对象理论，允许程序员以优雅的思维方式进行复杂的编程。</p>
						</div>
						<div class="case-card" style="background: url(img/home_img1.jpg) no-repeat center center;background-size: cover;">
							<div class="logo">
								人工智能
							</div>
							<p class="title">最近一直是热门的语言</p>
							<p class="detail">说到人工智能就要说起python，Python 是一种解释型语言： 这意味着开发过程中没有了编译这个环节。类似于PHP和Perl语言。Python 是交互式语言： 这意味着，您可以在一个 Python 提示符 >>> 后直接执行代码。Python 是面向对象语言: 这意味着Python支持面向对象的风格或代码封装在对象的编程技术。</p></div>
					</div>
				</div>
			</div>
		</div>
		<?php include("view/right.php"); ?>
		<?php include("view/footer.php"); ?>
	</body>
	<script src="js/main_content.js"></script>
	<script>
		
	tanWindow();

	function magic_number(value,type) { 
		var num = $(".span_active"+type); 
		num.animate({count: value}, { 
			duration: 5000, 
			step: function() { 
			num.text(String(parseInt(this.count))); 
			} 
		}); 
	};
	$(window).scroll(function(){
	    if ($(window).scrollTop() + $(window).height() >= $('.span_active1').offset().top) {
			console.log(1)
			magic_number(32,1);
			magic_number(97,2);
			magic_number(1762,3);
			magic_number(162,4);	
		}
	});
		
	function tanWindow() {

		//弹窗效果
		var oDiv = document.getElementById('messageBoardContainer');
		var oDivContent = oDiv.getElementsByTagName('div')[0];
		var oText = oDiv.getElementsByTagName('div')[2];
		var aSpan = oText.getElementsByTagName('span');
		var oCloseBtn = oDiv.getElementsByTagName('a')[0];
		var oBtnShow = document.getElementById('quirkyPopupShowBtn');

		var w = 354;
		var h = 294;

		var i = 0;

		var t = document.body.scrollTop || document.documentElement.scrollTop;

		oDiv.style.left = (document.documentElement.clientWidth - w) / 2 + 'px';
		oDiv.style.top = t + (document.documentElement.clientHeight) / 2 + 'px';

		for(i = 0; i < aSpan.length; i++) {
			aSpan[i].onmousedown = function(ev) {
				var oEvent = window.event || ev;

				if(oEvent.stopPropagation) {
					oEvent.stopPropagation();
				} else {
					oEvent.cancelBubble = true;
				}
			};
		}

		var oQP = new MiaovQuirkyPopup(
			oDiv, oDiv, oBtnShow, oCloseBtn, {
				x: w,
				y: h
			},
			function() //getPos
			{
				return {
					x: oDiv.offsetLeft,
					y: oDiv.offsetTop
				};
			},
			function() //getSize
			{
				return {
					x: oDiv.offsetWidth,
					y: oDiv.offsetHeight
				};
			},
			function(x, y) //doMove
			{
				oDiv.style.left = x + 'px';
				oDiv.style.top = y + 'px';
			},
			function(x, y) //doResize
			{
				oDivContent.style.top = (y - h) / 2 + 'px';
				oDivContent.style.left = (x - w) / 2 + 'px';

				oDiv.style.width = x + 'px';
				oDiv.style.height = y + 'px';
			}
		);

		setTimeout
			(
				function() {
					oQP.initShow();
				}, 1000
			);
	}
	</script>
</html>

<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	session_start();
	$db = new Db();	
?>
<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8" />
	<title>社团纳新新闻</title>
	<?php include("css/main.html"); ?>
	<?php include("view/head.php"); ?>
	<?php include("css/footer.html"); ?>
	<?php include("css/news_index.html"); ?>
</head>
<body>
	<?php include("view/header.php"); ?>
  <div id="zxc" align = "center">

    <video width="750" height="450" autoplay="autoplay" controls="controls" id="vie1">
		<source src="mp4/output.mp4" type="video/mp4">
		您的浏览器不支持此种视频格式。
	</video>

    </video>
    <div id="news_content">
    	<h2>社团新闻</h2>
    	<div class="content">
    		<p class="indent"><span>IT俱乐部创建于2016年12月，经过2019年<a href="join_kaifa.php" style="color:red;">IT俱乐部全体人员</a>数个月的开发，IT俱乐部已经正式完工，很开心和大家一起学习技术^_^！</span></p>
			<p class="indent"><span>欢迎来到IT俱乐部 ,如果同学有更好的建议或者想要一起加入开发者团队的话，可以联系我们:<strong><a href="join_kaifa.php" style="color:#666;">电话</a>、<a href="join_kaifa.php" style="color:#666;">QQ</a>、<a href="join_kaifa.php" style="color:#666;">微信</a>、<a href="join_kaifa.php" style="color:#666;">在线论坛</a></strong> 我们会虚心接受大家的意见，越做越好，并备好果汁或可乐热情款待各位朋友的到来^_^！</span></p>
			<p class="date"><span>IT俱乐部2019年5月28日</span></p>
    	</div>
    </div>
    <div class="clearall"></div>

  </div>
          
  <div class="main-product">
    <div class="layui-container">
      <p class="title">专为全栈人才而学习的<span>俱乐部</span></p>
      <div class="layui-row layui-col-space25">
        <div class="layui-col-sm6 layui-col-md3">
          <div class="content">
            <div><img src="img/Big_icon1.png"></div>
            <div>
              <p class="label">JS</p>
              <p>使网页增加互动性，并且能及时响应用户的操作，对提交表单做即时的检查。</p>
            </div>
            <a href="javascript:;">想学，我们教你 ></a>
          </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3 ">
          <div class="content">
            <div><img src="img/Big_icon2.png"></div>
            <div>
              <p class="label">CSS</p>
              <p>可以有效地对页面的布局、字体、颜色、背景和其它效果实现更加精确的控制。</p>
            </div>
            <a href="javascript:;">想学，我们教你 ></a>
          </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3 ">
          <div class="content">
            <div><img src="img/Big_icon3.png"></div>
            <div>
              <p class="label">PHP</p>
              <p>作为内嵌式语言，让网页开发人员快速的写出动态的网页。</p>
            </div>
            <a href="javascript:;">想学，我们教你 ></a>
          </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3 ">
          <div class="content">
            <div><img src="img/Big_icon4.png"></div>
            <div>
              <p class="label">mySql</p>
              <p>利用数据库的增删改查等方面的操控，应用于数据库编程或数据库数据的维护。</p>
            </div>
            <a href="javascript:;">想学，我们教你 ></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="main-service">
    <div class="layui-container">
      <p class="title">为同学创造完美的<span>专业服务和学习环境</span></p>
      <div class="layui-row layui-col-space25 layui-col-space80">
        <div class="layui-col-sm6">
          <div class="content">
            <div class="content-left"><img src="img/avatar.jpg"></div>
            <div class="content-right">
              <p class="label">甄大棚(网络科技部副部长)</p>
              <span></span>
              <p>精通原生JavaScript，拥有极强的代码逻辑，擅长优化复杂逻辑的JavaScript项目代码。熟练运用多种前端框架，在Vue.js、React.js上颇有建树。</p>
            </div>
          </div>
        </div>
        <div class="layui-col-sm6">
          <div class="content">
            <div class="content-left"><img src="img/avatar.jpg"></div>
            <div class="content-right">
              <p class="label">贾代超(副社长)</p>
              <span></span>
              <p>熟练运用并深入理解CSS3、HTML5，擅长前端页面复杂动态效果的实现与优化。</p>
            </div>
          </div>
        </div>
        <div class="layui-col-sm6">
          <div class="content">
            <div class="content-left"><img src="img/avatar.jpg"></div>
            <div class="content-right">
              <p class="label">贾鸿儒(网络科技部部长)</p>
              <span></span>
              <p>熟练掌握Java、C#等命令式编程语言。</p>
            </div>
          </div>
        </div>
        <div class="layui-col-sm6">
          <div class="content">
            <div class="content-left"><img src="img/avatar.jpg"></div>
            <div class="content-right">
              <p class="label">李盛喆(社长)</p>
              <span></span>
             <p>熟练硬件设为，U盘制作，c#等编程。</p>
            </div>
          </div>
        </div>
      </div>
      <div class="service-more"><a href="">查看更多优秀成员</a></div>
      <div class="service-more"><a href="">每周三晚7:00,社团活动日,巩固，提升，拔高!</a></div>
    </div>
  </div>
<?php include("view/right.php"); ?>
<?php include("view/footer.php"); ?>
</body>
</html>
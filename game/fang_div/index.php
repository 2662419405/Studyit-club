<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
  			<title>俄罗斯方块</title>
    		<link rel="stylesheet" href="../../css/style.css" media="screen" type="text/css" />
    		<link rel="shortcut icon" href="../../ico/it.ico" />
    		<?php include("../../css/fang_div.html"); ?>
	</head>
	<body>
		<div style="float: left; margin-left: 100px;">
			<p style="color:red;font-size:18px;font-weight:bold;width: 200px;">页面并没有那么美化，还请见谅，如果游戏死亡，请刷新页面进行重新开始,不是很完善</p>
			<br />
			<br />
			<br />
			<p  style="color:red;font-size:18px;font-weight:bold;width: 200px;">操作:
				<br />
				小键盘进行操作
				<br />
				PgUp:&nbsp;&nbsp;变形<br />
				PgRi:&nbsp;&nbsp;右<br />
				PgLe:&nbsp;&nbsp;左<br />
				PgDn:&nbsp;&nbsp;加速<br />
			</p>
		</div>  
		<div style="float: right;  margin-right: 100px;">
			<p style="color:red;font-size:18px;font-weight:bold;width: 200px;">技术点:单机类型的网页小游戏，并不需要对数据进行操作，所以只做起来比较简单，主要使用html中的canvas画布，配合js进行开发，可以理解为，通过一个画笔，绘画出一堆个界面，然后固定的时间内以此执行</p>
		</div>  
    <div id="tetris">
        <div id="info">
            <div id="next_shape">asdfasdf</div>
            <p id="level">等级: <span></span></p>
            <p id="lines">消除: <span></span></p>
            <p id="score">分数: <span></span></p>
            <p id="time">时间: <span></span></p>
        </div>
        <div id="canvas"></div>
    </div>
		<div style="text-align:center;clear:both;">
</div>
	</body>
</html>

  <script src="../../js/div_index.js"></script>

</body>

</html>
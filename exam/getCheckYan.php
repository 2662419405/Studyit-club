<?php
	session_start();
	$pid = $_GET['pid'];
	$type=$_GET['type'];
?>
<html>
	<head>
		<style type="text/css">
			p{
				text-align: center;
				color: #999;
				margin: 0 0 30px 0;
			}
			.kuai{
				width: 240px;
				margin: 0 auto;
			}
			#put1{
				float: left;
				padding: 10px 15px;
				width: 120px;
			}
			#btn_yan{
				float: right;
				border-radius:5px;
				border: none;
				padding: 10px 15px;
				cursor: pointer;
			}
			#sendyan{
				border-radius: 5px;
				padding: .5em 2.5em;
				font-size: 1em;
				background-color: #dd514c;
				border-color: #dd514c;
				transition: background-color 300ms ease-out, border-color 300ms ease-out;
				cursor: pointer;
				outline: 0;
				text-align: center;
				font-weight: 600;
				line-height: 1.2;
				color: #fff;
				float: left;
				position: relative;
				top: 30px;
    			margin-left: 55px;
			}
			#sendyan:hover {
				background-color: #c9322c;
				border-color: #c9322c;
			}
		</style>
		<script src="js/jquery.js"></script>
		<script src="layer/layer.js"></script>
	</head>
	<body>
		<p>短信验证码已发送至+86<?php echo $pid?></p>
		<div class="kuai">
			<input type="text" placeholder="验证码" id="put1"/>
			<input type="button" value="重新发送" id="btn_yan"/>
			<input type="button" name="sendyan" id="sendyan" value="提交" />
		</div>
	</body>
	<script>
		var shou=<?php echo "'".$pid."'";?>;
		var type=<?php echo $type;?>;
		$('#sendyan').click(function(){
			var tel=$('#put1').val();
			$.post('ajaxCode.php',{
				telement:tel
			},function(data){
				if(data==1){
					if(type==1){
						<?php $_SESSION['success']="kai";?>
            			window.parent.location.href="register.php?tel="+shou;
					}
					if(type==2){
						<?php $_SESSION['zhaohui']="kai";?>
						window.parent.location.href="FindMiMa.php?tel="+shou;
					}
				}else{
					layer.msg('验证码错误',{time:1000});
				}
			})
		})
		
		function start(){
			var time=60;
			var Timer=setInterval(function(){
				time--;
				if(time<=0){
					btn_yan.value="重新发送";
					clearInterval(Timer);
				}else{
					btn_yan.value=time+"后重发";
				}
			},1000)
		}
		start();
		
		$('#btn_yan').click(function(){
			if(this.value=="重新发送"){
				start();
				return false;
			}else{
				$.post('ajaxCheckYan.php',{
					yan:1,
					tel:shou
				},function(data){
					if(data==1){
						layer.msg('再次发送成功',{time:1000});
					}
				});
			}
		})
		
	</script>
</html>
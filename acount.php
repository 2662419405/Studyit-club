<?php
	
?>
<html>
	<head>
		<style type="text/css">
			.btn {
			    max-width: 220px;
			    width: 100%;
			    margin-top: 10px;
			    color: #fff;
			    background-color: #dd514c;
			    border-color: #dd514c;
			    margin-bottom: 0;
			    padding: .5em 1em;
			    display: inline-block;
			    font-size: 1.2rem;
			    font-weight: 400;
			    line-height: 1.2;
			    text-align: center;
			    white-space: nowrap;
			    background-image: none;
			    vertical-align: middle;
			    border: 1px solid transparent;
			    cursor: pointer;
			    outline: 0;
			    transition: background-color 300ms ease-out, border-color 300ms ease-out;
			    border-radius: 5px;
			}
			.btn:hover {
				background-color: #c9322c;
				border-color: #c9322c;
			}
			body {
			    line-height: 1.6;
			    font-weight: 400;
			    color: #333;
			    font-size: 1rem;
			}
			.am_ico {
			    width: 18px;
			    display: inline-block;
			    margin-top: 8px;
			}
			
			#btn{
				margin: 0 auto;	
				width: 93%;
			}
			
			.group {
			    margin: 17px;
			    position: relative;
			    display: table;
			    border-collapse: separate;
			    box-sizing: border-box;
			}

			img {
			    border-style: none;
			    vertical-align: middle;
			    text-align: center;
			}
			.form_tel {
			    vertical-align: middle;
			    display: table-cell;
			    padding: 6px;
			    font-size: 1rem;
			    line-height: 1.2;
			    color: #555!important;
			    background-color: #fff;
			    background-image: none;
			    border: 1px solid #ccc;
			    border-radius: 0;
			    height: 40px;
    			width: 250px;
			    border-bottom-left-radius: 0;
			    border-top-left-radius: 0;
			}
			.for_img {
			    width: 20px;
			    font-size: 1.6rem;
			    font-weight: 400;
			    line-height: 36px;
			    color: #555;
			    text-align: center;
			}
			.span_tel {
			    height: 38px;
			    float: left;
			    padding: 0 0.7em;
			    font-size: 1.6rem;
			    font-weight: 400;
			    line-height: 36px;
			    color: #555;
			    text-align: center;
			    background-color: #eee;
			    border: 1px solid #ccc;
			    border-radius: 0;
			}
			.btn_for {
			    text-align: center!important;
			}
		</style>
		<script src="js/jquery.js"></script>
		<script src="layer/layer.js"></script>
	</head>
	<body>
		
		<div id="btn">
			<div class="group">
				<span class="span_tel">
					<i class="am_ico">
						<img src="img/name.jpg" class="for_img"/>
					</i>
				</span>
				<input type="text" name="username" id="username" placeholder="请输入你的账户名" value="" class="form_tel"/>
			</div>
			<div class="group">
				<span class="span_tel">
					<i class="am_ico">
						<img src="img/mima.jpg" class="for_img"/>
					</i>
				</span>
				<input type="password" name="password" id="password" placeholder="请输入你的密码" value="" class="form_tel"/>
			</div>
			<div class="btn_for">
				<div class="btn am_btn" id="send_account">
					开始进行登录
				</div>
			</div>
		</div>
		<script>
			$('#send_account').click(function(){
				var username = $('#username').val();
				var password = $('#password').val();
				$.post('ajaxAcount.php',{
					username:username,
					password:password
				},function(data){
					if(data==1){
						window.parent.location.reload();
					}else{
						layer.msg("账号或密码错误",{time:1500});
					}
				})
			})
		</script>
	</body>
</html>
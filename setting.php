<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	session_start();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	
	?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>个人设置</title>
		<?php include("css/main.html"); ?>
		<?php include("view/head.php"); ?>
		<?php include("css/footer.html"); ?>
		<?php include("css/setting.html"); ?>	
		<style type="text/css">
			body{
				background: #fff;
			}		
		</style>
	</head>
	<body>
		<?php include("view/header.php"); ?>
		<div class="main_setting">
			<div class="my_head" style="background: url(img/my_bg.png) center center no-repeat;">
				<img src="<?php if($user['avatar']==null){echo "img/avatar.jpg";}else{echo "images/".$user['avatar'];}?>" class="touxiang" value="<?php echo $user['avatar'] ?>">
				<p class="p1"><?php echo $user['username']?></p>
				<p class="p2"><marquee behavior="scroll" direction="left">我的努力求学没有得到别的好处，只不过是愈来愈发觉自己的无知！</marquee></p>
				<span>注册于<?php echo date('Y-m-d',$user['addtime']) ?></span>
			</div>
			<div id="wp" class="wp">
				<div id="pt" class="cl">
					<div class="z">
						<a href="main.php" title="首页" class="nvhm"></a>
						<em>></em>
						<a onclick="window.location.reload()">设置</a>
						<em>></em>
						<span>头像设置</span>
					</div>
				</div>
				<div class="cl wp ct2_a ww" id="ct">
					<div class="mn bian">
						<div class="bm bw0" id="setting_index">
							<div>
								<h1 class="mt">修改头像</h1>
								<div style="height: 400px">
					                <div id="altContent">
					                </div>
					            </div>
							</div>
							<div>
								<ul class="tb cl" id="ul_click">
									<li class="a">
										<span>基本资料</span>
									</li>
									<li>
										<span>个人信息</span>
									</li>
									<div class="clearall"></div>
								</ul>
								<div id="ul_click_content">
									<div>
										<table class="tfm" id="profilelist" cellspacing="0" cellpadding="0">
											<tr>
												<th>用户名</th>
												<td><?php echo $_SESSION['user']['username'];?></td>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<th>真实姓名</th>
												<td>
													<input type="text" name="tr_realname" id="tr_realname" value="<?php echo $user['true_name'];?>" class="px"/>
												</td>
												<td class="p">
													<select name="realname">
														<option value="0">公开</option>
														<option value="1">好友</option>
														<option value="2">保密</option>
													</select>
												</td>
											</tr>
											<tr>
												<th>性别</th>
												<td>
													<select name="tr_gender" id="tr_gender" class="ps" >
														<option value="0">保密</option>
														<option value="1">男</option>
														<option value="2">女</option>
													</select>
												</td>
												<td class="p">
													<select name="gender">
														<option value="0">公开</option>
														<option value="1">好友</option>
														<option value="2">保密</option>
													</select>
												</td>
											</tr>
											<tr>
												<th>生日</th>
												<td>
													<input type="date" id="tr_birthday"  class="px" value="<?php echo $user['bir'];?>"/>
												</td>
												<td class="p">	
													<select name="birthday">
														<option value="0">公开</option>
														<option value="1">好友</option>
														<option value="2">保密</option>
													</select>
												</td>
											</tr>
											<tr>
												<th>出生地</th>
												<td>
													<input type="text" id="tr_address"  class="px" value="<?php echo $user['chusheng'];?>"/>
												</td>
												<td class="p">	
													<select name="address">
														<option value="0">公开</option>
														<option value="1">好友</option>
														<option value="2">保密</option>
													</select>
												</td>
											</tr>
											<tr>
												<th>居住地</th>
												<td>
													<input type="text" id="tr_residecity"  class="px" value="<?php echo $user['juzhu'];?>"/>
												</td>
												<td class="p">	
													<select name="residecity">
														<option value="0">公开</option>
														<option value="1">好友</option>
														<option value="2">保密</option>
													</select>
												</td>
											</tr>
											<tr>
												<th>情感状况</th>
												<td>
													<input type="text" id="tr_affectivestatus"  class="px" value="<?php echo $user['qinggan'];?>"/>
												</td>
												<td class="p">	
													<select name="affectivestatus">
														<option value="0">公开</option>
														<option value="1">好友</option>
														<option value="2">保密</option>
													</select>
												</td>
											</tr>
											<tr>
												<th>血型</th>
												<td>
													<select name="tr_bloodtype" id="tr_xue" class="ps">
														<option value="0">A</option>
														<option value="1">B</option>
														<option value="2">O</option>
														<option value="3">AB</option>
														<option value="4">其他</option>
													</select>
												</td>
												<td class="p">
													<select name="bloodtype">
														<option value="0">公开</option>
														<option value="1">好友</option>
														<option value="2">保密</option>
													</select>
												</td>
											</tr>
											<tr>
												<th>QQ</th>
												<td>
													<input type="text" id="tr_qq" class="px" value="<?php echo $user['qq'];?>"/>
												</td>
												<td class="p">	
													<select name="qq">
														<option value="0">公开</option>
														<option value="1">好友</option>
														<option value="2">保密</option>
													</select>
												</td>
											</tr>
											<tr>
												<th>&nbsp;</th>
												<td>
													<button type="submit" name="pwdsubmit" value="true" class="pn pnc" id="save_geren_setting">
														<strong>保存</strong>
													</button>
												</td>
											</tr>
										</table>
									</div>
									<div>
										<table class="tfm" cellspacing="0" cellpadding="0">
											<tr>
												<th>用户名</th>
												<td><?php echo $_SESSION['user']['username'];?></td>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<th>自我介绍</th>
												<td>
													<textarea name="tr_bio" rows="3" cols="40" id="tr_bio" class="pt" ><?php echo $user['jieshao'];?></textarea>
												</td>
												<td class="p">	
													<select name="bio">
														<option value="0">公开</option>
														<option value="1">好友</option>
														<option value="2">保密</option>
													</select>
												</td>
											</tr>
											<tr>
												<th>兴趣爱好</th>
												<td>
													<textarea name="tr_interest" rows="3" cols="40" id="tr_interest" class="pt" ><?php echo $user['aihao'];?></textarea>
												</td>
												<td class="p">	
													<select name="interest">
														<option value="0">公开</option>
														<option value="1">好友</option>
														<option value="2">保密</option>
													</select>
												</td>
											</tr>
											<tr>
												<th>个性签名</th>
												<td>
													<textarea name="tr_sightml" rows="3" cols="40" id="tr_sightml" class="pt" ><?php echo $user['qianming'];?></textarea>
												</td>
												<td class="p">	
													&nbsp;
												</td>
											</tr>
											<tr>
												<th>&nbsp;</th>
												<td>
													<button type="submit" name="pwdsubmit" value="true" class="pn pnc" id="save_setting_xinxi">
														<strong>保存</strong>
													</button>
												</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
							<div>
								<h1 class="mt">密码安全</h1>
								<p class="bbda pbm mbm">
									您必须填写原密码才能修改下面的资料
									<input type="hidden" name="user_id" id="user_id" value="<?php echo $user['id'];?>" />
									<table border="" cellspacing="0" cellpadding="0" summary="个人资料" class="tfm">
										<tbody>
											<tr>
												<th>新密码</th>
												<td>
													<input type="password" name="newpassword" id="newpassword" value="" class="px"/>
													<p class="d" id="chk_newpassword">如不需要更改密码，此处请留空 </p>
												</td>
											</tr>
											<tr>
												<th>确认新密码</th>
												<td>
													<input type="password" name="password" id="password" value="" class="px"/>
													<p class="d" id="chk_password">如不需要更改密码，此处请留空 </p>
												</td>
											</tr>
											<tr>
												<th>邮箱</th>
												<td>
													<input type="text" name="send_email" id="send_email" value="" class="px"/>
													<p class="d" id="chk_email">如不需要更改密码，此处请留空 </p>
												</td>
											</tr>
											<tr>
												<th>安全提示</th>
												<td>
													<select name="questionidnew" id="questionidnew">
															<option value="-1" selected>保持原有的安全提问和答案</option>
															<option value="0">无安全提问</option>
															<option value="1">母亲的名字</option>
															<option value="2">爷爷的名字</option>
															<option value="3">父亲出生的城市</option>
															<option value="4">您其中一位老师的名字</option>
															<option value="5">您个人计算机的型号</option>
															<option value="6">您最喜欢的餐馆名称</option>
															<option value="7">驾驶执照最后四位数字</option>
</select>
													<p class="d">如果您启用安全提问，以后我们会开放对应的找回密码方式 </p>
												</td>
											</tr>
											<tr>
												<th>回答</th>
												<td>
													<input type="text" name="answer" id="answer" value="" class="px"/>
													<p class="d">	
如您设置新的安全提问，请在此输入答案 </p>
												</td>
											</tr>
											<tr>
												<th>
													<span class="rq" title="必填">*</span>
													旧密码</th>
												<td>
													<input type="password" name="old_password" id="old_password" value="" class="px"/>
												</td>
											</tr>
											<tr>
												<th>&nbsp;</th>
												<td>
													<button type="submit" name="pwdsubmit" value="true" class="pn pnc" id="saveSetting">
														<strong>保存</strong>
													</button>
												</td>
											</tr>
										</tbody>
									</table>
								</p>
							</div>
							<div>
								<h1 class="mt">我的消息</h1>
							</div>
						</div>
					</div>
					<div class="appl">
						<div class="tbn">
							<h2 class="mt bbda">设置</h2>
							<ul id="ul_li">
								<li class="a">头像设置</li>
								<li>个人资料</li>
								<li>密码安全</li>
								<li>我的消息</li>
								<li>注销</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			$(function() {

				//点击切换设置东西
				clickProductTabs()
				//安全密码方面的验证
				CheckFun()
				//密码验证提交
				SaveSettingFun()
				//切換個人資料頁面信息

				function clickProductTabs() {
					var $lis = $('#ul_li>li')
					var $contents = $('#setting_index>div');
					$contents.hide();
					$('#setting_index>div:first').show();
					$lis.click(function() {
						$lis.removeClass('a')
						this.className = 'a'
						$contents.hide();
						var index = $(this).index()
						$contents.eq(index).show();
					})

					$('#ul_li>li:last').click(function() {
						layer.confirm('你确定要退出登录吗？', {
							btn: ['确定', '取消'] //按钮
						}, function() {
							window.location.href = "logout.php";
						});
					})

				}

				function CheckFun() {
					$('#newpassword').blur(function() {
						if($(this).val().length < 4) {
							$(this).addClass("er");
							$('#chk_newpassword').html("如不需要更改密码，此处请留空, 最小长度为 4 个字符");
						} else {
							$(this).removeClass("er");
							$('#chk_newpassword').html("如不需要更改密码，此处请留空");
						}
					})
					$('#password').blur(function() {
						if($(this).val().length < 4 && $(this).val() == $('#newpassword').val()) {
							$(this).addClass("er");
							$('#chk_password').html("如不需要更改密码，此处请留空, 最小长度为 4 个字符,且密码一致");
						} else {
							$(this).removeClass("er");
							$('#chk_password').html("如不需要更改密码，此处请留空");
						}
					})
				}

				function SaveSettingFun() {
					$('#saveSetting').click(function() {
						var newpassword = $('#newpassword').val();
						var password = $('#password').val();
						var send_email = $('#send_email').val();
						var old_password = $('#old_password').val();
						var answer = $('#answer').val();
						var questionidnew = $('#questionidnew option:selected').val();
						if(newpassword.length < 4 && newpassword.length > 0) {
							layer.msg('密码长度不符合条件', {
								time: 1000
							});
							return false;
						}
						if(password.length < 4 && password.length > 0 && password != newpassword) {
							layer.msg('密码长度不符合或两次密码不一致', {
								time: 1000
							});
							return false;
						}
						if(old_password.length == 0) {
							layer.msg('新密码不能为 空', {
								time: 1000
							});
							return false;
						}
						//提交表单的页面信息
						$.post('ajaxSaveSetting.php', {
							newpassword: newpassword,
							send_email: send_email,
							old_password: old_password,
							answer: answer,
							questionidnew: questionidnew
						}, function(data) {
							console.log(data);
							if(data == -1) {
								layer.msg('原密码错误', {
									time: 1000
								});
								return false;
							}
							if(data == -2) {
								layer.msg('修改失败', {
									time: 1000
								});
								return false;
							}
							if(data == 1) {
								layer.msg('修改完毕', {
									time: 1000
								});
								window.location.reload();
							}
						})
					})
				}

			})
		</script>
		<script>
			qiehuanMain();
			function qiehuanMain() {
				var $lis = $('#ul_click>li');
				var $contents = $('#ul_click_content>div');
				$contents.hide();
				$('#ul_click_content>div:first').show();
				$lis.click(function() {
					$lis.removeClass('a')
					this.className = 'a'
					$contents.hide();
					var index = $(this).index()
					$contents.eq(index).show();
				})
			}
			$('#save_geren_setting').click(function(){
				var true_name = $('#tr_realname').val();
				var sex=$('#tr_gender option:selected').val();
				var bir=$('#tr_birthday').val();
				var chu=$('#tr_address').val();
				var ju=$('#tr_residecity').val();
				var qing=$('#tr_affectivestatus').val();
				var xue=$('#tr_xue option:selected').val();
				var qq=$('#tr_qq').val();
				var user_id=$('#user_id').val();
				$.post('ajaxSaveGeren.php',{
					true_name:true_name,
					sex:sex,
					bir:bir,
					chu:chu,
					ju:ju,
					qing:qing,
					xue:xue,
					qq:qq,
					user_id:user_id
				},function(data){
					if(data==1){
						layer.msg('修改成功',{time:1000},function(){
				            var index = parent.layer.getFrameIndex(window.name);
				            parent.location.reload();
				            parent.layer.close(index); 
				        });
					}else{
						layer.msg('修改失败',{time:1000});
					}
				})
			})
			$('#save_setting_xinxi').click(function(){
				var bio=$('#tr_bio').val();
				var tr_interest=$('#tr_interest').val();
				var tr_sightml=$('#tr_sightml').val();
				$.post('ajaxSavexinxi.php',{
					bio:bio,
					tr_interest:tr_interest,
					tr_sightml:tr_sightml
				},function(data){
					if(data==1){
						layer.msg('修改成功',{time:1000},function(){
				            var index = parent.layer.getFrameIndex(window.name);
				            parent.location.reload();
				            parent.layer.close(index); 
				        });
					}else{
						layer.msg('修改失败',{time:1000});
					}
				})
			})
		</script>
		<script>
			$(function () {
				var old_avatar  = "http://open.web.meitu.com/sources/images/1.jpg";
				var avatar      = $('.my_head img').attr('value');
				var avatar_url = "http://studyit.club/itclub/images/"+avatar;
				if(!avatar_url){
					avatar_url = old_avatar;
				}
				xiuxiu.embedSWF("altContent",5,"100%","100%");
				xiuxiu.setUploadURL("http://studyit.club/itclub/imageUploadForm.php");
				xiuxiu.setUploadType(2);
				xiuxiu.setUploadDataFieldName("Filedata");
				xiuxiu.onInit = function ()
				{
					xiuxiu.loadPhoto(avatar_url);
				};
				xiuxiu.onUploadResponse = function (data)
				{
					layer.msg('上传成功',{time:2000});
					window.location.reload();
				}
			});
		</script>
		<?php include("view/right.php"); ?>
		<?php include("view/footer.php"); ?>
	</body>
</html>


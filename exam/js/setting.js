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
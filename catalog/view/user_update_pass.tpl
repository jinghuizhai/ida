<div class="main-inner">
	<p class="p-title">
		修改密码
	</p>
	<div class="form-group">
		<p class="red mb10" id="login-info"></p>
		<form action="<?php echo HOSTNAME;?>user/updatePass" method="post">
			<div class="p-group">
				<b>新密码</b>
				<input type="password" name="pass" id="pass" maxlength="20" />
			</div>
			<div class="p-group">
				<b>重复</b>
				<input type="password" name="pass2" id="pass2" maxlength="20"/>
			</div>
			<div class="p-group">
				<b>短信</b>
				<input name="sms" id="sms" />
				<a id="btn-get-sms" class="btn b-green" href="javascript:;" data-time="yes" onclick="getSms(this);">
					<span class="loading dn" id="loading"></span>
					<span id="a-btn-content">获取短信验证码</span>
				</a>
			</div>
			<button class="btn" onclick="return checkPass(this);">确定</button>
		</form>
	</div>
</div>
<script type="text/javascript">
	function getSms(othis){
		var loading = zjh.get('loading'),
			pass = zjh.get('pass').value.trim(),
			pass2 = zjh.get('pass2').value.trim(),
			info = zjh.get('login-info'),
			btn = zjh.get('a-btn-content');
		if(othis.getAttribute('data-time') == 'no'){
			alert('请60秒后再试');
			return;
		}
		othis.setAttribute('data-time','no');
		if(!zjh.validate('pass',pass)){
			info.innerHTML = '密码格式不正确';
			return;
		}
		if(!zjh.validate('pass',pass2)){
			info.innerHTML = '第二次输入密码格式不正确';
			return;
		}

		zjh.showi(loading);

		zjh.POST('<?php echo HOSTNAME;?>user/sendSmsWhenUpdate',{'phone':'123'},function(ret){
			ret = ret.trim();
			console.log(ret);
			if(ret == 'success'){
				btn.innerHTML = '已发送，将有7秒延迟';
				setTimeout(function(){
					othis.setAttribute('data-time','yes');
				},1000*60);
			}else if(ret == 'fail'){
				info.innerHTML = '因网络问题，短信未能发送';
			}else{
				info.innerHTML = ret;
			}
			zjh.hide(loading);
		});
	}
	function checkPass(othis){
		var pass = zjh.get('pass').value.trim(),
			pass2= zjh.get('pass2').value.trim(),
			sms = zjh.get('sms').value.trim(),
			loading = zjh.get('loading'),
			info = zjh.get('login-info');

		if(!zjh.validate('pass',pass)){
			info.innerHTML = '密码格式不正确';
			return false;
		}
		if(!zjh.validate('pass',pass2)){
			info.innerHTML = '第二次输入密码格式不正确';
			return false;
		}
		if(!zjh.validate('sms',sms)){
			info.innerHTML = '短信验证码格式不正确';
			return false;
		}
		return true;
	}

</script>
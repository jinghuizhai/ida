<div class="container mt20">
	<div class="login-title">
		<h1>会员登录</h1>
	</div>
	<div class="login">
		<div class="inner">
			<p class="red mb10" id="login-info"></p>
			<form action="<?php echo HOSTNAME;?>home/login" method="post" id="formlogin">
				<div class="input-group">
					<b>手机</b>
					<input name="phone" id="phone"/>
				</div>
				<div class="input-group">
					<b>密码</b>
					<input type="password" name="pass" id="pass"/>
				</div>
				<div class="input-group">
					<b>验证码</b>
					<input name="code" id="code"/>
					<div class="codeimg">
						<a href="javascript:;" id="not-clear" onclick="reflushCode('codeimg');">看不清？</a>
						<img data-src="<?php echo HOSTNAME;?>code.php" src="<?php echo HOSTNAME;?>code.php" id="codeimg" onclick="reflushCode(this.id);"/>
					</div>
				</div>
				<p class="login-plus fix">
					<input type="checkbox" name="rememberme" id="rememberme"/>
					<label for="rememberme">记住账号</label>
					<a class="f12 c9" href="<?php echo HOSTNAME;?>home/forget">忘记密码？</a>
					<button class="btn r" onclick="return checkLogin(this);">登录</button>
					<span id="loading" class="r loading dn"></span>
				</p>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	function reflushCode(id){
		var img = zjh.get(id);
		img.src = img.getAttribute('data-src')+"?v="+Math.random();
	}
	function checkLogin(othis){
		var phone = zjh.get('phone').value.trim(),
			pass = zjh.get('pass').value.trim(),
			code = zjh.get('code').value.trim(),
			loading = zjh.get('loading'),
			info = zjh.get('login-info');

		if(!zjh.validate('phone',phone)){
			info.innerHTML = '手机号不符合要求';
			return false;
		}
		if(!zjh.validate('pass',pass)){
			info.innerHTML = '密码不符合要求';
			return false;
		}
		if(zjh.validate('code',code)){

			othis.disabled = true;
			zjh.showi(loading);

			zjh.POST('<?php echo HOSTNAME;?>home/getValidateCode',null,function(r){
				if(r.trim() == code){
					zjh.get('formlogin').submit();
				}else{
					info.innerHTML = '验证码不正确';
					zjh.get('codeimg').click();
					zjh.hide(loading);
					othis.disabled = false;
				}
			});
			return false;
		}else{
			info.innerHTML = '验证码格式不正确';
			return false;
		}
		return false;
	}
	zjh.get('phone').focus();
</script>
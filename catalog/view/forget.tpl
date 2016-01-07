<div class="container">
	<div class="login-title mt20">
		<h1>密码找回</h1>
	</div>
	<div class="login">
		<div class="inner">
			<p class="red mb10" id="login-info"></p>
			<form action="<?php echo HOSTNAME;?>home/forget" method="post">
				<div class="input-group">
					<b>手机号</b>
					<input type="text" name="phone" id="phone"/>
				</div>
				<div class="input-group">
					<b>验证码</b>
					<input name="code" id="code"/>
					<div class="codeimg">
						<a href="javascript:;" id="not-clear" onclick="reflushCode('codeimg');">看不清？</a>
						<img data-src="<?php echo HOSTNAME;?>code.php" src="<?php echo HOSTNAME;?>code.php" id="codeimg" onclick="reflushCode(this.id);"/>
					</div>
				</div>
				<button class="btn" onclick="return checkForget(this);">找回密码</button>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	function reflushCode(id){
		var img = zjh.get(id);
		img.src = img.getAttribute('data-src')+"?v="+Math.random();
	}
	function checkForget(othis){
		var phone = zjh.get('phone').value.trim(),
			info = zjh.get('login-info'),
			code = zjh.get('code').value.trim();
		if(!zjh.validate('phone',phone)){
			info.innerHTML = '手机号不符合要求';
			return false;
		}
		if(!zjh.validate('code',code)){
			info.innerHTML = '验证码格式不正确';
			return false;
		}
		return true;
	}
</script>
<div class="main-inner">
	<p class="p-title">更新信息</p>
	<div class="form-group">
		<div class="inner">
			<p id="login-info"></p>
			<form action="<?php echo HOSTNAME;?>admin/admin/update" method="post">
				<div class="p-group">
					<b>现在密码</b>
					<input type="password" name="old_pass" id="old-pass"/>
				</div>
				<div class="p-group">
					<b>新密码</b>
					<input type="password" name="pass" id="pass"/>
				</div>
				<div class="p-group">
					<b>重复新密码</b>
					<input type="password" name="pass2" id="pass2"/>
				</div>
				<button class="btn" onclick="return checkPass(this)">
				更新
				</button>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	function checkPass(othis){
		var oldPass = zjh.get('old-pass').value.trim(),
			pass = zjh.get('pass').value.trim(),
			pass2 = zjh.get('pass2').value.trim(),
			info = zjh.get('login-info');

		if(!zjh.validate('pass',oldPass)){
			info.innerHTML = "现在使用密码格式不正确";
			return false;
		}
		if(!zjh.validate('pass',pass)){
			info.innerHTML = "新密码格式不正确";
			return false;
		}
		if(!zjh.validate('pass',pass2)){
			info.innerHTML = "重复密码格式不正确";
			return false;
		}
		if(pass != pass2){
			info.innerHTML = "两次密码输入不正确";
			return false;
		}
		return true;
	}
</script>
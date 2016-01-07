<div class="main-inner">
	<p class="p-title">
		修改密码
	</p>
	<div class="form-group">
		<p id="login-info"></p>
		<form action="<?php echo HOSTNAME;?>admin/user/pass_update" method="post">
			<input type="hidden" name="user_id" value="<?php echo $user_id;?>" />
			<div class="p-group">
				<b>姓名</b>
				<input type="text" disabled="true" name="name" value="<?php echo $name;?>"/>   
			</div>
			<div class="p-group">
				<b>密码</b>
				<input type="password" name="pass" id="pass"/>   
			</div>
			<div class="p-group">
				<b>重复</b>
				<input type="password" name="pass2" id="pass2"/>
			</div>
			<button class="btn" onclick="return checkPass(this);">更新</button>
		</form>
	</div>
</div>
<script type="text/javascript">
	function checkPass(othis){
		var pass = zjh.get('pass').value.trim(),
			pass2 = zjh.get('pass2').value.trim(),
			info = zjh.get('login-info');

		if(!zjh.validate('pass',pass)){
			info.innerHTML = '密码格式不符合要求';
			return false;
		}
		if(!zjh.validate('pass',pass2)){
			info.innerHTML = '重复密码格式不符合要求';
			return false;
		}
		if(pass != pass2){
			info.innerHTML = '两次输入密码不相同';
			return false;
		}
		return true;
	}
</script>
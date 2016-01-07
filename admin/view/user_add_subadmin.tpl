<div class="main-inner">
	<p class="p-title">添加分管理员</p>
	<div class="form-group">
		<div class="inner">
			<p id="login-info" class="red mb10"></p>
			<form action="<?php echo HOSTNAME;?>admin/user/addSubadmin" method="post">
				<div class="p-group">
					<b>角色</b>
					<?php if(!empty($roles)){ ?>
						<select name="role_id">
							<?php foreach($roles as $key => $value){ ?>
								<option value="<?php echo $value['role_id'];?>"><?php echo $value['name'];?></option>
							<?php } ?>
						</select>
					<?php } ?>
				</div>
				<div class="p-group">
					<b>Email</b>
					<input name="email" id="email" />
				</div>
				<div class="p-group">
					<b>姓名</b>
					<input name="name" id="name" />
				</div>
				<div class="p-group">
					<b>密码</b>
					<input type="password" name="pass" id="pass" />
				</div>
				<button class="btn" onclick="return checkAddSub(this);">
				添加
				</button>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	function checkAddSub(othis){
		var name = zjh.get('name').value.trim(),
			pass = zjh.get('pass').value.trim(),
			info = zjh.get('login-info'),
			email = zjh.get('email').value.trim();

		if(!zjh.validate('email',email)){
			info.innerHTML = 'Email不符合要求';
			return false;
		}
		if(!zjh.validate('name',name)){
			info.innerHTML = '姓名不符合要求';
			return false;
		}
		if(!zjh.validate('pass',pass)){
			info.innerHTML = 'Email不符合要求';
			return false;
		}
		return true;
	}
</script>
<div class="main-inner">
	<p class="p-title">
		添加分公司
	</p>
	<div class="form-group">
		<p id="login-info"></p>
		<form action="<?php echo HOSTNAME;?>admin/user/addBranch" method="post">
			<input type="hidden" name="tag" value="branch" />
			<div class="p-group">
				<b>名称</b>
				<input name="name" value="<?php echo $name;?>" id="name"/>
			</div>
			<!-- <div class="p-group">
				<b>Email</b>
				<input name="email" value="<?php echo $email;?>" id="email"/>
			</div> -->
			<div class="p-group">
				<b>密码</b>
				<input type="password" name="pass" value="<?php echo $pass;?>" id="pass"/>
			</div>
			<div class="p-group">
				<b>电话</b>
				<input name="phone" value="<?php echo $phone;?>" id="phone"/>
			</div>
			<button class="btn" onclick="return checkAdd(this);">添加</button>
		</form>
	</div>
</div>
<script type="text/javascript">
	
	function checkAdd(othis){
		var name = zjh.get('name').value.trim(),
			pass = zjh.get('pass').value.trim(),
			phone = zjh.get('phone').value.trim(),
			info = zjh.get('login-info');

		if(!zjh.validate('name',name)){
			info.innerHTML = '姓名必须为2-4个字的中文';
			return false;
		}
		if(!zjh.validate('pass',pass)){
			info.innerHTML = '密码格式不符合要求';
			return false;
		}
		if(!zjh.validate('phone',phone)){
			info.innerHTML = '电话格式不符合要求';
			return false;
		}
		return true;
	}
</script>
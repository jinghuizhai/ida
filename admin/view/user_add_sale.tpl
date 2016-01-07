<div class="main-inner">
	<p class="p-title">
		添加业务员
	</p>
	<div class="form-group">
		<p id="login-info"></p>
		<form action="<?php echo HOSTNAME;?>admin/user/addSale" method="post">
			<input type="hidden" name="tag" value="sale" />
			<div class="p-group">
				<b>分公司ID</b>
				<input name="branch_id" value="<?php echo $branch_id;?>" id="branch_id"/>
			</div>
			<div class="p-group">
				<b>名称</b>
				<input name="name" value="<?php echo $name;?>" id="name"/>
			</div>
			<!-- <div class="p-group">
				<b>Email</b>
				<input name="email" value="<?php echo $email;?>"/>
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
			branch_id = zjh.get('branch_id').value.trim(),
			info = zjh.get('login-info');

		if(!zjh.validate('int',branch_id)){
			info.innerHTML = '分公司ID必须为整数';
			return false;
		}

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

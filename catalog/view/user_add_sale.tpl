<div class="main-inner">
	<p class="p-title">
		添加业务员
	</p>
	<div class="form-group">
		<p id="login-info"></p>
		<form action="<?php echo HOSTNAME;?>user/addSale" method="post"> 
			<div class="p-group">
				<b>姓名</b>
				<input type="text" name="name" id="name"/>
			</div>
			<div class="p-group">
				<b>电话</b>
				<input type="text" name="phone" id="phone"/>
			</div>
			<div class="p-group">
				<b>密码</b>
				<input type="password" name="pass" id='pass'/>
			</div>
			<div class="p-group">
				<b>重复</b>
				<input type="password" name="pass2" id='pass2'/>
			</div>
			<button class="btn" onclick="return checkSale(this);">添加</button>
		</div>
	</div>
</div>
<script type="text/javascript">
	function checkSale(othis){
		var name = zjh.get('name').value.trim(),
			phone = zjh.get('phone').value.trim(),
			pass = zjh.get('pass').value.trim(),
			pass2 = zjh.get('pass2').value.trim(),
			info = zjh.get('login-info');

		if(!zjh.validate('name',name)){
			info.innerHTML = '姓名不符合要求';
			return false;
		}
		if(!zjh.validate('phone',phone)){
			info.innerHTML = '电话号码不符合要求';
			return false;
		}
		if(!zjh.validate('pass',pass)){
			info.innerHTML = '密码不符合要求';
			return false;
		}
		if(pass != pass2){
			info.innerHTML = '重复密码不符合要求';
			return false;
		}
		return true;
	}
</script>
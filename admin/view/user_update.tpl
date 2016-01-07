<div class="main-inner">
	<p class="p-title">
		更新用户
	</p>
	<form action="<?php echo HOSTNAME;?>admin/user/update" method="post">
		<input type="hidden" name="user_id" value="<?php echo $user_id;?>" />
		<div class="form-group">
			<p id="login-info"></p>
			<div class="p-group">
				<b>姓名</b>
				<input id="name" type="text" name="name" value="<?php echo $name;?>" />
			</div>
			<div class="p-group">
				<b>电话</b>
				<input id="phone" type="text" name="phone" value="<?php echo $phone;?>" />
			</div>
			<div class="p-group">
				<b>是否能提现</b>
				<select name="can_cashout">
					<?php if(empty($can_cashout)){ ?>
					<option value="1">能</option>
					<option value="0" selected="selected">不能</option>
					<?php }else{ ?>
					<option value="1" selected="selected">能</option>
					<option value="0">不能</option>
					<?php } ?>
				</select>
			</div>
			<div class="p-group">
				<b>银行名称</b>
				<input type="text" name="paybank" value="<?php echo $paybank;?>" />
			</div>
			<div class="p-group">
				<b>银行账户</b>
				<input type="text" name="paycount" value="<?php echo $paycount;?>" />
			</div>
			<button class="btn" onclick="return checkUser(this)">更新用户</button>
		</div>
	</form>
</div>
<script type="text/javascript">
	function checkUser(othis){
		var name = zjh.get('name').value.trim(),
			phone = zjh.get('phone').value.trim(),
			info = zjh.get('login-info');

		if(name.length < 1){
			info.innerHTML = '名称不能为空';
			return false;
		}
		if(!zjh.validate('phone',phone)){
			info.innerHTML = '电话不符合要求';
			return false;
		}
		return true;
	}
</script>

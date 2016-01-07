<div class="main-inner">
	<p class="p-title">
		修改银行账户
	</p>
	<div class="form-group">
		<form action="<?php echo HOSTNAME;?>user/updateName" method="post">
			<div class="input-group">
				<input type="hidden" name="user_id" value="<?php echo $user_id;?>" />
				<b>姓名</b>
				<input name="name" />
			</div>
			<button class="btn">确定</button>
		</form>
	</div>
</div>
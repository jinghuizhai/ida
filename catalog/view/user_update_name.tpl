<div class="main-inner">
	<p class="p-title">
		修改名称
	</p>
	<div class="form-group">
		<form action="<?php echo HOSTNAME;?>user/updateName" method="post">
			<div class="p-group">
				<b>姓名</b>
				<input id="name" name="name" value="<?php echo $name;?>"/>
			</div>
			<button class="btn" id="return checkName(this);">确定</button>
		</form>
	</div>
</div>
<script type="text/javascript">
	function checkName(othis){
		var name = zjh.get('name').value.trim();
		if(!zjh.validate('name',name)){
			alert('姓名必须为2~4个字符的中文');
			return false;
		}
		return true;
	}
</script>

<div class="main-inner">
	<p class="p-title">添加属性</p>
	<div class="form-group">
		<p id="login-info"></p>
		<div class="inner">
			<form action="<?php echo HOSTNAME;?>admin/attr/add" method="post">
				<div class="p-group">
					<b>属性名称</b>
					<input name="name" id="name" />
				</div>
				<button class="btn" onclick="return checkName(this)">
				添加
				</button>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	function checkName(othis){
		var name = zjh.get('name').value.trim(),
			info = zjh.get('login-info');

		if(name.length < 1){
			info.innerHTML = "属性名称不能为空";
			return false;
		}
		return true;
	}
</script>
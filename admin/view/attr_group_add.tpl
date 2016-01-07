<div class="main-inner">
	<p class="p-title">添加属性组</p>
	<div class="form-group">
		<p id="login-info"></p>
		<form action="" method="post">
			<div class="p-group">
				<b>属性组名称</b>
				<input name="name" id="name" />
			</div>
			<?php
				if(!empty($attrs)){
					foreach($attrs as $key => $value){
			?>			
			<div class="p-group" id="p-group">
				<b><?php echo $value['name'];?></b>
				<input type="hidden" name="attr[]" value="<?php echo $value['attr_id'];?>" />
				<input type="text" name="value[]" />
			</div>
			<?php }} ?>
			<button class="btn" onclick="return checkName(this)">添加</button>
		</form>
	</div>
</div>
<script type="text/javascript">
	function checkName(othis){
		var name = zjh.get('name').value.trim(),
			inputs = zjh.get('p-group').getElementsByTagName('input'),
			info = zjh.get('login-info');

		if(name.length < 1){
			info.innerHTML = '属性组名称不能为空';
			return false;
		}
		var tag = false;
		for(var i = 0,len = inputs.length;i<len;i++){
			var input = inputs[i];
			if(input.getAttribute('type') == 'text'){
				if(input.value.trim().length > 0){
					tag = true;
					break;
				}
			}
		}
		if(!tag){
			info.innerHTML = '属性组至少一个不为空';
			return false;
		}
		return true;
	}
</script>
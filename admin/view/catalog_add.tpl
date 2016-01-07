<p class="p-title">增加分类</p>
<div class="form-group">
	<p id="login-info"></p>
	<form action="<?php echo HOSTNAME;?>admin/catalog/add" method="post">
		<div class="p-group">
			<b>名称</b>
			<input type="text" name="name" id="name" />
		</div>
		<div class="p-group">
			<b>所属类别</b>
			<select name="catalog_id">
				<option value="0">新类别</option>
				<?php
					if(!empty($catalogs)){
						foreach($catalogs as $catalog){
							echo "<option value='".$catalog['catalog_id']."'>".$catalog['name']."</option>";
						}
					}
				?>
			</select>
		</div>
		<button class="btn" onclick="return checkName(this);">添加</button>
	</form>
</div>
<script type="text/javascript">
	function checkName(othis){
		var name = zjh.get('name').value.trim(),
			info = zjh.get('login-info');
		if(name.length < 1){
			info.innerHTML = '名称不能为空';
			return false;
		}
		return true;
	}
</script>

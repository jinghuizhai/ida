<p class="p-title">更新分类</p>
<table class="p-table">
	<thead>
		<th>所属分类</th>
		<th>名称</th>
		<th>操作</th>
		<th>操作</th>
	</thead>
	<tbody>
		<?php
			foreach($catalogs as $key => $catalog){
		?>
		<tr>
		<td>
			<form action="<?php echo HOSTNAME;?>admin/catalog/update" method="post" id="formtag_<?php echo $key;?>">
			<input type="hidden" name="catalog_id" value="<?php echo $catalog['catalog_id'];?>" />
			<select name="p_id">
				<option value="0">新分类</option>
				<?php
					foreach ($cats as $cat) {
						if($catalog['p_id'] == $cat['catalog_id']){
							echo "<option selected='selected' value='".$cat['catalog_id']."'>".$cat['name']."</option>";
						}else{
							echo "<option value='".$cat['catalog_id']."'>".$cat['name']."</option>";
						}
					}
				?>
			</select>
		</td>
		<td>
			<input name="name" value="<?php echo $catalog['name'];?>" />
		</td>
		<td><button class="btn b-green" onclick="return checkUpdate(this);">修改</button></td>
		<td><button data-dele="formtag_<?php echo $key;?>" class="btn b-red" onclick="return deleCatalog(this);">删除</button></form></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<script type="text/javascript">
	function checkUpdate(othis){
		var name = zjh.first(zjh.prev(othis.parentNode)).value.trim();
		if(name.length<1){
			alert('名称不能为空');
			return false;
		}else{
			return true;
		}
	}
	function deleCatalog(othis){
		var r = confirm('确定删除？'),
			host = "<?php echo HOSTNAME;?>";
		if(r){
			var formId = othis.getAttribute('data-dele'),
				form = zjh.get(formId);
			form.setAttribute('action',host+'admin/catalog/delete');
			form.submit();
		}else{
			return false;
		}
		return false;
	}
</script>
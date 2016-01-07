<div class="main-inner">
	<p class="p-title">
		所有角色
	</p>
	<p class="mb20">
		<small>没有网站建设者的许可，请不要<span class="btn small b-red">删除</span>角色，以避免造成不可逆转的错误</small>
	</p>
	<table class="p-table">
		<thead>
			<th>角色ID</th>
			<th>角色名称</th>
			<th>角色TAG</th>
			<th>角色入口</th>
			<th>权限</th>
			<th>操作</th>
			<th>操作</th>
		</thead>
		<tbody>
			<?php if(!empty($roles)){
				foreach($roles as $key => $value){
			?>
				<tr>
					<td>
						<form action="<?php echo HOSTNAME;?>admin/role/delete" method="post" id="formtag_<?php echo $key;?>">
						<input type="hidden" name="role_id" value="<?php echo $value['role_id'];?>" />
						<?php echo $value['role_id'];?>
					</td>
					<td>
						<?php echo $value['name'];?>
					</td>
					<td>
						<?php echo $value['tag'];?>
					</td>
					<td>
						<?php echo $value['entrance'];?>
					</td>
					<td>
						<?php echo var_dump(unserialize($value['permission'])); ?>
					</td>
					<td>
						<a href="<?php echo HOSTNAME;?>admin/role/update/<?php echo $value['role_id'];?>" class="btn b-green">更新</a>
					</td>
					<td>
						<button data-id="formtag_<?php echo $key;?>" class="btn b-red" onclick="return checkDelete(this);">删除</button>
					</td>
				</tr>
			<?php }} ?>
		</tbody>
	</table>
</div>
<script type="text/javascript">
	function checkDelete(othis){
		var r = confirm('确定删除么？');
		if(r){
			var dataId = othis.getAttribute('data-id');
			var form = zjh.get(dataId);
			form.submit();
		}else{
			return false;
		}
	}
</script>
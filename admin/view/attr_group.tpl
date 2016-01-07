<div class="main-inner">
	<p class="p-title">所有属性组</p>
	<table class="p-table">
		<thead>
			<th>属性名称</th>
			<th>属性内容</th>
			<th>操作</th>
			<th>操作</th>
		</thead>
		<tbody>
			<?php
				if(!empty($attr_groups)){
				foreach($attr_groups as $key => $value){
			?>
			<tr>
				<td>
					<form action="<?php echo HOSTNAME;?>admin/attr/update" method="post" id="formtag_<?php echo $key;?>">
					<input type="hidden" name="attr_group_id" value="<?php echo $value['attr_group_id'];?>"/>
					<?php echo $value['pname'];?>
				</td>
				<td>
					<?php echo $value['name'];?>
					/
					<?php echo $value['value'];?>
				</td>
				<td>
					<a href="<?php echo HOSTNAME;?>admin/attr_group/update/<?php echo $value['attr_group_id'];?>" class="btn b-green">修改</a>
				</td>
				<td>
					<button data-id="formtag_<?php echo $key;?>" onclick="return checkDelete(this)" class="btn b-red">删除</button>
					</form>
				</td>
			</tr>
			<?php }} ?>
		</tbody>
	</table>
</div>
<script type="text/javascript">
	function checkDelete(othis){
		var r = confirm('确定删除么?');
		if(r){
			var dataId = othis.getAttribute('data-id');
			var form = zjh.get(dataId);
			form.setAttribute('action','<?php echo HOSTNAME;?>admin/attr_group/delete');
			form.submit();
		}else{
			return false;
		}
	}
</script>
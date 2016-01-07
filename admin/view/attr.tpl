<div class="main-inner">
	<p class="p-title">所有属性</p>
	<table class="p-table">
		<thead>
			<th>属性ID</th>
			<th>属性名称</th>
			<th>操作</th>
			<th>操作</th>
		</thead>
		<tbody>
			<?php
				if(!empty($attrs)){
				foreach($attrs as $key => $value){
			?>
			<tr>
				<td>
					<form action="<?php echo HOSTNAME;?>admin/attr/update" method="post" id="formtag_<?php echo $key;?>">
					<input type="hidden" name="attr_id" value="<?php echo $value['attr_id'];?>"/>
					<?php echo $value['attr_id'];?>
				</td>
				<td>
					<input type="text" name="name" value="<?php echo $value['name'];?>" />
				</td>
				<td>
					<button class="btn b-green">修改</button>
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
			form.setAttribute('action','<?php echo HOSTNAME;?>admin/attr/delete');
			form.submit();
		}else{
			form.submit();
		}
	}
</script>
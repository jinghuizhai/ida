<div class="main-inner">
	<p class="p-title">所有分管理员</p>
	<table class="p-table">
		<thead>
			<th>角色</th>
			<th>Email</th>
			<th>姓名</th>
			<th>操作</th>
		</thead>
		<tbody>
			<?php if(!empty($roles)){
				foreach($roles as $key => $value){
			?>
			<tr>
				<td>
					<form action="<?php echo HOSTNAME;?>admin/user/deleteSubadmin" method="post">
					<input type="hidden" name="admin_id" value="<?php echo $value['admin_id'];?>"/>
					<?php echo $value['rname'];?>
				</td>
				<td>
					<?php echo $value['email'];?>
				</td>
				<td>
					<?php echo $value['name'];?>
				</td>
				<!-- <td>
					<a class="btn b-green" href="<?php echo HOSTNAME;?>admin/admin/update/<?php echo $value['admin_id'];?>">更新</a>
				</td> -->
				<td>
					<button class="btn b-red" onclick="return confirm('真的要删除么？');">删除</button>					
					</form>
				</td>
			</tr>
			<?php }} ?>
		</tbody>
	</table>
</div>
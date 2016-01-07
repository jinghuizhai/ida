<div class="main-inner">
	<p class="p-title">
	所有地址
	</p>
	<table class="p-table">
		<thead>
			<th>地址</th>
			<th>当前使用</th>
			<th>更新</th>
			<th>删除</th>
		</thead>
		<tbody>
			<?php if(!empty($addresses)){
				foreach($addresses as $key => $value){
			?>
			<tr>
				<td>
					<form action="<?php echo HOSTNAME;?>address/delete" method="post">
					<input type="hidden" name="address_id" value="<?php echo $value['address_id'];?>" />
					<?php echo $value['province'];?>
					<?php echo $value['city'];?>
					<?php echo $value['area'];?>
					<?php echo $value['zip'];?>
					<?php echo $value['detail'];?>
				</td>
				<td>
					<?php
						if($value['used'] == 0){
							echo '未使用';
						}else{
							echo '正在使用';
						}
					?>
				</td>
				<td>
					<a href="<?php echo HOSTNAME;?>address/update/<?php echo $value['address_id'];?>" class="btn b-green">更新</a>
				</td>
				<td>
					<button class="btn b-red" onclick="return confirm('确定删除？');">删除</button>
					</form>
				</td>
			</tr>
			<?php }} ?>
		</tbody>
	</table>
</div>
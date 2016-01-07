<div class="main-inner">
	<p class="p-title">所有广播</p>
	<table class="p-table">
		<thead>
			<th>广播内容</th>
			<th>日期界限</th>
			<th>给谁看</th>
			<th>操作</th>
			<th>操作</th>
		</thead>
		<tbody>
			<?php
				if(!empty($broadcasts)){
				foreach($broadcasts as $key => $value){
			?>
			<tr>
				<td>
					<form action="<?php echo HOSTNAME;?>admin/broadcast/delete" method="post">
					<input type="hidden" name="broadcast_id" value="<?php echo $value['broadcast_id'];?>"/>
					<?php echo $value['content'];?>
				</td>
				<td>
					<?php echo $value['date_start'];?>
					/
					<?php echo $value['date_end'];?>
				</td>
				<td>
					<?php 
						if(!empty($role_ids)){
							if($value['role_id'] == 0){
								echo '所有人';
							}else{
								foreach($role_ids as $k => $v){
									if($v == $value['role_id']){
										echo $role_names[$k];
									}
								}
							}
						}
					?>
				</td>
				<td>
					<a href="<?php echo HOSTNAME;?>admin/broadcast/update/<?php echo $value['broadcast_id'];?>" class="btn b-green">更新</a>
				</td>
				<td>
					<button onclick="return confirm('确定删除？');" class="btn b-red">删除</button>
					</form>
				</td>
			</tr>
			<?php }} ?>
		</tbody>
	</table>
</div>
<div class="main-inner">
	<p class="p-title">未付款</p>
	<table class="p-table">
		<thead>
			<th>订单号</th>
			<th>姓名</th>
			<th>地址</th>
			<th>应付款</th>
			<th>日期</th>
			<th>操作</th>
		</thead>
		<tbody>
			<?php if(!empty($orders)){
				foreach($orders as $key => $value){
			?>
			<tr>
				<td>
					<form action="<?php echo HOSTNAME;?>admin/order/delete" method="post">
					<input type="hidden" name="order_id" value="<?php echo $value['order_id'];?>"/>
					<input type="hidden" name="tag" value="not"/>
					<?php echo $value['order_code'];?>
				</td>
				<td>
					<?php echo $value['name'];?>
				</td>
				<td>
					<?php echo $value['address'];?>
				</td>
				<td>
					<?php echo $value['money'];?>
				</td>
				<td>
					<?php echo $value['date'];?>
				</td>
				<td>
					<button class="btn b-red">删除</button>					
					</form>
				</td>
			</tr>
			<?php }} ?>
		</tbody>
	</table>
	<?php
		echo $pagination;
	?>
</div>
<div class="main-inner">
	<p class="p-title">已经付款，但未发送成功订单</p>
	<p class="mb20">
		<small>这里显示的数据，有可能是用户已经付款，但仍在处理的过程中。所以不要一旦看见有未发送订单就手动发送，要参照订单的付款时间
		<br/>
		如果超过<span class='red'>30</span>分钟仍然显示未发送成功，建议再手动发送</small>
	</p>
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
					<form action="<?php echo HOSTNAME;?>admin/order/handSend" method="post">
					<input type="hidden" name="order_id" value="<?php echo $value['order_id'];?>"/>
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
					<button class="btn b-green">远程提交</button>					
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
<script type="text/javascript" src="<?php echo HOSTNAME;?>style/js/laydate/laydate.js"></script>
<div class="main-inner">
	<p class="p-title">已付款</p>
	<div class="tool-bar">
		<form action="<?php echo HOSTNAME;?>admin/order/findHasPay" method="get">
			<label>开始日期</label>
			<input name="date_start" placeholder="请输入日期" class="laydate-icon" onclick="laydate({format:'YYYY-MM-DD hh:mm:ss'})" value="<?php echo $date_start;?>"/>
			<label>结束日期</label>
			<input name="date_end" placeholder="请输入日期" class="laydate-icon" onclick="laydate({format:'YYYY-MM-DD hh:mm:ss'})" value="<?php echo $date_end;?>"/>
			<label>姓名</label>
			<input name="name" value="<?php echo $name;?>"/>
			<button>确定</button>
		</form>
	</div>
	<table class="p-table">
		<thead>
			<th>订单号</th>
			<th>姓名</th>
			<th>地址</th>
			<th>应付款</th>
			<th>日期</th>
		</thead>
		<tbody>
			<?php if(!empty($orders)){
				foreach($orders as $key => $value){
			?>
			<tr>
				<td>
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
			</tr>
			<?php }} ?>
		</tbody>
	</table>
	<?php
		echo $pagination;
	?>
</div>
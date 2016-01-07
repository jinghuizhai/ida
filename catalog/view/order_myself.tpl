<script type="text/javascript" src="<?php echo HOSTNAME;?>style/js/laydate/laydate.js"></script>
<div class="main-inner">
	<p class="p-title">我的订单</p>
	<table class="p-table">
		<thead>
			<th>订单号</th>
			<th>付款</th>
			<th>地址</th>
			<th>日期</th>
		</thead>
		<tbody>
			<?php
				if(!empty($orders)){
				foreach($orders as $key => $value){
			?>
			<tr>
				<td>
					<a onclick="requestProductInfo(<?php echo $value['order_id'];?>)" class="blue">
					<?php echo $value['order_code'];?>
					</a>
				</td>
				<td>
					<?php echo $value['money'];?>
				</td>
				<td>
					<?php echo $value['address'];?>
				</td>
				<td>
					<?php echo $value['date'];?>
				</td>
			</tr>
			<?php }} ?>
		</tbody>
	</table>
	<?php echo $pagination;?>
</div>
<script type="text/javascript">
	function requestProductInfo(order_id){
		// alert(order_id);
		zjh.POST("<?php echo HOSTNAME;?>order/jsonProductInfo",{'order_id':order_id},function(r){
			if(r){
				r = eval("("+r+")");
				var html = "";
				r.forEach(function(ele){
					html += ele.name+"x"+ele.piece+",价格："+ele.price+"￥"+"邮费:"+ele.postage+"￥";
				});
				zjh.pop('订单详细信息',html);
			}else{
				alert('对不起没有此订单信息');
			}
		});
	}
</script>
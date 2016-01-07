<div class="container">
	<h1 class="mt20">结账<small class="f12">已经为您生成账单</small></h1>
	<div class="create-order">
		<div class="p20">
			<h2 class="mb20">
				<i class="icon iconfont qingdan">&#xe656;</i>(清单)
			</h2>
			<?php if(!empty($products)){
				foreach($products as $key => $value){
			?>
			<p><?php echo $value['name'];?>&nbsp;x&nbsp;<?php echo $value['piece'];?></p>
			<?php }} ?>
			<div class="total-money">
				共计：<?php echo $order['money'];?>￥
			</div>
		</div>
	</div>
	<form id="submit-order" action="<?php echo HOSTNAME;?>checkout/<?php echo $payway;?>" method="post">
		<?php if(!empty($paycode)){ ?>
			<input type="hidden" name="paycode" value="<?php echo $paycode;?>"/>
		<?php } ?>
		<input type='hidden' name="WIDout_trade_no" value="<?php echo $order['order_code'];?>" />
		<input type='hidden' name="WIDsubject" value="<?php echo $order['subject'];?>" />
		<input type='hidden' name="WIDtotal_fee" value="<?php echo $order['money'];?>" />
		<input type='hidden' name="WIDbody" value="<?php echo $order['body'];?>" />
		<input type='hidden' name="WIDshow_url" value="<?php echo $order['url'];?>" />
		<button class="btn b-green r" onclick="return checkoutPay(this)">
			<span class='loading dn' id="loading"></span>支付
		</button>
	</form>
</div>
<script type="text/javascript">
	function checkoutPay(othis){
		var loading = zjh.get('loading');
		zjh.showi(loading);
		othis.disabled = true;
		// return true;
		zjh.get('submit-order').submit();
	}
</script>
<div class="main-inner">
	<p class="p-title">提现记录</p>
	<?php if(!empty($historys)){ 
		foreach($historys as $key => $value){
	?>
		<p class="amount-history">
			您在：<?php echo $value['date']?>
			兑换积分<?php echo $value['score']?>
			为
			<?php echo $value['money']?>￥
		</p>
	<?php }}else{
		echo "<p>您暂没有提现记录</p>";
	} ?>
	<?php echo $pagination;?>
</div>
<div class="">
	<p class="p-title">银行账户</p>
	<div class="form-group">
		<form action="<?php echo HOSTNAME;?>user/bank" method="post">
			<div class="p-group">
				<b>银行</b>
				<input type="text" name="bank" />
			</div>
			<div class="p-group">
				<b>账户</b>
				<input type="text" name="bank" />
			</div>
			<!-- <div class="p-group">
				<b>短信</b>
				<input name="sms" id="sms" />
				<a id="btn-get-sms" class="btn b-green" href="javascript:;" onclick="getSms();">
					<span class="loading dn" id="loading"></span>
					<span id="a-btn-content">获取短信验证码</span>
				</a>
			</div> -->
			<button class="btn" onclick="return checkBank(this)">确定</button>
		</form>
	</div>
</div>
<script type="text/javascript">
	function checkBank(othis){
		alert('正在紧张升级程序，暂时不能添加银行账户，静候佳音！');
	}
</script>
<div class="container mt20">
	<div class="register">
		<div class="login-title">
			<h1>注销自己(请慎用)</h1>
		</div>
		<small>
			当您注销自己后，您的所有信息都会消失
		</small>
		<div class="login">
			<div class="inner">
				<p class="red mb10" id="login-info"></p>
				<!-- <form action="<?php echo HOSTNAME;?>user/cancelMyself" method="post" id="formregister"> -->
					<div class="input-group">
						<b>验证码</b>
						<input name="code" id="code"/>
						<div class="codeimg">
							<a href="javascript:;" id="not-clear" onclick="reflushCode();">看不清？</a>
							<img data-src="<?php echo HOSTNAME;?>code.php" src="<?php echo HOSTNAME;?>code.php" id="codeimg" onclick="reflushCode();"/>
						</div>
					</div>
					<div class="input-group">
						<b>短信</b>
						<input name="sms" id="sms" />
						<a id="btn-get-sms" class="btn b-green" href="javascript:;" onclick="getSms();">
							<span class="loading dn" id="loading2"></span>
							<span id="a-btn-content">获取短信验证码</span>
						</a>
					</div>
					<p class="login-plus">
						<button class="btn" onclick="checkCancel(this);">我要注销我自己</button>
						<span id="loading" class="loading dn"></span>
					</p>
				<!-- </form> -->
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

	function reflushCode(){
		var img = zjh.get('codeimg');
		img.src = img.getAttribute('data-src')+"?v="+Math.random();
	}

	function getSms(){
		var loading = zjh.get('loading2'),
			info = zjh.get('login-info'),
			code = zjh.get('code').value.trim(),
			span = zjh.get('a-btn-content');

		if(!zjh.validate('code',code)){
			info.innerHTML = '验证码格式不正确';
			return;
		}
		zjh.POST('<?php echo HOSTNAME;?>user/sendCancelSms',{'code':code},function(r){
			if(r) r = eval("("+r+")");
			if(r.tag == 'success'){
				span.innerHTML = '已经发送，请输入验证码';
			}else if(r.tag == 'fail'){
				alert(r.info);
			}
		});
	}
	function checkCancel(othis){
		var loading = zjh.get('loading'),
			info = zjh.get('login-info'),
			code = zjh.get('code').value.trim(),
			sms = zjh.get('sms').value.trim();

		if(!zjh.validate('code',code)){
			info.innerHTML = '验证码格式不正确';
			return false;
		}
		if(!zjh.validate('sms',sms)){
			info.innerHTML = '短信格式不正确';
			return false;
		}
		othis.disabled = true;
		zjh.showi(loading);
		zjh.POST("<?php echo HOSTNAME;?>user/cancelMyself",{
			'code':code,
			'sms':sms
		},function(r){
			if(r) r = eval("("+r+")");
			if(r.tag == 'success'){
				alert(r.info);
				window.location.href = r.url;
			}else if(r.tag == 'fail'){
				alert(r.info);
			}
			zjh.hide(loading);
		});
	}
</script>
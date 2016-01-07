<div class="container mt20">
	<div class="register">
		<div class="login-title">
			<h1>注册</h1>
		</div>
		<?php if(empty($invitationcode)){
			echo "<h2 class='mt10 register-warning'>对不起，您没有<a href='' class='blue'>邀请码</a>，不能注册</h2>";
		} ?>
		<?php if(!empty($invitationcode)){ ?>
		<div class="login">
			<div class="inner">
				<p class="red mb10" id="login-info"></p>
				<form action="<?php echo HOSTNAME;?>home/register" method="post" id="formregister">
					<div class="input-group">
						<b>手机</b>
						<input name="phone" id="phone"/>
					</div>
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
							<span id="a-btn-content" data-time="yes">获取短信验证码</span>
						</a>
					</div>
					<div class="input-group">
						<b>姓名</b>
						<input name="name" id="name" />
					</div>
					<div class="input-group">
						<b>密码</b>
						<input type="password" name="pass" id="pass"/>
					</div>
					<div class="input-group">
						<b>重复</b>
						<input type="password" name="pass" id="pass2"/>
					</div>
					<p class="login-plus">
						<button class="btn" onclick="return checkRegister(this);">注册</button>
						<span id="loading" class="loading dn"></span>
					</p>
				</form>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<?php if(!empty($invitationcode)){ ?>
<script type="text/javascript">
	function getSms(){
		var phone = zjh.get('phone').value.trim(),
			code = zjh.get('code').value.trim(),
			info = zjh.get('login-info'),
			loading = zjh.get('loading2'),
			btn = zjh.get('a-btn-content');
		if(btn.getAttribute('data-time').trim() == 'no'){
			alert('请于60秒后再发送');
			return;
		}
		btn.setAttribute('data-time','no');
		if(!zjh.validate('phone',phone)){
			info.innerHTML = "请输入正确的手机号";
			return;
		}
		if(!zjh.validate('code',code)){
			info.innerHTML = "请输入正确格式的图片验证码";
			zjh.get('codeimg').click();
			return;
		}
		zjh.showi(loading);

		zjh.POST("<?php echo HOSTNAME;?>home/getValidateCode",null,function(r){
			if(r.trim() == code){
				//send sms
				btn.innerHTML = '正在发送验证码';
				zjh.POST('<?php echo HOSTNAME;?>home/checkPhone',{'phone':phone},function(ret){
					ret = ret.trim();
					if(ret == 'success'){
						btn.innerHTML = '验证码已经发送,请等候约6秒';
						setTimeout(function(){
							btn.innerHTML = '获取短信验证码';
							btn.setAttribute('data-time','yes');
						},1000*60);
					}else if(ret == 'fail'){
						info.innerHTML = '由于网络原因，短信没有发送成功';
					}else{
						info.innerHTML = ret;
					}
					zjh.hide(loading);
				});
			}else{
				info.innerHTML = '请输入正确的验证码';
				zjh.get('codeimg').click();
			}
			zjh.hide(loading);
		});
	}
	function reflushCode(){
		var img = zjh.get('codeimg');
		img.src = img.getAttribute('data-src')+"?v="+Math.random();
	}
	function checkRegister(othis){
		othis.disabled = true;
		var phone = zjh.get('phone').value.trim(),
			pass = zjh.get('pass').value.trim(),
			pass2 = zjh.get('pass2').value.trim(),
			code = zjh.get('code').value.trim(),
			sms = zjh.get('sms').value.trim(),
			name = zjh.get('name').value.trim(),
			loading = zjh.get('loading'),
			info = zjh.get('login-info');

		if(!zjh.validate('phone',phone)){
			info.innerHTML = '手机号不符合要求';
			othis.disabled = false;
			return false;
		}
		if(!zjh.validate('code',code)){
			info.innerHTML = '图片验证码格式不正确';
			othis.disabled = false;
			return false;
		}
		if(!zjh.validate('sms',sms)){
			info.innerHTML = '短信验证码不正确';
			othis.disabled = false;
			return false;
		}
		if(!zjh.validate('name',name)){
			info.innerHTML = '姓名必须为2~4个中文字符';
			othis.disabled = false;
			return false;
		}
		if(!zjh.validate('pass',pass)){
			info.innerHTML = '密码为8~20个英文数字字符，可以包含_#%$@.特殊字符';
			othis.disabled = false;
			return false;
		}
		if(!zjh.validate('pass',pass2)){
			info.innerHTML = '重复密码为8~20个英文数字字符，可以包含_#%$@.特殊字符';
			othis.disabled = false;
			return false;
		}
		if(pass != pass2){
			info.innerHTML = '两次输入密码不同';
			othis.disabled = false;
			return false;
		}
		zjh.get('formregister').submit();		
	}
	zjh.get('phone').focus();
</script>
<?php } ?>
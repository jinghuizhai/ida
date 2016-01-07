<!doctype html>
<html lang="zh-CN" xml:lang="zh-CN">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<meta charset="UTF-8" />
	<title></title>
	<link rel="stylesheet" type="text/css" href="<?php echo HOSTNAME.'style/css/admin.css';?>" >
	<script type="text/javascript" src="<?php echo HOSTNAME.'style/js/zjhlib-1.0.js';?>"></script>
</head>
<body>
	<div id="hint">
		<?php
			echo getHint();
		?>
	</div>
	<div class="container">
		<div id="main-login">
			<div class="login">
				<div class="inner">
					<p id="login-info"></p>
					<form action="<?php echo HOSTNAME;?>admin/admin/login" method="post">
						<div class="input-group">
							<b>账号</b>
							<input type="text" name="email" id="email"/>
						</div>
						<div class="input-group">
							<b>密码</b>
							<input type="password" name="pass" id="pass"/>
						</div>
						<div class="input-group">
							<b>验证码</b>
							<input type="text" name="code" id="code"/>
							<div class="codeimg">
								<a href="javascript:;" id="not-clear" onclick="reflushCode('codeimg');">看不清？</a>
								<img data-src="<?php echo HOSTNAME;?>code.php" src="<?php echo HOSTNAME;?>code.php" id="codeimg" onclick="reflushCode(this.id);"/>
							</div>
						</div>
						<p class="login-plus">
							<button class="btn" onclick="return checkLogin(this);">登录</button>
						</p>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function reflushCode(id){
			var img = zjh.get(id);
			img.src = img.getAttribute('data-src')+"?v="+Math.random();
		}
		function checkLogin(othis){
			var email = zjh.get('email').value.trim(),
				pass = zjh.get('pass').value.trim(),
				code = zjh.get('code').value.trim(),
				info = zjh.get('login-info');

			if(!zjh.validate('email',email)){
				info.innerHTML = 'Email不符合要求';
				return false;
			}
			if(!zjh.validate('pass',pass)){
				info.innerHTML = '密码不符合要求';
				return false;
			}
			if(!zjh.validate('code',code)){
				info.innerHTML = '验证码不正确';
				return false;
			}
			// othis.parentNode.parentNode.submit();
			return true;
		}
		(function(){
			var hint = zjh.get('hint');
			if(hint){
				setTimeout(function(){
					zjh.hide(hint);
				},2000);
			}else{
				zjh.hide(hint);
			}
		})();
	</script>
</body>
</html>


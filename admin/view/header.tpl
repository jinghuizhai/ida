<!doctype html>
<html lang="zh-CN" xml:lang="zh-CN">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<meta charset="UTF-8" />
	<title>IDA管理系统</title>
	<link rel="stylesheet" type="text/css" href="<?php echo HOSTNAME.'style/css/admin.css';?>" >
	<script type="text/javascript" src="<?php echo HOSTNAME.'style/js/zjhlib-1.0.js';?>"></script>
</head>
<body>
<div id="hint">
	<?php
		echo getHint();
	?>
</div>
<?php include('menu.tpl');?>
<div id="main">
	<div id="header">
		<div class="logout">
			<a href="<?php echo HOSTNAME;?>user">商城首页</a>
			<a href="<?php echo HOSTNAME;?>admin/admin/logout">注销</a>
			<a onclick="howCancel(this)">如何注销</a>
		</div>
	</div>
	<div class="main-inner">
	<script type="text/javascript">
		function howCancel(othis){
			var r = prompt('请输入密码','密码');
			if(r == '删除'){
				alert('会员删除自己，将会失去在本站所有的资料，包括积分和订单。请慎用删除自己功能。如果确实存在此需要，请会员在登录状态下访问<?php echo HOSTNAME;?>user/cancelMyself页面。请保密此页面');
			}else{
				alert('错误');
			}
		}
	</script>
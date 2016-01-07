<!doctype html>
<html lang="zh-CN" xml:lang="zh-CN">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<meta charset="UTF-8" />
	<title>IDA账户管理</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<link rel="stylesheet" type="text/css" href="<?php echo HOSTNAME.'style/css/front_admin.css';?>" >
	<link rel="stylesheet" type="text/css" href="<?php echo HOSTNAME;?>style/iconfont/front/iconfont.css" />
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
		<div class="identity c9">
			你好,<?php echo $session['user']['name'];?>,<?php echo $session['user']['rname'];?>
		</div>
		<div class="logout">
			<a href="<?php echo HOSTNAME;?>home"><i class="icon iconfont">&#xe6b2;</i>商城首页</a>
			<a href="<?php echo HOSTNAME;?>home/logout"><i class="icon iconfont">&#xe698;</i>注销</a>
		</div>
	</div>
	<div id="mobil-header" class="fix">
		<ul>
			<li>
				<a href="<?php echo HOSTNAME;?>home"><i class="icon iconfont">&#xe6b2;</i></a>
			</li>
			<li ontouchend="toggleMenu(this)">
				<a><i class="icon iconfont">&#xe667;</i></a>
			</li>
			<li>
				<a href="<?php echo HOSTNAME;?>home/logout"><i class="icon iconfont">&#xe698;</i></a>
			</li>
		</ul>
	</div>
	<div class="main-inner">

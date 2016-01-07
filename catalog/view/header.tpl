<!doctype html>
<html lang="zh-CN" xml:lang="zh-CN">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<meta charset="UTF-8" />
	<title><?php echo $title;?></title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<meta name="description" content="<?php echo $description;?>" />
	<meta name="keywords" content="<?php echo $keywords;?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo HOSTNAME.'style/css/common.css';?>" >
	<script type="text/javascript" src="<?php echo HOSTNAME.'style/js/zjhlib-1.0.js';?>"></script>
	<link rel="shortcut icon"  type="image/x-icon" href="<?php echo HOSTNAME;?>style/imgs/favicon.ico" />
	<script type="text/javascript">
		(function(){
			if(zjh.isphone()){
				var link = document.createElement('link');
				link.setAttribute('rel','stylesheet');
				link.setAttribute('type','text/css');
				link.setAttribute('href',"<?php echo HOSTNAME.'style/css/mobil.css';?>");
				document.getElementsByTagName('head')[0].appendChild(link);
			}
		})();
	</script>
</head>
<body>
	<div id='hint'>
		<?php echo getHint();?>
	</div>
	<!-- 移动端菜单 -->
	<div class="mobil-nav-ul" id="mobil-nav-ul">
		<b id="closeMenu" class="close-icon" ontouchend="zjh.hide(zjh.get('mobil-nav-ul'))">×</b>
		<ul>
			<!--
			<?php
				if(!empty($catalogs)){
					foreach($catalogs as $value){
			?>			
				<li>
					<a href="<?php echo HOSTNAME.'catalog/'.$value['catalog_id'];?>"><?php echo $value['name'];?></a>
				</li>
			<?php }} ?>
			-->
			<li>
				<a href="<?php echo HOSTNAME.'product/1';?>">男士腕表</a>
			</li>
			<li>
				<a href="<?php echo HOSTNAME.'product/2';?>">女士腕表</a>
			</li>
			<li>
				<a href="<?php echo HOSTNAME.'product/3';?>">情侣腕表</a>
			</li>
			<li>
				<a href="<?php echo HOSTNAME.'product/4';?>">超值厨具</a>
			</li>
			<li>
				<a target="_blank" href="http://192.168.10.35/idablog/">关于我们</a>
			</li>
		</ul>
	</div>
	<div id="header" class="fix">
		<div>
			<div class="logo">
				<div class="mobil-nav" ontouchend="zjh.show(zjh.get('mobil-nav-ul'))">
					<i class="icon iconfont">&#xe667;</i>
				</div>
				<a href="<?php echo HOSTNAME;?>home">
					<img src="<?php echo HOSTNAME;?>style/imgs/logo.png" id="header-logo"/>
				</a>
				<div id="nav-cart">
					<div class="cart-icon">
						<div id="zjh-icon">
							<i class="icon iconfont icart">&#xe66f;</i>
							<span id="cart-goods-num">0</span>
						</div>
						<!-- 购物车详细信息 begin -->
						<div class="cart-inner" id="cart-inner">
							<div id="cart-info">
								<div class="cart-info">
									<div class="cart-info-item fix">
										<div class="product-info">
											<p>{{name}}</p>
											<p>
												<span class="red">{{price}}￥</span>
												<span class="c9 f12">×{{pieces}}件</span>
											</p>
											<p>
												<a onclick="deleteProduct(this)" class="delete-goods" data-id="{{product_id}}">×</a>
											</p>
										</div>
										<div class="product-image">
											<a href="<?php echo HOSTNAME;?>product/{{product_id}}">
											<img src="<?php echo IMG;?>{{thumbnail}}" />
											</a>
										</div>
									</div>
								</div>
							</div>
							<div id="price-info">
								<div class="cart-total fix">
									<span class="l">商品:</span>
									<span class="l">{{price}}<span class="f12 c9">￥</span></span>
									<span class="l">邮费:</span>
									<span class="l">{{postage}}<span class="f12 c9">￥</span></span>
									<span class="r">总计:<span class="red">{{total}}</span><span class="f12 c9">￥</span></span>
								</div>
							</div>
							<div class="checknow">
								<a href="<?php echo HOSTNAME;?>home/productList">购物车</a>
							</div>
						</div>
						<!-- 购物车详细信息 end -->
					</div>
				</div>
			</div>
			<div id="nav">
				<div class="container rel">
					<ul class="list-none nav-list">
						<!--
						<?php
							if(!empty($catalogs)){
								foreach($catalogs as $value){
						?>			
							<li>
								<a href="<?php echo HOSTNAME.'catalog/'.$value['catalog_id'];?>"><?php echo $value['name'];?></a>
							</li>
						<?php }} ?>
						-->
						<li>
							<a href="<?php echo HOSTNAME.'product/1';?>">男士腕表</a>
						</li>
						<li>
							<a href="<?php echo HOSTNAME.'product/2';?>">女士腕表</a>
						</li>
						<li>
							<a href="<?php echo HOSTNAME.'product/3';?>">情侣腕表</a>
						</li>
						<li>
							<a href="<?php echo HOSTNAME.'product/4';?>">超值厨具</a>
						</li>
						<li>
							<a target="_blank" href="http://192.168.10.35/idablog/">关于我们</a>
						</li>
					</ul>
					<div class="nav-login fix">
						<?php if(empty($session['user'])){ ?>
						<a href="<?php echo HOSTNAME;?>home/register"><i class="icon iconfont">&#xe61a;</i>注册</a>
						<?php } ?>
						<?php if(empty($session['user'])){ ?>
						<a href="<?php echo HOSTNAME;?>home/login"><i class="icon iconfont">&#xe633;</i>登录</a>
						<?php } ?>
						<?php if(!empty($session['user'])){ ?>
						<a href="<?php echo HOSTNAME;?>home/logout"><i class="icon iconfont">&#xe698;</i>注销</a>
						<?php } ?>
						<?php if(!empty($session['user'])){ ?>
						<a href="<?php echo HOSTNAME;?>user/dashboard"><i class="icon iconfont">&#xe68c;</i>管理</a>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	

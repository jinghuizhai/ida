<div class="">
	<?php if(!empty($broadcasts)){ ?>
	<div class="broadcast">
		<div class="broadcast-inner fix">
			<div class="broadcast-info">
				<p class="tc mb10">
					<i class="icon iconfont">&#xe638;</i>
				</p>
				<?php foreach ($broadcasts as $key => $value) { ?>
					<p>
						<?php echo $value['content']; ?>
					</p>			
				<?php } ?>
			</div>
			<div class="broadcast-icon">
				<i class="icon iconfont">&#xf00fa;</i>
				<h2 class="mt10"><?php echo format(timenow());?></h2>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php if(!empty($user['link'])){ ?>
	<div class="img-links">
		<ul class="fix">
			<li>
				<div class="img-links-title">
					永久邀请注册链接
				</div>
				<div class="img-links-inner">
					<div class="img-links-block">
						<?php echo HOSTNAME;?>home/register/<?php echo $user['link'];?>
					</div>
				</div>
			</li>
			<li>
				<div class="img-links-title">
					永久注册二维码
				</div>
				<div class="img-links-inner">
					<a href="<?php echo HOSTNAME.'qcode/'.$user['linkimg'];?>" target="_blank">
						<img src="<?php echo HOSTNAME.'qcode/'.$user['linkimg'];?>" />
					</a>
				</div>
			</li>
			<li class="mr0">
				<div class="img-links-title">
					带LOGO
				</div>
				<div class="img-links-inner">
					<a href="<?php echo HOSTNAME.'qcode/'.$user['logoimg'];?>" target="_blank">
						<img src="<?php echo HOSTNAME.'qcode/'.$user['logoimg'];?>" />
					</a>
				</div>
			</li>
		</ul>
	</div>
	<?php } ?>
	<div class="dashboard-data">
		<ul class="fix">
			<li>
				<div class="data-inner b-green">
					<h2>您推荐的订单数为：<span  id="recommend"></span></h2>
				</div>
			</li>
			<li>
				<div class="data-inner b-red">
					<h2>您推荐的会员数为：<span  id="users"></span></h2>
				</div>
			</li>
			<li class="mr0">
				<div class="data-inner b-pink">
					<h2>您的积分为：<span  id="score"></span></h2>
				</div>
			</li>
		</ul>
	</div>
</div>
<script type="text/javascript">
	zjh.POST('<?php echo HOSTNAME;?>order/countRecommend',{r:'abc'},function(r){
		if(r) r = r.trim();
		zjh.get('recommend').innerHTML = r;
	});
	zjh.POST('<?php echo HOSTNAME;?>user/countUsers',{r:'abc'},function(r){
		if(r) r = r.trim();
		zjh.get('users').innerHTML = r;
	});
	zjh.POST('<?php echo HOSTNAME;?>amount/countScore',{r:'abc'},function(r){
		if(r) r = r.trim();
		zjh.get('score').innerHTML = r;
	});
</script>
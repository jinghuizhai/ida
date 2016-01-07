<div id="menu">
	<div class="dash-title">
		<a href="<?php echo HOSTNAME;?>user/dashboard"><i class="icon iconfont">&#xe6b2;</i>IDA账号管理首页</a>
	</div>
	<div class="inner">
		<?php if($session['user']['tag'] == 'branch'){ ?>
		<dl>
			<dt>管理会员</dt>
			<dd><a href="<?php echo HOSTNAME;?>user/addSale">添加业务员</a></dd>
		</dl>
		<?php } ?>
		<dl>
			<dt>订单管理</dt>
			<dd><a href="<?php echo HOSTNAME;?>order/recommend">我推荐的订单</a></dd>
			<dd><a href="<?php echo HOSTNAME;?>order/myself">我自己的订单</a></dd>
		</dl>
		<dl>
			<dt>我推荐的会员</dt>
			<dd><a href="<?php echo HOSTNAME;?>user/find">所有会员</a></dd>
		</dl>
		<?php if($session['user']['tag'] != 'branch'){ ?>
		<dl>
			<dt>积分管理</dt>
			<dd><a href="<?php echo HOSTNAME;?>amount">我的积分</a></dd>
			<dd><a href="<?php echo HOSTNAME;?>cashoutHistory">我的提现记录</a></dd>
		</dl>
		<?php } ?>
		<dl>
			<dt>账户管理</dt>
			<dd><a href="<?php echo HOSTNAME;?>user/updatePass">修改密码</a></dd>
			<dd><a href="<?php echo HOSTNAME;?>user/updateName">修改名称</a></dd>
			<?php if($session['user']['tag'] != 'branch'){ ?>
			<dd><a href="<?php echo HOSTNAME;?>user/bank">银行账户</a></dd>
			<?php } ?>
		</dl>
		<dl>
			<dt>地址管理</dt>
			<dd><a href="<?php echo HOSTNAME;?>address">地址</a></dd>
			<dd><a href="<?php echo HOSTNAME;?>address/add">添加地址</a></dd>
		</dl>
	</div>
</div>

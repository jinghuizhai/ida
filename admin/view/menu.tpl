<div id="menu">
	<div class="dash-title">
		<a href="<?php echo HOSTNAME;?>admin/admin/dashboard">IDA管理系统</a>
	</div>
	<div class="inner">
		<dl>
			<dt>统计分析</dt>
			<dd><a href="<?php echo HOSTNAME;?>admin/order/findHasPay">付款订单</a></dd>
			<dd><a href="<?php echo HOSTNAME;?>admin/order/findNotPay">未付款订单</a></dd>
		</dl>
		<dl>
			<dt>商品管理</dt>
			<dd><a href="<?php echo HOSTNAME;?>admin/catalog/update">所有分类</a></dd>
			<dd><a href="<?php echo HOSTNAME;?>admin/catalog/add">添加分类</a></dd>
			<dd><a href="<?php echo HOSTNAME;?>admin/product">所有商品</a></dd>
			<dd><a href="<?php echo HOSTNAME;?>admin/product/add">添加商品</a></dd>
		</dl>
		<dl>
			<dt>属性设置</dt>
			<dd><a href="<?php echo HOSTNAME;?>admin/attr/add">添加属性</a></dd>
			<dd><a href="<?php echo HOSTNAME;?>admin/attr">所有属性</a></dd>
			<dd><a href="<?php echo HOSTNAME;?>admin/attr_group">所有属性组</a></dd>
			<dd><a href="<?php echo HOSTNAME;?>admin/attr_group/add">添加属性组</a></dd>
		</dl>
		<dl>
			<dt>图库</dt>
			<dd><a href="<?php echo HOSTNAME;?>admin/img">所有图片</a></dd>
		</dl>
		<dl>
			<dt>会员管理</dt>
			<dd><a href="<?php echo HOSTNAME;?>admin/user">所有会员</a></dd>
			<dd><a href="<?php echo HOSTNAME;?>admin/user/addBranch">添加分公司</a></dd>
			<dd><a href="<?php echo HOSTNAME;?>admin/user/addSale">添加业务员</a></dd>
			<dd><a href="<?php echo HOSTNAME;?>admin/user/addAgent">添加代理</a></dd>
			<dd><a href="<?php echo HOSTNAME;?>admin/user/addSubagent">添加分代理</a></dd>
			<dd><a href="<?php echo HOSTNAME;?>admin/user/addSubadmin">添加分管理员</a></dd>
			<dd><a href="<?php echo HOSTNAME;?>admin/user/subadmin">所有分管理员</a></dd>
		</dl>
		<dl>
			<dt>角色管理</dt>
			<dd><a href="<?php echo HOSTNAME;?>admin/role">所有角色</a></dd>
			<dd><a href="<?php echo HOSTNAME;?>admin/role/add">添加角色</a></dd>
		</dl>
		<dl>
			<dt>评论管理</dt>
			<dd><a href="<?php echo HOSTNAME;?>admin/comment/notreply">未回复</a></dd>
			<dd><a href="<?php echo HOSTNAME;?>admin/comment/hasreply">已回复</a></dd>
			<dd><a href="<?php echo HOSTNAME;?>admin/comment">所有评论</a></dd>
		</dl>
		<dl>
			<dt>账户设置</dt>
			<dd><a href="<?php echo HOSTNAME?>admin/admin/update">更新信息</a></dd>
			<dd>访问记录</dd>
		</dl>
		<dl>
			<dt>广播</dt>
			<dd><a href="<?php echo HOSTNAME?>admin/broadcast">所有广播</a></dd>
			<dd><a href="<?php echo HOSTNAME?>admin/broadcast/add">添加广播</a></dd>
		</dl>
		<dl>
			<dt>提现审核</dt>
			<dd><a href="<?php echo HOSTNAME?>admin/cashoutHistory/notCheck">未审核请求</a></dd>
			<dd><a href="<?php echo HOSTNAME?>admin/cashoutHistory/hasCheck">已审核请求</a></dd>
		</dl>
	</div>
</div>
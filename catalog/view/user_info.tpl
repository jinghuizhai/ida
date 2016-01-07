<div class="user-info-page">
	<p class="p-title">用户信息</p>
	<div class="b-green p10">
		<?php if(!empty($user)){ ?>
		<p>
			姓名：<?php echo $user['name'];?>
		</p>
		<p>
			电话：<?php echo $user['phone'];?>
		</p>
		<p>
			角色：<?php echo $user['rname'];?>
		</p>
		<p>
			链接：<a class="blue" target="_blank" href="<?php echo HOSTNAME.'home/register/'.$user['link'];?>"><?php echo $user['link'];?></a>
		</p>
		<p>
			二维码：
			<a href="<?php echo HOSTNAME.'qcode/'.$user['linkimg'];?>" target="_blank">
				<img src="<?php echo HOSTNAME.'qcode/'.$user['linkimg'];?>" />
			</a>
			<a href="<?php echo HOSTNAME.'qcode/'.$user['logoimg'];?>" target="_blank">
				<img src="<?php echo HOSTNAME.'qcode/'.$user['logoimg'];?>" />
			</a>
		</p>
		<p>
			开户银行：<?php echo empty($user['paybank'])?'暂时未填写':$user['paybank'];?>
		</p>
		<p>
			银行账号：<?php echo empty($user['paycount'])?'暂时未填写':'已填写';?>
		</p>
		<p>
			注册日期：<?php echo $user['date'];?>
		</p>
		<?php }else{
			echo '<p>信息为空</p>';
		} ?>
	</div>
	<!-- <div class="b-yellow mt10 p10">
		<p>
			地址
		</p>
		<?php if(!empty($addresses)){
			foreach($addresses as $key => $value){
		?>
			<p>
				<?php echo ($key+1).":".$value['province'].$value['city'].$value['area'].$value['zip'].$value['detail'];?>
			</p>
		<?php }}else{
			echo '<p>信息为空</p>';
		} ?>
	</div> -->
	<div class="b-red mt10 p10">
		<p>此用户购买产生订单：</p>
		<?php if(!empty($orders)){
			foreach($orders as $key => $value){
		?>
			<p>
				<?php echo ($key+1).":".$value['order_code'].",".$value['money']."￥,".$value['date'];?>
			</p>
		<?php }}else{echo '<p>暂无订单</p>';} ?>
	</div>
	<div class="b-pink mt10 p10">
		<p>此用户一共推荐订单：</p>
		<?php echo empty($rcount)?0:$rcount;?>
	</div>

</div>
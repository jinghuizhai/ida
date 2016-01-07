<div class="goods-catalog">
	<div class="container fix">
		<?php
			if(!empty($products)){
				foreach($products as $key => $value){
		?>
			<div class="goods-single">
				<div class="inner">
					<b class="single-likes" data-tag='0' onclick="productHitLikes(<?php echo $value['product_id']?>,this)"><i class="icon iconfont">&#xe658;</i><?php echo $value['likes'];?></b>
					<div class="tc single-thumbnail">
						<a href="<?php echo HOSTNAME.'product/'.$value['product_id'];?>">
							<img src="<?php echo IMG.$value['iname'];?>" />
						</a>
					</div>
					<div class="single-info">
						<p class="single-name">
							<?php echo $value['name'];?>
						</p>
						<p class="single-price">
							<?php echo $value['price'];?><small>￥</small>
						</p>
					</div>
				</div>
			</div>
		<?php
			}}else{
		?>
		<div class="sorry">
			<h1>对不起，这个页面没有商品</h1>
			<p>
				<span class="loading"></span>
				<span id="redirect-tag" class="blue" data-num="3">3</span>
				秒后跳转到首页
			</p>
		</div>		
		<script type="text/javascript">
			void function(){
				setTimeout(function(){
					var red = zjh.get('redirect-tag');
					var num = red.getAttribute('data-num');
					num = num - 1;
					red.setAttribute('data-num',num);
					red.innerHTML = num;
					if(num > 0){
						setTimeout(arguments.callee,1000);
					}else{
						window.location.href = "<?php echo HOSTNAME;?>home";
					}
				},1000);
			}();
		</script>
		<?php } ?>
	</div>
</div>
<script type="text/javascript">
	function productHitLikes(product_id,othis){
		if(othis.getAttribute('data-tag') == 0){
			hitLikes(product_id,function(r){
				othis.innerHTML = '<i class=\'icon iconfont\'>&#xe658;</i>'+r;
				othis.setAttribute('data-tag',1);
			})
		}else{
			alert('谢谢，您已经点赞');
		}
	}
</script>
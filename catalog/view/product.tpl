<div class="container">
	<?php if(!empty($product)){ ?>
	<div class="buy-main fix">
		<div class="goods-small">
			<ul id="goods-small">
				<?php 
					foreach($imgs as $key => $value){
						$class = "";
						if($key == 0){
							$class = "active";
						}
				?>
					<li class="<?php echo $class;?>">
						<img data-src="<?php echo IMG.$value['name'];?>" src="<?php echo IMG.$value['thumbnail'];?>" />
					</li>
				<?php } ?>
			</ul>
		</div>
		<div class="goods-main">
			<div class="inner">
				<img src="<?php echo IMG.$imgs[0]['name'];?>" id="goods-main"/>
			</div>
		</div>
		<div class="goods-info">
			<div class="goods-name">
				<h1><?php echo $product['name'];?></h1>
			</div>
			<p class="mb20 c9 free_postage_icon">
				<i class="icon iconfont">&#xe66d;</i>
				<?php if(empty($product['free_postage'])){
					echo '免运费';
				}else{
					echo '需要收取运费'.$product['postage'].'￥';
				} ?>
				<span class='f12 blue remote rel'>
					偏远地区<?php echo $product['postage_remote'];?>￥<i class="icon iconfont">&#xe643;</i>
					<span class="remote-content">
						偏远地区包括内蒙古、青海、宁夏、甘肃、广西、海南(新疆、西藏地区暂无法提供配送，请谅解)
					</span>
				</span>
			</p>
			<p>
				
			</p>
			<div class="goods-price">
				<div class="fix">
					<span class='l'><?php echo $product['price'];?><small>￥</small></span>
					<span class="goods-stock l">
						<?php if(!empty($product['stock'])){
							echo '现在有货';
						}else{
							echo '现在缺货';
						} ?>
					</span>
					<div class="set-count"  onselectstart="return false" style="-moz-user-select:none;">
						<label>数量</label>
						<span class="product-add" onclick="addProduct(this,event)">
							<i class="icon iconfont">&#xe634;</i>
						</span>
						<input name="product-count" value="1" id="product-count" disabled="disabled" />
						<span class="product-sub" onclick="subProduct(this,event)" >
							<i class="icon iconfont">&#xe635;</i>
						</span>
					</div>
				</div>
			</div>
			<div class="goods=attr">

			</div>
			<div class="goods-buy fix">
				<span class="goods-cart">
					<a href="javascript:;" onclick="addToCart(this)" data-product="<?php echo $product['product_id'];?>">
						<i class="icon iconfont icart">&#xe66f;</i>
						加入购物车
					</a>
				</span>
				<span class="goods-likes" data-tag="0" onclick="productPageHitLikes(<?php echo $product['product_id']?>,this)">
					<a>
						<i class="icon iconfont icart">&#xe658;</i>
						<span id="product-likes-btn"><?php echo $product['likes'];?></span>人喜欢
					</a>
				</span>
			</div>
			<div class="goods-feedback">
				<span class="goods-comment">
				<?php echo $count_comments;?>个评价
				</span>
				<span class="goods-stars">
				4.5星
				</span>
			</div>
			<p class="goods-more">
				<a href="<?php echo HOSTNAME;?>catalog/<?php echo $product['catalog_id'];?>"><i class="icon iconfont icart">&#x3432;</i>查看相似商品</a>
			</p>
		</div>
	</div>
</div>
<div class="detail-nav" id="detail-nav">
	<div class="container rel">
		<div class="nav-thumbnail dn" id="nav-thumbnail">
			<img src="<?php echo IMG.$imgs[0]['thumbnail'];?>" />
			<div class="nav-thumbnail-name">
				<p><?php echo $product['name'];?></p>
				<p><b class="red"><?php echo $product['price'];?></b>￥</p>
			</div>
		</div>
		<span class="active">
			<a href="#goods-detail-title">产品详情</a>
		</span>
		<span>
			<a href="#goods-params-title">规格参数</a>
		</span>
		<span>
			<a href="#goods-comments-list-title">新鲜评论</a>
		</span>
		<span>
			<a href="#goods-comments-title">我要评论</a>
		</span>
	</div>
</div>
<div class="goods-desc">
	<div class="container">
		<div class="goods-title" id='goods-detail-title'>
			<h2>产品详情</h2>
		</div>
		<div id="goods-detail">
			<?php
				echo html_entity_decode($product['detail']);
			?>
		</div>
		<div class="goods-title" id="goods-params-title">
			<h2>规格参数</h2>
		</div>
		<div id="goods-params" class="fix">
			<div class="goods-params-img">
				<img src="<?php echo IMG.$imgs[0]['name'];?>" />
			</div>
			<ul>
				<?php if(!empty($attrs)){
					foreach($attrs as $key => $value){
						echo "<li>".$value['name'].":".$value['value']."</li>";
					}
				} ?>
			</ul>
		</div>
		<div class="goods-title" id="goods-comments-list-title">
			<h2>新鲜评论</h2>
		</div>
		<div id="goods-comments-list">
			<div class="comments-inner" id="goods-comments-list-inner">
			</div>
		</div>
		<a class="view-more" onclick="viewMore(this);" id="viewMore">查看更多评论</a>
		<div class="goods-title" id="goods-comments-title">
			<h2>快来评论</h2>
		</div>
		<div id="goods-comments">
			<div class="comment-face" id="comment-face">
				<span class="active" data-stars="5" onclick="changeFace(this);">
					<i class="icon iconfont">&#xe653;</i>
				</span>
				<span data-stars="3" onclick="changeFace(this);">
					<i class="icon iconfont">&#xe64b;</i>
				</span>
			</div>
			<input type="hidden" name="stars" value="5" id="comment-stars"/>
			<input type="hidden" name="product_id" id="product_id_comment" value="<?php echo $product['product_id'];?>" />
			<textarea id="comments-textarea" name="content"></textarea>
			<button class="btn b-green add-comment-btn" onclick="checkComment(this);"><i class="icon iconfont">&#xe61b;</i></button>
		</div>
	</div>
</div>

<script type="text/javascript">
	function productPageHitLikes(product_id,othis){
		if(othis.getAttribute('data-tag') == 0){
			hitLikes(product_id,function(r){
				zjh.get('product-likes-btn').innerHTML = r;
				othis.setAttribute('data-tag',1);
			})
		}else{
			alert('谢谢，您已经点赞');
		}
	}
	function checkComment(othis){
		var stars = zjh.get('comment-stars').value,
			product_id = zjh.get('product_id_comment').value,
			content = zjh.get('comments-textarea').value.trim();
		if(content.length < 1){
			alert('评论不能为空');
			return;
		}
		zjh.POST('<?php echo HOSTNAME;?>comment/add',{
			'stars':stars,
			'product_id':product_id,
			"content":content
		},function(r){
			r = eval("("+r+")");
			if(r.fail){
				alert(r.fail);
			}else if(r.content){
				var comment = zjh.get('goods-comments-list-inner');
				comment.innerHTML = comment.innerHTML+r.content;
				zjh.get('comments-textarea').value = null;
				alert('感谢您的评论');
			}
		});
	}
	function initThumbnail(){
		var goods = zjh.get('goods-small'),
			lis = goods.getElementsByTagName('li'),
			mainimg = zjh.get('goods-main'),
			active = 0;
		for(var i = 0,len = lis.length;i<len;i++){
			(function(i){
				lis[i].onclick = function(){
					zjh.removeClass(lis[active],'active');
					zjh.addClass(this,'active');
					mainimg.src = zjh.first(this).getAttribute('data-src');
					active = i;
				};
			})(i);
		}
	}
	function changeFace(othis){
		var face = zjh.get('comment-face'),
			spans = face.getElementsByTagName('span'),
			stars = zjh.get('comment-stars');
			
		stars.value = othis.getAttribute('data-stars');
		zjh.removeClass(spans,'active');
		zjh.addClass(othis,'active');
	}
	//商品增加或减少数量
	function addProduct(othis,e){
		var input = zjh.get('product-count');
		if(input.value){
			input.value = parseInt(input.value)+1;
		}else{
			input.value = 1;
		}
	}
	function subProduct(othis,e){
		var input = zjh.get('product-count');
		if(input.value){
			var val = parseInt(input.value)-1;
			if(val < 1){
				input.value = 1;
			}else{
				input.value = val;
			}
		}else{
			value = 1;
		}
	}
	function addToCart(othis){
		var days = 30;
		var product_id = othis.getAttribute('data-product');
		var count = zjh.get('product-count').value;
		var cart = zjh.getCookie('cart');
		if(cart){
			var reg = new RegExp(product_id+":[0-9]+");
			var ret = cart.match(reg);
			if(ret){
				cart = cart.replace(ret[0],product_id+":"+count);
				zjh.setCookie('cart',cart,days);
			}else{
				zjh.setCookie('cart',cart+","+product_id+":"+count,days);
			}
		}else{
			zjh.setCookie('cart',product_id+":"+count,days);
		}
		zjh.scrollTo('top');
		// 统计cart中商品数量
		// console.log(zjh.getCookie('cart'));
		updateCart();
	}
	function requestComments(product_id,limit_start,limit_end,fn){
		var comment = zjh.get('goods-comments-list-inner');

		zjh.POST('<?php echo HOSTNAME;?>comment/findByProductid',{
			'product_id':product_id,
			'limit_start':limit_start,
			'limit_end':limit_end
		},function(r){
			r = r.trim();
			// alert(r);
			if(r != 'fail'){
				comment.innerHTML = comment.innerHTML+r;
			}else{
				comment.innerHTML = comment.innerHTML+'~没有评论了';
			}
			if(fn){
				fn(r);
			}
		})
	}
	// requestComments();
	function viewMore(othis){
		var limit_start = othis.getAttribute('data-start');
		var limit_end = othis.getAttribute('data-end');
		var product_id = "<?php echo $product['product_id'];?>";
		if(!limit_start) limit_start = 0;
		if(!limit_end) limit_end = 10;
		requestComments(product_id,limit_start,limit_end,function(r){
			if(r == 'fail') zjh.hide(othis);
		});
		othis.setAttribute('data-start',parseInt(limit_start)+parseInt(limit_end));
		othis.setAttribute('data-end',limit_end);
	}
</script>
<?php }else{
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
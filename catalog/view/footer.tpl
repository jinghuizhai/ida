<div id="footer">
	<div class="container">
		<div class="service-info fix">
			<div class="service-single">
				<i class="icon iconfont">&#xf00fa;</i>
				<p>
					3天退换货
				</p>
			</div>
			<div class="service-single">
				<i class="icon iconfont">&#xe785;</i>
				<p>
					支付宝安全保障
				</p>
			</div>
			<div class="service-single">
				<i class="icon iconfont">&#xe66d;</i>
				<p>
					3天内到货
				</p>
			</div>
			<div class="service-single">
				<i class="icon iconfont">&#xe629;</i>
				<p>
					积分计划
				</p>
			</div>
		</div>
		<div class="footer-logo">
			<img src="<?php echo HOSTNAME;?>style/imgs/logo_s.png" id="footer-logo"/>
		</div>
		<p class="all-rights">
			© 2015 IDA Watch
		</p>
		<div class="pay-icon">
		</div>
	</div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo HOSTNAME;?>style/iconfont/front/iconfont.css" />
<script type="text/javascript">
	var restime = <?php global $time;echo time()-$time;?>;
	(function(){
		var hint = zjh.get('hint');
		if(hint.innerHTML.trim().length > 0){
			setTimeout(function(){
				zjh.hide(hint);
				zjh.setCookie('idawatch','',-10);
			},2000);
		}else{
			zjh.hide(hint);
		}
	})();
	function updateCart(){
		var cart = zjh.getCookie('cart');
		var cartarr = cart.split(',');
		var sum = 0;
		cartarr.forEach(function(ele){
			var num = ele.match(/[:](\d+)/);
			if(num){
				num = parseInt(num[1]);
				sum = sum+num;
			}
		});
		if(sum == 0){
			sum = "0";
		}
		var cartGoods = zjh.get('cart-goods-num');
		if(cartGoods) cartGoods.innerHTML = sum;
	}
	function updateCartInfo(){
		var cart = zjh.getCookie('cart'),
			cartInfo = zjh.get('cart-info'),
			priceInfo = zjh.get('price-info');

		if(cart){
			zjh.POST("<?php echo HOSTNAME;?>cart/find",{'cart':cart},function(r){
				if(r){
					r = eval('('+r+')');
					var html = zjh.model(zjh.first(cartInfo),r.products,'happycart');
					console.log(html);
					if(html){
						cartInfo.innerHTML = html;
						var html2 = zjh.model(zjh.first(priceInfo),{
							price:r.price,
							postage:r.postage,
							total:r.total
						},'happyprice');
						if(html2){
							priceInfo.innerHTML = html2;
						}
						var products = r.products;
						var parr = [];
						for(var i = 0,len = products.length;i<len;i++){
							var pro = products[i];
							parr.push(pro['product_id']+":"+pro['pieces']);
						}
						zjh.setCookie('cart',parr.join(','),30);
					}else{
						zjh.setCookie('cart','',30);
						cartInfo.innerHTML = '';
						var html = zjh.model(zjh.first(priceInfo),{
							price:0,
							postage:0,
							total:0
						},'happyprice');
						priceInfo.innerHTML = html;
					}
				}else{
					zjh.setCookie('cart','',30);
					cartInfo.innerHTML = '';
					var html = zjh.model(zjh.first(priceInfo),{
						price:0,
						postage:0,
						total:0
					},'happyprice');
					priceInfo.innerHTML = html;
				}
				updateCart();
			});
		}else{
			zjh.setCookie('cart','',30);
			cartInfo.innerHTML = '';
			var html = zjh.model(zjh.first(priceInfo),{
				price:0,
				postage:0,
				total:0
			},'happyprice');
			priceInfo.innerHTML = html;
		}
	}
	function deleteProduct(othis){
		var productId = othis.getAttribute('data-id');
		var cart = zjh.getCookie('cart');
		if(cart){
			var cartarr = cart.split(",");
			var newarr = [];
			cartarr.forEach(function(ele,index){
				if(!ele.match(new RegExp(productId+":[0-9]+"))){
					newarr.push(ele);
				}
			});
			var cartstr = newarr.join(',');
			zjh.setCookie('cart',cartstr,30);
			updateCart();
			updateCartInfo();
		}
	}
	function hitLikes(product_id,fn){
		zjh.POST('<?php echo HOSTNAME;?>product/hitLikes',{'product_id':product_id},function(r){
			if(fn) fn(r.trim());
		});
	}
	window.onload = function(){
		updateCart();

		var zjhIcon = zjh.get('zjh-icon');
		if(zjhIcon){
			zjhIcon.onmouseenter = function(){
				updateCartInfo();
			};
			zjhIcon.ontouchend = function(){
				updateCartInfo();
				// zjh.show(zjh.get('cart-inner'));
				zjh.toggle(zjh.get('cart-inner'));
			}
			// zjhIcon.ontouchend = function(){
			// 	updateCartInfo();
			// }
		}
		if(typeof checkoutGoods != 'undefined'){
			checkoutGoods();
		}
		if(typeof initThumbnail != 'undefined'){
			initThumbnail();
		}
		if(typeof startThumb != 'undefined'){
			startThumb();
		}
		var detailNav = zjh.get('detail-nav');
		if(detailNav){
			var spans = detailNav.getElementsByTagName('span');
			for(var i = 0,len = spans.length;i<len;i++){
				void function(i){
					spans[i].onclick = function(){
						zjh.removeClass(spans,'active');
						zjh.addClass(this,'active');
					};
				}(i);
			}
			var dt = detailNav.offsetTop;
			var navThumbnail = zjh.get('nav-thumbnail');
		}
		var imgs = zjh.get('goods-detail')?zjh.get('goods-detail').getElementsByTagName('img'):null;
		var imgarr = [];
		var browerHeight = zjh.getViewport().height;
		if(imgs){
			for(var i = 0,len = imgs.length;i<len;i++){
				var src = imgs[i].getAttribute('data-src');
				if(src){
					imgarr.push({img:imgs[i],src:src});
				};
			}
		}
		window.onscroll = function(){
			//商品页详情导航栏
			var st = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop,
				to_top = zjh.get('to-top');
			//to-top
			if(st > 200){
				zjh.show(to_top);
			}else{
				zjh.hide(to_top);
			}
			if(detailNav){
				if(dt - st <= 0){
					zjh.show(navThumbnail);
					zjh.addClass(detailNav,'detail-nav-fixed');
				}else{
					zjh.hide(navThumbnail);
					zjh.removeClass(detailNav,'detail-nav-fixed');
				}
			}
			//img 瀑布加载
			if(imgarr.length > 0){
				var img = imgarr[0];
				var index = 0;
				while(typeof img != 'undefined'){
					var imgtop = img.img.offsetTop;
					console.log(new Date());
					if(imgtop-st <= browerHeight/3){
						img.img.src = img.src;
						imgarr.splice(index,1);
						img = imgarr[index];
					}else{
						index = index+1;
						img = imgarr[index];
					}
				}
			}
		};
		//viewmore
		var viewMore = zjh.get('viewMore');
		if(viewMore) viewMore.click();
		if(zjh.isphone()){
			var mobileWidth = zjh.getViewport().width,
				cartInner = zjh.get('cart-inner');
			zjh.css(cartInner,{
				width:mobileWidth+"px"
			});
		}
		//retina screen download big logo img
		zjh.get('header-logo').src = zjh.get('header-logo').src.replace('.png','@2x.png');
		zjh.get('footer-logo').src = zjh.get('footer-logo').src.replace('.png','@2x.png');
	};
</script>
<div id='to-top' class="dn">
	<div class="qq-service">
		<i class="icon iconfont">
			&#xe65f;
		</i>
	</div>
	<div class="top-icon" onclick="zjh.scrollTo('top')">
		<i class="icon iconfont">
			&#xe647;
		</i>
	</div>
</div>
</body>


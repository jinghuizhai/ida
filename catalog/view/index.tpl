<div class="home-banner" id="home-banner">
	<ul class="home-banner-img fix" id="banner-ul">
		<li>
			<a href="<?php echo HOSTNAME;?>product/1">
				<img src="<?php echo HOSTNAME;?>style/imgs/banner_1.jpg" />
			</a>
		</li>
		<li>
			<a href="<?php echo HOSTNAME;?>product/1">
				<img src="<?php echo HOSTNAME;?>style/imgs/banner_2.jpg" />
			</a>
		</li>	
		<li>
			<a href="<?php echo HOSTNAME;?>product/2">
				<img src="<?php echo HOSTNAME;?>style/imgs/banner_3.jpg" />
			</a>
		</li>
		<li>
			<a href="<?php echo HOSTNAME;?>product/2">
				<img src="<?php echo HOSTNAME;?>style/imgs/banner_4.jpg" />
			</a>
		</li>	
		<li>
			<a href="<?php echo HOSTNAME;?>product/3">
				<img src="<?php echo HOSTNAME;?>style/imgs/banner_5.jpg" />
			</a>
		</li>
		<li>
			<a href="<?php echo HOSTNAME;?>product/3">
				<img src="<?php echo HOSTNAME;?>style/imgs/banner_6.jpg" />
			</a>
		</li>	
	</ul>
	<ul class="banner-btn" id="banner-btn">
		<li class="active">
			<b></b>
		</li>
		<li>
			<b></b>
		</li>
		<li>
			<b></b>
		</li>
		<li>
			<b></b>
		</li>
		<li>
			<b></b>
		</li>
		<li>
			<b></b>
		</li>
	</ul>
</div>
<script type="text/javascript">
	function bindTouch(obj,type,fn){
		if(obj.length){
			for(var i = 0,len = obj.length;i<len;i++){
				obj[i].addEventListener(type,fn);
			}
		}else{
			obj.addEventListener(type,fn);
		}
	}

	function startThumb(){
		var vwidth = zjh.getViewport().width,
			ul = zjh.get('banner-ul'),
			lis = ul.getElementsByTagName('li'),
			total = lis.length,
			btn = zjh.get('banner-btn'),
			homeBanner = zjh.get('home-banner'),
			blis = btn.getElementsByTagName('li');

		zjh.css(ul,{"width":vwidth*total+"px"});
		for(var i = 0,len = lis.length;i<len;i++){
			zjh.css(lis[i],{'width':vwidth+"px"});
		}
		zjh.css(btn,{
			width:blis.length*22+"px",
			left:-blis.length*22/2+"px"
		});
		for(var i = 0,len = blis.length;i<len;i++){
			(function(i){
				var li = blis[i];
				li.onclick = function(){
					var ml = -(i*vwidth)+"px";
					zjh.animate(ul,{
						marginLeft:ml
					});
					zjh.removeClass(blis,'active');
					zjh.addClass(this,'active');
				};
			})(i);
		}
		var timeInter;

		function nowstart(){

			timeInter = setTimeout(function(){
				for(var i = 0,len = blis.length;i<len;i++){
					var li = blis[i];
					if(zjh.hasClass(li,'active')){
						var target = i+1;
						if(target == blis.length){
							target = 0;
						}
						blis[target].click();
						break;
					}
				}
				nowstart();
			},3000);
		};

		if(!zjh.isphone()){
			homeBanner.onmouseleave = function(){
				nowstart();
			};
			homeBanner.onmouseenter = function(){
				clearTimeout(timeInter);
			};
			nowstart();	
		}else{
			var xStart = 0;
			var xEnd = 0;
			var hasMoved = false;
			bindTouch(homeBanner,'touchstart',function(evt){
				evt.preventDefault();
				var touch = evt.touches[0];
				xStart = touch.pageX;
			});
			bindTouch(homeBanner,'touchmove',function(evt){
				evt.preventDefault();
				var touch = evt.touches[0];
				xEnd = touch.pageX;
				// alert(xEnd);
				hasMoved = true;
			});

			bindTouch(homeBanner,'touchend',function(evt){
				evt.preventDefault();
				for(var i = 0,len = blis.length;i<len;i++){
					var li = blis[i];
					if(zjh.hasClass(li,'active')){
						if(!hasMoved){
							window.location.href = zjh.first(lis[i]).getAttribute('href');
							break;
						}
						var target = i;
						if(xStart - xEnd < 0){
							target = target - 1;
						}else if(xStart - xEnd > 0){
							target = target + 1;
						}else{
							return true;
							break;
						}
						if(target == blis.length){
							target = 0;
						}
						if(target < 0){
							target = blis.length - 1;
						}
						blis[target].click();
						break;
					}
				}
				hasMoved = false;
			});

		}
	}
</script>
<div class="container tc hot">
	<img src="<?php echo HOSTNAME;?>style/imgs/fans.png" />
</div>
<div class="home-main">
	<div class="container fix pt20 pb20">
		<div class="overview">
			<div class="over-title">
				<h2>
					Happy Ida
				</h2>
			</div>
			<div class="new-features">
				<h3>新特性</h3>
			</div>
			<p class="watch-info">
				这款表在细节上融入了全新的设计理念，38毫米的表盘具备了时尚、美观、大方的元素，定会在任何场合让你熠熠生辉！ 深蓝色的表针，简约罗马数字表盘，以及可提供银色与棕色的表带选择，可在任何场所尽显你的魅力！ 让自己成为一个时尚的、独一无二的自己，为帅气以及时尚代言。
			</p>
		</div>
		<div class="overview tc">
			<a href="<?php echo HOSTNAME;?>product/1">
				<img src="<?php echo HOSTNAME;?>style/imgs/man_watch.png" />
			</a>
		</div>
	</div>
</div>
<div class="container tc mt20 fans">
	<img src="<?php echo HOSTNAME;?>style/imgs/hot.png" />
</div>
<div class="home-product-info">
	<p>
		IDA手表时尚优雅，无论男女、场合和服装风格，均可百搭。 在手表创意和生产过程中，我们始终追求完美，让每一个细节都透射着斯堪的纳维亚风格。 
		<br/><br/>
		我们采用简约的设计风格，避免冗余的特殊功能，确保每款手表都能给您完美流畅的触感。 我们的手表设计永恒独特，可完美搭配各种装扮风格。 在轻松安全下订单后，您便可等待物超所值的奢侈手表装在漂亮盒子内，寄至您的门口。
	</p>
</div>



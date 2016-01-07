<div class="container product-list-page">
	<div class="mt20">
		<h1>商品</h1>
	</div>
	<div id="checkout-list">
		<div class="checkout-list">
			<div class="checkout-info">
			{{name}}
			</div>
			<div class="checkout-img">
				<a href="<?php echo HOSTNAME;?>product/{{product_id}}">
					<img src="<?php echo IMG;?>{{thumbnail}}" />
				</a>
			</div>
			<div class="checkout-price">
			价格：{{price}}￥
			</div>
			<div class="checkout-postage">
			邮费：{{postage}}￥
			</div>
			<div class="checkout-pieces">
			{{pieces}}件
			</div>
			<div class="checkout-exe">
				<a onclick="deleteCheckoutProduct(this)" class="delete-goods" data-id="{{product_id}}">×</a>
			</div>
		</div>
	</div>
	<div class="total-price">
		商品：<span id="t-goods-price"></span>￥
		邮费：<span id="t-goods-postage"></span>￥
		共计：<span id="t-goods-total"></span>￥
	</div>
	<div class="mt20 mb20">
		<h1>选择支付方式</h1>
	</div>
	<div class="pay-way">
		<div>
			<h2>推荐</h2>
			<ul class="ali-icon fix" id="net-pay">
				<li class="active" data-code="alipay">
					<i class="icon iconfont">&#xe785;</i>
				</li>
				<li data-code="weixinpay">
					<i class="icon iconfont">&#xe677;</i>
				</li>
			</ul>
		</div>
		<div class="bank-pay">
			<h2>网银支付<i class="icon iconfont">&#xe6d1;</i></h2>
			<ul class="fix" id="bank-pay">
				<li>
					<img data-code="ICBC-DEBIT" src="<?php echo HOSTNAME;?>style/imgs/bankimg/payOnline_gsyh.png" />
				</li>
				<li>
					<img data-code="ABC" src="<?php echo HOSTNAME;?>style/imgs/bankimg/payOnline_nyyh.png" />
				</li>
				<li>
					<img data-code="CCB-DEBIT" src="<?php echo HOSTNAME;?>style/imgs/bankimg/payOnline_jsyh.png" />
				</li>
				<li>
					<img data-code="COMM-DEBIT" src="<?php echo HOSTNAME;?>style/imgs/bankimg/payOnline_jtyh.png" />
				</li>
				<li>
					<img data-code="CEB-DEBIT" src="<?php echo HOSTNAME;?>style/imgs/bankimg/payOnline_gdyh.png" />
				</li>
				<li>
					<img data-code="GDB-DEBIT" src="<?php echo HOSTNAME;?>style/imgs/bankimg/payOnline_gfyh.png" />
				</li>
				<li>
					<img data-code="CMBC" src="<?php echo HOSTNAME;?>style/imgs/bankimg/payOnline_msyh.png" />
				</li>
				<li>
					<img data-code="SPDB-DEBIT" src="<?php echo HOSTNAME;?>style/imgs/bankimg/payOnline_pufa.png" />
				</li>
				<li>
					<img data-code="CIB" src="<?php echo HOSTNAME;?>style/imgs/bankimg/payOnline_xyyh.png" />
				</li>
				<li>
					<img data-code="PSBC-DEBIT" src="<?php echo HOSTNAME;?>style/imgs/bankimg/payOnline_youzheng.png" />
				</li>
				<li>
					<img data-code="BOC-DEBIT" src="<?php echo HOSTNAME;?>style/imgs/bankimg/payOnline_zgyh.png" />
				</li>
				<li>
					<img data-code="CMB-DEBIT" src="<?php echo HOSTNAME;?>style/imgs/bankimg/payOnline_zsyh.png" />
				</li>
				<li>
					<img data-code="CITIC-DEBIT" src="<?php echo HOSTNAME;?>style/imgs/bankimg/payOnline_zxyh.png" />
				</li>
			</ul>
		</div>
	</div>
	<div class="mt20 mb20">
		<h1>地址</h1>
	</div>
	<div id="new-address" class="dn">
		<li class="address-single" onclick="activeAddress(this);">
			<input type="radio" name="radio" value="{{address_id}}" class="dn" />
			<div class="address-single-inner">
			{{province}}{{city}}{{area}}{{zip}}{{detail}}
			</div>
		</li>
	</div>
	<form action="<?php echo HOSTNAME;?>checkout/createOrder" method="post">
		<input type="hidden" name="cart" id="cart"/>
		<input type="hidden" name="payway" id="pay-way" value="alipay"/>
		<ul class="address-list fix" id="address-list">
			<?php if(!empty($addresses)){ 
				foreach($addresses as $key => $value){
					$clazz = '';
					if($value['used'] == 1) $clazz = ' active';
			?>
			<li class="address-single <?php echo $clazz;?>" onclick="activeAddress(this);">
				<?php if(empty($clazz)){ ?>
				<input type="radio" name="radio" value="<?php echo $value['address_id'];?>" class="dn" />
				<?php }else{ ?>
				<input type="radio" checked="checked" name="radio" value="<?php echo $value['address_id'];?>" class="dn" />
				<?php } ?>
				<div class="address-single-inner">
				<?php echo $value['province'];?>
				<?php echo $value['city'];?>
				<?php echo $value['area'];?>
				<?php echo $value['zip'];?>
				<?php echo $value['detail'];?>
				</div>
			</li>
			<?php }} ?>
		</ul>

		<!-- <div class="mt20 mb20"> -->
			<p id="login-info"></p>
			<div class="add-address mt20">
				<div class="input-group">
					<b>省</b>
					<select name="province" id="province" onchange="requireCity(this)">
						<option value="{{provinceid}}">{{province}}</option>
					</select>
				</div>
				<div class="input-group">
					<b>市</b>
					<select name="city" id="city" onchange="requireArea(this)" class="dn">
						<option value="{{cityid}}">{{city}}</option>
					</select>
				</div>
				<div class="input-group">
					<b>区</b>
					<select name="area" id="area" onchange="requireZipcode(this);" class="dn">
						<option value="{{areaid}}">{{area}}</option>
					</select>
				</div>
				<div class="input-group">
					<b>邮编</b>
					<select name="zipcode" id="zipcode" class="dn">
						<option value="{{zip}}">{{zip}}</option>
					</select>
				</div>
				<div class="input-group">
					<b>详细地址</b>
					<input name="detail" id="detail" maxlength="30" />
				</div>
				<a class="btn add-address-href" onclick="postAddress(this);">添加地址</a>
			</div>
		<!-- </div> -->
		<div class="mt20 mb20 fix">
			<button class="btn b-red r submit-order-btn" onclick="return submitOrder(this);">提交订单</button>
		</div>
	</form>
</div>
<script type="text/javascript">
	function postAddress(othis){
		var province = zjh.get('province').value.trim(),
			city = zjh.get('city').value.trim(),
			area = zjh.get('area').value.trim(),
			zipcode = zjh.get('zipcode').value.trim(),
			detail = zjh.get('detail').value.trim(),
			info = zjh.get('login-info');

		if(!zjh.validate('allnum',province)){
			info.innerHTML = '省为必填项目';
			return;
		}
		if(!zjh.validate('allnum',area)){
			info.innerHTML = '省为必填项目';
			return;
		}
		if(!/.{5,}/.test(detail)){
			info.innerHTML = '详细地址字数需要大于5';
			return;
		}
		zjh.POST('<?php echo HOSTNAME;?>address/jsonadd',{
			"province":province,
			"city":city,
			"area":area,
			"zipcode":zipcode,
			"detail":detail
		},function(r){
			r = eval("("+r+")");
			if(r.info == 'success'){
				var address = r.address;
				var html = zjh.model(zjh.get('new-address').innerHTML,address,'new_address');
				var list = zjh.get('address-list');
				list.innerHTML = list.innerHTML+html;
				zjh.last(list).click();
				province = zjh.get('province').value.trim(),
				zjh.get('city').value = null;
				zjh.get('area').value = null;
				zjh.get('zipcode').value = null;
				zjh.get('detail').value = null;
				zjh.get('login-info').innerHTML = '';
			}else{
				alert(r.info);
			}
		});
	}
	//在footer中调用
	function checkoutGoods(){
		var checkoutList = zjh.get('checkout-list');
		var cart = zjh.getCookie('cart');
		if(cart){
			zjh.POST("<?php echo HOSTNAME;?>cart/find",{'cart':cart,'address_id':getSelectAddress()},function(r){
				if(r){
					r = eval('('+r+')');
					var html = zjh.model(checkoutList.innerHTML,r.products,'checkoutList');
					console.log(r);
					if(html){
						checkoutList.innerHTML = html;
						zjh.get('t-goods-price').innerHTML = r.price;
						zjh.get('t-goods-postage').innerHTML = r.postage;
						zjh.get('t-goods-total').innerHTML = r.total;
					}
				}
			});
		}else{
			checkoutList.innerHTML = "";
			zjh.get('t-goods-price').innerHTML = 0;
			zjh.get('t-goods-postage').innerHTML = 0;
			zjh.get('t-goods-total').innerHTML = 0;
		}
		zjh.get('cart').value = cart;
	}
	function deleteCheckoutProduct(othis){
		deleteProduct(othis);
		checkoutGoods();
	}
	function activeAddress(othis){
		var ul = zjh.get('address-list');
		var lis = ul.getElementsByTagName('li');
		zjh.removeClass(lis,'active');
		zjh.addClass(othis,'active');
		var input = othis.getElementsByTagName('input')[0];
		input.checked = true;
		//根据地址再次请求商品信息
		checkoutGoods();
	}
	function getSelectAddress(){
		var checks = zjh.get('address-list').getElementsByTagName('input');
		for(var i = 0,len = checks.length;i<len;i++){
			if(checks[i].checked == true){
				return checks[i].value;
			}
		}
		return -1;
	}
	function submitOrder(othis){
		var cart = zjh.get('cart').value.trim();
			
		if(cart.length < 3){
			alert('购车中没有商品，不能提交订单');
			return false;
		}

		if(getSelectAddress() < 0){
			alert("您没有选择地址");
			return false;
		}else if(zjh.get('pay-way').value.trim().length == 0){
			alert('请选择支付方式');
			return false;
		}else{
			return true;
		}
	}

</script>
<script type="text/javascript">
	
	function requireProvince(){
		zjh.POST("<?php echo HOSTNAME;?>address/findProvince",{'params':1},function(r){
			if(r){
				r = eval("("+r+")");
				var ele = zjh.get('province');
				var html = zjh.model(ele.innerHTML,r,'province');
				if(html){
					ele.innerHTML = html;
				}
			}
		});
	}
	requireProvince();
	function requireCity(othis){
		var provinceid = othis.options[othis.selectedIndex].value;
		zjh.POST("<?php echo HOSTNAME;?>address/findCity",{'provinceid':provinceid},function(r){
			if(r){
				r = eval("("+r+")");
				var ele = zjh.get('city');
				zjh.showi(ele);
				var html = zjh.model(ele.innerHTML,r,'city');
				if(html){
					ele.innerHTML = html;
				}
			}
		});
	}
	function requireArea(othis){
		var cityid = othis.options[othis.selectedIndex].value;
		zjh.POST("<?php echo HOSTNAME;?>address/findArea",{'cityid':cityid},function(r){
			if(r){
				r = eval("("+r+")");
				var ele = zjh.get('area');
				zjh.showi(ele);
				var html = zjh.model(ele.innerHTML,r,'area');
				if(html){
					ele.innerHTML = html;
				}
				requireZipcode(zjh.get('area'));
			}
		});
	}
	function requireZipcode(othis){
		var areaid = othis.options[othis.selectedIndex].value;
		zjh.POST("<?php echo HOSTNAME;?>address/findZipcode",{'areaid':areaid},function(r){
			if(r){
				r = eval("("+r+")");
				var ele = zjh.get('zipcode');
				zjh.showi(ele);
				var html = zjh.model(ele.innerHTML,r,'zipcode');
				if(html){
					ele.innerHTML = html;
				}
			}
		});
	}

	(function(){
		var net = zjh.get('net-pay'),
			bank = zjh.get('bank-pay'),
			lisNet = net.getElementsByTagName('li'),
			lisBank = bank.getElementsByTagName('li'),
			payway = zjh.get('pay-way');

		for(var i = 0,len = lisNet.length;i<len;i++){
			(function(i){
				lisNet[i].onclick = function(){
					zjh.removeClass(lisNet,'active');
					zjh.removeClass(lisBank,'active');
					if(this.getAttribute('data-code')){
						payway.value = this.getAttribute('data-code');
					}else{
						var img = zjh.first(this);
						payway.value = img.getAttribute('data-code');
					}
					zjh.addClass(lisNet[i],'active');
				};
			})(i);
		}
		for(var i = 0,len = lisBank.length;i<len;i++){
			(function(i){
				lisBank[i].onclick = function(){
					zjh.removeClass(lisNet,'active');
					zjh.removeClass(lisBank,'active');
					if(this.getAttribute('data-code')){
						payway.value = this.getAttribute('data-code');
					}else{
						var img = zjh.first(this);
						payway.value = img.getAttribute('data-code');
					}
					zjh.addClass(lisBank[i],'active');
				};
			})(i);
		}
	})();
</script>
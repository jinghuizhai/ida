<div class="main-inner">
	<p class="p-title">
	添加地址
	</p>
	<div class="form-group">
		<p id="login-info"></p>
		<form action="<?php echo HOSTNAME;?>address/add" method="post">
			<div class="p-group">
				<b>省</b>
				<select name="province" id="province" onchange="requireCity(this)">
					<option value="{{provinceid}}">{{province}}</option>
				</select>
			</div>
			<div class="p-group">
				<b>市</b>
				<select name="city" id="city" onchange="requireArea(this)" class="dn">
					<option value="{{cityid}}">{{city}}</option>
				</select>
			</div>
			<div class="p-group">
				<b>区</b>
				<select name="area" id="area" onchange="requireZipcode(this);" class="dn">
					<option value="{{areaid}}">{{area}}</option>
				</select>
			</div>
			<div class="p-group">
				<b>邮编</b>
				<select name="zipcode" id="zipcode" class="dn">
					<option value="{{zip}}">{{zip}}</option>
				</select>
			</div>
			<div class="p-group">
				<b>详细地址</b>
				<input name="detail" id="detail" maxlength="30" />
			</div>
			<button class="btn" onclick="return checkAddress(this)">添加</button>
		</form>
	</div>
</div>
<script type="text/javascript">
	function checkAddress(othis){
		var province = zjh.get('province').value.trim(),
			city = zjh.get('city').value.trim(),
			area = zjh.get('area').value.trim(),
			zipcode = zjh.get('zipcode').value.trim(),
			detail = zjh.get('detail').value.trim(),
			info = zjh.get('login-info');

		if(!zjh.validate('allnum',province)){
			info.innerHTML = '省不能为空';
			return false;
		}
		if(!zjh.validate('allnum',city)){
			info.innerHTML = '城市不能为空';
			return false;
		}
		if(!zjh.validate('allnum',area)){
			info.innerHTML = '区不能为空';
			return false;
		}
		if(!zjh.validate('allnum',zipcode)){
			info.innerHTML = '邮编不能为空';
			return false;
		}
		if(detail.length < 5){
			info.innerHTML = '详细地址需要超过5个字符';
			return false;
		}
		return true;
	}
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
</script>
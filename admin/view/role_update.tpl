<div class="main-inner">
	<p class="p-title">更新角色</p>
	<div class="form-group">
		<p id="login-info"></p>
		<a href="#login-info" id="to-top"></a>
		<form action="<?php echo HOSTNAME;?>admin/role/update" method="post">
			<input type="hidden" name="role_id" value="<?php echo $role['role_id'];?>" />
			<div class="p-group">
				<b>名称</b>
				<input id="name" name="name" value="<?php echo $role['name'];?>"/>
			</div>
			<div class="p-group">
				<b>TAG</b>
				<input id="tag" name="tag" value="<?php echo $role['tag'];?>"/>
			</div>
			<div class="p-group">
				<b>登录入口</b>
				<select name="entrance" onchange="exchangeEntrance(this);" id="entrance">
					<option value="front">前台</option>
					<option value="backstage">后台</option>
				</select>
			</div>
			<a class="btn b-green" href="javascript:;">
				权限:
				<label>全选</label><input type="checkbox" onclick="checkAllBox(this);"/>
				<label>选类</label><input type="checkbox" onclick="checkClass(this);"/>
			</a>
			<div id="check-area">
			</div>
			<button class="btn" onclick="return checkRole(this);">更新</button>
		</form>
	</div>
</div>
<script type="text/javascript">
	function checkRole(othis){
		var name = zjh.get('name').value.trim(),
			tag = zjh.get('tag').value.trim(),
			toTop = zjh.get('to-top'),
			info = zjh.get('login-info');
		toTop.click();

		if(name.length < 1){
			info.innerHTML = '名称不能为空';
			return false;
		}
		if(tag.length < 1){
			info.innerHTML = 'tag不能为空';
			return false;
		}
		return true;
	}
	function checkAllBox(othis){
		var check = zjh.get('check-area'),
			boxes = check.getElementsByTagName('input'),
			len = boxes.length;
		for(var i = 0;i<len;i++){
			boxes[i].checked = othis.checked;
		}
	}
	function checkClass(othis){
		var check = zjh.get('check-area'),
			boxes = check.getElementsByTagName('input'),
			len = boxes.length;
		for(var i = 0;i<len;i++){
			if(!/\//.test(boxes[i].value)){
				boxes[i].checked = othis.checked;
			}
		}
	}
	function exchangeEntrance(othis){
		var value = othis.options[othis.selectedIndex].value;
		zjh.POST('<?php echo HOSTNAME;?>admin/role/jsonMethodList',{"entrance":value,'role_id':"<?php echo $role['role_id'];?>"},function(r){
			if(r){
				zjh.get('check-area').innerHTML = r;
			}else{
				alert('没有配置项，请检查后台程序');
			}
		});
	}
	(function(){
		//初始化权限checkbox
		var select = zjh.get('entrance');
		exchangeEntrance(select);
	})();
</script>

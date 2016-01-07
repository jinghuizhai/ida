<div class="main-inner">
	<p class="p-title">
		管理图片
	</p>
	<button class="btn b-red mb20" onclick="deleteMany(this);">
		批量删除
	</button>
	<button class="btn b-green mb20" onclick="clearMany(this);">
		清空
	</button>
	<button class="btn mb20" onclick="selectMany(this);">
		全选
	</button>
	<div class="fix" id='all-img'>
	<?php
	if(!empty($imgs)){
		foreach($imgs as $key => $value){
	?>
		<div class="img-hub">
			<a target="_blank" href="<?php echo IMG.$value['name'];?>">
			LOOK
			</a>
			<input type='checkbox' name="checkbox[]" id="<?php echo $value['img_id'];?>" />
			<img src="<?php echo IMG.$value['name'];?>"/>
		</div>
	<?php }} ?>
	</div>
	<?php echo $pagination;?>
</div>
<script type="text/javascript">
	(function(){
		var ele = zjh.get('all-img'),
			imgs = ele.getElementsByTagName('img');
		for(var i = 0,len = imgs.length;i<len;i++){
			(function(i){
				var img = imgs[i];
				img.onclick = function(){
					var el = this.parentNode;
					var input = zjh.nth(el,1);
					input.checked = !input.checked;
				};
			})(i);
		}
	})();
	function deleteMany(othis){
		var ele = zjh.get('all-img'),
			checks = ele.getElementsByTagName('input'),
			result = [];
		for(var i = 0,len = checks.length;i<len;i++){
			var c = checks[i];
			if(c.getAttribute('type') == 'checkbox'){
				if(c.checked){
					result.push(c.id);
				}
			}
		}
		console.log(result);
		if(result.length){
			var str = result.join(',');
			zjh.POST('<?php echo HOSTNAME;?>admin/img/delete',{"ids":str},function(r){
				r = r.trim();
				if(r == 'success'){
					//移除页面上的节点
					result.forEach(function(ele){
						var box = zjh.get(ele);
						box.parentNode.parentNode.removeChild(box.parentNode);
					});
				}else{
					alert(r);
				}
			});
		}else{
			alert('没有选中的图片');
		}
	}
	function clearMany(othis){
		var ele = zjh.get('all-img'),
			checks = ele.getElementsByTagName('input');
		for(var i = 0,len = checks.length;i<len;i++){
			var c = checks[i];
			if(c.getAttribute('type') == 'checkbox'){
				c.checked = false;
			}
		}
	}
	function selectMany(othis){
		var ele = zjh.get('all-img'),
			checks = ele.getElementsByTagName('input');
		for(var i = 0,len = checks.length;i<len;i++){
			var c = checks[i];
			if(c.getAttribute('type') == 'checkbox'){
				c.checked = true;
			}
		}
	}
</script>
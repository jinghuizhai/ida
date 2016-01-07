<script type="text/javascript" charset="utf-8" src="<?php echo EDITOR;?>ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo EDITOR;?>ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="<?php echo EDITOR;?>lang/zh-cn/zh-cn.js"></script>
<div class="main-inner">
	<p class="p-title">更新商品</p>
	<p id="login-info"></p>
	<a href="#login-info" id="to-top"></a>
	<form action="<?php echo HOSTNAME;?>admin/product/update" method="post">
		<input type="hidden" name="product_id" value="<?php echo $product_id;?>" />
		<div class="p-group">
			<b>所属分类</b>
			<select name="catalog_id">
				<?php if(!empty($catalogs)){
						foreach($catalogs as $key => $catalog){
							if($catalog['catalog_id'] != $catalog_id){
								echo "<option value='".$catalog['catalog_id']."'>".$catalog['name']."</option>";	
							}else{
								echo "<option selected='selected' value='".$catalog['catalog_id']."'>".$catalog['name']."</option>";
							}
						}
					}
				?>
			</select>
		</div>
		<div class="p-group">
			<b>名称</b>
			<input id="name" type="text" name="name" value="<?php echo $name;?>" />
		</div>
		<div class="p-group">
			<b>价格</b>
			<input id="price" type="text" name="price" value="<?php echo $price;?>"/>
		</div>
		<div class="p-group">
			<b>是否免运费</b>
			<select name="free_postage">
				<?php if(empty($free_postage)){ ?>
					<option value="0">免运费</option>
					<option value="1">不免运费</option>
				<?php }else{ ?>
					<option value="0">免运费</option>
					<option value="1" selected="selected">不免运费</option>
				<?php } ?>
			</select>
		</div>
		<div class="p-group">
			<b>运费</b>
			<input id="postage" type="text" name="postage" value="<?php echo $postage;?>"/>
		</div>
		<div class="p-group">
			<b>偏远地区运费</b>
			<input id="postage_remote" type="text" name="postage_remote" value="<?php echo $postage_remote;?>" id="postage_remote"/>
		</div>
		<div class="p-group">
			<b>库存</b>
			<input id="stock" type="text" name="stock" value="<?php echo $stock;?>"/>
		</div>
		<div class="p-group">
			<b>购买可获积分</b>
			<input id="score" type="text" name="score" value="<?php echo $score;?>"/>
		</div>
		<div class="p-group">
			<b>属性组</b>
			<select name="attr_group_id">
				<?php if(!empty($attrs)){
					foreach($attrs as $akey => $avalue){
						if($attr_group_id == $avalue['attr_group_id']){
							echo "<option selected='selected' value='".$avalue['attr_group_id']."'>".$avalue['name']."</option>";
						}else{
							echo "<option value='".$avalue['attr_group_id']."'>".$avalue['name']."</option>";
						}
					}
				}
				?>
			</select>
		</div>
		<div class="p-group">
			<b>title</b>
			<input id="title" type="text" name="title" value="<?php echo $title;?>"/>
		</div>
		<div class="p-group">
			<b>keywords</b>
			<input id="keywords" type="text" name="keywords" value="<?php echo $keywords;?>"/>
		</div>
		<div class="p-group">
			<b>description</b>
			<input id="description" type="text" name="description" value="<?php echo $description;?>"/>
		</div>
		<div class="p-group">
			<b>点击次数</b>
			<input id="hits" type="text" name="hits" value="<?php echo $hits;?>" />
		</div>
		<div class="p-group">
			<b>点赞次数</b>
			<input id='likes' type="text" name="likes" value="<?php echo $likes;?>"/>
		</div>
		<div class="p-group">
			<b>返给直接推荐者</b>
			<input id="for_presenter" type="text" name="for_presenter" value="<?php echo $for_presenter;?>" id="for_presenter"/>
		</div>
		<div class="p-group">
			<b>返给工作人员</b>
			<input id="for_workers" type="text" name="for_workers" value="<?php echo $for_workers;?>" id="for_workers"/>
		</div>
		<div class="p-group">
			<b>商品主图</b>
			<span id="showimgs">
				<?php 
					if(!empty($imgs)){
						$imgs_str = "";
						foreach($imgs as $key => $value){
							echo "<img data-id='".$value['img_id']."' src='".IMG.$value['name']."'/>";
							if($key == 0){
								$imgs_str = $value['img_id'];
							}else{
								$imgs_str = $imgs_str.",".$value['img_id'];
							}
					}}
				?>
			</span>
			<span href="javascript;" class="upload-href btn" data-action="<?php echo HOSTNAME;?>admin/product/thumbnail" onclick="uploadStart(this);" />添加图片</span>
		</div>
		<input type="hidden" id="img_id" name="img_id" value="<?php echo $imgs_str;?>"/>
		<textarea name="detail" id="detail" class="dn"><?php echo $detail;?></textarea>
		<script id="editor" type="text/plain" style="width:100%;height:400px;"></script>
		<button class="btn mt10" onclick="return addProduct(this);">修改</button>
	</form>
</div>
<iframe class="dn" src="../../view/uploadimgs.html" id="p-iframe"></iframe>
<script type="text/javascript">
	var ue = UE.getEditor('editor');
	function uploadStart(othis){
		var iframe = document.getElementById('p-iframe').contentDocument;
		var action = othis.getAttribute('data-action');
		var form = iframe.getElementById('upload-iframe');
		form.setAttribute('action',action);
		iframe.getElementById('file').click();
	}
	function addProduct(othis){
		var content = ue.getContent(),
			detail = zjh.get('detail'),
			info = zjh.get('login-info'),
			name = zjh.get('name').value.trim(),
			price = zjh.get('price').value.trim(),
			postage = zjh.get('postage').value.trim(),
			postage_remote = zjh.get('postage_remote').value.trim(),
			stock  = zjh.get('stock').value.trim(),
			score = zjh.get('score').value.trim(),
			title = zjh.get('title').value.trim(),
			keywords = zjh.get('keywords').value.trim(),
			description = zjh.get('description').value.trim(),
			hits = zjh.get('hits').value.trim(),
			likes = zjh.get('likes').value.trim(),
			for_presenter = zjh.get('for_presenter').value.trim(),
			for_workers = zjh.get('for_workers').value.trim(),
			img_id = zjh.get('img_id').value.trim(),
			toTop = zjh.get('to-top');

		toTop.click();

		if(name.length < 1){
			info.innerHTML = '商品名称不能为空';
			return false;
		}
		if(!zjh.validate('int',price) && !zjh.validate('float',price)){
			info.innerHTML = '价格必须为数字';
			return false;
		}
		if(!zjh.validate('int',postage) && !zjh.validate('float',postage)){
			info.innerHTML = '运费必须为数字';
			return false;
		}
		if(!zjh.validate('int',postage_remote) && !zjh.validate('float',postage_remote)){
			info.innerHTML = '偏远地区运费必须为数字';
			return false;
		}
		if(!zjh.validate('int',stock)){
			info.innerHTML = '库存必须为数字';
			return false;
		}
		if(!zjh.validate('int',score)){
			info.innerHTML = '积分必须为数字';
			return false;
		}
		if(!zjh.validate('int',hits)){
			info.innerHTML = '点击必须为数字';
			return false;
		}
		if(!zjh.validate('int',likes)){
			info.innerHTML = '点赞数必须为数字';
			return false;
		}
		if(title.length < 1){
			info.innerHTML = '标题不能为空';
			return false;
		}
		if(keywords.length < 1){
			info.innerHTML = '关键字不能为空';
			return false;
		}
		if(description.length < 1){
			info.innerHTML = '描述不能为空';
			return false;
		}
		if(!zjh.validate('int',for_presenter) && !zjh.validate('float',for_presenter)){
			info.innerHTML = '返给直接推荐者必须为数字';
			return false;
		}
		if(!zjh.validate('int',for_workers) && !zjh.validate('float',for_workers)){
			info.innerHTML = '返给工作人员必须为数字';
			return false;
		}
		if(img_id.length < 1){
			info.innerHTML = '还没有上传产品图片';
			return false;
		}
		if(content.length < 10){
			info.innerHTML = '产品详情内容太短';
			return false;
		}else{
			var detail = zjh.get('detail');
			detail.value = content;
			return true;		
		}
	}
	function initContent(){
		var detail = zjh.get('detail').value;
		ue.ready(function(){
			ue.setContent(detail);
		});
	}
	window.onload = function(){
		initContent();
		//商品略缩图选中
		var showimgs = zjh.get('showimgs');
		var imgs = showimgs.getElementsByTagName('img');
		var imgId = zjh.get('img_id');
		for(var i = 0,len = imgs.length;i<len;i++){
			(function(i){
				var img = imgs[i];
				img.onclick = function(){
					var oid = this.getAttribute('data-id');
					var imgValue = imgId.value;
					if(zjh.hasClass(this,"cancel")){
						//增加
						zjh.removeClass(this,'cancel');
						if(imgValue.length == 0){
							imgId.value = oid;
						}else{
							imgId.value = imgId.value+","+oid;
						}
					}else{
						//取消
						zjh.addClass(this,'cancel');
						var imgarr = imgValue.split(',');
						var newarr = [];
						imgarr.forEach(function(el){
							if(el != oid){
								newarr.push(el);
							}
						});
						imgId.value = newarr.join(',');
					}
				};
			})(i);
		}
	};

	
</script>
<form id="upload-iframe" action="<?php echo HOSTNAME?>admin/product/thumbnail" method="post" enctype="multipart/form-data">
	<input id="file" type="file" name="file" onchange="uploadNow(this);" />
	<button id="start">OK</button>
</form>
<script type="text/javascript">
	function uploadNow(othis){
		othis.parentNode.submit();
	}
	(function(){
		var ele = window.parent.document;
		var showimgs = ele.getElementById('showimgs');
		var img = document.createElement('img');
		img.src="<?php echo $src;?>";
		img.setAttribute('data-id',"<?php echo $img_id;?>");
		showimgs.appendChild(img);
		var img_id = ele.getElementById('img_id');
		if(img_id.value){
			img_id.value = img_id.value+","+"<?php echo $img_id;?>";
		}else{
			img_id.value = "<?php echo $img_id;?>";
		}
	})();
</script>
<form id="upload-iframe" action="<?php echo HOSTNAME?>admin/product/thumbnail" method="post" enctype="multipart/form-data">
	<input id="file" type="file" name="file" onchange="uploadNow(this);" />
	<button id="start">OK</button>
</form>
<script type="text/javascript">
	function uploadNow(othis){
		othis.parentNode.submit();
	}
	alert("<?php echo $info;?>");
</script>
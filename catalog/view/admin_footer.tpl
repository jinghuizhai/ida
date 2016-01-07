</div>
</div>
<script type="text/javascript">
	function toggleMenu(othis){
		var menu = zjh.get('menu');
		zjh.toggle(menu);
	}
	(function(){
		var hint = zjh.get('hint');
		if(hint){
			setTimeout(function(){
				zjh.hide(hint);
			},2000);
		}
	})();
</script>
</body>
</html>
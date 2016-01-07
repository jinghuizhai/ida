<script type="text/javascript" src="<?php echo HOSTNAME;?>style/js/laydate/laydate.js"></script>
<div class="main-inner">
	<p class="p-title">
		更新广播
	</p>
	<div class="form-group">
		<p id="login-info"></p>
		<form action="<?php echo HOSTNAME;?>admin/broadcast/update" method="post">
			<input type="hidden" name="broadcast_id" value="<?php echo $broadcast['broadcast_id'];?>" />
			<div class="p-group">
				<b>给谁</b>
				<?php if(!empty($roles)){ ?>
					<select name="role_id">
						<option value="0">所有人</option>
						<?php foreach($roles as $key => $value){
						?>
						<option value="<?php echo $value['role_id'];?>"><?php echo $value['name'];?></option>
						<?php } ?>
					</select>
				<?php } ?>
			</div>
			<textarea name="content" class="broadcast-content" placeholder="广播内容" id="content"><?php echo $broadcast['content'];?></textarea>
			<div class="p-group">
				<b>开始日期</b>
				<input id="date-start" value="<?php echo $broadcast['date_start'];?>" name="date_start" placeholder="请输入日期" class="laydate-icon" onclick="laydate()">
			</div>
			<div class="p-group">
				<b>结束日期</b>
				<input id="date-end" value="<?php echo $broadcast['date_end'];?>" name="date_end" placeholder="请输入日期" class="laydate-icon" onclick="laydate()">
			</div>
			<button class="btn" onclick="return checkBroadcast(this)">更新</button>
		</form>
	</div>
</div>
<script type="text/javascript">
	function checkBroadcast(othis){
		var content = zjh.get('content').value.trim(),
			date_start = zjh.get('date-start').value.trim(),
			date_end = zjh.get('date-end').value.trim(),
			info = zjh.get('login-info');

		if(content.length < 1){
			info.innerHTML = '内容不能为空';
			return false;
		}
		if(date_start.length < 1){
			info.innerHTML = '开始日期不能为空';
			return false;
		}
		if(date_end.length < 1){
			info.innerHTML = '结束日期不能为空';
			return false;
		}
		return true;
	}
</script>
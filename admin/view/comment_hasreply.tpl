<div class="main-inner">
	<p class="p-title">
	已回复
	</p>
	<table class="p-table">
		<thead>
			<th>用户</th>
			<th>评论</th>
			<th>回复</th>
			<th>回复时间</th>
			<th>编辑</th>
			<th>删除</th>
		</thead>
		<tbody>
			<?php if(!empty($comments)){ 
				foreach($comments as $key => $value){
			?>
				<tr>
					<td>
						<form action="<?php echo HOSTNAME;?>admin/reply/add" method="post">
						<input type="hidden" value="<?php echo $value['reply_id'];?>" name="reply_id" />
						<?php echo $value['name'];?>
					</td>
					<td>
						<?php echo $value['content'];?>
					</td>
					<td id="r_<?php echo $value['reply_id'];?>">
						<?php echo $value['rcontent'];?>
					</td>
					<td>
						<?php echo $value['rdate'];?>
					</td>
					<td>
						<a href="javascript:;" data-id="<?php echo $value['reply_id'];?>" onclick="editReply(this);" class="btn">编辑</a>
					</td>
					<td>
						<button class="btn b-red">删除</button>
						</form>
					</td>
				</tr>
			<?php }} ?>
		</tbody>
	</table>
	<?php echo $pagination;?>
</div>
<div class="dn" id="reply">
	<textarea class="reply-area"></textarea>
	<button class="btn r">确定</button>
</div>
<script type="text/javascript">
	function editReply(othis){
		var reply = zjh.get('reply');
		zjh.pop('编辑',reply,500,300,function(closeDiv){
			var area = reply.getElementsByTagName('textarea')[0];
			var btn = reply.getElementsByTagName('button')[0];
			area.value = zjh.get('r_'+othis.getAttribute('data-id')).innerHTML.trim();
			area.focus();
			btn.onclick = function(){
				if(area.value.length < 1){
					alert('回复不能为空');
				}else{
					zjh.POST('<?php echo HOSTNAME;?>admin/reply/update',{
						'reply_id':othis.getAttribute('data-id'),
						'content':area.value.trim()
					},function(r){
						if(r){
							area.value = '';
							var td = zjh.get('r_'+othis.getAttribute('data-id'));
							td.innerHTML = r;
						}else{
							alert('编辑失败');
						}
						closeDiv.click();
					});
				}
			};
		});
	}
</script>

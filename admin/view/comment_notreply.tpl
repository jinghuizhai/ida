<div class="main-inner">
	<p class="p-title">
	未回复
	</p>
	<table class="p-table">
		<thead>
			<th>身份</th>
			<th>用户</th>
			<th>评论</th>
			<th>时间</th>
			<th>回复</th>
			<th>删除</th>
		</thead>
		<tbody>
			<?php if(!empty($comments)){ 
				foreach($comments as $key => $value){
			?>
				<tr>
					<td>
						<form action="<?php echo HOSTNAME;?>admin/reply/add" method="post">
						<input type="hidden" name="<?php echo $value['comment_id'];?>">
						<?php echo $value['rname'];?>
					</td>
					<td>
						<?php echo $value['name'];?>
					</td>
					<td>
						<?php echo $value['content'];?>
					</td>
					<td>
						<?php echo $value['date'];?>
					</td>
					<td>
						<a href="javascript:;" data-id="<?php echo $value['comment_id'];?>" onclick="reply(this);" class="btn">回复</a>
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
	<button class="btn r">回复</button>
</div>
<script type="text/javascript">
	function reply(othis){
		var reply = zjh.get('reply');
		zjh.pop('回复',reply,500,300,function(closeDiv){
			var area = reply.getElementsByTagName('textarea')[0];
			var btn = reply.getElementsByTagName('button')[0];
			area.focus();
			btn.onclick = function(){
				if(area.value.length < 1){
					alert('回复不能为空');
				}else{
					zjh.POST('<?php echo HOSTNAME;?>admin/reply/add',{
						'comment_id':othis.getAttribute('data-id'),
						'content':area.value.trim()
					},function(r){
						if(r){
							area.value = '';
							var tr = othis.parentNode.parentNode;
							zjh.animate(tr,{
								'height':'0px'
							},function(){
								tr.parentNode.removeChild(tr);
							});
						}else{
							alert('评论失败');
						}
						closeDiv.click();
					});
				}
			};
		});
	}
</script>

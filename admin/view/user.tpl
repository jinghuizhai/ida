<div class="main-inner">
	<p class="p-title">
		所有会员
	</p>
	<table class="p-table p-code">
		<thead>
			<th>ID</th>
			<th>角色</th>
			<th>名称</th>
			<th>电话</th>
			<th>银行名称</th>
			<th>银行账户</th>
			<th>提现</th>
			<th>分公司</th>
			<th>业务员</th>
			<th>代理</th>
			<th>分代理</th>
			<th>所属会员</th>
			<th width="100">链接</th>
			<th>原生二维</th>
			<th>LOGO二维</th>
			<th>更新</th>
			<th>修改密码</th>
			<th>删除</th>
		</thead>
		<tbody>
			<?php if(!empty($users)){
				foreach($users as $key => $value){
			?>		
				<tr>
					<td>
						<form action="<?php echo HOSTNAME;?>admin/user/update" method="post" id="formtag_<?php echo $key;?>">
						<input type="hidden" name="user_id" value="<?php echo $value['user_id'];?>" />
						<?php echo $value['user_id'];?>
					</td>
					<td>
						<?php
							echo $value['rname'];
						?>
					</td>
					<td>
						<?php echo $value['name'];?>
					</td>
					<td>
						<?php echo $value['phone'];?>
					</td>
					<td>
						<?php echo $value['paybank'];?>
					</td>
					<td>
						<?php echo $value['paycount'];?>
					</td>
					<td>
						<?php if(empty($value['can_cashout'])){
							echo '<b>不能</b>';
						}else{
							echo '能';
						} ?>
					</td>
					<td>
						<?php echo $value['branch_id'];?>
					</td>
					<td>
						<?php echo $value['sale_id'];?>
					</td>
					<td>
						<?php echo $value['agent_id'];?>
					</td>
					<td>
						<?php echo $value['subagent_id'];?>
					</td>
					<td>
						<?php echo $value['p_id'];?>
					</td>
					<td>
						<a target="_blank" href="<?php echo HOSTNAME;?>home/register/<?php echo $value['link'];?>">
							<?php echo $value['link'];?>
						</a>
					</td>
					<td>
						<?php if(!empty($value['linkimg'])){ ?>
						<a target="_blank" href="<?php echo HOSTNAME.'qcode/'.$value['linkimg'];?>">
							<img src="<?php echo HOSTNAME.'qcode/'.$value['linkimg'];?>" />
						</a>
						<?php } ?>
					</td>
					<td>
						<?php if(!empty($value['logoimg'])){ ?>
						<a target="_blank" href="<?php echo HOSTNAME.'qcode/'.$value['logoimg'];?>">
							<img src="<?php echo HOSTNAME.'qcode/'.$value['logoimg'];?>" />
						</a>
						<?php } ?>
					</td>
					<td>
						<a class="btn small b-green" href="<?php echo HOSTNAME;?>admin/user/update/<?php echo $value['user_id'];?>">更新</a>
					</td>
					<td>
						<a class="btn small" href="<?php echo HOSTNAME;?>admin/user/pass_update/<?php echo $value['user_id'];?>">修改密码</a>
					</td>
					<td>
						<button data-id="formtag_<?php echo $key;?>" class="btn small b-red" onclick="return checkUser(this);">删除</button>
						</form>
					</td>
				</tr>
			<?php }} ?>
		</tbody>
	</table>
	<div class="pagination">
		<?php echo $pagination;?>
	</div>
</div>
<script type="text/javascript">
	function checkUser(othis){
		var r = confirm('请谨慎，真的要删除么？');
		if(r){
			var dataId = othis.getAttribute('data-id');
			var form = zjh.get(dataId);
			form.setAttribute('action','<?php echo HOSTNAME;?>admin/user/delete');
			form.submit();
		}else{
			return false;
		}
	}

</script>
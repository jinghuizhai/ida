<div class="main-inner">
	<p class="p-title">未审核提现记录</p>
	<button onclick="passAll(this)" class="btn b-red mb20">批量通过</button>
	<table class="p-table">
		<thead>
			<th><input type="checkbox" onclick="selectAll(this);" id="select-all"><label for="select-all">全选</label></th>
			<th>姓名</th>
			<th>兑换金额</th>
			<th>日期</th>
			<th>操作</th>
		</thead>
		<tbody>
			<?php
				if(!empty($cashouts)){
				foreach($cashouts as $key => $value){
			?>
			<tr>
				<td>
					<input type="checkbox" name="transfer_id" value="<?php echo $value['cashout_history_id'];?>" />
				</td>
				<td>
					<?php echo $value['name'];?>
				</td>
				<td>
					<?php if($value['money'] >= 20){ ?>
						<span class='red'><?php echo $value['money'];?></span>
					<?php }else{
						echo $value['money'];
					} ?>
				</td>
				<td>
					<?php echo $value['date'];?>
				</td>
				<td>
					<button data-id="<?php echo $value['cashout_history_id'];?>" onclick="passMe(this)" class="btn b-green">通过</button>
				</td>
			</tr>
			<?php }} ?>
		</tbody>
	</table>
	<?php echo $pagination;?>
</div>
<script type="text/javascript">
	
	function selectAll(othis){
		var tbody = document.getElementsByTagName('tbody')[0],
			checks = tbody.getElementsByTagName('input');
		for(var i = 0,len = checks.length;i<len;i++){
			var c = checks[i];
			if(c.getAttribute('type') == 'checkbox'){
				c.checked = othis.checked;
			}
		}
	}
	function passAll(othis){
		var tbody = document.getElementsByTagName('tbody')[0],
			checks = tbody.getElementsByTagName('input');
		var carr = [];
		var objarr = [];

		for(var i = 0,len = checks.length;i<len;i++){
			var c = checks[i];
			if(c.getAttribute('type') == 'checkbox'){
				if(c.checked){
					carr.push(c.value);
					objarr.push(c);
				}
			}
		}
		if(carr.length){
			var str = carr.join(",");
			passCheck(str,function(r){
				if(r == 'success'){
					for(var i = 0,len = objarr.length;i<len;i++){
						var c = objarr[i];
						var ele = c.parentNode.parentNode;
						ele.parentNode.removeChild(ele);
					}
				}else{
					alert('批量审核失败');
				}
			});
		}else{
			alert('请先选中要审核的信息');
		}
	}
	function passMe(othis){
		var transfer_id = othis.getAttribute('data-id');
		passCheck(transfer_id,function(r){
			if(r == 'success'){
				var ele = othis.parentNode.parentNode;
				ele.parentNode.removeChild(ele);
			}else{
				alert('审核失败');
			}
		});
	}
	function passCheck(str,fn){
		zjh.POST('<?php echo HOSTNAME;?>admin/cashoutHistory/check',{'ids':str},function(r){
			if(fn){
				fn(r.trim());
			}
		});
	}
</script>
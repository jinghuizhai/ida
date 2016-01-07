<div class="main-inner">
	<p class="p-title">已审核提现记录</p>
	<table class="p-table">
		<thead>
			<th>姓名</th>
			<th>兑换金额</th>
			<th>日期</th>
		</thead>
		<tbody>
			<?php
				if(!empty($cashouts)){
				foreach($cashouts as $key => $value){
			?>
			<tr>
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
			</tr>
			<?php }} ?>
		</tbody>
	</table>
	<?php echo $pagination;?>
</div>

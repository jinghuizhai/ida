<script type="text/javascript" src="<?php echo HOSTNAME;?>style/js/laydate/laydate.js"></script>
<div class="main-inner">
	<p class="p-title">推荐的订单</p>
	<div class="tool-bar">
		<form action="<?php echo HOSTNAME;?>order/recommend" method="get">
			<?php if(!empty($tags)){ ?>
			<select name="tag">
				<?php foreach($tags as $key => $value){ ?>
					<option value="<?php echo $key;?>"><?php echo $value;?></option>
				<?php } ?>
			</select>
			<?php } ?>
			<span>
				<label>开始日期</label>
				<input name="date_start" placeholder="请输入日期" class="laydate-icon" onclick="laydate({format:'YYYY-MM-DD hh:mm:ss'})" value="<?php echo $date_start;?>"/>
			</span>
			<span>
				<label>结束日期</label>
				<input name="date_end" placeholder="请输入日期" class="laydate-icon" onclick="laydate({format:'YYYY-MM-DD hh:mm:ss'})" value="<?php echo $date_end;?>"/>
			</span>
			<span>
				<label>姓名</label>
				<input type="text" name="name" value="<?php echo $name;?>" id="name"/>
			</span>
			<span>
				<button>查询</button>
				<a onclick="zjh.get('name').value=null;">清空</a>
			</span>
		</form>
	</div>
	<table class="p-table">
		<thead>
			<th>姓名</th>
			<th>电话</th>
			<th>订单号</th>
			<th>付款</th>
			<th>日期</th>
		</thead>
		<tbody>
			<?php
				if(!empty($orders)){
				foreach($orders as $key => $value){
			?>
			<tr>
				<td>
					<a class="blue" href="<?php echo HOSTNAME.'user/info/'.$value['user_id'];?>"><?php echo $value['name'];?></a>
				</td>
				<td>
					<?php echo $value['phone'];?>
				</td>
				<td>
					<?php echo $value['order_code'];?>
				</td>
				<td>
					<?php echo $value['money'];?>
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
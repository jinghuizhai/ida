<div class="main-inner">
	<h1 class="p-title">所有商品</h1>
	<table class="p-table">
		<thead>
			<th>名称</th>
			<th>价格</th>
			<th>免运费</th>
			<th>运费</th>
			<th>偏远运费</th>
			<th>积分</th>
			<th>库存</th>
			<th>属性组</th>
			<th>title</th>
			<th>keywords</th>
			<th>description</th>
			<th>点击</th>
			<th>点赞</th>
			<th>返直接推荐</th>
			<th>返工作人员</th>
			<th>操作</th>
			<th>操作</th>
		</thead>
		<tbody>
			<?php if(!empty($products)){
				foreach($products as $key => $value){
			?>
				<tr>
					<td>
						<form action="<?php echo HOSTNAME;?>admin/product/delete" method="post" id="formtag_<?php echo $key;?>">
						<input type="hidden" name="product_id" value="<?php echo $value['product_id'];?>">
						<a target="_blank" href="<?php echo HOSTNAME.'product/'.$value['product_id'];?>">
							<?php echo $value['name'];?>
						</a>
					</td>
					<td>
						<?php echo $value['price'];?>
					</td>
					<td>
						<?php if($value['free_postage'] == 0){
							echo '免运费';
						}else{
							echo '不免运费';
						}
						?>
					</td>
					<td>
						<?php echo $value['postage'];?>
					</td>
					<td>
						<?php echo $value['postage_remote'];?>
					</td>
					<td>
						<?php echo $value['score'];?>
					</td>
					<td>
						<?php 
							if(empty($value['stock'])){
								echo 0;
							}else{
								echo $value['stock'];
							}
						?>
					</td>
					<td>
						<?php echo $value['att_group_id'];?>
					</td>
					<td>
						<?php echo $value['title'];?>
					</td>
					<td>
						<?php echo $value['keywords'];?>
					</td>
					<td>
						<?php echo $value['description'];?>
					</td>
					<td>
						<?php echo $value['hits'];?>
					</td>
					<td>
						<?php echo $value['likes'];?>
					</td>
					<td>
						<?php echo empty($value['for_presenter'])?0 : $value['for_presenter'];?>￥
					</td>
					<td>
						<?php echo empty($value['for_workers'])?0 : $value['for_workers'];?>￥
					</td>
					<td>
						<a href="<?php echo HOSTNAME;?>admin/product/update/<?php echo $value['product_id'];?>" class="btn b-green">修改</a>
					</td>
					<td>
						<button data-id="formtag_<?php echo $key;?>" class="btn b-red" onclick="return checkDelete(this);">删除</button>
						</form>
					</td>
				</tr>
			<?php }} ?>
		</tbody>
	</table>
</div>
<script type="text/javascript">
	function checkDelete(othis){
		var r = confirm('确定删除？');
		return r;
	}	
</script>
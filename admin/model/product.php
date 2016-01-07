<?php
	class ModelProduct extends Model{
		private $product_id;//p key
		private $catalog_id;// f key
		private $name;
		private $price;
		private $free_postage;// 0 == 免运费 1==不免
		private $postage;
		private $score;//给推荐者都少积分
		private $imgs;
		private $detail;
		private $attr_group_id;
		private $title;
		private $keywords;
		private $description;
		private $hits;
		private $likes;
		private $for_presenter;//为直接推荐者返钱数
		private $for_workers;//为业务人员返钱数
		private $date;
		function add($arr){
			return $this->db->exec('insert into `product` set 
				catalog_id=:catalog_id,
				name=:name,
				price=:price,
				free_postage=:free_postage,
				postage=:postage,
				postage_remote=:postage_remote,
				score=:score,
				stock=:stock,
				detail=:detail,
				attr_group_id=:attr_group_id,
				title=:title,
				keywords=:keywords,
				description=:description,
				hits=:hits,
				likes=:likes,
				for_presenter=:for_presenter,
				for_workers=:for_workers,
				date=:date
			',$arr);
		}
		function update($arr){
			return $this->db->exec('update `product` set 
				catalog_id=:catalog_id,
				name=:name,
				price=:price,
				free_postage=:free_postage,
				postage=:postage,
				postage_remote=:postage_remote,
				score=:score,
				stock=:stock,
				detail=:detail,
				attr_group_id=:attr_group_id,
				title=:title,
				keywords=:keywords,
				description=:description,
				hits=:hits,
				likes=:likes,
				for_presenter=:for_presenter,
				for_workers=:for_workers
				where product_id=:product_id
			',$arr);
		}
		function find(){
			return $this->db->query('select * from `product`');
		}
		function findById($product_id){
			return $this->db->queryOne('select * from `product` where product_id=?',$product_id);
		}
		function addLike($product_id){
			return $this->db->exec('update `product` set like=like+1 where product_id=?',$product_id);
		}
		function delete($product_id){
			return $this->db->exec('delete from `product` where product_id=?',$product_id);
		}
	}
?>
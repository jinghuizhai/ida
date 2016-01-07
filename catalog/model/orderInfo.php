<?php
	class ModelOrderInfo extends Model{
		private $order_info_id;
		private $order_id;
		private $product_id;
		private $money;

		function add($arr){
			return $this->db->exec('insert into `order_info` set
				order_id=:order_id,
				product_id=:product_id,
				piece=:piece,
				postage=:postage,
				price=:price,
				money=:money
			',$arr);
		}
		function findByOrderid($order_id){
			return $this->db->query('select * from `order_info` where order_id=?',$order_id);
		}
		function findInfoById($order_id){
			return $this->db->query('select 
				p.price,
				p.postage,
				p.free_postage,
				p.score,
				p.for_presenter,
				p.for_workers,
				p.name,
				i.piece
				from `orders` o,`product` p,`order_info` i 
				where o.order_id = i.order_id 
				and i.product_id = p.product_id
				and o.order_id=?
				',$order_id);
		}
		function findInfoByUserid($user_id,$order_id){
			return $this->db->query('select 
				p.price,
				p.postage,
				p.free_postage,
				p.score,
				p.for_presenter,
				p.for_workers,
				p.name,
				i.piece
				from `orders` o,`product` p,`order_info` i 
				where o.order_id = i.order_id 
				and i.product_id = p.product_id
				and o.user_id=?
				and o.order_id=?
				',array($user_id,$order_id));
		}
	}
?>
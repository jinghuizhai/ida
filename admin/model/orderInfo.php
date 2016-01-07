<?php
	class ModelOrderInfo extends Model{
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
	}
?>
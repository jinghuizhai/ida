<?php 
	class ModelCart extends Model{
		function findById($product_id){
			return $this->db->queryOne('select p.free_postage,p.product_id,p.name,i.thumbnail,p.postage,p.postage_remote,p.price from `product` p ,`img` i where p.product_id = i.product_id and p.product_id = ?',$product_id);
		}
	}
?>
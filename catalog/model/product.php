<?php
	class ModelProduct extends Model{
		function findById($product_id){
			return $this->db->queryOne('select * from `product` where product_id=?',$product_id);
		}
		function findByCatalog(){
			return $this->db->query('select * from `product` where catalog_id=?',$catalog_id);
		}
		function updateLikes($product_id){
			return $this->db->exec('update `product` set likes = likes+1 where product_id=?',$product_id);
		}
	}
?>
<?php
	class ModelImg extends Model{
		function findById($img_id){
			return $this->db->queryOne('select * from `img` where img_id=?',$img_id);
		}
		function findByName($name){
			return $this->db->query('select * from `img` where name=?',$name);
		}
		function findByProductid($product_id){
			return $this->db->query('select * from `img` where product_id=?',$product_id);
		}
	}
?>
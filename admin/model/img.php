<?php
	class ModelImg extends Model{
		private $img_id;
		private $name;
		private $product_id;
		
		function add($name,$thumbnail){
			return $this->db->exec('insert into `img` set name=?,thumbnail=?',array($name,$thumbnail));
		}
		function findById($img_id){
			return $this->db->queryOne('select * from `img` where img_id=?',$img_id);
		}
		function find($page){
			return $this->db->query('select * from `img`',array(),$page);
		}
		function findByName($name){
			return $this->db->query('select * from `img` where name=?',$name);
		}
		function findByProductid($product_id){
			return $this->db->query('select * from `img` where product_id=?',$product_id);
		}
		function updateProductid($img_id,$product_id){
			return $this->db->exec('update `img` set product_id=? where img_id=?',array($product_id,$img_id));
		}
		function delete($img_id){
			return $this->db->exec('delete from `img` where img_id=?',$img_id);
		}
		function deleteByProductid($product_id){
			return $this->db->exec('delete from `img` where product_id=?',$product_id);
		}
	}
?>
<?php
	class ModelAttr extends Model{
		//table attr
		private $attr_id;
		private $name;

		function add($name){
			return $this->db->exec('insert into `attr` set name=?',$name);
		}
		function delete($attr_id){
			return $this->db->exec('delete from `attr` where attr_id=?',$attr_id);
		}
		function update($attr_id,$name){
			return $this->db->exec('update `attr` set name=? where attr_id=?',array($name,$attr_id));
		}
		function find(){
			return $this->db->query('select * from `attr`');
		}
		function findById($attr_id){
			return $this->db->queryOne('select * from `attr` where attr_id=?',$attr_id);
		}
	}
?>
<?php
	class ModelAttr_value extends Model{
		//table attr_value
		private $attr_value_id;//p key
		private $attr_group_id;//f key
		private $attr_id;//f key
		private $value;
		//table attr_value
		function add($arr){
			return $this->db->exec('insert into `attr_value` set 
				attr_group_id=:attr_group_id,
				attr_id=:attr_id,
				value=:value
			',$arr);
		}
		function findById($attr_value_id){
			return $this->db->queryOne('select * from `attr_value` where attr_value_id=?',$attr_value_id);
		}
		function update($attr_value_id,$value){
			return $this->db->exec('update `attr_value` set value=? where attr_value_id=?',array($value,$attr_value_id));
		}
		function delete($attr_value_id){
			return $this->db->exec('delete from `attr_value` where attr_value_id=?',$attr_value_id);
		}
	}
?>
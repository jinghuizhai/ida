<?php
	class ModelAttr_value extends Model{
		function findByGroupid($attr_group_id){
			return $this->db->query('select a.name,v.value from `attr` a ,`attr_group` g,`attr_value` v where g.attr_group_id = v.attr_group_id and v.attr_id = a.attr_id and g.attr_group_id = ?',$attr_group_id);
		}
	}
?>
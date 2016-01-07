<?php
	class ModelAttr_group extends Model{
		//table attr_group
		private $attr_group_id;
		private $name;

		function add($name){
			return $this->db->exec('insert into `attr_group` set name=?',$name);
		}
		function findName(){
			return $this->db->query('select * from `attr_group`');
		}
		function find(){
			return $this->db->query("select p.attr_group_id,u.attr_id,u.name,u.value,p.name pname from `attr_group` p left join (select a.attr_id,a.name,v.attr_group_id,v.value from `attr` a ,`attr_value` v where a.attr_id = v.attr_id) u on p.attr_group_id = u.attr_group_id");
		}
		function findGroup($attr_group_id){
			return $this->db->queryOne('select * from `attr_group` where attr_group_id=?',$attr_group_id);
		}
		function findJoinLeft($attr_group_id){
			return $this->db->query('select a.attr_id,
				a.name,
				u.attr_group_id,
				u.attr_value_id,
				u.value
				from `attr` a left join 
				(select g.name,v.* 
					from `attr_group` g,`attr_value` v 
					where g.attr_group_id = v.attr_group_id
					and g.attr_group_id=?
				) u  
			on a.attr_id = u.attr_id',$attr_group_id);
		}
		function delete($attr_group_id){
			return $this->db->exec('delete from `attr_group` where attr_group_id=?',$attr_group_id);
		}
		function update($attr_group_id,$name){
			return $this->db->exec('update `attr_group` set name=? where attr_group_id=?',array($name,$attr_group_id));
		}
	}
?>
<?php
	class ModelRole extends Model{
		function findByTag($tag){
			return $this->db->queryOne('select * from `roles` where tag = ?',$tag);
		}
	}
?>
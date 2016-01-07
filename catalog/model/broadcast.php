<?php
	class ModelBroadcast extends Model{
		function findByRoleid($role_id){
			return $this->db->query('select * from `broadcast` where (role_id=? or role_id = 0) and now() > date_start and now() < date_end',$role_id);
		}
	}
?>
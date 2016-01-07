<?php
	class ModelConfigs extends Model{
		function findMoney(){
			return $this->db->queryOne('select money from `configs` where configs_id=1');
		}
		function updateMoney($money){
			return $this->db->exec('update `configs` set money=? where configs_id=1',$money);
		}
	}
?>
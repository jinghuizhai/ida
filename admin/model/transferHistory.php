<?php
	class ModelTransferHistory extends Model{
		private $transfer_history_id;
		private $user_id;
		private $score,
		private $money;
		private $date;
		
		function findByUserid($user_id){
			return $this->db->query('select * from `transfer_history` where user_id=?',$user_id);
		}
		function countMoney($user_id){
			return $this->db->queryOne('select sum(money) money from `transfer_history` where user_id=?',$user_id);
		}
	}
?>
<?php
	class ModelCashoutHistory extends Model{
		private $cashout_history_id;
		private $user_id;
		private $score;
		private $money;
		private $date;

		function add($arr){
			return $this->db->exec('insert into `cashout_history` set
				user_id=:user_id,
				money=:money,
				status=:status,
				date=:date
			',$arr);
		}
		function findByUserid($user_id,$page){
			return $this->db->query('select * from `cashout_history` where user_id=?',$user_id,$page);
		}
	}
?>
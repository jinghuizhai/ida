<?php
	class ModelTransferHistory extends Model{
		private $transfer_history_id;
		private $user_id;
		private $score;
		private $money;
		private $date;

		function add($arr){
			return $this->db->exec('insert into `transfer_history` set
				user_id=:user_id,
				score=:score,
				money=:money,
				date=:date
			',$arr);
		}
		function findByUserid($user_id){
			return $this->db->query('select * from `transfer_history` where user_id=?',$user_id);
		}
	}
?>
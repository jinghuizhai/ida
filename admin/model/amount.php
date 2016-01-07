<?php
	class ModelAmount extends Model{
		private $amount_id;//p key
		private $user_id;//f key
		private $money;
		private $score;
		function add($arr){
			return $this->db->exec('insert into `amount` set 
				user_id=:user_id,
				money=:money,
				score=:score
			',$arr);
		}
	}
?>
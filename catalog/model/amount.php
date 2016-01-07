<?php
	class ModelAmount extends Model{
		private $amount_id;
		private $user_id;
		private $money;
		private $score;

		function findByUserid($user_id){
			return $this->db->queryOne('select * from `amount` where user_id=?',$user_id);
		}
		function add($arr){
			return $this->db->exec('insert into `amount` set 
				user_id=:user_id,
				money=:money,
				score=:score
			',$arr);
		}
		function updateMoney($user_id,$addmoney){
			return $this->db->exec('update `amount` set money=money+? where user_id=?',array($addmoney,$user_id));
		}
		function updateScore($user_id,$addscore){
			return $this->db->exec('update `amount` set score=score+? where user_id=?',array($addscore,$user_id));
		}
		function clearMoney($user_id){
			return $this->db->exec('update `amount` set money=0 where user_id=?',$user_id);
		}
		function update($arr){
			return $this->db->exec('update `amount` set
				money=:money,
				score=:score
				where amount_id=:amount_id
				and user_id=:user_id
			',$arr);
		}

	}
?>
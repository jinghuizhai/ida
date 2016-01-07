<?php 
	class ModelCashoutHistory extends Model{
		private $cashout_history_id;
		private $user_id;
		private $money;
		private $status;
		private $date;

		function findByUserid($user_id){
			return $this->db->query('select * from `cashout_history` where user_id=?',$user_id);
		}
		function countMoney(){
			return $this->db->queryOne('select sum(money) money from `cashout_history` where status=1');
		}
		function find($page){
			return $this->db->query('select * from `cashout_history`',$page);
		}
		function findByStatus($status,$page){
			return $this->db->query('select u.name,u.phone,c.money,c.date from `cashout_history` c,`user` u where u.user_id = c.user_id and status=:status',array('status'=>$status),$page);
		}
		function countByStatus($status){
			return $this->db->queryOne('select count(*) count from `cashout_history` where status=:status',array('status'=>$status));
		}
		function updateStatus($cashout_history_id){
			return $this->db->exec('update `cashout_history` set status=1 where cashout_history_id=?',$cashout_history_id);
		}
	}
?>
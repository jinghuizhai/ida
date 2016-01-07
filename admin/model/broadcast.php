<?php
	class ModelBroadcast extends Model{
		private $broadcast_id;
		private $content;
		private $role_id;
		private $date_start;
		private $date_end;
		private $date;

		function add($arr){
			return $this->db->exec('insert into `broadcast` set
				content=:content,
				role_id=:role_id,
				date_start=:date_start,
				date_end=:date_end,
				date=:date
			',$arr);
		}
		function findByRoleid($role_id){
			return $this->db->query('select * from `broadcast` where role_id=? and now() > date_start and now() < date_end',$role_id);
		}
		function findById($broadcast_id){
			return $this->db->queryOne('select * from `broadcast` where broadcast_id=?',$broadcast_id);
		}
		function find(){
			return $this->db->query('select * from `broadcast`');
		}
		function update($arr){
			return $this->db->exec('update `broadcast` set 
				content=:content,
				role_id=:role_id,
				date_start=:date_start,
				date_end=:date_end
				where 
				broadcast_id=:broadcast_id
			',$arr);
		}
		function delete($broadcast_id){
			return $this->db->exec('delete from `broadcast` where broadcast_id=?',$broadcast_id);
		}
	}
?>
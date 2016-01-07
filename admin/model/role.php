<?php
	class ModelRole extends Model{
		private $role_id;
		private $tag;
		private $entrance;//入口 front,backstage;
		private $name;

		function find(){
			return $this->db->query('select * from `roles`');
		}
		function findById($role_id){
			return $this->db->queryOne('select * from `roles` where role_id=?',$role_id);
		}
		function findByTag($tag){
			return $this->db->queryOne('select * from `roles` where tag=?',$tag);
		}
		function add($arr){
			return $this->db->exec('insert into `roles` set 
				name=:name,
				tag=:tag,
				entrance=:entrance,
				permission=:permission
			',$arr);
		}
		function update($arr){
			return $this->db->exec('update `roles` set 
				entrance=:entrance,
				name=:name,
				tag=:tag,
				permission=:permission 
				where role_id=:role_id',$arr);
		}
		function delete($role_id){
			return $this->db->exec('delete from `roles` where role_id=?',$role_id);
		}
		function findByName($name,$tag){
			return $this->db->queryOne('select * from `roles` where name=? or tag=?',array($name,$tag));
		}
		function findByEntrance($entrance){
			return $this->db->query('select * from `roles` where entrance=?',$entrance);
		}
	}
?>
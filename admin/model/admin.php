<?php
	class ModelAdmin extends Model{
		private $admin_id;
		private $email;
		private $name;
		private $pass;
		private $permission;

		function add($arr){
			return $this->db->exec('insert into `admin` set email=:email,name=:name,pass=:pass,role_id=:role_id',$arr);
		}
		function find($email,$pass){
			return $this->db->queryOne('select a.admin_id,a.name,a.email,r.name,r.tag,r.permission,r.role_id from `admin` a left join `roles` r on a.role_id = r.role_id where a.email=? and a.pass=?',array($email,$pass));
		}
		function findSubadmin(){
			return $this->db->query("select r.name rname,a.name,a.email,a.admin_id from `roles` r ,`admin` a where r.role_id = a.role_id and r.entrance = 'backstage'");
		}
		function update($arr){
			return $this->db->exec('udpate `admin` set
				email=:email,
				name=:name,
				pass=:pass,
				permission=:permission
				where admin_id=:admin_id
				',$arr);
		}
		function updatePass($arr){
			return $this->db->exec('update `admin` set pass=:pass where pass=:old_pass',$arr);
		}
		function delete($admin_id){
			return $this->db->exec('delete * from `admin` where admin_id=?',$admin_id);
		}
	}
?>
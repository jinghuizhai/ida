<?php
	class ModelUser extends Model{
		private $user_id;//p key
		private $email;
		private $pass;
		private $name;
		private $phone;
		private $identity;
		private $paybank;
		private $paycount;
		private $p_id;
		private $a_id;
		private $s_id;
		private $link;
		private $linkimg;
		private $logoimg;
		
		// function add($arr){
		// 	return $this->db->exec('insert into `user` set 
		// 		p_id=:p_id,
		// 		sale_id=:sale_id,
		// 		agent_id=:agent_id,
		// 		email=:email,
		// 		pass=:pass,
		// 		phone=:phone,
		// 		identity=:identity,
		// 		name=:name
		// 		',$arr);
		// }
		function add($arr){
			return $this->db->exec('insert into `user` set
				p_id=:p_id,
				role_id=:role_id,
				branch_id=:branch_id,
				sale_id=:sale_id,
				agent_id=:agent_id,
				subagent_id=:subagent_id,
				pass=:pass,
				phone=:phone,
				date=:date,
				can_cashout=:can_cashout,
				name=:name
			',$arr);
		}
		function findCountByDate($start,$end){
			return $this->db->queryOne('select count(*) count from `user` where date>=? and date<=?',array($start,$end));
		}
		function updateQcode($arr){
			return $this->db->exec('update `user` set
				link=:link,
				linkimg=:linkimg,
				logoimg=:logoimg
				where user_id=:user_id
			',$arr);
		}
		function updatePass($user_id,$pass){
			return $this->db->exec('
				update `user` set pass=? where user_id=?
			',array($pass,$user_id));
		}
		function findById($user_id){
			return $this->db->queryOne('select * from `user` where user_id=:user_id',array('user_id'=>$user_id));
		}
		function find($page){
			return $this->db->query('select u.*,r.name rname from `user` u,`roles` r where r.role_id = u.role_id',null,$page);
		}
		function findByRole($user_id,$role_id){
			return $this->db->queryOne('select u.user_id,u.branch_id,u.sale_id,u.agent_id,u.p_id from `user` u,`roles` r where u.user_id = ? and r.role_id = u.role_id and r.tag = ?',array($user_id,$role_id));
		}
		function findByIdentity($identity){
			return $this->db->query('select * from 	`user` where identity=?',$identity);
		}
		function findByEmail($email){
			return $this->db->queryOne('select * from `user` where email=?',$email);
		}
		function findByPhone($phone){
			return $this->db->queryOne('select * from `user` where phone=?',$phone);
		}
		function findImg($user_id){
			return $this->db->queryOne('select linkimg,logoimg from `user` where user_id=?',$user_id);
		}
		function delete($user_id){
			return $this->db->exec('delete from `user` where user_id=?',$user_id);
		}
		function update($arr){
			return $this->db->exec('update `user` set 
				name=:name,
				phone=:phone,
				can_cashout=:can_cashout,
				paybank=:paybank,
				paycount=:paycount
				where user_id=:user_id
			',$arr);
		}
	}
?>
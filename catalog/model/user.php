<?php
	class ModelUser extends Model{
		function findPaycount($user_id){
			return $this->db->queryOne('select paycount from `user` where user_id=? and paycount is not null',$user_id);
		}
		function findDetailByBranch($branch_id,$user_id){
			return $this->db->queryOne('select 
				u.name,
				u.user_id,
				u.phone,
				u.paybank,
				u.paycount,
				u.can_cashout,
				u.date,
				u.link,
				u.linkimg,
				u.logoimg,
				r.role_id,
				r.tag,
				u.p_id,
				u.branch_id,
				u.sale_id,
				u.agent_id,
				u.subagent_id,
				r.name rname 
				from `user` u,`roles` r 
				where u.role_id = r.role_id 
				and r.entrance = "front" 
				and u.branch_id=?
				and u.user_id=?
				',array($branch_id,$user_id));
		}
		function findDetailBySale($sale_id,$user_id){
			return $this->db->queryOne('select 
				u.name,
				u.user_id,
				u.phone,
				u.paybank,
				u.paycount,
				u.can_cashout,
				u.date,
				u.link,
				u.linkimg,
				u.logoimg,
				r.role_id,
				r.tag,
				u.p_id,
				u.branch_id,
				u.sale_id,
				u.agent_id,
				u.subagent_id,
				r.name rname 
				from `user` u,`roles` r 
				where u.role_id = r.role_id 
				and r.entrance = "front" 
				and u.sale_id=?
				and u.user_id=?
				',array($sale_id,$user_id));
		}
		function findDetailByAgent($agent_id,$user_id){
			return $this->db->queryOne('select 
				u.name,
				u.user_id,
				u.phone,
				u.paybank,
				u.paycount,
				u.can_cashout,
				u.date,
				u.link,
				u.linkimg,
				u.logoimg,
				r.role_id,
				r.tag,
				u.p_id,
				u.branch_id,
				u.sale_id,
				u.agent_id,
				u.subagent_id,
				r.name rname 
				from `user` u,`roles` r 
				where u.role_id = r.role_id 
				and r.entrance = "front" 
				and u.agent_id=?
				and u.user_id=?
				',array($agent_id,$user_id));
		}
		function findDetailBySubagent($subagent_id,$user_id){
			return $this->db->queryOne('select 
				u.name,
				u.user_id,
				u.phone,
				u.paybank,
				u.paycount,
				u.can_cashout,
				u.date,
				u.link,
				u.linkimg,
				u.logoimg,
				r.role_id,
				r.tag,
				u.p_id,
				u.branch_id,
				u.sale_id,
				u.agent_id,
				u.subagent_id,
				r.name rname 
				from `user` u,`roles` r 
				where u.role_id = r.role_id 
				and r.entrance = "front" 
				and u.subagent_id=?
				and u.user_id=?
				',array($subagent_id,$user_id));
		}
		function findDetailByMember($p_id,$user_id){
			return $this->db->queryOne('select 
				u.name,
				u.user_id,
				u.phone,
				u.paybank,
				u.paycount,
				u.can_cashout,
				u.date,
				u.link,
				u.linkimg,
				u.logoimg,
				r.role_id,
				r.tag,
				u.p_id,
				u.branch_id,
				u.sale_id,
				u.agent_id,
				u.subagent_id,
				r.name rname 
				from `user` u,`roles` r 
				where u.role_id = r.role_id 
				and r.entrance = "front" 
				and u.p_id=?
				and u.user_id=?
				',array($p_id,$user_id));
		}
		function countByBranch($user_id){
			return $this->db->queryOne('select count(*) count from `user` where branch_id=?',$user_id);
		}
		function countBySale($user_id){
			return $this->db->queryOne('select count(*) count from `user` where sale_id=?',$user_id);
		}
		function countByAgent($user_id){
			return $this->db->queryOne('select count(*) count from `user` where agent_id=?',$user_id);
		}
		function countBySubagent($user_id){
			return $this->db->queryOne('select count(*) count from `user` where subagent_id=?',$user_id);
		}
		function countByPid($user_id){
			return $this->db->queryOne('select count(*) count from `user` where p_id=?',$user_id);
		}
		// function find($email,$pass){
		// 	return $this->db->queryOne("select 
		// 		u.name,
		// 		u.phone,
		// 		u.user_id,
		// 		u.can_cashout,
		// 		r.role_id,
		// 		r.permission,
		// 		r.tag,
		// 		u.p_id,
		// 		u.branch_id,
		// 		u.sale_id,
		// 		u.agent_id,
		// 		u.subagent_id,
		// 		r.name rname 
		// 		from `user` u,`roles` r 
		// 		where u.role_id = r.role_id 
		// 		and r.entrance = 'front' 
		// 		and u.email=? and u.pass = ?",array($email,$pass));
		// }
		function findByPhonePass($phone,$pass){
			return $this->db->queryOne("select 
				u.name,
				u.phone,
				u.user_id,
				r.role_id,
				r.permission,
				r.tag,
				u.p_id,
				u.branch_id,
				u.sale_id,
				u.agent_id,
				u.subagent_id,
				r.name rname 
				from `user` u,`roles` r 
				where u.role_id = r.role_id 
				and r.entrance = 'front' 
				and u.phone=? and u.pass = ?",array($phone,$pass));
		}
		function findImgById($user_id){
			return $this->db->queryOne('select link,linkimg,logoimg from `user` where user_id=?',$user_id);
		}
		function findCashoutById($user_id){
			return $this->db->queryOne('select can_cashout from `user` where user_id=?',$user_id);
		}
		function findById($user_id){
			return $this->db->queryOne('select 
				u.name,
				u.user_id,
				u.phone,
				u.can_cashout,
				u.link,
				u.linkimg,
				u.logoimg,
				r.role_id,
				r.permission,
				r.tag,
				u.p_id,
				u.branch_id,
				u.sale_id,
				u.agent_id,
				u.subagent_id,
				r.name rname 
				from `user` u,`roles` r 
				where u.role_id = r.role_id 
				and r.entrance = "front" 
				and u.user_id=?
				',$user_id);
		}
		function findByPhone($phone){
			return $this->db->queryOne('select user_id from `user` where phone=?',$phone);
		}
		function findByLink($link){
			return $this->db->queryOne("select 
				u.user_id,
				u.link,
				u.p_id,
				u.branch_id,
				u.sale_id,
				u.agent_id,
				u.subagent_id,
				r.tag,
				r.role_id
				from `user` u,`roles` r 
				where u.role_id = r.role_id 
				and u.link = ?
				",$link);
		}
		// 通过管理员添加的信息必须有姓名
		function adminAdd($arr){
			return $this->db->exec("insert into `user` set
				name=:name,
				email=:email,
				pass=:pass,
				role_id=:role_id,
				branch_id=:branch_id,
				sale_id=:sale_id,
				agent_id=:agent_id,
				date=:date,
				p_id=:p_id
			",$arr);
		}
		function add($arr){
			return $this->db->exec("insert into `user` set
				phone=:phone,
				pass=:pass,
				name=:name,
				can_cashout=:can_cashout,
				role_id=:role_id,
				branch_id=:branch_id,
				sale_id=:sale_id,
				agent_id=:agent_id,
				subagent_id=:subagent_id,
				date=:date,
				p_id=:p_id
			",$arr);
		}
		function updateLink($arr){
			return $this->db->exec("update `user` set 
				link=:link,
				linkimg=:linkimg,
				logoimg=:logoimg
				where user_id=:user_id
			",$arr);
		}
		function updateQcode($arr){
			return $this->db->exec('update `user` set
				link=:link,
				linkimg=:linkimg,
				logoimg=:logoimg
				where user_id=:user_id
			',$arr);
		}
		function updateName($user_id,$name){
			return $this->db->exec('update `user` set name=? where user_id=?',array($name,$user_id));
		}
		function updatePass($user_id,$pass){
			return $this->db->exec('update `user` set pass=? where user_id=?',array($pass,$user_id));	
		}
		function updatePassByPhone($phone,$pass){
			return $this->db->exec('update `user` set pass=? where phone=?',array($pass,$phone));
		}
		function findByBranch($branch_id,$page){
			return $this->db->query('select u.user_id,r.name rname,u.name,u.email,u.phone,u.paybank,u.paycount,u.branch_id,u.p_id,u.sale_id,u.agent_id,u.subagent_id,u.link,u.linkimg,u.logoimg from `user` u,`roles` r where u.role_id = r.role_id and u.branch_id=?',$branch_id,$page);
		}
		function findBySale($sale_id,$page){
			return $this->db->query('select u.user_id,r.name rname,u.name,u.email,u.phone,u.paybank,u.paycount,u.branch_id,u.p_id,u.sale_id,u.agent_id,u.subagent_id,u.link,u.linkimg,u.logoimg from `user` u,`roles` r where u.role_id = r.role_id and u.sale_id=?',$sale_id,$page);
		}
		function findByAgent($agent_id,$page){
			return $this->db->query('select u.user_id,r.name rname,u.name,u.email,u.phone,u.paybank,u.paycount,u.branch_id,u.p_id,u.sale_id,u.agent_id,u.subagent_id,u.link,u.linkimg,u.logoimg from `user` u,`roles` r where u.role_id = r.role_id and u.agent_id=?',$agent_id,$page);
		}
		function findBySubAgent($subagent_id,$page){
			return $this->db->query('select u.user_id,r.name rname,u.name,u.email,u.phone,u.paybank,u.paycount,u.branch_id,u.p_id,u.sale_id,u.agent_id,u.subagent_id,u.link,u.linkimg,u.logoimg from `user` u,`roles` r where u.role_id = r.role_id and u.subagent_id=?',$subagent_id,$page);
		}
		function findByMember($p_id,$page){
			return $this->db->query('select u.user_id,r.name rname,u.name,u.email,u.phone,u.paybank,u.paycount,u.branch_id,u.p_id,u.sale_id,u.agent_id,u.subagent_id,u.link,u.linkimg,u.logoimg from `user` u,`roles` r where u.role_id = r.role_id and u.p_id=?',$p_id,$page);
		}
		function deleteById($user_id){
			return $this->db->exec('delete from `user` where user_id=?',$user_id);
		}
	}
?>
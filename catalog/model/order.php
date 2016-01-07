<?php
	class ModelOrder extends Model{
		// table orders,考虑到mysql保留字
		private $order_id;
		private $order_code;
		private $pay;
		private $send;
		private $user_id;
		private $address_id;
		private $money;
		private $pay_code;//微信支付或者阿里支付返回的支付宝交易号
		private $express_code;//和航标返回的快递订单号
		private $rebate_tag;//已经返佣的tag  0||null==未返佣 1==已经返佣
		private $date;

		function findDetailByid($order_id){
			return $this->db->queryOne('select u.name,u.phone,o.order_code,o.address,o.money from `orders` o,`user` u where u.user_id = o.user_id and o.order_id=?',$order_id);
		}
		function updateRebatetag($order_id,$pay_code){
			return $this->db->exec('update `orders` set pay_code=?,pay=1,rebate_tag=1 where order_id=?',array($pay_code,$order_id));
		}
		function updateSend($order_id){
			return $this->db->exec('update `orders` set send=1 where order_id=?',$order_id);
		}
		function findCountByDate($date_start,$date_end){
			return $this->db->queryOne('select count(*) count from `orders` where date>=? and date<=?',array($date_start,$date_end));
		}
		function findByOrdercode($order_code){
			return $this->db->queryOne('select * from `orders` where order_code=?',$order_code);
		}
		function updateExpress($order_id,$express_code){
			return $this->db->exec('update `orders` set express_code=? where order_id=?',array($express_code,$order_id));
		}
		function add($arr){
			return $this->db->exec('insert into `orders` set 
				pay=:pay,
				send=:send,
				user_id=:user_id,
				address_id=:address_id,
				address=:address,
				date=:date
			',$arr);
		}
		function updatePay($order_code,$user_id){
			return $this->db->exec('update `orders` set pay=1 where and order_code=? and user_id=? and pay=0 and send=0',array($order_code,$user_id));
		}
		function update($order_id,$order_code,$money){
			return $this->db->exec('update `orders` set order_code=?,money=? where order_id=?',array($order_code,$money,$order_id));
		}
		function findById($order_id){
			return $this->db->queryOne('select * from `orders` where order_id=?',$order_id);
		}
		function findByUserid($user_id){
			return $this->db->query('select * from `orders` where user_id=? and pay=1 and send=1',$user_id);
		}
		function countByBranch($user_id){
			return $this->db->queryOne('select count(*) count from `orders` o ,`user` u  where o.user_id = u.user_id  and o.pay=1 and o.send=1 and u.branch_id=?',$user_id);
		}
		function countBySale($user_id){
			return $this->db->queryOne('select count(*) count from `orders` o ,`user` u  where o.user_id = u.user_id  and o.pay=1 and o.send=1 and u.sale_id=?',$user_id);
		}
		function countByAgent($user_id){
			return $this->db->queryOne('select count(*) count from `orders` o ,`user` u  where o.user_id = u.user_id  and o.pay=1 and o.send=1  and u.agent_id=?',$user_id);
		}
		function countBySubagent($user_id){
			return $this->db->queryOne('select count(*) count from `orders` o ,`user` u  where o.user_id = u.user_id  and o.pay=1 and o.send=1  and u.subagent_id=?',$user_id);
		}
		function countByPid($user_id){
			return $this->db->queryOne('select count(*) count from `orders` o ,`user` u  where o.user_id = u.user_id  and o.pay=1 and o.send=1  and u.p_id=?',$user_id);
		}
		function findByBranch($arr,$page){
			return $this->db->query('select 
				u.user_id,
				u.name,
				u.phone,
				o.order_id,
				o.order_code,
				o.date,
				o.money 
				from `user` u,`orders` o 
				where u.user_id = o.user_id 
				and u.branch_id=:branch_id 
				and o.date>=:date_start and o.date<=:date_end
				and u.name like "%":name"%"
				'
				,$arr,$page);
		}
		function findBySale($arr,$page){
			return $this->db->query('select 
				u.user_id,
				u.name,
				u.phone,
				o.order_id,
				o.order_code,
				o.date,
				o.money 
				from `user` u,`orders` o 
				where u.user_id = o.user_id 
				and u.sale_id=:sale_id 
				and o.date>=:date_start and o.date<=:date_end
				and u.name like "%":name"%"
				'
				,$arr,$page);
		}
		function findByAgent($arr,$page){
			return $this->db->query('select 
				u.user_id,
				u.name,
				u.phone,
				o.order_id,
				o.order_code,
				o.date,
				o.money 
				from `user` u,`orders` o 
				where u.user_id = o.user_id 
				and u.agent_id=:agent_id 
				and o.date>=:date_start and o.date<=:date_end
				and u.name like "%":name"%"
				'
				,$arr,$page);
		}
		function findBySubagent($arr,$page){
			return $this->db->query('select 
				u.user_id,
				u.name,
				u.phone,
				o.order_id,
				o.order_code,
				o.date,
				o.money 
				from `user` u,`orders` o 
				where u.user_id = o.user_id 
				and u.subagent_id=:subagent_id 
				and o.date>=:date_start and o.date<=:date_end
				and u.name like "%":name"%"
				'
				,$arr,$page);
		}
		function findByPid($arr,$page){
			return $this->db->query('select 
				u.user_id,
				u.name,
				u.phone,
				o.order_id,
				o.order_code,
				o.date,
				o.money 
				from `user` u,`orders` o 
				where u.user_id = o.user_id 
				and u.p_id=:p_id 
				and o.date>=:date_start and o.date<=:date_end
				and u.name like "%":name"%"
				'
				,$arr,$page);
		}
		function findByme($user_id,$page){
			return $this->db->query('select 
				u.user_id,
				u.name,
				u.phone,
				o.order_id,
				o.address,
				o.order_code,
				o.date,
				o.money 
				from `user` u,`orders` o 
				where u.user_id = o.user_id 
				and u.user_id=?
				and o.pay=1
				and o.send=1
				',$user_id,$page);
		}
		function delete($order_id){
			return $this->db->exec('delete from `orders` where order_id=?',$order_id);
		}
		function deleteNotPay($order_id,$user_id){
			return $this->db->exec('delete from `orders` where order_id!=? and user_id=? and pay=0 and send=0',array($order_id,$user_id));
		}
	}
?>
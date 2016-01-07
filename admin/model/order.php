<?php
	class ModelOrder extends Model{
		function findCountByProvince($province){
			return $this->db->queryOne('select count(*) count from `orders` o,`address` a where o.address_id = a.address_id and a.province=?',$province);
		}
		function findByPay($arr,$page){
			return $this->db->query('select 
				o.money,
				o.order_id,
				o.user_id,
				o.order_code,
				o.address_id,
				o.address,
				o.date,
				u.name 
				from `orders` o,`user` u 
				where u.user_id=o.user_id 
				and pay=:pay 
				and o.date>=:date_start
				and o.date<=:date_end
				and name like "%":name"%"
				order by date desc',$arr,$page);
		}
		function findById($order_id){
			return $this->db->queryOne('select 
				u.name,
				u.phone,
				o.address,
				o.money,
				o.order_id,
				o.pay,
				o.send,
				o.order_code
				from `user` u,`orders` o 
				where u.user_id = o.user_id 
				and o.order_id=?',$order_id);
		}
		function deleteByDate($date_start,$date_end){
			return $this->db->exec('delete from `orders` where pay=0 and send=0 and date >= ? and date <= ?',array($date_start,$date_end));
		}
		function delete($order_id){
			return $this->db->exec('delete from `orders` where order_id=?',$order_id);
		}
		function findCountByDate($start,$end){
			return $this->db->queryOne('select count(*) count from `orders` where date >= ? and date <= ? and pay=1',array($start,$end));
		}
		function countNotSend(){
			return $this->db->queryOne('select count(*) count from `orders` where pay=1 and send=0');
		}
		function updateSend($order_id){
			return $this->db->exec('update `orders` set send = 1 where order_id=?',$order_id);
		}
		function notSend($page){
			return $this->db->query('select o.address,o.order_id,o.order_code,u.name,o.money,o.date from `orders` o,`user` u where u.user_id = o.user_id and pay=1 and send=0',array(),$page);
		}
	}
?>
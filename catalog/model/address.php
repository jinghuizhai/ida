<?php
	class ModelAddress extends Model{
		private $address_id;
		private $user_id;
		private $province;
		private $city;
		private $area;
		private $zipcode;
		private $detail;
		private $used; // 0 == 未使用，1 == 已使用

		function add($arr){
			return $this->db->exec('insert into `address` set
				user_id=:user_id,
				province=:province,
				city=:city,
				area=:area,
				zipcode=:zipcode,
				detail=:detail,
				used=:used
			',$arr);
		}
		function findProvinceById($address_id){
			return $this->db->queryOne('select province from `address` where address_id=:address_id',array('address_id'=>$address_id));
		}
		function countByUserid($user_id){
			return $this->db->queryOne('select count(address_id) count from `address` where user_id=?',$user_id);
		}
		function find($user_id){
			return $this->db->query('select a.used,a.address_id,p.province,c.city,r.area,z.zip,a.detail,a.user_id,p.provinceid,c.cityid,r.areaid from `address` a , `provinces` p,`cities` c,`areas` r,`zipcode` z where a.province = p.provinceid and a.city = c.cityid and a.area = r.areaid and a.zipcode = z.zip and a.user_id=? group by a.address_id order by a.address_id desc',$user_id);
		}
		function findById($address_id,$user_id){
			return $this->db->queryOne('select a.used,a.address_id,p.province,c.city,r.area,z.zip,a.detail,a.user_id,p.provinceid,c.cityid,r.areaid from `address` a , `provinces` p,`cities` c,`areas` r,`zipcode` z where a.province = p.provinceid and a.city = c.cityid and a.area = r.areaid and a.zipcode = z.zip and a.user_id=? and a.address_id=? group by a.address_id',array($user_id,$address_id));
		}
		function updateUsing($address_id,$using){
			return $this->db->exec('update `address` set used=? where address_id=?',array($using,$address_id));
		}
		function findProvince(){
			return $this->db->query('select * from `provinces`');
		}
		function findCity($provinceid){
			return $this->db->query('select * from `cities` where provinceid=?',$provinceid);
		}
		function findArea($cityid){
			return $this->db->query('select * from `areas` where cityid=?',$cityid);
		}
		function findZipcode($areaid){
			return $this->db->query('select * from `zipcode` where areaid=?',$areaid);
		}
		function updateUsed($user_id,$used){
			return $this->db->exec('update `address` set used=? where user_id=?',array($used,$user_id));
		}
		function update($arr){
			return $this->db->exec('update `address` set
				province=:province,
				city=:city,
				area=:area,
				zipcode=:zipcode,
				detail=:detail,
				used=:used
				where address_id=:address_id
				and user_id=:user_id
				',$arr);
		}
		function delete($address_id,$user_id){
			return $this->db->exec('delete from `address` where address_id=? and user_id=?',array($address_id,$user_id));
		}
	}
?>
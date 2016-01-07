<?php
	class ModelAddress extends Model{
		private $address_id;//p key
		private $user_id;// f key
		private $province;
		private $city;
		private $area;
		private $zipcode;
		private $detail;
		private $using;

		function findAllProvince(){
			return $this->db->query('select provinceid,province from `provinces`');
		}
		function findCountByProvince($province){
			return $this->db->queryOne('select count(*) count from `address` where province=?',$province);
		}
		function add($arr){
			return $this->db->exec('insert into `address` set
				user_id=:user_id,
				province=:province,
				city=:city,
				area=:area,
				zipcode=:zipcode,
				detail=:detail,
				using=:using
			',$arr);
		}
		function find($user_id){
			return $this->db->query('select a.address_id,p.province,c.city,r.area,z.zip,a.detail,a.user_id,p.provinceid,c.cityid,r.areaid from `address` a , `provinces` p,`cities` c,`areas` r,`zipcode` z where a.province = p.provinceid and a.city = c.cityid and a.area = r.areaid and a.zipcode = z.zip and a.user_id=?',$user_id);
		}
		function delete($address_id){
			return $this->exec('delete from `address` where address_id=?',$address_id);
		}
		function updateUsing($address_id,$using){
			return $this->exec('update `address` set using=? where address_id=?',array($using,$address_id));
		}
	}
?>
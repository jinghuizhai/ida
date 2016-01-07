<?php
	class ModelCatalog extends Model{
		private $catalog_id;
		private $name;
		private $p_id;

		function add($arr){
			return $this->db->exec('insert into `catalog` set name=:name,p_id=:p_id',$arr);
		}
		function update($arr){
			return $this->db->exec('update `catalog` set name=:name,p_id=:p_id where catalog_id=:catalog_id',$arr);
		}
		function delete($catalog_id){
			return $this->db->exec('delete from `catalog` where catalog_id=?',$catalog_id);
		}
		function findName(){
			return $this->db->query('select * from `catalog`');
		}
		function find(){
			return $this->db->query('select c1.catalog_id,c1.name,c1.p_id,c2.name father from `catalog` c1 left join `catalog` c2 on c1.p_id = c2.catalog_id order by c1.catalog_id desc');
		}
		function findById($catalog_id){
			return $this->db->queryOne('select * from  `catalog` where catalog_id=?',$catalog_id);
		}
	}
?>
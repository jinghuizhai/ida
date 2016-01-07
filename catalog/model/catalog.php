<?php
	class ModelCatalog extends Model{
		private $catalog_id;
		private $name;
		private $p_id;

		function findName(){
			return $this->db->query('select * from `catalog`');
		}
		function find(){
			return $this->db->query('select c1.catalog_id,c1.name,c1.p_id,c2.name father from `catalog` c1 left join `catalog` c2 on c1.p_id = c2.catalog_id order by c1.catalog_id desc');
		}
		function findById($catalog_id){
			return $this->db->query('select 
				p.product_id,
				p.name,
				p.price,
				p.likes,
				p.stock,
				c.name cname,
				i.name iname 
				from `product` p,`catalog` c,`img` i 
				where p.catalog_id = c.catalog_id 
				and i.product_id = p.product_id
				and p.catalog_id=?
				group by p.product_id
				',$catalog_id);
		}
		//查找一级分类商品
		function findFirst(){
			return $this->db->query('select * from `catalog` where p_id=0');
		}
	}
?>
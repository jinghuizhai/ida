<?php
	class ModelComment extends Model{
		private $comment_id;// p key
		private $user_id;// f key
		private $content;
		private $date;
		private $product_id;//f key
		private $stars;
		private $istop;

		function add($arr){
			return $this->db->exec('insert into `comment` set 
				user_id=:user_id,
				content=:content,
				date=:date,
				status=:status,
				product_id=:product_id,
				stars=:stars
			',$arr);
		}
		//某件商品有几个评论
		function findCountByProductid($product_id){
			return $this->db->queryOne('select count(*) count from `comment` where product_id=?',$product_id);
		}
		function findByProductid($arr){
			return $this->db->query('select 
				c.comment_id,
				r.reply_id,
				c.content,
				c.date,
				c.stars,
				r.content rcontent,
				r.date rdate 
				from `comment` c left join `reply` r on 
				c.comment_id = r.comment_id 
				where c.product_id=:product_id
				limit :limit_start,:limit_end',$arr);
		}
	}
?>
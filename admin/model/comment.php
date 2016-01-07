<?php
	class ModelComment extends Model{
		private $comment_id;// p key
		private $user_id;// f key
		private $content;
		private $date;
		private $product_id;//f key
		private $stars;
		private $istop;
		private $status;//0 == 未回复 1 == 已回复

		function count(){
			return $this->db->queryOne('select count(*) count from `comment`');
		}
		function countByStatus($status){
			return $this->db->queryOne('select count(*) count from `comment` where status = :status ',array('status'=>$status));
		}
		function updateStatus($comment_id,$status){
			return $this->db->exec('update `comment` set status=? where comment_id=?',array($status,$comment_id));
		}
		function findHasReply($page){
			return $this->db->query("select r.reply_id,c.content,r.content rcontent,c.date,r.date rdate,u.name from `comment` c ,`reply` r,`user` u where c.comment_id = r.comment_id and u.user_id = c.user_id",array(),$page);
		}
		function findByStatus($status,$page){
			return $this->db->query("select 
				u.name,
				u.user_id,
				r.tag,
				c.comment_id,
				c.content,
				c.date,
				r.name rname 
				from `comment` c,
				`user` u,
				`roles` r 
				where status=? 
				and u.user_id = c.user_id 
				and u.role_id = r.role_id",$status,$page);
		}
	}
?>
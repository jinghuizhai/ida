<?php
	class ModelReply extends Model{
		private $reply;//p key
		private $comment_id;// f key
		private $content;
		private $date;

		function add($arr){
			return $this->db->exec('insert into `reply` set 
				comment_id=:comment_id,
				content=:content,
				date=:date
			',$arr);
		}
		function update($arr){
			return $this->db->exec('update `reply` set 
				content=:content,
				date=:date
				where reply_id=:reply_id
			',$arr);
		}
	}
?>
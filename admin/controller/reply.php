<?php
	class ControllerReply extends Controller{
		function add(){
			$post = $this->req->post;
			$comment_id = (int)$post['comment_id'];
			$content = $post['content'];
			header("Content-type: application/json");
			if(strlen($content) > 0){
				$result = $this->load->model('reply')->add(array(
					'comment_id' => $comment_id,
					'content'    => $content,
					'date'       => timenow()
				));
				if($result){
					$this->load->model('comment')->updateStatus($comment_id,1);
					echo true;
				}else{
					echo false;
				}
			}else{
				echo false;
			}
		}
		function update(){
			$post = $this->req->post;
			$reply_id = (int)$post['reply_id'];
			$content = $post['content'];
			header("Content-type: application/json");
			if(strlen($content) > 0){
				$result = $this->load->model('reply')->update(array(
					'reply_id' => $reply_id,
					'content'    => $content,
					'date'       => timenow()
				));
				if($result){
					echo $content;
				}else{
					echo false;
				}
			}else{
				echo false;
			}
		}
	}
?>
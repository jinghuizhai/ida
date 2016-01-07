<?php
	class ControllerComment extends Controller{
		function notreply($args){
			$current = $args[0];
			if(empty($current)) $current = 1;
			$data = $this->load->model('comment')->findByStatus(0,array($current,HOSTNAME.'admin/comment/notreply/',50));
			$pagination = $this->db->getPage();
			return $this->load->view('comment_notreply',array('comments'=>$data,'pagination'=>$pagination));
		}
		function hasreply($args){
			$current = $args[0];
			if(empty($current)) $current = 1;
			// $data = $this->load->model('comment')->findByStatus(1,array($current,HOSTNAME.'admin/comment/hasreply/',50));
			$data = $this->load->model('comment')->findHasReply(array($current,HOSTNAME.'admin/comment/hasreply/',50));
			$pagination = $this->db->getPage();
			return $this->load->view('comment_hasreply',array('comments'=>$data,'pagination'=>$pagination));
		}
	}
?>
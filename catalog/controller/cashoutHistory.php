<?php
	class ControllerCashoutHistory extends Controller{
		function index($args){
			$current = (int)$args[0];
			if(empty($current)) $current = 1;
			$user_id = (int)$this->session->data['user']['user_id'];
			$data = $this->load->model('cashoutHistory')->findByUserid($user_id,array($current,HOSTNAME.'cashoutHistory/',20));
			$pagination = $this->db->getPage();
			return $this->load->view('cashout_history',array('historys'=>$data,'pagination' => $pagination),'admin_header','admin_footer');
		}
	}
?>
<?php
	class ControllerCashoutHistory extends Controller{
		function notCheck($args){
			$current = (int)$args[0];
			if(empty($current)) $current = 1;
			$data = $this->load->model('cashoutHistory')->findByStatus(0,array($current,HOSTNAME.'admin/cashoutHistory/notCheck/',50));
			$pagination = $this->db->getPage();
			return $this->load->view('cashout_history_notCheck',array('cashouts'=>$data,'pagination'=>$pagination));
		}
		function hasCheck(){
			$current = (int)$args[0];
			if(empty($current)) $current = 1;
			$data = $this->load->model('cashoutHistory')->findByStatus(1,array($current,HOSTNAME.'admin/cashoutHistory/hasCheck/',50));
			$pagination = $this->db->getPage();
			return $this->load->view('cashout_history_hasCheck',array('cashouts'=>$data,'pagination'=>$pagination));
		}
		//审核通过
		function check(){
			$ids = $this->req->post['ids'];
			header("Content-type:application/json");
			if(strlen($ids) > 0){
				$arr = explode(',',$ids);
				$transfer = $this->load->model('cashoutHistory');
				foreach($arr as $key => $value){
					$transfer->updateStatus((int)$value);
				}
				echo 'success';
			}else{
				echo 'fail';
			}
		}
	}
?>
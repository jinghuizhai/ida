<?php 
	class ControllerOrder extends Controller{
		function countRecommend(){
			$this->res->json();
			$user_id = (int)$this->session->data['user']['user_id'];
			$tag = $this->session->data['user']['tag'];
			$order = $this->load->model('order');
			if($tag == 'branch'){
				$data = $order->countByBranch($user_id);
			}else if($tag == 'sale'){
				$data = $order->countBySale($user_id);
			}else if($tag == 'agent'){
				$data = $order->countByAgent($user_id);
			}else if($tag == 'subagent'){
				$data = $order->countBySubagent($user_id);
			}else if($tag == 'member'){
				$data = $order->countByPid($user_id);
			}else{
				$data = array();
			}
			echo (int)$data['count'];
		}
		//推荐的订单
		/*
		private function getTags(){
			$tag = $this->session->data['user']['tag'];
			$arr = array();
			switch($tag){
				case 'branch':
				$arr = array(
					'sale'=>'业务员',
					'agent'=>'总代理',
					'subagent'=>'分代理',
					'member'=>'会员'
				);
				break;
				case 'sale':
					$arr=array(
						'agent'=>'总代理',
						'subagent'=>'分代理',
						'member'=>'会员'
					);
					break;
				case 'agent':
					$arr=array(
						'subagent'=>'分代理',
						'member'=>'会员'
					);
					break;
				case 'subagent':
					$arr=array('member'=>'会员');
					break;
				default:
					break;
			}
			return $arr;
		}
		*/
		function recommend(){
			$get = $this->req->get;

			$user_id = (int)$this->session->data['user']['user_id'];
			$tag = $this->session->data['user']['tag'];

			$date_start = $get['date_start'];
			$date_end = $get['date_end'];
			$current = $get['p'];
			$name = $get['name'];

			if(empty($current)) $current = 1;
			if(empty($name)) $name = "";

			if(empty($date_start)){
				$date_start = '2015-09-01 00:00:00';	
			}else{
				$date_start = format($date_start,'-')." 00:00:00";
			}

			if(empty($date_end)){
				$date_end = format(timenow(''),'-')." 23:59:59";
			}else{
				$date_end = format($date_end,'-')." 23:59:59";
			}

			$page = array($current,HOSTNAME.'order/recommend/?date_start='.$date_start."&date_end=".$date_end."&name=".$name."&p=",10);

			$arr = array(
				'name' => $name,
				'date_start'=>$date_start,
				'date_end'  => $date_end
			);
			// return var_dump($date_start,$date_end,$page);
			$order = $this->load->model('order');
			
			if($tag == 'branch'){
				$arr['branch_id'] = $user_id;
				$data = $order->findByBranch($arr,$page);
			}
			if($tag == 'sale'){
				$arr['sale_id'] = $user_id;
				$data = $order->findBySale($arr,$page);
			}
			if($tag == 'agent'){
				$arr['agent_id'] = $user_id;
				$data = $order->findByAgent($arr,$page);
			}
			if($tag == 'subagent'){
				$arr['subagent_id'] = $user_id;
				$data = $order->findBySubagent($arr,$page);
			}
			if($tag == 'member'){
				$arr['p_id'] = $user_id;
				$data = $order->findByPid($arr,$page);
			}

			$pagination = $this->db->getPage();
			return $this->load->view('order',array(
				'orders'=>$data,
				'date_start'=>$date_start,
				'date_end' => $date_end,
				'name' => $name,
				'pagination' => $pagination
			),'admin_header','admin_footer');
		}
		//自己的已付款订单
		function myself($args){
			$current = (int)$args[0];
			if(empty($current)) $current = 1;

			$data = $this->load->model('order')->findByme((int)$this->session->data['user']['user_id'],array($current,HOSTNAME.'order/myself/',20));
			$pagination = $this->db->getPage();
			// return var_dump($data);
			return $this->load->view('order_myself',array('orders'=>$data,'pagination'=>$pagination),'admin_header','admin_footer');
		}
		function jsonProductInfo(){
			$this->res->json();
			$user_id = (int)$this->session->data['user']['user_id'];
			$post = $this->req->post;
			$order_id = $post['order_id'];
			$data = $this->load->model('orderInfo')->findInfoByUserid($user_id,$order_id);
			echo json_encode($data);
		}
	}
?>
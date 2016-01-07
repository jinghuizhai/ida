<?php
	class ControllerOrder extends Controller{
		//返回前current_days天的日期数组
		private function getLimitDayArr($current_days){
			$arr = array();
			for($i = 0;$i<$current_days;$i++){
				$arr[] = date('Y-m-d',strtotime(-$i.' day'));
			}
			return $arr;
		}
		private function lambda_days($current_days){
			$arr = array();
			for($i = 0;$i<$current_days;$i++){
				$arr[] = $i+1;
			}
			return $arr;
		}
		function findCount(){
			$this->res->json();//return json;
			$post = $this->req->post;
			$current_days = (int)$post['current_days'];
			if(empty($current_days)) $current_days = 30;
			$days_arr = $this->getLimitDayArr($current_days);
			$order = $this->load->model('order');
			$counts = array();
			foreach($days_arr as $key => $value){
				$counts[] = (int)$order->findCountByDate($value." 00:00:00",$value." 23:59:59")['count'];
			}
			$ret = array('counts'=>$counts,'days'=>$this->lambda_days($current_days));
			echo json_encode($ret);
		}
		function countByProvince(){
			$this->res->json();
			$address = $this->load->model('address');
			$provinces = $address->findAllProvince();
			$order = $this->load->model('order');
			$orders = array();
			$members = array();
			foreach($provinces as $key => $value){
				$orders[] = array(
					'name'=>$value['province'],
					'value'=> (int)$order->findCountByProvince($value['provinceid'])['count']
				);
				$members[] = array(
					'name' => $value['province'],
					'value' => (int)$address->findCountByProvince($value['provinceid'])['count']
				);
			}
			echo json_encode(array(
				'orders' => $orders,
				'members' => $members
			));
		}
		function findHasPay(){
			$get = $this->req->get;
			$date_start = $get['date_start'];
			$date_end = $get['date_end'];
			$name = $get['name'];
			// return empty($date_end);
			if(empty($date_start)){
				$date_start = '2015-09-01';
			}
			if(empty($date_end)){
				$date_end = format(timenow(),'-')." 23:59:59";
			}
			if(empty($name)){
				$name = '';
			}
			$current = (int)$get['p'];
			if($current == 0) $current = 1;
			$arr = array(
				'date_start'=>$date_start,
				'date_end'  =>$date_end,
				'name'      =>$name,
				'pay'       => 1
			);
			$data = $this->load->model('order')->findByPay($arr,array($current,HOSTNAME.'admin/order/findHasPay/?date_start='.$date_start."&date_end=".$date_end.'&name='.$name.'&p=',15));
			$pagination = $this->db->getPage();
			return $this->load->view('order_hasPay',array(
				'orders'=>$data,
				'pagination'=>$pagination,
				'date_start'=>$date_start,
				'date_end'  =>$date_end,
				'name'      =>$name
			));
		}
		function findNotPay($args){
			$current = (int)$args[0];
			if($current == 0) $current = 1;
			$arr = array(
				'date_start' => '2015-09-01',
				'date_end'   => format(timenow(),'-').' 23:59:59',
				'name' => '',
				'pay'  => 0
			);
			$data = $this->load->model('order')->findByPay($arr,array($current,HOSTNAME.'admin/order/findNotPay/',15));
			$pagination = $this->db->getPage();
			return $this->load->view('order_notPay',array('orders'=>$data,'pagination'=>$pagination));
		}
		function delete(){
			$order_id = (int)$this->req->post['order_id'];
			$result = $this->load->model('order')->delete($order_id);
			$tag = $this->req->post['tag'];
			if($result){
				setHint('删除成功');
			}else{
				setHint('删除失败','bad');
			}
			if($tag == 'not'){
				$this->res->red('order/findNotPay');
			}else{
				$this->res->red('order/findHasPay');
			}
		}
		//成功付款，但由于网络原因没有成功发送到客户端
		function notSend($args){
			$current = (int)$args[0];
			if(empty($current)) $current = 1;
			$data = $this->load->model('order')->notSend(array($current,HOSTNAME.'admin/order/notSend/',50));
			$pagination = $this->db->getPage();
			return $this->load->view('order_not_send',array('orders'=>$data,'pagination'=>$pagination));
		}
		//手动提交订单到客户端
		function handSend(){
			$order_id = (int)$this->req->post['order_id'];
			$order = $this->load->model('order')->findById($order_id);
			$order_info = $this->load->model('orderInfo')->findInfoById($order_id);
			if(!empty($order) && !empty($order_info)){
				// 商品信息
				$product_info = "";
				foreach($order_info as $key => $value){
					$product_info = $product_info.$value['name'].'x'.$value['piece'];
				}
				//需要远程提交的数据
				$data = array(
					'name' => $order['name'],
					'phone' => $order['phone'],
					'address' => $order['address'],
					'order_id' => $order['order_id'],
					'order_code' => $order['order_code'],
					'money' => $order['money'],
					'product'=>$product_info
				);
				$ret = phppost(CLIENTURL,$data);
				if($ret == 'success'){
					//改变订单状态为已经发送
					$result = $this->load->model('order')->updateSend($order_id);
					if($result){
						setHint('远程提交订单成功');
					}else{
						setHint('远程提交订单成功，但本地失败','bad');
					}
				}else{
					setHint('未发送成功','bad');
				}
			}else{
				setHint('此订单不存在','bad');
			}
			$this->res->red('order/notSend');
		}
	}
?>
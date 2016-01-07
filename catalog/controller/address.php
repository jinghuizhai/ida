<?php
	class ControllerAddress extends Controller{
		function index(){
			$user_id = (int)$this->session->data['user']['user_id'];
			$data = $this->load->model('address')->find($user_id);
			return $this->load->view('address',array('addresses'=>$data),'admin_header','admin_footer');
		}
		function update($args){
			$address_id = (int)$args[0];
			$user_id = (int)$this->session->data['user']['user_id'];
			$post = $this->req->post;
			if(count($post)){
				$province = $post['province'];
				$city = $post['city'];
				$area = $post['area'];
				$zipcode = $post['zipcode'];
				$detail = $post['detail'];
				$address_id = (int)$post['address_id'];
				$used = (int)$post['used'];

				if(empty($province)){
					setHint('省不能为空','bad');
					$this->res->redirect('address/add');
				}
				if(empty($city)){
					setHint('城市不能为空','bad');
					$this->res->redirect('address/add');
				}
				if(empty($area)){
					setHint('地区不能为空','bad');
					$this->res->redirect('address/add');
				}
				if(empty($zipcode)){
					setHint('邮编不能为空','bad');
					$this->res->redirect('address/add');
				}
				if(empty($detail)){
					setHint('详细地址不能为空','bad');
					$this->res->redirect('address/add');
				}
				if($used != 0 && $used != 1){
					$used = 1;
				}
				$arr = array(
					'address_id'=> $address_id,
					'province' => $province,
					'city'     => $city,
					'area'     => $area,
					'zipcode'  => $zipcode,
					'user_id'  => (int)$this->session->data['user']['user_id'],
					'detail'   => $detail,
					'used'     => $used
				);
				if($used == 1){
					$this->load->model('address')->updateUsed((int)$this->session->data['user']['user_id'],0);	
				}
				$result = $this->load->model('address')->update($arr);
				if($result){
					setHint('修改地址成功');
				}else{
					setHint('修改地址失败','bad');
				}
				$this->res->redirect('address/update/'.$address_id);
			}else{
				$data = $this->load->model('address')->findById($address_id,$user_id);
				if(!$data){
					return '地址不存在';
				}else{
					return $this->load->view('address_update',$data,'admin_header','admin_footer');
				}
			}
		}
		function delete(){
			$address_id = (int)$this->req->post['address_id'];
			$user_id = (int)$this->session->data['user']['user_id'];
			$result = $this->load->model('address')->delete($address_id,$user_id);
			if($result){
				setHint('删除地址成功');
			}else{
				setHint('删除地址失败','bad');
			}
			$this->res->redirect('address');
		}
		function jsonadd(){
			$post = $this->req->post;
			$user_id = (int)$this->session->data['user']['user_id'];

			header("Content-type:application/json");

			$province = $post['province'];
			$city = $post['city'];
			$area = $post['area'];
			$zipcode = $post['zipcode'];
			$detail = $post['detail'];

			$json = array();

			if(empty($province)){
				$json['info'] = '省不能为空';
				echo json_encode($json);
				return;
			}
			if(empty($city)){
				$json['info'] = '城市不能为空';
				echo json_encode($json);
				return;
			}
			if(empty($area)){
				$json['info'] = '地区不能为空';
				echo json_encode($json);
				return;
			}
			if(empty($zipcode)){
				$json['info'] = '邮编不能为空';
				echo json_encode($json);
				return;
			}
			if(empty($detail)){
				$json['info'] = '详细地址不能为空';
				echo json_encode($json);
				return;
			}
			//如果此人已经添加了5个地址，那么将不能继续添加
			$num = $this->load->model('address')->countByUserid($user_id);
			if($num['count'] >= 4){
				$json['info'] = '对不起，您添加的地址已经到上限';
				echo json_encode($json);
				return;
			}
			//改其他地址为不启用
			$this->load->model('address')->updateUsed($user_id,0);
			$arr = array(
				'province' => $province,
				'city'     => $city,
				'area'     => $area,
				'zipcode'  => $zipcode,
				'user_id'  => $user_id,
				'detail'   => $detail,
				'used'     => 1
			);
			$result = $this->load->model('address')->add($arr);
			$lastId = (int)$this->db->lastId();

			if($result){
				$add = $this->load->model('address')->findById($lastId,$user_id);
				$json['info'] = 'success';
				$json['address'] = $add;
				echo json_encode($json);
			}else{
				$json['info'] = 'fail';
				echo json_encode($json);
			}
		}
		function add(){
			$post = $this->req->post;
			if(count($post)){
				$province = $post['province'];
				$city = $post['city'];
				$area = $post['area'];
				$zipcode = $post['zipcode'];
				$detail = $post['detail'];
				if(empty($province)){
					setHint('省不能为空','bad');
					$this->res->redirect('address/add');
				}
				if(empty($city)){
					setHint('城市不能为空','bad');
					$this->res->redirect('address/add');
				}
				if(empty($area)){
					setHint('地区不能为空','bad');
					$this->res->redirect('address/add');
				}
				if(empty($zipcode)){
					setHint('邮编不能为空','bad');
					$this->res->redirect('address/add');
				}
				if(empty($detail)){
					setHint('详细地址不能为空','bad');
					$this->res->redirect('address/add');
				}
				//如果此人已经添加了5个地址，那么将不能继续添加
				$num = $this->load->model('address')->countByUserid((int)$this->session->data['user']['user_id']);
				if($num['count'] >= 4){
					setHint('对不起，您添加的地址已经到上限','bad');
					$this->res->redirect('address/add');
				}
				$arr = array(
					'province' => $province,
					'city'     => $city,
					'area'     => $area,
					'zipcode'  => $zipcode,
					'user_id'  => (int)$this->session->data['user']['user_id'],
					'detail'   => $detail,
					'used'     => 1
				);
				$this->load->model('address')->updateUsed((int)$this->session->data['user']['user_id'],0);
				$result = $this->load->model('address')->add($arr);
				if($result){
					setHint('添加地址成功');
				}else{
					setHint('添加地址失败','bad');
				}
				$this->res->redirect('address/add');
			}else{
				return $this->load->view('address_add',null,'admin_header','admin_footer');
			}
		}
		function findProvince(){
			header("Content-type:application/json");
			$data = $this->load->model('address')->findProvince();
			echo json_encode($data);
		}
		function findCity(){
			$provinceid = (int)$this->req->post['provinceid'];
			header("Content-type: application/json");
			$data = $this->load->model('address')->findCity($provinceid);
			echo json_encode($data);
		}
		function findArea(){
			$cityid = (int)$this->req->post['cityid'];
			header("Content-type: application/json");
			$data = $this->load->model('address')->findArea($cityid);
			echo json_encode($data);
		}
		function findZipcode(){
			$areaid = (int)$this->req->post['areaid'];
			header("Content-type: application/json");
			$data = $this->load->model('address')->findZipcode($areaid);
			echo json_encode($data);
		}
	}
?>
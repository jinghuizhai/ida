<?php 
	class ControllerBroadcast extends Controller{
		function index(){
			$data = $this->load->model('broadcast')->find();
			$roles = $this->load->model('role')->find();
			$role_ids = array();
			$role_names = array();
			foreach($roles as $key => $value){
				$role_ids[] = $value['role_id'];
				$role_names[] = $value['name'];
			}
			return $this->load->view('broadcast',array(
				'broadcasts' => $data,
				'role_ids' => $role_ids,
				'role_names' => $role_names
			));
		}

		function add(){
			$post = $this->req->post;
			if(count($post)){
				$content = $post['content'];
				$role_id = (int)$post["role_id"];
				$date_start = $post['date_start'];
				$date_end = $post['date_end'];
				$date = timenow();
				if(strlen($content) < 1){
					setHint('内容不能为空','bad');
					$this->res->red('broadcast/add');
				}
				if(strlen($date_start) < 1 || strlen($date_end) < 1){
					setHint('其实日期都不能为空','bad');
					$this->res->red('broadcast/add');
				}

				$arr = array(
					"content"=>$content,
					"role_id"=>$role_id,
					"date_start"=>$date_start,
					"date_end"=>$date_end,
					"date"=>$date
				);
				$result = $this->load->model('broadcast')->add($arr);
				if($result){
					setHint('添加广播成功');
				}else{
					setHint('添加广播失败','bad');
				}
				$this->res->red('broadcast/add');
			}else{
				$roles = $this->load->model('role')->find();
				return $this->load->view('broadcast_add',array('roles'=>$roles));
			}
		}
		function update($args){
			$post = $this->req->post;
			if(count($post)){
				$content = $post['content'];
				$broadcast_id = (int)$post['broadcast_id'];
				$role_id = (int)$post["role_id"];
				$date_start = $post['date_start'];
				$date_end = $post['date_end'];

				if(strlen($content) < 1){
					setHint('内容不能为空','bad');
					$this->res->red('broadcast/update/'.$broadcast_id);
				}
				if(strlen($date_start) < 1 || strlen($date_end) < 1){
					setHint('其实日期都不能为空','bad');
					$this->res->red('broadcast/update/'.$broadcast_id);
				}

				$arr = array(
					'broadcast_id'=>$broadcast_id,
					"content"=>$content,
					"role_id"=>$role_id,
					"date_start"=>$date_start,
					"date_end"=>$date_end
				);
				$result = $this->load->model('broadcast')->update($arr);
				if($result){
					setHint('更新广播成功');
				}else{
					setHint('更新广播失败','bad');
				}
				$this->res->red('broadcast');
			}else{
				$broadcast_id = (int)$args[0];
				$roles = $this->load->model('role')->find();
				$broadcast = $this->load->model('broadcast')->findById($broadcast_id);

				return $this->load->view('broadcast_update',array('roles'=>$roles,'broadcast'=>$broadcast));
			}
		}
		function delete(){
			$broadcast_id = (int)$this->req->post['broadcast_id'];
			$result = $this->load->model('broadcast')->delete($broadcast_id);
			if($result){
				setHint('删除广播成功');
			}else{
				setHint('删除广播失败','bad');
			}
			$this->res->red('broadcast');
		}
	}
?>
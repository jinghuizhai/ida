<?php
	class ControllerRole extends Controller{
		function index(){
			$data = $this->load->model('role')->find();
			return $this->load->view('role',array('roles'=>$data));
		}
		function jsonMethodList(){
			$entrance = $this->req->post['entrance'];
			$role_id = $this->req->post['role_id'];
			$permission = array();
			if(!empty($role_id)){
				$role = $this->load->model('role')->findById($role_id);
				if($role){
					if(!empty($role['permission'])){
						$permission = unserialize($role['permission']);
					}
				}
			}
			header("Content-type: text/html");
			$methodList = array();
			if($entrance == 'front'){
				$methodList = getMethodList(FRONT);				
			}else if($entrance == 'backstage'){
				$methodList = getMethodList(CONTROLLER);
			}
			$html = "";
			// echo empty($permission);
			foreach($methodList as $key => $value){
				if(in_array($value,$permission)){
					$ht = sprintf('<p><label for="%s">%s</label><input checked="checked" id="%s" type="checkbox" name="checkbox[]" value="%s" /></p>',$value,$value,$value,$value);
				}else{
					$ht = sprintf('<p><label for="%s">%s</label><input id="%s" type="checkbox" name="checkbox[]" value="%s" /></p>',$value,$value,$value,$value);
				}
				$html = $html.$ht;
			}
			echo $html;
		}
		function add(){
			$post = $this->req->post;
			if(count($post)){
				$name = $post['name'];
				$tag = $post['tag'];
				$permission = $post['checkbox'];
				$entrance = $post['entrance'];

				if(strlen($name) > 0 && strlen($tag) > 0){
					$findOne = $this->load->model('role')->findByName($name,$tag);
					if($findOne){
						setHint('名字或tag已经存在','bad');
						$this->res->red("role/add");
					}
					$result = $this->load->model('role')->add(array(
						'name' => $name,
						'tag'  => $tag,
						'entrance'=> $entrance,
						'permission'=> serialize($permission)
					));
					if($result){
						setHint('添加成功');
					}else{
						setHint('添加失败','bad');
					}
				}else{
					//检查name和tag
					setHint('名称和tag不符合要求','bad');
				}
				$this->res->red('role/add');
			}else{
				return $this->load->view('role_add');
			}
		}
		function update($args){
			$post = $this->req->post;
			if(count($post)){
				$role_id = (int)$post['role_id'];
				$name = $post['name'];
				$tag = $post['tag'];
				$entrance = $post['entrance'];
				$permission = $post['checkbox'];

				if(strlen($name) > 0 && strlen($tag) > 0){
					$result = $this->load->model('role')->update(array(
						'role_id'=>$role_id,
						'name' => $name,
						'tag'  => $tag,
						'entrance'=>$entrance,
						'permission'=> serialize($permission)
					));

					if($result){
						setHint('更新成功');
					}else{
						setHint('更新失败','bad');
					}
				}else{
					setHint('名称和tag不符合要求','bad');
				}
				$this->res->red('role/update/'.$role_id);
			}else{
				$role_id = (int)$args[0];
				$role = $this->load->model('role')->findById($role_id);
				return $this->load->view('role_update',array('role'=>$role));
			}
		}
		function delete(){
			$role_id = (int)$this->req->post['role_id'];
			$result = $this->load->model('role')->delete($role_id);
			if($result){
				setHint('删除成功');
			}else{
				setHint('删除失败','bad');
			}
			$this->res->red('role');
		}
	}
?>
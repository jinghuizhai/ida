<?php
	class ControllerAttr extends Controller{
		
		function index(){
			$data = $this->load->model('attr')->find();
			return $this->load->view('attr',array('attrs'=>$data));
		}
		function add(){
			$post = $this->req->post;
			if(count($post)){
				$name = $post['name'];
				if(strlen($name) < 1){
					setHint('属性名称太短','bad');
				}else{
					$result = $this->load->model('attr')->add($name);	
					if($result){
						setHint('属性添加成功');
					}else{
						setHint('属性添加失败','bad');
					}
				}
				$this->res->red('attr/add');
			}else{
				return $this->load->view('attr_add');
			}
		}
		function update(){
			$post = $this->req->post;
			$attr_id = (int)$post['attr_id'];
			$name = $post['name'];
			if(strlen($name) < 1){
				setHint('属性名称太短','bad');
			}else{
				$result = $this->load->model('attr')->update($attr_id,$name);
				if($result){
					setHint('属性修改成功');
				}else{
					setHint('属性修改失败','bad');
				}
			}
			$this->res->red('attr');
		}
		function delete(){
			$attr_id = (int)$this->req->post['attr_id'];
			$result = $this->load->model('attr')->delete($attr_id);
			if($result){
				setHint('属性删除成功');
			}else{
				setHint('属性删除失败','bad');
			}
			$this->res->red('attr');
		}
	}
?>
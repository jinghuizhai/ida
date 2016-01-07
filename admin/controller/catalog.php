<?php
	class ControllerCatalog extends Controller{
		function add(){
			if(count($this->req->post)){
				$name = $this->req->post['name'];
				$catalog_id = $this->req->post['catalog_id'];
				if(strlen($name)>0 && is_numeric($catalog_id)){
					$result = $this->load->model('catalog')->add(array(
						'name'   => $name,
						'p_id'   => (int)$catalog_id
					));
					if($result){
						setHint('添加分类成功');
					}else{
						setHint('添加分类失败','bad');
					}
				}else{
					setHint('信息不符合要求','bad');
				}
				$this->res->red('catalog/add');
			}else{
				$data = $this->load->model('catalog')->findName();
				return $this->load->view('catalog_add',array('catalogs'=>$data));
			}
		}
		function update(){
			if(count($this->req->post)){
				$post = $this->req->post;
				$catalog_id = $post['catalog_id'];
				$name = $post['name'];
				$p_id = $post['p_id'];
				if(strlen($name) > 0 && is_numeric($catalog_id) && is_numeric($p_id)){
					$result = $this->load->model('catalog')->update(array(
						'catalog_id'=>(int)$catalog_id,
						'name'      => $name,
						'p_id'      => (int)$p_id
					));
					if(empty($result)){
						setHint('修改品类失败','bad');
					}else{
						setHint('修改品类成功');
					}
				}else{
					setHint('输入信息不符合要求','bad');
				}
				$this->res->red('catalog/update');
			}else{
				$data = $this->load->model('catalog')->find();
				$cats = $this->load->model('catalog')->findName();
				return $this->load->view('catalog_update',array('catalogs'=>$data,'cats'=>$cats));
			}
		}
		function delete(){
			$catalog_id = $this->req->post['catalog_id'];
			$result = $this->load->model('catalog')->delete($catalog_id);
			if($result){
				setHint('删除成功');
			}else{
				setHint('删除失败','bad');
			}
			$this->res->red('catalog/update');
		}
	}
?>
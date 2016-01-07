<?php
	class ControllerAttr_group extends Controller{
		function index(){
			$data = $this->load->model('attr_group')->find();
			return $this->load->view('attr_group',array('attr_groups'=>$data));
		}
		function delete(){
			$attr_group_id = (int)$this->req->post['attr_group_id'];
			$result = $this->load->model('attr_group')->delete($attr_group_id);
			if($result){
				setHint('删除属性组成功');
			}else{
				setHint('删除属性组失败','bad');
			}
			$this->res->red('attr_group');
		}
		function update($args){
			$attr_group_id = (int)$args[0];
			$post = $this->req->post;
			if(count($post)){
				$attr_group_id = (int)$post['attr_group_id'];
				$name = $post['name'];
				$attrs = $post['attr'];//Array
				$value = $post['value'];//Array
				$attr_value_id = $post['attr_value_id'];//Array
				// return var_dump($attr_group_id,$name,$attrs,$value,$attr_value_id);
				if(strlen($name)>0){
					foreach ($attr_value_id as $k => $v) {
						if(empty($v)){
							$this->load->model('attr_value')->add(array(
								"attr_group_id"=>$attr_group_id,
								"attr_id"=>(int)$attrs[$k],
								"value"=>$value[$k]
							));
						}else{
							if(strlen($value[$k]) > 0){
								$this->load->model('attr_value')->update((int)$v,$value[$k]);
							}else{
								$this->load->model('attr_value')->delete((int)$v);
							}
						}
					}
					setHint('属性名组修改成功');
				}else{
					setHint('属性名太短，不能修改');
					$this->res->red('attr_group/update/'.$attr_group_id);
				}
				$this->res->red('attr_group');
			}else{
				$group = $this->load->model('attr_group')->findGroup($attr_group_id);
				$data = $this->load->model('attr_group')->findJoinLeft($attr_group_id);
				return $this->load->view('attr_group_update',array('attrs'=>$data,'group'=>$group));
			}
		}
		function add(){
			$post = $this->req->post;
			if(count($post)){
				$name = $post['name'];
				$value = $post['value'];
				$attr = $post['attr'];
				// var_dump($value);
				if(strlen($name) > 0){
					$result = $this->load->model('attr_group')->add($name);
					if($result){
						setHint('属性组添加成功');
					}else{
						setHint('属性组添加失败','bad');
					}
					$lastId = $this->db->lastId();
					if($lastId){
						foreach($value as $key => $v){
							if(strlen($v)>0){
								$this->load->model('attr_value')->add(array(
									"attr_group_id" =>(int)$lastId,
									"attr_id"       =>(int)$attr[$key],
									"value"         =>$v
								));
							}
						}
					}
				}else{
					setHint('属性名太短','bad');
				}
				$this->res->red('attr_group/add');
			}else{
				$data = $this->load->model('attr')->find();
				return $this->load->view('attr_group_add',array('attrs'=>$data));
			}
		}
	}
?>
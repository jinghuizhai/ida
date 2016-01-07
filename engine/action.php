<?php
	class Action{
		private $file;
		private $class;
		private $method;
		private $originalClass;
		private $args = array();
		function __construct($route,$args=array()){
			if(strpos($route,'/?') == 0){
				$route = str_replace('?', '/?', $route);
			}
			$params = explode('/', $route);
			foreach($params as $key => $value){
				if($key == 0 || $key == 1) continue;
				if($key == 2 && $value != ''){
					$this->originalClass = preg_replace('/[^a-zA-Z0-9_]/','',$value);
					$this->class = 'Controller'.ucfirst(preg_replace('/[^a-zA-Z0-9_]/','',$value));
					$this->file = CONTROLLER.$value.'.php';
				}
				if($key == 3 && $value != ''){
					if(is_numeric($value)){
						$this->method = 'index';
						$args[] = $value;
					}else{
						$this->method = $value;
					}
				}
				if($key > 3 && $value != ''){
					$args[] = $value;
				}
			}
			if(empty($this->method)){
				$this->method = 'index';
			}
			if($args){
				$this->args = $args;
			}
		}
		private function doexecute($registry){
			if(is_file($this->file)){
				require_once($this->file);
			}else{
				// trigger_error('can not loading controller file:'.$this->file);
				//跳转
				$registry->get('res')->redirect('');
			}
			//此处可以加上过滤程序
			$class = $this->class;
			$controller = new $class($registry);
			if(is_callable(array($controller,$this->method))){
				return call_user_func(array($controller,$this->method),$this->args);
			}else{
				return false;
			}
		}
		function execute($registry){
			$filterArr = array('home','comment','product','catalog','cart','blog');
			if(empty($this->class)){
				$registry->get('res')->redirect('home');
			}
			// return $this->originalClass;
			if(in_array($this->originalClass,$filterArr)){
				return $this->doexecute($registry);
			}else{
				$user = $registry->get('session')->data['user'];
				if(!empty($user)){
					$permission = $user['permission'];
					if(in_array($this->originalClass,$permission) || in_array($this->originalClass.'/'.$this->method,$permission)){
						return $this->doexecute($registry);	
					}else{
						return '对不起，您没有权限，sorry,you have no permission!';
					}
				}else{
					setHint('请先登录');
					$registry->get('res')->redirect('home/login');
				}
			}
		}
	}	
?>
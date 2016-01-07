<?php
	class Action{
		private $file;
		private $class;
		private $originalClass;
		private $method;
		private $args = array();
		
		function __construct($route,$args=array()){
			if(strpos($route,'/?') == 0){
				$route = str_replace('?', '/?', $route);
			}
			$params = explode('/', $route);
			foreach($params as $key => $value){
				if($key == 0 || $key == 1) continue;
				if($key == 2 && $value == 'admin') continue;
				if($key == 3 && $value != ''){
					$this->originalClass = preg_replace('/[^a-zA-Z0-9_]/','',$value);
					$this->class = 'Controller'.ucfirst(preg_replace('/[^a-zA-Z0-9_]/','',$value));
					$this->file = CONTROLLER.$value.'.php';
				}
				if($key == 4 && $value != ''){
					if(is_numeric($value)){
						$this->method = 'index';
						$args[] = $value;
					}else{
						$this->method = $value;
					}
				}
				if($key > 4 && $value != ''){
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
				// $registry->get("res")->red('admin/hasError');
				return '您访问的页面&nbsp;不存在';
			}
			$class = $this->class;
			$controller = new $class($registry);
			if(is_callable(array($controller,$this->method))){
				return call_user_func(array($controller,$this->method),$this->args);
			}else{
				return '您访问的页面不存在';
			}
		}
		function execute($registry){
			//以下是过滤程序
			$admin = $registry->get('session')->data['admin'];
			if(empty($admin)){
				if($this->class == 'ControllerAdmin' && ($this->method == 'login' || $this->method == "hasError")){
					return $this->doexecute($registry);
				}else{
					$registry->get('res')->red('admin/hasError');
				}
			}else{
				if($admin['admin_id'] == 1){
					return $this->doexecute($registry);	
				}else{
					if(in_array($this->originalClass,$admin['permission']) || in_array($this->originalClass."/".$this->method,$admin['permission'])){
						return $this->doexecute($registry);
					}else{
						return '没有权限，sorry,you have no permission！';
					}
				}
			}
		}
	}	
?>
<?php
	final class Loader{
		private $registry;
		function __construct($registry){
			$this->registry = $registry;
		}
		function model($model){
			$file = MODEL.$model.'.php';
			if(file_exists($file)){
				require_once($file);
				$class = "Model".ucFirst(preg_replace('/[^a-zA-z0-9_]/','', $model));
				return new $class($this->registry);
			}else{
				trigger_error('下载model:'.$model.'失败');
			}
		}
		function controller($controller){
			$file = CONTROLLER.$controller.'.php';
			if(file_exists($file)){
				require_once($file);
				$class = 'Controller'.ucFirst(preg_replace('/[^a-zA-z0-9_]/','',$controller));
				return new $class($this->registry);
			}else{
				trigger_error("下载controller:".$controller.'失败');
			}
		}
		function view($template,$data=array(),$header=null,$footer=null){
			$file = VIEW.$template.'.tpl';
			if(!empty($_SESSION)){
				$data['session'] = &$_SESSION;
			}
			if(file_exists($file)){
				extract($data);
				ob_start();
				if(empty($title)){
					$title = 'IDA手表官网，轻时尚手表品牌';
				}
				if(empty($description)){
					$description = 'IDA手表官网，轻时尚手表品牌';
				}
				if(empty($keywords)){
					$keywords = 'IDA手表官网，轻时尚手表品牌';
				}
				if(!empty($header)){
					$path = VIEW.$header.'.tpl';
					//检查文件是否存在，这样设计，是有不存在的需要
					if(file_exists($path)){
						require($path);
					}
				}else{
					require(VIEW.'header.tpl');	
				}
				require($file);
				if(!empty($footer)){
					$path = VIEW.$footer.'.tpl';
					if(file_exists($path)){
						require($path);
					}
				}else{
					require(VIEW.'footer.tpl');
				}
				$output = ob_get_contents();
				ob_end_clean();
				return $output;
			}else{
				trigger_error('下载view:'.$file.'失败');
			}
		}
	}
?>
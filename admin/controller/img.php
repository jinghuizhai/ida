<?php 
	class ControllerImg extends Controller{
		function index($args){
			$current = (int)$args[0];
			if(empty($current)) $current = 1;
			$data = $this->load->model('img')->find(array($current,HOSTNAME.'admin/img/',50));
			$pagination = $this->db->getPage();
			return $this->load->view('img',array('imgs'=>$data,'pagination'=>$pagination));
		}
		private function deleteFile($name){
			$path = UPLOAD.'thumbnail/';
			if(is_file($path.$name)){
				return unlink($path.$name);
			}else{
				return false;
			}
		}
		function delete(){
			$ids = $this->req->post['ids'];
			header("Content-type: application/json");
			if(strlen($ids) > 0){
				$arr = explode(',',$ids);
				$img = $this->load->model('img');
				foreach($arr as $key => $value){
					$result = $img->findById((int)$value);
					if($result){
						$this->deleteFile($result['name']);
						$this->deleteFile($result['thumbnail']);
						$img->delete((int)$value);
					}
				}
				echo 'success';
			}else{
				echo '没有要删除的图片';
			}
		}
	}
?>
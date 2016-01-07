<?php
	class ControllerComment extends Controller{
		function add(){
			$post = $this->req->post;
			$this->res->json();
			$arr = array();
			if(empty($this->session->data['user'])){
				$arr['fail'] = '需要您先登录';
			}else{
				$product_id = (int)$post['product_id'];
				$content = trim($post['content']);
				$stars = (float)$post['stars'];
				if(strlen($content) < 1){
					$arr['fail'] = '内容不能为空';
				}else{
					$arr2 = array(
						'product_id' => $product_id,
						'user_id'    => (int)$this->session->data['user']['user_id'],
						'content'    => htmlentities($content),
						'date'       => timenow(),
						'status'     => 0,
						'stars'		 => $stars
					);
					$result = $this->load->model('comment')->add($arr2);
					if($result){
						$html = '<div class="comment-list"><p class="fix">';
						if($stars > 3){
							$html = $html.'<i class="icon iconfont">&#xe653;</i>';
						}else{
							$html = $html.'<i class="icon iconfont">&#xe64b;</i>';
						}
						$html = $html.html_entity_decode($arr2["content"])."<span class='r f12'>".timenow()."</span></p></div>";
						$arr['content'] = $html;
					}else{
						$arr['fail'] = '评论失败';
					}
				}
			}
			echo json_encode($arr);
		}
		function findByProductid(){
			//默认一次加载10条
			$post = $this->req->post;
			$product_id = (int)$post['product_id'];
			$limit_start = (int)$post['limit_start'];
			$limit_end = (int)$post['limit_end'];
			$arr = array(
				'product_id'  => $product_id,
				'limit_start' => $limit_start,
				'limit_end'   => $limit_end
			);
			$data = $this->load->model('comment')->findByProductid($arr);
			header("Content-type: text/html");
			if(empty($data)){
				echo 'fail';
			}else{
				$html = '';
				foreach($data as $key => $value){
					$html = $html.'<div class="comment-list"><p class="fix">';
					if($value['stars'] > 3){
						$html = $html.'<i class="icon iconfont">&#xe653;</i>';
					}else{
						$html = $html.'<i class="icon iconfont">&#xe64b;</i>';
					}
					$html = $html.html_entity_decode($value['content'])."<span class='r'>".$value['date']."</span></p>";
					if(!empty($value['rcontent'])){
						$html = $html.sprintf('<p class="admin-reply">%s<span class="r">%s</span></p>',html_entity_decode($value['rcontent']),$value['rdate']);
					}
					$html = $html."</div>";
				}
				echo $html;
			}
		}
	}
?>
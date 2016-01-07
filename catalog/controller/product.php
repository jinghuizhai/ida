<?php
	class ControllerProduct extends Controller{
		function index($args){
			$product_id = (int)$args[0];
			$data = $this->load->model('product')->findById($product_id);
			$imgs = $this->load->model('img')->findByProductid($product_id);
			$catalogs = $this->load->model('catalog')->findFirst();
			$attrs = $this->load->model('attr_value')->findByGroupid((int)$data['attr_group_id']);
			$count_comments = $this->load->model('comment')->findCountByProductid($product_id)['count'];
			return $this->load->view('product',array(
				'product'  => $data,
				'catalogs' => $catalogs,
				'imgs'     => $imgs,
				'title'    => $data['title'],
				'description'    => $data['description'],
				'keywords'    => $data['keywords'],
				'count_comments'=> $count_comments,
				'attrs'    => $attrs
			));
		}
		function hitLikes(){
			$this->res->json();
			$product_id = (int)$this->req->post['product_id'];
			$product = $this->load->model('product'); 
			$result = $product->updateLikes($product_id);
			if($result){
				echo $product->findById($product_id)['likes'];
			}else{
				echo 0;
			}
		}
	}
?>
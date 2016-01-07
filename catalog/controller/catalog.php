<?php
	class ControllerCatalog extends Controller{
		function index($args){
			$catalog_id = (int)$args[0];
			$data = $this->load->model('catalog')->findById($catalog_id);
			$catalogs = $this->load->model('catalog')->findFirst();
			return $this->load->view('catalog',array('products'=>$data,'catalogs'=>$catalogs));
		}
	}
?>
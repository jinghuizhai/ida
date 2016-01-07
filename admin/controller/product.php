<?php
	class ControllerProduct extends Controller{
		function index(){
			$data = $this->load->model('product')->find();
			return $this->load->view('product',array('products'=>$data));
		}
		function delete(){
			$product_id = $this->req->post['product_id'];
			$result = $this->load->model('product')->delete((int)$product_id);
			if($result){
				setHint('删除商品成功');
			}else{
				setHint('删除商品失败','bad');
			}
			$this->res->red('product');
		}
		function thumbnail(){
			$file = $this->req->files['file'];
			if(!empty($file)){
				$name = $file['name'];
				$type = $file['type'];
				$size = $file['size'];
				$tmp = $file['tmp_name'];
				$error = $file['error'];
				if($error != 0){
					echo $this->load->view('uploadfail',array('info'=>'上传图片出现系统错误'));
					exit;
				}
				if(!in_array($type,array('image/jpeg','image/png','image/bmp'))){
					echo $this->load->view('uploadfail',array('info'=>'只能上传图片类型：jpg,jpeg,png,bmp'));
					exit;
				}
				if($size > 1024*1024*4){
					echo $this->load->view('uploadfail',array('info'=>'上传图片不能超过4M'));
					exit;
				}
				$pos = strrpos($name,'.');
				if($pos > 0){
					$suffix = substr($name, $pos);
				}
				if(empty($suffix)){
					echo $this->load->view('uploadfail',array('info'=>'文件名不符合要求'));
					exit;
				}
				$imgname = randImgName(30);
				$thumbnail = $imgname.'60x60'.$suffix;
				$result = move_uploaded_file($tmp,UPLOAD.'thumbnail/'.$imgname.$suffix);
				header('Content-type:text/html');
				if($result){
					$this->load->model('img')->add($imgname.$suffix,$thumbnail);
					$lastid = $this->db->lastId();
					if(!empty($lastid)){
						imagecropper(UPLOAD.'thumbnail/'.$imgname.$suffix,60);//生成略缩图
						echo $this->load->view('uploadsuc',array('src'=>HOSTNAME."upload/thumbnail/".$imgname.$suffix,'img_id'=>$lastid));
					}else{
						if(unlink(UPLOAD.'thumbnail/'.$imgname)){
							echo $this->load->view('uploadfail',array('info'=>'插入数据库失败'));
							exit;
						}
					}
				}else{
					echo $this->load->view('uploadfail',array('info'=>'移动文件失败'));
				}
			}
		}
		function add(){
			// var_dump($this->req->post);
			// exit;
			if(count($this->req->post)){
				$post = $this->req->post;

				$name = $post['name'];
				$catalog_id = $post['catalog_id'];
				$price = $post['price'];
				$free_postage = $post['free_postage'];
				$postage = $post['postage'];
				$postage_remote = $post['postage_remote'];
				$score = $post['score'];
				$stock = $post['stock'];
				$detail = $post['editorValue'];
				$likes = $post['likes'];
				$attr_group_id = $post['attr_group_id'];
				$title = $post['title'];
				$keywords = $post['keywords'];
				$description = $post['description'];
				$hits = (int)$post['hits'];
				$for_presenter = (float)$post['for_presenter'];
				$for_workers = (float)$post['for_workers'];
				$date = timenow();
				$img_id = $post['img_id'];

				$arr = array(
					'name' => $name,
					'catalog_id' => (int)$catalog_id,
					'price' => (float)$price,
					'free_postage' => (int)$free_postage,
					'postage' => (float)$postage,
					"postage_remote" => (float)$postage_remote,
					'score' => (float)$score,
					'stock' => (int)$stock,
					'detail' => $detail,
					'likes' => (int)$likes,
					'date' => $date,
					'attr_group_id' => (int)$attr_group_id,
					'title' => $title,
					'hits' => $hits,
					'for_presenter' => $for_presenter,
					'for_workers' => $for_workers,
					'keywords' => $keywords,
					'description' => $description
				);
				// 用户输入产品信息验证
				if(strlen($name) < 1){
					setHint('名字不符合要求','bad');
					return $this->load->view('product_add',$arr);
				}
				if(!is_numeric($price)){
					setHint('价格必须是数字','bad');
					return $this->load->view('product_add',$arr);
				}
				if(!is_numeric($postage)){
					setHint('运费必须是数字','bad');
					return $this->load->view('product_add',$arr);
				}
				if(!is_numeric($postage_remote)){
					setHint('偏远地区运费必须是数字','bad');
					return $this->load->view('product_add',$arr);
				}
				if(!is_numeric($score)){
					setHint('积分必须是数字','bad');
					return $this->load->view('product_add',$arr);
				}
				if(!is_numeric($stock)){
					setHint('库存必须是数字','bad');
					return $this->load->view('product_add',$arr);
				}
				if(strlen($detail) < 10){
					setHint('产品详情太短','bad');
					return $this->load->view('product_add',$arr);
				}
				if(!is_numeric($likes)){
					setHint('点赞数必须是数字','bad');
					return $this->load->view('product_add',$arr);
				}
				if(!is_numeric($hits)){
					setHint('点击次数必须是数字','bad');
					return $this->load->view('product_add',$arr);
				}
				if(!is_numeric($for_presenter)){
					setHint('返给直接推荐者必须是数字','bad');
					return $this->load->view('product_add',$arr);
				}
				if(!is_numeric($for_workers)){
					setHint('返给工作人员必须是数字','bad');
					return $this->load->view('product_add',$arr);
				}
				if(strlen($title) < 5){
					setHint('详情页标题太短','bad');
					return $this->load->view('product_add',$arr);
				}
				if(strlen($keywords) < 5){
					setHint('详情页关键字太短','bad');
					return $this->load->view('product_add',$arr);
				}
				if(strlen($description) < 5){
					setHint('详情页描述太短','bad');
					return $this->load->view('product_add',$arr);
				}

				$result = $this->load->model('product')->add($arr);
				$lastid = $this->db->lastId();
				if($result && $lastid){
					$img_id_arr = explode(',', $img_id);
					$imgobj = $this->load->model('img');
					foreach ($img_id_arr as $key => $value) {
						$imgobj->updateProductid((int)$value,(int)$lastid);
					}
					setHint('添加商品成功');
				}else{
					setHint('添加商品失败','bad');
				}
				$this->res->red('product/add');
			}else{
				$catalogs = $this->load->model('catalog')->findName();
				$attrs = $this->load->model('attr_group')->findName();
				return $this->load->view('product_add',array(
					'catalogs'=>$catalogs,
					'attrs' => $attrs
				));
			}
		}
		function update($args){
			if(!count($this->req->post)){
				$product_id = (int)$args[0];
				if(empty($product_id)){
					$this->res->red('product/index');
				}
				$product = $this->load->model('product')->findById($product_id);
				$imgs = $this->load->model('img')->findByProductid($product_id);
				$catalogs = $this->load->model('catalog')->findName();
				$attrs = $this->load->model('attr_group')->findName();
				$product['imgs'] = $imgs;
				$product['catalogs'] = $catalogs;
				$product['attrs'] = $attrs;
				return $this->load->view('product_update',$product);
			}else{
				$post = $this->req->post;

				$name = $post['name'];
				$product_id = $post['product_id'];
				$catalog_id = $post['catalog_id'];
				$price = $post['price'];
				$free_postage = $post['free_postage'];
				$postage = $post['postage'];
				$postage_remote = $post['postage_remote'];
				$score = $post['score'];
				$stock = $post['stock'];
				$detail = $post['editorValue'];
				$likes = $post['likes'];
				$attr_group_id = $post['attr_group_id'];
				$title = $post['title'];
				$keywords = $post['keywords'];
				$description = $post['description'];
				$hits = (int)$post['hits'];
				$for_presenter = (float)$post['for_presenter'];
				$for_workers = (float)$post['for_workers'];
				$img_id = $post['img_id'];

				$arr = array(
					'product_id' => (int)$product_id,
					'name' => $name,
					'catalog_id' => (int)$catalog_id,
					'price' => (float)$price,
					'free_postage' => (int)$free_postage,
					'postage' => (float)$postage,
					'postage_remote' => (float)$postage_remote,
					'score' => (float)$score,
					'stock' => (int)$stock,
					'detail' => $detail,
					'likes' => (int)$likes,
					'attr_group_id' => (int)$attr_group_id,
					'title' => $title,
					'hits' => $hits,
					'for_presenter' => $for_presenter,
					'for_workers' => $for_workers,
					'keywords' => $keywords,
					'description' => $description
				);
				// 用户输入产品信息验证
				if(strlen($name) < 1){
					setHint('名字不符合要求','bad');
					$this->res->red('product/update/'.$product_id);
				}
				if(!is_numeric($price)){
					setHint('价格必须是数字','bad');
					$this->res->red('product/update/'.$product_id);
				}
				if(!is_numeric($postage)){
					setHint('运费必须是数字','bad');
					$this->res->red('product/update/'.$product_id);
				}
				if(!is_numeric($postage_remote)){
					setHint('偏远地区运费必须是数字','bad');
					$this->res->red('product/update/'.$product_id);
				}
				if(!is_numeric($score)){
					setHint('积分必须是数字','bad');
					$this->res->red('product/update/'.$product_id);
				}
				if(!is_numeric($stock)){
					setHint('库存必须是数字','bad');
					$this->res->red('product/update/'.$product_id);
				}
				if(strlen($detail) < 10){
					setHint('产品详情太短','bad');
					$this->res->red('product/update/'.$product_id);
				}
				if(!is_numeric($likes)){
					setHint('点赞数必须是数字','bad');
					$this->res->red('product/update/'.$product_id);
				}
				if(!is_numeric($hits)){
					setHint('点击次数必须是数字','bad');
					$this->res->red('product/update/'.$product_id);
				}
				if(!is_numeric($for_presenter)){
					setHint('返给直接推荐者必须是数字','bad');
					$this->res->red('product/update/'.$product_id);
				}
				if(!is_numeric($for_workers)){
					setHint('返给工作人员必须是数字','bad');
					$this->res->red('product/update/'.$product_id);
				}
				if(strlen($title) < 5){
					setHint('详情页标题太短','bad');
					$this->res->red('product/update/'.$product_id);
				}
				if(strlen($keywords) < 5){
					setHint('详情页关键字太短','bad');
					$this->res->red('product/update/'.$product_id);
				}
				if(strlen($description) < 5){
					setHint('详情页描述太短','bad');
					$this->res->red('product/update/'.$product_id);
				}
				$result = $this->load->model('product')->update($arr);
				$img_id_arr = explode(',', $img_id);
				$imgobj = $this->load->model('img');
				foreach ($img_id_arr as $key => $value) {
					$imgobj->updateProductid((int)$value,(int)$product_id);
				}
				setHint('更新商品成功');//这里无法判断是否真的成功，因为用户可能只更新了img表
				$this->res->red('product');
			}
		}
	}
?>
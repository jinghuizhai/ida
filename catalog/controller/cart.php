<?php 
	class ControllerCart extends Controller{
		function find(){
			header("Content-type:application/json");
			/*偏远地区省份id
			内蒙古，青海，宁夏，甘肃，广西，海南*/
			$remote_arr = array(
				'150000','630000','640000','620000','450000','460000'
			);
			$user_id = (int)$this->session->data['user']['user_id'];
			$cart = $this->req->post['cart'];
			$address_id = (int)$this->req->post['address_id'];
			$cart_arr = explode(',',$cart);
			$product_id_arr = array();
			$product_num_arr = array();
			preg_match_all('/(\d+)[:](\d+)/',$cart,$arr);
			$product_id_arr = $arr[1];
			$product_num_arr = $arr[2];
			$product = array();
			$cartobj = $this->load->model('cart');
			$price = 0;
			$postage = 0;
			$address = $this->load->model('address');
			if(count($product_id_arr) > 0 && count($product_id_arr) == count($product_num_arr)){
				foreach($product_id_arr as $key => $value){
					$result = $cartobj->findById((int)$value);
					if($result){
						$pieces = $product_num_arr[$key];
						$price = $price+$result['price']*$pieces;
						//不免运费
						if($result['free_postage'] == 1){
							//根据用户的地址确定商品的邮费
							if($address_id != 0){
								$ads = $address->findProvinceById($address_id);
								if(!empty($ads) && in_array($ads['province'],$remote_arr)){
									$fee = $result['postage_remote'];
								}else{
									$fee = $result['postage'];
								}
							}else{
								$fee = $result['postage'];
							}
							$postage = $postage+$fee*$pieces;
						}
						$result['pieces'] = $pieces;
						$product[] = $result;
					}
				}
				echo json_encode(array(
					'price'   => $price,
					'postage' => $postage,
					'total'   => $price+$postage,
					'products'=> $product 
				));
			}else{
				echo "";
			}
		}
	}
?>
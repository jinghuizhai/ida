<?php
	class ControllerCheckout extends Controller{
		function ali_pc_pay(){
			require_once(ALIPCPAY."alipay.config.php");
			require_once(ALIPCPAY."alipay_submit.class.php");
	        $payment_type = "1";
	        $notify_url = "<?php echo HOSTNAME;?>home/pay_callback";
	        $return_url = HOSTNAME."home/paysuccess";
	        $out_trade_no = $_POST['WIDout_trade_no'];
	        $subject = $_POST['WIDsubject'];
	        $total_fee = $_POST['WIDtotal_fee'];
	        $body = $_POST['WIDbody'];
	        $show_url = $_POST['WIDshow_url'];
	        $anti_phishing_key = time();
	        $exter_invoke_ip = $_SERVER["REMOTE_ADDR"];

			$parameter = array(
					"service" => "create_direct_pay_by_user",
					"partner" => trim($alipay_config['partner']),
					"seller_email" => trim($alipay_config['seller_email']),
					"payment_type"	=> $payment_type,
					"notify_url"	=> $notify_url,
					"return_url"	=> $return_url,
					"out_trade_no"	=> $out_trade_no,
					"subject"	=> $subject,
					"total_fee"	=> $total_fee,
					"body"	=> $body,
					"show_url"	=> $show_url,
					"anti_phishing_key"	=> $anti_phishing_key,
					"exter_invoke_ip"	=> $exter_invoke_ip,
					"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
			);
			// var_dump($alipay_config,$parameter);
			//建立请求
			$alipaySubmit = new AlipaySubmit($alipay_config);
			$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
			return $html_text;
		}
		function ali_wap_pay(){
			require_once(ALIWAPPAY."alipay.config.php");
			require_once(ALIWAPPAY."lib/alipay_submit.class.php");
	        $payment_type = "1";
	        $notify_url = "<?php echo HOSTNAME;?>home/pay_callback";
	        $return_url = HOSTNAME."home/paysuccess";
	        $out_trade_no = $_POST['WIDout_trade_no'];
	        $subject = $_POST['WIDsubject'];
	        $total_fee = $_POST['WIDtotal_fee'];
	        $show_url = $_POST['WIDshow_url'];
	        $body = $_POST['WIDbody'];
	        $it_b_pay = $_POST['WIDit_b_pay'];
	        $extern_token = $_POST['WIDextern_token'];
			$parameter = array(
				"service" => "alipay.wap.create.direct.pay.by.user",
				"partner" => trim($alipay_config['partner']),
				"seller_id" => trim($alipay_config['seller_id']),
				"payment_type"	=> $payment_type,
				"notify_url"	=> $notify_url,
				"return_url"	=> $return_url,
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> $subject,
				"total_fee"	=> $total_fee,
				"show_url"	=> $show_url,
				"body"	=> $body,
				"it_b_pay"	=> $it_b_pay,
				"extern_token"	=> $extern_token,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
			);
			// return var_dump($alipay_config,$parameter);
			//建立请求
			$alipaySubmit = new AlipaySubmit($alipay_config);
			$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
			echo $html_text;
		}
		function ali_bank_pay(){
			require_once(ALIBANKPAY."alipay.config.php");
			require_once(ALIBANKPAY."lib/alipay_submit.class.php");
	        $payment_type = "1";
	        $notify_url = "<?php echo HOSTNAME;?>home/pay_callback";
	        $return_url = HOSTNAME."home/paysuccess";
	        $out_trade_no = $_POST['WIDout_trade_no'];
	        $subject = $_POST['WIDsubject'];
	        $total_fee = $_POST['WIDtotal_fee'];
	        $body = $_POST['WIDbody'];
	        $paymethod = "bankPay";
	        // $defaultbank = $_POST['WIDdefaultbank'];
	        $defaultbank = $_POST['paycode'];
	        $show_url = $_POST['WIDshow_url'];
	        $anti_phishing_key = "";
	        $exter_invoke_ip = "";
			$parameter = array(
				"service" => "create_direct_pay_by_user",
				"partner" => trim($alipay_config['partner']),
				"seller_email" => trim($alipay_config['seller_email']),
				"payment_type"	=> $payment_type,
				"notify_url"	=> $notify_url,
				"return_url"	=> $return_url,
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> $subject,
				"total_fee"	=> $total_fee,
				"body"	=> $body,
				"paymethod"	=> $paymethod,
				"defaultbank"	=> $defaultbank,
				"show_url"	=> $show_url,
				"anti_phishing_key"	=> $anti_phishing_key,
				"exter_invoke_ip"	=> $exter_invoke_ip,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
			);
			// return var_dump($alipay_config,$parameter);
			$alipaySubmit = new AlipaySubmit($alipay_config);
			$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
			echo $html_text;
		}
		function createOrder(){
			$post = $this->req->post;
			$user_id = (int)$this->session->data['user']['user_id'];
			$cart = $post['cart'];
			$address_id = (int)$post['radio'];
			$payway = $post['payway'];

			if(strlen($cart) < 3){
				setHint('您的购物车中还没有商品，不能提交订单','bad');
				$this->res->redirect('checkout/productList');
			}
			if($payway == 'alipay'){
				if(isMobil()){
					$payway = 'ali_wap_pay';
				}else{
					$payway = 'ali_pc_pay';
				}
			}else if($payway == 'weixinpay'){
				$payway = 'weixin_pay';
			}else if(!empty($payway)){
				$paycode = strtoupper($payway);
				$payway = 'ali_bank_pay';
			}else{
				setHint('请选择支付方式','bad');
				$this->res->redirect('checkout/productList');
			}
			//暂时只能使用此方式
			$payway = 'ali_pc_pay';

			//检查地址是否存在
			$address = $this->load->model('address');
			$result_address = $address->findById($address_id,$user_id);
			if($result_address){
				$address->updateUsed($user_id,0);
				$address->updateUsing($address_id,1);
			}else{
				setHint('地址不存在，不能提交订单','bad');
				$this->res->redirect('checkout/productList');
			}
			/*偏远地区省份id
			内蒙古，青海，宁夏，甘肃，广西，海南*/
			$remote_arr = array(
				'150000','630000','640000','620000','450000','460000'
			);
			$is_remote = in_array($result_address['provinceid'],$remote_arr);
			//查询商品
			$product_id_arr = array();
			$product_num_arr = array();
			preg_match_all('/(\d+)[:](\d+)/',$cart,$arr);
			$product_id_arr = $arr[1];
			$product_num_arr = $arr[2];
			$products = array();
			if(count($product_id_arr) > 0 && count($product_id_arr) == count($product_num_arr)){
				$product = $this->load->model('product');
				foreach($product_id_arr as $key => $value){
					$result = $product->findById((int)$value);
					if(!$result || empty($product_num_arr[$key])){
						setHint('非法的商品信息，不能提交订单','bad');
						$this->res->redirect('checkout/productList');
						break;
					}else{
						$result['piece'] = $product_num_arr[$key];
					}
					$products[] = $result;
				}
				//生成订单
				//事务
				$this->db->begin();
				$order = $this->load->model('order');
				$order_info = $this->load->model('orderInfo');

				$ret = $order->add(array(
					"pay"         =>  0,
					"send"        =>  0,
					"user_id"     =>  $user_id,
					"address_id"  =>  $address_id,
					'address'     =>  $result_address['province'].$result_address['city'].$result_address['area'].$result_address['zip'].$result_address['detail'],
					"date"        =>  timenow()
				));
				if(!$ret){
					$this->db->rollback();
					setHint('生成订单失败');
					$this->res->redirect('checkout/productList');
				}

				$lastId = (int)$this->db->lastId();
				$total_money = 0;

				foreach($products as $key => $value){
					$money = $value['piece']*$value['price'];
					if($value['free_postage'] == 1){
						if($is_remote){
							$fee = $value['postage_remote'];
						}else{
							$fee = $value['postage'];
						}
						$money = $money + $value['piece']*$fee;
					}
					$total_money = $total_money + $money;
					$ret = $order_info->add(array(
						'order_id'   => $lastId,
						"product_id" => (int)$value['product_id'],
						'piece'  => (int)$value['piece'],
						"postage"    => empty($value['free_postage'])?0:(float)$fee,
						"price"      => (float)$value['price'],
						"money"      => (float)$money
					));
					if(!$ret){
						$this->db->rollback();
						setHint('生成订单失败');
						$this->res->redirect('checkout/productList');
					}
				}
				$orderNum = createOrderNum();
				$ret = $order->update($lastId,$orderNum.$lastId,$total_money);
				if(!$ret){
					$this->db->rollback();
					setHint('生成订单失败');
					$this->res->redirect('checkout/productList');
				}
				$this->db->commit();
				//订单生成后清空cookie
				// setcookie('cart','',time()-3600);
				//订单已经提交，查询订单并返回结果
				$product_subject = '';
				foreach($products as $key => $value){
					$product_subject = $product_subject.$value['name']."(".$value['piece'].")";
				}
				$data = $order->findById($lastId);
				$data['subject'] = $product_subject;
				$data['body'] = '购物愉快';
				$data['url'] = HOSTNAME.'product/'.$products[0]['product_id'];
				//生成清单后删除此用户所有其他未付款订单
				$order->deleteNotPay($lastId,$user_id);
				return $this->load->view('checkout_createorder',array('order' => $data,'products'=>$products,'payway'=>$payway,'paycode'=>$paycode));
			}else{
				setHint('非法的商品信息，不能提交订单','bad');
			}
		}
	}
?>
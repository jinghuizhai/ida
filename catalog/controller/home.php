<?php 
	class ControllerHome extends Controller{
		function test(){
			var_dump($this->req->post);
		}
		function jsonArea(){
			$this->res->json();
			$filterArr = ['新疆维吾尔自治区','台湾省','香港特别行政区','澳门特别行政区','西藏自治区'];
			$data = (int)$this->req->post['data'];
			$html = file_get_contents("http://japi.zto.cn/zto/api_utf8/baseArea?msg_type=GET_AREA&data=".$data);
			if($data == 0){
				$province = json_decode('['.$html.']')[0];
				$result = array();
				if(empty($province->message)){
					$province = $province->result;
					foreach($province as $key => $value){
						if(!in_array($value->fullName,$filterArr)){
							$arr = array(
								'code' => $value->code,
								'fullName'=>$value->fullName
							);
							$result[] = $arr;
						}
					}
					echo json_encode(array(
						'message'=>'',
						'result'=>$result
					));
				}else{
					echo false;
				}
			}else{
				return $html;
			}
			// if(empty($this->session->data['user']) && empty($this->session->data['admin'])){
			// 	echo false;//前台并不显示内容
			// }else{
			// 	echo file_get_contents("http://japi.zto.cn/zto/api_utf8/baseArea?msg_type=GET_AREA&data=".$data);
			// }
		}
		// function test2(){
		// 	$this->res->json();
		// 	$post = $this->req->post;
		// 	$a = $post['a'];
		// 	sleep(5);
		// 	echo $a;
		// }
		// function test(){
		// 	$arr = array(
		// 		'name' => 'zjh',
		// 		'phone' => '125456456456',
		// 		'address'=> '河南武陟',
		// 		'order_code'=>'126546545415',
		// 		'ssl' => 'jfslkjsd978f9sdioj',
		// 		'money' => 25,
		// 		'product_info'=>'ida man x2'
		// 	);
		// 	echo phppost('http://www.vipaida.com/YlFyS93/sslorder2.php',$arr);
		// }
		//支付成功后由支付页面同步返回此页面，不保证一定返回，所以尽量不处理业务逻辑
		function paysuccess(){
			return $this->load->view('pay_success');
		}
		//接收何航标发送的参数,插入快递单号
		function send_express_code(){
			//何航标不支持post发送
			$post = $this->req->get;
			$this->res->json();
			$ret = array();
			if($post){
				$ssl = $post['ssl'];
				$order_code = $post['order_code'];
				$express_code = $post['express_code'];
				$order = $this->load->model('order');
				if(empty($order_code) || empty($express_code) || empty($ssl)){
					$ret['tag'] = 'fail';
					$ret['info'] = 105;//某一项或多项参数为空
					echo json_encode($ret);
					exit;
				}
				if($ssl == '0b84fec8ed166bfb981b70f78d66349c7'){
					$result = $order->findByOrdercode($order_code);
					if($result){
						if(empty($result['express_code'])){
							$result_express = $order->updateExpress((int)$result['order_id'],$express_code);
							if($result_express){
								$ret['tag'] = 'success';
							}else{
								$ret['tag'] = 'fail';
								$ret['info'] = 104;//由于网络原因，插入数据失败
							}
						}else{
							$ret['tag'] = 'fail';
							$ret['info'] = 103;//快递单号已经存在
						}
					}else{
						$ret['tag'] = 'fail';
						$ret['info'] = 102;//订单号不存在
					}
				}else{
					$ret['tag'] = 'fail';
					$ret['info'] = 101;//密钥不正确
				}
			}else{
				$ret['tag'] = 'fail';
				$ret['info'] = 100;//没有传参数
			}
			// echo json_encode($ret);何航标不支持json
			echo $ret['tag'];
		}
		//根据user购买的商品清单，对上级进行返利
		private function returnMoneyByProduct($products,$user){

			$amount = $this->load->model('amount');

			try{
				foreach($products as $key => $value){
					$for_presenter = $value['for_presenter'];
					$for_workers = $value['for_workers'];
					$score = $value['score'];
					$piece = $value['piece'];
					$user_id = (int)$user_id;
					$money_presenter = (float)$piece*$for_presenter;
					$total_score = (float)$piece*$score;

					if($user['p_id'] != 0){
						$amount->updateMoney((int)$user['p_id'],$money_presenter);
					}else if($user['subagent_id'] != 0){
						$amount->updateMoney((int)$user['subagent_id'],$money_presenter);
					}else if($user['agent_id'] != 0){
						$amount->updateMoney((int)$user['agent_id'],$money_presenter);
					}else if($user['sale_id'] != 0){
						$amount->updateMoney((int)$user['sale_id'],$money_presenter);
					}

					if($user['sale_id'] != 0){
						$amount->updateScore((int)$user['sale_id'],$total_score);
					}
					if($user['agent_id'] != 0){
						$amount->updateScore((int)$user['agent_id'],$total_score);
					}
					if($user['subagent_id'] != 0){
						$amount->updateScore((int)$user['subagent_id'],$total_score);
					}
				}
				return true;
			}catch(Exception $e){
				// throw new Exception("Error Processing Request", 1);
				logs($e);
				return false;
			}
		}
		//虚拟主机发送过来的订单更新信息 可能会失败
		function remote_update_send(){
			$post = $this->req->post;
			$ssl = $post['ssl'];
			$order_id = $post['order_id'];
			//9108ed24564b0f65228dff35970c1546 = md5('123sjfkl56@%<#');
			if(md5($ssl) == '9108ed24564b0f65228dff35970c1546'){
				$result = $this->load->model('order')->updateSend($order_id);
				if(!$result){
					logs('remote_update_send error!');
				}
			}
		}
		private function getSendOrderInfo($order_id){
			$order_send = $this->load->model('order')->findDetailByid($order_id);
			$product_send = $this->load->model('orderInfo')->findInfoById($order_id);
			$product_info = '';
			foreach($product_send as $key => $value){
				$product_info = $product_info.$value['name'].'x'.$value['piece'];
			}
			$order_send['product_info'] = $product_info;
			$order_send['ssl'] = '0b84fec8ed166bfb981b70f78d66349c7';
			return $order_send;
		}
		//阿里支付，微信支付，网银支付使用的回调函数，订单下单成功后
		// 1 改变订单状态
		// 2 发送订单到远程客户端
		// 3 为上级业务员返利
		// 4 所有分公司，业务员，代理，分代理，都添加积分
		function pay_callback(){

			$this->res->json();
			require_once(ALIPAY."alipay.config.php");
			require_once(ALIPAY."alipay_notify.class.php");
			$post = $this->req->post;
			// //计算得出通知验证结果
			$alipayNotify = new AlipayNotify($alipay_config);
			$verify_result = $alipayNotify->verifyNotify();
			$error_str = "";
			foreach($post as $key => $value){
				$error_str .= $key."=>".$value; 
			}
			logs($error_str);
			// $verify_result = true;
			if($verify_result) {
				//商户订单号
				$order_code = $post['out_trade_no'];
				//支付宝交易号
				$trade_no = $post['trade_no'];
				//交易状态
				$trade_status = $post['trade_status'];
				if(empty($order_code) || empty($trade_no)){
					echo 'fail';
					return;
				}
			    if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
			    	//检查此订单是否已经有快递单号
			    	$result_order = $this->load->model('order')->findByOrdercode($order_code);
			    	if($result_order){
			    		if(empty($result_order['rebate_tag'])){
			    			//处理系统返佣等业务
			    			$user_id = (int)$result_order['user_id'];
			    			$order_id = (int)$result_order['order_id'];

			    			$user = $this->load->model('user')->findById($user_id);
			    			$products = $this->load->model('orderInfo')->findInfoById($order_id);
			    			//开始事务
			    			$this->db->begin();
			    			//为上级业务员返利
							$result_ret = $this->returnMoneyByProduct($products,$user);
							//更新订单信息
							$result_update = $this->load->model('order')->updateRebatetag($result_order['order_id'],$trade_no);
							if($result_ret && $result_update){
								// $this->db->commit();
								$remote_result = phppost('http://www.vipaida.com/YlFyS93/sslorder2.php',$this->getSendOrderInfo($order_id));
								if(trim($remote_result) == 'success'){
									//更新订单send= 1
									$result_send = $this->load->model('order')->updateSend($order_id);
									if(!$result_send){
										logs('error upadte order send id='.$order_id);
									}
								}
								echo 'success';
							}else{
								$this->db->rollback();
								logs('pay_callback error');
								echo 'fail';
							}
							//缺少给何发送订单
			    		}else{
			    			echo 'fail';
			    		}
			    	}else{
			    		echo 'fail';//订单号不存在
			    	}
			    }else{
			    	echo 'fail';
			    }
			}else{
				echo 'fail';
			}
		}
		function index(){
			$data = $this->load->model('catalog')->findFirst();
			return $this->load->view('index',array(
				'catalogs'=>$data
			));
		}
		function productList(){
			if(empty($this->session->data['user'])){
				setHint('请先登录','bad');
				$this->res->redirect('home/login');
			}
			$data = $this->load->model('address')->find((int)$this->session->data['user']['user_id']);
			return $this->load->view('checkout_product_list',array('addresses'=>$data));
		}
		function forget(){
			$post = $this->req->post;
			if(count($post)){
				$phone = $post['phone'];
				$code = $post['code'];
				if(!validate('phone',$phone)){
					setHint('手机号格式不正确','bad');
					$this->res->redirect('home/forget');
				}
				if(!validate('code',$code)){
					setHint('验证码格式不正确','bad');
					$this->res->redirect('home/forget');
				}
				$user = $this->load->model('user');
				$result = $user->findByPhone($phone);
				if($result){
					$newpass = randCode(8);
					$result2 = $user->updatePassByPhone($phone,md5($newpass));
					if($result2){
						//发送sms
						sendSmscode($phone,'您的新密码是'.$newpass);
						setHint('密码已发送到您的手机,请稍后……');
						$this->res->redirect('home/login');
					}else{
						setHint('变更密码失败','bad');
						$this->res->redirect('home/forget');
					}
				}else{
					setHint('没有此用户','bad');
					$this->res->redirect('home/forget');
				}
			}else{
				return $this->load->view('forget');
			}
		}
		function logout(){
			$this->session->destroy();
			$this->res->redirect('home');
		}
		function login(){
			$post = $this->req->post;
			if(count($post)){
				$phone = $post['phone'];
				$pass = $post['pass'];
				$code = $post['code'];
				if(!validate('phone',$phone)){
					setHint('邮件格式不正确');
					$this->res->redirect('home/login');
				}
				if(!validate('pass',$pass)){
					setHint('密码不符合要求');
					$this->res->redirect('home/login');
				}
				if(!validate('code',$code)){
					setHint('验证码格式不正确');
					$this->res->redirect('home/login');
				}
				if($this->session->data['validatecode'] != $code){
					setHint('验证码不正确');
					$this->res->redirect('home/login');
				}
				$user = $this->load->model('user')->findByPhonePass($phone,md5($pass));
				// return var_dump($user);
				if($user){
					if(!empty($user['permission'])){
						$user['permission'] = unserialize($user['permission']);
					}
					$this->session->data['user'] = $user;
					setHint('欢迎登录');
					$this->session->data['validatecode'] = null;
					$this->res->redirect('home');
				}else{
					setHint('账号或密码不正确','bad');
					$this->res->redirect('home/login');
				}
			}else{
				$catalogs = $this->load->model('catalog')->findFirst();
				return $this->load->view('login',array('catalogs'=>$catalogs));
			}
		}
		function register($args){
			$post = $this->req->post;
			if(count($post)){
				$phone = $post['phone'];
				$pass = $post['pass'];
				$code = $post['code'];
				$sms = $post['sms'];
				$name = $post['name'];

				// return var_dump($post);
				if(empty($this->session->data['invitationcode'])){
					setHint('对不起，不通过邀请链接不能注册');
					$this->res->redirect('home/register');
				}
				if(!validate('pass',$pass)){
					setHint('密码不符合要求');
					$this->res->redirect('home/register');
				}
				if(!validate('code',$code)){
					setHint('验证码格式不正确');
					$this->res->redirect('home/register');
				}
				if($this->session->data['validatecode'] != $code){
					setHint('验证码不正确');
					$this->res->redirect('home/register');
				}
				if(!validate('sms',$sms)){
					setHint('短信验证码格式不正确');
					$this->res->redirect('home/register');
				}
				if(!validate('name',$name)){
					setHint('姓名必须为2~4个中文字符');
					$this->res->redirect('home/register');
				}
				if(empty($this->session->data['smscode'])){
					setHint('您没有获取短信验证码');
					$this->res->redirect('home/register');
				}
				if($this->session->data['smscode'] != $sms){
					setHint('短信验证码不正确');
					$this->res->redirect('home/register');
				}

				$user = $this->load->model('user');
				$link = $user->findByLink($this->session->data['invitationcode']);
				if(!$link){
					setHint('对不起，邀请链接不合法','bad');
					$this->res->redirect('home/register');
				}
				$euser = $user->findByPhone($phone);
				if($euser){
					setHint('对不起，手机号已经被注册','bad');
					$this->res->redirect('home/register');
				}

				$arr = array(
					"phone"     => $phone,
					"pass"      => md5($pass),
					'name'      => $name,
					'can_cashout'=>1,
					'date'      => timenow()
				);

				$tag = $link['tag'];

				if($tag == 'sale'){//添加代理
					$role_id = (int)$this->load->model('role')->findByTag('agent')["role_id"];
					$arr['role_id'] = $role_id;
					$arr['branch_id'] = (int)$link['branch_id'];
					$arr['sale_id'] = (int)$link['user_id'];
					$arr['agent_id'] = 0;
					$arr['subagent_id'] = 0;
					$arr['p_id'] = 0;
				}else if($tag == 'agent'){//添加分代理
					$role_id = (int)$this->load->model('role')->findByTag('subagent')["role_id"];
					$arr['role_id'] = $role_id;
					$arr['branch_id'] = (int)$link['branch_id'];
					$arr['sale_id'] = (int)$link['sale_id'];
					$arr['agent_id'] = (int)$link['user_id'];
					$arr['subagent_id'] = 0;
					$arr['p_id'] = 0;
				}else if($tag == 'subagent'){//添加会员
					$role_id = (int)$this->load->model('role')->findByTag('member')["role_id"];
					$arr['role_id'] = $role_id;
					$arr['branch_id'] = (int)$link['branch_id'];
					$arr['sale_id'] = (int)$link['sale_id'];
					$arr['agent_id'] = (int)$link['agent_id'];
					$arr['subagent_id'] = (int)$link['user_id'];
					$arr['p_id'] = 0;
				}else if($tag == 'member'){//添加介绍会员
					$role_id = (int)$this->load->model('role')->findByTag('member')["role_id"];
					$arr['role_id'] = $role_id;
					$arr['branch_id'] = (int)$link['branch_id'];
					$arr['sale_id'] = (int)$link['sale_id'];
					$arr['agent_id'] = (int)$link['agent_id'];
					$arr['subagent_id'] = (int)$link['subagent_id'];
					$arr['p_id'] = (int)$link['user_id'];
				}else{
					setHint('您的链接不合法','bad');
					$this->res->redirect('home/register');
				}
				$result = $user->add($arr);
				if($result){
					$lastId = (int)$this->db->lastId();
					$randcode = randImgName(25);
					$link = $randcode.'u'.$lastId;
					$update = $user->updateLink(array(
						'user_id' => $lastId,
						'link' => $link,
						'linkimg' => $link.'.png',
						'logoimg' => $link."logo.png"
					));
					if($update){
						createQcode(HOSTNAME.'home/register/'.$link,$link,'logo.png',QCODE,7);
					}
					setHint('注册成功');
					//为用户生成积分账号
					$this->load->model('amount')->add(array(
						'user_id' => $lastId,
						'money' => 0,
						'score' => 0
					));
					$newuser = $user->findById($lastId);
					if(!empty($newuser['permission'])){
						$newuser['permission'] = unserialize($newuser['permission']);
					}else{
						$newuser['permission'] = array();
					}
					$this->session->data['user'] = $newuser;
					$this->session->data['validatecode'] = null;
					$this->session->data['smscode'] = null;
					$this->res->redirect('user/dashboard');
				}else{
					setHint('注册失败',"bad");
				}
				//无论注册成功失败，都重置关于验证码的session
				$this->session->data['validatecode'] = null;
				$this->session->data['smscode'] = null;
				$this->res->redirect('home/register');
			}else{
				if(!empty($args[0])){
					$this->session->data['invitationcode'] = $args[0];
				}
				$catalogs = $this->load->model('catalog')->findFirst();
				return $this->load->view('register',array('invitationcode'=>$this->session->data['invitationcode'],'catalogs'=>$catalogs));
			}
		}
		function getValidateCode(){
			$this->res->json();
			echo trim($this->session->data['validatecode']);
		}
		function hasError(){
			return $this->load->view('404');
		}
		// 查看此手机号是否注册，如果没有，则发送验证码
		function checkPhone(){
			$this->res->json();
			$phone = $this->req->post['phone'];
			if(!validate('phone',$phone)){
				echo '您输入的手机号不符合要求';
				return;
			}
			$result = $this->load->model('user')->findByPhone($phone);
			if($result){
				echo "您输入的手机号已经被注册";
				return;
			}else{
				$code = createSmscode();//default 6 digits
				$sms = sendSmscode($phone,'您好，您的验证码是'.$code.'，此验证码用于注册');
				if($sms == 1){
					$this->session->data['smscode'] = $code;
					echo 'success';
				}else{
					echo 'fail';
				}
			}
		}
	}
?>
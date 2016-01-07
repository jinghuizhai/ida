<?php
	class ControllerAmount extends Controller{
		function index(){
			$user_id = (int)$this->session->data['user']['user_id'];
			$data = $this->load->model('amount')->findByUserid($user_id);
			return $this->load->view('amount',array('amount'=>$data),'admin_header','admin_footer');
		}
		function cashout(){
			$this->res->json();
			$user_id = (int)$this->session->data['user']['user_id'];
			$ret = array();
			//检查是否能提现
			$user = $this->load->model('user')->findCashoutById($user_id);
			if(!empty($user['can_cashout'])){
				//检查账号是否存在
				$result = $this->load->model('amount')->findByUserid($user_id);
				if((float)$result['money'] > 0){
					$paycount = $this->load->model('user')->findPaycount($user_id);
					if($paycount){
						//开始事务
						$this->db->begin();
						//添加提现记录
						try{
							$result_cashout = $this->load->model('cashoutHistory')->add(array(
								'user_id' => $user_id,
								'money'   => (float)$result['money'],
								'status'  => 0,
								'date'    => timenow()
							));
							//更新账户现金余额
							$result_clear = $this->load->model('amount')->clearMoney($user_id);
							$this->db->commit();
							$ret['tag'] = 'success';
							$ret['money'] = array('from' => (float)$result['money'],'to'=> 0);
						}catch(Exception $e){
							$this->db->rollback();
							$ret['tag'] = 'fail';
							$ret['info'] = '由于网络原因，提现失败，请稍候再试';
							logs($e);
						}
					}else{
						$ret['tag'] = 'fail';
						$ret['info'] = '您还没有添加银行卡信息，无法提现，请先添加银行卡信息';
					}
				}else{
					$ret['tag'] = 'fail';
					$ret['info'] = '您的账户中没有余额，不能提现';
				}
			}else{
				$ret['tag'] = 'fail';
				$ret['info'] = '您暂时不能提现，需要管理员开放提现权限';
			}
			echo json_encode($ret);
		}
		function countScore(){
			$this->res->json();
			$user_id = (int)$this->session->data['user']['user_id'];
			$tag = $this->session->data['user']['tag'];
			if($tag == 'branch'){
				echo '0<small>(分公司不积累积分)</small>';
			}else{
				echo (int)$this->load->model('amount')->findByUserid($user_id)['score'];
			}
		}
		function transfer(){
			$this->res->json();
			$user_id = (int)$this->session->data['user']['user_id'];
			$amount = $this->load->model('amount')->findByUserid($user_id);
			$ret = array();

			if($amount){
				$score = $amount['score'];
				$money = $amount['money'];
				if($score > 0){
					//事务开始
					$this->db->begin();
					try{
						//查看兑换规则
						$configs = $this->load->model('configs')->findMoney();
						//更新积分和金额
						$total_money = $money + $configs['money']*$score;
						$result = $this->load->model('amount')->update(array(
							"money"    => (float)$total_money,
							"score"   => 0,
							"amount_id"=> (int)$amount['amount_id'],
							"user_id"  => $user_id
						));
						//插入兑换记录
						$history = $this->load->model('transferHistory')->add(array(
							"user_id" => $user_id,
							"score"   => (float)$score,
							'money'   => (float)$configs['money']*$score,
							"date"    => timenow()
						));
						$history_id = (int)$this->db->lastId();
						$this->db->commit();
						$ret['tag'] = 'success';
						$amount_result = $this->load->model('amount')->findByUserid($user_id);
						$ret['score'] = array('from'=>(float)$score,'to'=>(float)$amount_result['score']);
						$ret['money'] = array('from'=>(float)$money,'to'=>(float)$amount_result['money']);
					}catch(Exception $e){
						$ret['tag'] = 'fail';
						$ret['info'] = '网络原因，兑换失败，请稍后再试';
						$this->db->rollback();
						logs($e);
					}
				}else{
					$ret['tag'] = 'fail';
					$ret['info'] = '您的账户中没有可以兑换的积分';
				}
			}else{
				$ret['tag'] = 'fail';
				$ret['info'] = '您还没有积分账户,不能兑换积分';
			}
			echo json_encode($ret);
		}
	}
?>
<?php
	class ControllerUser extends Controller{
		private $name;
		function bank(){
			$user_id = (int)$this->session->data['user']['user_id'];
			$user = $this->load->model('user')->findById($user_id);
			return $this->load->view('user_bank',array(),'admin_header','admin_footer');
		}
		function cancelMyself(){
			$post = $this->req->post;
			if(count($post)){
				$this->res->json();
				$sms = $post['sms'];
				$code = $post['code'];
				$json = array();

				if($sms == $this->session->data['smscode'] && $code == $this->session->data['validatecode']){
					//删除自己
					$user_id = (int)$this->session->data['user']['user_id'];
					$duser = $this->session->data['user'];
					$img = QCODE.$duser['linkimg'];
					$logoimg = QCODE.$duser['logoimg'];
					if(is_file($img)){
						unlink($img);
					}
					if(is_file($logoimg)){
						unlink($logoimg);
					}
					$result = $this->load->model('user')->deleteById($user_id);
					if(!empty($result)){
						$this->session->destroy();
						$json['tag'] = 'success';
						$json['info'] = '您的账号已经被删除';
						$json['url'] = HOSTNAME.'home';
					}else{
						$json['tag'] = 'fail';
						$json['info'] = '账号删除失败';
					}
				}else{
					$json['tag'] = 'fail';
					$json['info'] = '验证码或者短信不正确';
				}
				echo json_encode($json);
			}else{
				return $this->load->view('user_cancel');
			}
		}
		function sendCancelSms(){
			$this->res->json();
			$json = array();
			$phone = $this->session->data['user']['phone'];
			$code_s = $this->session->data['validatecode'];
			$code = $this->req->post['code'];
			if($code_s == $code){
				$sms = createSmscode();
				$this->session->data['smscode'] = $sms;
				$ret = sendSmscode($phone,'您的验证码是:'.$sms);
				if($ret == 1){
					$json['tag'] = 'success';
				}else{
					$json['tag'] = 'fail';
					$json['info'] = '由于网络问题，短信没有发送成功，请稍候再试';
					$json['info'] = $ret;
				}
			}else{
				$json['tag'] = 'fail';
				$json['info'] = '验证码不正确';
			}
			echo json_encode($json);
		}
		function countUsers(){
			$this->res->json();
			$user_id = (int)$this->session->data['user']['user_id'];
			$tag = $this->session->data['user']['tag'];
			$user = $this->load->model('user');
			if($tag == 'branch'){
				$data = $user->countByBranch($user_id);
			}else if($tag == 'sale'){
				$data = $user->countBySale($user_id);
			}else if($tag == 'agent'){
				$data = $user->countByAgent($user_id);
			}else if($tag == 'subagent'){
				$data = $user->countBySubagent($user_id);
			}else if($tag == 'member'){
				$data = $user->countByPid($user_id);
			}else{
				$data = array();
			}
			echo (int)$data['count'];
		}
		function addSale(){
			$post = $this->req->post;
			if(count($post)){
				$name = $post['name'];
				$phone = $post['phone'];
				$pass = $post['pass'];
				$branch_id = (int)$this->session->data['user']['user_id'];
				$tag = 'sale';

				$arr = array(
					'name' => $name,
					'phone'=> $phone,
					'can_cashout'=>1,
					'branch_id'=> $branch_id,
					'sale_id'=>0,
					'agent_id'=>0,
					'subagent_id'=>0,
					'p_id' => 0,
					'date' => timenow(),
					'pass' => md5($pass)
				);
				
				if(empty($branch_id)){
					setHint('分公司ID必须是数字');
					$this->res->redirect('user/addSale');
				}
				if(strlen($name) < 1){
					setHint('名称太短');
					$this->res->redirect('user/addSale');
				}
				if(!validate('phone',$phone)){
					setHint('电话不符合要求');
					$this->res->redirect('user/addSale');
				}
				if(!validate('pass',$pass)){
					setHint('密码不符合要求');
					$this->res->redirect('user/addSale');
				}
				$hasUser = $this->load->model('user')->findByPhone($phone);
				if($hasUser){
					setHint('电话已经存在,请重新输入','bad');
					$this->res->redirect('user/addSale');
				}
				$role = $this->load->model('role')->findByTag($tag);
				if(!$role){
					setHint('tag不存在，不能添加','bad');
					$this->res->redirect('user/addSale');
				}
				$arr['role_id'] = (int)$role['role_id'];
				$result = $this->load->model('user')->add($arr);
				if($result){
					setHint('添加成功');
					$lastId = $this->db->lastId();
					//初始化用户积分账户
					$this->load->model('amount')->add(array(
						'user_id' => $lastId,
						'money'   => 0,
						'score'   => 0
					));
					$randcode = randImgName(25);
					$link = $randcode.'u'.$lastId;
					$imgarr = array(
						'user_id' => $lastId,
						'link' => $link,
						'linkimg' => $link.'.png',
						'logoimg' => $link."logo.png"
					);
					$update = $this->load->model("user")->updateQcode($imgarr);
					if($update){
						createQcode(HOSTNAME.'home/register/'.$link,$link,'logo.png',QCODE,7);
					}
				}else{
					setHint('添加失败','bad');
				}
				$this->res->redirect('user/addSale');
			}else{
				return $this->load->view('user_add_sale',array(),'admin_header','admin_footer');
			}
		}
		private function findByBranch($page){
			$data = $this->load->model('user')->findByBranch((int)$this->session->data['user']['user_id'],$page);
			$pagination = $this->db->getPage();
			return $this->load->view('user',array('users'=>$data,'pagination'=>$pagination),'admin_header','admin_footer');
		}
		private function findBySale($page){
			$data = $this->load->model('user')->findBySale((int)$this->session->data['user']['user_id'],$page);
			$pagination = $this->db->getPage();
			return $this->load->view('user',array('users'=>$data,'pagination'=>$pagination),'admin_header','admin_footer');
		}
		private function findByAgent($page){
			$data = $this->load->model('user')->findByAgent((int)$this->session->data['user']['user_id'],$page);
			$pagination = $this->db->getPage();
			return $this->load->view('user',array('users'=>$data,'pagination'=>$pagination),'admin_header','admin_footer');
		}
		private function findBySubagent($page){
			$data = $this->load->model('user')->findBySubagent((int)$this->session->data['user']['user_id'],$page);
			$pagination = $this->db->getPage();
			return $this->load->view('user',array('users'=>$data,'pagination'=>$pagination),'admin_header','admin_footer');
		}
		private function findByMember($page){
			$data = $this->load->model('user')->findByMember((int)$this->session->data['user']['user_id'],$page);
			$pagination = $this->db->getPage();
			return $this->load->view('user',array('users'=>$data,'pagination'=>$pagination),'admin_header','admin_footer');
		}
		function dashboard(){
			$broadcasts = $this->load->model('broadcast')->findByRoleid((int)$this->session->data['user']['role_id']);
			$user_id = (int)$this->session->data['user']['user_id'];
			$user = $this->load->model('user')->findImgById($user_id);
			return $this->load->view('dashboard',array('broadcasts'=>$broadcasts,'user'=>$user),'admin_header','admin_footer');
		}
		function find($args){
			$tag = $this->session->data['user']['tag'];
			$current = (int)$args[0];
			if(empty($current)){
				$current = 1;
			}
			$page = array($current,HOSTNAME."user/find/",15);
			if($tag == 'branch'){
				return $this->findByBranch($page);
			}else if($tag == 'sale'){
				return $this->findBySale($page);
			}else if($tag == 'agent'){
				return $this->findByAgent($page);
			}else if($tag == 'subagent'){
				return $this->findBySubagent($page);
			}else if($tag == 'member'){
				return $this->findByMember($page);
			}else{
				$this->res->redirect('user/noright');
			}
		}
		function updateName(){
			$post = $this->req->post;
			if(count($post)){
				$name = $post['name'];
				if(validate('name',$name)){
					$result = $this->load->model('user')->updateName((int)$this->session->data['user']['user_id'],$name);
					if($result){
						setHint('修改成功');
						$this->session->data['user'] = $this->load->model('user')->findById((int)$this->session->data['user']['user_id']);
					}else{
						setHint('修改失败','bad');
					}
				}else{
					setHint('姓名不符合要求','bad');
				}
				$this->res->redirect('user/updateName');
			}else{
				return $this->load->view('user_update_name',$this->session->data['user'],'admin_header','admin_footer');
			}
		}
		function updatePass(){
			$post = $this->req->post;
			if(count($post)){
				$pass = $post['pass'];
				$pass2 = $post['pass2'];
				$sms = $post['sms'];

				if(!validate('pass',$pass)){
					setHint('密码格式不正确','bad');
					$this->res->redirect('user/updatePass');
				}
				if(!validate('pass',$pass2)){
					setHint('重复密码格式不正确','bad');
					$this->res->redirect('user/updatePass');
				}
				if(!validate('sms',$sms)){
					setHint('短信验证码格式不正确','bad');
					$this->res->redirect('user/updatePass');
				}
				if($this->session->data['smscode'] != $sms){
					setHint('短信验证码不正确','bad');
					$this->res->redirect('user/updatePass');
				}
				$result = $this->load->model('user')->updatePass((int)$this->session->data['user']['user_id'],md5($pass));
				$this->session->data['smscode'] = null;
				if($result){
					setHint('修改密码成功');
				}else{
					setHint('修改密码失败','bad');
				}
				$this->res->redirect('user/updatePass');
			}else{
				return $this->load->view('user_update_pass',array(),'admin_header','admin_footer');
			}
		}
		function sendSmsWhenUpdate(){
			$this->res->json();
			$phone = $this->session->data['user']['phone'];
			if(!empty($phone)){
				$code = createSmscode();//default 6 digits
				$sms = sendSmscode($phone,'您好，您的验证码是'.$code.'，此验证码用于注册');
				if($sms == 1){
					$this->session->data['smscode'] = $code;
					echo 'success';
				}else{
					echo 'fail';
				}
			}else{
				echo '您没有手机号';
			}
		}
		function noright(){
			return $this->load->view('noright',null,'admin_header',"admin_footer");
		}
		function info($args){
			$user_id = (int)$args[0];
			$tag = $this->session->data['user']['tag'];
			$selfid = (int)$this->session->data['user']['user_id'];
			$ouser = $this->load->model('user');

			//此人基本信息
			//tag 限定只能是查看自己名下用户
			if($tag == 'branch'){
				$user = $ouser->findDetailByBranch($selfid,$user_id);
			}else if($tag == 'sale'){
				$user = $ouser->findDetailBySale($selfid,$user_id);
			}else if($tag == 'agent'){
				$user = $ouser->findDetailByAgent($selfid,$user_id);
			}else if($tag == 'subagent'){
				$user = $ouser->findDetailBySubagent($selfid,$user_id);
			}else if($tag == 'member'){
				$user = $ouser->findDetailByMember($selfid,$user_id);
			}
			//此人地址
			// $addresses = $this->load->model('address')->find($user_id);
			//此人订单
			$orders = $this->load->model('order')->findByUserid($user_id);
			
			//此人推荐总数
			$utag = $user['tag'];
			$oorder = $this->load->model('order');
			if($utag == 'sale'){
				$rcount = (int)$oorder->countBySale($user_id)['count'];
			}else if($utag == 'agent'){
				$rcount = (int)$oorder->countByAgent($user_id)['count'];
			}else if($utag == 'subagent'){
				$rcount = (int)$oorder->countBySubagent($user_id)['count'];
			}else if($utag == 'member'){
				$rcount = (int)$oorder->countByPid($user_id)['count'];
			}
			return $this->load->view('user_info',array(
				'user' => $user,
				// 'addresses'=> $addresses,
				'orders' => $orders,
				'rcount' => $rcount
			),'admin_header','admin_footer');
		}
	}
?>
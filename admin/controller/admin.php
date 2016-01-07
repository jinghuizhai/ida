<?php
	class ControllerAdmin extends Controller{
		function login(){
			$post = $this->req->post;
			if(count($post)){
				$email = $post['email'];
				$pass = $post['pass'];
				$code = $post['code'];

				if($this->session->data['validatecode'] != $code){
					setHint('验证码不正确','bad');
					$this->res->red('admin/login');
				}
				if(!validate('email',$email)){
					setHint('邮箱格式不正确','bad');
					$this->res->red('admin/login');
				}
				if(!validate('pass',$pass)){
					setHint('密码格式不正确','bad');
					$this->res->red('admin/login');
				}
				$pass = md5($pass);
				$result = $this->load->model('admin')->find($email,$pass);
				if($result){
					if(!empty($result['permission'])){
						$result['permission'] = unserialize($result['permission']);
					}
					$this->session->data['admin'] = $result;
					$this->res->red('admin/dashboard');
				}else{
					setHint('账号或者密码错误');
					$this->res->red('admin/login');
				}
			}else{
				return $this->load->view('login',array(),"placeholder","placeholder");	
			}
		}
		function hasError(){
			return $this->load->view('404',array(),'placeholder','placeholder');
		}
		function logout(){
			$this->session->destroy();
			setHint('注销成功');
			$this->res->red('admin/login');
		}
		function dashboard(){
			$today = format(timenow(),'-');

			$today_order = $this->load->model('order')->findCountByDate($today." 00:00:00",$today." 23:59:59");
			$today_user = $this->load->model('user')->findCountByDate($today." 00:00:00",$today." 23:59:59");
			$total_order = $this->load->model('order')->findCountByDate("1970-01-01",$today." 23:59:59");
			$total_user = $this->load->model('user')->findCountByDate("1970-01-01",$today." 23:59:59");
			//未发送成功订单
			$not_send = $this->load->model('order')->countNotSend()['count'];
			//未回复评论
			$comment_notReply = $this->load->model('comment')->countByStatus(0)['count'];
			//共有评论
			$comment_total = $this->load->model('comment')->count()['count'];
			//今天需要审核的提现请求
			$cashout_not = $this->load->model('cashoutHistory')->countByStatus(0)['count'];
			//已审核的体现请求
			$cashout_has = $this->load->model('cashoutHistory')->countByStatus(1)['count'];
			//所有已经审核的金额
			$total_money = $this->load->model('cashoutHistory')->countMoney()['money'];

			return $this->load->view('dashboard',array(
				'today_order'  => empty($today_order)?0:$today_order['count'],
				'today_user'   => empty($today_user)?0:$today_user['count'],
				'total_order'  => empty($total_order)?0:$total_order['count'],
				'total_user'  => empty($total_user)?0:$total_user['count'],
				'not_send' => $not_send,
				'comment_notReply' => $comment_notReply,
				'comment_total' => $comment_total,
				'cashout_not' => $cashout_not,
				'cashout_has' => $cashout_has,
				'total_money' => $total_money
			));

		}
		private function find($email,$pass){
			if(!validate('email',$email)){
				setHint('账号不符合要求','bad');
				$this->res->red('admin/login');
			}
			if(validate('pass',$pass)){
				$pass = md5($pass);
			}else{
				setHint('密码不符合要求','bad');
				$this->res->red('admin/login');
			}
			$result = $this->load->model('admin')->find($email,$pass);
			if($result){
				$this->session->data['admin'] = $result;
				setHint('登录成功');
				$this->res->red('admin/dashboard');
			}else{
				setHint('账号或密码错误','bad');
				$this->res->red('admin');
			}
		}
		function update(){
			$post = $this->req->post;
			if(count($post)){
				$old_pass = $post['old_pass'];
				$pass = $post['pass'];
				$pass2 = $post['pass2'];

				if(!validate('pass',$old_pass)){
					setHint('现在使用密码格式不正确','bad');
					$this->res->red('admin/update');
				}
				if(!validate('pass',$pass)){
					setHint('密码格式不正确','bad');
					$this->res->red('admin/update');
				}
				if(!validate('pass',$pass2)){
					setHint('重复密码格式不正确','bad');
					$this->res->red('admin/update');
				}
				$result = $this->load->model('admin')->updatePass(array(
					'pass' => md5($pass),
					'old_pass'=> md5($old_pass)
				));
				if($result){
					setHint('修改密码成功');
					$this->res->red('admin/update');
				}else{
					setHint('修改密码失败','bad');
					$this->res->red('admin/update');
				}
			}else{
				return $this->load->view('admin_update');
			}
		}
	}
?>
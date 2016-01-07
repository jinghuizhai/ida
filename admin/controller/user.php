<?php
	class ControllerUser extends Controller{
		function index($args){
			$current = (int)end($args);
			if($current == 0) $current = 1;

			$data = $this->load->model('user')->find(array($current,HOSTNAME.'admin/user/',15));
			return $this->load->view('user',array(
				'users'     => $data,
				'pagination'=> $this->db->getPage(),
			));
		}
		function deleteSubadmin(){
			$admin_id = (int)$this->req->post['admin_id'];
			$result = $this->load->model('admin')->delete($admin_id);
			if($result){
				setHint('删除分管理员成功');
			}else{
				setHint('删除分管理员失败','bad');
			}
			$this->res->red('user/subadmin');
		}
		function addSubadmin(){
			$post = $this->req->post;
			if(count($post)){
				$email = $post['email'];
				$pass = $post['pass']; 
				$role_id = $post['role_id'];
				$name = $post['name'];
				if(!validate('email',$email)){
					setHint('email不符合要求','bad');
					$this->res->red('user/addSubadmin');
				}
				if(!validate('name',$name)){
					setHint('姓名不符合要求','bad');
					$this->res->red('user/addSubadmin');
				}
				if(!validate('pass',$pass)){
					setHint('密码不符合要求','bad');
					$this->res->red('user/addSubadmin');
				}
				if(!is_numeric($role_id)){
					setHint('角色不符合要求','bad');
					$this->res->red('user/addSubadmin');
				}
				$arr = array(
					'email' => $email,
					'name' => $name,
					'pass' => md5($pass),
					'role_id' => (int)$role_id
				);
				$result = $this->load->model('admin')->add($arr);
				if($result){
					setHint('添加分管理员成功');
				}else{
					setHint('添加分管理员失败','bad');
				}
				$this->res->red('user/addSubadmin');
			}else{
				$roles = $this->load->model('role')->findByEntrance('backstage');
				return $this->load->view('user_add_subadmin',array('roles'=>$roles));
			}
		}
		function subadmin(){
			$roles = $this->load->model('admin')->findSubadmin();
			return $this->load->view('user_subadmin',array('roles'=>$roles));
		}
		function addBranch(){
			$post = $this->req->post;
			if(count($post)){
				$name = $post['name'];
				$phone = $post['phone'];
				$pass = $post['pass'];
				$tag = $post['tag'];

				$arr = array(
					'name' => $name,
					'phone'=> $phone,
					'can_cashout' => 1,
					'branch_id'=>0,
					'sale_id'=>0,
					'agent_id'=>0,
					'subagent_id'=>0,
					'p_id' => 0,
					'date' => timenow(),
					'pass' => md5($pass)
				);
				if(strlen($name) < 1){
					setHint('名称太短');
					$this->res->red('user/add');
				}
				if(!validate('phone',$phone)){
					setHint('电话不符合要求');
					$this->res->red('user/add');
				}
				if(!validate('pass',$pass)){
					setHint('密码不符合要求');
					$this->res->red('user/add');
				}
				$hasUser = $this->load->model('user')->findByPhone($phone);
				if($hasUser){
					setHint('电话已经存在,请重新输入','bad');
					$this->res->red('user/addBranch');
				}
				$role = $this->load->model('role')->findByTag($tag);
				if($role){
					$arr['role_id'] = (int)$role['role_id'];
					$result = $this->load->model('user')->add($arr);
					if($result){
						setHint('添加成功');
					}else{
						setHint('添加失败','bad');
					}
					$this->res->red('user/addBranch');
				}else{
					setHint('tag不存在，不能添加','bad');
				}
			}else{
				return $this->load->view('user_add_branch');
			}
		}
		function addSale(){
			$post = $this->req->post;
			if(count($post)){
				$name = $post['name'];
				$phone = $post['phone'];
				$pass = $post['pass'];
				$branch_id = (int)$post['branch_id'];
				$tag = $post['tag'];

				$arr = array(
					'name' => $name,
					'phone'=> $phone,
					'can_cashout' => 1,
					'sale_id'=>0,
					'agent_id'=>0,
					'subagent_id'=>0,
					'p_id' => 0,
					'date' => timenow(),
					'pass' => md5($pass)
				);
				
				if(empty($branch_id)){
					setHint('分公司ID必须是数字');
					$this->res->red('user/addSale');
				}
				if(strlen($name) < 1){
					setHint('名称太短');
					$this->res->red('user/addSale');
				}
				if(!validate('phone',$phone)){
					setHint('电话不符合要求');
					$this->res->red('user/addSale');
				}
				if(!validate('pass',$pass)){
					setHint('密码不符合要求');
					$this->res->red('user/addSale');
				}
				$hasUser = $this->load->model('user')->findByPhone($phone);
				if($hasUser){
					setHint('电话已经存在,请重新输入','bad');
					$this->res->red('user/addSale');
				}
				$role = $this->load->model('role')->findByTag($tag);
				$branch = $this->load->model('user')->findByRole($branch_id,'branch');
				if(!$role){
					setHint('tag不存在，不能添加','bad');
					$this->res->red('user/addSale');
				}
				if(!$branch){
					setHint('分公司不存在，不能添加','bad');
					$this->res->red('user/addSale');
				}

				$arr['role_id'] = (int)$role['role_id'];
				$arr['branch_id'] = (int)$branch['user_id'];
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
				$this->res->red('user/addSale');
			}else{
				return $this->load->view('user_add_sale');
			}
		}
		function addAgent(){
			$post = $this->req->post;
			if(count($post)){
				$name = $post['name'];
				$phone = $post['phone'];
				$pass = $post['pass'];
				$sale_id = (int)$post['sale_id'];
				$tag = $post['tag'];

				$arr = array(
					'name' => $name,
					'phone'=> $phone,
					'can_cashout' => 1,
					'p_id' => 0,
					'agent_id'=> 0,
					'subagent_id'=>0,
					'date' => timenow(),
					'pass' => md5($pass)
				);
				if(empty($sale_id)){
					setHint('业务员ID必须是数字');
					$this->res->red('user/addAgent');
				}
				if(strlen($name) < 1){
					setHint('名称太短');
					$this->res->red('user/addAgent');
				}
				if(!validate('phone',$phone)){
					setHint('电话不符合要求');
					$this->res->red('user/addAgent');
				}
				if(!validate('pass',$pass)){
					setHint('密码不符合要求');
					$this->res->red('user/addAgent');
				}
				$hasUser = $this->load->model('user')->findByPhone($phone);
				if($hasUser){
					setHint('电话已经存在,请重新输入','bad');
					$this->res->red('user/addAgent');
				}
				$role = $this->load->model('role')->findByTag($tag);
				$sale = $this->load->model('user')->findByRole($sale_id,'sale');
				if(!$role){
					setHint('tag不存在，不能添加','bad');
					$this->res->red('user/addAgent');
				}
				if(!$sale){
					setHint('业务员不存在，不能添加','bad');
					$this->res->red('user/addAgent');
				}

				$arr['role_id'] = (int)$role['role_id'];
				$arr['sale_id'] = (int)$sale['user_id'];
				$arr['branch_id'] = (int)$sale['branch_id'];
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
				$this->res->red('user/addAgent');
			}else{
				return $this->load->view('user_add_agent');
			}
		}
		function addSubagent(){
			$post = $this->req->post;
			if(count($post)){
				$name = $post['name'];
				$phone = $post['phone'];
				$pass = $post['pass'];
				$agent_id = (int)$post['agent_id'];
				$tag = $post['tag'];

				$arr = array(
					'name' => $name,
					'phone'=> $phone,
					'can_cashout' => 1,
					'subagent_id'=>0,
					'date' => timenow(),
					'pass' => md5($pass)
				);
				
				if(empty($agent_id)){
					setHint('代理ID必须是数字');
					$this->res->red('user/addSubagent');
				}
				if(strlen($name) < 1){
					setHint('名称太短');
					$this->res->red('user/addSubagent');
				}
				if(!validate('phone',$phone)){
					setHint('电话不符合要求');
					$this->res->red('user/addSubagent');
				}
				if(!validate('pass',$pass)){
					setHint('密码不符合要求');
					$this->res->red('user/addSubagent');
				}
				$hasUser = $this->load->model('user')->findByPhone($phone);
				if($hasUser){
					setHint('电话已经存在,请重新输入','bad');
					$this->res->red('user/addSubagent');
				}
				$role = $this->load->model('role')->findByTag($tag);
				$agent = $this->load->model('user')->findByRole($agent_id,'agent');
				if(!$role){
					setHint('tag不存在，不能添加','bad');
					$this->res->red('user/addSubagent');
				}
				if(!$agent){
					setHint('代理不存在，不能添加','bad');
					$this->res->red('user/addSubagent');
				}

				$arr['role_id'] = (int)$role['role_id'];
				$arr['branch_id'] = (int)$agent['branch_id'];
				$arr['sale_id'] = (int)$agent['sale_id'];
				$arr['p_id'] = (int)$agent['p_id'];
				$arr['agent_id'] = (int)$agent['user_id'];
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
				$this->res->red('user/addSubagent');
			}else{
				return $this->load->view('user_add_subagent');
			}
		}
		function delete(){
			$user_id = (int)$this->req->post['user_id'];
			$user = $this->load->model('user');
			$duser = $user->findById($user_id);
			if($duser){
				$img = QCODE.$duser['linkimg'];
				$logoimg = QCODE.$duser['logoimg'];
				if(is_file($img)){
					unlink($img);
				}
				if(is_file($logoimg)){
					unlink($logoimg);
				}
				$result = $user->delete($user_id);
				if($result){
					setHint('删除成功');
				}else{
					setHint('删除失败','bad');
				}
			}else{
				setHint('您要删除的用户不存在','bad');
			}
			$this->res->red('user');
		}
		function update($args){
			$post = $this->req->post;
			$user = $this->load->model('user');
			if(count($post)){
				$user_id = (int)$post['user_id'];
				$name = $post['name'];
				$phone = $post['phone'];
				$can_cashout = (int)$post['can_cashout'];
				$paybank = $post['paybank'];
				$paycount = $post['paycount'];

				$arr = array(
					'user_id'=> $user_id,
					'name'   => $name,
					'can_cashout' => $can_cashout,
					'phone'  => $phone,
					'paybank'=> $paybank,
					'paycount'=> $paycount
				);

				$result = $user->update($arr);
				if($result){
					setHint('更新用户成功');
				}else{
					setHint('更新用户失败','bad');
				}
				
				$this->res->red('user/update/'.$user_id);				
				
			}else{
				$user_id = (int)$args[0];
				$u = $user->findById($user_id);
				return $this->load->view('user_update',$u);
			}
		}
		function pass_update($args){
			$post = $this->req->post;
			if(!count($post)){
				$user_id = (int)$args[0];
				$user = $this->load->model('user')->findById($user_id);
				return $this->load->view('pass_update',$user);
			}else{
				$pass = $post['pass'];
				$pass2 = $post['pass2'];
				$user_id = (int)$post['user_id'];
				if(strlen($pass) > 5 && strlen($pass2) > 5 && strcmp($pass,$pass2) == 0){
					$result = $this->load->model('user')->updatePass($user_id,md5($pass));
					if($result){
						setHint('密码修改成功');
					}else{
						setHint('密码修改失败','bad');
					}
				}else{
					setHint('密码不符合要求，修改失败','bad');
				}
				$this->res->red('user/pass_update/'.$user_id);
			}
		}
	}
?>
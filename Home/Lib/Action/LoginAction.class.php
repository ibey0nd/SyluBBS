<?php 

	/**
	* 
	*/
	class LoginAction extends Action
	{
		
		public function doLogin()
		{

			if ($_SESSION['username']) {
				$_SESSION['username']="";
				$this->success("注销成功！",U('Index/index'));
				session_destroy();
				return;
				
			}
			$user = M('user');
			$username=$this->_post('username');
			$password =$this->_post('password');
			$where['username'] = $username;
			$where['password'] = $password;
			$count=$user->field('id')->where($where)->find();
			if($count){

				$_SESSION['username'] = $username;
				$_SESSION['id']  = $count['id'];
				$this->assign('usermark',$username);
				$this->success("登陆成功！",U('Index/index'));

				
			}else{
				$this->error("登陆失败，请检查用户名或密码！",U('Index/index'));
			}
		}
	}











 ?>
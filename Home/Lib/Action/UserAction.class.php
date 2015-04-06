<?php 

	/**
	* 
	*/
	class UserAction extends Action
	{
		
		public function index()
		{
			$uid = $this->_get("uid");
			$topic = M('topic');
			$clubName= M("club");
    			$User= M("user");
			$data = $topic->where("uid=".$uid)->select();
			//帖子数量
			$count = count($data);
			$this->assign("topicCount",$count);
			//用户名
			$username = $User->where("id=".$uid)->getField("username");
			$this->assign("currUsername",$username);
			//用户经验值
			$exp = $User->where("id=".$uid)->getField("exp");
			$this->assign("currexp",$exp);
			//用户当前等级。。不完善TODO
			switch ($exp) {
				case $exp>500:
					$level = "论坛元老";
					break;
				case $exp>400:
					$level = "金牌会员";
					break;
				case $exp>300:
					$level = "高级会员";
					break;
				case $exp>200:
					$level = "中级会员";
					break;
				case $exp>50:
					$level = "初级会员";
					break;
				default:
					$level = "新手上路";
					break;
			}
			$this->assign("level",$level);

			//用户说明
			$message = $User->where("id=".$uid)->getField("message");
			$this->assign("currMessage",$message);

			foreach ($data as $key => $value) {
	   		// 把板块的id号转换成对应的名称
		   		$c= $value['cid'];
		   		$cname=$clubName->select("$c");
		   		$data[$key]["clubname"] = $cname[0]['name'];

		   		// 把用户的id号转换成对应的用户名
		   		$u= $value['uid'];
		   		$cname=$User->select("$u");
		   		$data[$key]["uid"] = $cname[0]['username'];

   			}

   			$this->assign("data",$data);
			$this->display('index');
		}



		public function Reg()
		{
			$this->display('Reg');
		}
		
		/**
		*	注册处理函数
		*/
		public function doReg()
		{
			$user = M('user');
			$username = $this->_post('user');
			$password = $this->_post('pwd');
			$password1 = $this->_post('pwd1');
			if($password!=$password1){
				$this->error("注册失败   !  请检查输入...",U('Index/index'));
				return;
			}

			//数据库中是否有这个用户名，有的话禁止注册
			$where['username'] = $username;
			$count = $user->where($where)->count();
			if ($count!="0") {
				$this->error("亲，都告诉你用户名存在了哦~~~换个呗",U('Index/index'));
				return;
			}


			
			$data['username'] = $username;
			$data['password'] = $password;

			$user->data($data)->add();
			$this->success("注册成功   !  请返回登陆...",U('Index/index'));

		}

		/**
		*	个人属性页面
		*/
		public function profile()
		{	
			if($this->_get('id') == "")
			{
				$this->display('profile');
			}
			if ($this->_get('id')==1) {
				$this->display('profile');
			}elseif ($this->_get('id')==2) {
				// $this->display('edit');
				$this->edit();
			}
			
		}
		/**
		*	修改密码
		*/
		public function changePwd()
		{
			$user = M('user');
			
			$oldpass = $this->_post('oldPwd');
			$newpass  = $this->_post('newPwd');
			$uid = $_SESSION['id'];
			$userpassword = $user->where("id=".$uid)->getField('password');
			if ($userpassword != $oldpass) {
				$this->error("原密码错误，请重试....",U('User/profile?id=1'));
				return;
			}else{
				$data['password'] = $newpass;
				$user->where("id=".$uid)->data($data)->save();
				$this->success("修改密码成功！",U('User/profile'));
			}


		}

		/**
		*	请求跳转并赋初值
		*/
		public function edit()
		{
			$user = M('user');
			$id = $_SESSION['id'];
			$muser = $user->where("id=".$id)->select();
			$this->assign("muser",$muser[0]);
			// var_dump($muser);
			$this->display('edit');
			

		}

		/**
		*	更新用户信息
		*/
		public function doEdit()
		{
			
			$data['id'] = $_SESSION['id'];
			$data['realname']=$this->_post('realname');
			$data['mobile']=$this->_post('mobile');
			$data['email']=$this->_post('email');
			$data['message']=$this->_post('message');
			

			$user = M('user');
			$user->where("id=".$_SESSION['id'])->data($data)->save();
			$this->success("更新成功",U('User/edit'));

		}


		public function userIsExist()
		{
			$user = M("user");
			$where['username'] = $this->_post("name");;
			$count = $user->where($where)->count();
			echo $count;
			// if ($count=='1') {
			// 	echo   "用户名已经存在，请换一个....";
			// }else{
			// 	echo "恭喜您，这个用户名可以注册.";
			// }
		}







	}

















 ?>
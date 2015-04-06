<?php

class LoginAction extends Action{

	public function login(){
		$this->display();
	}





//登录处理
    public function do_login(){

    	$username= $this->_post("username");
    	$password= $this->_post("password");

    	$Admin = M('admin');
        $where['username']=$username;
        $where['password']=$password;
        $arr=$Admin->field('id')->where($where)->find();

        if($arr){
            $_SESSION['adminname']=$username;
            //与前台避免
           // $_SESSION['id']=$arr['id'];
            $this->success('欢迎登录沈阳理工微社区后台管理系统！',U('Index/index'));
        }else{
            $this->error('该管理员不存在！');
        }

    }


//注销处理
    public function do_logout(){

    	
		session_destroy();
		$this->redirect('Login/login');
    }



}

?>
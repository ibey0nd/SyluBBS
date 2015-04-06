<?php

class UserAction extends ExtendAction{
	public function index(){

		$User = M('user');


		import('ORG.Util.Page');// 导入分页类
		$count      = $User->count();// 查询满足要求的总记录数
		$Page       = new Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
		$Page->setConfig('header','个用户');
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $User->order('id')->limit($Page->firstRow.','.$Page->listRows)->select();

		foreach ($list as $key => $value) {
			if($value['status']=="1"){
				$list[$key]['status'] = "正常";
			}else{
				$list[$key]['status']  = "禁言";
			}
		}
		// var_dump($list);

		$this->assign('data',$list);// 赋值数据集
		$this->assign('pageshow',$show);// 赋值分页输出

		$this->display('index');
	}


//编辑用户
	public function editUser(){

		$User = M('user');

		$uid = $this->_get("uid");

		$userlist=$User->where("id=".$uid)->find();
		$this->assign("ulist",$userlist);

		$this->display('edit');

	}

//保存用户
	public function saveUser(){

		$User = M('user');

		$uid = $this->_post('id');
		$data['username'] = $this->_post('username');
		$data['realname'] = $this->_post('realname');
		$data['age'] = $this->_post('age');
		$data['mobile'] = $this->_post('mobile');
		$data['email'] = $this->_post('email');
		$data['status'] = $this->_post('status');

		$result = $User->where("id=".$uid)->save($data);
		if($result>=0){
			$this->success("修改成功！",'index');
		}else{
			$this->error("修改失败！",'index');
		}

	}

//删除用户
	public function deleteUser(){
		$uid = $this->_get("uid");
		$User = M('user');
		$result = $User->where("id=".$uid)->delete();
		if($result>=0){
			$this->success("删除成功！");
		}else{
			$this->error("删除失败！");
		}
	}



	
}

?>
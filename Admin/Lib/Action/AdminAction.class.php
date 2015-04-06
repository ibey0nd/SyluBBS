<?php
class AdminAction extends ExtendAction{

	public function index(){

		$Admin = M('admin');

		$adminList = $Admin->select();
		$this->assign('data',$adminList);

		$this->display();
	}

//删除管理员
	public function deleteAdmin(){
		$id =$this_>_get('id');
		$Admin = M('admin');
		$result = $Admin->where("id=".$id)->delete();
		if($result>=0){
			$this->success('删除成功！');
		}else{
			$this->error('删除失败！');
		}
	}

//添加新管理员
	public function addAdmin(){
		$Admin = M('admin');
		$data['username'] = $this->_post('username');
		$data['password'] = $this->_post('password');

		$result = $Admin->add($data);
		if($result>=0){
			$this->success('添加成功！','index');
		}else{
			$this->error('添加失败！', 'index');
		}
	}

//修改管理员
	public function editAdmin(){
		$Admin = M('admin');

		$id = $this->_get('id');
		$adminList = $Admin->where("id=".$id)->find();
		$this->assign('list',$adminList);
		$this->display('edit');
	}


//保存修改后的管理员
	public function saveAdmin(){
		$Admin = M('admin');

		$id = $this->_post('id');
		$data['username'] = $this->_post('username');
		$data['password'] = $this->_post('password');

		$result = $Admin->where("id=".$id)->save($data);
		if($result>=0){
			$this->success('修改成功！','index');
		}else{
			$this_>error('修改失败！','index');
		}
	}
}

?>
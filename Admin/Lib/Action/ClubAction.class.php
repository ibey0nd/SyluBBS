<?php

class ClubAction extends ExtendAction{

	public function index(){

		$Club = M('club');
		$clubList = $Club->select();
		$this->assign('data',$clubList);

		$this->display();
	}


//编辑板块
	public function editClub(){
		$cid = $this->_get('cid');
		$Club = M('club');
		$clubList = $Club->where("cid=".$cid)->find();
		$this->assign('clubList',$clubList);
		$this->display('edit');
		
	}


//删除板块
	public function deleteClub(){
		$cid = $this->_get('cid');

		$Club = M('club');
		$result = $Club->where("cid=".$cid)->delete();
		if($result>=0){
			$this->success('删除成功！');
		}else{
			$this->error('删除失败！');
		}
	}

//编辑保存板块
	public function saveClub(){
		$Club = M('club');
		$cid = $this->_post('cid');
		$data['name'] = $this->_post('clubname');

		$result = $Club->where("cid=".$cid)->save($data);
		if($result>=0){
			$this->success('修改成功！','index');
		}else{
			$this->error('修改失败！');
		}
	}

//添加板块
	public function addClub(){
		
		$Club = M('club');
		$data['name'] = $this->_post('clubname');

		$result = $Club->add($data);
		if($result>0){
			$this->redirect('Club/index');
		}else{
			$this->error('添加失败！');
		}
	}
}

?>
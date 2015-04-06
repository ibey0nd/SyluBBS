<?php
	class LinkAction extends ExtendAction{

		public function index(){

			$Link = M('link');

			$linkList = $Link->select();
			$this->assign('data',$linkList);
			$this->display();
		}

//编辑链接
		public function editLink(){
			$id = $this->_get('id');

			$Link = M('link');

			$linkList = $Link->where("id=".$id)->find();
			var_dump($linkList);
			$this->assign('list',$linkList);
			$this->display('edit');

		}

//删除链接
		public function deleteLink(){

			$id = $this->_get('id');
			$Link = M('link');

			$result = $Link->where("id=".$id)->delete();
			if($result>=0){
				$this->redirect('Link/index');
			}else{
				$this->error('删除失败！');
			}


		}

//编辑保存
		public function saveLink(){

			$id = $this->_post('id');
			$Link = M('link');
			$data['name']=$this->_post('linkname');
			$data['url']=$this->_post('linkurl');
			$result = $Link->where("id=".$id)->save($data);
			if($result>=0){
				$this->success('修改成功！','index');
			}else{
				$this->error('修改失败！');
			}
		}


//添加新链接
		public function addLink(){
			$Link = M('link');
			$id = $this->_post('id');
			$data['name']=$this->_post('linkname');
			$data['url']=$this->_post('linkurl');

			$result = $Link->add($data);
			if($result>=0){
				$this->success('添加成功！','index');
			}else{
				$this->error('添加失败！','index');
			}
		}

	}
?>
<?php 

	/**
	* 
	*/
	class CommentsAction extends Action
	{
		
		public function add()
		{
			//var_dump($this->_post());
			//未登录
			if ($_SESSION['id'] =="" || is_null($_SESSION['id'])) {
				$this->error("您还没有登录，请先登陆",U('Index/index'));
				return;
			}

			$user = M('user');
			$status = $user->where("id=".$_SESSION['id'])->getField('status');
			if ($status=="0") {
				$this->error("您已处于禁言状态，请联系管理员.",U("Index/index"));
				return;
			}

			$comment = M('comments');
			$topic = M('topic');
			$data['uid'] = $_SESSION['id'];
			$data['tid']  =  $this->_post('tid');
			$data['content'] =$_POST['editorValue'];
			$data['time'] = time();
			//获取回复的楼层
			$count = $comment->where("tid=".$data['tid'])->count();
			//楼层加1
			$data['floor'] = $count+1;

			//在帖子表中更新，评论数加1

			$commentCount = $topic->where("tid=".$data['tid'])->getField('comment');
			$data1['comment'] = (int)$commentCount + 1;
			$topic->where("tid=".$data['tid'])->data($data1)->save();
			//添加评论
			$comment->data($data)->add();

			//添加经验值，回一个帖子增加5
			
			$uid = $_SESSION['id'];
			$user->where("id=".$uid)->setInc('exp',5);

			$this->success("回帖成功，经验值+5！   正在返回...",U('Post/index?tid='.$data['tid']));
			

		}
	}











 ?>
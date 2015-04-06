<?php 

	/**
	* 
	*/
	class PostAction extends Action
	{
		
		public function index()
		{
			$Topic = M('topic');
			$User = M('user');
			$Club = M('club');
			$comment = M('comments');
			$tid = $this->_get("tid");
			if($tid=="" || is_null($tid)){
				$tid =1;
			}

			

			//把用户id转成用户名
			$data = $Topic->where("tid=".$tid)->find();

			$uid = $data['uid'];
			$uarray = $User->where("id=".$uid)->find();
			//保留uid字段，方便前台超链接获取，同时输出用户名
			$data['uidname'] = $uarray['username'];

			 //把模块id转成板块名
			 $cid = $data['cid'];
			 $data1 = $Club->where("cid=".$cid)->find();
			 $cid = $data['cid'];
			 $carray = $Club->where("cid=".$cid)->find();
			 $data['cid'] = $carray['name'];

			
			 $this->assign('topicdata',$data);

			 //获取所有版块信息列表
			      $clubList = $Club->select();

			    //  var_dump($clubList);
			      $this->assign('clubList',$clubList);


			//读取出所有的评论内容并输出
		             $commentList = $comment->where("tid=".$tid)->select();
			foreach ($commentList as $key => $value) {

		   		// 把用户的id号转换成对应的用户名
		   		$u= $value['uid'];
		   		$cname=$User->select("$u");
		   		$commentList[$key]["uid"] = $cname[0]['username'];

		   	}

			$this->assign('commentList',$commentList);


			 $this->display('index');

		}

		public function newTopic()
		{
			//获取所有版块信息列表
			$Club = M('club');
			 $clubList = $Club->select();
			 $this->assign('clubList',$clubList);
			



			$this->display('new');
		}


		public function newPost()
		{
			$topic = M('topic');

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
			$data['uid'] = $_SESSION['id'];
			$data['cid'] = $this->_post('cid');
			$data['posttime'] = time();
			$data['content'] = $this->_post('editorValue',false);
			$data['title'] = $this->_post('title');
			$data['comment'] = 0;

			
			$topic->data($data)->add();

			//添加经验值，发一个帖子增加10
			$user = M('user');
			$uid = $_SESSION['id'];
			$user->where("id=".$uid)->setInc('exp',10);



			$this->success("发帖成功，经验值+10！",U('Index/index'));

		}





	}














 ?>
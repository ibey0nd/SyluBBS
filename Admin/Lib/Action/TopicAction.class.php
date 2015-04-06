<?php
// 本类由系统自动生成，仅供测试用途
class TopicAction extends ExtendAction {
    public function index(){

    	$Topic = M("topic");
    	$Club = M("club");
    	$User = M("user");


      import('ORG.Util.Page');// 导入分页类
      $count      = $Topic->count();// 查询满足要求的总记录数
      $Page       = new Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
      $Page->setConfig('header','个帖子');
      $show       = $Page->show();// 分页显示输出
      // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
      $topicList = $Topic->order('tid desc')->limit($Page->firstRow.','.$Page->listRows)->select();


    	foreach ($topicList as $key => $value) {
	   		// 把板块的id号转换成对应的名称
	   		$c= $value['cid'];
	   		$cname=$Club->select("$c");

	   		$topicList[$key]["clubname"] = $cname[0]['name'];

	   		// 把用户的id号转换成对应的用户名
	   		$u= $value['uid'];
	   		$uname=$User->select("$u");
	   		$topicList[$key]["uname"] = $uname[0]['username'];

   		}
   	
   		$this->assign('data',$topicList);
      $this->assign('pageshow',$show);// 赋值分页输出

     	$clubList = $Club->select();

     	$this->assign('clubList',$clubList);

      $this->display('index');
    }

//查询帖子
    public function queryTopic(){

    $cid = $this->_post('cid');
    
    $Topic = M("topic");
      $Club = M("club");
      $User = M("user");


     import('ORG.Util.Page');// 导入分页类
      $count      = $Topic->where("cid=".$cid)->count();// 查询满足要求的总记录数
      $Page       = new Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
      $Page->setConfig('header','个帖子');
      $show       = $Page->show();// 分页显示输出
      // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
      
      if($cid =="" || is_null($cid) || $cid == "0"){
        $topicList = $Topic->order('tid desc')->limit($Page->firstRow.','.$Page->listRows)->select();
      }else{
        $topicList = $Topic->where("cid=".$cid)->order('tid desc')->limit($Page->firstRow.','.$Page->listRows)->select();
      }

    
    foreach ($topicList as $key => $value) {
      $cid = $value["cid"];
      $cname = $Club->where("cid=".$cid)->select();
      $topicList[$key]["clubname"] = $cname[0]['name'];
      
      $u= $value['uid'];
        $uname=$User->select("$u");
        $topicList[$key]["uname"] = $uname[0]['username'];
    }
    


    $this->assign('data',$topicList);
    $this->assign('pageshow',$show);// 赋值分页输出

    $clubList = $Club->select();

      $this->assign('clubList',$clubList);

    $this->display('index');
  }

//删除帖子
  public function deleteTopic(){
    
      $Topic = M("topic");
      $Club = M("club");
      $User = M("user");

    $tid = $this->_get("tid");
    $result =$Topic->where("tid=".$tid)->delete();
    if($result>=0){
      $this->success('删除成功！');
     }else{
      $this->error('删除失败！');
     }
      
   
  }


//评论查询
  public function commentTopic(){

    $tid = $this->_get("tid");

    $User = M("user");
    $Topic =  M("topic");
    $Comments = M("comments");

    $commentList = $Comments->where("tid=".$tid)->select();

    foreach ($commentList as $key => $value) {
      $uid = $value['uid'];
      $uname = $User->where("id=".$uid)->select();
      $commentList[$key]['username'] = $uname[0]['username'];
    }

    $topicList = $Topic->where("tid=".$tid)->find();
    $this ->assign('topicList',$topicList);
    $this->assign("data",$commentList);

    $this->display('comment');

  }

//删除评论
  public function deleteComment(){
    $id = $this->_get('id');
    $Comments = M('comments');
    $result = $Comments->where("id=".$id)->delete();
    if($result>=0){
      $this->success('删除成功！');
    }else{
      $this->error('删除失败！');
    }

  }

}

?>
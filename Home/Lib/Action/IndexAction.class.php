<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){

    	// 获取帖子列表
    	$topic = M("topic");
    	$clubName= M("club");
    	$User= M("user");
   	$cid =  $this->_get("cid");

      //获取总共的数量，用来分页
       import('ORG.Util.Page');// 导入分页类
       $count = 1;

   	if ($cid=='' || is_null($cid)) {
            // 增加分页功能，暂时去掉原来直接获取全部内容代码 2014年11月25日20:56:47
   		//$topicList = $topic->order('tid desc')->select();
             $count =  $topic->count();
   	}else{
   		//$topicList = $topic->where("cid=".$cid)->order('tid desc')->select();
             $count =  $topic->where("cid=".$cid)->count();
   	}
      // 每页显示数量
      $Page = new Page($count,8);
      $show = $Page->show();
      if ($cid=='' || is_null($cid)) {
            $topicList1=$topic->limit($Page->firstRow.','.$Page->listRows)->order('tid desc')->select();
      }else{
            $topicList1=$topic->where("cid=".$cid)->limit($Page->firstRow.','.$Page->listRows)->order('tid desc')->select();
      }
           
      
     $this->assign('show',$show);// 赋值分页输出


   	foreach ($topicList1 as $key => $value) {
   		// 把板块的id号转换成对应的名称
   		$c= $value['cid'];
   		$cname=$clubName->select("$c");
   		$topicList1[$key]["clubname"] = $cname[0]['name'];

   		// 把用户的id号转换成对应的用户名
   		$u= $value['uid'];
   		$cname=$User->select("$u");
            //为主题列表数组增加一列，显示用户名，同时保留uid字段
   		$topicList1[$key]["uidname"] = $cname[0]['username'];

   	}
   	// var_dump($topicList);
   	$this->assign('data',$topicList1);

      //显示当前板块的标题
      if (is_null($cid)) {
          $currClubName = "全部帖子";
      }else{
         $currClubName   =  $topicList1[0]['clubname'];
      }
      $this->assign('currClubName',$currClubName);



      //获取所有版块信息列表
      $clubList = $clubName->select();

    //  var_dump($clubList);
      $this->assign('clubList',$clubList);



      //获取友情链接
      $link = M('link');
      $linkList = $link->select();
      $this->assign('linkList',$linkList);
      
	$this->display("index");
    }


    


}
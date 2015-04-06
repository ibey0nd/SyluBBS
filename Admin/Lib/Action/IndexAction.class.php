<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends ExtendAction {
    public function index(){

        $User = M('user');
        $Topic = M('topic');
        $Admin = M('admin');


        $ucount = $User->count();
        $tcount = $Topic->count();
        $acount = $Admin->count();

        $this->assign('ucount',$ucount);
        $this->assign('tcount',$tcount);
        $this->assign('acount',$acount);

        $this->display('index');
    }



}

?>
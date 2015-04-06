
<?php

	
	/**
	*	TP控制器扩展，后台所有控制器继承该类来检查权限
	*/
	class ExtendAction extends Action{
		Public function _initialize(){
			// 初始化的时候检查用户权限，如果尚未登录则跳转。防止未授权访问
			if(!isset($_SESSION['adminname'])&& $_SESSION['adminname']==''){
				$this->error('尚未登录！',U('Login/login'));
			}
		}
	}
?>
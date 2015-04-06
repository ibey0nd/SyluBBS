<?php 

	/**
	* 
	*/
	class DemoAction extends Action
	{
		
		public function index()
		{

			$user = M('user');
			$list = $user->select();
			var_dump($list);
		}
	}











 ?>
<?php
class InitAction extends Action {
	
	
	function __construct(){
		
	 	 Vendor('Init.Loader');
		
		 parent::__construct();
	}
	
    // 生成验证码
    public function verify(){
	   Inits::verify();
    }
	
	// 生成验证码
	static public function phpmailer(){
	   Inits::phpmailer("guoshaoyi@qq.com");
    }






}

?>
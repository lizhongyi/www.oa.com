<?php
class InitAction extends Action {
	
	
	function __construct(){
		
	 	 Vendor('Init.Loader');
		
		 parent::__construct();
	}
	
    // ������֤��
    public function verify(){
	   Inits::verify();
    }
	
	// ������֤��
	static public function phpmailer(){
	   Inits::phpmailer("guoshaoyi@qq.com");
    }






}

?>
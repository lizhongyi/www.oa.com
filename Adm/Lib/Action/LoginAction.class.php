<?php
class LoginAction extends Action {
	
	
	function __construct(){
		
	 	 Vendor('Init.Loader');
		
		 parent::__construct();
	}
	
    public function index(){
		
		     $this->display();
    }



}

?>
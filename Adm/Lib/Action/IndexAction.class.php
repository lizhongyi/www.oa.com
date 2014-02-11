<?php
class IndexAction extends Action {
	
	
	function __construct(){
		
	 	 Vendor('Init.Loader');
		
		 parent::__construct();
	}
	
    public function index(){
       
	   $this->display();
    }
	

	 public function manage(){
       
	   $this->display();
    }

	 public function init(){
       
	   $this->display();
    }

	 public function top(){
       
	   $this->display();
    }


	 public function main(){
       
	     // 验证登录
		 if (Inits::CheckLogin()){
			  $this->error('登录失败！','__APP__/Index/Login');
		}
	  
	    $this->display();
    }


	 public function left(){
       
	   $this->display();
    }



}

?>
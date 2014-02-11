<?php
/**
 * Created by ADdobe DW cs6.
 * User: Administrator
 * Date: 13-5-15
 * Time: PM 14:52
 * To change this template use File | Settings | File Templates.
 * className:GlAction
 * dever:yige
 * ProjectName:jobmedia OA.
 */
 
 class GlAction extends Action{
	 
	          function _initialize(){
				    
				      Load('extend');  
				      include('./includes/Page.class.php');
				     }
	 
	 
	         //index
			 
			    function index(){
				 
				     $this->display();
				     
				 }
	 
	 
	 
	 
	 
	   public function checkLogin(){
		   
		         if(Session::get('hash') == ""){
					  
					  $this->error("登陆超时",'/Login');
					   
					 }
			   
		    }
	 
	 
	 }
 
 
?>
<?php
/**
 * Created by DW cs6.
 * User: Administrator
 * Date: 13-7-16
 * Time: 上午11:03
 * To change this template use File | Settings | File    Templates.
 * className:About
 * dever:yige
 * ProjectName:jobme.cn.
 */
 
 class AboutAction extends GlAction{
	 
	               
				   public function index(){
					   
					  $this->display();
					   
					   }
					   
				      public function feedback(){
					     
						 
					     $this->display();
					  
					  }	   
				    
					
					public function about(){
						
						   $this->display();
						
						}
					
	               
				    public function contact(){
						
						   $this->display();
						   
						}
						
						
						public function do_feed(){
							  
							     $data=$_POST;
							     $data['uid']=$this->uid;
								 $data['type']=$this->utype;
								 $data['create_time']=time();
								 
								 $rs=M('Feedback')->add($data);
								 if($rs){
									  
									   parent::_message('success','提交成功，我们一定会认真阅读你的建议！');
									 
									 } else{
										  parent::_message('error','出错了，稍后再试试');
										 
										 }
								  
								  
							
							}
						 
				    
	 }
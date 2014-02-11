<?php
/**

候选人操作类

**/

class VipAction extends GlAction{
	
	     //initialize
	     public function _initialize(){
			    
				parent::_initialize();
				parent::Checklogin();
				
			 
			 }
			 
			 
			 public function index(){
				 
				     if($this->level==1){
                         $this->display('viped');
					 }else{
						 
						 $this->display();
						 }
				 
				 
				 }
				 
				 
				 
		
		
		   		 public function do_vip(){
				       
					   
					   
					   
                
                          
                       
					   $t=$_GET['t'];
                       $t1=substr(sha1(date('ymdhis',time()).'nihao'),4,11);
                       $t2=substr(sha1(date('ymdhis',time()) - 1 .'nihao'),4,11); 
					    $t3=substr(sha1(date('ymdhis',time()) - 2 .'nihao'),4,11); 
					 
					  if($t1!=$t && $t2!=$t && $t3=$t) parent::_message('error','验证失败');
                         
						

					  
					   $jin=$_GET['qian'];
					   
					    //exit($jin);
					   
					   if($jin==1){
						   
						    $vtpye=1;
						   
						   }else if($jin=='500'){
							   
							  $vtpye=2;
							   
						  }else{
							    
								parent::_message('error','验证失败');
							  
							  }
							   
							   
							   
						//假设充值成功
						
						
						$d['uid']=$this->uid;
						$d['vtpye']=$vtpye;
						$d['start_time']=date('Ymd',time());
						$d['end_time']=date('Y')+1 . date('md',time());
						
						$rs=D('vip')->add($d);
						
						if($rs){
							
							   $dt['level']=$vtpye;
							   $ap=D('User')->where('uid='.$this->uid)->save($dt);
							   
							   if($ap){
								       
								   }
								   
								 
								    Session::set('level',$vtpye);
									Cookie::set('level',$vtpye,60*60*60);
								   
								 parent::_message('success','升级成功');  
								 
							   
							   }else{
								  
								 parent::_message('error','升级失败');
								 
								
								 
								}	   
							   
							   
				      
				 
				  }
			 
			 
}
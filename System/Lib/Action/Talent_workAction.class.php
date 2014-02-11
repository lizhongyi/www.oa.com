<?php
class Talent_workAction extends GlAction {
	
	       
		    public function _initialize(){
				
				            parent::_initialize();
 				}
	
	             
			    public function index(){
					 
				              	 
					 
					 }
				 
				    
			    public function edu(){
					    
						$this->display();
					
					}
					
					
				public function  do_add(){
					
					    $data=$_POST;
						if($data['title']==""){
							  
							  parent::_message('error','非法操作');
							}
						 //$add_uid=M('Talent')->where('id='.$data['resume_id'].' and add_uid='.$this->uid)->count();
						// if($add_uid==0){
						//	    parent::_message('error','非法操作');  
							// }
						 	
						  $data['create_time']=time();
						  $data['start_time']=strtotime($data['start_time']."-01");
						   if($data['end_time']!='0'){
						  $data['end_time']=strtotime($data['end_time']."-01");
						   }
						  $data['add_uid']=$this->uid;
						
						     
							 $rs=$this->dao->add($data);
						     if($rs){
								     
									 parent::_message('success','添加成功');
								    
								 }else{
									 
									 parent::_message('error','添加失败');
									 }   
						
				
				}   
				
				public function edit(){
					      
						  parent::checkID();
						  
						    
						  if($this->pid!=0){
						       $dt=$this->dao->where("id=".$this->id.' and add_uid='.$this->uid)->find();
						  }else{
							   $dt=$this->dao->where("id=".$this->id)->find();
							  }
						  $this->assign('dt',$dt);
						  $this->display();
					    
					}
				
				
				
				
				
				
				public function  do_edit(){
					
					    $data=$_POST;
						if($data['title']==""){
							  
							  parent::_message('error','非法操作');
							}
						 //$add_uid=M('Talent')->where('id='.$data['resume_id'].' and add_uid='.$this->uid)->count();
						// if($add_uid==0){
						//	    parent::_message('error','非法操作');  
							// }
						 	
						 
						 $data['start_time']=strtotime($data['start_time']."-01");
						 if($data['end_time']!='0'){
						  $data['end_time']=strtotime($data['end_time']."-01");
						 }
						  //$data['add_uid']=$this->uid;
						
						     
							 if($this->pid!=0){
							   $rs=$this->dao->where('add_uid='.$this->uid.' and id='.$data['id'])->save($data);
							 }else{
								 $rs=$this->dao->where('id='.$data['id'])->save($data);
								 }
						     if($rs){
								     
									 parent::_message('success','编辑成功');
								    
								 }else{
									 
									 parent::_message('error',$data['end_time']);
									 }   
						
				
				}   
				
				
				
				
				
				
				
				
				
				
				
				public function delete(){
					       
						   parent::checkID();
					     
						   $rs=$this->dao->where('id='.$this->id.' and add_uid='.$this->uid)->delete();
					       
						   if($rs){
							      parent::_message('success','删除成功');
							   }else{
								  parent::_message('error','删除失败'); 
								   
								   }
					}
	
	
	
	
	}

?>
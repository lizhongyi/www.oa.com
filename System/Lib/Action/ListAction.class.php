<?php
class ListAction extends GlAction {
	
	       
		    public function _initialize(){
				
				            parent::_initialize();
						    parent::Checklogin();
 				}
	
	             
				 
				 
				 
				 
			    public function index(){
					 
					             $condition['comid']=array('eq',$this->comid);
				                 $pageCount = $this->dao->where($condition)->count();
					            $listRows = empty($listRows) ? 10 : $listRows;
						 	    $orderd = empty($orders) ? 'id DESC' : $orders;
							    $paged = new page($pageCount, $listRows);
								$glist=$this->dao->Where($condition)
							                        ->Order($orderd)
							                        ->Limit($paged->firstRow.','.$paged->listRows)
													->select();  
													
												
													
													                          
							$pageContentBar = $paged->show();
						
							$this->assign('pageBar', $pageContentBar);
								
								
								 $this->assign('getList',$glist);
								 
								 
								  $cm=M('Commission')->limit(8)->select();
							   
							     $this->assign('cm',$cm);
								 
								 
								 
								 $this->display();    	 
					 
					 }
				 
				    
		
					
					
				public function  do_import(){
					
					                 
							 $data=$_POST;
						     include('./includes/files.class.php');   
							  if(!$_FILES){
								  parent::_message('error','没有上传文件');
								  }
							  
						     $run=new files();
							 
							$is= $run->upload('files',$_FILES['docs']);							 
                           	
							if($is['db_path']){
								 //开始上传操作
								
										$ty=$is['type'];
								        $fl=$is['file_url'];				
											
											
											
											
											   if (file_exists($fl)){
														 		
														  
													
															  
															   //插入数据库
															   $data['comid']=$this->comid;
															   $data['department']=$this->department;
															   $data['create_time']=time();
															   $data['url']=$fl;
															   $data['uid']=$this->uid;
															   $rs=D('List')->add($data);
															   if($rs){
															    parent::_message('success','上传成功');
															  }else{
																   
																  // exit(D('List')->getLastSql());
																   parent::_message('error','上传失败');
																  
																  }
														  
														  
														  
														
														  
											   }
  


							     	
								
								} 					  
												  
			                 
				
				}   
				
				
				
				
				   
				         public function do_modfy(){
					 
					                       parent::checkID();
										  
										   $data=$_POST;
						     include('./includes/files.class.php');   
							 
							  
							  
							  
							  
							  if($_FILES['docs']){
							  
						     $run=new files();
							 
							$is= $run->upload('files',$_FILES['docs']);							 
                           	
						             	if($is['db_path']){
								                  //开始上传操作
												  $ty=$is['type'];
												  $fl=$is['file_url'];
												  if (file_exists($fl)){
												      $data['url']=$fl;
													}
                                                             
							} 	
							  }                               $data['update_time']=time();
							  
							  
							  
							  
							                                   if($this->uid == $this->comid){
                                                               $rs=D('List')->where('id='.$this->id. ' and comid='.$this->comid)->save($data);                                                               }else{
																   
																   $rs=D('List')->where('id='.$this->id. ' and uid='.$this->uid)->save($data);
																   }
								               					if($rs){
															    parent::_message('success','更新成功');
															      }else{
																//  exit(D('Talent_import')->getLastSql());	  
																   parent::_message('error','更新失败');
																  }
							     	
								
								                  					  
												  
			                 
					 
					 
					 
					 }
				 
				
				
				
				
				
				
				
				
				
				
				  public function detail(){
						   
						   
						       parent::CheckID();
							   
							   $dt=$this->dao->where('id='.$this->id)->find();
							   
							   $this->assign('dt',$dt);
							   $this->display();
						   
						   }
					   
				
				
					 
				 public function modfy(){
					 
					       
						      parent::checkID();
							  
							  if($this->uid ==$this->comid){
							  
							  $dt=M('List')->where('id='.$this->id." and comid=".$this->uid)->find(); 
							  
							  }else{
								  
							   $dt=M('List')->where('id='.$this->id." and uid=".$this->uid)->find();   
								  
								  }
							  
							  
							    
							  $this->assign('dt',$dt);  
					          $this->display();	       
					 
					 
					 }
	
			
				
				public function delete(){
					       
						   parent::checkID();
					                  
									 if($this->uid == $this->comid){ 
									      $rs=$this->dao->where('id='.$this->id.' and comid='.$this->comid)->delete();
									 }else{
									 $rs=$this->dao->where('id='.$this->id.' and uid='.$this->uid)->delete();	 
									}
						   if($rs){ 
						          //删除文件
							      parent::_message('success','删除成功');
							   }else{
								  parent::_message('error','删除失败'); 
								   
								   }
					}
	           
			   public function share(){
				   
				   
				              
				                $pageCount = $this->dao->where($condition)->count();
					            $listRows = empty($listRows) ? 10 : $listRows;
						 	    $orderd = empty($orders) ? 'id DESC' : $orders;
							    $paged = new page($pageCount, $listRows);
								$glist=$this->dao->Where($condition)
							                        ->Order($orderd)
							                        ->Limit($paged->firstRow.','.$paged->listRows)
													->select();  
													
												
													
													                          
							     $pageContentBar = $paged->show();
						         $this->assign('pageBar', $pageContentBar);
								 $this->assign('getList',$glist);
								 $this->display();    	 
				   
				   
				   }
	
	
	
	}

?>
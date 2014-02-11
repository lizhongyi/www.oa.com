<?php
class Talent_importAction extends GlAction {
	
	       
		    public function _initialize(){
				
				            parent::_initialize();
						    parent::Checklogin();
 				}
	
	             
				 
				 
				 
				 
			    public function index(){
					 
					            $listRows = empty($listRows) ? 10 : $listRows;
						 	    $orderd = empty($orders) ? 'id DESC' : $orders;
							    $paged = new page($pageCount, $listRows);
								$area_cn =$_GET['area_cn'];
								$area_cn && $condition['area_cn']=array('like','%'.$area_cn.'%');
								
								$last_company=$_GET['last_company'];
								$last_company && $condition['last_company']=array('like','%'.$last_company.'%');         
							    $post = $_GET['post'];
								$post && $condition['post']=array('eq',$post);
								
								$keyword=$_GET['keyword'];
								$keyword && $condition['keyword']=array('like','%'.$keyword.'%');
								
								$condition['comid']=array('eq',$this->comid);
						
								
					            $dt = $this->dao
							                        ->Where($condition)
							                        ->Order($orderd)
							                        ->Limit($paged->firstRow.','.$paged->listRows)
													->select();  
													
												
													
													                          
							$pageContentBar = $paged->show();
							$this->assign('getList', $dt);
							$this->assign('pageBar', $pageContentBar);
                    
						  
		                   parent::_tpl('index_small');
					 
					 
					 
					 
					            
					 
				                  	 
					 
					 }
				 
				 
				
			
				    
		
					
					
				public function  do_import(){
					
					                 
							 $data=$_POST;
						       
							/*  if(!$_FILES){
								  parent::_message('error','没有上传文件');
								  }
							  
						     $run=new files();
							 
							$is= $run->upload('files',$_FILES['docs']);							 
                           	
							if($is['db_path']){
								 //开始上传操作
								 $ty=$is['type'];
								 $fl=$is['file_url'];
								
								              
											  
											   if (file_exists($fl)){*/
														 		
														  
													if($_POST['title']=='' || $_POST['phone'] ==''  || $_POST['last_company']==""){
														 parent::_message('error','请填写完整');
														
														
														}
															  
															   //插入数据库
															   $data['comid']=$this->comid;
															   $data['department']=$this->department;
															   $data['create_time']=time();
															  // $data['url']=$fl;
															   $data['uid']=$this->uid;
															   $rs=D('Talent_import')->add($data);
															   if($rs){
															    parent::_message('success','上传成功');
															  }else{
																  
																   parent::_message('error','上传失败');
																  
																  }
														  
														  
														  
														
														  
										/*	   }


							     	
								
								} 					  
												 */ 
			                 
				
				}   
				
				
				
				
				
				  public function detail(){
						   
						   
						       parent::CheckID();
							   
							   $dt=$this->dao->where('id='.$this->id)->find();
							   
							   $this->assign('dt',$dt);
							   $this->display();
						   
						   }
					   
				
				
				
			
				
				public function delete(){
					       
						   parent::checkID();
					     
						   if($this->uid == $this->comid){
						   $rs=$this->dao->where('id='.$this->id .' and comid='.$this->comid)->delete();
						   }else{
							   
							     $rs=$this->dao->where('id='.$this->id)->delete(); 
								 
							   }
						     if($rs){
							      parent::_message('success','删除成功');
							   }else{
								  parent::_message('error','删除失败'); 
								}
					}
	
	             
				 
				 
				         public function do_modfy(){
					 
					                       parent::checkID();
										  
										   $data=$_POST;
						    /* include('./includes/files.class.php');   
							 
							  
							  
							  
							  
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
							  }
													  
													  
													  */
													  	 
															 
															 
															 $data['update_time']=time();
															 if($this->uid!=$this->comid){
                                                             $rs=D('Talent_import')->where('id='.$this->id. ' and uid='.$this->uid)->save($data);
															 }else{
																  $rs=D('Talent_import')->where('id='.$this->id. ' and comid='.$this->uid)->save($data);
																 }
								               					if($rs){
															    parent::_message('success','更新成功');
															      }else{
																  //exit(D('Talent_import')->getLastSql());	  
																   parent::_message('error','更新失败');
																  }
							     	
								
								                  					  
												  
			                 
					 
					 
					 
					 }
				 
				 
				 
				 
				 
				 public function modfy(){
					 
					       
						      parent::checkID();
							  if($this->uid!=$this->comid){
							  $dt=M('Talent_import')->where('id='.$this->id." and uid=".$this->uid)->find();
							  }else{
								  $dt=M('Talent_import')->where('id='.$this->id." and comid=".$this->comid)->find();  
								  
								  }
							  $this->assign('dt',$dt);  
					          $this->display();	       
					 
					 
					 }
	
	
	}

?>
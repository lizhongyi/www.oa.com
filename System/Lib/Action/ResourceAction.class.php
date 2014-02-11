<?php

class ResourceAction extends GlAction{
	
	   
	   public function _initialize(){
		   
		      parent::_initialize();
		   
		   }
	
	    
		public function index(){
			
			     
				 $this->checkLevel('该服务需要升级VIP会员');
				 
				
				                $area_cn =$_GET['area_cn'];
								$area_cn && $condition['area_cn']=array('like','%'.$area_cn.'%');
								
								$last_company=$_GET['last_company'];
								$last_company && $condition['last_company']=array('like','%'.$last_company.'%');         
							    $post = $_GET['post'];
								$post && $condition['post']=array('eq',$post);
								
								$keyword=$_GET['keyword'];
								$keyword && $condition['realname']=array('like','%'.$keyword.'%');
				  
				                $condition['type']=array('eq',3);
				                $pageCount = M('Resume')->where($condition)->count();
			                	$listRows = empty($listRows) ? 10 : $listRows;
						 	    $orderd = empty($orders) ? 'uid DESC' : $orders;
							    $paged = new page($pageCount, $listRows);
								
								
							    
						
								
					            $dt = M('Resume')
							                        ->Where($condition)
													//->field('uid,username,realname,type,level,last_company,update_time,education,area_cn')
							                        ->Order($orderd)
							                        ->Limit($paged->firstRow.','.$paged->listRows)
													->select();  
													
													
													foreach($dt as $k=>$v){
															  	
												       $dt[$k]['down']=M('Resume_down')->where('Resume_id='.$v['uid'].' and comid='.$this->comid)->count();
														
													
														}
													
											//print_r($dt);
													
											                          
							$pageContentBar = $paged->show();
							$this->assign('getList', $dt);
							$this->assign('pageBar', $pageContentBar);
				             
							$this->display(); 
				 
			   
			
			
			}
	
	
	
	
	
	
	
	
	
	
	
	
	   public function checkLevel($msg){
		   
		      
			  if($this->level!=1){
				  
                    $this->assign('msg',$msg);
					$this->display('tips');
					
					exit();
					
				  
				  }
		   
		   
		   }
		   
		   
		   
		   
		   
		   
			   public function detail(){
				   
				               
				 $this->checkLevel('该服务需要升级VIP会员');
                            $this->id=$_GET['id'];
							$pr=M('User')->where('uid='.$this->id)->find();
						    $dt=M('Resume')->where('uid='.$this->id)->find();  
							
							
							
							
							
									 $dt=M('User')->where('uid='.$this->id)->find();
									 $dt['edu']=M('Resume_edu')->where('resume_id='.$dt['uid'])->select();
									 $dt['work']=M('Resume_work')->where('resume_id='.$dt['uid'])->select();
									
									 $ex=$this->dao->where("uid=".$this->id)->find(); 
									 $this->assign('ex',$ex);
								     $this->assign('dt',$dt);
								
							$this->assign('pr',$pr);            
						    $this->assign('dt',$dt);
						   
						    $this->display();
						   				  
				   
				   } 
				   
				   
				   
				   public function resume_down(){
					             
				 $this->checkLevel('该服务需要升级VIP会员');
					       
						      parent::checkID($this->id);
							  
							  
							  //检测下载过没有
							  
							  $ed=M('Resume_down')->where('resume_id='.$this->id.' and comid='.$this->comid)->count();
							  if($ed!=0){
								   
								   parent::_message('error','已下载过');
								   
								  }
							  
							  
							  $data['create_time']=time();
							  $data['duid']=$this->uid;
							  $data['resume_id']=$this->id;
							  $data['comid']=$this->comid;
							  $rs=D('Resume_down')->add($data);
							  
							      if($rs){
								     
									 parent::_message('success','下载成功');
									  
								  }else{
									  
									   parent::_message('error','下载失败');
									   
									  }
					   
					   
					   }
					   
					   
					  
	
	
	
	}


?>
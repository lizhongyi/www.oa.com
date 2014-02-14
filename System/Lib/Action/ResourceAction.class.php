<?php

class ResourceAction extends GlAction{
	
	   
	   public function _initialize(){
		   
		      parent::_initialize();
		   
		   }
	
	    
		public function index(){
			
			     
				 $this->checkLevel('该服务需要升级VIP会员');
				 
				
				               
								
								$last_company=$_GET['last_company'];
								$last_company && $condition['a.last_company']=array('like','%'.$last_company.'%');         
							    
								$keyword=$_GET['keyword'];
								$keyword && $condition['a.realname']=array('like','%'.$keyword.'%');
				                $condition['b.skills']=array('neq','');
							
				                $condition['a.type']=array('eq',3);
								
				                $pageCount = M('Resume')->where($condition)->count();
			                	$listRows = empty($listRows) ? 10 : $listRows;
						 	    $orderd = empty($orders) ? 'uid DESC' : $orders;
							    $paged = new page($pageCount, $listRows);
								
								
							    
						
								
					            $this->getJoinList($condition, 'a.uid DESC', 12, C('DB_PREFIX').'user a', C('DB_PREFIX').'resume b on a.uid=b.uid','a.*,b.*');
													
												
										
										
										
										
										
										
										
										
										
										
										
										
							
			   
			
			
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
					   
					   
					   
					   
					   
					   
					   
					   
					   
					   
					     public function getJoinList($conditions = '', $orders = '' , $listRows = '', $table = '', $join = '', $fields = '')
    {   
        $condition = !empty($conditions) ? $conditions : '' ;
        $pageCount = $this->dao->Where($condition)->Table($table)->Join($join)->Field($fields)->count();
        $listRows = empty($listRows) ? 10 : $listRows;
        $orderd = empty($orders) ? 'id DESC' : $orders;
        $paged = new page($pageCount, $listRows);
        $dataContentList = $this->dao->Table($table)->join($join)->field($fields)->Where($condition)->Order($orderd)->Limit($paged->firstRow.','.$paged->listRows)->select();
					   
					   
				
					  $pageContentBar = $paged->show();
					  $this->assign('getList', $dataContentList);
					  $this->assign('pageBar', $pageContentBar);
					  $this->display();
					 
					 }  
					   
					   
					   
					   
					   
					  
	
	
	
	}


?>
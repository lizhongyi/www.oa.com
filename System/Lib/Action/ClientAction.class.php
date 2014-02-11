<?php

class ClientAction extends GlAction {
	
	
	             function _initialize(){ 
				 
                        parent::_initialize();
				
				         parent::Checklogin();
						  
				        $this->assign('page_hover','client');
						
				 }
	
		  
		  
		       //客户列表
            
			  public function index(){
				              
							   $this->indexList(1);
							   
							   
							  
							   
							   
				  }		  
				  
				  
				  
				  //回收站  
				  
				  public function recycle(){
					  
					       $this->indexList(0);
					  
					  }
		         
				  
				  
				public function hr_list(){
					   
					    $cid=$_GET['cid'];
						$hr_list=$this->get_hr_list($cid);
						$this->assign('hr_list',$hr_list);
						parent::_tpl('plus/hr_list');
					
					}  
		  
		  
		       //客户详细
			   
			   public function detail(){
				         parent::_checkPermission();
						parent::checkID();
					     
						$detail=$this->dao->find($this->id);
						
						foreach($detail as $k=>$v){
							
							    $detail['hr_contacts']=M("hr_contacts")->where("company_id=".$detail['id'])->find();
							
							}
						//HR联系人列表
						
						
						$condition['company_id']=array('eq',$id);
						$pageCount =M("hr_contacts")->count();  
						
						$listRows = empty($listRows) ? 15 : $listRows;  
						$paged = new page($pageCount, $listRows);
						$hr_list = $this->get_hr_list($this->id); 
						
						
						
						
	  
        $pageCount = M('Works')->where("cid=".$this->id)->count();
		
        $listRows = empty($listRows) ? 15 : $listRows;
        $orderd = empty($orders) ? 'id DESC' : $orders;
        $paged = new page($pageCount, $listRows);
        $dataContentList = M('Works')->Where("cid=".$this->id)->Order($orderd)->Limit($paged->firstRow.','.$paged->listRows)->select();
		
		
		
		
		
		foreach($dataContentList as $k=>$v){
			  
			   //候选人数量
			   $dataContentList[$k]['hnums']=M("Candidate")->where('gid='.$v['id'])->count();
			   $dataContentList[$k]['stage']=parent::__get_c_stage($v['id']);
			   
			
			}
		
		
		//print_r($dataContentList);
		
		$pageContentBar = $paged->show();
        $this->assign('getList', $dataContentList);
        $this->assign('pageBar', $pageContentBar);
						
						
					//	print_r($hr_list);
						
						
						
						
						
						
						
						
						$pageContentBar = $paged->show();
						$this->assign("hr_list",$hr_list); 
						$this->assign("detail",$detail);
	                    $this->assign('pageBar', $pageContentBar);
						//print_r($detail);
						parent::_tpl('plus/detail');
						
						
						
				   
				    }
		  
		  
		    /*   public function delete(){
				           parent::_checkPermission();
				         $act=$this->_get('act');
						  
						  if($act=='hr_del'){
							  
							  $delid=intval($_GET['did']);
						     if($delid!=0){
							   
							        $re=M("hr_contacts")->where("id=".$delid)->delete();
									
							        if($re){
								      
									  parent::_message("success",'删除成功',$_SERVER['HTTP_REFERER']);
		                            }else{
										
                                     parent::_message("error",'删除失败',$_SERVER['HTTP_REFERER']);
										
									}
   							 }
							  
							  }
						   
						  
				   
				   }*/
		       
		   
		  
		  
		   //设置分类
		   
		  
				
		   //添加hr联系人
		   
		    public function Hr_contact_add(){
				   
				   
				    $this->display();
				
				}
				
			//保存HR联系人	
			
			public function doHr_contact(){
				    
					
					$data=rfilter($_POST);
					
					
					if($data['hname']=="" || $data['tel']==""){
						 
						 parent::_message("error",'用户名电话必须填写');
						
						}
						
						
					$data['create_time']=time();
				    $rs=D("hr_contacts")->add($data);
					if($rs){
						 
						 
						 if($data['ajax']!=1){
						  parent::_message("success","添加成功");
						 }
						 else{
							 exit("ok");
							 }
						} 
					exit;
				 
				 
				  }	
				  
				  
				  //修改HR联系人 
				  public function hr_modfy(){
					   
					    $id=intval($_GET['id']);
						if($id!=0){
							$hr_modfy=M("hr_contacts")->where('id='.$id)->find();
								//print_r($hr_modfy);
								$this->assign('hr_modfy',$hr_modfy);
					            $this->display();
							
							}else{
								 
								 exit();
								 
								}
						
					  
					  }
					  
					  
					  
					  
					  //保存修改联系人	
			
			public function doHr_modfy_contact(){
				    
					
					$data=$_POST;
					
					
					if($data['hname']=="" || $data['tel']==""){
						 
						 parent::_message("error",'用户名电话必须填写');
						
						}
						
					
					
				    $rs=M("hr_contacts")->where('id='.$data['id'])->save($data);
					if($rs){
						  if($data['ajax']!=1){
						  parent::_message("success","修改成功");
						 }
						 else{
							 exit("ok");
							 }
						} 
					exit($rs);
				 
				 
				  }	
				
			
			public function get_hr_list($id){
				
				      $hr=M("hr_contacts")->where("company_id=".$id)->select();
					  return $hr;
				
				}	
         
		 
		 
		 
		    //get remote file in local
			
			public function setlocal(){
				             $json_url=C('API_URL')."json_cache.php?act=client&p=0&ps=100&nums=x$parm";
							 //exit($json_url);
                             $list  = json_decode(file_get_contents($json_url));
		                     
			                 foreach($list as $k=>$v){
				   
				              $list[$k]=(array)$list[$k];
							  
				              }
				           
						   
						    foreach($list as $k=>$v){
				   
				                   //start  write clients data
								   
								   $data="";
								   $data['companyname']=$v['companyname'];
								   $data['short_name'] =$v['companyname'];
								   $data['ompany_name']=$v['companyname_cname'];
								   $data['trade']      =$v['trade'];
								   $data['nature']     =$v['nature'];
								   $data['scale']      =$v['scale'];
								   $data['content']   =urldecode($v['contents']);
								   $data['create_time']=$v['pubdate'];
								   $data['id']         =$v['id'];
								   $data['uid']=       $v['uid'];
								   
								   if($this->get_upid($v['uid']) != 0){
								   $data['comid']     =$this->get_upid($v['uid']);
								   }else{
									    $data['comid']     =$v['uid'];
									   }
								   $data['display'] = 1;
								   $rs=$this->dao->add($data);
								   
								   if(!$rs){
									   echo $this->dao->getLastSql();
									    exit('nnnonoo');
									   }
								   							  
				              }
				           
						 
				
				
				}
				
				
				
				
				
				public function get_upid($uid){
					         
					         $json_url=C('API_URL')."json_cache.php?act=user_info&uid=".$uid;
							 //exit($json_url);
                             $list  = json_decode(file_get_contents($json_url));
							return intval($list->pid);
					
					}
				
				
				public function add(){
					   
					   parent::_tpl('plus/add');
					
					}
				
				// save insert client
				
				public function do_add(){
					
					
					    $dao=$this->dao->create();
						if($dao){
							    $this->dao->create_time=time();  
							  	$this->dao->comid=$this->comid;
								$this->dao->uid=$this->uid;
								$rs=$this->dao->add();
								 
								 if($rs){
									parent::_message('success',"添加成功");
									 }else{
									  parent::_message('error',"保存失败");
								    }
								
							  }else{ 
								    exit($this->dao->getError());
								}
					
					}
					
					//client  modfy
					public  function modfy(){
						
						         parent::_checkPermission();
							   if(!$this->id){
								parent::_message('error',"关键条件丢失");
								}
								
								$detail=$this->dao->find($this->id);
								$this->assign('page_title','客户数据修改');
						        $this->assign('dt',$detail);
								$this->display();
						} 
			
			       // client do modfy  
				   
				   public function do_modfy(){
					        
					       
						    $dao=$this->dao->create();
							
							
							
							if($dao){
							      
								$this->dao->update_time=time();
							  	$this->dao->comid=$this->comid;
								$this->dao->uid=$this->uid;
								$rs=$this->dao->save();
								 
								 if($rs){
									parent::_message('success',"保存成功");
									 }else{
										 
									
									  parent::_message('error',"保存失败");
								    }
								
							  }else{ 
								    exit($this->dao->getError());
								}
					   
					   }
					   
					   //delete  
					   
					   public function delete(){
						        
								 parent::_checkPermission();
						       
							    if(!$this->id){
								  parent::_message('error',"关键条件丢失");
								}
								  
								  parent::__deletes($this->dao,$this->id);  
						        
						   }
				
				
				public function indexList($dis){
					
					       
						      $condition['display']=$dis; 
                              $keyword    =      $_GET['keyword'];
							  $area=         $_GET['area'];
							  $area_cn    =  $_GET['area_cn'];
							  $industry   =  $_GET['industry'];
							  $start_time =  $_GET['start_time'];
							  $end_time   =   $_GET['end_time'];
							  $condition['comid']=$this->comid;
							  $keyword && $condition['keyword']=array('like','%'.$keyword.'%');
							  $area && $condition['area']=array('eq',$area);
							  $industry && $condition['trade']=array('eq',$industry);
							  
							  $start_time && $condition['create_time']=array('gt',strtotime($start_time));
							  
							 // $condition['_logic'] ="AND";
							  
							  $end_time &&   $condition['create_time']=array('lt',strtotime($end_time));
							
							  $pageCount = $this->dao->where($condition)->count();
							  $listRows = empty($listRows) ? 10 : $listRows;
							  $orderd = empty($orders) ? 'id DESC' : $orders;
							  $paged = new page($pageCount, $listRows);
                              $paged = new page($pageCount, $listRows);
		                    
							
		                    $list = $this->dao
							                        ->Where($condition)
							                        ->Order($orderd)
							                        ->Limit($paged->firstRow.','.$paged->listRows)
													->select();
													
													
							// echo $this->dao->getLastSql();					  
			                 foreach($list as $k=>$v){
				   
				              $list[$k]=(array)$list[$k];
				              }
							
							 
							 foreach($list as $k=>$v){
								     $works=M("Works");
									 $gids='';
									 $zdz=0;
									 $gdids="";
									 $collection=M("collection");
                                     $list[$k]['hr_cname']=getHrName($list[$k]['id'],'hname');
									 $list[$k]['gongdan_num']=$works->where('cid='.$v['id'])->count();
									 
									  //先读取所有工作单
									  $all_gd_id=$works->field('id')->where('cid='.$v['id'])->select();
									  
									  foreach($all_gd_id as $a=>$b){
										       
											   $gdids[]=$b['id'];
										     
										  }
									 $gids=implode(',',$gdids);
									 //查出所有等于这个工作单的到账
									   
									 
									 $list[$k]['cnum']=M("Candidate")->where("cid=".$v['id']." and stage > 6")->count();
									 $fkz=M("Candidate")->where("cid=".$v['id']." and stage=8")->select();
									 $dzz= $collection->field('gid,dz_jine')->where("gid in ($gids)")->select();
									 
									
									 foreach($dzz as $a=>$b){
										      $zdz+=$b['dz_jine'];
										 }
									 
									 $zfk=0;
									 
									 foreach($fkz as $a=>$b){
										   
										   $zfk+=$b['yfk_jine'];
										   
										 }
									 $list[$k]['zongfk']=$zfk;
									 $list[$k]['zongdz']=$zdz;
                              }
							// print_r($list);
                             $pageContentBar = $paged->show();
						
                             $this->assign('getList', $list);
                             $this->assign('pageBar', $pageContentBar);
                             $this->display();
					
					
					}
					
					//extrnal 
					
					
				public 	function indexs(){
					
					          $condition['comid']=$this->comid;
							  $condition['display']=1;
							  $pageCount = $this->dao->where($condition)->count();
							  $listRows = empty($listRows) ? 18 : $listRows;
							  $orderd = empty($orders) ? 'id DESC' : $orders;
							  $paged = new page($pageCount, $listRows);
							   $list = $this->dao->Field('id,uid,short_name,companyname,company_name')
							                        ->Where($condition)
							                        ->Order($orderd)
							                        ->Limit($paged->firstRow.','.$paged->listRows)
													->select();  
													
						      $pageContentBar = $paged->show_ajax();				
					         $this->assign('getList', $list);
                             $this->assign('pageBar', $pageContentBar);
							 
						
                             parent::_tpl('plus/selector');
							
					  
					  }
					
					
					
					
					//恢复回收站数据到列表
				 
				 public function  recover(){
					      parent::_checkPermission();
						  parent::__recover($this->dao,$this->id);
					 
				}
				
				 public function  hard_delete(){
					      parent::_checkPermission();
						  parent::__hard_delete($this->dao,$this->id);
					 
					 }
				
}
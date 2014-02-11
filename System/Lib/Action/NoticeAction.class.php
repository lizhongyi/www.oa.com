<?php
/**
 * Created by Adobe DW cs6.
 * User: Administrator
 * Date: 13-4-26
 * Time: AM 11:38
 * To change this template use File | Settings | File Templates.
 * className:Notice
 * dever:yige
 * ProjectName:jobmedia OA.
 */
 
 class NoticeAction extends GlAction{
	    
		                
				    public function _initialize(){
				 
				    parent::_initialize();
					parent::Checklogin();
				    
				 }	  
				 
				 
				 //index show notice list
				 
				 public function index(){
					    
					    $this->show_list();
						parent::_tpl('ajax/index');					
													
					 }
					 
					 
					 
					 
					 
					 
					 
					 public function show_list(){
						     
							 
							 
							 
							   
							 $condition['comid']=$this->comid;
						
						$pageCount = $this->dao->where($condition)->count();
						
						
						if($this->ajax==1){
					    $listRows = empty($listRows) ? 6 : $listRows;
						}else{
							$listRows = empty($listRows) ? 4 : $listRows;
							}
						
						
					    $orderd = empty($orders) ? 'id DESC' : $orders;
					    $paged = new page($pageCount, $listRows);
				        $notlist= 	    $this->dao
							                        ->Where($condition)
							                        ->Order($orderd)
							                        ->Limit($paged->firstRow.','.$paged->listRows)
						
						 					        ->select();  
											
						 							
					    $pageBar=$paged->show();
						
						$this->assign('notList', $notlist);
					    $this->assign('pbr', $pageBar);		
						 
						 
						 }
					 
					 
					 
					 
					 
					 
				  // add notice
				  
				  public function add(){
					    
						parent::_tpl('ajax/add');
					  
					  }
				  
				  public function do_add(){
					  
					    $data=$_POST;
						$dao=$this->dao->create();
						if($dao){
							 
							 $data['create_time']=time();
							 $data['uid']=$this->uid;
							 $data['comid']=$this->comid;
							 $rs=$this->dao->add($data); 
							    
								if($rs){
								    
									parent::_message('success','添加成功');
										
								 }else{
								    
									parent::_message('error','添加失败');
									 	 
								 }
							
							}else{
								 
								 $this->dao->getError();
								
								}
					  
					  
					  }
					  
					 //modify
					 
					 public function modfy(){
						     
							  parent::checkID();
							  
							  $detail=M('Notice')->where('id='.$this->id)->find();
							   
							  $this->assign('vo',$detail); 
							 
						     parent::_tpl('ajax/modfy');
						    
						 } 
						 
						 
					 //modify
					 
					 public function do_modfy(){
						     
							  parent::checkID();
							  
							 $data=$_POST;
						$dao=$this->dao->create();
						if($dao){
							 
							 //$data['create_time']=time();
							 $data['comid']=$this->comid;
							 $data['id']=$this->id;
							 $rs=$this->dao->save($data); 
							    
								if($rs){
								    
									parent::_message('success','编辑成功');
										
								 }else{
								    
									parent::_message('error','添加失败');
									 	 
								 }
							
							}else{
								 
								 $this->dao->getError();
								
								}
					  
					  
						    
						 } 	 
		       
			   
			    // delete
				
				public function delete(){
					
					        parent::checkID();
							
							$rs=$this->dao->where('id='.$this->id)->delete();
							if($rs){
								
									parent::_message('success','删除成功');
										
								 }else{
								    
									parent::_message('error','删除失败');
									 	 
								 }
								
								
						   
					
					}
					
				public	function detail(){
						
						  parent::checkID();
						  $vo=$this->dao->find($this->id);
						  $this->assign('vo',$vo);
						  parent::_tpl('ajax/detail');
						
						}
		
	 
	 }

?>
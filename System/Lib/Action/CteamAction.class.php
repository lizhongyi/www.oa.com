<?php
/**

候选人操作类

**/

class TeamAction extends GlAction{
	
	     //initialize
	     public function _initialize(){
			    
				parent::_initialize();
				$this->dao=D("Team");
			 
			 }
	    
		
		 //index action
		 
		 public function index(){
			 
			 
			 
			 
                            $ajax=intval($this->_get('ajax'));
				            
							$gid=intval($_GET['gid']);
							
							$where="1=1 and gid=$gid";	
							
							$condition = !empty($conditions) ? $conditions : '' ;
                            $pageCount = $this->dao->where($where)->count();
		
                            $listRows = empty($listRows) ? 10 : $listRows;
                            $orderd = empty($orders) ? 'id DESC' : $orders;
                            $paged = new page($pageCount, $listRows);
                            $dataContentList = $this->dao->Where($where)->Order($orderd)->Limit($paged->firstRow.','.$paged->listRows)->select();                  
							
							 $ajax==0 ? $pageContentBar = $paged->show() : $pageContentBar = $paged->show_ajax();
							 
                            $this->assign('getList', $dataContentList);
                            $this->assign('pageBar', $pageContentBar);
		                    $ajax==0 ? $this->display() : $this->display('plus/index');
			 
			          
			  
			  }
			  
			  
			  //add action
			  
			  public  function add(){
						
						     $ajax=intval($_GET['ajax']);
						     
						      $ajax==0 ? $this->display() : $this->display('plus/add');
							
						
						}
				
				
				
				
				
	        //doAdd
			
			
			public  function do_Add(){
						
						        $ajax=intval($_GET['ajax']);
						        $data=$_POST;
							    $data['start_time']  = date(strtotime($data['start_time']));
                                $data['end_time']    = date(strtotime($data['end_time']));
								$data['create_time']= time();
								
								$chongfu=$this->dao->where('uid='.$data['uid'].' and gid ='.$data['gid'])->count();
								if($chongfu > 0) exit('err');
								 
								 if($data){
									  
									  $rs=$this->dao->add($data);
									       
										   
										    if($rs){
							    
							               $data['ajax']==1? exit('ok') : parent::_message('success','添加成功',$_SERVER['HTTP_REFERER']);
							   
							                }
						                
						                     }else{
							 
							                  $data['ajax']==1? exit('err') : parent::_message('error','添加失败',$_SERVER['HTTP_REFERER']);
							 
							            }
                                      
						
						}	
				 
				
				
				
				
				
				//modfy action
				
				  public  function modfy(){
						
						        $ajax=intval($_GET['ajax']);
						        $id=intval($_GET['id']);
                                $detail=$this->dao->where("id=".$id)->find();
							    $this->assign('vo',$detail); 
								  
						         $ajax==0 ? $this->display() : $this->display('plus/modfy');
							
						
						}
				 
				 //do_modfy
				 
				  
				 public  function do_modfy(){
						
						        $ajax=intval($_GET['ajax']);
						        $id=intval($_GET['id']);
								
								$data=$_POST;
								$data['id']=$id;
								
								$data['start_time']  = date(strtotime($data['start_time']));
                                $data['end_time']    = date(strtotime($data['end_time']));
								$data['update_time'] = time();
								
                                $rs=$this->dao->save($data);
								
							    if($rs){
							    
							               $data['ajax']==1? exit('ok') : parent::_message('success','添加成功',$_SERVER['HTTP_REFERER']);
		                                 }else{
							 
							               $data['ajax']==1? exit('err') : parent::_message('error','添加失败',$_SERVER['HTTP_REFERER']);
							 
							            }
								  
}
				
				
			// delete action
			
			
			 public function delete(){
				 
				    
					 $id=intval($_GET['id']);
				
					 if($id!=0){
						     $data['id']=$id;
							 
						     $rs=$this->dao->where("id=".$id)->delete();
							 
						  if($rs){
							    
							$data['ajax']==1? exit('ok') : parent::_message('success','删除成功',$_SERVER['HTTP_REFERER'].'#'.$_GET['maodian'],$ajax);
							   
							   }
						   
						  }else{
							 
							    $data['ajax']==1? exit('err') : parent::_message('error','删除失败',$_SERVER['HTTP_REFERER']);
							 
							 }
					 
				
				
				}
				
				
				
				//批量操作
				
				public function doCommand(){
		           
				   
				 
                  
                      if(getMethod() == 'get'){
                       $operate = trim($_GET['sid']);
                       }elseif(getMethod() == 'post'){
                       $operate = trim($_POST['sid']);
                       }else{
                       parent::_message('error', '只支持POST,GET数据');
                       }
                      
                      if($operate=='100'){
                                $ids= implode(',',$_POST['id']);
								 $rs=$this->dao->where("id in ($ids)")->delete();
								  if($rs){
									    if($_PSOT['ajax']!=1){
									      parent::_message('success', '删除成功',$_SERVER['HTTP_REFERER'].$_REQUEST['maodian'],$ajax=true);
										}else
										{
											echo "nihao";
										}
									}else{ 
									 
										 parent::_message('error', '删除失败');
									}
										
										
								
                        
							
							}else{
								
								 parent::_message('error', '操作类型错误');
								
								}
	       }
				
				
				
				
	
	
	
	}

?>
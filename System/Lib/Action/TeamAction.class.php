<?php
/**

候选人操作类

**/

class TeamAction extends GlAction{
	
	     //initialize
	     public function _initialize(){
			    
				parent::_initialize();
				parent::Checklogin();
				$this->dao=D("Team");
			 
			 }
	    
		
		 //index action
		 
		 public function index(){
			 
			 
			                
			 
                            $ajax=intval($this->_get('ajax'));
				            
							$gid=intval($_GET['gid']);
							
							$gid && $where="1=1 and gid=$gid";	
							
							$condition = !empty($conditions) ? $conditions : '' ;
                            $pageCount = $this->dao->where($where)->count();
		
                            $listRows = empty($listRows) ? 10 : $listRows;
                            $orderd = empty($orders) ? 'id DESC' : $orders;
                            $paged = new page($pageCount, $listRows);
                            $dt = $this->dao->Where($where)->Order($orderd)->Limit($paged->firstRow.','.$paged->listRows)->select();                  
							
							 $ajax==0 ? $pageContentBar = $paged->show() : $pageContentBar = $paged->show_ajax();                 
							 
							 
							 
							 
							 
							 
						     $persona=$this->persona;//角色列表
							
							 
							 //request Nteam persona
							 $personas="";
							 $puid="";
							 foreach($dt as $k=>$v){
								     
									 $personas.=$dt[$k]['persona'].",";
									 $puid.=$dt[$k]['uid'].",";
									  
									  //去掉已选角色
									    $perArray=explode(',',$dt[$k]['persona']);
									  
									  
									    foreach($persona as $k1=>$v1){
											
											
											if(in_array($k1,$perArray)){
											  $dt[$k]['per'].=$persona[$k1]['title'].",";
											 }
											 
											 
											}
											
											
									   		
									   
								 }
							 
							 
                            $this->assign('getList', $dt);
                            $this->assign('pageBar', $pageContentBar);
		                    $ajax==0 ? $this->display() : $this->display('plus/index');
			 
			          
			  
			  }
			  
			  
			  
			   public function nteam(){
			                
                            $ajax=intval($this->_get('ajax'));
				            
							$gid=intval($_GET['gid']);
							
							$gid && $where="1=1 and gid=$gid";	
						
							
							$condition = !empty($conditions) ? $conditions : '' ;
                            $pageCount = $this->dao->where($where)->count();
		
                            $listRows = empty($listRows) ? 10 : $listRows;
                            $orderd = empty($orders) ? 'id DESC' : $orders;
                            $paged = new page($pageCount, $listRows);
                            $dataContentList = $this->dao->Where($where)->Order($orderd)->Limit($paged->firstRow.','.$paged->listRows)->select();                  
							
							 $ajax==0 ? $pageContentBar = $paged->show() : $pageContentBar = $paged->show_ajax();
							 
                            $this->assign('getList', $dataContentList);
                            $this->assign('pageBar', $pageContentBar);
		                    $ajax==0 ? $this->display() : $this->display('plus/nteam');
			 
			          
			  
			  }
			  
			  
			  
			  //add action
			  
			  public  function add(){
						       
						        $ajax=intval($_GET['ajax']);
                                $gid=intval($_GET['gid']);
								//读取已经有的成员
								$cun=$this->dao->where('gid='.$gid)->select();
								foreach($cun as $k=>$v){
									  
									  $notid[]=$v['uid'];
									 
									}
								$nid=implode(',',$notid);
								
								if($nid){	
							    $parm="&pid=".$this->comid."&nid=".$nid;
								}else{
									$parm="&pid=".$this->comid;
									}
									
									
									
									
									
									
									
									
							$ps=10;
							
							$where='uid ='.$this->uid.' or pid='.$this->comid.' or uid='.$this->pid;
							//$where.=" and realname <> ''";
							$list=parent::get_json_list(M('User'),$where,$order='uid DESC',$listRows=16);
							$list=$list['list'];
							
							$pageBar=$list['pageBar'];
							$this->assign('getList',$list);
							$this->assign('pageBar',$pageBar); 
							 	
                                
									
								$dt = $this->dao->where('gid='.$gid)->order('id asc')->select(); //团队列表                                $uid=$this->comid;	
								$persona=$this->persona;//角色                               //request Nteam persona
								$personas="";
								$puid="";
								foreach($dt as $k=>$v){
								     $personas.=$dt[$k]['persona'].",";
									 $puid.=$dt[$k]['uid'].",";
									  
									  //去掉已选角色
									    $perArray=explode(',',$dt[$k]['persona']);
									        foreach($persona as $k1=>$v1){
									          if(in_array($k1,$perArray)){
											  $dt[$k]['per'].=$persona[$k1]['title']."，";
											 }
									 }
									   
								 }
								
							         $cunzai=explode(',',substr($personas,0,strlen($personas)-1));
							         $kexuan=0;
							  
							  
							  
							   foreach($persona as $k=>$v){
								   
								   
							        if(in_array($k,$cunzai1)){
										  
                                          //$checkbox.='<input type="checkbox" name="persona"  disabled value='.$k.' class="persona_cbox1"/>'.$persona[$k]['title']."　";
										 }else{
											 //$kexuan=$kexuan+1;
											  $checkbox.='<input type="checkbox" name="persona"  value='.$k.' class="persona_cbox1"/>'.$persona[$k]['title']."　";
											  
											  
											 }
								 }
							    
							     	//if(trim($checkbox) == ""){
									 
									   // $checkbox="<span class='red'>已经没有工作角色,如果要增加请点击左侧<a href='javascript:;' id='setp'>设置角色！</a><br/></span>";
									 
									//}
							 
							
							  $this->assign("msg",$msg);
							  $this->assign("checkbox",$checkbox); 
							 
								
								
								
								
								
								
						       // $this->display('plus/teamer');
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
								$gid = intval($_GET['gid']);
								$detail=$this->dao->find($id);
                                $dt = $this->dao->where('gid='.$detail['gid'])->order('id asc')->select(); //团队列表                 
						        $persona=$this->persona;//角色列表
								
								foreach($persona as $k=>$v){
									$persona[$k]['k']=$k;
									}
								
								
								
								$personas="";
							 $puid="";
							 foreach($dt as $k=>$v){
								     
									 $personas.=$dt[$k]['persona'].",";
									 $puid.=$dt[$k]['uid'].",";
									  
									  //去掉已选角色
									    $perArray=explode(',',$dt[$k]['persona']);
									  
									  
									    foreach($persona as $k1=>$v1){
											
											
											if(in_array($k1,$perArray)){
											  $dt[$k]['per'].=$persona[$k1]['title']."，";
											 }
											 
											 
											}
											
											
									   		
									   
								 }
								
								
								
								
								  //设置工作角色,如果有有角色，工作角色自动递减
							   $cunzai=explode(',',substr($personas,0,strlen($personas)-1));
								
								$check=explode(',',$detail['persona']);
								$checkbox="";
								
								
								foreach($persona as $k=>$v){
									
									
									
									
									if(in_array($k,$check)){
									  $checkbox.='<input type="checkbox" name="persona" checked value='.$k.' class="persona_cbox1"/>'.$persona[$k]['title']."　";                                         }else{
										  
										 if(in_array($k,$cunzai)){
                                        // $checkbox.='<input type="checkbox" name="persona" disabled value='.$k.' class="persona_cbox1"/>'.$persona[$k]['title']."　";
										 }else{
											  $checkbox.='<input type="checkbox" name="persona" value='.$k.' class="persona_cbox1"/>'.$persona[$k]['title']."　";
											 }
										                                          
																				  
																				   }
								
								}
								
								
			
								
								
							   
							    $this->assign('checkbox',$checkbox);
								$this->assign('check',$ck);
								$this->assign('persona_list', $persona); 
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
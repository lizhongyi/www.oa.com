<?php
/**

候选人操作类

**/

class NteamAction extends GlAction{
	
	     //initialize
	     public function _initialize(){
			    
				parent::_initialize();
				parent::Checklogin();
				
			 
			 }
	    
		
		 //index action
		 
		 public function index(){
			 
			 
			 
			                  
                             $ajax=intval($this->_get('ajax'));
				             $cid=intval($_GET['cid']);
							 
							 
							 
							 $gid=intval($_GET['gid']);
							 
							 $cidk=M('Candidate')->find($cid);
							 if($cidk['kelong_id']==0){
							 $where="1=1 and cid=$cid";	
							 }else{
								  $where="1=1 and cid=".$cidk['kelong_id'];	
								 }
							 $dt = $this->dao->where($where)->order('id asc')->select(); //团队列表                 
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
								
							
							 
							 //设置工作角色,如果有有角色，工作角色自动递减
							  $cunzai=explode(',',substr($personas,0,strlen($personas)-1));
							 
							
							 
							 foreach($persona as $k=>$v){
								     
									 if(in_array($k,$cunzai)){
										 unset($persona[$k]);
									  }
								 }
							 
							 
							 
							 //去掉已经加入团队成员
							 
							 $cunzai_uid=explode(',',substr($puid,0,strlen($puid)-1));
							 $puid=substr($puid,0,strlen($puid)-1);
							 $Team_list=M('Team')->where("uid not in($puid) and gid=".$gid)->select();
						      
							 // echo $cunzai_uid;
							 
							/*foreach($Team_list as $k=>$v){
								     
									 if(in_array($Team_list[$k]['uid'],$cunzai_uid)){
										 unset($Team_list[$k]);
									  }
								 }
							 */
							
							 
							$this->assign('Team_list',$Team_list);
							
							$this->assign('persona_list',$persona);
                            $this->assign('getList',$dt);
                        
		                    parent::_tpl('plus/index');
			 
			          
			  
			  }
			  
			  
			  //add action
			  
			  public  function add(){
						       
							    
							  $cid=intval($_GET['cid']);
							  $gid=intval($_GET['gid']); 
						      $where="1=1 and cid=$cid";	
							  
							  //先取得候选人分配情况
							  $fen=M("Candidate")->where('id='.$cid)->getField('fenpei');
							  
							  if($fen ==1){
								    
								    exit('<div class="nodata">该候选人已经分配佣金，不能再添加团队成员！</div>'); 
									
								   
								  }
								  
							  
							  $dt = $this->dao->where($where)->order('id asc')->select(); //团队列表                 
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
											  $dt[$k]['per'].=$persona[$k1]['title']."，";
											 }
											 
											 
											}
											
											
									   		
									   
								 }
								
							
							 
							 //设置工作角色,如果有有角色，工作角色自动递减
							  $cunzai=explode(',',substr($personas,0,strlen($personas)-1));
							 
						
							  $kexuan=0;
							  foreach($persona as $k=>$v){
								     
									  if(in_array($k,$cunzai)){
										  
                                          //$checkbox.='<input type="checkbox" name="persona"  disabled value='.$k.' class="persona_cbox1"/>'.$persona[$k]['title']."　";
										 }else{
											 $kexuan=$kexuan+1;
											  $checkbox.='<input type="checkbox" name="persona"  value='.$k.' class="persona_cbox1"/>'.$persona[$k]['title']."　";
											 }
								 }
							    
								if($kexuan==0){
									 
									$msg="已经没有工作角色,如果要增加请点击左侧设置角色！<br/>";
									 
									}
							 
							 
							 //去掉已经加入团队成员
							
							 $cunzai_uid=explode(',',substr($puid,0,strlen($puid)-1));
							 $puid=substr($puid,0,strlen($puid)-1); 
                             $Team_list=M('Team')->where("uid not in($puid) and gid=".$gid)->select();
							
						   
							 
							/*foreach($Team_list as $k=>$v){
								     
									 if(in_array($Team_list[$k]['uid'],$cunzai_uid)){
										 unset($Team_list[$k]);
									  }
								 }
							 */
							 if($Team_list[0]['id']==""){
								 
								  
								   $msg.="已经没有其他团队成员可选，请先在流程管理最右侧的内部团队中增加其他成员。";
								 }
							  $this->assign("msg",$msg);
							  $this->assign("checkbox",$checkbox); 
							  $this->assign('Team_list',$Team_list);
						      $this->assign('persona_list',$persona);
							  
						      parent::_tpl('plus/add');
							
						
						}
				
				
				
				
				
	        //doAdd
			
			
			public  function do_add(){
						
						       
						        $data=$_POST;
							    $data['create_time']=time();
								$data['comid']=$this->comid;
								
								$chongfu=$this->dao->where('uid='.$data['uid'].' and cid ='.$data['cid'])->count();
								if($chongfu > 0) {
									
									 parent::_message('error','不能重复添加',$_SERVER['HTTP_REFERER']);
									
									}
								
								
								 
								 if($data){
									  
									  $rs=$this->dao->add($data);
									       
										   
										    if($rs){
							    
							                parent::_message('success','添加成功',$_SERVER['HTTP_REFERER']);
							   
							                }
						                
						                     }else{
							 
							               parent::_message('error','添加失败',$_SERVER['HTTP_REFERER']);
							 
							            }
                                      
						
						}	
				 
				
				
				
				
				
				//modfy action
				
				  public  function modfy(){
						         
						        $ajax=intval($_GET['ajax']);
						        $id=intval($_GET['id']);
                                $detail=$this->dao->where("id=".$id)->find();
								$dt = $this->dao->where('cid='.$detail['cid'])->order('id asc')->select(); //团队列表                 
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
							    $this->assign('detail',$detail); 
								   
						         parent::_tpl('plus/modfy');
							
						
						}
				 
				 //do_modfy
				 
				  
				 public  function do_modfy(){
						
								$data=$_POST;
								$data['update_time']=time();
								$data['id']=$_GET['id'];
								//$doSave=$this->dao->create();
								
                                 $rs=$this->dao->save($data);
								
							      if($rs){
							    
							                parent::_message('success','保存成功',$_SERVER['HTTP_REFERER']);
		                                 }else{
							 
							              parent::_message('error',"保存失败",$_SERVER['HTTP_REFERER']);
							 
							            }
								  
}
				
				
			// delete action
			
			
			 public function delete(){
				 
				       
					 $id=intval($_GET['id']);
				
					 if($id!=0){
						     $data['id']=$id;
							 
						     $rs=$this->dao->where("id=".$id)->delete();
							 
						  if($rs){
							    
							parent::_message('success','删除成功');
							   
							   }
						   
						  }else{
							 
							  parent::_message('error','删除失败');
							 
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
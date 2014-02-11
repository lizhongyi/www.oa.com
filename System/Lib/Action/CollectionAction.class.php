<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-2-16
 * Time: 上午9:54
 * To change this template use File | Settings | File Templates.
 * className:Persona
 * dever:yige
 * ProjectName:jobmedia OA.
 */
 
 class CollectionAction extends GlAction{
	 
	        public function _initialize(){
				    
					parent::_initialize();
					parent::Checklogin();
					
				}
				
			public function index(){
				       parent::_checkPermission();
					      parent::teamer();
						  parent::bumen();
				
					 $gid=$_GET['gid'];  
					 $cid=$_GET['cid'];
					 
					 $client_id=$_GET['client_id'];
				     $keyword=$_GET['keyword'];
					
					 if($keyword){
					 $condition['realname']=array("like","%".$keyword."%");
					
					 }
				     $gid && $condition['gid'] = array('eq',$gid);
					 $client_id &&  $condition['client_id']=array('eq',$client_id);
					 
					 $c_status = $_GET['c_status'];
					 
					 if($c_status != ""){
					  $condition['c_status'] = array('eq',$c_status);
					 }
					
					  //搜索客户
					  
					  
					  
					  
					  //如果这不是公司账户的话可以查询自己的
					    
					  if($this->pid !=0 && $this->role_id > 2){ 
					 
					 
					  $cids=M("Nteam")->Field('cid,uid')->where('uid='.$this->uid)->select();
					  foreach($cids as $k=>$v){
						      
							  
						     $cids1[]=$v['cid'];
						  
						  
						  }
						  $cids3=implode(',',$cids1); 
						  $condition['cid']=array('in',$cids3);
						  
					  }else{
						   
						    $condition['comid']=$this->comid;
						  
						  }
					// $condition = !empty($where) ? $condition : '' ;
									$pageCount = $this->dao->where($condition)->count();
									$listRows = empty($listRows) ? 15 : $listRows;
									$orderd = empty($orders) ? 'id DESC' : $orders;
									$paged = new page($pageCount, $listRows);
									
									$zongshu=$this->dao->field('yfk_jine')->Where($condition)->select();
									//总付款金额
									$zongjine="";
									 foreach($zongshu as $k=>$v){
										 $zongjine+=$v['yfk_jine'];
										 }
									 
									 
									$getList = $this->dao->Where($condition)->Order($orderd)->Limit($paged->firstRow.','.$paged->listRows)->select();           
									       
					              foreach($getList as $k=>$v){
									      
										  //通过工作单ID找客户
										  $cid=M('Works')->where('id='.$v['gid'])->getField('cid');
										  $getList[$k]['client_name']=M('Client')->where('id='.$cid)->getField('short_name');
										  $getList[$k]['client_id']=$cid;
										  $getList[$k]['deparment']=$bm[$v['gid']];
									     
									  }
					   
					   
					            //  echo $this->dao->getLastSql();
					   
					 
					  $pageContentBar = $paged->show();
					//  print_r($bm);
					// $getList=$this->dao->where($condition)->order('id desc')->select();
					// echo $this->dao->getLastSql();
					 $this->assign("getList",$getList);
					 $this->assign("zongjine",$zongjine);
					 $this->assign('pageBar', $pageContentBar);
					 parent::_tpl('plus/index_list');
				}
				
	            public function index_list(){
			          parent::_checkPermission('Collection_index');
					 $gid=$_GET['gid'];
			         $gid && $condition['gid'] = array('eq',$gid);
					 //$condition['comid']=$this->comid;
					 $getList=$this->dao->where($condition)->order('id desc,create_time desc')->select();
					// echo $this->dao->getLastSql();
					 $this->assign("getList",$getList);
					 parent::_tpl('plus/index_list');
			   
			   }
			   
			   
			   /*---------------------------------
			    * 修改的地方
			    *---------------------------------
				* 默认的方式
			    *--------------------------------*/
				
				
			   public function modfy(){
				 parent::_checkPermission();
			     $id=$_GET['id'];
                 if(!isset($id)) exit('关键标识错误');
				 
				
				 
				 
                 $detail=$this->dao->where('id='.$id)->find();
				 $detail['realname']=M('Candidate')->where('id='.$detail['cid'])->getField('realname');
				 //echo M('Candidate')->getLastSql();
                 $this->assign('detail',$detail);
				 parent::_tpl('plus/modfy');
			 }		  
			   //提交更新
			    public function do_modfy(){
					
					
				                        $id=$_GET['id'];
										$data=$_POST;
										 if($data['c_status']==0){
										$data['dz_jine']  =  0;
										$data['dz_time']=0;
									   }else{
										$data['dz_time']=strtotime($data['dz_time']);
							   
							   }
						   
						//要查找是否已经分配了
						
						
						   
					   $data['yfk_time']=strtotime($data['yfk_time']);
					   $data['update_time']=time();
					   $rs=$this->dao->where("id=".$id)->save($data);  
				       if($rs){
							 parent::_message('success', '更新成功',$_SERVER['HTTP_REFERER'].$_REQUEST['maodian']);
						   }else{
							 parent::_message('error', '更新失败,可能并没有进行修改',$_SERVER['HTTP_REFERER'].$_REQUEST['maodian']);
						 }
				   }
			   
			   
			   
			   
			   //删除操作 
			   public function delete(){
				    parent::_checkPermission();
				    //首先更新收款中表的数据字段如果是全额那就把收款中已经进入状态的取消。
					//执行父类操作并且执行回调函数
                    $rs=parent::__deletes($this->dao,$this->id);
					 if($rs){
						
						}
					 
					  
				   }
				   
				   
				   
				  //单个佣金分配
				  
				  
				  public function fenpei(){
					  
					      if(!$this->id){
							    
							  parent::_message('error', '关键标志丢失');	  
						      	  
						 }
						 
						 
						   $su=$this->set_commission($this->id);
						  
						  if($su){
						  parent::_message('success','分配成功');
						  }else{
							   parent::_message('success','分配失败'); 
							  
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
                       $ids= implode(',',$_POST['id']);
                       if($operate=='3'){
                       $rs=$this->dao->where("id in ($ids)")->delete();
                                         if($rs){
									    if($_PSOT['ajax']!=1){
									      parent::_message('success', '删除成功',$_SERVER['HTTP_REFERER'].$_REQUEST['maodian'],$ajax=true);
										 }else{
											//echo "nihao";
										}
									}else{ 
								   parent::_message('error', '删除失败');
									}
							 }
								  elseif($operate=='1' || $operate=='0'){
								
								//更新已到账操作
								//$this->dao->create();
								 //字段等于字段更新
								 if($operate==1){
								    $dz_jine=array('field'=>'yfk_jine');
									 $this->dao->dz_time=time();
								 }else{
									 $dz_jine=0;
									 $this->dao->dz_time=time();
									 $this->dao->fen=0;
									 }
								 $this->dao->c_status=$operate;
								 $this->dao->dz_jine=$dz_jine;
								 $this->dao->jishu=$dz_jine;
								
								 $this->dao->update_time=time();
								 $rs=$this->dao->where("id in ($ids)")->save();
								 // echo $this->dao->getLastSql();
								   if($rs){
									    if($_PSOT['ajax']!=1){
									      parent::_message('success', '更新成功啦',$_SERVER['HTTP_REFERER']."#".$_REQUEST['maodian'],$ajax=true);
										}else
										{
											//echo "nihao";
										}
										
										
										
										
									}else{ 
									 
										 parent::_message('error', '更新失败');
									}
									
							     //如果等13就更新已到账
								 
								  }
								  
								  
								  
								  
								  
								  
								  elseif($operate==13){
								       
									 foreach($_POST['id'] as $k=>$v){
										  
										   $this->set_commission($v);
										  
										   
										 }	
										 
										
								      parent::_message('success', '更新成功啦',$_SERVER['HTTP_REFERER']."#".$_POST['maodian']);	
									
								 //类型错误就返回		
								}else{
								 parent::_message('error', '操作类型错误');
								}
								  
								  
								  
								  
							}
							
							
							
							 #--------------------------------
							 # 设置到佣金分配
							 #--------------------------------
							public function set_commission($id){
								
								       
								
						                      #读取数据是否是已到账状态
											  $sed=$this->dao->find($id);
											  if($sed['c_status']!=1){
												   parent::_message("error","候选未到账");
												  }
											  //在读取这批收款是否已经进入分配，如果已经有了则不能操作
											  $commission=D('Commission');
											  
											  $nums=$commission->where('did='.$id)->count();
											  if($nums >0){
												  
												  parent::_message('error', '已经分配过！');
												  
												  exit();
												  }
											  
											  	  
												  
											  $cid=M("Collection")->where('id='.$id)->find(); 
											  $jishu=$cid['jishu'];
											  $dz_jine=$cid['dz_jine'];
											  $gid=$cid['gid'];	  
											  $pici=$cid['pici']."-".$cid['zongpi'];
							              	  #读取候选人提成状态，默认为系统设置提成
											  $ticheng=M("Ticheng")->where('cid='.$cid['cid'])->find();
						                      $ticheng=explode(',',$ticheng['ticheng']);
											  #读取佣金基数信息  
											  #读取候选人团队成员
											  $Nteam=M('Nteam')->where('cid='.$cid['cid'])->select();
											  #读取角色
											  
											  //默认的提成比例		
											  $juese=$this->persona;
											   foreach($juese as $k=>$v){
													   $njuse.=$v['bili'].",";
												   }	
												   
												   
												   
												   foreach($Nteam as $k=>$v){
																
																	$data['uid']=$v['uid'];
																	$data['cid']=$v['cid'];
																	$data['did']=$id;
																	$data['gid']=$gid;
																	$data['persona']=$v['persona'];
																	$data['befor_bili']=$njuse;
																	$persona=explode(',',$v['persona']);
																	$fentc='';
																	$zongtc=0;
																	 foreach($ticheng as $c=>$d){
																			 if(in_array($c,$persona)){
																			 $fentc.=$d.",";
																			 $zongtc=$zongtc+intval($d);
																			 }
																		   }
																	 
																	$data['dz_jine']=$dz_jine;
																	$data['jishu']=$jishu;
																	$data['comid']=$this->comid;
																	$data['department']=$this->department;
																	$data['commission']=$jishu*$zongtc/100;
																	$data['create_time']=time();
																	$data['update_time']=time();
																	$data['pici']=$pici;
																	
																	$data['issue']=0;
																	$data['bili']=$fentc;
																	$data['zongbi']=$zongtc;
																	$rs=$commission->add($data);
																		  if(!$rs){ 
																		         parent::_message('error', '写入失败');
																			      
																				 
																				 
																				 }else{
																					 
																				   $data1['fen']=1;
																				    M('Candidate')->where('id='.$cid['cid'])->save($data1);
																				   $rs1=$this->dao->where('id='.$id)->save($data1);
																				   
																			}
																			
																			
																	  
																} 
																
															return $rs;	
																	
								
						   }
						   
						   
						   
						   
						   
						   	//恢复回收站
			     public function  recover(){
					     
						  parent::__recover($this->dao,$this->id);
					 
				}
				
				//强制删除
				
				 public function  hard_delete(){
					     
						  parent::__hard_delete($this->dao,$this->id);
					 
					 }
						   
						   
						   
						   
						   
				
	 } 
	 
	 ?>
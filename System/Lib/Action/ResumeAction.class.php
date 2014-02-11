<?php
/**
 * Created by Adobe DW cs6.
 * User: Administrator
 * Date: 13-5-17
 * Time: AM 11:02
 * To change this template use File | Settings | File Templates.
 * className:Notice
 * dever:yige
 * ProjectName:jobmedia OA.
 */
 
 class ResumeAction extends GlAction{
	 
	 
	 
	        //initialize
			   public function _initialize(){
				    
					parent::_initialize();
					//$this->dao=D('Persona');
					
					} 
				 
				 
				  
			   public function index(){
					
				                	
					
				 }  
	 
	             
			   
			   public function detail(){
				   
				           
                            parent::checkID($this->id);
							$pr=$this->dao->where('uid='.$this->id)->find();
						    $dt=$this->dao->where('uid='.$this->id)->find();  
							
							
							
							
							
									 $dt=M('User')->where('uid='.$this->id)->find();
									 $dt['edu']=M('Resume_edu')->where('resume_id='.$dt['uid'])->select();
									 $dt['work']=M('Resume_work')->where('resume_id='.$dt['uid'])->select();
									
									 $ex=$this->dao->where("uid=".$this->id)->find(); 
									 $this->assign('ex',$ex);
								     $this->assign('dt',$dt);
								
							
							
							
							
							
							//print_r($pr);   
							$this->assign('pr',$pr);            
						    $this->assign('dt',$dt);
						    // print_r($dt);
						    $this->display();
						   				  
				   
				   } 
	 
	 
	              
				  public  function  add_can(){
					  
					             //  print_r($_POST);
					  
					               $s=M('Candidate')->where('resume_id='.$_POST['id'].' and gid="'.$_POST['gid'].'"')->count();  	
						         //  echo "niohap";
								  
							        if($s==0){
								      
												  $data['resume_id']=$_POST['id'];
												  $data['cid']=M('Works')->where('id='.$_POST['gid'])->getField('cid');
												  $data['comid']=$this->comid;
												  $data['uid']=$this->uid;
												  $data['source']=1;
												  $data['stage']=1;
												  $data['gid']=$_POST['gid'];
												  $data['realname']=get_resume('fullname',$v);
												  $data['stages']=1;
												  $data['create_time']=time();
												  $rs=D('Candidate')->add($data);
									  
									     if($rs){
							   
													     
														  $tichengs=$this->persona;
														  $ti='';
														   foreach($tichengs as $k=>$v){
															   
																   $ti.=$v['bili'].",";
															   }
															 
														 $ti=substr($ti,0,strlen($ti)-1); 
														 $data1['cid']=$rs;
														 $data1['ticheng']=$ti;
														 $r1= D("Ticheng")->add($data1);
							   
							  
							    
																$touid=M('Team')->where('gid='.$_POST['gid'].' and uid <> '.$this->uid)->select(); 
																$in['touid']=imp($touid,',',$field='uid');
																$in['gid']=$_POST['gid'];
																$in['module']='Candidate';
																$in['uid']=$this->uid;
																$in['cid']=$rs;
																$in['resume_id']=$_POST['id'];
																
																$inrs=M('Inform')->add($in);
																if(!$inrs){
																	  parent::_message('error','通知写入失败',$_SERVER['HTTP_REFERER']);
																	} 
							   
							                                                 if(!$r1){
																		 
																		        parent::_message('error','提成添加失败',$_SERVER['HTTP_REFERER']);
																	      
																	        }
																				 //欠缺回滚机制
																					$data2['persona']=0;
																					$data2['uid']=$this->uid;
																					$data2['cid']=$rs;
																					$rs2=D('Nteam')->add($data2);
																					// exit(print_r($data2).$rs2);
																					
																				 if($rs2){
																					
																				  }else{
																					  
																					  
																					   parent::_message('error','添加失败');
																					  }
																				   
																				   }
						   
						   
						   
						   
						   
						   
						   
						   
						   
						                                                          //最后一步写入通知
																				   $zhiwei=M('Works')->where('id='.$_POST['gid'])->getField('Search_posts');
						                                                           $d['title']="你的职位申请 <a href='/Job/detail/id/".$_POST['gid']."'>".$zhiwei."</a> 已经通过";
																				   $d['create_time']=time();
																				   $d['to_uid']=$_POST['id'];
						                                                           $d['fa_uid']=$this->uid;
																				   $rs8=D('Sinform')->add($d);
																				   if(!$rs8){
																					     
																						 parent::_message('error','消息添加失败');
																					     
																					   } 
						   
					                                                        	   parent::_message('success','推荐成功');
						   
						   
						   
						   
						   
																				}else{
																				   
																					parent::_message('error','添加失败,不能重复增加');
																				   
																				   }
					  
																	  }
	 
	          
			  
	 
	 
	 
	 
	 }
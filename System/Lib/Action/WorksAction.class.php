<?php
// 本类由系统自动生成，仅供测试用途
class WorksAction extends GlAction {
	
	              public $ajax;
	             function _initialize(){ 
				        $this->ajax=intval($_REQUEST['ajax']);
                        parent::_initialize();
						//parent::Checklogin();
						$this->dao=D('Works');
						$this->can=D("Candidate");
						$this->id=intval($_GET['id']);
						
						// $this->consultant 
				 }
	
	
	
	
	           
                 public function index(){  
				             parent::_checkPermission();
							 parent::teamer();
							 parent::bumen();
				             $this->assign("page_hover",'myWork'); 
				             $condition = array();
                             $title           =formatQuery($_GET['title']);
                             $industry        =$this->_get('industry');
							 $cid = $_GET['cid'];
							 
                             $executive_arm   =$this->_get('department_id');
				             $area            =$this->_get('area');
							 $area_cn         =$this->_get('area_cn'); 
							 $status          =$this->_get('status');
							 $stage           =$this->_get('stage');
							 $Search_posts    =$this->_get('Search_posts');
							 $display=1;
							 $condition = !empty($conditions) ? $conditions : '' ;
	                         $title &&  $condition['title'] = array('like', '%'.$title.'%');
							 $area_cn &&  $condition['area_cn'] = array('like','%'.$area_cn.'%');
							 $cid &&  $condition['cid'] = array('eq',$cid);
							 $display &&  $condition['display'] = array('eq',$display);
							 $industry && $industry['industry'] = array('eq',$industry);
                             $executive_arm != 0 && $condition['department_id'] = array('eq',$executive_arm);
                             $status !=0 && $condition['status'] = array('eq', $status);
                             $stage !=0 && $condition['stage'] = array('eq', $stage);
							 $Search_posts && $condition['Search_posts']=array('like','%'.$Search_posts.'%');
							 $condition['uid']=$this->uid;
							 $orders="up_time desc, id desc";
							 
							 
							 //exit($wids);
							 // $condition['_logic'] = 'OR';
							 //$Search_posts && $condition['client']=array('like','%'.$Search_posts.'%');
							$pageCount = $this->dao->where($condition)->count();
							
							//echo $this->dao->getLastSql();
							
							
							$listRows = empty($listRows) ? 10 : $listRows;
							$orderd = empty($orders) ? 'id DESC' : $orders;
							$paged = new page($pageCount, $listRows);
							$dataContentList = $this->dao
							                        ->Where($condition)
							                        ->Order($orderd)
							                        ->Limit($paged->firstRow.','.$paged->listRows)
													->select();  
													 foreach($dataContentList as $k=>$v){
														$dataContentList[$k]['stage']=parent::__get_c_stage($v['id']);
														if(time()>$v['end_time']){
														$dataContentList[$k]['guoqi']=1;
														}else{
															$dataContentList[$k]['guoqi']=0;
															}
														}
													
													
													                          
							$pageContentBar = $paged->show();
							$this->assign('getList', $dataContentList);
							$this->assign('pageBar', $pageContentBar);
                    
						  
		                    $this->ajax==0 ? $this->display() : $this->display("plus/index_small");
           }     
		   
		   
		   
		   
		       //我参与的
			   
			   public  function partake(){
				   
				         
				             $this->assign("page_hover",'myWork'); 
							  parent::teamer();
							  parent::bumen();
							  
				             $condition = array();
                             $title           =formatQuery($_GET['title']);
                             $industry        =$this->_get('industry');
							 $cid = $_GET['cid'];
							 $source=$_GET['source'];
							 $resume_id=  $_GET['resume_id'];
							 
                             $executive_arm   =$this->_get('executive_arm');
				             $area            =$this->_get('area'); 
							 $status          =$this->_get('status');
							 $stage           =$this->_get('stage');
							 $department_id   =$this->_get('department_id');
							 $Search_posts    =$this->_get('Search_posts');
							 $display=1;
							  $orders="up_time desc, id desc";
							 $condition = !empty($conditions) ? $conditions : '' ;
	                         $title &&  $condition['title'] = array('like', '%'.$title.'%');
							 $area &&  $condition['area'] = array('eq',$area);
							 $cid &&  $condition['cid'] = array('eq',$cid);
							 $department_id && $condition['department_id']=array('eq',$department_id); 
							 $display &&  $condition['display'] = array('eq',$display);
							 $industry && $industry['industry'] = array('eq',$industry);
                             $executive_arm != 0 && $condition['department_id'] = array('eq',$executive_arm);
                             $status !=0 && $condition['status'] = array('eq', $status);
                             $stage !=0 && $condition['stage'] = array('eq', $stage);
							 $Search_posts && $condition['Search_posts']=array('like','%'.$Search_posts.'%');
							 $wid=M('Team')->Field('gid,uid')->where('uid='.$this->uid)->select();
							 $wids=imp($wid,',','gid');
							 
							 if($resume_id!=0){
								 
									   $ngid=M('Candidate')->Field('gid')->where('resume_id='.$resume_id.' and source='.$source)->select();
									   $ngid1=imp($ngid,',','gid');
									  
									//  print_r($ngid);
									  
							
							}
							 
							/*$ff=explode(',',$wids);
							$bb=explode(',',$ngid1);
							$rr=array_merge($ff,$bb); 
						    $ee=array_unique($rr);
							$rr=implode(',',$rr);
						  */
							$condition['id']=array('in',$wids);
							//$condition['_logic']='AND';
							//$condition['id']=array('not in',$ngid1);
							$pageCount = $this->dao->where($condition)->count();
							$listRows = empty($listRows) ? 10 : $listRows;
							$orderd = empty($orders) ? 'id DESC' : $orders;
							$paged = new page($pageCount, $listRows);
							$dataContentList = $this->dao
							                        ->Where($condition)
							                        ->Order($orderd)
							                        ->Limit($paged->firstRow.','.$paged->listRows)
													->select();  
													
													
													
													  foreach($dataContentList as $k=>$v){
														    
															$dataContentList[$k]['stage']=parent::__get_c_stage($v['id']);
															
															
																if(time()>$v['end_time']){
														               $dataContentList[$k]['guoqi']=1;
														             }else{
														            	$dataContentList[$k]['guoqi']=0;
															          }
														
															//$dataContentList[$k]['cz']=checkCan($v['id'],$resume_id)."jajhah";
														
														}
													
							//	echo $this->dao->getLastSql();					
													                          
						    $this->ajax==0 ? $pageContentBar = $paged->show() :$pageContentBar = $paged->show_ajax() ;                           $this->assign('getList', $dataContentList);
							$this->assign('pageBar', $pageContentBar);
                            $this->ajax==0 ? $this->display() : $this->display("plus/index_small");
				   
				   }
				   
				   
				   
				   
				   
				   
				   
				   
				   
				   
				   public  function partake1(){
				            
				         
				             $this->assign("page_hover",'myWork'); 
							 
							 $source=$_GET['source'];
				             $condition = array();
                             $resume_id=  $_GET['resume_id'];
							 $wid=M('Team')->Field('gid,uid')->where('uid='.$this->uid)->select();
							 $wids=imp($wid,',','gid');
							 
							 
							
							 $where=" id in ($wids)";
							 
							/* if($resume_id!=0){
								 
									   $ngid=M('Candidate')->Field('gid')->where('resume_id='.$resume_id.' and source='.$source)->select();
									   $ngid1=imp($ngid,',','gid');
									   if($ngid1){
									   $where.=" AND id not in ($ngid1)";
									   }
									//  print_r($ngid);
									  
							
							}*/
						
							$pageCount = $this->dao->where($where)->count();
							$listRows = empty($listRows) ? 10 : $listRows;
							$orderd = empty($orders) ? 'id DESC' : $orders;
							$paged = new page($pageCount, $listRows);
							$dataContentList = $this->dao
							                        ->Where($where)
							                        ->Order($orderd)
							                        ->Limit($paged->firstRow.','.$paged->listRows)
													->select();  
													
													
													
													  foreach($dataContentList as $k=>$v){
														    
															$dataContentList[$k]['stage']=parent::__get_c_stage($v['id']);
															$dataContentList[$k]['cz']=$this->checkCan($v['id'],$resume_id);
															
															
																if(time()>$v['end_time']){
														               $dataContentList[$k]['guoqi']=1;
														             }else{
														            	$dataContentList[$k]['guoqi']=0;
															          }
														
														}
										
								//echo $this->dao->getLastSql();							                          
								
								
								
							 $this->ajax==0 ? $pageContentBar = $paged->show() :$pageContentBar = $paged->show_ajax() ;
							
							$this->assign('getList', $dataContentList);
							$this->assign('pageBar', $pageContentBar);
                    
						  
		                    $this->ajax==0 ? $this->display() : $this->display("plus/index_small");
				   
				   }
				   
				   
				   
				   
				   
				   
				   
				   
				   
				   
				   
				   
				   
				   
				   
		   
		   
		   
		   
		       public function all(){  
			   
			      parent::_checkPermission();
				  parent::teamer();
				  parent::bumen();
			      $this->assign("page_hover",'allWork'); 
				             $condition = array();
                             $title           =formatQuery($_GET['title']);
							 $cid = $_GET['cid'];
							 $cid &&  $condition['cid'] = array('eq',$cid);
                             $industry        =$this->_get('industry');
                             $executive_arm   =$this->_get('executive_arm');
				             $area            =$this->_get('area'); 
							 $status          =$this->_get('status');
							 $stage           =$this->_get('stage');
							 $Search_posts    =$this->_get('Search_posts');
							 $uid             =$this->_get('uid');
							 $display=1;
							 $condition = !empty($conditions) ? $conditions : '' ;
	                         $title &&  $condition['title'] = array('like', '%'.$title.'%');
							 $area &&  $condition['area'] = array('eq',$area);
							 $uid &&  $condition['uid'] = array('eq',$uid);
							 $display &&  $condition['display'] = array('eq',$display);
							 $industry && $industry['industry'] = array('eq',$industry);
                             $executive_arm != 0 && $condition['department_id'] = array('eq',$executive_arm);
                             $status !=0 && $condition['status'] = array('eq', $status);
                             $stage !=0 && $condition['stage'] = array('eq', $stage);
							 $Search_posts && $condition['Search_posts']=array('like','%'.$Search_posts.'%');
							 //获取部门其他成员
							 $condition['comid']=$this->comid;
							 // $condition['_logic'] = 'OR';
							 //$Search_posts && $condition['client']=array('like','%'.$Search_posts.'%');
							$pageCount = $this->dao->where($condition)->count();
							$listRows = empty($listRows) ? 10 : $listRows;
							$orderd="up_time DESC,id DESC";
							$orderd = empty($orders) ? 'id DESC' : $orders;
							$paged = new page($pageCount, $listRows);
							$dataContentList = $this->dao
							                        ->Where($condition)
							                        ->Order($orderd)
							                        ->Limit($paged->firstRow.','.$paged->listRows)
													->select();  
													  foreach($dataContentList as $k=>$v){
														   $dataContentList[$k]['stage']=parent::__get_c_stage($v['id']);
															if(time() > $v['end_time'] && $v['end_time'] !=0 ){
																$dataContentList[$k]['guoqi']=1;
																}else if($v['end_time'] > time() || $v['end_time'] == 0 ){
																	
																$dataContentList[$k]['guoqi']=0;
														     }
															
														      }
                            $pageContentBar = $paged->show();
							$this->assign('getList', $dataContentList);
							$this->assign('pageBar', $pageContentBar);
                            $this->ajax==0 ? $this->display() : $this->display("plus/index_small");
           }
		     //创建工作单
	
	     public function add(){
			  parent::_checkPermission();
			  parent::bumen();
			      //测试该用户是否填写部门
				  $msg="";
				  if($this->department < 1){
				    $msg="您的账户还没有设置部门信息呢，设置部门信息可以再批量查询的时候进行筛选，和统计等。";
				   }
				// echo  $this->department;
				 $this->assign("msg",$msg); 
                 $this->assign("page_hover",'work_insert');
                 $this->display();
		 
		  }    
		  
		    
		  
		 
		       
		       //公共的ajax 页面
		       public function plus(){
				   
				   
				            $act=$this->_get('act');
					        switch($act){
						    /*获取负责人*/
						    case "fuze":
							$ps=10;
							
							$where='uid ='.$this->uid.' or pid='.$this->comid.' or uid='.$this->pid;
							//$where.=" and realname <> ''";
							$list=parent::get_json_list(M('User'),$where,$order='uid DESC',$listRows=16);
							$list=$list['list'];
							
							$pageBar=$list['pageBar'];
							$this->assign('getList',$list);
							$this->assign('pageBar',$pageBar); 
							$this->display('plus/fuze');
							break;
							/*添加团队成员*/
							
							case "teamer":
							$ps=$_GET['ps'];
							$parm="&pid=".$this->uid;
							
							parent::get_json_list('teamer',$ps,$parm);
							$this->display('plus/teamer');
							break;
							
							
							/*获取HR联系人*/
							case "hr_contact":
						     
							 $com_id=$this->_get('com_id');
							 if($com_id){
								  
								  $hr=D("hr_contacts")->where("company_id=".$com_id)->select();
								  
								 } 
							
						    $this->assign("getList",$hr);		 
							$this->display('plus/hr_contact');
							break;
							/*获取客户*/
							case "client":
							$ps=$_GET['ps'];
							$parm="&uid=".$this->pid;
							$list=parent::get_json_list($act,$ps,$parm);
							$list=$list['list'];
							$pageBar=$list['pageBar'];
							$this->assign('getList',$list);
							$this->assign('pageBar',$pageBar); 
                            $this->display("plus/client");	
						    break;
							
							
							/*获取候选人提成比例*/
							case "set_ticheng":
							$gid=$_GET['gid'];
							$detail=M("set_ticheng")->where("candidate_id=".$gid)->find();
							
							$this->assign("set",$detail);  
							
                            $this->display("plus/set_ticheng");	
						    break;
							
							
							
							case "do_set_ticheng":
							$gid=intval($_GET['gid']);
							$data=$_POST;
							$data['id']=$gid;
							$res=D("set_ticheng")->where('id='.$data['id'])->save($data);
							if($res){
								 D("yeji")->where('candidate_id='.$data['candidate_id'])->delete();
								 exit('ok');
								}else{
								 exit(print_r($gid));
									}
						    break;
							case "team":
							$gid=intval($_GET['gid']);
							$vlist=M("Team")->where("gid=".$gid)->select();
							//print_r($vlist);
							$this->assign('getList',$vlist);
							$this->display('plus/juese');
							break;
							default:
							echo "";
							break;
						   
						  
						  }
					   
				   
			  
			  }
		  
		  /*保存工作单*/
		  public function do_add(){
			  
			      $data=$_POST;
				 // print_r($data);
				  //exit();
				 
				  $data['start_time'] = date(strtotime($data['start_time']));
                  $data['end_time']   = date(strtotime($data['end_time']));
				  $data['create_time']=time();
				  $data['up_time']=time();
				  $data['uid']=$this->uid;
				  //$data['department_id']=$this->department;
				 // $data['group_id']=$this->group_id;
				  $data['comid']=$this->comid;
				  
				  //读取行业
				  
				  $trade=M('Client')->where('id='.$data['cid'])->getField('trade');
				  $data['industry']=$trade;
				   
			
					     
						$re=$this->dao->add($data); 
					    
						     if($re){
							     
								$data1['gid']=$re;
								$data1['persona']=0;
								$data1['start_time']=time();
								$data1['end_time']= $data['end_time'];
								$data1['uid']=$this->uid;
								$data1['uname']=getTruename($this->uid);
								$data1['works_nr']=3;  
								$rs=D("Team")->add($data1);
								 
								  if($data['principal'] != $this->uid){
									    $data2['gid']=$re;
										$data2['persona']=11;
										$data2['start_time']=time();
										$data2['end_time']=time()+3600*24*60;
									
										//这里我考虑是不是需要优化一下
										$data2['uname']=getTruename($data['principal']);  
									    $data2['uid']=$data['principal'];
									     $rs1=D("Team")->add($data2);
									  
									  }
								 
								
									
													if($rs1){
														
													}
							         
									 parent::_message('success','添加成功');
									 
									 
						 }else{
										 
										 
		                             parent::_message('error','失败');
                            }
								   
								   
								
								   
						
			
			  
			  }
			 //修改工作单 
			  
	     public function modfy(){
			    parent::_checkPermission();
				parent::bumen();
				 
			     $id=$_GET['id'];
                 if(!isset($id)) exit('关键标识错误');
                 $detail=$this->dao->where('id='.$id)->find();
                 $this->assign('detail',$detail);
				 $this->display();
				  
			 
			 
			 }		  
		  
		  
		   //保存修改工作单
		   
		  public function do_modfy(){
			  
			  
	                      $id=$_GET['id'];
	                      if(intval($id)==0){
                          parent::_message('error','条件丢失');
                          }  
						  $data=$_POST;
						  $data['start_time']  = date(strtotime($data['start_time']));
						  if($data['end_time']!='长期'){
                          $data['end_time']    = date(strtotime($data['end_time']));
						  }else{
							   $data['end_time']=0;
							  }
						  $data['update_time'] = time(); 
                          $trade=M('Client')->where('id='.$data['cid'])->getField('trade');
				          $data['industry']=$trade;
				          $data['id']=$id;
						  
						  //如果负责人修改了怎么办呢？删除该工作单的负责人重新加一下么？
						   
						   if($data['principal'] != $data['yfz']){
							   
							      //删除团队里面原来的领导
								  $dl=M('Team')->where('uid='.$data['yfz'])->delete();
								  
								  if(!$dl){
									     
										   parent::_message('error',"删除原负责人失败");
										 
									  }
								   
								   
								        $data2['gid']=$data['id'];
										$data2['persona']=11;
										$data2['start_time']=time();
										$data2['end_time']=time()+3600*24*60;
									
										//这里我考虑是不是需要优化一下
										$data2['uname']=getTruename($data['principal']);  
									    $data2['uid']=$data['principal'];
									    $rs=D("Team")->add($data2);
								       
									   if(!$rs){
										   parent::_message('error',"团队成员更新失败");
										   
										   }
								   
								   
								   
							   
							   }
						   
						  //$this->dao->update_time=time();
				          $re=D('works')->save($data);
						
				          if($re){
							 
							     parent::_message('success','保存成功',$_SERVER['HTTP_REFERER']);
								
								
		                        }else{ 
                                 print_r($data,$re);
						  exit;
								parent::_message('error',"好像有严重的问题$id");
								}
                        } 
						
						
						
						
						
						
						
	       //工作单详细
		   
		   public function detail(){
			          
					 
					  
			          parent::checkID();
						
					   parent::bumen();	
			          $work_detail=$this->dao->where("id=".$this->id)->find();
				  
					    foreach( $this->pb_arr['stage'] as $k=>$v){
							
						     if($k>0){
						    $stage[$k]=array('id'=>$k,'title'=>$this->pb_arr['stage'][$k]);
							 }
							
						
						 }
						
					  $ids=M('Candidate')->Field('resume_id,gid')->where('gid='.$this->id)->select();
					  $idx=imp($ids,',',$field='resume_id');
					  	
					  $work_detail['noids']=$idx;	 
					 
					 /*取得团队成员列表*/
					//$team_list=M("works_team")->where('gid='.$this->id)->select(); 	 
					 
					$pt=$work_detail['Search_search'];
					$this->assign('page_title',$pt);
					
					$this->assign('tlist',$team_list); 
					$this->assign('stage',$stage);
			        $this->assign("detail",$work_detail);
					$this->display();
			   
			   }	
			
				 
				 
				 
				 
			
				 
				 
				 
				 
				 
				 
			
			
			
		
			public function do_candidate_add(){
				      
				        $data=rfilter($_POST);
					  //print_r($data);
					  if($data){
						    $data['uid']=$this->uid;
							$data['luru']=$this->uid;
							
							$data['create_time']=time();
							$jr_zhiwei=M('Works')->find($data['gid']);
							
							
							
					        $data['jr_zhiwei']=$jr_zhiwei['Search_posts'];
							$data['comid']=$jr_zhiwei['comid'];
							$data['department_id']=$jr_zhiwei['department'];
							$data['group_id']=$jr_zhiwei['group_id'];
							
							
							
							
							//写入到公司间简历库
				  
				               $url=C('API_URL')."json.php?act=add_resume&uid=".$data['uid']."&fullname=".$data['realname']."&area_cn=".$data['area_cn']."&email=".$data['email']."&tel=".$data['phone']."&comid=".$this->comid."&last_company=".$data['before_job'];
							
							
							 
							    $add=file_get_contents($url);
								
								//  exit($url.$add);
							   if($add == 0){
								     
									 exit( '添加失败' );
									 
								   }
							
							
							     $data['resume_id']=$add;
							     $rs=D("Candidate")->add($data);
							
							
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
							   
							  // write a data in inform 
							    
							  $touid=M('Team')->where('gid='.$data['gid'].' and uid <> '.$this->uid)->select(); 
							  $in['touid']=imp($touid,',',$field='uid');
							  $in['gid']=$data['gid'];
							  $in['module']='candidate';
							  $in['uid']=$this->uid;
							  $in['cid']=$rs;
							  $in['resume_id']=$v;
							  
							  $inrs=M('Inform')->add($in);
							  if(!$inrs){
								    parent::_message('error','通知写入失败',$_SERVER['HTTP_REFERER']);
								  } 
								  
								  
								  
								  
								  
								  
							   
							   if(!$r1){
								     
									  parent::_message('error','提成添加失败',$_SERVER['HTTP_REFERER']);
								   
								   }
							 //欠缺回滚机制
							    $data2['persona']=$data['persona'];
							    $data2['uid']=$this->uid;
							    $data2['cid']=$rs;
							    $rs2=D('Nteam')->add($data2);
								// exit(print_r($data2).$rs2);
							 	
							 if($rs2){
							     parent::_message('success','添加成功',$_SERVER['HTTP_REFERER'].'#'.$_GET['maodian']);
							  }
							   
							   }
						   
						  }else{
							 
							    $data['ajax']==1? exit('err') : parent::_message('error','添加失败',$_SERVER['HTTP_REFERER']);
							 
							 }
					 
				
				
				}
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				  
                         /*******保存修改候选人******/
                         
                         
                         public function do_candidate_modfy(){
                                 
                                     $data=$_POST;
                                         
                                         
                                         $id=intval($_GET['id']);
                                         
                                          if($_POST['mianshi_time']!=''){
                                            $data['mianshi_time'] = date(strtotime($data['mianshi_time']));   
                                           }
                                         
                                              $data['yfk_time'] = date(strtotime($data['yfk_time']));   
                                              $data['sjdz_time']= $data['sjdz_time'] =="" ? 0 : date(strtotime($data['sjdz_time']));                               $data['yfk_jine']  = $data['yfk_jine'];   
                                              $data['sjdz_jine'] = $data['sjdz_jine'];  
                                              $data['update_time']=time();
											   
											   
											   if($data['stage']==4){
												   
												      $mian=M('Candidate')->where('id='.$id)->getField('mianshidate');                                                     
													  if($mian != '' && $mian != 'null'){
													      
														   $mian=json_decode($mian);
														   $mian=(array)$mian;
														    unset($mian[$_POST['stages']]);
														 //  echo $_POST['stages'];
														   $narr=array($_POST['stages']=>$data['mianshi_time']);
														   
														
														   foreach($mian as $k=>$v){
															    if($_POST['stages']==$k)
															     {
																  unset($mian[$k]);
																 }
															   }
														   
														  
														    unset($mian[4]);
															echo $mian[4];
														  
														   
														   
															if(count($mian)>0){	  
														        unset($mian[$_POST['stages']]);
															   $mian[$_POST['stages']]=$data['mianshi_time'];
															  
															   $xin=$mian;
															   
															}else{
																$xin=$narr;
																}
														  // exit;
														   $data['mianshidate']=json_encode($xin);
														   
												         }else{
															$narr=array($data['stages']=>$data['mianshi_time']);
															$data['mianshidate']=json_encode($narr);
															 
															 }
															 
															 $arr=array();
															
															
												   
												   }
											   
											   
											   
											   
                                         
                                         if($data && $id!=0){
                                                    
                                                     $rs=M("Candidate")->where("id=".$id)->save($data);
                                                         
                                                  if($rs){
                                                            
                                                        $data['ajax']==1? exit('ok') : parent::_message('success','编辑成功',$_SERVER['HTTP_REFERER']);
														}
                                                   
                                                  }else{
                                                         
                                                            $data['ajax']==1? exit('err') : parent::_message('error','编辑失败',$_SERVER['HTTP_REFERER']);
                                                         
                                                         }
                                         
                                
                                
                                }
			
			
			 /********************************************************
			   
			   业绩分配
			  
			******************************************************/ 
			 
			 
				
				
				//删除工作单
				
				
				public function delete(){
					   
					        $id=intval($_GET['id']);
						    parent::__deletes($this->dao,$id);
					
					}
				 
				 // 获取工作点全部业绩
			  
			
			
			 
			 
			// 删除业绩列







			 
			/********************************************************
			   
			   候选恩列表  采用ID get 方式获取列表
			  
			******************************************************/ 
			 
			 
			 
			   				
		   
		   //设置分类
		   
		  public function set(){
			   import("ORG.Util.Session");
			   $record=$_POST;
               Session::set('username', $record['username']);
			   Session::set('realname', $record['realname']);
               Session::set('userID', $record['id']);
               Session::set('roleId', $record['role_id']);
			//记住登录状态
			  $jinzhu=1;
			if($jizhu=='1'){
                Cookie::set('user_name',$record['username'],60*60*24*7);
				Cookie::set('real_name',$record['realname'],60*60*24*7);
			    Cookie::set('userID', $record['id'],60*60*24*7);
			    Cookie::set('roleId', $record['role_id'],60*60*24*7);
			}  
					echo  Session::get('username');
			  
			    }
				
				
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
				
				
				
				
				//批量操作工作单
				
				 public function doCommand(){
		
                   parent::_checkPermission('Works_command');
                 if(getMethod() == 'get'){
                         $operate = trim($_GET['operate']);
                         }elseif(getMethod() == 'post'){
                          $operate = trim($_POST['operate']);
                       }else{
                          parent::_message('error', '只支持POST,GET数据');
                       }
      
                            switch ($operate){
								
								
                                case 'delete':
								//设置回收站
								//parent::_delete(0,0);
							  $ids= implode(',',$_POST['id']);
							  $data['display']=0;
							  //$data['stage']=$operate;
							  $rs=$this->dao->where("id in ($ids)")->save($data);
						
						
						        if($rs){
									    if($_PSOT['ajax']!=1){
									      parent::_message('success', '删除成功',$_SERVER['HTTP_REFERER']);
										}else
										{
											echo "";
										}
									}else{ 
									 
										 parent::_message('error', '删除失败');
									}
			                    break;
								
								case 'update':
							    $ids= implode(',',$_POST['id']);
								$data1['up_time']=time();
							   //$data['stage']=$operate;
							   $rs=$this->dao->where("id in ($ids)")->save($data1);
								
								
								
								 if($rs){
									    if($_PSOT['ajax']!=1){
									      parent::_message('success', '刷新成功',$_SERVER['HTTP_REFERER']);
										}else
										{
											echo "";
										}
									}else{ 
									 
										 parent::_message('error', '刷新失败'.$this->dao->getLastSql());
									}
								
								
								
								break;
								
								
								
								case 'qk_delete':
								//设置回收站
								parent::_delete(0,0);
							    break;
								
                                default: parent::_message('error', '操作类型错误') ;
        
    }
	}
			
			
			/***-==================candidate Command=======================***/
			
				
				
				public function candidate_doCommand(){
		           
				   
				 
                  
                 if(getMethod() == 'get'){
                       $operate = trim($_GET['sid']);
                       }elseif(getMethod() == 'post'){
                       $operate = trim($_POST['sid']);
                       }else{
                       parent::_message('error', '只支持POST,GET数据');
                       }
                      
                      if($operate=='100'){
                                $ids= implode(',',$_POST['id']);
								 $rs=M('candidate')->where("id in ($ids)")->delete();
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
										
										
								
                        }elseif($operate && $operate <10){
							 $ids= implode(',',$_POST['id']);
							$data['stage']=$operate;
							 $rs=M('candidate')->where("id in ($ids)")->save($data);
							 if($rs){
								 
								   parent::_message('success', '更新成功',$_SERVER['HTTP_REFERER'].'#'.$_REQUEST['stage_cn'],$ajax=true);
								 }else{
									  parent::_message('error', '更新失败');
									 } 
							
							}else{
								
								 parent::_message('error', '操作类型错误');
								
								}
	       }
				/******************************************************/
				   
				/*======================搜索工作单 =====================*/
				
				/******************************************************/
				
				public function search(){
					    
						
						$this->assign("page_hover",'search');
					    $this->display();
					
					}
				
				
				//回收站
				
				public function recycle(){
					          parent::_checkPermission();
							   parent::bumen();
					        $condition = array();
                             $title           =formatQuery($_GET['title']);
							 $cid = $_GET['cid'];
							 $cid &&  $condition['cid'] = array('eq',$cid);
                             $industry        =$this->_get('industry');
                             $executive_arm   =$this->_get('executive_arm');
				             $area            =$this->_get('area'); 
							 $status          =$this->_get('status');
							 $stage           =$this->_get('stage');
							 $Search_posts    =$this->_get('Search_posts');
							 $uid             =$this->_get('uid');
							 $display=0;
							 $condition = !empty($conditions) ? $conditions : '' ;
	                         $title &&  $condition['title'] = array('like', '%'.$title.'%');
							 $area &&  $condition['area'] = array('eq',$area);
							 $uid &&  $condition['uid'] = array('eq',$uid);
							 $condition['display'] = array('eq',$display);
							 $industry && $industry['industry'] = array('eq',$industry);
                             $executive_arm != 0 && $condition['executive_arm'] = array('eq',$executive_arm);
                             $status !=0 && $condition['status'] = array('eq', $status);
                             $stage !=0 && $condition['stage'] = array('eq', $stage);
							 $Search_posts && $condition['Search_posts']=array('like','%'.$Search_posts.'%');
							 //获取部门其他成员
							 $condition['comid']=$this->comid;
							 // $condition['_logic'] = 'OR';
							 //$Search_posts && $condition['client']=array('like','%'.$Search_posts.'%');
							$pageCount = $this->dao->where($condition)->count();
							$listRows = empty($listRows) ? 10 : $listRows;
							$orderd = empty($orders) ? 'id DESC' : $orders;
							$paged = new page($pageCount, $listRows);
							$dataContentList = $this->dao
							                        ->Where($condition)
							                        ->Order($orderd)
							                        ->Limit($paged->firstRow.','.$paged->listRows)
													->select();  
													  foreach($dataContentList as $k=>$v){
														    $dataContentList[$k]['stage']=parent::__get_c_stage($v['id']);
														      }
                            $pageContentBar = $paged->show();
							$this->assign('getList', $dataContentList);
							$this->assign('pageBar', $pageContentBar);
					         $this->display();
					}
		
				
				 //恢复回收站数据到列表
				 
				 public function  recover(){
					     
						  parent::__recover($this->dao,$this->id);
					 
				}
				
				 public function  hard_delete(){
					     
						  parent::__hard_delete($this->dao,$this->id);
					 
					 }
				
				
		       /***-==================candidate Command=======================***/
			
				
				
				public function works_team_doCommand(){
		           
				   
				 
                  
                 if(getMethod() == 'get'){
                       $operate = trim($_GET['sid']);
                       }elseif(getMethod() == 'post'){
                       $operate = trim($_POST['sid']);
                       }else{
                       parent::_message('error', '只支持POST,GET数据');
                       }
                      
                      if($operate=='100'){
                                $ids= implode(',',$_POST['id']);
								 $rs=M('works_team')->where("id in ($ids)")->delete();
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
				
				
				
				
				
				
				
				
				
				
				
				public function set_c($rs){
					
					                   $tichengs=$this->persona;
								$ti='';
								 foreach($tichengs as $k=>$v){
									 
									     $ti.=$v['bili'].",";
									 }
								   
							   $ti=substr($ti,0,strlen($ti)-1); 
							   $data1['cid']=$rs;
							   $data1['ticheng']=$ti;
							   $r1= D("Ticheng")->add($data1);
							   
							  // write a data in inform 
							    
							  $touid=M('Team')->where('gid='.$data['gid'].' and uid <> '.$this->uid)->select(); 
							  $in['touid']=imp($touid,',',$field='uid');
							  $in['gid']=$data['gid'];
							  $in['module']='candidate';
							  $in['uid']=$this->uid;
							  $in['cid']=$rs;
							  $in['resume_id']=$v;
							  
							  $inrs=M('Inform')->add($in);
							  if(!$inrs){
								    parent::_message('error','通知写入失败',$_SERVER['HTTP_REFERER']);
								  } 
								  
								  
								  
								  
								  
								  
							   
							   if(!$r1){
								     
									  parent::_message('error','提成添加失败',$_SERVER['HTTP_REFERER']);
								   
								   }
							 //欠缺回滚机制
							    $data2['persona']=$data['persona'];
							    $data2['uid']=$this->uid;
							    $data2['cid']=$rs;
							    $rs2=D('Nteam')->add($data2);
								// exit(print_r($data2).$rs2);
							 	
							 if($rs2){
							     parent::_message('success','添加成功',$_SERVER['HTTP_REFERER'].'#'.$_GET['maodian']);
							  }
							   
							  
						   
						 
					
					      }
				
				
				
				
				
				
				//查找候选人是否存在
				
			
					 
					    
	              	public	function checkCan($gid,$rid){
			
						 if(!$gid || !$rid) return false;
						 
						 $nid=M('Candidate')->where('resume_id='.$rid.' and gid ='.$gid.' and source=0 and comid='.$this->comid)->count();
						 
						 
						 
			   
			   if($nid==0){
				    
					return 0;
				   
				   }else{
					 
					 return 1;   
					   }
			
			
			}
					     
					
				
				
				
				
				
				
				
				
				
				 public function doHuishou(){
		
                   parent::_checkPermission('doHuishou');
                 if(getMethod() == 'get'){
                         $operate = trim($_GET['operate']);
                         }elseif(getMethod() == 'post'){
                          $operate = trim($_POST['operate']);
                       }else{
                          parent::_message('error', '只支持POST,GET数据');
                       }
      
                            switch ($operate){
								
								
                                case 'delete':
								//设置回收站
								//parent::_delete(0,0);
							  $ids= implode(',',$_POST['id']);
							  $data['display']=0;
							  //$data['stage']=$operate;
							  $rs=$this->dao->where("id in ($ids)")->delete();
						
						
						        if($rs){
									    if($_PSOT['ajax']!=1){
									      parent::_message('success', '删除成功',$_SERVER['HTTP_REFERER']);
										}else
										{
											echo "";
										}
									}else{ 
									 
										 parent::_message('error', '删除失败');
									}
			                    break;
								
								case 'qk_delete':
								//设置回收站
								parent::_delete(0,0);
							    break;
								
                                default: parent::_message('error', '操作类型错误') ;
        
    }
	}
			
			
				
				
				
				public function up(){
					
					      $gid=$_POST['gid'];
						  if(!$gid) return false;
						  
						  $data['id']=$gid;
						  $data['up_time']=time();
						  $rs=D('Works')->where('id='.$gid)->save($data);
					      if($rs){
							   parent::_message('success', '刷新成功');
							  }else{
								  
								   parent::_message('error', '刷新失败');
								   
								  }
					
					}
				
				
				
				
				
}

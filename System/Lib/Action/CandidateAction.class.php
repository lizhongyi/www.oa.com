<?php
/**

候选人操作类

**/

class CandidateAction extends GlAction{
	
	     //initialize
	      
	       public function _initialize(){
			                   $this->ajax=intval($_REQUEST['ajax']);
				               parent::_initialize();
				               $this->dao=D("Candidate");
							   
							    $this->Checklogin();
			  
			                  
			 }
	    
		
		 //index action
		 
		 public function index(){
			 
			 
			 
			                parent::_checkPermission();
                            $ajax=intval($this->_get('ajax'));
							
							if(!$ajax){
								 header('Location:/Candidate/search');
								
								}
							$stage_id=intval($_GET['stage']);
							$gid=intval($_GET['gid']);
							$stage_id == 0 ? exit('err') : $stage_id;
							if($stage_id!=1){
				            $stage_id && $condition['stage']=array('eq',$stage_id);
							}
							if($stage_id && $stage_id!=12){
							if($stage_id==8){	
							
							$where="1=1 and stage = 8 and gid=$gid and display=1";	
							}else{
								$where="1=1 and stage=$stage_id and gid=$gid and display=1";
								}
							}else{
								$where="1=1 and gid=$gid and display=1 and comid=".$this->comid;	
								}
							$condition = !empty($conditions) ? $conditions : '' ;
                            $pageCount = $this->dao->where($where)->count();
		                     //echo $this->dao->getLastSql();
                            $listRows = empty($listRows) ? 10 : $listRows;
                            $orderd = empty($orders) ? 'id DESC' : $orders;
                            $paged = new page($pageCount, $listRows);
                            $dt = $this->dao->Where($where)->Order($orderd)->Limit($paged->firstRow.','.$paged->listRows)->select();    
							$pipi="";
							foreach($dt as $k=>$v){
								 if($v['stage'] > 7){
									                if($v['pici_history'] != ""){
										            $pi=json_decode($v['pici_history']);
									                foreach ($pi as $a=>$b){
													$dz=M('Collection')->Field('cid,pici,c_status')->where("cid=".$v['id']." and pici=$a+1 ")->find();                                $dzl="";
													if($dz['c_status']==1){
														  $dzl='已到账';
														}
													$dt[$k]['pici_jin'].=$a + 1 ."批 金额:".$b->jine." ".$dzl."<br/>";
													$dt[$k]['pici_time'.$a]= $b->time;
													$dt[$k]['pici_time'].=$a + 1 ."批 日期：". $b->time."<br/>";
													
													}	 
										   
										   
										   
										   }
										   
									 }
							
											
									 if($v['stage'] == 4){
									
							                            $mian=(array)json_decode($dt[$k]['mianshidate']);
														
														$zt=array("请选择","尚未面试","客户一面","客户二面","客户多轮面试","等待面试反馈","未通过面试","通过面试");                                               $dt[$k]['mm']="";
														
														foreach($mian as $b=>$c){
															 
															  $dt[$k]['mm'].=$zt[$b].":　".date('Y-m-d',$c)."<br/>"; 
															
															}
														
							                            $dt[$k]['mian']='<a href="#" rel="tooltip" class="top_tooltip" data-original-title="'.$dt[$k]['mm'].'">'.date('Y-m-d',$dt[$k]['mianshi_time'])." ".$dt[$k]['shi'].':'.$dt[$k]['fen'].'</a>';
														
							 
									 }			
									}
								
									
									$pj=$dt[$k]['pici_jin'];
									
									 foreach($dt as $k=>$v){
											
										
											
											        if($v['source']==0 && $v['realname']==0){
											      
													  $in=get_resume($v['resume_id']);
													  $dt[$k]['realname']=$in['realname'];
													  $dt[$k]['before_job']=$in['last_company'];
													  $dt[$k]['zhiwei']=$in['last_post'];
													}
													else if($v['source']==1 ){
														
													          $in=get_tlent($v['resume_id']);
													          $dt[$k]['realname']=getTruename($v['resume_id']);
													          $dt[$k]['before_job']=$in['last_company'];
													          $dt[$k]['zhiwei']=$in['post_cn'];
														}else if($v['source']==2 && $v['realname']==0){
															
														 $in=get_import($v['resume_id']);
														 
													           $dt[$k]['realname']=$in['title'];
														       $dt[$k]['before_job']=$in['last_company'];
													           $dt[$k]['zhiwei']=$in['post_cn'];
														}
												     $info="";
													 
													 $info.="<div class='info_b'>";
											         $info.="<h5>初选评语</h5>";
													 $info.="<p>".$v['cx_mark']."</p>";
													 $info.="</div>";
													  $info.="<div class='info_b'>";
													 $info.="<h5>顾问评语</h5>";
													 $info.="<p>".$v['gw_mark']."</p>";
													 $info.="</div>";
													  $info.="<div class='info_b'>";
													 $info.="<h5>推荐反馈</h5>";
													 $info.="<p>".$v['tj_mark']."</p>";
													 $info.="</div>";
													  $info.="<div class='info_b'>";
													 $info.="<h5>面试反馈</h5>";
													 $info.="<p>".$v['ms_mark']."</p>";
													 $info.="</div>";
													  $info.="<div class='info_b'>";
													  $info.="<h5>谈判备注</h5>";
													 $info.="<p>".$v['tp_mark']."</p>";
													 $info.="</div>";
													  $info.="<div class='info_b'>";
													  $info.="<h5>录用备注</h5>";
													 $info.="<p>".$v['ly_mark']."</p>";
													 $info.="</div>";
													  $info.="<div class='info_b'>";
													  $info.="<h5>入职备注</h5>";
													 $info.="<p>".$v['rz_mark']."</p>";
													 $info.="</div>";
													  $info.="<div class='info_b'>";
													  $info.="<h5>收款备注</h5>";
													 $info.="<p>".$v['fk_mark']."</p>";
													 $info.="</div>";
												
													 $dt[$k]['mk']=$info;
													 if($dt[$k]['jr_zhiwei']==''){
													   $dt[$k]['jr_zhiwei']=M('Works')->where('id='.$v['$gid'])->getField('Search_posts');
													 }
													 
													 //还要读取候选人的状态，那么就是判断是否收款全部到账了。
													 
													 if($v['stage'] > 7){
													       $cl=M('Collection')->where('cid='.$v['id'].' and c_status=0')->count();
													   if($cl==0){
														    $dt[$k]['st']='<span class="lv">已完成</span>';
														  
														      }else{
																    $dt[$k]['st']='收款中';
																  }
													}
											   
											}
							              
								
									// echo $this->dao->getLastSql();
									 $ajax==0 ? $pageContentBar = $paged->show() : $pageContentBar = $paged->show_ajax();
									//print_r($dt); 
									$this->assign('getList', $dt);
									$this->assign('pageBar', $pageContentBar);
									
									
									parent::_tpl('plus/candidate'.$stage_id);
			 
			          
			  
			  }
			  //综合统计与查询
			  
			  
			  
			                         public function search(){
				                     $this->readClist();
									 	   
		                               parent::bumen();
		   
		   
		   
		   
		    
			                        $ajax=intval($this->_get('ajax'));
									$cid=intval($_GET['cid']);
									$stage_id=intval($_GET['stage']);
									
									
									$gid=intval($_GET['gid']);
									$cid= intval($_GET['cid']);
									$uid=$_GET['uid'];
									$keyword=$_GET['keyword'];
									$where="1=1";
									$cid && $where.=" and cid=".$cid;
									$gid && $where.=" and gid=".$gid;
									if($uid!=1){
									$uid && $where.=" and uid=".$uid;
									}
									$executive_arm=$_GET['executive_arm'];
									$executive_arm && $where.=" and department=$executive_arm"; 
									
									
									if($stage_id >=7){
									$stage_id && $where.=" and stage>=".$stage_id;
									}else{
										$stage_id && $where.=" and stage=".$stage_id;
										}
									
									
									
									$keyword && $where.=" and realname like '%".$keyword."%'";
									
									
									
									if($this->uid && $this->role_id > 2){
										  
										      $ids=M("Nteam")->Field('uid,cid')->where('uid='.$this->uid)->select();
										       foreach($ids as $k=>$v){
											     $idx[]=$v['cid'];
											  }
											  $idy=implode(',',$idx);
											  
											  $where.=" and id in($idy)";
										}
									
									
									$where.=" and display=1 and comid=".$this->comid;
									//$condition['_logoc']='OR';
									//$condition['gid']=array('like',"%".$keyword."%");
									$condition = !empty($where) ? $condition : '' ;
									$pageCount = $this->dao->where($where)->count();
									$listRows = empty($listRows) ? 10 : $listRows;
									$orderd = empty($orders) ? 'id DESC' : $orders;
									$paged = new page($pageCount, $listRows);
									$dt = $this->dao->Where($where)->Order($orderd)->Limit($paged->firstRow.','.$paged->listRows)->select();                  
							      // echo $this->dao->getLastSql();
							  
							 foreach($dt as $k=>$v){
								 
								     $uids="";
								     $tid="";
								     $gong=M("Works")->where('id='.$dt[$k]['gid'])->find();
								    // $dt[$k]['gongdan']=$gong['custom'];
									 $dt[$k]['zhiwei']=$gong['Search_posts'];
									 $dt[$k]['custom_id']=$gong['cid'];
									 $dt[$k]['gongdan_id']=$gong['id'];
									 $tid=M("Nteam")->field('id,cid,uid,persona')->where('cid='.$v['id'])->select();
									 foreach ($tid as $b=>$c){
										     $uids[]=array('uid'=>getTruename($c['uid']),'persona'=>parent::get_persona($c['persona']));
										  }
									 
								      $dt[$k]['tuan']=$uids;
								      
								 } 
							            
										   
										   $pipi="";
						
								
								foreach($dt as $k=>$v){
									
									
									
								                	 
											        if($v['source']==0 && $v['realname']==0){
											      
													  $in=get_resume($v['resume_id']);
													  $dt[$k]['realname']=$in['realname'];
													  $dt[$k]['before_job']=$in['last_company'];
													  $dt[$k]['zhiwei']=$in['last_post'];
													}
													else if($v['source']==1 ){
														
													          $in=get_tlent($v['resume_id']);
													          $dt[$k]['realname']=getTruename($v['resume_id']);
													          $dt[$k]['before_job']=$in['last_company'];
													          $dt[$k]['zhiwei']=$in['post_cn'];
														}else if($v['source']==2 && $v['realname']==0){
															
														 $in=get_import($v['resume_id']);
														 
													           $dt[$k]['realname']=$in['title'];
														       $dt[$k]['before_job']=$in['last_company'];
													           $dt[$k]['zhiwei']=$in['post_cn'];
														}
														
									
									
									
									            if($v['pici_history'] != ""){
										   
										         $pi=json_decode($v['pici_history']);
									        
											        foreach ($pi as $a=>$b){
													$dz=M('Collection')->Field('cid,pici,c_status')->where("cid=".$v['id']." and pici=$a+1 ")->find();                                $dzl="";
													if($dz['c_status']==1){
														  $dzl='已到账';
														}
													$dt[$k]['pici_jin'].=$a + 1 ."批 金额:".$b->jine."".$dzl."<br/>";
													//nn
													$dt[$k]['pici_time'].=$a + 1 ."批 日期：". $b->time."<br/>";
													
													}	 
										   
										   
										   
										   }
										   
										  
										  
										  
							
													
									}
									
									
									
									                
							    	
							
										  
										   
										   
										   
										   
										   
										   
									   
									   foreach($dt as $k=>$v){
										             
											           if($v['source']==0){
											      
													  $in=get_resume($v['resume_id']);
													  $dt[$k]['realname']=$in['realname'];
													  $dt[$k]['before_job']=$in['last_company'];
													  $dt[$k]['zhiwei']=$in['last_post'];
													}
													else if($v['source']==1){
														
													          $in=get_tlent($v['resume_id']);
													          $dt[$k]['realname']=getTruename($v['resume_id']);
													          $dt[$k]['before_job']=$in['last_company'];
													          $dt[$k]['zhiwei']=$in['post_cn'];
														}else if($v['source']==2){
															
														 $in=get_import($v['resume_id']);
														 
													           $dt[$k]['realname']=$in['title'];
														       $dt[$k]['before_job']=$in['last_company'];
													           $dt[$k]['zhiwei']=$in['post'];
														}
										   
										      $info="";
													 
													 
													 
													 $info.="<div class='info_b'>";
											         $info.="<h5>初选评语</h5>";
													 $info.="<p>".$v['cx_mark']."</p>";
													 $info.="</div>";
													  $info.="<div class='info_b'>";
													 $info.="<h5>顾问评语</h5>";
													 $info.="<p>".$v['gw_mark']."</p>";
													 $info.="</div>";
													  $info.="<div class='info_b'>";
													 $info.="<h5>推荐反馈</h5>";
													 $info.="<p>".$v['tj_mark']."</p>";
													 $info.="</div>";
													  $info.="<div class='info_b'>";
													 $info.="<h5>面试反馈</h5>";
													 $info.="<p>".$v['ms_mark']."</p>";
													 $info.="</div>";
													  $info.="<div class='info_b'>";
													  $info.="<h5>谈判备注</h5>";
													 $info.="<p>".$v['tp_mark']."</p>";
													 $info.="</div>";
													  $info.="<div class='info_b'>";
													  $info.="<h5>录用备注</h5>";
													 $info.="<p>".$v['ly_mark']."</p>";
													 $info.="</div>";
													  $info.="<div class='info_b'>";
													  $info.="<h5>入职备注</h5>";
													 $info.="<p>".$v['rz_mark']."</p>";
													 $info.="</div>";
													  $info.="<div class='info_b'>";
													  $info.="<h5>收款备注</h5>";
													 $info.="<p>".$v['fk_mark']."</p>";
													 $info.="</div>";
												
													 $dt[$k]['mk']=$info;
										   
										       
											   
											   
											   
											   
											   
											   
											       if($v['stage'] > 7){
													       $cl=M('Collection')->where('cid='.$v['id'].' and c_status=0')->count();
													         if($cl==0){
														          $dt[$k]['st']='<span class="lv">已完成</span>';
														           }else{
																	   
																	  
																	  if($v['pici_history'] != ""){
																	  
																	   
																	   
																    $dt[$k]['st']='<a href="#" rel="tooltip" class="top_tooltip" data-original-title="'.$dt[$k]['pici_jin'].'">收款中</a>';
																	
																	
																	  }else{
																		   $dt[$k]['st']='收款中';
																		  
																		  }
																	
																	
																  }
														 }
											   
											   
										   }
							  //print_r($dataContentList);
							  
							  
							 $ajax==0 ? $pageBar = $paged->show() : $pageBar = $paged->show_ajax();
							 $this->assign('getList', $dt);
                             $this->assign('pageBar', $pageBar);
							 $ajax==0 ? $this->display() : $this->display('plus/search');
			 
			          
			  
			  }
			  
			  
			  
			  
			  
			  
			  
			  //add action
			  
			 public function add(){
				           
						    // echo  $this->ajax;
							
							//read persona
							 $persona=M("Persona")->where("comid=".$this->comid)->order('id asc')->select(); 
							 $this->assign("plist",$persona);
							 
							 $this->ajax==0 ? $this->display() : $this->display('plus/add') ;
				             
				}
				
				
				
				
				
	        //doAdd
			
			
			public function do_add(){
				      
				      $data=rfilter($_POST);
					 // print_r($data);
					  if($data){
						    $data['uid']=$this->uid;
							$data['luru']=$this->uid;
							$data['comid']=$this->comid;
							$data['create_time']=time();
							$gid=M("Candidate")->find($data['gid']);
						 
					       $jr_zhiwei=M('Works')->find($gid['gid']);
					      
						  
					 
					         $data['jr_zhiwei']=$jr_zhiwei['Search_posts'];
						    $rs=D("candidate")->add($data);
						  if($rs){
							  
							   
							
							     
								$tichengs=$this->persona;
								$ti='';
								 foreach($tichengs as $k=>$v){
									 
									     $ti.=$v['bili'].",";
									 }
								   
							   $ti=substr($ti,0,strlen($ti)-1); 
							   $data1['cid']=$rs;
							   $data1['ticheng']=$ti;
							    $t1=D("Ticheng")->add($data1);
								if(!$t1){
									   
									    parent::_message('error','提成写入失败');
									
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
				
				
				
				 //modfy action
                                
                                public function modfy(){
                                           parent::_checkPermission();
                                         $id=intval($_REQUEST['id']);
                                         $st=$this->_get('stage');
                                            if($id !=0 ){
                                                  
                                                    $detail=$this->dao->where("id=".$id)->find();
													
													if($detail['source']==0){
													
												    $in=get_resume($detail['resume_id']);
												    $detail['realname']=$in['realname'];
												    $detail['phone']=$in['phone'];
												    $detail['before_job']=$in['last_company'];
												   //$detail['jr_zhiwei']=
													}else if($detail['source']==1){
														
														    $in=get_tlent($detail['resume_id']);
															$detail['realname']=getTruename($detail['resume_id']);
															$detail['phone']=M('User')->where('uid='.$detail['resume_id'])->getField('phone');
															$detail['before_job']=$in['last_company'];
														
														}else if($detail['source']==2){
															
															$in=get_import($detail['resume_id']);
												            $detail['realname']=$in['title'];
												            $detail['phone']=$in['phone'];
												            $detail['before_job']=$in['last_company'];
															
															}
													
                                                 }else{
                                                   $this->ajax==1? exit('err') : parent::_message('error','关键条件',$_SERVER['HTTP_REFERER']);
                                                   } 
                                                 
												 
												
												   if($detail['jr_zhiwei']==''){
													   $detail['jr_zhiwei']=M('Works')->where('id='.$detail['gid'])->getField('Search_posts');
													   }
                                            
                                                  
												   if($st==8){
													    
														$coll_count=M("Collection")->where("cid=".$id)->count();
														
													        if($coll_count >0){
															 
															 }
															 
															 
															 
															 $f=M('Collection')->where("cid=".$id.' and fen=1')->count();  
						 
						                                      if($f==1){
							      
							                                    $detail['fenpei']=1;
							 
							                                } else{
																
																$detail['fenpei']=0;
																}
				  
															 
														  
														  
														  
														   
													   } 
													   
													   
													   
													   
													     if($st==4){
													  
							                                
				  
															 
														  
														  
														  
														   
													   } 
													   
													   
													   
													   
													   
													   
													   
													   
													   
													   
													   
													   
													   
													   
													       
														 
													   
													    
													      $pici_history=json_decode($detail['pici_history']);
														  
														   foreach($pici_history as $k=>$v){
															   
															   $pici_history[$k]=(array)$pici_history[$k];
															   }
															 //  print_r($pici_history);
														  $this->assign('ph',$pici_history);
														  
														     $this->assign('detail',$detail); 
												    
                                                 parent::_tpl('plus/candidate_modfy'.$st);
											 
                                         
                                      
                                   
                                 }
                                 
				 
				 //do_modfy
				 
				  public function do_modfy(){
				 
				     $data=$_POST;
					   
					 
					 if($data['stage']==8 && $data['stages']==1){
						  
						  unset($data['ys_time']);
						  unset($data['fp_jine']);
						 
						 }
					 
					 $id=intval($_GET['id']);
					 
					 
					 
					  if($_POST['mianshi_time']!=''){
					     $data['mianshi_time'] = date(strtotime($data['mianshi_time']));   
					   }
					 
					
					     $data['yfk_time'] = date(strtotime($data['yfk_time']));   
					     $data['sjdz_time']= $data['sjdz_time'] =="" ? 0 : date(strtotime($data['sjdz_time']));  
					
					 
	                      $data['yfk_jine']  = $data['yfk_jine'];   
					      $data['sjdz_jine'] = $data['sjdz_jine'];  
						  
						  
						  
						     if($data['stage'] == 6 || $data['stage'] == 7 ){
								 
                                    //exit( $_POST['sjrz_time']);
								   $data['yrz_time']   =  date(strtotime($_POST['yrz_time']));
								   $data['sjrz_time']  =  date(strtotime($_POST['sjrz_time']));
					       }
						
						  
					 
					            $data['update_time']=time();
								
								$sved=$this->dao->where('id='.$id)->find();
								
					 
					    if($data && $id!=0){
							
							
							
							
						    
						     $rs=M("Candidate")->where("id=".$id)->save($data);
							 
							 
						/*	 if($data['stage']==9){
								 
								 
								  if($count==0){
									  
									   
						            R('Commission/__set_commission',array($id));
						  	  
					}
								 
								 
								 }*/
							   
							 
							 
							 
						  if($rs){ 
						  
						      
						  
							      if($data['stage']==8 && $data['stages']==2){
									  
									 // parent::_checkPermission('Collection_modfy');
									     
										     //exit($_POST['ys_time']);
									 
									        $shujv=array('time'=>$_POST['ys_time'],'jine'=>$_POST['fp_jine'],'realname'=>$_POST['realname']); 
											$jine=explode(',',substr($_POST['fp_jine'],0,strlen($_POST['fp_jine'])-1));
											$time=explode(',',substr($_POST['ys_time'],0,strlen($_POST['ys_time'])-1));
											$jin=0;
											foreach($jine as $k=>$v){
												    
													$sv[]=array('jine'=>$v,'time'=>$time[$k]);
												    $jin+=$v;
												  }
												  
											 $sv=json_encode($sv);	  
											 $datas['pici_history']=$sv;
											 $datas['yfk_jine']=$jin;
											 $data['stage']=9;
											 $data['realname']=$_POST['realname'];
											 $datas['yfk']=date(strtotime($time[0]));
											 $rs=$this->dao->where("id=".$id)->save($datas);
								             $sved=$sved['pici_history'];
								              
											  
								              //如果批次金额发生了变化则更新否则不更新
											  if($sv!=$sved){
												  
												  
												  
								                   $this->set_fenpi($id,$shujv,2);
												   
												   
											  }
											 
											 
											 
											 
											 
								  
								  }
								  
								   if($data['stage']==8 && $data['stages']==1){
									   
									   // parent::_checkPermission('Collection_modfy');
									        
											/*about  先把之际的历史记录清空，
											  然后对比付款已经是否被一致，如果以则不更新收款表
											  否则重新写入收款表。  
											*/
											$datas="";
											$datas['pici_history']="";
											$data['stage']=9;
											//$datas['yfk_time']=strtotime($_POST['yfk_time']);
									        $rs=$this->dao->where("id=".$id)->save($datas);
											
											
									        $shujv=array('time'=>$_POST['yfk_time'],'jine'=>$_POST['yfk_jine'],'realname'=>$_POST['realname']); 
								            $sved=$sved['yfk_jine']; 
											 
											
											   
								                $this->set_fenpi($id,$shujv,1);
											
								  }
								  
								  
								  
								  
							$data['ajax']==1? exit('ok') : parent::_message('success','修改成功',$_SERVER['HTTP_REFERER']);
							//如果状态有阶段付款 克隆一条数据到分批;
							 
							   
							   }
						   
						  }else{
							 
							    $data['ajax']==1? exit('err') : parent::_message('error','修改失败',$_SERVER['HTTP_REFERER']);
							 
							 }
					 
				
				
				}
				
				
			// delete action
			
			  public function delete(){
                                 
                                         parent::_checkPermission();
                                         $id=intval($_GET['id']);
                                
                                         if($id!=0){
                                                     $data['id']=$id;
                                                     $data['display']=0;
													 
													 //此处判断是否是第一次
													 
													 
													 $st=$this->dao->where('id='.$id)->getField('stage');
													 
													 if($st<2){
													 $rs=$this->dao->where("id=".$id)->delete();	 
														 }else{
													    
                                                     $rs=$this->dao->where("id=".$id)->save($data);
														 }
                                                  if($rs){
                                                           
                                                   
                                                             
                                                          $data['ajax']==1? exit('ok') : parent::_message('success','删除成功',$_SERVER['HTTP_REFERER'].'#'.$_GET['maodian'],$ajax);
                                                           
                                                           }
                                                   
                                                  }else{
                                                         
                                                            $data['ajax']==1? exit('err') : parent::_message('error','删除失败',$_SERVER['HTTP_REFERER']);
                                                         
                                                         }
                                         
                                
                                
                                }
                                
                                
				
				
				
				//批量操作
				
				public function doCommand(){
		           
				   
				  parent::_checkPermission();
                  
                      if(getMethod() == 'get'){
                       $operate = trim($_GET['sid']);
                       }elseif(getMethod() == 'post'){
                       $operate = trim($_POST['sid']);
                       }else{
                       parent::_message('error', '只支持POST,GET数据');
                       }
                      
                      if($operate=='100'){
                                $ids= implode(',',$_POST['id']);
								
								
								//设置为回收站
								 //$rs=$this->dao->where("id in ($ids)")->delete();
								 $data['display']='0';
								 $rs=$this->dao->where("id in ($ids)")->save($data);
								 
								 
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
										
										
								
                        }elseif($operate && $operate <14){
							 $ids= implode(',',$_POST['id']);
							 $data['stage']=$operate;
							 $data['stages']=1;
							 $data['update_time']=time();
							 $rs=$this->dao->where("id in ($ids)")->save($data);
							 if($rs){
								 
								   parent::_message('success', '更新成功',$_SERVER['HTTP_REFERER'].'#'.$_REQUEST['stage_cn'],$ajax=true);
								 }else{
									  parent::_message('error', '更新失败');
									 } 
									 
									 
					
									 
							
							}else{
								
								 parent::_message('error', '操作类型错误'.$operate);
								
								}
	       }
				
				
				
				public function test(){
					    
						//$vv=$this->dao->scope()->select();
						 $this->dao->scope()->getTopUser();
					    echo $this->dao->getLastSql(); 
					
					}
	
	       
		   
		   
		   
		   
		   
		   
		         public function set_fenpi($id,$shujv,$stages){
			                  /** 
							  
							   写入收款详情
							       
								   
								   
							  ***/
							      
							     
							      
			                     $Collection=M("Collection");
								 $Candidate=M('Candidate');
								 $cd=$Candidate->where("id=".$id)->find();
								 //如果有数据了那就删除重新来
								 $ct=$Collection->where('cid='.$id)->count();
								 if($ct > 0){
									   
										$del=$Collection->where('cid='.$id)->delete();
									  
									 }
									 
									 
								 
								 
								 $data['cid']=$id; 
								 $data['create_time']=time();
								 $data['c_type']=$stages;
								 //$cm=$this->dao->find($id); 
								 $data['resume_id']=$cd['resume_id'];
								 $data['gid']=$cd['gid'];
								 $data['client_id']=$cd['cid'];//补充客户ID
								 $data['comid']=$this->comid;
								 $data['realname']=$shujv['realname'];
								 $data['department_id']=$cd['department_id'];
								// $data['group_id']=$cd['group_id'];
								 
								 
						         if($stages==1){
								   
								    
									 $data['yfk_time']=date(strtotime($shujv['time']));
								     $data['yfk_jine']=$shujv['jine'];  
									 $data['c_type']=1;
									
									
									 $rs=$Collection->add($data);
									
										   
										   if(!$rs){
											      
													exit('保存1出错'.$Collection->getLastSql()); 
											     
											   }
									 
								   }
								   
								   
								   if($stages==2){
								   
								    
									 $ys_time=explode(',',substr($shujv['time'],0,strlen($shujv['ys_time'])-1));
									 $fp_jine=explode(',',substr($shujv['jine'],0,strlen($shujv['jine'])-1));
									 //exit(print_r($ys_time));
									 foreach( $ys_time as $k=>$v){
									    	 
										   $data['yfk_time']=date(strtotime($v));     
										   $data['yfk_jine']=$fp_jine[$k];
										   $data['pici']    =$k+1;
										   $data['c_type']=2;
										   $data['realname']=$shujv['realname'];
										   $data['zongpi']=count($ys_time);
										   $rs =$Collection->add($data);
										   
										   if(!$rs){
											      
													exit('保存2出错'.$Collection->getLastSql()); 
											     
											   }
;										 }
									 
									 
								   }
								   
                            				 
			   
			   }
		   
		   
		   //获取进展最快的那个候选人的阶段
		     
			    //回收站相关操作
				
				  
				  
				//读取回收站
				
				
				public function  recycle(){
					                parent::_checkPermission();
					                 
									 
									 
									 
									 
									 
									 
					                $ajax=intval($this->_get('ajax'));
									$cid=intval($_GET['cid']);
									$stage_id=intval($_GET['stage']);
									$gid=intval($_GET['gid']);
									$cid= intval($_GET['cid']);
									$uid=$_GET['uid'];
									$keyword=$_GET['keyword'];
									$where="1=1";
									$cid && $where.=" and cid=".$cid;
									$gid && $where.=" and gid=".$gid;
									$stage_id && $where.=" and stage=".$stage_id;
									$keyword && $where.=" and realname like '%".$keyword."%'";
									
									if($uid){
										  
										      $ids=M("Nteam")->Field('uid,cid')->where('uid='.$uid)->select();
										       foreach($ids as $k=>$v){
											     $idx[]=$v['cid'];
											  }
											  $idy=implode(',',$idx);
											  
											  $where.=" and id in($idy)";
										}
									
									
									$where.=" and display=0 and comid=".$this->comid;
									//$condition['_logoc']='OR';
									//$condition['gid']=array('like',"%".$keyword."%");
									$condition = !empty($where) ? $condition : '' ;
									$pageCount = $this->dao->where($where)->count();
									$listRows = empty($listRows) ? 10 : $listRows;
									$orderd = empty($orders) ? 'id DESC' : $orders;
									$paged = new page($pageCount, $listRows);
									$dt = $this->dao->Where($where)->Order($orderd)->Limit($paged->firstRow.','.$paged->listRows)->select();                  
							       //echo $this->dao->getLastSql();
							  
							 foreach($dt as $k=>$v){
								 
								     $uids="";
								     $tid="";
								     $gong=M("Works")->where('id='.$dt[$k]['gid'])->find();
								     $dt[$k]['gongdan']=$gong['custom'];
									 $dt[$k]['zhiwei']=$gong['Search_posts'];
									 $dt[$k]['custom_id']=$gong['cid'];
									 $dt[$k]['gongdan_id']=$gong['id'];
									 
									  if($v['source']==0){
											      
													  $in=get_resume($v['resume_id']);
													  $dt[$k]['realname']=$in['realname'];
													  $dt[$k]['before_job']=$in['last_company'];
													  $dt[$k]['zhiwei']=$in['last_post'];
													}
													else if($v['source']==1){
														
													          $in=get_tlent($v['resume_id']);
													          $dt[$k]['realname']=getTruename($v['resume_id']);
													          $dt[$k]['before_job']=$in['last_company'];
													          $dt[$k]['zhiwei']=$in['post_cn'];
														}else if($v['source']==2){
															
														 $in=get_import($v['resume_id']);
														 
													           $dt[$k]['realname']=$in['title'];
														       $dt[$k]['before_job']=$in['last_company'];
													           $dt[$k]['zhiwei']=$in['post'];
														}
									 
									 
									 $tid=M("Nteam")->field('id,cid,uid,persona')->where('cid='.$v['id'])->select();
									 foreach ($tid as $b=>$c){
										     $uids[]=array('uid'=>getTruename($c['uid']),'persona'=>parent::get_persona($c['persona']));
										  }
									 
								      $dt[$k]['tuan']=$uids;
								      
								 } 
							 // print_r( $dataContentList);
							 //decho $this->dao->getLastSql();
							 $ajax==0 ? $pageContentBar = $paged->show() : $pageContentBar = $paged->show_ajax();
							 $this->assign('getList', $dt);
                             $this->assign('pageBar', $pageContentBar);
							 
							 
							 $this->display();
			 
					
					
					
					
					
					}
				
				
				
				  
				
				
				
				//恢复回收站
			     public function  recover(){
					        parent::_checkPermission();
						  parent::__recover($this->dao,$this->id);
					 
				}
				
				//强制删除
				
				 public function  hard_delete(){
					        parent::_checkPermission();
							
							  $rs=D('Nteam')->where('cid='.$this->id)->delete();
							  
						      $rs1=$this->dao->where('id='.$this->id)->delete();
							  
							  if($rs1){
								  
								   parent::_message('success', '数据删除成功');
								  }else{
									  parent::_message('error', '数据删除失败');
									  }
					 
					 }
		      
			  
			  
			   //read client list
			   public function  readClist(){
				   
				         $list=M('Client')->Field('companyname,id,uid,comid')->where('comid='.$this->comid)->select();
				            foreach($list as $k=>$v){
							 
							    $list[$k]['pinyin']=Pinyin($v['companyname']);
							    $list[$k]['realname']=$v['companyname'];
							 }
							 
							 
							 $this->assign('cl',json_encode($list));
							 
				   }
			  
	
	
	
	public function doDel(){
		 parent::_checkPermission();
                  
                      if(getMethod() == 'get'){
                       $operate = trim($_GET['sid']);
                       }elseif(getMethod() == 'post'){
                       $operate = trim($_POST['sid']);
                       }else{
                       parent::_message('error', '只支持POST,GET数据');
                       }
                      
                     
                                $ids= implode(',',$_POST['id']);
								
								
								//设置为回收站
								 //$rs=$this->dao->where("id in ($ids)")->delete();
								 
								 $rs=$this->dao->where("id in ($ids)")->delete();
								 //删除收款
								 
								 $rs1=M('Collection')->where("cid in ($ids)")->delete();
								 $rs2=M('Commission')->where("cid in ($ids)")->delete();
								 
								 
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
										
										
								
                        
									 
							
							
	       }
				
				
				
				
	
	
	
	
	}

?>
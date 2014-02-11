<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-4-9
 * Time: PM1:30
 * To change this template use File | Settings | File Templates.
 * className:Talent poor
 * dever:yige
 * ProjectName:jobmedia OA.
 */
 
 class TalentAction extends GlAction{
	 
	       
		   //initialize
		   
		   public function _initialize(){
			        
					   parent::_initialize();
					   parent::Checklogin();
			   
			   }
			   
			 //index
			 
			 public function index(){
				 
				          //  parent::set_category_job();
							     
								$gid=$_GET['gid'];
								$area_cn =$_GET['area_cn'];
								$area_cn && $condition['area_cn']=array('like','%'.$area_cn.'%');
								
								$last_company=$_GET['last_company'];
								$last_company && $condition['last_company']=array('like','%'.$last_company.'%');         
								        $post = $_GET['post'];
								$post && $condition['post']=array('eq',$post);
								
								$keyword=$_GET['keyword'];
								$keyword && $condition['realname']=array('like','%'.$keyword.'%');
								
								$condition['comid']=array('eq',$this->comid);
								$sex=$_GET['sex'];
								$sex && $condition['sex']=array('eq',$sex);
								$payment=$_GET['payment'];
								
								$payment && $condition['payment']=array('egt',$payment);
								
								$payment1=$_GET['payment1'];
								$payment1 && $condition['payment1']=array('egt',$payment1);
								
								
								$work1=$_GET['work1'];
								$work2=$_GET['work2'];
								$work1 && $condition['workexp']=array(array('egt',$work1),array('elt',$work2));                 $education=$_GET['education'];
								$education && $condition['education']=array('eq',$education);
								$where="comid = $this->comid";
								if($area_cn){
									  $where.=" and area_cn like '%$area_cn%'";
									}
									
								if($last_company){
									  
									   $where.=" and last_company like '%$last_company%'";
									
									}	
									
								if($post){
									
									 $where.=" and post ='$post'";
									  
									}	
									
								if($sex){
									
									 $where.=" and sex ='$sex'";
									}	
									
									
									if($payment && $payment1){
										
										$where.=" and payment > $payment  and payment1 < $payment1";
										}
										
									if($education){
										   
										   $where.=" and education = $education";
										  
										}	
										
								    if($work1 && $work2){
										
										  $where.=" and workexp > $work1 and  workexp < $work2 ";
										}	
									
									 $where1=$where;	
								     	if($keyword){
										
										  $where.=" and realname like '%$keyword%' or $where1 and skills like '%$keyword%' or $where1 and last_post like '%$keyword%'";
										
										}
										
										
									
										
								
								//print_r($condition);
								
								
								
								
								
								//$condition['realname']=array('neq','');
								
								if($gid){

									   $ids=M('Candidate')->Field('resume_id')->where('gid='.$gid)->select();  
									   if($ids){
									   $id2=imp($ids,',','resume_id');
									  // print_r($ids);
									 
									  $conditions['id']=array('not in',$id2); 
									  }
									}
								
								//$condition = !empty($conditions) ? $conditions : '' ;
								
								
								$pageCount = $this->dao->where($where)->count();
								
								
								
								$listRows = empty($listRows) ? 8 : $listRows;
								$orderd = empty($orders) ? 'id DESC' : $orders;
								$paged = new page($pageCount, $listRows);
								$List =$this->dao->Where($where)
								->Order($orderd)->Limit($paged->firstRow.','.$paged->listRows)
								->select();   
								
								
								foreach($List as $k=>$v){
									   $List[$k]['cz']=M('Candidate')->where('resume_id='.$v['id'].' and source=0')->count();                                 }
								//echo $this->dao->getlastSql();
								 
								if($this->ajax==1){  
								$pageBar = $paged->show_ajax();
								}else{
								$pageBar = $paged->show();	
									}
								 $this->assign('list',$List);
								 $this->assign('pageBar',$pageBar);	
							     parent::_tpl('index_small');
				                 
				 }  
	 
	 
	           public function add_c(){
				      
					          
						if(!$_POST['gid']){
							  
							  parent::_message('error','非法操作了');
							
							}
							

							
						$data=$_POST;	
				        $gids=explode(',',$_POST['gid']);
						
						
						    foreach($gids as $k=>$v){
						      $s=M('Candidate')->where('gid='.$v.' and resume_id='.$_POST['resume_id'].' and source='.$_POST['source'])->count();  	  
							      //  exit(M('Candidate')->getLastSql());
							     // parent::_message('error',$s);           
							     if($s==0){
								      
									  $data['gid']=$v;
									  $data['cid']=M('Works')->where('id='.$v)->getField('cid');
								      $data['comid']=$this->comid;
									  $data['uid']=$this->uid;
									  $data['stage']=1;
									  $data['realname']=$_POST['realname'];
									  $data['source']=$_POST['source'];
									  $data['resume_id']=$_POST['resume_id'];
									  $data['department']=$this->department;
									  $data['stages']=1;
									   $data['last_company']=$_POST['last_company'];
									  $data['jr_zhiwei']=M('Works')->where('id='.$v)->getField('Search_posts');
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
							   
							   
							   
							 //欠缺回滚机制
							    
							
							    $data2['persona']=0;
							    $data2['uid']=$this->uid;
							    $data2['cid']=$rs;
								$data2['create_time']=time();
							    $rs2=D('Nteam')->add($data2);
								
							  
							 	
							 if($rs2){
							    
							    }else{
								  
								  
								   parent::_message('error','添加失败');
								   
								   
								  }
								  
								  
							   
							   }
							   
							   
							   
						   
						  }else{
							 
							
							
							 }
									  
									  
									  
								  
						   }
						   
						   parent::_message('success',"操作完成"); 
				   
				   }
				   
				   
				   //resume to candidate
	 
	                   public function add_wc(){
					 
					    if(!$_POST['cid']){
							  
							  parent::_message('error','非法操作了');
							
							}
						$data=$_POST;	
				        $gids=explode(',',$_POST['cid']); 
						$realname=explode(',',$_POST['realname']); 
						
						
						foreach($gids as $k=>$v){
							
							
							
						      $s=M('Candidate')->where('resume_id='.$v.' and gid='.$_POST['gid'].' and source='.$_POST['source'])->count();  
							  
							 // echo M('Candidate')->getLastSql();
							  	
							// parent::_message('error',$s);           
							     if($s==0){
								      
									  $data['resume_id']=$v;
									  $data['cid']=M('Works')->where('id='.$_POST['gid'])->getField('cid');
								      $data['comid']=$this->comid;
									  $data['uid']=$this->uid;
									  $data['stage']=1;
									  $data['realname']=$realname[$k];
									  $data['stages']=1;
									  $data['department']=$this->department;
									  $data['source']=$_POST['source'];
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
							   
							   
							   
							     // write a data in inform 
							    
							  $touid=M('Team')->where('gid='.$_POST['gid'].' and uid <> '.$this->uid)->select(); 
							  $in['touid']=imp($touid,',',$field='uid');
							  $in['gid']=$_POST['gid'];
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
							    $data2['persona']=0;
							    $data2['uid']=$this->uid;
							    $data2['cid']=$rs;
								$data2['create_time']=time();
							    $rs2=D('Nteam')->add($data2);
								// exit(print_r($data2).$rs2);
							 	
							 if($rs2){
							    
							  }else{
								   parent::_message('error','添加失败');
								  }
							   
							   }
						   
						  }else{
							 
							  //parent::_message('error','添加失败');
							 
							 }
							  
						   }
						   
						parent::_message('success','操作完成');   
					     
					 
					 }
	 
	          
			  
			    //talent add
			     public function add(){
					 
				          $this->display();	 
					 
					 }
					 
					 
			  //talent add
			     public function do_add(){
					 
					       $act=$_GET['act'];
					      $data=$_POST;
						  if($data['realname'] == ""){
							    parent::_message('error','非法提交数据');    
							  }
						
						  $dao=$this->dao->create();
						  
						   if($dao){  
						         
							     $this->dao->create_time=time();
								 $this->dao->add_uid=$this->uid;
								 $this->dao->comid=$this->comid;
							                          $rs=$this->dao->add();
												 
												 if($rs){
													     
														 //写一条工作经验进去
														 
														 $da['title']=$data['last_company'];
														 $da['post']=$data['last_post'];
														 
														 $da['resume_id']=$rs;
														 $da['add_uid']=$this->uid;
														 $rs1=D('Talent_work')->add($da);
														  
														    if(!$rs1){
																 
																 echo  "插入工作经验失败";
																 
																}
														 
														 /* if($act=='import'){
										     
															 //add candidate
															 $dt['gid']=$_GET['gid'];
															 $dt['comid']=$this->comid;
															 $dt['uid']=$this->uid;
															 $dt['stage']=1;
															 $dt['stages']=1;
															 $dt['resume_id']=$rs;
															 $dt['create_time']=time();
															 $rs2=M('Candidate')->add($dt);
															 
															  if(!$rs2){
																  
																	parent::_message('error','新增失败');
																	
																 }
																 
																 else{
																	 
																	   R('Works/set_c',array($rs2));
																	  
																	   exit();
																	  
																	 }
										         
										                 }*/
														 
														 
														    
															
															
															  parent::_message('success','添加成功','/Talent/detail/id/'.$rs);
														     }else{
														 
														           parent::_message('error','添加失败');
														 }
								       
							   
							   }
						  
				       
					 
					 }		 
	 
	          
			  //talent add_edu
			  
	         public function add_edu(){
				      
					   $this->display();
				 
				 
				 }
				 
				 
				 
				 public function edit(){
					          
					             parent::checkID();
								 $dt=$this->dao->where('id='.$this->id.' and comid='.$this->comid)->find();
								          $this->assign('dt',$dt);
								           $this->display();
									
									
								
					 
					 }
			
				 public function do_edit(){
					 
					 
					 
					            $data=$_POST;
						            
							                  $data['id']=$_GET['id'];
								 
						
							;
							                          $rs=$this->dao->where('id='.$data['id'])->save($data);
												 
												 if($rs){
													     
														 parent::_message('success','编辑成功','/Talent/detail/id/'.$data['id']);
														 
													    
													 }else{
														 
														    
											 parent::_message('error','编辑失败,原因可能您没有做任何更改');

														   
														 }
								       
							   
							  
					 
					 
					 }
				 
				 public function detail(){
					 
					      parent::CheckID();
						  
						  $dt=$this->dao->where('comid='.$this->comid.' and id='.$this->id)->find();
						  $dt['edu']=M('Talent_edu')->where('resume_id='.$dt['id'])->order('id asc')->select();
						  $dt['work']=M('Talent_work')->where('resume_id='.$dt['id'])->order('id asc')->select();
						  if(!$dt){
							     
								 parent::_message('error','简历不存在');
							  
							  } 
						   
					      $this->assign('dt',$dt);
						  if($dt['add_uid']==$this->uid || $this->pid==0 ){
							      
								 $this->display();
								  
							  }else{
								  
								   $this->display('details'); 
						  
							  }
					 }
					 
					 
					 public function delete(){
						 
						     parent::checkID();
							 
							 $rs=$this->dao->where('id='.$this->id)->delete();
						        
								if($rs){
									    
										$rs1=M('Talent_edu')->where('id='.$this->id)->delete();
										$rs1=M('Talent_work')->where('id='.$this->id)->delete();
										
										parent::_message('success','删除成功');
									
									}else{
										
										parent::_message('error','删除失败');
										
										}
						              
						 }
	 
	                   
					   public function import(){
						   
						             $this->display();       
										 
						   
						   
						   }
						   
					    
						
						
					public  function do_import(){
						     
							 $data=$_POST;
						     include('./includes/files.class.php');   
							  if(!$_FILES){
								  parent::_message('error','没有上传文件');
								  }
							  
						     $run=new files();
							 
							$is= $run->upload('files',$_FILES['docs']);							 
                           	
							if($is['db_path']){
								 //开始上传操作
								 $ty=$is['type'];
								 $fl=$is['file_url'];
								$pdfpath = '/home/wwwroot/app.jobme.cn/'; 
								$pdfpath = '/home/wwwroot/app.jobme.cn/';
								$swfpath = '/home/wwwroot/app.jobme.cn/';
								
								              
											  
											   if (file_exists($is['file_url'])){
														  //执行转换
														 
														  if($ty=='pdf'){ //PDF 转SWF
														  $pdf = $fl;
														  $swf = str_replace('pdf','swf',$pdf);
														  exec('pdf2swf -o '.$swfpath.$swf.' -T -z -t -f '.$pdfpath.$pdf.' -s languagedir=/usr/share/xpdf/xpdf-chinese-simplified -s flashversion=9');
														  $path2 = $pdfpath.$pdf;
														  $path3 = $swfpath.$swf;
														  }else{ //DOC 转 PDF
														  $doc = $fl;
														  $format = explode('.',$fl);
														  $formatName = $format[0].'.pdf';
														  $command = 'java -jar /usr/local/wenku/jodconverter-2.2.2/lib/jodconverter-cli-2.2.2.jar '.$docpath.$doc.' '.$pdfpath.$formatName;
														  exec($command);
														  $path1 = $docpath.$doc;
														  $path2 = $pdfpath.$formatName;
														  
														  if(file_exists( $pdfpath.$formatName)){
														  $pdf = $formatName;
														  $swf = str_replace('pdf','swf',$pdf);
														  $swfcommand = 'pdf2swf -o '.$swfpath.$swf.' -T -z -t -f '.$pdfpath.$pdf.' -s languagedir=/usr/share/xpdf/xpdf-chinese-simplified -s flashversion=9';
														  exec($swfcommand);
														  $path3 = $swfpath.$swf;
														  
														  if($path3){
															  
															   //插入数据库
															   $data['comid']=$this->comid;
															   $data['department']=$this->department;
															   $data['create_time']=time();
															   $data['url']=substr($path3,26,strlen($path3));
															   $rs=D('Talent_import')->add($data);
															   if($rs){
															    parent::_message('success','上传成功','/Talent/imp');
															  }else{
																  
																   parent::_message('error','上传失败');
																  
																  }
														  
														  
														  }
														  }
														  }
											   }


							     	
								
								} 					  
												  
			                 
						   
						}	   
					   
					   
					   
					   public function imp(){
						       
							   
							     $glist=M('Talent_import')->where('comid='.$this->comid)->select();
								 
								 $this->assign('getList',$glist);
								 $this->display();
						   
						   
						   }
					   
					   
					   
					   public function idtail(){
						   
						   
						       parent::CheckID();
							   
							   $dt=M('Talent_import')->where('id='.$this->id)->find();
							   
							   $this->assign('dt',$dt);
							   $this->display();
						   
						   }
					   
					   
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					   public function add_d(){
				      
					          
						if(!$_POST['gid']){
							  
							  parent::_message('error','非法操作了');
							
							}
						$data=$_POST;	
				        $gids=explode(',',$_POST['gid']);
						
						    foreach($gids as $k=>$v){
						      $s=M('Candidate')->where('gid='.$v.' and resume_id="'.$_POST['resume_id'].'"')->count();  	
							// parent::_message('error',$s);           
							     if($s==0){
								      
									  $data['gid']=$v;
									  $data['cid']=M('Works')->where('id='.$v)->getField('cid');
								      $data['comid']=$this->comid;
									  $data['uid']=$this->uid;
									  $data['stage']=1;
									  $data['type']=3;
									  $data['resume_id']=$_POST['resume_id'];
									  $data['stages']=1;
									  $data['jr_zhiwei']=M('Works')->where('id='.$v)->getField('Search_posts');
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
						   
						  }else{
							 
							  //parent::_message('error','添加失败');
							 
							 }
									  
									  
									  
								  
						   }
						   
						parent::_message('success','操作完成');   
				   
				   }
				    
					 
					 
				##################################
				#                                #
				# 已经再下载的简历                  #
				#                                #
				##################################	 
					 
				public function myDown(){
					
					       
						   $dlist=M('Resume_down')->where('comid='.$this->comid)->select();
						   
						   
						   foreach($dlist as $k=>$v){
							   
							       $arr=M('User')->field('realname,uid,last_company,area_cn,post_cn')->where('uid='.$v['resume_id'])->find();
							      foreach($arr as $n=>$b){
									  
									    $dlist[$k][$n]=$b;
 									      
									  }
								  
								  
								  
							   }
					 
					
					  $this->assign('getList',$dlist);
					  $this->display(); 
					}
					 
					  
					
					 
					 
					 
					 
			    ##################################
				#                                
				# 删除下载的简历               
				#                               
				##################################	 
					 
					 
			    public  function down_delete(){
					
					       
						   parent::checkID($this->id);
						   
						   $rs=M('Resume_down')->where('id='.$this->id)->delete();
						   if($rs){
							     
								 parent::_message('success','删除成功','/Talent/myDown');
							   
							   }else{
								  parent::_message('eroor','删除失败');  
								   
								   }
						 
						
					}		 
					 
					 
					 
					 
					 
					   
	 }
<?php
/**
 * Created by Adobe DW cs6.
 * User: Administrator
 * Date: 13-5-17
 * Time: AM 11:02
 * To change this template use File | Settings | File Templates.
 * className:User_company
 * dever:yige
 * ProjectName:jobmedia OA.
 */
 
 class User_groupAction extends GlAction{
	 
	 
	          public function _initialize(){
				      
					  parent::_initialize();
					  
					  if($this->pid!=0){
						     
							 parent::_message('error','非法操作');
						  
						  }
					  
					 $company=M("User_company")->where('uid='.$this->uid)->find();
					 
					 
					     if($company['examine'] != 1){
						 
						// parent::_message('error','您的的资料尚未通过审核，暂时不能访问');
						 
						 }
					 
					 
				     $this->assign("company",$company['companyname']);
					 $dp=$this->dao->field('id,title')->where('fid='.$this->uid)->select();
					 foreach($dp as $k=>$v){
						   
						   $narray[$v['id']]=$v['title'];
						   
						 }
						 
						$this->assign('department',$narray);
				  }
	 
	           
			   
			  public function index(){
				   
				      
						$list=$this->dao->where('fid='.$this->uid.' and level=0 ')->select();
						$list_count=count($list);
						
						$list1=$this->dao->where('fid='.$this->uid.' and level=1 ')->select();
						
						$list1_count=count($list1);
						//print_r($list);
				       // $list=getCategory2($list); 
						
						// print_r($list);
						
						$pid=$this->dao->where('fid='.$this->uid.' and level < 1')->select();
						
					    $pid=getCategory2($pid);
					    
						
						
						$this->assign('pid',$pid);
						$this->assign('list1_count',$list1_count);
						$this->assign('list_count',$list_count);
						$this->assign('list',$list);
						$this->assign('list1',$list1);
						
				        parent::_tpl('ajax/index');
				   
				   }
	           
			   //add
			   
			   public function add(){
				   
				         $data=$_POST;
						 if($data['title']==""){
							   
							   parent::_message('error','请填写部门名称');
							 
						  }
						  
						  $dao=$this->dao->create();
						  
						  if($dao){
							  
                                if($data['pid']>0){							  
							    $level=$this->dao->where('id='.$data['pid'])->getField('level');
								
								$this->dao->level=$level+1;
								}
								
							    $this->dao->fid=$this->uid;
								
								$this->create_time=time();
							    $rs=$this->dao->add();
								
								if($rs){
									   
									   parent::_message('success','添加成功'); 
									
									}
							  }else{
								     
									 $dao->getError();
								  
								  }
							 
				   }
				   
				   //edit
				   
				   public function edit(){
					         
							 //parent::CheckID();
							 $pid=$this->dao->where('fid='.$this->uid.' and level < 1')->select();
						
					    $pid=getCategory2($pid);
					    
						
						
						
							 $dt=$this->dao->where('id='.$this->id.' and fid='.$this->uid)->find();
							 $this->assign('dt',$dt);
							 $this->assign('pid',$pid);
					         parent::_tpl('ajax/edit');
					   }
				   
				   //doEdit
				   
				   public function doEdit(){
					   
					       $data=$_POST;
						   
						   $dao=$this->dao->create();
						   
						   if($dao){
							   
							       $rs=$this->dao->where('id='.$data['id'].' and fid='.$this->uid)->save();
							       
								   if($rs){
									     
										 parent::_message("success",'编辑完成');
									   
									   }else{
										     
											 parent::_message('error','编辑失败,原因可能您没有做任何更改');
										   
										   }
							   }else{
								     
									 $dao->getError();
								   
								   }
					   
					   }
				   
				   public function delete(){
					   
					        $data=$_POST;
					        $del=$this->dao->where('id='.$data['id'].' and fid='.$this->uid)->delete();
							if($del){  
							    //删除用户
								 
								 $groupids=$this->dao->Field('id')->where('pid='.$data['id'].' and id='.$data['id'])->select();                        
								 $ids=imp($groupids,',','id');
								 
								 $rs1=M('User')->where('uid in ('.$ids.')')->delete();
								 //这里是需要优化的需要存储过程了
								   
								   parent::_message('success','删除成功');
								
								}else{
									  
									  parent::_message('error','删除失败');
									 
									}
					   
					    }
						
						
						//add_user
						
						public function add_user(){
							
							    
								$pid=$this->dao->where('fid='.$this->uid.' and level < 4')->select();
						
					             $pid=getCategory2($pid);
					    
						
						
					      	$this->assign('pid',$pid);
							   parent::_tpl("ajax/add_user");
							
							
							}
							
							
							
							
							
							
							
							//do_add_user
							
							public function do_add_user(){
								     
								   
								   	 
									 
								   $data=$_POST;
								   
								      if(!$data['username']){
									      
										  parent::_message("error",'请填写用户名');
									       
									   }
									   
									   if(!$data['password']){
									      
										  parent::_message("error",'请输入密码');
									       
									   }
									   
									   
									   if(!$data['email']){
									      
										  parent::_message("error",'请输入Email');
									       
									   }
									   
									   
									   
									   
									   
									   $d=D('User');
									   $dao=D('User')->create();
									   
								    
									  if($dao){
							             
										     $d->status=0;
											 $d->step=1;
											 $d->create_time=time(); 
											 $d->regip=get_client_ip();
											 $nums=base64_encode(md5($data['username'].rand(0,999999).time()));
											 $d->activate=$nums;
											 $d->password=sha1($data['password']);
											 $d->pid=$this->uid;
											 $d->role_id=3;
										
									   
                                             $rs=D('User')->add();  
								
							
									   
									   
									   
									    if($rs){
										//send an email to this emialaddrs
										$to=$data['email'];
										$name='Jobme';
										$subject="jobme账号激活邮件";
										$url="<a href='http://".$_SERVER['HTTP_HOST']."/Login/activate/uid/".$rs."/numbs/".$nums."'>点击激活</a>";         $body="您的用户名：<b>".$data['username']."</b>密码：<b>".$data['password']."</b>";
										$body.="这是我们给你发送的一封激活账号的邮件请点击下面链接激活邮箱<br>".$url;
										$send=send_email($to,$subject,$body,$charset='UTF-8', $attachment = null);
										 
										 if($send==0){
											   $d->where('uid='.$rs)->delete();
											   
											  parent::_message('error','系统异常,邮件地址有问题');
											 
											 }else{
												   
													
											   parent::_message('success','添加成功'); 
											
											 }
												
										}else{
											
											
											}
												
										}else{
											 
											 $dao->getError();
										  
										  }
										}
							
							
							
							
							
							//user edit
							
							public function user_edit(){
								          
										  parent::checkID();
										  $pid=$this->dao->where('fid='.$this->uid.' and level < 4')->select();
						                  $pid=getCategory2($pid);
					                      $dt=D('User')->where('uid='.$this->id.' and pid='.$this->uid)->find();
										  $this->assign('pid',$pid);
										  $this->assign('dt',$dt);
										  parent::_tpl('ajax/user_edit');
										  
										  
										  
								}
							//do_user_edit
							
							public function do_user_edit(){
								    
									parent::CheckID();
									$data=$_POST;
									if($data['password']==""){
										  
										  unset($data['password']);
										}else{
											
											$data['password']=sha1($data['password']);
											
											}
											
									$rs=D('User')->where('uid='.$this->id.' and pid='.$this->uid)->save($data);
									if($rs){
										     
											parent::_message('success','编辑成功');
											
										}else{
											 
											 parent::_message('error','编辑失败,原因可能您没有做任何更改');

                                              											
											}								
								}
							
							
							
							public function delete_user(){
								
								       $data=$_POST;
									   
									   $rs=D('User')->where('uid='.$data['id'].' and pid ='.$this->uid)->delete();
									    if($rs){
											   
											   parent::_message('success','删除成功');
											 
											}else{
												 parent::_message('error','删除失败');
												
												}
									   
								
								}
							
							
							
							public function user_list(){
								     
									 $bid=$_GET['bid'];
									 $bid && $condition['department']=array('eq',$bid);
									 $condition['pid']=$this->uid;
									 
								      $pageCount = D('User')->where($condition)->count();
									  $listRows = empty($listRows) ? 18 : $listRows;
									  $orderd = empty($orders) ? 'uid DESC' : $orders;
									  $paged = new page($pageCount, $listRows);
									  $list = D('User')->Where($condition)
															->Order($orderd)
															->Limit($paged->firstRow.','.$paged->listRows)	->select();  
									 
									
									 
									 					
															
									 $pageBar = $paged->show_ajax();				
									 $this->assign('list',$list);
									 $this->assign('pageBar',$pageBar);
							
							        parent::_tpl('ajax/user_list');
											 
								
								
								
								}
							
							
							
							
	 
	 
	 
	 
	 }
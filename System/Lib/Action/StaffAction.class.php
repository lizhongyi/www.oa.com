<?php
  /**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-3-15
 * Time: 下午17:15
 * To change this template use File | Settings | File Templates.
 * className:Servant Action
 * dever:yige
 * ProjectName:jobmedia OA.
 */
 class StaffAction extends GlAction{
	 
	              //初始化
				  public function _initialize(){
					       
						   parent::_initialize();
						   parent::Checklogin();
						    $this->dao=D('User');
						   if($this->role_id != 1 && $this->pid != 0){
							   
							    parent::_message('error','您没有权限访问该模块');
							   
						   }
					  
					  
					}
	               
				  //index
				  function index(){
					          $where="pid=".$this->comid;
							 // $where.=" or uid=".$this->uid;
							  $pageCount = D('User')->where($where)->count();
							  $listRows = empty($listRows) ? 10 : $listRows;
							  $orderd = empty($orders) ? 'id DESC' : $orders;
							  $paged = new page($pageCount, $listRows);
                              $list = D('User')->where($where)->select();
							   foreach($list as $k=>$v){
								
								    //得到工作单数
									$list[$k]['g_nums']=M('Works')->where('uid='.$v['uid'])->count(); 
								    //候选人数量
									$list[$k]['c_nums']=M('Nteam')->where('uid='.$v['uid'])->count();
									$list[$k]['role_id']=D('User')->where('uid='.$v['uid'])->getField('role_id');
									//成功候选人数量
									$list[$k]['sc_nums']=M('Candidate')->where('uid='.$v['uid'].' and stage > 8')->count();
							  } 
							   
							   
							                        //->Where($condition)
							                        
							 $role=M('StaffRole')->Field('id,title')->where('1=1')->select(); 
						
							//print_r($list);
							$this->assign('role',$role);
							$this->assign("getList",$list);
							$this->assign("pageBar",$pageBar);
						
							parent::_tpl('plus/index');
					  
					  }
	              
				  
				  public  function setRole(){
					         
							 if(!$_POST){
								  
								  parent::_message('error','非法操作');
								  
								 
								}
								
								
							 
					        //先查询权限表中有没有数据
							$extis=$this->dao->where('uid='.$_POST['uid'])->count();
							//$ss=$this->dao->getLastSql();
							 
							 $data['role_id']=$_POST['role_id'];
							 if($extis > 0){
								   
								    $rs=$this->dao->where('uid='.$_POST['uid'])->save($data);
								  
								}else{
									  $data['uid']=$_POST['uid'];
									  $rs=$this->dao->add($data);
									
									}
									
								  if($rs){
									
									   parent::_message('success','设置成功');
									   
									   //写入他的状态进内存
									   
									    $memcache = new Memcache;
			                            $memcache->connect("127.0.0.1", 11211) or die ("Could not connect");
						            		   
									   	  $key=md5('role'.$this->uid);
										  
										 
										  
							           if(!$memcache->get($key)){
													$dt['uid']=$this->uid;
													$dt['role']=M('User')->where('uid='.$this->uid)->getField('role_id');
													$f = 'sql';
													$memcache->add($key,serialize($dt),0,1020);  
													//Cookie::set('role_id',$dt['role'],60*60*60);			
													$data=$dt;			
													
											// echo $dt['role'];
							  }
							  else{   
							  
							          
									  $f = 'mem';
									  $data_mem=$memcache->get($key);
									  $data = unserialize($data_mem);
									  // $mem->replace( $key, $data['role'], 0, 1020);
									  
									 
							  }
									   
									   
									   
									   
									   
									   
									   
									
									}else{
										
									   parent::_message('error','操作失败，没有任何更新');
										
										}	
							
					  
					  }
	 
	 
	 
	 
	 
	 }

?>
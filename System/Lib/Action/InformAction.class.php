<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-4-19
 * Time: 上午14:54
 * To change this template use File | Settings | File Templates.
 * className:Inform
 * dever:yige
 * ProjectName:jobmedia OA.
 */
   
   class InformAction extends GlAction{
	   
	   
	         public function _initialize(){
				 
				    parent::_initialize();
					parent::Checklogin();
				    
				 }
				 
				 public function index(){
					       
						  // echo $this->uid;
					      //读取工作单职位
						   $wid=M('Team')->Field('gid,uid')->where('uid='.$this->uid)->select();
						   $wids=imp($wid,',','gid');
						   $condition['id']=array('in',$wids);
						   $dt = M('Works')
							                       ->Field('id')
							                       ->Where($condition)
							                       ->Order($orderd)
							                       ->select();  
						    $aid=imp($dt,',','id');					
													
								//读取应聘列表
							      $condition1['gid']=array('in',$aid);
								// $condition1=" find_in_set($this->uid,touid)'";
								  $pageCount =M('Apply')->where($condition1)->count();
								  $listRows = empty($listRows) ? 10 : $listRows;
								  $orderd = empty($orders) ? 'id DESC' : $orders;
								  $paged = new page($pageCount, $listRows);
								  $apply=M('Apply')->where($condition1)->group('gid')->select();
								  
								  
								   if($apply){
								   foreach($apply as $k=>$v){
									$apply[$k]['ynum']=M('Apply')->where('gid='.$v['gid'])->count();
										  
										  $readArr=explode(',',$apply[$k]['read_id']);
										  
										    if(in_array($this->uid,$readArr)){
											     
												 $apply[$k]['rd']=1; 
												 
											    }else{
												  
												  $apply[$k]['rd']=0; 
												  
										    }
									   
									  }
								   }
								  print_r($apply);
								  $this->ajax==0 ? $pageBar = $paged->show() :$pageBar = $paged->show_ajax() ;		                                  $this->assign('ap1',$apply);		
						          $this->display();
					 }
					 
				// candidate·inform
				
				public function Candidate(){
					
					    
						      // if hove a toal datas in the candidate then insert one data  in the this table
							  
							 //$condition['touid']=array('in',44);
							  $condition=" find_in_set($this->uid,touid) and module='candidate'";
							  $pageCount = $this->dao->where($condition)->count();
							  $listRows = empty($listRows) ? 10 : $listRows;
							  $orderd = empty($orders) ? 'id DESC' : $orders;
							  $paged = new page($pageCount, $listRows);
							  $infoList= $this->dao
							                        ->Where($condition)
							                        //->group('gid')
													->Limit($paged->firstRow.','.$paged->listRows)
													->select();  
									foreach($infoList as $k=>$v){
									   
									   if(in_array($this->uid,explode(',',$v['read']))){
									   
									      $infoList[$k]['rd']=1;
										  
									   }else{
										   $infoList[$k]['rd']=0;
										}
										  // $top1=$this->dao->where($condition)->order('id desc')->limit(1)->select();
										  // $infoList[$k]['nid']=$top1[0]['id'];
									}
								
													
													
								//echo $this->dao->getlastSql();					
							   // print_r($infoList);
							    $this->ajax==0 ? $pageBar = $paged->show() :$pageBar = $paged->show_ajax() ;
							    $this->assign('pageBar',$pageBar);					
							    $this->assign('infoList',$infoList);
								parent::_tpl('candidate_ajax');
							    
					         
					
					}	 
					
			     // get inform_collection  
				 
				 public function collection(){
					 
					 
					 
					     //$condition['touid']=array('in',44);
							  $condition=" find_in_set($this->uid,touid) and module='collection'";
							  $pageCount = $this->dao->where($condition)->count();
							  $listRows = empty($listRows) ? 10 : $listRows;
							  $orderd = empty($orders) ? 'id DESC' : $orders;
							  $paged = new page($pageCount, $listRows);
							  
							  
							  
							  $infoList= $this->dao
							                        ->Where($condition)
							                        ->Order($orderd)
							                        ->Limit($paged->firstRow.','.$paged->listRows)
													->select();  
													
								
							   $this->ajax==0 ? $pageBar = $paged->show() :$pageBar = $paged->show_ajax() ;
							   print_r($infoList);
							   $this->assign('pageBar',$pageBar);					
							   $this->assign('infoList',$infoList);
							   parent::_tpl('candudate_ajax');
					 
					 }		
					
	            
				// get inform totals
				
				
				//details jump url
				public function detail(){
					     
						    parent::checkID();
						    $dt=$this->dao->where("id=".$this->id)->find();
						  
						  if(!in_array($this->uid,explode(',',$dt['read'])))
						    {
						    $data['read']=$dt['read'].",".$this->uid;
						    $rs=$this->dao->where('id='.$this->id)->save($data);
						   }
					       if($_GET['rd'] !=1){
						   header("Location:/Works/detail/cid/".$dt['cid']."/id/".$dt['gid']."#初选");
						  
						   }else{
							   
							    redirect($_SERVER['HTTP_REFERER']);   
							 	 
							   }
							   
							   if($rs==1){
								   
								    redirect($_SERVER['HTTP_REFERER']);   
								   }
					}
				
	   
	   }
   
?>
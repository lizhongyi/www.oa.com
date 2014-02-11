<?php
	  
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-4-25
 * Time: 上午9:54
 * To change this template use File | Settings | File Templates.
 * className:Usermsg
 * dever:yige
 * ProjectName:jobmedia OA.
 */
class UsermsgAction extends GlAction{
	  
					  /*私信部分*/
					  
					  
				    public function _initialize(){
				 
				    parent::_initialize();
					parent::Checklogin();
				    
				 }	  
            
			
			
			     //index
			     public  function index(){
					 
					      if(!$this->uid){
		                     redirect(U('User/login'));
		                 }

					     /*私信列表*/
					       parent::teamer();	
							  
							  
							/*取得对话用户*/
							$smslist=$this->dao->field('faid,id,toid')->where('toid ='.$this->uid.'  and delid <> '.$this->uid.'          or faid='.$this->uid.' and  delid <> '.$this->uid)->order('id desc')->select();
								
								foreach($smslist as $k=>$v){
									
									  if($v['faid']==$this->uid){
										  
										  $suid[]=$v['toid'];
										  }
										  
										  if($v['toid']==$this->uid){
										  
										   $suid[]=$v['faid'];
										  }
									
									
									  
									$siin=implode(',',$suid);
									
									
									
								$suid=array_unique($suid);
								//print_r($suid);	
															
															
															
															
															
															
															
								     foreach($suid as $k=>$v){
	                                 $silist[$k]['uid']=$v;
									 $silist[$k]['sixin']=$this->dao->where('toid ='.$this->uid.' and faid='.$v.' and delid <> '.$this->uid.'   or toid='.$v.' and faid='.$this->uid.' and delid <> '.$this->uid)->order('id desc')->limit('1')->select();       
									
									
									 if($silist[$k]['sixin'][0]['faid']==$this->uid){
										$silist[$k]['sixin'][0]['st']="我发给";
										$silist[$k]['uname']=getTruename($silist[$k]['sixin'][0]['toid']);
										$silist[$k]['tid']=$silist[$k]['sixin'][0]['toid'];
										
										}
										
										if($silist[$k]['sixin'][0]['toid']==$this->uid){
										//$silist[$k]['sixin'][0]['st']="发件人";
										$silist[$k]['uname']=getTruename($silist[$k]['sixin'][0]['faid']);
										$silist[$k]['tid']=$silist[$k]['sixin'][0]['faid'];
										$silist[$k]['weidu']=$this->dao->where('faid='.$silist[$k]['sixin'][0]['faid'].' and toid='.$this->uid.' and status =0')->count();                                
										if($silist[$k]['weidu'] > 1){
										 $weidus=$silist[$k]['weidu']-1;
										 $silist[$k]['tixing']="有".$weidus."条新私信";
										 
                                          }
										 $data['status']=1;
										 $data['id']=$silist[$k]['sixin'][0]['id'];
										 $mu=$this->dao->save($data);		
										
										}
									   $silist[$k]['nums']=$this->dao->where('toid ='.$this->uid.' and faid='.$v.' or toid='.$v.' and faid='.$this->uid.' and delid <> '.$this->uid)->order('id desc')->count();
									  // $silist[$k]['uface']=getTruename($v,1);
									  
															}
								}
							  
							  /*根据对话用户读私信*/
							  
							//print_r($silist);
						  $jsrand=rand(0,4000);
						  $this->assign('jsrand',$jsrand);
                          $this->assign('silist',$silist);
						  parent::_tpl('ajax/index');
						 
			
		
					 
					 
					 }		
					 
					 
					 
					 public function sendmsg(){
						 
						      /*发送私信*/
						
							  
							 $post=rfilter($_POST); 
							 $data['content']   = $post['content'];
							 $data['toid']      = $post['toid'];
							 $data['faid']      = $this->uid;
							 $data['uid']       = $this->uid;
							 $data['create_time']=time();
							 
							 
							 $send=$this->dao->add($data);
							 if($send){
							    parent::_message("success",'发送成功');
							 }else{
							    parent::_message("error",'删除成功');  
							   }
						 
						 }
					 
					 
					 
					 /*私信对话列表*/
					 public function smsbox(){
						         
                                 $toid=$_GET['toid'];
								 if($toid==0){
									 
								   parent::_message("error",'没有找到页面');
									
									}
								$dhlist=$this->dao->where('toid ='.$this->uid.' and faid='.$toid.' and delid <> '.$this->uid.' or faid='.$this->uid. ' and toid='.$toid.' and delid <> '.$this->uid)->order('id desc')->select();//对话列表模板
								
								foreach($dhlist as $k=>$v){
									
									      //$dhlist[$k]['uname']=getTruename($dhlist[$k]['faid']);
										 // $dhlist[$k]['uface']=getTruename($dhlist[$k]['faid'],1);
										  if($dhlist[$k]['faid']==$this->uid){
											  
											  $dhlist[$k]['ut']="我:";
											  }
											else{
												/*发送给我新的都设置为已读*/
												
												if($dhlist[$k]['status']==0){
													$data['status']=1;
													$data['id']=$dhlist[$k]['id'];
													$this->dao->save($data);
													
													}
												
												$dhlist[$k]['ut']='<a href="'.U("User/home",array('uid'=>$dhlist[$k]['faid'])).'">'.getTruename($dhlist[$k]['faid']).'</a>';
												}  
									}
								
								
								//print_r($dhlist);
								$this->assign('dhlist',$dhlist);
								$this->assign('toid',$toid);
								$this->display();
							  
							 
						 }	
						 
						 public function add(){
							 
							      
								  parent::_tpl('ajax/add');
							 
							 }
						 
						 
						 /*删除私信*/	
						 public function delete(){
							 
							     /*判断是否是发给自己*/ 
								  $id=$_GET['id'];
								 
								 $del=$this->dao->where('id ='.$id)->find();
								     /*如果hi自己发的就并且没有操作就是添加删除ID*/
								    if($del['faid']==$this->uid  && $del['delid'] !=0 && $del['delid'] != $this->uid  || $del['toid']==$this->uid  && $del['delid'] !=0 &&  $del['delid'] != $this->uid  ){
									   
									    $deled=$this->dao->where('id='.$id)->delete();
										if($deled){
											
											  parent::_message("success",'删除成功');
							             }else{
							                parent::_message("error",'删除成功');  
							               }

									 }else{
										 /*如果是空的那就写入自己的delid*/
										  $data['delid']=$this->uid;
										  $data['id']=$id;
										  $delset=$this->dao->save($data);
										  if($delset){
											  parent::_message("success",'删除成功');
							 }else{
							    parent::_message("error",'删除成功');  
							   }
										 
										 }
							 
							 
							 }	
							 
							 
							 
							 
							 
							 
}
							 
							 
							    
?>
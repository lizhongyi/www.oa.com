<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-7-29
 * Time: 上午11:54
 * To change this template use File | Settings | File Templates.
 * className:Im
 * dever:yige
 * ProjectName:jobmedia OA.
 */
 
 class ImAction extends Action{
	 
	 
	 
	        public function _initialize(){
	 
	          $this->cuname         = Cookie::get('username'); 
		      $this->uid            = Cookie::get('uid'); 
			  $this->pid            = Cookie::get('pid');
			  $this->post            = Cookie::get('post');
			  $this->utype     = intval(Cookie::get('type'));
		      
			  $this->department     = Cookie::get('department');
			  $this->role_id        = Cookie::get('role_id');
			  $this->realname=      Cookie::get('realname');
			  $this->permission_tile = Cookie::get('permission_tile');
			  $this->permission = Cookie::get('permission');
			  $this->assign('uid',$this->uid);
			  $this->assign('realname',$this->realname);
			  $this->assign('department',$this->department);
			    Load('extend');
        include('./includes/Page.class.php');
	 
			}
			
			
	    
	     public function msg(){
			 
			     
				 $touid=$this->_get('touid');
				 $user_info=M('User')->field('uid,realname,face,department,pid')->where('uid='.$touid)->find();
				 if(!$user_info){
					  exit('出错');
					 }
					 
					
				 $this->assign('user',$user_info);
				 $this->display();
			 
			 }
			 
			 
		
			 
			 
		public function add(){
			
			        $data=$_POST;
					$data['create_time']=time();
					$data['touid']=$_GET['touid'];
					$data['fauid']=$this->uid;
					$data['msg']=str_replace("<","&lt;",$data['msg']);
					$data['msg']=str_replace(">","&gt;",$data['msg']);
					$rs=D('Im')->add($data);
					
					if($rs){
						    $data['status']=1;
							$data['create_time']=date('H:i:s',$data['create_time']);
							$data['msg']=nl2br($data['msg']);
							exit(json_encode($data));
						   
						}else{
							$data['status']=0;
							exit(json_encode($data));
							}
					
					
					
			
			}	 
			 
	    public function  poll(){
			      
				      $fauid=$_GET['fauid'];
					  if(intval($fauid)==0) return false;
				      $msg=M('Im')->where('fauid='.$fauid." and touid=".$this->uid."
					  and read_id=0")->order('id desc')->find();
			
			          if($msg){
						  
						   $d['read_id']=1;
						   $r=D('Im')->where('id='.$msg['id'])->save($d);
						   $msg['status']=1;
						   $msg['realname']=getTruename($msg['fauid']);
						   $msg['create_time']=date('H:i:s',time());
						   exit(json_encode($msg));
						  
						  }else{
							  
							  }
							   
							 
					  
					  
			}
			
			
			
			
			
			
			
			
			
			 public function  polllist(){
			      
				      $fauid=$_GET['fauid'];
					  if(intval($fauid)==0) return false;
				       $msg=M('Im')->where('fauid='.$fauid." and touid=".$this->uid."
					   and read_id=0")->order('id asc')->select();
					  
					  if($msg){
					  
					        foreach($msg as $k=>$v){
					       $d['read_id']=1;
						   $r=D('Im')->where('id='.$v['id'])->save($d);
						   $msg[$k]['status']=1;
						   $msg[$k]['realname']=getTruename($msg[$k]['fauid']);
						   $msg[$k]['create_time']=date('H:i:s',time());
						  
					     }
			                }else{
								
							$msg[0]['status']=0;	
				 
				   
				        }
			   
					   exit(json_encode($msg)); 
					 	

			 }
					
					
		 //聊谈记录
		 
		 public function story(){
			 
			                      $touid=$_GET['touid'];
				                  $where=" fauid=".$this->uid." and touid=".$touid." and read_id=0 or fauid=".$touid." and touid=".$this->uid." and read_id=1";
				                  $pageCount =M('Im')->where($where)->count();
								  $listRows = empty($listRows) ? 15 : $listRows;
								  $orderd = empty($orders) ? 'id DESC' : $orders;
								  $paged = new page($pageCount, $listRows);
								  $xlist=M('Im')->where($where)->Limit($paged->firstRow.','.$paged->listRows)->select();
								   $i=0;
								   foreach($xlist as $k=>$v){
									    
										   
										   $xlist[$k]['status']=1;
										   $xlist[$k]['realname']=getTruename($xlist[$k]['fauid']);
										   $xlist[$k]['create_time']=date('Y-m-d H:i:s',$v['create_time']);
										   $xlist[$k]['uid']=$this->uid;
										   
										  
									  }
								   
								  
								  
								
								  $pageBar = $paged->show_ajax1() ;		
							      $this->assign('msg',$xlist);
								   $this->assign('pageBar',$pageBar);
								  
								  $this->display('ajax/story');		
			 
			 
			 }			  
					  
			
	    
		
		 
	 
	 
	 }
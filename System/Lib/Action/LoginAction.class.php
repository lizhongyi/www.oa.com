<?php
class LoginAction extends Action{
	
	  
	    public function _initialize(){
			
			
			
			
			
			  $this->cuname         = Cookie::get('username'); 
		      $this->uid            = Cookie::get('uid'); 
			  $this->pid            = Cookie::get('pid');
			  $this->utype     = intval(Cookie::get('type'));
		      $this->level         = Cookie::get('level');
			  $this->department     = Cookie::get('department');
			  $this->role_id        = Cookie::get('role_id');
			  $this->permission_tile = Cookie::get('permission_tile');
			  $this->permission = Cookie::get('permission');
			  
			 
			  
							 
			       //获取公司ID采用递归
				   if($this->pid != 0){
				   $this->comid=$this->pid;
				   }else{
				   $this->comid=$this->uid;
					   }
			       
				 
			
				  
	              $this->assign('uname', $this->cuname);
		          $this->assign('uid', $this->uid);
				   $this->assign('comid', $this->comid);
		          $this->assign('pid',$this->pid);
		          $this->assign('permission_tile',$this->permission_tile);
				  $this->assign('role_id',$this->role_id);
			      $this->assign('utype',$this->utype);
				  $this->assign("select",$public_arr);
				 
			
			    $this->dao=D('User');
			
			
			   
			}
	   
	    
	
  public function index(){
			            if(Cookie::get('uid') != ""){
				           
				           header("Location:/");
				   
				   }
				       
				        $this->display();
			        
			   }
			   
			   
			   
			   public function  doLogin(){ 
		             if(Session::get('uid') != ""){
				   
				        header("Location:/");
				   
				   } 
				     $data= rfilter($_POST);
					 
					 $username=$_POST['login_username'];
					 $pass=sha1($_POST['login_password']);
					 
					 if($username=="" || $pass==""){
						  $this->_message('error',$username);
						 
						 }
					 
					 $lo=M('User')->where("username='".$username."' and password='".$pass."' and type=0  or  email='".$username."' and password='".$pass."' and type=0 ")->find();
					// exit(M('User')->getLastSql());
					 if($lo['uid']!=""){
						      
							  
							  if($lo['status']==0){
							   $this->_message('error','该账号已被禁用');
							  }
							  
							  
							  if($_POST['remember_me']=='yes'){
								  $time=3600*60*24*30;
								  }else{
								   $time=3600*60*24;	 
								}
							 
							 $data['last_login_time']=time();
							 $data['last_ip']=get_ip();
							 
							 $uptime=M('User')->where('uid='.$lo['uid'])->save($data); 
							  
							  Session::set('uid',$lo['uid']);
							  Session::set('pid',$lo['pid']);
							  Session::set('username',$lo['username']);
							  Session::set('realname',$lo['realname']);
							  Session::set('type',$lo['type']);
							  Session::set('post',$lo['post']);
							  Session::set('role_id',$lo['role_id']);
							  Session::set('level',$lo['level']);
							 if($lo['pid'] <> 0){
								 Session::set('comid',$lo['pid']);
									    $level=M('User')->where('uid='.$lo['pid'])->getField('level');
										
									    Session::set('level',$level);
									    Cookie::set('level',$level,$time);
									 }else{
									   $level=M('User')->where('uid='.$lo['uid'])->getField('level');
									    Session::set('level',$level);
									    Cookie::set('level',$level,$time);  
									}
								  
							 
							
							 	  
							  
							  Session::set('department',$lo['department']);
							 
							 
							 Cookie::set('uid',$lo['uid'],$time);
							 Cookie::set('post',$lo['post'],$time);
							 Cookie::set('pid',$lo['pid'],$time);
							 Cookie::set('username',$lo['username'],$time);
							 Cookie::set('department',$lo['department'],$time);
							 Cookie::set('realname',$lo['realname'],$time);
							 Cookie::set('type',$lo['type'],$time);
							 
							 
							  if($lo['pid']==0){
								  
								    Cookie::set('comid',$lo['uid'],$time);
								  }else{
									Cookie::set('comid',$lo['pid'],$time);
									  
								}
							 
							  
							   
							   
							 
							 
							   $d['username']=$lo['username'];
							   $d['uid']=$lo['uid'];
							   $d['login_time']=time();
							   $d['status']=1;
							   $rs=M('User_online')->add($d);
							   if(!$rs){
								    
									//exit($d);
									
								   }
							 
							 
							   Cookie::set('role_id',$lo['role_id'],$times);
							 
							  
							
						     $this->_message('success','登陆成功');
						 }else{
							 $u=M('User')->where('username="'.$username.'" or email="'.$username.'"')->count();
							 if($u==0){
								 $errStr="用户名不存在";
								 }else{
									 $errStr="密码不正确"; 
									 }
							  $this->_message('error','登陆失败，'.$errStr);
							 }
				        
				   
			        
               }   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   public function checkInput(){
				
				       $act=$_GET['act'];
					   
					   if($act=='uname'){
						      
							 $rs=M('User')->where("username='".$_POST['username']."'")->count();  
							           
									     if($rs>0){
														   exit(false);
														}else{
															exit(true);
															}           
						   
						   }
						   
						   if($act=='mail'){
							   
							    $rs=M('User')->where("email='".$_POST['email']."'")->count();  
								
								
								 if($rs>0){
														   exit(false);
														}else{
															
															exit(true);
															
															}
							   }
							   
						exit('error');	   
				      
				
				}	
			   
			   
			   
		 /*User reg*/
		 
		  function do_reg(){
			  
			         Load('extend');
			         //first reg step1
					 $this->dao=D('User');
					 $data=$_POST;
					 
					//check ext
					 $c=$this->dao->where('username='.$_POST['username'])->count();
					 if($c>0){
						  $this->error('用户名已经存在！');
						 }
						 
					 if($_POST['username']==""){
						  $this->error('用户名不能为空');
						 }	 
					 $daoAdd=$this->dao->create();
					 if($daoAdd){
						    $this->dao->status=1;
							$this->dao->step=1;
							$this->dao->create_time=time(); 
							$this->dao->regip=get_client_ip();
							$nums=base64_encode(md5($data['username'].rand(0,999999).time()));
							$this->dao->activate=$nums;
							$this->dao->password=sha1($data['password']);
							$this->dao->pid=0;
						    $rs=$this->dao->add();
						    if($rs){
								//send an email to this emialaddrs
								$to=$data['email'];
								$name='Jobme';
								$subject="账号激活邮件";
								$url="<a href='http://".$_SERVER['HTTP_HOST']."/Login/activate/uid/".$rs."/numbs/".$nums."'>点击激活</a>";
								$body="这是我们给你发送的一封激活账号的邮件请点击下面链接激活邮箱<br>".$url;
								$send=send_email($to,$subject,$body,$charset='UTF-8', $attachment = null);
								
								
								 
								 if($send==0){
									  
									  
									   
									  
									   
									  
									   $this->dao->where('uid='.$rs)->delete();
									   
									   $this->error('系统异常,邮件地址有问题');
									 
									 }else{
										   
										 //$zemail=$_POST['email'];
//								
//								         $body1="新用户".$_POST['username']." 　邮箱：".$_POST['email'];
//								
//								         $send1=send_email('yuchao@jobmes.com','用户注册通知:',$body1,$charset='UTF-8', $attachment = null);
											
										 $lo=M('User')->where('uid='.$rs)->find();	
										 
										 Session::set('uid',$lo['uid']);
										 Session::set('pid',$lo['pid']);
										 Session::set('username',$lo['username']);
										  Session::set('realname',$lo['realname']);
										 Session::set('type',$lo['type']);
										
										 
										 
										 Cookie::set('uid',$lo['uid'],60*60*24);
										 Cookie::set('pid',$lo['pid'],60*60*24);
										 Cookie::set('username',$lo['username'],60*60*24);
										 Cookie::set('realname',$lo['realname'],60*60*24);
										 Cookie::set('type',$lo['type'],60*60*24);
										 $d['uid']=$lo['uid'];
										 $r=D('User_company')->add($d);
										 if($r){
										 	
										 $this->_message('success','注册成功','/Login/checkMail',1);
										 }else{
											 $this->_message('error','注册失败');
											 
											 }
										 
										 }
								 
								}
							
						 }
					 
			          
			        
			  
			  
			  
			  
			  }
		
		
		
			   /*退出登陆*/
			   public function logout(){
				
			          Session::set('uid','');
					   Session::set('pid','');
					  Session::set('uname','');
					  Session::set('realid','');
					  Session::set('face','');
					  Session::set('permission','');
					  Session::set('role_id','');
					  
					  
					  
					  Cookie::set('role_id','',time()-3600);
					  Cookie::set('uid','',time()-3600);
					  Cookie::set('pid','',time()-3600);
					  Cookie::set('comid','',time()-3600);
					   Cookie::set('type','',time()-3600);
					  Cookie::set('realid','',time()-3600);
					  Cookie::set('uname','',time()-3600);
					  Cookie::set('username','',time()-3600);
					  Cookie::set('face','',time()-3600);
					 
	                  redirect("/Login");
               //  print_r($_COOKIE);
		   
		       //echo  Session::get('uid');
			
          

      
    
				   
			   }
			   
			   
			  
			   
			   	public function activate(){
					
					     $uid=$this->_get('uid');
						 $nums=$this->_get('numbs');
						 if(!$uid){
							  
							   $this->error('参数错误');
							 
							 }
							 
						 $condition['uid']=array('eq',$uid);
						 $condition['activate']=array('eq',$nums);
						 $condition['step']=array('eq',1);	 
						 $activate=M('User')->where($condition)->count();
						 
						 if( $activate > 0){
							  
							   $data['step']=2;
							   
							   $r=M('User')->where('uid='.$uid)->save($data);
							   
							   
							   if($r){
								   
								   
								   
								   
								   $this->_message('success','激活成功','/User/profile_edit');
								   
								   
								   
							    }else{
								 
								 $this->_message('error',"激活失败，或该链接已经失效");
								 }	 
							   
							 }else{
								 
								 $this->_message('error',"该链接已经失效");
								 }	 
						
							 
					
					}
					
					
			   
			   
			    //checksetp
		  
		       public function checkStep(){
				           $uid=Cookie::get('uid');
				          $step=M('User')->where('uid='.$uid)->find();
						   $steps=M('User_company')->Field('examine')->where('uid='.$uid)->find();	
							$this->assign('email',$step['email']);
							
				         
						 if($step['pid']==0){
					  
					   switch ($step['step']){
						     
							 case 1 :
							 redirect('/Login/checkMail');
							 exit;
							 break;
							 case 2 :
						     redirect('/User/profile_edit');
							 exit;
							 break;
							 case 3 :
							 redirect('/User/profile_company');
							 exit;
							  break;
							 case 10 :
							 $this->display('disbaled');
						      exit;
							 break;
						   }  
						   
						   
						         if($steps['examine']==0 || $steps['examine']==2){
							   
							        //  redirect('/Login/examine');
							     
							      }else{
									  
									  //检测组织架构
									  
									   $groups=M('User_group')->where('fid='.$uid)->count();
									   if($groups<1){
										     
											 redirect('User_group/index');
										   
										   }
										   
										//exit( $groups );  
									  
									  }
							       
						   
						 }else{
							 
							 
							 
							  switch ($step['step']){
						     
						     	 case 1 :
							    redirect('/Login/checkMail');
							    exit;
							    break;
							   case 2 :
						       redirect('/User/profile_edit');
							   
							   exit;
							   break;
							   case 10 :
							   $this->display('disbaled');
						        exit;
							   break;
							   default: 
							    
								break;
							 
						       }  
						   
						    
							   
							   
							
							 
							 
							 }
				 
				 }		
			
			   
			   
			   
			   public function checkMail(){
				            $uid=Cookie::get('uid');
							
							if($_GET['test']){
								
								
							
							 $ji=M('User')->where('uid='.$uid)->getField('step');
							echo $ji;
							 if($ji<2){
								   
								   $data['step']=2;
								   $rs=D('User')->where('uid='.$uid)->save($data);
								   
								 
								 }
							
							}
							
							
							
							
				            $step=M('User')->where('uid='.$uid)->find();
							if($step['step'] >=2){
								  $this->checkStep();
								}
							
							$this->assign('email',$step['email']);
							$this->display();
				   }
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
					 protected function _message($type = 'success', $content = '更新成功', $jumpUrl = __URL__, $time = 1, $ajax = false)
    {
        $jumpUrl = empty($jumpUrl) ? __URL__ : $jumpUrl ;
        switch ($type){
            case 'success':
                $this->assign('jumpUrl', $jumpUrl);
                $this->assign('waitSecond', $time);
                $this->success($content, $ajax);
                break;
            case 'error':
                $this->assign('jumpUrl', 'javascript:history.back(-1);');
                $this->assign('waitSecond', $time);
                $this->assign('error', $content);
                $this->error($content, $ajax);
                break;
            case 'errorUri':
                $this->assign('jumpUrl', $jumpUrl);
                $this->assign('waitSecond', $time);
                $this->assign('error', $content);
                $this->error($content, $ajax);
                break;
            default:
                die('error type');
                break;
        }
    }
					
			   
			   public function examine(){
				      
					  
					  //get examine profile
					  if($this->pid==0){
					  $eid=$this->uid;
					  
					  }else{
						  $eid=$this->pid;
						  }
						  
					          $dt=D('User_company')->Field('examine,examine_info')->where('uid='.$eid)->find();
					         if($dt['examine']==0){
							  $dt['title']=":)您的资料正在审核中...";
							  }
							  
							 if($dt['examine']==2){
							  $dt['title']=":(您的资料没有通过审核...";
							  }  
							 $this->assign('dt',$dt);
							 
							 if($dt['examine']==1){
								     
									 
								 
								 }
							 
							 
							 
							 
					      $this->display();
				   
				   
				   }
			   
			   
			   
			   
			   	   public function forget(){
				   
				   
				       $this->display();
				   
				   }
				   
				   
				   
				   
				   
				   
				   
				   
				   
				   
				   
				   
				   
				   
				   public  function repass(){
		
			  $toemail=$_POST['umail'];
			  if($toemail==""){
				   exit('邮箱不存在');
				  }
			  $tiao=$this->dao->where('email ="'.$toemail.'" and email <> ""   and type=0')->find();
			 
			  if(!$tiao['uid']){
				 exit('邮箱不存在');  
			   }
				  
				  /*生成随机验证码*/
				  $randnum=base64_encode($toemail.",".rand(1,time()));
				  //echo $randnum;
				 // exit();
				  $data['randnum']=$randnum;
				  $data['uid']=$tiao['uid'];
				  $uprand=$this->dao->where('uid='.$tiao['uid'])->save($data);
				  
				//  exit($this->dao->getLastSql());
				/*导热邮件类*/  
				 require_cache('includes/class.phpmailer.php');
				if(!$uprand){
					 
					 exit('yichang');
					
					}
				   require_cache('includes/mailer.class.php');
				
				         $from      =    $this->sysConfig['site_name'];
				         $email     =    $this->sysConfig['smtpmail'];
						 $protocol  =    $this->sysConfig['smtpyz'];
						 $host      =    $this->sysConfig['smtpserver']; 
						 $port      =    $this->sysConfig['smtpport']; 
						 $user      =    $this->sysConfig['smtpuser']; 
						 $pass      =    $this->sysConfig['smtppass']; 
						
						
						
			          
						
						$to= $toemail;
						$subject="找回密码";
						$body="您好您的密码需要修改，请点击如下链接<a href='http://".$_SERVER['HTTP_HOST']."/Login/urepass/rand/".$randnum."'>http://".$_SERVER['HTTP_HOST']."/Login/urepass/rand/".$randnum."</a>";
						$is_html=true;
						$charset='utf-8';
			            $body             = eregi_replace("[\]",'',$body); //对邮件内容进行必要的过滤
					
						
					
						                 $fasong=send_email($to,$subject,$body,$charset='UTF-8', $attachment = null);
						                 if($fasong){
							
							             exit ('ok');
							
							             }else{
							             echo 0;	
							             }
										 
						    
						

			  
			 
			
			 
		}
		//找回密码
		public  function urepass(){
			
			              $rand=$_GET['rand'];
			          
				          if($_GET['act'] != 'uppass' && $rand !="" ){
							 
							 
					         $array = explode(',',base64_decode($rand));
						
					 
					  //查询验证码
					      $tiao=$this->dao->where('email ="'.$array[0].'" and randnum = "'.$rand.'"')->find();
					      
					   if(!$tiao['uid']){
						   
						   self::_message('errorUri', '验证码作物或已经失效', U('Index/index'));
						   exit();
						   
						   }else{
							  
							    $this->assign('rand',$rand);
								$this->display();
								exit();
							   
					}  
						 }
                   if($_GET['act'] == 'uppass' ){
					   
					        $pass    =  $_POST['pass'];
					        $pass1   =  $_POST['pass1'];
	                        $rand    =  $_POST['rand'];
							
							
							
							if($pass=="" || $pass1==""){
							 
							   exit('请输入密码');	
							}
							
							if($pass != $pass1){
							 
							   exit('两次输入的不一致');	
							}
						   $array = explode(',',base64_decode($rand));
						   $tiao=$this->dao->where('email ="'.$array[0].'" and randnum = "'.$rand.'"')->find();
						  
						  
						   //更新
						   $data['password']=sha1($pass);
                           $data['randnum']="";
						   $data['uid']=$tiao['uid'];
						   $up=$this->dao->where('uid='.$tiao['uid'])->save($data);
						   if($up){
							    
								exit('ok');
								
							   }
							  else{
								  
								  exit('修改失败');
								  
								  } 
						 
						  
					   }
					  
					  } 
					  
			   
			   
			   //内侧用户激活程序
			   
			
			   
			   

}

?>
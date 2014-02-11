<?php
/*
用户基本操作
*/

class UserAction extends GlAction{
            
	
	         function _initialize(){  
			       
		            
			            parent::_initialize(); 
						parent::Check();
						
			                 
				
				}
			
			
			
			
	       public  function index(){
			   
			    
			       R('Login/checkStep');
			   
			        $this->display();
					
			   
			    }			
				
	
		
			   
			   
			   public function profile(){
				   
				   
				   }
				
				
				  //profile view tamplate
				   public function profile_edit(){
					         
				             $pr=M('User')->where('uid='.$this->uid)->find();
							 
							  if($pr['step'] < 2){
					           redirect('/Login/checkMail');
							  }
							 
							 $this->assign('pr',$pr);
							  
				            $this->display();
				   
				   }
				   
				    //profile view tamplate
				   public function profile_edu(){
					       
						   
					   
				             $pr=M('User_edu')->where('uid='.$this->uid)->find();
							 $this->assign('pr',$pr);
							 $this->display();
				   
				   }
				   
				   
				   
				//save profile
				 
				public function do_profile(){
					     $data=$_POST; 
						 $data['update_time']=time();
						 $dao=$this->dao->create();
						
						if($dao){
							     
								 if($data['step']<3){
									 $this->dao->step=3; 
									 $rs=$this->dao->where('uid='.$this->uid)->save(); 
									 }else{
										 $rs=$this->dao->where('uid='.$this->uid)->save(); 
										 }
								 
							   
								
								if($rs){
									   
									   $com=M('User_company')->where('uid='.$this->uid)->getField('companyname');
									   if($this->pid==0 && $com==''){
										   
									         $this->_message('success','更新成功','/User/profile_company');
											 
											 
									   }else if($this->pid <> 0){
										   
										   
										    $this->_message('success','更新成功','/User/profile_edit');
											
											Cookie::set('realname',$data['realname'],60*60*60*24);
											Session::set('realname',$lo['realname']);
											
										   }else{
											   
											   
											    $this->_message('success','更新成功','/User/profile_edit');
												Cookie::set('realname',$data['realname'],60*60*60*24);
											   
											   }
									   
									   
									   
									}else{
										
										$this->_message('error','更新失败，信息没有改动');
										}
							
							 }else{
								  
								  exit("错误了");
								 
								 
								 }
							 
					} 
				 
				 
		 
					
					//pro_file_company
					
					public function profile_company(){
						           
								    
							  
								   if($this->pid==0){
								      $list=D('User_company')->where('uid='.$this->uid)->find();
								   }else{
									    $list=D('User_company')->where('uid='.$this->pid)->find();
									   }
								  
								  
								  if($this->pid==0){
								        $list['step']=$this->dao->where('uid='.$this->uid)->getField('step'); 
												if( $list['step'] < 2){
												redirect('/Login/checkMail');
												}
											
											   
												   if( $list['step'] < 3){
													   $this->_message('error','请完善基本资料');
													   
														redirect('/User/profile_edit');
												   }
								  }
								  
								  
								  
						          $this->assign('pr',$list);
								  if($this->pid==0){
						              $this->display();
								  }else{
									  
									   $this->display('company_info');
									  
									  }
						
						
						}
						
					//do profile_compamy
					
					public function do_company(){
						
						    
							
							  $data=$_POST; 
						      $dao=D('User_company')->create();
						
						if($dao){
							     
								  if($data['step']<4){
									 $dt['step']=4; 
									 $rs1=D('User')->where('uid='.$this->uid)->save($dt); 
									 }
									 
									 
									 
											 $uploadFile = upload('Company');
                   if ($uploadFile)
            {
               
              D('User_company')->license = formatAttachPath($uploadFile[0]['savepath']) .splitbig($uploadFile[0]['savename']);
               

            }     
			
			
			
			
			 $uploadFile = upload('Company',1,"","","","",$attachFields = 'logo_file');
                   if ($uploadFile){
               
                             D('User_company')->logo_file = formatAttachPath($uploadFile[0]['savepath']) .splitbig($uploadFile[0]['savename']);
               

            }
			                       $ed=M('User_company')->where('uid='.$this->uid)->count();
				                    if($ed<>0){
								   $rs=D('User_company')->where('uid='.$this->uid)->save(); 
									}else{
										 D('User_company')->uid=$this->uid;
										 $rs=D('User_company')->add(); 
										}
								
								if($rs){
									   
									 //  $this->_message('success','更新成功','/User/profile_company');
									   
									   //此时应该写入 角色设置
									   
									   $d=M('persona')->where('comid='.$this->uid)->count();
									   
									   if($d==0){
										      
											  $da['title']='人选提供';
											  $da['comid']=$this->uid;
											  $c=D('persona')->add($da);
											  
											  if($c){
												   
												  }
												  else{
													  $this->_message('error','设置角色失败');
													  
													  }
										      
										   }
										   
										    //检测组织架构如果没有自动加入总部
											
											
											$jiagou=M('User_group')->where('fid='.$this->uid)->select();
											if($jiagou<1){
												 //自动创建总部
												 
												 $data['title']="总部";
												 $data['fid']=$this->uid;
												 $data['pid']=0;
												 $bu=D('User_group')->add($data);
												 if(!$bu){
													  
													  $this->_message('error','更新失败，信息没有改动');
													 
													 }
												
												}
										   
										   $this->_message('success','更新成功','/User_group');
										   
									   
									}else{
										
									
									$this->_message('error','更新失败，信息没有改动');
									
										}
							
							 }else{
								  
								  exit("错误了");
								 
								 
								 }
							
						      
						
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
				     
					 
					 $this->display();
				   
				   
				   }
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
		public function upPass(){
		
		
			   $data= rfilter($_POST); 
			  
			    /*验证原密码*/
				  
				  if($data['npass'] != $data['npass1']){
					  
					    exit("密码不一致");
					  }
				  
				 $ypass=sha1($data['ypass']);
				  
			
				  
				  $pas=$this->dao->where('uid = '.$this->uid.' and password="'.$ypass.'"')->count();
				  
				//echo $pas;
				  
				  if($pas < 1 ){
					   
					 $this->_message('error','原密码错误');
					  }
				//exit($pas);
				
		      		$data['password']=sha1($data['npass']);	 
                    
		            $savep=$this->dao->where('uid='.$this->uid)->save($data);	
					
					
		            if($savep){
						
		                    $this->_message('success','密码修改成功'); 
					    
                            } else{
							
				             $this->_message('error','修改失败');
				  
                         }
		  
			    
			    
			
			  
		 }
	 
	 
	 
	 
	
	 /**
	 
	 上传
	 
	 */
    public function upFace(){
		    
			if(empty($_FILES)){
				  
				 exit("<script> parent.callback(3);</script>");
				 
				}
				else{
					 $uploadFile = upload($this->getActionName());
					if($uploadFile) {
						
						//exit($uploadFile);
						$fname=$uploadFile[0]['savepath']."m_".$uploadFile[0]['savename'];
						$wh=getimagesize($fname);
						
						
						if($wh[0] > 200){ 
						
							$data['face2']=sub1($fname);
							$data['face1']=0;
							
							$data['uid']=$this->uid;
							$cheng=$this->dao->where('uid='.$this->uid)->save($data);
							if($cheng){
						 exit("<script> parent.callback(2,'".sub1($fname)."',$wh[0],$wh[1]);</script>");
							}else{
								//echo $this->dao->getlastSql();
								}
						}else{
						//写数据库删除
						   
							 @unlink($this->userarr['face']);
							
							
							$data['face']=sub1($fname);
							$data['face1']=1;
							$data['face2']="";
							$data['uid']=$this->uid;
							$cheng=$this->dao->where('uid='.$this->uid)->save($data);
							
							if($cheng){
							exit("<script> parent.alert('上传成功');</script>");
							}
						}
							
							
					}
					
					
					}
			  
			 
		  
	}
	
	
	 /**
	 
	 上传
	 
	 */
    public function  cutFace(){
		    
			if(!$_POST) exit("提交失败");
				//exit("nihaohah");
			
			$x1=intval($_POST['x1']);
			$y1=intval($_POST['y1']);
			$x2=intval($_POST['x2']);
			$y2=intval($_POST['y2']);
			$face2=$this->dao->where('uid='.$this->uid)->getField('face2');
			$picname=sub1($face2);
		
			$ext=substr($picname,-3);
			//exit($face2);
			$dstimg=$picname;
			$nw=intval($x2-$x1);
			$nh=intval($y2-$y1);
			
			
			$r = 100;
            if($x2<$x1||$y2<$y1){
              return false;
             }
			 
            $img=$picname;
             if($ext=='jpg'){
            $im=imagecreatefromjpeg($img);
			 }
			
             if($ext=='gif'){
            $im=imagecreatefromgif($img);
			 }
			 
             if($ext=='png'){
            $im=imagecreatefrompng($img);
			 }
            $percent = $r*0.01;
           
           list($width, $height) = getimagesize($img);
            $new_width = $width * $percent;
            $new_height = $height * $percent;
            $tempimg = imagecreatetruecolor($new_width,$new_height);
            imagecopyresampled($tempimg, $im,0,0,0,0, $new_width,$new_height, $width, $height);
			
			
			
             if($ext=='jpg'){
           imagejpeg($tempimg,"Uploads/User/face/temp_".$picname);
			 }
            
			if($ext=='gif'){
           imagegif($tempimg,"Uploads/User/face/temp_".$picname);
			 }
			 if($ext=='png'){
           imagepng($tempimg,"Uploads/User/face/temp_".$picname);
			 }
			
			
			
            imagedestroy ($im);

           $ims=$tempimg;
           $srcW=imagesx($ims);
           $srcH=imagesx($ims);
           $top_x = $x1;
           $top_y = $y1;
           $bottom_x = $x2;
           $bottom_y = $y2;
           $newimg = imagecreatetruecolor($bottom_x-$top_x,$bottom_y-$top_y);
           imagecopyresampled($newimg, $ims,0,0,$top_x,$top_y, $srcW,$srcH, $srcW, $srcH);    
		   $nface="Uploads/User/face/".substr(md5($this->uid),8).time().".".$ext;
		   
		   
		   if($ext=='png'){
           imagepng($newimg,$nface);
			 }
		   
		    if($ext=='gif'){
           imagegif($newimg,$nface);
			 }
			 if($ext=='jpg'){
           imagejpeg($newimg,$nface);
			 }
		   
         
		   
           if(imagedestroy ($ims))
		   /*更新数据库删除临时图*/
		   @unlink("Uploads/User/face/temp_".$picname);
		   @unlink($picname);
		   $data['face']="/".$nface;
		   $data['face1']=1;
		   $data['face2']="";
		   $data['uid']=$this->uid;
		   $sv=$this->dao->where('uid='.$this->uid)->save($data);
		   if($sv){
			       
				   echo "/".$nface;
				   
			   }
		   else{
			    echo $this->dao->getLastSql();
			   
			   }


			
			
			 
		  
	}
		
			   
			   
			   
			   
		
				    public function Upass(){
						
						     $this->display();
							 
						}
		   
			   
			   
			   
			   
					//用户设置
		
	 
					
					
	
	}

?>
<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends GlAction {
      
	  
	  
	     public function _initialize(){
			        
					parent::_initialize();
					parent::Checklogin();
					 
				    
			  }
		 
		  public function index(){
             
			 
			 
			 
			           
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
		  
		 // New candidate  
		 $wid=M('Team')->Field('gid,uid')->where('uid='.$this->uid)->select();
							 $wids=imp($wid,',','gid');
							 if($this->pid!=0){
							 $condition['id']=array('in',$wids);
							 }else{
								  $condition['comid']=array('in',$this->comid);
								 
								 }
							 
		 $wk=M('Works')->Field('id,Search_posts,custom,principal_cn,cid')
		               ->where($condition)
					   ->limit(6)
					   ->order('id desc')
					   ->select();
					   
			                foreach($wk as $k=>$v){
				             $wk[$k]['stage']=parent::__get_c_stage($v['id']);
														
			            	}		    
							$conditions['cid']=$this->comid;
							$list=parent::get_json_list(M('Resume'),$conditions,$orders='uid desc',$listRows=8);
							$list=$list['list'];
							$pageBar=$list['pageBar'];
							$this->assign('getList',$list);
							$this->assign('wkList',$wk);	 
		                    // $this->assign('talent',$list);
		
		     
			
			
		 $notice=M("Notice")->where('comid='.$this->comid)->order('id desc')->limit(8)->select();	 
			 
		 $this->assign('notList',$notice);
		 
		 
		 
		 
		 
		 
		 
		 // echo $this->uid;
					      //读取工作单职位
						     $wid=M('Team')->Field('gid,uid')->where('uid='.$this->uid)->select();
							 $wids=imp($wid,',','gid');
							 $condition['id']=array('in',$wids);
							 
							//$pageCount = $this->dao->where($condition)->count();
							
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
								  
								   foreach($apply as $k=>$v){
									     $apply[$k]['ynum']=M('Apply')->where('gid='.$v['gid'])->count();
									   
									  }
									  
									
								    $nums=0;
									
								   foreach($apply as $k=>$v){
									    
										   $readArr=explode(',',$v['read_id']);
										   if(!in_array($this->uid,$readArr)){
										  $nums=$nums+$apply[$k]['ynum'];
										   }
									  }
								 
						       
		                           $this->assign('tongzhi',$nums);
		 
		 
		                //个人业绩
		                $gerenArray=array(
										get_geren_yeji(1,$this->uid),
										get_geren_yeji(2,$this->uid),
										get_geren_yeji(3,$this->uid),
										get_geren_yeji(4,$this->uid),
										get_geren_yeji(5,$this->uid),
										get_geren_yeji(6,$this->uid),
										get_geren_yeji(7,$this->uid),
						               );
		                 
		 
		 
		                //部门业绩
						$bmArray=array(
										get_bm_yeji(1,$this->department,$this->comid),
										get_bm_yeji(2,$this->department,$this->comid),
										get_bm_yeji(3,$this->department,$this->comid),
										get_bm_yeji(4,$this->department,$this->comid),
										get_bm_yeji(5,$this->department,$this->comid),
										get_bm_yeji(6,$this->department,$this->comid),
										get_bm_yeji(7,$this->department,$this->comid),
						               );
		                 //公司业绩    
		 
	                    $comArray=array(
										get_com_yeji(1,$this->comid),
										get_com_yeji(2,$this->comid),
										get_com_yeji(3,$this->comid),
										get_com_yeji(4,$this->comid),
										get_com_yeji(5,$this->comid),
										get_com_yeji(6,$this->comid),
										get_com_yeji(7,$this->comid),
						               );
	                    	
							
							
							
							
							$d1="";
							$d2="";
							$d3="";
							
							$nows=date('m',time());
							
							for($i=1;$i<=$nows;$i++){
								
								   $d1.="['".$i."',".get_geren_yeji($i,$this->uid)."],";
								   $d2.="['".$i."',".get_bm_yeji($i,$this->department,$this->comid)."],";
								   $d3.="['".$i."',".get_com_yeji($i,$this->comid)."],";
								
								}
							  $d1=substr($d1,0,-1);
							  $d2=substr($d2,0,-1);
							  $d3=substr($d2,0,-1);
							
							
							
							
							
							
							
							
							$this->assign('geren',$d1);
							$this->assign('bumen',$d2);
							$this->assign('com',$d3);
							
							
							
							
							
							
					    $conditions['pid']=array('eq',$this->comid);
						$conditions['realname']=array('neq','');
						$condition = !empty($conditions) ? $conditions : '' ;
						$pageCount = M('User')->where($condition)->count();
						
						$listRows = empty($listRows) ? 15 : $listRows;
						$orderd = empty($orders) ? 'id DESC' : $orders;
						$paged = new page($pageCount, $listRows);
						$List = M('User')->Where($condition)->Order($orderd)->Limit($paged->firstRow.','.$paged->listRows)->select();      
						$pageContentBar = $paged->show();
						$this->assign('getList', $dataContentList);
						$this->assign('ul',$List);
						$this->assign('pageBar', $pageContentBar);
							$this->assign('role',$role);
							$this->assign("getList4",$list4);
				
				  
				   $rm=M('Talent')
				   ->Field('id,comid,realname,last_company,last_post,create_time')
				   ->where('comid='.$this->comid)->limit(8)->order(' id desc')->select();
				 
				// print_r($rm);
				  
				  $this->assign('rm',$rm);
				  
				 
			   
		 $this->display();
  
  
     }
	 
	 
	 
	 
	                   //时时检测权限
					   
					   public function get_role(){
						  
										  
							         
													$dt['uid']=$this->uid;
													$dt['role']=M('User')->where('uid='.$this->uid)->getField('role_id');
													
									  
									             Cookie::set('role_id',$dt['role'],60*60*60);
									  
									             echo Cookie::get('role_id');
							  		
													
							 				
										
													
											
									   
						   
						   }
	 
	 
	 
	 
	 
	 
	 
	 
	 
}
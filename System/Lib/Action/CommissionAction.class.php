<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-2-20
 * Time: 上午10:28
 * To change this template use File | Settings | File Templates.
 */
class CommissionAction extends GlAction
{             public $cid;
                  function _initialize(){
                          $this->cid=$_GET['cid'];
                  parent::_initialize();
				  parent::Checklogin();

             }

            //commission index
             public  function  index(){
                           parent::_checkPermission();
						      parent::teamer();
							  parent::bumen();
                          $uid =$_GET['uid'];
						  //查找出这个人所有的参与的cid
						  
                           $keyword=$_GET['keyword'];//查找候选人
						   
						   $cid_array=M("Candidate")->Field('id,realname')->where('realname like '.'"%'.$keyword.'%" and comid='.$this->comid)->select();
						   
						   
						   
						   foreach($cid_array as $k=>$v){
							       $cids[]=$v['id'];
							     }
							
						   $cids=implode(',',$cids); 
						   $cids && $condition['cid']=array('in',$cids);  	  
						      
							  
							  
							  
							  
							  
					   if($this->pid !=0 && $this->role_id > 2){ 
					 
					 
					      $cids=M("Nteam")->Field('cid,uid')->where('uid='.$this->uid)->select();
					      foreach($cids as $k=>$v){
						      
							  
						     $cids1[]=$v['cid'];
						  
						  
						  }
						  $cids3=implode(',',$cids1); 
						  $condition['cid']=array('in',$cids3);
						  
					  }else{
						   
						    $condition['comid']=$this->comid;
							
							
							if($uid){
								
								
								     
									
						      $condition['uid']=$uid;
								
								
								
								
								}
						  
						  }
						  
						  
						  
						           $executive_arm=$_GET['executive_arm'];
								   $executive_arm && $condition['department']=array('eq',$executive_arm); 
						  
						  
						   
						            $pageCount = $this->dao->where($condition)->count();
									$listRows = empty($listRows) ? 10 : $listRows;
									$orderd = empty($orders) ? 'id DESC' : $orders;
									$paged = new page($pageCount, $listRows);
						   
						   
						   
						   
						   $getList=$this->dao->where($condition)->Order($orderd)->Limit($paged->firstRow.','.$paged->listRows)->select();
					      // echo $this->dao->getLastSql();
						  
						   //获取总业绩=锁头所有业绩相加值
						   $zongyeji="";
						   //获取总佣金
						   $zongjine="";
					  	   foreach($getList as $k=>$v){
						   $ni='';
						   $juese=explode(',',$getList[$k]['persona']);
						   $tc=explode(',',$getList[$k]['bili']);
						   $ni=$this->get_juese($juese,$tc);
						   $getList[$k]['per']=$ni;
						   $zongyeji+=$v['yeji'];
						   $zongjine+=$v['commission'];
						   
						   //$getList['realname']="这是谁啊";
						   
						    
						}
						
						  
						  
						 $pageContentBar = $paged->show();
						 $this->assign("zongjine",$zongjine);	
					     $this->assign("zongyeji",$zongyeji);	
				         $this->assign("getList",$getList);
						  $this->assign('pageBar', $pageContentBar);
					     parent::_tpl('plus/index_list');
 

             }
              //commission 候选人佣金计算页面
             public function cid_list(){
                     parent::_checkPermission();
					if(!$this->cid){
					   parent::_message('error','条件丢失');	 
					}  
                    
					$condtion['did']=array('eq',$_GET['did']);
					$condtion['comid']=$this->comid;
					$count=$this->dao->where($condtion)->count();  
					
                    
					$cInfo=M('Collection')->find($_GET['did']);
					
					
					$cInfo['realname']=get_houxuan($cInfo['cid']);
					
					
					$cid_list=$this->dao->where($condtion)->select();
					
					
					
					foreach($cid_list as $k=>$v){
						  
						   $ni='';
						   $juese=explode(',',$cid_list[$k]['persona']);
						   $tc=explode(',',$cid_list[$k]['bili']);
						   
						   $ni=$this->get_juese($juese,$tc);
						      
						   $cid_list[$k]['persona1']=$ni;
						}
						
						
					//print_r($this->p_t_array);	
					$this->assign('cInfo',$cInfo);
					$this->assign('cid_list',$cid_list);
					parent::_tpl('plus/cid_list');


             }


             protected  function __set_commission1($cid){
				 
				       

                        // check up candidate's stage is or 9 ?
                        $stage=M('Candidate')->where('id='.$cid)->count();  
                        if($stage < 1){
							   
							   parent::_message('error',"$stage");
							
						}
					
						//start 
						//读取候选人佣金设置
						$ticheng=M("Ticheng")->where('cid='.$cid)->find();
						$ticheng=explode(',',$ticheng['ticheng']);
						//读取佣金基数
						$cid_jishu=M("Candidate")->where('id='.$cid)->find();
						$dz_jine=$cid_jishu['sjdz_jine'];
						$gid=$cid_jishu['gid'];
						$cid_jishu=$cid_jishu['jishu'];
						//读取候选人团队成员
						$Nteam=M('Nteam')->where('cid='.$cid)->select();
						//读取角色
						
						//之前的比例		
						$juese=$this->persona;
						 foreach($juese as $k=>$v){
							     $njuse.=$v['bili'].",";
							 }
						  
						//print_r($ticheng);
						//print_r($Nteam);
						
						foreach($Nteam as $k=>$v){
							
							    $data['uid']=$v['uid'];
								$data['cid']=$v['cid'];
								$data['gid']=$gid;
								$data['persona']=$v['persona'];
								$data['befor_bili']=$njuse;
								$persona=explode(',',$v['persona']);
								$fentc='';
								$zongtc=0;
								 foreach($ticheng as $c=>$d){
									      
										 if(in_array($c,$persona)){
										 $fentc.=$d.",";
										 $zongtc=$zongtc+intval($d);
										 }
									   }
								 
								$data['dz_jine']=$dz_jine;
								$data['jishu']=$cid_jishu;
								$data['commission']=$cid_jishu*$zongtc/100;
								$data['create_time']=time();
								$data['update_time']=time();
								$data['issue']=0;
								$data['bili']=$fentc;
								$data['zongbi']=$zongtc;
								
								
								$rs=$this->dao->add($data);
								
								if(!$rs){
									   
									  echo $this->dao->getLastSql();  
									  
									}
							
							} 
						
						
						 

             } 
			 
			 
			 //index——list
			 
			 public function index_list(){
				        parent::_checkPermission('Commission_index');
					   $gid=$_GET['gid'];
					   $where="gid=".$gid." and comid=".$this->comid;
					   $getList=$this->dao->where($where)->order('id desc')->select();
					   
					  	foreach($getList as $k=>$v){
						  
						   $ni='';
						   $juese=explode(',',$getList[$k]['persona']);
						   $tc=explode(',',$getList[$k]['bili']);
						   
						   $ni=$this->get_juese($juese,$tc);
						      
						  $getList[$k]['per']=$ni;
						  $getList[$k]['realname']=M('Candidate')->where('id='.$v['cid'])->getField('realname');
						  
						  
						  
						}
						
						//print_r($getList);
						
				       $this->assign("getList",$getList);
					   parent::_tpl('plus/index_list');
				 }
			 
			 //modfy commission
			 public function modfy(){
				  parent::_checkPermission();
				   if(!$this->id){
					   parent::_message('error','条件丢失');	 
					}  
				     $detail=$this->dao->find($this->id);
					 
					 
					 $zongshu=$this->dao->where('cid='.$detail['cid'].' and  did='.$detail['did'])->select();
					 $detail['yue']=0;
					 foreach($zongshu as $k=>$v){
						 
						      $detail['yue']+=$v['yeji'];
						 }
					
					 //可分配余额
					 
					 $detail['yue']=$detail['dz_jine']-$detail['yue']+10000;
					 
					 
					 $juese=explode(',',$detail['persona']);
					 $tc=explode(',',$detail['bili']);
					 $detail['juese']=$this->get_juese($juese,$tc);
					 
					 
					 $this->assign('detail',$detail);
				     parent::_tpl('plus/modfy');
				 }
				 
				 
				 //modfy commission
			 public function index_modfy(){
				  parent::_checkPermission('Commission_index');
				   if(!$this->id){
					   parent::_message('error','条件丢失');	 
					}  
				     $detail=$this->dao->find($this->id);
					 
					 
					 $zongshu=$this->dao->where('cid='.$detail['cid'].' and  did='.$detail['did'])->select();
					 $detail['yue']=0;
					 foreach($zongshu as $k=>$v){
						 
						      $detail['yue']+=$v['yeji'];
						 }
					 
					 //可分配余额
					 
					 $detail['yue']=$detail['dz_jine']-$detail['yue'];
					 
					 
					 $juese=explode(',',$detail['persona']);
					 $tc=explode(',',$detail['bili']);
					 $detail['juese']=$this->get_juese($juese,$tc);
					 
					 
					 $this->assign('detail',$detail);
				     parent::_tpl('plus/index_modfy');
				 }
				 
				 
			 //do modfy
			  
			  public function do_modfy(){
				       
					   $_POST['fa_time']=strtotime($_POST['fa_time']);
					   $_POST['update_time']=time();
					   parent::_do_modfy($this->dao,$su='更新成功',$err='更新失败',$_POST);
					   
				  }	 
				 
				 
				 
			  public  function get_juese($juese,$tc){       
	
	                       foreach($juese as $b=>$c){
                                        $ni.=$this->p_t_array[$c]."　".$tc[$b]."%<br/>";
								        }    
	                            return $ni;
	                            }
          
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		protected  function __set_commission($id){
				 
				       

                        // check up candidate's stage is or 9 ?
                        //读取是否在到账状态
						
						$ticheng=M("Ticheng")->where('cid='.$cid)->find();
						$ticheng=explode(',',$ticheng['ticheng']);
						//读取佣金基数
						$cid_jishu=M("Collection")->where('id='.$cid)->find();
						$dz_jine=$cid_jishu['sjdz_jine'];
						$gid=$cid_jishu['gid'];
						$cid_jishu=$cid_jishu['jishu'];
						//读取候选人团队成员
						$Nteam=M('Nteam')->where('cid='.$cid)->select();
						//读取角色
						
						//之前的比例		
						$juese=$this->persona;
						 foreach($juese as $k=>$v){
							     $njuse.=$v['bili'].",";
							 }
						  
						//print_r($ticheng);
						//print_r($Nteam);
						
						foreach($Nteam as $k=>$v){
							
							    $data['uid']=$v['uid'];
								$data['cid']=$v['cid'];
								$data['gid']=$gid;
								$data['comid']=$this->comid;
								$data['department_id']=$cid_jishu['department_id'];
								$data['group_id']=$cid_jishu['group_id'];
								$data['persona']=$v['persona'];
								$data['befor_bili']=$njuse;
								$persona=explode(',',$v['persona']);
								$fentc='';
								$zongtc=0;
								 foreach($ticheng as $c=>$d){
									      
										 if(in_array($c,$persona)){
										 $fentc.=$d.",";
										 $zongtc=$zongtc+intval($d);
										 }
									   }
								 
								$data['dz_jine']=$dz_jine;
								$data['jishu']=$cid_jishu;
								$data['commission']=$cid_jishu*$zongtc/100;
								$data['create_time']=time();
								$data['comid']=$this->comid;
								$data['update_time']=time();
								$data['issue']=0;
								$data['bili']=$fentc;
								$data['zongbi']=$zongtc;
								
								
								$rs=$this->dao->add($data);
								
								if(!$rs){
									   
									  echo $this->dao->getLastSql();  
									  
									}
							
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
                       $ids= implode(',',$_POST['id']);
                       if($operate=='3'){
                       $rs=$this->dao->where("id in ($ids)")->delete();
                                         if($rs){
									    if($_PSOT['ajax']!=1){
									      parent::_message('success', '删除成功',$_SERVER['HTTP_REFERER'].$_REQUEST['maodian'],$ajax=true);
										 }else{
											//echo "nihao";
										}
									}else{ 
								   parent::_message('error', '删除失败');
									}
							 }
								  elseif($operate=='1' || $operate=='0'){
								     $data['issue']=$operate; 
									 if($operate=='1'){
										 $data['fa_time']=time();
										 }else{
											 $data['fa_time']=0;
											}
								     $rs=$this->dao->where("id in ($ids)")->save($data);
							    	 // echo $this->dao->getLastSql();
								      if($rs){
									    if($_PSOT['ajax']!=1){
									      parent::_message('success', '更新成功',$_SERVER['HTTP_REFERER']."#".$_REQUEST['maodian'],$ajax=true);
										}else
										{
											//echo "nihao";
										}
										
										
										
										
									}else{ 
									 
										 parent::_message('error', '更新失败');
									}
									
							     //如果等13就更新已到账
								 
								 
								  
								  
								  
								  
								  
								 	
								}else{
								 parent::_message('error', '操作类型错误');
								}
								  
								  
								  
								  
							}
			 
			 
			 
			   

}

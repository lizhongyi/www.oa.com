<?php

/*业绩管理类*/

class YejiAction extends GlAction{
	
	          
			  
			         
				public function	 _initialize(){
					
					         $this->dao=D("yeji");
							 $this->id=$_GET['id'];
					
					        parent::_initialize();
							
					}
					 
			  
			   public function fenpei(){
				            
							
							
							
							
							
							
							
							
							
				                //生成业绩分配
								
								$houxuan_id=intval($_GET['houxuan_id']);
								$daozhang=M('candidate')->where("id=".$houxuan_id)->find();
								//符合条件
								
								/*取得提成比例*/
								
								$get_bili=M('set_ticheng')->where('candidate_id='.$houxuan_id)->limit('1')->find();
								unset($get_bili['id'],$get_bili['gid'],$get_bili['create_time'],$get_bili['candidate_id']);
								//print_r($get_bili);
								//exit;
								
								  
								  $works_arr=array(
								                         'xunfang'=>0,
								                         'mianshi'=>1,
								                         'goutong'=>2,
								                         'xiaoshou'=>3,
								                         'other'=>4
								                       
													   );
								  
								
								 foreach($get_bili as $k=>$v){
									      
										  $set_array[$k]=array('t_bili'=>$get_bili[$k],'work_nr'=>$works_arr[$k]);
									     
									 }
								 
								 
								
								
								/*
								
								$set_array=array(
								          'xunfang'=>array('t_bili'=>8,'work_nr'=> $works_content['xunfang']),
										  'goutong'=>array('t_bili'=>5,'work_nr'=>$works_content['goutong']),
										  'miashi'=>array('t_bili'=>10,'work_nr'=>$works_content['mianshi']),
										  'luru'=>array('t_bili'=>2,'work_nr'=>$works_content['luru']),
										  'xiaoshou'=>array('t_bili'=>2,'work_nr'=>$works_content['xiaoshou']),
										  'other'=>array('t_bili'=>2,'work_nr'=>$works_content['other'])
								);
								
								*/
								
							
								
								$daozhang['s']=$daozhang['stage'];
                                $yeji_count=$this->dao->where("candidate_id=".$houxuan_id)->count();
								
								    foreach($set_array as $k=>$v){
									   
									   if($set_array[$k]['t_bili']==0){
										    
											unset($set_array[$k]);
										   
										   }
									  
									
									 
									}
								
								
								 
								 
								 
								
							    if($daozhang['s']==9 && $yeji_count==0){
									 //满足跳进行写入操作
									   
									    //$work_arr=array('xunfang','mianshi','goutong','luru','other','xiaoshou');
										
									  
										foreach($set_array as $k=>$v){
										if($daozhang[$k]!=0){
										  $data['uid']=$daozhang[$k];
			                             }else{
											 $data['uid']=$daozhang['uid'];
											 }
										$data['gid']=$daozhang['gid'];	 
										$data['candidate_id']=$houxuan_id;
										$data['work_content']=$set_array[$k]['work_nr'];
										$data['ticheng_bili']=$set_array[$k]['t_bili'].'%';
										$data['yd_ticheng'] = $daozhang['jishu'] * $set_array[$k]['t_bili'] /100;                                        $data['ticheng_stauts']=0;
										$data['kouchu_jine']=0; 
										$data['jishu']=$daozhang['jishu'];
										$data['sjdz_jine']=$daozhang['sjdz_jine'];
										$data['create_time']=time();
										$rs=M("yeji")->add($data);
								
										
										}
									  //刷新当先页面	
									  
									 header("Location:".$_SERVER['PHP_SELF'].$_SERVER['QUERY_STRING']);
									
									}
									
									
									
									
									
									
									
									if($daozhang['s']==9 && $yeji_count!=0){
									 //满足跳进行写入操作
									   
									   
									   $daozhang['shengyu']=$daozhang['sjdz_jine']-$daozhang['zongticheng'];
									   $yeji_list=$this->dao->where("candidate_id=".$houxuan_id)->select();
									    
									   foreach($yeji_list as $k=>$v){
									   $zongbili='';
									   }
									  
									   $this->assign("daozhang",$daozhang);
									   $this->assign("yeji_list",$yeji_list);
									   $this->display('plus/fenpei'); 
									    
   									}
									
									
									
									
									
									
									
									
									
								
								
				   }
			   
			   
			 
			 
			
			  // 获取工作点全部业绩
			  
			
			 
			 public function yeji_list(){
				           
						   $gid=intval($_GET['gid']);
							$ajax=intval($_GET['ajax']);
							
						    $where="1=1 and gid=".$gid;
						    
							$condition = !empty($conditions) ? $conditions : '' ;
                            $pageCount = $this->dao->where($where)->count();
		
                            $listRows = empty($listRows) ? 10 : $listRows;
                            $orderd = empty($orders) ? 'id DESC' : $orders;
                            $paged = new page($pageCount, $listRows);
                            $dataContentList = $this->dao->Where($where)->Order($orderd)->Limit($paged->firstRow.','.$paged->listRows)->select();                  
							
							 $ajax==0 ? $pageContentBar = $paged->show() : $pageContentBar = $paged->show_ajax();
							 
                            $this->assign('getList', $dataContentList);
                            $this->assign('pageBar', $pageContentBar);
		                    $ajax==0 ? $this->display() : $this->display('plus/yeji_list');
								  
							
				                   
				 
				 
				 }
			 
			 
			 
			 
			 
			 //业绩搜索
			 
			 
			 public function search(){
				 
				       
					   
					
						    $gid=intval($_GET['gid']);
							$ajax=intval($_GET['ajax']);
							
						    $gid && $where="1=1 and gid=".$gid;
						    
							$condition = !empty($conditions) ? $conditions : '' ;
                            $pageCount = $this->dao->where($where)->count();
		
                            $listRows = empty($listRows) ? 10 : $listRows;
                            $orderd = empty($orders) ? 'id DESC' : $orders;
                            $paged = new page($pageCount, $listRows);
                            $dataContentList = $this->dao->Where($where)->Order($orderd)->Limit($paged->firstRow.','.$paged->listRows)->select();                  
							
							 $ajax==0 ? $pageContentBar = $paged->show() : $pageContentBar = $paged->show_ajax();
							 
                            $this->assign('getList', $dataContentList);
                            $this->assign('pageBar', $pageContentBar);
		                    $ajax==0 ? $this->display() : $this->display('plus/search');
								  
							
				                   
				 
				 
				
			 
			 
				 
				 
				 }
			 
			 
			 
			 
			 
			// 删除业绩列





             public function delete(){
				          
						  $id=intval($_GET['id']);
				      
					     parent::__deletes($this->dao,$id);
				 
				 
				 }

          
		    //修改业绩
		  
		     public function modfy(){
				 
				        $ajax=intval($_GET['ajax']);
					    $detail=$this->dao->where("id=".$this->id)->find();
						$this->assign('detail',$detail);
				        $this->ajax == 1 ? $this->display() : $this->display('plus/modfy'); 
				   
				 }
            //save do_modfy
			
	
				 
				  public  function do_modfy(){
						
						        $ajax=intval($_GET['ajax']);
						        $id=intval($_GET['id']);
								
								$data=$_POST;
								$data['id']=$id;
								$data['update_time']=time();
								
								
                                $rs=$this->dao->save($data);
								
							    if($rs){
							    
							               $data['ajax']==1? exit('ok') : parent::_message('success','添加成功',$_SERVER['HTTP_REFERER']);
		                                 }else{
							 
							               $data['ajax']==1? exit('err') : parent::_message('error','添加失败',$_SERVER['HTTP_REFERER']);
							 
							           }
								  
}

	
	
	}
?>

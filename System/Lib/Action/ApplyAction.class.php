<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-2-16
 * Time: 上午9:54
 * To change this template use File | Settings | File Templates.
 * className:Persona
 * dever:yige
 * ProjectName:jobmedia OA.
 */


class  ApplyAction extends GlAction{
	
	
	               public function _initialize(){
					     
						     parent::_initialize();
					    
					   }
	         
			 
			        public function index(){
					 
					 
					 
					}
					
					public function detail(){
						
						   $gid=$_GET['gid'];
						
						  
						   $wlist=M('Works')->where('id='.$gid)->find();
						   // echo $this->comid;
						  // print_r($wlist);
						   
						   $dt=$this->dao->where("gid=".$gid)->select();
						   
						   foreach($dt as $k=>$v){
							        $info=D('Resume')->where('uid='.$v['a_uid'])->find();
								    $dt[$k]['last_company']=$info['last_company'];
									$dt[$k]['post']=$info['post_cn'];
							   
							   }
							   
						
						    //消灭已读数字
							
							 foreach($dt as $k=>$v){
							        $d['read_id']=$dt['read_id'].','.$this->uid;
								    $rs=$this->dao->where('id='.$dt['id'])->save($d);
							   
							   }
						
						
						  
						   $this->assign('wt',$wlist);
						   $this->assign('dt',$dt);
			              
						   $this->display(); 
						   
						  
						   			
						}
						
						
						
						
						
						
						
						public function read(){
							
							      $gid=$_GET['gid'];
						
						  
						   $wlist=M('Works')->where('id='.$gid)->find();
				
						   $dt=$this->dao->where("gid=".$gid)->select();
						   
						
							   
						
						    //消灭已读数字
							
							 foreach($dt as $k=>$v){
								 
								 
								    $readArr=explode(',',$dt['read_id']);
									
									if(!in_array($this->uid,$readArr))
									{
								    $d['read_id']=$v['read_id'].','.$this->uid;
								    $rs=$this->dao->where('id='.$v['id'])->save($d);
									}
							   
							   }
						
						
						           redirect($_SERVER['HTTP_REFERER']);   
								   
								  // echo $this->dao->getLastSql();
						           
							
							
							}
	
	
	
	}





?>
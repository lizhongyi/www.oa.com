<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-2-19
 * Time: 下午15:49
 * To change this template use File | Settings | File Templates.
 * className:Ticheng
 * dever:yige
 * ProjectName:jobmedia OA.
 */

class TichengAction extends GlAction{
	
	       
	           //initialize
			   public function _initialize(){
				    
					parent::_initialize();
					parent::Checklogin();
					//$this->dao=D('Persona');
				      
				   }  
	           // index ActionNAME
               public function index(){
				   
				           parent::_checkPermission();
				          $cid=intval($_GET['cid']);
						
						  $ticheng=$this->dao->where('cid='.$cid)->find();
						  //读取团队成员
						  $Nteam=M("Nteam")->where('cid='.$cid)->select();
						  $juese="";
						  foreach($Nteam as $k=>$v){
							     $juese.=$v['persona'].","; 
							   }
						  $juese=substr($juese,0,strlen($juese)-1);	    
						  $juese=explode(',',$juese);
						  sort($juese);
						 // print_r($juese);
						  $tarray=explode(',',$ticheng['ticheng']);
						 
						  $setlist=$this->persona;
					
						  
						  
						  foreach($setlist as $k=>$v){
						        $setlist[$k]['tc']=$tarray[$k];
						     }
							 
							foreach($setlist as $k=>$v){
								
						        if(!in_array($k,$juese)){
									 $setlist[$k]['dis']='hide';
									}
						     } 
						 // print_r($setlist);
						  
						  
							   
							   
						    //print_r($setlist);
						   $this->assign('getList',$setlist);
						   parent::_tpl('plus/index');
						 
						}	
	
	            // add Action
				public function add(){
					             parent::_checkPermission();
					
					           parent::_tpl('plus/index');
					
					   }
				
				
				// add Action
				public function do_add(){
					            
								//echo $this->ajax;
								    $data=$_POST;
									$cid=intval($_GET['cid']);
									//先取得候选人佣金非配状态，如果已经分配，则不允许提交
									
									$fen=M('Candidate')->Field('id,fenpei')->where('id='.$cid)->getField('fenpei');
									
									if($fen==1){
										
										 parent::_message('error',"保存失败,该候选人已经分配佣金不可再修改比例",1);
										
										}
									
							      if($_POST['ticheng']==""){
 									    parent::_message('error','字段不能为空',1);
								      }else{
									             
											    $rs=$this->dao->where('cid='.$cid)->save($data);
											    if($rs){
												   parent::_message('success','添加成功',1);
												   }else{
													  parent::_message('error',"保存失败,原因可能是您并未作出改动",1);
												 }
										  
                                           
										  
									   
								  }
							 
					
					   }	   
					   
				// modfy Action
				public function modfy(){
					             parent::_checkPermission();
					           parent::_tpl('plus/index');
					
					   }	   
	
	
	}




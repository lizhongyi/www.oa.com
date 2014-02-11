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

class PersonaAction extends GlAction{
	
	       
	           //initialize
			   public function _initialize(){
				    
					parent::_initialize();
					parent::Checklogin();
					//$this->dao=D('Persona');
					
				   
				   }  
	           // index ActionNAME
               public function index(){
				           parent::_checkPermission();
						 
						  $where="comid=$this->comid";
						  $setlist=$this->dao->where($where)->order('id asc')->select();
					     //$setlist=getCache('persona');
						 //不显示没有添加的提成
						 
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
					            parent::_checkPermission();
								//echo $this->ajax;
								
							   if($_POST['title']==""){
 									parent::_message('error','字段不能为空',1);
								  }else{
									 $title=explode(',', htmlCv($_POST['title']));
									 $bili=explode(',', htmlCv($_POST['bili']));
									  $title=(array_unique($title));
									    
									   $this->dao->create();	
									   //判断删除是否重复
									   $del=$this->dao->where('comid='.$this->comid)->delete();
									   $v=0;
									   if($del){
									   foreach($title as $k=>$v){
										      
											  $data['title']=$title[$k];
											  $data['bili']=$bili[$k];
											  $data['create_time']=time();
											  $data['comid']=$this->comid;
											  $data['uid']=$this->uid;
											  $rs=$this->dao->add($data);
											  if($rs){
												  $v=v+1;
												  }else{
													  parent::_message('error',"出错咯",1);
													  }
										   }
									       writeCache($name='Persona');
                                           parent::_message('success',"保存成功",1);
										  
									   
									   }
								  }
							 
					
					   }	   
					   
				// modfy Action
				public function modfy(){
					
					           parent::_tpl('plus/index');
					
					   }	   
	
	
	}




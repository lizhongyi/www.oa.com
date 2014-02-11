<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-3-14
 * Time: 下午15:49
 * To change this template use File | Settings | File Templates.
 * className:Hr_contacts Action
 * dever:yige
 * ProjectName:jobmedia OA.
 */
 
 class Hr_contactsAction extends GlAction{
	 
	    
	    public function _initialize(){
			
			           parent::_initialize();
					   parent::Checklogin();
					   
			
			}   
			
	    public function index(){
			    
				$cid=$this->_get('cid');
				if(!$cid) return false;
				$getList=$this->get_hr_list($cid);
			
				$this->assign('hr_list',$getList['getlist']);
		  		parent::_tpl('plus/index');
			
			} 
	      
		  
		public function  get_hr_list($cid){
			
			              if(!$cid) return false;
						  $where=" 1=1 ";
						  //$condition = !empty($conditions) ? $conditions : '' ;
						  $cid && $where.='and company_id ='.$cid;
                          $pageCount = $this->dao->where("company_id=".$cid)->count();
						  $listRows = empty($listRows) ? 15 : $listRows;
						  $orderd = empty($orders) ? 'id DESC' : $orders;
						  $paged = new page($pageCount, $listRows);
				          $getlist=M("Hr_contacts")->where($where)->Order($orderd)->select();
						  $ajax==0 ? $pageContentBar = $paged->show() : $pageContentBar = $paged->show_ajax();             
						 // print_r($getlist);
						 
						  return array('getlist'=>$getlist,'pagelist'=>$pageContentBar);		
						   
			}  
	 
	  
	  
	  //添加面板
	   
	    public function add(){
		                   parent::_tpl('plus/add');		   
		         }
	  
	   //修改面板
	   
	   public function  modfy(){
		     
		                        $id=intval($_GET['id']);
						        if($id!=0){
							    $hr_modfy=$this->dao->where('id='.$id)->find();                               //print_r($hr_modfy);
								$this->assign('hr_modfy',$hr_modfy);
					            parent::_tpl('plus/modfy');
								
								
							
							}else{
								 
								 exit();
								 
								} 
		   
		   
		   
		   }
	   //写入操作
	   
	   public function do_add(){
		   
		            $do=$this->dao->create();
					
					if($do){
						  
						  $rs=$this->dao->add();
						      
							  if($rs){
								     
									parent::_message('success','添加成功');
									  
								  }else{
									  
									  parent::_message('error','添加失败');
								}
						
					}
		   }
	 
	  
	   //删除操作
	   
	   public function delete(){
		   
		                if(!$this->id) return false;
						
						
		                $rs=D('Hr_contacts')->where('id='.$this->id)->delete();
						
						if($rs){
							
								parent::_message('success','删除成功',$_SERVER['HTTP_REFERER']);
							
							}else{
								parent::_message('error','删除失败');
								}
						
		   
		   
		   
		   }
	 
	 
	 
	 
	 
	 }
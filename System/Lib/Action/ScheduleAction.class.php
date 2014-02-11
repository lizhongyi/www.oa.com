<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-4-2
 * Time: 上午11:51
 * To change this template use File | Settings | File Templates.
 * className:schedule
 * dever:yige
 * ProjectName:jobmedia OA.
 */
 
 class scheduleAction extends GlAction{
	 
	     //init
		 
		 public function _initialize(){
			     
				 parent::_initialize();
				 parent::Checklogin();
			 
			 }
	    
		 //index
		 
		public function index(){	 
			        
					 
				  
				    $this->display();
			 
			 }
		
	     
		public function index_json(){
			
			       
				   
				     $condition['uid']=$this->uid; 
					 if($_GET['st']==""){
						 
						  exit('time is null');
						  
						 }
					 $condition['start_time']=array('gt',$_GET['st']);
					 $condition['start_time']=array('lt',$_GET['end']);
					// print_r($condition);
					 $getList=$this->dao->Field('id,title,start_time,end_time')->where($condition)->select();
					 
					 foreach($getList as $k=>$v){
						 
						
							
						    $getList1[$k]['title']=$v['title'];

							
						    $getList1[$k]['start']=substr(date('l',$v['end_time']),0,3).date(' M d Y H:i:s',$v['start_time']);
							if(date('H',$v['start_time'])=='00'){
							//$getList1[$k]['allDay']=true;
							}else{
								$getList1[$k]['allDay']=false;
							}
							
							if($v['end_time'] > 0){
								 $getList1[$k]['end']=substr(date('l',$v['end_time']),0,3).date(' M d Y H:i:s',$v['end_time']);
								}
								
							$getList1[$k]['url']=U('Schedule/detail',array('ajax'=>1,'id'=>$v['id']));	
								
							
						 }
					echo  $ds=json_encode($getList1);
					
				   
			 
			} 
	 
	    public function add(){
			     
				 parent::_tpl('plus/add');
			    
			 }
	    //do save 
	    
		public function do_add(){
			
			     
				 $dao=$this->dao->create();
				 
				 if($dao){
					     
						 $this->dao->start_time=strtotime($_POST['start_time'].' '.$_POST['sshi'].':'.$_POST['sfen']);
						 if(strtotime($_POST['end_time']) != 0){
						 $this->dao->end_time=strtotime($_POST['end_time'].' '.$_POST['eshi'].':'.$_POST['efen']);
						 }else{
							 $this->dao->end_time=0;
							 }
							 
						 $this->dao->uid=$this->uid;	 
						 $rs=$this->dao->add();
						 
						 if($rs){
							    
								
								parent::_message('success','添加成功',$rs);
								
							 }else{ 
							 
							     exit($this->dao->getLastSql());
								 parent::_message('success','添加失败');
								 }
					     
					 
					    }else{
							 
							  exit($this->dao->getError());
							
							}
			
			}
			
		  //do_modfy
		  
		  public function do_modfy(){
			      
				  
				  
				  
				  $dao=$this->dao->create();
				 
				 if($dao){
					     
						 $this->dao->start_time=strtotime($_POST['start_time'].' '.$_POST['sshi'].':'.$_POST['sfen']);
						 if(strtotime($_POST['end_time']) != 0){
						 $this->dao->end_time=strtotime($_POST['end_time'].' '.$_POST['eshi'].':'.$_POST['efen']);
						 }else{
							 $this->dao->end_time=0;
							 }
						 $rs=$this->dao->save();
						 
						 if($rs){
							    
								parent::_message('success',"保存成功");
							 
							 }else{ 
							 
							     exit($this->dao->getLastSql());
								 parent::_message('success','保存失败');
								 }
					     
					 
					    }else{
							 
							  exit($this->dao->getError());
							
							}
				  
			  
			  }	
	 
	     // detail 
		 
		 public function detail(){
			      
				  parent::checkId();
				  
			     $dt=$this->dao->where('id='.$this->id)->find();
				 $this->assign('dt',$dt);
				  parent::_tpl('plus/detail');
				 
			    
			 }
			 
		 public function delete(){
			       
				    parent::checkId();
					$rs=$this->dao->where('id='.$this->id)->delete();
					if($rs){
						  
						  parent::_message('success','删除成功');
						
						}else{
							
							 parent::_message('error','删除失败');
							}
					
			 
			 }	 
	 
	 
	 }
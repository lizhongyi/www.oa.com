<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-2-16
 * Time: 上午9:54
 * To change this template use File | Settings | File Templates.
 * className:ServantRole
 * dever:yige
 * ProjectName:jobmedia OA.
 */
 
 class StaffRoleAction extends GlAction{
	       
		   
		   public function  _initialize(){
			   
			   
			        parent::_initialize(); 
					parent::Checklogin();
			        
			   
			   }
	       
		   //权限首页
		    public function index(){
			           parent::teamer();
					  
				
					  $dataList = $this->dao->Where($condition)->Order('id DESC')->select();

						if($dataList !== false)
				
						{
				
							$this->assign('dataList', $dataList);
				
						}

							//parent::_sysLog('index');
						$this->display();	
					
			   }		 
	 
	        public function  add(){
				   
				   
				   
			
					  $dataList = M('Module')->select();
			  
					  $this->assign('dataList', $dataList); 
				      $this->display();
				} 
				
				
			public function  do_add(){
				
				       parent::_setMethod('post');
					   
					   //判断是否有重复名字的数据
					   
					   $rs=$this->dao->where('comid='.$this->comid.' and title="'.$_POST['title'].'"')->count();
					  
					    if($rs >0){
						        
								exit('录入失败，权限组名称重复');
							   
						   }

        if($daoCreate = $this->dao->create())

        {    

             $this->dao->role_permission = empty($_POST['role_permission']) ? 'all' : implode(',', $_POST['role_permission']) ;
             $this->dao->comid=$this->comid;
			 $this->dao->create_time=time();
             $daoAdd = $this->dao->add();

            if(false !== $daoAdd)

            {

                writeCache('StaffRole');

                //parent::_sysLog('insert', "录入:$daoAdd");

                parent::_message('success', '录入成功');

            }else

            {

                parent::_message('error', '录入失败');

            }

        }else

        {

            parent::_message('error', $this->dao->getError());

        }

				} 	
	         
			 
			 public function modfy(){
				 
				 
				 
				     $item = $this->id;
					  in_array($item, array(1)) && parent::_message('error', '内置角色组不允许编辑');
					  $adminRoleRecord = D('StaffRole')->Where('id='.$item)->find();
					  if (empty($item) || empty($adminRoleRecord)) parent::_message('error', '记录不存在');
					  $dataList = D('Module')->where('type <> 2')->select();
					  $this->assign('dataList', $dataList);
					  $this->assign('vo', $adminRoleRecord);
					  $this->display();
				 
				}
		 
		 
		     public function do_modfy(){
				 
				        //parent::_checkPermission('Admin_modify');
						parent::_setMethod('post');
						$item = intval($_POST['id']);
						empty($item) && parent::_message('error', '记录不存在');
						in_array($item, array(1, 2)) && parent::_message('error', '内置角色组不允许编辑');
						if($daoCreate = $this->dao->create())
						{
							$this->dao->role_permission = empty($_POST['role_permission']) ? 'all' : implode(',', $_POST['role_permission']) ;
							$this->dao->update_time=time();
							$daoSave = $this->dao->save();
							if(false !== $daoSave)
							{
								writeCache('StaffRole');
								//parent::_sysLog('modify', "编辑:$item");
								parent::_message('success', '编辑成功');
							}else
							{
							 
											 parent::_message('error','编辑失败,原因可能您没有做任何更改');

							}
						}else
						{
							parent::_message('error', $this->dao->getError());
						}
				 
				}
		 
	 
	    
		
		  public  function delete(){
			  
			         if($this->id){
						 
						    $rs=$this->dao->where('systeam != 1 and id='.$this->id)->delete();
							
							if($rs){
								
								      parent::_message("success",'删除成功！');
								 }else{
									   
									  parent::_message("error",'删除失败！'.$this->dao->getError()); 
									 
									 }
						 
						 }
			  
			  
			  }
		   
	 
	 
	 
	 }
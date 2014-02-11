<?php
/**
 * Created by ADdobe DW cs6.
 * User: Administrator
 * Date: 13-5-15
 * Time: PM 14:49
 * To change this template use File | Settings | File Templates.
 * className:Persona
 * dever:yige
 * ProjectName:jobmedia OA.
 */
 
 class UserAction extends GlAction{
	 
	          function _initialize(){
				  
				       parent::_initialize();
					   $this->dao=D('User');
				  
				  }
	 
	 
	         //index
			 
			 function index(){
				 
				 
				              $pageCount = $this->dao->where($condition)->count();
							  $listRows = empty($listRows) ? 18 : $listRows;
							  $orderd = empty($orders) ? 'uid DESC' : $orders;
							  $paged = new page($pageCount, $listRows);
							  $list = $this->dao->Where($condition)
							                        ->Order($orderd)
							                        ->Limit($paged->firstRow.','.$paged->listRows)
													->select();  
													
						      $pageBar = $paged->show();				
					         $this->assign('list',$list);
                             $this->assign('pageBar',$pageBar);
					
				    $this->display();
    }



	 public function add(){

	   $this->display();
    }


	public function edit(){
	   $this->display();
    }

				  
				 
	 
	 
	 
	 
	 
	 
	 
	 }
 
 
?>
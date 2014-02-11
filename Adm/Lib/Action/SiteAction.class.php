<?php
class SiteAction extends Action {
	


	function __construct(){
	 	 Vendor('Init.Loader');
		 parent::__construct();
		 
		  if (Inits::CheckLogin()){
			  $this->error('登录失败！','__APP__/Index/Login');
		}



		 
	}
	
	



	 public function main(){
	   	   $config = D("config");
		   $arr = array();
		   $config = $config->select();
		   foreach($config as $k=>$s){
			    $arr[$s['name']] = $s['value'];
			   
		   }
		$this->assign("config",$arr);
	    $this->display();
    }




	 public function sitemail(){
		$mailconfig = D("mailconfig");
		$mailconfig = $mailconfig->select();
		   foreach($mailconfig as $k=>$s){
			    $arr[$s['name']] = $s['value'];
			   
		}
		$this->assign("mailconfig",$arr);
		$this->assign("config",$arr);
	    $this->display();
    }



	 public function area(){
		$class = D("area");
		
		
		$district = $class->where(" parentid ='0' ")->select();
		
		$sdistrict  =array();
		foreach ($district as $k=>$v){
		  $sdistrict['id']              = $v['id'];
		  $sdistrict['parentid']        = $v['parentid'];
		  $sdistrict['categoryname']    = $v['categoryname'];
		  $sdistrict['parent_id']       = $v['parent_id'];
		  $sdistrict['parent_name']     = $v['parent_name'];
		  $sdistrict['category_order']  = $v['category_order'];
		  $sdistrict['sub']             = $class->where(" parentid ='".$v['id']."' ")->select();
		  $arr[]                        = $sdistrict;
		}
		
		$this->assign("district",$arr);
	    $this->display();
    }



	 public function cateclass(){
		$class = D("class");
		
		
		$district = $class->where(" parentid ='0' ")->select();
		
		$sdistrict  =array();
		foreach ($district as $k=>$v){
		  $sdistrict['id']              = $v['id'];
		  $sdistrict['parentid']        = $v['parentid'];
		  $sdistrict['categoryname']    = $v['categoryname'];
		  $sdistrict['parent_id']       = $v['parent_id'];
		  $sdistrict['parent_name']     = $v['parent_name'];
		  $sdistrict['category_order']  = $v['category_order'];
		  $sdistrict['sub']             = $class->where(" parentid ='".$v['id']."' ")->select();
		  $arr[]                        = $sdistrict;
		}
		
		$this->assign("district",$arr);
	    $this->display();
    }



	 public function industry(){
		$class = D("industry");
		
		
		$district = $class->where(" parentid ='0' ")->select();
		
		$sdistrict  =array();
		foreach ($district as $k=>$v){
		  $sdistrict['id']              = $v['id'];
		  $sdistrict['parentid']        = $v['parentid'];
		  $sdistrict['categoryname']    = $v['categoryname'];
		  $sdistrict['parent_id']       = $v['parent_id'];
		  $sdistrict['parent_name']     = $v['parent_name'];
		  $sdistrict['category_order']  = $v['category_order'];
		  $sdistrict['sub']             = $class->where(" parentid ='".$v['id']."' ")->select();
		  $arr[]                        = $sdistrict;
		}
		
		$this->assign("district",$arr);
	    $this->display();
    }






	 public function industry_all_save(){
		
		
		if (is_array($_POST['save_id']) && count($_POST['save_id'])>0)
	    {
			
			
		$class = M("industry");
		for ($i =0; $i <count($_POST['save_id']);$i++){
			if (!empty($_POST['categoryname'][$i]))
			{	
		       $class->execute("update __TABLE__ SET categoryname='".trim($_POST['categoryname'][$i])."',
												     category_order='".trim($_POST['category_order'][$i])."' 
													 WHERE id='".intval($_POST['save_id'][$i])."'");
			 }
		}
		}
		
		if (is_array($_POST['add_pid']) && count($_POST['add_pid'])>0)
	    {
			for ($i =0; $i <count($_POST['add_pid']);$i++){
				if (!empty($_POST['add_categoryname'][$i]))
				{
					$data['categoryname']   = trim($_POST['add_categoryname'][$i]);
					$data['category_order'] = intval($_POST['add_category_order'][$i]);
					$data['parentid']       = intval($_POST['add_pid'][$i]);
					$class->data($data)->add();
				}
	
			}
	    }
		$this->success('更新成功！');
    }


	 public function cateclass_all_save(){
		
		
		if (is_array($_POST['save_id']) && count($_POST['save_id'])>0)
	    {
			
			
		$class = M("class");
		for ($i =0; $i <count($_POST['save_id']);$i++){
			if (!empty($_POST['categoryname'][$i]))
			{	
		       $class->execute("update __TABLE__ SET categoryname='".trim($_POST['categoryname'][$i])."',
												     category_order='".trim($_POST['category_order'][$i])."' 
													 WHERE id='".intval($_POST['save_id'][$i])."'");
			 }
		}
		}
		
		if (is_array($_POST['add_pid']) && count($_POST['add_pid'])>0)
	    {
			for ($i =0; $i <count($_POST['add_pid']);$i++){
				if (!empty($_POST['add_categoryname'][$i]))
				{
					$data['categoryname']   = trim($_POST['add_categoryname'][$i]);
					$data['category_order'] = intval($_POST['add_category_order'][$i]);
					$data['parentid']       = intval($_POST['add_pid'][$i]);
					$class->data($data)->add();
				}
	
			}
	    }
		$this->success('更新成功！');
    }



	 public function area_all_save(){
		
		
		if (is_array($_POST['save_id']) && count($_POST['save_id'])>0)
	    {
			
			
		$class = M("area");
		for ($i =0; $i <count($_POST['save_id']);$i++){
			if (!empty($_POST['categoryname'][$i]))
			{	
		       $class->execute("update __TABLE__ SET categoryname='".trim($_POST['categoryname'][$i])."',
												     category_order='".trim($_POST['category_order'][$i])."' 
													 WHERE id='".intval($_POST['save_id'][$i])."'");
			 }
		}
		}
		
		if (is_array($_POST['add_pid']) && count($_POST['add_pid'])>0)
	    {
			for ($i =0; $i <count($_POST['add_pid']);$i++){
				if (!empty($_POST['add_categoryname'][$i]))
				{
					$data['categoryname']   = trim($_POST['add_categoryname'][$i]);
					$data['category_order'] = intval($_POST['add_category_order'][$i]);
					$data['parentid']       = intval($_POST['add_pid'][$i]);
					$class->data($data)->add();
				}
	
			}
	    }
		$this->success('更新成功！');
    }




	
	
	public function email_testing_sends(){
		if (Inits::phpmailer($_POST['check_smtp'])){
			$this->success('发送成功！');
		}else{
			$this->error('发送失败！','__APP__/Site/sitemail');
		}
    }
	
	
	
	
	
	
	public function cateclass_del(){
		$class  = M("class");
		$class->find(intval($_GET['id']));
		$class->delete(); 
		$this->success('删除成功！');
    }
	


	public function industry_del(){
		$class  = M("industry");
		$class->find(intval($_GET['id']));
		$class->delete(); 
		$this->success('删除成功！');
    }
	
	
	
	
	
	
	 public function email_testing(){
	   
	   	Vendor('Phpmailer.phpmailer');
		
		$mailconfig = D("mailconfig");
		$mailconfig = $mailconfig->select();
		   foreach($mailconfig as $k=>$s){
			    $arr[$s['name']] = $s['value'];
			   
		}
		$this->assign("mailconfig",$arr);
		
		
		
		$this->assign("config",$arr);
	    $this->display();
    }

 
     public function email_set_save(){
	  
	   foreach($_POST as $k=>$v){
		   $mailconfig = M("mailconfig");
		   $mailconfig->execute("update __TABLE__ SET value='$v' WHERE name='$k'");
	  }
	   
		$this->success('更新成功！');
	
	
	}

	 public function main_set_save(){
	   


	   
	   foreach($_POST as $k=>$v){
		   $config = M("config");
		   $config->execute("update __TABLE__ SET value='$v' WHERE name='$k'");
	   }
	   
		$this->success('更新成功！');
	   
	
		
		exit;
    }










	 public function left(){
       
	   $this->display();
    }



}

?>
<?php
class AdminAction extends Action {
	


	function __construct(){
	 	 Vendor('Init.Loader');
		 parent::__construct();
		  if (Inits::CheckLogin()){
			  $this->error('登录失败！','__APP__/Index/Login');
		}

		 
	}

	 public function main(){
	    $admin = M('admin');
		$list = $admin->select();
		$this->assign('list',$list);
	    $this->display();
    }




	public function add_users(){
	    $this->assign('ip',get_client_ip());
	    $this->display();
    }
	
	
	public function add_users_save(){
	   
	   $admin = D("admin");
	   $data = array();
	   $data['admin_name']     = strip_tags($_POST['admin_name']);
	   $data['email']          = strip_tags($_POST['email']);
	   $data['pwd']            = strip_tags($_POST['password']);
	   $data['last_login_ip'] = strip_tags($_POST['ip']);
	   $data['add_time']       = strip_tags(time());
	   $result = $admin->add($data);
	   if ($result){
		 $this->success("添加成功");
	   }else{
		 $this->error("添加失败");   
	   }

	   
    }




	 public function left(){
       
	   $this->display();
    }



}

?>
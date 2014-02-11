<?php
class MembersAction extends Action {
	
	function __construct(){
	 	 Vendor('Init.Loader');
		 parent::__construct();
		  if (Inits::CheckLogin()){
			  $this->error('��¼ʧ�ܣ�','__APP__/Index/Login');
		}

		 
	}
	


	 public function main(){
		$Form = M('members'); 
        import("ORG.Util.Page");       //�����ҳ�� 
        $count = $Form->count();    //�������� 
        $p = new Page($count, 20); 
        $list = $Form->where('`delete` =0')->limit($p->firstRow . ',' . $p->listRows)->order('reg_time desc')->select(); 
        $page = $p->show(); 
		//print_r($page);
        $this->assign("page", $page); 
        $this->assign("list", $list); 
	   $this->display();
    }



	 public function add(){

	   $this->display();
    }


	public function edit(){
	   $this->display();
    }


	public function left(){
	   $this->display();
    }


	public function addusers(){
	   $this->assign('ip',get_client_ip());
	   $this->display();
    }
	
	public function addusers_save(){
	   
	   $admin = D("members");
	   $data = array();
	   $data['username']     = strip_tags($_POST['admin_name']);
	   $data['email']          = strip_tags($_POST['email']);
	   $data['password']       = strip_tags($_POST['password']);
	   $data['reg_ip']         = strip_tags($_POST['ip']);
	   $data['reg_time']       = strip_tags(time());
	   $data['pid']            = intval("0");
	   $data['groupid']        = intval("0");
	   
	   $result = $admin->add($data);
	   if ($result){
		 $this->success("��ӳɹ�");
	   }else{
		 $this->error("���ʧ��");   
	   }

	   
    }
	
	
	function addusers_update(){
		  if($_POST['tuid']['0']==""){
			 $this->error("��ѡ���û�ɾ����");   
		  }
		  
		  $members = M("members"); // ʵ����User����
		  foreach($_POST['tuid'] as $k=>$s){
		   $members->find($s);	
		   $members->delete = '1'; // �޸����ݶ���
		   $members->save(); // ���浱ǰ���ݶ���
		 }
	
	      exit;
	}





}
?>
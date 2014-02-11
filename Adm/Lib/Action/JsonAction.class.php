<?php
class JsonAction extends Action {
	
    public function AcheckUser(){

	$model = M("admin");

	$cs = $model->query("select count(*) as b from __TABLE__ where admin_name='".strip_tags($_REQUEST['param'])."'");
		 if ($cs['0']['b']<=0){
			exit("y");
		 }else{
			exit("用户名已被占用")	 ;
		 }
    }



    public function McheckUser(){
		$model = M("members");
		$cs = $model->query("select count(*) as b from __TABLE__ where username='".strip_tags($_REQUEST['param'])."'");
		 if ($cs['0']['b']<=0){
			exit("y");
		 }else{
			exit("用户名已被占用")	 ;
		 }
    }


    public function McheckEmail(){
		$model = M("members");
		$cs = $model->query("select count(*) as b from __TABLE__ where email='".strip_tags($_REQUEST['param'])."'");
		 if ($cs['0']['b']<=0){
			exit("y");
		 }else{
			exit("邮箱已被占用")	 ;
		 }
    }

	






}

?>
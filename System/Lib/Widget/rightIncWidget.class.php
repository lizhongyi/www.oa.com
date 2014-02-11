<?php
class rightIncWidget extends Widget{
	
	
    public function render($data){ 
	
				   
				   
				   $ulist=M('User')->Field('realname,username,uid,pid,department')->where('pid='.Cookie::get('comid').' and uid <>'.Cookie::get('uid')." and status=1 or uid=".Cookie::get('comid')." and uid <>".Cookie::get('uid')." and status=1" )->select();  
				   
				   foreach($ulist as $k=>$v){
					      
						  if($v['realname']==""){
							   $ulist[$k]['realname']=$v['username'];
								 }
					   $ulist[$k]['tome']=M('Im')->where('fauid='.$v['uid']." and touid=".Cookie::get('uid')." and read_id=0")->count();
					   
					   $ulist[$k]['online']=M('User_online')->where('uid='.$v['uid'])->getField('status');
					   
	}
				      
				       $data['ulist']=$ulist;
					   
				 
				   
				   
	               $data['module']=MODULE_NAME;
	
	
        $ct=$this->renderFile('',$data);
		
		return $ct;
        
   } 
}
 

?>
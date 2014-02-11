<?php
class GlAction extends Action{
	
	   public $globalMenu;
	   public $ajax;
	   public $id;
	   public $persona;
	   public $user_list;
	 
	   public $groupid;
	   public $group;
	   public $uid; 
	   public $comid;
        /*
	        初始化
	    */
	         function _initialize(){  
			  $this->ajax=intval($_REQUEST['ajax']);
			  $this->id=intval($_REQUEST['id']);         
		     
			  $memcache = new Memcache;
			  $memcache->connect("127.0.0.1", 11211) or die ("Could not connect");
			   
			   
			   
			  $this->dao=D(MODULE_NAME) ;   
	          include_once('./includes/array.php');	
			    $this->assign("select",$public_arr);
              $this->cuname         = Cookie::get('username'); 
		      $this->uid            = Cookie::get('uid'); 
			  $this->pid            = Cookie::get('pid');
			  $this->post            = Cookie::get('post');
			  $this->utype           = intval(Cookie::get('type'));
		      $this->level          = Cookie::get('level');
			  $this->department     = Cookie::get('department');
			  $this->role_id        = Cookie::get('role_id');
			  $this->realname=      Cookie::get('realname');
			  $this->permission_tile = Cookie::get('permission_tile');
			  $this->permission = Cookie::get('permission');
			  		 
			       //获取公司ID采用递归
				   if($this->pid != 0){
				   $this->comid=$this->pid;
				   }else{
				   $this->comid=$this->uid;
					   }
					
					
					
					
					if($this->role_id == 4){
									 redirect('/Login/disabled');
									}
						
				  if($this->p_t_array ==""){		
				  $juese=M('Persona')->where('comid='.$this->comid)->order('id asc')->select();
				  $this->persona=$juese;
				  
				  foreach($this->persona as $k=>$v){
					     $nt[]=$v['title'];
					  }
				  
				  Session::set('p_t',$nt,60*60*24,30);	
				  Cookie::set('p_t',$nt,60*60*24,30);
				  $this->p_t_array=Cookie::get('p_t');
				  }
				 
				  $jobs=M('Works')->where("comid=$this->comid and display=1")->count();
				  $candidate=M('Candidate')->where("comid=$this->comid and stage>6")->count();
				  $yeji=M('Commission')->Field('yeji')->where('uid='.$this->uid)->select();
				  $ye=0;
				  foreach($yeji as $k=>$v){
					     
						 $ye+=$v['yeji'];  
						  
					      
					  }
				  
				  //权限设置普通用户不能访问的模块
				  
				  
				   if($this->level==0){
					 $levelname="普通用户";
					 }else if($this->level==1){
					 $levelname="VIP会员";
					 }else if($this->level==2){
					 $levelname="VIP用户"; 
					}
				  
				  
			      $this->pb_arr=$public_arr;
	              $this->assign('uname', $this->cuname);
		          $this->assign('uid', $this->uid);
				   $this->assign('comid', $this->comid);
		          $this->assign('pid',$this->pid);
				  $this->assign('jobs',$jobs);
				  $this->assign('yeji',$ye);
				  $this->assign('candidate',$candidate);
		          $this->assign('permission_tile',$this->permission_tile);
				  $this->assign('role_id',$this->role_id);
			      $this->assign('utype',$this->utype);
				  $this->assign('level_name',$levelname);
				  $this->assign('module',MODULE_NAME);
				  $this->assign('action',ACTION_NAME);
				       
        //导入函数
        Load('extend');
        include('./includes/Page.class.php');
	   //生成行业js文件
	   if(!file_exists('./Static/skin/js/industry.js')){
		   
		    $industry=M("industry")->select();
			$industry="var industry=".json_encode($industry).';function get_industry(id){document.write(industry[id].categoryname);}';
			$industry=file_put_contents('./Static/skin/js/industry.js',$industry);
		    $industry ?"":exit('cuowu');
	   }
	   
	   
	   //生成地区js文件
	   if(!file_exists('./Static/skin/js/area.js')){
		   
		    $area=M("area")->select();
			$area="var area=".json_encode($area);
			$area=file_put_contents('./Static/skin/js/area.js',$area);
		    $area ?"":exit('cuowu');
	   }
		
		
		   /*//公共user_list_json 列表
		    $parm="&uid=".$this->comid;
		    $this->clientlist=self::get_user_list('client_json',$ps,$parm);
		  	$this->assign('cl',$this->clientlist);
			
			*/
		      
						  $where="1=1";
						  $where.=" and find_in_set($this->uid,touid) and not find_in_set($this->uid,`read`)";
						  $cand=" and module='candidate'";
					      $c_infonums=M('Inform')->where($where.$cand)->count();
						  
						 // echo M('Inform')->getLastSql();
						  $cand=" and module='collection' ";
						  $c_collection=M('Inform')->where($where.$cand)->count();
						  $sixin=D('Usermsg')->where('toid='.$this->uid.' and status=0')->count();
						  $infoTotal=$c_infonums+$c_collection+$sixin;
						  $this->assign('c_inform',$c_infonums);
						  $this->assign('coll_inform',$c_collection);
						  $this->assign('sixin',$sixin);
						  $this->assign("infoTotal",$infoTotal);
						  
						  $infoTotal=$c_infonums+$c_collection;
					
                         // echo $c_infonums;					
			 
			 
			 
			             self::teamer();
			 
				
			  }
			 
		
		
		
	  public function set_category_job(){
		     $url=C('API_URL')."json_cache.php?act=cate_job";
		     $c_job_list=curl($url);
			 $c_job="var cate_job=".$c_job_list;
		     $cate=file_put_contents('./Static/skin/js/cate_job.js',$c_job);
		     $cate ?"":exit('cuowu');
		  }		 
			 
			 
	  public function teamer(){
		  
		    //这里都需要本地缓存一下
		
		  
		   //公共user_list_json 列
		     $ulist=M('User')->Field('realname,username,uid,pid')->where('pid='.$this->comid.' and uid <>'.$this->uid)->select();          // print_r(M('User')->getLastSql());
			
		  	$this->assign('ul',$ulist);  
			//print_r($this->userList);
			//公共客户公司列表
	    
		  
		  }		 
			 
			 
	  public function bumen(){
		  
		      	
		   //取得公司的所有部门	
		    
			  $bm=M('User_group')->where('fid='.$this->comid)->select();
			  foreach($bm as $k=>$v){
				       $bm1[$v['id']]=$v['title'];
				   }
		        
			    $this->assign('bm',$bm1);	
		   
		  }		 
			
	 public  function Checklogin(){
		        
				if(!Cookie::get('uid')){
				  
						      redirect("/Login");
						    
							 
							 }else{
								 
								 
                             /*   if($this->realname==""){
									
								    redirect('/User/profile_edit');
								}else{
									  
									  if($this->pid==0){
										    
											
										  
										  }}*/
										  
										  
										  
										  R('Login/checkStep');
									
									
								
								
				                  
								 }
		          
		 }		 
		 
		 
		 
		 
		 
		 
		  public  function Check(){
		        
				if(!Cookie::get('uid')){
				  
						      redirect("/Login");
						    
							 
							 }
		          
		 }		 
		 
		 
		 
	  public function checkID(){
		  
		     if(!$this->id){
				  
				  self::_message('error','关键条件丢失');
				  
				 }
		  
		  }
	  	 
		 
		 
	/**
     * 数据列表
     *
     * @param $conditions 条件
     * @param $orders 排序
     * @param $listRows 每页显示数量
     * @param $joind 是否表关联
     * @param $table 关联表
     * @param $join 
     * @param $fields 取字段
     */
    public function getList($table,$conditions = '', $orders = '' , $listRows = '')
         {
		$condition['display']=array('eq',0);	 
        $condition = !empty($conditions) ? $conditions : '' ;
        $pageCount = $table->where($condition)->count();
		
        $listRows = empty($listRows) ? 15 : $listRows;
        $orderd = empty($orders) ? 'id DESC' : $orders;
        $paged = new page($pageCount, $listRows);
        $dataContentList = $table->Where($condition)->Order($orderd)->Limit($paged->firstRow.','.$paged->listRows)->select();      
		$pageContentBar = $paged->show();
        $this->assign('getList', $dataContentList);
        $this->assign('pageBar', $pageContentBar);
        
    }
		 
		
		
   public function get_json_list($model,$where,$orders,$listRows,$ajax=0){
	   
	  
            
			
			
			$pageCount=$model->where($where)->count();
			$listRows = empty($listRows) ? 10 : $listRows;
			$orderd = empty($orders) ? 'id DESC' : $orders;
			$paged = new page($pageCount, $listRows);
		    $list=$model->Where($where)
							                        ->Order($orderd)
							                        ->Limit($paged->firstRow.','.$paged->listRows)
													->select(); 
													
	      										 
			foreach($list as $k=>$v){
				   
				   $list[$k]=(array)$list[$k];
				  
				}
		
		    if($ajax==0){
		        $pageContentBar = $paged->show();
		    }else{
			    $pageContentBar = $paged->show_ajax();
			}
	        return array('list'=>$list,'pagebar'=>$pageContentBar);
		   		
	   
	    } 
		
		
		
		
		 public function get_user_list($act,$ps,$parm){
										 $json_url=C('API_URL')."json_cache.php?act=$act&p=$p&ps=$ps$parm";
										 $list =(file_get_contents($json_url));
										 return $list;
         
	   
	    } 
		     
			 
			  public function get_user1_list($act,$ps,$parm){
										 $json_url=C('API_URL')."json_cache.php?act=$act&p=$p&ps=$ps$parm";
										 $list =json_decode(file_get_contents($json_url));
										 
										 foreach($list as $k=>$v){
											      
												  $list[$k]=(array)$list[$k];
											 
											 }
										 
										 return $list;
         
	   
	    } 
			 
			 
			 
			 //公共编辑提交
			 protected function _do_modfy($model,$su='更新成功',$err='更新失败',$data='',$jumpUri=0){
				 
				 
				                    if(!$this->id){
					                 self::_message('error','条件丢失');	 
					   }            
									 unset($data['ajax']);
                                     $data['id']=$this->id;
				                     $rs=$model->save($data);
					                 if($rs){
						        
								     self::_message('success',$su);
								
						             }else{
							          self::_message('error',$err);
							   
							      }
				 
				 }
			 
			 
			 
			 
			 
			 
			 
			 
			//公共单个删除
			
			
			
			protected function __deletes($table,$id){

				    	 if($id!=0){
						     $data['display']=0;
						     $rs=$table->where("id=".$id)->save($data);
							 //如果回调函数有的话就直接返回rs否则进入下面
							 //echo $table->getLastSql();
							 
						  if($rs){
							    
							     $this->_message('success',"删除成功",$_SERVER['HTTP_REFERER']);
							   
							   }
						   
						  }else{
							 
							
							    $this->_message('error',"删除失败");
							 
							 }
					 
				
				
				}
			 
			 
			 
			 
			 
		   
		   //公共批量删除
		   
		   
		   protected function _delete($model = 0,$jumpUri= 0,$param = 0,$field = 'id')
                       {
                         if(getMethod() == 'get'){
                            $operate = trim($_GET['operate']);
                            $item = intval($_GET[$field]);
                            }elseif(getMethod() == 'post'){
                            $operate = trim($_POST['operate']);
                            $item = $_POST[$field];
                            }
                           if($item){
                           if(empty($operate) ||$operate !='delete') self::_message('error','操作类型错误');
                           $jumpUri = '';
                           $daoModel = empty($model)?$this->getActionName() : $model ;
                           $items = is_array($item) ?implode(',',$item) : $item ;
                           if(empty($param)){
                           $dao = D($daoModel);
                           $daoResult = $dao->where($field.' IN('.$items.')')->delete();




                          if(false !== $daoResult)
                         {
	//exit($items);
                       //self::_sysLog('delete',"删除: {$items}");
                       $this->_message('success',"{$items} 删除成功",'/'.MODULE_NAME);
                         }else{
							 
						exit($daoModel);	 
                          $this->_message('error',"删除失败",$jumpUri);
                         }
                         }else{
                       //  self::_deleteWith($daoModel,$items,$param,$jumpUri,$field);
                         }
                         }else{
                              $this->_message('error',"未选择要删除的记录",$jumpUri);
                              }
}
		   
		   
		   
		   
		   
		   
		   
		   
		   
		  
		  // set template NAME
		  protected function _tpl($tplname){
			        
					return  $this->ajax==0 ? $this->display() : $this->display($tplname) ; 
					
			  }
		 
		  protected function _message($type = 'success', $content = '更新成功', $jumpUrl = __URL__, $time = 1, $ajax = false)
    {
        $jumpUrl = empty($jumpUrl) ? __URL__ : $jumpUrl ;
        switch ($type){
            case 'success':
                $this->assign('jumpUrl', $jumpUrl);
                $this->assign('waitSecond', $time);
                $this->success($content, $ajax);
                break;
            case 'error':
                $this->assign('jumpUrl', 'javascript:history.back(-1);');
                $this->assign('waitSecond', $time);
                $this->assign('error', $content);
                $this->error($content, $ajax);
                break;
            case 'errorUri':
                $this->assign('jumpUrl', $jumpUrl);
                $this->assign('waitSecond', $time);
                $this->assign('error', $content);
                $this->error($content, $ajax);
                break;
            default:
                die('error type');
                break;
        }
    }
	
	
	
	//获取公共角色
							public function get_persona($per){
							          $perArray=explode(',',$per);
									  foreach($perArray as $k=>$v){
									         
											 $persona[]=$this->p_t_array[$v]."";	  
										  
										  }
										return implode(',',$persona);  
							
							}	
	
	
	
	//获取后寻人的最快状态
	public function  __get_c_stage($gid){
				 
				     // if(!$gid || intval($gid)==0) return false;
					  
					  $stages=M("Candidate")->field('stage,id,gid')->where('gid='.$gid,' and stage > 1')->order('stage desc')->limit(1)->select();
					  if($stages[0]['stage']) {
					  return $stages[0]['stage'];			    
					  }else{
						  return 1;
						  }
				 
				 }	
				 
				 
				 //公共回收站
				 public function __recycle($table,$conditions = '', $orders = '' , $listRows = ''){
					 
											  $condition = !empty($conditions) ? $conditions : '' ;
											  $pageCount = $table->where($condition)->count();
											  
											  $listRows = empty($listRows) ? 15 : $listRows;
											  $orderd = empty($orders) ? 'id DESC' : $orders;
											  $paged = new page($pageCount, $listRows);
											  $dataContentList = $table->Where($condition)->Order($orderd)->Limit($paged->firstRow.','.$paged->listRows)->select();
											
											  $pageContentBar = $paged->show();
											  $this->assign('getList', $dataContentList);
											  $this->assign('pageBar', $pageContentBar);
					 
					 
					 }
					 
					 
					 
					//从回收站中恢复
					public  function __recover($table,$id){
						
						         
								 if(!$id){
									    
										self::_message('error','关键字段丢失');
									     
									 }
								
								  $data['display']=1;	 
						          $rs=$table->where('id='.$id)->save($data);
								  if($rs){
									     
										  self::_message('success','恢复成功',$_SERVER['HTTP_REFERER']);
									  
									  }
						
						}
						
						
						//硬删除,清理回收站
						
						public function __hard_delete($table,$id){
							         
							               
								 if(!$id){
									    
										self::_message('error','关键字段丢失');
									     
									 }
								
								  $data['display']=1;	 
						          $rs=$table->where('id='.$id)->delete();
								  if($rs){
									     
										  self::_message('success','该数据已经彻底删除',$_SERVER['HTTP_REFERER']);
									  
									  }  
							}
						
						
						
						
		  protected function _setMethod($set = 'POST')
{
$getMethod = strtolower($_SERVER['REQUEST_METHOD']);
if($getMethod != $set){
self::_message('error',"当前只接受 {$set} 数据");
}
}		









protected function _checkPermission($action = NULL)
{
	
	if($this->pid !=0 && $this->role_id > 2){
 

 
$formatAction = $action;
if(empty($action)) $formatAction = MODULE_NAME.'_'.ACTION_NAME;
$permissionFile = CMS_DATA."/cache.StaffRole.php";




$permission = $this->permission;
            if($permission != 'all'){
                  if(file_exists($permissionFile)){
                 $getPermission = @require($permissionFile);
                 foreach((array)$getPermission as $row){
                 if($row['id'] == $this->role_id){
                $arrPermission = explode(',',$row['role_permission']);

              }
}
}else{
      $roleDao = D('StaffRole');
      $getPermission = $roleDao->Where("id={$this->role_id}")->find();
      $arrPermission = explode(',',$getPermission['role_permission']);

      writeCache('StaffRole');

}




if(!in_array($formatAction,$arrPermission)){
	
	    
        self::_message('error','当前角色组无权限进行此操作，请联系管理员授权',0,5);
}
}






}else{
	
	 
	 
	 
	 
	
	  
	
	}




}







 
	  	 














		
				 
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
?>
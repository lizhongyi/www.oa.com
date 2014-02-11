  <?php
 /*
  * 企业控制器类
  * 2013-2-5  
  * className  Business 
  * dever yige
  */
  
  class TestAction extends GlAction{
	  
	        public function _initialize(){
                  // $this->dao=D('Business');
				   parent::_initialize();
				   
				   //判断权限
				   
						   $this->consultant !=1 ? exit("身份失败") :''; 
						   }
				 
				 
				 
			 //首页链接	 
		    
					 
				     public function index(){
				  
				             $parm  = "&uid=1000210";
                             $keyword=$_GET['keyword'];
							 $area=$_GET['area'];
							 $keyword && $parm.="&keyword=$keyword";
							 $area && $parm.="&area=&area"; 
							 
							// exit(C('API_URL')."json_cache.php?act=jobs$parm");
				             $pageCount = file_get_contents(C('API_URL')."json_cache.php?act=jobs&num=x$parm");//获取总数
							 $listRows = empty($listRows) ? $ps : $listRows;
							 $orderd = empty($orders) ? 'id DESC' : $orders;
		                     $p=$_GET['p'];
		
	                     	 if($p==0 || $p=="" ){
			                 $p=1;
			 
			                 }
		                    
                             $paged = new page($pageCount, $listRows);
		                     $json_url=C('API_URL')."json_cache.php?act=jobs_list&p=$p&ps=10$parm";
							
                             $list  = json_decode(file_get_contents($json_url));
							 
							 //$testStr="{'id':'1055','uid':'1000212'}";
							 //$nr=array('asdasd','asdasd','asdasdasd');
							 
							  foreach($list as $k=>$k){
								  $list[$k]->contents=urldecode($list[$k]->contents);
								  }
							  
							  print_r($list);
							
		                    
							  foreach($list as $k=>$v){
				   
				              $list[$k]=(array)$list[$k];
				              }
							 
                             $pageContentBar = $paged->show_ajax();
						
                             $this->assign('getList', $list);
                             $this->assign('pageBar', $pageContentBar);
                             $this->display();
				 	
				  
				 
					 
	         }
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  }
  
?>
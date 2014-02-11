<?php    
         header("Content-type: text/html; charset=utf-8");
		  $kai=0;
		  
		  
		 
		  //检测缓存
		  
		   $url='json.php';
		   $url='http://app.jobmedia.cn/daima/json.php?'.$_SERVER['QUERY_STRING'];
		   $cacheUrl=md5($url);
		   
		   vcache($cacheUrl,$url);
		   
		   
		   
		   function vcache($file,$url){
	 
	      if(!file_exists('cache/'.$file.".txt")){
			      
				  //写入缓存文件
				  file_put_contents('cache/'.$file.".txt",file_get_contents($url));
				 
				  include_once('cache/'.$file.".txt");
				 
			  }else{
				  
				    $oldTime=filemtime('cache/'.$file.".txt");
				    if((time()-$oldTime) > 3600){
						 file_put_contents('cache/'.$file.".txt",file_get_contents($url));
				          //echo "updated";
				         include_once('cache/'.$file.".txt");
				        
						}else{ 
				    include_once('cache/'.$file.".txt");
						}
				  
				  }
	    
		}



		




?>


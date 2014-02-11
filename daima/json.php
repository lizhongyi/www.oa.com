<?php    
         header("Content-type: text/html; charset=utf-8");
		  $kai=0;
		  
		  
		  if($kai==1){
		  
		  $link=$_SERVER['HTTP_REFERER'];
		  $str   = str_replace("http://","",$link);  //去掉http://
		 //echo $str;
          $strdomain = explode("/",$str);               // 以“/”分开成数组
          $domain    = $strdomain[0];  
		  if($domain != ""){
			 exit('ddd');
			 }
			 
		  }
		  
		 
		  
		  
		  
         error_reporting(0);
         $conn=mysql_connect('localhost','root','lizhongyi-009');
         if(!$conn) die("zuoke");
          mysql_select_db("jobs");
          mysql_query("SET NAMES UTF8"); 
         $db= new db;

           
		   



          
		   
		     

           //获取猎头账户
           $act       =   $_GET['act'];
        if( $act      ==  'fuze'){
               
		       
		    $uid=intval($_GET['pid']);
			$nid=$_GET['nid'];
			if($nid) {$where="and pid =".$uid." and consultant = 0 and uid not in($nid) and pid <> 0 or uid=".$uid." and consultant = 0 and uid not in($nid) and pid <> 0";}
			else{
				$where="and pid =".$uid." and consultant = 0  and pid <> 0 or uid=".$uid." and consultant = 0  and pid <> 0";
				}
				
		    $sql="select uid,username,consultant,pid,org_parentid,org_smallid from dev_members where 1=1 $where";	
			
			//获取部门
			$bumen_sql="select * form dev_company_org";
			$nums="SELECT COUNT( * ) AS num FROM  dev_members  where 1=1 $where";
            $user_arr = get_json_list($sql,$nums);
			foreach ($user_arr as $k=>$v){
				       
					   $info=$db->getRow("select realname from dev_members_info where uid =".$v['uid']);
					   $bumen=$db->getRow("select * from dev_company_org where 	itemid=".$v['org_parentid']);
					   $zu=$db->getRow("select * from dev_company_org where 	itemid=".$v['org_smallid']);
					   
					   
					   
					   if($info['realname'] !='' && isgb($info['realname'])==1){
					   
					   $user_arr[$k]['pinyin']= Pinyin($info['realname'],$_Code='UTF-8');
					   
					   
					   }else{
						    $user_arr[$k]['pinyin']="";
						   }
					   
					   
					   
					   
					   
					   $user_arr[$k]['realname']=$info['realname']==''? $v['username'] :$info['realname'];
					  
				       $user_arr[$k]['bumen']=$bumen['org_name'];
					   $user_arr[$k]['group']=$zu['org_name'];
					   $user_arr[$k]['id']=$v['uid'];
					   //$user_arr[$k]['sql']=$sql;
					  
					   
				    }
			 echo JSON($user_arr);
	                }
		    
					
					
					
			//获取公司的所有部门
			  if( $act      ==  'bumen'){
				  
				  $uid=intval($_GET['uid']);
				  $sql="select * from dev_company_org where 	org_pid=$uid";
				  $bumen=get_json_list($sql);
				  
				   echo JSON($bumen);
				  
				  
				  
				  
				  
				  }
			
					
					
		  
		  
		   
		    //获取猎头账户
            $act       =   $_GET['act'];
            if( $act      ==  'teamer'){
               
		    $uid=intval($_GET['pid']);
			$keyword = $_GET['keyword'];
			$nid=$_GET['nid'];
			if($nid) {$where="and pid =".$uid." and consultant = 0 and uid not in($nid) and pid <> 0 or uid=".$uid." and consultant = 0 and uid not in($nid) and pid <> 0";}
			else{
				$where="and pid =".$uid." and consultant = 0  and pid <> 0 or uid=".$uid." and consultant = 0  and pid <> 0";
				}
				
		    $sql="select uid,username,consultant,pid,org_parentid,org_smallid from dev_members where 1=1 $where";	
			//获取资料语句
			
			//获取部门
			$bumen_sql="select * form dev_company_org";
			$nums="SELECT COUNT( * ) AS num FROM  dev_members  where 1=1 $where";
            $user_arr = get_json_list($sql,$nums);
			foreach ($user_arr as $k=>$v){
				       
					   $info=$db->getRow("select realname from dev_members_info where uid =".$v['uid']);
					   $bumen=$db->getRow("select * from dev_company_org where 	itemid=".$v['org_parentid']);
					   $zu=$db->getRow("select * from dev_company_org where 	itemid=".$v['org_smallid']);
					   
					 
					 
					 
					 
					  $user_arr[$k]['realname']=$info['realname']==''? $v['username'] :$info['realname'];
					  
					  
					  
					   if($info['realname'] !='' && isgb($info['realname'])==1){
					   
					   $user_arr[$k]['pinyin']= Pinyin($info['realname'],$_Code='UTF-8');
					   
					   
					   }else{
						    $user_arr[$k]['pinyin']="";
						   }
					   
					 
					 
					 
					 
					 
					  
					  
				       $user_arr[$k]['bumen']=$bumen['org_name'];
					   $user_arr[$k]['group']=$zu['org_name'];
					   $user_arr[$k]['id']=$v['uid'];
					   //$user_arr[$k]['sql']=$sql;
					  
					   
				    }
			 echo JSON($user_arr);
	                }
		    
			
			
			
		 //获取客户json
		 
		 
		   if( $act ==  'client_json'){
               
		      $uid=$_GET['uid'];
		      if($uid) $where="and uid =".$uid;
			  $sql="SELECT id,uid,pid,companyname,companyname_cname FROM  `dev_members_business` where 1=1 $where order by id desc";
		     $nums="SELECT COUNT( * ) AS num FROM  dev_members_business  where 1=1 $where";	
		   $client_list=get_json_list($sql,$nums);
		  
		     
			 foreach($client_list as $k=>$v){
				 
				   $client_list[$k]['realname']=$v['companyname'];
				   
				   $client_list[$k]['pinyin'] =Pinyin($v['companyname_cname']);
				 
				 }
		         echo JSON($client_list);
	            }
		  	
		  			
		
					
					
		  //获取客户		 	
		  else if($act=='client'){
		
		     $uid=$_GET['uid'];
			 $area = $_GET['area'];
			 $keyword=$_GET['keyword'];
			 
			 if($uid) $where="and uid =".$uid;
			 
			 $keyword && $where.=" and companyname like '%$keyword%'";
			 $area && $where.="and area like '%keyword%'";
			 
			  if($_GET['start_time'] != "" && $_GET['start_time'] != ""){
								 
								 //$parm.="&start_time=".$_GET['start_time']."&end_time=".$_GET['end_time'];
								 
								 $where.="and pubdate > ".strtotime($_GET['start_time']);
								 }
			
			
			
			
			
		   $sql="SELECT * FROM  `dev_members_business` where 1=1 $where order by id desc group by companyname";
		   $nums="SELECT COUNT( * ) AS num FROM  dev_members_business  where 1=1 $where";	
		    echo JSON(get_json_list($sql,$nums));
		   
		   }
		   //get Talent poor
		   
		   else if($act=='talent'){
			               
						   
							$comid=      $_GET['cid'];
							$job=        $_GET['job'];
							$keyword=    $_GET['keydord'];
							$category=   $_GET['category'];
							$district=  $_GET['district'];
							$area_cn=   $_GET['area_cn'];
							$experience =$_GET['experience'];
							$sex        =$_GET['sex'];
							$company   =$_GET['company'];
							$wage      =$_GET['wage'];   
							$noids     =$_GET['noids'];
							
							$where="where pid=$comid";
							$category && $where.=" and subclass =".$category;
							$district && $where.=" and  sdistrict=".$district;
							$experience && $where.=" and experience=".$experience;
							$sex        && $where.=" and sex=".$sex;
							$company   && $where.=" and last_company=".$commpany;
							$noids     &&  $where.=" and id not in($noids) ";
							$area_cn       && $where.=" and district_cn like '%$area_cn%' ";
							//$job && $where=" and intention_jobs like '%$job%' ";
							$keyword && $where= " and fullname like '%$keyword%' ";
							
							$sql="SELECT id,uid,title,fullname,last_company,telephone,email,
							 district_cn,recentjobs,experience_cn,intention_jobs,addtime
						     from `dev_hr_standard`  $where order by id desc" ; 
						    $nums="SELECT COUNT( * ) AS num FROM  `dev_hr_standard` $where";	
						    $talent_list=get_json_list($sql,$nums);
							 
							//  echo $sql;
							  
							// print_r($talent_list); 
		                       echo JSON($talent_list);
						     
  			   
			   }
			   
			   
			  
			  
			   else if($act=='talent_info'){
			               
						   
							$id=$_GET['id'];
					
			
								     $info=$db->getRow("SELECT id,uid,title,last_company,fullname,telephone,email,district_cn,recentjobs,experience_cn from `dev_hr_standard` where id=$id limit 1");
									 if($info['title']!=''){
										 
									
									
									
								
						
									 }
		                     echo JSON($info);
						     
  			   
			   } 
			   
			   
			   
			   
			   
			   
		   
		   //获取客户职位信息
		   
		   
		   //获取客户职位
	       else if($act=='jobs_list'){
		
		     $uid=$_GET['uid'];
			 //$area = $_GET['area'];
			 $keyword=$_GET['keyword'];
			 
			 //if($uid) $where="and uid =".$uid;
			 
			 $keyword && $where.=" and jobs_name like '%$keyword%' or ";
			 //$area && $where="and area like '%keyword%'";
			
			
			
			
			
		   $sql="SELECT contents FROM  `dev_jobs` where 1=1 $where order by id desc";
		   $nums="SELECT COUNT( * ) AS num FROM  dev_jobs  where 1=1 $where";	
		    echo JSON(get_json_list($sql,$nums));
		   
		   }
		   
		   //get category_job
		   
		   else if($act=='cate_job'){
			   
			     $sql="SELECT * FROM `dev_category_jobs` ";
			     $cate_job=$db->getAll($sql); 
			     echo JSON($cate_job);
			   }
		   
		   //获取用户详细
		   
		   else if($act=='client_detail'){
		
		   $id=$_GET['id'];
			if($id) $where="and id =".$id;
			
		   $sql="SELECT * FROM  `dev_members_business` where 1=1 $where order by id desc";
		   $row=$db->getRow($sql);	
		    echo JSON($row);
		   
		   }
		   


        	    //获取用户资料
	else if($act=='user_info'){
		     
			 $uid=intval($_GET['uid']);
		     $user_info=$db->getRow("select * from dev_members as A , dev_members_info as B where A.uid=B.uid and A.uid=".$uid);
		     echo JSON($user_info);
		   }
		   
		   
		   
		         	    //获取用户资料
	else if($act=='user_name'){
		     
			 $uid=intval($_GET['uid']);
		     $user_info=$db->getRow("select A.uid,A.username,B.realname,A.pid from dev_members as A , dev_members_info as B where A.uid=B.uid and A.uid=".$uid);
		     echo JSON($user_info);
		   }
		   
		   
		   
		   
		   
		        	    //获取用户资料
	else if($act=='user_login'){
		     
			  $uname=$_GET['uname'];
			  
			  $pass=$_GET['pass'];
			
			  $user_hash=$db->getRow("select * from dev_members where username='$uname'");
			  $user_hash=$user_hash['pwd_hash'];
			  $pass=md5(md5(trim($pass)).$user_hash);
		      $user_info=$db->getRow("SELECT  A.*,B.realname 
                                     FROM dev_members AS A, dev_members_info AS B
                                     WHERE A.username =  '$uname' and password='$pass'
                                     AND A.uid = B.uid
                                     LIMIT 0 , 1");
		     echo JSON($user_info);
		   }


       //  add resume to table 
	   
	   else if($act=='add_resume'){
		   
		   
		         $sql="INSERT INTO `dev_hr_standard`(`uid`,`pid`,`title`,`fullname`,`last_company`,`district_cn`,`telephone`,`email`,`recentjobs`,`addtime`) values(".$_GET['uid'].",".$_GET['comid'].",'".$_GET['title']."','".$_GET['fullname']."','".$_GET['last_company']."','".$_GET['area_cn']."','".$_GET['tel']."','".$_GET['email']."','".$_GET['job']."',".time().")";
				// echo $sql;
				 $rs=mysql_query($sql);
				 if($rs){
					
						echo mysql_insert_id();
					
					 }else{
						 
						 echo 0;
						 
						// echo $sql;
						 
						 }
		   
		   
		   
		   }
		   
		   //personal 
		   else if($act=='friend'){
			   
			        
		    $uid=intval($_GET['uid']);
		
		    $where="and uid = ".$uid." and stauts = 3 order by letter asc";
			
				
		    $sql="select * from dev_friends_post where 1=1 $where";	
			//echo $sql;
					
			$nums="SELECT COUNT( * ) AS num FROM  dev_friends_post  where 1=1 $where";
			
            $user_arr = get_json_list($sql,$nums);
			
			
			foreach($user_arr as $k=>$v){
				     
				$info=$db->getRow("select * from dev_members as A , dev_members_info as B where A.uid=B.uid and A.uid=".$v['pid']);	 
				$user_arr[$k]['realname']=$info['realname'];
				}
			
			foreach($user_arr as $k=>$v){
				     
					 
				if($user_arr[$k]['realname']==''){
				unset($user_arr[$k]);
				
				
				
				}
				
				
				}
			   
			   foreach($user_arr as $k=>$v){
				      
					  $nu[]=$user_arr[$k];
				   
				   }
			   
			
		
			
			
			echo JSON($nu);
			
	                }



/**************************************************************
 *
 *	使用特定function对数组中所有元素做处理
 *	@param	string	&$array		要处理的字符串
 *	@param	string	$function	要执行的函数
 *	@return boolean	$apply_to_keys_also		是否也应用到key上
 *	@access public
 *
 *************************************************************/
function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
{
    $recursive_counter = 0;
    if (++$recursive_counter > 1000) {
        die('possible deep recursion attack');
    }
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            arrayRecursive($array[$key], $function, $apply_to_keys_also);
        } else {
            $array[$key] = $function($value);
        }
 
        if ($apply_to_keys_also && is_string($key)) {
            $new_key = $function($key);
            if ($new_key != $key) {
                $array[''.$new_key.''] = $array[''.$key.''];
                unset($array[''.$key.'']);
            }
        }
    }
    $recursive_counter--;
}
 
/**************************************************************
 *
 *	将数组转换为JSON字符串（兼容中文）
 *	@param	array	$array		要转换的数组
 *	@return string		转换得到的json字符串
 *	@access public
 *
 *************************************************************/
function JSON($array) {
	arrayRecursive($array, 'urlencode', true);
	$json = json_encode($array);
	return urldecode($json);
}



function get_json_list($q,$n){
	     
		 //global $conn;
		 
		 
		 
		 
		$ps       =    intval($_GET['ps'])==0 ? 50 : intval($_GET['ps']);
		$p=$_GET['p'];
		
		if($p==0 || $p=="" ){
			$p=1;
			 
			}
			$c=($p-1)*$ps;
			$d=$ps;
		    $limit=" limit ".$c.",".$d;
		
	        $sql=$q.$limit;	
			//echo $sql;
			$nums=$n;
			$nums=mysql_fetch_array(mysql_query($nums)); 
			
             $rs=mysql_query($sql);
			
	       while($row=mysql_fetch_array($rs,MYSQL_ASSOC)){
			 
			  $arr[]=$row;
			 
			}
			
			  foreach($arr as $k=>$v){
				  
				  if($arr[$k]['contents']==""){
					  
					   $arr[$k]['contents']='NO DATA';
  					  }else{
						  
						 $arr[$k]['contents']=urlencode($arr[$k]['contents']);  
					}
				     
				 }
		 
		
			   	
		    if($_GET['num']==""){
		     return $arr;
			}else{
			//输出总数
			return $nums['num'];	
		  }
		 
		 
		 
	
	}

class db{
	
	  function getRow($sql){
		     
			 if($sql){
				   
				   $rs=mysql_query($sql);
				   $row=mysql_fetch_array($rs,MYSQL_ASSOC);
				   return $row;
				 
				 }
		  
		  }
		  
		  
		  function getAll($sql){
		     
			 if($sql){
				   
				   $rs=mysql_query($sql);
				  
				   while($row=mysql_fetch_array($rs,MYSQL_ASSOC)){
					   
						   $row1[]=$row;
					   
					   }
				   return $row1;
				 
				 }
		  
		  }
		  
		  
		 
		  
		  
	
	}



  
  
  
  
  
  
 // $sr='123456';
 // echo md5(md5(trim($sr)).'NyjH=2');


 

 function Pinyin($_String, $_Code='UTF8'){ //GBK页面可改为gb2312，其他随意填写为UTF8

        $_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha".

                        "|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|".

                        "cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er".

                        "|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui".

                        "|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang".

                        "|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang".

                        "|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue".

                        "|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne".

                        "|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen".

                        "|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang".
                        "|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|".

                        "she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|".

                        "tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu".

                        "|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you".

                        "|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|".

                        "zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo";

        $_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990".

                        "|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725".

                        "|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263".

                        "|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003".

                        "|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697".

                        "|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211".

                        "|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922".

                        "|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468".

                        "|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664".

                        "|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407".

                        "|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959".

                        "|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652".

                        "|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369".

                        "|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128".

                        "|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914".

                        "|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645".

                        "|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149".

                        "|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087".

                        "|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658".

                        "|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340".

                        "|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888".

                        "|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585".

                        "|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847".

                        "|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055".

                        "|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780".

                        "|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274".

                        "|-10270|-10262|-10260|-10256|-10254";
        $_TDataKey   = explode('|', $_DataKey);

        $_TDataValue = explode('|', $_DataValue);

        $_Data = array_combine($_TDataKey, $_TDataValue);

        arsort($_Data);

        reset($_Data);

        if($_Code!= 'gb2312') $_String = _U2_Utf8_Gb($_String);

        $_Res = '';

        for($i=0; $i<strlen($_String); $i++) {

                $_P = ord(substr($_String, $i, 1));

                if($_P>160) {

                        $_Q = ord(substr($_String, ++$i, 1)); $_P = $_P*256 + $_Q - 65536;

                }

                $_Res .= _Pinyin($_P, $_Data);

        }

        return preg_replace("/[^a-z0-9]*/", '', $_Res);

}

function _Pinyin($_Num, $_Data){

        if($_Num>0 && $_Num<160 ){

                return chr($_Num);
        }elseif($_Num<-20319 || $_Num>-10247){

                return '';

        }else{

                foreach($_Data as $k=>$v){ if($v<=$_Num) break; }

                return $k;
        }

}

function _U2_Utf8_Gb($_C){

        $_String = '';

        if($_C < 0x80){

                $_String .= $_C;

        }elseif($_C < 0x800) {
                $_String .= chr(0xC0 | $_C>>6);

                $_String .= chr(0x80 | $_C & 0x3F);

        }elseif($_C < 0x10000){

                $_String .= chr(0xE0 | $_C>>12);

                $_String .= chr(0x80 | $_C>>6 & 0x3F);

                $_String .= chr(0x80 | $_C & 0x3F);

        }elseif($_C < 0x200000) {

                $_String .= chr(0xF0 | $_C>>18);

                $_String .= chr(0x80 | $_C>>12 & 0x3F);

                $_String .= chr(0x80 | $_C>>6 & 0x3F);

                $_String .= chr(0x80 | $_C & 0x3F);

        }

        return iconv('UTF-8', 'GB2312', $_String);

}










 function isgb($str){
	 
 	     if(preg_match_all("/^([\x81-\xfe][\x40-\xfe])+$/",$str,$match))
         {
            return 1;
             }else{
				 
	         return 0;
	      }
	 
	 }




?>


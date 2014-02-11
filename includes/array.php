<?php
             //薪资
        $public_arr = array('payment'=>array(
                    1=>'请选择',
                    1=>'10万~20万',
					2=>'20万~30万',
					3=>'30万~40万',
					4=>'40万~50万',
					5=>'50万~60万',
					6=>'60万~70万',
					7=>'70万~80万',
					8=>'80万~90万',
					9=>'100万以上'
					

           ),
		   //'com_type'=>array("国企", "民营", "事业", "非盈利"),
		   
		   'scale'=>array("1-49人", "50-99人", "100-199人", "200-300人","400-500人","500-1000人","1000人以上"),
		   //执行部门
		   'executive_arm'=>array(
		               0=>'请选择',
		               1=>'技术部',
					   2=>'财务部',
					   3=>'销售部',
					   4=>'人力资源部'
		   
		   ),
		   
		   //进展状态
		   'evolve'=>array(
		                0=>'请选择',
		               1=>'进行中',
					   2=>'暂停',
					   3=>'结束',
					   4=>'完成'
					   
		   
		   ),
		   
		   //成功概率
		    
		   
		    'feasibility'=>array(
			           0=>'请选择',
		               1=>'很高',
					   2=>'较高',
					   3=>'一般',
					   4=>'较低'
					   
		   
		   ),
		   //账户身份
		   'realid'=>array(
		                0=>'企业用户',
		               1=>'猎头用户',
					   2=>'xx',
					   3=>'个人用户',
					   4=>''
		     
		   //进展阶段
		   ),
		   'stage'=>array(
		                0=>'请选择',
		               1 =>'初选',
					   2 =>'顾问面试',
					   3 =>'已推荐',
					   4 =>'客户面试',
	                   5 =>'薪酬谈判',
					   6 =>'已录用',
					   7 =>'入职',
					   8 =>'收款中',
                       9 =>'收款状态',
					   13=>'佣金分配',
					   10=>'内部团队',
					   11=>'业绩查看',
					   12=>'统计'
					   
					 
		     
		   
		   )
					 
		 ,
		   
		   'stage1'=>array(
		               '请选择',
		               '初选',
					   '顾问面试',
					   '已推荐',
					   '客户面试',
	                   '薪酬谈判',
					   '已录用',
					   '已入职',
					   '收款中',
                       '已到账',
					 
					   
					 
		     
		   
		   ),
		   
		   //面试阶段
		            'mianshi'=>array(
		                   
						   0=>'请选择',
						   
						   4=>'面试通过',
						   5=>'不符合要求'
					    
		             ), 
		   //阶段状态
		   'stages'=>array(
		   
		
					   1=>array(   0=>'请选择',
					             1=>'未联系',
								 2=>'已联系'
								 
					            ),
								
						//顾问面试		
					   2=>array(
					  
					             0=>'请选择',
								 1=>'尚未面试',
						         2=>'面试通过',
						         3=>'不符合要求',
								 4=>'待定'
						       
					        
					   
					   ),
					   //已推荐
					   3=>array(
			        "请选择","等待反馈","等待安排面试","未通过HR审核" 
					   ),
					    //已推荐
					   4=>array("请选择","尚未面试","客户一面","客户二面","客户多轮面试","等待面试反馈","未通过面试","通过面试"),
					   5=>array(
					  "请选择","尚未谈判","谈判中","谈判失败","谈判成功"
					   
					   ),
					   6=>array("请选择","待做背景调查","背景调查中","背景调查未通过","等待入职"),
					   7=>array("请选择","正常入职","提前入职","延期入职"),
					   8=>array("请选择","全额收款","分批收款"),
					   	 	   
							   
					   ),
		   //阶段停留
		    'stage_stay'=>array(
			           0=>'请选择',
		               1=>'一天',
					   2=>'两天',
					   3=>'三天'
					 
		     
		   
		   ),'status'=>array(
		               0=>'请选择' ,
		               1=>'进行中',
					   2=>'暂停',
					   3=>'结束',
					   4=>'完成'
					 
		     
		   
		   ),
		   'degree'=>array(
		               0=>'请选择' ,
		               1=>'学士',
					   6=>'双学位',
					   2=>'硕士',
					   3=>'博士',
					   4=>'博士后',
					   5=>'大专'
					 
		     
		   
		   ),
		    'sex'=>array(
		               1=>'男' ,
		               2=>'女',
					   
		     
		   
		   ),
		    'post_type'=>array(
		               1=>'全职' ,
		               2=>'兼职',
					   
		     
		   
		   ),
		   'workexp'=>array(
		               1=>'1-2年' ,
		               2=>'2-4年',
					   3=>'3-5年',
					   4=>'5-10年',
					   
		     
		   
		   ),
		    'education'=>array(
		               1=>'本科' ,
		               2=>'硕士',
					   3=>'博士',
					   4=>'博士后',
					   5=>'大专',
					   
		     
		   
		   ),
		   
		   
		      'scale'=>array("1-49人", "50-99人", "100-499人", "500-999人","1000-9999人","10000人以上"),
			  'nature'=>array("外商独资企业", "台资企业", "境内上市公司", "境外上市公司","股份制企业","中央企业","国有企业","民营企业","政府·NGO·协会·基金会·其他"),
		   
		   );
		   
		   if($_GET['json']==1){
			    
				
				header("Content-type: text/html; charset=utf-8");
				
				echo "var public_array=".JSON($public_arr);
				//print_r($public_arr);
			   }
			   
			   
			   
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
?>
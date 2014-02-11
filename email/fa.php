<?php


$send=send_email('2479526304@qq.com',"nihao","<h1 style=\"nihao\"><a href='http://www.baidu.com' style='color:red'>zhendema</a></h1>",$charset='UTF-8', $is_html='true',$attachment = null);


if($send){
	    echo 1;
	}else{
		echo 0;
		}



function send_email($address,$subject,$body, $charset, $is_html, $receipt = false){
		
		
	            
				     require('include/mailer.class.php');
					
				
				         $from      =    'jobme.cn';
				         $email     =    '165256676@qq.com';
						 $protocol  =    '1';
						 $host      =    'smtp.qq.com';
						 $port      =    '25'; 
						 $user      =    '165256676'; 
						 $pass      =    'kajielinon-009'; 
						
						
						
			            $smtp      =     new Mailer($from, $email, $protocol, $host, $port, $user, $pass);
						
						       //对邮件内容进行必要的过滤
					
						
						if($smtp){
						                 $fasong=$smtp->send($address,$subject,$body, $charset, $is_html=true, $receipt = false);
						                 if($fasong){
							
							               return 1;
							
							             }else{
							                return  0;	
							             }
										 
						     }
						  else
						{
						 
						 echo  "邮件错误";	
							
						}


}


?>
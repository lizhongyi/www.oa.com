<?php


 $database=array(         //数据库配置信息       
				'DB_TYPE'   => 'mysql', // 数据库类型 
				'DB_HOST'   => 'localhost', // 服务器地址    
				'DB_NAME'   => 'erpking', // 数据库名      
				'DB_USER'   => 'root', // 用户名       
				'DB_PWD'    => 'lizhongyi-009', // 密码      
				'DB_PORT'   => 3306, // 端口     
				'DB_PREFIX' => 'eking_', // 数据库表前缀 
			    'DEFAULT_THEME' => 'default',
				'APP_AUTOLOAD_PATH'=>'ORG.Util',
				'COOKIE_PREFIX'=>'THINK_',
				'UPLOAD_PATH'=>'./Uploads',
				//'SHOW_PAGE_TRACE' =>true,  
				'URL_PATHINFO_MODEL' => 1,
                'URL_PATHINFO_DEPR' => '/',
				'UPLOAD_PATH'=>'./Uploads/',
				//'TMPL_ACTION_SUCCESS'=>'Public:success',
				//'TMPL_ACTION_ERROR'=>'Public:error',
				'API_URL'=>'http://'.$_SERVER['HTTP_HOST'].'/daima/',
				'THINK_EMAIL' => array(
										'SMTP_HOST'   => 'smtp.qq.com', //SMTP服务器
										'SMTP_PORT'   => '465', //SMTP服务器端口
										'SMTP_USER'   => 'mail@aaa.com', //SMTP服务器用户名
										'SMTP_PASS'   => '198412253234', //SMTP服务器密码
										'FROM_EMAIL'  => '592341646@qq.com', //发件人EMAIL
										'FROM_NAME'   => 'JOBME', //发件人名称
										'REPLY_EMAIL' => '', //回复EMAIL（留空则为发件人EMAIL）
										'REPLY_NAME'  => '', //回复名称（留空则为发件人名称）
									 ),
				
             
				);
?>
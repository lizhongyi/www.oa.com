<?php
define("ERPKING",true);
define('ROOT_PATH', str_replace('index.php', '', str_replace('\\', '/', __FILE__)));
define("APP_NAME","System");
define("APP_PATH","System/");
define('CMS_DATA', './Data/');
define('RUNTIME_PATH','Static/Temp/');
define('APP_DEBUG', true); 
header("Content-Type:text/html; charset=utf-8");
require_once(dirname(__FILE__).'/Framework/ThinkPHP.php');
?>

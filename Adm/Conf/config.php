<?php
if (!defined('ERPKING')) die('not in erpking.cn');
require (ROOT_PATH.'config.db.php');
$config = array();
return array_merge($database, $config);

?>
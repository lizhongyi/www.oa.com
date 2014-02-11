<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title></title>

<link href="__PUBLIC__/skin/style/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/skin/js/init.js"></script>

<script type="text/javascript">

$(document).ready(function()

{

$("li").first().addClass("hover");

$("li>a").click(function(){

	$("li").removeClass("hover");

	$(this).parent().addClass("hover");

	$(this).blur();

	})

})

</script>

</head>

<body>

<div  class="admin_left_box">

<ul>

<li>

<a href="__APP__/Index/main"  target="mainFrame">管理中心首页</a>

</li>

<li>

<a  href="__APP__/System/logout"  target="_top" >退出登录</a>

</li>

</ul>

</div>

</body>

</html>
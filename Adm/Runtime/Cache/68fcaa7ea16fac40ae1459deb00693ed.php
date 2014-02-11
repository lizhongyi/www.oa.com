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

<a href="__APP__/Site/main"  target="mainFrame">网站配置</a>

</li>

<li>

<a  href="__APP__/Site/sitemail"  target="mainFrame" >邮件配置</a>

</li>

<li>

<a  href="__APP__/Site/cateclass"  target="mainFrame" >职位分类</a>

</li>

<li>

<a  href="__APP__/Site/industry"  target="mainFrame" >行业分类</a>

</li>


<li>

<a  href="__APP__/Site/area"  target="mainFrame" >地区分类</a>

</li>




</ul>

</div>

</body>

</html>
<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title></title>
<link href="__PUBLIC__/skin/style/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/skin/js/init.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
$(".admin_top_nav>a").click(function(){
	$(".admin_top_nav>a").removeClass("select");
	$(this).addClass("select");
	$(this).blur();
	window.parent.frames["leftFrame"].location.href =  "__APP__/"+$(this).attr("id");
	})
})
</script>
</head>
<body>
<div class="admin_top_bg">
    <table width="100%" height="70" border="0" cellpadding="0" cellspacing="0">
        <tr><td width="200" rowspan="2" align="right" valign="middle" ><div align="center"><img src="__PUBLIC__/skin/admin/logo_in.png" width="160" height="69" /></div>
		</td>
          <td height="39" align="right" valign="middle" class="link_w" style="padding-right:10px;">欢迎：<strong style="color: #99FF00">{#$admin_name#}</strong>&nbsp; &nbsp;&nbsp;&nbsp;<a href="__APP__/Manages/logout" target="_top">[退出]</a>&nbsp;&nbsp;&nbsp;<a href="../" target="_blank">网站首页</a> </td>
        </tr>
        <tr>
          <td height="31" valign="bottom" class="admin_top_nav">
		  <a href="__APP__/Index/main" class="select" target="mainFrame" id="Index/left">首页</a>
          <a href="__APP__/Members/main" target="mainFrame" id="Members/left">用户管理</a>
          <a href="__APP__/Members/main" target="mainFrame" id="Members/left">工作单管理</a>
          <a href="__APP__/Members/main" target="mainFrame" id="Members/left">简历管理</a>
          <a href="__APP__/Members/main" target="mainFrame" id="Members/left">业绩管理</a>
          <a href="__APP__/Suggest/main" target="mainFrame" id="Suggest/left">搜索关键字</a>
          <a href="__APP__/Admin/main" target="mainFrame" id="Admin/left">管理员</a>
          <a href="__APP__/Site/main" target="mainFrame" id="Site/left">系统配置</a>
		  <div class="clear"></div>
		   </td>
        </tr>
</table>
	  </div>
</body>
</html>
<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<meta name="author" content="" />

<meta name="copyright" content="jobmedia.cn" />

<title>网站后台管理中心</title>

<link href="__PUBLIC__/skin/style/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/skin/js/init.js"></script>


<script type="text/javascript"> 

$(document).ready(function(){

	   $("#verify").click(function(){
			var tsTimeStamp= new Date().getTime();
			$("#verify").attr("src","__APP__/Init/verify/?"+tsTimeStamp);

	   });

});	 

</script>


</head>



<body class="admin_top_bg">

<div class="login_top" style="height:300px;" ></div>

  <form id="form1" name="form1" method="post" action="__APP__/Manages/login">

    <table width="530" border="0" align="center" cellpadding="0" cellspacing="0"  class="link_lan">

      <tr>

        <td valign="top"><table width="230" border="0"  >

            <tr>

                <td style="padding-top:15px;"><img src="__PUBLIC__/skin/admin/logo_in.png" /></td>

            </tr>

              

        </table></td>

        <td width="300"><table width="100%" border="0" cellpadding="0" cellspacing="4">

          <tr>

            <td width="75" height="26" align="right">用户名：</td>

            <td ><input name="admin_name" type="text"  class="login_box_input" id="admin_name" value="l405023944" maxlength="16"/></td>

          </tr>

          <tr>

            <td height="26" align="right">密&nbsp;&nbsp;&nbsp;&nbsp;码：</td>

            <td ><input name="admin_pwd" type="password" id="admin_pwd" value="a11112222" class="login_box_input"/></td>

          </tr>

          <tr>

            <td height="26" align="right">验证码：</td>

            <td><input  class="login_box_captcha" name="verify" type="text" value="" maxlength="6" />

               <img src="__APP__/Init/verify" align="absmiddle"  id="verify" style="cursor:pointer; top:5px;"/>           </td>

          </tr>

          <tr>

            <td height="30">&nbsp;</td>

            <td ><input class="login_box_rig_an" type="submit" name="Submit" value="登录" />&nbsp;&nbsp;&nbsp;&nbsp;<label>

              <input name="rememberme" class="login_box_rememberme"   type="checkbox" id="rememberme" value="1" />

记住我</label>

<input type="hidden" name="act" value="do_login" /></td>

          </tr>

		<!--

          <tr>

            <td height="30">&nbsp;</td>

            <td  >			

			<div style="border:1px #FF6600 solid; font-size:12ppx; color:#FF3300; background-color:#FFFFCC; padding:5px; width:150px; text-align:center">{#$smarty.get.err#}</div>

			</td>

          </tr>
 -->
		

        </table></td>

      </tr>

    </table>

  </form>

<script language ="javascript">    

function init(){    

var ctrl=document.getElementById("admin_name");    

ctrl.focus();    

}  

init();  

</script>

</body>

</html>
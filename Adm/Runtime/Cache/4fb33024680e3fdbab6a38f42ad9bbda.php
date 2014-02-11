<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<meta name="author" content="" />

<meta name="copyright" content="jobmedia.cn" />

<title> </title>

<link href="__PUBLIC__/skin/style/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/skin/js/init.js"></script>


</head>

<body style="background-color:#E0F0FE">


<div class="admin_nav_bg">




<?php if(ACTION_NAME == main ): ?><div class="admin_nav_li"><a href="__APP__/Site/main">网站配置</a></div>
<?php else: ?> 
<div class="admin_nav_li_hover"><a href="__APP__/Site/main">网站配置</a></div><?php endif; ?>

<!--
<?php if(ACTION_NAME == agreement ): ?><div class="admin_nav_li"><a href="__APP__/Site/agreement">使用协议</a></div>
<?php else: ?> 
<div class="admin_nav_li_hover"><a href="__APP__/Site/agreement">使用协议</a></div><?php endif; ?>


<?php if(ACTION_NAME == filter ): ?><div class="admin_nav_li"><a href="__APP__/Site/filter">词语过滤</a></div>
<?php else: ?> 
<div class="admin_nav_li_hover"><a href="__APP__/Site/filter">词语过滤</a></div><?php endif; ?>


-->







<div class="clear"></div>

</div>

<div class="admin_main_nr_box">

<div class="toptip">

	<h2>提示：</h2>

	<p>

页面标题设置以及关键字设置等请在页面管理中设置。<br />



网站域名和网站安装目录填写错误可导致网站部分功能不能使用。

</p>

</div>



<div class="toptit">网站配置</div>

  <form action="__APP__/Site/main_set_save" method="post" enctype="multipart/form-data" name="form1" id="form1">

 

    <table width="100%" border="0" cellspacing="5" cellpadding="5">

    <tr>

      <td width="120" align="right">网站名称：</td>

      <td><input name="site_name" type="text"  class="input_text_200" id="site_name" value="<?php echo ($config["site_name"]); ?>" maxlength="30"/></td>

    </tr>



    <tr>

      <td align="right">网站域名：</td>

      <td><input name="site_domain" type="text"  class="input_text_200" id="site_domain" value="<?php echo ($config["site_domain"]); ?>" maxlength="100"/>

      结尾不要加 &quot; / &quot;</td>

    </tr>

    <tr>

      <td align="right">静态地址：</td>

      <td><input name="site_static" type="text"  class="input_text_200" id="site_static" value="<?php echo ($config["site_static"]); ?>" maxlength="100"/>

      结尾不要加 &quot; / &quot;</td>

    </tr>



    

    

    <tr>

      <td align="right">安装目录：</td>

      <td><input name="site_dir" type="text"  class="input_text_200" id="site_dir" value="<?php echo ($config["site_dir"]); ?>" maxlength="40"/>

      ( 以 &quot; / &quot; 开头和结尾, 如果安装在根目录，则为&quot; / &quot;)      </td>

    </tr>

    <tr>

      <td align="right">联系电话(顶部)：</td>

      <td><input name="top_tel" type="text"  class="input_text_400" id="top_tel" value="<?php echo ($config["top_tel"]); ?>" maxlength="80"/></td>

    </tr>

    <tr>

      <td align="right">联系电话(底部)：</td>

      <td><input name="bootom_tel" type="text"  class="input_text_400" id="bootom_tel" value="<?php echo ($config["bootom_tel"]); ?>" maxlength="80"/></td>

    </tr>

	<tr>

      <td align="right">网站底部联系地址：</td>

      <td><input name="address" type="text"  class="input_text_400" id="address" value="<?php echo ($config["address"]); ?>" maxlength="120"/></td>

    </tr>

	<tr>

      <td align="right">网站底部其他说明：</td>

      <td><input name="bottom_other" type="text"  class="input_text_400" id="bottom_other" value="<?php echo ($config["bottom_other"]); ?>" maxlength="200"/></td>

    </tr>

    <tr>

      <td align="right">网站备案号(ICP)：</td>

      <td><input name="icp" type="text"  class="input_text_400" id="icp" value="<?php echo ($config["icp"]); ?>" maxlength="30"  /></td>

    </tr>

   

    <tr>

      <td align="right" valign="top">搜索关键字：</td>

      <td><textarea name="keywords" class="input_text_400" id="close_reason" style="height:60px;"><?php echo ($config["keywords"]); ?></textarea></td>

    </tr>



    <tr>

      <td align="right" valign="top">过滤词：</td>

      <td><textarea name="filtration" class="input_text_400" id="close_reason" style="height:60px;"><?php echo ($config["filtration"]); ?></textarea></td>

    </tr>



    


    <tr>

      <td align="right" valign="top">第三方流量统计代码：</td>

      <td><textarea name="statistics" class="input_text_400" id="statistics" style="height:60px;"><?php echo ($config["statistics"]); ?></textarea></td>

    </tr>

   

	       <tr>

            <td align="right">自动清除缓存周期：</td>

            <td><input name="clear_timing" type="text"  class="input_text_200" id="clear_timing" value="<?php echo ($config["clear_timing"]); ?>" onKeyUp="if(event.keyCode !=37 &amp;&amp; event.keyCode != 39) value=value.replace(/\D/g,'');"   maxlength="10" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/\D/g,''))"/>

              分钟</td>

          </tr>

	       <tr>

	         <td align="right">&nbsp;</td>

	         <td height="50"> 

	           <input name="submit" type="submit" class="admin_submit"    value="保存修改"/>

             </td>

      </tr>

  </table>

  </form>

</div>


</body>

</html>
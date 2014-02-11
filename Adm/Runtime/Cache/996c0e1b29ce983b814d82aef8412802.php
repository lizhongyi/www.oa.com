<?php if (!defined('THINK_PATH')) exit();?><div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>添加用户</h3>
  </div> 
  

  <div class="modal-body"> 
  
  
  <div class=" modal_box">
<div id="msg"></div>



<p>
<h5>提示：</h5>
通过管理员设置，您可以进行编辑管理员资料、权限、密码以及删除管理员等操作；

</p>

</div>  

 <div class="toptit">新增用户</div>

 

 <form id="form1" name="form1" method="post" action="__APP__/Members/addusers_save">
 <input type="hidden" name="last_login_ip" value="<?php echo ($ip); ?>"/>

  <table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF"  >

    <tr>

      <td width="120" height="30" align="right" bgcolor="#FFFFFF" style=" border-bottom:1px #CCCCCC dashed">用户名：</td>

      <td width="220" bgcolor="#FFFFFF" style=" border-bottom:1px #CCCCCC dashed"><input name="admin_name" ajaxurl="__APP__/Json/McheckUser" datatype="s6-18" nullmsg="请输入用户名" errormsg="昵称至少6个字符,最多18个字符！"  type="text" class="input_text_200" id="admin_name" maxlength="25" value=""/></td>
      <td bgcolor="#FFFFFF" style=" border-bottom:1px #CCCCCC dashed"><div class="Validform_checktip"></div></td>

    </tr>

    <tr>

      <td height="30" align="right" bgcolor="#FFFFFF" style=" border-bottom:1px #CCCCCC dashed">电子邮件：</td>

      <td bgcolor="#FFFFFF" style=" border-bottom:1px #CCCCCC dashed" ><input name="email" datatype="e" ajaxurl="__APP__/Json/McheckEmail"  nullmsg="请输入邮箱" errormsg="请输入邮箱！"  type="text" class="input_text_200" id="old_emailpwd" maxlength="25" value=""/></td>
 <td bgcolor="#FFFFFF" style=" border-bottom:1px #CCCCCC dashed"><div class="Validform_checktip"></div></td>
    </tr>

    <tr>

      <td height="30" align="right" bgcolor="#FFFFFF" style=" border-bottom:1px #CCCCCC dashed">密码：</td>

      <td bgcolor="#FFFFFF" style=" border-bottom:1px #CCCCCC dashed" ><input name="password" datatype="*6-16" nullmsg="请设置密码！" errormsg="密码范围在6~16位之间！"  type="password" class="input_text_200" id="password" maxlength="25" value=""/></td>
<td  style=" border-bottom:1px #CCCCCC dashed" ><div class="Validform_checktip"></div></td>

    </tr>

    <tr>

      <td height="30" align="right" bgcolor="#FFFFFF" style=" border-bottom:1px #CCCCCC dashed">再次输入密码：</td>

      <td  bgcolor="#FFFFFF" style=" border-bottom:1px #CCCCCC dashed" ><input name="password1" type="password" class="input_text_200" id="password1" maxlength="25" value="" tip="test"  datatype="*" recheck="password" nullmsg="请再输入一次密码！" errormsg="您两次输入的账号密码不一致！" /></td>
<td  style=" border-bottom:1px #CCCCCC dashed" ><div class="Validform_checktip"></div></td>

    </tr>

  </table>

    </form>

</div>

</div> 



 </div>
  <div class="modal-footer">
     <button class="btn btn-primary" type="submit" id="candidate_bt" >保存</button></div>

 </div>
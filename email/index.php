<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>邮件群发系统--Create By Terry</title>
<script language="javascript" src="public/script/jquery.js"></script>
<script language="javascript" src="public/script/jquery.form.js"></script>
<style type="text/css">
body {
	background: #fff;
}

table {
	border-collapse: collapse;
	width: 85%;
	margin: 24px;
	font-size: 1.1em;
}

th {
	background: #3e83c9;
	color: #fff;
	font-weight: bold;
	padding: 2px 11px;
	border-right: 1px solid #fff;
	line-height: 1.2;
}

td {
	padding: 6px 11px;
	border-bottom: 1px solid #95bce2;
	vertical-align: top;
}

td * {
	padding: 6px 11px;
}

tr.alt td {
	background: #ecf6fc;
}

tr.over td, tr:hover td {
	background: #bcd4ec;
}
input {width:500px;}
#subm {width:100px;}

.slabel  
         {  
             width:100px;  
             display: -moz-inline-box;  
            line-height: 1.8;  
             display: inline-block;  
             text-align:right;  
         }  
         /* 出错样式 */  
        input.error, textarea.error  
        {  
            border: solid 1px #CD0A0A;  
       }  
label.error  
        {  
            color:#CD0A0A;  
            margin-left:5px;  
       }  
        /* 深红色文字 */  
.textred  {  
            color:#CD0A0A;  
        }  
</style>
</head>
<body>
<form action="server.php?action=send" method="post" enctype="multipart/form-data" id="myform">
<table width="800" align="center" id="mytable">
	<thead>
		<tr>
			<th height="73" colspan="2" align="center">邮件群发系统
			<div style="width:300px; display:block; background-color:#FF0000; text-align:center" align="center"><span>terry831010@163.com</div>
			</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>发送方式：</td>
			<td><select name="sendtype" id="sendtype">
		<option value="smtp">smtp</option>
		<option value="mail" >mail</option>
		</select></td>
		</tr>
		<tr  id="servertr">
			<td>SMTP Server：</td>
			<td><input type="text" name="server"  id="server"  value="<?php print isset($_POST['server']) ? $_POST['server'] : ''?>"/><span id="servererror"></span></td>
		</tr>
		<tr id="porttr">
			<td>PORT：</td>
			<td><input type="text" name="port"  id="port"  value="<?php print isset($_POST['port']) ? $_POST['port'] : ''?>"/><span id="porterror"></span></td>
		</tr>
		<tr id="usernametr">
			<td>用户名：</td>
			<td><input type="text" name="username"  id="username" value="<?php print isset($_POST['username']) ? $_POST['username'] : ''?>"/><span id="usernameerror"></span></td>
		</tr>
		<tr id="passwordtr">
			<td>密码：</td>
			<td><input type="password" name="password"  id="password" value="<?php print isset($_POST['password']) ? $_POST['password'] : ''?>"/>
			<span id="passworderror"></span></td>
		</tr>
		<tr>
			<td>发件人名称：</td>
			<td><input type="text" name="fromname"  id="fromname" value="<?php print isset($_POST['fromname']) ? $_POST['fromname'] : ''?>"/></td>
		</tr>
		<tr>
			<td>发件人邮件：</td>
			<td><input type="text" name="fromemail"  id="fromemail" value="<?php print isset($_POST['fromemail']) ? $_POST['fromemail'] : ''?>"/></td>
		</tr>
		<tr>
			<td>收件人邮件列表：</td>
			<td><input type="file" name="toemail"  id="toemail" /><span id="toemailerror"></span></td>
		</tr>
		<tr>
			<td>邮件主题：</td>
			<td><input type="text" name="subject"  id="subject" value="<?php print isset($_POST['subject']) ? $_POST['subject'] : ''?>"/><span id="subjecterror"></span></td>
		</tr>
		<tr>
			<td>邮件正文：</td>
			<td><textarea name="body" id="body"><?php print isset($_POST['body']) ? $_POST['body'] : ''?></textarea>
			<script type="text/javascript" src="public/ckeditor/ckeditor.js">
			<script type="text/javascript">CKEDITOR.addStylesSet( 'my_styles', [{ name : 'style 1', element : 'h2', styles : { 'color' : 'Blue','font-weight' : 'bold'} },{ name : 'style 2', element : 'h2', styles : { 'color' : 'Red','font-weight' : 'bold','text-decoration' : 'underline'} }]);</script><script type="text/javascript">
		CKEDITOR_BASEPATH = 'public/ckeditor/';
		CKEDITOR.replace('body', {toolbar : 'MyToolbar',width : '800px',height : '360px'});CKEDITOR.config.stylesCombo_stylesSet = 'my_styles';
	</script>	<span id="bodyerror"></span>
			</td>
		</tr>
		<tr>
			<td>附件：</td>
			<td><input type="file" name="attachment"  id="attachment"/></td>
		</tr>
		<tr>
		  <td  colspan="2" align="center"> <input  type="submit"  value="发送" id="subm"/></td>
		</tr>
	</tbody>
</table></form>
<div id="tip" style="display:none"><img src="public/images/ajax-loader.gif"  border="0"/> <font color="#FF0000">正在发送，请等待...</font></div>
<script language="javascript">
$(document).ready(function(){
	$("#sendtype").change(function() {
		if($(this).find('option:selected').val() == 'smtp') {
			$('#servertr').show();
			$('#porttr').show();
			$('#usernametr').show();
			$('#passwordtr').show();
			$('#authtr').show();
		} else {
			$('#servertr').hide();
			$('#porttr').hide();
			$('#usernametr').hide();
			$('#passwordtr').hide();
			$('#authtr').hide();
		}
	});
	
	 
	
	$('#subm').click(function(){
		$('$tip').show();
	});
	
	
	$('#myform').submit(function(){
		var　options　=　{　
		target:'#tip',
		beforeSubmit:  validate,
		url:'server.php?action=send',
		type:'POST',　
		success:　function(){　}
		};
		$('#myform').ajaxSubmit(options);
		return　false;
	});
	
	
	function validate(formData, jqForm, options) { 
		var form = jqForm[0]; 
		if (form.sendtype.value == 'smtp') { 
			if(!form.server.value) {
				$("#servererror").html('<font color="red">SMTP服务器地址必须填写！</font>');
				return false; 
			} else {
				$("#servererror").html('');
			}
			if(!form.port.value) {
				$("#porterror").html('<font color="red">SMTP服务器端口必须填写！</font>');
				return false; 
			} else {
				$("#porterror").html('');
			}
			if(!form.username.value) {
				$("#usernameerror").html('<font color="red">用户名必须填写！</font>');
				return false; 
			} else {
				$("#usernameerror").html('');
			}
			if(!form.password.value) {
				$("#passworderror").html('<font color="red">密码必须填写！</font>');
				return false; 
			} else {
				$("#passworderror").html('');
			}
		} 
		if(!form.toemail.value) {
				$("#toemailerror").html('<font color="red">收件人地址必须上传xls文件！</font>');
				return false; 
		} else {
				$("#toemailerror").html('');
			}
		if(!form.subject.value) {
				$("#subjecterror").html('<font color="red">邮件主题必须填写！</font>');
				return false; 
		} else {
				$("#subjecterror").html('');
			}
		if(!form.body.value) {
				$("#bodyerror").html('<font color="red">邮件正文必须填写！</font>');
				return false; 
		} else {
				$("#bodyerror").html('');
			}
		$('#tip').html('<img src="public/images/ajax-loader.gif"  border="0"/> <font color="#FF0000">正在发送，请等待...</font>');
		$('#tip').show();
	}
});

</script>
</body>
</html>

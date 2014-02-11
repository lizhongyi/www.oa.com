<?php
header("Content-type: text/html;charset=utf-8");
if($_POST['sendtype']) {
	set_time_limit(0);
	 require_once './include/reader.php';
	// require('include/class.phpmailer.php')		
				   
	$uploadpath = './public/tmpfiles/';
	//$mail = new PHPMailer(true); //New instance, with exceptions enabled
//	$mail->CharSet = 'utf-8';
//	$mail->Timeout = 15;
//	$mail->SMTPDebug = true;
//	$mail->SMTPKeepAlive = true;
//	if(preg_match('/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/',$_POST['fromemail'])) {
//		$mail->AddReplyTo($_POST['fromemail'],$_POST['fromname']);
//	} else {
//		print '发件人邮件地址不正确！<br>';
//	}
//	
//	$mail->From       = $_POST['fromemail'];
//	$mail->FromName   = $_POST['fromname'];
//	$mail->Subject  =  $_POST['subject'];
//	$mail->AltBody    = $_POST['body']; // optional, comment out and test
//	$mail->WordWrap   = 80; // set word wrap
//	$mail->MsgHTML($_POST['body']);
//	$mail->IsHTML(true); // send as HTML
//	$attached = false;

    $subject= $_POST['subject'];
	$body=    $_POST['body'];




	if(isset($_FILES['attachment']['name'])) {
		$attachfilename = basename($_FILES['attachment']['name']);
	}
	
	if (move_uploaded_file($_FILES['attachment']['tmp_name'],$uploadpath.$attachfilename)) {
		$mail->AddAttachment($uploadpath.$attachfilename);
		$attached = true;
	}
	
	//if($_POST['sendtype'] == 'smtp'){
//		$mail->Mailer = "smtp";
//		//$mail->IsSMTP();     
//		$mail->SMTPAuth   = true;                  // enable SMTP authentication
//		$mail->Port       = $_POST['port'];                    // set the SMTP server port
//		$mail->Host       = $_POST['server']; //"ssl://smtp.gmail.com:465"; // SMTP server
//		$mail->Username   = $_POST['username']; // "jjk@dx.com";     // SMTP server username
//		$mail->Password   = $_POST['password']; //"11111111";            // SMTP server password
//	} else {
//		$mail->IsMail();
//	}
//	
	$filename = $_FILES['toemail']['tmp_name'];
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP936');
	if (is_readable($filename)) {
		$data->read($filename);
	} else {
		print '没有收件人列表！请上传xls格式文件。<br>';
		exit;
	}
	
	print '<font color="blue">正在发送...</font><br>';
	
	$sc =  count($data->boundsheets) ;
	$count = 0;   
	$error = 0;
	for($s=0;$s <= $sc - 1;$s++){
		if(is_array($data->sheets[$s]['cells'])) {
			foreach($data->sheets[$s]['cells']   as  $val) {
					if(trim($val[1]) != '') {
						preg_match('/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/',$val[1],$match);
						
						
						if(trim($match[0]) != '') {
							 
							$send=send_email($match[0], $subject,$body,$charset='UTF-8', $is_html=TRUE,$attachment = null);
							
							if($send){
								print '邮件'.$match[0].'发送成功！。<br>';
								$count++;
							} else {
								$error++;
								print '<font color="green">邮件'.$match[0].'发送失败！。</font><br>';
							}
							
						}
					}
			}
		}
	}
	
	unset($data);
	print '<font color="red">恭喜,发送成功!此次共发送成功'.$count.'封邮件！'.$error.'封发送失败.</font>';
	if($attached) unlink($uploadpath.$attachfilename);
}








         
		function send_email($address,$subject,$body, $charset, $is_html, $receipt = false){
		
	
				       
					    require_once('includes/mailer.class.php');
				
				         $from      =    'jobme.cn';
				         $email     =    '165256676@qq.com';
						 $protocol  =    '1';
						 $host      =    'smtp.qq.com';
						 $port      =    '25'; 
						 $user      =    '165256676@qq.com'; 
						 $pass      =    'kajielinon-009'; 
						
						
						
			            $smtp      =     new Mailer($from, $email, $protocol, $host, $port, $user, $pass);
						
						       //对邮件内容进行必要的过滤
					
						
						if($smtp){
						                 $fasong=$smtp->send($address,$subject,$body, $charset, $is_html=true, $receipt = false);
						                 if($fasong){
							
							               return 1;
							
							             }else{
							                return  0;	
							             }
										 
						     }
						  else
						{
						 
						 echo  "邮件错误";	
							
						}


}




?>
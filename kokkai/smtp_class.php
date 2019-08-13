<?php
class smtp_class{
	
	/* mail header setting */
	var $Priority			= 3;
	var $CharSet			= "iso-8859-1";
	var $ContentType		= "text/plain";
	var	$Encoding			= "8bit";
	var	$FromEmail			= "root@localhost";
	var	$FromName			= "root";
	var $Subject			= "";
	var $Body				= "";
	var $WordWrap			= "";
	var $MailerDebug		= false;
	var $UseMSMailHeaders	= true;
	var $IsHTML				= false;
	var $IPAddress			= "unknown";
	var $Timezone			= "+0000";
	
	
	/* SMTP setting */
	var $Host				= "localhost";
	var $Port				= 25;
	var $Timeout			= 10;
	var $Helo				= "";
	
	
	/* private variables */
	var $Version			= "";
	var $To					= array();
	var $Cc					= array();
	var $Bcc				= array();
	var $ReplyTo			= array();
	var $Attachment			= array();
	var $CustomHeader		= array();
	var $boundary			= "";
	var $ErrorAlerts		= array();
	var $AuthLogin			= false;
	var $AuthUser			= "";
	var $AuthPass			= "";
	var $CRLF				= "\r\n";
	var $error_status		= false;
	var $current_count		= 0;
	
	
	function From($address,$name){
		$this->FromEmail=trim($address);
		if($name==""){
			$this->FromName=$this->FromEmail;
		}else{
			$this->FromName=$name;
		}
	}
	
	
	function AddTo($address,$name){
		$current_count=count($this->To);
		$this->To[$current_count][0]=trim($address);
		$this->To[$current_count][1]=$name;
	}
	
	/*
	function AddCc($address,$name){
		$current_count=count($this->Cc);
		$this->Cc[$current_count][0]=trim($address);
		$this->Cc[$current_count][1]=$name;
	}
	
	function AddBcc($address,$name){
		$current_count=count($this->Bcc);
		$this->Bcc[$current_count][0]=trim($address);
		$this->Bcc[$current_count][1]=$name;
	}
	
	function AddReplyTo($address,$name){
		$current_count=count($this->ReplyTo);
		$this->ReplyTo[$current_count][0]=trim($address);
		$this->ReplyTo[$current_count][1]=$name;
	}
	
	
	function AddAttachment($path,$name,$type="application/octet-stream"){
		if($name==""){
			$name=basename($path);
		}
		
		$current_count=count($this->Attachment);
		$this->Attachment[$current_count][0]=$path;
		$this->Attachment[$current_count][1]=$name;
		$this->Attachment[$current_count][2]=$type;
	}
	*/
	
	
	function SMTP_open($host,$port,$timeout){
		$this->smtp_connection=fsockopen($host,$port,$errno,$errstr,$timeout);
		if(empty($this->smtp_connection)){
			return false;
		}
	
		$this->get_lines();
		return true;
	}
	
	
	function SMTP_close(){
		fclose($this->smtp_connection);
		return true;
	}
	
	
	function Send(){
		
		# open SMTP connection
		if(!$this->SMTP_open($this->Host,$this->Port,$this->Timeout)){
			$this->error_handler("SMTP Error: SMTP Connection Fail.");
			return false;
		}
		
		# if SMTP need authorization
		if($this->AuthLogin==true){
			
			# send the EHLO command to SMTP
			$this->send_lines("EHLO ".$this->Host);
			if(substr($this->get_lines(),0,3)!=250){
				$this->error_handler("SMTP Error: EHLO not accepted from server.");
			}
			
			# send AUTH LOGIN command
			if($this->error_status==false){
				$this->send_lines("AUTH LOGIN");
				if(substr($this->get_lines(),0,3)!=334){
					$this->error_handler("SMTP Error: AUTH LOGIN not accepted from server.");
				}
			}
			
			# username and password authorization
			if($this->error_status==false){
				$this->SMTP_Auth();
				if(substr($this->get_lines(),0,3)!=235){
					$this->error_handler("SMTP Error: Authentication failed.");
				}
			}
			
		}else{
			
			# send the HELO command to SMTP
			$this->send_lines("HELO ".$this->Host);
			if(substr($this->get_lines(),0,3)!=250){
				$this->error_handler("SMTP Error: HELO not accepted from server.");
			}
			
		}
		
		
		# define sender email
		if($this->error_status==false){
			$this->send_lines("MAIL FROM: ".$this->FromEmail);
			if(substr($this->get_lines(),0,3)!=250){
				$this->error_handler("SMTP Error: MAIL not accepted from server.");
			}
		}
		
		
		# define sending email address
		$this->reset_current_count();
		while($this->error_status==false and $this->current_count<count($this->To)){
			
			$this->SMTP_RCPT($this->To[$this->current_count][0]);
			$this->current_count++;
			
		}
		$this->reset_current_count();
		while($this->error_status==false and $this->current_count<count($this->Cc)){
			
			$this->SMTP_RCPT($this->Cc[$this->current_count][0]);
			$this->current_count++;
			
		}
		$this->reset_current_count();
		while($this->error_status==false and $this->current_count<count($this->Bcc)){
			
			$this->SMTP_RCPT($this->Bcc[$this->current_count][0]);
			$this->current_count++;
			
		}
		
		
		# send mail
		$this->SMTP_Data("");
		
		
		# close SMTP connection
		$this->SMTP_close();
		
		
		# return send email success or fail
		if($this->error_status){
			return false;
		}else{
			return true;
		}
	}
	
	function reset_current_count(){
		$this->current_count=0;
	}
	
	function SMTP_RCPT($emailto){
		# send the RCPT TO command to SMTP
		$this->send_lines("RCPT TO: ".$emailto);
		if(substr($this->get_lines(),0,3)!=250){
			$this->error_handler("SMTP Error: RCPT TO not accepted from server.");
		}
	}
	
	
	function SMTP_Auth(){
		$this->send_lines(base64_encode($this->AuthUser));
		$this->get_lines();
		$this->send_lines(base64_encode($this->AuthPass));
	}
	
	
	function SMTP_Data($message){
		# send the DATA command to SMTP
		if($this->error_status==false){
			$this->send_lines("DATA");
			if(substr($this->get_lines(),0,3)!=354){
				$this->error_handler("SMTP Error: DATA not accepted from server.");
			}
		}
		
		if($this->error_status==false){
			$this->boundary="_alangor" . md5(uniqid(time()));
			
			# send header
			$this->Create_Header();
			
			# send body
			if(count($this->Attachment)>0){
				$this->send_lines("----=".$this->boundary);
				$this->send_lines("Content-Type: ".$this->IsHTML($this->IsHTML)."; charset=\"".$this->CharSet."\";");
				$this->send_lines("");
			}
			$this->Create_Body();
			$this->send_lines("");
			
			# add attachment
			if(count($this->Attachment)>0){
				$this->append_attachment();
			}
			
			# end of message
			$this->send_lines(".");
		}
		
		
	}
	
	
	function Create_Header(){
		$this->send_lines("Received: from client ".getenv("REMOTE_ADDR")." for alangor.com development team; ".date("D, j M Y G:i:s")." ".$this->Timezone);
		$this->send_lines("Date: ".date("D, j M Y G:i:s")." ".$this->Timezone);
		$this->send_lines("From: \"".$this->FromName."\" <".$this->FromEmail.">");
		if(count($this->To)>0){
			$this->send_lines($this->append_email("To",$this->To));
		}
		if(count($this->Cc)>0){
			$this->send_lines($this->append_email("Cc",$this->Cc));
		}
		if(count($this->ReplyTo)>0){
			$this->send_lines($this->append_email("Reply-to",$this->ReplyTo));
		}
		$this->send_lines("Subject: ".$this->Subject);
		$this->send_lines("X-Priority: ".$this->Priority);
		$this->send_lines("X-Mailer: ".$this->Version);
		$this->send_lines("X-Original-IP: ".getenv("REMOTE_ADDR"));
		$this->send_lines("Content-Transfer-Encoding: ".$this->Encoding);
		$this->send_lines("Return-Path: ".$this->FromEmail);
		$this->send_lines("MIME-Version: 1.0");
		if(count($this->Attachment)>0){
			$this->send_lines("Content-Type: multipart/mixed; charset=\"".$this->CharSet."\";");
			$this->send_lines("\tboundary=\"--=".$this->boundary."\"");
		}else{
			$this->send_lines("Content-Type: ".$this->IsHTML($this->IsHTML)."; charset=\"".$this->CharSet."\";");
		}
		$this->send_lines("");
	}
	
	
	function Create_Body(){
		if($this->WordWrap){
			$this->Body=wordwrap($this->Body,$this->WordWrap,"\n",1);
		}
		$this->send_lines(ereg_replace("\n","\r\n",$this->Body));
	}
	
	
	function append_email($type,$email) {
		$email_string=$type.": ";
		for($i=0;$i<count($email);$i++){
			if($i>0){
				$email_string.=",\r\n\t";
			}
			if(trim($email[$i][1])!= ""){
				$email_string.="\"".$email[$i][1]."\" <".$email[$i][0].">";
			}else{
				$email_string.="\"".$email[$i][1]."\"";
			}
		}
		return($email_string);
	}
	
	
	function append_attachment(){
		for($i=0;$i<count($this->Attachment);$i++){
			$this->send_lines("----=".$this->boundary);
			$this->send_lines("Content-Type: ".$this->Attachment[$i][2]."; name=\"".$this->Attachment[$i][1]."\"");
			$this->send_lines("Content-Transfer-Encoding: base64");
			$this->send_lines("Content-Disposition: attachment; filename=\"".$this->Attachment[$i][1]."\"\r\n");
			$this->send_lines(chunk_split(base64_encode(implode(file($this->Attachment[$i][0]))))."\r\n");
		}
	}
	
	function IsHTML($status){
		if($status==true){
			return $this->ContentType="text/html";
		}else{
			return $this->ContentType="text/plain";
		}
	}
	
	
	function error_handler($message){
		if($this->MailerDebug==true){
			echo $message;
		}
		if($message!=""){
			return $this->error_status=true;
		}else{
			return $this->error_status=false;
		}
	}
	
	
	function get_lines(){
		while($data=fgets($this->smtp_connection,1024)){
			if(substr($data,3,1)==" "){
				break;
			}
		}
		return $data;
	}
	
	
	function send_lines($command){
		fputs($this->smtp_connection,$command."\r\n");
	}
	
}

	function send_mail($from, $to, $content)
	{
		$mail=new smtp_class(); 

		# email setting 
		$mail->Host            = $_SERVER["SERVER_ADDR"];  // SMTP server. like smtp.21cn.com
		$mail->Port            = 25;  // SMTP port. Default: 25; 
		$mail->Timeout        = 10;  // SMTP connection timeout. Default: 10; 
		$mail->Timezone        = "+0900";  // Time Zone. Default: "+0000"; 
		$mail->Priority        = 3;  // Email priority Default: 3 (1=High,3=Medium or 5=Low); 
		$mail->CharSet        = "UTF-8";  // Character set. 
		$mail->WordWrap        = 0;  // characters per line. 0 for umlimit characterc per line 
		$mail->IsHTML        = true;  // HTML email. Default: false (true or false); 
		$mail->MailerDebug    = true;  // Display SMTP error. Default: false (true or false); 
		$mail->AuthLogin    = false;  // using SMTP authorization. Default: false (true or false); 
		$mail->AuthUser        = "";  // SMTP username 
		$mail->AuthPass        = "";  // SMTP password 

		# email address and content start here 
		$mail->From($from,"KIDS JAPAN");
		$mail->AddTo($to,$to); 
		//$mail->AddCc("Email","Name"); 
		//$mail->AddBcc("Email","Name"); 
		//$mail->AddReplyTo("Email","Name"); 
		$mail->Subject="国会・地方議会会議録統合検索システムユーザー情報お知らせ"; 
		$mail->Body=$content; 


		# add attachment 
		//$mail->AddAttachment("filename.ext"); 


		# define attachment content 
		//$mail->AddAttachmentContent("attachment content","attachment_filename.ext"); 


		# check email success or fail with your own program
		$mail->Send();
		/*
		if(!$mail->Send()){ 
			print "<p>ユーザーにお知らせメールの送るが失敗しました。ホームページからもう一度操作してください</p>";
		}else{
			print "<p>ユーザーにお知らせメールを送りました。</p>";
		}
		*/
	}
	
	function mail_body($user_name, $permission, $active, $active_code)
	{
		$active_url = "http://{$_SERVER["SERVER_ADDR"]}/active.php?code={$active_code}";
		$login_url =  "http://{$_SERVER["SERVER_ADDR"]}/index.php";
		if($permission == "Y"){
			if($active == "Y"){
				return("{$user_name}様<br><br>
						アカウントの登録が完了致しました。<br>
						下記のURLで国会・地方議会会議録統合検索システムをご利用ください。<br><br><a href={$login_url}>{$login_url}</a><br>
						--<br>
						Copyright &copy; 2008 Keio University GCOE The Center of Governance for Civil Society All rights reserved. <br>
慶應義塾大学 市民社会ガバナンス教育研究センター");
			}else{
				return("{$user_name}様<br><br>
						アカウントの登録が完了致しました。<br>
						下記URLをクリックの上、国会・地方議会会議録統合検索システムをご利用ください。<br><br>
						<a href={$active_url}>{$active_url}</a><br><br><br>
						--<br>
						Copyright &copy; 2008 Keio University GCOE The Center of Governance for Civil Society All rights reserved. <br>
慶應義塾大学 市民社会ガバナンス教育研究センター");
			}
		}else if($permission == "R"){
				return("{$user_name}様<br><br>
						お申し込みのアカウントはご利用でいただけません。<br>
						再度国会・地方議会会議録統合検索システムのお申し込みをお願い致します。<br><br><br>
						--<br>
						Copyright &copy; 2008 Keio University GCOE The Center of Governance for Civil Society All rights reserved. <br>
慶應義塾大学 市民社会ガバナンス教育研究センター");
		}else{
			return("");
		}
	}
?>
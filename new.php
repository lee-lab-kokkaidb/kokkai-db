<?php
	function __autoload($class_name) {
	    require_once $class_name.".php";
	}
	session_start();
	session_unregister('user');
	
	$smarty = new mysmarty();
	$smarty->assign('no_tab', "true");
	/* ログインしているか且つ管理者の権限があるかをチェックする */
	$com = new common();
	
	$com->user_login_check();
	$com->user_authority_check();
	
	$db = new db();
	$mail = new smtp_class();
	
	$alert = "";
	$success = "";
	
	$db->db_connect();
	
	if($_SERVER{'REQUEST_METHOD'} == "POST"){
		$Guid = new Guid();
		
		$user_id = $_POST{'user_id'};
		$password = md5($_POST{'password'});
		$user_name = $_POST{'user_name'};
		$company = $_POST{'company'};
	  	$email  = $_POST{'email'};
  		$reason = $_POST{'reason'};
	  	$permission = $_POST{'permission'};
  		$active = $_POST{'active'};
	  	$authority = "N";
  		$active_code = $Guid->toString();

  		$sql = "select * from t_user where user_id = '$user_id'";
  		$R = pg_query("$sql");
  	
  		$rows = pg_num_rows($R);
		
  		if($rows != 0 ){
			$alert = "入力したユーザーIDは既に存在します。
異なるIDを入力してください。";
  		}else{
  	  		$sql = "insert into t_user 
  			(user_id,password,user_name,permission,active,active_code,company,email,reason,authority)
  			values('$user_id','$password','$user_name','$permission','$active','$active_code','$company','$email','$reason','$authority')";

			$R = pg_query("$sql");
  			$cmdtuples = pg_affected_rows($R);
			$db->db_close();
			
			if($cmdtuples == 0){
				$success = "ユーザー登録が失敗しました。ホームページからもう一度登録してください。<br><br><input class=back type=button onclick='document.location = \"manage.php\"'>";
			}else{
				$success = $user_name."様のアカウントを登録しました。";
				if($permission != "N"){
					$mail_body =  mail_body($user_name, $permission, $active, $active_code);
					send_mail($_SESSION{'email'}, $email, $mail_body);
				}
			}
		}
	}
	if($success == ""){
		$smarty->assign('error', "$alert");
		$smarty->assign('user_id',   "$user_id");
		$smarty->assign('user_name', "$user_name");
		$selected_n = "";
		$selected_y = "";
		$selected_R = "";
		switch($permission){
			case "N":	$selected_n = "selected";
						break;
			case "Y":	$selected_y = "selected";
						break;
			case "R":	$selected_r = "selected";
						break;
		}
		$selected_yy = "";
		$selected_nn = "";
		switch($active){
			case "Y":	$selected_yy = "selected";
						break;
			case "N":	$selected_nn = "selected";
						break;
		}
		$smarty->assign('selected_n' ,  "$selected_n");
		$smarty->assign('selected_y' ,  "$selected_y");
		$smarty->assign('selected_r' ,  "$selected_r");
		$smarty->assign('selected_nn', "$selected_nn");
		$smarty->assign('selected_yy', "$selected_yy");
		$smarty->assign('company',   "$company");
		$smarty->assign('email',     "$email");
		$smarty->assign('reason',    "$reason");
		$smarty->display('new.tpl',"ユーザー登録");
	}else{
		$success .= "<br><br><input class=back type=button onclick='document.location = \"manage.php\"'>";
		$smarty->assign('message', "$success");
		$smarty->display_dialog('message.tpl');
	}
?>
<?php

	function __autoload($class_name) {
	    require_once $class_name.".php";
	}
	session_start();
	//include_once"./include/mail_send.php";
		
	$smarty = new mysmarty();
	$smarty->assign('no_tab', "true");
	/* ログインしているか且つ管理者の権限があるかをチェックする */
	$com = new common();
	
	$com->user_login_check();
	$com->user_authority_check();

	$mail = new smtp_class();
	$db = new db();
	
	$alert = "";
	$success = "";
	$db->db_connect();
	
	if($_SERVER{'REQUEST_METHOD'} == "POST"){

		$user_id = $_POST{'user_id'};
		$password = $_POST{'password'};
		$user_name = $_POST{'user_name'};
		$company = $_POST{'company'};
  		$email  = $_POST{'email'};
		$reason = $_POST{'reason'};
  		$permission = $_POST{'permission'};
		$active = $_POST{'active'};
		$active_code = $_POST{'active_code'};
		
		if($password == ""){
			$sql = "update t_user set user_name = '$user_name', permission = '$permission', active = '$active', company = '$company', email = '$email', reason = '$reason' where user_id = '$user_id'";
		}else{
			$password = md5($password);
			$sql = "update t_user set password = '$password', user_name = '$user_name', permission = '$permission', active = '$active', company = '$company', email = '$email', reason = '$reason' where user_id = '$user_id'";
		}
	
		$R = pg_query("$sql");
		$cmdtuples = pg_affected_rows($R);
		$db->db_close();
		if($cmdtuples == 0){
			$success = "ユーザーの更新が失敗しました。<br><br><input class=back type=button onclick='document.location = \"manage.php\"'>";
		}else{
			$success = "ユーザーの更新が成功しました。";
					
			if($permission != "N"){
				$mail_body =  mail_body($user_name, $permission, $active, $active_code);
				send_mail($_SESSION{'email'}, $email, $mail_body);
			}
		}
	}else{
		$user_id = $_GET{'user_id'};
		$sql = "select * from t_user where user_id = '$user_id'";
		$R = pg_query("$sql");
	  	$rows = pg_num_rows($R);
	  	$db->db_close();
	  	if($rows == 0 ){
			$alert = "ユーザーが存在しません。";
		}else{
			$data = pg_fetch_array($R, 0);
			$user_name= $data{'user_name'};
			$permission = $data{'permission'};
			$active = $data{'active'};
			$company = $data{'company'};
			$email  = $data{'email'};
			$reason= $data{'reason'};
			$active_code = $data{'active_code'};
		}
	}
	if($success == ""){
		$smarty->assign('error',     "$alert");
		$smarty->assign('user_id',   "$user_id");
		$smarty->assign('user_name', "$user_name");
		//$smarty->assign('permission', "$permission");
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
		$smarty->assign('active_code', "$active_code");
		$smarty->display('change.tpl',"ユーザー情報変更");
	}else{
		$success .= "<br><br><input class=back type=button onclick='document.location = \"manage.php\"'>";
		$smarty->assign('message', "$success");
		$smarty->display('message.tpl');
	}	
?>
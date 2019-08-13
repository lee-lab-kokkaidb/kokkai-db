<?php
	function __autoload($class_name) {
	    require_once $class_name.".php";
	}
	
	$smarty = new mysmarty();
	$smarty->assign('no_tab', "true");
	$db = new db();
	
	$success = "";
	$alert = "";
	
	session_start();
	// user login check
	$com = new common();
	$com->user_login_check();

	$db->db_connect();

	if($_SERVER{'REQUEST_METHOD'} == "POST"){
		$user_id = $_POST{'user_id'};
		$password = $_POST{'password'};
		$user_name= $_POST{'user_name'};
		$company = $_POST{'company'};
  		$reason= $_POST{'reason'};
		
		if($password == ""){
			$sql = "update t_user set user_name = '$user_name', company = '$company', reason = '$reason' where user_id = '$user_id'";
		}else{
			$password = md5($password);
			$sql = "update t_user set password = '$password', user_name = '$user_name', company = '$company', reason = '$reason' where user_id = '$user_id'";
		}
				
		$R = pg_query("$sql");
		$cmdtuples = pg_affected_rows($R);
			
		if($cmdtuples == 0){
			$success = "個人情報の更新が失敗しました。<br><br><input class=close type=button onclick='document.location = \"userupdate.php\"'>";
		}else{
			$success = "個人情報の更新が成功しました。<br><br><input class=close type=button onclick=\"window.close()\">";
		}
	}else{
		$user_id = $_SESSION{'user_id'};
		$sql = "select * from t_user where user_id = '$user_id'";
		$R = pg_query("$sql");
  		$rows = pg_num_rows($R);
  		if($rows == 0 ){
			$alert = "ユーザーが存在しません。";
		}else{
			$data = pg_fetch_array($R, 0);
			$user_name= $data{'user_name'};
			$company = $data{'company'};
		  	$email  = $data{'email'};
	  		$reason= $data{'reason'};
		}
		$db->db_close();		
	}
	
	if($success == ""){
		$smarty->assign('error',     "$alert");
		$smarty->assign('user_id',   "$user_id");
		$smarty->assign('user_name', "$user_name");
		$smarty->assign('company',   "$company");
		$smarty->assign('email',     "$email");
		$smarty->assign('reason',    "$reason");
		$smarty->display('update.tpl', '個人情報変更');
	}else{
		$smarty->assign('message', "$success");
		$smarty->display('message.tpl');
	}
?>
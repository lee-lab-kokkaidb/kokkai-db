<?php
	function __autoload($class_name) {
	    require_once $class_name.".php";
	}
	session_start();
		
	$smarty = new mysmarty();
	/* ログインしているか且つ管理者の権限があるかをチェックする */
	$com = new common();
	
	$com->user_login_check();
	$com->user_authority_check();

	$smarty->assign('no_tab', "true");
	$db = new db();
	
	$db->db_connect();
	$alert = "";
	
	if($_SERVER{'REQUEST_METHOD'} == "GET"){
		$user_id = $_GET{'user_id'};
//		$authority = $_SESSION{'authority'};
		
		$sql = "select * from t_user where user_id = '$user_id'";
		$R = pg_query("$sql");

		$rows = pg_num_rows($R);

		if($rows == 0 ){
			$alert = "指定したユーザーが存在しません。";
		}else{
			$data = pg_fetch_array($R, 0);
			$user_id = $data{'user_id'};
			$user_name= $data{'user_name'};
			$permission = $data{'permission'};
			$active = $data{'active'};
			$company = $data{'company'};
			$email  = $data{'email'};
			$reason= $data{'reason'};
			switch($permission){
				case "Y": $permission = "許可";break;
				case "N": $permission = "未処理";break;
				case "R": $permission = "禁止";break;
			}
			switch($active){
				case "Y": $active = "アクティブ";break;
				case "N": $active = "未アクティブ";break;
			}
		}
  		$db->db_close();
  		$smarty->assign('error',      "$alert");
		$smarty->assign('user_id',    "$user_id");
		$smarty->assign('user_name',  "$user_name");
		$smarty->assign('permission', "$permission");
		$smarty->assign('active', 	  "$active");
		$smarty->assign('company',    "$company");
		$smarty->assign('email',      "$email");
		$smarty->assign('reason',     "$reason");
		$smarty->display('inquiry.tpl',ユーザー情報照会);
	}
?>
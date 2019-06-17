<?php
	function __autoload($class_name) {
	    require_once $class_name.".php";
	}
	
	$smarty = new mysmarty();
	$db = new db();
	$db->db_connect();
	
	$active_code = $_GET{'code'};
	$sql = "select * from t_user where active_code = '$active_code'";
  	$R = pg_query("$sql");
  	$rows = pg_num_rows($R);
  	
  	if($rows == 0){
  		$message = "ユーザーが存在しません。";
  	}else{
  		$data = pg_fetch_array($R, 0);
  		$user_name = $data{'user_name'};
  		if($data{'permission'} == "Y"){
  			if($data{'active'} == "Y"){
  				$message = "{$user_name}さん、ユーザーアカウントは既にアクティブです。";
  			}else{
				$sql = "update t_user set active = 'Y' where active_code = '$active_code'";
				$R = pg_query("$sql");
				$message = "{$user_name}さん、ユーザーアカウントをアクティブにしました。";
			}
			$message .= "<br><br><input type=button class=login value=''  onClick = \"window.location.href = 'index.php'\">";
		}else{
			$message = "{$user_name}さん、ユーザーアカウントをアクティブにできませんでした。管理者にお問い合わせください。";
		}
	}
	$db->db_close();
	$smarty->assign('message', "$message");
	$smarty->display('message.tpl');
?>
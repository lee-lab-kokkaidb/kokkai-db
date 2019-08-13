<?php
	function __autoload($class_name) {
	    require_once $class_name.".php";
	}
	
	$smarty = new mysmarty();
	$smarty->assign('no_tab', "true");

	$db = new db();

	$success = "";
	$alert = "";

	if($_SERVER{'REQUEST_METHOD'} == "POST"){
	
		$Guid = new Guid();
		
		$db->db_connect();
		
		$user_id = $_POST{'user_id'};
		$password = md5($_POST{'password'});
		$user_name = $_POST{'user_name'};
		$company = $_POST{'company'};
	  	$email  = $_POST{'email'};
		$reason = $_POST{'reason'};
	  	$permission = "N";
  		$active = "N";
	  	$authority = "N";
  		$active_code = $Guid->toString();
  	
  		$sql = "select * from t_user where user_id = '$user_id'";
  		$R = pg_query("$sql");
  		$rows = pg_num_rows($R);
		
  		if($rows != 0 ){
			$alert = "入力したユーザーIDは既に存在します。異なるIDを入力してください。";

  		}else{
  	
	  		$sql = "insert into t_user 
  			(user_id,password,user_name,permission,active,active_code,company,email,reason,authority)
  			values('$user_id','$password','$user_name','$permission','$active','$active_code','$company','$email','$reason','$authority')";
  	
  			$R = pg_query("$sql");
  			$cmdtuples = pg_affected_rows($R);
			
			if($cmdtuples == 0){
				$alert = "申し込みが失敗しました。";
			}else{
				$success = $user_name."様、お申し込み有難うございました。お申し込み内容を確認後、管理者よりお知らせMailをお送り致します。<br><br><input class=back type=button onclick='document.location = \"index.php\"'>";
			}
			$db->db_close();
		}
	}
	
	if($success == ""){
		$smarty->assign('error', "$alert");
		$smarty->assign('user_id', "$user_id");
		$smarty->assign('user_name', "$user_name");
		$smarty->assign('company', "$company");
		$smarty->assign('email', "$email");
		$smarty->assign('reason', "$reason");
		$smarty->display('register.tpl', 'ユーザー申し込み');
	}else{
		$smarty->assign('message', "$success");
		$smarty->display('message.tpl');
	}
?>
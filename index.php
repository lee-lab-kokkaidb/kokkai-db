<?php
	session_start();

	include_once  'mysmarty.php';
	include_once  'db.php';
	include_once  'user_model.php';
	$smarty = new mysmarty();
	
	/* logout */
	// logoutURL:index.php?logout=true
	if(isset($_REQUEST['logout'])){
		$smarty->assign('error', "");
		session_unset();
		session_destroy();
	}

	/* login */
	// loginURL: index.php
	if(isset($_REQUEST['login'])){
		$user = new user_model();
		$user_id = $_REQUEST['user_id'];
		$user_info = $user->user_get_check();
		if($user_info['user_id'] == $user_id){
			//ユーザー管理システム用のパラメータをSessionに保存,logoutする際クリアされる。
			$_SESSION['user_id'] = $user_id;
			$_SESSION['authority'] = $user_info['authority'];
			$_SESSION['user_name'] = $user_info['user_name'];
			$_SESSION['email'] = $user_info['email'];
		}else{
			//ログインエラーの時に、ログインで使ったユーザーIDを残す為に
			$smarty->assign('user_id',  $user_id);
			//エラー情報
			$smarty->assign('error', $user_info);
			}
	}

	/* ページの表示 */
	if(!isset($_SESSION['user_id'])){
		// ログイン画面の表示
		$smarty->display('login.tpl');
	}else{
		// メイン画面(検索)を表示する
		include 'search.php';
	}
?>

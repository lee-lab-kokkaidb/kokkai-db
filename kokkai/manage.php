<?php

	function __autoload($class_name) {
	    include_once $class_name . '.php';
	}

	session_start();

	$smarty	= new mysmarty();

	/* ログインしているか且つ管理者の権限があるかをチェックする */
	$com = new common();
	
	$com->user_login_check();
	$com->user_authority_check();
	
	/* １ページにおいて、表示するレコード数(固定値) */
	$disp_rows = 20;
		
	$user	= new user_model();

	switch($_REQUEST['mode'])
	{
	case 'search':
		$_SESSION['user']["order"] = "reg_dt";
		$_SESSION['user']['direction'] = "DESC";
		$_SESSION['user']['page'] = 1;
		// POSTした情報から検索条件のuser_id,user_name,permission,activeを取得する
	case 'order':
	case 'page':
		// POSTした情報から表示用ののpage,order,directionを取得する
		$_SESSION['user'] = array_merge($_SESSION['user'], $_REQUEST);
	}

	/* 削除処理 */
	if ($_REQUEST['selected_id'] != "") {
		//削除処理対して、データベースからの提示情報により、削除結果を確認する
		if($user->user_delete($_REQUEST['selected_id']) != "1"){
			$alert = "削除エラー：".$_REQUEST['selected_id'];
			$smarty->assign("alert",$alert);
		}
	}

	//defaultの場合に、登録日付の降順でソーティングする
	if($_SESSION['user']["order"] == ""){
		$_SESSION['user']["order"] = "reg_dt";
	}
	if($_SESSION['user']['direction'] == "") {
		$_SESSION['user']['direction'] = "DESC";
	}
	
	/* 検索用FORM */
	// 許可状態とアクティブ状態に関してのHTMLコードの生成する為の情報格納
	$smarty->assign('search_permission_options',array(
														''=>'',
														'N'=>'未処理',
														'Y'=>'許可',
														'R'=>'禁止'));
	$smarty->assign('search_permission_select',$_SESSION['user']['permission']);

	$smarty->assign('search_active_options',array(
														''=>'',
														'N'=>'未アクティブ',
														'Y'=>'アクティブ'));
	$smarty->assign('search_active_select',$_SESSION['user']['active']);	


	/* ページング機能 */
	if($_SESSION['user']['page'] == "") {
		$_SESSION['user']['page'] = 1;
	}
	//件数
	$_SESSION['user']['count_of_user_list'] = $user->user_get_count();
	//ページ数
	$_SESSION['user']['maxpage']  = ceil($_SESSION['user']['count_of_user_list'] /$disp_rows);

	/* ユーザー情報のリストを取得する */
	$lines	= $user->user_get_list($disp_rows);

	$smarty->assign("search",$_SESSION['user']);
	
	$smarty->assign("lines",$lines);

	/* debug用 */
//	echo "debug information:<BR>";
//	print_r($_SESSION['user']);

	$smarty->display('manage.tpl', 'ユーザー管理');
	
?>
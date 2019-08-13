<?php
	function __autoload($class_name) {
	    include_once $class_name . '.php';
	}

	session_start();
	
	$smarty = new mysmarty();
	$model	= new list_model();
	$dict	= new dict_model();

	// user login check
	$com = new common();
	$com->user_login_check();

//$time_start = microtime(true);

	// モード別処理
	switch($_REQUEST['mode']){
	case 'search':
		$_SESSION['search'] = array_merge($_SESSION['search'], $_REQUEST);		// セッション内容を更新
	case 'report':
//		$_SESSION['pop'] = ($_SESSION['pop'], $_SESSION['search']);
		$_SESSION['pop'] = $_SESSION['search'];
		$_SESSION['pop'] = array_merge($_SESSION['pop'], $_REQUEST);
		$_SESSION['pop']['row'] = urldecode($_SESSION['pop']['row']);
		$_SESSION['pop']['col'] = urldecode($_SESSION['pop']['col']);
		$ret = $model->get_list_pages($_SESSION['pop']['disp_rows']);
		$_SESSION['pop']['rows'] = $ret[0];
		$_SESSION['pop']['page'] = 1;
		$_SESSION['pop']['maxpage'] = $ret[1];
		$_SESSION['pop']['order'] = 'conf_dt';
		$_SESSION['pop']['direction'] = 'ASC';
		break;
	case 'page':		// ページ変更・ソート時
	case 'order':
		$_SESSION['pop'] = array_merge($_SESSION['pop'], $_REQUEST);
		break;
	}


	// 検索結果取得
	$lines = $model->get_list($_SESSION['pop']['disp_rows']);
/*
$time_end = microtime(true);
$time = sprintf("%.2f",$time_end - $time_start);
$smarty->assign('alert', "Did nothing in $time seconds\n");
*/

	// 結果ページ表示
	$smarty->assign("lines",$lines);
	$smarty->assign('search', $_SESSION['pop']);
	$smarty->assign("disp_rows", $dict->get_disp_rows());
	$smarty->assign("offset",($_SESSION['pop']['page'] - 1) * $_SESSION['pop']['disp_rows']);
	//print_r($_SESSION);
	$smarty->display_dialog("list.tpl", '選択リスト表示');


?>

<?php

	function __autoload($class_name) {
	    include_once $class_name . '.php';
	}
	session_start();

	$smarty = new mysmarty();
	$dict 	= new dict_model();

	// user login check
	$com 	= new common();
	$com->user_login_check();
 	
	switch($_REQUEST['mode']){
	case 'reset':
		session_unregister('search');
		break;
	}

	$smarty->assign('system',$dict->get_sys_tp());
	$smarty->assign('diet',$dict->get_diet_tp());
	$smarty->assign('kind',$dict->get_conf_tp());
	$smarty->assign('rpt',$dict->get_rpt_tp());
	$smarty->assign('disp_rows',$dict->get_disp_rows());
	$smarty->assign('search',$_SESSION['search']);

	$smarty->display('search.tpl', '検索条件入力');


?>
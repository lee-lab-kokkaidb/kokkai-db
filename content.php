<?php

	function __autoload($class_name) {
	    include_once $class_name . '.php';
	}

	session_start();

	$smarty = new mysmarty();

	// user login check
	$com = new common();
	$com->user_login_check();
	
	$model	= new content_model();

	// 検索結果取得
	$info	= $model->get_conf_item($_GET['conf_id'],$_GET['conf_item_id']);


	// 取得データ検索文字色換え

	foreach($_SESSION['search']['option'] as $key => $option){
		if($_SESSION['search']['option_value'][$key]=="") continue;
		if($option=="発言内容") $info[0]['content'] = preg_replace($_SESSION['search']['option_value'][$key],"<b>" . $_SESSION['search']['option_value'][$key]."</b>",  $info[0]['content'],-1);
	}


	// 詳細ページ
	$smarty->assign("info",$info[0]);
	$smarty->display_dialog('content.tpl','詳細情報表示');

?>
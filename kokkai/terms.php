<?php

	session_start();

	include_once  'mysmarty.php';
	include_once  'db.php';
	include_once  'user_model.php';
	$smarty = new mysmarty();
	$smarty->display('terms.tpl',"利用者登録規約");
?>
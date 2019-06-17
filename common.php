<?php

	class common {

		function __autoload($class_name) {
		    include_once $class_name . '.php';
		}

		function __construct(){
		}
/*************************************************************************/
/**		説明	ログインしていない場合に、ログイン画面へ移動する 		**/
/**		入力	SESSIONにのユーザーID									**/
/**		出力															**/
/**		下記の関数を使用になる対象サイト：		全サイト				**/
/*************************************************************************/
		function user_login_check(){
			if (!isset($_SESSION['user_id'])){
				header("Location: index.php");
				return;
			}
		}
/*************************************************************************/
/**		説明	管理者ではない場合に、ログイン画面へ移動する 			**/
/**		入力	SESSIONにの権限											**/
/**		出力															**/
/**		下記の関数を使用になる対象サイト：		管理者専用サイト		**/
/*************************************************************************/
		function user_authority_check(){
			if($_SESSION['authority'] != "A"){
				header("Location: index.php");
				return;
			}
		}
	}
?>
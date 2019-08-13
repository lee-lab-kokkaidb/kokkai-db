<?php

	class user_model extends db {
	
		function __autoload($class_name) {
		    include_once $class_name . '.php';
		}
		
		function __construct(){
			parent::__construct();
			$this->db_connect();
		}

/*************************************************************************/
/**		関数名	ユーザーログインチェック関数 (ログインする際利用)		**/
/**		入力	ユーザーＩＤ、パスワード								**/
/**		出力	正常：	該当ユーザーＩＤの								**/
/**						user_name、authority、email						**/
/**						user_id、permission、active						**/
/**				異常：	エラー情報										**/
/*************************************************************************/
		function user_get_check(){
			/* formのPOSTした情報から取得 */
			$user_id = $_REQUEST['user_id'];
			$password = $_REQUEST['password'];

			/* ユーザーＩＤとパスワードの入力しているかのチェック */
			if ($user_id == "") {
				return "ユーザーIDを入力してください。";
			}
			if ($password == "") {
				return "パスワードを入力してください。";
			}
			$password = md5($_REQUEST['password']);
			
			/* データベースから該当ユーザーＩＤに対して、情報を取得 */
			$user_info = $this->db_query_fetch("select user_id,user_name,authority,permission,active,email FROM t_user where user_id = '$user_id' and password = '$password'");

			/* 取得した情報に対して、チェックを行う。異常の場合にエラー情報出力する */
			if ($user_info[0]['authority'] == "") {
				
				return "入力したユーザーIDまたはパスワードが間違っています。";
			}
			
			if ($user_info[0]['permission'] != "Y") {
				
				return "ユーザーIDが許可されていません、管理者にお問い合わせください。";
			}


			if ($user_info[0]['active'] != "Y") {
				
				return "ユーザーIDがアクティブにされていません。許可Mailからアクティブにしてください。";
			}

			/* ユーザーのアクセス時刻をデータベースのログに残す */
			$this->db_query("INSERT INTO t_login_log(user_id) VALUES ('$user_id')");
			/* 正常、該当ユーザーの情報を返す */
			return $user_info[0];
		}
		
/*************************************************************************/
/**		関数名	検索条件&ページの表示条件によりユーザー情報を取得する	**/
/**		入力	ユーザーID、名前、許可状態、アクティブ状態、			**/
/**				一頁で表示するレコード数、ソーティング対象&順番			**/
/**		出力	検索したユーザー情報リスト								**/
/**				ユーザーID、ユーザー名、所属、
/**				Email、許可状態、アクティブ状態、登録日付				**/
/*************************************************************************/
		function user_get_list($disp_rows){
			$query = "select user_id, user_name, company, email, permission, active,date_trunc('day', reg_dt) as reg_day FROM t_user";
			
			/* 検索条件 */
			$query .= " where 1 = 1";
			if ($_SESSION['user']['user_id'] != "")
			{
				$query .= " and user_id like '".$_SESSION['user']['user_id']."%'";
			}
			if ($_SESSION['user']['user_name'] != "")
			{
				$query .= " and user_name like '".$_SESSION['user']['user_name']."%'";
			}
			if ($_SESSION['user']['permission'] != "")
			{
				$query .= " and permission = '".$_SESSION['user']['permission']."'";
			}			
			if ($_SESSION['user']['active'] != "")
			{
				$query .= " and active = '".$_SESSION['user']['active']."'";
			}
			
			/* ソーティング */
			$query .= " ORDER BY {$_SESSION['user']['order']} {$_SESSION['user']['direction']}";
			
			/* ページング */
			$offset = ($_SESSION['user']['page'] - 1) * $disp_rows;
			$query .= " limit $disp_rows offset $offset";
			
			return $this->db_query_fetch($query);
		}
		
/*************************************************************************/
/**		関数名	検索条件&ページの表示条件によりユーザー情報数を取得する	**/
/**		入力	ユーザーID、ユーザー名、許可状態、アクティブ状態、		**/
/**		出力	検索したユーザー情報リスト数							**/
/*************************************************************************/
		function user_get_count(){
			$query = "select count(*) FROM t_user";

			$query .= " where 1 = 1";
			/* 検索条件 */
			if ($_SESSION['user']['user_id'] != "")
			{
				$query .= " and user_id like '".$_SESSION['user']['user_id']."%'";
			}
			if ($_SESSION['user']['user_name'] != "")
			{
				$query .= " and user_name like '".$_SESSION['user']['user_name']."%'";
			}
			if ($_SESSION['user']['permission'] != "")
			{
				$query .= " and permission = '".$_SESSION['user']['permission']."'";
			}			
			if ($_SESSION['user']['active'] != "")
			{
				$query .= " and active = '".$_SESSION['user']['active']."'";
			}
			
			$result = $this->db_query_fetch($query);
			return $result[0]['count'];
		}
		
/*************************************************************************/
/**		関数名	削除関数												**/
/**		入力	削除するユーザーID										**/
/**		出力	データベースに削除処理により、変更されたレコード数		**/
/*************************************************************************/
		function user_delete($id){
			return $this->db_query("delete from t_user where user_id='$id'");
		}
	}
?>

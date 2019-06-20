<?php
	function __autoload($class_name) {
	    include_once $class_name . '.php';
	}

	session_start();
	$smarty = new mysmarty();
	$model	= new stat_model();
	$dict	= new dict_model();
	$list	= new list_model();

	// user login check
	$com = new common();
	$com->user_login_check();

//$time_start = microtime(true);
	// モード別処理
	switch($_REQUEST['mode']){
	case 'search':		// 条件入力から検索時
//		$_REQUEST['rpt'] = check_rpt();											// 検索条件に合わせ初期レポート設定
		$_SESSION['search']=array();											// セッション内容をクリア
	case 'report':		// レポート変更時　検索も含む

		$_SESSION['search'] = array_merge($_SESSION['search'], $_REQUEST);		// セッション内容を更新
		
		switch($_SESSION['search']['rpt']){
		case '00':		// 発言リスト
			$_SESSION['search']['rows'] = $ret[0];
			$_SESSION['search']['page'] = 1;
			$_SESSION['search']['maxpage'] = $ret[1];
			$_SESSION['search']['order'] = 'conf_dt';
			$_SESSION['search']['direction'] = 'ASC';
			$_SESSION['pop']=$_SESSION['search'];
			$ret = $list->get_list_pages($_SESSION['pop']['disp_rows']);
			break;
		case '01':		// 発言者別月別   会議別と共通
		case '02':		// 発言者別年別   会議別と共通
		case '03':		// 発言者別会議別
			$ret = $model->get_stat_talker_pages($_SESSION['search']['disp_rows']);
			$_SESSION['search']['order'] = 'talker_name';
			break;
		case '04':		// DB別月別
		case '05':		// DB別年別 月別と共通
			$ret = $model->get_stat_db_pages($_SESSION['search']['disp_rows']);
			$_SESSION['search']['order'] = 'sys_tp';
			break;
		case '06':		// 会議別月別
		case '07':		// 会議別年別
			$ret =  $model->get_stat_conf_pages($_SESSION['search']['disp_rows']);
			$_SESSION['search']['order'] = 'conf_tp';
			break;
		case '08':		// 政党別月別
		case '09':		// 政党別年別
			$ret = $model->get_stat_party_pages($_SESSION['search']['disp_rows']);
			$_SESSION['search']['order'] = 'parties';
			break;
		}
		$_SESSION['search']['rows'] = $ret[0];
		$_SESSION['search']['maxpage'] = $ret[1];
		break;
	case 'page':		// ページ変更・ソート時
	case 'order':
		$_SESSION['search'] = array_merge($_SESSION['search'], $_REQUEST);
		if($_SESSION['search']['rpt']=='00'){
			$_SESSION['pop']=$_SESSION['search'];
		}
		break;
	}

	$template = 'stat_date_report.tpl';
	// 検索結果取得
	switch($_SESSION['search']['rpt']){
	case '00':			// 発言リスト
		$lines = $list->get_list($_SESSION['pop']['disp_rows']);
		$template = 'list.tpl';
		$smarty->assign("offset",($_SESSION['pop']['page'] - 1) * $_SESSION['pop']['disp_rows']);
		break;
	case '01':			// 発言別月別
		$template = 'stat_talker_month.tpl';
		$lines = $model->get_stat_talker_month($_SESSION['search']['disp_rows']);
		$smarty->assign("label", make_month($lines));							// 表示ラベルの生成
		if($lines!=''){
			foreach($lines as $key => $line){
				$tmp = explode(",",preg_replace("^{|}$","", $key,-1));
				if(count($tmp)!=2) continue;
				$lines[$key]['parties'] = $tmp[0];
				$lines[$key]['name'] = $tmp[1];
			}
		}
		break;
	case '02':			// 発言別年別
		$template = 'stat_talker_date.tpl';
		$lines = $model->get_stat_talker_year($_SESSION['search']['disp_rows']);
		$smarty->assign("label", make_year($lines));							// 表示ラベルの生成
		if($lines!=''){
			foreach($lines as $key => $line){
				$tmp = explode(",",preg_replace("^{|}$","", $key,-1));
				if(count($tmp)!=2) continue;
				$lines[$key]['parties'] = $tmp[0];
				$lines[$key]['name'] = $tmp[1];
			}
		}
		break;
	case '03':			// 発言者別会議別
		$lines = $model->get_stat_talker_conf($_SESSION['search']['disp_rows']);
		$smarty->assign("col",$dict->get_col_conf());
		$template = 'stat_talker_conf.tpl';
		break;
	case '04':			// DB別月別
		$template = 'stat_date_month.tpl';
		$lines = $model->get_stat_db_month($_SESSION['search']['disp_rows']);
		$smarty->assign("label", make_month($lines));							// 表示ラベルの生成
		break;
	case '05':			// DB別年別
		$lines = $model->get_stat_db_year($_SESSION['search']['disp_rows']);
		$smarty->assign("label", make_year($lines));							// 表示ラベルの生成
		break;
	case '06':			// 会議別月別
		$template = 'stat_date_month.tpl';
		$lines = $model->get_stat_conf_month($_SESSION['search']['disp_rows']);
		$smarty->assign("label", make_month($lines));							// 表示ラベルの生成
		break;
	case '07':			// 会議別年別
		$lines = $model->get_stat_conf_year($_SESSION['search']['disp_rows']);
		$smarty->assign("label", make_year($lines));							// 表示ラベルの生成
		break;
	case '08':			// 政党別月別
		$template = 'stat_date_month.tpl';
		$lines = $model->get_stat_party_month($_SESSION['search']['disp_rows']);
		$smarty->assign("label", make_month($lines));							// 表示ラベルの生成
		break;
	case '09':			// 政党別年別
		$lines = $model->get_stat_party_year($_SESSION['search']['disp_rows']);
		$smarty->assign("label", make_year($lines));							// 表示ラベルの生成
		break;
	}

/*
$time_end = microtime(true);
$time = sprintf("%.2f",$time_end - $time_start);
$smarty->assign('alert', "Did nothing in $time seconds\n{$model->lasterror}");
*/

	// 結果ページ表示
	$smarty->assign("lines",$lines);
	$smarty->assign('search', $_SESSION['search']);
	$smarty->assign('rpt', $dict->get_rpt_tp(check_talker()));
	$smarty->assign("disp_rows", $dict->get_disp_rows());
	$smarty->display($template, '検索結果表示');

	///
	///		private function
	///

	function check_rpt(){
	
		if($_REQUEST['rpt']=='list') return '00';

		$talker = check_talker();
		$date 	= 0;
		$rpt = array(array( '01',			//発言者無し　3年以内 発別月別
							'02'),			//　　　　　　3年以上 発別年別
		             array( '04',			//発言者有り　3年以内 DB別月別
					 		'05'));			//　　　　　　3年以上 DB別年別

		if($_REQUEST['time']==0 && $_REQUEST['period']==0) $date =1;

		if($_REQUEST['time']==1){
			$tmp = $_REQUEST['date_s'];
			$tmp['Date_Year'] += 3;
			if(strtotime(implode("/", $tmp)) >= strtotime(implode("/", $_REQUEST['date_e']))) $date = 1;
		}
		return $rpt[$talker][$date];
	}

	function make_month(&$lines){
		if($lines == '') return array();

		$max = $lines[0]['conf_dt'];
		$min = $lines[0]['conf_dt'];
		$tmp= array();
		foreach($lines as $line){
			if($max < $line['conf_dt']) $max = $line['conf_dt'];
			if($min > $line['conf_dt']) $min = $line['conf_dt'];
			$tmp[$line['name']][date("Y/m", strtotime($line['conf_dt']))] = $line['cnt'];
		}
		foreach($tmp as $key => $line){
			$tmp[$key]['sum'] = array_sum($line);
		}
		$lines = $tmp;
		
		if($_SESSION['search']['time']==1){
			$min = implode("/", $_SESSION['search']['date_s']);
			$max = implode("/", $_SESSION['search']['date_e']);
		}elseif($_SESSION['search']['period']!=0){
			$max = date("Y/m/d", strtotime('2011/12/31'));
			$min = (date("Y",strtotime('2012/1/1')) - $_SESSION['search']['period']).date("/m/d",strtotime('2012/1/1'));
		}

		$lt_max = localtime(strtotime($max), TRUE);
		$lt_min = localtime(strtotime($min), TRUE);
		$cnt_month = (($lt_max['tm_year'] - $lt_min['tm_year']) * 12) + ($lt_max['tm_mon'] - $lt_min['tm_mon'] + 1);
		for($i=0;$i<$cnt_month;$i++){
			$year[] = date("Y", mktime(0, 0, 0, $lt_min['tm_mon'] + 1 + $i, 1, 1900 + $lt_min['tm_year']));
			$label['month'][] = date("Y/m", mktime(0, 0, 0, $lt_min['tm_mon'] + 1 + $i, 1, 1900 + $lt_min['tm_year']));
		}
		$label['year'] = array_count_values($year);
		return $label;

	}

	function make_year(&$lines){
		if($lines == '') return array();										// データがないときはリターン

		// 全期間は暫定であるデータ分
		// データを表示用ハッシュに変換
		$max = $lines[0]['conf_dt'];
		$min = $lines[0]['conf_dt'];
		$tmp= array();
		foreach($lines as $line){
			if($max < $line['conf_dt']) $max = $line['conf_dt'];
			if($min > $line['conf_dt']) $min = $line['conf_dt'];
			$tmp[$line['name']][date("Y", strtotime($line['conf_dt']))] = $line['cnt'];
		}
		// 合計の計算
		foreach($tmp as $key => $line){
			$tmp[$key]['sum'] = array_sum($line);
		}

		$lines = $tmp;
		if($_SESSION['search']['time']==1){
			$min = $_SESSION['search']['date_s']['Date_Year'];
			$max = $_SESSION['search']['date_e']['Date_Year'];
		}elseif($_SESSION['search']['period']!=0){
			$max = date("Y", strtotime('2011/12/31'));
			$min = date("Y", strtotime('2012/01/01')) - $_SESSION['search']['period'];
		}

		// 表示用ヘッダーの作成
		$cnt_year = $max - $min + $i;
		for($i=0;$i<$cnt_year;$i++){
			$label[] = $min + $i;
		}
/*	データ存在分だけバージョン

		$max = $lines[0]['conf_dt'];
		$min = $lines[0]['conf_dt'];
		$tmp= array();
		foreach($lines as $line){
			if($max < $line['conf_dt']) $max = $line['conf_dt'];
			if($min > $line['conf_dt']) $min = $line['conf_dt'];
			$tmp[$line['name']][date("Y", strtotime($line['conf_dt']))] = $line['cnt'];
		}
		foreach($tmp as $key => $line){
			$tmp[$key]['sum'] = array_sum($line);
		}

		$lines = $tmp;
		$cnt_year = $max - $min + 1;
		for($i=0;$i<$cnt_year;$i++){
			$label[] = $min + $i;
		}
*/
		return $label;

	}

	function check_talker(){
		if($_REQUEST['option'] != ''){
			foreach($_REQUEST['option'] as $key => $option){
				if($option == '発言者' and $_REQUEST['option_value'][$key]!="") return 1;
			}
		}else{		
			if($_SESSION['search']['option'] != ''){
				foreach($_SESSION['search']['option'] as $key => $option){
					if($option == '発言者' and $_SESSION['search']['option_value'][$key]!="") return 1;
				}
			}
		}
		return 0;
	}

?>
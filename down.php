<?php

	function __autoload($class_name) {
	    include_once $class_name . '.php';
	}

	session_start();
	$smarty = new mysmarty();
	$model	= new stat_model();
	$dict	= new dict_model();
	$list	= new list_model();
	$rows = $_SESSION[search][rows];
//	if($rows>65530){
//		$rows = 65530;
//	}
	$template = 'stat_date_report.tpl';
	// 検索結果取得
	
	if( ($_REQUEST['d_mode']) == 'list'){
		$rows = $_SESSION[pop][rows];
		$lines = $list->get_list_down($rows);
		$template = 'list.tpl';
		$smarty->assign("offset",0);
		$smarty->assign("down", "YES");
	}else{
		switch($_SESSION['search']['rpt']){
		case '00':			// 発言リスト
			$lines = $list->get_list_down($rows);
			//$template = 'list_down.tpl';
			$template = 'list.tpl';
			$smarty->assign("offset",0);
			$smarty->assign("down", "YES");
			break;
		case '01':			// 発言別月別
			$template = 'stat_talker_month.tpl';
			$lines = $model->get_stat_talker_month($rows);
			$smarty->assign("label", make_month($lines));							// 表示ラベルの生成
			if($lines!=''){
				foreach($lines as $key => $line){
					$tmp = explode(",",ereg_replace("^{|}$","", $key));
					if(count($tmp)!=2) continue;
					$lines[$key]['parties'] = $tmp[0];
					$lines[$key]['name'] = $tmp[1];
				}
			}
			break;
		case '02':			// 発言別年別
			$template = 'stat_talker_date.tpl';
			$lines = $model->get_stat_talker_year($rows);
			$smarty->assign("label", make_year($lines));							// 表示ラベルの生成
			if($lines!=''){
				foreach($lines as $key => $line){
					$tmp = explode(",",ereg_replace("^{|}$","", $key));
					if(count($tmp)!=2) continue;
					$lines[$key]['parties'] = $tmp[0];
					$lines[$key]['name'] = $tmp[1];
				}
			}
			break;
		case '03':			// 発言者別会議別
			$lines = $model->get_stat_talker_conf($rows);
			$smarty->assign("col",$dict->get_col_conf());
			$template = 'stat_talker_conf.tpl';
			break;
		case '04':			// DB別月別
			$template = 'stat_date_month.tpl';
			$lines = $model->get_stat_db_month($rows);
			$smarty->assign("label", make_month($lines));							// 表示ラベルの生成
			break;
		case '05':			// DB別年別
			$lines = $model->get_stat_db_year($rows);
			$smarty->assign("label", make_year($lines));							// 表示ラベルの生成
			break;
		case '06':			// 会議別月別
			$template = 'stat_date_month.tpl';
			$lines = $model->get_stat_conf_month($rows);
			$smarty->assign("label", make_month($lines));							// 表示ラベルの生成
			break;
		case '07':			// 会議別年別
			$lines = $model->get_stat_conf_year($rows);
			$smarty->assign("label", make_year($lines));							// 表示ラベルの生成
			break;
		case '08':			// 政党別月別
			$template = 'stat_date_month.tpl';
			$lines = $model->get_stat_party_month($rows);
			$smarty->assign("label", make_month($lines));							// 表示ラベルの生成
			break;
		case '09':			// 政党別年別
			$lines = $model->get_stat_party_year($rows);
			$smarty->assign("label", make_year($lines));							// 表示ラベルの生成
			break;
		}
	}

	$smarty->assign("lines",$lines);
	$smarty->assign('search', $_SESSION['search']);
	$smarty->assign("disp_rows", $rows);
	$src = $smarty->fetch($template);

	$pos1 = stripos($src, "<table");
	$pos2 = stripos($src, "</table");
	$src = substr($src, $pos1, ($pos2-$pos1+8));
	
	$src = ereg_replace("<a[^>]*>|<\/a>|style=\"[^\"]*\"", "", $src);
//	
	header("Cache-Control: public");
	header("Pragma: public");
	header('Content-type: application/xls\n\n');
	header('Content-Disposition: attachment; filename="download.xls"');
	ob_clean();
    flush();
	echo "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" /></head><body>{$src}</body></html>";
	///
	///		private function
	///

	
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
			$max = date("Y/m/d", strtotime('2008/12/31'));
			$min = (date("Y",strtotime('2009/1/1')) - $_SESSION['search']['period']).date("/m/d",strtotime('2009/1/1'));
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
			$max = date("Y", strtotime('2008/12/31'));
			$min = date("Y", strtotime('2009/01/01')) - $_SESSION['search']['period'];
		}
		// 表示用ヘッダーの作成
		$cnt_year = $max - $min + 1;
		for($i=0;$i<$cnt_year;$i++){
			$label[] = $min + $i;
		}
		return $label;
		
	}

?>
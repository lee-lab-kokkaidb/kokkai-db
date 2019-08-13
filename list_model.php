<?php
	class list_model extends db {
		function __autoload($class_name) {
		    include_once $class_name . '.php';
		}
		function __construct(){
			parent::__construct();
			$this->db_connect();
		}
		private function make_where($replace_where=true){

			if($_SESSION['pop']['time']==0 && $_SESSION['pop']['period']!=0){
				$where .= " AND a.conf_dt BETWEEN  to_date('20081231','YYYYMMDD')  + interval '-{$_SESSION['pop']['period']} year' and to_date('20081231','YYYYMMDD') ";
				//$where .= " AND b.conf_dt BETWEEN  to_date('20081231','YYYYMMDD')  + interval '-{$_SESSION['pop']['period']} year' and to_date('20081231','YYYYMMDD') ";
				$flg_conf=true;
				//$flg_item=true;
			}

			if($_SESSION['pop']['time']==1){
				if($_SESSION['pop']['date_s']['Date_Year']!=''){
					$tmp_s = strtotime(implode("/", $_SESSION['pop']['date_s']));
					$tmp_e = strtotime(implode("/", $_SESSION['pop']['date_e']));
					if($tmp_s>$tmp_e){
						$tmp = $tmp_s; $tmp_s = $tmp_e; $tmp_e = $tmp;
					}
					$date_s = date("Ymd",$tmp_s);
					$date_e = date("Ymd",$tmp_e);
					if($_SESSION['pop']['date_e']!=''){
						$where .= " AND a.conf_dt BETWEEN '$date_s' and '$date_e'";
						//$where .= " AND b.conf_dt BETWEEN '$date_s' and '$date_e'";
					}else{
						$where .= " AND a.conf_dt = '$date_s'";
					}
					$flg_conf=true;
					//$flg_item=true;
				}
			}

			// all 判定
			$flg_all = false;
			$flg_sys = false;
			$flg_diet = false;

			if(count($_SESSION['pop']['select_all'])>0){
				foreach($_SESSION['pop']['select_all'] as $all){
					switch($all){
					case "0";
						$flg_all = true;
						break;
					case "1";
						$flg_diet = true;
						break;
					case "2";
						$flg_sys = true;
					}
				}
			}

			if(!$flg_all){

				if(count($_SESSION['pop']['diet_tp'])>0){
					$diet = $_SESSION['pop']['diet_tp'];
					if(count($_SESSION['pop']['sys_tp'])>0 or $flg_sys){
						array_push($diet, '');
					}
					$where .= " AND a.diet_tp IN ('".implode("','", $diet)."')";
				}elseif($flg_diet and count($_SESSION['pop']['sys_tp'])==0 and !$flg_sys){
					$where .= " AND a.diet_tp != ''";
				}

				if(count($_SESSION['pop']['sys_tp'])>0){
					$sys = $_SESSION['pop']['sys_tp'];
					if(count($_SESSION['pop']['diet_tp'])>0 or $flg_diet){
						array_push($sys, '01');
					}
					$where .= " AND a.sys_tp IN ('" . implode("','", $sys) . "')";
				}elseif($flg_sys and count($_SESSION['pop']['diet_tp'])==0 and !$flg_diet){
					$where .= " AND a.sys_tp != '01'";
				}
				$flg_conf=true;
			}
			
			if(isset($_SESSION['pop']['conf_tp'])){
				$where .= " AND a.conf_tp IN ('".implode("','", $_SESSION['pop']['conf_tp'])."')";
				$flg_conf=true;
			}			

			foreach($_SESSION['pop']['option'] as $key => $option){
				if($_SESSION['pop']['option_value'][$key]=="") continue;

				//1=>'会議名',2=>'会議情報',3=>'発言内容',4=>'全て'
				//発言内容、発言者、政党、肩書き、会議情報、会議名
				switch($option){
				case '発言内容';
					$where2 .= " {$_SESSION['pop']['andor'][$key]}  content like '%{$_SESSION['pop']['option_value'][$key]}%'";
					//$where2 .= " {$_SESSION['pop']['andor'][$key]}  (b.conf_id, b.conf_item_id) IN (select conf_id, conf_item_id from t_conf_item where content like '%{$_SESSION['pop']['option_value'][$key]}%')";
					//$where2 .= " {$_SESSION['pop']['andor'][$key]}( b.content like '%{$_SESSION['pop']['option_value'][$key]}%'";
					//$where2 .= " and to_tsvector('japanese', b.content) @@ to_tsquery('japanese','{$_SESSION['pop']['option_value'][$key]}'))";
					$flg['item']=true;
					break;
				case '会議名';
					$where2 .= " {$_SESSION['pop']['andor'][$key]} a.conf_title like '%{$_SESSION['pop']['option_value'][$key]}%'";

					//$where2 .= " {$_SESSION['pop']['andor'][$key]} (a.conf_title like '%{$_SESSION['pop']['option_value'][$key]}%'";
					//$where2 .= " and to_tsvector('japanese', a.conf_title) @@ to_tsquery('japanese','{$_SESSION['pop']['option_value'][$key]}'))";
					$flg['conf']=true;
					break;
				case '会議情報';
					$where2 .= " {$_SESSION['pop']['andor'][$key]} a.conf_info like '%{$_SESSION['pop']['option_value'][$key]}%'";
					//$where2 .= " {$_SESSION['pop']['andor'][$key]} (a.conf_info like '%{$_SESSION['pop']['option_value'][$key]}%'";
					//$where2 .= " and to_tsvector('japanese', a.conf_info) @@ to_tsquery('japanese','{$_SESSION['pop']['option_value'][$key]}'))";
					$flg['conf']=true;
					break;
				case '政党';
					$where2 .= " {$_SESSION['pop']['andor'][$key]} parties like '%{$_SESSION['pop']['option_value'][$key]}%'";
					//$where2 .= " {$_SESSION['pop']['andor'][$key]} b.talker_id in (select talker_id from t_talker where parties like '%{$_SESSION['pop']['option_value'][$key]}%')";
					//$where2 .= " {$_SESSION['pop']['andor'][$key]} b.talker_id in (select talker_id from t_talker where to_tsvector('japanese',parties) @@ to_tsquery('japanese','{$_SESSION['pop']['option_value'][$key]}'))";
					//$flg['item']=true;
					$flg['talker']=true;
					break;
				case '肩書き';
					$where2 .= " {$_SESSION['pop']['andor'][$key]}  position like '%{$_SESSION['pop']['option_value'][$key]}%'";
					//$where2 .= " {$_SESSION['pop']['andor'][$key]} b.talker_id in (select talker_id from t_talker where position like '%{$_SESSION['pop']['option_value'][$key]}%')";
					//$where2 .= " {$_SESSION['pop']['andor'][$key]} b.talker_id in (select talker_id from t_talker where to_tsvector('japanese',position) @@ to_tsquery('japanese','{$_SESSION['pop']['option_value'][$key]}'))";
					//$flg['item']=true;
					$flg['talker']=true;
					break;
				case '発言者';
					$where2 .= " {$_SESSION['pop']['andor'][$key]} (talker_name like'%{$_SESSION['pop']['option_value'][$key]}%' or talker_jname like'%{$_SESSION['pop']['option_value'][$key]}%')";
					//$where2 .= " {$_SESSION['pop']['andor'][$key]} b.talker_id in (select talker_id from t_talker where to_tsvector('japanese', talker_name||talker_jname) @@ to_tsquery('japanese','{$_SESSION['pop']['option_value'][$key]}'))";
					//$where2 .= " {$_SESSION['pop']['andor'][$key]} b.talker_id in (select talker_id from t_talker where (talker_name like'%{$_SESSION['pop']['option_value'][$key]}%' or talker_jname like'%{$_SESSION['pop']['option_value'][$key]}%'))";
					//$flg['item']=true;
					$flg['talker']=true;
					break;
				}
			}
			
			if(isset($where2)){
				$where2 = preg_replace("/^ OR/", " AND", $where2,-1);
				$where2 = preg_replace("/^ AND/", " AND(", $where2,-1) . ")" ;
			}
			
			if(isset($where) && $replace_where)
				$where = preg_replace("/^ AND/", " WHERE", $where,-1);
			// 集計内選択の反映
			switch($_SESSION['pop']['rpt']){
			case '01':		// 発言者別月別   会議別と共通
			case '02':		// 発言者別年別   会議別と共通
			case '03':		// 発言者別会議別
				$_SESSION['pop']['col'] = preg_replace('/sum/', '//', $_SESSION['pop']['col'],-1);
				$tmp = explode(",",preg_replace("/^{|}$/","", $_SESSION['pop']['row'],-1));
				if(count($tmp)==2){
					$tmp[0] = preg_replace("/政党無し/","",$tmp[0],-1);
					$where .= " and c.parties = '{$tmp[0]}' and c.talker_name = '{$tmp[1]}'";
				}else{
					$where .= " and c.talker_name = '{$_SESSION['pop']['row']}'";
				}
				break;
			case '04':		// DB別月別
			case '05':		// DB別年別 月別と共通
				$where .= " and (a.diet_tp = (SELECT dict_code FROM t_dict WHERE dict_tp = 'DIET_TP' AND dict_name = '{$_SESSION['pop']['row']}')";
				$where .= " or a.sys_tp = (SELECT dict_code FROM t_dict WHERE dict_tp = 'SYS_TP' AND dict_name = '{$_SESSION['pop']['row']}'))";
				break;
			case '06':		// 会議別月別
			case '07':		// 会議別年別
				$where .= " and a.conf_tp = (SELECT dict_code FROM t_dict WHERE dict_tp = 'CONF_TP' AND dict_name = '{$_SESSION['pop']['row']}')";
				break;
			case '08':		// 政党別月別
			case '09':		// 政党別年別
				$_SESSION['pop']['row'] = preg_replace('政党無し', '', $_SESSION['pop']['row'],-1);
				$where .= " and c.parties = '{$_SESSION['pop']['row']}'";
				break;
			}

			if($_SESSION['pop']['col'] != 'all'){
				switch($_SESSION['pop']['rpt']){
				case '01':		// 発言者別月別   会議別と共通
				case '04':		// DB別月別
				case '06':		// 会議別月別
				case '08':		// 政党別月別
					$where .= " and date_trunc('month', b.conf_dt) = '{$_SESSION['pop']['col']}/01 00:00:00'";
					break;
				case '02':		// 発言者別年別   会議別と共通
				case '05':		// DB別年別 月別と共通
				case '07':		// 会議別年別
				case '09':		// 政党別年別
					$where .= " and date_trunc('year', b.conf_dt) = '{$_SESSION['pop']['col']}/01/01 00:00:00'";
					break;
				case '03':		// 発言者別会議別
					$where .= " and conf_tp = '{$_SESSION['pop']['col']}'";
					break;
				}
			}
			$ret = array(array('conf'=>$flg_conf,'item'=>$flg_item), $where, $where2);
			return $ret;
		}

		// 会議情報検索結果取得
		function get_list($disp_rows){
			$where = $this->make_where(true);
			$query = "SELECT b.conf_id, b.conf_item_id,
					c.talker_name, c.parties, c.position, c.roles,
					a.conf_dt, 
					(SELECT dict_name FROM t_dict WHERE dict_tp = 'SYS_TP' AND dict_code = a.sys_tp) as sys_tp,
					(SELECT dict_name FROM t_dict WHERE dict_tp = 'DIET_TP' AND dict_code = a.diet_tp) as diet_tp, 
					(SELECT dict_name FROM t_dict WHERE dict_tp = 'CONF_TP' AND dict_code = a.conf_tp) as conf_tp, 
					a.conf_title,
			 		a.conf_no,
					a.conf_seq, 
					a.item_cnt,
					a.conf_len,
					b.cont_len,
					CASE WHEN char_length(b.content) > 1200 THEN
						substr(b.content,1,1200) || '…'
					ELSE
						b.content
					END  as content
					FROM t_conf as a
					inner join t_conf_item as b on a.conf_id=b.conf_id and a.conf_dt = b.conf_dt
					inner join t_talker as c on b.talker_id=c.talker_id and a.conf_id = c.conf_id
					";
			$query .= $where[1].$where[2];
			$query .= " ORDER BY {$_SESSION['pop']['order']} {$_SESSION['pop']['direction']}, a.conf_no, a.conf_seq, b.conf_item_id ";
			$offset =  ($_SESSION['pop']['page'] - 1) * $disp_rows;
			$query .= " LIMIT $disp_rows OFFSET $offset";

 			return $this->db_query_fetch($query);
		}
		
		// 会議情報検索結果取得(ダウンロードために)
		function get_list_down($disp_rows){
			$where = $this->make_where(true);
			$query = "SELECT b.conf_id, b.conf_item_id,
					c.talker_name, c.parties, c.position, c.roles,
					a.conf_dt, 
					(SELECT dict_name FROM t_dict WHERE dict_tp = 'SYS_TP' AND dict_code = a.sys_tp) as sys_tp,
					(SELECT dict_name FROM t_dict WHERE dict_tp = 'DIET_TP' AND dict_code = a.diet_tp) as diet_tp, 
					(SELECT dict_name FROM t_dict WHERE dict_tp = 'CONF_TP' AND dict_code = a.conf_tp) as conf_tp, 
					a.conf_title,
			 		a.conf_no,
					a.conf_seq, 
					a.item_cnt,
					a.conf_len,
					b.cont_len,
					b.content
					FROM t_conf as a
					inner join t_conf_item as b on a.conf_id=b.conf_id and a.conf_dt = b.conf_dt
					inner join t_talker as c on b.talker_id=c.talker_id and a.conf_id = c.conf_id
					";
			$query .= $where[1].$where[2];
			$query .= " ORDER BY {$_SESSION['pop']['order']} {$_SESSION['pop']['direction']}, a.conf_no, a.conf_seq, b.conf_item_id ";
			$offset =  ($_SESSION['pop']['page'] - 1) * $disp_rows;
			$query .= " LIMIT $disp_rows OFFSET $offset";

 			return $this->db_query_fetch($query);
		}
		

		// 会議情報検索結果全体ページ数取得
		function get_list_pages($disp_rows){
			$where = $this->make_where(true);
			$query = "SELECT count(*) as cnt FROM t_conf as a
					inner join t_conf_item as b on a.conf_id=b.conf_id and a.conf_dt = b.conf_dt
					inner join t_talker as c on b.talker_id=c.talker_id and a.conf_id = c.conf_id
					";
			$query .= $where[1].$where[2];
			$line = $this->db_query_fetch($query);
			return array($line[0]['cnt'], ceil($line[0]['cnt'] / $disp_rows));
		}
	
		function __destruct() {
			//$this->db_close();
			//parent::__destruct();
		}
	}
?>

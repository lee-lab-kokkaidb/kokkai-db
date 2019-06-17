<?php

	class dict_model extends db {
	
		function __autoload($class_name) {
		    include_once $class_name . '.php';
		}
		
		function __construct(){
			parent::__construct();
			$this->db_connect();
		}

		function makearray($liens){
			foreach($liens as $line){
				$out[$line['dict_code']] = $line['dict_name'];
			}
			return $out;
		}
		
		function get_sys_tp(){
			$query = "SELECT dict_code, dict_name FROM t_dict WHERE dict_tp = 'SYS_TP' and dict_name != '国会' ORDER BY dict_sort ";
			$lines = $this->makearray($this->db_query_fetch($query));
			foreach($lines as $key => $line){
				$line = str_pad($line, 9, '　');
				switch($line){
				case '国会　':
				case '福島　':
				case '神奈川':
				case '愛知　':
				case '和歌山':
				case '高知　':
					$line .= '<br>';
				}
				$lines[$key] = $line;
			}
			return $lines;
		}

		function get_sys_tp2(){
			$query = "SELECT dict_code, dict_name FROM t_dict WHERE dict_tp = 'SYS_TP' and dict_name != '国会' ORDER BY dict_sort ";
			$lines = $this->makearray($this->db_query_fetch($query));
			foreach($lines as $key => $line){
				$lines[$key] = $line."<br>";
			}
			return $lines;
		}

		function get_conf_tp(){
			$query = "SELECT dict_code, dict_name FROM t_dict WHERE dict_tp = 'CONF_TP' ORDER BY dict_sort ";
			return $this->makearray($this->db_query_fetch($query));
		}
		
		function get_diet_tp(){
			$query = "SELECT dict_code, dict_name FROM t_dict WHERE dict_tp = 'DIET_TP' ORDER BY dict_sort ";
			return $this->makearray($this->db_query_fetch($query));
		}

		function get_rpt_tp($talker=false){
			if($talker) $tmp = " not";
//			$query = "SELECT dict_code, dict_name FROM t_dict WHERE dict_tp = 'RPT_TP' and $tmp (dict_name like '発言者%' or dict_name like '政党%')  ORDER BY dict_sort";
			$query = "SELECT dict_code, dict_name FROM t_dict WHERE dict_tp = 'RPT_TP' ORDER BY dict_sort";
			return array_merge(array("00"=>"リスト"), $this->makearray($this->db_query_fetch($query)));
		}
		
		function get_col_conf(){
			return array(
							'parties'		=>'政党',
							'talker_name'	=>'発言者名',
							'sum01'			=>'本会議',
							'sum02'			=>'委員会',
							'sum03'			=>'定例会',
							'sum04'			=>'臨時会',
							'sum05'			=>'その他',
							'sumall'		=>'合計'
						);
		}
		function get_disp_rows(){
			return array(20=>20, 50=>50, 100=>100, 200=>200, 500=>500);
		}

		function __destruct() {
			//$this->db_close();
			//parent::__destruct();
		}
		
	
	}

?>

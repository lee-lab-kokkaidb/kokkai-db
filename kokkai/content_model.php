<?php

	class content_model extends db {
	
		function __autoload($class_name) {
		    include_once $class_name . '.php';
		}
		
		function __construct(){
			parent::__construct();
			$this->db_connect();
		}

		// 会議情報取得
		function get_conf_item($id, $item_id){

			$query = "SELECT c.talker_name,
					(SELECT dict_name FROM t_dict WHERE dict_tp = 'SYS_TP' AND dict_code = a.sys_tp) as sys_tp,
					(SELECT dict_name FROM t_dict WHERE dict_tp = 'DIET_TP' AND dict_code = a.diet_tp) as diet_tp, 
					(SELECT dict_name FROM t_dict WHERE dict_tp = 'CONF_TP' AND dict_code = a.conf_tp) as conf_tp, 
					a.conf_title,
					a.conf_dt, 
					b.content
					FROM t_conf as a
					inner join t_conf_item as b on a.conf_id=b.conf_id
					inner join t_talker as c on b.talker_id=c.talker_id
					where a.conf_id = $id and b.conf_item_id = $item_id";
					
			return $this->db_query_fetch($query);
		}


		function __destruct() {
			//$this->db_close();
			//parent::__destruct();
		}
	
	}


?>
<?php
	
	class db {

		private $dbconn;
		private $member = array();
		
	    public function __set($name, $value) {
	        $this->member[$name] = $value;
	    }
	
	    public function __get($name) {
	        if (array_key_exists($name, $this->member)) {
	            return $this->member[$name];
	        }

			$trace = debug_backtrace();
			trigger_error( 'Undefined property via __get(): ' . $name .' in '
							 . $trace[0]['file'] .' on line ' . $trace[0]['line'], E_USER_NOTICE);
	        return null;
	    }
	
		public function __isset($name) {
			return isset($this->member[$name]);
		}
		public function __unset($name) {
			unset($this->member[$name]);
		}

		function __construct(){
			$this->member['db_ip'] = '127.0.0.1';
			$this->member['db_port'] = '5432';
			$this->member['db_name'] = 'hongchun_kas';
			$this->member['db_user'] = 'hongchun_kas';
			$this->member['db_pass'] = '1234';
			$this->member['lasterror'] = null;
			$this->member['count_fetch'] = null;
			$this->member['count_all'] = null;
			$this->member['max_fetch_rows'] = 20;
		}

		// 接続し、データベースを選択する
		function db_connect(){
			$this->dbconn = pg_connect("host={$this->member['db_ip']} port={$this->member['db_port']} dbname={$this->member['db_name']} user={$this->member['db_user']} password={$this->member['db_pass']}")
			//$this->dbconn = pg_connect("host=localhost port=5432 dbname=kas user=kas password=1234")
			or $this->lasterror = pg_last_error();
			
		}

		// 接続をクローズする
		function db_close(){
			pg_close($this->dbconn);
		}
	
		// SQL クエリを実行する(結果セット有り)
		function db_query_fetch($sql){
				echo "SQL DEBUG:"."$sql"."<br><br>";
//$time_start = microtime(true);
			$result = pg_query($this->dbconn, (string)$sql) or $this->lasterror = pg_last_error();
			if (!$result) {
//				echo "$sql";
				return null;
			}
//$time_query = microtime(true);

			// 結果を配列に格納
			$lines = pg_fetch_all($result);

/*
$time_fetch = microtime(true);
if(($time_fetch - $time_start) > 4){
	$time = sprintf("total:%.2f query:%.2f fetch:%.2f",$time_fetch - $time_start,$time_query - $time_start,$time_fetch - $time_query);
	$hnd = fopen("sql_log.txt", "a");
	fwrite($hnd, "**************************************************************************************************\n$sql\n--------------------------------------------------------------------------------------------\n$time\n");
	fclose($hnd);
//	echo "$sql<br>";
	$this->lasterror = "<br>$sql\n<br>";
}*/

			$this->member['count_fetch'] = pg_num_rows($result);
			// 結果セットを開放する
			pg_free_result($result);

			return $lines;
		}

		// SQL クエリを実行する(結果セット無し)
		function db_query($sql){
			$result = pg_query($this->dbconn, $sql) or $this->lasterror = pg_last_error();
			return pg_affected_rows($result);
		}


	}

?>
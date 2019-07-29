<?php
	require "db.php";
	class stat_model extends db {
		private $query = "SET statement_timeout to 0";
		function __autoload($class_name) {
		    include_once $class_name . '.php';
		}

		function __construct(){
			parent::__construct();
			$this->db_connect();
		}

		function get_stat_talker_conf($disp_rows, $down=false){

			$offset =  ($_SESSION['search']['page'] - 1) * $disp_rows;
			$where = $this->make_where(false);

			$query .= "select 
							CASE WHEN parties='' THEN '政党無し' ELSE parties END as parties,
							talker_name,
							sum(cnt1) as sum01,
							sum(cnt2) as sum02,
							sum(cnt3) as sum03,
							sum(cnt4) as sum04,
							sum(cnt5) as sum05,
							coalesce(sum(cnt1), 0) + coalesce(sum(cnt2), 0) + coalesce(sum(cnt3), 0) + coalesce(sum(cnt4), 0) + coalesce(sum(cnt5), 0) as sumall
						from 
						(select  parties,
							talker_name,
							(select count(conf_item_id) from t_conf_item b, t_conf a 
								where b.conf_id = a.conf_id 
								and a.conf_id = c.conf_id
								and b.talker_id = c.talker_id 
								and conf_tp='01' " . $where[1] . $where[2] . "
								group by talker_id) as cnt1,
							(select count(conf_item_id) from t_conf_item b, t_conf a 
								where b.conf_id = a.conf_id 
								and a.conf_id = c.conf_id
								and b.talker_id = c.talker_id 
								and conf_tp='02' " . $where[1] . $where[2] . "
								group by talker_id) as cnt2,
							(select count(conf_item_id) from t_conf_item b, t_conf a 
								where b.conf_id = a.conf_id 
								and a.conf_id = c.conf_id
								and b.talker_id = c.talker_id 
								and conf_tp='03' " . $where[1] . $where[2] . "
								group by talker_id) as cnt3,
							(select count(conf_item_id) from t_conf_item b, t_conf a 
								where b.conf_id = a.conf_id 
								and a.conf_id = c.conf_id
								and b.talker_id = c.talker_id 
								and conf_tp='04' " . $where[1] . $where[2] . "
								group by talker_id) as cnt4,
							(select count(conf_item_id) from t_conf_item b, t_conf a 
								where b.conf_id = a.conf_id 
								and a.conf_id = c.conf_id
								and b.talker_id = c.talker_id 
								and conf_tp='05' " . $where[1] . $where[2] . "
								group by talker_id) as cnt5
						from  ( select * from t_talker 
									where (parties, talker_name) in 
													(select parties, talker_name
													from t_talker
													where 1=1";
			if($where[0]['talker']){
				$query.= "								and talker_id in (select e.talker_id from t_conf as a\n";
				$query.= "													inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt\n";
				$query.= "													inner join t_talker as e on a.conf_id = e.conf_id and b.talker_id = e.talker_id\n";
				$query.= "													where 1 = 1" . $where[1] . $where[2] . " group by e.talker_id)";
			}elseif($where[0]['item']){
				$query.= "								and talker_id in (select talker_id from t_conf as a\n";
				$query.= "												inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt";
				$query.= "												where 1 = 1" . $where[1] . $where[2] . " group by talker_id)";
			}elseif($where[0]['conf']){
				$query.= "								and conf_id in (select conf_id from t_conf as a\n";
				$query.= "												where 1 = 1" . $where[1] . $where[2] . " group by conf_id)";
			}							

			$query.="								group by parties, talker_name 
													order by {$_SESSION['search']['order']} {$_SESSION['search']['direction']}
													limit $disp_rows offset $offset
													)
								) as c
						) as g
						
						group by parties, talker_name
						order by {$_SESSION['search']['order']} {$_SESSION['search']['direction']}";
			//echo $query.'<br>';
 			return $this->db_query_fetch($query);

		}

		function get_stat_talker_conf_old($disp_rows, $down=false){

			$offset =  ($_SESSION['search']['page'] - 1) * $disp_rows;
			$where = $this->make_where(false);

			$query .= "select 
							CASE WHEN parties='' THEN '政党無し' ELSE parties END as parties,
							talker_name,
							sum(cnt1) as sum01,
							sum(cnt2) as sum02,
							sum(cnt3) as sum03,
							sum(cnt4) as sum04,
							sum(cnt5) as sum05,
							coalesce(sum(cnt1), 0) + coalesce(sum(cnt2), 0) + coalesce(sum(cnt3), 0) + coalesce(sum(cnt4), 0) + coalesce(sum(cnt5), 0) as sumall
						from 
						(select  parties,
							talker_name,
							(select count(conf_item_id) from t_conf_item b, t_conf a 
								where b.conf_id = a.conf_id 
								and a.conf_id = c.conf_id
								and b.talker_id = c.talker_id 
								and conf_tp='01' " . $where[1] . $where[2] . "
								group by talker_id) as cnt1,
							(select count(conf_item_id) from t_conf_item b, t_conf a 
								where b.conf_id = a.conf_id 
								and a.conf_id = c.conf_id
								and b.talker_id = c.talker_id 
								and conf_tp='02' " . $where[1] . $where[2] . "
								group by talker_id) as cnt2,
							(select count(conf_item_id) from t_conf_item b, t_conf a 
								where b.conf_id = a.conf_id 
								and a.conf_id = c.conf_id
								and b.talker_id = c.talker_id 
								and conf_tp='03' " . $where[1] . $where[2] . "
								group by talker_id) as cnt3,
							(select count(conf_item_id) from t_conf_item b, t_conf a 
								where b.conf_id = a.conf_id 
								and a.conf_id = c.conf_id
								and b.talker_id = c.talker_id 
								and conf_tp='04' " . $where[1] . $where[2] . "
								group by talker_id) as cnt4,
							(select count(conf_item_id) from t_conf_item b, t_conf a 
								where b.conf_id = a.conf_id 
								and a.conf_id = c.conf_id
								and b.talker_id = c.talker_id 
								and conf_tp='05' " . $where[1] . $where[2] . "
								group by talker_id) as cnt5
						from  ( select *
							from t_talker 
							where (parties,talker_name) in (select parties,talker_name
										from t_talker as c";
			if($where[0]['item']){
				$query.= "								inner join t_conf as a on a.conf_id = c.conf_id\n";
				$query.= "								inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt\n";
				$query.= "								where 1 = 1" . $where[1] . $where[2];
			}elseif($where[0]['conf']){
				$query.= "								inner join t_conf as a on a.conf_id = c.conf_id\n";
				$query.= "								where 1 = 1" . $where[1] . $where[2];
			}

			$query.="					group by parties, talker_name 
										order by {$_SESSION['search']['order']} {$_SESSION['search']['direction']}
										limit $disp_rows offset $offset
										)
							order by conf_id, talker_id) as c
						) as g
						
						group by parties, talker_name
						order by {$_SESSION['search']['order']} {$_SESSION['search']['direction']}";
			//echo $query;
 			return $this->db_query_fetch($query);

		}

		function get_stat_talker_pages($disp_rows){
			$where = $this->make_where(false);

			$query .= "select count(*) as cnt  from
						(select parties, talker_name
													from t_talker
													where 1=1";
			if($where[0]['talker']){
				$query.= "								and talker_id in (select c.talker_id from t_conf as a\n";
				$query.= "													inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt\n";
				$query.= "													inner join t_talker as c on a.conf_id = c.conf_id and b.talker_id = c.talker_id\n";
				$query.= "													where 1 = 1" . $where[1] . $where[2] . " group by c.talker_id)";
			}elseif($where[0]['item']){
				$query.= "								and talker_id in (select talker_id from t_conf as a\n";
				$query.= "												inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt";
				$query.= "												where 1 = 1" . $where[1] . $where[2] . " group by talker_id)";
			}elseif($where[0]['conf']){
				$query.= "								and conf_id in (select conf_id from t_conf as a\n";
				$query.= "												where 1 = 1" . $where[1] . $where[2] . " group by conf_id)";
			}

			$query.="					group by parties, talker_name
						) as c";

			//echo $query.'<br>';
			$line = $this->db_query_fetch($query);
			return array($line[0]['cnt'], ceil($line[0]['cnt'] / $disp_rows));
		}

		function get_stat_talker_pages_old($disp_rows){
			$where = $this->make_where(false);
			$query .= "select count(*) as cnt  from
						(select parties, talker_name
						from t_talker as c\n";
			if($where[0]['item']){
				$query.= "								inner join t_conf as a on a.conf_id = c.conf_id\n";
				$query.= "								inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt\n";
				$query.= "								where 1 = 1" . $where[1] . $where[2];
			}elseif($where[0]['conf']){
				$query.= "								inner join t_conf as a on a.conf_id = c.conf_id\n";
				$query.= "								where 1 = 1" . $where[1] . $where[2];
			}
			$query .= "						group by parties, talker_name
						)as c";
			$line = $this->db_query_fetch($query);

			return array($line[0]['cnt'], ceil($line[0]['cnt'] / $disp_rows));
		}

		function get_stat_db_pages($disp_rows){
			$where = $this->make_where(true);
			$query .= "select count(sys_tp) as cnt from (
					select distinct a.sys_tp || ':' || a.diet_tp as sys_tp
					 from  t_conf a\n";
			if($where[0]['talker']){
				$query.= "							inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt
									inner join t_talker as c on a.conf_id = c.conf_id and b.talker_id = c.talker_id\n";
			}elseif($where[0]['item']){
				$query .= "		inner join t_conf_item b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt";
			}				
			$query .= "{$where[1]} {$where[2]}
					) as c";
			$line = $this->db_query_fetch($query);
			return array($line[0]['cnt'], ceil($line[0]['cnt'] / $disp_rows));
		}
		
		function get_stat_db_month($disp_rows){
			// 入力条件よりSQLの編集
			$offset =  ($_SESSION['search']['page'] - 1) * $disp_rows;
			$where = $this->make_where(true);	

			$query .= "select
							CASE WHEN diet_tp='' THEN (SELECT dict_name FROM t_dict WHERE dict_tp = 'SYS_TP' AND dict_code = sys_tp)
				            ELSE (SELECT dict_name FROM t_dict WHERE dict_tp = 'DIET_TP' AND dict_code = diet_tp) END as name,
							conf_dt,
							count(*) as cnt
						from 
						(select a.diet_tp, a.sys_tp, date_trunc('month', b.conf_dt) as conf_dt
						 from  
						t_conf a 
						inner join  
						t_conf_item b 
						on 
						a.conf_id = b.conf_id 
						and a.conf_dt = b.conf_dt";
			if($where[0]['talker']){
				$query.= "							inner join t_talker as c on a.conf_id = c.conf_id and b.talker_id = c.talker_id\n";
			}
			$query.= "			and (a.sys_tp, diet_tp) in (select distinct a.sys_tp, diet_tp  from t_conf as a\n";
			if($where[0]['talker']){
				$query.= "							inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt
									inner join t_talker as c on a.conf_id = c.conf_id and b.talker_id = c.talker_id\n";
			}elseif($where[0]['item']){
				$query.= "							inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt";
			}
										
			$query.= "		{$where[1]} {$where[2]} 
							group by diet_tp, a.sys_tp
							order by {$_SESSION['search']['order']} {$_SESSION['search']['direction']}
							limit $disp_rows offset $offset)";
			$query.= "							{$where[1]} {$where[2]}
						) as cnt1
						group by diet_tp, sys_tp, conf_dt
						order by {$_SESSION['search']['order']} {$_SESSION['search']['direction']} , conf_dt";
			return $this->db_query_fetch($query);
		}

		function get_stat_db_year($disp_rows){
			// 入力条件よりSQLの編集
			$offset =  ($_SESSION['search']['page'] - 1) * $disp_rows;
			$where = $this->make_where(true);	

			$query .= "select
							CASE WHEN diet_tp='' THEN (SELECT dict_name FROM t_dict WHERE dict_tp = 'SYS_TP' AND dict_code = sys_tp)
				            ELSE (SELECT dict_name FROM t_dict WHERE dict_tp = 'DIET_TP' AND dict_code = diet_tp) END as name,
							conf_dt,
							count(*) as cnt
						from 
						(select a.diet_tp, a.sys_tp, date_trunc('year', b.conf_dt) as conf_dt
						 from  
						t_conf a 
						inner join  
						t_conf_item b 
						on 
						a.conf_id = b.conf_id 
						and a.conf_dt = b.conf_dt";
			if($where[0]['talker']){
				$query.= "							inner join t_talker as c on a.conf_id = c.conf_id and b.talker_id = c.talker_id\n";
			}
			$query.= "			and (a.sys_tp, diet_tp) in (select distinct a.sys_tp, diet_tp  from t_conf as a\n";
			if($where[0]['talker']){
				$query.= "							inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt
									inner join t_talker as c on a.conf_id = c.conf_id and b.talker_id = c.talker_id\n";
			}elseif($where[0]['item']){
				$query.= "							inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt";
			}
										
			$query.= "		{$where[1]} {$where[2]} 
							group by diet_tp, a.sys_tp
							order by {$_SESSION['search']['order']} {$_SESSION['search']['direction']}
							limit $disp_rows offset $offset)";
			$query.= "							{$where[1]} {$where[2]}
						) as cnt1						group by diet_tp, sys_tp, conf_dt
						order by  {$_SESSION['search']['order']} {$_SESSION['search']['direction']} , conf_dt";
			 
			return $this->db_query_fetch($query);
		}

		function get_stat_conf_pages($disp_rows){
			// 入力条件よりSQLの編集
			$offset =  ($_SESSION['search']['page'] - 1) * $disp_rows;
			$where = $this->make_where(true);	

			$query .= "select
							count(*) as cnt
						from 
						(select a.conf_tp
						 from  
						t_conf a"; 
			if($where[0]['talker']){
				$query.= "							inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt
									inner join t_talker as c on a.conf_id = c.conf_id and b.talker_id = c.talker_id\n";
			}elseif($where[0]['item']){
				$query.= "							inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt";
			}
	
			$query .= "			{$where[1]} {$where[2]}
						group by conf_tp
						) as cnt1";
			$line = $this->db_query_fetch($query);
			
			return array($line[0]['cnt'], ceil($line[0]['cnt'] / $disp_rows));
		}


		function get_stat_conf_month($disp_rows){
			// 入力条件よりSQLの編集
			$offset =  ($_SESSION['search']['page'] - 1) * $disp_rows;
			$where = $this->make_where(true);	

			$query .= "select
							(SELECT dict_name FROM t_dict WHERE dict_tp = 'CONF_TP' AND dict_code = conf_tp) as name,
							conf_dt,
							count(*) as cnt
						from 
						(select a.conf_tp, date_trunc('month', b.conf_dt) as conf_dt
						 from  
						t_conf a 
						inner join  
						t_conf_item b 
						on 
						a.conf_id = b.conf_id 
						and a.conf_dt = b.conf_dt"; 
			if($where[0]['talker']){
				$query.= "						inner join t_talker as c on a.conf_id = c.conf_id and b.talker_id = c.talker_id\n";
			} 
			$query .= "					{$where[1]} {$where[2]}
						) as cnt1
						group by conf_tp, conf_dt
						order by {$_SESSION['search']['order']} {$_SESSION['search']['direction']} , conf_dt";
			 
			return $this->db_query_fetch($query);
		}

		function get_stat_conf_year($disp_rows){
			// 入力条件よりSQLの編集
			$offset =  ($_SESSION['search']['page'] - 1) * $disp_rows;
			$where = $this->make_where(true);	

			$query .= "select
							(SELECT dict_name FROM t_dict WHERE dict_tp = 'CONF_TP' AND dict_code = conf_tp) as name,
							conf_dt,
							count(*) as cnt
						from 
						(select a.conf_tp, date_trunc('year', b.conf_dt) as conf_dt
						 from  
						t_conf a 
						inner join  
						t_conf_item b 
						on 
						a.conf_id = b.conf_id 
						and a.conf_dt = b.conf_dt"; 
			if($where[0]['talker']){
				$query.= "						inner join t_talker as c on a.conf_id = c.conf_id and b.talker_id = c.talker_id\n";
			} 
			$query .= "						{$where[1]} {$where[2]}
						) as cnt1
						group by conf_tp, conf_dt
						order by {$_SESSION['search']['order']} {$_SESSION['search']['direction']} , conf_dt";

 			return $this->db_query_fetch($query);
		}

		
		function get_stat_talker_month($disp_rows){
			// 入力条件よりSQLの編集
			$offset =  ($_SESSION['search']['page'] - 1) * $disp_rows;
			$where = $this->make_where(false);	

			$query .= "select array[CASE WHEN c.parties='' THEN '政党無し' ELSE c.parties END, c.talker_name] as name,date_trunc('month', b.conf_dt) as conf_dt, count(conf_item_id) as cnt
					from t_conf as a, t_conf_item as b, t_talker as c 
					where a.conf_id = b.conf_id
					and a.conf_dt = b.conf_dt 
					and a.conf_id = c.conf_id
					and b.talker_id = c.talker_id
					and (parties, talker_name) in (select parties, talker_name
													from t_talker
													where 1=1";
			if($where[0]['talker']){
				$query.= "								and talker_id in (select c.talker_id from t_conf as a\n";
				$query.= "													inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt\n";
				$query.= "													inner join t_talker as c on a.conf_id = c.conf_id and b.talker_id = c.talker_id\n";
				$query.= "													where 1 = 1" . $where[1] . $where[2] . " group by c.talker_id)";
			}elseif($where[0]['item']){
				$query.= "								and talker_id in (select talker_id from t_conf as a\n";
				$query.= "												inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt";
				$query.= "												where 1 = 1" . $where[1] . $where[2] . " group by talker_id)";
			}elseif($where[0]['conf']){
				$query.= "								and conf_id in (select conf_id from t_conf as a\n";
				$query.= "												where 1 = 1" . $where[1] . $where[2] . " group by conf_id)";
			}

			$query.="					group by parties, talker_name 
										order by {$_SESSION['search']['order']} {$_SESSION['search']['direction']}
										limit $disp_rows offset $offset
										)
					{$where[1]} {$where[2]}
					group by parties, c.talker_name,  date_trunc('month', b.conf_dt)
					order by {$_SESSION['search']['order']} {$_SESSION['search']['direction']} , conf_dt";
 			return $this->db_query_fetch($query);
		}

		function get_stat_talker_year($disp_rows){
			// 入力条件よりSQLの編集
			$offset =  ($_SESSION['search']['page']-1) * $disp_rows;
			$where = $this->make_where(false);	

			$query .= "select array[CASE WHEN c.parties='' THEN '政党無し' ELSE c.parties END, c.talker_name] as name,date_trunc('year', b.conf_dt) as conf_dt, count(conf_item_id) as cnt
					from t_conf as a, t_conf_item as b, t_talker as c 
					where a.conf_id = b.conf_id
					and a.conf_dt = b.conf_dt 
					and a.conf_id = c.conf_id
					and b.talker_id = c.talker_id
					and (parties, talker_name) in (select parties, talker_name
													from t_talker
													where 1=1";
			if($where[0]['talker']){
				$query.= "								and talker_id in (select c.talker_id from t_conf as a\n";
				$query.= "													inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt\n";
				$query.= "													inner join t_talker as c on a.conf_id = c.conf_id and b.talker_id = c.talker_id\n";
				$query.= "													where 1 = 1" . $where[1] . $where[2] . " group by c.talker_id)";
			}elseif($where[0]['item']){
				$query.= "								and talker_id in (select talker_id from t_conf as a\n";
				$query.= "												inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt";
				$query.= "												where 1 = 1" . $where[1] . $where[2] . " group by talker_id)";
			}elseif($where[0]['conf']){
				$query.= "								and conf_id in (select conf_id from t_conf as a\n";
				$query.= "												where 1 = 1" . $where[1] . $where[2] . " group by conf_id)";
			}

			$query.="					group by parties, talker_name 
										order by {$_SESSION['search']['order']} {$_SESSION['search']['direction']}
										limit $disp_rows offset $offset
										)
					{$where[1]} {$where[2]}
					group by parties, c.talker_name,  date_trunc('year', b.conf_dt)
					order by {$_SESSION['search']['order']} {$_SESSION['search']['direction']} , conf_dt";

 			return $this->db_query_fetch($query);
		}


		function get_stat_party_pages($disp_rows){
			$where = $this->make_where(false);
			$query .= "select count(*) as cnt  from
						(select parties
						from t_talker\n";
			if($where[0]['talker']){
				$query.= "								where talker_id in (select c.talker_id from t_conf as a\n";
				$query.= "													inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt\n";
				$query.= "													inner join t_talker as c on a.conf_id = c.conf_id and b.talker_id = c.talker_id\n";
				$query.= "													where 1 = 1" . $where[1] . $where[2] . " group by c.talker_id)";
			}elseif($where[0]['item']){
				$query.= "								where talker_id in (select talker_id from t_conf as a\n";
				$query.= "												inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt";
				$query.= "												where 1 = 1" . $where[1] . $where[2] . " group by talker_id)";
			}elseif($where[0]['conf']){
				$query.= "								where conf_id in (select conf_id from t_conf as a\n";
				$query.= "												where 1 = 1" . $where[1] . $where[2] . " group by conf_id)";
			}
			$query.= "						group by parties
						)as c";

			$line = $this->db_query_fetch($query);
			return array($line[0]['cnt'], ceil($line[0]['cnt'] / $disp_rows));
		}

		function get_stat_party_month($disp_rows){
			// 入力条件よりSQLの編集
			$offset =  ($_SESSION['search']['page'] - 1) * $disp_rows;
			$where = $this->make_where(false);	

			$query .= "select CASE WHEN c.parties='' THEN '政党無し' ELSE c.parties END as name, date_trunc('month', b.conf_dt) as conf_dt, count(conf_item_id) as cnt
						from t_conf as a
						inner join t_conf_item as b on 
						a.conf_id = b.conf_id
						and a.conf_dt = b.conf_dt
						inner join t_talker as c on				
						b.talker_id = c.talker_id
						and a.conf_id = c.conf_id
						where c.parties in (select parties
											from t_talker
											where 1=1\n";
			if($where[0]['talker']){
				$query.= "								and talker_id in (select c.talker_id from t_conf as a\n";
				$query.= "													inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt\n";
				$query.= "													inner join t_talker as c on a.conf_id = c.conf_id and b.talker_id = c.talker_id\n";
				$query.= "													where 1 = 1" . $where[1] . $where[2] . " group by c.talker_id)";
			}elseif($where[0]['item']){
				$query.= "								and talker_id in (select talker_id from t_conf as a\n";
				$query.= "												inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt";
				$query.= "												where 1 = 1" . $where[1] . $where[2] . " group by talker_id)";
			}elseif($where[0]['conf']){
				$query.= "								and conf_id in (select conf_id from t_conf as a\n";
				$query.= "												where 1 = 1" . $where[1] . $where[2] . " group by conf_id)";
			}

			$query.="					group by parties
										order by {$_SESSION['search']['order']} {$_SESSION['search']['direction']}
										limit $disp_rows offset $offset
										)

					{$where[1]} {$where[2]}
					group by c.parties,  date_trunc('month', b.conf_dt)
					order by {$_SESSION['search']['order']} {$_SESSION['search']['direction']} , conf_dt";

			 
			return $this->db_query_fetch($query);
		}

		function get_stat_party_year($disp_rows){
			// 入力条件よりSQLの編集
			$offset =  ($_SESSION['search']['page'] - 1) * $disp_rows;
			$where = $this->make_where(false);	

			$query .= "select CASE WHEN c.parties='' THEN '政党無し' ELSE c.parties END as name, date_trunc('year', b.conf_dt) as conf_dt, count(*) as cnt
						from t_conf as a
						inner join t_conf_item as b on 
						a.conf_id = b.conf_id
						and a.conf_dt = b.conf_dt
						inner join t_talker as c on				
						b.talker_id = c.talker_id
						and a.conf_id = c.conf_id
						where c.parties in (select parties
										  from t_talker
										  where 1=1\n";
			if($where[0]['talker']){
				$query.= "								and talker_id in (select c.talker_id from t_conf as a\n";
				$query.= "													inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt\n";
				$query.= "													inner join t_talker as c on a.conf_id = c.conf_id and b.talker_id = c.talker_id\n";
				$query.= "													where 1 = 1" . $where[1] . $where[2] . " group by c.talker_id)";
			}elseif($where[0]['item']){
				$query.= "								and talker_id in (select talker_id from t_conf as a\n";
				$query.= "												inner join t_conf_item as b on a.conf_id = b.conf_id and a.conf_dt = b.conf_dt";
				$query.= "												where 1 = 1" . $where[1] . $where[2] . " group by talker_id)";
			}elseif($where[0]['conf']){
				$query.= "								and conf_id in (select conf_id from t_conf as a\n";
				$query.= "												where 1 = 1" . $where[1] . $where[2] . " group by conf_id)";
			}

			$query.="					group by parties
										order by {$_SESSION['search']['order']} {$_SESSION['search']['direction']}
										limit $disp_rows offset $offset
										)
					{$where[1]} {$where[2]}
					group by c.parties,  date_trunc('year', b.conf_dt)
					order by {$_SESSION['search']['order']} {$_SESSION['search']['direction']} , conf_dt";
			 
			return $this->db_query_fetch($query);
		}


		private function make_where($replace_where=true){

			if($_SESSION['search']['time']==0 && $_SESSION['search']['period']!=0){
				$where[] = "a.conf_dt BETWEEN  to_date('20081231','YYYYMMDD')  + interval '-{$_SESSION['search']['period']} year' and to_date('20081231','YYYYMMDD')";
				//$where[] = "b.conf_dt BETWEEN  to_date('20081231','YYYYMMDD')  + interval '-{$_SESSION['search']['period']} year' and to_date('20081231','YYYYMMDD')";
				$flg['conf']=true;
				//$flg['item']=true;
			}
			if($_SESSION['search']['time']==1){
				$tmp_s = strtotime(implode("/", $_SESSION['search']['date_s']));
				$tmp_e = strtotime(implode("/", $_SESSION['search']['date_e']));
				if($tmp_s>$tmp_e){
					$tmp = $tmp_s; $tmp_s = $tmp_e; $tmp_e = $tmp;
				}
				$date_s = date("Ymd",$tmp_s);
				$date_e = date("Ymd",$tmp_e);
				$where[] = "a.conf_dt BETWEEN '$date_s' and '$date_e'";
				//$where[] = "b.conf_dt BETWEEN '$date_s' and '$date_e'";
				$flg['conf']=true;
				//$flg['item']=true;
			}

			// all 判定
			$flg_sys = false;
			$flg_diet = false;
			if(count($_SESSION['search']['select_all'])>0){
				foreach($_SESSION['search']['select_all'] as $all){
					switch($all){
					case "1";
						$flg_diet = true;
						break;
					case "2";
						$flg_sys = true;
					}
				}
			}
			if(count($_SESSION['search']['diet_tp'])>0){
				$diet = $_SESSION['search']['diet_tp'];
				if(count($_SESSION['search']['sys_tp'])>0 or $flg_sys){
					array_push($diet, '');
				}
				$where[] = "a.diet_tp IN ('".implode("','", $diet)."')";
				$flg['conf']=true;
			}elseif($flg_diet and count($_SESSION['search']['sys_tp'])==0 and !$flg_sys){
				$where[] = "a.diet_tp::text != ''";
				$flg['conf']=true;
			}

			if(count($_SESSION['search']['sys_tp'])>0){
				$sys = $_SESSION['search']['sys_tp'];
				if(count($_SESSION['search']['diet_tp'])>0 or $flg_diet){
					array_push($sys, '01');
				}
				$where[] = "a.sys_tp IN ('" . implode("','", $sys) . "')";
				$flg['conf']=true;
			}elseif($flg_sys and count($_SESSION['search']['diet_tp'])==0 and !$flg_diet){
				$where[] = "a.sys_tp != '01'";
				$flg['conf']=true;
			}
			
			if(isset($_SESSION['search']['conf_tp'])){
				$where[] = "a.conf_tp IN ('".implode("','", $_SESSION['search']['conf_tp'])."')";
				$flg['conf']=true;
			}			

			foreach($_SESSION['search']['option'] as $key => $option){
				if($_SESSION['search']['option_value'][$key]=="") continue;
				//1=>'会議名',2=>'会議情報',3=>'発言内容',4=>'全て'
				//発言内容、発言者、政党、肩書き、会議情報、会議名
				switch($option){
				case '発言内容';
					$where2 .= " {$_SESSION['search']['andor'][$key]} b.content like '%{$_SESSION['search']['option_value'][$key]}%'";
					//$where2 .= " {$_SESSION['search']['andor'][$key]} (b.conf_id, b.conf_item_id) IN (select conf_id, conf_item_id from t_conf_item where content like '%{$_SESSION['search']['option_value'][$key]}%')";
					//$where2 .= " {$_SESSION['search']['andor'][$key]}( b.content like '%{$_SESSION['search']['option_value'][$key]}%'";
					//$where2 .= " and to_tsvector('japanese', b.content) @@ to_tsquery('japanese','{$_SESSION['search']['option_value'][$key]}'))";
					$flg['item']=true;
					break;
				case '会議名';
					$where2 .= " {$_SESSION['search']['andor'][$key]} a.conf_title like '%{$_SESSION['search']['option_value'][$key]}%'";

					//$where2 .= " {$_SESSION['search']['andor'][$key]} (a.conf_title like '%{$_SESSION['search']['option_value'][$key]}%'";
					//$where2 .= " and to_tsvector('japanese', a.conf_title) @@ to_tsquery('japanese','{$_SESSION['search']['option_value'][$key]}'))";
					$flg['conf']=true;
					break;
				case '会議情報';
					$where2 .= " {$_SESSION['search']['andor'][$key]} a.conf_info like '%{$_SESSION['search']['option_value'][$key]}%'";
					//$where2 .= " {$_SESSION['search']['andor'][$key]} (a.conf_info like '%{$_SESSION['search']['option_value'][$key]}%'";
					//$where2 .= " and to_tsvector('japanese', a.conf_info) @@ to_tsquery('japanese','{$_SESSION['search']['option_value'][$key]}'))";
					$flg['conf']=true;
					break;
				case '政党';
					//$where2 .= " {$_SESSION['search']['andor'][$key]} b.talker_id in (select talker_id from t_talker where parties like '%{$_SESSION['search']['option_value'][$key]}%')";
					//$where2 .= " {$_SESSION['search']['andor'][$key]} b.talker_id in (select talker_id from t_talker where to_tsvector('japanese',parties) @@ to_tsquery('japanese','{$_SESSION['search']['option_value'][$key]}'))";
					$where2 .= " {$_SESSION['search']['andor'][$key]} parties like '%{$_SESSION['search']['option_value'][$key]}%'";
					//$flg['item']=true;
					$flg['talker']=true;
					break;
				case '肩書き';
					//$where2 .= " {$_SESSION['search']['andor'][$key]} b.talker_id in (select talker_id from t_talker where position like '%{$_SESSION['search']['option_value'][$key]}%')";
					//$where2 .= " {$_SESSION['search']['andor'][$key]} b.talker_id in (select talker_id from t_talker where to_tsvector('japanese',position) @@ to_tsquery('japanese','{$_SESSION['search']['option_value'][$key]}'))";
					$where2 .= " {$_SESSION['search']['andor'][$key]} position like '%{$_SESSION['search']['option_value'][$key]}%'";
					//$flg['item']=true;
					$flg['talker']=true;
					break;
				case '発言者';
					//$where2 .= " {$_SESSION['search']['andor'][$key]} b.talker_id in (select talker_id from t_talker where to_tsvector('japanese', talker_name||talker_jname) @@ to_tsquery('japanese','{$_SESSION['search']['option_value'][$key]}'))";
					//$where2 .= " {$_SESSION['search']['andor'][$key]} b.talker_id in (select talker_id from t_talker where (talker_name like'%{$_SESSION['search']['option_value'][$key]}%' or talker_jname like'%{$_SESSION['search']['option_value'][$key]}%'))";
					$where2 .= " {$_SESSION['search']['andor'][$key]} (talker_name like'%{$_SESSION['search']['option_value'][$key]}%' or talker_jname like'%{$_SESSION['search']['option_value'][$key]}%')";
					//$flg['item']=true;
					$flg['talker']=true;
					break;
				}
			}
			
			if(isset($where2)){
				$where2 = preg_replace("/^ OR/", " AND", $where2,-1);
				$where2 = preg_replace("/^ AND/", " AND(", $where2,-1) . ")" ;
			}
			
			if(isset($where)){
				$where = implode("\n AND ", $where);
				if($replace_where){
					$where = " WHERE " . $where;
				}else{
					$where = " AND " . $where;
				}
			}	

			$ret = array($flg, $where, $where2);
			return $ret;
		}

		function __destruct() {
			//$this->db_close();
			//parent::__destruct();
		}

	}
?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
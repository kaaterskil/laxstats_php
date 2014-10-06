<?php
class db_control{
	/*************************************************************
	DECLARE VARIABLES
	*************************************************************/
	var $linkage;
	var $connected;
		
	/*************************************************************
	CONSTRUCTOR
	*************************************************************/
	function db_control(){
		$this->db_connect();
	}
	
	/*************************************************************
	FUNCTIONS
	*************************************************************/
	/*------------------------------------------------------------
	CONNECT
	------------------------------------------------------------*/
	function db_connect(){
		$this->linkage = @mysql_connect(HOSTNAME, USERNAME, PASSWORD);
		if($this->linkage){
			if(@mysql_select_db(DATABASE, $this->linkage)){
				$this->connected = true;
				return true;
			}else{
				$this->db_error(mysql_errno(), mysql_error());
				return false;
			}
		}else{
			$this->db_error(mysql_errno(), mysql_error());
			return false;
		}
	}
		
	/*------------------------------------------------------------
	QUERY DATABASE
	The first version returns an array of associative arrays. The
	second version returns an associate array of arrays.
	------------------------------------------------------------*/
	function db_query($sql){
		if(!$this->connected){
			$this->db_connect();
		}
		$resource = @mysql_query($sql, $this->linkage);
		if(!$resource){
			$this->db_error(@mysql_errno(), @mysql_error(), $sql);
		}
		$obj = new query_result;
		$obj->sql = $sql;
		$obj->cursor = 0;
		$obj->resource = $resource;
		if($obj->count_records() > 0){
			$obj->eof = false;
			$i = 0;
			while(!$obj->eof){
				$result_array = @mysql_fetch_array($resource);
				if($result_array){
					while(list($key, $value) = each($result_array)){
						if(!preg_match('#^[0-9]#', $key)){
							$obj->result[$key][$i] = stripslashes($value);
						}
					}
				}else{
					$obj->limit = $i;
					$obj->eof = true;
				}
				$i++;
			}
			@mysql_data_seek($obj->resource, 0);
			$result_array = @mysql_fetch_array($obj->resource);
			while(list($key, $value) = each($result_array)){
				if(!preg_match('#^[0-9]#', $key)){
					$obj->field[$key] = stripslashes($value);
				}
			}
			$obj->eof = false;
		}else{
			$obj->eof = true;
		}
		return $obj;
	}

	/*------------------------------------------------------------
	WRITE ARRAY TO DATABASE
	------------------------------------------------------------*/
	function db_write_array($table, $data_array, $action = 'insert', $param = ''){
		reset($data_array);
		if($action == 'insert'){
			$sql = 'INSERT INTO '.$table.' SET ';
			while(list($column, $value) = each($data_array)){
				switch($value){
					case 'now':
						$sql .= $column.'=NOW(), ';
						break;
					case 'null':
						$sql .= $column='=NULL, ';
						break;
					default:
						$sql .= $column.'=\''.$value.'\', ';
						break;
				}
			}
			$sql = substr($sql, 0, -2);
		}elseif($action == 'update'){
			$sql = 'UPDATE '.$table.' SET ';
			while(list($column, $value) = each($data_array)){
				switch($value){
					case 'now':
						$sql .= $column.'=NOW(), ';
						break;
					case 'null':
						$sql .= $column='=NULL, ';
						break;
					default:
						$sql .= $column.'=\''.$value.'\', ';
						break;
				}
			}
			$sql = substr($sql, 0, -2).' WHERE '.$param;
		}
		return $this->db_write($sql);
	}

	/*------------------------------------------------------------
	WRITE TO DATABASE
	------------------------------------------------------------*/
	function db_write($sql){
		if(isset($sql) && $sql != ''){
			if(!$this->connected){
				$this->db_connect();
			}
			$resource = @mysql_query($sql, $this->linkage);
			if(!$resource){
				$this->db_error(@mysql_errno(), @mysql_error(), $sql);
			}
		}
		return null;
	}

	/*------------------------------------------------------------
	GET LAST ID
	------------------------------------------------------------*/
	function db_insert_id(){
		$r = @mysql_insert_id($this->linkage);
		return $r;
	}
	
	/*------------------------------------------------------------
	PREPARE INPUT
	------------------------------------------------------------*/
	function db_sanitize($string){
		if(function_exists('mysql_real_escape_string')){
			$r = mysql_real_escape_string($string);
		}elseif(function_exists('mysql_escape_string')){
			$r = mysql_escape_string($string);
		}else{
			$r = addslashes($string);
		}
		return $r;
	}
	
	/*------------------------------------------------------------
	ERROR HANDLER
	------------------------------------------------------------*/
	function db_error($err_no, $error_message, $sql = ''){
		if($sql != ''){
			die('Error: '.$err_no.': '.$error_message.'. SQL:'.$sql);
		}else{
			die('Error: '.$err_no.': '.$error_message);
		}
	}
}
?>
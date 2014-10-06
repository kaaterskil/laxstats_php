<?php
class query_result{
	/*************************************************************
	DECLARE VARIABLES
	*************************************************************/
	var $sql;
	var $eof;
	var $cursor;
	var $field;
	var $resource;
	var $result;
	var $limit;
	
	/*************************************************************
	FUNCTIONS
	*************************************************************/
	/*------------------------------------------------------------
	RETRIEVE THE CURRENT DATA ROW
	------------------------------------------------------------*/
	function move_next(){
		$result_array = @mysql_fetch_array($this->resource);
		if(!$result_array){
			$this->eof = true;
		}else{
			$this->eof = false;
			while(list($key, $value) = each($result_array)){
				if(!preg_match('#^[0-9]#', $key)){
					$this->field[$key] = stripslashes($value);
				}
			}
		}
	}
	
	/*------------------------------------------------------------
	GET NUMBER OF DATA ROWS
	------------------------------------------------------------*/
	function count_records(){
		$r = @mysql_num_rows($this->resource);
		return $r;
	}
	
	/*------------------------------------------------------------
	RETRIEVE THE SPECIFIED DATA ROW
	------------------------------------------------------------*/
	function move($row = 0){
		if(@mysql_data_seek($this->resource, $row)){
			$result_array = @mysql_fetch_array($this->resource);
			while(list($key, $value) = each($result_array)){
				if(!preg_match('#^[0-9]#', $key)){
					$obj->field[$key] = $value;
				}
			}
			@mysql_data_seek($this->resource, $row);
			$this->eof = false;
			return;
		}else{
			$this->eof = true;
		}
	}
}
?>
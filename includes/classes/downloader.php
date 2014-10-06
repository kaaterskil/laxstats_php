<?php
class downloader{
	/*************************************************************
	DECLARE VARIABLES
	*************************************************************/
	var $file_name;
	var $file_type;
	var $file_size;
	var $file_path;
	var $teamMasterRef;
	var $directory;
	var $recordID;
	
	/*************************************************************
	CONSTRUCTOR
	*************************************************************/
	function downloader($type, $recordID){
		$this->recordID = $recordID;
		switch($type){
			case 'image':
				break;
			case 'blog_file':
				$this->get_blog_file();
				break;
		}
		$this->send_file();
	}
	
	/*************************************************************
	FUNCTIONS
	*************************************************************/
	/*------------------------------------------------------------
	GET FILE
	------------------------------------------------------------*/
	function get_blog_file(){
		global $db;
		$sql = 'SELECT teamMasterRef, fileName, fileType 
				FROM coachLetters
				WHERE reference='.$this->recordID;
		$result = $db->db_query($sql);
		$this->file_name		= $result->field['fileName'];
		$this->file_type		= $result->field['fileType'];
		$this->teamMasterRef	= $result->field['teamMasterRef'];
		$this->directory		= 'userFiles/tmr_'.$this->teamMasterRef.'/';
	}
	
	/*------------------------------------------------------------
	GET FILE DATA
	------------------------------------------------------------*/
	function get_file_data(){
		global $template;
		if($template->test_file_exists($this->directory, $this->file_name)){
			$this->file_size = @filesize($this->directory.$this->file_name);
			$this->file_path = $this->directory.$this->file_name;
			return true;
		}
		return false;
	}
	
	/*------------------------------------------------------------
	OUTPUT FILE TO BUFFER
	------------------------------------------------------------*/
	function send_file(){
		$test = $this->get_file_data();
		if($test){
			if(ini_get('zlib.output_compression')){
				ini_set('zlib.output_compression', 'Off');
			}
			header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Cache-Control: private', false);
			header('Content-Type: '.$this->file_type);
			header('Content-Disposition: attachment; filename="'.$this->file_name.'"');
			header('Content-Transfer-Encoding: Binary');
			if($this->file_type != 'application/pdf'){
				header('Content-Length: '.$this->file_size);
			}
			set_time_limit(0);
			$message = @readfile($this->directory.$this->file_name);
			return $message;
		}
		return false;
	}
}
?>
<?php
class upload{
	/*************************************************************
	DECLARE VARIABLES
	*************************************************************/
	var $file_upload;
	var $filename;
	var $destination;
	var $permissions;
	var $extensions;
	var $tmp_filename;
	var $size;
	var $type;

	/*************************************************************
	CONSTRUCTOR
	*************************************************************/
	function upload($file = '', $destination = '', $permissions = '666', $extensions = array()){
		$this->set_file($file);
		$this->set_destination($destination);
		$this->set_permissions($permissions);
		
		if(!not_null($extensions)){
			$extensions = explode(' ', preg_replace('/[.,;\s]+/', ' ', UPLOAD_FILENAME_EXTENSIONS));
		}
		$this->set_extensions($extensions);
		
		if(not_null($this->file_upload) && not_null($this->destination)){
			$message = $this->parse_upload();
			if($message == true){
				$message = save_file();
				if($message == true){
					return FILE_UPLOADED_SUCCESSFULLY;
				}else{
					return $message;
				}
			}else{
				return $message;
			}
		}
	}

	/*************************************************************
	FUNCTIONS
	*************************************************************/
	/*------------------------------------------------------------
	SET FILE
	------------------------------------------------------------*/
	function set_file($file){
		$this->file_upload = $file;
	}
	
	/*------------------------------------------------------------
	SET DESTINATION
	------------------------------------------------------------*/
	function set_destination($destination){
		$this->destination = $destination;
	}
	
	/*------------------------------------------------------------
	SET PERMISSIONS
	------------------------------------------------------------*/
	function set_permissions($permissions){
		$this->permissions = octdec($permissions);
	}
	
	/*------------------------------------------------------------
	SET EXTENSIONS
	------------------------------------------------------------*/
	function set_extensions($extensions){
		if(not_null($extensions)){
			if(is_array($extensions)){
				$this->extensions = $extensions;
			}else{
				$this->extensions = array($extensions);
			}
		}else{
			$this->extensions = array();
		}
	}
	
	/*------------------------------------------------------------
	SET FILENAME
	------------------------------------------------------------*/
	function set_filename($filename){
		$this->filename = $filename;
	}
	
	/*------------------------------------------------------------
	SET TEMPORARY FILENAME
	------------------------------------------------------------*/
	function set_tmp_filename($filename){
		$this->tmp_filename = $filename;
	}
	
	/*------------------------------------------------------------
	SET SIZE
	------------------------------------------------------------*/
	function set_size($filesize){
		$this->size = $filesize;
	}
	
	/*------------------------------------------------------------
	SET TYPE
	------------------------------------------------------------*/
	function set_type($filetype){
		$this->type = $filetype;
	}

	/*------------------------------------------------------------
	PARSE FILE UPLOAD
	------------------------------------------------------------*/
	function parse_upload($key = ''){
		$message = '';
		if(isset($_FILES[$this->file_upload])){
			if(not_null($key)){
				$file_array = array('name'		=> $_FILES[$this->file_upload]['name'][$key],
									'type'		=> $_FILES[$this->file_upload]['type'][$key],
									'size'		=> $_FILES[$this->file_upload]['size'][$key],
									'tmp_name'	=> $_FILES[$this->file_upload]['tmp_name'][$key]
									);
			}else{
				$file_array = array('name'		=> $_FILES[$this->file_upload]['name'],
									'type'		=> $_FILES[$this->file_upload]['type'],
									'size'		=> $_FILES[$this->file_upload]['size'],
									'tmp_name'	=> $_FILES[$this->file_upload]['tmp_name']
									);
			}
		}elseif(isset($GLOBALS['HTTP_POST_FILES'][$this->file_upload])){
			global $HTTP_POST_FILES;
			$file_array = array('name'		=> $HTTP_POST_FILES[$this->file_upload]['name'],
								'type'		=> $HTTP_POST_FILES[$this->file_upload]['type'],
								'size'		=> $HTTP_POST_FILES[$this->file_upload]['size'],
								'tmp_name'	=> $HTTP_POST_FILES[$this->file_upload]['tmp_name']
								);
		}else{
			$file_array = array('name'		=> (isset($GLOBALS[$this->file_upload.'_name']) ? $GLOBALS[$this->file_upload.'_name'] : ''),
								'type'		=> (isset($GLOBALS[$this->file_upload.'_type']) ? $GLOBALS[$this->file_upload.'_type'] : ''),
								'size'		=> (isset($GLOBALS[$this->file_upload.'_size']) ? $GLOBALS[$this->file_upload.'_size'] : ''),
								'tmp_name'	=> (isset($GLOBALS[$this->file_upload]) ? $GLOBALS[$this->file_upload] : '')
								);
		}
		if(!is_uploaded_file($file_array['tmp_name'])){
			$message = ERROR_NO_FILE_UPLOADED;
			return $message;
		}
		if(not_null($file_array['tmp_name']) && $file_array['tmp_name'] != 'none' && is_uploaded_file($file_array['tmp_name'])){
			//get extension
			$ext = strtolower(substr($file_array['name'], strrpos($file_array['name'], '.') + 1));
			//test for maximum file size
			if($ext == 'txt' || $ext == 'doc' || $ext == 'xls' || $ext == 'ppt' || $ext == 'pdf'){
				$max_size = UPLOAD_MAXSIZE_DOCUMENT;
			}else{
				$max_size = UPLOAD_MAXSIZE_IMAGE;
			}
			if($file_array['size'] > $max_size){
					$message = ERROR_MAXSIZE_EXCEEDED;
					return $message;
			}
			//test for correct extension
			if(count($this->extensions) > 0){
				if(!in_array($ext, $this->extensions)){
					$message = ERROR_FILETYPE_NOT_ALLOWED;
					return $message;
				}
			}
			//parse data
			$this->set_file($file_array);
			$this->set_filename($file_array['name']);
			$this->set_type($file_array['type']);
			$this->set_tmp_filename($file_array['tmp_name']);
			$message = $this->test_destination();
			return $message;
		}else{
			$message = ERROR_NO_FILE_UPLOADED;
			return $message;
		}
	}

	/*------------------------------------------------------------
	TEST DESTINATION
	------------------------------------------------------------*/
	function test_destination(){
		if(!is_writable($this->destination)){
			if(is_dir($this->destination)){
				$message = ERROR_DESTINATION_NOT_WRITABLE;
			}else{
				if(!mkdir($this->destination, 0777)){
					$message = ERROR_DESTINATION_DOES_NOT_EXIST;
				}else{
					return true;
				}
			}
			return $message;
		}else{
			return true;
		}
	}

	/*------------------------------------------------------------
	SAVE FILE
	------------------------------------------------------------*/
	function save_file($overwrite = true){
		if(!$overwrite && file_exists($this->destination.$this->filename)){
			$message = ERROR_CANNOT_OVERWRITE;
		}else{
			if(substr($this->destination, -1) != '/'){
				$this->destination .= '/';
			}
			if(move_uploaded_file($this->file_upload['tmp_name'], $this->destination.$this->filename)){
				chmod($this->destination.$this->filename, $this->permissions);
				$message = true;
			}else{
				$message = ERROR_FILE_NOT_SAVED;
			}
		}
		return $message;
	}

	/*------------------------------------------------------------
	SELF_DESTRUCT
	------------------------------------------------------------*/
	function self_destruct($message){
		while(list($key, ) = each($this)){
			$this->$key = NULL;
		}
		return $message;
	}
}
?>
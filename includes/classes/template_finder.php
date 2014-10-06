<?php
class template_finder {
	/***********************************************************************
	DECLARE VARIABLES
	***********************************************************************/
	var $info;
	
	/***********************************************************************
	CONSTRUCTOR
	***********************************************************************/
	function template_finder(){
		$this->info = array();
	}
	
	/***********************************************************************
	FUNCTIONS
	***********************************************************************/
	/*----------------------------------------------------------------------
	GET TEMPLATE FILES
	----------------------------------------------------------------------*/
	function get_template_files($tpl_directory, $tpl_file, $extension = '.php'){
		$r = array();
		if($directory = @dir($tpl_directory)){
			while($file = $directory->read()){
				if(!is_dir($tpl_directory.$file)){
					if(substr($file, strpos($file, '.')) == $extension && preg_match($tpl_file, $file)){
						$r[] = $file;
					}
				}
			}
			sort($r);
			$directory->close();
		}
		return $r;
	}

	/*----------------------------------------------------------------------
	TEST FILE
	----------------------------------------------------------------------*/
	function test_file_exists($tpl_directory, $pattern){
		$r = false;
		$pattern = '/'.str_replace('/', '\/', $pattern).'$/';
		if($directory = @dir($tpl_directory)){
			while($file = $directory->read()){
				if(preg_match($pattern, $file)){
					$r = true;
					break;
				}
			}
		}
		return $r;
	}
}
?>
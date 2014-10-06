<?php
reset($directory_array);
ksort($directory_array);
foreach($directory_array as $break_point => $row){
	foreach($row as $entry){
		$debug_output = 'break_point: '.$break_point.': ';
		switch($entry['load_type']){
			
			//for require files
			case 'require':
				require($entry['load_file']);
				$debug_output .='require(\''.$entry['load_file'].'\')<br>';
				
				if(file_exists($entry['load_file'])){
				}
				break;
			
			//for include files
			case 'include':
				include($entry['load_file']);
				$debug_output .='include(\''.$entry['load_file'].'\')<br>';
				
				if(file_exists($entry['load_file'])){
				}
				break;
			
			//for initialization scripts
			case 'init_script':
				$directory = 'includes/init/';
				require($directory.$entry['load_file']);
				$debug_output .='require(\''.$directory.$entry['load_file'].'\')<br>';
				
				if(file_exists($entry['load_file'])){
				}
				break;
				
			//for class definitions	
			case 'class':
				$directory = 'includes/classes/';
				require($directory.$entry['load_file']);
				$debug_output .='require(\''.$directory.$entry['load_file'].'\')<br>';
				
				if(file_exists($entry['load_file'])){
				}
				break;
				
			//to instantiate a class
			case 'class_instantiate':
				$object_name = $entry['object_name'];
				$class_name = $entry['class_name'];
				if(isset($entry['class_session']) && $entry['class_session'] === true){
					if(isset($entry['instantiated']) && $entry['instantiated'] === true){
						if(!isset($_SESSION[$object_name])){
							$debug_output .= '$_SESSION[\''.$object_name.'\'] = new '.$class_name.'()<br>';
							$_SESSION[$object_name] = new $class_name();
						}
					}else{
						$debug_output .= '$_SESSION[\''.$object_name.'\'] = new '.$class_name.'()<br>';
						$_SESSION[$object_name] = new $class_name();
					}
				}else{
					//create a variable with a name based on the object name, i.e. a variable variable
					$debug_output = '$'.$object_name.' = new '.$class_name.'()<br>';
					$$object_name = new $class_name();
				}
				break;
			
			//to run an object method
			case 'object_method':
				$object_name = $entry['object_name'];
				$method_name = $entry['method_name'];
				if(is_object($_SESSION[$object_name])){
					$_SESSION[$object_name]->$method_name();
					$debug_output .='$_SESSION[\''.$object_name.'\']->'.$method_name.'()<br>';
				}else{
					//create a variable with a name based on the object name, i.e. a variable variable
					$$object_name->$method_name();
					$debug_output .= '$'.$object_name.'->'.$method_name.'()</br>';
				}
				break;
		}
		//echo $debug_output;
	}
}
?>
<?php
//1. load classes
$directory_array[0][] = array ('load_type' => 'class',
							   'load_file' => 'db_control.php'
							   );
$directory_array[0][] = array ('load_type' => 'class',
							   'load_file' => 'query_result.php'
							   );
$directory_array[0][] = array ('load_type' => 'class',
							   'load_file' => 'downloader.php'
							   );
$directory_array[0][] = array ('load_type' => 'class',
							   'load_file' => 'emailer.php'
							   );
$directory_array[0][] = array ('load_type' => 'class',
							   'load_file' => 'laxpower_reader.php'
							   );
$directory_array[0][] = array ('load_type' => 'class',
							   'load_file' => 'template_finder.php'
							   );
$directory_array[0][] = array ('load_type' => 'class',
							   'load_file' => 'upload.php'
							   );
$directory_array[0][] = array ('load_type' => 'class',
							   'load_file' => 'rss_reader.php'
							   );
//2. load main init files
$directory_array[10][] = array ('load_type' => 'init_script',
								'load_file' => 'init_common.php'
								);
$directory_array[10][] = array ('load_type' => 'init_script',
								'load_file' => 'init_http.php'
								);
//3. initialize sessions
$directory_array[20][] = array('load_type' => 'init_script',
							   'load_file' => 'init_sessions.php'
							   );
//4. instantiate classes
$directory_array[40][] = array ('load_type' => 'class_instantiate',
								'class_name' => 'db_control',
								'object_name' => 'db'
								);
$directory_array[40][] = array ('load_type' => 'class_instantiate',
								'class_name' => 'template_finder',
								'object_name' => 'template'
								);
//5. load additional init files
$directory_array[50][] = array ('load_type' => 'init_script',
								'load_file' => 'init_sanitation.php'
								);
//6. load template handler
$directory_array[100][] = array('load_type' => 'init_script',
								'load_file' => 'init_templates.php'
								);
?>
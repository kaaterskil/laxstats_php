<?php
$masthead_logo = MASTHEAD_FIELD;
$tpl_menubar = MENUBAR_PUBLIC;
define('PAGE_TITLE', 'Playing Fields');

//retrieve data
$surface = '';
$fieldRef = $playing_field;
if($fieldRef == 'A'){
	$fieldRef = 0;
}
$sql = 'SELECT town, name, type, directions
		FROM sites
		WHERE fieldRef='.$fieldRef;
$field_obj = $db->db_query($sql);
$town = (isset($field_obj->field['town']) ? $field_obj->field['town'] : '');
$name = (isset($field_obj->field['name']) ? $field_obj->field['name'] : '');
$type = (isset($field_obj->field['type']) ? $field_obj->field['type'] : '');
$directions = (isset($field_obj->field['directions']) ? $field_obj->field['directions'] : '');

switch($type){
	case 'GP':
		$surface = 'Practice grass';
		break;
	case 'GC':
		$surface = 'Competition grass';
		break;
	case 'T':
		$surface = 'Turf';
		break;
	case NULL:
		$surface = '';
		break;
	default:
		$surface = 'Unknown';
		break;
}
$directions = nl2br($directions);

$param = 'f='.$playing_field.'&nmh=true';
$href_print = set_href(FILENAME_FIELD_PRINT, $param);
?>
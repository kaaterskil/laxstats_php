<?php
define('PAGE_TITLE', 'Playing Fields');

//retrieve data
$sql = 'SELECT town, name, directions
		FROM sites
		WHERE fieldRef='.$playing_field;
$field_obj = $db->db_query($sql);
$town = (isset($field_obj->field['town']) ? $field_obj->field['town'] : '');
$name = (isset($field_obj->field['name']) ? $field_obj->field['name'] : '');
$directions = (isset($field_obj->field['directions']) ? $field_obj->field['directions'] : '');

$field_name = strtoupper(set_team_name($town, $name));
$directions = nl2br($directions);
$title = 'DIRECTIONS TO '.$field_name.' FIELD';
$image_src = 'images/iconprinter.gif';
?>
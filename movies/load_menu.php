<?php
include '../includes/definitions/definitions_common.php';
include '../includes/classes/db_control.php';
include '../includes/classes/query_result.php';

$teamMasterRef = intval($_GET['tmr']);
$db = new db_control();

$xml = '<menu>';
$sql = 'SELECT ref, title
		FROM playbook
		WHERE teamMasterRef='.$teamMasterRef.'
			OR teamMasterRef=0
		ORDER BY ref DESC';
$obj = $db->db_query($sql);
if($obj->count_records() > 0){
	while(!$obj->eof){
		$ref = strval($obj->field['ref']);
		$title = $obj->field['title'];
		
		$xml .= '<menuItem><title>'.$title.'</title><ref>'.$ref.'</ref></menuItem>';
		$obj->move_next();
	}
}else{
	$xml .= '<menuItem><title>No plays have been saved yet.</title><ref></ref></menuItem>';
}
$xml .= '</menu>';
echo $xml;
?>
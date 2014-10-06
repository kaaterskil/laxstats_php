<?php
include '../includes/definitions/definitions_common.php';
include '../includes/classes/db_control.php';
include '../includes/classes/query_result.php';

$recordID = intval($_GET['r']);
$db = new db_control();

$xml = '';
$sql = 'SELECT params
		FROM playbook
		WHERE ref='.$recordID;
$obj = $db->db_query($sql);
if($obj->count_records() > 0){
	$xml = $obj->field['params'];
}
echo $xml;
?>
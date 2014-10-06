<?php
include '../includes/definitions/definitions_common.php';
include '../includes/classes/db_control.php';
include '../includes/classes/query_result.php';
$db = new db_control();

$teamMasterRef = (isset($_GET['tmr']) ? $_GET['tmr'] : 0);
$recordID = (isset($_GET['r']) ? $_GET['r'] : 0);
$action = (isset($_GET['a']) ? $_GET['a'] : '');

$message = '';
if($action != ''){
	switch($action){
		//delete play
		case 'd':
			if($recordID > 0){
				$sql = 'SELECT COUNT(*) AS count
						FROM playbook
						WHERE ref='.$recordID;
				$test = $db->db_query($sql);
				if($test->field['count'] > 0){
					$sql = 'DELETE FROM playbook WHERE ref='.$recordID;
					$message = $db->db_write($sql);
				}
				if($message == ''){
					$message = 'Play deleted.';
				}
			}
			break;
		//save pale
		case 's':
			$title = (isset($_POST['tl']) ? $_POST['tl'] : '');
			$xml = (isset($_POST['xml']) ? $_POST['xml'] : '');
			if($recordID > 0){
				$sql_data_array = array('title'			=> $title,
										'params'		=> $xml,
										'modifiedBy'	=> $_SESSION['user_id'],
										'modified'		=> 'now'
										);
				$param = 'ref='.$recordID;
				$message = $db->db_write_array('playbook', $sql_data_array, 'update', $param);
			}else{
				$sql_data_array = array('teamMasterRef'	=> $teamMasterRef,
										'title'			=> $title,
										'params'		=> $xml,
										'modifiedBy'	=> $_SESSION['user_id'],
										'created'		=> 'now',
										'modified'		=> 'now'
										);
				$message = $db->db_write_array('playbook', $sql_data_array);
			}
			if($message == ''){
				$message = 'Record successfully written to database.';
			}
			break;
	}
}
echo $message;
?>
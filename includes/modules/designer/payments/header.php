<?php
//test privileges
test_privileges(0);
//set headers
$masthead_logo = MASTHEAD_ADMIN_DESIGNER_HOME;
$tpl_menubar = MENUBAR_ADMIN3;
define('PAGE_TITLE', 'Payments');

$params = 'tmr=';
$href_show = set_href(FILENAME_ADMIN_PAYMENTS, $params);
$params = 'tmr='.$teamMasterRef.'&a=s';
$href_action = set_href(FILENAME_ADMIN_PAYMENTS, $params);

$edit_season = '';
$edit_payment = 0;
$edit_status = '';
$selection = ($selection != '' ? $selection : 0);

$message = '';
if($action != ''){
	switch($action){
		case 'e':
			if($teamMasterRef > 0){
				$sql = 'SELECT season, payment, paidStatus
						FROM payments
						WHERE reference='.$selection;
				$edit_team = $db->db_query($sql);
				$edit_season = $edit_team->field['season'];
				$edit_payment = $edit_team->field['payment'];
				$edit_status = $edit_team->field['paidStatus'];
			}
			break;
		case 'd':
			$sql = 'DELETE FROM payments
					WHERE reference='.$selection;
			$message = $db->db_write($sql);
			if($message == ''){
				$params = get_all_get_params(array('p', 'se', 'a'));
				redirect(set_href(FILENAME_ADMIN_PAYMENTS, $param));
			}
			break;
		case 's':
			if($teamMasterRef > 0){
				//retrieve POST variables
				$season = $db->db_sanitize($_POST['season']);
				$payment = $db->db_sanitize($_POST['payment']);
				$status = (isset($_POST['status']) ? 'T' : 'F');
				$recordID = $_POST['recordID'];
				//validate
				if($recordID == 0){
					//test for same season
					$sql = 'SELECT t.teamRef, COUNT(p.reference) AS duplicates
							FROM teams t
							LEFT JOIN payments p
								ON t.teamMasterRef=p.teamMasterRef
								AND t.season=p.season
							WHERE t.teammasterRef='.$teamMasterRef.'
								AND t.season=\''.$season.'\'
							GROUP BY t.teamRef';
					$test = $db->db_query($sql);
					if(isset($test->result['teamRef'])){
						$teamRef = $test->field['teamRef'];
						if($test->field['duplicates'] > 0){
							$message = 'There is already a record for that season. You should edit it instead of adding a new one.';
						}
					}else{
						$message = 'No team has been created for that season.';
					}
				}
				//write to disk
				if($message == ''){
					if($recordID > 0){
						$sql_data_array = array('payment' => $payment,
												'date' => $date,
												'paidStatus' => $status,
												'modified' => 'now',
												'modifiedBy' => $_SESSION['user_id']
												);
						$param = 'reference='.$recordID;
						$message = $db->db_write_array('payments', $sql_data_array, 'update', $param);
					}else{
						$sql_data_array = array('reference' => NULL,
												'teamMasterRef' => $teamMasterRef,
												'teamRef' => $teamRef,
												'season' => $season,
												'payment' => $payment,
												'date' => date('Y-m-d'),
												'paidStatus' => $status,
												'created' => 'now',
												'modified' => 'now',
												'modifiedBy' => $_SESSION['user_id']
												);
						$message = $db->db_write_array('payments', $sql_data_array);
					}
				}
				//proceed
				if($message == ''){
					$params = get_all_get_params(array('p', 'se', 'a'));
					redirect(set_href(FILENAME_ADMIN_PAYMENTS, $params));
				}
			}else{
				$message = 'You must select a team.';
			}
			break;
	}
}

$sql = 'SELECT p.reference, p.payment, p.date, p.paidStatus,
			t.teamRef, IF(t.name!=\'\', CONCAT_WS(\' \', t.town, t.name), t.town) AS team_name, t.division, t.season, t.type
			FROM payments p
			INNER JOIN teams t
				ON p.teamRef=t.teamRef
			WHERE p.teamMasterRef='.$teamMasterRef.'
			ORDER BY season DESC';
$teams = $db->db_query($sql);
?>
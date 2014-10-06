<?php
//test privileges
test_privileges(1);
//set headers
$masthead_logo = MASTHEAD_ADMIN_TEAM_INDEX;
if($_SESSION['user_affiliation'] == 'Administrator'){
	$tpl_menubar = MENUBAR_ADMIN3;
}else{
	$tpl_menubar = MENUBAR_ADMIN2;
}
define('PAGE_TITLE', 'Teams');
define('PAGE_HEADER', 'TEAM MAINTENANCE');

$message = '';
if($action != ''){
	switch($action){
		case 'd':
			//validation
			$sql = 'SELECT DISTINCT py.paidStatus, COUNT(gm.gameRef) AS games
					FROM payments py
					RIGHT JOIN teams t
						USING(teamMasterRef)
					LEFT JOIN games gm
						ON t.teamRef=gm.usTeamRef OR t.teamRef=gm.themTeamRef
					WHERE t.teamMasterRef='.$teamMasterRef.'
					GROUP BY t.teamMasterRef';
			$test = $db->db_query($sql);
			if(isset($test->result['games'])){
				$games = $test->field['games'];
				$paid_status = $test->field['paidStatus'];
				if($_SESSION['user_tmr'] != $selection){
					if($paid_status == 'T'){
						$message = 'This team is a Laxstats subscriber. You cannot delete it.';
					}
					if($games > 0){
						$message = 'There are games associated with this team. You cannot delete it.';
					}
				}else{
					$message = 'You cannot delete your own team.';
				}
			}
			//test for active subscription
			if($message == ''){
				$message .= subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
			}
			if($message == ''){
				$sql = 'DELETE teamsMaster, teams
						FROM teamsMaster
						LEFT JOIN teams
							ON teamsMaster.teamMasterRef=teams.teamMasterRef
						WHERE teamsMaster.teamMasterRef='.$teamMasterRef;
				$message = $db->db_write($sql);
			}
			//proceed
			if($message == ''){
				$param = 'tmr='.$_SESSION['user_tmr'].'&sn='.$state;
				redirect(set_href(FILENAME_ADMIN_TEAM_INDEX, $param));
			}
			break;
	}
}
if($state != ''){
	$sql = 'SELECT tm.teamMasterRef, tm.teamName, tm.town, tm.conference, tm.league, tm.division, tm.type, tm.gender, tm.password, py.paidStatus
			FROM teamsMaster tm
			LEFT JOIN payments py
				USING(teamMasterRef)
			WHERE tm.state=\''.$state.'\'
			GROUP BY tm.teamMasterRef
			ORDER BY tm.conference, tm.type, tm.town';
	$teams = $db->db_query($sql);
}
?>
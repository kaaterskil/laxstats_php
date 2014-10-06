<?php
//test privileges
test_privileges(1);
//set headers
$masthead_logo = MASTHEAD_ADMIN_ROSTER;
$tpl_menubar = MENUBAR_ADMIN2;
define('PAGE_TITLE', 'Roster');

$staffRef = 0;
$staff_name = '';
$telephone = '';
$extension = '';
$telephone2 = '';
$email = '';
$type = 0;
$playerRef = ($playerRef > 0 ? $playerRef : 0);
$playerMasterRef = ($playerMasterRef > 0 ? $playerMasterRef : 0);
$first_name = '';
$last_name = '';
$jerseyNo = 0;
$captain = '';
$position ='';
$class = '';
$height = '';
$weight = '';
$hand = '';
$player_telephone = '';
$player_email = '';

$params					= 'tmr='.$teamMasterRef.'&tr='.$teamRef.'&nmh=1';
$href_edit_team			= set_href(FILENAME_ADMIN_SEASON, $params);
$params					= 'tmr='.$teamMasterRef.'&tr='.$teamRef.'&sr=0&nmh=1';
$href_new_staff			= set_href(FILENAME_ADMIN_STAFF, $params);
$params					= 'tmr='.$teamMasterRef.'&tr='.$teamRef.'&pr=0&nmh=1&ct=0';
$href_new_player		= set_href(FILENAME_ADMIN_PLAYER_NEW, $params);
$params					= 'tmr='.$teamMasterRef.'&tr='.$teamRef.'&a=sp';
$href_action_return		= set_href(FILENAME_ADMIN_ROSTER, $params);

$staff_message = '';
$player_message = '';
if($action != ''){
	switch($action){
		//delete staff
		case 'ds':
			$staffRef = (isset($_GET['sr']) ? $_GET['sr'] : 0);
			if($staffRef > 0){
				$sql = 'DELETE FROM officials
						WHERE reference='.$staffRef;
				$staff_message = $db->db_write($sql);
			}
			if($staff_message == ''){
				$params = 'tmr='.$teamMasterRef.'&tr='.$teamRef;
				redirect(set_href(FILENAME_ADMIN_ROSTER, $params));
			}
			break;
		//delete player
		case 'dp':
			//1. test if this is the only player instance
			$sql = 'SELECT COUNT(p.reference) AS seasons
					FROM players p
					INNER JOIN playerMaster pm
						ON p.playerMasterRef=pm.reference
					WHERE pm.reference='.$playerMasterRef;
			$test = $db->db_query($sql);
			$seasons = $test->field['seasons'];
			//delete roster record
			$sql = 'DELETE FROM players
					WHERE playerMasterRef='.$playerMasterRef.'
						AND teamRef='.$teamRef;
			$player_message = $db->db_write($sql);
			//delete master record
			if($seasons <= 1){
				$sql = 'DELETE FROM playerMaster
						WHERE reference='.$playerMasterRef;
				$player_message .= $db->db_write($sql);
			}
			//proceed
			if($player_message == ''){
				$params = 'tmr='.$teamMasterRef.'&tr='.$teamRef;
				redirect(set_href(FILENAME_ADMIN_ROSTER, $params));
			}
			break;
		//add returning player
		case 'sp':
			//get POST variable
			$playerRef = (isset($_POST['playerRef']) ? intval($_POST['playerRef']) : 0);
			//test for active subscription
			$message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
			//validate
			if($message == ''){
				if($playerRef == 0){
					$player_message = 'Please select a returning player from the drop-down menu.';
				}else{
					//validate
					$sql = 'SELECT COUNT(p2.reference) AS duplicates
							FROM players p1
							INNER JOIN players p2
								USING(playerMasterRef)
							WHERE p1.reference='.$playerRef.'
								AND p2.teamRef='.$teamRef;
					$test = $db->db_query($sql);
					$duplicates = $test->field['duplicates'];
					if($duplicates > 0){
						$player_message = 'That player is already on the roster.';
					}
				}
			}
			//write to disk
			if($player_message == ''){
				$sql = 'SELECT playerMasterRef, jerseyNo, LName, FName, position, class, height, weight
						FROM players
						WHERE reference='.$playerRef;
				$player = $db->db_query($sql);
				$sql_data_array = array('reference'			=> NULL,
										'playerMasterRef'	=> $player->field['playerMasterRef'],
										'teamRef'			=> $teamRef,
										'jerseyNo'			=> $player->field['jerseyNo'],
										'LName'				=> addslashes($player->field['LName']),
										'FName'				=> addslashes($player->field['FName']),
										'position'			=> $player->field['position'],
										'class'				=> $player->field['class'],
										'height'			=> $player->field['height'],
										'weight'			=> $player->field['weight'],
										'modifiedBy'		=> $_SESSION['user_id'],
										'created'			=> 'now',
										'modified'			=> 'now'
										);
				$player_message = $db->db_write_array('players', $sql_data_array);
			}
			//proceed
			if($player_message == ''){
				$params = 'tmr='.$teamMasterRef.'&tr='.$teamRef;
				redirect(set_href(FILENAME_ADMIN_ROSTER, $params));
			}
			break;
	}
}

//get team
$sql = 'SELECT tm.teamMasterRef, tm.town, tm.teamName, tm.gender, tm.type, tm.conference, tm.league, tm.shortName,
			t.division, t.season
		FROM teams t
		INNER JOIN teamsMaster tm
			USING(teamMasterRef)
		WHERE t.teamRef='.$teamRef;
$team = $db->db_query($sql);
if(isset($team->result['teamMasterRef'])){
	//get data
	$town			= $team->field['town'];
	$name			= $team->field['teamName'];
	$gender			= $team->field['gender'];
	$type			= $team->field['type'];
	$conference		= $team->field['conference'];
	$league			= $team->field['league'];
	$short_name		= $team->field['shortName'];
	$division		= $team->field['division'];
	$season			= $team->field['season'];
	//process data
	$letter			= set_team_letter($type);
	$season			= ($season != '' ? $season : date('Y'));
	$prior_year		= intval($season) - 1;
	$team_name		= set_team_name($town, $name);
	$page_header	= strtoupper($season.' '.$team_name);
	define('PAGE_HEADER', $page_header.'<br>ROSTER MAINTENANCE');
}
//get staff
$sql = 'SELECT reference, name, phone, phoneExt, phone2, email, type
		FROM officials
		WHERE teamRef='.$teamRef.'
		ORDER BY type';
$staff = $db->db_query($sql);
//get players
$sql = 'SELECT pm.dominantHand, pm.homePhone, pm.email, pm.FName, pm.LName,
			p.reference, p.playerMasterRef, p.jerseyNo, p.captain, p.position, p.class, p.height, p.weight
		FROM players p
		INNER JOIN playerMaster pm
			ON pm.reference=p.playerMasterRef
		WHERE p.teamRef='.$teamRef.'
		ORDER BY p.jerseyNo';
$roster = $db->db_query($sql);
?>
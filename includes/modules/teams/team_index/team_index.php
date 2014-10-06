	<!-- BOF HEADER -->
	<div id="pageTitle">
		<div class="header">TEAM INDEX</div>
		<div class="subheader"><i>Want news and late breaking information about your team? Sign up <a href="<?php echo $href_fans; ?>">here</a>.</i></div>
		<div class="subheader" style="padding-right:140px; float:right; z-index:1; "><a href="<?php echo $href_team_ranking; ?>">Team Game High Scores</a></div>
	</div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div class="body_container">
		<table cellspacing="0" cellpadding="0" border="0" width="560">
<?php
$state_test = '';
$conf_test = '';
$tmr_test = 0;
$row = 0;
while(!$teams->eof){
	//get team data
	$state = $teams->field['state'];
	$teamMasterRef = $teams->field['teamMasterRef'];
	$teamRef = $teams->field['teamRef'];
	$season = $teams->field['season'];
	$conference = $teams->field['conference'];
	$town = $teams->field['town'];
	$name = $teams->field['name'];
	$password = $teams->field['password'];
	$games = $teams->field['games'];
	$paidStatus = $teams->field['paidStatus'];
	//process data
	$team_name = set_team_name($town, $name);
	$print_test = ($games > 0 || $paidStatus == 'T' ? true : false);
	//set links
	$param = 's='.$current_year.'&c='.$conference;
	$href_conference = set_href(FILENAME_CONFERENCE_RANKING, $param);
	$param = 'tmr='.$teamMasterRef;
	$href_corner = set_href(FILENAME_CORNER_HOME, $param);
	$param = 'tmr='.$teamMasterRef.'&tr='.$teamRef.'&s='.$season;
	$href_stats = set_href(FILENAME_TEAM_STATS, $param).'&ty=F';
	$href_schedule = set_href(FILENAME_TEAM_SCHEDULE, $param);
	$href_roster = set_href(FILENAME_TEAM_ROSTER, $param);
	$href_photos = set_href(FILENAME_TEAM_PHOTOS, $param).'&se=All';
	//print data
	if($print_test){
		if($teamMasterRef != $tmr_test){
			$tmr_test = $teamMasterRef;
			//print state header
			if($state != $state_test){
				$state_test = $state;
?>
		<tr><td colspan="8" height="20" class="divider2"></td></tr>
		<tr><td colspan="8" class="conference"><?php echo $state; ?> Teams</td></tr>
		<tr><td colspan="8" height="1" class="divider"></td></tr>
<?php
			}
			//print conference header
			if($conference != $conf_test){
				$conf_test = $conference;
				$row = 0;
?>
		<tr><td colspan="8" class="division">
			<div style="font-style:italic; float:right;"><a href="<?php echo $href_conference; ?>">Conference Standings</a></div>
			<div><?php echo $conference; ?></div>
		</td></tr>
<?php
			}
			//print detail
			$background = set_background($row);
			$row++;
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="193" class="chartL"><?php echo $team_name; ?></td>
<?php
				if($password != ''){
?>
			<td width="94" class="chartC"><a href="#" onClick="enterPassword('<?php echo $href_corner; ?>');">Coach's Corner</a></td>
<?php
				}else{
?>
			<td width="94" class="chartC"><a href="<?php echo $href_corner; ?>">Coach's Corner</a></td>
<?php
				}
?>
			<td width="64" class="chartC"><a href="<?php echo $href_stats; ?>">Statistics</a></td>
			<td width="64" class="chartC"><a href="<?php echo $href_schedule; ?>">Schedule</a></td>
			<td width="54" class="chartC"><a href="<?php echo $href_roster; ?>">Roster</a></td>
			<td width="53" class="chartC"><a href="<?php echo $href_photos; ?>">Photos</a></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
		}
	}
	$teams->move_next();
}
?>
		</table>
	</div>
	<!-- EOF BODY -->

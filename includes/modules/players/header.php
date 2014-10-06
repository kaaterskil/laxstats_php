<?php
$current_year = date('Y');

$headline = get_player_headline($playerMasterRef);
if($season != ''){
	while(!$headline->eof){
		if($headline->field['season'] == $season){
			$town			= $headline->field['town'];
			$team_name		= $headline->field['name'];
			$teamRef		= $headline->field['teamRef'];
			$teamMasterRef	= $headline->field['teamMasterRef'];
			$playerRef		= $headline->field['reference'];
			$jerseyNo		= $headline->field['jerseyNo'];
			$pos			= $headline->field['position'];
			$FName			= $headline->field['FName'];
			$LName			= $headline->field['LName'];
			$dob			= $headline->field['birthdate'];
			$height			= ($headline->field['height'] != '' ? $headline->field['height'] : 'n/a');
			$weight			= ($headline->field['weight'] != '' ? $headline->field['weight'] : 'n/a');
			$class			= ($headline->field['class'] != '' ? $headline->field['class'] : 'n/a');
			$photo			= $headline->field['photo'];
			$college		= $headline->field['collegeName'];
			$college_link	= $headline->field['collegeLink'];
			break;
		}
		$headline->move_next();
	}
}else{
	$season			= $headline->field['season'];
	$town			= $headline->field['town'];
	$team_name		= $headline->field['name'];
	$teamRef		= $headline->field['teamRef'];
	$teamMasterRef	= $headline->field['teamMasterRef'];
	$playerRef		= $headline->field['reference'];
	$jerseyNo		= $headline->field['jerseyNo'];
	$pos			= $headline->field['position'];
	$FName			= $headline->field['FName'];
	$LName			= $headline->field['LName'];
	$dob			= $headline->field['birthdate'];
	$height			= ($headline->field['height'] != '' ? $headline->field['height'] : 'n/a');
	$weight			= ($headline->field['weight'] != '' ? $headline->field['weight'] : 'n/a');
	$class			= ($headline->field['class'] != '' ? $headline->field['class'] : 'n/a');
	$photo			= $headline->field['photo'];
	$college		= $headline->field['collegeName'];
	$college_link	= $headline->field['collegeLink'];
}

$player = set_player_name($FName, $LName);
$team = set_team_name($town, $team_name);
if($college != '' && $college != NULL){
	if($college_link != ''){
		$college_href = '<a href="'.$college_link.'">'.$college.'</a>';
	}else{
		$college_href = $college;
	}
}else{
	$college_href = '';
}
if($dob == '0000-00-00'){
	$birthdate = 'n/a';
	$age = 'n/a';
}else{
	$dob_time = strtotime($dob);
	$birthdate = date('F j, Y', $dob_time);
	$now = time();
	$age = date('Y', $now - $dob_time) - 1970;
}
$photo_test = ($photo != '' ? true : false);
$position = get_position($pos);

$params = 'pmr='.$playerMasterRef;
$href1 = set_href(FILENAME_PLAYER_SUMMARY, $params);
$href2 = set_href(FILENAME_PLAYER_STATS, $params);
$href3 = set_href(FILENAME_PLAYER_GAME_LOG, $params).'&s='.$season;
$href4 = set_href(FILENAME_PLAYER_SPLITS, $params).'&s='.$season;
$link1 = ($page_ref == FILENAME_PLAYER_SUMMARY ? 'Summary' : '<a href="'.$href1.'">Summary</a>');
$link2 = ($page_ref == FILENAME_PLAYER_STATS ? 'Statistics' : '<a href="'.$href2.'">Statistics</a>');
$link3 = ($page_ref == FILENAME_PLAYER_GAME_LOG ? 'Game Log' : '<a href="'.$href3.'">Game Log</a>');
$link4 = ($page_ref == FILENAME_PLAYER_SPLITS ? 'Splits' : '<a href="'.$href4.'">Splits</a>');

$page_title = '#'.$jerseyNo.' '.strtoupper($player).'<br>'.strtoupper($team).' | '.strtoupper($position);
?>

	<!-- BOF HEADER -->
	<div id="pageTitle">
		<div class="header" style=" float:left; "><?php echo $page_title; ?></div>
		<div style=" text-align:right; padding: 15px 20px 0px 0px; ">
		<?php
		draw_player_select($teamRef, $playerMasterRef, $page_ref);
		?>
		</div>

		<!-- bof team links -->
		<div class="subheader" style="clear:both; ">
			<?php
			$params = 'tmr='.$teamMasterRef.'&tr='.$teamRef.'&s='.$season;
			$href1 = set_href(FILENAME_TEAM_STATS, $params).'&ty=F';
			$href2 = set_href(FILENAME_TEAM_SCHEDULE, $params);
			$href3 = set_href(FILENAME_TEAM_ROSTER, $params);
			?>
			<a href="<?php echo $href1; ?>">Team Statistics</a> | 
			<a href="<?php echo $href2; ?>">Team Schedule</a> | 
			<a href="<?php echo $href3; ?>">Team Roster</a>
			<?php
			if($page_ref == FILENAME_PLAYER_GAME_LOG || $page_ref == FILENAME_PLAYER_SPLITS){
				draw_player_season_select($headline->result['season'], $playerMasterRef, $season, $page_ref);
			}
			?>
		</div>
		<!-- eof team links -->
	</div>
	
	<div class="player_header_container">
		<!-- bof personal information -->
<?php
		if($college != '' && $college != NULL){
?>
		<table border="0" cellspacing="0" cellpadding="0" width="700">
		<tr valign="top">
			<td width="80">
<?php
		if($photo_test && $age > 18){
			$photo_href = '../loadHeadshot.php?ref='.$playerMasterRef;
?>
		<span style="padding:5px 10px 0px 0px;"><?php echo draw_image($photo_href, 65, 90, 'photo', 1); ?></span>
<?php
		}
?>
			</td>
			<td width="620">
				<table border="0" cellspacing="0" cellpadding="0" width="620">
				<tr>
					<td width="194" class="chartL3"><b>Name: </b><?php echo $player; ?></td>
					<td width="194" class="chartL3"><b>Age (as of today): </b><?php echo $age; ?></td>
					<td width="214" class="chartL3"><b>College: </b><?php echo $college_href; ?></td>
				</tr>
				<tr>
					<td class="chartL3"><b>Height: </b><?php echo $height; ?></td>
					<td colspan="2" class="chartL3"><b>Class: </b><?php echo $class; ?></td>
				</tr>
				<tr>
					<td class="chartL3"><b>Weight: </b><?php echo $weight; ?></td>
					<td colspan="2" class="chartL3"><b>Position: </b><?php echo $position; ?></td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
<?php
		}else{
?>
		<table border="0" cellspacing="0" cellpadding="0" width="480">
		<tr valign="top">
			<td width="80">
<?php
		if($photo_test && $age > 18){
			$photo_href = '../loadHeadshot.php?ref='.$playerMasterRef;
?>
		<span style="padding:5px 10px 0px 0px;"><?php echo draw_image($photo_href, 65, 90, 'photo', 1); ?></span>
<?php
		}
?>
			</td>
			<td width="400">
				<table border="0" cellspacing="0" cellpadding="0" width="400">
				<tr>
					<td width="194" class=""><b>Name: </b><?php echo $player; ?></td>
					<td width="194" class=""><b>Age (as of today): </b><?php echo $age; ?></td>
				</tr>
				<tr>
					<td class=""><b>Height: </b><?php echo $height; ?></td>
					<td class=""><b>Class: </b><?php echo $class?></td>
				</tr>
				<tr>
					<td class=""><b>Weight: </b><?php echo $weight; ?></td>
					<td class=""><b>Position: </b><?php echo $position; ?></td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
<?php
		}
?>
		<!-- eof personal information -->
		
		<!-- bof player links -->
		<table border="0" cellspacing="0" cellpadding="0" width="700">
		<tr>
			<td width="190" class="subheader2"><?php echo $link1; ?></td>
			<td width="190" class="subheader2"><?php echo $link2; ?></td>
			<td width="190" class="subheader2"><?php echo $link3; ?></td>
			<td width="190" class="subheader2"><?php echo $link4; ?></td>
		</tr>
		</table>
		<!-- eof player links -->
	</div>
	<!-- EOF HEADER -->

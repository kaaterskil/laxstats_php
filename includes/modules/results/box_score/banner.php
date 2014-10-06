<?php
$game = get_box_score_game($gameRef);
$season = $game->field['season'];
$seasonType = $game->field['seasonType'];
$date = $game->field['date'];
$time = $game->field['time'];
$usTeamRef = $game->field['usTeamRef'];
$themTeamRef = $game->field['themTeamRef'];
$fieldRef = $game->field['fieldRef'];
$conditions = $game->field['conditions'];
$scorekeeper = $game->field['scorekeeper'];
$timekeeper = $game->field['timekeeper'];
$referee = $game->field['referee'];
$umpire = $game->field['umpire'];
$fieldJudge = $game->field['fieldJudge'];
$conference = $game->field['conference'];
$us_town = $game->field['us_town'];
$us_name = $game->field['us_name'];
$us_short_name = strtoupper($game->field['us_short_name']);
$them_town = $game->field['them_town'];
$them_name = $game->field['them_name'];
$them_short_name = strtoupper($game->field['them_short_name']);
$us_q1 = $game->field['us_q1'];
$us_q2 = $game->field['us_q2'];
$us_q3 = $game->field['us_q3'];
$us_q4 = $game->field['us_q4'];
$us_ot = ($game->field['us_ot'] > 0 ? $game->field['us_ot'] : '-');
$us_score = $game->field['us_score'];
$them_q1 = $game->field['them_q1'];
$them_q2 = $game->field['them_q2'];
$them_q3 = $game->field['them_q3'];
$them_q4 = $game->field['them_q4'];
$them_ot = ($game->field['them_ot'] > 0 ? $game->field['them_ot'] : '-');
$them_score = $game->field['them_score'];
$field = $game->field['field'];
$field_name = $game->field['field_name'];

//1b. process data
$us_team = set_team_name($us_town, $us_name);
$them_team = set_team_name($them_town, $them_name);
$field_name = set_team_name($field, $field_name);
$timestamp = strtotime($date) + $time;
$date_str = date('D F j, Y', $timestamp);
$time_str = date('g:i a', $timestamp);

//1c. test for home / visitor
if($us_town == $field){
	$home_teamRef = $usTeamRef;
	$home_town = $us_town;
	$home_team = $us_team;
	$home_abbrev = $us_short_name;
	$home_goals_q1 = $us_q1;
	$home_goals_q2 = $us_q2;
	$home_goals_q3 = $us_q3;
	$home_goals_q4 = $us_q4;
	$home_goals_ot = $us_ot;
	$home_score = $us_score;
	
	$visitor_teamRef = $themTeamRef;
	$visitor_town = $them_town;
	$visitor_team = $them_team;
	$visitor_abbrev = $them_short_name;
	$visitor_goals_q1 = $them_q1;
	$visitor_goals_q2 = $them_q2;
	$visitor_goals_q3 = $them_q3;
	$visitor_goals_q4 = $them_q4;
	$visitor_goals_ot = $them_ot;
	$visitor_score = $them_score;
}else{
	$home_teamRef = $themTeamRef;
	$home_town = $them_town;
	$home_team = $them_team;
	$home_abbrev = $them_short_name;
	$home_goals_q1 = $them_q1;
	$home_goals_q2 = $them_q2;
	$home_goals_q3 = $them_q3;
	$home_goals_q4 = $them_q4;
	$home_goals_ot = $them_ot;
	$home_score = $them_score;
	
	$visitor_teamRef = $usTeamRef;
	$visitor_town = $us_town;
	$visitor_team = $us_team;
	$visitor_abbrev = $us_short_name;
	$visitor_goals_q1 = $us_q1;
	$visitor_goals_q2 = $us_q2;
	$visitor_goals_q3 = $us_q3;
	$visitor_goals_q4 = $us_q4;
	$visitor_goals_ot = $us_ot;
	$visitor_score = $us_score;
}
$home_record = get_team_record_results($home_teamRef, $date);
$visitor_record = get_team_record_results($visitor_teamRef, $date);
?>
	<!-- BOF HEADER -->
	<div class="header_container">
		<table border="0" cellspacing="0" cellpadding="0" width="750">
		<tr>
			<td width="180" class="team_name"><?php echo $visitor_team; ?></td>
			<td rowspan="2" width="1" class="divider"></td>
			<td rowspan="2" width="20" class="divider2"></td>
			<td rowspan="2" width="348">
				<table border="0" cellspacing="0" cellpadding="0" width="348">
				<tr>
					<td width="228"></td>
					<td width="20" class="header_goals">1</td>
					<td width="20" class="header_goals">2</td>
					<td width="20" class="header_goals">3</td>
					<td width="20" class="header_goals">4</td>
					<td width="20" class="header_goals">OT</td>
					<td width="20" class="header_goals"><b>F</b></td>
				</tr>
				<tr><td colspan="7" height="1" class="divider"></td></tr>
				<tr>
					<td width="228"><?php echo $home_team.$home_record; ?></td>
					<td width="20" class="header_goals"><?php echo $home_goals_q1; ?></td>
					<td width="20" class="header_goals"><?php echo $home_goals_q2; ?></td>
					<td width="20" class="header_goals"><?php echo $home_goals_q3; ?></td>
					<td width="20" class="header_goals"><?php echo $home_goals_q4; ?></td>
					<td width="20" class="header_goals"><?php echo $home_goals_ot; ?></td>
					<td width="20" class="header_goals"><b><?php echo $home_score; ?></b></td>
				</tr>
				<tr>
					<td width="228"><?php echo $visitor_team.$visitor_record; ?></td>
					<td width="20" class="header_goals"><?php echo $visitor_goals_q1; ?></td>
					<td width="20" class="header_goals"><?php echo $visitor_goals_q2; ?></td>
					<td width="20" class="header_goals"><?php echo $visitor_goals_q3; ?></td>
					<td width="20" class="header_goals"><?php echo $visitor_goals_q4; ?></td>
					<td width="20" class="header_goals"><?php echo $visitor_goals_ot; ?></td>
					<td width="20" class="header_goals"><b><?php echo $visitor_score; ?></b></td>
				</tr>
				<tr><td colspan="7" height="1" class="divider"></td></tr>
				<tr><td colspan="7" class="header_place"><?php echo $date_str.', '.$time_str.' - '.$field_name; ?></td></tr>
				</table>
			</td>
			<td rowspan="2" width="20" class="divider2"></td>
			<td rowspan="2" width="1" class="divider"></td>
			<td width="180" class="team_name"><?php echo $home_team; ?></td>
		</tr>
		<tr>
			<td width="180" class="team_score"><?php echo $visitor_score; ?></td>
			<td width="180" class="team_score"><?php echo $home_score; ?></td>
		</tr>
		<tr><td colspan="7" height="5" class="divider2"></td></tr>
		<tr><td colspan="7" height="1" class="divider"></td></tr>
		</table>
	</div>
	<!-- EOF HEADER -->

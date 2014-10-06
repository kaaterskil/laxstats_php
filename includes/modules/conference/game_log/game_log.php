	<!-- BOF HEADER -->
	<div id="pageTitle">
		<div class="team_select">
			<div class="right_menu"><?php draw_conference_team_select($conference, $season, $town, $page_ref); ?></div>
			<div class="right_menu"><?php draw_conference_season_select($conference, $season, $page_ref); ?></div>
			<div class="right_menu"><a href="<?php echo $href_conference; ?>">Back to Conference Standings</a></div>
		</div>
		<div class="header"><?php echo $header_title; ?></div>
		<div class="subheader"><?php echo $team_data; ?></div>
		<div class="subheader">Score data courtesy of <a href="http://www.laxpower.com">LaxPower.com</a></div>
	</div>
	<!-- EOF HEADER -->

	<!-- BOF BODY -->
	<div class="body_container">
		<table border="0" cellspacing="0" cellpadding="0" width="720">
		<tr><td colspan="21" class="chartTitleC">GAME LOG</td></tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="47" class="chartHeaderC">Date</td>
			<td width="1" class="divider"></td>
			<td width="168" class="chartHeaderC">Opponent</td>
			<td width="1" class="divider"></td>
			<td width="83" class="chartHeaderC">Conf</td>
			<td width="1" class="divider"></td>
			<td width="133" class="chartHeaderC">League</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">Div</td>
			<td width="1" class="divider"></td>
			<td colspan="3" class="chartHeaderC">Score</td>
			<td width="1" class="divider"></td>
			<td width="38" class="chartHeaderC">Conf</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">League</td>
			<td width="1" class="divider"></td>
			<td width="38" class="chartHeaderC">Div</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
$wins = 0;
$losses = 0;
$conference_wins = 0;
$conference_losses = 0;
$league_wins = 0;
$league_losses = 0;
$division_wins = 0;
$division_losses = 0;
$row = 0;
while(!$games->eof){
	//get data
	$date				= $games->field['date'];
	$versus				= $games->field['versus'];
	$them_tmr			= $games->field['them_tmr'];
	$opponent			= $games->field['opponent'];
	$them_conference	= $games->field['them_conference'];
	$them_league		= $games->field['them_league'];
	$them_division		= $games->field['them_division'];
	$them_dt			= $games->field['them_dt'];
	$us_score			= $games->field['us_score'];
	$them_score			= $games->field['them_score'];
	$them_record = get_team_conference_record($them_tmr, $date);
	//process data
	$game_date		= date('M d', strtotime($date));
	$versus			= ($versus != '' ? $versus.' ' : '');
	$win_label		= ($us_score > $them_score ? 'W' : '');
	$loss_label		= ($us_score >= $them_score ? '' : 'L');
	$score			= $us_score.'-'.$them_score;
	$them_division	= ($them_dt != '' && $them_dt != $them_division ? $them_dt : $them_division);
	$background		= set_background($row);
	//set links
	$params = get_all_get_params(array('p', 'tmr')).'&tmr='.$them_tmr;
	$href = set_href(FILENAME_CONFERENCE_GAME_LOG, $params);
	
	$conference_test	= ($conference == $them_conference ? true : false);
	$league_test		= ($league == $them_league ? true : false);
	$division_test		= ($division == $them_division ? true : false);
	$conference_label	= ($conference_test ? '&radic;' : '');
	$league_label		= ($league_test ? '&radic;' : '');
	$division_label		= ($division_test ? '&radic;' : '');
	
	//update totals
	if($us_score > $them_score){
		$wins++;
		if($conference_test){
			$conference_wins++;
		}
		if($league_test){
			$league_wins++;
		}
		if($division_test){
			$division_wins++;
		}
	}elseif($them_score > $us_score){
		$losses++;
		if($conference_test){
			$conference_losses++;
		}
		if($league_test){
			$league_losses++;
		}
		if($division_test){
			$division_losses++;
		}
	}
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="47" class="chartL"><?php echo $game_date; ?></td>
			<td width="1" class="divider"></td>
			<td width="168" class="chartL"><?php echo $versus; ?><a href="<?php echo $href; ?>"><?php echo $opponent; ?></a> <?php echo $them_record; ?></td>
			<td width="1" class="divider"></td>
			<td width="83" class="chartC"><?php echo $them_conference; ?></td>
			<td width="1" class="divider"></td>
			<td width="133" class="chartC"><?php echo $them_league; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><?php echo $them_division; ?></td>
			<td width="1" class="divider"></td>
			<td width="14" class="chartC"><?php echo $win_label; ?></td>
			<td width="34" class="chartC"><?php echo $score; ?></td>
			<td width="13" class="chartC"><?php echo $loss_label; ?></td>
			<td width="1" class="divider"></td>
			<td width="38" class="chartC"><?php echo $conference_label; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><?php echo $league_label; ?></td>
			<td width="1" class="divider"></td>
			<td width="38" class="chartC"><?php echo $division_label; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
	$row++;
	$games->move_next();
}
$overall_record		= $wins.'-'.$losses;
$conference_record	= $conference_wins.'-'.$conference_losses;
$league_record		= $league_wins.'-'.$league_losses;
$division_record	= $division_wins.'-'.$division_losses;
?>
		<tr>
			<td width="1" class="divider"></td>
			<td colspan="13" class="chartL"><b>Overall Record (<?php echo $overall_record; ?>):</b></td>
			<td width="1" class="divider"></td>
			<td width="38" class="chartC"><b><?php echo $conference_record; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><b><?php echo $league_record; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="38" class="chartC"><b><?php echo $division_record; ?></b></td>
			<td width="1" class="divider"></td>
		<tr>
		</table>
	</div>
	<!-- EOF BODY -->

<?php
$team_stats = array();
for($i = 0; $i < 2; $i++){
	$teamRef = ($i == 0 ? $visitor_teamRef : $home_teamRef);
	$param = 'g.gameRef='.$gameRef.' AND p.teamRef='.$teamRef;
	//get scoring data
	$scoring = get_team_goals_summary($param);
	$tot_goals = $scoring->field['tot_goals'];
	$goals_q1 = $scoring->field['goals_q1'];
	$goals_q2 = $scoring->field['goals_q2'];
	$goals_q3 = $scoring->field['goals_q3'];
	$goals_q4 = $scoring->field['goals_q4'];
	$goals_ot = $scoring->field['goals_ot'];
	$unassisted = $scoring->field['unassisted'];
	$assisted = $scoring->field['assisted'];
	$man_up = $scoring->field['man_up'];
	$man_down = $scoring->field['man_down'];
	//get man-up opportunities
	$opportunities = get_manUp_opps_summary($param);
	//get play data
	$plays = get_team_plays_summary($param);
	$shots_q1 = $plays->field['shots_q1'];
	$shots_q2 = $plays->field['shots_q2'];
	$shots_q3 = $plays->field['shots_q3'];
	$shots_q4 = $plays->field['shots_q4'];
	$shots_ot = $plays->field['shots_ot'];
	$tot_shots = $plays->field['tot_shots'];
	$gb_q1 = $plays->field['gb_q1'];
	$gb_q2 = $plays->field['gb_q2'];
	$gb_q3 = $plays->field['gb_q3'];
	$gb_q4 = $plays->field['gb_q4'];
	$gb_ot = ($plays->field['gb_ot'] > 0 ? $plays->field['gb_ot'] : '-');
	$gb = $plays->field['gb'];
	$shotPct = ($tot_shots > 0 ? number_format($tot_goals / $tot_shots, 3) : '0.000');
	//get faceoff data
	$faceoffs = get_team_faceoffs_summary($param);
	$won_q1 = $faceoffs->field['won_q1'];
	$won_q2 = $faceoffs->field['won_q2'];
	$won_q3 = $faceoffs->field['won_q3'];
	$won_q4 = $faceoffs->field['won_q4'];
	$won_ot = $faceoffs->field['won_ot'];
	$lost_q1 = $faceoffs->field['lost_q1'];
	$lost_q2 = $faceoffs->field['lost_q2'];
	$lost_q3 = $faceoffs->field['lost_q3'];
	$lost_q4 = $faceoffs->field['lost_q4'];
	$lost_ot = $faceoffs->field['lost_ot'];
	$fo_q1 = $won_q1.'-'.$lost_q1;
	$fo_q2 =  $won_q2.'-'.$lost_q2;
	$fo_q3 =  $won_q3.'-'.$lost_q3;
	$fo_q4 =  $won_q4.'-'.$lost_q4;
	$fo_ot = ($won_ot + $lost_ot > 0 ? $won_ot.'-'.$lost_ot : '-');
	$fo_won = $faceoffs->field['won'];
	$fo_lost = $faceoffs->field['lost'];
	$total_fo = $fo_won + $fo_lost;
	$foPct = ($total_fo > 0 ? number_format($fo_won / $total_fo, 3) : '0.000');
	//get clear data
	$clears = get_team_clears_summary($param);
	$cleared_q1 = $clears->field['cleared_q1'];
	$cleared_q2 = $clears->field['cleared_q2'];
	$cleared_q3 = $clears->field['cleared_q3'];
	$cleared_q4 = $clears->field['cleared_q4'];
	$cleared_ot = $clears->field['cleared_ot'];
	$failed_q1 = $clears->field['failed_q1'];
	$failed_q2 = $clears->field['failed_q2'];
	$failed_q3 = $clears->field['failed_q3'];
	$failed_q4 = $clears->field['failed_q4'];
	$failed_ot = $clears->field['failed_ot'];
	$cl_q1 = $cleared_q1.'-'.$failed_q1;
	$cl_q2 = $cleared_q2.'-'.$failed_q2;
	$cl_q3 = $cleared_q3.'-'.$failed_q3;
	$cl_q4 = $cleared_q4.'-'.$failed_q4;
	$cl_ot = ($cleared_ot + $failed_ot > 0 ? $cleared_ot.'-'.$failed_ot : '-');
	$cleared = $clears->field['cleared'];
	$failed = $clears->field['failed'];
	$total_clears = $cleared + $failed;
	$clearPct = ($total_clears > 0 ? number_format($cleared / $total_clears, 3) : '0.000');
	//get penalty data
	$violations = get_team_penalties_summary($param);
	$penalties = $violations->field['penalties'];
	$minutes = $violations->field['minutes'];
	//get goalie data
	$saves_obj = get_team_saves_summary($param);
	$saves_q1 = $saves_obj->field['saves_q1'];
	$saves_q2 = $saves_obj->field['saves_q2'];
	$saves_q3 = $saves_obj->field['saves_q3'];
	$saves_q4 = $saves_obj->field['saves_q4'];
	$saves_ot = $saves_obj->field['saves_ot'];
	$tot_saves = $saves_obj->field['tot_saves'];
	$ga_q1 = $saves_obj->field['ga_q1'];
	$ga_q2 = $saves_obj->field['ga_q2'];
	$ga_q3 = $saves_obj->field['ga_q3'];
	$ga_q4 = $saves_obj->field['ga_q4'];
	$ga_ot = $saves_obj->field['ga_ot'];
	$tot_ga = $saves_obj->field['tot_ga'];
	//load array
	$team_stats[$i] = array('tot_goals' => $tot_goals,
						  'goals_q1' => $goals_q1,
						  'goals_q2' => $goals_q2,
						  'goals_q3' => $goals_q3,
						  'goals_q4' => $goals_q4,
						  'goals_ot' => $goals_ot,
						  'assisted' => $assisted,
						  'unassisted' => $unassisted,
						  'man_up' => $man_up,
						  'man_down' => $man_down,
						  'opportunities' => $opportunities,
						  'shots_q1' => $shots_q1,
						  'shots_q2' => $shots_q2,
						  'shots_q3' => $shots_q3,
						  'shots_q4' => $shots_q4,
						  'shots_ot' => $shots_ot,
						  'tot_shots' => $tot_shots,
						  'shotPct' => $shotPct,
						  'gb_q1' => $gb_q1,
						  'gb_q2' => $gb_q2,
						  'gb_q3' => $gb_q3,
						  'gb_q4' => $gb_q4,
						  'gb_ot' => $gb_ot,
						  'gb' => $gb,
						  'fo_q1' => $fo_q1,
						  'fo_q2' => $fo_q2,
						  'fo_q3' => $fo_q3,
						  'fo_q4' => $fo_q4,
						  'fo_ot' => $fo_ot,
						  'fo_won' => $fo_won,
						  'fo_lost' => $fo_lost,
						  'foPct' => $foPct,
						  'cl_q1' => $cl_q1,
						  'cl_q2' => $cl_q2,
						  'cl_q3' => $cl_q3,
						  'cl_q4' => $cl_q4,
						  'cl_ot' => $cl_ot,
						  'cleared' => $cleared,
						  'failed' => $failed,
						  'clearPct' => $clearPct,
						  'saves_q1' => $saves_q1,
						  'saves_q2' => $saves_q2,
						  'saves_q3' => $saves_q3,
						  'saves_q4' => $saves_q4,
						  'saves_ot' => $saves_ot,
						  'tot_saves' => $tot_saves,
						  'ga_q1' => $ga_q1,
						  'ga_q2' => $ga_q2,
						  'ga_q3' => $ga_q3,
						  'ga_q4' => $ga_q4,
						  'ga_ot' => $ga_ot,
						  'tot_ga' => $tot_ga,
						  'penalties' => $penalties,
						  'minutes' => $minutes
						  );
}
//compute shots on goal
$team_stats[0]['sog_q1'] = $team_stats[1]['saves_q1'] + $team_stats[1]['ga_q1'];
$team_stats[0]['sog_q2'] = $team_stats[1]['saves_q2'] + $team_stats[1]['ga_q2'];
$team_stats[0]['sog_q3'] = $team_stats[1]['saves_q3'] + $team_stats[1]['ga_q3'];
$team_stats[0]['sog_q4'] = $team_stats[1]['saves_q4'] + $team_stats[1]['ga_q4'];
$team_stats[0]['sog_ot'] = $team_stats[1]['saves_ot'] + $team_stats[1]['ga_ot'];
$team_stats[0]['tot_sog'] = $team_stats[1]['tot_saves'] + $team_stats[1]['tot_ga'];
$team_stats[1]['sog_q1'] = $team_stats[0]['saves_q1'] + $team_stats[0]['ga_q1'];
$team_stats[1]['sog_q2'] = $team_stats[0]['saves_q2'] + $team_stats[0]['ga_q2'];
$team_stats[1]['sog_q3'] = $team_stats[0]['saves_q3'] + $team_stats[0]['ga_q3'];
$team_stats[1]['sog_q4'] = $team_stats[0]['saves_q4'] + $team_stats[0]['ga_q4'];
$team_stats[1]['sog_ot'] = $team_stats[0]['saves_ot'] + $team_stats[0]['ga_ot'];
$team_stats[1]['tot_sog'] = $team_stats[0]['tot_saves'] + $team_stats[0]['tot_ga'];

//compute shots off target
$team_stats[0]['off_q1'] = $team_stats[0]['shots_q1'] - $team_stats[0]['sog_q1'];
$team_stats[0]['off_q2'] = $team_stats[0]['shots_q2'] - $team_stats[0]['sog_q2'];
$team_stats[0]['off_q3'] = $team_stats[0]['shots_q3'] - $team_stats[0]['sog_q3'];
$team_stats[0]['off_q4'] = $team_stats[0]['shots_q4'] - $team_stats[0]['sog_q4'];
$team_stats[0]['off_ot'] = $team_stats[0]['shots_ot'] - $team_stats[0]['sog_ot'];
$team_stats[0]['tot_off'] = $team_stats[0]['tot_shots'] - $team_stats[0]['tot_sog'];
$team_stats[1]['off_q1'] = $team_stats[1]['shots_q1'] - $team_stats[1]['sog_q1'];
$team_stats[1]['off_q2'] = $team_stats[1]['shots_q2'] - $team_stats[1]['sog_q2'];
$team_stats[1]['off_q3'] = $team_stats[1]['shots_q3'] - $team_stats[1]['sog_q3'];
$team_stats[1]['off_q4'] = $team_stats[1]['shots_q4'] - $team_stats[1]['sog_q4'];
$team_stats[1]['off_ot'] = $team_stats[1]['shots_ot'] - $team_stats[1]['sog_ot'];
$team_stats[1]['tot_off'] = $team_stats[1]['tot_shots'] - $team_stats[1]['tot_sog'];

//compute man-up conversion percentage
$team_stats[0]['man_up_pct'] = ($team_stats[1]['opportunities'] > 0 ? number_format($team_stats[0]['man_up'] / $team_stats[1]['opportunities'], 3) : '0.000');
$team_stats[1]['man_up_pct'] = ($team_stats[0]['opportunities'] > 0 ? number_format($team_stats[1]['man_up'] / $team_stats[0]['opportunities'], 3) : '0.000');

//format overtime zeros
$team_stats[0]['goals_ot'] = ($team_stats[0]['goals_ot'] > 0 ? $team_stats[0]['goals_ot'] : '-');
$team_stats[1]['goals_ot'] = ($team_stats[1]['goals_ot'] > 0 ? $team_stats[1]['goals_ot'] : '-');
$team_stats[0]['shots_ot'] = ($team_stats[0]['shots_ot'] > 0 ? $team_stats[0]['shots_ot'] : '-');
$team_stats[1]['shots_ot'] = ($team_stats[1]['shots_ot'] > 0 ? $team_stats[1]['shots_ot'] : '-');
$team_stats[0]['saves_ot'] = ($team_stats[0]['saves_ot'] > 0 ? $team_stats[0]['saves_ot'] : '-');
$team_stats[1]['saves_ot'] = ($team_stats[1]['saves_ot'] > 0 ? $team_stats[1]['saves_ot'] : '-');
$team_stats[0]['off_ot'] = ($team_stats[0]['off_ot'] > 0 ? $team_stats[0]['off_ot'] : '-');
$team_stats[1]['off_ot'] = ($team_stats[1]['off_ot'] > 0 ? $team_stats[1]['off_ot'] : '-');
$team_stats[0]['sog_ot'] = ($team_stats[0]['sog_ot'] > 0 ? $team_stats[0]['sog_ot'] : '-');
$team_stats[1]['sog_ot'] = ($team_stats[1]['sog_ot'] > 0 ? $team_stats[1]['sog_ot'] : '-');
?>
			<!-- bof team stats -->
			<table border="0" cellspacing="0" cellpadding="0" width="360">
			<tr><td colspan="4" class="chartTitleT">Team Statistics</td></tr>
			<tr>
				<td colspan="2" class="chartHeaderL">Shot Statistics</td>
				<td width="94" class="chartHeaderR"><?php echo $visitor_abbrev; ?></td>
				<td width="94" class="chartHeaderR"><?php echo $home_abbrev; ?></td>
			</tr>
				<td width="4" class="chartL"></td>
				<td width="144" class="chartL">Goals scored:</td>
				<td width="94" class="chartR1"><?php echo $visitor_score; ?></td>
				<td width="94" class="chartR1"><?php echo $home_score; ?></td>
			</tr>
			<tr>
				<td class="chartL"></td>
				<td class="chartL">Goals-shot attempts:</td>
				<td class="chartR1"><?php echo $team_stats[0]['tot_goals'].'-'.$team_stats[0]['tot_shots']; ?></td>
				<td class="chartR1"><?php echo $team_stats[1]['tot_goals'].'-'.$team_stats[1]['tot_shots']; ?></td>
			</tr>
			<tr>
				<td class="chartL"></td>
				<td class="chartL">Shot percent:</td>
				<td class="chartR1"><?php echo $team_stats[0]['shotPct']; ?></td>
				<td class="chartR1"><?php echo $team_stats[1]['shotPct']; ?></td>
			</tr>
			<tr>
				<td class="chartL"></td>
				<td class="chartL">Assists:</td>
				<td class="chartR1"><?php echo $team_stats[0]['assisted']; ?></td>
				<td class="chartR1"><?php echo $team_stats[1]['assisted']; ?></td>
			</tr>
			<tr><td colspan="4" height="1" class="chartHeaderL">Man-Up Opportunities</td></tr>
			<tr>
				<td class="chartL"></td>
				<td class="chartL">Goals-Opportunities</td>
				<td class="chartR1"><?php echo $team_stats[0]['man_up'].'-'.$team_stats[1]['opportunities']; ?></td>
				<td class="chartR1"><?php echo $team_stats[1]['man_up'].'-'.$team_stats[0]['opportunities']; ?></td>
			</tr>
			<tr>
				<td class="chartL"></td>
				<td class="chartL">Conversion percent:</td>
				<td class="chartR1"><?php echo $team_stats[0]['man_up_pct']; ?></td>
				<td class="chartR1"><?php echo $team_stats[1]['man_up_pct']; ?></td>
			</tr>
			<tr><td colspan="4" height="1" class="chartHeaderL">Goal Breakdown</td></tr>
			<tr>
				<td class="chartL"></td>
				<td class="chartL">Total goals:</td>
				<td class="chartR1"><?php echo $visitor_score; ?></td>
				<td class="chartR1"><?php echo $home_score; ?></td>
			</tr>
			<tr>
				<td class="chartL"></td>
				<td class="chartL">Assisted:</td>
				<td class="chartR1"><?php echo $team_stats[0]['assisted']; ?></td>
				<td class="chartR1"><?php echo $team_stats[1]['assisted']; ?></td>
			</tr>
			<tr>
				<td class="chartL"></td>
				<td class="chartL">Unassisted:</td>
				<td class="chartR1"><?php echo $team_stats[0]['unassisted']; ?></td>
				<td class="chartR1"><?php echo $team_stats[1]['unassisted']; ?></td>
			</tr>
			<tr>
				<td class="chartL"></td>
				<td class="chartL">Man-up:</td>
				<td class="chartR1"><?php echo $team_stats[0]['man_up']; ?></td>
				<td class="chartR1"><?php echo $team_stats[1]['man_up']; ?></td>
			</tr>
			<tr>
				<td class="chartL"></td>
				<td class="chartL">Short-handed:</td>
				<td class="chartR1"><?php echo $team_stats[0]['man_down']; ?></td>
				<td class="chartR1"><?php echo $team_stats[1]['man_down']; ?></td>
			</tr>
			<tr>
				<td class="chartL"></td>
				<td class="chartL">Overtime:</td>
				<td class="chartR1"><?php echo $team_stats[0]['goals_ot']; ?></td>
				<td class="chartR1"><?php echo $team_stats[1]['goals_ot']; ?></td>
			</tr>
			<tr><td colspan="4" height="1" class="chartHeaderL">Ground Balls</td></tr>
			<tr>
				<td class="chartL"></td>
				<td class="chartL">Count:</td>
				<td class="chartR1"><?php echo $team_stats[0]['gb']; ?></td>
				<td class="chartR1"><?php echo $team_stats[1]['gb']; ?></td>
			</tr>
			<tr><td colspan="4" height="1" class="chartHeaderL">Faceoffs</td></tr>
			<tr>
				<td class="chartL"></td>
				<td class="chartL">Won-Loss:</td>
				<td class="chartR1"><?php echo $team_stats[0]['fo_won'].'-'.$team_stats[0]['fo_lost']; ?></td>
				<td class="chartR1"><?php echo $team_stats[1]['fo_won'].'-'.$team_stats[1]['fo_lost']; ?></td>
			</tr>
			<tr>
				<td class="chartL"></td>
				<td class="chartL">Percentage:</td>
				<td class="chartR1"><?php echo $team_stats[0]['foPct']; ?></td>
				<td class="chartR1"><?php echo $team_stats[1]['foPct']; ?></td>
			</tr>
			<tr><td colspan="4" height="1" class="chartHeaderL">Clears</td></tr>
			<tr>
				<td class="chartL"></td>
				<td class="chartL">Cleared-Failed:</td>
				<td class="chartR1"><?php echo $team_stats[0]['cleared'].'-'.$team_stats[0]['failed']; ?></td>
				<td class="chartR1"><?php echo $team_stats[1]['cleared'].'-'.$team_stats[1]['failed']; ?></td>
			</tr>
			<tr>
				<td class="chartL"></td>
				<td class="chartL">Percentage:</td>
				<td class="chartR1"><?php echo $team_stats[0]['clearPct']; ?></td>
				<td class="chartR1"><?php echo $team_stats[1]['clearPct']; ?></td>
			</tr>
			<tr><td colspan="4" height="1" class="chartHeaderL">Penalties</td></tr>
			<tr>
				<td class="chartL"></td>
				<td class="chartL">Count:</td>
				<td class="chartR1"><?php echo $team_stats[0]['penalties']; ?></td>
				<td class="chartR1"><?php echo $team_stats[1]['penalties']; ?></td>
			</tr>
			<tr>
				<td class="chartL"></td>
				<td class="chartL">Minutes:</td>
				<td class="chartR1"><?php echo $team_stats[0]['minutes']; ?></td>
				<td class="chartR1"><?php echo $team_stats[1]['minutes']; ?></td>
			</tr>
			<tr><td colspan="4" height="20" class="divider2"></td></tr>
			</table>
			<!-- eof team stats -->
			
			<!-- bof plays by period -->
			<table border="0" cellspacing="0" cellpadding="0" width="365">
			<tr><td colspan="15" height="10" class="divider2"></td></tr>
			<tr><td colspan="15" class="chartTitleT">PLAYS BY PERIOD</td></tr>
			<tr>
				<td width="1" class="divider4"></td>
				<td width="117" class="chartHeaderL">GOALS</td>
				<td width="1" class="divider"></td>
				<td width="33" class="chartHeaderC">1</td>
				<td width="1" class="divider"></td>
				<td width="33" class="chartHeaderC">2</td>
				<td width="1" class="divider"></td>
				<td width="33" class="chartHeaderC">3</td>
				<td width="1" class="divider"></td>
				<td width="33" class="chartHeaderC">4</td>
				<td width="1" class="divider"></td>
				<td width="33" class="chartHeaderC">OT</td>
				<td width="1" class="divider"></td>
				<td width="33" class="chartHeaderC"><b>T</b></td>
				<td width="1" class="divider4"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL"><?php echo $visitor_town; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['goals_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['goals_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['goals_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['goals_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['goals_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[0]['tot_goals']; ?></b></td>
				<td class="divider"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL"><?php echo $home_town; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['goals_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['goals_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['goals_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['goals_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['goals_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[1]['tot_goals']; ?></b></td>
				<td class="divider"></td>
			</tr>
			<tr><td colspan="15" height="10" class="divider2"></td></tr>
			<tr>
				<td class="divider4"></td>
				<td class="chartHeaderL">SHOTS</td>
				<td class="divider"></td>
				<td class="chartHeaderC">1</td>
				<td class="divider"></td>
				<td class="chartHeaderC">2</td>
				<td class="divider"></td>
				<td class="chartHeaderC">3</td>
				<td class="divider"></td>
				<td class="chartHeaderC">4</td>
				<td class="divider"></td>
				<td class="chartHeaderC">OT</td>
				<td class="divider"></td>
				<td class="chartHeaderC"><b>T</b></td>
				<td class="divider4"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL"><?php echo $visitor_town; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['shots_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['shots_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['shots_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['shots_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['shots_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[0]['tot_shots']; ?></b></td>
				<td class="divider"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL"><?php echo $home_town; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['shots_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['shots_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['shots_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['shots_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['shots_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[1]['tot_shots']; ?></b></td>
				<td class="divider"></td>
			</tr>
			<tr><td colspan="15" height="10" class="divider2"></td></tr>
			<tr>
				<td class="divider4"></td>
				<td class="chartHeaderL">GROUND BALLS</td>
				<td class="divider"></td>
				<td class="chartHeaderC">1</td>
				<td class="divider"></td>
				<td class="chartHeaderC">2</td>
				<td class="divider"></td>
				<td class="chartHeaderC">3</td>
				<td class="divider"></td>
				<td class="chartHeaderC">4</td>
				<td class="divider"></td>
				<td class="chartHeaderC">OT</td>
				<td class="divider"></td>
				<td class="chartHeaderC"><b>T</b></td>
				<td class="divider4"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL"><?php echo $visitor_town; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['gb_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['gb_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['gb_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['gb_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['gb_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[0]['gb']; ?></b></td>
				<td class="divider"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL"><?php echo $home_town; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['gb_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['gb_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['gb_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['gb_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['gb_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[1]['gb']; ?></b></td>
				<td class="divider"></td>
			</tr>
			<tr><td colspan="15" height="10" class="divider2"></td></tr>
			<tr>
				<td class="divider4"></td>
				<td class="chartHeaderL">SAVES</td>
				<td class="divider"></td>
				<td class="chartHeaderC">1</td>
				<td class="divider"></td>
				<td class="chartHeaderC">2</td>
				<td class="divider"></td>
				<td class="chartHeaderC">3</td>
				<td class="divider"></td>
				<td class="chartHeaderC">4</td>
				<td class="divider"></td>
				<td class="chartHeaderC">OT</td>
				<td class="divider"></td>
				<td class="chartHeaderC"><b>T</b></td>
				<td class="divider4"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL"><?php echo $visitor_town; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['saves_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['saves_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['saves_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['saves_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['saves_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[0]['tot_saves']; ?></b></td>
				<td class="divider"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL"><?php echo $home_town; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['saves_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['saves_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['saves_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['saves_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['saves_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[1]['tot_saves']; ?></b></td>
				<td class="divider"></td>
			</tr>
			<tr><td colspan="15" height="10" class="divider2"></td></tr>
			<tr>
				<td class="divider4"></td>
				<td class="chartHeaderL">FACEOFFS</td>
				<td class="divider"></td>
				<td class="chartHeaderC">1</td>
				<td class="divider"></td>
				<td class="chartHeaderC">2</td>
				<td class="divider"></td>
				<td class="chartHeaderC">3</td>
				<td class="divider"></td>
				<td class="chartHeaderC">4</td>
				<td class="divider"></td>
				<td class="chartHeaderC">OT</td>
				<td class="divider"></td>
				<td class="chartHeaderC"><b>T</b></td>
				<td class="divider4"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL"><?php echo $visitor_town; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['fo_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['fo_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['fo_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['fo_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['fo_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[0]['fo_won'].'-'.$team_stats[0]['fo_lost']; ?></b></td>
				<td class="divider"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL"><?php echo $home_town; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['fo_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['fo_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['fo_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['fo_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['fo_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[1]['fo_won'].'-'.$team_stats[1]['fo_lost']; ?></b></td>
				<td class="divider"></td>
			</tr>
			<tr><td colspan="15" height="10" class="divider2"></td></tr>
			<tr>
				<td class="divider4"></td>
				<td class="chartHeaderL">CLEARS</td>
				<td class="divider"></td>
				<td class="chartHeaderC">1</td>
				<td class="divider"></td>
				<td class="chartHeaderC">2</td>
				<td class="divider"></td>
				<td class="chartHeaderC">3</td>
				<td class="divider"></td>
				<td class="chartHeaderC">4</td>
				<td class="divider"></td>
				<td class="chartHeaderC">OT</td>
				<td class="divider"></td>
				<td class="chartHeaderC"><b>T</b></td>
				<td class="divider4"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL"><?php echo $visitor_town; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['cl_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['cl_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['cl_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['cl_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['cl_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[0]['cleared'].'-'.$team_stats[0]['failed']; ?></b></td>
				<td class="divider"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL"><?php echo $home_town; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['cl_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['cl_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['cl_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['cl_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['cl_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[1]['cleared'].'-'.$team_stats[1]['failed']; ?></b></td>
				<td class="divider"></td>
			</tr>
			</table>
			<!-- eof plays by period -->
			
			<!-- bof shot analysis -->
			<table border="0" cellspacing="0" cellpadding="0" width="365">
			<tr><td colspan="15" height="10" class="divider2"></td></tr>
			<tr><td colspan="15" class="chartTitleT">SHOT ANALYSIS</td></tr>
			<tr>
				<td width="1" class="divider4"></td>
				<td width="172" class="chartHeaderL"><?php echo $visitor_town; ?></td>
				<td width="1" class="divider"></td>
				<td width="23" class="chartHeaderC">1</td>
				<td width="1" class="divider"></td>
				<td width="23" class="chartHeaderC">2</td>
				<td width="1" class="divider"></td>
				<td width="23" class="chartHeaderC">3</td>
				<td width="1" class="divider"></td>
				<td width="23" class="chartHeaderC">4</td>
				<td width="1" class="divider"></td>
				<td width="23" class="chartHeaderC">OT</td>
				<td width="1" class="divider"></td>
				<td width="23" class="chartHeaderC"><b>T</b></td>
				<td width="1" class="divider4"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL">Shots</td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['shots_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['shots_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['shots_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['shots_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['shots_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[0]['tot_shots']; ?></b></td>
				<td class="divider"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL">Post, blocked or off target</td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['off_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['off_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['off_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['off_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['off_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[0]['tot_off']; ?></b></td>
				<td class="divider"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL">Shots on goal</td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['sog_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['sog_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['sog_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['sog_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['sog_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[0]['tot_sog']; ?></b></td>
				<td class="divider"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL">Saved by Goalkeeper</td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['saves_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['saves_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['saves_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['saves_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['saves_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[1]['tot_saves']; ?></b></td>
				<td class="divider"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL">Goals scored</td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['goals_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['goals_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['goals_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['goals_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['goals_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[0]['tot_goals']; ?></b></td>
				<td class="divider"></td>
			</tr>
			<tr>
				<td class="divider4"></td>
				<td class="chartHeaderL"><?php echo $home_town; ?></td>
				<td class="divider"></td>
				<td class="chartHeaderC">1</td>
				<td class="divider"></td>
				<td class="chartHeaderC">2</td>
				<td class="divider"></td>
				<td class="chartHeaderC">3</td>
				<td class="divider"></td>
				<td class="chartHeaderC">4</td>
				<td class="divider"></td>
				<td class="chartHeaderC">OT</td>
				<td class="divider"></td>
				<td class="chartHeaderC"><b>T</b></td>
				<td class="divider4"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL">Shots</td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['shots_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['shots_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['shots_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['shots_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['shots_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[1]['tot_shots']; ?></b></td>
				<td class="divider"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL">Post, blocked or off target</td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['off_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['off_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['off_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['off_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['off_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[1]['tot_off']; ?></b></td>
				<td class="divider"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL">Shots on goal</td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['sog_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['sog_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['sog_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['sog_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['sog_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[1]['tot_sog']; ?></b></td>
				<td class="divider"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL">Saved by Goalkeeper</td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['saves_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['saves_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['saves_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['saves_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[0]['saves_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[0]['tot_saves']; ?></b></td>
				<td class="divider"></td>
			</tr>
			<tr>
				<td class="divider"></td>
				<td class="chartL">Goals scored</td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['goals_q1']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['goals_q2']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['goals_q3']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['goals_q4']; ?></td>
				<td class="divider"></td>
				<td class="chartC1"><?php echo $team_stats[1]['goals_ot']; ?></td>
				<td class="divider"></td>
				<td class="chartC"><b><?php echo $team_stats[1]['tot_goals']; ?></b></td>
				<td class="divider"></td>
			</tr>
			</table>
			<!-- eof shot analysis -->

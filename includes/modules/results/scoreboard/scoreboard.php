<?php
require('includes/modules/results/header.php');
?>
						
	<!-- BOF BODY -->
<?php
//retrieve data
$games_obj		= get_scoreboard_games($season, $month);
$shots_obj		= get_scoreboard_shots($season, $month);
$goalies		= get_scoreboard_goalkeepers($season, $month);
$players_obj	= get_scoreboard_players($season, $month);

$row = 0;
$column = 0;
$game = 0;
$games = count($games_obj->result['gameRef']);
$rows = ceil($games / 2);
if($games > 0){
	$i = 0;
	while($i < $games){
		while($row < $rows){
			$column = 0;
			while($column < 2){
				if($game < $games){
					//1. get data
					$gameRef			= $games_obj->result['gameRef'][$i];
					$date				= $games_obj->result['date'][$i];
					$fieldRef			= $games_obj->result['fieldRef'][$i];
					$seasonType			= $games_obj->result['seasonType'][$i];
					$field				= $games_obj->result['field'][$i];
					$home_team			= $games_obj->result['home_team'][$i];
					$home_abbrev		= $games_obj->result['home_abbrev'][$i];
					$home_tr			= $games_obj->result['home_tr'][$i];
					$home_tmr			= $games_obj->result['home_tmr'][$i];
					$visitor_team		= $games_obj->result['visitor_team'][$i];
					$visitor_abbrev		= $games_obj->result['visitor_abbrev'][$i];
					$visitor_tr			= $games_obj->result['visitor_tr'][$i];
					$visitor_tmr		= $games_obj->result['visitor_tmr'][$i];
					$home_score			= $games_obj->result['home_score'][$i];
					$home_shots			= $shots_obj->result['home_shots'][$i];
					$home_goalsQ1		= $games_obj->result['home_goalsQ1'][$i];
					$home_goalsQ2		= $games_obj->result['home_goalsQ2'][$i];
					$home_goalsQ3		= $games_obj->result['home_goalsQ3'][$i];
					$home_goalsQ4		= $games_obj->result['home_goalsQ4'][$i];
					$home_goalsOT		= ($games_obj->result['home_goalsOT'][$i] > 0 ? $games_obj->result['home_goalsOT'][$i] : '-');
					$visitor_score		= $games_obj->result['visitor_score'][$i];
					$visitor_shots		= $shots_obj->result['visitor_shots'][$i];
					$visitor_goalsQ1	= $games_obj->result['visitor_goalsQ1'][$i];
					$visitor_goalsQ2	= $games_obj->result['visitor_goalsQ2'][$i];
					$visitor_goalsQ3	= $games_obj->result['visitor_goalsQ3'][$i];
					$visitor_goalsQ4	= $games_obj->result['visitor_goalsQ4'][$i];
					$visitor_goalsOT	= ($games_obj->result['visitor_goalsOT'][$i] > 0 ? $games_obj->result['visitor_goalsOT'][$i] : '-');
					
					//2. process data
					$winner_tr		= ($home_score > $visitor_score ? $home_tr : $visitor_tr);
					$print_test		= true;
					$game_date		= date('l, F j, Y', strtotime($date));
					$home_record	= get_team_record_results($home_tr, $date);
					$visitor_record	= get_team_record_results($visitor_tr, $date);
					
					//3. set links
					$param			= 'tmr='.$home_tmr.'&tr='.$home_tr.'&s='.$season.'&ty='.$seasonType;
					$home_href		= set_href(FILENAME_TEAM_STATS, $param);
					$param			= 'tmr='.$visitor_tmr.'&tr='.$visitor_tr.'&s='.$season.'&ty='.$seasonType;
					$visitor_href	= set_href(FILENAME_TEAM_STATS, $param);
					$param			= 'gr='.$gameRef.'&tr='.$home_tr;
					$boxScore_href	= set_href(FILENAME_BOX_SCORE, $param);
					
					//4. build player array
					$players = array();
					$players_obj->move();
					while(!$players_obj->eof){
						if($players_obj->field['gameRef'] == $gameRef){
							$players['player_pmr'][]	= $players_obj->field['reference'];
							$players['player_name'][]	= $players_obj->field['name'];
							$players['player_tr'][]		= $players_obj->field['teamRef'];
							$players['goals'][]			= $players_obj->field['goals'];
							$players['assists'][]		= $players_obj->field['assists'];
						}
						$players_obj->move_next();
					}
					
					//5. get scorer data
					array_multisort($players['goals'], SORT_DESC, $players['assists'], $players['player_tr'], $players['player_name'], $players['player_pmr']);
					$scorer_string = set_player_string(1, $players, $winner_tr, $home_tr, $home_abbrev, $visitor_abbrev);
					
					//6. get assist data
					array_multisort($players['assists'], SORT_DESC, $players['goals'], $players['player_tr'], $players['player_name'], $players['player_pmr']);
					$assist_string = set_player_string(0, $players, $winner_tr, $home_tr, $home_abbrev, $visitor_abbrev);
					
					//7. get goalie data
					$goalkeeper_string = set_goalkeeper_string($goalies, $gameRef, $winner_tr);
				}
				//8. print data
				//8a. test for column start
				if($column == 0){
?>
	<div class="body_container">
		<div class="leftScoreboard">
<?php
				}else{
?>
		<div class="rightScoreboard">
<?php
				}
				//8b. print detail
				if($game < $games){
?>
			<div class="scoreboardContainer">
			<table border="0" cellspacing="0" cellpadding="0" width="330">
			<tr><td colspan="11" class="chartTitleL2"><b><?php echo $game_date; ?></b></td></tr>
			<tr>
				<td width="1" class="divider4"></td>
				<td width="5" class="chartHeaderC"></td>
				<td width="129" class="chartHeaderL"></td>
				<td width="20" class="chartHeaderC">1</td>
				<td width="20" class="chartHeaderC">2</td>
				<td width="20" class="chartHeaderC">3</td>
				<td width="20" class="chartHeaderC">4</td>
				<td width="20" class="chartHeaderC">OT</td>
				<td width="20" class="chartHeaderC"><b>G</b></td>
				<td width="20" class="chartHeaderC"><b>SH</b></td>
				<td width="1" class="divider4"></td>
			</tr>
			<tr><td colspan="11" height="1" class="divider"></td></tr>
			<tr>
				<td width="1" class="divider"></td>
<?php
						if($winner_tr == $visitor_tr){
?>
				<td width="5" class="chartC1"><img src="images/winner.png" width="5" height="10" alt="winnerArrow"></td>
<?php
						}else{
?>
				<td width="5" class="chartC1"></td>
<?php
						}
?>
				<td width="129" class="chartL3"><a href="<?php echo $visitor_href; ?>"><b><?php echo $visitor_team; ?></b></a><?php echo $visitor_record; ?></td>
				<td width="20" class="chartC2"><?php echo $visitor_goalsQ1; ?></td>
				<td width="20" class="chartC2"><?php echo $visitor_goalsQ2; ?></td>
				<td width="20" class="chartC2"><?php echo $visitor_goalsQ3; ?></td>
				<td width="20" class="chartC2"><?php echo $visitor_goalsQ4; ?></td>
				<td width="20" class="chartC2"><?php echo $visitor_goalsOT; ?></td>
				<td width="20" class="chartC1"><b><?php echo $visitor_score; ?></b></td>
				<td width="20" class="chartC1"><?php echo $visitor_shots; ?></td>
				<td width="1" class="divider"></td>
			</tr>
			<tr><td colspan="11" height="1" class="divider"></td></tr>
			<tr>
				<td width="1" class="divider"></td>
<?php
						if($winner_tr == $home_tr){
?>
				<td width="5" class="chartC1"><img src="images/winner.png" width="5" height="10" alt="winnerArrow"></td>
<?php
						}else{
?>
				<td width="5" class="chartC1"></td>
<?php
						}
?>
				<td width="129" class="chartL3"><a href="<?php echo $home_href; ?>"><b><?php echo $home_team; ?></b></a><?php echo $home_record; ?></td>
				<td width="20" class="chartC2"><?php echo $home_goalsQ1; ?></td>
				<td width="20" class="chartC2"><?php echo $home_goalsQ2; ?></td>
				<td width="20" class="chartC2"><?php echo $home_goalsQ3; ?></td>
				<td width="20" class="chartC2"><?php echo $home_goalsQ4; ?></td>
				<td width="20" class="chartC2"><?php echo $home_goalsOT; ?></td>
				<td width="20" class="chartC1"><b><?php echo $home_score; ?></b></td>
				<td width="20" class="chartC1"><?php echo $home_shots; ?></td>
				<td width="1" class="divider"></td>
			</tr>
			<tr><td colspan="11" height="1" class="divider"></td></tr>
			</table>
			<table border="0" cellspacing="0" cellpadding="0" width="330">
			<tr>
				<td width="1" class="divider"></td>
				<td width="5" class="chartC1"></td>
				<td width="109" class="chartL3"><a href="<?php echo $boxScore_href; ?>"><b>Box Score</b></a></td>
				<td width="197" class="chartR1"><b>at <?php echo $field; ?></b></td>
				<td width="1" class="divider"></td>
			</tr>
			<tr>
				<td width="1" class="divider"></td>
				<td width="5" class="chartC1"></td>
				<td colspan="2" width="312" class="chartL2"><b>Goalkeeper:</b> <?php echo $goalkeeper_string; ?></td>
				<td width="1" class="divider"></td>
			</tr>
			<tr>
				<td width="1" class="divider"></td>
				<td width="5" class="chartC1"></td>
				<td colspan="2" width="312" class="chartL2"><b>Scoring:</b> <?php echo $scorer_string; ?></td>
				<td width="1" class="divider"></td>
			</tr>
			<tr>
				<td width="1" class="divider"></td>
				<td width="5" class="chartC1"></td>
				<td colspan="2" width="312" class="chartL2"><b>Assists:</b> <?php echo $assist_string; ?></td>
				<td width="1" class="divider"></td>
			</tr>
			<tr><td colspan="5" height="1" class="divider"></td></tr>
			</table>
<?php
				}
?>
			</div>
		</div>
<?php
				//9. increment
				//$games_obj->move_next();
				$i++;
				$game++;
				$column++;
			}
			//10. end row
?>
	</div>
<?php
			$row++;
		}
	}
}else{
	//no games
	$month_name = get_month_name($month);
?>
	<p style="padding:0px 30px 0px 30px; ">No games found in the month of <?php echo $month_name; ?>.<br>Click on one of the months above to see game activity.</p>
<?php
}
?>
	<!-- EOF BODY -->

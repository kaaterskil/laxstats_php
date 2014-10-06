<?php
require('includes/modules/results/header.php');
?>
	<!-- BOF BODY -->
	<div class="body_container">
		<table border="0" cellspacing="0" cellpadding="0" width="750">
<?php
		//set up weeks
		$start_month = mktime(0, 0, 0, $month, 1, $season);
		$end_month = mktime(0, 0, 0, $month + 1, 0, $season);
		$days_to_sunday = 7 - date('w', $start_month);
		$next_sunday = mktime(0, 0, 0, date('m', $start_month), date('d', $start_month) + $days_to_sunday, date('Y', $start_month));
		$last_monday = mktime(0, 0, 0, date('m', $start_month), date('d', $start_month) + $days_to_sunday - 6, date('Y', $start_month));
		//retrieve data
		$games = get_schedule($start_month, $end_month);
		if(isset($games->result['gameRef'])){
			//loop through weeks
			$sunday_test = date('Y-m-d', $next_sunday);
			$monday_test = date('Y-m-d', $last_monday);
			$header_test = true;
			$subheader_test = 0;
			$row = 0;
			while(!$games->eof){
				//retrieve data
				$gameRef = $games->field['gameRef'];
				$date = $games->field['date'];
				$startTime = $games->field['startTime'];
				$seconds = $games->field['time_as_seconds'];
				$fieldRef = $games->field['fieldRef'];
				$final = $games->field['final'];
				$created = $games->field['created'];
				$modified = $games->field['modified'];
				$site = $games->field['site'];
				$field = $games->field['field'];
				$versus = $games->field['versus'];
				$home_team = $games->field['home_team'];
				$home_tr = $games->field['home_tr'];
				$visitor_team = $games->field['visitor_team'];
				$visitor_tr = $games->field['visitor_tr'];
				$home_score = $games->field['home_score'];
				$visitor_score = $games->field['visitor_score'];
				//process data
				$now = time();
				$game_timestamp = strtotime($date) + $seconds;
				$subheader = ($game_timestamp < $now ? 1 : 2);
				$game_time = date('g:i a', $game_timestamp);
				
				if($home_score > $visitor_score){
					$winner_tr = $home_tr;
					$loser_tr = $visitor_tr;
				}else{
					$winner_tr = $visitor_tr;
					$loser_tr = $home_tr;
				}
				$now_SQL = date('YmdHis', $now);
				$five_days_ago = $now - (60 * 60 * 24 * 5);
				$five_days_ago_SQL = date('YmdHis', $five_days_ago);
				if($final != 'F'){
					$game_title = ($home_score > $visitor_score ? '<b>'.$home_team.' '.$home_score.'</b> '.$versus.' '.$visitor_team.' '.$visitor_score : $home_team.' '.$home_score.' '.$versus.' <b>'.$visitor_team.' '.$visitor_score.'</b>');
				}else{
					$game_title = $home_team.' '.$versus.' '.$visitor_team;
				}
				
				//print data
				//1. test for new week header
				while($date > $sunday_test){
					$sunday_test = date('Y-m-d', strtotime($sunday_test) + (60 * 60 * 24 * 7));
					$monday_test = date('Y-m-d', strtotime($monday_test) + (60 * 60 * 24 * 7));
					$header_test = true;
				}
				if($header_test){
					if($row > 0){
?>
		<tr><td colspan="11" height="20" class="divider2"></td></tr>
<?php
					}
					$header_title = ($sunday_test < date('Y-m-d', $end_month) ? 'Week ending '.date('l, F j, Y', strtotime($sunday_test)) : 'Week ending '.date('l, F j, Y', $end_month));
?>
		<tr><td colspan="11" class="chartTitleL2"><?php echo $header_title; ?></td></tr>
<?php
					$header_test = false;
					$subheader_test = 0;
				}
				//2. test for subheader
				if($subheader != $subheader_test){
					if($subheader == 1){
						//for past games
?>
		</table>
		<table border="0" cellspacing="0" cellpadding="0" width="750">
		<tr>
			<td width="1" class="divider4"></td>
			<td width="38" class="chartHeaderL">Date</td>
			<td width="1" class="divider"></td>
			<td width="217" class="chartHeaderL">Result</td>
			<td width="1" class="divider"></td>
			<td width="153" class="chartHeaderL">Win</td>
			<td width="1" class="divider"></td>
			<td width="153" class="chartHeaderL">Loss</td>
			<td width="1" class="divider"></td>
			<td width="153" class="chartHeaderL">Saves</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
					}else{
						//for future games
?>
		</table>
		<table border="0" cellspacing="0" cellpadding="0" width="750">
		<tr>
			<td width="1" class="divider4"></td>
			<td width="138" class="chartHeaderL">Date</td>
			<td width="1" class="divider"></td>
			<td width="337" class="chartHeaderL">Teams</td>
			<td width="1" class="divider"></td>
			<td width="93" class="chartHeaderL">Time</td>
			<td width="1" class="divider"></td>
			<td width="153" class="chartHeaderL">Field</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
					}
					$subheader_test = $subheader;
				}
				//3. print detail
				$param = 'f='.$fieldRef;
				$href_field = set_href(FILENAME_FIELD, $param);
				if($subheader == 1){
					$short_date = date('m/d', strtotime($date));
					$param = 'gr='.$gameRef.'&tr='.$home_tr;
					$href_box_score = set_href(FILENAME_BOX_SCORE, $param);
					//for past games
					if($final != 'F'){
						//get scorer data
						$winner_goals = '';
						$loser_goals = '';
						$winner_test = 0;
						$loser_test = 0;
						$goals_obj = get_schedule_scorers($gameRef);
						while(!$goals_obj->eof){
							$playerMasterRef = $goals_obj->field['reference'];
							$LName = $goals_obj->field['LName'];
							$goals = $goals_obj->field['goals'];
							$tr = $goals_obj->field['teamRef'];
							$param = 'pmr='.$playerMasterRef;
							$href_player = set_href(FILENAME_PLAYER_SUMMARY, $param);
							if($tr == $winner_tr){
								if($winner_test < 2){
									$winner_goals .=', <a href="'.$href_player.'">'.$LName.'</a> '.$goals;
								}
								$winner_test++;
							}else{
								if($loser_test < 2){
									$loser_goals .=', <a href="'.$href_player.'">'.$LName.'</a> '.$goals;
								}
								$loser_test++;
							}
							$goals_obj->move_next();
						}
						$winner_goals = ($winner_goals != '' ? substr($winner_goals, 2) : 'No goals scored.');
						$loser_goals = ($loser_goals != '' ? substr($loser_goals, 2) : 'No goals scored.');
						//get goalie data
						$winner_saves = '';
						$loser_saves = '';
						$winner_test = 0;
						$loser_test = 0;
						$saves_obj = get_schedule_goalies($gameRef);
						while(!$saves_obj->eof){
							$playerMasterRef = $saves_obj->field['reference'];
							$LName = $saves_obj->field['LName'];
							$saves = $saves_obj->field['saves'];
							$tr = $saves_obj->field['teamRef'];
							$param = 'pmr='.$playerMasterRef;
							$href_player = set_href(FILENAME_PLAYER_SUMMARY, $param);
							if($tr == $winner_tr){
								if($winner_test < 1){
									$winner_saves .=', <a href="'.$href_player.'">'.$LName.'</a> '.$saves;
								}
								$winner_test++;
							}else{
								if($loser_test < 1){
									$loser_saves .=', <a href="'.$href_player.'">'.$LName.'</a> '.$saves;
								}
								$loser_test++;
							}
							$saves_obj->move_next();
						}
						$goalie_string = substr($winner_saves.$loser_saves, 2);
?>
		<tr>
			<td width="1" class="divider"></td>
			<td width="38" class="chartL"><?php echo $short_date; ?></td>
			<td width="1" class="divider"></td>
			<td width="217" class="chartL"><a href="<?php echo $href_box_score; ?>"><?php echo $game_title; ?></a></td>
			<td width="1" class="divider"></td>
			<td width="153" class="chartL"><?php echo $winner_goals; ?></td>
			<td width="1" class="divider"></td>
			<td width="153" class="chartL"><?php echo $loser_goals; ?></td>
			<td width="1" class="divider"></td>
			<td width="153" class="chartL"><?php echo $goalie_string; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
					}else{
?>
		<tr>
			<td width="1" class="divider"></td>
			<td width="38" class="chartL"><?php echo $short_date; ?></td>
			<td width="1" class="divider"></td>
			<td width="217" class="chartL"><?php echo $game_title; ?></td>
			<td width="1" class="divider"></td>
			<td width="153" class="chartL"></td>
			<td width="1" class="divider"></td>
			<td width="153" class="chartL"></td>
			<td width="1" class="divider"></td>
			<td width="153" class="chartL"></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
					}
				}else{
					//for future games
					$long_date = date('l, F j', strtotime($date));
					if($modified != $created && $modified > $five_days_ago_SQL && $modified < $now_SQL){
?>
		<tr>
			<td width="1" class="divider"></td>
			<td width="138" class="chartL"><?php echo $long_date; ?></td>
			<td width="1" class="divider"></td>
			<td width="337" class="chartL">
				<span style="padding-right:10px; float:right; color:#cc0000; font-style:italic;">New Information!</span>
				<span style="text-align:left;"><?php echo $game_title; ?></span>
			</td>
			<td width="1" class="divider"></td>
			<td width="93" class="chartL"><?php echo $game_time; ?></td>
			<td width="1" class="divider"></td>
			<td width="153" class="chartL"><a href="<?php echo $href_field; ?>"><?php echo $field; ?></a></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
					}else{
?>
		<tr>
			<td width="1" class="divider"></td>
			<td width="138" class="chartL"><?php echo $long_date; ?></td>
			<td width="1" class="divider"></td>
			<td width="337" class="chartL"><?php echo $game_title; ?></td>
			<td width="1" class="divider"></td>
			<td width="93" class="chartL"><?php echo $game_time; ?></td>
			<td width="1" class="divider"></td>
			<td width="153" class="chartL"><a href="<?php echo $href_field; ?>"><?php echo $field; ?></a></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
					}
				}
				$row++;
				$games->move_next();
			}
		}else{
			$month_name = get_month_name($month);
?>
		<tr>
			<td width="30">&nbsp;</td>
			<td width="720">No games found in the month of <?php echo $month_name; ?>.<br>Click on one of the months above to see game activity.</td>
		</tr>
<?php
		}
?>
		</table>
	</div>
	<!-- EOF BODY -->

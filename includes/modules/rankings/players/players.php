<?php
$header_title = 'SORTABLE RANKINGS';
require('includes/modules/rankings/header.php');
?>

	<!-- BOF BODY -->
	<div class="body_container">
		<table border="0" cellspacing="0" cellpadding="0" width="700">
		<tr><td colspan="29" class="chartTitleC">ALL GAMES</td></tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="43" class="chartHeaderL1">Rank</td>
			<td width="1" class="divider"></td>
			<td width="127" class="chartHeaderL1">Player</td>
			<td width="1" class="divider"></td>
			<td width="133" class="chartHeaderL1">Town</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC1"><a href="#" onClick="changeSort('g');">g</a></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC1"><a href="#" onClick="changeSort('a');">a</a></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC1"><a href="#" onClick="changeSort('pt');">pt</a></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC1"><a href="#" onClick="changeSort('sh');">sh</a></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC1"><a href="#" onClick="changeSort('sp');">sh pct</a></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC1">un</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC1">up</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC1">dn</td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartHeaderC1"><a href="#" onClick="changeSort('gb');">gb</a></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC1"><a href="#" onClick="changeSort('pen');">Pen</a></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC1"><a href="#" onClick="changeSort('min');">Min</a></td>
			<td width="1" class="divider4"></td>
		</tr>
		<?php
		$stats = array();
		if(isset($plays->result['playerMasterRef']) && count($plays->result['playerMasterRef']) > 0){
			for($i = 0; $i < count($plays->result['playerMasterRef']); $i++){
				$playerMasterRef = $plays->result['playerMasterRef'][$i];
				$player_name = $plays->result['player_name'][$i];
				$town = $plays->result['town'][$i];
				$teamMasterRef = $plays->result['teamMasterRef'][$i];
				$teamRef = $plays->result['teamRef'][$i];
				$goals = $goals_obj->result['goals'][$i];
				$assists = $goals_obj->result['assists'][$i];
				$points = $goals_obj->result['points'][$i];
				$shots = $plays->result['shots'][$i];
				$unassisted = $goals_obj->result['unassisted'][$i];
				$man_up = $goals_obj->result['man_up'][$i];
				$man_down = $goals_obj->result['man_down'][$i];
				$gb = $plays->result['gb'][$i];
				$penalties = $penalties_obj->result['penalties'][$i];
				$minutes = $penalties_obj->result['minutes'][$i];
				
				$shotPct = ($shots > 0 ? number_format($goals / $shots, 3) : '0.000');
				$minutes = ($minutes > 0 ? number_format($minutes, 1) : '0.0');
				
				$stats['playerMasterRef'][] = $playerMasterRef;
				$stats['player_name'][] = $player_name;
				$stats['town'][] = $town;
				$stats['teamMasterRef'][] = $teamMasterRef;
				$stats['teamRef'][] = $teamRef;
				$stats['goals'][] = $goals;
				$stats['assists'][] = $assists;
				$stats['points'][] = $points;
				$stats['shots'][] = $shots;
				$stats['shotPct'][] = $shotPct;
				$stats['unassisted'][] = $unassisted;
				$stats['man_up'][] = $man_up;
				$stats['man_down'][] = $man_down;
				$stats['gb'][] = $gb;
				$stats['penalties'][] = $penalties;
				$stats['minutes'][] = $minutes;
			}
			
			switch($sortCode){
				case 'g':
					array_multisort($stats['goals'], SORT_DESC, $stats['assists'], SORT_DESC, $stats['points'], SORT_DESC, $stats['shotPct'], SORT_DESC, $stats['shots'], SORT_DESC, $stats['gb'], SORT_DESC, $stats['penalties'], SORT_ASC, $stats['minutes'], SORT_DESC, $stats['playerMasterRef'], $stats['player_name'], $stats['town'], $stats['teamMasterRef'], $stats['teamRef'], $stats['unassisted'], $stats['man_up'], $stats['man_down']);
					break;
				case 'a':
					array_multisort($stats['assists'], SORT_DESC, $stats['goals'], SORT_DESC, $stats['points'], SORT_DESC, $stats['shotPct'], SORT_DESC, $stats['shots'], SORT_DESC, $stats['gb'], SORT_DESC, $stats['penalties'], SORT_ASC, $stats['minutes'], SORT_DESC, $stats['playerMasterRef'], $stats['player_name'], $stats['town'], $stats['teamMasterRef'], $stats['teamRef'], $stats['unassisted'], $stats['man_up'], $stats['man_down']);
					break;
				case 'pt':
					array_multisort($stats['points'], SORT_DESC, $stats['goals'], SORT_DESC, $stats['assists'], SORT_DESC, $stats['shotPct'], SORT_DESC, $stats['shots'], SORT_DESC, $stats['gb'], SORT_DESC, $stats['penalties'], SORT_ASC, $stats['minutes'], SORT_DESC, $stats['playerMasterRef'], $stats['player_name'], $stats['town'], $stats['teamMasterRef'], $stats['teamRef'], $stats['unassisted'], $stats['man_up'], $stats['man_down']);
					break;
				case 'sh':
					array_multisort($stats['shots'], SORT_DESC, $stats['goals'], SORT_DESC, $stats['assists'], SORT_DESC, $stats['points'], SORT_DESC, $stats['shotPct'], SORT_DESC, $stats['gb'], SORT_DESC, $stats['penalties'], SORT_ASC, $stats['minutes'], SORT_DESC, $stats['playerMasterRef'], $stats['player_name'], $stats['town'], $stats['teamMasterRef'], $stats['teamRef'], $stats['unassisted'], $stats['man_up'], $stats['man_down']);
					break;
				case 'sp':
					array_multisort($stats['shotPct'], SORT_DESC, $stats['shots'], SORT_DESC, $stats['goals'], SORT_DESC, $stats['assists'], SORT_DESC, $stats['points'], SORT_DESC, $stats['gb'], SORT_DESC, $stats['penalties'], SORT_ASC, $stats['minutes'], SORT_DESC, $stats['playerMasterRef'], $stats['player_name'], $stats['town'], $stats['teamMasterRef'], $stats['teamRef'], $stats['unassisted'], $stats['man_up'], $stats['man_down']);
					break;
				case 'gb':
					array_multisort($stats['gb'], SORT_DESC, $stats['goals'], SORT_DESC, $stats['assists'], SORT_DESC, $stats['points'], SORT_DESC, $stats['shotPct'], SORT_DESC, $stats['shots'], SORT_DESC, $stats['penalties'], SORT_ASC, $stats['minutes'], SORT_DESC, $stats['playerMasterRef'], $stats['player_name'], $stats['town'], $stats['teamMasterRef'], $stats['teamRef'], $stats['unassisted'], $stats['man_up'], $stats['man_down']);
					break;
				case 'pen':
					array_multisort($stats['penalties'], SORT_DESC,$stats['goals'], SORT_DESC, $stats['assists'], SORT_DESC, $stats['points'], SORT_DESC, $stats['shotPct'], SORT_DESC, $stats['shots'], SORT_DESC, $stats['gb'], SORT_DESC,  $stats['minutes'], SORT_DESC, $stats['playerMasterRef'], $stats['player_name'], $stats['town'], $stats['teamMasterRef'], $stats['teamRef'], $stats['unassisted'], $stats['man_up'], $stats['man_down']);
					break;
				case 'min':
					array_multisort($stats['minutes'], SORT_DESC, $stats['goals'], SORT_DESC, $stats['assists'], SORT_DESC, $stats['points'], SORT_DESC, $stats['shotPct'], SORT_DESC, $stats['shots'], SORT_DESC, $stats['gb'], SORT_DESC, $stats['penalties'], SORT_ASC, $stats['playerMasterRef'], $stats['player_name'], $stats['town'], $stats['teamMasterRef'], $stats['teamRef'], $stats['unassisted'], $stats['man_up'], $stats['man_down']);
					break;
			}
			
			for($i = 0; $i < 100; $i++){
				if(isset($stats['playerMasterRef'][$i])){
					$playerMasterRef = $stats['playerMasterRef'][$i];
					$player_name = $stats['player_name'][$i];
					$town = $stats['town'][$i];
					$teamMasterRef = $stats['teamMasterRef'][$i];
					$teamRef = $stats['teamRef'][$i];
					$goals = $stats['goals'][$i];
					$assists = $stats['assists'][$i];
					$points = $stats['points'][$i];
					$shots = $stats['shots'][$i];
					$shotPct = $stats['shotPct'][$i];
					$unassisted = $stats['unassisted'][$i];
					$man_up = $stats['man_up'][$i];
					$man_down = $stats['man_down'][$i];
					$gb = $stats['gb'][$i];
					$penalties = $stats['penalties'][$i];
					$minutes = $stats['minutes'][$i];
					
					$param = 'pmr='.$playerMasterRef;
					$href1 = set_href(FILENAME_PLAYER_SUMMARY, $param);
					$param = 'tmr='.$teamMasterRef.'&tr='.$teamRef.'&s='.$season.'&ty=F';
					$href2 = set_href(FILENAME_TEAM_STATS, $param);
				}else{
					$playerMasterRef = '';
					$player_name = '';
					$town = '';
					$goals = '';
					$assists = '';
					$points = '';
					$shots = '';
					$shotPct = '';
					$unassisted = '';
					$man_up = '';
					$man_down = '';
					$gb = '';
					$penalties = '';
					$minutes = '';
					$href1 = '';
					$href2 = '';
				}
				
				$ranking = $i + 1;
				$gClass = 'chartC2';
				$aClass = 'chartC2';
				$ptClass = 'chartC2';
				$shClass = 'chartC2';
				$spClass = 'chartC2';
				$gbClass = 'chartC2';
				$pnClass = 'chartC2';
				$pmClass = 'chartC2';
				switch($sortCode){
					case 'g':
						$gClass = 'chartC5';
						break;
					case 'a':
						$aClass = 'chartC5';
						break;
					case 'pt':
						$ptClass = 'chartC5';
						break;
					case 'sh':
						$shClass = 'chartC5';
						break;
					case 'sp':
						$spClass = 'chartC5';
						break;
					case 'gb':
						$gbClass = 'chartC5';
						break;
					case 'pn':
						$pnClass = 'chartC5';
						break;
					case 'pm':
						$pmClass = 'chartC5';
						break;
				}
				$background = set_background($i);
				
			?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="43" class="chartL"><?php echo $ranking; ?>.</td>
			<td width="1" class="divider"></td>
			<td width="127" class="chartL"><a href="<?php echo $href1; ?>"><?php echo $player_name; ?></a></td>
			<td width="1" class="divider"></td>
			<td width="133" class="chartL"><a href="<?php echo $href2; ?>"><?php echo $town; ?></a></td>
			<td width="1" class="divider"></td>
			<td width="23" class="<?php echo $gClass; ?>"><?php echo $goals; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="<?php echo $aClass; ?>"><?php echo $assists; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="<?php echo $ptClass; ?>"><?php echo $points; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="<?php echo $shClass; ?>"><?php echo $shots; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="<?php echo $spClass; ?>"><?php echo $shotPct; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $unassisted; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $man_up; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $man_down; ?></td>
			<td width="1" class="divider"></td>
			<td width="28" class="<?php echo $gbClass; ?>"><?php echo $gb; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="<?php echo $pnClass; ?>"><?php echo $penalties; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="<?php echo $pmClass; ?>"><?php echo $minutes; ?></td>
			<td width="1" class="divider"></td>
		</tr>
			<?php
			}
		}
			?>
</table>
		<p class="chartL"><b>LEGEND:</b><br><b>PL:</b> Played; <b>ST:</b> Started; <b>G:</b> Goals; <b>A:</b> Assists; <b>PT:</b> Points; <b>SH:</b> Shots; <b>SH PCT:</b> Shot Percentage; <b>UN:</b> Unassisted Goals; <b>UP:</b> Man-up Goals; <b>DN:</b> Man-down Goals; <b>GB:</b> Ground Balls; <b>W-L:</b> Faceoffs Won-Lost; <b>FO PCT:</b> Faceoff Percentage; <b>PEN:</b> Penalties; <b>MIN:</b> Penalty Minutes.</p>
	</div>
	<!-- EOF BODY -->

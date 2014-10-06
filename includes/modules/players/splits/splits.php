<?php
require('includes/modules/players/header.php');
?>

	<!-- bof split stats -->
	<div class="split_container">
		<table border="0" cellspacing="0" cellpadding="0" width="750">
<?php
for($i = 0; $i < 8; $i++){
	$group_param = 'label';
	$sort_param = 'label';
	switch($i){
		case 0:
			//season total stats
			$select_param = ', t.season AS label';
			$header_test = true;
			$header_label = $season.' Overall';
			break;
		case 1:
			//home vs. away stats
			$select_param = ', IF(f.town = t.town, "Home", "Away") AS label';
			$header_test = true;
			$header_label = 'By Breakdown';
			break;
		case 2:
			//day vs nigt
			$select_param = ', IF(gm.startTime < "18:00:00", "Day", "Night") AS label';
			$header_test = false;
			$header_label = '';
			break;
		case 3:
			//surface
			$select_param = ', f.type AS label';
			$header_test = false;
			$header_label = '';
			break;
		case 4:
			//month
			$select_param = ', MONTH(gm.date) AS month, MONTHNAME(gm.date) AS label';
			$header_test = true;
			$header_label = 'By Month';
			$group_param = 'month';
			$sort_param = 'month';
			break;
		case 5:
			//season type
			$select_param = ', IF(gm.seasonType = "F", "Regular Season", "Post-Season") AS label';
			$header_test = false;
			$header_label = '';
			$sort_param = 'label DESC';
			break;
		case 6:
			//opponent
			$select_param = ', t.town AS label';
			$header_test = true;
			$header_label = 'By Opponent';
			break;
		case 7:
			//field
			$select_param = ', IF(f.name != "", CONCAT(f.town, " ", f.name), f.town) AS label';
			$header_test = true;
			$header_label = 'By Field';
			break;
	}
	//print header
	if($header_test){
		?>
		<tr><td colspan="41" height="10" class="divider2"></td></tr>
		<tr>
			<td colspan="2" class="chartTitleL"><?php echo $header_label; ?></td>
			<td width="1" class="divider"></td>
			<td colspan="3" class="chartTitleTC">Play</td>
			<td width="1" class="divider"></td>
			<td colspan="21" class="chartTitleTC">Totals</td>
			<td width="1" class="divider"></td>
			<td colspan="12" class="chartTitleTC">Per Game Average</td>
		</tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="107" class="chartHeaderL"></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">pl</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">st</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">g</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">a</td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartHeaderC">pt</td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartHeaderC">sh</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">sh pct</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">un</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">up</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">dn</td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartHeaderC">GB</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">Pen</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">Min</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">g</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">a</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">un</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">gb</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">Pen</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">Min</td>
			<td width="1" class="divider4"></td>
		</tr>
		<?php
	}
	
	//retrieve data
	$plays = get_split_play_stats($playerRef, $select_param, $group_param, $sort_param);
	$goals_obj = get_split_goal_stats($playerRef, $select_param, $group_param, $sort_param);
	$penalties_obj = get_split_penalty_stats($playerRef, $select_param, $group_param, $sort_param);
	
	for($j = 0; $j < count($plays->result['label']); $j++){
		$label			= $plays->result['label'][$j];
		$played			= $plays->result['played'][$j];
		$started		= $plays->result['started'][$j];
		$shots			= $plays->result['shots'][$j];
		$gb				= $plays->result['gb'][$j];
		$goals			= $goals_obj->result['goals'][$j];
		$assists		= $goals_obj->result['assists'][$j];
		$unassisted		= $goals_obj->result['unassisted'][$j];
		$man_up			= $goals_obj->result['man_up'][$j];
		$man_down		= $goals_obj->result['man_down'][$j];
		$penalties		= (isset($penalties_obj->result['penalties'][$j]) ? $penalties_obj->result['penalties'][$j] : 0);
		$minutes		= (isset($penalties_obj->result['minutes'][$j]) ? $penalties_obj->result['minutes'][$j] : 0);
		
		//process data
		$points = $goals + $assists;
		$shotPct = ($shots > 0 ? number_format($goals / $shots, 3) : '0.000');
		$minutes = ($minutes > 0 ? number_format($minutes, 1) : '0.0');
		if($i == 0){
			$label = 'Total';
		}
		if($i == 3){
			switch($label){
				case 'GP':
					$label = 'Grass: practice';
					break;
				case 'GC':
					$label = 'Grass: comp';
					break;
				case 'T':
					$label = 'Turf';
					break;
				default:
					$label = 'Unknown surface';
			}
		}
		$background = set_background($j);
		
		//per-game stats
		$goals_per_game = ($played > 0 ? number_format($goals / $played, 1) : '0.0');
		$assists_per_game = ($played > 0 ? number_format($assists / $played, 0) : '0');
		$unassisted_per_game = ($played > 0 ? number_format($unassisted / $played, 0) : '0');
		$gb_per_game = ($played > 0 ? number_format($gb / $played, 0) : '0');
		$penalties_per_game = ($played > 0 ? number_format($penalties / $played, 0) : '0');
		$minutes_per_game = ($played > 0 ? number_format($minutes / $played, 1) : '0.0');
		
		//print data
		?>
<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="107" class="chartL"><?php echo $label; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><?php echo $played; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><?php echo $started; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><?php echo $goals; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><?php echo $assists; ?></td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartC"><?php echo $points; ?></td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartC"><?php echo $shots; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><?php echo $shotPct; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><?php echo $unassisted; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><?php echo $man_up; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><?php echo $man_down; ?></td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartC"><?php echo $gb; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><?php echo $penalties; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><?php echo $minutes; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><?php echo $goals_per_game; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><?php echo $assists_per_game; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><?php echo $unassisted_per_game; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><?php echo $gb_per_game; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><?php echo $penalties_per_game; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><?php echo $minutes_per_game; ?></td>
			<td width="1" class="divider"></td>
		</tr>
		<?php
	}
}
?>
</table>
	<p class=\"chartL\"><b>LEGEND:</b><br><b>PL:</b> Played; <b>ST:</b> Started; <b>G:</b> Goals; <b>A:</b> Assists; <b>PT:</b> Points; <b>SH:</b> Shots; <b>SH PCT:</b> Shot Percentage; <b>UN:</b> Unassisted Goals; <b>UP:</b> Man-up Goals; <b>DN:</b> Man-down Goals; <b>GB:</b> Ground Balls; <b>W-L:</b> Faceoffs Won-Lost; <b>FO PCT:</b> Faceoff Percentage; <b>PEN:</b> Penalties; <b>MIN:</b> Penalty Minutes.</p>
	</div>
	<!-- eof split stats -->
	
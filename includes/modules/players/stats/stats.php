<?php
require('includes/modules/players/header.php');

//print career stats by season
$season_detail = true;
require('includes/modules/players/season_stats.php');


if($chart_type == 'G'){
	$sql = 'SELECT t1.season, gm.gameRef, gm.date, t2.town AS opponent,
				f.town AS field, p.teamRef,
				SUM(IF(s.teamRef = p.teamRef AND s.playerRef = p.jerseyNo,
					savedQ1 + savedQ2 + savedQ3 + savedQ4 + savedOT, 0)) AS statistic
			FROM sites f
			RIGHT JOIN games gm
				ON f.fieldRef = gm.fieldRef
			RIGHT JOIN saves s
				ON gm.gameRef = s.gameRef
			RIGHT JOIN teams t1
				ON (gm.usTeamRef = t1.teamRef OR gm.themTeamRef = t1.teamRef)
			RIGHT JOIN teams t2
				ON (gm.usTeamRef = t2.teamRef OR gm.themTeamRef = t2.teamRef)
				AND t2.teamRef != t1.teamRef
			INNER JOIN players p
				ON t1.teamRef = p.teamRef
			INNER JOIN playerMaster pm
				ON p.playerMasterRef = pm.reference
			WHERE pm.reference = "' . $playerMasterRef . '"
				AND gm.final != "F"
			GROUP BY gm.gameRef
			ORDER BY t1.season DESC, statistic DESC, gm.date DESC';
	$high_saves = $db->db_query($sql);
}

//compte table dimensions
$seasons_array = array_unique($goals_obj->result['season']);
$seasons = count($seasons_array);
if($seasons > 2){
	$table_width = (231 * 3) - 1;
}elseif($seasons > 1){
	$table_width = 231 * 2;
}else{
	$table_width = 230;
}
$columns = ($seasons * 2) - 1;
//print chart header
?>

	<!-- bof career highs -->
	<div class="game_highs">
		<table border="0" cellspacing="0" cellpadding="0" width="<?php echo $table_width; ?>">
		<tr><td colspan="<?php echo $columns; ?>" class="chartTitleL">GAME HIGHS</td></tr>
<?php

//retrieve and print data
//each season is a table set inside a <td> column
$column = 1;
$categories = ($chart_type == 'G' ? 6 : 5);
rsort($seasons_array);
reset($seasons_array);
while(current($seasons_array)){
	$career_season = current($seasons_array);
	if($column == 1){
?>
		<tr valign="top">
<?php
	}
?>
			<td><table border="0" cellspacing="0" cellpadding="0" width="230">
				<tr><td colspan="7" class="chartTitle2"><?php echo $career_season; ?></td></tr>
<?php

	for($k = 0; $k < $categories; $k++){
		switch($k){
			case 0:
				$category = 'points';
				$category_obj = $high_points;
				break;
			case 1:
				$category = 'goals';
				$category_obj = $high_goals;
				break;
			case 2:
				$category = 'assists';
				$category_obj = $high_assists;
				break;
			case 3:
				$category = 'shots';
				$category_obj = $high_shots;
				break;
			case 4:
				$category = 'ground balls';
				$category_obj = $high_gb;
				break;
			case 5:
				$category = 'saves';
				$category_obj = $high_saves;
				break;
		}
?>
				<tr>
					<td width="1" class="divider4"></td>
					<td colspan="3" class="chartHeaderL"><?php echo $category; ?></td>
					<td width="1" class="divider"></td>
					<td width="33" class="chartHeaderC"></td>
					<td width="1" class="divider4"></td>
				</tr>
<?php
		$category_obj->move();
		while(!$category_obj->eof){
			if($category_obj->field['season'] == $career_season){
				for($j = 0; $j < 3; $j++){
					$game_date = '&nbsp';
					$game = '';
					$statistic = '';
					//get stats
					$gameRef = $category_obj->field['gameRef'];
					$date = $category_obj->field['date'];
					$teamRef = $category_obj->field['teamRef'];
					$field = $category_obj->field['field'];
					$opponent = $category_obj->field['opponent'];
					$statistic = $category_obj->field['statistic'];
					$category_obj->move_next();
					//process data
					if($statistic > 0){
						$game_date = date('M j', strtotime($date));
						$param = 'gr='.$gameRef.'&tr='.$teamRef;
						$href = set_href(FILENAME_BOX_SCORE, $param);
						$link = '<a href="'.$href.'">'.$opponent.'</a>';
						$game = ($field == $opponent ? 'at '.$link : $link);
					}else{
						$statistic = '';
					}
					$background = set_background($j);
					//print data
?>
				<tr class="<?php echo $background; ?>">
					<td width="1" class="divider"></td>
					<td width="42" class="chartC"><?php echo $game_date; ?></td>
					<td width="1" class="divider"></td>
					<td width="133" class="chartL"><?php echo $game; ?></td>
					<td width="1" class="divider"></td>
					<td width="33" class="chartC"><?php echo $statistic; ?></td>
					<td width="1" class="divider"></td>
				</tr>
<?php
				}
				break;
			}
			$category_obj->move_next();
		}
?>
				<tr><td colspan="7" height="10" class="divider2"></td></tr>
<?php
	}
?>
				</table></td>
<?php
	if($column != 3 && $seasons > 1){
?>
			<td width="1" class="divider2"></td>
<?php
	}
	if($column == 3 || $column == $seasons){
		?>
		</tr>
<?php
	}
	$column++;
	next($seasons_array);
}

?>
		</table>
		<p><b>LEGEND:</b><br><b>PL:</b> Played; <b>ST:</b> Started; <b>G:</b> Goals; <b>A:</b> Assists; <b>PT:</b> Points; <b>SH:</b> Shots; <b>SH PCT:</b> Shot Percentage; <b>UN:</b> Unassisted Goals; <b>UP:</b> Man-up Goals; <b>DN:</b> Man-down Goals; <b>GB:</b> Ground Balls; <b>W-L:</b> Faceoffs Won-Lost; <b>FO PCT:</b> Faceoff Percentage; <b>S:</b> Saves; <b>GA:</b> Goals Allowed; <b>GA AVG:</b> Goals Allowed Average Per Game; <b>PEN:</b> Penalties; <b>MIN:</b> Penalty Minutes.</p>
	</div>
	<!-- eof career highs -->

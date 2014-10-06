<?php
require('includes/modules/teams/header.php');
?>
	<!-- BOF BODY -->
	<div class="body_container">
		<!-- bof depth chart -->
		<table border="0" cellspacing="0" cellpadding="0" width="700">
		<tr><td colspan="11" class="chartTitleC">DEPTH CHART</td></tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="72" class="chartHeaderC">Position</td>
			<td width="1" class="divider"></td>
			<td width="148" class="chartHeaderC">Starter</td>
			<td width="1" class="divider"></td>
			<td width="148" class="chartHeaderC">2</td>
			<td width="1" class="divider"></td>
			<td width="148" class="chartHeaderC">3</td>
			<td width="1" class="divider"></td>
			<td width="148" class="chartHeaderC">4</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
$player_array = array();
for($row = 0; $row < 5; $row++){
	$starter = array();
	$second_string = array();
	$third_string = array();
	$bench = array();
	switch($row){
		case 0:
			$player_array = $attacks;
			$position = 'Attack';
			break;
		case 1:
			$player_array = $middies;
			$position = 'Midfield';
			break;
		case 2:
			$player_array = $defense;
			$position = 'Defense';
			break;
		case 3:
			$player_array = $goalies;
			$position = 'Goalkeeper';
			break;
		case 4:
			$player_array = $unknown;
			$position = 'Unknown';
			break;
	}
	if(isset($player_array) && count($player_array) > 0){
		$background = set_background($row);
		for($j = 0; $j < count($player_array); $j++){
			$playerMasterRef = $player_array[$j]['playerMasterRef'];
			$jerseyNo = $player_array[$j]['jerseyNo'];
			$last_name = $player_array[$j]['LName'];
			$first_name = $player_array[$j]['FName'];
			$depth = $player_array[$j]['depth'];
			$yr = $player_array[$j]['class'];
			
			$yr = intval(str_pad($yr, 4, '2000', STR_PAD_LEFT));
			$year_test = $yr - intval($season);
			switch($year_test){
				case 0:
					$class = '(Sr)';
					break;
				case 1:
					$class = '(Jr)';
					break;
				case 2:
					$class = '(Sph)';
					break;
				case 3:
					$class = '(Fr)';
					break;
				default:
					$class = '';
			}
			$player_name = set_player_name($first_name, $last_name);
			$params = 'pmr='.$playerMasterRef;
			$href = set_href(FILENAME_PLAYER_SUMMARY, $params);
			
			$temp = array('playerMasterRef' => $playerMasterRef,
						  'jerseyNo' => $jerseyNo,
						  'player_name' => $player_name,
						  'class' => $class,
						  'href' => $href
						  );
			switch($depth){
				case 1:
					$starter[] = $temp;
					break;
				case 2:
					$second_string[] = $temp;
					break;
				case 3:
					$third_string[] = $temp;
					break;
				default:
					$bench[] = $temp;
			}
		}
		$background = set_background($row);
		$class_td = 'chartL';
		$class_div = 'ref';
		for($column = 0; $column < 5; $column++){
			switch($column){
				case 0:
?>
		<tr class="<?php echo $background; ?>" valign="top">
			<td width="1" class="divider4"></td>
			<td class="chartL"><?php echo $position; ?></td>
			<td width="1" class="divider"></td>
<?php
					break;
				case 1:
					echo draw_depth_string($starter, $class_td, $class_div);
					break;
				case 2:
					echo draw_depth_string($second_string, $class_td, $class_div);
					break;
				case 3:
					echo draw_depth_string($third_string, $class_td, $class_div);
					break;
				case 4:
					echo draw_depth_string($bench, $class_td, $class_div);
?>
		</tr>
<?php
					break;
			}
		}
	}
}
?>
		</table>
		<!-- eof depth chart -->
		
		<!-- bof stat boxes -->
<?php
$players->move();
while(!$players->eof){
	get_stat_box($players->field, $goals_obj->result, $plays->result, $saves->result);
	$players->move_next();
}
?>
		<!-- eof stat boxes -->
	</div>
	<!-- EOF BODY -->

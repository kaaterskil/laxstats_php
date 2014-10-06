<?php
$result = get_team_headline($teamRef, $season);
$pageTitle = $result[0];
$town = $result[1];

switch($page_ref){
	case 't2':
		$record_array = get_team_record($teamRef, '');
		$record = '('.$record_array['wins'].'-'.$record_array['losses'].')';
		$pageTitle .= ' CUMULATIVE STATISTICS '.$record;
		$table_width = 700;
		break;
	case 't3':
		$record_array = get_team_record($teamRef, '');
		$record = '('.$record_array['wins'].'-'.$record_array['losses'].')';
		$pageTitle .= ' SCHEDULE '.$record;
		$table_width = 720;
		break;
	case 't4':
		$pageTitle .= ' ROSTER';
		$table_width = 400;
		break;
	case 't5':
		$pageTitle .= ' DEPTH CHART';
		$table_width = 700;
		break;
	case 't6':
		$pageTitle .= ' PHOTOS';
		$table_width = 400;
		break;
}
$column_width = round($table_width / 5, 0);
?>

	<!-- BOF HEADER -->
	<div id="pageTitle">
		<div class="header" style="float:left; "><?php echo $pageTitle; ?></div>
		<div style=" text-align:right; padding: 15px 20px 0px 0px; ">
<?php
		draw_team_select($town, $season, $page_ref);
?>
		</div>
		
		<div class="subheader" style="clear:both; ">
<?php
		draw_team_season_select($teamMasterRef, $season, $page_ref);
		if($page_ref == FILENAME_TEAM_STATS){
			$param = 'tmr='.$teamMasterRef.'&tr='.$teamRef.'&s='.$season;
			$href = set_href(FILENAME_TEAM_STATS, $param);
			$href1 = $href.'&ty=T';
			$href2 = $href.'&ty=F';
			$href3 = $href.'&ty=A';
			switch($type){
				case 'A':
					echo "\t\t\t".'<a href="'.$href2.'">Regular Season</a> | <a href="'.$href1.'">Post-Season</a> | Cumulative'."\n";
					break;
				case 'T':
					echo "\t\t\t".'<a href="'.$href2.'">Regular Season</a> | Post-Season | <a href="'.$href3.'">Cumulative</a>'."\n";
					break;
				default:
					echo "\t\t\t".'Regular Season | <a href="'.$href1.'">Post-Season</a> | <a href="'.$href3.'">Cumulative</a>'."\n";
			}
		}
?>
		</div>
		
		<table border="0" cellpadding="0" cellspacing="0" width="<?php echo $table_width; ?>">
		<tr>
<?php
			for($i = 2; $i < 7; $i++){
				$param = 'tmr='.$teamMasterRef.'&tr='.$teamRef.'&s='.$season;
				switch($i){
					case 2:
						$href = set_href(FILENAME_TEAM_STATS, $param).'&ty=F';
						$label = 'Team Stats';
						break;
					case 3:
						$href = set_href(FILENAME_TEAM_SCHEDULE, $param);
						$label = 'Schedule';
						break;
					case 4:
						$href = set_href(FILENAME_TEAM_ROSTER, $param);
						$label = 'Roster';
						break;
					case 5:
						$href = set_href(FILENAME_TEAM_DEPTH, $param);
						$label = 'Depth Chart';
						break;
					case 6:
						$href = set_href(FILENAME_TEAM_PHOTOS, $param).'&se=A';
						$label = 'Photos';
						break;
				}
				$page = substr($page_ref, 1, 1);
				if($i == $page){
?>
			<td width="<?php echo $column_width; ?>" class="subheader2"><?php echo $label; ?></td>
<?php
				}else{
?>
			<td width="<?php echo $column_width; ?>" class="subheader2"><a href="<?php echo $href; ?>"><?php echo $label; ?></a></td>
<?php
				}
			}
			?>
		</tr>
		</table>
	</div>
	<!-- EOF HEADER -->

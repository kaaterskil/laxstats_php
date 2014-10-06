	<!-- BOF HEADER -->
	<div id="pageTitle">
		<div class="team_select">Conference: <?php echo draw_conference_select($season, $page_ref, $conference); ?></div>
		<div class="header"><?php echo $header_title; ?></div>
		<div class="subheader"><?php draw_conference_season_select($conference, $season, $page_ref); ?></div>
		<div class="subheader">Score data courtesy of <a href="http://www.laxpower.com">LaxPower.com</a></div>
	</div>
	<!-- EOF HEADER -->

	<!-- BOF BODY -->
	<div class="body_container">
		<table border="0" cellspacing="0" cellpadding="0" width="580">
<?php
//for conference standings
if($conference != ''){
	for($i = 0; $i < 3; $i++){
		switch($i){
			case 0:
				$label = 'Conference';
				$subTitle = $season.' Conference Standings';
				array_multisort($rankings['conference'], $rankings['conference_pct'], SORT_DESC, $rankings['conference_win'], SORT_DESC, $rankings['conference_loss'], $rankings['overall_pct'], SORT_DESC, $rankings['win'], SORT_DESC, $rankings['loss'], $rankings['league_pct'], SORT_DESC, $rankings['league_win'], SORT_DESC, $rankings['league_loss'], $rankings['division_pct'], SORT_DESC, $rankings['division_win'], SORT_DESC, $rankings['division_loss'], $rankings['town'], $rankings['division'], $rankings['league'], $rankings['teamMasterRef']);
				break;
			case 1:
				$label = 'Division';
				$subTitle = $season.' Division Standings';
				array_multisort($rankings['division'], $rankings['division_pct'], SORT_DESC, $rankings['division_win'], SORT_DESC, $rankings['division_loss'], $rankings['conference_pct'], SORT_DESC, $rankings['conference_win'], SORT_DESC, $rankings['conference_loss'], $rankings['overall_pct'], SORT_DESC, $rankings['win'], SORT_DESC, $rankings['loss'], $rankings['league_pct'], SORT_DESC, $rankings['league_win'], SORT_DESC, $rankings['league_loss'], $rankings['town'], $rankings['conference'], $rankings['league'], $rankings['teamMasterRef']);
				break;
			case 2:
				$label = 'League';
				$subTitle = $season.' League Standings';
				array_multisort($rankings['league'], $rankings['league_pct'], SORT_DESC, $rankings['league_win'], SORT_DESC, $rankings['league_loss'], $rankings['conference_pct'], SORT_DESC, $rankings['conference_win'], SORT_DESC, $rankings['conference_loss'], $rankings['overall_pct'], SORT_DESC, $rankings['win'], SORT_DESC, $rankings['loss'], $rankings['division_pct'], SORT_DESC, $rankings['division_win'], SORT_DESC, $rankings['division_loss'], $rankings['town'], $rankings['conference'], $rankings['division'], $rankings['teamMasterRef']);
				break;
		}
?>
		<tr><td colspan="13" class="chartTitleC"><?php echo $conference.': '.$subTitle; ?></td></tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="192" class="chartHeaderC">Town</td>
			<td width="1" class="divider"></td>
			<td width="133" class="chartHeaderC"><?php echo $label; ?></td>
			<td width="1" class="divider"></td>
			<td colspan="7" class="chartHeaderC">Win-Loss Record</td>
			<td width="1" class="divider4"></td>
		</tr>
		<tr><td colspan="13" height="1" class="divider"></td></tr>
<?php
		$rank = 0;
		$category_test = '';
		for($j = 0; $j < count($rankings['teamMasterRef']); $j++){
			//get data
			$teamMasterRef		= $rankings['teamMasterRef'][$j];
			$town				= $rankings['town'][$j];
			$team_conference	= $rankings['conference'][$j];
			$team_league		= $rankings['league'][$j];
			$team_division		= $rankings['division'][$j];
			$conference_win		= $rankings['conference_win'][$j];
			$conference_loss	= $rankings['conference_loss'][$j];
			$overall_win		= $rankings['win'][$j];
			$overall_loss		= $rankings['loss'][$j];
			$league_win			= $rankings['league_win'][$j];
			$league_loss		= $rankings['league_loss'][$j];
			$division_win		= $rankings['division_win'][$j];
			$division_loss		= $rankings['division_loss'][$j];
			//process data
			$rank++;
			$conference_record	= $conference_win.'-'.$conference_loss;
			$overall_record		= $overall_win.'-'.$overall_loss;
			$league_record		= $league_win.'-'.$league_loss;
			$division_record	= $division_win.'-'.$division_loss;
			$background			= set_background($j);
			switch($i){
				case 0:
					$subheader = '';
					$category_value = 'Conference';
					$string = $team_league;
					break;
				case 1:
					$subheader = 'Division: ';
					$category_value = $team_division;
					$string = $team_league;
					break;
				case 2:
					$subheader = 'League: ';
					$category_value = $team_league;
					$string = $team_division;
					break;
			}
			//set links
			$params = get_all_get_params(array('p')).'&tmr='.$teamMasterRef;
			$href = set_href(FILENAME_CONFERENCE_GAME_LOG, $params);
			//test for and print category separator
			if($category_value != $category_test){
				if($j > 0){
?>
	<tr><td colspan="13" height="20" class="divider2"></td></tr>
<?php
				}
?>
		<tr>
			<td colspan="4" class="chartHeaderL"><?php echo $subheader.$category_value; ?></td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartHeaderC">Conf</td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartHeaderC">Overall</td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartHeaderC">League</td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartHeaderC">Div</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
				$rank = 1;
				$category_test = $category_value;
			}//end category separator
			//print detail
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="192" class="chartL"><?php echo $rank; ?>. <a href="<?php echo $href; ?>"><?php echo $town; ?></a></td>
			<td width="1" class="divider"></td>
			<td width="133" class="chartL"><?php echo $string; ?></td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartC"><?php echo $conference_record; ?></td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartC"><?php echo $overall_record; ?></td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartC"><?php echo $league_record; ?></td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartC"><?php echo $division_record; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
		}//end team loop
?>
		<tr><td colspan="13" height="20" class="divider2"></td></tr>
<?php
	}//end conference loop
//for state standings
}else{
	$subTitle = $season.' '.$state.' Standings';
	array_multisort($rankings['overall_pct'], SORT_DESC, $rankings['win'], SORT_DESC, $rankings['loss'], $rankings['conference'], $rankings['conference_pct'], SORT_DESC, $rankings['conference_win'], SORT_DESC, $rankings['conference_loss'], $rankings['division'], $rankings['division_pct'], SORT_DESC, $rankings['division_win'], SORT_DESC, $rankings['division_loss'], $rankings['league'], $rankings['league_pct'], SORT_DESC, $rankings['league_win'], SORT_DESC, $rankings['league_loss'], $rankings['town'], $rankings['teamMasterRef']);
?>
		<tr><td colspan="13" class="chartTitleC"><?php echo $subTitle; ?></td></tr>
		<tr><td colspan="13" height="1" class="division2"></td></tr>
		<tr>
			<td colspan="4" class="chartHeaderL"></td>
			<td width="1" class="divider"></td>
			<td colspan="7" class="chartHeaderC">Win-Loss Record</td>
			<td width="1" class="divider4"></td>
		</tr>
		<tr><td colspan="9" height="1" class="division2"></td></tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="192" class="chartHeaderC">Town</td>
			<td width="1" class="divider"></td>
			<td width="133" class="chartHeaderC">Conference</td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartHeaderC">Overall</td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartHeaderC">Conf</td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartHeaderC">League</td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartHeaderC">Div</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
	$rank = 0;
	for($j = 0; $j < count($rankings['teamMasterRef']); $j++){
		//get data
		$teamMasterRef		= $rankings['teamMasterRef'][$j];
		$town				= $rankings['town'][$j];
		$team_conference	= $rankings['conference'][$j];
		$team_league		= $rankings['league'][$j];
		$team_division		= $rankings['division'][$j];
		$conference_win		= $rankings['conference_win'][$j];
		$conference_loss	= $rankings['conference_loss'][$j];
		$overall_win		= $rankings['win'][$j];
		$overall_loss		= $rankings['loss'][$j];
		$league_win			= $rankings['league_win'][$j];
		$league_loss		= $rankings['league_loss'][$j];
		$division_win		= $rankings['division_win'][$j];
		$division_loss		= $rankings['division_loss'][$j];
		//process data
		$rank++;
		$conference_record	= $conference_win.'-'.$conference_loss;
		$overall_record		= $overall_win.'-'.$overall_loss;
		$league_record		= $league_win.'-'.$league_loss;
		$division_record	= $division_win.'-'.$division_loss;
		$background			= set_background($j);
		//set links
		$params = get_all_get_params(array('p')).'&tmr='.$teamMasterRef;
		$href = set_href(FILENAME_CONFERENCE_GAME_LOG, $params);
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="192" class="chartL"><?php echo $rank; ?>. <a href="<?php echo $href; ?>"><?php echo $town; ?></a></td>
			<td width="1" class="divider"></td>
			<td width="133" class="chartL"><?php echo $conference; ?></td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartC"><?php echo $overall_record; ?></td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartC"><?php echo $conference_record; ?></td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartC"><?php echo $league_record; ?></td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartC"><?php echo $division_record; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
	}
}
?>
		</table>
	</div>
	<!-- EOF BODY -->

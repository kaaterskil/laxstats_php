<?php
$header_title = 'TEAM GAME HIGHS';
require('includes/modules/rankings/header.php');
?>

	<!-- BOF BODY -->
	<div class="body_container">
		<?php
		//build points array
		$points_obj = $goals_obj;
		if(isset($points_obj->result['gameRef']) && count($points_obj->result['gameRef']) > 0){
			for($i = 0; $i < count($points_obj->result['gameRef']); $i++){
				$gameRef = $points_obj->result['gameRef'][$i];
				$key = array_search($gameRef, $assists_obj->result['gameRef']);
				if($key >= 0){
					$points_obj->result['statistic'][$i] += $assists_obj->result['statistic'][$key];
				}
			}
			array_multisort($points_obj->result['statistic'], SORT_DESC, $points_obj->result['town'], $points_obj->result['teamRef'], $points_obj->result['opponent'], $points_obj->result['date'], $points_obj->result['gameRef'], $points_obj->result['usTeamRef']);
		}
		?>
		<!-- bof goals block -->
		<div class="ranking_rightTable">
		<?php
		team_leaderboard($goals_obj, 'goals', 'g');
		?>
		</div>
		<!-- eof goals block -->
		
		<!-- bof points block -->
		<div class="ranking_leftTable">
		<?php
		team_leaderboard($points_obj, 'points', 'pt');
		?>
		</div>
		<!-- eof points block -->
	</div>
	<div class="body_container">
		<!-- bof shots block -->
		<div class="ranking_rightTable">
		<?php
		team_leaderboard($shots_obj, 'shots', 'sh');
		?>
		</div>
		<!-- eof shots block -->
		
		<!-- bof assists block -->
		<div class="ranking_leftTable">
		<?php
		team_leaderboard($assists_obj, 'assists', 'a');
		?>
		</div>
		<!-- eof assists block -->
	</div>
	<div class="body_container">
		<!-- bof ground balls block -->
		<div class="ranking_rightTable">
		<?php
		team_leaderboard($gb_obj, 'ground balls', 'gb');
		?>
		</div>
		<!-- eof ground balls block -->
		
		<!-- bof saves block -->
		<div class="ranking_leftTable">
		<?php
		team_leaderboard($saves_obj, 'saves', 's');
		?>	
		</div>
		<!-- eof saves block -->
	</div>
	<!-- EOF BODY -->
	
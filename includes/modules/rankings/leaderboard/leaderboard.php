<?php
$header_title = 'CATEGORY LEADERS';
require('includes/modules/rankings/header.php');
?>

	<!-- BOF BODY -->
	<div class="body_container">
		<!-- bof goals block -->
		<div class="ranking_rightTable">
		<?php
		player_leaderboard($goals_obj, $season, 'goals', 'g');
		?>
		</div>
		<!-- eof goals block -->
		
		<!-- bof points block -->
		<div class="ranking_leftTable">
		<?php
		player_leaderboard($points_obj, $season, 'points', 'pt');
		?>
		</div>
		<!-- eof points block -->
	</div>
	<div class="body_container">
		<!-- bof shots block -->
		<div class="ranking_rightTable">
		<?php
		player_leaderboard($shots_obj, $season, 'shots', 'sh');
		?>
		</div>
		<!-- eof shots block -->
		
		<!-- bof assists block -->
		<div class="ranking_leftTable">
		<?php
		player_leaderboard($assists_obj, $season, 'assists', 'a');
		?>
		</div>
		<!-- eof assists block -->
	</div>
	<div class="body_container">
		<!-- bof ground balls block -->
		<div class="ranking_rightTable">
		<?php
		player_leaderboard($gb_obj, $season, 'ground balls', 'gb');
		?>
		</div>
		<!-- eof ground balls block -->
		
		<!-- bof saves block -->
		<div class="ranking_leftTable">
		<?php
		player_leaderboard($saves_obj, $season, 'saves', 's');
		?>	
		</div>
		<!-- eof saves block -->
	</div>
	<div class="body_container">
		<!-- bof penalty minutes block -->
		<div class="ranking_rightTable">
		<?php
		player_leaderboard($minutes_obj, $season, 'penalty minutes', 'min');
		?>
		</div>
		<!-- eof penalty minutes block -->
		
		<!-- bof penalties block -->
		<div class="ranking_leftTable">
		<?php
		player_leaderboard($penalties_obj, $season, 'penalties', 'pen');
		?>	
		</div>
		<!-- eof penalties block -->
	</div>
	<!-- EOF BODY -->

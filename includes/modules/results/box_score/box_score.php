<?php
include('includes/modules/results/box_score/banner.php');
?>
	<!-- BOF TEAM STATISTICS -->
	<div class="body_container">
		<!-- bof play-by-play -->
		<div class="right_container">
<?php
include('includes/modules/results/box_score/scoring.php');
include('includes/modules/results/box_score/violations.php');
?>			
		</div>
		<!-- eof play-by-play -->
		
		<!-- bof game summary -->
		<div class="left_container">
<?php
include('includes/modules/results/box_score/team_stats.php');
?>			
		</div>
		<!-- eof game summary -->
	</div>
	<!-- TEAM STATISTICS -->
	
	<!-- BOF INDIVIDUAL STATS -->
<?php
include('includes/modules/results/box_score/lineup.php');
include('includes/modules/results/box_score/offense.php');
include('includes/modules/results/box_score/faceoffs.php');
include('includes/modules/results/box_score/saves.php');
include('includes/modules/results/box_score/penalties.php');
?>			
	<!-- EOF INDIVIDUAL STATS -->

<?php
include(FILENAME_ADMIN_PAGE_HEADER);
?>

	<!-- BOF BODY -->
	<div class="body_container">
<?php
if($final_message != ''){
?>
		<div class="validation_error"><?php echo $final_message; ?></div>
<?php
}
include('includes/modules/admin/game_edit/game.php');
include('includes/modules/admin/game_edit/plays.php');
include('includes/modules/admin/game_edit/scoring.php');
include('includes/modules/admin/game_edit/penalties.php');
include('includes/modules/admin/game_edit/saves.php');
include('includes/modules/admin/game_edit/faceoffs.php');
include('includes/modules/admin/game_edit/clears.php');
?>
		<div class="text_container">Think you're done? Then click <a href="#" onMouseUp="confirm_submit('<?php echo $href_action_final; ?>');">here</a> to submit the game as final. Just remember, once you do, you can't pull it back to do any more edits, so check it over once more before clicking this link.</div>
	</div>
	<!-- EOF BODY -->

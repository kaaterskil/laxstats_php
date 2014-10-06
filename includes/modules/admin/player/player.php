<?php
$href_home			= set_href(FILENAME_ADMIN_USER_HOME);
$param				= 'se=a';
$href_team_index	= set_href(FILENAME_ADMIN_TEAM_INDEX, $param);
$href_fields		= set_href(FILENAME_ADMIN_FIELD);
$player_selection	= set_href($page_ref, get_all_get_params(array('p')));
?>
	<!-- BOF HEADER -->
	<div id="pageTitle">
		<div class="player_select"><?php echo draw_player_select2($teamRef, $player_selection, FILENAME_ADMIN_PLAYER); ?></div>
		<div class="header"><?php echo $page_header ?></div>
		<div class="subheader">
			<a href="<?php echo $href_home; ?>">Manager's Office</a> | 
			<a href="<?php echo $href_team_index; ?>">Full Team List</a> | 
			<a href="<?php echo $href_fields; ?>">Playing Fields</a> | 
			<?php
			echo draw_team_season_select2($team, FILENAME_ADMIN_PLAYER, $season);
			?>
		</div>
	</div>
	<!-- EOF HEADER -->

	<!-- BOF BODY -->
	<div class="body_container">
<?php
if($playerMasterRef > 0){
	if($photo_test){
	?>
		<div style="padding:5px 10px 20px 0px; float:left;"><?php draw_image('images/team_images/'.$photo, 65, 90); ?></div>
	<?php
	}
?>
		<!-- bof player description -->
		<div class="player_header_container">
			<table border="0" cellspacing="0" cellpadding="0" width="620">
			<tr>
				<td width="184" class="chartL1"><b>Name: </b><?php echo $player_name; ?></td>
				<td width="184" class="chartL1"><b>Age (as of today): </b><?php echo $age; ?></td>
				<td width="240" rowspan="2">
					<table border="0" cellspacing="0" cellpadding="0" width="240">
					<tr valign="top">
						<td width="53" class="chartL1"><b>Address: </b></td>
						<td width="175" class="chartL1"><?php echo $address['street']; ?></td>
					</tr>
					<tr>
						<td class="chartL1">&nbsp;</td>
						<td class="chartL1"><?php echo $address['city']; ?></td>
					</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="chartL1"><b>Birthdate: </b><?php echo $birthdate; ?></td>
				<td class="chartL1"><b>Class: </b><?php echo $class; ?></td>
			</tr>
			<tr>
				<td class="chartL1"><b>Height: </b><?php echo $height; ?></td>
				<td class="chartL1"><b>Position: </b><?php echo $position; ?></td>
				<td class="chartL1"><b>Phone: </b><?php echo $telephone_home; ?></td>
			</tr>
			<tr>
				<td class="chartL1"><b>Weight: </b><?php echo $weight; ?></td>
				<td class="chartL1"><b>Hand: </b><?php echo $hand; ?></td>
				<td class="chartL1"><b>email: </b><?php echo $email_home; ?></td>
			</tr>
			<tr>
				<td class="chartL1"></td>
				<td class="chartL1"><b>School: </b><?php echo $school; ?></td>
				<td class="chartL1"><b>Parent: </b><?php echo $parent_name; ?></td>
			</tr>
			<tr valign="top">
				<td class="chartL1"><a href="#" onClick="edit_player('<?php echo $href_edit_player; ?>');">Edit Player</a></td>
				<td class="chartL1"><b>Counselor: </b><?php echo $counselor; ?></td>
				<td class="chartL1"><b>email: </b><?php echo $email_parent; ?></td>
			</tr>
			<tr>
				<td class="chartL1">&nbsp;</td>
				<td class="chartL1"><?php echo $telephone_counselor; ?></td>
				<td class="chartL1"><?php echo $college; ?></td>
			</tr>
			<tr>
<?php
	if($age > 0 && $age < 18){
?>
				<td colspan="3" class="chartL1" style="font-style:italic; color:#990000;">NOTE: This player is a minor. Personal information, including any photo, is not viewable outside the Manager's Office.</td>
<?php
	}else{
?>
				<td colspan="3" class="chartL1"></td>
<?php
	}
?>		
			</tr>
			</table>
		</div>
		<!-- eof player description -->
<?php
$season_detail = false;
include('includes/modules/players/season_stats.php');
include('includes/modules/admin/player/athletics.php');
include('includes/modules/admin/player/academics.php');
include('includes/modules/admin/player/tests.php');
include('includes/modules/admin/player/letters.php');
include('includes/modules/admin/player/notes.php');
}
?>
	</div>
	<!-- EOF BODY -->

		<!-- bof seasons block -->
		<table border="0" cellpadding="0" cellspacing="0" width="460">
		<tr>
			<td colspan="11" class="chartTitleC">
				<span class="information"><a href="#" onClick="openInfo('seasonData1');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
				<span>Seasons</span>
			</td>
		</tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="28" class="chartHeaderC"></td>
			<td width="1" class="divider"></td>
			<td width="42" class="chartHeaderC">Season</td>
			<td width="1" class="divider"></td>
			<td colspan="5" class="chartHeaderC">Staff</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
if(isset($team_obj->result['teamRef'])){
	$seasons = array_unique($team_obj->result['teamRef']);
	if(count($seasons) > 0 && $seasons[0] != NULL){
		reset($seasons);
		$row = 0;
		foreach($seasons as $key=>$value){
			$teamRef = $value;
			$season = $team_obj->result['season'][$key];
			$elements = array_keys($team_obj->result['teamRef'], $teamRef);
			$staff_array = array();
			for($j = 0; $j < 3; $j++){
				if(isset($elements[$j])){
					$element = $elements[$j];
					$staff_array[] = $team_obj->result['staff'][$element];
				}else{
					$staff_array[] = '';
				}
			}
			$params = get_all_get_params(array('p', 'tmr', 'tr')).'&tmr='.$teamMasterRef.'&tr='.$teamRef;
			$href_delete = set_href($page_ref, $params).'&a=ds';
			$params = 'tmr='.$teamMasterRef.'&tr='.$teamRef;
			$href_edit = set_href(FILENAME_ADMIN_ROSTER, $params);
			$background = set_background($row);
			$row++;
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="28" class="chartC">
				<a href="#" onClick="confirm_season_delete('<?php echo $href_delete; ?>');"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a>
				<a href="<?php echo $href_edit; ?>"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a>
			</td>
			<td width="1" class="divider"></td>
			<td width="42" class="chartC"><?php echo $season; ?></td>
			<td width="1" class="divider"></td>
			<td width="118" class="chartL"><?php echo $staff_array[0]; ?></td>
			<td width="1" class="divider"></td>
			<td width="118" class="chartL"><?php echo $staff_array[1]; ?></td>
			<td width="1" class="divider"></td>
			<td width="118" class="chartL"><?php echo $staff_array[2]; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
		}
	}else{
?>
		<tr>
			<td width="1" class="divider"></td>
			<td colspan="9" class="chartL9">No seasons have been created yet.</td>
			<td width="1" class="divider"></td>
		</tr>
<?php
	}
}
$params = 'tmr='.$teamMasterRef.'&nmh=1';
$href_new_season = set_href(FILENAME_ADMIN_SEASON, $params);
?>
		<tr><td colspan="11" class="buttonText"><input name="addSeason" type="button" value="Add Season" onClick="new_season('<?php echo $href_new_season; ?>', '<?php echo $_SESSION['user_affiliation']; ?>');"></td></tr>
		<tr><td colspan="11" height="1" class="error"><?php echo $season_message; ?></td></tr>
		</table>
		<!-- eof seasons block -->

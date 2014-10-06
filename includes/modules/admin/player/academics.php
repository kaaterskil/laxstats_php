		<!-- bof academic history -->
		<div class="academic_container">
			<div class="header" style="float:left;">ACADEMICS</div>
			<div class="buttonText" style="padding-top:15px;"><?php echo draw_button('academics', 'Add Academic Entry', 'onClick="open_academic(\''.$href_new_academic.'\');"'); ?></div>
			<table border="0" cellspacing="0" cellpadding="0" width="480">
			<tr>
				<td colspan="7" class="chartTitleC">
					<span class="information"><a href="#" onClick="openInfo('academics');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
					<span>ACADEMIC LOG</span>
				</td>
			</tr>
			<tr>
				<td width="1" class="divider4"></td>
				<td width="28" class="chartHeaderC"></td>
				<td width="1" class="divider"></td>
				<td width="83" class="chartHeaderC">Entry Date</td>
				<td width="1" class="divider"></td>
				<td width="347" class="chartHeaderC">Description</td>
				<td width="1" class="divider4"></td>
			</tr>
<?php
if(count($academics->result['reference']) > 0){
	$row = 0;
	while(!$academics->eof){
		//get data
		$recordID	= $academics->field['reference'];
		$date		= $academics->field['date'];
		$semester	= $academics->field['semester'];
		$classes	= $academics->field['classes'];
		$activities	= $academics->field['activities'];
		$gpa		= $academics->field['gpa'];
		$rank		= $academics->field['rank'];
		$major		= $academics->field['major'];
		$colleges	= $academics->field['colleges'];
		//process data
		$date = date('m/d/Y', strtotime($date));
		$description = '';
		for($i = 0; $i < 5; $i++){
			switch($i){
				case 0:
					$description .= ($classes != '' ? 'Honors classes, ' : '');
					break;
				case 1:
					$description .= ($activities != '' ? 'Activities/awards, ' : '');
					break;
				case 2:
					$description .= ($gpa > 0 ? 'GPA, ' : '');
					break;
				case 3:
					$description .= ($rank != '' ? 'Class rank, ' : '');
					break;
				case 4:
					$description .= (($major != '' || $colleges != '') ? 'Future plans, ' : '');
					break;
			}
		}
		$description = substr($description, 0, -2);
		$background = set_background($row);
		//set links
		$params = get_all_get_params(array('p')).'&pmr='.$playerMasterRef.'&se='.$recordID.'&a=dac';
		$href_delete = set_href(FILENAME_ADMIN_PLAYER, $params);
		$params = get_all_get_params(array('p', 'se')).'&se='.$recordID.'&nmh=1';
		$href_edit = set_href(FILENAME_ADMIN_ACADEMICS, $params);
?>
			<tr class="<?php echo $background; ?>" valign="top">
				<td width="1" class="divider"></td>
				<td width="28" class="chartL">
					<a href="#" onClick="return confirm_delete(1, '<?php echo $href_delete; ?>');"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a>
					<a href="#" onClick="return open_academic('<?php echo $href_edit; ?>');"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a>
				</td>
				<td width="1" class="divider"></td>
				<td width="83" class="chartL"><?php echo $date; ?></td>
				<td width="1" class="divider"></td>
				<td width="347" class="chartL"><?php echo $description; ?></a></td>
				<td width="1" class="divider"></td>
			</tr>
<?php
		$row++;
		$academics->move_next();
	}
}else{
?>
			<tr>
				<td width="1" class="divider"></td>
				<td colspan="5" class="chartL3">No academic entries have been saved.</td>
				<td width="1" class="divider"></td>
			</tr>
<?php
}
?>
			<tr><td colspan="7" class="error"><?php echo $academic_message; ?></td></tr>
			</table>
		</div>
		<!-- eof academic history -->

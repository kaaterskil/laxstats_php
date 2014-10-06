		<!-- bof letters history -->
		<div style="clear:both; ">
			<table border="0" cellspacing="0" cellpadding="0" width="700">
			<tr valign="bottom">
				<td colspan="7" class="header">COACH COMMENTS</td>
				<td colspan="2" class="buttonText" style="text-align:right;"><?php echo draw_button('letter', 'Create Comment', 'onClick="open_comment(\''.$href_new_letter.'\');"'); ?></td>
			</tr>
			<tr>
				<td colspan="9" class="chartTitleC">
					<span class="information"><a href="#" onClick="openInfo('recommendation');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
					<span>COACH COMMENTS & IMPORTANT INFORMATION</span>
				</td>
			</tr>
			<tr>
				<td width="1" class="divider4"></td>
				<td width="28" class="chartHeaderC"></td>
				<td width="1" class="divider"></td>
				<td width="53" class="chartHeaderC">Print</td>
				<td width="1" class="divider"></td>
				<td width="83" class="chartHeaderC">Entry Date</td>
				<td width="1" class="divider"></td>
				<td width="505" class="chartHeaderC">Text</td>
				<td width="1" class="divider4"></td>
			</tr>
<?php
if(count($letters->result['reference']) > 0){
	$row = 0;
	while(!$letters->eof){
		//get data
		$recordID	= $letters->field['reference'];
		$date		= $letters->field['date'];
		$current	= ($letters->field['current'] == 'T' ? '&radic;' : '');
		$comments	= $letters->field['comments'];
		//process data
		$date		= date('m/d/Y', strtotime($date));
		$comments	= (strlen($comments) > 200 ? substr($comments, 0, 200).'...' : $comments);
		$background = set_background($row);
		//set links
		$params = get_all_get_params(array('p')).'&pmr='.$playerMasterRef.'&se='.$recordID.'&a=dc';
		$href_delete = set_href(FILENAME_ADMIN_PLAYER, $params);
		$params = get_all_get_params(array('p', 'ae')).'&se='.$recordID.'&nmh=1';
		$href_edit = set_href(FILENAME_ADMIN_LETTERS, $params);
?>
			<tr valign="top" class="<?php echo $background; ?>" valign="top">
				<td width="1" class="divider"></td>
				<td width="28" class="chartC">
					<a href="#" onClick="return confirm_delete(3, '<?php echo $href_delete; ?>');"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a>
					<a href="#" onClick="open_comment('<?php echo $href_edit; ?>');"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a>
				</td>
				<td width="1" class="divider"></td>
				<td width="53" class="chartC"><?php echo $current; ?></td>
				<td width="1" class="divider"></td>
				<td width="83" class="chartL"><?php echo $date; ?></td>
				<td width="1" class="divider"></td>
				<td width="505" class="chartL"><?php echo $comments; ?></td>
				<td width="1" class="divider"></td>
			</tr>
<?php
		$row++;
		$letters->move_next();
	}
}else{
?>
			<tr>
				<td width="1" class="divider"></td>
				<td colspan="7" class="chartL3">No comments have been created.</td>
				<td width="1" class="divider"></td>
			</tr>
<?php
}
?>
			<tr><td colspan="9" class="error"><?php echo $comment_message; ?></td></tr>
			</table>
		</div>
		<!-- eof letters history -->

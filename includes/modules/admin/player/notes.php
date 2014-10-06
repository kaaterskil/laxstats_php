		<!-- bof notes history -->
		<div>
			<table border="0" cellspacing="0" cellpadding="0" width="700">
			<tr valign="bottom">
				<td colspan="8" class="header">NOTES</td>
				<td colspan="3" class="buttonText" style="text-align:right;"><?php echo draw_button('note', 'Create Note', 'onClick="open_note(\''.$href_new_note.'\');"'); ?><td>
			</tr>
			<tr>
				<td colspan="11" class="chartTitleC">
					<span class="information"><a href="#" onClick="openInfo('notes');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
					<span>NOTES LOG</span>
				</td>
			</tr>
			<tr>
				<td width="1" class="divider4"></td>
				<td width="14" class="chartHeaderC"></td>
				<td width="1" class="divider"></td>
				<td width="83" class="chartHeaderC">Date</td>
				<td width="1" class="divider"></td>
				<td width="93" class="chartHeaderC">Type</td>
				<td width="1" class="divider"></td>
				<td width="200" class="chartHeaderC">Contact</td>
				<td width="1" class="divider"></td>
				<td width="274" class="chartHeaderC">Subject</td>
				<td width="1" class="divider4"></td>
			</tr>
<?php
if(count($notes->result['reference']) > 0){
	$row = 0;
	while(!$notes->eof){
		//get data
		$recordID	= $notes->field['reference'];
		$type		= $notes->field['type'];
		$date		= $notes->field['date'];
		$contact	= $notes->field['contact'];
		$subject	= $notes->field['subject'];
		//process data
		$date = date('m/d/Y', strtotime($date));
		switch($type){
			case 'N':
				$type = 'Note';
				break;
			case 'E':
				$type = 'Laxstats email';
				break;
			case 'S':
				$type = 'Email sent';
				break;
			case 'R':
				$type = 'Email received';
				break;
			case 'L':
				$type = 'Letter';
				break;
			case 'T':
				$type = 'Phone';
				break;
		}
		$contact		= (strlen($contact) > 25 ? substr($contact).'...' : $contact);
		$background		= set_background($row);
		//set links
		$params			= get_all_get_params(array('p')).'&pmr='.$playerMasterRef.'&se='.$recordID.'&a=dn';
		$href_delete	= set_href(FILENAME_ADMIN_PLAYER, $params);
		$params			= get_all_get_params(array('p', 'se')).'&se='.$recordID.'&nmh=1';
		$href_edit		= set_href(FILENAME_ADMIN_NOTES, $params);
?>
			<tr class="<?php echo $background; ?>" valign="top">
				<td width="1" class="divider"></td>
				<td width="14" class="chartC"><a href="#" onClick="return confirm_delete(4, '<?php echo $href_delete; ?>');"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a></td>
				<td width="1" class="divider"></td>
				<td width="83" class="chartL"><?php echo $date; ?></td>
				<td width="1" class="divider"></td>
				<td width="93" class="chartC"><?php echo $type; ?></td>
				<td width="1" class="divider"></td>
				<td width="200" class="chartL"><?php echo $contact; ?></td>
				<td width="1" class="divider"></td>
				<td width="274" class="chartL"><a href="#" onClick="open_note('<?php echo $href_edit; ?>');"><?php echo $subject; ?></a></td>
				<td width="1" class="divider"></td>
			</tr>
<?php
		$row++;
		$notes->move_next();
	}
}else{
?>
			<tr>
				<td width="1" class="divider"></td>
				<td colspan="9" class="chartL3">No notes have been created.</td>
				<td width="1" class="divider"></td>	
			</tr>
<?php
}
?>
			<tr><td colspan="11" class="error"><?php echo $note_message; ?></td></tr>
			</table>
		</div>
		<!-- eof notes history -->

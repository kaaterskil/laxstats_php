		<!-- bof athletic history -->
		<div>
			<div class="header" style="float:left;">ATHLETICS</div>
			<div class="buttonText" style="padding-top:15px;"><?php echo draw_button('athletics', 'Add Athletic Entry', 'onClick="open_athletic(\''.$href_new_athletic.'\');"'); ?></div>
			<div style="clear:both;"><table border="0" cellspacing="0" cellpadding="0" width="700">
			<tr>
				<td colspan="11" class="chartTitleC">
					<span style="text-align:left; float:left;"><a href="#" onClick="openInfo('athletics');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
					<span>ATHLETIC LOG</span>
				</td>
			</tr>
			<tr>
				<td width="1" class="divider4"></td>
				<td width="28" class="chartHeaderC"></td>
				<td width="1" class="divider"></td>
				<td width="83" class="chartHeaderC">Entry Date</td>
				<td width="1" class="divider"></td>
				<td width="63" class="chartHeaderC">Sport</td>
				<td width="1" class="divider"></td>
				<td width="83" class="chartHeaderC">Class Year</td>
				<td width="1" class="divider"></td>
				<td width="407" class="chartHeaderC">Description</td>
				<td width="1" class="divider4"></td>
			</tr>
<?php
if(count($athletics->result['reference']) > 0){
	$row = 0;
	while(!$athletics->eof){
		//get data
		$recordID		= $athletics->field['reference'];
		$date			= $athletics->field['date'];
		$year			= $athletics->field['year'];
		$sport			= $athletics->field['sport'];
		$description	= $athletics->field['description'];
		//process data
		$date			= date('m/d/Y', strtotime($date));
		$class			= get_class_year_text($year);
		$sport			= ($sport == 'L' ? 'Lacrosse' : 'Other');
		$background		= set_background($row);
		//set links
		$params			= get_all_get_params(array('p')).'&pmr='.$playerMasterRef.'&se='.$recordID.'&a=dat';
		$href_delete	= set_href(FILENAME_ADMIN_PLAYER, $params);
		$params			= get_all_get_params(array('p', 'se')).'se='.$recordID.'&nmh=1';
		$href_edit		= set_href(FILENAME_ADMIN_ATHLETICS, $params);
?>
			<tr valign="top" class="<?php echo $background; ?>" valign="top">
				<td width="1" class="divider"></td>
				<td width="28" class="chartL">
					<a href="#" onClick="return confirm_delete(0, '<?php echo $href_delete; ?>');"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a>
					<a href="#" onClick="return open_athletic('<?php echo $href_edit; ?>');"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a>
				</td>
				<td width="1" class="divider"></td>
				<td width="83" class="chartL"><?php echo $date; ?></td>
				<td width="1" class="divider"></td>
				<td width="63" class="chartL"><?php echo $sport; ?></td>
				<td width="1" class="divider"></td>
				<td width="83" class="chartL"><?php echo $class; ?></td>
				<td width="1" class="divider"></td>
				<td width="407" class="chartL"><?php echo $description; ?></td>
				<td width="1" class="divider"></td>
			</tr>
<?php		
		$row++;
		$athletics->move_next();
	}
}else{
?>
			<tr>
				<td width="1" class="divider"></td>
				<td colspan="9" class="chartL3">No athletic entries have been saved.</td>
				<td width="1" class="divider"></td>
			</tr>
<?php
}
?>
			<tr><td colspan="11" class="error"><?php echo $athletic_message; ?></td></tr>
			</table></div>
		</div>
		<!-- eof athletic history -->

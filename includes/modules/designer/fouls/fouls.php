	<!-- BOF HEADER -->
		<div id="pageTitle">
			<div class="header">FOUL MAINTENANCE</div>
		</div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div class="body_container">
		<table border="0" cellpadding="0" cellspacing="0" width="350">
		<tr><td colspan="9" class="buttonText"><?php echo draw_button('new', 'Add Violation', 'onClick="open_foul(\''.$href_new.'\');"'); ?></td></tr>
		<tr><td colspan="9" class="chartTitleC">FOULS</td></tr>
		<tr>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC"></td>
			<td width="1" class="divider"></td>
			<td width="147" class="chartHeaderL">Description</td>
			<td width="1" class="divider"></td>
			<td width="73" class="chartHeaderC">Type</td>
			<td width="1" class="divider"></td>
			<td width="68" class="chartHeaderC">Releasable</td>
			<td width="1" class="divider"></td>
		</tr>
<?php
if(count($fouls->result['reference']) > 0){
	$row = 0;
	while(!$fouls->eof){
		//get data
		$recordID = $fouls->field['reference'];
		$description = $fouls->field['description'];
		$type = ($fouls->field['type'] == 'T' ? 'Team' : 'Personal');
		$releasable = ($fouls->field['releasable'] == 'T' ? '&radic;' : '');
		//process data
		$background = set_background($row);
		//set links
		$params = 'se='.$recordID.'&a=d';
		$href_delete = set_href(FILENAME_ADMIN_FOULS, $params);
		$params = 'se='.$recordID.'&nmh=1';
		$href_edit = set_href(FILENAME_ADMIN_FOULS_NEW, $params);
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="33" class="chartC">
				<a href="#" onClick="return confirm_delete('<?php echo $href_delete; ?>');"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a>
				<a href="#" onClick="open_foul('<?php echo $href_edit; ?>');"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a>
			</td>
			<td width="1" class="divider"></td>
			<td width="147" class="chartL"><?php echo $description; ?></td>
			<td width="1" class="divider"></td>
			<td width="73" class="chartC"><?php echo $type; ?></td>
			<td width="1" class="divider"></td>
			<td width="68" class="chartC"><?php echo $releasable; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
		$row++;
		$fouls->move_next();
	}
}
?>
		</table>
	</div>
	<!-- EOF BODY -->

<?php
include(FILENAME_ADMIN_PAGE_HEADER);
?>
	<!-- BOF BODY -->
	<div class="body_container">
		<table border="0" cellspacing="0" cellpadding="0" width="700">
		<tr><td colspan="11" class="buttonText"><?php echo draw_button('new_field', 'Add Field', 'onClick="new_field(\''.$href_new.'\');"'); ?></td></tr>
		<tr>
			<td colspan="11" class="chartTitleC">
				<span class="information"><a href="#" onClick="openInfo('fields');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
				<span>Playing Fields</span>
			</td>
		</tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="32" class="chartHeaderC"></td>
			<td width="1" class="divider"></td>
			<td width="133" class="chartHeaderL">Town</td>
			<td width="1" class="divider"></td>
			<td width="83" class="chartHeaderL">Field Name</td>
			<td width="1" class="divider"></td>
			<td width="113" class="chartHeaderL">Surface</td>
			<td width="1" class="divider"></td>
			<td width="303" class="chartHeaderL">Directions</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
if(isset($fields->result['fieldRef'])){
	$row = 0;
	while(!$fields->eof){
		$fieldRef = $fields->field['fieldRef'];
		$town = $fields->field['town'];
		$name = $fields->field['name'];
		$type = $fields->field['type'];
		$directions = nl2br($fields->field['directions']);
		
		$surface = get_surface($type);
		$background = set_background($row);
		$params = 'f='.$fieldRef.'&sn='.$state.'&a=d';
		$href_delete = set_href(FILENAME_ADMIN_FIELD, $params);
		$params = 'f='.$fieldRef.'&sn='.$state.'&nmh=1';
		$href_edit = set_href(FILENAME_ADMIN_FIELD_NEW, $params);
?>
		<tr class="<?php echo $background; ?>" valign="top">
			<td width="1" class="divider"></td>
			<td width="32" class="chartC">
				<a href="#" onClick="confirm_delete('<?php echo $href_delete; ?>');"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a>
				<a href="#" onClick="edit_field('<?php echo $href_edit; ?>');"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a>
			</td>
			<td width="1" class="divider"></td>
			<td width="133" class="chartL"><?php echo $town; ?></td>
			<td width="1" class="divider"></td>
			<td width="83" class="chartL"><?php echo $name; ?></td>
			<td width="1" class="divider"></td>
			<td width="113" class="chartL"><?php echo $surface; ?></td>
			<td width="1" class="divider"></td>
			<td width="303" class="chartL"><?php echo $directions; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
		$row++;
		$fields->move_next();
	}
}
?>
		<tr><td colspan="11" class="error"><?php echo $message; ?></td></tr>
		</table>
	</div>
	<!-- EOF BODY -->

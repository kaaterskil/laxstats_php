		<!-- bof test history -->
		<div class="test_container">
			<div class="buttonText" style="padding-top:15px;"><?php echo draw_button('test', 'Add Test', 'onClick="open_test(\''.$href_new_test.'\');"'); ?></div>
			<table border="0" cellspacing="0" cellpadding="0" width="197">
			<tr>
				<td colspan="7" class="chartTitleC">
					<span class="information"><a href="#" onClick="openInfo('testLog');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
					<span>TEST LOG</span>
				</td>
			</tr>
			<tr>
				<td width="1" class="divider4"></td>
				<td width="14" class="chartHeaderC"></td>
				<td width="1" class="divider"></td>
				<td width="83" class="chartHeaderC">Entry Date</td>
				<td width="1" class="divider"></td>
				<td width="78" class="chartHeaderC">Test</td>
				<td width="1" class="divider4"></td>
			</tr>
<?php
if(count($tests->result['reference']) > 0){
	$row = 0;
	while(!$tests->eof){
		//get data
		$recordID = $tests->field['reference'];
		$date = $tests->field['date'];
		$test_name = $tests->field['name'];
		//process data
		$date = date('m/d/Y', strtotime($date));
		$background = set_background($row);
		//set links
		$params = get_all_get_params(array('p')).'&pmr='.$playerMasterRef.'&se='.$recordID.'&a=dt';
		$href_delete = set_href(FILENAME_ADMIN_PLAYER, $params);
		$params = get_all_get_params(array('p'. 'se')).'&se='.$recordID.'&nmh=1';
		$href_view = set_href(FILENAME_ADMIN_TESTS, $params);
?>
			<tr class="<?php echo $background; ?>">
				<td width="1" class="divider"></td>
				<td width="14" class="chartL"><a href="#" onMouseUp="return confirm_delete(2, '<?php echo $href_delete; ?>');"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a></td>
				<td width="1" class="divider"></td>
				<td width="83" class="chartL"><?php echo $date; ?></td>
				<td width="1" class="divider"></td>
				<td width="78" class="chartL"><a href="#" onClick="open_test('<?php echo $href_view; ?>');"><?php echo $test_name; ?></a></td>
				<td width="1" class="divider"></td>
			</tr>
<?php
		$row++;
		$tests->move_next();
	}
}else{
?>
			<tr>
				<td width="1" class="divider"></td>
				<td colspan="5" class="chartL3">No scores have been saved.</td>
				<td width="1" class="divider"></td>
			</tr>
<?php
}
?>
			<tr><td colspan="7" class="error"><?php echo $test_message; ?></td></tr>
			</table>
		</div>
		<!-- eof test history -->

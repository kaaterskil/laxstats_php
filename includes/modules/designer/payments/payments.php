	<!-- BOF HEADER -->
	<div id="pageTitle">
		<div class="header">USER PAYMENTS</div>
		<div class="subheader">Select team: <?php echo draw_team_select2('team', $teamMasterRef, 'select_team(\''.$href_show.'\', this.options[this.selectedIndex].value)'); ?></div>
	</div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div class="body_container">
		<!-- bof display -->
		<div class="left_container">
		<table border="0" cellspacing="0" cellpadding="0" width="470">
		<tr><td colspan="13" class="chartTitleC">PAYMENT HISTORY</td></tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="33" class="chartHeaderC"></td>
			<td width="1" class="divider"></td>
			<td class="chartHeaderL">team</td>
			<td width="1" class="divider"></td>
			<td width="44" class="chartHeaderC">season</td>
			<td width="1" class="divider"></td>
			<td width="64" class="chartHeaderC">date</td>
			<td width="1" class="divider"></td>
			<td width="44" class="chartHeaderC">status</td>
			<td width="1" class="divider"></td>
			<td width="54" class="chartHeaderC">amount</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
if(count($teams->result['teamRef']) > 0){
	$total = 0;
	$row = 0;
	while(!$teams->eof){
		//get data
		$recordID = $teams->field['reference'];
		$payment = $teams->field['payment'];
		$date = $teams->field['date'];
		$status = ($teams->field['paidStatus'] == 'T' ? 'Paid' : 'Open');
		$teamRef = $teams->field['teamRef'];
		$team_name = $teams->field['team_name'];
		$division = $teams->field['division'];
		$season = $teams->field['season'];
		$type = $teams->field['type'];
		//process data
		$date = date('m/d/y', strtotime($date));
		$type = get_team_type($type);
		$total += $payment;
		$payment = number_format($payment, 2);
		$background = set_background($row);
		//set links
		$params = get_all_get_params(array('p', 'a')).'&se='.$recordID.'&a=d';
		$href_delete = set_href(FILENAME_ADMIN_PAYMENTS, $params);
		$params = get_all_get_params(array('p', 'a')).'&se='.$recordID.'&a=e';
		$href_edit = set_href(FILENAME_ADMIN_PAYMENTS, $params);
?>
		<tr class="<?php echo $background; ?>">
			<td class="divider"></td>
			<td class="chartC">
				<a href="#" onClick="confirm_delete('<?php echo $href_delete; ?>');"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a>
				<a href="<?php echo $href_edit; ?>"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a>
			</td>
			<td class="divider"></td>
			<td class="chartL"><?php echo $team_name; ?></td>
			<td class="divider"></td>
			<td class="chartC"><?php echo $season; ?></td>
			<td class="divider"></td>
			<td class="chartC"><?php echo $date; ?></td>
			<td class="divider"></td>
			<td class="chartC"><?php echo $status; ?></td>
			<td class="divider"></td>
			<td class="chartR"><?php echo $payment; ?></td>
			<td class="divider"></td>
		</tr>
<?php
		$row++;
		$teams->move_next();
	}
?>
		<tr>
			<td class="divider"></td>
			<td colspan="9" class="chartL"><b>TOTAL:</b></td>
			<td class="divider"></td>
			<td class="chartR"><b><?php echo number_format($total, 2); ?></b></td>
			<td class="divider"></td>
		</tr>
<?php
}else{
?>
		<tr>
			<td class="divider"></td>
			<td colspan="11" class="chartL3">No payments have been made.</td>
			<td class="divider"></td>
		</tr>
<?php
}
?>
		</table>
		</div>
		<!-- eof display -->
		
		<!-- bof data entry -->
		<div class="right_container">
			<form name="payment" method="post" onSubmit="return validate_payment(this);" action="<?php echo $href_action; ?>">
			<table border="0" cellspacing="0" cellpadding="0" width="'220">
			<tr><td colspan="2" class="chartTitleC">PAYMENT ENTRY</td></tr>
			<tr>
				<td class="form_label2">Season:</td>
				<td class="form_text2"><?php echo draw_text_input_element('season', '', 6, 4, $edit_season, 'validate_season(\'year\', this);'); ?></td>
			</tr>
			<tr>
				<td class="form_label2">Amount:</td>
				<td class="form_text2"><?php echo draw_text_input_element('payment', '', 12, 6, $edit_payment, 'validate_string(\'dollar\', this);'); ?></td>
			</tr>
			<tr>
				<td class="form_label2">Status:</td>
				<td class="form_text2"><?php echo draw_checkbox_input_element('status', '', 'Paid', 'T', $edit_status); ?></td>
			</tr>
			<tr>
				<td class="required"><?php echo draw_hidden_input_element('recordID', $selection); ?></td>
				<td class="buttonText"><?php echo draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Save'); ?></td>
			</tr>
			<tr><td colspan="2" class="error"><?php echo $message; ?></td></tr>
			</table>
			</form>
		</div>
		<!-- eof data entry -->
	</div>
	<!-- EOF BODY -->

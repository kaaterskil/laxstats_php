	<!-- BOF HEADER -->
	<div id="pageTitle">
		<div class="header">CONFERENCE RANKINGS UPDATE</div>
	</div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div class="body_container">
		<div class="form_container">Select the following conferences:
			<form name="update" method="post" action="<?php echo $href_action; ?>">
			<table border="0" cellspacing="0" cellpadding="0" width="600">
			<tr>
				<td class="formLabel"><?php echo draw_checkbox_input_element('region1', '', 'MA East', 'T'); ?></td>
				<td class="formLabel"><?php echo draw_checkbox_input_element('region2', '', 'MA Central', 'T'); ?></td>
				<td class="formLabel"><?php echo draw_checkbox_input_element('region3', '', 'MA West', 'T'); ?></td>
			</tr>
			<tr>
				<td class="formLabel"><?php echo draw_checkbox_input_element('region6', '', 'NJ NJSPIAA', 'T'); ?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="formLabel"><?php echo draw_checkbox_input_element('region4', '', 'MIAA/DC IAC', 'T'); ?></td>
				<td class="formLabel"><?php echo draw_checkbox_input_element('region5', '', 'VA Northern AAA', 'T'); ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="formLabel"><?php draw_admin_ranking_season_select($season); ?></td>
				<td colspan="2" class="buttonText"><?php echo draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('proceed', 'Proceed'); ?></td>
			</tr>
			</table>
			</form>
		</div>
<?php
	for($i = 0; $i < count($reader); $i++){
		for($j = 0; $j < count($reader[$i]->results['message']); $j++){
?>
		<div class="results"><?php echo $reader[$i]->results['message'][$j]; ?></div>
<?php
		}
	}
?>
	</div>
	<!-- EOF BODY -->

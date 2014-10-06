	<!-- BOF HEADER -->
	<div id="pageTitle">
		<div style=" padding-top:20px; "><?php draw_field_select($playing_field, $page_ref);	?></div>
	</div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div class="body_container">
		<table border="0" cellspacing="0" cellpadding="0" width="500">
		<tr><td colspan="2" class="right"><a href="#" onClick="printField('<?php echo $href_print; ?>')">Printable version</a></td></tr>
		<tr><td colspan="2" class="chartTitleC">PLAYING FIELDS</td></tr>
		<tr>
			<td width="94" class="chartL">Town:</td>
			<td width="394" class="chartL6"><?php echo $town; ?></td>
		</tr>
		<tr valign="top">
			<td class="chartL">Field Name:</td>
			<td class="chartL6"><?php echo $name; ?></td>
		</tr>
		<tr valign="top">
			<td class="chartL">Surface:</td>
			<td class="chartL6"><?php echo $surface; ?></td>
		</tr>
		<tr valign="top">
			<td class="chartL">Directions:</td>
			<td class="chartL6"><?php echo $directions; ?></td>
		</tr>
		</table>
	</div>
	<!-- EOF BODY -->

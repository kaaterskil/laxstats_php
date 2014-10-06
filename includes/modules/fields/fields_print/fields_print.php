	<!-- BOF HEADER -->
	<div class="popup_header">
		<div class="subheader"><?php echo draw_image($image_src); ?> <a href="javaScript:window.print();">Print</a></div>
		<div class="header"><?php echo $title; ?></div>
	</div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div style="padding:0px 0px 0px 30px; ">
		<table border="0" cellspacing="0" cellpadding="0" width="500">
		<tr>
			<td width="94" class="chartL8">TOWN:</td>
			<td width="394" class="chartL8"><?php echo $town; ?></td>
		</tr>
		<tr>
			<td class="chartL8">FIELD NAME:</td>
			<td class="chartL8"><?php echo $name; ?></td>
		</tr>
		<tr>
			<td class="chartL8">DIRECTIONS:</td>
			<td class="chartL8"><?php echo $directions; ?></td>
		</tr>
		</table>
	</div>
	<!-- EOF BODY -->

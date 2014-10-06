<?php
include(FILENAME_ADMIN_PAGE_HEADER);
?>
	<!-- BOF BODY -->
	<div class="body_container">
		<table border="0" cellspacing="0" cellpadding="0" width="740">
		<tr><td colspan="13" class="chartTitleC">BOOSTERS</td></tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="102" class="chartHeaderC">Name</td>
			<td width="1" class="divider"></td>
			<td width="133" class="chartHeaderC">address</td>
			<td width="1" class="divider"></td>
			<td width="83" class="chartHeaderC">phone</td>
			<td width="1" class="divider"></td>
			<td width="223" class="chartHeaderC">email</td>
			<td width="1" class="divider"></td>
			<td width="88" class="chartHeaderC">IP address</td>
			<td width="1" class="divider"></td>
			<td width="68" class="chartHeaderC">Created</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
if(isset($fans)){
	$row = 0;
	while(!$fans->eof){
		//get data
		$name = $fans->field['name'];
		$street1 = $fans->field['street1'];
		$street2 = $fans->field['street2'];
		$city = $fans->field['city'];
		$state = $fans->field['state'];
		$ZIP_Code = $fans->field['zip'];
		$telephone = $fans->field['phone'];
		$email = $fans->field['email'];
		$userIP = $fans->field['userIP'];
		$created = $fans->field['created'];
		//process data
		$address = '';
		if($street1 != '' || $street2 != ''){
			$address = ($street1 != '' ? $street1 : '');
			$address .= ($street2 != '' ? ($street1 != '' ? '<br>' : '').$street2 : '');
			$address .= $city.', '.$state.' '.$ZIP_Code;
		}
		$created = date('m/d/Y', strtotime($created));
		$background = set_background($row);
?>
		<tr class="<?php echo $background; ?>" valign="top">
			<td width="1" class="divider"></td>
			<td width="102" class="chartL"><?php echo $name; ?></td>
			<td width="1" class="divider"></td>
			<td width="133" class="chartL"><?php echo $address; ?></td>
			<td width="1" class="divider"></td>
			<td width="83" class="chartL"><?php echo $telephone; ?></td>
			<td width="1" class="divider"></td>
			<td width="223" class="chartL"><?php echo $email; ?></td>
			<td width="1" class="divider"></td>
			<td width="88" class="chartL"><?php echo $userIP; ?></td>
			<td width="1" class="divider"></td>
			<td width="68" class="chartL"><?php echo $created; ?></td>
			<td width="1" class="divider"></td>
		<tr>
<?php
		$row++;
		$fans->move_next();
	}
}else{
?>
		<tr>
			<td width="1" class="divider"></td>
			<td colspan="11" class="chartL3">No boosters have registered on Laxstats.</td>
			<td width="1" class="divider"></td>
		</tr>
<?php
}
?>
		</table>
	</div>
	<!-- EOF BODY -->


	<!-- BOF HEADER -->
		<div id="pageTitle">
			<div class="header">USER MAINTENANCE</div>
		</div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div class="body_container">
		<table border="0" cellpadding="0" cellspacing="0" width="700">
		<tr><td colspan="15" class="buttonText"><?php echo draw_button('new', 'Add User', 'onClick="open_user(\''.$href_new.'\')"'); ?></td></tr>
		<tr><td colspan="15" class="chartTitleC">REGISTERED USERS</td></tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="32" class="chartHeaderC"></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">Ref</td>
			<td width="1" class="divider"></td>
			<td width="103" class="chartHeaderC">Town</td>
			<td width="1" class="divider"></td>
			<td width="223" class="chartHeaderC">Name</td>
			<td width="1" class="divider"></td>
			<td width="103" class="chartHeaderC">Phone</td>
			<td width="1" class="divider"></td>
			<td width="93" class="chartHeaderC">Username</td>
			<td width="1" class="divider4"></td>
			<td width="63" class="chartHeaderC">Password</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
if(count($users->result['userRef']) > 0){
	$row = 0;
	while(!$users->eof){
		//get data
		$recordID = $users->field['userRef'];
		$name = $users->field['user_name'];
		$town = $users->field['affiliation'];
		$phone = $users->field['phone'];
		$email = $users->field['email'];
		$username = $users->field['username'];
		$password = $users->field['password'];
		$userIP = $users->field['userIP'];
		$created = $users->field['created'];
		//process data
		$href = 'mailto:'.$email;
		$created = date('m/d/Y', strtotime($created));
		$background = set_background($row);
		//set links
		$params = 'ur='.$recordID.'&a=d';
		$href_delete = set_href(FILENAME_ADMIN_USERS, $params);
		$params = 'ur='.$recordID.'&nmh=1';
		$href_edit = set_href(FILENAME_ADMIN_USERS_NEW, $params);
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="32" class="chartC">
				<a href="#" onClick="confirm_delete('<?php echo $href_delete; ?>');"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a>
				<a href="#" onClick="open_user('<?php echo $href_edit; ?>');"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a>
			</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><?php echo $recordID; ?></td>
			<td width="1" class="divider"></td>
			<td width="103" class="chartL"><?php echo $town; ?></td>
			<td width="1" class="divider"></td>
			<td width="223" class="chartL"><?php echo $name; ?></td>
			<td width="1" class="divider"></td>
			<td width="103" class="chartL"><?php echo $phone; ?></td>
			<td width="1" class="divider"></td>
			<td width="93" class="chartL"><?php echo $username; ?></td>
			<td width="1" class="divider"></td>
			<td width="63" class="chartL"><?php echo $password; ?></td>
			<td width="1" class="divider"></td>
		</tr>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td colspan="5" class="chartL"></td>
			<td width="1" class="divider"></td>
			<td width="223" class="chartL"><a href="<?php echo $href; ?>"><?php echo $email; ?></a></td>
			<td width="1" class="divider"></td>
			<td width="103" class="chartL"><?php echo $userIP; ?></td>
			<td width="1" class="divider"></td>
			<td width="93" class="chartL"><?php echo $created; ?></td>
			<td width="1" class="divider"></td>
			<td width="63" class="chartL"></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
		$row++;
		$users->move_next();
	}
}
?>
		</table>
	</div>
	<!-- EOF BODY -->

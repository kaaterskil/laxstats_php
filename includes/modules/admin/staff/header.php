<?php
//test privileges
test_privileges(1);
define('PAGE_TITLE', 'New/Edit Staff');
$page_header = ($staffRef > 0 ? 'EDIT STAFF' : 'NEW STAFF');

$name = '';
$street1 = '';
$street2 = '';
$city = '';
$state = '';
$ZIP_Code = '';
$telephone1 = '';
$telephone2 = '';
$extension = '';
$email = '';

$params = 'tmr='.$teamMasterRef.'&nmh=1&a=s';
$href_action = set_href(FILENAME_ADMIN_STAFF, $params);

$message = '';
if($action != ''){
	if($action == 's'){
		//retrieve POST variables
		$teamRef		= $_POST['teamRef'];
		$teamMasterRef	= $_POST['teamMasterRef'];
		$staffRef		= $_POST['staffRef'];
		$name			= $db->db_sanitize($_POST['name']);
		$staff_type		= $_POST['staff_type'];
		$street1		= $db->db_sanitize($_POST['street1']);
		$street2		= $db->db_sanitize($_POST['street2']);
		$city			= $db->db_sanitize($_POST['city']);
		$state			= $db->db_sanitize($_POST['state']);
		$ZIP_Code		= $db->db_sanitize($_POST['ZIP_Code']);
		$telephone1		= $db->db_sanitize($_POST['telephone1']);
		$telephoen2		= $db->db_sanitize($_POST['telephone2']);
		$extension		= $db->db_sanitize($_POST['extension']);
		$email			= $db->db_sanitize($_POST['email']);
		
		//validate
		$message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
		if($message == ''){
			$message .= (empty($name) ? ERROR_NO_NAME : '');
			$message .= ($staff_type == 0 ? ERROR_NO_STAFF_TYPE : '');
		}
		if($message == ''){
			$sql = 'SELECT COUNT(*) AS count
					FROM officials
					WHERE name=\''.$name.'\' 
						AND teamRef='.$teamRef;
			$test = $db->db_query($sql);
			if(isset($test->result['count']) && $test->field['count'] > 0){
				$message .= ERROR_DUPLICATE_STAFF;
			}
		}
		
		//write to disk
		if($message == ''){
			if($staffRef > 0){
				$sql_data_array = array('teamRef'		=> $teamRef,
										'name'			=> $name,
										'street1'		=> $street1,
										'street2'		=> $street2,
										'city'			=> $city,
										'state'			=> $state,
										'zip'			=> $ZIP_Code,
										'phone'			=> $telephone1,
										'phoneExt'		=> $extension,
										'phone2'		=> $telephone2,
										'email'			=> $email,
										'type'			=> $staff_type,
										'modifiedBy'	=> $_SESSION['user_id'],
										'modified'		=> 'now'
										);
				$param = 'reference='.$staffRef;
				$message = $db->db_write_array('officials', $sql_data_array, 'update', $param);
			}else{
				$sql_data_array = array('teamRef'		=> $teamRef,
										'name'			=> $name,
										'street1'		=> $street1,
										'street2'		=> $street2,
										'city'			=> $city,
										'state'			=> $state,
										'zip'			=> $ZIP_Code,
										'phone'			=> $telephone1,
										'phoneExt'		=> $extension,
										'phone2'		=> $telephone2,
										'email'			=> $email,
										'type'			=> $staff_type,
										'modifiedBy'	=> $_SESSION['user_id'],
										'created'		=> 'now',
										'modified'		=> 'now'
										);
				$message = $db->db_write_array('officials', $sql_data_array);
			}
		}
		//proceed
		if($message == ''){
			$params = 'tmr='.$teamMasterRef.'&tr='.$teamRef.'&nmh=1&ct=1';
			redirect(set_href(FILENAME_ADMIN_STAFF, $params));
		}
	}
}
if($teamRef > 0){
	$sql = 'SELECT name, street1, street2, city, state, zip, phone, phoneExt, phone2, email, type
			FROM officials
			WHERE reference='.$staffRef;
	$staff = $db->db_query($sql);
	$name		= $staff->field['name'];
	$street1	= $staff->field['street1'];
	$street2	= $staff->field['street2'];
	$city		= $staff->field['city'];
	$state		= $staff->field['state'];
	$ZIP_Code	= $staff->field['zip'];
	$telephone1	= $staff->field['phone'];
	$telephone2	= $staff->field['phone2'];
	$extension	= $staff->field['phoneExt'];
	$email		= $staff->field['email'];
	$staff_type	= $staff->field['type'];
}
?>
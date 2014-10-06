<?php
//test privileges
test_privileges(1);
define('PAGE_TITLE', 'New/Edit Blog');
$page_header1 = ($blog_ref > 0 ? 'EDIT BLOG POSTING' : 'NEW BLOG POSTING');
$page_header2 = ($blog_ref > 0 ? 'EDIT EMAIL BLAST' : 'NEW EMAIL BLAST');
$allowed_tags = '<p><strong><em><u><h1><h2><h3><h4><h5><h6><img><li><ol><ul><span><div><br><ins><del>';

if($teamMasterRef > 0){
	$sql = 'SELECT IF(name!=\'\', CONCAT_WS(\' \', town, name), town) AS team_name, teamRef
			FROM teams
			WHERE teamMasterRef='.$teamMasterRef.'
			ORDER BY season DESC
			LIMIT 1';
	$team = $db->db_query($sql);
	$team_name		= $team->field['team_name'];
	$teamRef		= $team->field['teamRef'];
	$page_header1	= strtoupper($team_name).'<br>'.$page_header1;
	$page_header2	= strtoupper($team_name).'<br>'.$page_header2;
}

$params = get_all_get_params(array('p', 'br', 'a')).'&a=s';
$href_action = set_href(FILENAME_ADMIN_BLOG_NEW, $params);

$blog_type		= 'B';
$date			= date('m/d/Y');
$title			= '';
$ePlayer		= 'F';
$eStaff			= 'F';
$eParent		= 'F';
$eIndividual	= 'F';
$eBooster		= 'F';
$eAlumni		= 'F';
$eOther			= '';
$blog_text		= '';
$message		= '';

if($action != ''){
	switch($action){
		case 's':
			//retrieve POST variables
			$blog_ref	= $_POST['blog_ref'];
			$blog_type	= $_POST['blog_type'];
			$date		= $db->db_sanitize($_POST['date']);
			$title		= $db->db_sanitize($_POST['title']);
			$blog_text	= $db->db_sanitize($_POST['blog_text']);
			$ePlayer	= (isset($_POST['ePlayer']) ? $_POST['ePlayer'] : '');
			$eStaff		= (isset($_POST['eStaff']) ? $_POST['eStaff'] : '');
			$eParent	= (isset($_POST['eParent']) ? $_POST['eParent'] : '');
			$eBooster	= (isset($_POST['eBooster']) ? $_POST['eBooster'] : '');
			$eAlumni	= (isset($_POST['eAlumni']) ? $_POST['eAlumni'] : '');
			$eOther		= $db->db_sanitize($_POST['eOther']);
			
			//test for active subscription
			$message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
			//validate
			if($message == ''){
				if(empty($date)){
					$message = 'You must enter a date. ';
				}
				if(empty($title)){
					$message .= 'You must enter a title/subject. ';
				}
				if(empty($blog_text)){
					$message .= 'You must enter some text. ';
				}else{
					$content = strip_tags($blog_text, $allowed_tags);
					$plaintext = strip_tags($blog_text);
				}
				if($blog_ref == 0){
					$sql = 'SELECT COUNT(*) AS duplicates
							FROM coachLetters
							WHERE teamMasterRef='.$teamMasterRef.'
								AND title=\''.$title.'\'';
					$test = $db->db_query($sql);
					if($test->field['duplicates'] > 0){
						$message .= 'That title has already been used. ';
					}
				}
			}
			
			//file upload
			$filename = '';
			$filetype = '';
			$filepath = '';
			if($message == ''){
				$file = new upload('user_file');
				$file->set_destination('userFiles/tmr_'.$teamMasterRef.'/');
				$upload_message = $file->parse_upload();
				if($upload_message == true){
					$filename = $file->filename;
					$filetype = $file->type;
					$upload_message = $file->save_file();
					if(!$upload_message){
						$message = $upload_message;
					}
				}elseif($upload_message != FILE_UPLOADED_SUCCESSFULLY){
					$message = $upload_message;
				}
			}
			
			//build email
			$send_to = '';
			if($message == '' && $type == 2){
				//1. test for sender's email address
				$from = ($_SESSION['user_first_name'] != '' ? $_SESSION['user_first_name'].' '.$_SESSION['user_last_name'] : $_SESSION['user_last_name']);
				$from = '"'.$from.'" ['.$_SESSION['user_email'].']';
				$reply_to = $_SESSION['user_email'];
				if($reply_to != ''){
					//2. collect email addresses
					if($ePlayer == 'T'){
						$sql = 'SELECT pm email 
								FROM playerMaster pm
								INNER JOIN players p
									ON p.playerMasterRef=pm.reference 
								INNER JOIN teams t
									ON p.teamRef=t.teamRef
								WHERE p.teamMasterRef='.$teamMasterRef.' 
									AND t.season=\''.date('Y').'\'
									AND (pm.email!=\'\' OR pm.email!=NULL)';
						$people = $db->db_query($sql);
						while(!$people->eof){
							$send_to .= $people->field['email'].', ';
							$people->move_next();
						}
					}
					if($eStaff == 'S'){
						$sql = 'SELECT o.email 
								FROM officials o
								INNER JOIN teams t
									USING (teamRef) 
								WHERE t.teamMasterRef='.$teamMasterRef.' 
									AND t.season=\''.date('Y').'\' 
									AND (o.email!=\'\' OR o.email!=NULL)';
						$people = $db->db_query($sql);
						while(!$people->eof){
							$send_to .= $people->field['email'].', ';
							$people->move_next();
						}
					}
					if($eParent == 'P'){
						$sql = 'SELECT pm.parentEmail 
								FROM playerMaster pm
								INNER JOIN players p
									ON p.playerMasterRef=pm.reference 
								INNER JOIN teams t
									ON p.teamRef=t.teamRef
								WHERE p.teamMasterRef='.$teamMasterRef.' 
									AND t.season=\''.date('Y').'\'
									AND (pm.parentEmail!=\'\' OR pm.parentEmail!=NULL)';
						$people = $db->db_query($sql);
						while(!$people->eof){
							$send_to .= $people->field['parentEmail'].', ';
							$people->move_next();
						}
					}
					if($eBooster == 'B'){
						$sql = 'SELECT email 
								FROM people 
								WHERE teamMasterRef='.$teamMasterRef.' 
									AND (email!=\'\' OR email!=NULL)';
						$people = $db->db_query($sql);
						while(!$people->eof){
							$send_to .= $people->field['parentEmail'].', ';
							$people->move_next();
						}
					}
					if($eAlumni == 'A'){
						$sql = 'SELECT pm.email 
								FROM playerMaster pm
								INNER JOIN players p
									ON p.playerMasterRef=pm.reference 
								INNER JOIN teams t
									ON p.teamRef=t.teamRef
								WHERE p.teamMasterRef='.$teamMasterRef.' 
									AND t.season!=\''.date('Y').'\' 
									AND (pm.email!=\'\' OR pm.email!=NULL)';
						$people = $db->db_query($sql);
						while(!$people->eof){
							$send_to .= $people->field['email'].', ';
							$people->move_next();
						}
					}
					if($eOther != ''){
						$send_to .= $eOther.', ';
					}
					$send_to = substr($sendTo, 0, -2);
					
					//3. build html message
					$html_module = array(HTML_EMAIL_BLOG);
					$html_data_array = array();
					$html_data_array[] = array('SUBJECT'			=> $title,
											   'DATE'				=> $date,
											   'BLOG_TEXT'			=> stripslashes($content),
											   'EMAIL_MESSAGE_HTML'	=> $content
											   );
					if($filename != ''){
						$filepath = 'userFiles/tmr'.$teamMasterRef.'/'.$filename;
					}
					$attachment_array = array('path'		=> $filepath,
											  'name'		=> $filename,
											  'encoding'	=> 'base64',
											  'type'		=> $filetype
											  );
					
					//4. send mail
					$recipients = $send_to.COMPANY_EMAIL_ADDRESS;
					$result = send_mail($recipients, $from, $reply_to, $title, $plaintext, $attachment_array, $html_data_array, $html_module);
					if($result != true){
						$message = 'The mail could not be sent.';
					}
				}else{
					$message = "Send error: You do not have an email address on file to use for a reply. Please contact the <a href=\"mailto:webmaster@laxstats.net\">webmaster</a> for assistance.";
				}
			}
			
			//write to disk
			if($message == ''){
				$date = date('Y-m-d', strtotime($date));
				if($blog_ref > 0){
					$sql_data_array = array('type'			=> $blog_type,
											'date'			=> $date,
											'title'			=> $title,
											'letter'		=> $content,
											'ePlayer'		=> $ePlayer,
											'eStaff'		=> $eStaff,
											'eParent'		=> $eParent,
											'eOther'		=> $eOther,
											'sendTo'		=> $send_to,
											'fileName'		=> $filename,
											'fileType'		=> $filetype,
											'modifiedBy'	=> $_SESSION['user_id'],
											'modified'		=> 'now'
											);
					$param = 'reference='.$blog_ref;
					$message = $db->db_write_array('coachLetters', $sql_data_array, 'update', $param);
				}else{
					$sql_data_array = array('teamMasterRef'	=> $teamMasterRef,
											'type'			=> $blog_type,
											'date'			=> $date,
											'title'			=> $title,
											'letter'		=> $content,
											'ePlayer'		=> $ePlayer,
											'eStaff'		=> $eStaff,
											'eParent'		=> $eParent,
											'eOther'		=> $eOther,
											'sendTo'		=> $send_to,
											'fileName'		=> $filename,
											'fileType'		=> $filetype,
											'modifiedBy'	=> $_SESSION['user_id'],
											'created'		=> 'now',
											'modified'		=> 'now'
											);
					$message = $db->db_write_array('coachLetters', $sql_data_array);
				}
			}
			
			//proceed
			if($message == ''){
				$params = get_all_get_params(array('p', 'a'));
				redirect(set_href(FILENAME_ADMIN_BLOG_NEW, $params));
			}
			break;
	}
}

if($teamMasterRef > 0 && $blog_ref > 0){
	$sql = 'SELECT type, date, title, letter, ePlayer, eStaff, eParent, eOther, sendTo, fileName, fileType, fileSize, filePath
			FROM coachLetters
			WHERE reference='.$blog_ref;
	$blogs = $db->db_query($sql);
	$blog_type	= $blogs->field['type'];
	$date		= $blogs->field['date'];
	$title		= $blogs->field['title'];
	$ePlayer	= $blogs->field['ePlayer'];
	$eStaff		= $blogs->field['eStaff'];
	$eParent	= $blogs->field['eParent'];
	$eOther		= $blogs->field['eOther'];
	$blog_text	= $blogs->field['letter'];
	$date		= date('m/d/Y', strtotime($date));
}
?>
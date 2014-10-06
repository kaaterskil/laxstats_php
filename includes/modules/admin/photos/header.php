<?php
//test privileges
test_privileges(1);
//set headers
$masthead_logo = MASTHEAD_ADMIN_PHOTOS;
$tpl_menubar = MENUBAR_ADMIN2;
define('PAGE_TITLE', 'Photos');
define('PAGE_HEADER', 'PHOTO MAINTENANCE');

$imageRef = 0;
$edit_title = '';
$edit_date = date('m/d/Y');
$edit_photographer = '';
$edit_notes = '';

$params = get_all_get_params(array('p', 'se', 'gr', 'a')).'&a=s';
$href_action = set_href(FILENAME_ADMIN_PHOTOS, $params);

$message = '';
if($action != ''){
	switch($action){
		//delete record
		case 'd':
			if($selection > 0){
				$sql = 'DELETE FROM imageLibrary
						WHERE imageRef='.$selection;
				$message = $db->db_wrtie($sql);
				if($message == ''){
					$params = get_all_get_params(array('p', 'gr', 'se', 'a'));
					redirect(set_href(FILENAME_ADMIN_PHOTOS, $params));
				}
			}
			break;
		//save record
		case 's':
			//retrieve POST variables
			$recordID = $_POST['recordID'];
			$edit_title = $db->db_sanitize($_POST['title']);
			$edit_date = $db->db_sanitize($_POST['photo_date']);
			$gameRef = $_POST['gameRef'];
			$edit_photographer = $db->db_sanitize($_POST['photographer']);
			$edit_notes = $db->db_sanitize($_POST['notes']);
			
			//test for active subscription
			$message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
			//image management
			if($message == ''){
				$image = new upload('photo');
				$image->set_destination('cache/images/tmr'.$teamMasterRef.'/');
				$upload_message = $image->parse_upload();
				if($upload_message == true){
					$image_name = $image->filename;
					$image_size = $image->size;
					$image_type = $image->type;
					$upload_message = $image->save_file();
					if(!$upload_message){
						$message = $upload_message;
					}
				}elseif($upload_message != FILE_UPLOADED_SUCCESSFULLY){
					$message = $upload_message;
				}
			}
			//write to disk
			if($message == ''){
				$edit_date = date('Y-m-d', strtotime($edit_date));
				if($recordID > 0){
					$sql_data_array = array('gameRef' => $gameRef,
											'teamRef' => $teamRef,
											'photoDate' => $edit_date,
											'photographer' => $edit_photographer,
											'title' => $edit_title,
											'type' => $image_type,
											'docName' => $image_name,
											'size' => $image_size,
											'note' => $edit_notes,
											'createdBy' => $_SESSION['user_id'],
											'modified' => 'now'
											);
					$param = 'imageRef='.$recordID;
					$message = $db->db_write_array('imageLibrary', $sql_data_array, 'update', $param);
				}else{
					$sql_data_array = array('imageRef' => NULL,
											'gameRef' => $gameRef,
											'teamRef' => $teamRef,
											'photoDate' => $edit_date,
											'photographer' => $edit_photographer,
											'title' => $edit_title,
											'type' => $image_type,
											'docName' => $image_name,
											'size' => $image_size,
											'note' => $edit_notes,
											'createdBy' => $_SESSION['user_id'],
											'created' => 'now',
											'modified' => 'now'
											);
					$message = $db->db_write_array('imageLibrary', $sql_data_array);
				}
			}
			//proceed
			if($message = ''){
				$params = get_all_get_params(array('p', 'gr', 'se', 'a'));
				redirect(set_href(FILENAME_ADMIN_PHOTOS, $params));
			}
			break;
	}
}

if($teamMasterRef > 0){
	$sql = 'SELECT DISTINCT ph.gameRef, ph.photoDate, t.town AS opponent
			FROM imageLibrary ph
			LEFT JOIN games gm
				ON ph.gameRef=gm.gameRef
			LEFT JOIN teams t
				ON (t.teamRef=gm.usTeamRef OR t.teamRef=gm.themTeamRef)
				AND t.teamRef!=ph.teamRef
			WHERE ph.teamRef='.$teamRef.'
			ORDER BY photoDate DESC';
	$photo_list = $db->db_query($sql);
}
if($gameRef > 0){
	$sql = 'SELECT ph.imageRef, ph.title, ph.size, ph.note, ph.photographer, gm.date, t.town AS opponent
			FROM imageLibrary ph
			LEFT JOIN games gm
				ON ph.gameRef=gm.gameRef
			LEFT JOIN teams t
				ON (t.teamRef=gm.usTeamRef OR t.teamRef=gm.themTeamRef)
				AND t.teamRef!=ph.teamRef
			WHERE ph.gameRef='.$gameRef.'
			ORDER BY imageRef';
	$photos = $db->db_query($sql);
}elseif($selection != ''){
	$sql = 'SELECT ph.imageRef, ph.title, ph.size, ph.note, ph.photographer, gm.date, t.town AS opponent
			FROM imageLibrary ph
			LEFT JOIN games gm
				ON ph.gameRef=gm.gameRef
			LEFT JOIN teams t
				ON (t.teamRef=gm.usTeamRef OR t.teamRef=gm.themTeamRef)
				AND t.teamRef!=ph.teamRef
			WHERE ph.photoDate='.$selection.'
			ORDER BY imageRef';
	$photos = $db->db_query($sql);
}
?>
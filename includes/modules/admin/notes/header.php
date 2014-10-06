<?php
//test privileges
test_privileges(1);
define('PAGE_TITLE', 'New/Edit notes');

//declare variables
$record_id = $selection;
$player_name = '';
$date = date('m/d/Y');
$type = '';
$contact = '';
$recipients = '';
$attachment = '';
$attachment1 = '';
$attachment2 = '';
$attachment3 = '';
$subject = '';
$text = '';
$message = '';

$params = get_all_get_params(array('p', 'a')).'&a=s';
$href_action = set_href(FILENAME_ADMIN_NOTES, $params);

if($action != ''){
	switch($action){
		case 'e':
			break;
		case 'd':
			break;
		case 's':
			//retrieve POST variables
			$record_id		= $_POST['record_id'];
			$type			= ($_POST['type'] != '' ? $_POST['type'] : 'N');
			$date			= $db->db_sanitize($_POST['date']);
			$contact		= $db->db_sanitize($_POST['contact']);
			$subject		= $db->db_sanitize($_POST['subject']);
			$text			= $db->db_sanitize($_POST['text']);
			$recipients		= $db->db_sanitize($_POST['recipients']);
			$attachment1	= (isset($_POST['attachment1']) ? 'P' : '');
			$attachment2	= (isset($_POST['attachment2']) ? 'A' : '');
			$attachment3	= (isset($_POST['attachment3']) ? 'S' : '');
			
			//test for active subscription
			$message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
			
			//validate
			if($message == ''){
				$result = validate_date($date);
				if($result === false){
					$message = 'Please enter a valid date. ';
				}else{
					$date = $result;
				}
				if($type == 'E' && empty($recipients)){
					$message .= 'Please enter an email address to send to. ';
				}
				if(empty($subject)){
					$message .= 'Please enter a subject. ';
				}
				if(empty($text)){
					$message .= 'Please enter some text. ';
				}
			}
			
			//test for and send email
			if($message == '' && $record_id == 0 && $type == 'E'){
				//1. build attachment
				//1a. get html header
				$html_data_array = array();
				$html_module = array();
				$html_module[] = EMAIL_PLAYER_TOP;
				$html_data_array[] = array('EMAIL_MESSAGE_HTML' => 'foo');
				
				//1b. get personal information
				if($attachment1 == 'P'){
					//get data
					$player = get_player_personal_info($playerMasterRef);
					$player_name			= $player->field['player_name'];
					$birthdate				= $player->field['birthdate'];
					$dominant_hand			= $player->field['dominantHand'];
					$jerseyNo				= $player->field['jerseyNo'];
					$position				= $player->field['position'];
					$street1				= $player->field['street1'];
					$street2				= $player->field['street2'];
					$city					= $player->field['city'];
					$state					= $player->field['state'];
					$ZIP_Code				= $player->field['zip'];
					$email_home				= $player->field['email'];
					$email_parent			= $player->field['parentEmail'];
					$telephone_counselor	= $player->field['counselorPhone'];
					$class					= ($player->field['class'] != ''		? $player->field['class']			: 'n/a');
					$height					= ($player->field['height'] != ''		? $player->field['height']			: 'n/a');
					$weight					= ($player->field['weight'] != ''		? $player->field['weight'].' lbs'	: 'n/a');
					$telephone_home			= ($player->field['homePhone'] != ''	? $player->field['homePhone']		: 'n/a');
					$parent_name			= ($player->field['parentName'] != ''	? $player->field['parentName']		: 'n/a');
					$school					= ($player->field['school'] != ''		? $player->field['school']			: 'n/a');
					$counselor				= ($player->field['counselor'] != ''	? $player->field['counselor']		: 'n/a');
					//process data
					$hand				= set_dominant_hand($dominant_hand);
					$position			= get_position($position);
					$address			= get_address($street1, $city, $state, $ZIP_Code, $street2);
					$email_home			= ($email_home != ''	? '<a href="mailto:'.$email_home.'">'.$email_home.'</a>'		: 'n/a');
					$email_parent		= ($email_parent != ''	? '<a href="mailto:'.$email_parent.'">'.$email_parent.'</a>'	: 'n/a');
					if($birthdate != '0000-00-00' && $birthdate != NULL){
						$dob			= strtotime($birthdate);
						$birthdate		= date('F j, Y', $dob);
						$age 			= intval(date('Y', time() - $dob)) - 1970;
					}else{
						$birthdate		= 'n/a';
						$age			= 'n/a';
					}
					//load data
					$html_module[] = EMAIL_PLAYER_INFO;
					$html_data_array[] = array('PLAYER_NAME_CAPS' 	=> strtoupper($player_name),
											   'PLAYER_NAME'		=> $player_name,
											   'PLAYER_AGE'			=> $age,
											   'PLAYER_ADDRESS1'	=> $address['street'],
											   'PLAYER_ADDRESS2'	=> $address['city'],
											   'PLAYER_BIRTHDATE'	=> $birthdate,
											   'PLAYER_CLASS'		=> $class,
											   'PLAYER_HEIGHT'		=> $height,
											   'PLAYER_POSITION'	=> $position,
											   'PLAYER_TELEPHONE'	=> $telephone_home,
											   'PLAYER_WEIGHT'		=> $weight,
											   'PLAYER_HAND'		=> $hand,
											   'PLAYER_EMAIL'		=> $email_home,
											   'SCHOOL'				=> $school,
											   'PARENT_NAME'		=> $parent_name,
											   'COUNSELOR'			=> $counselor,
											   'PARENT_EMAIL'		=> $email_parent,
											   'ADVISOR_PHONE'		=>$telephone_counselor
											   );
				}
				
				//1c. get academic information
				if($attachment2 == 'A'){
					$academics = get_player_academics($playerMasterRef);
					if($academics->count_records() > 0){
						//load header
						$html_module[] = EMAIL_PLAYER_ACADEMIC_HEADER;
						$html_data_array[] = array('EMAIL_MESSAGE_HTML' => '');
						//load body
						$row = 0;
						while(!$academics->eof){
							//get data
							$record_date	= $academics->field['date'];
							$semester		= $academics->field['semester'];
							$classes		= $academics->field['classes'];
							$activities		= $academics->field['activities'];
							$gpa			= $academics->field['gpa'];
							$rank			= $academics->field['rank'];
							$major			= $academics->field['major'];
							$colleges		= $academics->field['colleges'];
							//process data
							$record_date = date('m/d/Y', strtotime($record_date));
							$description = '';
							$description .= ($semester != '' ? '<b>Semester: </b>'.$semester.'<br />' : '');
							$description .= ($classes != '<b>Honors classes: </b>'.$classes.'<br />' ? '' : '');
							$description .= ($activities != '' ? '<b>Activities and awards: </b>'.$activities.'<br />' : '');
							$description .= ($gpa != '' ? '<b>GPA: </b>'.$gpa.'<br />' : '');
							$description .= ($rank != '' ? '<b>Rank: </b>'.$rank.'<br />' : '');
							$description .= ($major != '' ? '<b>Goals/major: </b>'.$major.'<br />' : '');
							$description .= ($colleges != '' ? '<b>Intended schools: </b>'.$colleges.'<br />' : '');
							$background = set_background($row);
							//load data
							$html_module[] = EMAIL_PLAYER_ACADEMIC_BODY;
							$html_data_array[] = array('BACKGROUND'		=> $background,
													   'DATE'			=> $record_date,
													   'DESCRIPTION'	=> $description
													   );
							
							$row++;
							$academics->move_next();
						}
						//load footer
						$html_module[] = EMAIL_PLAYER_ACADEMIC_FOOTER;
						$html_data_array[] = array('EMAIL_MESSAGE_HTML' => '');
					}
				}
				
				//1d. get athletic information
				if($attachment3 == 'S'){
					$athletics = get_player_athletics($playerMasterRef);
					if($athletics->count_records() > 0){
						//load header
						$html_module[] = EMAIL_PLAYER_ATHLETIC_HEADER;
						$html_data_array[] = array('EMAIL_MESSAGE_HTML' => '');
						//load body
						$row = 0;
						while(!$athletics->eof){
							//get data
							$record_date	= $athletics->field['date'];
							$year			= $athletics->field['year'];
							$sport			= $athletics->field['sport'];
							$description	= $athletics->field['description'];
							//process data
							$record_date	= date('m/d/Y', strtotime($record_date));
							$class			= get_class_year_text($year);
							$sport			= ($sport == 'L' ? 'Lacrosse' : 'Other');
							$background		= set_background($row);
							//load data
							$html_module[] = EMAIL_PLAYER_ATHLETIC_BODY;
							$html_data_array[] = array('BACKGROUND'		=> $background,
													   'DATE'			=> $record_date,
													   'SPORT'			=> $sport,
													   'CLASS'			=> $class,
													   'DESCRIPTION'	=> $description
													   );
							$row++;
							$athletics->move_next();
						}
						//load footer
						$html_module[] = EMAIL_PLAYER_ATHLETIC_FOOTER;
						$html_data_array[] = array('EMAIL_MESSAGE_HTML' => '');
					}
				}
				
				//1e. get stats
				if($attachment3 == 'S'){
					//retrieve career data by season
					$plays			= get_career_playing_stats($playerMasterRef);
					$goals_obj		= get_career_goal_stats($playerMasterRef);
					$penalties_obj	= get_career_penalty_stats($playerMasterRef);
					$faceoffs		= get_career_faceoff_stats($playerMasterRef);
					$saves_obj		= get_career_goalie_stats($playerMasterRef);
					//set chart type
					if($faceoffs->count_records() > 0){
						$chart_type = 'F';
					}elseif($saves_obj->count_records() > 0){
						$chart_type = 'G';
					}else{
						$chart_type = 'R';
					}
					//load header
					switch($chart_type){
						case 'G':
							$html_module[] = EMAIL_PLAYER_STATS_GOALIE_HEADER;
							$html_data_array[] = array('EMAIL_MESSAGE_HTML' => '');
							break;
						case 'F':
							$html_module[] = EMAIL_PLAYER_STATS_FACEOFF_HEADER;
							$html_data_array[] = array('EMAIL_MESSAGE_HTML' => '');
							break;
						case 'R':
							$html_module[] = EMAIL_PLAYER_STATS_HEADER;
							$html_data_array[] = array('EMAIL_MESSAGE_HTML' => '');
							break;
					}
					//load body
					$tot_played		= 0;
					$tot_started	= 0;
					$tot_goals		= 0;
					$tot_assists	= 0;
					$tot_points		= 0;
					$tot_shots		= 0;
					$tot_gb			= 0;
					$tot_unassisted	= 0;
					$tot_man_up		= 0;
					$tot_man_down	= 0;
					$tot_penalties	= 0;
					$tot_minutes	= 0;
					$tot_won		= 0;
					$tot_lost		= 0;
					$tot_saved		= 0;
					$tot_allowed	= 0;
					$row			= 0;
					
					while(!$plays->eof){
						$background			= set_background($row);
						$goals				= 0;
						$assists			= 0;
						$unassisted 		= 0;
						$man_up				= 0;
						$man_down			= 0;
						$penalties			= 0;
						$minutes			= number_format(0, 1);
						$saved				= 0;
						$allowed			= 0;
						$won				= 0;
						$lost				= 0;
						//get play data
						$career_season		= $plays->field['season'];
						$played				= $plays->field['played'];
						$started			= $plays->field['started'];
						$shots				= $plays->field['shots'];
						$gb					= $plays->field['gb'];
						//get goal data
						$goals_obj->move();
						while(!$goals_obj->eof){
							if($goals_obj->field['season'] == $career_season){
								$goals		= $goals_obj->field['goals'];
								$assists	= $goals_obj->field['assists'];
								$unassisted	= $goals_obj->field['unassisted'];
								$man_up		= $goals_obj->field['man_up'];
								$man_down	= $goals_obj->field['man_down'];
								break;
							}
							$goals_obj->move_next();
						}
						$points				= $goals + $assists;
						$shotPct			= ($shots > 0 ? number_format($goals / $shots, 3) : '0.000');
						//get penalty data
						$penalties_obj->move();
						while(!$penalties_obj->eof){
							if($penalties_obj->field['season'] == $career_season){
								$penalties	= $penalties_obj->field['penalties'];
								$minutes	= $penalties_obj->field['minutes'];
								break;
							}
							$penalties_obj->move_next();
						}
						//update totals
						$tot_played		+= $played;
						$tot_started	+= $started;
						$tot_goals		+= $goals;
						$tot_assists	+= $assists;
						$tot_points		+= $points;
						$tot_shots		+= $shots;
						$tot_gb			+= $gb;
						$tot_unassisted	+= $unassisted;
						$tot_man_up		+= $man_up;
						$tot_man_down	+= $man_down;
						$tot_penalties	+= $penalties;
						$tot_minutes	+= $minutes;
						
						switch($chart_type){
							case 'G':
								//get goalie data
								$saves_obj->move();
								while(!$saves_obj->eof){
									if($saves_obj->field['season'] == $career_season){
										$saved		= $saves_obj->field['saved'];
										$allowed	= $saves_obj->field['allowed'];
										break;
									}
									$saves_obj->move_next();
								}
								//process goalie data
								$gaAvg			= ($played > 0 ? number_format($allowed / $played, 1) : '0.0');
								$savePct		= ($saved + $allowed > 0 ? number_format($saved / ($saved + $allowed), 3) : '0.000');
								$tot_saved		+= $saved;
								$tot_allowed	+= $allowed;
								//print data
								$html_module[] = EMAIL_PLAYER_STATS_GOALIE_BODY;
								$html_data_array[] = array('BACKGROUND'	=> $background,
														   'SEASON'		=> $career_season,
														   'PLAYED'		=> $played,
														   'STARTED'	=> $started,
														   'GOALS'		=> $goals,
														   'ASSISTS'	=> $assists,
														   'POINTS'		=> $points,
														   'SHOTS'		=> $shots,
														   'SHOT_PCT'	=> $shotPct,
														   'GB'			=> $gb,
														   'SAVED'		=> $saved,
														   'ALLOWED'	=> $allowed,
														   'GA_AVG'		=> $gaAvg,
														   'SAVE_PCT'	=> $savePct,
														   'PENALTIES'	=> $penalties,
														   'MINUTES'	=> $minutes
														   );
								break;
							case 'F':
								//get faceoff data
								$faceoffs->move();
								while(!$faceoffs->eof){
									if($faceoffs->field['season'] == $career_season){
										$won	= $faceoffs->field['won'];
										$lost	= $faceoffs->field['lost'];
										break;
									}
									$faceoffs->move_next();
								}
								//process faceoff data
								if($won + $lost > 0){
									$fo_record	= $won.'-'.$lost;
									$foPct		= ($won + $lost > 0 ? number_format($won / ($won + $lost), 3) : '0.000');
									$tot_won	+= $won;
									$tot_lost	+= $lost;
								}else{
									$fo_record	= '-';
									$foPct		= '0.000';
								}
								//print data
								$html_module[] = EMAIL_PLAYER_STATS_FACEOFF_BODY;
								$html_data_array[] = array('BACKGROUND'	=> $background,
														   'SEASON'		=> $career_season,
														   'PLAYED'		=> $played,
														   'STARTED'	=> $started,
														   'GOALS'		=> $goals,
														   'ASSISTS'	=> $assists,
														   'POINTS'		=> $points,
														   'SHOTS'		=> $shots,
														   'SHOT_PCT'	=> $shotPct,
														   'GB'			=> $gb,
														   'FO_RECORD'	=> $fo_record,
														   'FO_PCT'		=> $foPct,
														   'PENALTIES'	=> $penalties,
														   'MINUTES'	=> $minutes
														   );
								break;
							default:
								$html_module[] = EMAIL_PLAYER_STATS_BODY;
								$html_data_array[] = array('BACKGROUND'	=> $background,
														   'SEASON'		=> $career_season,
														   'PLAYED'		=> $played,
														   'STARTED'	=> $started,
														   'GOALS'		=> $goals,
														   'ASSISTS'	=> $assists,
														   'POINTS'		=> $points,
														   'SHOTS'		=> $shots,
														   'SHOT_PCT'	=> $shotPct,
														   'GB'			=> $gb,
														   'PENALTIES'	=> $penalties,
														   'MINUTES'	=> $minutes
														   );
						}
						$row++;
						$plays->move_next();
					}
					//load footer
					$tot_minutes = number_format($tot_minutes, 1);
					$shotPct_total = ($tot_shots > 0 ? number_format($tot_goals / $tot_shots, 3) : '0.000');
					switch($chart_type){
						case 'G':
							$gaAvg_total = ($tot_played > 0 ? number_format($tot_allowed / $tot_played, 1) : '0.0');
							$savePct_total = ($tot_saved + $tot_allowed > 0 ? number_format($tot_saved / ($tot_saved + $tot_allowed), 3) : '0.000');
							$html_module[] = EMAIL_PLAYER_STATS_GOALIE_FOOTER;
							$html_data_array[] = array('TOTAL_PLAYED'		=> $tot_played,
													   'TOTAL_STARTED'		=> $tot_started,
													   'TOTAL_GOALS'		=> $tot_goals,
													   'TOTAL_ASSISTS'		=> $tot_assists,
													   'TOTAL_POINTS'		=> $tot_points,
													   'TOTAL_SHOTS'		=> $tot_shots,
													   'TOTAL_SHOT_PCT'		=> $shotPct_total,
													   'TOTAL_GB'			=> $tot_gb,
													   'TOTAL_SAVED'		=> $tot_saved,
													   'TOTAL_ALLOWED'		=> $tot_allowed,
													   'TOTAL_GA_AVG'		=> $gaAvg_total,
													   'TOTAL_SAVE_PCT'		=> $savePct_total,
													   'TOTAL_PENALTIES'	=> $tot_penalties,
													   'TOTAL_MINUTES'		=> $tot_minutes
													   );
							break;
						case 'F':
							$record_total = $tot_won.'-'.$tot_lost;
							$foPct_total = ($tot_won + $tot_lost > 0 ? number_format($tot_won / ($tot_won + $tot_lost), 3) : '0.000');
							$html_module[] = EMAIL_PLAYER_STATS_FACEOFF_FOOTER;
							$html_data_array[] = array('TOTAL_PLAYED'		=> $tot_played,
													   'TOTAL_STARTED'		=> $tot_started,
													   'TOTAL_GOALS'		=> $tot_goals,
													   'TOTAL_ASSISTS'		=> $tot_assists,
													   'TOTAL_POINTS'		=> $tot_points,
													   'TOTAL_SHOTS'		=> $tot_shots,
													   'TOTAL_SHOT_PCT'		=> $shotPct_total,
													   'TOTAL_GB'			=> $tot_gb,
													   'TOTAL_FO_RECORD'	=> $record_total,
													   'TOTAL_FO_PCT'		=> $foPct_total,
													   'TOTAL_PENALTIES'	=> $tot_penalties,
													   'TOTAL_MINUTES'		=> $tot_minutes
													   );
							break;
						case 'R':
							$html_module[] = EMAIL_PLAYER_STATS_FOOTER;
							$html_data_array[] = array('TOTAL_PLAYED'		=> $tot_played,
													   'TOTAL_STARTED'		=> $tot_started,
													   'TOTAL_GOALS'		=> $tot_goals,
													   'TOTAL_ASSISTS'		=> $tot_assists,
													   'TOTAL_POINTS'		=> $tot_points,
													   'TOTAL_SHOTS'		=> $tot_shots,
													   'TOTAL_SHOT_PCT'		=> $shotPct_total,
													   'TOTAL_GB'			=> $tot_gb,
													   'TOTAL_PENALTIES'	=> $tot_penalties,
													   'TOTAL_MINUTES'		=> $tot_minutes
													   );
							break;
					}
				}
				
				//1f. get comments
				$sql = 'SELECT date, comments
						FROM playerComments
						WHERE playerMasterRef='.$playerMasterRef.'
							AND current=\'T\'
						ORDER BY date DESC';
				$comments = $db->db_query($sql);
				if($comments->count_records() > 0){
					//load header
					$html_module[] = EMAIL_PLAYER_COMMENTS_HEADER;
					$html_data_array[] = array('EMAIL_MESSAGE_HTML' => '');
					//load body
					while(!$comments->eof){
						$record_date		= $comments->field['date'];
						$description		= $comments->field['comments'];
						$record_date		= date('m/d/Y', strtotime($record_date));
						$html_module[]		= EMAIL_PLAYER_COMMENTS_BODY;
						$html_data_array[] = array('DATE'			=> $record_date,
												   'DESCRIPTION'	=> $description
												   );
						$comments->move_next();
					}
					//load footer
					$html_module[] = EMAIL_PLAYER_COMMENTS_FOOTER;
					$html_data_array[] = array('EMAIL_MESSAGE_HTML' => '');
				}
				
				//1g. get coach contact
				$sql = 'SELECT o.name, o.street1, o.street2, o.city, o.state, o.zip, o.phone, o.phoneExt, o.phone2, o.email, IF(p.FName!=\'\', CONCAT_WS(\' \', p.FName, p.LName), p.LName) AS player_name
						FROM officials o, playerMaster p
						WHERE o.teamRef='.$teamRef.'
							AND o.type=1
							AND p.reference='.$playerMasterRef;
				$contacts = $db->db_query($sql);
				//get data
				$coach_name			= $contacts->field['name'];
				$player_name		= $contacts->field['player_name'];
				$street1			= $contacts->field['street1'];
				$street2			= $contacts->field['street2'];
				$city				= $contacts->field['city'];
				$state				= $contacts->field['state'];
				$ZIP_Code			= $contacts->field['zip'];
				$telephone1			= $contacts->field['phone'];
				$phoneExt			= $contacts->field['phoneExt'];
				$telephone2			= $contacts->field['phone2'];
				$email				= $contacts->field['email'];
				//process data
				$address = get_address($street1, $city, $state, $ZIP_Code, $street2);
				$coach_address = $address['street'].'<br />'.$address['city'];
				if($telephone1 != ''){
					$telephone1	.= ($phoneExt != '' ? $telephone1.' x'.$phoneExt : $telephone1);
				}else{
					$telephone1	= 'n/a';
				}
				$telephone2 = ($telephone2 != '' ? $telephone2 : 'n/a');
				$email = ($email != '' ? $email : 'n/a');
				//load data
				$html_module[] = EMAIL_COACH_CONTACT;
				$html_data_array[] = array('COACH_NAME'			=> $coach_name,
										   'COACH_ADDRESS'		=> $coach_address,
										   'COACH_TELEPHONE1'	=> $telephone1,
										   'COACH_TELEPHONE2'	=> $telephone2,
										   'COACH_EMAIL'		=> $email,
										   'CURRENT_YEAR'		=> date('Y')
										   );
				
				//1h. get html footer
				$html_module[] = EMAIL_PLAYER_BOTTOM;
				$html_data_array[] = array('EMAIL_MESSAGE_HTML' => 'foo');
				
				//1i. build document
				$attachment = '';
				for($i = 0; $i < count($html_module); $i++){
					$attachment .= set_html_email_text($html_module[$i], $html_data_array[$i]);
				}
				
				//1j. save document
				$player_name = str_replace(' ', '_', $player_name);
				$filename = date('Ymd').'_'.$player_name.'_Statistics.htm';
				$filepath = 'userFiles/tmr_'.$teamMasterRef.'/'.$filename;
				if(!$handle = @fopen($filepath, "w")){
					$message = 'Cannot create attachment.';
				}else{
					if(fwrite($handle, $attachment) === false){
						$message = 'Cannot write attachment to disk.';
					}
					fclose($handle);
				}
				$attachment_array = array('path'		=> $filepath,
										  'name'		=> $filename,
										  'encoding'	=> 'base64',
										  'type'		=> 'text/html'
										  );
			
				if($message == ''){
					//2. build html message
					$html_text = $text;
					$html_text = str_replace("\\r\\n", "\n", $html_text);
					$html_text = str_replace("\\n", '<br />', $html_text);
					$html_text = nl2br($html_text);
					while(strpos($html_text, '  ') !== false){
						$html_text = str_replace('  ', '&nbsp;&nbsp;', $html_text);
					}
					$html_data_array = array();
					$html_module = array();
					$html_data_array[] = array('EMAIL_MESSAGE_HTML' => $html_text);
					$html_module[] = EMAIL_PLAYER;
					
					//3. send mail
					$recipients .= ', '.$_SESSION['user_email'];
					$from_name = (isset($_SESSION['user_first_name']) ? $_SESSION['user_first_name'].' '.$_SESSION['user_last_name'] : $_SESSION['user_last_name']);
					$from_name = '"'.$from_name.'" <'.$_SESSION['user_email'].'>';
					
					$message = send_mail($recipients, $from_name, $_SESSION['user_email'], $subject, $text, $attachment_array, $html_data_array, $html_module);
					$message = ($message != true ? $message : '');
				}
			}
			
			//write to disk
			if($message == '' && $record_id == 0){
				$date = date('Y-m-d', strtotime($date));
				$sql_data_array = array('reference'		=> 'NULL',
										'playerRef'		=> $playerMasterRef,
										'type'			=> $type,
										'date'			=> $date,
										'contact'		=> $contact,
										'sendTo'		=> $recipients,
										'subject'		=> $subject,
										'note'			=> $text,
										'attachment'	=> $attachment,
										'modifiedBy'	=> $_SESSION['user_id'],
										'created'		=> 'now',
										'modified'		=> 'now'
										);
				$message = $db->db_write_array('contactNotes', $sql_data_array);
				if($message == ''){
					$params = get_all_get_params(array('p', 'se', 'a'));
					redirect(set_href(FILENAME_ADMIN_NOTES, $params));
				}
			}
			break;
	}
}

if($record_id > 0){
	$sql = 'SELECT c.type, c.date, c.contact, c.sendTo, c.subject, c.note, c.attachment, c.created, IF(p.FName!=\'\', CONCAT_WS(\' \', p.FName, p.LName), p.LName) AS player_name
			FROM contactNotes c, playerMaster p
			WHERE c.reference='.$record_id.'
				AND p.reference='.$playerMasterRef;
	$notes = $db->db_query($sql);
	//get data
	$type			= $notes->field['type'];
	$date			= $notes->field['date'];
	$contact		= $notes->field['contact'];
	$recipients		= $notes->field['sendTo'];
	$subject		= $notes->field['subject'];
	$text			= $notes->field['note'];
	$attachment		= $notes->field['attachment'];
	$created		= $notes->field['created'];
	$player_name	= $notes->field['player_name'];
	//process data
	$date 				= date('m/d/Y', strtotime($date));
	$created 			= date('m/d/Y', strtotime($created));
	$text2				= nl2br($text);
	$attachment_test	= ($attachment != '' ? true : false);
	$params				= 'r='.$record_id.'&nmh=1';
	$href_attachment	= set_href(FILENAME_ADMIN_NOTE_ATTACHMENT, $params);
	switch($type){
		case 'N':
			$type = 'Note';
			break;
		case 'E':
			$type = 'Laxstats email';
			break;
		case 'S':
			$type = 'Email sent';
			break;
		case 'R':
			$type = 'Email received';
			break;
		case 'L':
			$type = 'Letter';
			break;
		case 'T':
			$type = 'Phone';
			break;
	}
}
$page_header = ($selection > 0 ? 'NOTE FOR ' : 'NEW NOTE ').strtoupper($player_name);
?>
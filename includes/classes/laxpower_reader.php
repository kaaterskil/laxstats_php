<?php
class laxpower_reader{
	/*************************************************************
	DECLARE VARIABLES
	*************************************************************/
	var $team_urls = array();
	var $pre_dedupe = 0;
	var $post_dedupe = 0;
	var $results = array('new'			=> 0,
						 'updated'		=> 0,
						 'ignored'		=> 0,
						 'neutral'		=> 0,
						 'failed1'		=> 0,
						 'failed2'		=> 0,
						 'no_match'		=> 0,
						 'pre_dedupe'	=> 0,
						 'post_dedupe'	=> 0
						 );
	/*************************************************************
	CONSTRUCTOR
	*************************************************************/
	function laxpower_reader($href, $season, $start_string){
		$this->set_season($season);
		$this->set_start_string($start_string);
		$this->set_end_string('conferences');
		$this->processor($href);
		$this->summarize();
	}
	
	/*************************************************************
	FUNCTIONS
	*************************************************************/
	/*------------------------------------------------------------
	CONTROLLER
	------------------------------------------------------------*/
	function processor($href){
		//read conference page
		$result = $this->read_file($href);
		if(!$result){
			$this->results['message'][] = 'ERROR: Could not read master file.';
			return;
		}
		//parse page
		$result = $this->parse_file();
		if(!$result){
			$this->results['message'][] = 'ERROR: Delimeters not found in master document.';
			return;
		}
		//get team urls
		$this->get_team_urls();
		//loop through teams and get data
		for($i = 0; $i < count($this->team_urls); $i++){
			//read page
			$team_page = $this->team_urls[$i];
			$team_href = 'http://www.laxpower.com/update'.$this->season.'/binboy/'.$team_page;
			$result = $this->read_file($team_href);
			if($result){
				//parse page
				$this->set_start_string('NAME="'.substr($team_page, 1, 3).'"');
				$this->set_end_string(' ----- ');
				$result = $this->parse_file();
				if($result){
					//set team data
					$us_team			= substr($this->text, 12, 22);
					$us_state			= substr($team_page, 4, 2);
					$this->team_name	= $this->set_team_town($us_team);
					$this->teamRef		= $this->set_teamRef($this->team_name, $us_state);
					if($this->teamRef == 0){
						$this->results['message'][] = 'ERROR: Unable to find ID for '.$this->team_name.' ('.$us_state.')';
					}else{
						//get games
						$this->get_games();
						if(isset($this->raw_games['date'])){
							$this->de_dupe();
							$this->save();
						}
					}
				}else{
					$this->results['message'][] = 'ERROR: Delimeters not found in '.$team_page.' document.';
				}
			}else{
				$this->results['message'][] = 'ERROR: Could not read '.$team_page.' file.';
			}
		}//end for
	}
	
	/*------------------------------------------------------------
	READ FILE
	------------------------------------------------------------*/
	function read_file($href){
		ini_set('user_agent', 'Mozilla: (compatible; Windows XP)');
		$handle = @fopen($href, "rb");
		if(!$handle){
			return false;
		}
		$this->buffer = '';
		while(!feof($handle)){
			$this->buffer .= fread($handle, 65536);
		}
		fclose($handle);
		return true;
	}

	/*------------------------------------------------------------
	DISCARD UNNECESSARY DATA
	------------------------------------------------------------*/
	function parse_file(){
		$start = strpos($this->buffer, $this->start_string);
		$end = strpos($this->buffer, $this->end_string);
		if($start && $end){ 
			$length = $end - $start;
			$this->text = substr($this->buffer, $start, $length);
			return true;
		}else{
			$this->text = '';
			return false;
		}
	}

	/*------------------------------------------------------------
	GET TEAM PAGE URLS
	------------------------------------------------------------*/
	function get_team_urls(){
		$parts = preg_split('/"/', $this->text);
		for($i = 0; $i < count($parts); $i++){
			$test = ereg("([a-zA-Z]+\.PHP)", $parts[$i], $uri);
			if($test){
				if(!in_array($uri[0], $this->team_urls)){
					$this->team_urls[] = $uri[0];
				}
			}
		}
	}
	
	/*------------------------------------------------------------
	GET GAMES
	------------------------------------------------------------*/
	function get_games(){
		$this->raw_games = array();
		$parts = preg_split("/\n/", $this->text);
		for($i = 0; $i < count($parts); $i++){
			//parse data
			$test = ereg("^ ([0-9]{3}) ([A|H|N]) (.+)$", $parts[$i], $game);
			if($test){
				//process data
				$month			= intval(substr($game[1], 0, 1));
				$day			= intval(substr($game[1], 1, 2));
				$date			= mktime(0, 0, 0, $month, $day, $this->season);
				$versus			= $game[2];
				$them_town		= substr($game[3], 0, 22);
				$them_state		= substr($game[3], 23 ,2);
				$them_town		= $this->set_team_town($them_town);
				$them_teamRef	= $this->set_teamRef($them_town, $them_state);
				$us_score		= intval(substr($game[3], 38, 2));
				$them_score		= intval(substr($game[3], 41, 2));
				//add to array
				if($them_teamRef > 0){
					$this->raw_games['date'][]	= $date;
					$this->raw_games['vs'][]	= $versus;
					if($versus == 'H'){
						$this->raw_games['hTeam'][]		= $this->team_name;
						$this->raw_games['hTeamRef'][]	= $this->teamRef;
						$this->raw_games['vTeam'][]		= $them_town;
						$this->raw_games['vTeamRef'][]	= $them_teamRef;
						$this->raw_games['hScore'][]	= $us_score;
						$this->raw_games['vScore'][]	= $them_score;
					}else{
						$this->raw_games['hTeam'][]		= $them_town;
						$this->raw_games['hTeamRef'][]	= $them_teamRef;
						$this->raw_games['vTeam'][]		= $this->team_name;
						$this->raw_games['vTeamRef'][]	= $this->teamRef;
						$this->raw_games['hScore'][]	= $them_score;
						$this->raw_games['vScore'][]	= $us_score;
					}
				}else{
					$this->results['message'][] = 'ERROR: Unable to find ID for '.$them_town.' ('.$them_state.')';
					$this->results['no_match']++;
				}
			}
		}//end for
	}

	/*------------------------------------------------------------
	DE-DUPE GAMES
	------------------------------------------------------------*/
	function de_dupe(){
		$this->clean_games = array();
		$date = null;
		$hTeam = 0;
		$vTeam = 0;
		$this->results['pre_dedupe'] += count($this->raw_games['date']);
		
		array_multisort($this->raw_games['date'], $this->raw_games['hTeam'], $this->raw_games['hTeamRef'], $this->raw_games['vTeam'], $this->raw_games['vTeamRef'], $this->raw_games['hScore'], $this->raw_games['vScore'], $this->raw_games['vs']);
		
		for($i = 0; $i < count($this->raw_games['date']); $i++){
			if($this->raw_games['date'][$i] != $date || $this->raw_games['hTeam'][$i] != $hTeam || $this->raw_games['vTeam'][$i] != $vTeam){
				$date = $this->raw_games['date'][$i];
				$hTeam = $this->raw_games['hTeam'][$i];
				$vTeam = $this->raw_games['vTeam'][$i];
				
				$this->clean_games['date'][]		= $this->raw_games['date'][$i];
				$this->clean_games['hTeam'][]		= $this->raw_games['hTeam'][$i];
				$this->clean_games['hTeamRef'][]	= $this->raw_games['hTeamRef'][$i];
				$this->clean_games['vTeam'][]		= $this->raw_games['vTeam'][$i];
				$this->clean_games['vTeamRef'][]	= $this->raw_games['vTeamRef'][$i];
				$this->clean_games['vs'][]			= $this->raw_games['vs'][$i];
				$this->clean_games['hScore'][]		= $this->raw_games['hScore'][$i];
				$this->clean_games['vScore'][]		= $this->raw_games['vScore'][$i];
			}
		}
		$this->results['post_dedupe'] += count($this->clean_games['date']);
	}

	/*------------------------------------------------------------
	SAVE TO DISK
	------------------------------------------------------------*/
	function save(){
		global $db;
		global $_SESSION;
		for($i = 0; $i < count($this->clean_games['date']); $i++){
			//get data
			$date		= date('Y-m-d', $this->clean_games['date'][$i]);
			$hTeam		= $this->clean_games['hTeam'][$i];
			$vTeam		= $this->clean_games['vTeam'][$i];
			$hTeamRef	= $this->clean_games['hTeamRef'][$i];
			$vTeamRef	= $this->clean_games['vTeamRef'][$i];
			$vs			= $this->clean_games['vs'][$i];
			$hScore		= intval($this->clean_games['hScore'][$i]);
			$vScore		= intval($this->clean_games['vScore'][$i]);
			$userRef	= $_SESSION['user_id'];
			//test for new record
			$sql = 'SELECT gameRef, hTeamRef, vTeamRef, hScore, vScore
					FROM gamesShort
					WHERE date=\''.$date.'\'
						AND (hTeamRef='.$hTeamRef.' OR hTeamRef='.$vTeamRef.')
						AND(vTeamRef='.$hTeamRef.' OR vTeamRef='.$vTeamRef.')';
			$test = $db->db_query($sql);
			if($test->field['gameRef'] > 0){
				$gameRef = $test->field['gameRef'];
				$hTeamRef_test = $test->field['hTeamRef'];
				$vTeamRef_test = $test->field['vTeamRef'];
				//test for home team
				if($hTeamRef == $hTeamRef_test){
					$hScore_test = $test->field['hScore'];
					$vScore_test = $test->field['vScore'];
					//test if scores have changed
					if($hScore != $hScore_test || $vScore != $vScore_test){
						$sql_data_array = array('hScore'		=> strval($hScore),
												'vScore'		=> strval($vScore),
												'modifiedBy'	=> $userRef,
												'modified'		=> 'now'
												);
						$param = 'gameRef='.$gameRef;
						$message = $db->db_write_array('gamesShort', $sql_data_array, 'update', $param);
						if($message != ''){
							$this->results['message'][] = 'Update error for '.$hTeam.' vs '.$vTeam.' on '.$date;
							$this->results['failed1']++;
						}else{
							$this->results['message'][] = $date.' '.$hTeam.' ('.$hTeamRef.') vs '.$vTeam.' ('.$vTeamRef.') '.$hScore.'-'.$vScore.' UPDATED';
							$this->results['updated']++;
						}
					}else{
						$this->results['ignored']++;
					}
				}else{
					$this->results['neutral']++;
				}
			}else{
				$sql_data_array = array('gameRef'		=> NULL,
										'date'			=> $date,
										'hTeamRef'		=> $hTeamRef,
										'vTeamRef'		=> $vTeamRef,
										'hScore'		=> strval($hScore),
										'vScore'		=> strval($vScore),
										'modifiedBy'	=> $userRef,
										'created'		=> 'now',
										'modified'		=> 'now'
										);
				$message = $db->db_write_array('gamesShort', $sql_data_array);
				if($message != ''){
					$this->results['message'][] = 'Write error for '.$hTeam.' vs '.$vTeam.' on '.$date;
					$this->results['failed2']++;
				}else{
					$this->results['message'][] = $date.' '.$hTeam.' ('.$hTeamRef.') vs '.$vTeam.' ('.$vTeamRef.') '.$hScore.'-'.$vScore.' WRITTEN';
					$this->results['new']++;
				}
			}
		}//end for
	}

	
	/*************************************************************
	OTHER FUNCTIONS
	*************************************************************/
	/*------------------------------------------------------------
	SUMMARIZE ACTION
	------------------------------------------------------------*/
	function summarize(){
		$message = '<br>SUMMARY:<br>';
		$message .= 'Raw games: '.$this->results['pre_dedupe'].'<br>';
		$message .= 'Games after de-duping: '.$this->results['post_dedupe'].'<br>';
		$message .= 'Records with teams not matched to system: '.$this->results['no_match'].'<br>';
		$message .= 'Neutral games screened (ignored): '.$this->results['neutral'].'<br>';
		$message .= 'Records not changed (ignored): '.$this->results['ignored'].'<br>';
		$message .= 'New records written: '.$this->results['new'].'<br>';
		$message .= 'New records failed to write: '.$this->results['failed2'].'<br>';
		$message .= 'Existing records updated: '.$this->results['updated'].'<br>';
		$message .= 'Existing records failed to update: '.$this->results['failed1'].'<br>';
		$this->results['message'][] = $message;
	}
	
	/*------------------------------------------------------------
	SET TEAM NAME
	------------------------------------------------------------*/
	function set_team_town($town){
		$town = str_replace('AL Johnson/Clark', 'A.L.Johnson-Clark', $town);
		$town = str_replace('Cath'.chr(32), 'Catholic', $town);
		$town = str_replace('Bros', 'Brothers', $town);
		$town = str_replace('St Johns', 'St John\'s', $town);
		$town = str_replace('St Albans', 'St Alban\'s', $town);
		$town = str_replace('St Marys', 'St Mary\'s', $town);
		$town = str_replace('Peters ', 'Peter\'s ', $town);
		$town = str_replace(' Twp', '', $town);
		$town = str_replace('/', ' ', $town);
		$town = str_replace('St ', 'St. ', $town);
		$town = str_replace('Gr.', 'Gr. ', $town);
		$town = str_replace('& ', '', $town);
		
		$pos = strpos($town, 'HS');
		if($pos){
			$town = substr($town, 0, $pos);
		}
		$pos = strpos($town, 'Central');
		if($pos){
			$town = substr($town, 0, $pos);
		}
		$pos = strpos($town, 'Reg Vo Tech');
		if($pos){
			$town = substr($town, 0, $pos);
		}
		$pos = strpos($town, 'Vo Tech');
		if($pos){
			$town = substr($town, 0, $pos);
		}
		$pos = strpos($town, 'V-T');
		if($pos){
			$town = substr($town, 0, $pos);
		}
		$pos = strpos($town, 'VoTech');
		if($pos){
			$town = substr($town, 0, $pos);
		}
		$pos = strpos($town, 'Tech');
		if($pos){
			$town = substr($town, 0, $pos);
		}
		$town = rtrim($town);
		$len = strlen($town);
		if($len > 21){
			//look for a previous hyphen
			$pos = strrpos($town, chr(45));
			if(!$pos){
				//look for a previous space
				$pos=strrpos($town, chr(32));
			}
			$town = substr($town, 0, $pos);
		}
		return $town;
	}

	/*------------------------------------------------------------
	SET TEAM ID
	------------------------------------------------------------*/
	function set_teamRef($team, $state){
		global $db;
		$teamRef = 0;
		$town = ereg_replace('\'', '\\\\\\\'', $team);
		$town_wc = $town.'%';
		for($i = 0; $i < 4; $i++){
			switch($i){
				case 0:
					$sql = 'SELECT teamMasterRef
							FROM teamsMaster
							WHERE town=\''.$town.'\' 
								AND state=\''.$state.'\'';
					break;
				case 1:
					$sql = 'SELECT teamMasterRef
							FROM teamsMaster
							WHERE town LIKE \''.$town_wc.'\'
								AND state=\''.$state.'\'';
					break;
				case 2:
					$sql = 'SELECT teamMasterRef
							FROM teamsMaster
							WHERE town=\''.$town.'\'';
					break;
				case 3:
					$sql = 'SELECT teamMasterRef
							FROM teamsMaster
							WHERE town LIKE \''.$town_wc.'\'';
					break;
			}
			$result = $db->db_query($sql);
			if(count($result->result['teamMasterRef']) > 0){
				$teamRef = $result->field['teamMasterRef'];
				break;
			}
		}
		return $teamRef;
	}

	/*------------------------------------------------------------
	SET START STRING
	------------------------------------------------------------*/
	function set_start_string($start_string){
		$this->start_string = $start_string;
	}

	/*------------------------------------------------------------
	SET END STRING
	------------------------------------------------------------*/
	function set_end_string($end_string){
		$this->end_string = $end_string;
	}

	/*------------------------------------------------------------
	SET SEASON
	------------------------------------------------------------*/
	function set_season($season){
		$this->season = $season;
	}
}
?>
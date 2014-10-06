<?php
class emailer{
	/*************************************************************
	DECLARE VARIABLES
	*************************************************************/
	var $subject = '';
	var $headers = '';
	var $body = '';
	var $from = '';
	var $from_name = '';
	var $eol = '';
	
	var $to = array();
	var $reply_to = array();
	var $attachment = array();
	
	var $message_type = 'plain';
	var $boundary = '';
	var $content_type = 'text/plain';
	var $charset = 'iso-8859-1';
	var $encoding = '7bit';
	
	/*************************************************************
	GETTER FUNCTIONS
	*************************************************************/
	/*------------------------------------------------------------
	GET RECIPIENT ARRAY
	------------------------------------------------------------*/
	function get_recipients($string){
		$addresses = explode(', ', $string);
		foreach($addresses as $value){
			$element = count($this->to);
			$this->to[$element] = $value;
		}
	}
		
	/*------------------------------------------------------------
	GET REPLY-TO ARRAY
	------------------------------------------------------------*/
	function get_reply_to($string){
		$addresses = explode(', ', $string);
		foreach($addresses as $value){
			$element = count($this->reply_to);
			$this->reply_to[$element] = $value;
		}
	}
	
	/*------------------------------------------------------------
	GET ATTACHMENT ARRAY
	------------------------------------------------------------*/
	function get_attachment($path, $name = '', $encoding = 'base64', $type = 'text/html'){
		if(!@is_file($path)){
			return false;
		}
		$filename = basename($path);
		$name = ($name == '' ? $file_name : $name);
		
		$element = count($this->attachment);
		$this->attachment[$element] = array('path'			=> $path,
											'filename'		=> $filename,
											'name'			=> $name,
											'encoding'		=> $encoding,
											'type'			=> $type,
											'disposition'	=> 'attachment'
											);
		$this->get_message_type();
		return true;
	}
	
	/*------------------------------------------------------------
	GET MESSAGE TYPE
	------------------------------------------------------------*/
	function get_message_type(){
		if(count($this->attachment) < 1){
			$this->message_type = 'plain';
		}else{
			$this->message_type = 'attachments';
		}
	}
	
	/*------------------------------------------------------------
	GET CONTENT TYPE
	------------------------------------------------------------*/
	function get_content_type($html_test){
		if($html_test){
			$this->content_type = 'text/html';
		}else{
			$this->content_type = 'text/plain';
		}
	}

	/*************************************************************
	SETTER FUNCTIONS
	*************************************************************/
	/*------------------------------------------------------------
	SET END-OF-LINE CHARACTERS
	------------------------------------------------------------*/
	function set_eol(){
		if(strtolower(substr(PHP_OS, 0, 3)) == 'win'){
			$this->eol = "\r\n";
		}elseif(strtolower(substr(PHP_OS, 0, 3)) == 'mac'){
			$this->eol = "\r";
		}else{
			$this->eol = "\n";
		}
	}
	
	/*------------------------------------------------------------
	FIX END-OF-LINE CHARACTERS
	Changes every eol from CR or LF to CRLF
	------------------------------------------------------------*/
	function fix_eol($r){
		$r = str_replace("\r\n", "\n", $r);
		$r = str_replace("\r", "\n", $r);
		$t = str_replace("\n", $this->eol, $r);
		return $r;
	}
	
	/*------------------------------------------------------------
	SET RECIPIENTS
	------------------------------------------------------------*/
	function set_recipients(){
		$r = '';
		foreach($this->to as $value){
			$r .= $value.', ';
		}
		$r = substr($r, 0, -2);
		return $r;
	}
	
	/*------------------------------------------------------------
	SET ADDRESSES
	------------------------------------------------------------*/
	function set_addresses($param, $array){
		$r = $param.': ';
		foreach($array as $value){
			$r .= $value.', ';
		}
		$r = substr($r, 0, -2);
		$r .= $this->eol;
		return $r;
	}
	
	/*------------------------------------------------------------
	SET BOUNDARY
	------------------------------------------------------------*/
	function set_boundary(){
		$id = md5(uniqid(time()));
		$this->boundary = 'LAXSTATS-'.$id;
	}
	
	/*------------------------------------------------------------
	SET HEADER LINE
	------------------------------------------------------------*/
	function set_header_line($param, $value){
		$r = '';
		if($param != '' && $value != ''){
			$r = $param.': '.$value;
			$r .= $this->eol;
		}
		return $r;
	}
	
	/*------------------------------------------------------------
	ENCODE FILE
	------------------------------------------------------------*/
	function encode_file($path, $encoding = 'base64'){
		if(!$handle = @fopen($path, "rb")){
			return false;
		}
		$r = fread($handle, filesize($path));
		$r = $this->encode_string($r, $encoding);
		fclose($handle);
		return $r;
	}
	
	/*------------------------------------------------------------
	ENCODE STRING
	------------------------------------------------------------*/
	function encode_string($string, $encoding = 'base64'){
		$r = '';
		switch(strtolower($encoding)){
			case 'base64':
				$r = chunk_split(base64_encode($string));
				break;
			case '7bit':
			case '8bit':
				$r = $this->fix_eol($string);
				if(substr($r, -(strlen($this->eol))) != $this->eol){
					$r .= $this->eol;
				}
				break;
			case 'binary':
				$r = $string;
				break;
			default:
				$r = $string;
				break;
		}
		return $r;
	}
	
	/*------------------------------------------------------------
	SET HEADERS
	------------------------------------------------------------*/
	function set_headers(){
		$r = '';
		$r = $this->set_header_line('From', $this->from_name);
		if(count($this->reply_to) > 0){
			$r .= $this->set_addresses('Reply-To', $this->reply_to);
		}
		$r .= $this->set_header_line('Return-Path', $this->from);
		$r .= $this->set_header_line('X-Mailer', 'PHP v'.phpversion());
		$r .= $this->set_header_line('MIME-Version', '1.0');
		switch($this->message_type){
			case 'plain':
				$r .= sprintf('Content-Type: %s; charset="%s"', $this->content_type, $this->charset).$this->eol;
				break;
			case 'attachments':
				$r .= sprintf('Content-Type: %s; boundary="%s"', 'multipart/mixed', $this->boundary).$this->eol;
				break;
		}
		return $r;
	}
	
	/*------------------------------------------------------------
	SET ATTACHMENTS
	------------------------------------------------------------*/
	function set_body(){
		switch($this->message_type){
			case 'plain':
				$r = $this->body;
				break;
			case 'attachments':
				$r = $this->set_attachments();
				$r .= sprintf('--%s%s', $this->boundary, $this->eol);
				$r .= sprintf('Content-Type: %s; charset="%s"%s', $this->content_type, $this->charset, $this->eol);
				$r .= sprintf('Content-Transfer-Encoding: %s%s', $this->encoding, $this->eol);
				$r .= $this->encode_string($this->body, $this->encoding);
				$r .= $this->eol.$this->eol;
				$r .= sprintf('--%s--%s%s', $this->boundary, $this->eol, $this->eol);
				break;
		}
		return $r;
	}
	
	/*------------------------------------------------------------
	SET ATTACHMENTS
	------------------------------------------------------------*/
	function set_attachments(){
		$mime = array();
		for($i = 0; $i < count($this->attachment); $i++){
			$path			= $this->attachment[$i]['path'];
			$filename		= $this->attachment[$i]['filename'];
			$name			= $this->attachment[$i]['name'];
			$encoding		= $this->attachment[$i]['encoding'];
			$type			= $this->attachment[$i]['type'];
			$disposition	= $this->attachment[$i]['disposition'];
			
			$mime[] = sprintf('--%s', $this->boundary).$this->eol;
			$mime[] = sprintf('Content-Type: %s; name="%s"', $type, $name).$this->eol;
			$mime[] = sprintf('Content-Transfer-Encoding: %s', $encoding).$this->eol;
			$mime[] = sprintf('Content-Disposition: %s; filename="%s"', $disposition, $filename).$this->eol.$this->eol;
			$mime[] = $this->encode_file($path, $encoding).$this->eol.$this->eol;
		}
		return join('', $mime);
	}

	/*************************************************************
	ACTION FUNCTIONS
	*************************************************************/
	/*------------------------------------------------------------
	PREP MAIL
	------------------------------------------------------------*/
	function process_mail(){
		$result = true;
		
		if(count($this->to) < 1){
			return 'No email address.';
		}
		$this->set_eol();
		$this->get_message_type();
		$this->set_boundary();
		$headers = $this->set_headers();
		$body = $this->set_body();
		
		if($body == ''){
			return 'Empty email body.';
		}
		$result = $this->send_mail($headers, $body);
		return $result;
	}
	
	/*------------------------------------------------------------
	SEND MAIL
	------------------------------------------------------------*/
	function send_mail($headers, $body){
		$to = $this->set_recipients();
		//ini_set(sendmail_from, $this->from_name);
		$test = @mail($to, $this->subject, $body, $headers);
		if(!$test){
			return 'The email could not be sent.';
		}
		return true;
	}
}
?>
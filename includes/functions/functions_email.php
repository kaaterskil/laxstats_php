<?php
/*----------------------------------------------------------------------
SEND EMAIL
----------------------------------------------------------------------*/
function send_mail($recipients, $from_name, $from_address, $subject, $text, $attachment = array(), $html_array = array(), $html_module = array()){
	//1. validation
	//a. test for email enabling
	if(SEND_EMAILS != 'true'){
		return 'Email is not enabled.';
	}
	//b. test for injection
	$test = array($recipients, $from_name, $from_address, $subject);
	foreach($test as $key => $value){
		if(eregi("\r", $value) || eregi("\n", $value)){
			return 'There are invalid characters in the email.';
		}
	}
	//c. test for text
	if(!isset($text) && !isset($html_array['EMAIL_MESSAGE_HTML'])){
		return 'There is no text.';
	}
	if(!not_null($text) && !not_null($html_array['EMAIL_MESSAGE_HTML'])){
		return 'There is no text.';
	}
	//d. test for sender name
	if($from_name == $from_address || $from_name == ''){
		$from_name = COMPANY_NAME.' <'.COMPANY_EMAIL_ADDRESS.'>';
	}
	
	//2. process data
	//a. build html
	if(!is_array($html_module)){
		$html_module = array($html_module);
	}
	$html_text = '';
	for($i = 0; $i < count($html_module); $i++){
		$html_text .= set_html_email_text($html_module[$i], $html_array[$i]);
	}
	
	//b. clean up
	while(strstr($text, '&amp;&amp;')){
		$text = str_replace('&amp;&amp;', '&amp;', $text);
	}
	while(strstr($text, '&amp;')){
		$text = str_replace('&amp;', '&', $text);
	}
	while(strstr($text, '&&')){
		$text = str_replace('&&', '&', $text);
	}
	while(strstr($text, '&quot;')){
		$text = str_replace('&quot;', '"', $text);
	}
	$text = stripslashes($text);
	$html_text = stripslashes($html_text);
	
	//c. if text is null, use the html text and replace tags
	if(!not_null($text) && (isset($html_array[0]['EMAIL_MESSAGE_HTML']) && $html_array[0]['EMAIL_MESSAGE_HTML'] != '')){
		$text = str_replace('<br[[:space::]]*/?[[:space:]]*>', "\n", $html_array[0]['EMAIL_MESSAGE_HTML']);
		$text = str_replace('</p>', "</p>\n", $text);
		$text = htmlspecialchars(stripslashes(strip_tags($text)));
	}else{
		//$text = strip_tags($text);
	}
	$text = wordwrap($text, 70);
	
	//d. build mail object
	if($text == '' && $html_text == ''){
		return 'There is no text.';
	}
	$mail = new emailer();
	$mail->subject		= $subject;
	$mail->from_name	= $from_name;
	$mail->from			= $from_address;
	$mail->get_recipients($recipients);
	$mail->get_reply_to($from_name);
	if(isset($attachment['path']) && $attachment['path'] != ''){
		$mail->get_attachment($attachment['path'], $attachment['name'], $attachment['encoding'], $attachment['type']);
	}
	
	//e. load body
	$html_test = (HTML_EMAIL_ENABLED == 'true' ? true : false);
	$mail->get_content_type($html_test);
	if($html_test){
		$mail->body = $html_text;
	}else{
		$mail->body = $text;
	}
	
	//f. send mail
	$message = $mail->process_mail();
	if($message != true){
		return $message;
	}else{
		return true;
	}
}

/*----------------------------------------------------------------------
BUILD HTML EMAIL MESSAGE
----------------------------------------------------------------------*/
function set_html_email_text($module = '', $data = array()){
	//1. test for data
	if(count($data) < 1){
		return false;
	}
	if($module == ''){
		$module = HTML_EMAIL_DEFAULT_MODULE;
	}
	//2. read template module
	if(!$handle = @fopen($module, "rb")){
		return false;
	}
	$buffer = fread($handle, filesize($module));
	fclose($handle);
	//3. strip tabs
	$buffer = str_replace(array("\t"), ' ', $buffer);
	//4. replace template items with data
	foreach($data as $key => $value){
		$buffer = str_replace('$'.$key, $value, $buffer);
	}
	return $buffer;
}

/*----------------------------------------------------------------------
VALIDATE EMAIL
----------------------------------------------------------------------*/
function validate_email($email){
	$ip_pattern = '[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}';
	$email_pattern = '^[a-zA-Z0-9]+[a-zA-Z0-9_\.\-]*@[a-zA-Z0-9]+[a-zA-Z0-9\.\-]*\.(([a-zA-Z]{2,6})|([0-9]{1,3}))$';
	
	//test for '@' sign
	if(!strstr($email, '@')){
		return false;
	}
	//split email into user/domain strings
	list($user, $domain) = explode('@', $email);
	
	//strip quotes and white space from user, if existing
	if(ereg('^["]', $user) && ereg('["]$', $user)){
		$user = ereg_replace('^["]', '', $user);
		$user = ereg_replace('["]$', '', $user);
		$user = ereg_replace('[\s]', '', $user);
		$email = $user.'@'.$domain;
	}
	
	//test for white space in domain
	if(strstr($domain, ' ')){
		return false;
	}
	
	//test against IP address pattern
	if(ereg($ip_pattern, $domain)){
		$parts = explode('.', $domain);
		//test that IP address parts have values under 256
		for($i = 0; $i < 4; $i++){
			if($parts[$i] > 255){
				return false;
				exit;
			}
		}
		//test for internal IP address
		if($parts[0] == 192 || $parts[0] == 10){
			return false;
		}
	}
	
	//test against email pattern
	if(eregi($email_pattern, $email)){
		return true;
	}else{
		return false;
	}
}
?>
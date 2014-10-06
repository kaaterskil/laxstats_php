/*======================================================================
LOGIN FUNCTIONS
======================================================================*/
/*----------------------------------------------------------------------
EMAIL VALIDATION
----------------------------------------------------------------------*/
function validate_email(email){
	if(email.length <= 0){
		return false;
	}
	var parts = email.match('^(.+)@(.+)$');
	if(parts == null){
		return false;
	}
	if(parts[1] != null){
		var pattern_user = /^\"?[\w-_\.]\"?$/;
		if(parts[1].match(pattern_user) == null){
			return false;
		}
	}
	if(parts[2] != null){
		var pattern_domain = /^[\w-\.]*\.[A-Za-z]{2,4}$/;
		if(parts[2].match(pattern_domain)  ==  null){
			var pattern_ip = /^[\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}]$/;
			if(parts[2].match(pattern_ip) == null){
				return false;
			}
		}
		return true;
	}
}

/*----------------------------------------------------------------------
RETURNING USER VALIDATION
----------------------------------------------------------------------*/
function returning_user(f){
	var u = f.username;
	if(u.length <= 0){
		alert('Please enter a username or email address');
		return false;
	}
	var w = false;
	for(var i = 0; i<u.length; i++){
		var c = u.value.charAt(i);
		if((c == ' ')||(c == "\n")||(c == "\t")){
			w = true;
		}
	}
	if(w == true){
		alert('The username must not contain whitespace.');
		return false;
	}
	var e = validate_email(u.value);
	if(e == false){
		return false;
	}
	return true;
}


/*----------------------------------------------------------------------
NEW USER VALIDATION
----------------------------------------------------------------------*/
function new_user(url){
	window.location.href = url;
}

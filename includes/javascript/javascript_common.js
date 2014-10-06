// JavaScript Document
/*--------------------------------------------------
FIND DOM ELEMENT
--------------------------------------------------*/
function find_DOM(e){
	if(document.getElementById){
		var f = document.getElementById(e);
	}else if(document.all){
		var f = document.all[e];
	}else if(document.layers){
		var f = document.layers[e];
	}
	return f;
}

/*--------------------------------------------------
OPEN POP-UP WINDOW
--------------------------------------------------*/
function open_popup(r, url, w, h){
	var x = (screen.availWidth - w) / 2;
	var y = (screen.availHeight - h) / 2;
	r = window.open(url, r, 'toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=no,width=' + w + ',height=' + h + ',left=' + x + ',top=' + y);
}
function open_image_popup(r, url, w, h){
	var x = (screen.availWidth - w) / 2;
	var y = (screen.availHeight - h) / 2;
	r = window.open(url, r, 'toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=no,resizable=no,width=' + w + ',height=' + h + ',left=' + x + ',top=' + y);
}

/*--------------------------------------------------
CLOSE POP-UP WINDOW
--------------------------------------------------*/
function close_window(){
	window.close();
}

/*--------------------------------------------------
OPEN DATA ENTRY INFORMATION WINDOW
FOR COMPLIANT BROWSERS, THE INFO WINDOW WILL OPEN
EITHER LEFT OR RIGHT OF THE MAIN WINDOW DEPENDING
ON AVAILABLE ROOM. FOR NON-COMPLIANT BROWSERS (IE),
THE WINDOW OPENS IN THE CENTER OF THE SCREEN
--------------------------------------------------*/
function openInfo(a){
	var w = screen.availWidth;
	var h = screen.availHeight;
	var x = 0;
	var y = (h / 2) - 200;
	if(window.screenX){
		var px = window.screenX;
		if(px < 305){
			if(window.outerWidth){
				var pw = px + window.outerWidth;
				if(w - pw > 305){
					x = pw;
				}
			}else{
				x = (w / 2) - 150;
			}
		}else{
			x = px - 305;
		}
	}else{
		x = 100;
	}
	var info = window.open('includes/modules/help/information.htm#' + a, 'info', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=300,height=400,left=' + x + ',top=' + y);
	return false;
}

/*--------------------------------------------------
POSITION FOOTER AT BOTTOM OF WINDOW
--------------------------------------------------*/
function set_footer(e){
	//test for all three methods
	var sh1 = window.innerHeight ? window.innerHeight : 0;
	var sh2 = document.documentElement ? document.documentElement.clientHeight : 0;
	var sh3 = document.body ? document.body.clientHeight : 0;
	
	//determine highest number
	var sh = sh1 ? sh1 : 0;
	sh = sh2 && (!sh || sh < sh2) ? sh2 : sh;
	sh = sh3 && (!sh || sh < sh3) ? sh3 : sh;
	
	//get bottom of footer
	var f = find_DOM(e);
	if(f){
		var h = f.offsetHeight;
		var fb = f.offsetTop + h;
		
		//compare dimensions
		if(sh > fb){
			f.style.position = 'absolute';
			f.style.top = (sh - h) + 'px';
		}
	}
}

/*----------------------------------------------------------------------
SET CURRENCY FORMAT FOR FORM INPUT FIELDS
----------------------------------------------------------------------*/
function dollar_format(obj){
	var v = obj.value;
	var r = '0.00';
	var c = 0;
	var parts = v.split('.')
	if(parts[0] == '' || parts[0] == null){
		parts[0] = '0';
	}
	if(parts.length == 1){
		r = parts[0] + '.00';
	}else{
		var length = parts[1].length;
		if(length > 2){
			c = parts[1].substr(0, 2) + '.' + parts[1].substr(2, 1);
			c = Math.round(c);
		}else if(length == 1){
			c = parts[1] + '0';
		}else{
			c = parts[1];
		}
		r = parts[0] + '.' + c;
	}
	obj.value = r;
}

/*----------------------------------------------------------------------
SET TELEPHONE FORMAT FOR FORM INPUT FIELDS
----------------------------------------------------------------------*/
function telephone_format(obj){
	var r = '';
	var v = obj.value;
	var p = /^\(?([2-9]\d{2})\)?(?:\-?|\s?)([2-9]\d{2})(?:\-?|\s?)(\d{4})$/;
	var t = v.match(p);
	if(t){
		if(t.length == 4){
			r = t[1] + '-' + t[2] + '-' + t[3];
		}else{
			r = t[1] + '-' + t[2];
		}
		obj.value = r;
		return true;
	}
	return false;
}

/*----------------------------------------------------------------------
SET TO UPPERCASE
----------------------------------------------------------------------*/
function uppercase(obj){
	if(obj.value){
		obj.value.toUpperCase();
	}
}

/*----------------------------------------------------------------------
GET REGEXP PATTERN
----------------------------------------------------------------------*/
function set_regexp_pattern(ty){
	var r = '';
	var p_html_text		= /^[a-zA-Z0-9_\-\='"\.\!\:\s,<>\/]+$/;
	var p_text			= /^[a-zA-Z0-9_\-'"\.\!\:\s,]+$/;
	var p_int			= /^\d+$/;
	var p_float			= /^[0-9\.]+$/;
	var p_dollar		= /^[0-9]*(\.[0-9]*)?$/;
	var p_keyword		= /[a-zA-Z0-9_\-'\s]+/;
	var p_state			= /^[a-zA-Z]{2}$/;
	var p_ZIP_Code		= /^\d{5}-\d{4}|\d{5}|[A-Z]\d[A-Z] \d[A-Z]\d$/;
	var p_telephone		= /^\(?([2-9][0-9][0-9])\)?(?:[\-\.\s])?([2-9][0-9][0-9])(?:[\-\.\s])?([0-9]{4})$/;
	var p_email			= /([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,6})/;
	var p_year			= /^([1][9][0-9][0-9]|[2][0][0-9][0-9])$/;
	var p_jerseyNo		= /^([1-9]|[1-9][0-9]|[1-9][0-9][0-9])$/;
	var p_url			= /^((http|https)\:\/\/)?(([a-zA-Z0-9_\-]{2,}\.)+[a-zA-Z]{2,})(\:[a-zA-Z0-9]+)?([a-zA-Z0-9_\-\.\?\+\/\\&;%\$#\=~]*)?$/;
	var p_quarter		= /^([oO][tT2-9]|[1-4])$/;
	var p_clock			= /^(0?[0-9]|[1][0-5]):(0?[0-9]|[1-5][0-9])$/;
	var p_position		= /^([A|M|D|G|GK|DM|LSM])$/;
	switch(ty){
		case 'html_text':
			r = p_html_text;
			break;
		case 'text':
			r = p_text;
			break;
		case 'int':
		case 'integer':
			r = p_int;
			break;
		case 'float':
			r = p_float;
			break;
		case 'dollar':
			r = p_dollar;
			break;
		case 'keyword':
			r = p_keyword;
			break;
		case 'state':
			r = p_state;
			break;
		case 'ZIP_Code':
			r = p_ZIP_Code;
			break;
		case 'telephone':
			r = p_telephone;
			break;
		case 'email':
			r = p_email;
			break;
		case 'year':
			r = p_year;
			break;
		case 'jerseyNo':
			r = p_jerseyNo;
			break;
		case 'url':
			r = p_url;
			break;
		case 'quarter':
			r = p_quarter;
			break;
		case 'clock':
			r = p_clock;
			break;
		case 'position':
			r = p_position;
			break;
	}
	return r;
}

/*----------------------------------------------------------------------
SET VALIDATION ERROR MESSAGE
----------------------------------------------------------------------*/
function set_validation_error_message(ty){
	var r = '';
	var m_text			= 'Please use only letters, dashes, periods, commas or whitespace.';
	var m_int			= 'Please enter a valid integer.';
	var m_float			= 'Please enter a valid decimal number.';
	var m_keyword		= 'Please enter a query using standard characters.';
	var m_state			= 'Please enter a two-character state abbreviation.';
	var m_ZIP_Code		= 'Please enter a valid ZIP Code in XXXXX-XXXX format.';
	var m_telephone		= 'Please enter a valid telephone number in XXX-XXX-XXXX format.';
	var m_email			= 'Please enter a valid email address';
	var m_year			= 'Please enter a 4-digit year between 1900 and 2100';
	var m_jerseyNo		= 'Please enter an integer greater than "0".';
	var m_url			= 'Please enter valid URL';
	var m_quarter		= 'Please enter 1-4, OT, or O2, O3...';
	var m_clock			= 'Please enter a valid clock time in MM:SS format.';
	var m_position		= 'Please enter a valid position (A, M, D, GK, DM, LSM)';
	switch(ty){
		case 'html_text':
		case 'text':
			r = m_text;
			break;
		case 'int':
		case 'integer':
			r = m_int;
			break;
		case 'dollar':
		case 'float':
			r = m_float;
			break;
		case 'keyword':
			r = m_keyword;
			break;
		case 'state':
			r = m_state;
			break;
		case 'ZIP_Code':
			r = m_ZIP_Code;
			break;
		case 'telephone':
			r = m_telephone;
			break;
		case 'email':
			r = m_email;
			break;
		case 'year':
			r = m_year;
			break;
		case 'jerseyNo':
			r = m_jerseyNo;
			break;
		case 'url':
			r = m_url;
			break;
		case 'quarter':
			r = m_quarter;
			break;
		case 'clock':
			r = m_clock;
			break;
		case 'position':
			r = m_position;
			break;
	}
	return r;
}

/*----------------------------------------------------------------------
STRING PATTERN MATCH
----------------------------------------------------------------------*/
function validate_string(ty, o){
	var s = o.value;
	if(ty != '' && s != ''){
		var p = set_regexp_pattern(ty);
		var msg = set_validation_error_message(ty);
		var t = s.match(p);
		if(!t){
			alert(msg);
			o.value = '';
			return false;
		}else{
			return true;
		}
	}
}

/*------------------------------------------------------------
VALIDATE TIME
------------------------------------------------------------*/
function validate_time(obj){
	var meridian;
	var str = obj.value;
	var long_pattern = /^([0-9]|[0-1][0-9]|[2][0-3])\:?([0-5][0-9])\x20?([AM|PM|am|pm]{2,2})?$/;
	var short_pattern = /^([0-9]|[0-1][0-9]|[2][0-3])\x20?([AM|PM|am|pm]{2,2})?$/;
	var msg = 'Please enter a valid time in one of the following four formats: a) hh, b) hh am|pm, c) hh:mm, or d) hh:mm am|pm.';
	
	//match to long pattern
	var time_array = str.match(long_pattern);
	if(time_array != null){
		if(time_array[3] != null){
			meridian = time_array[3];
			if((meridian == 'PM' || meridian == 'pm') && time_array[1] < 12){
				time_array[1] = parseInt(time_array[1]) + 12;
			}
		}
		var v = (parseInt(time_array[1]) * 60 * 60) + (parseInt(time_array[2]) * 60);
	}else{
		//match to short pattern
		time_array = str.match(short_pattern);
		if(time_array != null){
			if(time_array[2] != null){
				meridian = time_array[2];
				//time_array[2] = '00';
				if((meridian == 'PM' || meridian == 'pm') && time_array[1] < 12){
					time_array[1] = parseInt(time_array[1]) + 12;
				}
			}
			var v = parseInt(time_array[1]) * 60 * 60;
		}else{
			obj.value = '';
			alert(msg);
			return false;
		}
	}
	if(v < (60 * 60 * 24)){
		//obj.value = time_array[1] + ':' + time_array[2];
		return true;
	}
	obj.value = '';
	alert(msg);
	return false;
}

/*------------------------------------------------------------
VALIDATE DATE
------------------------------------------------------------*/
function validate_date(obj){
	var str = obj.value;
	var min_year = 1900;
	var max_year = 2100;
	var month_days_array = new Array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	var parser_array = new Array('-', ' ', '/', '.');
	var parser_type = -1;
	var msg = 'Please enter a valid date in mm/dd/YY or mm/dd/YYYY format.';
	
	//get date parser
	for(i = 0; i < parser_array.length; i++){
		var pos = str.indexOf(parser_array[i]);
		if(pos > 0){
			parser_type = i;
			break;
		}
	}
	//split date components
	if(parser_type != -1){
		var date_array = str.split(parser_array[parser_type]);
		if(date_array.length != 3){
			obj.value = '';
			alert(msg);
			return false;
		}
	}else{
		obj.value = '';
		alert(msg);
		return false;
	}
	//test year
	var year = (date_array[2].length == 2 ? 2000 + parseInt(date_array[2]) : parseInt(date_array[2]));
	if(year < min_year || year > max_year){
		obj.value = '';
		alert(msg);
		return false;
	}
	//test month
	var month = parseInt(date_array[0]);
	if(month < 1 || month > 12){
		obj.value = '';
		alert(msg);
		return false;
	}
	//test day
	var day = parseInt(date_array[1]);
	var feb_days = get_february_days(year);
	if((day < 1) || (day > month_days_array[month - 1]) || (month == 2 && day > feb_days)){
		obj.value = '';
		alert(msg);
		return false;
	}
	//reformat date
	var r = month + '/' + day + '/' + year;
	return r;
}
function get_february_days(year){
	var r = 28;
	if(year % 100 == 0){
		if(year % 400 == 0){
			r = 29;
		}
	}else if(year % 4 == 0){
		r = 29;
	}
	return r;
}

/*----------------------------------------------------------------------
BASIC FORM VALIDATION
----------------------------------------------------------------------*/
function validate_form(f){
	var empty = '';
	var error = '';
	var not_set = '';
	var msg = '';
	for(i = 0; i < f.length; i++){
		var e = f.elements[i];
		if(e.type == 'text' || e.type == 'textarea'){
			if((e.value == '' || e.value == null) && e.required == true){
				empty +="\n" + ' - ' + e.name;
			}
			if(e.value != '' && e.pattern != ''){
				var t = validate_string(e.pattern, e);
				if(!t){
					error += "\n" + ' - ' + e.name;
				}
			}
		}
		if((e.type == 'select-one' || e.type == 'select-multiple') && e.required == true){
			if(e.options[e.selectedIndex].value == 0){
				not_set += "\n" + ' - ' + e.name;
			}
		}
		if(e.type == 'hidden' && e.required == true){
			if(e.value == 0 || e.value == '0' || e.value == '' || e.value == null){
				not_set += "\n" + ' - ' + e.name;
			}
		}
	}
	if(empty != '' || error != '' || not_set != ''){
		msg = 'Hold up! The form has errors:';
		if(empty != ''){
			msg += "\n\n" + 'The following required fields are empty:' + empty;
		}
		if(not_set != ''){
			msg += "\n\n" + 'The following items have not been set:' + not_set;
		}
		if(error != ''){
			msg += "\n\n" + 'The following fields have invalid values:' + error;
		}
		alert(msg);
		return false;
	}
	return true;
}

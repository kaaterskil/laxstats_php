// JavaScript Document

/*------------------------------------------------------------
RELOAD PARENT WINDOW
------------------------------------------------------------*/
window.opener.location.reload();
if(document.note){
	var f = document.note;
	select_note_form(f.type.options[f.type.selectedIndex].value);
}

/*------------------------------------------------------------
VIEW ATTACHMENT
------------------------------------------------------------*/
function view_attachment(url){
	var w = screen.availWidth;
	var h = screen.availHeight;
	var x = (w / 2) - 330;
	var y = (h / 2) - 250;
	var viewAttach = window.open(url, 'viewAttach', 'toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=no,width=660,height=500,left=' + x + ',top=' + y);
	return false;
}

/*------------------------------------------------------------
SHOW/HIDE EMAIL ELEMENTS
------------------------------------------------------------*/
function select_note_form(v){
	var e = find_DOM('email');
	if(v == 'E'){
		e.style.display = 'block';
	}else{
		e.style.display = 'none';
	}
}

/*------------------------------------------------------------
VALIDATE FORM
------------------------------------------------------------*/
function validate_note(f){
	f.date.required			= true;
	f.type.required			= true;
	f.subject.required		= true;
	f.text.required			= true;
	f.contact.pattern		= 'text';
	f.recipients.pattern	= 'email';
	f.subject.pattern		= 'text';
	f.text.pattern			= 'html_text';
	if(f.type.options[f.type.selectedIndex].value == 'E'){
		f.recipients.required = true;
	}
	var t = validate_form(f);
	if(!t){
		return false;
	}
	return true;
}
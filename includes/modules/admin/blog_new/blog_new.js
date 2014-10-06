// JavaScript Document

/*************************************************************
FORMATTING FUNCTIONS
*************************************************************/
/*------------------------------------------------------------
BOLD
------------------------------------------------------------*/
function bold_this(){
	modify_text('b', '', document.blog.blog_text);
}

/*------------------------------------------------------------
ITALICIZE
------------------------------------------------------------*/
function italicize_this(){
	modify_text('i', '', document.blog.blog_text);
}

/*------------------------------------------------------------
HIGHLIGHT
------------------------------------------------------------*/
function highlight_this(){
	modify_text('span',' style="font-weight:bold; color:#993300;"', document.blog.blog_text);
}

/*------------------------------------------------------------
FORMAT STRING
------------------------------------------------------------*/
function format_string(obj){
	var s = obj.value;
	var r = '';
	for(var i = 0; i < s.length; i++){
		if(s.substr(i, 2) == "\n" || s.substr(i, 2) == "\r"){
			r += '<br>';
			i++;
		}else if(s.charCodeAt(i) == 10 && s.charCodeAt(i + 1) == 10){
			r += '<br>';
			i++;
		}else if(s.charCodeAt(i) == 10 || s.charCodeAt(i) == 13){
			r += '<br>';
		}else if(s.charCodeAt(i) == 32 && s.charCodeAt(i - 1) == 32){
			r += "&nbsp;";
		}else{
			r += s.substr(i, 1);
		}
	}
	return r;
}

/*************************************************************
OTHER FUNCTIONS
*************************************************************/
/*------------------------------------------------------------
RELOAD PARENT WINDOW
------------------------------------------------------------*/
window.opener.location.reload();

/*------------------------------------------------------------
SELECT FORM
------------------------------------------------------------*/
function select_form(v){
	var f1 = null;
	var f2 = null;
	var f3 = null;
	f1 = find_DOM('email');
	f2 = find_DOM('title1');
	f3 = find_DOM('title2');
	if(v == 'E'){
		f1.style.display = 'block';
		f2.style.display = 'none';
		f3.style.display = 'block';
		document.blog.save_blog.value = 'Send email';
	}else{
		f1.style.display = 'none';
		f2.style.display = 'block';
		f3.style.display = 'none';
		document.blog.save_blog.value = 'Save';
	}
}

/*------------------------------------------------------------
ADD EMAIL TO LIST
------------------------------------------------------------*/
function add_email(v){
	if(v != 0){
		var e = document.blog.eOther.value;
		if(e == ''){
			document.blog.eOther.value = v;
		}else{
			document.blog.eOther.value = e + ', ' + v;
		}
	}
}

/*------------------------------------------------------------
VALIDATE FORM
------------------------------------------------------------*/
function validate_blog(f){
	f.date.required			= true;
	f.title.requred			= true;
	//f.blog_text.required	= true;
	f.date.pattern			= 'date';
	f.title.pattern			= 'text';
	f.eOther.pattern		= 'email';
	f.blog_text.pattern		= 'html_text';
	var t = validate_form(f);
	if(!t){
		return false;
	}
	var br = f.blog_ref.value;
	var ty = f.blog_type.value;
	if(ty == 'E'){
		if(!f.ePlayer.checked && !f.eStaff.checked && !f.eParent.checked && (f.eOther.value == '' || f.eOther.value == null)){
			var msg = 'You must either select an email group or enter an email in the \'Other\' field';
			alert(msg);
			return false;
		}
	}
	if(br == 0){
		if(ty == 'E'){
			//f.blog_text.value = format_string(f.blog_text);
			f.action += '&ty=2';
		}else{
			f.action += '&ty=1';
		}
	}else{
		if(ty == 'E'){
			var msg = 'Are you sure you want to resend this email?';
			if(confirm(msg)){
				//f.blog_text.value = format_string(f.blog_text);
				f.action += '&ty=2';
			}else{
				return false;
			}
		}else{
			f.action += '&ty=1';
		}
	}
	return true;
}

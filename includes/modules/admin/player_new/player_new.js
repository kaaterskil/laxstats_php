// JavaScript Document

/*------------------------------------------------------------
RELOAD PARENT WINDOW
------------------------------------------------------------*/
window.opener.location.reload();

/*----------------------------------------------------------------------
VALIDATE FORM
----------------------------------------------------------------------*/
function validate_player(f){
	f.jerseyNo.required				= true;
	f.last_name.required			= true;
	f.position.required				= true;
	f.jerseyNo.pattern				= 'jerseyNo';
	f.last_name.pattern				= 'text';
	f.first_name.pattern			= 'text';
	f.class.pattern					= 'year';
	f.height.pattern				= 'text';
	f.weight.pattern				= 'integer';
	f.school.pattern				= 'text';
	f.counselor.pattern				= 'text';
	f.telephone_counselor.pattern	= 'telephone';
	f.college.pattern				= 'text';
	f.college_link.pattern			= 'url';
	f.street1.pattern				= 'text';
	f.street2.pattern				= 'text';
	f.city.pattern					= 'text';
	f.ZIP_Code.pattern				= 'ZIP_Code';
	f.telephone_home.pattern		= 'telephone';
	f.email_player.pattern			= 'email';
	f.parent.pattern				= 'text';
	f.email_parent.pattern			= 'email';
	var t = validateForm(f);
	if(!t){
		return false;
	}
	return true;
}

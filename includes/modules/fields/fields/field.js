// JavaScript Document
/*--------------------------------------------------
CHANGE PLAYING FIELD
--------------------------------------------------*/
function changeField(url){
	//get fieldRef value
	var r = 0;
	var parts = url.split('&');
	for(i = 0; i < parts.length; i++){
		var t = parts[i].substr(0, 1);
		if(t == 'f'){
			r = parts[i].substr(2);
			break;
		}
	}
	if(r > 0){
		window.location.href = url;
	}else{
		var msg = 'Please select a field.';
		alert(msg);
	}
}

/*--------------------------------------------------
PRINT PLAYING FIELD
--------------------------------------------------*/
function printField(url){
	//get fieldRef value
	var r = 0;
	var parts = url.split('&');
	for(i = 0; i < parts.length; i++){
		var t = parts[i].substr(0, 1);
		if(t == 'f'){
			r = parts[i].substr(2);
			break;
		}
	}
	if(r > 0){
		var w = 640;
		var h = 550;
		var ref = 'fieldPrint';
		open_popup(ref, url, w, h);
	}else{
		msg = 'Please select a field.';
		alert(msg);
	}
	return false;
}

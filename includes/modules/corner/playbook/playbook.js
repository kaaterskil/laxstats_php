// JavaScript Document

/*------------------------------------------------------------
OPEN PRINT WINDOW
------------------------------------------------------------*/
function playbookPrint(r){
	var w = 640;
	var h = 550;
	var ref = 'print_playbook';
	var url = 'teamPlaysPrint.php?teamMasterRef=' + r;
	openPopUp2(ref,url,w,h);
	return false;
}

/*------------------------------------------------------------
GET FLASH OBJECT
------------------------------------------------------------*/
function getFlashObject(n){
	if(window.document[n]){
		return window.document[n];
	}
	if(navigator.appName.indexOf("Microsoft Internet") == -1){
		if(document.embeds && document.embeds[n]){
			return document.embeds[n];
		}
	}else{
		return document.getElementById(n);
	}
}

/*------------------------------------------------------------
FOR FS COMMAND CAPABLE BROWSERS
------------------------------------------------------------*/
function laxChalkboardDesign_DoFSCommand(c, a){
	switch(c){
		case 'getTeamRef':
			var m = getFlashObject('laxChalkboardDesign');
			var t = document.playbook.teamMasterRef.value;
			var g = document.playbook.gender.value;
			m.SetVariable("/:_root.teamRef", t);
			m.SetVariable("/:_root.gender", g);
			break;
		case 'message':
			alert(a);
			break;
		case 'statusMessage':
			window.status = a;
			break;
	}
}

/*
var agt			= navigator.userAgent.toLowerCase();
var appVer		= navigator.appVersion.toLowerCase();
var is_opera	= (agt.indexOf('opera') != -1);
var iePos		= appVer.indexOf('msie');
if(isPos != -1 && agt.indexOf('mac') != -1){
	isPos = agt.indexOf('msie');
}
var is_safari	= ((agt.indexOf('safari') != -1) && (agt.indexOf('mac') != -1) : 'true' : 'false');
var is_kong		= ((agt.indexOf() != -1) ? true : false);
var is_khtml	= (is_safari || is_kong);
var is_ie		= (iePos != -1 && !is_opera && !is_khtml);
*/
if (navigator.appName && is_ie && navigator.userAgent.indexOf("Windows") != -1 && navigator.userAgent.indexOf("Windows 3.1") == -1) {
	document.write('<script language=\"VBScript\"\>\n');
	document.write('On Error Resume Next\n');
	document.write('Sub laxChalkboardDesign_FSCommand(ByVal command, ByVal args)\n');
	document.write('	Call laxChalkboardDesign_DoFSCommand(command, args)\n');
	document.write('End Sub\n');
	document.write('</script\>\n');
}

/*------------------------------------------------------------
FOR FLASHVARS CAPABLE CAPABLE BROWSERS
------------------------------------------------------------*/
function flashVarsMovie(){
	var r = document.playbook.teamMasterRef.value;
	var g = document.playbook.gender.value;
	document.write("<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0\" width=\"577\" height=\"450\" id=\"laxChalkboardDesign_FV\" align=\"middle\">");
	document.write("<param name=\"FlashVars\" value=\"setTMR=" + r + "&setGender=" + g + "\" />");
	document.write("<param name=\"allowScriptAccess\" value=\"sameDomain\" />");
	document.write("<param name=\"movie\" value=\"movies/laxChalkboardDesign_FV.swf\" />");
	document.write("<param name=\"loop\" value=\"false\" />");
	document.write("<param name=\"quality\" value=\"high\" />");
	document.write("<param name=\"bgcolor\" value=\"#ffffff\" />");
	document.write("<embed src=\"movies/laxChalkboardDesign_FV.swf\" loop=\"false\" quality=\"high\" bgcolor\"#ffffff\" width=\"577\" height=\"450\" name=\"laxChalkboardDesign_FV\" id=\"laxChalkboardDesign_FV\" FlashVars=\"setTMR=" + r + "&setGender=" + g + "\" align=\"middle\" allowScriptAccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />");
	document.write("</object>");
}

/*------------------------------------------------------------
FOR IE BROWSERS
------------------------------------------------------------*/

function ieMovie(){
	var r = document.playbook.teamMasterRef.value;
	var g = document.playbook.gender.value;
	document.write("<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0\" width=\"577\" height=\"450\" id=\"laxChalkboardDesign_IE\" align=\"middle\" FlashVars=\"setTMR=" + r + "&setGender=" + g + "\">");
	document.write("<param name=\"allowScriptAccess\" value=\"sameDomain\" />");
	document.write("<param name=\"movie\" value=\"movies/laxChalkboardDesign_IE.swf\" />");
	document.write("<param name=\"loop\" value=\"false\" />");
	document.write("<param name=\"quality\" value=\"high\" />");
	document.write("<param name=\"bgcolor\" value=\"#ffffff\" />");
	document.write("<embed src=\"movies/laxChalkboardDesign_IE.swf\" loop=\"false\" quality=\"high\" bgcolor\"#ffffff\" width=\"577\" height=\"450\" name=\"laxChalkboardDesign_IE\" id=\"laxChalkboardDesign_IE\" FlashVars=\"setTMR=" + r + "&setGender=" + g + "\" align=\"middle\" allowScriptAccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />");
	document.write("</object>");
}

/*------------------------------------------------------------
FOR FS COMMAND CAPABLE BROWSERS
------------------------------------------------------------*/
function fscommandMovie(){
	document.write("<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0\" id=\"laxChalkboardDesign\" width=\"577\" height=\"450\" align=\"middle\">");
	document.write("<param name=\"allowScriptAccess\" value=\"sameDomain\" />");
	document.write("<param name=\"movie\" value=\"movies/laxChalkboardDesign2.swf\" />");
	document.write("<param name=\"loop\" value=\"false\" />");
	document.write("<param name=\"quality\" value=\"high\" />");
	document.write("<param name=\"bgcolor\" value=\"#ffffff\" />");
	document.write("<embed src=\"movies/laxChalkboardDesign2.swf\" loop=\"false\" quality=\"high\" bgcolor=\"#ffffff\" width=\"577\" height=\"450\" swLiveConnect=true id=\"laxChalkboardDesign\" name=\"laxChalkboardDesign\" align=\"middle\" allowScriptAccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />");
	document.write("</object>");
}

function statusMsg(m){
	window.status = m;
}

<?php
/*------------------------------------------------------------
SERVER CONSTANTS
------------------------------------------------------------*/
if($_SERVER['SERVER_ADDR'] != '127.0.0.1' && $_SERVER['SERVER_ADDR'] != '::1'){
	define('HTTP_SERVER', 'http://www.laxstats.net/');
	define('HTTPS_SERVER', 'http://www.laxstats.net/');
} else {
	define('HTTP_SERVER', 'http://localhost/net.laxstats/');
	define('HTTPS_SERVER', 'http://localhost/net.laxstats/');
}

/*------------------------------------------------------------
DATABASE CONSTANTS
------------------------------------------------------------*/
define('HOSTNAME', 'localhost');
if($_SERVER['SERVER_ADDR'] != '127.0.0.1'){
	define('DATABASE', 'laxstats_data');
	define('USERNAME', 'dev');
	define('PASSWORD', '~Banzai41');
} else {
	define('DATABASE', 'laxstats_data');
	define('USERNAME', 'dev');
	define('PASSWORD', 'banzai41');
}

/*---------------------------------------------------
COMPANY CONSTANTS
---------------------------------------------------*/
define('META_TAG_DESCRIPTION', 'laxstats, a home for lacrosse statistics and lacrosse team management');
define('META_TAG_KEYWORDS', "laxstats, lax, lacrosse, stats, statistics, lax stats, lacrosse statistics, high school lacrosse, prep school lacrosse, lax teams, lacrosse teams, lax scores, lacrosse scores, men's lacrosse, women's lacrosse, boy's lacrosse, girl's lacrosse, boy's sports, girl's sports, animated drills, animated plays, team management, team scheduling, scoring, scorekeeping, sports statistics, sports software, coach, coaching, sports, sports tools, playmaker, chalkboard, blair caple, wellesley, kaaterskil");

/*---------------------------------------------------
EMAIL CONSTANTS
---------------------------------------------------*/
define('SEND_EMAILS', 'true');
define('HTML_EMAIL_ENABLED', 'true');
define('COMPANY_NAME', 'Laxstats.net');
define('COMPANY_EMAIL_ADDRESS', 'webmaster@laxstats.net');

/*---------------------------------------------------
FILE UPLOAD CONSTANTS
---------------------------------------------------*/
define('UPLOAD_FILENAME_EXTENSIONS', 'jpg,jpeg,gif,png,pdf,tif,tiff,bmp,txt,doc,xls,ppt,pdf');
define('UPLOAD_MAXSIZE_DOCUMENT', 2048000);
define('UPLOAD_MAXSIZE_IMAGE', 65536);
define('FILE_UPLOADED_SUCCESSFULLY', 'File uploaded successfully!');
define('ERROR_FILETYPE_NOT_ALLOWED', 'Sorry, but that filetype is not allowed.');
define('ERROR_MAXSIZE_EXCEEDED', 'Sorry, but the file size is too big.');
define('ERROR_NO_FILE_UPLOADED', 'No file was uploaded. Please try again.');
define('ERROR_DESTINATION_NOT_WRITABLE', 'Cannot write to that destination.');
define('ERROR_DESTINATION_DOES_NOT_EXIST', 'The specified destination does not exist.');
define('ERROR_CANNOT_OVERWRITE', 'The existing file cannot be overwritten.');
define('ERROR_FILE_NOT_SAVED', 'The file could not be saved.');

/*---------------------------------------------------
FOOTER CONSTANTS
---------------------------------------------------*/
define('WEBSITE_CONTACT_LINK', 'mailto:questions@laxstats.net');
define('TEXT_WEBSITE_NAME', 'laxstats:');
define('TEXT_FOOTER_CONTACT', 'Contact Us');
define('TEXT_FOOTER_SITEMAP', 'Site Map');
define('TEXT_FOOTER_TERMS', 'Terms of Use');
define('TEXT_FOOTER_PRIVACY', 'Privacy Policy');
define('TEXT_FOOTER_SUBSCRIPTION', 'Subscription Information');
define('TEXT_FOOTER_COPYRIGHT', 'Copyright &copy; 2005-2007 Kaaterskil Management, LLC. All rights reserved.');

/*---------------------------------------------------
ERROR CONSTANTS
---------------------------------------------------*/
define('TEXT_ERROR_ADMIN_LEVEL', 'Sorry, but you don\'t have privileges to enter this area.');
define('TEXT_ERROR_NONSUBSCRIBER', 'Sorry, but you need a current subscription to Laxtsats to perform that function. ');
?>
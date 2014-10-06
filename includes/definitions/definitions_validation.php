<?php
/***********************************************************************
FORM VALIDATION MESSAGES
***********************************************************************/
/*----------------------------------------------------------------------
BLOG COMMENTS
----------------------------------------------------------------------*/
define('ERROR_NO_BLOG_NAME', 'You need to enter a name.');
define('ERROR_NO_BLOG_COMMENT', 'You need to enter a name.');

/*----------------------------------------------------------------------
FAN REGISTRATION
----------------------------------------------------------------------*/
define('ERROR_DUPLICATE_FAN', 'You are aleady registered.');
define('ERROR_MAX_FANS', 'You have created too many entried from this IP address.');
define('FAN_REGISTRTAION_SUCCESS', 'Thank you for registering with Laxstats!');

/*----------------------------------------------------------------------
MANAGER'S OFFICE LOGIN
----------------------------------------------------------------------*/
define('ERROR_NO_LOGIN_USERNAME', 'Please enter a username or valid email address.');
define('ERROR_NO_LOGIN_PASSWORD', 'Please enter a password.');
define('ERROR_BAD_LOGIN', 'That user could not be found, Please try again.');

/*----------------------------------------------------------------------
NEW USER REGISTRATION
----------------------------------------------------------------------*/
define('ERROR_NO_USER_FIRST_NAME', 'Your first name cannot be blank.');
define('ERROR_NO_USER_LAST_NAME', 'Your last name cannot be blank.');
define('ERROR_NO_USERNAME', 'Please enter a username.');
define('ERROR_NO_PASSWORD', 'Please enter a password.');
define('ERROR_NO_EMAIL', 'Please enter an email address.');
define('ERROR_BAD_EMAIL', 'Please enter a valid email address.');
define('ERROR_BAD_EMAIL_MATCH', 'The two email addresses must match.');
define('ERROR_BAD_PASSWORD_MATCH', 'The two passwords must match.');
define('ERROR_DUPLICATE_REGISTRATION', 'You are already registered.');
define('ERROR_DUPLICATE_USERNAME', 'Sorry, but that username is in use. Please choose another.');
define('ERROR_MAX_USERS', 'Sorry, but only three users per team are permitted.');

/*----------------------------------------------------------------------
MANAGER'S OFFICE - HOME PAGE
----------------------------------------------------------------------*/

/*----------------------------------------------------------------------
MANAGER'S OFFICE - TEAM MAINTENANCE
----------------------------------------------------------------------*/
define('ERROR_NO_TOWN', 'Please enter a town.');
define('ERROR_NO_CONFERENCE', 'Please enter a conference.');
define('ERROR_DUPLICATE_TEAM', 'That team already exists.');
define('ERROR_CURRENT_SUBSCRIBER', 'This team is a Laxstats subscriber. You may not edit it.');
define('ERROR_TEAM_GAMES_EXIST', 'There are games associated with this team. You may not edit it.');
define('ERROR_SELF_TEAM', 'You cannot delete your own team.');

/*----------------------------------------------------------------------
MANAGER'S OFFICE - SEASON MAINTENANCE
----------------------------------------------------------------------*/
define('ERROR_NO_SEASON', 'Please enter a season.');
define('ERROR_DUPLICATE_SEASON', 'That season already exists.');
define('ERROR_SEASON_GAMES_EXIST', 'There are games associated with this season. You may not delete it.');

/*----------------------------------------------------------------------
MANAGER'S OFFICE - STAFF MAINTENANCE
----------------------------------------------------------------------*/
define('ERROR_NO_STAFF_NAME', 'Please enter a name.');
define('ERROR_NO_STAFF_POSITION', 'Please select a position.');
define('ERROR_DUPLICATE_STAFF', 'That individual is already on the staff list.');
?>
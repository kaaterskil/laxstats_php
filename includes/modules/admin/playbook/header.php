<?php
//test privileges
test_privileges(1);
//set headers
$masthead_logo = MASTHEAD_ADMIN_PLAYBOOK;
$tpl_menubar = MENUBAR_ADMIN1;
define('PAGE_TITLE', 'Playbook');
define('PAGE_HEADER', 'PLAYBOOK MAINTENANCE');
$teamMasterRef	= $_SESSION['user_tmr'];
?>
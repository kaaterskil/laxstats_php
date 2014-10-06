<?php
$masthead_logo = MASTHEAD_ADMIN_LOGOUT;
$tpl_menubar = MENUBAR_PUBLIC;
define('PAGE_TITLE', 'Logout');

destroy_user_session();
?>
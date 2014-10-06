<?php
//load directory
$directory_array = array();
require('directory/directory.php');
//run the page-loader
require('directory/page_loader.php');

//get visitor's ip address
$user_ip_address = $_SERVER['REMOTE_ADDR'];
if (!isset($_SESSION['user_ip_address'])) {
  $_SESSION['user_ip_address'] = $user_ip_address;
}
?>
<?php
$request_type = ((isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') || (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == '1') || (isset($_SERVER['HTTP_X_FORWARDED_BY']) && strstr(strtoupper($_SERVER['HTTP_X_FORWARDED_BY']),'SSL')) || (isset($_SERVER['HTTP_X_FORWARDED_HOST']) &&  strstr(strtoupper($_SERVER['HTTP_X_FORWARDED_HOST']),'SSL')) || (isset($_SERVER['SCRIPT_URI']) && strtolower(substr($_SERVER['SCRIPT_URI'], 0, 6)) == 'https:') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' )   )  ? 'SSL' : 'NONSSL';
$http_domain = get_top_level_domain(HTTP_SERVER);
$https_domain = get_top_level_domain(HTTPS_SERVER);
$current_domain = (($request_type == 'NONSSL') ? $http_domain : $https_domain);
?>
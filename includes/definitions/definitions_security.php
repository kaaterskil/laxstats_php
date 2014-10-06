<?php
/*----------------------------------------------------------------------
ADMIN SECURITY
The security system works by comparing the users rights level to levels 
assigned to each web page. The user is permitted to access pages that are 
equal to or higher in value to their assigned level.

Security ratings:
0 == superuser (designer)
1 == subscriber
----------------------------------------------------------------------*/
define('SECURITY_ADMIN_SUPERUSER', '0');
define('SECURITY_ADMIN_SUBSCRIBER', '1');
?>
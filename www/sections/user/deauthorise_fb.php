<?php



$themessage = '<table width="300" style="display:block; width:300px; border:none; margin:20px auto; border-collapse:collapse;"><tr><th>';
$themessage = $themessage . '<img src="' . $smtp_logo . '" style="width:239px; display:block; margin:0 auto 20px auto;" />';
$themessage = $themessage . '<h1 style="color:#0066a3; font-weight:bold; font-size:16pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">FACEBOOK LOGIN DEUTHORISED</h1>';
$themessage = $themessage . '<p style="color:#222222; font-weight:normal; font-size:10pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">FACEBOOK LOGIN DEUTHORISED</p>';
$themessage = $themessage . '</th></tr></table>';
$altbody = 'FACEBOOK LOGIN DEUTHORISED - ';

$mysqlquery = "INSERT INTO email_queue SET
email='kookynetwork@protonmail.com',
display_name = 'Bro Code Webmaster',
subject='FACEBOOK LOGIN DEUTHORISED',
body='$themessage',
altbody='$altbody'";
$dbconn->query($mysqlquery);

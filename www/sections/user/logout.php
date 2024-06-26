<?php
$mysqlquery = "DELETE FROM active_sessions WHERE id='$session_id'";
$dbconn->query($mysqlquery);

setcookie('brocode_id', null, -1, '/');
setcookie('brocode_session_id', null, -1, '/');
setcookie('brocode_session_key', null, -1, '/');
unset($_COOKIE['brocode_id']);
unset($_COOKIE['brocode_session_id']);
unset($_COOKIE['brocode_session_key']);

$location = "Location: " . $base_url;
header($location);
exit();

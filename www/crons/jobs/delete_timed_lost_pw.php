<?php

$cutoff=$request_time - 900;
$mysqlquery="DELETE FROM lostpw WHERE request_time<'$cutoff'";
$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

echo "DELETED ANY TIMED OUT LOST PASSWORD REQUESTS<br />";
echo "<br /><br />";

?>

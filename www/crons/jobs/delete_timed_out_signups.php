<?php

$last_update= $system_data['last_signups_clean'];

$trigger_next = 0;
if(($request_time - $last_update) > 3660){
  $trigger_next = 1;
}


if($trigger_next == 1){
  $minus = (int)172800;
  $cutoff = $request_time - $minus;
  $mysqlquery="DELETE FROM users WHERE email_verfied='0' AND validation_age < '$cutoff'";
  //$dbconn->query($mysqlquery);

  $mysqlquery="UPDATE system SET value='$request_time' WHERE name='last_signups_clean'";
  $dbconn->query($mysqlquery);

  echo "DELETED ANY TIMED OUT SIGN UP REQUESTS<br />";
  echo "<br /><br />";

} else {
  echo "NO TIMED OUT SIGN UP REQUESTS PROCESSED - STILL ON TIMEOUT<br />";
  echo "<br /><br />";
}




?>

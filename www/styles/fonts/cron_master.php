<?php

//get last cron ping
$mysqlquery="SELECT value FROM system WHERE id='3'";
$res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
while($row=$res->fetch_assoc()) {
   $last_cron_ping = $row['value'];
 }

$current_time = time();

if (($current_time - 50) > $last_cron_ping) {

  $mysqlquery="UPDATE system SET value='$current_time' WHERE id='3'";

  //proccess email queue
  include($php_base_directory . '/crons/jobs/email_queue.php');

  echo "<br /><br /><br /><br /><br />";

  //next potential code
  include($php_base_directory . '/crons/jobs/bro-code-crons.php');







  echo "<br /><br /><br /><br /><br />";

  //Clear lost passwords older than 15 minutes
  include($php_base_directory . '/crons/jobs/delete_timed_lost_pw.php');
  echo "<br /><br /><br /><br /><br />";
  //Clear out signup requests that have gone over 48 hours without verification
  include($php_base_directory . '/crons/jobs/delete_timed_out_signups.php');
  echo "<br /><br /><br /><br /><br />";
  // Clear viewed if there has been an update
  include($php_base_directory . '/crons/jobs/check_updates_clear_viewed.php');
  echo "<br /><br /><br /><br /><br />";
  //Clean out temp files
  include($php_base_directory . '/crons/jobs/clean_temp_files.php');
  echo "<br /><br /><br /><br /><br />";

} else {
  $timeleft= 50 - ($current_time = $last_cron_ping);
  echo "TIMEOUT:" . $timeleft;
}














?>

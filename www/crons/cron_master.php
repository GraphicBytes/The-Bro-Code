<?php

$last_cron_ping=$system_data['last_cron_ping'];
$timeout_ignore = 1;

include($php_base_directory . '/crons/jobs/tracking_updates.php');
echo "<br /><br /><br /><br /><br />";

if ((($request_time - 30) > $last_cron_ping) OR $timeout_ignore==1) {

  $mysqlquery="UPDATE system SET value='$request_time' WHERE name='last_cron_ping'";
  $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

  //next potential code
  include($php_base_directory . '/crons/jobs/bro-code-crons.php');
  echo "<br /><br /><br /><br /><br />";

  //clean up active sessions
  include($php_base_directory . '/crons/jobs/clear_inactive_sessions.php');
  echo "<br /><br /><br /><br /><br />";

  //Clear lost passwords older than 15 minutes
  include($php_base_directory . '/crons/jobs/delete_timed_lost_pw.php');
  echo "<br /><br /><br /><br /><br />";

  //Clear out signup requests that have gone over 48 hours without verification
  include($php_base_directory . '/crons/jobs/delete_timed_out_signups.php');
  echo "<br /><br /><br /><br /><br />";

  //Clean out temp files
  include($php_base_directory . '/crons/jobs/clean_temp_files.php');
  echo "<br /><br /><br /><br /><br />";

  //Clean out temp files
  include($php_base_directory . '/crons/jobs/malicious_ip_clean.php');
  echo "<br /><br /><br /><br /><br />";

  include($php_base_directory . '/crons/jobs/token_rotate.php');
  echo "<br /><br /><br /><br /><br />";



  // Email Moderate Prompt
  include($php_base_directory . '/crons/jobs/email_moderate_prompt.php');
  echo "<br /><br /><br /><br /><br />";


  echo "<br /><br /><br /><br /><br />";
  echo "<br /><br /><br /><br /><br />";


  // Clear viewed if there has been an update
  include($php_base_directory . '/crons/jobs/check_updates_clear_viewed.php');
  echo "<br /><br /><br /><br /><br />";







  //proccess email queue
  include($php_base_directory . '/crons/jobs/email_queue.php');
  echo "<br /><br /><br /><br /><br />";


} else {
  $timeleft= 50 - ($request_time = $last_cron_ping);
  echo "TIMEOUT:" . $timeleft;
}














?>

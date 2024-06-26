<?php

$last_csrf_rotate=$system_data['last_csrf_rotate'];
if (($request_time - $last_csrf_rotate) > 8640) {

  $current_tokens = unserialize($system_data['csrf_tokens']);

  $new_tokens=array();
  $new_tokens[0] = random_str(10);
  $new_tokens[1] = $current_tokens[0];
  $new_tokens[2] = $current_tokens[1];
  $new_tokens[3] = $current_tokens[2];
  $new_tokens[4] = $current_tokens[3];
  $new_tokens[5] = $current_tokens[4];
  $new_tokens[6] = $current_tokens[5];
  $new_tokens[7] = $current_tokens[6];
  $new_tokens[8] = $current_tokens[7];
  $new_tokens[9] = $current_tokens[8];
  $new_tokens = serialize($new_tokens);

  $db->sql("UPDATE system SET value=? WHERE name=?", "ss", $new_tokens, "csrf_tokens");

  $db->sql( "UPDATE system SET value='$request_time' WHERE name=?", 's' , 'last_csrf_rotate' );

  echo "ROTATED CSRF TOKENS<br />";
  echo "<br /><br />";

} else {
  echo "CSRF ROTATION ON TIMEOUT<br />";
  echo "<br /><br />";
}

?>

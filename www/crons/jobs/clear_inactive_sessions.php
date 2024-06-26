<?php

$last_session_clean=$system_data['last_session_clean'];

if (($request_time - $last_session_clean) > 300) {

  $res=$db->sql( "SELECT * FROM active_sessions ORDER BY id ASC");
  while($row=$res->fetch_assoc()) {

    $this_id = $row['id'];
    $this_session_timer = $row['session_timer'];
    $this_session_type = $row['session_type'];

    if ($this_session_type == 1) {
      if (($request_time - $this_session_timer) > $new_code_timer) {
        $db->sql( "DELETE FROM active_sessions WHERE id=?", 'i' , $this_id );
      }
    } else {
      if (($request_time - $this_session_timer) > 3600) {
        $db->sql( "DELETE FROM active_sessions WHERE id=?", 'i' , $this_id );
      }
    }

  }


  $db->sql( "UPDATE system SET value='$request_time' WHERE name=?", 's' , 'last_session_clean' );

  echo "DELETED INACTIVE SESSIONS";
  echo "<br /><br />";


} else {
  echo "SESSION CLEAN ON TIMEOUT";
  echo "<br /><br />";
}































?>

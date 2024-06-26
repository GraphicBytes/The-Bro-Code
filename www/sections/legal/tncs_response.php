<?php

$choice = $_POST['choice'];

if ($choice == '0' or $choice == '1' or $choice == '2') {
  $tnc = "UPDATE users SET tandc_seen='$choice' WHERE id=$logged_in_id";
  $db->sql("UPDATE users SET tandc_seen=? WHERE id=?", 'si', $choice, $logged_in_id);
}

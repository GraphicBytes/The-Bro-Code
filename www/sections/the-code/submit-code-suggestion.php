<?php
$the_code = $_POST["code"];
$character_count = strlen($the_code);
$the_code = ucfirst($the_code);
$the_code = str_replace("bro ", "Bro ", $the_code);
$the_code = str_replace("bros ", "Bros ", $the_code);
$the_code = str_replace("bro's ", "Bro's ", $the_code);

if ($the_code == null or $the_code == "" or $character_count < 5) {
  $location = "Location: " . $base_url . "/suggest-code/";
  header($location);
  exit();
} else {

  $unique_id = random_str(50);
  $time = time();
  $owner_id = $logged_in_id;
  $the_code = htmlspecialchars($the_code, ENT_QUOTES);

  $db->sql("INSERT INTO underground_codesindex SET owner_id=?, post_time=?, last_activity=?, unique_id=?", 'iiis', $owner_id, $time, $time, $unique_id);

  $res = $db->sql("SELECT id FROM underground_codesindex WHERE unique_id=? ORDER BY id DESC LIMIT 1", 's', $unique_id);
  while ($row = $res->fetch_assoc()) {
    $parent_id = $row['id'];
  }

  $db->sql("INSERT INTO underground_codevariants SET parent = ?, owner_id = ?, content = ?, post_time = ?", 'iisi', $parent_id, $owner_id, $the_code, $time);

  $location = "Location: " . $base_url . "/potential-code/" . $parent_id . "/";
  header($location);
  exit();
}

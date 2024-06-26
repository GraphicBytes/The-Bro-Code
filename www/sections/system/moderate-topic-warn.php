<?php
$topic_id = $typea;
$owner_id = $typeb;

//add the warning tally
$mysqlquery3 = "UPDATE users SET warnings=warnings+1 WHERE id='$owner_id'";
$dbconn->query($mysqlquery3);

//get user warnings
$mysqlquery3 = "SELECT * FROM users WHERE id='$owner_id' ORDER BY id DESC LIMIT 1";
$res3 = $dbconn->query($mysqlquery3);
while ($row3 = $res3->fetch_assoc()) {
  $warnings = $row3['warnings'];
}


if ($warnings > 2000000) {
  include($php_base_directory . '/sections/system/includes/ban_user.php');
} else {
  //get the content
  $mysqlquery = "SELECT * FROM topics WHERE id='$topic_id' ORDER BY id ASC";
  $res3 = $dbconn->query($mysqlquery);
  while ($row3 = $res3->fetch_assoc()) {
    $title = $row3['title'];
    $topic_gallery_ids = $row3['gallery_ids'];
    $content = html_entity_decode($title, ENT_QUOTES, 'UTF-8');
  }

  $title = "You have been given a warning";
  $message = "<h2>" . $content . "</h2>";
  $message = htmlspecialchars($message, ENT_QUOTES);

  // 1 = code
  // 2 = code varients
  // 3 = code varient comment
  // 4 = board topic
  // 5 = board reply
  // 6 = Meme
  $section = 4;
  $section_id = $section;

  // 1 = duplicate
  // 2 = grammar
  // 3 = NSFW
  // 4 = jibberish
  // 5 = warning
  $type = 5;

  //set notification
  $mysqlquery3 = "INSERT INTO notifications SET title='$title', user_id='$owner_id', message='$message', section='$section', section_id='$section_id', type='$type'";
  $dbconn->query($mysqlquery3);

  include($php_base_directory . '/sections/system/includes/delete-topic.php');
}



$return_arr = array("status" => 1);
echo json_encode($return_arr);























//

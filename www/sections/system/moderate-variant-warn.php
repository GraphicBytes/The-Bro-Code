<?php
$comment_id = $typea;
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

if ($warnings > 2) {
  include($php_base_directory . '/sections/system/includes/ban_user.php');
} else {


  $ids = array();

  //get the content
  $mysqlquery3 = "SELECT id, parent, owner_id, content FROM underground_codevariants WHERE id='$typea' ORDER BY id DESC LIMIT 1";
  $res3 = $dbconn->query($mysqlquery3);
  while ($row3 = $res3->fetch_assoc()) {
    $content = $row3['content'];
    $owner_id = $row3['owner_id'];
    $variant_parent = $row3['parent'];
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
  $section = 2;
  $section_id = $comment_id;


  // 1 = duplicate
  // 2 = grammar
  // 3 = NSFW
  // 4 = jibberish
  // 5 = warning
  $type = 5;



  //set notification
  $mysqlquery3 = "INSERT INTO notifications SET title='$title', user_id='$owner_id', message='$message', section='$section', section_id='$section_id', type='$type'";
  $dbconn->query($mysqlquery3);


  // delete it
  $mysqldelete = "DELETE FROM underground_codevariants WHERE id='$typea'";
  $dbconn->query($mysqldelete);

  $mysqldelete = "DELETE FROM underground_coderatings WHERE variant_id='$typea'";
  $dbconn->query($mysqldelete);


  // are there others
  $other_variants = 0;
  $mysqlquery3 = "SELECT id FROM underground_codevariants WHERE parent='$variant_parent' ORDER BY id DESC";
  $res3 = $dbconn->query($mysqlquery3);
  while ($row3 = $res3->fetch_assoc()) {
    $other_variants = 1;
  }

  if ($other_variants == 0) {

    $mysqlquery3 = "SELECT id FROM variant_comments WHERE code_id='$variant_parent' ORDER BY id DESC";
    $res3 = $dbconn->query($mysqlquery3);
    while ($row3 = $res3->fetch_assoc()) {
      $the_id = $row3['id'];

      $mysqldelete = "DELETE FROM variant_comments WHERE id='$the_id'";
      $dbconn->query($mysqldelete);
      $mysqldelete = "DELETE FROM variant_comment_ratings WHERE example_id='$the_id'";
      $dbconn->query($mysqldelete);
    }


    $mysqldelete = "DELETE FROM underground_codesindex WHERE id='$variant_parent'";
    $dbconn->query($mysqldelete);
  }
}



$return_arr = array("status" => 1, "id" => $typea, "leftovers" => $other_variants, "rating" => '5');
echo json_encode($return_arr);

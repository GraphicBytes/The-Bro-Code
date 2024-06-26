<?php
$comment_id = $typea;
$decision = $typeb;
$owner_id = $typec;

$refresh_action = 0;

$ids = array();

if ($decision == 0) {

  $other_variants = 1;

  //get the content
  $mysqlquery3 = "SELECT id, parent FROM underground_codevariants WHERE id='$typea' ORDER BY id DESC LIMIT 1";
  $res3 = $dbconn->query($mysqlquery3);
  while ($row3 = $res3->fetch_assoc()) {
    $variant_parent = $row3['parent'];
  }

  $indexstatus = 2;

  $mysqlquery = "UPDATE underground_codesindex SET status='$indexstatus' WHERE id='$variant_parent' AND status <> 3";
  $dbconn->query($mysqlquery);

  $mysqlquery = "UPDATE underground_codevariants SET status='$indexstatus' WHERE id='$typea'";
  $dbconn->query($mysqlquery);
} else if ($decision == 5) {

  //Move to comments
  $mysqlquery3 = "SELECT id, parent, owner_id, content, post_time FROM underground_codevariants WHERE id='$typea' ORDER BY id DESC LIMIT 1";
  $res3 = $dbconn->query($mysqlquery3);
  while ($row3 = $res3->fetch_assoc()) {
    $content = $row3['content'];
    $owner_id = $row3['owner_id'];
    $variant_post_time = $row3['post_time'];
    $variant_parent = $row3['parent'];

    $db->sql("INSERT INTO variant_comments SET owner_id=?, code_id=?, content=?, post_time=?, last_update=?", 'iisii', $owner_id, $variant_parent, $content, $variant_post_time, $variant_post_time);

    $mysqldelete = "DELETE FROM underground_codevariants WHERE id='$typea'";
    $dbconn->query($mysqldelete);

    $mysqldelete = "DELETE FROM underground_coderatings WHERE variant_id='$typea'";
    $dbconn->query($mysqldelete);

    $other_variants = 0;
    $refresh_action = 1;
  }
} else if ($decision > 0) {

  //get the content
  $mysqlquery3 = "SELECT id, parent, owner_id, content FROM underground_codevariants WHERE id='$typea' ORDER BY id DESC LIMIT 1";
  $res3 = $dbconn->query($mysqlquery3);
  while ($row3 = $res3->fetch_assoc()) {
    $content = $row3['content'];
    $owner_id = $row3['owner_id'];
    $variant_parent = $row3['parent'];
  }

  $title = "Your code suggestion has been deleted";
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
  $type = $decision;

  //set notification
  $mysqlquery3 = "INSERT INTO notifications SET title='$title', user_id='$owner_id', message='$message', section='$section', section_id='$section_id', type='$type'";
  $dbconn->query($mysqlquery3);



  $mysqldelete = "DELETE FROM underground_codevariants WHERE id='$typea'";
  $dbconn->query($mysqldelete);

  $mysqldelete = "DELETE FROM underground_coderatings WHERE variant_id='$typea'";
  $dbconn->query($mysqldelete);



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









$return_arr = array("status" => 1, "id" => $typea, "leftovers" => $other_variants, "rating" => $decision, "refresh_page" => $refresh_action);
echo json_encode($return_arr);

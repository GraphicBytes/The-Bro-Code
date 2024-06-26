<?php
$mod_needed = 0;
$url = null;


// check code comments
if ($mod_needed == 0) {

  $mysqlquery3 = "SELECT id, code_id, status FROM thecode_examples WHERE status='0' ORDER BY id ASC LIMIT 1";
  $res3 = $dbconn->query($mysqlquery3);
  while ($row3 = $res3->fetch_assoc()) {
    $code_id = $row3['code_id'];
    $mod_needed = 1;

    $mysqlquery4 = "SELECT id, slug FROM thecode WHERE id='$code_id' ORDER BY id ASC LIMIT 1";
    $res4 = $dbconn->query($mysqlquery4);
    while ($row4 = $res4->fetch_assoc()) {
      $slug = $row4['slug'];
      $mod_needed = 1;
      $url = $base_url . "/code/" . $slug . "/";
    }
  }
}


// check code variant comments
if ($mod_needed == 0) {
  $mysqlquery3 = "SELECT id, code_id, status FROM variant_comments WHERE status='0' ORDER BY id ASC LIMIT 1";
  $res3 = $dbconn->query($mysqlquery3);
  while ($row3 = $res3->fetch_assoc()) {
    $code_id = $row3['code_id'];
    $mod_needed = 1;
    $url = $base_url . "/potential-code/" . $code_id . "/";
  }
}


// check code variants
if ($mod_needed == 0) {
  $mysqlquery3 = "SELECT id, parent, status FROM underground_codevariants WHERE status<'2' ORDER BY id ASC LIMIT 1";
  $res3 = $dbconn->query($mysqlquery3);
  while ($row3 = $res3->fetch_assoc()) {
    $parent = $row3['parent'];
    $mod_needed = 1;
    $url = $base_url . "/potential-code/" . $parent . "/";
  }
}


// check new topics
if ($mod_needed == 0) {
  $mysqlquery3 = "SELECT id, slug, status FROM topics WHERE status='0' ORDER BY id ASC LIMIT 1";
  $res3 = $dbconn->query($mysqlquery3);
  while ($row3 = $res3->fetch_assoc()) {
    $slug = $row3['slug'];
    $mod_needed = 1;
    $url = $base_url . "/topic/" . $slug . "/";
  }
}


// check new topics
if ($mod_needed == 0) {
  $mysqlquery3 = "SELECT id, slug, status FROM topics WHERE status='0' ORDER BY id ASC LIMIT 1";
  $res3 = $dbconn->query($mysqlquery3);
  while ($row3 = $res3->fetch_assoc()) {
    $slug = $row3['slug'];
    $mod_needed = 1;
    $url = $base_url . "/topic/" . $slug . "/";
  }
}


// check new topics
if ($mod_needed == 0) {
  $mysqlquery3 = "SELECT id, topic_id, status FROM topic_replies WHERE status='0' ORDER BY id ASC LIMIT 1";
  $res3 = $dbconn->query($mysqlquery3);
  while ($row3 = $res3->fetch_assoc()) {
    $topic_id = $row3['topic_id'];
    $mod_needed = 1;

    $mysqlquery4 = "SELECT id, slug, status FROM topics WHERE id='$topic_id' ORDER BY id ASC LIMIT 1";
    $res4 = $dbconn->query($mysqlquery4);
    while ($row4 = $res4->fetch_assoc()) {
      $slug = $row4['slug'];
      $mod_needed = 1;
      $url = $base_url . "/topic/" . $slug . "/";
    }
  }
}


if ($mod_needed == 0) {
  $db->sql("UPDATE system SET value='0' WHERE name=?", 's', 'mod_email_pinged');
}

$return_arr = array("status" => "$mod_needed", "url" => "$url");
echo json_encode($return_arr);

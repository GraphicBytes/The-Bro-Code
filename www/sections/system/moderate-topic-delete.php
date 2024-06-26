<?php
$topic_id = $typea;
$owner_id = $typeb;


//get the content
$mysqlquery = "SELECT * FROM topics WHERE id='$topic_id' ORDER BY id ASC";
$res3 = $dbconn->query($mysqlquery);
while ($row3 = $res3->fetch_assoc()) {
  $title = $row3['title'];
  $topic_gallery_ids = $row3['gallery_ids'];
  $content = html_entity_decode($title, ENT_QUOTES, 'UTF-8');
}


include($php_base_directory . '/sections/system/includes/delete-topic.php');

$return_arr = array("status" => 1);
echo json_encode($return_arr);























//

<?php

$topicheader = null;
$description = null;
$membersonly = null;
$openstatus = null;
$readonlystatus = null;

if (isset($_POST['topicheader'])) {$topicheader = $_POST['topicheader'];}
if (isset($_POST['description'])) {$description = $_POST['description'];}
if (isset($_POST['membersonly'])) {$membersonly = $_POST['membersonly'];}
if (isset( $_POST['openstatus'])) {$openstatus = $_POST['openstatus'];}
if (isset($_POST['readonlystatus'])) {$readonlystatus = $_POST['readonlystatus'];}

$board_id = $typea;
$topicheader = htmlspecialchars($topicheader, ENT_QUOTES);
$description = htmlspecialchars($description, ENT_QUOTES);

$slug = create_slug($topicheader, 100);

$mysqlquery="SELECT * FROM boards WHERE id='$typea' ORDER BY id ASC";
$res=$dbconn->query($mysqlquery);
while($row=$res->fetch_assoc()) {
    $old_slug = $row['board_slug'];
}

if ($slug != $old_slug) {

  $mysqlquery="SELECT * FROM boards WHERE board_slug='$slug' ORDER BY post_order ASC";
  $res=$dbconn->query($mysqlquery);
  while($row=$res->fetch_assoc()) {
    $slug = create_slug($topicheader, 90) . random_str(5);
  }
  $mysqlquery="UPDATE boards SET board_slug = '$slug' WHERE id='$board_id'";
  $dbconn->query($mysqlquery);
}


if ($membersonly=='on') {
  $status = 0;
} else {
  $status = 1;
}

if ($openstatus=='on') {
  $openstatus = 1;
} else {
  $openstatus = 0;
}

if ($readonlystatus=='on') {
  $readonlystatus = 1;
} else {
  $readonlystatus = 0;
}

$mysqlquery="UPDATE boards SET
board_name = '$topicheader',
status = '$status',
open = '$openstatus',
read_only = '$readonlystatus',
description = '$description'
WHERE id='$board_id'
";
$dbconn->query($mysqlquery);

echo $mysqlquery;
echo "<br />";

$location= "location: " . $base_url . "/boards/" . $slug . "/";
header($location);
?>

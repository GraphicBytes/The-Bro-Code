<?php
$parent_slug=0;

$topicheader = null;
$description = null;
$membersonly = 0;
$openstatus = 0;
$readonlystatus = 0;

if (isset($_POST['topicheader'])) {$topicheader = $_POST['topicheader'];}
if (isset($_POST['description'])) {$description = $_POST['description'];}
if (isset($_POST['membersonly'])) {$membersonly = $_POST['membersonly'];}
if (isset( $_POST['openstatus'])) {$openstatus = $_POST['openstatus'];}
if (isset($_POST['readonlystatus'])) {$readonlystatus = $_POST['readonlystatus'];}

print_r($_POST);
$parent_id = $typea;
$mysqlquery="SELECT * FROM boards WHERE id='$parent_id' ORDER BY id";
$res=$dbconn->query($mysqlquery);
while($row=$res->fetch_assoc()) {
  $parent_slug = $row['board_slug'];
}

$topicheader = htmlspecialchars($topicheader, ENT_QUOTES);
$description = htmlspecialchars($description, ENT_QUOTES);

$slug = create_slug($topicheader, 100);
$mysqlquery="SELECT id, board_slug FROM boards WHERE board_slug='$slug' ORDER BY id";
$res=$dbconn->query($mysqlquery);
while($row=$res->fetch_assoc()) {
  $slug = $slug . random_str(5);
}


$mysqlquery="SELECT * FROM boards WHERE board_slug='$slug' ORDER BY post_order ASC";
$res=$dbconn->query($mysqlquery);
while($row=$res->fetch_assoc()) {
  $slug = create_slug($topicheader, 90) . random_str(5);
}

$title_length = strlen($topicheader);

if ($title_length > 3) {
  $mysqlquery="INSERT INTO boards SET
  board_name = '$topicheader',
  board_slug = '$slug',
  parent = '$parent_id',
  status = '$membersonly',
  open = '$openstatus',
  read_only = '$readonlystatus',
  description = '$description'
  ";
  $dbconn->query($mysqlquery);
}


$location= "location: " . $base_url . "/boards/" . $slug . "/";
header($location);
?>

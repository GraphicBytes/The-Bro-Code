<?php
$variant_id = $typea;
$ids = array();
$response = 0;

$mysqlquery = "SELECT * FROM underground_codevariants WHERE id='$variant_id' ORDER BY id DESC LIMIT 1";
$res = $dbconn->query($mysqlquery);
while ($row = $res->fetch_assoc()) {
  $response = 1;
  $id = $row['id'];
  $parent = $row['parent'];
  $owner_id = $row['owner_id'];
}


if ($owner_id == $logged_in_id) {

  // get rid of it
  $mysqlquery = "DELETE FROM underground_codevariants WHERE id='$variant_id'";
  $dbconn->query($mysqlquery);

  // get rid of ratings
  $mysqlquery = "DELETE FROM underground_coderatings WHERE variant_id='$id'";
  $dbconn->query($mysqlquery);

  $other_children = 0;
  $mysqlquery = "SELECT * FROM underground_codevariants WHERE parent='$parent' ORDER BY id DESC";
  $res = $dbconn->query($mysqlquery);
  while ($row = $res->fetch_assoc()) {
    $other_children = 1;
  }

  if ($other_children == 0) {
    $mysqlquery = "DELETE FROM underground_codesindex WHERE id='$parent'";
    $dbconn->query($mysqlquery);
  }

  $ids[] = $id;
}




$return_arr = array("status" => $response, "ids" => $ids, "other_children" => $other_children);
echo json_encode($return_arr);

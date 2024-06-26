<?php
$comment_id = $typea;
$ids = "";
$response = 0;

$res = $db->sql("SELECT id, owner_id, code_id, parent, child FROM variant_comments WHERE id=? ORDER BY id DESC", 'i', $comment_id);
while ($row = $res->fetch_assoc()) {
  $comment_id = $row['id'];
  $comment_owner_id = $row['owner_id'];
  $comment_code_id = $row['code_id'];
  $comment_parent = $row['parent'];
  $comment_child = $row['child'];
}

if ($comment_owner_id == $logged_in_id) {
  $response = 1;
  $ids = array();

  //is it just an infant?
  if ($comment_child > 0) {
    $ids[] = $comment_id;

    $delete = $comment_id;
    $mysqldelete = "DELETE FROM variant_comments WHERE id='$delete'";
    $dbconn->query($mysqldelete);
    $mysqldelete = "DELETE FROM variant_comment_ratings WHERE example_id='$delete'";
    $dbconn->query($mysqldelete);
  }

  //is it a child?
  else if ($comment_child == 0 && $comment_parent > 0) {

    $mysqlquery2 = "SELECT id, child FROM variant_comments WHERE child='$comment_id' ORDER BY id DESC";
    $res2 = $dbconn->query($mysqlquery2);
    while ($row2 = $res2->fetch_assoc()) {
      $ids[] = $row2['id'];

      $delete = $row2['id'];
      $mysqldelete = "DELETE FROM variant_comments WHERE id='$delete'";
      $dbconn->query($mysqldelete);
      $mysqldelete = "DELETE FROM variant_comment_ratings WHERE example_id='$delete'";
      $dbconn->query($mysqldelete);
    }

    $ids[] = $comment_id;

    $delete = $comment_id;
    $mysqldelete = "DELETE FROM variant_comments WHERE id='$delete'";
    $dbconn->query($mysqldelete);
    $mysqldelete = "DELETE FROM variant_comment_ratings WHERE example_id='$delete'";
    $dbconn->query($mysqldelete);
  } else if ($comment_parent == 0) {

    $mysqlquery2 = "SELECT id, parent, child FROM variant_comments WHERE parent='$comment_id' ORDER BY id DESC";
    $res2 = $dbconn->query($mysqlquery2);
    while ($row2 = $res2->fetch_assoc()) {

      $child_id = $row2['id'];

      $mysqlquery3 = "SELECT id, parent, child FROM variant_comments WHERE child='$child_id' ORDER BY id DESC";
      $res3 = $dbconn->query($mysqlquery3);
      while ($row3 = $res3->fetch_assoc()) {
        $ids[] = $row3['id'];

        $delete = $row3['id'];
        $mysqldelete = "DELETE FROM variant_comments WHERE id='$delete'";
        $dbconn->query($mysqldelete);
        $mysqldelete = "DELETE FROM variant_comment_ratings WHERE example_id='$delete'";
        $dbconn->query($mysqldelete);
      }

      $ids[] = $row2['id'];

      $delete = $row2['id'];
      $mysqldelete = "DELETE FROM variant_comments WHERE id='$delete'";
      $dbconn->query($mysqldelete);
      $mysqldelete = "DELETE FROM variant_comment_ratings WHERE example_id='$delete'";
      $dbconn->query($mysqldelete);
    }

    $ids[] = $comment_id;

    $delete = $comment_id;
    $mysqldelete = "DELETE FROM variant_comments WHERE id='$delete'";
    $dbconn->query($mysqldelete);
    $mysqldelete = "DELETE FROM variant_comment_ratings WHERE example_id='$delete'";
    $dbconn->query($mysqldelete);
  }
} else {
  $response = 0;
}


$return_arr = array("status" => $response, "ids" => $ids);
echo json_encode($return_arr);

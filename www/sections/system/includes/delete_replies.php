<?php
//delete comments
$ids = "";
$response = 0;

$mysqlquery = "SELECT id, owner_id, topic_id, parent, child FROM topic_replies WHERE id='$comment_id' ORDER BY id DESC";
$res = $dbconn->query($mysqlquery);
while ($row = $res->fetch_assoc()) {
  $comment_id = $row['id'];
  $comment_owner_id = $row['owner_id'];
  $comment_topic_id = $row['topic_id'];
  $comment_parent = $row['parent'];
  $comment_child = $row['child'];
}

if ($comment_owner_id == $logged_in_id or $logged_in_id == 1) {
  $response = 1;
  $ids = array();

  //is it just an infant?
  if ($comment_child > 0) {
    $ids[] = $comment_id;

    $delete = $comment_id;
    $mysqldelete = "DELETE FROM topic_replies WHERE id='$delete'";
    $dbconn->query($mysqldelete);
    $mysqldelete = "DELETE FROM reply_ratings WHERE reply_id='$delete'";
    $dbconn->query($mysqldelete);
  }

  //is it a child?
  else if ($comment_child == 0 && $comment_parent > 0) {

    $mysqlquery2 = "SELECT id, child FROM topic_replies WHERE child='$comment_id' ORDER BY id DESC";
    $res2 = $dbconn->query($mysqlquery2);
    while ($row2 = $res2->fetch_assoc()) {
      $ids[] = $row2['id'];

      $delete = $row2['id'];
      $mysqldelete = "DELETE FROM topic_replies WHERE id='$delete'";
      $dbconn->query($mysqldelete);
      $mysqldelete = "DELETE FROM reply_ratings WHERE reply_id='$delete'";
      $dbconn->query($mysqldelete);
    }

    $ids[] = $comment_id;

    $delete = $comment_id;
    $mysqldelete = "DELETE FROM topic_replies WHERE id='$delete'";
    $dbconn->query($mysqldelete);
    $mysqldelete = "DELETE FROM reply_ratings WHERE reply_id='$delete'";
    $dbconn->query($mysqldelete);
  } else if ($comment_parent == 0) {

    $mysqlquery2 = "SELECT id, parent, child FROM topic_replies WHERE parent='$comment_id' ORDER BY id DESC";
    $res2 = $dbconn->query($mysqlquery2);
    while ($row2 = $res2->fetch_assoc()) {

      $child_id = $row2['id'];

      $mysqlquery3 = "SELECT id, parent, child FROM topic_replies WHERE child='$child_id' ORDER BY id DESC";
      $res3 = $dbconn->query($mysqlquery3);
      while ($row3 = $res3->fetch_assoc()) {
        $ids[] = $row3['id'];

        $delete = $row3['id'];
        $mysqldelete = "DELETE FROM topic_replies WHERE id='$delete'";
        $dbconn->query($mysqldelete);
        $mysqldelete = "DELETE FROM reply_ratings WHERE reply_id='$delete'";
        $dbconn->query($mysqldelete);
      }

      $ids[] = $row2['id'];

      $delete = $row2['id'];
      $mysqldelete = "DELETE FROM topic_replies WHERE id='$delete'";
      $dbconn->query($mysqldelete);
      $mysqldelete = "DELETE FROM reply_ratings WHERE reply_id='$delete'";
      $dbconn->query($mysqldelete);
    }

    $ids[] = $comment_id;

    $delete = $comment_id;
    $mysqldelete = "DELETE FROM topic_replies WHERE id='$delete'";
    $dbconn->query($mysqldelete);
    $mysqldelete = "DELETE FROM reply_ratings WHERE reply_id='$delete'";
    $dbconn->query($mysqldelete);
  }
} else {
  $response = 0;
}

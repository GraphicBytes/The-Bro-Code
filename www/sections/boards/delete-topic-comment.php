<?php
$reply_id = $typea;
$ids="";
$response=0;

$mysqlquery="SELECT id, owner_id, topic_id, parent, child FROM topic_replies WHERE id='$reply_id' ORDER BY id DESC";
$res=$dbconn->query($mysqlquery);
while($row=$res->fetch_assoc()) {
  $reply_id=$row['id'];
  $comment_owner_id=$row['owner_id'];
  $comment_topic_id=$row['topic_id'];
  $comment_parent=$row['parent'];
  $comment_child=$row['child'];
}
if($comment_owner_id == $logged_in_id){
  $response=1;
  $ids=array();

  //is it just an infant?
  if ($comment_child > 0) {
    $ids[]=$reply_id;

    $delete=$reply_id;
    $mysqldelete="DELETE FROM topic_replies WHERE id='$delete'";
    $dbconn->query($mysqldelete);
    $mysqldelete="DELETE FROM reply_ratings WHERE reply_id='$delete'";
    $dbconn->query($mysqldelete);
  }

  //is it a child?
  else if ($comment_child == 0 && $comment_parent > 0) {

    $mysqlquery2="SELECT id, child FROM topic_replies WHERE child='$reply_id' ORDER BY id DESC";
    $res2=$dbconn->query($mysqlquery2);
    while($row2=$res2->fetch_assoc()) {
      $ids[]=$row2['id'];

      $delete=$row2['id'];
      $mysqldelete="DELETE FROM topic_replies WHERE id='$delete'";
      $dbconn->query($mysqldelete);
      $mysqldelete="DELETE FROM reply_ratings WHERE reply_id='$delete'";
      $dbconn->query($mysqldelete);

    }

    $ids[]=$reply_id;

    $delete=$reply_id;
    $mysqldelete="DELETE FROM topic_replies WHERE id='$delete'";
    $dbconn->query($mysqldelete);
    $mysqldelete="DELETE FROM reply_ratings WHERE reply_id='$delete'";
    $dbconn->query($mysqldelete);

  }

  else if ($comment_parent == 0) {

    $mysqlquery2="SELECT id, parent, child FROM topic_replies WHERE parent='$reply_id' ORDER BY id DESC";
    $res2=$dbconn->query($mysqlquery2);
    while($row2=$res2->fetch_assoc()) {

      $child_id=$row2['id'];

      $mysqlquery3="SELECT id, parent, child FROM topic_replies WHERE child='$child_id' ORDER BY id DESC";
      $res3=$dbconn->query($mysqlquery3);
      while($row3=$res3->fetch_assoc()) {
        $ids[]=$row3['id'];

        $delete=$row3['id'];
        $mysqldelete="DELETE FROM topic_replies WHERE id='$delete'";
        $dbconn->query($mysqldelete);
        $mysqldelete="DELETE FROM reply_ratings WHERE reply_id='$delete'";
        $dbconn->query($mysqldelete);
      }

      $ids[]=$row2['id'];

      $delete=$row2['id'];
      $mysqldelete="DELETE FROM topic_replies WHERE id='$delete'";
      $dbconn->query($mysqldelete);
      $mysqldelete="DELETE FROM reply_ratings WHERE reply_id='$delete'";
      $dbconn->query($mysqldelete);
    }

    $ids[]=$reply_id;

    $delete=$reply_id;
    $mysqldelete="DELETE FROM topic_replies WHERE id='$delete'";
    $dbconn->query($mysqldelete);
    $mysqldelete="DELETE FROM reply_ratings WHERE reply_id='$delete'";
    $dbconn->query($mysqldelete);
  }

} else {
  $response=0;
}


$return_arr = array("status" => $response, "ids"=> $ids);
echo json_encode($return_arr);





?>

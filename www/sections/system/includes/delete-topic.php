<?php

// delete all reply ratings for this topic
$mysqlquery3 = "SELECT id, topic_id FROM topic_replies WHERE topic_id='$topic_id' ORDER BY id";
$res3 = $dbconn->query($mysqlquery3);
while ($row3 = $res3->fetch_assoc()) {
  $reply_id = $row3['id'];
  $delete_query = "DELETE FROM reply_ratings WHERE reply_id='$reply_id'";
  $dbconn->query($delete_query);
}


// delete all REPLIES
$delete_query = "DELETE FROM topic_replies WHERE topic_id='$topic_id'";
$dbconn->query($delete_query);


// delete all topic ratings
$delete_query = "DELETE FROM topic_ratings WHERE topic_id='$topic_id'";
$dbconn->query($delete_query);

//delete the topic
$delete_query = "DELETE FROM topics WHERE id='$topic_id'";
$dbconn->query($delete_query);

// delete topic votes
$delete_query = "DELETE FROM topic_poll_votes WHERE id='$topic_id'";
$dbconn->query($delete_query);


// delete topic images
$topic_gallery_ids = unserialize($topic_gallery_ids);
foreach ($topic_gallery_ids as $key => $value) {
  delete_image($value);
  $delete_query = "DELETE FROM uploads WHERE id='$value'";
  $dbconn->query($delete_query);
}
















//

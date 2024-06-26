<?php
$comment_id = $typea;
$vote = $typeb;

//see if user has already voted
$vote_already=0;
$mysqlquery3="SELECT * FROM reply_ratings WHERE user_id='$logged_in_id' AND reply_id='$comment_id' ORDER BY id DESC";
$res3=$dbconn->query($mysqlquery3);
while($row3=$res3->fetch_assoc()) {
  $currentvote = $row3['vote'];
  $vote_already=1;
}

if($vote_already==0) {

    $mysqlquery="INSERT INTO reply_ratings SET user_id='$logged_in_id', reply_id='$comment_id', vote='$vote'";
    $dbconn->query($mysqlquery);

    if ($vote == 0) {
      $mysqlquery2="UPDATE topic_replies SET down_votes=down_votes+1 WHERE id='$comment_id'";
      $dbconn->query($mysqlquery2);
    } else if($vote == 1){
      $mysqlquery2="UPDATE topic_replies SET up_votes=up_votes+1 WHERE id='$comment_id'";
      $dbconn->query($mysqlquery2);
    }

} else if($vote_already == 1){
  if ($currentvote != $vote) {

    $mysqlquery4="UPDATE reply_ratings SET vote='$vote' WHERE user_id='$logged_in_id' AND reply_id='$comment_id'";
    $dbconn->query($mysqlquery4);

    if($vote==0){

      if($currentvote==1){
        $mysqlquery3="UPDATE topic_replies SET down_votes=down_votes+1, up_votes=up_votes-1 WHERE id='$comment_id'";
      } else if($currentvote==2){
        $mysqlquery3="UPDATE topic_replies SET down_votes=down_votes+1 WHERE id='$comment_id'";
      }

    } else if($vote==1){

      if($currentvote==0){
        $mysqlquery3="UPDATE topic_replies SET down_votes=down_votes-1, up_votes=up_votes+1 WHERE id='$comment_id'";
      } else if($currentvote==2){
        $mysqlquery3="UPDATE topic_replies SET up_votes=up_votes+1 WHERE id='$comment_id'";
      }

    } else if($vote==2){
      if($currentvote==0){
        $mysqlquery3="UPDATE topic_replies SET down_votes=down_votes-1 WHERE id='$comment_id'";
      } else if($currentvote==1){
        $mysqlquery3="UPDATE topic_replies SET up_votes=up_votes-1 WHERE id='$comment_id'";
      }
    }

    $dbconn->query($mysqlquery3);

  }
}










$mysqlquery="SELECT id, up_votes, down_votes FROM topic_replies WHERE id='$comment_id' ORDER BY id ASC LIMIT 1";
$res=$dbconn->query($mysqlquery);
while($row=$res->fetch_assoc()) {
  $up_votes = $row['up_votes'];
  $down_votes = $row['down_votes'];
  $rating = $up_votes - $down_votes;
  if($rating > 0){$rating='+'.$rating;}
  else if($rating == 0){$rating='-';}
}


$return_arr = array("response" => "1", "rating"=> $rating);
echo json_encode($return_arr);
?>

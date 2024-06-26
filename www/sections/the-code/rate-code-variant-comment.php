<?php
$comment_id = $typea;
$vote = $typeb;

//see if user has already voted
$vote_already = 0;
$res3 = $db->sql("SELECT * FROM variant_comment_ratings WHERE user_id=? AND example_id=? ORDER BY id DESC", 'ii', $logged_in_id, $comment_id);
while ($row3 = $res3->fetch_assoc()) {
  $currentvote = $row3['vote'];
  $vote_already = 1;
}

if ($vote_already == 0) {

  $db->sql("INSERT INTO variant_comment_ratings SET user_id=?, example_id=?, vote=?", 'iii', $logged_in_id, $comment_id, $vote);

  if ($vote == 0) {
    $db->sql("UPDATE variant_comments SET down_votes=down_votes+1 WHERE id=?", 'i', $comment_id);
  } else if ($vote == 1) {
    $db->sql("UPDATE variant_comments SET up_votes=up_votes+1 WHERE id=?", 'i', $comment_id);
  }
} else if ($vote_already == 1) {
  if ($currentvote != $vote) {

    $mysqlquery4 = "UPDATE variant_comment_ratings SET vote='$vote' WHERE user_id='$logged_in_id' AND example_id='$comment_id'";
    $db->sql("UPDATE variant_comment_ratings SET vote=? WHERE user_id=? AND example_id=?", 'iii', $vote, $logged_in_id, $comment_id);

    if ($vote == 0) {

      if ($currentvote == 1) {
        $mysqlquery3 = "UPDATE variant_comments SET down_votes=down_votes+1, up_votes=up_votes-1 WHERE id=?";
      } else if ($currentvote == 2) {
        $mysqlquery3 = "UPDATE variant_comments SET down_votes=down_votes+1 WHERE id=?";
      }
    } else if ($vote == 1) {

      if ($currentvote == 0) {
        $mysqlquery3 = "UPDATE variant_comments SET down_votes=down_votes-1, up_votes=up_votes+1 WHERE id=?";
      } else if ($currentvote == 2) {
        $mysqlquery3 = "UPDATE variant_comments SET up_votes=up_votes+1 WHERE id=?";
      }
    } else if ($vote == 2) {
      if ($currentvote == 0) {
        $mysqlquery3 = "UPDATE variant_comments SET down_votes=down_votes-1 WHERE id=?";
      } else if ($currentvote == 1) {
        $mysqlquery3 = "UPDATE variant_comments SET up_votes=up_votes-1 WHERE id=?";
      }
    }

    $db->sql($mysqlquery3, 'i', $comment_id);
  }
}








$res = $db->sql("SELECT id, up_votes, down_votes FROM variant_comments WHERE id=? ORDER BY id ASC LIMIT 1", 'i', $comment_id);
while ($row = $res->fetch_assoc()) {
  $up_votes = $row['up_votes'];
  $down_votes = $row['down_votes'];
  $rating = $up_votes - $down_votes;
  if ($rating > 0) {
    $rating = '+' . $rating;
  } else if ($rating == 0) {
    $rating = '-';
  }
}


$return_arr = array("response" => "1", "rating" => $rating);
echo json_encode($return_arr);

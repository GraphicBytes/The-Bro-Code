<?php
$topic_id = $typea;
$user_choice = $typeb;
$old_new_value = 0;
$old_id = 0;
//have they already voted here?

$already_voted = 0;
$votequery="SELECT topic_id, user_id, vote FROM topic_poll_votes WHERE topic_id='$topic_id' AND user_id='$logged_in_id' ORDER BY id ASC";
$res=$dbconn->query($votequery);
while($row=$res->fetch_assoc()) {
  $already_voted = 1;
  $old_id = $row['vote'];
}

if ($already_voted==1) {

  $get_poll_vote_count_query="SELECT id, topic_id, vote FROM topic_poll_votes WHERE topic_id='$topic_id' AND vote='$old_id' ORDER BY id ASC";
  $poll_vote_count_sql=$dbconn->query($get_poll_vote_count_query);
  $old_new_value=mysqli_num_rows($poll_vote_count_sql);
  $old_new_value=$old_new_value-1;

  $votequery="UPDATE topic_poll_votes SET vote='$user_choice' WHERE topic_id='$topic_id' AND user_id='$logged_in_id'";
} else {
  $votequery="INSERT INTO topic_poll_votes SET topic_id='$topic_id', user_id='$logged_in_id', vote='$user_choice'";
}
$dbconn->query($votequery);



$get_poll_vote_count_query="SELECT id, topic_id, vote FROM topic_poll_votes WHERE topic_id='$topic_id' AND vote='$user_choice' ORDER BY id ASC";
$poll_vote_count_sql=$dbconn->query($get_poll_vote_count_query);
$poll_vote_count=mysqli_num_rows($poll_vote_count_sql);



$return_arr = array("response" => 1, "updated_total" => $poll_vote_count, "already_voted" => $already_voted, "old_id" => $old_id, "old_new_value" => $old_new_value);
echo json_encode($return_arr);





















//

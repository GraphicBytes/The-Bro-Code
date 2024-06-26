<?php
$variant_id = $typea;
$vote = $typeb;

//see if user has already voted
$vote_already = 0;
$res3 = $db->sql("SELECT * FROM underground_coderatings WHERE user_id=? AND variant_id=? ORDER BY id DESC", 'ii', $logged_in_id, $variant_id);
while ($row3 = $res3->fetch_assoc()) {
  $currentvote = $row3['vote'];
  $vote_already = 1;
}

if ($vote_already == 0) {

  $db->sql("INSERT INTO underground_coderatings SET user_id=?, variant_id=?, vote=?", 'iii', $logged_in_id, $variant_id, $vote);

  if ($vote == 0) {
    $db->sql("UPDATE underground_codevariants SET down_votes=down_votes+1 WHERE id=?", 'i', $variant_id);
  } else if ($vote == 1) {
    $db->sql("UPDATE underground_codevariants SET up_votes=up_votes+1 WHERE id=?", 'i', $variant_id);
  }
} else if ($vote_already == 1) {
  if ($currentvote != $vote) {

    $db->sql("UPDATE underground_coderatings SET vote=? WHERE user_id=? AND variant_id=?", 'iii', $vote, $logged_in_id, $variant_id);

    if ($vote == 0) {

      if ($currentvote == 1) {
        $mysqlquery3 = "UPDATE underground_codevariants SET down_votes=down_votes+1, up_votes=up_votes-1 WHERE id=?";
      } else if ($currentvote == 2) {
        $mysqlquery3 = "UPDATE underground_codevariants SET down_votes=down_votes+1 WHERE id=?";
      }
    } else if ($vote == 1) {

      if ($currentvote == 0) {
        $mysqlquery3 = "UPDATE underground_codevariants SET down_votes=down_votes-1, up_votes=up_votes+1 WHERE id=?";
      } else if ($currentvote == 2) {
        $mysqlquery3 = "UPDATE underground_codevariants SET up_votes=up_votes+1 WHERE id=?";
      }
    } else if ($vote == 2) {
      if ($currentvote == 0) {
        $mysqlquery3 = "UPDATE underground_codevariants SET down_votes=down_votes-1 WHERE id=?";
      } else if ($currentvote == 1) {
        $mysqlquery3 = "UPDATE underground_codevariants SET up_votes=up_votes-1 WHERE id=?";
      }
    }

    $db->sql($mysqlquery3, 'i', $variant_id);
  }
}

$rating = 0;
$mysqlquery = "SELECT id, up_votes, down_votes FROM underground_codevariants WHERE id='$variant_id' ORDER BY id ASC LIMIT 1";
$res = $dbconn->query($mysqlquery);
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





$mysqlquery = "SELECT parent FROM underground_codevariants WHERE id='$variant_id' ORDER BY id ASC LIMIT 1";
$res = $dbconn->query($mysqlquery);
while ($row = $res->fetch_assoc()) {
  $parent = $row['parent'];
}




$total = -999999999;
$res = $db->sql("SELECT up_votes, down_votes FROM underground_codevariants WHERE parent=? ORDER BY id ASC", 'i', $parent);
while ($row = $res->fetch_assoc()) {

  $up_votes = $row['up_votes'];
  $down_votes = $row['down_votes'];
  $this_score = $up_votes - $down_votes;

  if ($this_score > $total) {
    $total = $this_score;
  }
}

$db->sql("UPDATE underground_codesindex SET totalvotes=? WHERE id=?", 'ii', $total, $parent);



$return_arr = array("response" => "1", "rating" => $rating, "total" => $total);
echo json_encode($return_arr);

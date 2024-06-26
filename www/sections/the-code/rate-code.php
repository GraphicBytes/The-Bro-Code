<?php
$code_id = $typea;
$vote = $typeb;

//see if user has already voted
$vote_already = 0;
$res3 = $db->sql("SELECT * FROM thecode_ratings WHERE user_id=? AND code_id=? ORDER BY id DESC", 'ii', $logged_in_id, $code_id);
while ($row3 = $res3->fetch_assoc()) {
  $currentvote = $row3['vote'];
  $vote_already = 1;
}

if ($vote_already == 0) {

  $db->sql("INSERT INTO thecode_ratings SET user_id=?, code_id=?, vote=?", 'iii', $logged_in_id, $code_id, $vote);

  if ($vote == 0) {
    $db->sql("UPDATE thecode SET votes_down=votes_down+1 WHERE id=?", 'i', $code_id);
  } else if ($vote == 1) {
    $db->sql("UPDATE thecode SET votes_up=votes_up+1 WHERE id=?", 'i', $code_id);
  }
} else if ($vote_already == 1) {
  if ($currentvote != $vote) {

    $db->sql("UPDATE thecode_ratings SET vote=? WHERE user_id=? AND code_id=?", 'iii', $vote, $logged_in_id, $code_id);

    if ($vote == 0) {

      if ($currentvote == 1) {
        $mysqlquery3 = "UPDATE thecode SET votes_down=votes_down+1, votes_up=votes_up-1 WHERE id=?";
      } else if ($currentvote == 2) {
        $mysqlquery3 = "UPDATE thecode SET votes_down=votes_down+1 WHERE id=?";
      }
    } else if ($vote == 1) {

      if ($currentvote == 0) {
        $mysqlquery3 = "UPDATE thecode SET votes_down=votes_down-1, votes_up=votes_up+1 WHERE id=?";
      } else if ($currentvote == 2) {
        $mysqlquery3 = "UPDATE thecode SET votes_up=votes_up+1 WHERE id=?";
      }
    } else if ($vote == 2) {
      if ($currentvote == 0) {
        $mysqlquery3 = "UPDATE thecode SET votes_down=votes_down-1 WHERE id=?";
      } else if ($currentvote == 1) {
        $mysqlquery3 = "UPDATE thecode SET votes_up=votes_up-1 WHERE id=?";
      }
    }

    $db->sql($mysqlquery3, 'i', $code_id);
  }
}



$res = $db->sql("SELECT id, votes_up, votes_down FROM thecode WHERE id=? ORDER BY id ASC LIMIT 1", 'i', $code_id);
while ($row = $res->fetch_assoc()) {
  $votes_up = $row['votes_up'];
  $votes_down = $row['votes_down'];
  $rating = $votes_up - $votes_down;
  if ($rating > 0) {
    $rating = '+' . $rating;
  } else if ($rating == 0) {
    $rating = '-';
  }
}


$return_arr = array("response" => "1", "rating" => $rating);
echo json_encode($return_arr);

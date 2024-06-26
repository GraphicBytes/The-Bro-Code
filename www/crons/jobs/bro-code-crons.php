<?php
$last_codes_checked=$system_data['last_codes_checked'];


$update_check=$request_time - $last_codes_checked;


$recalculate = 0;
if($update_check > 300){
 $recalculate = 1;
}
if($recalculate == 1){


  ///// Are there any new codes to add????

  $codes_launched = $system_data['codes_launched'];
  //$minimum_score = $codes_launched*($codes_launched/100);
  //$minimum_score = $codes_launched;
  $minimum_score = 5;

  echo "Minimum score for new code: ".$minimum_score;
  echo "<br /><br />";

  $current_next_code = $system_data['current_next_code'];

  $current_next_code_timer = $system_data['current_next_code_timer'];



  $do_any_qualify=0;
  $mysqlquery="SELECT * FROM underground_codesindex WHERE status > 0 AND status < 3 AND totalvotes > '$minimum_score' ORDER BY totalvotes DESC LIMIT 1";
  $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
  while($row=$res->fetch_assoc()) {
    $code_id = $row['id'];
    $totalvotes = $row['totalvotes'];
    $owner_id = $row['owner_id'];
    $do_any_qualify=1;
  }


  if ($do_any_qualify == 0) {

    $mysqlquery="UPDATE system SET value='0' WHERE name='current_next_code'";
    $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

    $mysqlquery="UPDATE system SET value='0' WHERE name='current_next_code_timer'";
    $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

    $mysqlquery="SELECT * FROM underground_codesindex WHERE status > 0 AND status < 3 AND totalvotes > '0' ORDER BY totalvotes DESC LIMIT 1";
    $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
    while($row=$res->fetch_assoc()) {
      $winning_code_id = $row['id'];

      $mysqlquery="UPDATE system SET value='$winning_code_id' WHERE name='current_winning_code'";
      $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
    }


    echo "NO CODE QUALIFIES, PROMOTING NEXT IN LINE INSTEAD<br />";
    echo "<br /><br />";
  }
  if ($do_any_qualify == 1) {

    if ($current_next_code == $code_id) {

      //if top for 1 whole week, go live
      $go_live_timer = $request_time - $current_next_code_timer;
      $go_live_wait = $new_code_timer;

      if ($go_live_timer > $new_code_timer) {

        //lock discussion
        $mysqlquery="UPDATE underground_codesindex SET status='3', include_time='$request_time' WHERE id='$current_next_code'";
        $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

        //add code
        $mysqlquery="SELECT *, up_votes-down_votes as rating FROM underground_codevariants WHERE parent='$code_id' ORDER BY rating DESC LIMIT 1";
        $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
        while($row=$res->fetch_assoc()) {
          $parent = $row['parent'];
          $variant_owner_id = $row['owner_id'];
          $content = $row['content'];
        }

        //prep new code
        echo $owner_id;
        echo "<br />";
        echo $variant_owner_id;
        echo "<br />";
        echo $suggestion_id = $code_id;
        echo "<br />";
        echo $content;
        echo "<br />";
        echo $slug = create_slug($content,100);
        echo "<br />";
        echo $post_time = $request_time;
        echo "<br /><br />";

        $mysqlquery="UPDATE system SET value='0' WHERE name='current_next_code'";
        $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
        $mysqlquery="UPDATE system SET value='0' WHERE name='current_next_code_timer'";
        $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

        $mysqlquery="INSERT INTO thecode SET
        owner_id='$owner_id',
        variant_owner_id='$variant_owner_id',
        suggestion_id='$suggestion_id',
        content='$content',
        slug='$slug',
        post_time='$post_time'";
        $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

        $codes_launched_update = $codes_launched + 1;
        $mysqlqueryb="UPDATE system SET value='$codes_launched_update' WHERE name='codes_launched'";
        $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));

        if ($owner_id==$variant_owner_id) {
          //set notification
          $title="Your suggestion has been included into The Bro Code";
          $message=$content;
          $mysqlquery3="INSERT INTO notifications SET title='$title', user_id='$owner_id', message='$message', section='0', section_id='$code_id', type='0'";
          $dbconn->query($mysqlquery3) or die(mysqli_error($dbconn));
        } else {
          //set notification
          $title="Your idea has been included into The Bro Code";
          $message=$content;
          $mysqlquery3="INSERT INTO notifications SET title='$title', user_id='$owner_id', message='$message', section='0', section_id='$code_id', type='0'";
          $dbconn->query($mysqlquery3) or die(mysqli_error($dbconn));
          //set notification
          $title="Your suggestion has been included into The Bro Code";
          $message=$content;
          $mysqlquery3="INSERT INTO notifications SET title='$title', user_id='$variant_owner_id', message='$message', section='0', section_id='$code_id', type='0'";
          $dbconn->query($mysqlquery3) or die(mysqli_error($dbconn));
        }










        echo "NEW CODE LIVE<br />";
        echo "<br /><br />";
      } else {
        echo "NEW CODE " .  $go_live_wait . " SECONDS AWAY TO GOING LIVE<br />";
        echo "<br /><br />";
      }


    } else {
      $mysqlquery="UPDATE system SET value='$code_id' WHERE name='current_next_code'";
      $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

      $mysqlquery="UPDATE system SET value='$request_time' WHERE name='current_next_code_timer'";
      $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

      $mysqlquery="UPDATE system SET value='0' WHERE name='current_winning_code'";
      $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

      echo "NEW CODE QUALIFIES, ADDED AS NEXT TO GO LIVE<br />";
      echo "<br /><br />";
    }
  }












  ///// Are any codes struck off?

  $mysqlquery="SELECT *, votes_up - votes_down AS rating FROM thecode ORDER BY id ASC";
  $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
  while($row=$res->fetch_assoc()) {

    $id = $row['id'];
    $rating = $row['rating'];
    $struck_off = $row['struck_off'];


    if (($rating > 0)) {
      $mysqlqueryb="UPDATE thecode SET struck_off='0' WHERE id='$id'";
      $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));
    }
    if (($rating < 0)) {
      $mysqlqueryb="UPDATE thecode SET struck_off='1' WHERE id='$id'";
      $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));
    }

  }



  $mysqlqueryb="UPDATE system SET value='$request_time' WHERE name='last_codes_checked'";
  $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));










  $mysqlquery = "SELECT * FROM thecode ORDER BY id ASC";
  $res = $dbconn->query($mysqlquery);
  while ($row = $res->fetch_assoc()) {

    $code_id = $row['id'];
    $suggestion_id = $row['suggestion_id'];
    $current_code = $row['content'];
    $current_slug = $row['slug'];

    $mysqlquery2 = "SELECT *, up_votes-down_votes as rating FROM underground_codevariants WHERE parent=$suggestion_id AND status='2' ORDER BY rating DESC LIMIT 1";
    $res2 = $dbconn->query($mysqlquery2);
    while ($row2 = $res2->fetch_assoc()) {

      $variant_id = $row2['id'];
      $top_version = $row2['content'];
      $new_owner_id = $row2['owner_id'];
    }


    if ($top_version != $current_code) {

      $new_slug = create_slug($top_version);
      $already_in = 0;

      $mysqlquery3 = "SELECT * FROM old_slugs WHERE slug='$current_slug'";
      $res3 = $dbconn->query($mysqlquery3);
      while ($row3 = $res3->fetch_assoc()) {
        $already_in = 1;
      }


      if ($already_in == 1) {
        $oldSlugSQL = "UPDATE old_slugs SET redirect='$new_slug' WHERE slug='$current_slug'";
      } else {
        $oldSlugSQL = "INSERT INTO old_slugs SET slug='$current_slug', redirect='$new_slug'";
      }
      $dbconn->query($oldSlugSQL);


      $db->sql("UPDATE thecode SET variant_owner_id=?, content=?, slug=? WHERE id=?", "issi", $new_owner_id, $top_version, $new_slug, $code_id);
    }
  }














} else {
  echo "NOT TIME TO CHECK FOR LATEST NEXT CODE<br />";
  echo "<br /><br />";
}





?>

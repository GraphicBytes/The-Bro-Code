<?php
$the_code = $_POST["variant"];
$character_count = strlen($the_code);
$the_code = ucfirst($the_code);
$the_code = str_replace("bro", "Bro", $the_code);
$the_code = str_replace("bros ", "Bros ", $the_code);
$the_code = str_replace("bro's ", "Bro's ", $the_code);
$html = null;

if ($the_code == null or $the_code == "" or $character_count < 5) {

  $html = 'error';
  $return_arr = array("response" => "0", "html" => $html);
  echo json_encode($return_arr);
  exit();
} else {

  // $indexstatus=0;
  // $res=$db->sql( "SELECT * FROM underground_codesindex WHERE id=? ORDER BY id DESC LIMIT 1", 'i' , $typea );
  // while($row=$res->fetch_assoc()) {
  //   $indexstatus=$row['status'];
  // }

  // if ($indexstatus == 3) {
  //   $return_arr = array("response" => "0", "html" => '');
  //   echo json_encode($return_arr);
  //   exit();
  // }



  $time = time();
  $owner_id = $logged_in_id;
  $the_code = $db->clean($the_code);

  $db->sql("INSERT INTO underground_codevariants SET parent = ?, owner_id = ?, content = ?, post_time = ?", 'iisi', $typea, $logged_in_id, $the_code, $time);

  $db->sql("UPDATE underground_codesindex SET last_activity=? WHERE id=?", 'ii', $time, $typea);

  $total = -999999999;
  $res = $db->sql("SELECT up_votes, down_votes FROM underground_codevariants WHERE parent=? ORDER BY id ASC LIMIT 1", 'i', $typea);
  while ($row = $res->fetch_assoc()) {

    $up_votes = $row['up_votes'];
    $down_votes = $row['down_votes'];
    $this_score = $up_votes - $down_votes;

    if ($this_score > $total) {
      $total = $this_score;
    }
  }

  $res = $db->sql("SELECT *, up_votes-down_votes as rating FROM underground_codevariants WHERE owner_id=? AND parent=? ORDER BY id DESC LIMIT 1", 'ii', $logged_in_id, $typea);
  while ($row = $res->fetch_assoc()) {

    $id = $row['id'];
    $parent = $row['parent'];
    $owner_id = $row['owner_id'];

    $post_time = $row['post_time'];
    $up_votes = $row['up_votes'];
    $down_votes = $row['down_votes'];
    $status = $row['status'];

    $content = $row['content'];
    $content = $content;

    $rating = $up_votes - $down_votes;
    if ($rating > 0) {
      $rating = '+' . $rating;
    } else if ($rating == 0) {
      $rating = '-';
    }

    //get user details
    $mysqlqueryb = "SELECT * FROM users WHERE id='$owner_id' ORDER BY id DESC LIMIT 1";
    $resb = $dbconn->query($mysqlqueryb);
    while ($rowb = $resb->fetch_assoc()) {
      $varient_name = $rowb['display_name'];
    }

    ob_start(); ?>

    <div class="comment variant-box-<?php echo $id; ?> brand-new border-top">

      <p><?php
          if ($tandc_seen < 2) {
            echo $profanity->filter_string($content);
          } else {
            echo $content;
          } ?></p>

      <span class="meta border-top">
        <span class="meta-left">

          <span data="<?php echo $base_url; ?>/profile/<?php echo $owner_id; ?>/" class="meta-link <?php if ($owner_id == $logged_in_id) {
                                                                                                      echo "self";
                                                                                                    } ?>" rel="nofollow">
            <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $varient_name; ?>" /> 
            <?php echo $varient_name; ?>
          </span>
        </span>

        <span class="meta-right code-meta-rating-<?php echo $id; ?>">

          <?php if ($logged_in_id > 0 && $owner_id != $logged_in_id) { ?>
            <span class="meta-link downvote code-down code-down-<?php echo $id; ?> <?php if ($vote == 0) {
                                                                                      echo 'on';
                                                                                    } ?>" data-id="<?php echo $id; ?>">
              <?php include($php_base_directory . '/styles/images/svgs/arrow.svg'); ?>
            </span>
          <?php } ?>

          <span class="meta-link-no-hover code-rating code-rating-<?php echo $id; ?>">
            <?php echo $rating; ?>
          </span>

          <?php if ($logged_in_id > 0 && $owner_id != $logged_in_id) { ?>
            <span class="meta-link upvote code-up code-up-<?php echo $id; ?> <?php if ($vote == 1) {
                                                                                echo 'on';
                                                                              } ?>" data-id="<?php echo $id; ?>">
              <?php include($php_base_directory . '/styles/images/svgs/arrow.svg'); ?>
            </span>
          <?php } ?>

          <?php if ($owner_id == $logged_in_id) { ?>
            <span class="meta-link delete-variant delete-variant-<?php echo $id; ?>" data-id="<?php echo $id; ?>" data-spot="0">
              <?php include($php_base_directory . '/styles/images/svgs/delete-icon.svg'); ?>
            </span>
          <?php } ?>

        </span>
      </span>

      <div class="loading invisible alt variant-loading-<?php echo $id; ?>">
        <?php include($php_base_directory . '/includes/loading-alt.php'); ?>
      </div>

      <?php if ($owner_id == $logged_in_id) { ?>
        <div class="are-you-sure variant_are-you-sure-<?php echo $id; ?>" data-spot="0">
          <?php
          $variant_to_delete_id = $id;
          $spot = 0;
          include($php_base_directory . '/includes/delete-variant.php');
          $variant_to_delete_id = 0;
          ?>
        </div>
      <?php } ?>

    </div>


    <script>
      $('.delete-variant-<?php echo $id; ?>').click(function() {
        var variant_id = $(this).attr("data-id");
        var spot = $(this).attr("data-spot");
        delete_variant(variant_id, spot);
      });
    </script>


<?php
    $html = ob_get_contents();
    ob_end_clean();
  }

  $return_arr = array("response" => "1", "html" => $html);
  echo json_encode($return_arr);
  exit();
}


?>
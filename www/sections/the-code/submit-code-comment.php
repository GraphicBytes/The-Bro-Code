<?php
$code_id = $typea;
$parent_id = $typeb;
if ($parent_id == null) {
  $parent_id = 0;
}

$comment = $_POST['comment'];
$character_count = strlen($comment);

$response = 0;
$html = "";

if ($character_count > 1000) {
  $response = 0;
} else if ($character_count < 5) {
  $response = 0;
} else {

  $comment = htmlspecialchars($comment, ENT_QUOTES);
  $post_time = time();

  $mysqlquery = "INSERT INTO thecode_examples SET
  owner_id='$logged_in_id',
  code_id='$code_id',
  parent='$parent_id',
  content='$comment',
  post_time='$post_time',
  last_update='$post_time'";
  $dbconn->query($mysqlquery);

  $response = 1;



  ob_start();

  $mysqlquery = "SELECT *, up_votes-down_votes as rating FROM thecode_examples WHERE code_id='$code_id' AND owner_id='$logged_in_id' ORDER BY post_time DESC, id ASC LIMIT 1";
  $res = $dbconn->query($mysqlquery);
  while ($row = $res->fetch_assoc()) {

    $scenario_id = $row['id'];
    $scenario_owner_id = $row['owner_id'];
    $scenario_post_time = $row['post_time'];
    $status = $row['status'];
    $rating = $row['rating'];
    $sfw = $row['sfw'];
    $content = $row['content'];
    $vdt = new DateTime("@$scenario_post_time");

    if ($rating > 0) {
      $rating = '+' . $rating;
    } else if ($rating == 0) {
      $rating = '-';
    }

    $mysqlquery3 = "SELECT * FROM users WHERE id='$scenario_owner_id' ORDER BY id DESC LIMIT 1";
    $res3 = $dbconn->query($mysqlquery3);
    while ($row3 = $res3->fetch_assoc()) {
      $scenario_owner_name = $row3['display_name'];
    }

?>

    <div class="ghost"></div>

    <div class="comment comment-box-<?php echo $scenario_id; ?> brand-new border-bottom">

      <span class="comment-header">
        <span class="author-name">
          <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $scenario_owner_name; ?>" /> 
        </span>
        <span class="author-post-time"><?php include($php_base_directory . '/styles/images/svgs/clock-icon.svg'); ?><?php echo $vdt->format("dS M Y"); ?></span>
      </span>
      <p><?php echo $content; ?></p>

      <span class="meta border-top">
        <span class="meta-left">
        </span>
        <span class="meta-right code-meta-rating-<?php echo $scenario_id; ?>">

          <span class="meta-link-no-hover rating-<?php echo $scenario_id; ?> <?php if ($logged_in_id < 1) {
                                                                                echo "mobile-hide";
                                                                              } ?>"> - </span>

          <span class="meta-link delete-comment delete-comment-<?php echo $scenario_id; ?>" data-id="<?php echo $scenario_id; ?>">
            <?php include($php_base_directory . '/styles/images/svgs/delete-icon.svg'); ?>
          </span>
          <script>
            $('.delete-comment-<?php echo $scenario_id; ?>').click(function() {
              var comment_id = $(this).attr("data-id");
              delete_comment(comment_id);
            });
          </script>

        </span>
      </span>


      <div class="loading invisible alt comment-loading-<?php echo $scenario_id; ?>">
        <?php include($php_base_directory . '/includes/loading-alt.php'); ?>
      </div>
      <div class="are-you-sure are-you-sure-<?php echo $scenario_id; ?>">
        <?php
        $comment_to_delete_id = $scenario_id;
        include($php_base_directory . '/includes/delete-comment.php');
        $comment_to_delete_id = 0;
        ?>
      </div>

    </div>



<?php
  }

  $html = ob_get_contents();
  ob_end_clean();
}


$return_arr = array("response" => $response, "html" => $html);
echo json_encode($return_arr);

?>
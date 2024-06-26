<?php
$topic_id = $typea;
$parent_id = $typeb;
$child_id = $typec;
if ($parent_id == null) {
  $parent_id = 0;
}
if ($child_id == null) {
  $child_id = 0;
}

$comment = $_POST['reply'];
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

  $mysqlquery = "INSERT INTO topic_replies SET
  owner_id='$logged_in_id',
  topic_id='$topic_id',
  parent='$parent_id',
  child='$child_id',
  content='$comment',
  post_time='$post_time',
  owner_ip='$user_ip'";
  $dbconn->query($mysqlquery);

  $mysqlquery = "UPDATE topic_replies SET last_update='$post_time' WHERE id='$parent_id'";
  $dbconn->query($mysqlquery);

  $response = 1;



  ob_start();

  $mysqlquery = "SELECT *, up_votes-down_votes as rating FROM topic_replies WHERE topic_id='$topic_id' AND owner_id='$logged_in_id' ORDER BY post_time DESC LIMIT 1";
  $res = $dbconn->query($mysqlquery);
  while ($row = $res->fetch_assoc()) {

    $reply_id = $row['id'];
    $reply_owner_id = $row['owner_id'];
    $reply_post_time = $row['post_time'];
    $status = $row['status'];
    $rating = $row['rating'];
    $sfw = $row['sfw'];
    $content = $row['content'];
    $vdt = new DateTime("@$reply_post_time");

    if ($rating > 0) {
      $rating = '+' . $rating;
    } else if ($rating == 0) {
      $rating = '-';
    }

    $mysqlquery3 = "SELECT * FROM users WHERE id='$reply_owner_id' ORDER BY id DESC LIMIT 1";
    $res3 = $dbconn->query($mysqlquery3);
    while ($row3 = $res3->fetch_assoc()) {
      $reply_owner_name = $row3['display_name'];
    }

?>

    <div class="ghost-<?php echo $reply_id; ?>"></div>

    <div class="comment comment-box-<?php echo $reply_id; ?> brand-new border-bottom <?php if ($child_id > 0) {
                                                                                        echo "infant";
                                                                                      } else {
                                                                                        echo "child";
                                                                                      } ?>">

      <p><?php echo $content; ?></p>

      <span class="meta border-top">
        <span class="meta-left">
          <a href="<?php echo $base_url; ?>/profile/<?php echo $reply_owner_id; ?>/" class="meta-link" rel="nofollow">
            <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $reply_owner_name; ?>" /> 
            <?php echo $reply_owner_name; ?>
          </a>
          <a href="<?php echo $base_url; ?>/profile/<?php echo $reply_owner_id; ?>/" class="meta-link" rel="nofollow">
            <?php include($php_base_directory . '/styles/images/svgs/clock-icon.svg'); ?>
            <?php echo $vdt->format("dS M Y g:ia"); ?>
          </a>
        </span>
        <span class="meta-right code-meta-rating-<?php echo $reply_id; ?>">

          <span class="meta-link-no-hover rating-<?php echo $reply_id; ?> <?php if ($logged_in_id < 1) {
                                                                            echo "mobile-hide";
                                                                          } ?>"> - </span>

          <span class="meta-link delete-comment delete-comment-<?php echo $reply_id; ?>" data-id="<?php echo $reply_id; ?>">
            <?php include($php_base_directory . '/styles/images/svgs/delete-icon.svg'); ?>
          </span>
          <script>
            $('.delete-comment-<?php echo $reply_id; ?>').click(function() {
              var comment_id = $(this).attr("data-id");
              delete_comment(comment_id);
            });
          </script>

        </span>
      </span>


      <div class="loading invisible alt comment-loading-<?php echo $reply_id; ?>">
        <?php include($php_base_directory . '/includes/loading-alt.php'); ?>
      </div>
      <div class="are-you-sure are-you-sure-<?php echo $reply_id; ?>">
        <?php
        $comment_to_delete_id = $reply_id;
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
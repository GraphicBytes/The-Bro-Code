<?php

//sleep(2);

$code_id = $typea;
$scenario_id = $typeb;
$child_id = $typec;

$totalcomments = 1;

$post_status = 0;
$mysqlquery = "SELECT * FROM underground_codesindex WHERE id='$code_id' ORDER BY id DESC LIMIT 1";
$res = $dbconn->query($mysqlquery);
while ($row = $res->fetch_assoc()) {
  $post_status = $row['status'];
}




ob_start();

//show infants
if ($tandc_seen < 2) {
  $sfw_sql = " AND sfw < 2 ";
} else {
  $sfw_sql = null;
}
if ($hide_shit == 1) {
  $hide_shit_sql = " AND (up_votes-down_votes) > -50 ";
} else {
  $hide_shit_sql = null;
}

$mysqlquery_infant_replies = "SELECT *, up_votes-down_votes as rating FROM variant_comments WHERE code_id='$code_id' AND child='$scenario_id' $sfw_sql $hide_shit_sql ORDER BY post_time ASC, id ASC";


$mysqlquery_get_parent = "SELECT parent FROM variant_comments WHERE code_id='$code_id' AND id='$scenario_id' ORDER BY post_time DESC, id ASC";
$get_parent_res = $dbconn->query($mysqlquery_get_parent);
while ($get_parent_row = $get_parent_res->fetch_assoc()) {
  $parent_id = $get_parent_row['parent'];
}

?>
<div class="infant-<?php echo $scenario_id; ?>" style="display:none;">
  <div class="infant-container infant-container-<?php echo $scenario_id; ?>">
    <?php
    $infant_res = $dbconn->query($mysqlquery_infant_replies);
    while ($infant_row = $infant_res->fetch_assoc()) {
      $infant_scenario_id = $infant_row['id'];
      $infant_scenario_owner_id = $infant_row['owner_id'];
      $infant_scenario_post_time = $infant_row['post_time'];
      $status = $infant_row['status'];
      $rating = $infant_row['rating'];
      $sfw = $infant_row['sfw'];
      $content = $infant_row['content'];
      $content = $content;
      $vdt = new DateTime("@$infant_scenario_post_time");

      if ($rating > 0) {
        $rating = '+' . $rating;
      } else if ($rating == 0) {
        $rating = '-';
      }

      //get vote of logged in user
      if ($logged_in_id > 0) {
        $vote = 2;
        $mysqlquery2 = "SELECT * FROM variant_comment_ratings WHERE user_id='$logged_in_id' AND example_id='$infant_scenario_id' ORDER BY id DESC";
        $res2 = $dbconn->query($mysqlquery2);
        while ($row2 = $res2->fetch_assoc()) {
          $vote = $row2['vote'];
        }
      }

      //get data of comment author
      $mysqlquery3 = "SELECT id, display_name, avatar_mini, avatar FROM users WHERE id='$infant_scenario_owner_id' ORDER BY id DESC LIMIT 1";
      $res3 = $dbconn->query($mysqlquery3);
      while ($row3 = $res3->fetch_assoc()) {
        $infant_scenario_owner_name = $row3['display_name'];
        $infant_scenario_owner_avatar_mini = $row3['avatar_mini'];
        $infant_scenario_owner_avatar = $row3['avatar'];
      }
    ?>

      <div class="comment comment-box-<?php echo $infant_scenario_id; ?> infant border-top">

        <span class="comment-header">
          <span class="author-name">
            <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $infant_scenario_owner_name; ?>" /> 
          </span>
          <span class="author-post-time"><?php include($php_base_directory . '/styles/images/svgs/clock-icon.svg'); ?><?php echo $vdt->format("dS M Y"); ?></span>
        </span>

        <p><?php
            if ($tandc_seen < 2) {
              echo $profanity->filter_string($content);
            } else {
              echo $content;
            } ?></p>

        <span class="meta border-top">
          <span class="meta-left meta-replies">

          </span>


          <span class="meta-right code-meta-rating-<?php echo $infant_scenario_id; ?>">

            <?php if ($logged_in_id > 0 && $infant_scenario_owner_id != $logged_in_id && $post_status < 3) { ?>
              <span class="meta-link downvote comment-down infant-comment-down-<?php echo $scenario_id ?> comment-down-<?php echo $infant_scenario_id; ?> <?php if ($vote == 0) {
                                                                                                                                                            echo 'on';
                                                                                                                                                          } ?>" data-id="<?php echo $infant_scenario_id; ?>">
                <?php include($php_base_directory . '/styles/images/svgs/arrow.svg'); ?>
              </span>
            <?php } ?>

            <span class="meta-link-no-hover rating-<?php echo $infant_scenario_id; ?>">
              <?php echo $rating; ?>
            </span>

            <?php if ($logged_in_id > 0 && $infant_scenario_owner_id != $logged_in_id && $post_status < 3) { ?>
              <span class="meta-link upvote comment-up infant-comment-up-<?php echo $scenario_id ?> comment-up-<?php echo $infant_scenario_id; ?> <?php if ($vote == 1) {
                                                                                                                                                    echo 'on';
                                                                                                                                                  } ?>" data-id="<?php echo $infant_scenario_id; ?>">
                <?php include($php_base_directory . '/styles/images/svgs/arrow.svg'); ?>
              </span>
            <?php } ?>

            <?php if ($infant_scenario_owner_id == $logged_in_id && $post_status < 3) { ?>
              <span class="meta-link delete-comment delete-comment-<?php echo $infant_scenario_id; ?>" data-id="<?php echo $infant_scenario_id; ?>">
                <?php include($php_base_directory . '/styles/images/svgs/delete-icon.svg'); ?>
              </span>
              <script>
                $('.delete-comment-<?php echo $infant_scenario_id; ?>').click(function() {

                  var comment_id = $(this).attr("data-id");
                  delete_comment(comment_id);
                });
              </script>
            <?php } ?>

          </span>
        </span>

        <div class="loading invisible alt comment-loading-<?php echo $infant_scenario_id; ?>">
          <?php include($php_base_directory . '/includes/loading-alt.php'); ?>
        </div>

        <?php if ($infant_scenario_owner_id == $logged_in_id && $post_status < 3) { ?>
          <div class="are-you-sure are-you-sure-<?php echo $infant_scenario_id; ?>">
            <?php
            $comment_to_delete_id = $infant_scenario_id;
            include($php_base_directory . '/includes/delete-comment.php');
            $comment_to_delete_id = 0;
            ?>
          </div>
        <?php } ?>

      </div>


      <?php if ($logged_in_id == 1 && $moderation == 1) : ?>
        <span class="meta moderation-bar infant moderation-bar-<?php echo $infant_scenario_id; ?> border-top <?php if ($status == 0) {
                                                                                                                echo "warning";
                                                                                                              } ?>">
          <span class="meta-left">
            <span class="meta-link mod-link mod-link-<?php echo $scenario_id; ?> mod-link-sfw mod-link-sfw-<?php echo $infant_scenario_id; ?> <?php if ($sfw == 0 && $status == 1) {
                                                                                                                                                echo "current";
                                                                                                                                              } ?>" data-id="<?php echo $infant_scenario_id; ?>" data-rating="0">
              SFW
            </span>
            <span class="meta-link mod-link mod-link-<?php echo $scenario_id; ?> mod-link-nsfw mod-link-nsfw-<?php echo $infant_scenario_id; ?> <?php if ($sfw == 1 && $status == 1) {
                                                                                                                                                  echo "current";
                                                                                                                                                } ?>" data-id="<?php echo $infant_scenario_id; ?>" data-rating="1">
              NSFW
            </span>
            <span class="meta-link mod-link mod-link-<?php echo $scenario_id; ?> mod-link-monly mod-link-monly-<?php echo $infant_scenario_id; ?> <?php if ($sfw == 2 && $status == 1) {
                                                                                                                                                    echo "current";
                                                                                                                                                  } ?>" data-id="<?php echo $infant_scenario_id; ?>" data-rating="2">
              M.ONLY
            </span>
          </span>

          <span class="meta-right">
            <span class="meta-link mod-link-delete" data-id="<?php echo $infant_scenario_id; ?>">
              DELETE
            </span>
            <span class="meta-link mod-link-warning" data-id="<?php echo $infant_scenario_id; ?>">
              WARNING
            </span>
            <span class="meta-link mod-link-ban" data-id="<?php echo $infant_scenario_id; ?>">
              BAN USER
            </span>
          </span>
        </span>
      <?php endif; ?>




    <?php
      $totalcomments = $totalcomments + 1;
    }
    ?>
    <div class="goto-anchor-<?php echo $scenario_id; ?>">
    </div>
  </div>
  <script>
    <?php if ($logged_in_id == 1 && $moderation == 1) : ?>
      $('.mod-link-<?php echo $scenario_id; ?>').click(function() {
        var comment_id = $(this).attr('data-id');
        var comment_rating = $(this).attr('data-rating');
        moderate_comment(comment_id, comment_rating);
      });
    <?php endif; ?>

    $('.infant-comment-up-<?php echo $scenario_id ?>').click(function() {
      var comment_id = $(this).attr("data-id");
      vote_up(comment_id);
    });

    $('.infant-comment-down-<?php echo $scenario_id ?>').click(function() {
      var comment_id = $(this).attr("data-id");
      vote_down(comment_id);
    });
  </script>


  <?php if ($logged_in_id > 0 && $post_status < 3) : ?>

    <div class="comment infant reply-form-container-<?php echo $scenario_id; ?>">

      <div class="loading alt reply-loading-<?php echo $scenario_id; ?>">
        <?php include($php_base_directory . '/includes/loading-alt.php'); ?>
      </div>

      <form method="post" class="reply-form reply-form-<?php echo $scenario_id; ?>" action="<?php echo $base_url; ?>/replyto-code-variant-comment/<?php echo $code_id; ?>/<?php echo $parent_id; ?>/<?php echo $scenario_id; ?>/" enctype="multipart/form-data">
        <textarea maxlength='1500' class="reply-comment-box reply-comment-box-<?php echo $scenario_id; ?>" id="reply-<?php echo $scenario_id; ?>" name="reply" placeholder="Reply to this comment!"></textarea>

        <span class="meta border-top">

          <span class="meta-left">
            <span class="meta-link-no-hover character_count-<?php echo $scenario_id; ?>">
              0/1000
            </span>
          </span>

          <span class="meta-right">
            <input class="reply-submit reply-submit-<?php echo $scenario_id; ?>" id="submit-<?php echo $scenario_id; ?>" type="submit" value="REPLY" disabled />
          </span>

        </span>

      </form>
    </div>
  <?php endif; ?>



</div>



<?php if ($logged_in_id > 0 && $post_status < 3) {
  // JS to catch reply submissions and to count the characters
?>
  <script>
    $('.reply-submit-<?php echo $scenario_id; ?>').click(function() {
      event.preventDefault();
      $(".reply-loading-<?php echo $scenario_id; ?>").addClass("active");

      $.ajax({
        url: $('.reply-form-<?php echo $scenario_id; ?>').attr('action'),
        type: 'POST',
        data: $('.reply-form-<?php echo $scenario_id; ?>').serialize(),
        success: function(data) {
          var obj = JSON.parse(data);
          var response_code = obj['response'];
          var newhtml = obj['html'];

          if (response_code == 0) {
            $(".reply-loading-<?php echo $scenario_id; ?>").removeClass("active");
          }
          if (response_code == 1) {
            $(".reply-comment-box-<?php echo $scenario_id; ?>").val("");

            $(".infant-container-<?php echo $scenario_id; ?>").append(newhtml);

            $('html, body').animate({
              scrollTop: $(".goto-anchor-<?php echo $scenario_id; ?>").offset().top - 350
            }, {
              duration: 1000,
              easing: "easeOutQuint"
            });

            $(".reply-form-<?php echo $scenario_id; ?>").replaceWith("");
            $(".reply-spacer-<?php echo $scenario_id; ?>").replaceWith("");

            $(".reply-loading-<?php echo $scenario_id; ?>").removeClass("active");
          }

        }
      });
      return false;
    });



    $('#reply-<?php echo $scenario_id; ?>').on('input', function() {
      var scroll_height = $('#reply-<?php echo $scenario_id; ?>').get(0).scrollHeight;
      $('#reply-<?php echo $scenario_id; ?>').css('height', scroll_height + 'px');

      minlength = 5;
      var maxlength = 1000;
      var currentLength = $('#reply-<?php echo $scenario_id; ?>').val().length;
      var newcount = currentLength + "/" + maxlength;
      $('.character_count-<?php echo $scenario_id; ?>').html(newcount);

      if (currentLength < 5) {
        $('#submit').attr("disabled", true);
      } else if (currentLength > maxlength) {
        $('.character_count-<?php echo $scenario_id; ?>').addClass('warning');
        $('#submit-<?php echo $scenario_id; ?>').attr("disabled", true);
      } else {
        $('.character_count-<?php echo $scenario_id; ?>').removeClass('warning');
        $('#submit-<?php echo $scenario_id; ?>').attr("disabled", false);
      }

    });
  </script>
<?php } ?>





<?php

$html = ob_get_contents();
ob_end_clean();

$return_arr = array("response" => 1, "html" => $html, "comment_count" => $totalcomments);
echo json_encode($return_arr);


?>
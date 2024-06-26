<?php

//sleep(2);

$code_id = $typea;
$scenario_id = $typeb;

$totalcomments = 1;

ob_start();

//show children
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
if ($view_order == 0) {
  $orderby_sql = "last_update DESC, id ASC";
} else if ($view_order == 1) {
  $orderby_sql = "last_update ASC, id ASC";
} else if ($view_order == 2) {
  $orderby_sql = "rating DESC, id ASC";
} else {
  $orderby_sql = "last_update DESC, id ASC";
}

$mysqlquery_child_replies = "SELECT *, up_votes-down_votes as rating FROM thecode_examples WHERE code_id='$code_id' AND parent='$scenario_id' AND child='0' $sfw_sql $hide_shit_sql ORDER BY $orderby_sql";


?>
<div class="children-<?php echo $scenario_id; ?>" style="display:none;">
  <div class="children-container children-container-<?php echo $scenario_id; ?>">
    <?php
    $child_res = $dbconn->query($mysqlquery_child_replies);
    while ($child_row = $child_res->fetch_assoc()) {
      $child_scenario_id = $child_row['id'];
      $child_scenario_owner_id = $child_row['owner_id'];
      $child_scenario_post_time = $child_row['post_time'];
      $status = $child_row['status'];
      $rating = $child_row['rating'];
      $sfw = $child_row['sfw'];
      $content = $child_row['content'];
      $content = $content;
      $vdt = new DateTime("@$child_scenario_post_time");

      if ($rating > 0) {
        $rating = '+' . $rating;
      } else if ($rating == 0) {
        $rating = '-';
      }

      //get vote of logged in user
      if ($logged_in_id > 0) {
        $vote = 2;
        $mysqlquery2 = "SELECT * FROM thecode_example_ratings WHERE user_id='$logged_in_id' AND example_id='$child_scenario_id' ORDER BY id DESC";
        $res2 = $dbconn->query($mysqlquery2);
        while ($row2 = $res2->fetch_assoc()) {
          $vote = $row2['vote'];
        }
      }

      //get data of comment author
      $mysqlquery3 = "SELECT id, display_name, avatar_mini, avatar FROM users WHERE id='$child_scenario_owner_id' ORDER BY id DESC LIMIT 1";
      $res3 = $dbconn->query($mysqlquery3);
      while ($row3 = $res3->fetch_assoc()) {
        $child_scenario_owner_name = $row3['display_name'];
        $child_scenario_owner_avatar_mini = $row3['avatar_mini'];
        $child_scenario_owner_avatar = $row3['avatar'];
      }

      //get infants
      $mysqlquery_infant_replies = "SELECT *, up_votes-down_votes as rating FROM thecode_examples WHERE code_id='$code_id' AND child='$child_scenario_id' $sfw_sql $hide_shit_sql ORDER BY post_time ASC, id ASC";

      if ($logged_in_id == 1) {
        $total_infant_replies = 0;
        $mod_status = 1;
        $res3 = $dbconn->query($mysqlquery_infant_replies);
        while ($row3 = $res3->fetch_assoc()) {
          $this_mod_status = $row3['status'];
          if ($this_mod_status == 0) {
            $mod_status = 0;
          }
          $total_infant_replies = $total_infant_replies + 1;
        }
      } else {
        $total_infant_replies = $dbconn->query($mysqlquery_infant_replies);
        $total_infant_replies = $total_infant_replies->num_rows;
      }



    ?>

      <div class="comment comment-box-<?php echo $child_scenario_id; ?> child border-top">

        <span class="comment-header">
          <span class="author-name">
          <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $child_scenario_owner_name; ?>" /> 
                    <?php echo $child_scenario_owner_name; ?></span>
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
            <?php if ($logged_in_id > 0 && $total_infant_replies < 1) { ?>
              <span class="meta-link infant-reply-select infant-reply-select-<?php echo $scenario_id; ?> infant infant-button-<?php echo $child_scenario_id; ?> reply-select reply-select-<?php echo $child_scenario_id; ?>" data-id="<?php echo $child_scenario_id; ?>">
                <?php include($php_base_directory . '/styles/images/svgs/respond-icon.svg'); ?>
                REPLY
              </span>
            <?php } ?>
            <?php if ($total_infant_replies > 0) : ?>
              <span class="meta-link infant-reply-select infant-reply-select-<?php echo $scenario_id; ?> infant infant-button-<?php echo $child_scenario_id; ?> <?php if ($logged_in_id == 1) {
                                                                                                                                                                  if ($mod_status == 0 && $moderation == 1) {
                                                                                                                                                                    echo "warning";
                                                                                                                                                                  }
                                                                                                                                                                } ?>" data-id="<?php echo $child_scenario_id; ?>">
                <?php include($php_base_directory . '/styles/images/svgs/reply-icon.svg'); ?>
                <?php echo $total_infant_replies; ?> <?php if ($total_infant_replies == 1) {
                                                        echo "REPLY";
                                                      } else {
                                                        echo "REPLIES";
                                                      } ?>
              </span>
            <?php endif; ?>
          </span>

          <span class="meta-right meta-replies-right code-meta-rating-<?php echo $child_scenario_id; ?>">

            <?php if ($logged_in_id > 0 && $child_scenario_owner_id != $logged_in_id) { ?>
              <span class="meta-link downvote comment-down child-comment-down-<?php echo $scenario_id ?> comment-down-<?php echo $child_scenario_id; ?> <?php if ($vote == 0) {
                                                                                                                                                          echo 'on';
                                                                                                                                                        } ?>" data-id="<?php echo $child_scenario_id; ?>">
                <?php include($php_base_directory . '/styles/images/svgs/arrow.svg'); ?>
              </span>
            <?php } ?>

            <span class="meta-link-no-hover rating-<?php echo $child_scenario_id; ?>">
              <?php echo $rating; ?>
            </span>

            <?php if ($logged_in_id > 0 && $child_scenario_owner_id != $logged_in_id) { ?>
              <span class="meta-link upvote comment-up child-comment-up-<?php echo $scenario_id ?> comment-up-<?php echo $child_scenario_id; ?> <?php if ($vote == 1) {
                                                                                                                                                  echo 'on';
                                                                                                                                                } ?>" data-id="<?php echo $child_scenario_id; ?>">
                <?php include($php_base_directory . '/styles/images/svgs/arrow.svg'); ?>
              </span>
            <?php } ?>

            <?php if ($child_scenario_owner_id == $logged_in_id) { ?>
              <span class="meta-link delete-comment delete-comment-<?php echo $child_scenario_id; ?>" data-id="<?php echo $child_scenario_id; ?>">
                <?php include($php_base_directory . '/styles/images/svgs/delete-icon.svg'); ?>
              </span>
              <script>
                $('.delete-comment-<?php echo $child_scenario_id; ?>').click(function() {

                  var comment_id = $(this).attr("data-id");
                  delete_comment(comment_id);
                });
              </script>
            <?php } ?>

          </span>
        </span>

        <div class="loading invisible alt comment-loading-<?php echo $child_scenario_id; ?>">
          <?php include($php_base_directory . '/includes/loading-alt.php'); ?>
        </div>

        <?php if ($child_scenario_owner_id == $logged_in_id) { ?>
          <div class="are-you-sure are-you-sure-<?php echo $child_scenario_id; ?>">
            <?php
            $comment_to_delete_id = $child_scenario_id;
            include($php_base_directory . '/includes/delete-comment.php');
            $comment_to_delete_id = 0;
            ?>
          </div>
        <?php } ?>

      </div>


      <?php if ($logged_in_id == 1 && $moderation == 1) : ?>
        <span class="meta moderation-bar child moderation-bar-<?php echo $child_scenario_id; ?> border-top <?php if ($status == 0) {
                                                                                                              echo "warning";
                                                                                                            } ?>">
          <span class="meta-left">
            <span class="meta-link mod-link mod-link-<?php echo $scenario_id; ?> mod-link-sfw mod-link-sfw-<?php echo $child_scenario_id; ?> <?php if ($sfw == 0 && $status == 1) {
                                                                                                                                                echo "current";
                                                                                                                                              } ?>" data-id="<?php echo $child_scenario_id; ?>" data-rating="0">
              SFW
            </span>
            <span class="meta-link mod-link mod-link-<?php echo $scenario_id; ?> mod-link-nsfw mod-link-nsfw-<?php echo $child_scenario_id; ?> <?php if ($sfw == 1 && $status == 1) {
                                                                                                                                                  echo "current";
                                                                                                                                                } ?>" data-id="<?php echo $child_scenario_id; ?>" data-rating="1">
              NSFW
            </span>
            <span class="meta-link mod-link mod-link-<?php echo $scenario_id; ?> mod-link-monly mod-link-monly-<?php echo $child_scenario_id; ?> <?php if ($sfw == 2 && $status == 1) {
                                                                                                                                                    echo "current";
                                                                                                                                                  } ?>" data-id="<?php echo $child_scenario_id; ?>" data-rating="2">
              M.ONLY
            </span>
          </span>

          <span class="meta-right">
            <span class="meta-link mod-link-delete" data-id="<?php echo $child_scenario_id; ?>">
              DELETE
            </span>
            <span class="meta-link mod-link-warning" data-id="<?php echo $child_scenario_id; ?>">
              WARNING
            </span>
            <span class="meta-link mod-link-ban" data-id="<?php echo $child_scenario_id; ?>">
              BAN USER
            </span>
          </span>
        </span>
      <?php endif; ?>


      <div class="infant-hidden infant-<?php echo $child_scenario_id; ?>">
        <div class="infant-container infant-container-<?php echo $child_scenario_id; ?>">

          <div class="goto-anchor-<?php echo $child_scenario_id; ?>"></div>

        </div>
      </div>






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


    $('.child-comment-up-<?php echo $scenario_id ?>').click(function() {
      var comment_id = $(this).attr("data-id");
      vote_up(comment_id);
    });

    $('.child-comment-down-<?php echo $scenario_id ?>').click(function() {
      var comment_id = $(this).attr("data-id");
      vote_down(comment_id);
    });


    $('.infant-reply-select-<?php echo $scenario_id; ?>').click(function() {

      var infant_id = $(this).attr("data-id");
      var infant_to_trigger = ".infant-" + infant_id;
      var infant_button = ".infant-button-" + infant_id;
      var loading_id = ".comment-loading-" + infant_id;

      if ($(infant_button).hasClass("activated")) {
        if ($(infant_to_trigger).hasClass("closed")) {
          $(infant_to_trigger).slideDown('1000', "easeOutQuint", function() {});
          $(infant_to_trigger).removeClass("closed");
          $(infant_button).addClass("live");
        } else {
          $(infant_to_trigger).slideUp('1000', "easeOutQuint", function() {});
          $(infant_to_trigger).addClass("closed");
          $(infant_button).removeClass("live");
        }
      } else {

        if ($(infant_button).hasClass("activated")) {} else {
          fetch_infants(infant_id);
        }

      }

    });

    document.addEventListener('DOMContentLoaded', function() { 
      $('.infant-reply-select-<?php echo $scenario_id; ?>').each(function() {

        var infant_id = $(this).attr("data-id");
        var infant_to_trigger = ".infant-" + infant_id;
        var infant_button = ".infant-button-" + infant_id;
        var loading_id = ".comment-loading-" + infant_id;

        if ($(infant_button).hasClass("activated")) {
          if ($(infant_to_trigger).hasClass("closed")) {
            $(infant_to_trigger).slideDown('1000', "easeOutQuint", function() {});
            $(infant_to_trigger).removeClass("closed");
            $(infant_button).addClass("live");
          } else {
            $(infant_to_trigger).slideUp('1000', "easeOutQuint", function() {});
            $(infant_to_trigger).addClass("closed");
            $(infant_button).removeClass("live");
          }
        } else {

          if ($(infant_button).hasClass("activated")) {} else {
            fetch_infants(infant_id);
          }

        }

      });
    });
  </script>
</div>

<?php

$html = ob_get_contents();
ob_end_clean();

$return_arr = array("response" => 1, "html" => $html, "comment_count" => $totalcomments);
echo json_encode($return_arr);


?>
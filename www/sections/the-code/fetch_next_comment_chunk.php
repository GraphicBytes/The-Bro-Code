<?php
$code_id = $typea;
$chunk = $typeb;

$nomore = 0;
$response = 0;

$nextchunk = $chunk + 1;

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

$offset = $comment_limit * $chunk;

$mysqlquery = "SELECT *, up_votes-down_votes as rating FROM thecode_examples WHERE code_id='$code_id' AND parent='0' $sfw_sql $hide_shit_sql ORDER BY $orderby_sql LIMIT $comment_limit OFFSET $offset";

$mysqlquery_count = "SELECT *, up_votes-down_votes as rating FROM thecode_examples WHERE code_id='$code_id' AND parent='0' $sfw_sql $hide_shit_sql ORDER BY $orderby_sql";
$total_examples = $dbconn->query($mysqlquery_count);
$total_examples = $total_examples->num_rows;

if ($total_examples < ($offset + $comment_limit)) {
  $nomore = 1;
}

$html = null;
ob_start();


$variant_count = $chunk * $comment_limit;

$res = $dbconn->query($mysqlquery);
while ($row = $res->fetch_assoc()) {
  $scenario_id = $row['id'];
  $scenario_owner_id = $row['owner_id'];
  $scenario_post_time = $row['post_time'];
  $status = $row['status'];
  $rating = $row['rating'];
  $sfw = $row['sfw'];
  $content = $row['content'];
  $content = $content;
  $vdt = new DateTime("@$scenario_post_time");

  if ($rating > 0) {
    $rating = '+' . $rating;
  } else if ($rating == 0) {
    $rating = '-';
  }

  //get vote of logged in user
  if ($logged_in_id > 0) {
    $vote = 2;
    $mysqlquery2 = "SELECT * FROM thecode_example_ratings WHERE user_id='$logged_in_id' AND example_id='$scenario_id' ORDER BY id DESC";
    $res2 = $dbconn->query($mysqlquery2);
    while ($row2 = $res2->fetch_assoc()) {
      $vote = $row2['vote'];
    }
  }

  //get data of comment author
  $mysqlquery3 = "SELECT id, display_name FROM users WHERE id='$scenario_owner_id' ORDER BY id DESC LIMIT 1";
  $res3 = $dbconn->query($mysqlquery3);
  while ($row3 = $res3->fetch_assoc()) {
    $scenario_owner_name = $row3['display_name'];
  }

  //get children
  if ($tandc_seen < 2) {
    $mysqlquery_child_replies = "SELECT *, up_votes-down_votes as rating FROM thecode_examples WHERE code_id='$code_id' AND parent='$scenario_id' AND sfw < 2 ORDER BY post_time DESC, id ASC";
  } else {
    $mysqlquery_child_replies = "SELECT *, up_votes-down_votes as rating FROM thecode_examples WHERE code_id='$code_id' AND parent='$scenario_id' ORDER BY post_time DESC, id ASC";
  }

  if ($logged_in_id == 1) {
    $total_child_replies = 0;
    $mod_status = 1;
    $res3 = $dbconn->query($mysqlquery_child_replies);
    while ($row3 = $res3->fetch_assoc()) {
      $this_mod_status = $row3['status'];
      if ($this_mod_status == 0) {
        $mod_status = 0;
      }
      $total_child_replies = $total_child_replies + 1;
    }
  } else {
    $total_child_replies = $dbconn->query($mysqlquery_child_replies);
    $total_child_replies = $total_child_replies->num_rows;
  }


?>


  <div class="comment comment-box-<?php echo $scenario_id; ?> <?php if ($variant_count != 1) {
                                                                echo "border-top";
                                                              } ?>">

    <p><?php
        if ($tandc_seen < 2) {
          echo $profanity->filter_string($content);
        } else {
          echo $content;
        } ?></p>

    <span class="meta border-top">
      <span class="meta-left">

        <span data="<?php echo $base_url; ?>/profile/<?php echo $scenario_owner_id; ?>/" class="meta-link <?php if ($scenario_owner_id == $logged_in_id) {
                                                                                                            echo "self";
                                                                                                          } ?>" rel="nofollow">

          <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $scenario_owner_name; ?>" /> 
          <?php echo $scenario_owner_name; ?>
        </span>
        <span data="<?php echo $base_url; ?>/profile/<?php echo $scenario_owner_id; ?>/" class="meta-link" rel="nofollow">
          <?php include($php_base_directory . '/styles/images/svgs/clock-icon.svg'); ?>
          <?php echo $vdt->format("dS M Y"); ?>
        </span>
      </span>

      <span class="meta-right code-meta-rating-<?php echo $scenario_id; ?>">

        <?php if ($logged_in_id > 0 && $scenario_owner_id != $logged_in_id) { ?>
          <span class="meta-link downvote comment-down comment-down-chunk-<?php echo $chunk; ?> comment-down-<?php echo $scenario_id; ?> <?php if ($vote == 0) {
                                                                                                                                            echo 'on';
                                                                                                                                          } ?>" data-id="<?php echo $scenario_id; ?>">
            <?php include($php_base_directory . '/styles/images/svgs/arrow.svg'); ?>
          </span>
        <?php } ?>

        <span class="meta-link-no-hover rating-<?php echo $scenario_id; ?>">
          <?php echo $rating; ?>
        </span>

        <?php if ($logged_in_id > 0 && $scenario_owner_id != $logged_in_id) { ?>
          <span class="meta-link upvote comment-up comment-up-chunk-<?php echo $chunk; ?> comment-up-<?php echo $scenario_id; ?> <?php if ($vote == 1) {
                                                                                                                                    echo 'on';
                                                                                                                                  } ?>" data-id="<?php echo $scenario_id; ?>">
            <?php include($php_base_directory . '/styles/images/svgs/arrow.svg'); ?>
          </span>
        <?php } ?>

        <?php if ($scenario_owner_id == $logged_in_id) { ?>
          <span class="meta-link delete-comment delete-comment-chunk-<?php echo $chunk; ?> delete-comment-<?php echo $scenario_id; ?>" data-id="<?php echo $scenario_id; ?>">
            <?php include($php_base_directory . '/styles/images/svgs/delete-icon.svg'); ?>
          </span>
        <?php } ?>

      </span>
      <span class="meta-member-tools">

        <?php if ($logged_in_id > 0) { ?>
          <span class="meta-link reply-select reply-select-chunk-<?php echo $chunk; ?> reply-select-<?php echo $scenario_id; ?>" data-id="<?php echo $scenario_id; ?>">
            <?php include($php_base_directory . '/styles/images/svgs/respond-icon.svg'); ?>
            REPLY
          </span>
        <?php } ?>

        <?php if ($total_child_replies > 0) : ?>
          <span class="meta-link children children-chunk-<?php echo $chunk; ?> children-button-<?php echo $scenario_id; ?> <?php if ($logged_in_id == 1) {
                                                                                                                              if ($mod_status == 0 && $moderation == 1) {
                                                                                                                                echo "warning";
                                                                                                                              }
                                                                                                                            } ?>" data-id="<?php echo $scenario_id; ?>">
            <?php include($php_base_directory . '/styles/images/svgs/reply-icon.svg'); ?>
            <?php echo $total_child_replies; ?> <?php if ($total_child_replies == 1) {
                                                  echo "REPLY";
                                                } else {
                                                  echo "REPLIES";
                                                } ?>
          </span>
        <?php endif; ?>

      </span>
    </span>

    <div class="loading invisible alt comment-loading-<?php echo $scenario_id; ?>">
      <?php include($php_base_directory . '/includes/loading-alt.php'); ?>
    </div>

    <?php if ($scenario_owner_id == $logged_in_id) { ?>
      <div class="are-you-sure are-you-sure-<?php echo $scenario_id; ?>">
        <?php
        $comment_to_delete_id = $scenario_id;
        include($php_base_directory . '/includes/delete-comment.php');
        $comment_to_delete_id = 0;
        ?>
      </div>
    <?php } ?>

  </div>


  <?php if ($logged_in_id == 1 && $moderation == 1) : ?>
    <span class="meta moderation-bar moderation-bar-<?php echo $scenario_id; ?> border-top <?php if ($status == 0) {
                                                                                              echo "warning";
                                                                                            } ?>">
      <span class="meta-left">
        <span class="meta-link mod-link mod-link-chunk-<?php echo $chunk; ?> mod-link-sfw mod-link-sfw-<?php echo $scenario_id; ?> <?php if ($sfw == 0 && $status == 1) {
                                                                                                                                      echo "current";
                                                                                                                                    } ?>" data-id="<?php echo $scenario_id; ?>" data-rating="0">
          SFW
        </span>
        <span class="meta-link mod-link mod-link-chunk-<?php echo $chunk; ?> mod-link-nsfw mod-link-nsfw-<?php echo $scenario_id; ?> <?php if ($sfw == 1 && $status == 1) {
                                                                                                                                        echo "current";
                                                                                                                                      } ?>" data-id="<?php echo $scenario_id; ?>" data-rating="1">
          NSFW
        </span>
        <span class="meta-link mod-link mod-link-chunk-<?php echo $chunk; ?> mod-link-monly mod-link-monly-<?php echo $scenario_id; ?> <?php if ($sfw == 2 && $status == 1) {
                                                                                                                                          echo "current";
                                                                                                                                        } ?>" data-id="<?php echo $scenario_id; ?>" data-rating="2">
          M.ONLY
        </span>
      </span>

      <span class="meta-right">
        <span class="meta-link mod-link-delete-chunk-<?php echo $chunk; ?> mod-link-delete mod-link-delete-<?php echo $scenario_id; ?>" data-level="1" owner-id="<?php echo $scenario_owner_id; ?>" data-id="<?php echo $scenario_id; ?>">
          DELETE
        </span>
        <span class="meta-link mod-link-warning mod-link-warning-<?php echo $scenario_id; ?> mod-link-warning-chunk-<?php echo $chunk; ?>" data-level="1" owner-id="<?php echo $scenario_owner_id; ?>" data-id="<?php echo $scenario_id; ?>">
          WARNING
        </span>
        <span class="meta-link mod-link-ban mod-link-ban-<?php echo $scenario_id; ?> mod-link-ban-chunk-<?php echo $chunk; ?>" data-level="1" owner-id="<?php echo $scenario_owner_id; ?>" data-id="<?php echo $scenario_id; ?>">
          BAN USER
        </span>
      </span>
    </span>
  <?php endif; ?>

  <div class="ghost-<?php echo $scenario_id; ?>"></div>

  <div class="reply-anchor reply-anchor-<?php echo $scenario_id; ?>"></div>

  <div class="child-hidden children-<?php echo $scenario_id; ?>">
    <div class="children-container children-container-<?php echo $scenario_id; ?>">

      <div class="goto-anchor-<?php echo $scenario_id; ?>"></div>

    </div>
  </div>

<?php $variant_count = $variant_count + 1;
} ?>

<?php if ($logged_in_id == 1) : ?>
  <script>
    $('.mod-link-delete-chunk-<?php echo $chunk; ?>').click(function() {
      var stage = $(this).attr('data-level');
      var comment_id = $(this).attr('data-id');
      var owner = $(this).attr('owner-id');
      mod_delete(stage, comment_id, owner)
    });

    $('.mod-link-warning-chunk-<?php echo $chunk; ?>').click(function() {
      var stage = $(this).attr('data-level');
      var comment_id = $(this).attr('data-id');
      var owner = $(this).attr('owner-id');
      mod_warn(stage, comment_id, owner)
    });

    $('.mod-link-ban-chunk-<?php echo $chunk; ?>').click(function() {
      var stage = $(this).attr('data-level');
      var comment_id = $(this).attr('data-id');
      var owner = $(this).attr('owner-id');
      mod_ban(stage, comment_id, owner)
    });
  </script>
<?php endif; ?>



<script>
  <?php if ($logged_in_id > 0) : ?>

    <?php if ($logged_in_id == 1) { ?>
      $('.mod-link-chunk-<?php echo $chunk; ?>').click(function() {
        var comment_id = $(this).attr('data-id');
        var comment_rating = $(this).attr('data-rating');
        moderate_comment(comment_id, comment_rating);
      });
    <?php } ?>




    $('.delete-comment-chunk-<?php echo $chunk; ?>').click(function() {
      var comment_id = $(this).attr("data-id");
      delete_comment(comment_id);
    });


    $('.reply-select-chunk-<?php echo $chunk; ?>').click(function() {

      var sceneario_id = $(this).attr("data-id");
      var ghost_id = ".ghost-" + sceneario_id;
      var select = ".reply-select-" + sceneario_id;
      var loading_id = ".comment-loading-" + sceneario_id;
      var replybox_id = ".reply-form-container-" + sceneario_id;

      if ($(select).hasClass("reply-box-loaded")) {

        if ($(replybox_id).hasClass("opened")) {
          $(replybox_id).slideUp('1000', "easeOutQuint", function() {});
          $(replybox_id).removeClass('opened');
          $(select).removeClass('live');
        } else {
          $(replybox_id).slideDown('1000', "easeOutQuint", function() {});
          $(replybox_id).addClass('opened');
          $(select).addClass('live');
        }

      } else {

        if ($(select).hasClass("disabled")) {

        } else {

          fetchreplyform(sceneario_id);
          fetch_children(sceneario_id);
        }
      }
    });


    $('.comment-up-chunk-<?php echo $chunk; ?>').click(function() {
      var comment_id = $(this).attr("data-id");
      vote_up(comment_id);
    });

    $('.comment-down-chunk-<?php echo $chunk; ?>').click(function() {
      var comment_id = $(this).attr("data-id");
      vote_down(comment_id);
    });


  <?php endif; ?>




  $('.children-chunk-<?php echo $chunk; ?>').click(function() {

    var children_id = $(this).attr("data-id");
    var children_to_trigger = ".children-" + children_id;
    var children_button = ".children-button-" + children_id;
    var loading_id = ".comment-loading-" + children_id;

    if ($(children_button).hasClass("activated")) {
      if ($(children_to_trigger).hasClass("closed")) {
        $(children_to_trigger).slideDown('1000', "easeOutQuint", function() {});
        $(children_to_trigger).removeClass("closed");
        $(children_button).addClass("live");
      } else {
        $(children_to_trigger).slideUp('1000', "easeOutQuint", function() {});
        $(children_to_trigger).addClass("closed");
        $(children_button).removeClass("live");
      }
    } else {
      if ($(children_button).hasClass("activated")) {} else {
        fetch_children(children_id);
      }
    }
  });
</script>



<?php if ($nomore == 0) { ?>
  <div class="extra-comments extra-comments-<?php echo $nextchunk; ?>"></div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $(window).scroll(function() {
        if ($('.extra-comments-<?php echo $nextchunk; ?>').visible()) {

          if (!$('.extra-comments-<?php echo $nextchunk; ?>').hasClass('triggered')) {
            $('.loading-extra-comments').addClass('active');
            fetch_next_comments(<?php echo $code_id; ?>, <?php echo $nextchunk; ?>, <?php echo $nextchunk; ?>);
            $('.extra-comments-<?php echo $nextchunk; ?>').addClass('triggered');
          }

        }
      });
    });
  </script>
<?php } ?>



<?php
$html = ob_get_contents();
ob_end_clean();

$response = 1;

$return_arr = array("response" => $response, "nomore" => $nomore, "html" => $html);
echo json_encode($return_arr);

?>
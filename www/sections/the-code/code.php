<?php

$result_found = 0;

$res = $db->sql("SELECT * FROM thecode WHERE slug=? ORDER BY id ASC LIMIT 1", "s", $typea);
while ($row = $res->fetch_assoc()) {
  $result_found = 1;

  $code_id = $row['id'];
  $owner_id = $row['owner_id'];
  $variant_owner_id = $row['variant_owner_id'];
  $content = $row['content'];
  $content = $content;
  $slug = $row['slug'];
  $postid = $row['id'];
  $suggestion_id = $row['suggestion_id'];
  $struck_off = $row['struck_off'];

  $votes_up = $row['votes_up'];
  $votes_down = $row['votes_down'];
  $rating = $votes_up - $votes_down;
  if ($rating > 0) {
    $rating = '+' . $rating;
  } else if ($rating == 0) {
    $rating = '-';
  }
}

//check for old slugs
if ($result_found == 0) {

  $oldSlugFound = 0;
  $res = $db->sql("SELECT * FROM old_slugs WHERE slug=? ORDER BY id ASC LIMIT 1", "s", $typea);
  while ($row = $res->fetch_assoc()) {

    $oldSlugFound = 1;
    $slugGoto = $row['redirect'];
    $bounce_out_header = "location: " . $base_url . "/code/" . $slugGoto . "/";
    header($bounce_out_header);
    die();
  }
}








//fucked up slug, bounce out.
if ($result_found == 0) {
  $bounce_out_header = "location: " . $base_url;
  header($bounce_out_header);
  die();
}

//get user details
$display_name = "";
$mysqlquery2 = "SELECT * FROM users WHERE id='$owner_id' ORDER BY id DESC LIMIT 1";
$res2 = $dbconn->query($mysqlquery2);
while ($row2 = $res2->fetch_assoc()) {
  $display_name = $row2['display_name'];
}

if ($owner_id == $variant_owner_id) {
} else {
  //get variant details
  $variant_display_name = "";
  $mysqlquery2 = "SELECT * FROM users WHERE id='$variant_owner_id' ORDER BY id DESC LIMIT 1";
  $res2 = $dbconn->query($mysqlquery2);
  while ($row2 = $res2->fetch_assoc()) {
    $variant_display_name = $row2['display_name'];
  }
}

$previous_code_available = 0;
if ($code_id != 1) {
  $previous_code_available = 1;
  $previous_id = $code_id - 1;
  $mysqlquery_prev = "SELECT id, slug FROM thecode WHERE id='$previous_id' ORDER BY id DESC LIMIT 1";
  $res_prev = $dbconn->query($mysqlquery_prev);
  while ($rows_prev = $res_prev->fetch_assoc()) {
    $previous_slug = $rows_prev['slug'];
  }
}

$next_code_available = 0;
if ($code_id != $system_data['codes_launched']) {
  $next_code_available = 1;
  $next_id = $code_id + 1;
  $mysqlquery_prev = "SELECT id, slug FROM thecode WHERE id='$next_id' ORDER BY id DESC LIMIT 1";
  $res_prev = $dbconn->query($mysqlquery_prev);
  while ($rows_prev = $res_prev->fetch_assoc()) {
    $next_slug = $rows_prev['slug'];
  }
}



//get vote of logged in user
if ($logged_in_id > 0) {
  $vote = 2;
  $mysqlquery3 = "SELECT * FROM thecode_ratings WHERE user_id='$logged_in_id' AND code_id='$code_id' ORDER BY id DESC";
  $res3 = $dbconn->query($mysqlquery3);
  while ($row3 = $res3->fetch_assoc()) {
    $vote = $row3['vote'];
  }
}


$pagetitle = $content;
$pagedescription = $content;
$canonical = $base_url . "/code/" . $typea . "/";

$sfw = 2;
include($php_base_directory . '/header.php');
?>


<div id="container" class="container">
  <main class="content">

    <div class="content-block bottom-padding">
      <h1 class="page-header hero">
        BRO CODE #<?php echo $postid; ?>
        <span class="hero-link-bg-image" style="background-image:url('<?php echo $static_url; ?>/images/tiles/fist-bump-large.jpg');"></span>
      </h1>
    </div>

    <div class="content-block bg bottom-padding">
      <div class="code-container">

        <div class="number <?php if ($struck_off == 1) {
                              echo "red";
                            } ?>">
          <?php echo $postid; ?>
        </div>
        <div class="code-content">

          <h1 class="the-code">
            <?php echo $content; ?>
          </h1>

          <span class="meta no-bg border-top-desktop">
            <span class="meta-left code-meta-rating-left">

              <?php if ($owner_id == 1) : ?>
                <span class="meta-link-no-hover author <?php if ($owner_id == $logged_in_id) {
                                                          echo "self";
                                                        } ?>" rel="nofollow">
                  <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - ORIGIN UNKNOWN" />
                  ORIGIN UNKNOWN
                </span>
              <?php elseif ($owner_id == 2) : ?>
                <span class="meta-link-no-hover author <?php if ($owner_id == $logged_in_id) {
                                                          echo "self";
                                                        } ?>" rel="nofollow">
                  <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $display_name; ?>" />
                  <span class="mobile-hide">&nbsp;</span><?php echo $display_name; ?>
                </span>
              <?php else : ?>
                <span data="<?php echo $base_url; ?>/profile/<?php echo $owner_id; ?>/" class="meta-link author <?php if ($owner_id == $logged_in_id) {
                                                                                                                  echo "self";
                                                                                                                } ?>" rel="nofollow">
                  <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $display_name; ?>" />
                  <span class="mobile-hide">&nbsp;</span><?php echo $display_name; ?>
                </span>
              <?php endif; ?>

              <?php if ($owner_id != $variant_owner_id) { ?>
                <span data="<?php echo $base_url; ?>/profile/<?php echo $variant_owner_id; ?>/" class="meta-link author <?php if ($variant_owner_id == $logged_in_id) {
                                                                                                                          echo "self";
                                                                                                                        } ?>" rel="nofollow">
                  <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $variant_display_name; ?>" />
                  <span class="mobile-hide">&nbsp;</span><?php echo $variant_display_name; ?>
                </span>
              <?php } ?>

            </span>

            <span class="meta-right code-meta-rating">

              <a href="<?php echo $base_url; ?>/amend-code/<?php echo $suggestion_id; ?>/" class="meta-link history <?php if ($variant_owner_id == $logged_in_id) {
                                                                                                                      echo "self";
                                                                                                                    } ?>" rel="nofollow">
                <?php include($php_base_directory . '/styles/images/svgs/code-icon.svg'); ?>
                Amend
              </a>
              <span class="desktop-hide meta-filler-block"></span>

              <?php if ($logged_in_id > 0) { ?>
                <span class="meta-link downvote code-down <?php if ($vote == 0) {
                                                            echo 'on';
                                                          } ?>">
                  <?php include($php_base_directory . '/styles/images/svgs/arrow.svg'); ?>
                </span>
              <?php } else { ?>
                <span class="meta-link downvote login-prompt">
                  <?php include($php_base_directory . '/styles/images/svgs/arrow.svg'); ?>
                </span>
              <?php } ?>

              <span class="meta-link-no-hover code-rating">
                <?php echo $rating; ?>
              </span>

              <?php if ($logged_in_id > 0) { ?>
                <span class="meta-link upvote code-up <?php if ($vote == 1) {
                                                        echo 'on';
                                                      } ?>">
                  <?php include($php_base_directory . '/styles/images/svgs/arrow.svg'); ?>
                </span>
              <?php } else { ?>
                <span class="meta-link upvote login-prompt">
                  <?php include($php_base_directory . '/styles/images/svgs/arrow.svg'); ?>
                </span>
              <?php } ?>

            </span>
          </span>

        </div>

      </div>
    </div>


    <?php if ($logged_in_id > 0) : ?>

      <script>
        document.addEventListener("DOMContentLoaded", function() {
          $('.code-down').click(function() {

            if ($(".code-down").hasClass("on")) {
              var theurl = "<?php echo $base_url ?>/rate-code/<?php echo $code_id; ?>/2/";
            } else {
              var theurl = "<?php echo $base_url ?>/rate-code/<?php echo $code_id; ?>/0/";
            }

            $('.code-meta-rating').addClass("blocked");
            $.ajax({
              url: theurl,
              type: 'get',
              contentType: false,
              processData: false,
              dataType: 'json',
              success: function(response) {
                var new_rating = response.rating;
                $('.code-rating').html(new_rating);

                if ($(".code-down").hasClass("on")) {
                  $('.code-down').removeClass("on");
                  $('.code-meta-rating').removeClass("blocked");
                } else {
                  $('.code-down').addClass("on");
                  $('.code-up').removeClass("on");
                  $('.code-meta-rating').removeClass("blocked");
                }

              }
            });

          });

          $('.code-up').click(function() {

            if ($(".code-up").hasClass("on")) {
              var theurl = "<?php echo $base_url ?>/rate-code/<?php echo $code_id; ?>/2/";
            } else {
              var theurl = "<?php echo $base_url ?>/rate-code/<?php echo $code_id; ?>/1/";
            }

            $('.code-meta-rating').addClass("blocked");
            $.ajax({
              url: theurl,
              type: 'get',
              contentType: false,
              processData: false,
              dataType: 'json',
              success: function(response) {
                var new_rating = response.rating;
                $('.code-rating').html(new_rating);

                if ($(".code-up").hasClass("on")) {
                  $('.code-up').removeClass("on");
                  $('.code-meta-rating').removeClass("blocked");
                } else {
                  $('.code-down').removeClass("on");
                  $('.code-up').addClass("on");
                  $('.code-meta-rating').removeClass("blocked");
                }
              }
            });

          });

        });
      </script>

    <?php endif; ?>


    <?php if ($struck_off == 1) : ?>
      <div class="content-block">
        <h3 class="page-header warning-header">THIS CODE HAS BEEN STRUCK OFF</h3>
      </div>
    <?php endif; ?>


    <div class="meta-nav">
      <nav class="meta-solo">
        <div class="meta-left flick-nav left">
          <?php if ($previous_code_available == 1) : ?>
            <a class="meta-link no-border mobile-full" href="<?php echo $base_url ?>/code/<?php echo $previous_slug; ?>/">
              <?php include($php_base_directory . '/styles/images/svgs/previous.svg'); ?>
              Previous Bro Code
            </a>
          <?php endif; ?>
        </div>
        <div class="meta-right flick-nav flick-nav-right right">
          <?php if ($next_code_available == 1 && isset($next_slug) && $next_slug != "" && $next_slug != null) : ?>
            <a class="meta-link no-border mobile-full" href="<?php echo $base_url ?>/code/<?php echo $next_slug; ?>/">
              Next Bro Code
              <?php include($php_base_directory . '/styles/images/svgs/previous.svg'); ?>
            </a>
          <?php endif; ?>
        </div>
      </nav>
    </div>



    <?php if ($previous_code_available == 1 or $next_code_available == 1) : ?>
      <script>
        document.addEventListener("DOMContentLoaded", function() {
          let touchstartX = 0;
          let touchendX = 0;
          const flickgestureZone = document.getElementById('container');

          flickgestureZone.addEventListener('touchstart', function(event) {
            touchstartX = event.changedTouches[0].screenX;
          }, false);

          flickgestureZone.addEventListener('touchend', function(event) {
            touchendX = event.changedTouches[0].screenX;
            handleFlickNavGesture();
          }, false);

          function handleFlickNavGesture() {
            const thebody = document.querySelector('.body');

            if (!thebody.classList.contains('mobile-menu-open')) {

              <?php if ($next_code_available == 1) : ?>
                if ((touchendX - 75) >= touchstartX) {
                  window.location.href = '<?php echo $base_url ?>/code/<?php echo $next_slug; ?>/';
                }
              <?php endif; ?>
              <?php if ($previous_code_available == 1) : ?>
                if ((touchendX + 75) <= touchstartX) {
                  window.location.href = '<?php echo $base_url ?>/code/<?php echo $previous_slug; ?>/';
                }
              <?php endif; ?>

            }

          }

        });
      </script>
    <?php endif; ?>

    <div class="content-block bg special">

      <?php if ($logged_in_id > 0) : ?>
        <div class="loading alt comment-loading">
          <?php include($php_base_directory . '/includes/loading-alt.php'); ?>
        </div>
        <form method="post" class="comment-form" action="<?php echo $base_url; ?>/submit-code-comment/<?php echo $code_id; ?>/" enctype="multipart/form-data">
        <?php endif; ?>

        <textarea maxlength='1500' class="main-comment-box <?php if ($logged_in_id < 1) {
                                                              echo "login-prompt no-click";
                                                            } ?>" id="comment" name="comment" placeholder="Have something to say about this Bro Code?"></textarea>

        <?php if ($logged_in_id < 1) : ?>
          <div class="login-prompt promt-overlay"></div>
        <?php endif; ?>

        <span class="meta comment-meta <?php if ($logged_in_id < 1) {
                                          echo "login-prompt";
                                        } ?>">
          <span class="meta-left">
            <span class="meta-link-no-hover character_count">
              0/1000
            </span>
          </span>

          <span class="meta-right meta-submit-contaner">
            <input class="comment-submit" id="submit" type="submit" value="POST" disabled />
          </span>
        </span>

        <?php if ($logged_in_id > 0) : ?>
        </form>
      <?php endif; ?>


      <?php if ($logged_in_id > 0) : ?>
        <script>
          document.addEventListener("DOMContentLoaded", function() {
            $('.comment-submit').click(function() {
              event.preventDefault();
              $(".comment-loading").addClass("active");

              $.ajax({
                url: $('.comment-form').attr('action'),
                type: 'POST',
                data: $('.comment-form').serialize(),
                success: function(data) {

                  var obj = JSON.parse(data);
                  var response_code = obj['response'];
                  var newhtml = obj['html'];

                  if (response_code == 0) {

                    $(".comment-loading").removeClass("active");
                  }
                  if (response_code == 1) {
                    $(".main-comment-box").val("");
                    $(".ghost").replaceWith(newhtml);
                    $('html, body').animate({
                      scrollTop: $(".number").offset().top
                    }, {
                      duration: 1000,
                      easing: "easeOutQuint"
                    });
                    $(".comment-loading").removeClass("active");
                  }

                }
              });
              return false;
            });

            $('#comment').on('input', function() {
              var scroll_height = $('#comment').get(0).scrollHeight;
              scroll_height = +scroll_height + +1;
              $('#comment').css('height', scroll_height + 'px');

              minlength = 5;
              var maxlength = 1000;
              var currentLength = $('#comment').val().length;
              var newcount = currentLength + "/" + maxlength;
              $('.character_count').html(newcount);

              if (currentLength < 5) {
                $('#submit').attr("disabled", true);
              } else if (currentLength > maxlength) {
                $('.character_count').addClass('warning');
                $('#submit').attr("disabled", true);
              } else {
                $('.character_count').removeClass('warning');
                $('#submit').attr("disabled", false);
              }

            });

          });
        </script>
      <?php endif; ?>

    </div>

    <div class="content-block bg">

      <?php
      if ($tandc_seen < 2) {
        $sfw_sql = " AND sfw < 2 ";
      } else {
        $sfw_sql = null;
      }
      if ($hide_shit == 1) {
        $hide_shit_sql = " AND (up_votes-down_votes) > -10 ";
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

      $mysqlquery = "SELECT *, up_votes-down_votes as rating FROM thecode_examples WHERE code_id='$code_id' AND parent='0' $sfw_sql $hide_shit_sql ORDER BY $orderby_sql LIMIT $comment_limit";

      $mysqlquery_count = "SELECT *, up_votes-down_votes as rating FROM thecode_examples WHERE code_id='$code_id' AND parent='0' $sfw_sql $hide_shit_sql ORDER BY $orderby_sql";
      $total_examples = $dbconn->query($mysqlquery_count);
      $total_examples = $total_examples->num_rows;
      ?>
      <h3 class="page-header <?php if ($struck_off == 1) {
                                echo "warning-sub-header";
                              } else {
                                echo "sub-header";
                              } ?>">COMMENTS &amp; REPLIES</h3>
      <div class="ghost">
        <?php if ($total_examples == 0) : ?>
          <div class="comment comment-box-25 ">
            <p>No replies yet...</p>
          </div>
        <?php endif; ?>
      </div>

      <?php
      $variant_count = 1;
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
        $mysqlquery_child_replies = "SELECT id, parent, up_votes, down_votes, status, sfw FROM thecode_examples WHERE code_id='$code_id' AND parent='$scenario_id' $sfw_sql $hide_shit_sql ORDER BY post_time DESC, id ASC";

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

          <span class="comment-header">
            <span class="author-name">
              <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $scenario_owner_name; ?>" />
              <?php echo $scenario_owner_name; ?></span>
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

              <?php if ($logged_in_id > 0) { ?>
                <span class="meta-link reply-select reply-select-<?php echo $scenario_id; ?>" data-id="<?php echo $scenario_id; ?>">
                  <?php include($php_base_directory . '/styles/images/svgs/respond-icon.svg'); ?>
                  REPLY
                </span>
              <?php } ?>

              <?php if ($total_child_replies > 0) : ?>
                <span class="meta-link children children-button-<?php echo $scenario_id; ?> <?php if ($logged_in_id == 1) {
                                                                                              if ($mod_status == 0 && $moderation == 1) {
                                                                                                echo "warning";
                                                                                              }
                                                                                            } ?>" data-id="<?php echo $scenario_id; ?>">
                  <?php include($php_base_directory . '/styles/images/svgs/reply-icon.svg'); ?>
                  <?php echo $total_child_replies; ?> <span class="mobile-hide"><?php if ($total_child_replies == 1) {
                                                                                  echo "&nbsp;REPLY";
                                                                                } else {
                                                                                  echo "&nbsp;REPLIES";
                                                                                } ?></span>
                </span>
              <?php endif; ?>
            </span>


            <span class="meta-right meta-replies-right code-meta-rating-<?php echo $scenario_id; ?>">

              <?php if ($logged_in_id > 0 && $scenario_owner_id != $logged_in_id) { ?>
                <span class="meta-link downvote comment-down comment-down-<?php echo $scenario_id; ?> <?php if ($vote == 0) {
                                                                                                        echo 'on';
                                                                                                      } ?>" data-id="<?php echo $scenario_id; ?>">
                  <?php include($php_base_directory . '/styles/images/svgs/arrow.svg'); ?>
                </span>
              <?php } ?>


              <span class="meta-link-no-hover rating-<?php echo $scenario_id; ?>">
                <?php echo $rating; ?>
              </span>

              <?php if ($logged_in_id > 0 && $scenario_owner_id != $logged_in_id) { ?>
                <span class="meta-link upvote comment-up comment-up-<?php echo $scenario_id; ?> <?php if ($vote == 1) {
                                                                                                  echo 'on';
                                                                                                } ?>" data-id="<?php echo $scenario_id; ?>">
                  <?php include($php_base_directory . '/styles/images/svgs/arrow.svg'); ?>
                </span>
              <?php } ?>

              <?php if ($scenario_owner_id == $logged_in_id) { ?>
                <span class="meta-link delete-comment delete-comment-<?php echo $scenario_id; ?>" data-id="<?php echo $scenario_id; ?>">
                  <?php include($php_base_directory . '/styles/images/svgs/delete-icon.svg'); ?>
                </span>
              <?php } ?>

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
              <span class="meta-link mod-link mod-link-sfw mod-link-sfw-<?php echo $scenario_id; ?> <?php if ($sfw == 0 && $status == 1) {
                                                                                                      echo "current";
                                                                                                    } ?>" data-id="<?php echo $scenario_id; ?>" data-rating="0">
                SFW
              </span>
              <span class="meta-link mod-link mod-link-nsfw mod-link-nsfw-<?php echo $scenario_id; ?> <?php if ($sfw == 1 && $status == 1) {
                                                                                                        echo "current";
                                                                                                      } ?>" data-id="<?php echo $scenario_id; ?>" data-rating="1">
                NSFW
              </span>
              <span class="meta-link mod-link mod-link-monly mod-link-monly-<?php echo $scenario_id; ?> <?php if ($sfw == 2 && $status == 1) {
                                                                                                          echo "current";
                                                                                                        } ?>" data-id="<?php echo $scenario_id; ?>" data-rating="2">
                M.ONLY
              </span>
            </span>

            <span class="meta-right">
              <span class="meta-link mod-link-delete mod-link-delete-<?php echo $scenario_id; ?>" data-level="1" owner-id="<?php echo $scenario_owner_id; ?>" data-id="<?php echo $scenario_id; ?>">
                DELETE
              </span>
              <span class="meta-link mod-link-warning mod-link-warning-<?php echo $scenario_id; ?>" data-level="1" owner-id="<?php echo $scenario_owner_id; ?>" data-id="<?php echo $scenario_id; ?>">
                WARNING
              </span>
              <span class="meta-link mod-link-ban mod-link-ban-<?php echo $scenario_id; ?>" data-level="1" owner-id="<?php echo $scenario_owner_id; ?>" data-id="<?php echo $scenario_id; ?>">
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
          document.addEventListener('DOMContentLoaded', function() {
            $('.mod-link-delete').click(function() {
              var stage = $(this).attr('data-level');
              var comment_id = $(this).attr('data-id');
              var owner = $(this).attr('owner-id');
              mod_delete(stage, comment_id, owner)
            });
          });

          function mod_delete(val, val2, val3) {
            var remove_box = ".comment-box-" + val2;
            var button_id = ".mod-link-delete-" + val2;

            var stage = val;
            var comment_id = val2;
            var owner = val3;

            theurl = "<?php echo $base_url; ?>/moderate-code-comment-delete/" + comment_id + "/" + owner + "/";

            if (stage == 3) {
              $.ajax({
                url: theurl,
                type: 'get',
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                  var status = response.status;
                  if (status == 1) {
                    var ids = response.ids;

                    $.each(ids, function(index, value) {

                      var remove_mod_bar = ".moderation-bar-" + value;
                      $(remove_mod_bar).remove();
                      remove_comment(value);
                    });

                  }
                }
              });

            }
            if (stage == 2) {
              $(button_id).removeClass('level-2');
              $(button_id).addClass('level-3');
              $(button_id).attr('data-level', '3');
            }
            if (stage == 1) {
              $(button_id).addClass('level-2');
              $(button_id).attr('data-level', '2');
            }
          }

          document.addEventListener('DOMContentLoaded', function() {
            $('.mod-link-warning').click(function() {
              var stage = $(this).attr('data-level');
              var owner = $(this).attr('owner-id');
              var id = $(this).attr('data-id');
              mod_warn(stage, id, owner)
            });
          });

          function mod_warn(val, val2, val3) {
            var remove_box = ".comment-box-" + val2;
            var button_id = ".mod-link-warning-" + val2;

            var stage = val;
            var comment_id = val2;
            var owner = val3;

            theurl = "<?php echo $base_url; ?>/moderate-code-comment-warn/" + comment_id + "/" + owner + "/";

            if (stage == 3) {
              $.ajax({
                url: theurl,
                type: 'get',
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                  var status = response.status;
                  if (status == 1) {
                    var ids = response.ids;

                    $.each(ids, function(index, value) {

                      var remove_mod_bar = ".moderation-bar-" + value;
                      $(remove_mod_bar).remove();
                      remove_comment(value);
                    });

                  }
                }
              });

            }
            if (stage == 2) {
              $(button_id).removeClass('level-2');
              $(button_id).addClass('level-3');
              $(button_id).attr('data-level', '3');
            }
            if (stage == 1) {
              $(button_id).addClass('level-2');
              $(button_id).attr('data-level', '2');
            }
          }

          document.addEventListener('DOMContentLoaded', function() {
            $('.mod-link-ban').click(function() {
              var stage = $(this).attr('data-level');
              var comment_id = $(this).attr('data-id');
              var owner = $(this).attr('owner-id');
              mod_ban(stage, comment_id, owner)
            });
          });

          function mod_ban(val, val2, val3) {
            var button_id = ".mod-link-ban-" + val2;

            var stage = val;
            var comment_id = val2;
            var owner = val3;

            theurl = "<?php echo $base_url; ?>/ban-user/" + owner + "/";

            if (stage == 3) {

              window.location.href = theurl;

            }
            if (stage == 2) {
              $(button_id).removeClass('level-2');
              $(button_id).addClass('level-3');
              $(button_id).attr('data-level', '3');
            }
            if (stage == 1) {
              $(button_id).addClass('level-2');
              $(button_id).attr('data-level', '2');
            }

          }
        </script>
      <?php endif; ?>

      <?php if ($total_examples > $comment_limit) : ?>

        <div class="extra-comments extra-comments-1"></div>

        <script>
          function fetch_next_comments(val, val2, val3) {
            var theurl = "<?php echo $base_url ?>/fetch-next-comment-chunk/" + val + "/" + val2 + "/";
            $.ajax({
              url: theurl,
              type: 'get',
              contentType: false,
              processData: false,
              dataType: 'json',
              success: function(reply) {

                var response = reply.response;
                var nomore = reply.nomore;
                var html = reply.html;

                var extra_to_fill = '.extra-comments-' + val3;

                if (nomore == 1) {
                  $('.extra-comments-loading').remove();
                }
                if (response == 1) {
                  $(extra_to_fill).replaceWith(html);
                  $('.loading-extra-comments').removeClass('active');
                }
              }
            });
          }

          document.addEventListener('DOMContentLoaded', function() {
            $(window).scroll(function() {
              if ($('.extra-comments-1').visible()) {

                if (!$('.extra-comments-1').hasClass('triggered')) {
                  $('.loading-extra-comments').addClass('active');
                  $('.extra-comments-1').addClass('triggered');

                  fetch_next_comments(<?php echo $code_id; ?>, 1, 1);
                }
              }
            });
          });
        </script>

      <?php endif; ?>

      <?php if ($logged_in_id > 0) : ?>

        <script>
          <?php if ($logged_in_id == 1 && $moderation == 1) : ?>


            function moderate_comment(id, decision) {
              var theurl = "<?php echo $base_url ?>/moderate-code-comment/" + id + "/" + decision + "/";
              $.ajax({
                url: theurl,
                type: 'get',
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                  var status = response.status;
                  var id = response.id;
                  var rating = response.rating;

                  var mod_bar = ".moderation-bar-" + id
                  var mod_link_sfw = ".mod-link-sfw-" + id
                  var mod_link_nsfw = ".mod-link-nsfw-" + id
                  var mod_link_monly = ".mod-link-monly-" + id

                  if (status == 1) {
                    $(mod_bar).removeClass('warning');
                    if (rating == 0) {
                      $(mod_link_sfw).addClass('current');
                      $(mod_link_nsfw).removeClass('current');
                      $(mod_link_monly).removeClass('current');
                    }
                    if (rating == 1) {
                      $(mod_link_sfw).removeClass('current');
                      $(mod_link_nsfw).addClass('current');
                      $(mod_link_monly).removeClass('current');
                    }
                    if (rating == 2) {
                      $(mod_link_sfw).removeClass('current');
                      $(mod_link_nsfw).removeClass('current');
                      $(mod_link_monly).addClass('current');
                    }

                  }
                }
              });
            };

            document.addEventListener('DOMContentLoaded', function() {
              $('.mod-link').click(function() {
                var comment_id = $(this).attr('data-id');
                var comment_rating = $(this).attr('data-rating');
                moderate_comment(comment_id, comment_rating);
              });
            });

          <?php endif; ?>

          function delete_comment(val) {
            var are_you_sure_id = ".are-you-sure-" + val;
            $(are_you_sure_id).addClass('asking');
          }

          function cancel_delete_comment(val) {
            var are_you_sure_id = ".are-you-sure-" + val;
            $(are_you_sure_id).removeClass('asking');
          }

          document.addEventListener('DOMContentLoaded', function() {
            $('.delete-comment').click(function() {
              var comment_id = $(this).attr("data-id");
              delete_comment(comment_id);
            });
          });

          function remove_comment(val) {
            var comment_to_delete = ".comment-box-" + val;
            var children_to_delete = ".children-" + val;
            var reply_form_to_delete = ".reply-form-" + val;
            var children_container_to_delete = ".children-container-" + val;
            $(comment_to_delete).remove();
            $(reply_form_to_delete).slideUp('1000', "easeOutQuint", function() {});
            $(children_container_to_delete).remove();
            $(children_to_delete).remove();
          }

          function confirm_delete_comment(val) {
            var question_id = ".delete-comment-question-" + val;
            var loading_id = ".comment-loading-" + val;
            var are_you_sure_id = ".are-you-sure-" + val;

            $(question_id).addClass('thinking');
            $(loading_id).addClass('active');

            theurl = "<?php echo $base_url; ?>/delete-code-comment/" + val + "/";

            $.ajax({
              url: theurl,
              type: 'get',
              contentType: false,
              processData: false,
              dataType: 'json',
              success: function(response) {

                var status = response.status;
                var ids = response.ids;

                if (status == 0) {
                  $(question_id).removeClass('thinking');
                  $(loading_id).removeClass('active');
                  $(are_you_sure_id).removeClass('asking');

                }
                if (status == 1) {

                  $.each(ids, function(index, value) {
                    remove_comment(value);
                  });
                }
              }
            });
          }

          function fetchreplyform(val) {

            var sceneario_id = val;
            var ghost_id = ".ghost-" + sceneario_id;
            var select = ".reply-select-" + sceneario_id;
            var loading_id = ".comment-loading-" + sceneario_id;
            var replybox_id = ".reply-form-container-" + sceneario_id;

            var theurl = "<?php echo $base_url ?>/fetch-reply-form/" + <?php echo $code_id ?> + "/" + sceneario_id + "/";

            $(select).addClass('disabled');
            $(loading_id).addClass('active');

            $.ajax({
              url: theurl,
              type: 'get',
              contentType: false,
              processData: false,
              dataType: 'json',
              success: function(response) {
                var newhtml = response.html;
                $(ghost_id).append(newhtml);
                $(select).removeClass('disabled');
                $(loading_id).removeClass('active');
                $(select).addClass('reply-box-loaded');
                $(replybox_id).slideDown('1000', "easeOutQuint", function() {});
                $(select).addClass('live');
              }
            });

          }

          document.addEventListener('DOMContentLoaded', function() {
            $('.reply-select').click(function() {

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
          });

          function vote_down(val) {

            var comment_id = val;
            var arrow_up_id = ".comment-up-" + comment_id;
            var arrow_down_id = ".comment-down-" + comment_id;
            var rating_id = ".rating-" + comment_id;
            var meta_id = ".code-meta-rating-" + comment_id;

            if ($(arrow_down_id).hasClass("on")) {
              var theurl = "<?php echo $base_url ?>/rate-code-comment/" + comment_id + "/2/";
            } else {
              var theurl = "<?php echo $base_url ?>/rate-code-comment/" + comment_id + "/0/";
            }

            $(meta_id).addClass("blocked");
            $.ajax({
              url: theurl,
              type: 'get',
              contentType: false,
              processData: false,
              dataType: 'json',
              success: function(response) {

                var new_rating = response.rating;
                $(rating_id).html(new_rating);

                if ($(arrow_down_id).hasClass("on")) {
                  $(arrow_down_id).removeClass("on");
                  $(meta_id).removeClass("blocked");
                } else {
                  $(arrow_down_id).addClass("on");
                  $(arrow_up_id).removeClass("on");
                  $(meta_id).removeClass("blocked");
                }

              }
            });
          }

          function vote_up(val) {

            var comment_id = val;
            var arrow_up_id = ".comment-up-" + comment_id;
            var arrow_down_id = ".comment-down-" + comment_id;
            var rating_id = ".rating-" + comment_id;
            var meta_id = ".code-meta-rating-" + comment_id;

            if ($(arrow_up_id).hasClass("on")) {
              var theurl = "<?php echo $base_url ?>/rate-code-comment/" + comment_id + "/2/";
            } else {
              var theurl = "<?php echo $base_url ?>/rate-code-comment/" + comment_id + "/1/";
            }

            $(meta_id).addClass("blocked");
            $.ajax({
              url: theurl,
              type: 'get',
              contentType: false,
              processData: false,
              dataType: 'json',
              success: function(response) {
                var new_rating = response.rating;
                $(rating_id).html(new_rating);

                if ($(arrow_up_id).hasClass("on")) {
                  $(arrow_up_id).removeClass("on");
                  $(meta_id).removeClass("blocked");
                } else {
                  $(arrow_down_id).removeClass("on");
                  $(arrow_up_id).addClass("on");
                  $(meta_id).removeClass("blocked");
                }
              }
            });
          }

          document.addEventListener('DOMContentLoaded', function() {
            $('.comment-up').click(function() {
              var comment_id = $(this).attr("data-id");
              vote_up(comment_id);
            });

            $('.comment-down').click(function() {
              var comment_id = $(this).attr("data-id");
              vote_down(comment_id);
            });
          });
        </script>

      <?php endif; ?>

    </div>

    <div class="extra-comments-loading">
      <div class="loading invisible alt loading-extra-comments">
        <?php include($php_base_directory . '/includes/loading-alt.php'); ?>
      </div>
    </div>

    <script>
      function fetch_children(val) {
        var children_id = val;
        var children_to_trigger = ".children-" + children_id;
        var children_button = ".children-button-" + children_id;
        var loading_id = ".comment-loading-" + children_id;
        var theurl = "<?php echo $base_url; ?>/fetch-comment-children/<?php echo $code_id; ?>/" + children_id + "/";

        if ($(children_button).hasClass("activated")) {

        } else {


          $(children_button).addClass("activated");
          $(children_button).addClass("disabled");
          $(loading_id).addClass("active");

          $.ajax({
            url: theurl,
            type: 'get',
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {

              var newhtml = response.html;
              var open_delay = 150 * response.comment_count;
              $(children_to_trigger).replaceWith(newhtml);
              $(loading_id).removeClass("active");
              $(children_button).addClass("live");
              $(children_button).removeClass("disabled");

              $(children_to_trigger).slideDown(open_delay, "easeOutQuint", function() {});
            }
          });

        }

      }

      function fetch_infants(val) {

        var infant_id = val;
        var infant_to_trigger = ".infant-" + infant_id;
        var infant_button = ".infant-button-" + infant_id;
        var loading_id = ".comment-loading-" + infant_id;
        var theurl = "<?php echo $base_url; ?>/fetch-comment-infants/<?php echo $code_id; ?>/" + infant_id + "/";

        if ($(infant_button).hasClass("activated")) {

        } else {

          $(infant_button).addClass("activated");
          $(infant_button).addClass("disabled");
          $(loading_id).addClass("active");

          $.ajax({
            url: theurl,
            type: 'get',
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
              var newhtml = response.html;
              var open_delay = 150 * response.comment_count;
              $(infant_to_trigger).replaceWith(newhtml);
              $(loading_id).removeClass("active");
              $(infant_button).addClass("live");
              $(infant_button).removeClass("disabled");
              $(infant_to_trigger).slideDown(open_delay, "easeOutQuint", function() {});

            }
          });

        }

      }

      document.addEventListener('DOMContentLoaded', function() {
        $('.children').click(function() {

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

        document.addEventListener('DOMContentLoaded', function() {
          $('.children').each(function() {

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
        });
      });
    </script>

  </main>
  <aside id="sidebar" class="sidebar">
    <?php include($php_base_directory . '/sidebar.php'); ?>
  </aside>
</div>

<?php if ($logged_in_id > 0) : ?>
  <div class="junk-div"></div>
<?php endif; ?>

<?php
include($php_base_directory . '/footer.php');
?>
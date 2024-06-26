<?php
//fiddly url bounce
if ($typea != NULL && !is_numeric($typea)) {
  $bounce_out_header = "location: " . $base_url . "/code-suggestions/";
  header($bounce_out_header);
  die();
}

//get index
$result = 0;
if ($tandc_seen != 2) {
  $swfsql = "status > '1' AND ";
} else {
  $swfsql = null;
}

$mysqlquery = "SELECT * FROM underground_codesindex WHERE $swfsql id='$typea' ORDER BY id DESC LIMIT 1";
$res = $dbconn->query($mysqlquery);
while ($row = $res->fetch_assoc()) {
  $result = 1;
  $code_id = $row['id'];
  $owner = $row['owner_id'];
  $post_time = $row['post_time'];
  $post_status = $row['status'];
  $include_time = $row['include_time'];
  $dt = new DateTime("@$post_time");
}






//result check
if ($result == 0) {

  $location = "Location: " . $base_url . "/code-suggestions/";
  header($location);
  exit();
} else {

  $mysqlquery = "SELECT id, suggestion_id, slug, struck_off FROM thecode WHERE suggestion_id='$code_id' ORDER BY id DESC LIMIT 1";
  $res = $dbconn->query($mysqlquery);
  while ($row = $res->fetch_assoc()) {
    $broCodeID = $row['id'];
    $broCodeSlug = $row['slug'];
    $broCodeStruckOff = $row['struck_off'];
  }

  //get user details
  $display_name = "";
  $mysqlquery = "SELECT * FROM users WHERE id='$owner' ORDER BY id DESC LIMIT 1";
  $res = $dbconn->query($mysqlquery);
  while ($row = $res->fetch_assoc()) {
    $display_name = $row['display_name'];
  }


  if ($post_status == 3) {
    $pagetitle = "Bro Code Amendment";
  } else {
    $pagetitle = $display_name . "'s Suggested Code";
  }


  $sfw = 2;
  include($php_base_directory . '/header.php');

?>



  <div class="container">
    <main class="content">

      <div class="content-block">
        <h1 class="page-header hero">
          <?php echo $pagetitle; ?>
          <span class="hero-link-bg-image" style="background-image:url('<?php echo $static_url; ?>/images/tiles/gavel.jpg');"></span>
        </h1>
      </div>


      <div class="content-block bg bottom-padding special">

        <?php
        $current_next_code = 0;
        $mysqlquery = "SELECT value FROM system WHERE name='current_next_code'";
        $res = $dbconn->query($mysqlquery);
        while ($row = $res->fetch_assoc()) {
          $current_next_code = $row['value'];

          $mysqlquery = "SELECT value FROM system WHERE name='current_next_code_timer'";
          $res = $dbconn->query($mysqlquery);
          while ($row = $res->fetch_assoc()) {
            $current_next_code_timer = $row['value'];
          }
        }


        //Get Top Code
        $mysqlquery = "SELECT *, up_votes-down_votes as rating FROM underground_codevariants WHERE parent='$code_id' ORDER BY rating DESC, id ASC LIMIT 1";
        $res = $dbconn->query($mysqlquery);
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
          $varient_name = "";
          $mysqlqueryb = "SELECT id, display_name FROM users WHERE id='$owner_id' ORDER BY id DESC LIMIT 1";
          $resb = $dbconn->query($mysqlqueryb);
          while ($rowb = $resb->fetch_assoc()) {
            $varient_name = $rowb['display_name'];
          }


          //get vote of logged in user
          if ($logged_in_id > 0) {
            $vote = 2;
            $mysqlquery3 = "SELECT * FROM underground_coderatings WHERE user_id='$logged_in_id' AND variant_id='$id' ORDER BY id DESC";
            $res3 = $dbconn->query($mysqlquery3);
            while ($row3 = $res3->fetch_assoc()) {
              $vote = $row3['vote'];
            }
          }

          $next_code = 0;
          if ($current_next_code == $code_id) {
            $next_code = 1;
          }
        ?>

          <div class="code-container">
            <div class="number <?php
                                if (($next_code == 1 or $post_status == 3) && $broCodeStruckOff == 0) {
                                  echo "green";
                                }
                                if ($broCodeStruckOff == 1) {
                                  echo "red";
                                }
                                ?>">
              <?php if ($post_status == 3) : ?>
                <?php echo $broCodeID; ?>
              <?php elseif ($next_code == 1) : ?>
                &starf;
              <?php else : ?>
                #
              <?php endif; ?>

            </div>
            <div class="code-content">

              <?php
              $current_time = time();
              $go_live_timer = $current_time - $current_next_code_timer;
              $go_live_wait = $new_code_timer - $go_live_timer;

              $goinglive = secondsToTime($go_live_wait);
              if ($post_status == 4) { ?>
                <span class="number green full-width ">
                  ADDED TO THE BRO CODE
                </span>
              <?php } else if ($go_live_wait < 0 && $next_code == 1) { ?>
                <span class="number green full-width ">
                  BEING ADDED TO THE BRO CODE
                </span>
              <?php } else if ($go_live_wait > 0 && $next_code == 1) { ?>
                <span class="number green full-width ">
                  BEING ADDED TO THE BRO CODE - <?php echo $goinglive ?> LEFT TO HAVE YOUR SAY
                </span>
              <?php } ?>

              <h1 class="the-code">
                <?php
                if ($tandc_seen < 2) {
                  echo $profanity->filter_string($content);
                } else {
                  echo $content;
                } ?>
              </h1>

              <span class="meta no-bg border-top-desktop">
                <span class="meta-left code-meta-rating-left">

                  <?php if ($owner_id == 1) : ?>

                    <span class="meta-link <?php if ($owner_id == $logged_in_id) {
                                              echo "self";
                                            } ?>" rel="nofollow">
                      <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - ORIGIN UNKNOWN" />
                      
                      ORIGIN UNKNOWN
                    </span>

                  <?php elseif ($owner_id == 2) : ?>

                    <span data="<?php echo $base_url; ?>/profile/<?php echo $owner_id; ?>/" class="meta-link <?php if ($owner_id == $logged_in_id) {
                                                                                                                echo "self";
                                                                                                              } ?>" rel="nofollow">
                      <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $display_name; ?>" />
                      
                      <?php echo $display_name; ?>
                    </span>

                  <?php else : ?>

                    <span data="<?php echo $base_url; ?>/profile/<?php echo $owner_id; ?>/" class="meta-link <?php if ($owner_id == $logged_in_id) {
                                                                                                                echo "self";
                                                                                                              } ?>" rel="nofollow">
                      <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $display_name; ?>" />
                      
                      <?php echo $display_name; ?>
                    </span>

                    <?php if ($owner_id != $owner) : ?>
                      <span data="<?php echo $base_url; ?>/profile/<?php echo $owner_id; ?>/" class="meta-link <?php if ($owner_id == $logged_in_id) {
                                                                                                                  echo "self";
                                                                                                                } ?>" rel="nofollow">
                        <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $varient_name; ?>" /> 
                        <?php echo $varient_name; ?>
                      </span>
                    <?php endif; ?>

                  <?php endif; ?>
                </span>

                <span class="meta-right code-meta-rating code-meta-rating-<?php echo $id; ?>">

                  <?php if ($post_status == 3) { ?>
                    <a class="meta-link" target="_top" href="<?php echo $base_url; ?>/code/<?php echo $broCodeSlug; ?>/">View Code</a>
                  <?php }  ?>

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
                    <span class="meta-link delete-variant delete-variant-<?php echo $id; ?>" data-id="<?php echo $id; ?>" data-spot="1">
                      <?php include($php_base_directory . '/styles/images/svgs/delete-icon.svg'); ?>
                    </span>
                  <?php } ?>

                </span>
              </span>

            </div>


            <div class="loading invisible alt variant-loading-<?php echo $id; ?>">
              <?php include($php_base_directory . '/includes/loading-alt.php'); ?>
            </div>

            <?php if ($owner_id == $logged_in_id && $post_status < 3) { ?>
              <div class="are-you-sure variant_are-you-sure-<?php echo $id; ?>" data-spot="1">
                <?php
                $variant_to_delete_id = $id;
                $spot = 1;
                include($php_base_directory . '/includes/delete-variant.php');
                $variant_to_delete_id = 0;
                ?>
              </div>
            <?php } ?>

          </div>

        <?php } ?>


        <?php if ($logged_in_id == 1 && $moderation == 1) : ?>

          <span class="meta moderation-bar moderation-variant-bar-<?php echo $id; ?> border-top <?php if ($status == 0) {
                                                                                                  echo "warning";
                                                                                                } ?>">
            <span class="meta-left">
              <span class="meta-link mod-variant-link mod-link-sfw mod-link-acceptable-<?php echo $id; ?> <?php if ($status == 2) {
                                                                                                            echo "current";
                                                                                                          } ?>" data-id="<?php echo $id; ?>" data-topbar="1" data-rating="0" owner-id="<?php echo $owner_id; ?>">
                ACCEPTABLE
              </span>
              <span class="meta-link mod-variant-link mod-link-nsfw" data-id="<?php echo $id; ?>" data-topbar="1" data-rating="1" owner-id="<?php echo $owner_id; ?>">
                DUPLICATE
              </span>
              <span class="meta-link mod-variant-link mod-link-nsfw" data-id="<?php echo $id; ?>" data-topbar="1" data-rating="2" owner-id="<?php echo $owner_id; ?>">
                GRAMMAR
              </span>
              <span class="meta-link mod-variant-link mod-link-nsfw" data-id="<?php echo $id; ?>" data-topbar="1" data-rating="3" owner-id="<?php echo $owner_id; ?>">
                NSFW
              </span>
              <span class="meta-link mod-variant-link mod-link-nsfw" data-id="<?php echo $id; ?>" data-topbar="1" data-rating="4" owner-id="<?php echo $owner_id; ?>">
                WTF?
              </span>
            </span>

            <span class="meta-right">
              <span class="meta-link mod-variant-warning mod-variant-warning-<?php echo $id; ?>" data-level="1" owner-id="<?php echo $owner_id; ?>" data-id="<?php echo $id; ?>" data-topbar="1">
                WARNING
              </span>
              <span class="meta-link mod-variant-ban mod-variant-ban-<?php echo $id; ?>" data-level="1" owner-id="<?php echo $owner_id; ?>" data-id="<?php echo $id; ?>" data-topbar="1">
                BAN USER
              </span>
            </span>
          </span>

        <?php endif; ?>

      </div>


      <?php if ($post_status == 3) : ?>
        <div class="content-block bg bottom-padding">
          <div class="comment big">
            <p>This suggestion was added to the Bro Code, the wording and grammar can still be amended.</p>
          </div>
        </div>
      <?php endif; ?>


      <div class="content-block bg">
        <h3 class="page-header <?php
                                if ($broCodeStruckOff == 1) {
                                  echo "warning-header";
                                } else {
                                  echo "sub-header";
                                }
                                ?>">CODE VARIANTS</h3>

        <?php if ($logged_in_id > 0 && $post_status < 3) : ?>
          <div class="comment big">
            <p>If this is destined to become part of The Bro Code we want to get this right. If you think there is a better way to phrase this Bro Code, suggest it below.</p>
          </div>
        <?php endif; ?>

        <?php if ($post_status == 3) : ?>
          <div class="comment big">
            <p>If you think there is a better way to phrase this Bro Code, suggest it below.</p>
          </div>
        <?php endif; ?>


        <?php if ($logged_in_id > 0) : ?>
          <div class="loading alt variant-loading">
            <?php include($php_base_directory . '/includes/loading-alt.php'); ?>
          </div>
          <form method="post" class="variant-form" action="<?php echo $base_url; ?>/submit-code-variant/<?php echo $code_id; ?>/" enctype="multipart/form-data">
          <?php endif; ?>

          <div class="text-box-container alt">
            <textarea maxlength='1500' class="main-comment-box main-variant-box border-top" id="variant" name="variant" placeholder="Can you phrase this better?"></textarea>
          </div>

          <?php if ($logged_in_id < 1) : ?>
            <div class="login-prompt promt-overlay"></div>
          <?php endif; ?>

          <span class="meta <?php if ($logged_in_id < 1) {
                              echo "login-prompt";
                            } ?>">
            <span class="meta-left">
              <span class="meta-link-no-hover variant_char_count">
                0/1000
              </span>
            </span>

            <span class="meta-right">
              <input class="comment-submit variant-submit" id="submitvariant" type="submit" value="POST" disabled />
            </span>
          </span>
          <?php if ($logged_in_id > 0) : ?>
          </form>
        <?php endif; ?>




        <?php
        $variant_count = 1;

        if ($hide_shit == 1) {
          $hide_shit_sql = " up_votes-down_votes > -10 AND ";
        } else {
          $hide_shit_sql = null;
        }

        if ($tandc_seen != 2) {
          $swfsql = "status > '1' AND ";
        } else {
          $swfsql = null;
        }

        //Get other variants
        $mysqlquery = "SELECT *, up_votes-down_votes as rating FROM underground_codevariants WHERE $swfsql  $hide_shit_sql parent='$code_id' ORDER BY rating DESC, id ASC LIMIT 999999999 OFFSET 1";
        $res = $dbconn->query($mysqlquery);
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
          $varient_name = "";
          $mysqlqueryb = "SELECT * FROM users WHERE id='$owner_id' ORDER BY id DESC LIMIT 1";
          $resb = $dbconn->query($mysqlqueryb);
          while ($rowb = $resb->fetch_assoc()) {
            $varient_name = $rowb['display_name'];
          }


          //get vote of logged in user
          if ($logged_in_id > 0) {
            $vote = 2;
            $mysqlquery3 = "SELECT * FROM underground_coderatings WHERE user_id='$logged_in_id' AND variant_id='$id' ORDER BY id DESC";
            $res3 = $dbconn->query($mysqlquery3);
            while ($row3 = $res3->fetch_assoc()) {
              $vote = $row3['vote'];
            }
          }
        ?>



          <div class="comment variant-box-<?php echo $id; ?> border-top">

            <p><?php
                if ($tandc_seen < 2) {
                  echo $profanity->filter_string($content);
                } else {
                  echo $content;
                } ?></p>

            <span class="meta border-top">
              <span class="meta-left">
                <?php if ($owner_id == 1) : ?>
                  <span class="meta-link <?php if ($owner_id == $logged_in_id) {
                                            echo "self";
                                          } ?>" rel="nofollow">
                    <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - ORIGIN UNKNOWN" />
                    ORIGIN UNKNOWN
                  </span>
                <?php else : ?>
                  <span data="<?php echo $base_url; ?>/profile/<?php echo $owner_id; ?>/" class="meta-link <?php if ($owner_id == $logged_in_id) {
                                                                                                              echo "self";
                                                                                                            } ?>" rel="nofollow">
                    <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $varient_name; ?>" /> 
                    <?php echo $varient_name; ?>
                  </span>
                <?php endif; ?>
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

          <?php if ($logged_in_id == 1 && $moderation == 1) : ?>
            <span class="meta moderation-bar moderation-variant-bar-<?php echo $id; ?> border-top <?php if ($status == 0) {
                                                                                                    echo "warning";
                                                                                                  } ?>">
              <span class="meta-left">
                <span class="meta-link mod-variant-link mod-link-sfw mod-link-acceptable-<?php echo $id; ?> <?php if ($status == 2) {
                                                                                                              echo "current";
                                                                                                            } ?>" data-id="<?php echo $id; ?>" data-topbar="0" data-rating="0" owner-id="<?php echo $owner_id; ?>">
                  ACCEPTABLE
                </span>
                <span class="meta-link mod-variant-link mod-link-nsfw" data-id="<?php echo $id; ?>" data-topbar="0" data-rating="1" owner-id="<?php echo $owner_id; ?>">
                  DUPLICATE
                </span>
                <span class="meta-link mod-variant-link mod-link-nsfw" data-id="<?php echo $id; ?>" data-topbar="0" data-rating="2" owner-id="<?php echo $owner_id; ?>">
                  GRAMMAR
                </span>
                <span class="meta-link mod-variant-link mod-link-nsfw" data-id="<?php echo $id; ?>" data-topbar="0" data-rating="3" owner-id="<?php echo $owner_id; ?>">
                  NSFW
                </span>
                <span class="meta-link mod-variant-link mod-link-nsfw" data-id="<?php echo $id; ?>" data-topbar="0" data-rating="4" owner-id="<?php echo $owner_id; ?>">
                  WTF?
                </span>
                <span class="meta-link mod-variant-link mod-link-nsfw" data-id="<?php echo $id; ?>" data-topbar="0" data-rating="5" owner-id="<?php echo $owner_id; ?>">
                  MOVE TO COMMENTS
                </span>
              </span>

              <span class="meta-right">
                <span class="meta-link mod-variant-warning mod-variant-warning-<?php echo $id; ?>" data-level="1" owner-id="<?php echo $owner_id; ?>" data-id="<?php echo $id; ?>" data-topbar="0">
                  WARNING
                </span>
                <span class="meta-link mod-variant-ban mod-variant-ban-<?php echo $id; ?>" data-level="1" owner-id="<?php echo $owner_id; ?>" data-id="<?php echo $id; ?>" data-topbar="0">
                  BAN USER
                </span>
              </span>
            </span>

          <?php endif; ?>

        <?php $variant_count = $variant_count + 1;
        } ?>

        <div class="variant_ghost"></div>
      </div>



      <div class="content-block no-margin bg-alt">

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

        $mysqlquery = "SELECT *, up_votes-down_votes as rating FROM variant_comments WHERE code_id='$code_id' AND parent='0' $sfw_sql $hide_shit_sql ORDER BY $orderby_sql LIMIT $comment_limit";

        $mysqlquery_count = "SELECT *, up_votes-down_votes as rating FROM variant_comments WHERE code_id='$code_id' AND parent='0' $sfw_sql $hide_shit_sql ORDER BY $orderby_sql";
        $total_examples = $dbconn->query($mysqlquery_count);
        $total_examples = $total_examples->num_rows;
        ?>



        <h3 class="page-header alt <?php
                                    if ($broCodeStruckOff == 1) {
                                      echo "warning-header";
                                    } else {
                                      echo "sub-header";
                                    }
                                    ?>">COMMENTS &amp; REPLIES</h3>

        <?php if ($logged_in_id > 0) : ?>
          <div class="loading alt comment-loading">
            <?php include($php_base_directory . '/includes/loading-alt.php'); ?>
          </div>
          <form method="post" class="comment-form" action="<?php echo $base_url; ?>/submit-variant-comment/<?php echo $code_id; ?>/" enctype="multipart/form-data">
          <?php endif; ?>

          <textarea maxlength='1500' class="main-comment-box <?php if ($logged_in_id < 1) {
                                                                echo "login-prompt no-click";
                                                              } ?>" id="comment" name="comment" placeholder="Have something to say about this Bro Code?"></textarea>

          <?php if ($logged_in_id < 1) : ?>
            <div class="login-prompt promt-overlay zz"></div>
          <?php endif; ?>

          <span class="meta <?php if ($logged_in_id < 1) {
                              echo "login-prompt";
                            } ?>">
            <span class="meta-left">
              <span class="meta-link-no-hover character_count">
                0/1000
              </span>
            </span>

            <span class="meta-right">
              <input class="comment-submit" id="submit" type="submit" value="POST" disabled />
            </span>
          </span>

          <?php if ($logged_in_id > 0) : ?>
          </form>
        <?php endif; ?>



      </div>
      <div class="content-block bg-alt2">

        <div class="ghost"></div>

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
            $mysqlquery2 = "SELECT * FROM variant_comment_ratings WHERE user_id='$logged_in_id' AND example_id='$scenario_id' ORDER BY id DESC";
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
          $mysqlquery_child_replies = "SELECT id, parent, up_votes, down_votes, status, sfw FROM variant_comments WHERE code_id='$code_id' AND parent='$scenario_id' $sfw_sql $hide_shit_sql ORDER BY post_time DESC, id ASC";
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

        <?php if ($total_examples > $comment_limit) : ?>
          <div class="extra-comments extra-comments-1"></div>
        <?php endif; ?>

      </div>



      <div class="extra-comments-loading">
        <div class="loading invisible alt loading-extra-comments">
          <?php include($php_base_directory . '/includes/loading-alt.php'); ?>
        </div>
      </div>

    </main>
    <aside id="sidebar" class="sidebar">
      <?php include($php_base_directory . '/sidebar.php'); ?>
    </aside>

  </div>
<?php } ?>


<?php
include($php_base_directory . '/sections/the-code/js/potential-code-js.php');
include($php_base_directory . '/footer.php');
?>
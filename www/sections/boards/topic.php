<?php
$page_exists = 0;
$mysqlquery = "SELECT id,owner_id,board_id,title,content,video,video_id,poll,poll_choices,links,link_urls,members_only,gallery,gallery_ids,slug,owner_ip,sfw,status,post_time,up_votes,down_votes,last_update_time FROM topics WHERE slug='$typea' ORDER BY id ASC LIMIT 1";
$res = $dbconn->query($mysqlquery);
while ($row = $res->fetch_assoc()) {
  $page_exists = 1;
  $topic_id = $row['id'];
  $topic_owner_id = $row['owner_id'];
  $topic_board_id = $row['board_id'];
  $topic_title = html_entity_decode($row['title'], ENT_QUOTES, 'UTF-8');
  $topic_content = html_entity_decode($row['content'], ENT_QUOTES, 'UTF-8');
  $topic_video = $row['video'];
  $topic_video_id = $row['video_id'];
  $topic_poll = $row['poll'];
  $topic_poll_choices = $row['poll_choices'];
  $topic_links = $row['links'];
  $topic_link_urls = $row['link_urls'];
  $topic_members_only = $row['members_only'];
  $topic_gallery = $row['gallery'];
  $topic_gallery_ids = $row['gallery_ids'];
  $topic_slug = $row['slug'];
  $topic_owner_ip = $row['owner_ip'];
  $topic_sfw = $row['sfw'];
  $topic_status = $row['status'];
  $topic_post_time = $row['post_time'];
  $topic_last_update_time = $row['last_update_time'];

  $votes_up = $row['up_votes'];
  $votes_down = $row['down_votes'];
  $rating = $votes_up - $votes_down;
  if ($rating > 0) {
    $rating = '+' . $rating;
  } else if ($rating == 0) {
    $rating = '-';
  }
}


if ($page_exists == 0) {
  $get_lost = "location: " . $base_url;
  header($get_lost);
  die();
}

//if members only, get lost
if ($topic_members_only == 1 && $logged_in_id < 1) {
  $get_lost = "location: " . $base_url;
  header($get_lost);
  die();
}

//if not safe for work, get lost
if ($topic_sfw < 2 && $tandc_seen < 2) {
  $get_lost = "location: " . $base_url;
  header($get_lost);
  die();
}

//get user details
$mysqlquery2 = "SELECT id,display_name FROM users WHERE id='$topic_owner_id' ORDER BY id DESC LIMIT 1";
$res2 = $dbconn->query($mysqlquery2);
while ($row2 = $res2->fetch_assoc()) {
  $display_name = $row2['display_name'];
}

//get vote of logged in user
if ($logged_in_id > 0) {
  $topic_vote = 2;
  $mysqlquery3 = "SELECT * FROM topic_ratings WHERE user_id='$logged_in_id' AND topic_id='$topic_id' ORDER BY id DESC";
  $res3 = $dbconn->query($mysqlquery3);
  while ($row3 = $res3->fetch_assoc()) {
    $topic_vote = $row3['vote'];
  }
  echo $topic_vote;
}

$pagetitle = $topic_title;
$pagedescription = $topic_title;
$canonical = $base_url . "/topic/" . $typea . "/";
$sfw = 2;
include($php_base_directory . '/header.php');

?>


<div class="container">
  <main class="content">

    <div class="content-block">
      <h1 class="page-header">
        <?php echo $pagetitle; ?>
      </h1>
    </div>


    <div class="meta-nav top">
      <nav class="meta-solo">
        <div class="meta-left">
          <a class="meta-link black bread mobile-full" href="<?php echo $base_url; ?>/boards/"><span class="bread_crumb_link">HOME</span></a>
          <?php
          $board_breadcrumb = $topic_board_id;
          $breadcrumbs = array();

          while ($board_breadcrumb > 0) {
            $mysqlqueryd = "SELECT * FROM boards WHERE id='$board_breadcrumb'";

            $resd = $dbconn->query($mysqlqueryd);
            while ($rowd = $resd->fetch_assoc()) {
              $bread_board_id = $rowd['id'];
              $bread_board_parent = $rowd['parent'];
              $bread_board_slug = $rowd['board_slug'];
              $bread_pagetitle = $rowd['board_name'];

              ob_start();
          ?>
              <a class="meta-link black bread mobile-full" href="<?php echo $base_url; ?>/boards/<?php echo $bread_board_slug; ?>/"><span class="bread_crumb_link"><?php echo $bread_pagetitle; ?></span></a>
          <?php
              $breadcrumbs[$board_breadcrumb] = ob_get_contents();
              ob_end_clean();
              $board_breadcrumb = $bread_board_parent;
            }
          }

          $breadcrumbs = new ArrayIterator(array_reverse($breadcrumbs));
          foreach ($breadcrumbs as $key => $value) {
            echo $value;
          }
          ?>

        </div>
      </nav>
    </div>

    <div class="content-block topic-block overflowhidden bg bottom-padding">
      <?php if ($topic_video == 1) : ?>
        <div class="video-container">
          <iframe class="video-frame" src="https://www.youtube.com/embed/<?php echo $topic_video_id; ?>/" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
      <?php endif; ?>

      <?php if ($topic_video == 2) : ?>
        <div class="video-container">
          <iframe src="https://player.vimeo.com/video/<?php echo $topic_video_id; ?>/" class="video-frame" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
        </div>
      <?php endif; ?>

      <?php if ($topic_gallery == 1) : ?>

        <?php
        $topic_gallery_ids = unserialize($topic_gallery_ids);

        $total_images = 0;
        foreach ($topic_gallery_ids as $key => $value) {
          $total_images = $total_images + 1;
        }
        ?>

        <?php if ($total_images == 1) : ?>

          <?php
          foreach ($topic_gallery_ids as $key => $value) {
            $mysqlquery3 = "SELECT id, imagefile, thumb, img_width, img_height FROM uploads WHERE id='$value' ORDER BY id DESC";
            $res3 = $dbconn->query($mysqlquery3);
            while ($row3 = $res3->fetch_assoc()) {
              $image_id = $row3['id'];
              $image_imagefile = $row3['imagefile'];
              $image_thumb = $row3['thumb'];
              $image_img_width = $row3['img_width'];
              $image_img_height = $row3['img_height'];
          ?>
              <div id="gallery-image-screen" data-current-id="3" class="gallery-image-screen open">
                <div class="gallery-image-screen-inner">
                  <div class="gallery-image-screen-image-container" data-image="0"><img class="gallery-image" src="<?php echo $base_url . $image_imagefile; ?>" style="max-width:<?php echo $image_img_width ?>px;"></div>
                </div>
              </div>
          <?php }
          } ?>

        <?php endif; ?>

        <?php if ($total_images > 1) : ?>
          <div id="gallery-image-screen" data-current-id='0' class="gallery-image-screen" style="display:none;">
            <div class="gallery-image-screen-inner">
              <div class="gallery-left-nav">
                <?php include($php_base_directory . '/styles/images/svgs/arrow2.svg'); ?>
              </div>
              <div class="gallery-right-nav">
                <?php include($php_base_directory . '/styles/images/svgs/arrow2.svg'); ?>
              </div>
              <div class="gallery-image-screen-image-container" data-image="0">

              </div>
            </div>
          </div>

          <div class="topic-gallery-frame">
            <div class="topic-gallery-container">
              <?php
              $current_item = 1;
              foreach ($topic_gallery_ids as $key => $value) {
                $mysqlquery3 = "SELECT id, imagefile, thumb, img_width, img_height FROM uploads WHERE id='$value' ORDER BY id DESC";
                $res3 = $dbconn->query($mysqlquery3);
                while ($row3 = $res3->fetch_assoc()) {
                  $image_id = $row3['id'];
                  $image_imagefile = $row3['imagefile'];
                  $image_thumb = $row3['thumb'];
                  $image_img_width = $row3['img_width'];
                  $image_img_height = $row3['img_height'];
              ?>

                  <div class="topic-gallery-item topic-gallery-item_<?php echo $current_item; ?>" data-url="<?php echo $base_url . $image_imagefile; ?>" data-id="<?php echo $current_item; ?>" data-width="<?php echo $image_img_width ?>" data-height="<?php echo $image_img_height ?>">
                    <div class="topic-gallery-item_thumb" style="background-image:url('<?php echo $base_url . $image_thumb; ?>')">
                    </div>
                  </div>

                <?php } ?>
              <?php $current_item = $current_item + 1;
              } ?>
            </div>
          </div>
        <?php endif; ?>

      <?php endif; ?>


      <?php if ($topic_content != NULL && $topic_content != "") : ?>
        <div class="topic-content">
          <?php
          $topic_content = preg_replace("/[\r\n]+/", "\n", $topic_content);
          echo $parser->parse($topic_content)
            ->detect_links()
            ->detect_emails()
            ->get_html();
          ?>
        </div>
      <?php endif; ?>


      <?php if ($topic_poll == 1  or $topic_links == 1) : ?>
        <div class="topic-poll-container">

          <?php if ($topic_poll == 1) : ?>
            <h3 class="page-header small-sub-header">CAST YOUR VOTE</h3>

            <div class="loading poll-loading">
              <?php include($php_base_directory . '/includes/loading-alt.php'); ?>
            </div>

            <?php
            function get_poll_vote_count($poll_id)
            {
              global $dbconn;
              global $topic_id;

              $get_poll_vote_count_query = "SELECT id, topic_id, vote FROM topic_poll_votes WHERE topic_id='$topic_id' AND vote='$poll_id' ORDER BY id ASC";
              $poll_vote_count_sql = $dbconn->query($get_poll_vote_count_query);
              $poll_vote_count = mysqli_num_rows($poll_vote_count_sql);

              return $poll_vote_count;
            }
            ?>

            <?php
            //total votes on this poll
            $total_poll_votes_query = "SELECT id, topic_id FROM topic_poll_votes WHERE topic_id='$topic_id' ORDER BY id ASC";
            $vote_count_sql = $dbconn->query($total_poll_votes_query);
            $vote_count = mysqli_num_rows($vote_count_sql);

            //current user's vote
            $already_voted = 0;
            $poll_vote = 0;
            $votequery = "SELECT topic_id, user_id, vote FROM topic_poll_votes WHERE topic_id='$topic_id' AND user_id='$logged_in_id' ORDER BY id ASC";
            $res = $dbconn->query($votequery);
            while ($row = $res->fetch_assoc()) {
              $already_voted = 1;
              $poll_vote = $row['vote'];
            }
            ?>

            <?php
            $topic_poll_choices = unserialize($topic_poll_choices);
            $current_option = 1;
            foreach ($topic_poll_choices as $key => $value) {

              $total_votes = get_poll_vote_count($current_option);
              if ($total_votes == 0) {
                $total_votes_percentage = 0;
              } else {
                $total_votes_percentage = round(($total_votes / $vote_count) * 100, 1);
              }
            ?>
              <div class="poll-option-bar poll-option-bar-<?php echo $current_option; ?> <?php if ($poll_vote == $current_option) {
                                                                                            echo "chosen";
                                                                                          } ?>" data-id="<?php echo $current_option; ?>">
                <div class="poll-top-bar"></div>
                <div class="poll-left-bar"></div>
                <div class="poll-right-bar"></div>
                <div class="poll-pecentage-bar" style="width:<?php echo $total_votes_percentage ?>%;"></div>
                <div class="poll-option-count poll-option-count-<?php echo $current_option; ?>">
                  <?php echo $total_votes; ?>
                </div>
                <div class="poll-option-content">
                  <?php echo $value; ?>
                </div>

              </div>
            <?php $current_option = $current_option + 1;
            } ?>
          <?php endif; ?>


          <?php if ($topic_links == 1) : ?>
            <h3 class="page-header small-sub-header <?php if ($topic_poll == 1) {
                                                      echo "header-margin-top";
                                                    } ?>">Links</h3>

            <div class="loading poll-loading">
              <?php include($php_base_directory . '/includes/loading-alt.php'); ?>
            </div>

            <?php
            $topic_link_urls = unserialize($topic_link_urls);
            foreach ($topic_link_urls as $key => $value) {
            ?>
              <a class="topic-link" rel="nofollow" href="<?php echo $value; ?>"><?php echo $value; ?></a>
            <?php } ?>
          <?php endif; ?>

        </div>
      <?php endif; ?>


      <span class="meta no-bg border-top">
        <span class="meta-left">
          <a href="<?php echo $base_url; ?>/profile/<?php echo $topic_owner_id; ?>/" class="meta-link <?php if ($topic_owner_id == $logged_in_id) {
                                                                                                        echo "self";
                                                                                                      } ?>" rel="nofollow">
            <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $display_name; ?>" /> 
            BY <?php echo $display_name; ?>
          </a>
        </span>

        <span class="meta-right topic-meta-rating">

          <?php if ($logged_in_id > 0) { ?>
            <span class="meta-link downvote topic-down <?php if ($topic_vote == 0) {
                                                          echo 'on';
                                                        } ?>">
              <?php include($php_base_directory . '/styles/images/svgs/arrow.svg'); ?>
            </span>
          <?php } ?>

          <span class="meta-link-no-hover topic-rating">
            <?php echo $rating; ?>
          </span>

          <?php if ($logged_in_id > 0) { ?>
            <span class="meta-link upvote topic-up <?php if ($topic_vote == 1) {
                                                      echo 'on';
                                                    } ?>">
              <?php include($php_base_directory . '/styles/images/svgs/arrow.svg'); ?>
            </span>
          <?php } ?>

        </span>
      </span>



      <?php if ($logged_in_id == 1 && $moderation == 1) : ?>
        <span class="meta moderation-topic-bar moderation-topic-bar-<?php echo $topic_id; ?> border-top <?php if ($topic_status == 0) {
                                                                                                          echo "warning";
                                                                                                        } ?>">
          <span class="meta-left">
            <span class="meta-link mod-link-topic mod-link-topic-sfw mod-link-topic-sfw-<?php echo $topic_id; ?> <?php if ($topic_sfw == 2 && $topic_status == 1) {
                                                                                                                    echo "current";
                                                                                                                  } ?>" data-id="<?php echo $topic_id; ?>" data-rating="2">
              SFW
            </span>
            <span class="meta-link mod-link-topic mod-link-topic-nsfw mod-link-topic-nsfw-<?php echo $topic_id; ?> <?php if ($topic_sfw == 1 && $topic_status == 1) {
                                                                                                                      echo "current";
                                                                                                                    } ?>" data-id="<?php echo $topic_id; ?>" data-rating="1">
              NSFW
            </span>
            <span class="meta-link mod-link-topic mod-link-topic-monly mod-link-topic-monly-<?php echo $topic_id; ?> <?php if ($topic_sfw == 0 && $topic_status == 1) {
                                                                                                                        echo "current";
                                                                                                                      } ?>" data-id="<?php echo $topic_id; ?>" data-rating="0">
              M.ONLY
            </span>
          </span>

          <span class="meta-right">
            <span class="meta-link mod-link-topic-delete mod-link-topic-delete-<?php echo $topic_id; ?>" data-level="1" owner-id="<?php echo $topic_owner_id; ?>" data-id="<?php echo $topic_id; ?>">
              DELETE
            </span>
            <span class="meta-link mod-link-topic-warning mod-link-topic-warning-<?php echo $topic_id; ?>" data-level="1" owner-id="<?php echo $topic_owner_id; ?>" data-id="<?php echo $topic_id; ?>">
              WARNING
            </span>
            <span class="meta-link mod-link-topic-ban mod-link-topic-ban-<?php echo $topic_id; ?>" data-level="1" owner-id="<?php echo $topic_owner_id; ?>" data-id="<?php echo $topic_id; ?>">
              BAN USER
            </span>
          </span>
        </span>
      <?php endif; ?>
    </div>


    <?php if ($logged_in_id == 1 && $moderation == 1) : ?>
      <script>
        $('.mod-link-topic-warning').click(function() {
          var stage = $(this).attr('data-level');
          var owner = $(this).attr('owner-id');
          var id = $(this).attr('data-id');
          mod_topic_warn(stage, id, owner);
        });

        function mod_topic_warn(val, val2, val3) {
          var button_id = ".mod-link-topic-warning-" + val2;

          var stage = val;
          var topic_id = val2;
          var owner = val3;

          theurl = "<?php echo $base_url; ?>/moderate-topic-warn/" + topic_id + "/" + owner + "/";

          console.log(theurl);

          if (stage == 3) {
            $.ajax({
              url: theurl,
              type: 'get',
              contentType: false,
              processData: false,
              dataType: 'json',
              success: function(response) {
                console.log(response);
                var status = response.status;
                if (status == 1) {
                  console.log('TOPIC DELETED AND USER WARNED');
                  $('.next-moderate').trigger('click');
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


        $('.mod-link-topic-delete').click(function() {
          var stage = $(this).attr('data-level');
          var topic_id = $(this).attr('data-id');
          var owner = $(this).attr('owner-id');
          mod_topic_delete(stage, topic_id, owner)
        });

        function mod_topic_delete(val, val2, val3) {
          var remove_box = ".comment-box-" + val2;
          var button_id = ".mod-link-topic-delete-" + val2;

          var stage = val;
          var topic_id = val2;
          var owner = val3;

          theurl = "<?php echo $base_url; ?>/moderate-topic-delete/" + topic_id + "/" + owner + "/";

          console.log(theurl);

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
                  console.log('TOPIC DELETED');
                  $('.next-moderate').trigger('click');
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






        function moderate_topic(id, decision) {
          var theurl = "<?php echo $base_url ?>/moderate-topic/" + id + "/" + decision + "/";
          $.ajax({
            url: theurl,
            type: 'get',
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {

              console.log(response);

              var status = response.status;
              var id = response.id;
              var rating = response.rating;

              var mod_bar = ".moderation-topic-bar-" + id
              var mod_link_sfw = ".mod-link-topic-sfw-" + id
              var mod_link_nsfw = ".mod-link-topic-nsfw-" + id
              var mod_link_monly = ".mod-link-topic-monly-" + id

              if (status == 1) {
                $(mod_bar).removeClass('warning');
                if (rating == 2) {
                  $(mod_link_sfw).addClass('current');
                  $(mod_link_nsfw).removeClass('current');
                  $(mod_link_monly).removeClass('current');
                }
                if (rating == 1) {
                  $(mod_link_sfw).removeClass('current');
                  $(mod_link_nsfw).addClass('current');
                  $(mod_link_monly).removeClass('current');
                }
                if (rating == 0) {
                  $(mod_link_sfw).removeClass('current');
                  $(mod_link_nsfw).removeClass('current');
                  $(mod_link_monly).addClass('current');
                }

              }
            }
          });

        };


        $('.mod-link-topic').click(function() {
          var topic_id = $(this).attr('data-id');
          var topic_rating = $(this).attr('data-rating');
          moderate_topic(topic_id, topic_rating);
        });
      </script>
    <?php endif; ?>



    <?php if ($logged_in_id > 0) : ?>

      <script>
        document.addEventListener("DOMContentLoaded", function() {
          $('.topic-down').click(function() {

            if ($(".topic-down").hasClass("on")) {
              var theurl = "<?php echo $base_url ?>/rate-topic/<?php echo $topic_id; ?>/2/";
            } else {
              var theurl = "<?php echo $base_url ?>/rate-topic/<?php echo $topic_id; ?>/0/";
            }

            $('.topic-meta-rating').addClass("blocked");
            $.ajax({
              url: theurl,
              type: 'get',
              contentType: false,
              processData: false,
              dataType: 'json',
              success: function(response) {

                var new_rating = response.rating;
                $('.topic-rating').html(new_rating);

                if ($(".topic-down").hasClass("on")) {
                  $('.topic-down').removeClass("on");
                  $('.topic-meta-rating').removeClass("blocked");
                } else {
                  $('.topic-down').addClass("on");
                  $('.topic-up').removeClass("on");
                  $('.topic-meta-rating').removeClass("blocked");
                }

              }
            });

          });

          $('.topic-up').click(function() {

            if ($(".topic-up").hasClass("on")) {
              var theurl = "<?php echo $base_url ?>/rate-topic/<?php echo $topic_id; ?>/2/";
            } else {
              var theurl = "<?php echo $base_url ?>/rate-topic/<?php echo $topic_id; ?>/1/";
            }

            $('.topic-meta-rating').addClass("blocked");
            $.ajax({
              url: theurl,
              type: 'get',
              contentType: false,
              processData: false,
              dataType: 'json',
              success: function(response) {

                var new_rating = response.rating;
                $('.topic-rating').html(new_rating);

                if ($(".topic-up").hasClass("on")) {
                  $('.topic-up').removeClass("on");
                  $('.topic-meta-rating').removeClass("blocked");
                } else {
                  $('.topic-down').removeClass("on");
                  $('.topic-up').addClass("on");
                  $('.topic-meta-rating').removeClass("blocked");
                }
              }
            });

          });

        });
      </script>

    <?php endif; ?>









    <div class="content-block bg special">

      <?php if ($logged_in_id > 0) : ?>
        <div class="loading alt comment-loading">
          <?php include($php_base_directory . '/includes/loading-alt.php'); ?>
        </div>
        <form method="post" class="comment-form" action="<?php echo $base_url; ?>/submit-topic-comment/<?php echo $topic_id; ?>/" enctype="multipart/form-data">
        <?php endif; ?>

        <textarea maxlength='1500' class="main-comment-box <?php if ($logged_in_id < 1) {
                                                              echo "login-prompt no-click";
                                                            } ?>" id="comment" name="comment" placeholder="Have something to say?"></textarea>

        <?php if ($logged_in_id < 1) : ?>
          <div class="login-prompt promt-overlay"></div>
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
        $orderby_sql = "last_update DESC";
      } else if ($view_order == 1) {
        $orderby_sql = "last_update ASC";
      } else if ($view_order == 2) {
        $orderby_sql = "rating DESC";
      } else {
        $orderby_sql = "last_update DESC";
      }

      $mysqlquery = "SELECT *, up_votes-down_votes as rating FROM topic_replies WHERE topic_id='$topic_id' AND parent='0' $sfw_sql $hide_shit_sql ORDER BY $orderby_sql LIMIT $comment_limit";

      $mysqlquery_count = "SELECT *, up_votes-down_votes as rating FROM topic_replies WHERE topic_id='$topic_id' AND parent='0' $sfw_sql $hide_shit_sql ORDER BY $orderby_sql";
      $total_comments = $dbconn->query($mysqlquery_count);
      $total_comments = $total_comments->num_rows;
      ?>

      <h3 class="page-header sub-header">COMMENTS &amp; REPLIES</h3>
      <div class="ghost">
        <?php if ($total_comments == 0) : ?>
          <div class="comment comment-box-25 ">
            <p>No replies yet...</p>
          </div>
        <?php endif; ?>
      </div>

      <?php
      $comment_count = 1;
      $res = $dbconn->query($mysqlquery);
      while ($row = $res->fetch_assoc()) {

        $comment_id = $row['id'];
        $comment_owner_id = $row['owner_id'];
        $comment_post_time = $row['post_time'];
        $status = $row['status'];
        $rating = $row['rating'];
        $sfw = $row['sfw'];
        $content = $row['content'];
        $content = $content;
        $vdt = new DateTime("@$comment_post_time");

        if ($rating > 0) {
          $rating = '+' . $rating;
        } else if ($rating == 0) {
          $rating = '-';
        }

        //get vote of logged in user
        if ($logged_in_id > 0) {
          $vote = 2;
          $mysqlquery2 = "SELECT * FROM reply_ratings WHERE user_id='$logged_in_id' AND reply_id='$comment_id' ORDER BY id DESC";
          $res2 = $dbconn->query($mysqlquery2);
          while ($row2 = $res2->fetch_assoc()) {
            $vote = $row2['vote'];
          }
        }

        //get data of comment author
        $mysqlquery3 = "SELECT id, display_name FROM users WHERE id='$comment_owner_id' ORDER BY id DESC LIMIT 1";
        $res3 = $dbconn->query($mysqlquery3);
        while ($row3 = $res3->fetch_assoc()) {
          $comment_owner_name = $row3['display_name'];
        }

        //get children
        $mysqlquery_child_replies = "SELECT id, parent, up_votes, down_votes, status, sfw FROM topic_replies WHERE topic_id='$topic_id' AND parent='$comment_id' $sfw_sql $hide_shit_sql ORDER BY post_time DESC";

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


        <div class="comment comment-box-<?php echo $comment_id; ?> <?php if ($comment_count != 1) {
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

              <a href="<?php echo $base_url; ?>/profile/<?php echo $comment_owner_id; ?>/" class="meta-link <?php if ($comment_owner_id == $logged_in_id) {
                                                                                                              echo "self";
                                                                                                            } ?>" rel="nofollow">

                <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $comment_owner_name; ?>" /> 
                <?php echo $comment_owner_name; ?>
              </a>
              <a href="<?php echo $base_url; ?>/profile/<?php echo $comment_owner_id; ?>/" class="meta-link" rel="nofollow">
                <?php include($php_base_directory . '/styles/images/svgs/clock-icon.svg'); ?>
                <?php echo $vdt->format("dS M Y"); ?>
              </a>
            </span>

            <span class="meta-right topic-meta-rating-<?php echo $comment_id; ?>">

              <?php if ($logged_in_id > 0 && $comment_owner_id != $logged_in_id) { ?>
                <span class="meta-link downvote comment-down comment-down-<?php echo $comment_id; ?> <?php if ($vote == 0) {
                                                                                                        echo 'on';
                                                                                                      } ?>" data-id="<?php echo $comment_id; ?>">
                  <?php include($php_base_directory . '/styles/images/svgs/arrow.svg'); ?>
                </span>
              <?php } ?>

              <span class="meta-link-no-hover rating-<?php echo $comment_id; ?>">
                <?php echo $rating; ?>
              </span>

              <?php if ($logged_in_id > 0 && $comment_owner_id != $logged_in_id) { ?>
                <span class="meta-link upvote comment-up comment-up-<?php echo $comment_id; ?> <?php if ($vote == 1) {
                                                                                                  echo 'on';
                                                                                                } ?>" data-id="<?php echo $comment_id; ?>">
                  <?php include($php_base_directory . '/styles/images/svgs/arrow.svg'); ?>
                </span>
              <?php } ?>

              <?php if ($comment_owner_id == $logged_in_id) { ?>
                <span class="meta-link delete-comment delete-comment-<?php echo $comment_id; ?>" data-id="<?php echo $comment_id; ?>">
                  <?php include($php_base_directory . '/styles/images/svgs/delete-icon.svg'); ?>
                </span>
              <?php } ?>

            </span>
            <span class="meta-member-tools">

              <?php if ($logged_in_id > 0) { ?>
                <span class="meta-link reply-select reply-select-<?php echo $comment_id; ?>" data-id="<?php echo $comment_id; ?>">
                  <?php include($php_base_directory . '/styles/images/svgs/respond-icon.svg'); ?>
                  REPLY
                </span>
              <?php } ?>

              <?php if ($total_child_replies > 0) : ?>
                <span class="meta-link children children-button-<?php echo $comment_id; ?> <?php if ($logged_in_id == 1) {
                                                                                              if ($mod_status == 0 && $moderation == 1) {
                                                                                                echo "warning";
                                                                                              }
                                                                                            } ?>" data-id="<?php echo $comment_id; ?>">
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

          <div class="loading invisible alt comment-loading-<?php echo $comment_id; ?>">
            <?php include($php_base_directory . '/includes/loading-alt.php'); ?>
          </div>

          <?php if ($comment_owner_id == $logged_in_id) { ?>
            <div class="are-you-sure are-you-sure-<?php echo $comment_id; ?>">
              <?php
              $comment_to_delete_id = $comment_id;
              include($php_base_directory . '/includes/delete-comment.php');
              $comment_to_delete_id = 0;
              ?>
            </div>
          <?php } ?>

        </div>


        <?php if ($logged_in_id == 1 && $moderation == 1) : ?>
          <span class="meta moderation-bar moderation-bar-<?php echo $comment_id; ?> border-top <?php if ($status == 0) {
                                                                                                  echo "warning";
                                                                                                } ?>">
            <span class="meta-left">
              <span class="meta-link mod-link mod-link-sfw mod-link-sfw-<?php echo $comment_id; ?> <?php if ($sfw == 0 && $status == 1) {
                                                                                                      echo "current";
                                                                                                    } ?>" data-id="<?php echo $comment_id; ?>" data-rating="0">
                SFW
              </span>
              <span class="meta-link mod-link mod-link-nsfw mod-link-nsfw-<?php echo $comment_id; ?> <?php if ($sfw == 1 && $status == 1) {
                                                                                                        echo "current";
                                                                                                      } ?>" data-id="<?php echo $comment_id; ?>" data-rating="1">
                NSFW
              </span>
              <span class="meta-link mod-link mod-link-monly mod-link-monly-<?php echo $comment_id; ?> <?php if ($sfw == 2 && $status == 1) {
                                                                                                          echo "current";
                                                                                                        } ?>" data-id="<?php echo $comment_id; ?>" data-rating="2">
                M.ONLY
              </span>
            </span>

            <span class="meta-right">
              <span class="meta-link mod-link-delete mod-link-delete-<?php echo $comment_id; ?>" data-level="1" owner-id="<?php echo $comment_owner_id; ?>" data-id="<?php echo $comment_id; ?>">
                DELETE
              </span>
              <span class="meta-link mod-link-warning mod-link-warning-<?php echo $comment_id; ?>" data-level="1" owner-id="<?php echo $comment_owner_id; ?>" data-id="<?php echo $comment_id; ?>">
                WARNING
              </span>
              <span class="meta-link mod-link-ban mod-link-ban-<?php echo $comment_id; ?>" data-level="1" owner-id="<?php echo $comment_owner_id; ?>" data-id="<?php echo $comment_id; ?>">
                BAN USER
              </span>
            </span>
          </span>
        <?php endif; ?>

        <div class="ghost-<?php echo $comment_id; ?>"></div>

        <div class="reply-anchor reply-anchor-<?php echo $comment_id; ?>"></div>

        <div class="child-hidden children-<?php echo $comment_id; ?>">
          <div class="children-container children-container-<?php echo $comment_id; ?>">

            <div class="goto-anchor-<?php echo $comment_id; ?>"></div>

          </div>
        </div>

      <?php $comment_count = $comment_count + 1;
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

            theurl = "<?php echo $base_url; ?>/moderate-topic-comment-delete/" + comment_id + "/" + owner + "/";

            if (stage == 3) {
              $.ajax({
                url: theurl,
                type: 'get',
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                  console.log(response);
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

            theurl = "<?php echo $base_url; ?>/moderate-topic-comment-warn/" + comment_id + "/" + owner + "/";

            console.log(theurl);

            if (stage == 3) {
              $.ajax({
                url: theurl,
                type: 'get',
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                  console.log(response);
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

            console.log(theurl);

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











      <?php if ($total_comments > $comment_limit) : ?>

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

                  fetch_next_comments(<?php echo $topic_id; ?>, 1, 1);
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
              var theurl = "<?php echo $base_url ?>/moderate-topic-comment/" + id + "/" + decision + "/";
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

          $('.delete-comment').click(function() {
            var comment_id = $(this).attr("data-id");
            delete_comment(comment_id);
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

            theurl = "<?php echo $base_url; ?>/delete-topic-comment/" + val + "/";

            console.log(theurl);

            $.ajax({
              url: theurl,
              type: 'get',
              contentType: false,
              processData: false,
              dataType: 'json',
              success: function(response) {

                console.log(response);

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

            var theurl = "<?php echo $base_url ?>/fetch-topic-reply-form/" + <?php echo $topic_id ?> + "/" + sceneario_id + "/";

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
            var meta_id = ".topic-meta-rating-" + comment_id;

            if ($(arrow_down_id).hasClass("on")) {
              var theurl = "<?php echo $base_url ?>/rate-topic-comment/" + comment_id + "/2/";
            } else {
              var theurl = "<?php echo $base_url ?>/rate-topic-comment/" + comment_id + "/0/";
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
            var meta_id = ".topic-meta-rating-" + comment_id;

            if ($(arrow_up_id).hasClass("on")) {
              var theurl = "<?php echo $base_url ?>/rate-topic-comment/" + comment_id + "/2/";
            } else {
              var theurl = "<?php echo $base_url ?>/rate-topic-comment/" + comment_id + "/1/";
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

      <script>
        function fetch_children(val) {
          var children_id = val;
          var children_to_trigger = ".children-" + children_id;
          var children_button = ".children-button-" + children_id;
          var loading_id = ".comment-loading-" + children_id;
          var theurl = "<?php echo $base_url; ?>/fetch-reply-children/<?php echo $topic_id; ?>/" + children_id + "/";

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
          var theurl = "<?php echo $base_url; ?>/fetch-reply-infants/<?php echo $topic_id; ?>/" + infant_id + "/";

          console.log(theurl);

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
        });
      </script>
    </div>

  </main>
  <aside id="sidebar" class="sidebar">
    <?php include($php_base_directory . '/sidebar.php'); ?>
  </aside>
</div>

<?php if ($logged_in_id > 0) : ?>
  <div class="junk-div"></div>
<?php endif; ?>

<?php include($php_base_directory . '/sections/boards/includes/topic-js.php'); ?>

<?php
include($php_base_directory . '/footer.php');
?>
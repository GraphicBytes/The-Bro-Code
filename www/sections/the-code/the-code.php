<?php
$extra_title = "";

//fiddly url bounce
if ($typea != NULL && !is_numeric($typea)) {
  $bounce_out_header = "location: " . $base_url . "/the-code/";
  header($bounce_out_header);
  die();
}

//zero correction
if ($typea < 1 or !is_numeric($typea)) {
  $typea = NULL;
}

if ($typea > 0) {
  $extra_title = " Page " . $typea;
}
$pagetitle = "The Bro Code" . $extra_title;
$pagedescription = "Page " . $typea . " of The Bro Code, your guide to being a better man.";

if ($typea > 0) {
  $canonical = $base_url . "/the-code/" . $typea . "/";
} else {
  $canonical = $base_url . "/the-code/";
}


$current_loop = 1;
$mysqlquerycount = "SELECT * FROM thecode ORDER BY id ASC";
$total = $dbconn->query($mysqlquerycount);
$total = $total->num_rows;
$limit = 20;
$pages = ceil($total / $limit);

$page = $typea;
if ($page == null) {
  $page = 1;
}
$offset = ($page - 1)  * $limit;

$prefix = "the-code";


$sfw = 2;


if ($page < $pages) {
  $promo_spot = $limit / 2;
} else {
  $promo_spot = ceil(($total - (($pages - 1) * $limit)) / 2);
}


//end of the line bounce
if ($typea > $pages) {
  $bounce_out_header = "location: " . $base_url . "/the-code/";
  header($bounce_out_header);
  die();
}

include($php_base_directory . '/header.php');
?>


<div class="container">
  <main class="content">
    <div class="content-block bottom-padding">

      <h1 class="page-header hero">
        <?php echo $pagetitle; ?>
        <span class="hero-link-bg-image" style="background-image:url('<?php echo $static_url; ?>/images/tiles/fist-bump-large.jpg');"></span>
      </h1>

      <?php
      $current_next_code = $system_data['current_next_code'];

      if ($current_next_code != 0) {

        $current_next_code_timer = $system_data['current_next_code_timer'];
        $current_time = $request_time;
        $go_live_timer = $current_time - $current_next_code_timer;
        $go_live_wait = $new_code_timer - $go_live_timer;

        $mysqlquery = "SELECT * FROM underground_codesindex WHERE id='$current_next_code'";
        $res = $dbconn->query($mysqlquery);
        while ($row = $res->fetch_assoc()) {
          $code_id = $row['id'];
          $owner_id = $row['owner_id'];

          $mysqlquery2 = "SELECT *, up_votes-down_votes AS rating FROM underground_codevariants WHERE parent='$code_id' ORDER BY rating DESC, id ASC LIMIT 1";
          $res2 = $dbconn->query($mysqlquery2);
          while ($row2 = $res2->fetch_assoc()) {

            $variant_owner_id = $row2['owner_id'];
            $content = $row2['content'];
            $up_votes = $row2['up_votes'];
            $down_votes = $row2['down_votes'];
            $rating = $up_votes - $down_votes;
          }

          if ($rating > 0) {
            $rating = '+' . $rating;
          } else if ($rating == 0) {
            $rating = '-';
          }

          $mysqlqueryb = "SELECT display_name FROM users WHERE id='$owner_id'";
          $resb = $dbconn->query($mysqlqueryb);
          while ($rowb = $resb->fetch_assoc()) {
            $owner_name = $rowb['display_name'];
          }

          if ($owner_id !== $variant_owner_id) {
            $mysqlqueryc = "SELECT display_name FROM users WHERE id='$variant_owner_id'";
            $resc = $dbconn->query($mysqlqueryc);
            while ($rowc = $resc->fetch_assoc()) {
              $variant_owner_name = $rowc['display_name'];
            }
          }

      ?>

          <a class="code-bar" href="<?php echo $base_url; ?>/potential-code/<?php echo $code_id; ?>/">

            <span class="code-number green">
              &starf;
            </span>
            <span class="code-content">

              <?php
              $goinglive = secondsToTime($go_live_wait);
              if ($go_live_wait < 0) { ?>
                <span class="code-number green full-width">
                  BEING ADDED TO THE BRO CODE
                </span>
              <?php } else { ?>
                <span class="code-number green full-width">
                  BEING ADDED TO THE BRO CODE - <?php echo $goinglive ?> LEFT TO HAVE YOUR SAY
                </span>
              <?php } ?>

              <span class="the-code">
                <?php
                if ($tandc_seen < 2) {
                  echo $profanity->filter_string($content);
                } else {
                  echo $content;
                } ?>
              </span>
              <span class="meta no-bg">
                <span class="meta-left ">
                  <span class="meta-link">
                    <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $owner_name; ?>" />
                    
                    <?php echo $owner_name; ?>
                  </span>

                  <?php if ($owner_id !== $variant_owner_id) { ?>
                    <span class="meta-link mobile-hide" rel="nofollow">
                      <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $variant_owner_name; ?>" />
                      
                      <?php echo $variant_owner_name; ?>
                    </span>
                  <?php } ?>
                </span>
                <span class="meta-right">
                  <span class="meta-link-no-hover green">
                    <?php echo $rating; ?>
                  </span>
                </span>
              </span>

            </span>

          </a>

      <?php }
      } ?>












      <?php
      $current_winning_code = $system_data['current_winning_code'];

      if ($current_winning_code != 0 && $current_next_code == 0) {

        $mysqlquery = "SELECT * FROM underground_codesindex WHERE id='$current_winning_code'";
        $res = $dbconn->query($mysqlquery);
        while ($row = $res->fetch_assoc()) {
          $code_id = $row['id'];
          $owner_id = $row['owner_id'];

          $mysqlquery2 = "SELECT *, up_votes-down_votes AS rating FROM underground_codevariants WHERE parent='$code_id' ORDER BY rating DESC, id ASC LIMIT 1";
          $res2 = $dbconn->query($mysqlquery2);
          while ($row2 = $res2->fetch_assoc()) {

            $variant_owner_id = $row2['owner_id'];
            $content = $row2['content'];
            $up_votes = $row2['up_votes'];
            $down_votes = $row2['down_votes'];
            $rating = $up_votes - $down_votes;
          }

          if ($rating > 0) {
            $rating = '+' . $rating;
          } else if ($rating == 0) {
            $rating = '-';
          }

          $mysqlqueryb = "SELECT display_name FROM users WHERE id='$owner_id'";
          $resb = $dbconn->query($mysqlqueryb);
          while ($rowb = $resb->fetch_assoc()) {
            $owner_name = $rowb['display_name'];
          }

          if ($owner_id !== $variant_owner_id) {
            $mysqlqueryc = "SELECT display_name FROM users WHERE id='$variant_owner_id'";
            $resb = $dbconn->query($mysqlqueryc);
            while ($rowc = $resb->fetch_assoc()) {
              $variant_owner_name = $rowc['display_name'];
            }
          }

      ?>

          <a class="code-bar" href="<?php echo $base_url; ?>/potential-code/<?php echo $code_id; ?>/">

            <span class="code-number green">
              &starf;
            </span>
            <span class="code-content">

              <span class="the-code">
                <?php
                if ($tandc_seen < 2) {
                  echo $profanity->filter_string($content);
                } else {
                  echo $content;
                } ?>
              </span>
              <span class="meta no-bg">
                <span class="meta-left ">
                  <span class="meta-link">
                    <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $owner_name; ?>" />
                    
                    <?php echo $owner_name; ?>
                  </span>

                  <?php if ($owner_id !== $variant_owner_id) { ?>
                    <span class="meta-link mobile-hide" rel="nofollow">
                      <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $variant_owner_name; ?>" />
                      
                      <?php echo $variant_owner_name; ?>
                    </span>
                  <?php } ?>
                </span>
                <span class="meta-right">
                  <span class="meta-link-no-hover green">
                    CURRENT TOP SUGGESTION
                  </span>
                </span>
              </span>

            </span>

          </a>
      <?php }
      } ?>








      <?php
      if ($view_order == 0) {
        $mysqlquery = "SELECT * FROM thecode ORDER BY id DESC LIMIT $limit OFFSET $offset";
      } else if ($view_order == 1) {
        $mysqlquery = "SELECT * FROM thecode ORDER BY id ASC LIMIT $limit OFFSET $offset";
      } else if ($view_order == 2) {
        $mysqlquery = "SELECT *, votes_up - votes_down AS rating FROM thecode ORDER BY rating DESC, id ASC LIMIT $limit OFFSET $offset";
      } else {
        $mysqlquery = "SELECT * FROM thecode ORDER BY id ASC LIMIT $limit OFFSET $offset";
      }

      $res = $dbconn->query($mysqlquery);
      while ($row = $res->fetch_assoc()) {
        $code_id = $row['id'];
        $owner_id = $row['owner_id'];
        $variant_owner_id = $row['variant_owner_id'];
        $content = $row['content'];
        $content = $content;
        $slug = $row['slug'];
        $votes_up = $row['votes_up'];
        $votes_down = $row['votes_down'];
        $struck_off = $row['struck_off'];
        $rating = $votes_up - $votes_down;
        if ($rating > 0) {
          $rating = '+' . $rating;
        } else if ($rating == 0) {
          $rating = '-';
        }

        //get user details
        $mysqlquery2 = "SELECT * FROM users WHERE id='$owner_id' ORDER BY id DESC LIMIT 1";
        $res2 = $dbconn->query($mysqlquery2);
        while ($row2 = $res2->fetch_assoc()) {
          $display_name = $row2['display_name'];
        }

        if ($owner_id != $variant_owner_id) {
          //get variant details
          $mysqlquery2 = "SELECT * FROM users WHERE id='$variant_owner_id' ORDER BY id DESC LIMIT 1";
          $res2 = $dbconn->query($mysqlquery2);
          while ($row2 = $res2->fetch_assoc()) {
            $variant_display_name = $row2['display_name'];
          }
        }

        $mysqlqueryd = "SELECT id FROM thecode_examples WHERE code_id='$code_id'";
        $comments = $dbconn->query($mysqlqueryd);
        $comments = $comments->num_rows;
      ?>


        <a class="code-bar <?php if ($struck_off == 1) {
                              echo "struck_off";
                            } ?>" href="<?php echo $base_url; ?>/code/<?php echo $slug; ?>/">

          <span class="code-number <?php if ($struck_off == 1) {
                                      echo "struck_off_line_small";
                                    } else {
                                      echo "blue";
                                    } ?>">
            <?php echo $code_id; ?>
          </span>
          <span class="code-content">
            <span class="the-code <?php if ($struck_off == 1) {
                                    echo "struck_off_line";
                                  } ?>">
              <?php echo $content; ?>
            </span>
            <span class="meta no-bg">
              <span class="meta-left ">

                <?php if ($owner_id == 1) : ?>
                  <span class="meta-link-no-hover <?php if ($owner_id == $logged_in_id) {
                                                    echo "self";
                                                  } ?>" rel="nofollow">
                    <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - ORIGIN UNKNOWN" />
                    
                    ORIGIN UNKNOWN
                  </span>
                <?php elseif ($owner_id == 2) : ?>
                  <span class="meta-link-no-hover <?php if ($owner_id == $logged_in_id) {
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
                <?php endif; ?>

                <?php if ($owner_id != $variant_owner_id) { ?>
                  <span class="meta-link mobile-hide" rel="nofollow">
                    <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $variant_display_name; ?>" /> 
                    <?php echo $variant_display_name; ?>
                  </span>
                <?php } ?>

              </span>
              <span class="meta-right">
                <?php if ($comments > 0) { ?>
                  <span class="meta-link">
                    <svg class="comments-icon" version="1.1" id="Layer_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" style="enable-background:new 0 0 1000 1000;" xml:space="preserve">
                      <g>
                        <path d="M826.7,10H173.3C83.5,10,10,83.5,10,173.3v490c0,90.1,73.3,163.3,163.3,163.3l0,0c1.1,0,2.1,0.7,2.5,1.8l50.6,142.2
                      c5.9,15.4,16.8,23.7,27.3,23.7c10.4,0,30-18.9,38-26.9l117.8-125.5c9.6-10.3,23.1-16.1,37.2-16l380,0.8
                      c90.1,0,163.3-73.3,163.3-163.3v-490C990,83.3,916.7,10,826.7,10z" />
                      </g>
                    </svg>
                    <?php echo $comments;
                    if ($comments > 1) { ?> <span class="mobile-hide">&nbsp;COMMENTS</span><?php } else { ?> <span class="mobile-hide">&nbsp;COMMENT</span><?php } ?>
                  </span>
                <?php } ?>
                <span class="meta-link-no-hover">
                  <?php echo $rating; ?>
                </span>
              </span>
            </span>

          </span>

        </a>

        <?php
        //if ($current_loop == $promo_spot && $current_loop > 5){include('includes/promo_embeds.php');}
        ?>

      <?php $current_loop = $current_loop + 1;
      } ?>

      <div class="meta-nav">
        <nav class="meta-solo">
          <div class="meta-left"><a class="meta-link no-border mobile-full" href="<?php echo $base_url ?>/printable/" target="_blank">Printer Friendly Bro Code</a></div>
          <div class="meta-right"><?php include('includes/pagenate.php'); ?></div>
        </nav>
      </div>

    </div>
  </main>


  <aside id="sidebar" class="sidebar">
    <?php include($php_base_directory . '/sidebar.php'); ?>
  </aside>

</div>




<?php
include($php_base_directory . '/footer.php');
?>
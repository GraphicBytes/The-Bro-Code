<?php
$extra_title = "";

//fiddly url bounce
if ($typea != NULL && !is_numeric($typea)) {
  $bounce_out_header = "location: " . $base_url . "/code-suggestions/";
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
$pagetitle = "Bro Code Suggestions" . $extra_title;
$pagedescription = "Page " . $typea . " of Bro Code Suggestions.";

if ($typea > 0) {
  $canonical = $base_url . "/code-suggestions/" . $typea . "/";
} else {
  $canonical = $base_url . "/code-suggestions/";
}


$current_loop = 1;

if ($tandc_seen != 2) {
  $sfwsql = " WHERE status='2'";
} else {
  $sfwsql = " WHERE status < 3";
}
if ($hide_shit == 1) {
  $hide_shit_sql = "AND totalvotes > -10";
} else {
  $hide_shit_sql = null;
}

$mysqlquerycount = "SELECT * FROM underground_codesindex $sfwsql $hide_shit_sql ORDER BY id ASC";
$total = $dbconn->query($mysqlquerycount);
$total = $total->num_rows;
$limit = 20;
$pages = ceil($total / $limit);

$page = $typea;
if ($page == null) {
  $page = 1;
}
$offset = ($page - 1)  * $limit;

$prefix = "code-suggestions";

$sfw = 2;


if ($page < $pages) {
  $promo_spot = $limit / 2;
} else {
  $promo_spot = ceil(($total - (($pages - 1) * $limit)) / 2);
}


//end of the line bounce
if ($typea > $pages) {
  $bounce_out_header = "location: " . $base_url . "/code-suggestions/";
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
        <span class="hero-link-bg-image" style="background-image:url('<?php echo $static_url; ?>/images/tiles/gavel-large.jpg');"></span>
      </h1>

      <?php
      $current_next_code = 0;
      $mysqlquery = "SELECT value FROM system WHERE name='current_next_code'";
      $res = $dbconn->query($mysqlquery);
      while ($row = $res->fetch_assoc()) {
        $current_next_code = $row['value'];
      }

      if ($current_next_code != 0) {


        $mysqlquery = "SELECT value FROM system WHERE name='current_next_code_timer'";
        $res = $dbconn->query($mysqlquery);
        while ($row = $res->fetch_assoc()) {
          $current_next_code_timer = $row['value'];
        }
        $current_time = time();
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
          $owner_name = $dbconn->query($mysqlqueryb)->fetch_assoc();

          $mysqlqueryc = "SELECT display_name FROM users WHERE id='$variant_owner_id'";
          $variant_owner_name = $dbconn->query($mysqlqueryc)->fetch_assoc();

      ?>

          <a class="code-bar" href="<?php echo $base_url; ?>/potential-code/<?php echo $code_id; ?>/">

            <span class="code-number green">
              &starf;
            </span>
            <span class="code-content">

              <?php
              $goinglive = secondsToTime($go_live_wait);
              if ($go_live_wait < 0) { ?>
                <span class="meta-link-no-hover green">
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
                    <span class="meta-link mobile-hide" rel="nofollow">
                      <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $owner_name['display_name']; ?>" /> 
                      <?php echo $owner_name['display_name']; ?>
                    </span>

                    <?php if ($owner_id !== $variant_owner_id) { ?>
                      <span class="meta-link mobile-hide" rel="nofollow">
                        <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $variant_owner_name['display_name']; ?>" />
                        <?php echo $variant_owner_name['display_name']; ?>
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
      if ($logged_in_id == 0) {
        $view_order = 2;
      }

      if ($view_order == 0) {
        $orderby = "ORDER BY last_activity DESC, id ASC";
      } else if ($view_order == 1) {
        $orderby = "ORDER BY post_time ASC, id ASC";
      } else if ($view_order == 2) {
        $orderby = "ORDER BY totalvotes DESC, id ASC";
      }

      $mysqlquery = "SELECT * FROM underground_codesindex $sfwsql $hide_shit_sql AND NOT id = '$current_next_code' $orderby LIMIT $limit OFFSET $offset";

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
        $owner_name = $dbconn->query($mysqlqueryb)->fetch_assoc();

        $mysqlqueryc = "SELECT display_name FROM users WHERE id='$variant_owner_id'";
        $variant_owner_name = $dbconn->query($mysqlqueryc)->fetch_assoc();

      ?>

        <a class="code-bar" href="<?php echo $base_url; ?>/potential-code/<?php echo $code_id; ?>/">

          <span class="code-number">
            #
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
                  <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $owner_name['display_name']; ?>" />
                  <?php echo $owner_name['display_name'];  ?>
                </span>

                <?php if ($owner_id !== $variant_owner_id) { ?>
                  <span class="meta-link mobile-hide" rel="nofollow">
                    <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $variant_owner_name['display_name']; ?>" />
                    <?php echo $variant_owner_name['display_name']; ?>
                  </span>
                <?php } ?>
              </span>
              <span class="meta-right">
                <span class="meta-link-no-hover">
                  <?php echo $rating; ?>
                </span>
              </span>
            </span>

          </span>

        </a>


      <?php $current_loop = $current_loop + 1;
      } ?>

      <div class="meta-nav">
        <nav class="meta-solo">
          <div class="meta-left"></div>
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
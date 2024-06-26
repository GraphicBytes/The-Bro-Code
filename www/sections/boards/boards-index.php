<?php
$description="";
$board_name="";
$board_id=0;
$open_status=0;
$board_status=0;
$board_parent=0;
$read_only_status=0;

$extra_title="";
if ($typeb > 0) {$extra_title = " Page " . $typea;}

if ($typeb > 0) {
  $canonical= $base_url . "/boards/" . $typea . "/" ;
}else{
  $canonical= $base_url . "/boards/" ;
}

if ($typea == null) {
  $pagetitle = "Message Boards";
  $pagedescription = "The Bro Code Message Boards";
  if($tandc_seen != 2) {
    $mysqlquery="SELECT * FROM boards WHERE parent='0' AND status='1' ORDER BY post_order ASC";
  }else{
    $mysqlquery="SELECT * FROM boards WHERE parent='0' ORDER BY post_order ASC";
  }
} else{
  if($tandc_seen != 2) {
    $mysqlquery="SELECT * FROM boards WHERE board_slug='$typea' AND status='1' ORDER BY post_order ASC";
  }else{
    $mysqlquery="SELECT * FROM boards WHERE board_slug='$typea' ORDER BY post_order ASC";
  }

  $res=$dbconn->query($mysqlquery);
  while($row=$res->fetch_assoc()) {
    $board_id=$row['id'];
    $board_parent=$row['parent'];
    $board_status=$row['status'];
    $open_status=$row['open'];
    $read_only_status=$row['read_only'];
    $pagetitle=$row['board_name'] . $extra_title;
    $pagedescription=$row['description'];
  }
  if($tandc_seen != 2) {
    $mysqlquery="SELECT * FROM boards WHERE parent='$board_id' AND status='1' ORDER BY post_order ASC";
  }else{
    $mysqlquery="SELECT * FROM boards WHERE parent='$board_id' ORDER BY post_order ASC";
  }

}
$wysibb = 1;
if($read_only_status == 0 && $logged_in_id > 0) {
  $wysibb = 1;
}

$total_boards = $dbconn->query($mysqlquery);
$total_boards = $total_boards->num_rows;

if ($open_status == 1) {
  if($hide_shit == 1) {$hide_shit_sql = " up_votes-down_votes > -10 AND ";}else{$hide_shit_sql=null;}

  if($tandc_seen != 2) {$swfsql = "status > '1' AND ";}else{$swfsql=null;}

  $mysqlquerycount="SELECT * FROM topics WHERE $hide_shit_sql $swfsql board_id = '$board_id' ORDER BY id ASC";
  $total = $dbconn->query($mysqlquerycount);
  $total = $total->num_rows;
  $limit = 40;
  $pages = ceil($total / $limit);
  $page = $typeb;
  if ($page == null) {$page = 1;}
  $offset = ($page - 1)  * $limit;
  $prefix="boards/" . $typea;
}



$sfw=2;


if($board_status < 2 && $board_parent > 0 && $tandc_seen < 2) {
  $goto = "location: " . $base_url . "/boards/";
  header($goto);
  die;
}

include($php_base_directory . '/header.php');
?>

<div class="container">
  <main class="content">
    <div class="content-block">
      <h1 class="page-header"><?php echo $pagetitle; ?>
        <?php if ($moderation == 1): ?>
          <span class="edit-board">
            <?php include($php_base_directory . '/styles/images/svgs/edit.svg'); ?>
          </span>
        <?php endif; ?>
      </h1>
    </div>

    <?php if ($pagedescription != null && $pagedescription != ""): ?>
      <div class="content-block-hero">
        <div class="content-block-hero-content">
          <p><?php echo $pagedescription; ?></p>
        </div>
        <div class="board-hero-image" style="background-image:url('<?php echo $base_url; ?>/styles/images/board-hero-default.jpg')"></div>
      </div>
    <?php endif; ?>


    <?php if ($logged_in_id == 1 && $moderation == 1): ?>

      <?php if ($board_id > 0): ?>
        <div class="slide-hide edit-board-box">
          <div class="content-block bg special">
            <h3 class="page-header warning-sub-header">UPDATE BOARD</h3>
            <form method="post" class="comment-form sm-font" action="<?php echo $base_url; ?>/update-board/<?php echo $board_id; ?>/" enctype="multipart/form-data">

            <textarea  maxlength='300' class="topicheader" id="edittopicheader2" name="topicheader" placeholder="Board Title"><?php echo $pagetitle; ?></textarea>

            <textarea  maxlength='1500' class="main-comment-box" id="editdescription2" name="description" placeholder="Board Description"><?php echo $pagedescription; ?></textarea>

            <span class="meta">
              <span class="meta-left">
                <input type="checkbox" class="checkbox" id="membersonly2" name="membersonly" <?php if ($board_status==0) {echo "checked";} ?>>
                <label class="checkbox-label" for="membersonly">MEMBERS ONLY</label>

                <input type="checkbox" class="checkbox" id="openstatus2" name="openstatus" <?php if ($open_status==1) {echo "checked";} ?>>
                <label class="checkbox-label" for="openstatus">OPEN</label>

                <input type="checkbox" class="checkbox" id="readonlystatus2" name="readonlystatus" <?php if ($read_only_status==1) {echo "checked";} ?>>
                <label class="checkbox-label" for="readonlystatus">READ ONLY</label>
              </span>
              <span class="meta-right">
                <input class="comment-submit" id="submit2" type="submit" value="UPDATE" />
              </span>
            </span>

            </form>

            <script>
              $('#edittopicheader').on('input', function() {
                var scroll_height = $('#edittopicheader').get(0).scrollHeight;
                scroll_height = +scroll_height + +1;
                $('#edittopicheader').css('height', scroll_height + 'px');
              });
              $('#editdescription').on('input', function() {
                var scroll_height = $('#editdescription').get(0).scrollHeight;
                scroll_height = +scroll_height + +1;
                $('#editdescription').css('height', scroll_height + 'px');
              });
            </script>
          </div>
        </div>
      <?php endif; ?>

      <div class="new-board-box" style="display:none;">
        <div style="display:block; overflow:hidden; width:100%;">
          <div class="content-block bg special">
            <h3 class="page-header warning-sub-header">CREATE BOARD</h3>
            <form method="post" class="comment-form sm-font" action="<?php echo $base_url; ?>/new-board/<?php echo $board_id; ?>/" enctype="multipart/form-data">

            <textarea  maxlength='300' class="topicheader" id="topicheader" name="topicheader" placeholder="Board Title"></textarea>

            <textarea  maxlength='1500' class="main-comment-box" id="description" name="description" placeholder="Board Description"></textarea>

            <span class="meta">
              <span class="meta-left">
                <input type="checkbox" class="checkbox" id="membersonly" name="membersonly">
                <label class="checkbox-label" for="membersonly">Members Only</label>

                <input type="checkbox" class="checkbox" id="membersonly" name="openstatus">
                <label class="checkbox-label" for="openstatus">Open</label>

                <input type="checkbox" class="checkbox" id="readonlystatus" name="readonlystatus">
                <label class="checkbox-label" for="readonlystatus">Read Only</label>
              </span>
              <span class="meta-right">
                <input class="comment-submit" id="submit" type="submit" value="Create" />
              </span>
            </span>

            </form>

            <script>
              $('#topicheader').on('input', function() {
                var scroll_height = $('#topicheader').get(0).scrollHeight;
                scroll_height = +scroll_height + +1;
                $('#topicheader').css('height', scroll_height + 'px');
              });
              $('#description').on('input', function() {
                var scroll_height = $('#description').get(0).scrollHeight;
                scroll_height = +scroll_height + +1;
                $('#description').css('height', scroll_height + 'px');
              });
            </script>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if ($board_id > 0): ?>
      <div class="meta-nav top">
        <nav class="meta-solo">
          <div class="meta-left">
            <a class="meta-link black bread mobile-full" href="<?php echo $base_url; ?>/boards/"><span class="bread_crumb_link">HOME</span></a>
            <?php
              $board_breadcrumb = $board_parent;

              while ($board_breadcrumb > 0) {
                if($tandc_seen != 2) {
                  $mysqlqueryd="SELECT * FROM boards WHERE id='$board_breadcrumb' AND status='1'";
                }else{
                  $mysqlqueryd="SELECT * FROM boards WHERE id='$board_breadcrumb'";
                }

              $resd=$dbconn->query($mysqlqueryd);
              while($rowd=$resd->fetch_assoc()) {
                $bread_board_id=$rowd['id'];
                $bread_board_parent=$rowd['parent'];
                $bread_board_slug=$rowd['board_slug'];
                $bread_pagetitle=$rowd['board_name'];
             ?>
                <a class="meta-link black bread mobile-full" href="<?php echo $base_url; ?>/boards/<?php echo $bread_board_slug; ?>/"><span class="bread_crumb_link"><?php echo $bread_pagetitle; ?></span></a>
            <?php $board_breadcrumb=$bread_board_parent; } } ?>

            <a class="meta-link black bread mobile-full" href="<?php echo $base_url; ?>/boards/<?php echo $typea; ?>/"><span class="bread_crumb_link"><?php echo $pagetitle; ?></span></a>
          </div>
          <div class="meta-right">
            <?php if ($logged_in_id == 1 && $moderation == 1): ?>
              <div class="meta-link new-board black mobile-full">New Board</div>
            <?php endif; ?>
            <?php if ($logged_in_id > 0 && $open_status == 1 && $read_only_status == 0): ?>
              <div class="meta-link new-topic black mobile-full">New Topic</div>
            <?php endif; ?>
          </div>
        </nav>
      </div>
    <?php endif; ?>

    <?php if ($total_boards>0): ?>
    <div class="content-block bg  board-list">
      <?php
        $board_count=0;
        $res=$dbconn->query($mysqlquery);
        while($row=$res->fetch_assoc()) {
          $board_count=1;
          $post_id=$row['id'];
          $post_order=$row['post_order'];
          $board_name=$row['board_name'];
          $board_slug=$row['board_slug'];
          $parent=$row['parent'];
          $status=$row['status'];
          $description=$row['description'];

          $board_name=$board_name;
          $description=$description;
      ?>
        <a <?php if ($moderation==1) {echo 'data-id="'.$post_id.'"';} ?> href="<?php echo $base_url; ?>/boards/<?php echo $board_slug; ?>/" class="board-index-bar <?php if ($status==0) {echo "m-only";} ?>">
          <strong><?php echo $board_name; ?></strong> <?php echo $description; ?>
        </a>
      <?php } ?>
    </div>
    <?php endif; ?>

    <?php if ($open_status == 1): ?>

      <?php if ($logged_in_id > 0 && $read_only_status == 0): ?>
        <div class="new-topic-box" style="display:none;">
          <div class="content-block bg">
            <h3 class="page-header sub-header">NEW TOPIC</h3>
            <?php include($php_base_directory . '/sections/boards/includes/editor.php'); ?>
          </div>
        </div>

        <script>
          document.addEventListener("DOMContentLoaded", function() {
            $('.new-topic').on('click',function(){
              $('.new-topic-box').slideToggle(500, 'easeOutQuart');
            });
          });
        </script>


      <?php endif; ?>

      <div class="content-block bg">
        <h3 class="page-header sub-header">Board Topics</h3>

        <?php
          if ($view_order == 0) {
            $mysqlquery="SELECT * FROM topics WHERE $hide_shit_sql $swfsql board_id='$board_id' ORDER BY id ASC LIMIT $limit OFFSET $offset";
          } else if ($view_order == 1) {
            $mysqlquery="SELECT * FROM topics WHERE $hide_shit_sql $swfsql board_id='$board_id' ORDER BY id DESC LIMIT $limit OFFSET $offset";
          } else if ($view_order == 2) {
            $mysqlquery="SELECT *, up_votes - down_votes AS rating FROM topics WHERE $hide_shit_sql $swfsql board_id='$board_id' ORDER BY rating DESC LIMIT $limit OFFSET $offset";
          } else {
            $mysqlquery="SELECT * FROM topics WHERE $hide_shit_sql $swfsql board_id='$board_id' ORDER BY id ASC LIMIT $limit OFFSET $offset";
          }

          $res=$dbconn->query($mysqlquery);
          while($row=$res->fetch_assoc()) {
            $topic_id = $row['id'];
            $owner_id = $row['owner_id'];
            $title = $row['title'];
            $content = $row['content'];
            $slug = $row['slug'];
            $status = $row['status'];
            $up_votes = $row['up_votes'];
            $down_votes = $row['down_votes'];
            $last_update_time = $row['last_update_time'];
            $replies = $row['replies'];

            $rating = $up_votes - $down_votes;
            if($rating > 0){$rating='+'.$rating;}
            else if($rating == 0){$rating='-';}

            //get user details
            $mysqlqueryb="SELECT * FROM users WHERE id='$owner_id' ORDER BY id DESC LIMIT 1";
            $resb=$dbconn->query($mysqlqueryb);
            while($rowb=$resb->fetch_assoc()) {
            $owner_name = $rowb['display_name'];
            }
        ?>

          <a href="<?php echo $base_url; ?>/topic/<?php echo $slug; ?>/" class="comment topic-index topic-box-<?php echo $topic_id; ?> border-top">
            <p><?php
            if ($tandc_seen < 2) {
               echo $profanity->filter_string($title);
            } else {
              echo $title;
            }?></p>
            <span class="meta border-top">
              <span class="meta-left">
                <span href="<?php echo $base_url; ?>/profile/<?php echo $owner_id; ?>/" class="meta-link <?php if($owner_id==$logged_in_id){echo "self";} ?>" rel="nofollow">
                <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - <?php echo $owner_name; ?>" /> 
                  <?php echo $owner_name; ?>
                </span>
                <span href="<?php echo $base_url; ?>/profile/<?php echo $owner_id; ?>/" class="meta-link <?php if($owner_id==$logged_in_id){echo "self";} ?>" rel="nofollow">
                  <?php include($php_base_directory . '/styles/images/svgs/clock-icon.svg'); ?>
                  <?php echo gmdate("jS M Y H:i", $last_update_time); ?>
                </span>
              </span>
              <span class="meta-right code-meta-rating-<?php echo $owner_id; ?>">

                <?php if ($replies>0): ?>
                  <span class="meta-link children">
                    <?php include($php_base_directory . '/styles/images/svgs/reply-icon.svg'); ?>
                    <?php echo $replies; ?> <?php if($replies==1){echo "REPLY";}else{echo "REPLIES";} ?>
                  </span>
                <?php endif; ?>

                <span class="meta-link-no-hover topic-rating topic-rating-<?php echo $topic_id; ?>">
                  <?php echo $rating; ?>
                </span>
              </span>
            </span>

          </a>
        <?php } ?>
      </div>

      <div class="content-block">
        <div class="meta-nav">
          <nav class="meta-solo">
            <div class="meta-left"></div>
            <div class="meta-right"><?php include('includes/pagenate.php'); ?></div>
          </nav>
        </div>
      </div>
    <?php endif; ?>


  </main>
  <aside id="sidebar" class="sidebar">
    <?php include($php_base_directory . '/sidebar.php'); ?>
  </aside>
</div>



<script>
<?php if($logged_in_id == 1 && $moderation == 1): ?>
  document.addEventListener("DOMContentLoaded", function() {

    $('.edit-board').on('click',function(){
      $('.edit-board-box').slideToggle(500, 'easeOutQuart');
    })

    var $sortableList = $(".board-list");
    var sortEventHandler = function(event, ui){
    var listElements = $sortableList.children();
    var listValues = [];
    Array.from(listElements).forEach(function(element){
        listValues.push(element.getAttribute("data-id"));
    });
    var the_order = { "the_order": listValues };
      $.ajax({
          url: '<?php echo $base_url; ?>/update-board-order/<?php echo $board_id; ?>/',
          type: 'POST',
          data : the_order,
          success: function(data){
          }
      });
    };
    $sortableList.sortable({
      stop: sortEventHandler
    });
    $sortableList.on("sortchange", sortEventHandler);

  });
<?php endif; ?>
</script>



<?php include($php_base_directory . '/footer.php'); ?>

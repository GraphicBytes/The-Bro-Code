<?php
$pagetitle = "Suggest a Bro Code";
$pagedescription = "Suggest a Bro Code";
$canonical = $base_url . "/code/" . $typea . "/";

$sfw = 2;
include($php_base_directory . '/header.php');
?> 

<div class="container">
  <main class="content">

    <div class="content-block">
      <h1 class="page-header hero">
        <?php echo $pagetitle; ?>
        <span class="hero-link-bg-image" style="background-image:url('<?php echo $static_url; ?>/images/tiles/book-and-pen-large.jpg');"></span>
      </h1>
    </div>

    <div class="content-block top-padding bottom-padding bg">

      <div class="how-it-words">
        <div class="step">
          <p><br /></p>
          <h2>1</h2>
          <p style="font-weight:700;"><br />SUGGEST A CODE<br /><br /></p>
        </div>
        <div class="step">
          <p><br /></p>
          <h2>2</h2>
          <p style="font-weight:700;"><br />MAKE AMENDMENTS<br /><br /></p>
        </div>
        <div class="step last">
          <p><br /></p>
          <h2>3</h2>
          <p style="font-weight:700;"><br />VOTE IT IN<br /><br /></p>
        </div>
      </div>

      <h2 class="center">Try not to take The Bro Code too seriously!<br /><br /></h2>

    </div>

    <div class="content-block bg no-padding special">

      <?php if ($logged_in_id > 0) : ?>
        <form method="post" id="suggest-code-form" class="suggest-code-form" action="<?php echo $base_url; ?>/submit-code-suggestion/" enctype="multipart/form-data">
        <?php endif; ?>

        <div class="text-box-container">
          <textarea maxlength='1500' id="reply-comment-box" class="reply-comment-box <?php if ($logged_in_id < 1) {
                                                                                        echo "main-comment-box";
                                                                                      } ?>" name="code" placeholder="Your Bro Code Suggestion"></textarea>
        </div>

        <?php if ($logged_in_id < 1) : ?>
          <div class="login-prompt promt-overlay"></div>
        <?php endif; ?>

        <span class="meta <?php if ($logged_in_id < 1) {
                            echo "login-prompt";
                          } ?>">
          <span class="meta-left meta-replies">
            <span class="meta-link-no-hover character_count">
              0/1000
            </span>
          </span>

          <span class="meta-right meta-replies-right">
            <div class="reply-submit-container">
              <input class="reply-submit <?php if ($logged_in_id < 1) {
                                            echo "comment-submit";
                                          } ?>" id="submit" type="submit" value="SUBMIT" disabled />
            </div>
          </span>

        </span>

        <?php if ($logged_in_id > 0) : ?>
        </form>
      <?php endif; ?> 
    </div>

  </main>
  <aside id="sidebar" class="sidebar">
    <?php include($php_base_directory . '/sidebar.php'); ?>
  </aside>
</div>
 
<script>
  document.addEventListener('DOMContentLoaded', function() { 
    $('#reply-comment-box').on('input', function() {

      var scroll_height = $('#reply-comment-box').get(0).scrollHeight;
      $('#reply-comment-box').css('height', scroll_height + 'px');
      
      minlength = 5;
      var maxlength = 1000;
      var currentLength = $('#reply-comment-box').val().length;
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

<?php
include($php_base_directory . '/footer.php');
?>
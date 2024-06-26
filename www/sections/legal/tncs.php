<?php
$pagetitle = "Please Review Our Terms &amp; Conditions | The Bro Code";
$pagedescription = "Please Review Our Terms &amp; Conditions";
$sfw = 1;
$legal_css = 1;
$jqueryvisible = 1;
$mainmenu = 0;
$home_body_css = 1;
include($php_base_directory . '/header.php');
?>

<div class="full-page-flex">


  <div class="legal-container">
    <h1 class="tnc-header">PLEASE REVIEW OUR TERMS AND CONDITIONS</h1>

    <div class="legal-content">
      <p>Let’s keep this short. To unlock all content available on this website and to unlock features that allow you to submit content, please review the following T&Cs.</p>

      <h2>What are we trying to build here:</h2>

      <p>For our more mature users who have agreed to these terms and conditions, we want to offer a more relaxed filter in comparison to mainstream social media. Our only rules are to not break the law or be unnecessarily abusive. This is a platform that will allow the content other platforms now censor. </p>

      <p>We also want The Bro Code to have a workplace friendly side to it, and something suitable for younger Bros. This means the mature content submitted to this website will only be available to other members who have agreed to these terms and conditions.</p>

      <p><strong>You may find the members-only content on this website upsetting. If you are easily upset, offended or in a fragile state of mind, some content may cause you distress and we strongly recommend that you do not become a member of this website. Unless a law has been broken complaints will be ignored. If you don’t like it, don’t look at it.</strong></p>


      <h2>So, with that in mind:</h2>

      <p><strong>You must be aged 18 or over to sign up and unlock all the features and content available on brocode.org. </strong></p>

      <p>All views and opinions you express on brocode.org are your own. Brocode.org and its operators do not endorse or support the views and opinions shared by users unless explicitly stated otherwise.</p>

      <p>We use the content submitted by our users on brocode.org related social media accounts.</p>

      <p>If a user breaks the law with their use of this website we will remove that content without notice and their account could be permanantly banned.</p>

      <p>Content is moderated at the site operator’s discretion; we do not publish guidelines on what we consider “safe for work” and “not safe for work”.</p>

      <p>The content you post and download to and from this website may be subject to legal restrictions in the country you reside in.</p>

      <p><u>IT IS YOUR RESPONSIBILTY TO KNOW AND UNDERSTAND ANY LEGAL RESTRICTIONS THAT APPLY TO YOU!</u></p>

      <p>We do not and will not share the data directly collected buy our servers unless required to do so by law.</p>

      <p><strong>By accepting, you agree to the terms and practices explained above. You can change your choice at any time in your user profile settings.</strong></p>

      <div class="anchor-spacer"></div>
      <div class="anchor"></div>

    </div>

    <div class="legal-options">

      <a class="red button legal-options-item" style="width:20%!important;" href="<?php echo $base_url; ?>/logout/">I DECLINE</a>

      <form class="legal-options-item" style="width:40%!important;" method="post" id="sfw" name="sfw" action="<?php echo $base_url; ?>/tncresponse/" enctype="multipart/form-data">
        <input type="hidden" name="choice" value="1">
        <input class="blue button" type="submit" value="ACCEPT BUT KEEP SFW ON" />
      </form>

      <form class="legal-options-item" style="width:40%!important;" method="post" id="accept" name="accept" action="<?php echo $base_url; ?>/tncresponse/" enctype="multipart/form-data">
        <input type="hidden" name="choice" value="2">
        <input class="green button" type="submit" value="I ACCEPT THESE T&amp;Cs" />
      </form>


      <div class="legal_block"></div>
    </div>

  </div>


  <script>
    document.addEventListener('DOMContentLoaded', function() { 

      $('.blue').click(function() {
        event.preventDefault();

        $.ajax({
          url: $('#sfw').attr('action'),
          type: 'POST',
          data: $('#sfw').serialize(),
          success: function(data) {
            location.reload();
          }
        });
        return false;
      });

    });

    document.addEventListener('DOMContentLoaded', function() { 

      $('.green').click(function() {
        event.preventDefault();

        $.ajax({
          url: $('#accept').attr('action'),
          type: 'POST',
          data: $('#accept').serialize(),
          success: function(data) {
            <?php if ($tnc_bounce = 2) { ?>
              window.location.replace("<?php echo $base_url; ?>");
            <?php } else { ?>
              location.reload();
            <?php } ?>
          }
        });
        return false;
      });

    });

    document.addEventListener('DOMContentLoaded', function() { 

      $(".legal-content").scroll(function() {
        if ($('.anchor').visible()) {
          $('.legal-options').addClass('seen');
        }
      });

    });
  </script>


</div>

<?php
include($php_base_directory . '/footer.php');
?>
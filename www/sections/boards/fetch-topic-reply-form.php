<?php
//sleep(2);

$topic_id = $typea;
$reply_id = $typeb;
ob_start();
?>

<div class="comment child reply-form-container-<?php echo $reply_id; ?>" style="display:none;">

  <div class="loading alt reply-loading-<?php echo $reply_id; ?>">
    <?php include($php_base_directory . '/includes/loading-alt.php'); ?>
  </div>

<form method="post" class="reply-form reply-form-<?php echo $reply_id; ?>" action="<?php echo $base_url; ?>/replyto-topic-comment/<?php echo $topic_id; ?>/<?php echo $reply_id; ?>/" enctype="multipart/form-data">
  <textarea  maxlength='1500' class="reply-comment-box reply-comment-box-<?php echo $reply_id; ?>" id="reply-<?php echo $reply_id; ?>" name="reply" placeholder="Reply to this comment!"></textarea>

  <span class="meta border-top">

  <span class="meta-left">
    <span class="meta-link-no-hover character_count-<?php echo $reply_id; ?>">
      0/1000
    </span>
  </span>

  <span class="meta-right">
    <input class="reply-submit reply-submit-<?php echo $reply_id; ?>" id="submit-<?php echo $reply_id; ?>" type="submit" value="REPLY" disabled />
  </span>

  </span>

</form>
</div>


<script>
document.addEventListener("DOMContentLoaded", function() {
  $('.reply-submit-<?php echo $reply_id; ?>').click( function() {
      event.preventDefault();
      $(".reply-loading-<?php echo $reply_id; ?>").addClass("active");
      $.ajax({
            url: $('.reply-form-<?php echo $reply_id; ?>').attr('action'),
            type: 'POST',
            data : $('.reply-form-<?php echo $reply_id; ?>').serialize(),
            success: function(data){

              var obj = JSON.parse(data);
              var response_code = obj['response'];
              var newhtml = obj['html'];

              if(response_code==0){
                $(".reply-loading-<?php echo $reply_id; ?>").removeClass("active");
              }
              if(response_code==1){
                $(".reply-comment-box-<?php echo $reply_id; ?>").val("");

                $( ".children-container-<?php echo $reply_id; ?>" ).append(newhtml);

                $('html, body').animate({scrollTop: $(".goto-anchor-<?php echo $reply_id; ?>").offset().top-350},{ duration:1000, easing:"easeOutQuint"});

                $( ".reply-form-<?php echo $reply_id; ?>" ).replaceWith("");
                $( ".reply-spacer-<?php echo $reply_id; ?>" ).replaceWith("");

                $(".reply-loading-<?php echo $reply_id; ?>").removeClass("active");
              }

            }
          });
          return false;
  });

  $('#reply-<?php echo $reply_id; ?>').on('input', function() {
    var scroll_height = $('#reply-<?php echo $reply_id; ?>').get(0).scrollHeight;
    $('#reply-<?php echo $reply_id; ?>').css('height', scroll_height + 'px');

    minlength = 5;
    var maxlength = 1000;
    var currentLength = $('#reply-<?php echo $reply_id; ?>').val().length;
    var newcount = currentLength + "/" + maxlength;
    $('.character_count-<?php echo $reply_id; ?>').html(newcount);

    if(currentLength < 5){
      $('#submit').attr("disabled", true);
    }
    else if(currentLength > maxlength){
      $('.character_count-<?php echo $reply_id; ?>').addClass('warning');
      $('#submit-<?php echo $reply_id; ?>').attr("disabled", true);
    } else {
      $('.character_count-<?php echo $reply_id; ?>').removeClass('warning');
      $('#submit-<?php echo $reply_id; ?>').attr("disabled", false);
    }

  });
});
</script>



<?php

$html = ob_get_contents();
ob_end_clean();

$return_arr = array("response" => 1, "html"=> $html);
echo json_encode($return_arr);


 ?>

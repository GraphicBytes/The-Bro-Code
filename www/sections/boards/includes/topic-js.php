<script>
$( document ).ready(function() {
<?php if ($logged_in_id > 0): ?>

  <?php if ($logged_in_id == 1): ?>

      $('.mod-link-delete').click(function(){
        var stage = $(this).attr('data-level');
        var comment_id = $(this).attr('data-id');
        var owner = $(this).attr('owner-id');
        mod_delete(stage,comment_id,owner)
      });

      function mod_delete(val,val2,val3){
        var remove_box = ".comment-box-"+val2;
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
              success: function(response){
                var status = response.status;
                if(status == 1){
                  var ids = response.ids;

                  $.each(ids,function(index, value){

                    var remove_mod_bar = ".moderation-bar-"+value;
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
          $(button_id).attr('data-level','3');
        }
        if (stage == 1) {
          $(button_id).addClass('level-2');
          $(button_id).attr('data-level','2');
        }

      }


      $('.mod-link-warning').click(function(){
        var stage = $(this).attr('data-level');
        var owner = $(this).attr('owner-id');
        var id = $(this).attr('data-id');
        mod_warn(stage,id,owner)
      });

      function mod_warn(val,val2,val3){
        var remove_box = ".comment-box-"+val2;
        var button_id = ".mod-link-warning-" + val2;

        var stage = val;
        var comment_id = val2;
        var owner = val3;

        theurl = "<?php echo $base_url; ?>/moderate-topic-comment-warn/" + comment_id + "/" + owner + "/";

        if (stage == 3) {
          $.ajax({
              url: theurl,
              type: 'get',
              contentType: false,
              processData: false,
              dataType: 'json',
              success: function(response){
                var status = response.status;
                if(status == 1){
                  var ids = response.ids;

                  $.each(ids,function(index, value){

                    var remove_mod_bar = ".moderation-bar-"+value;
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
          $(button_id).attr('data-level','3');
        }
        if (stage == 1) {
          $(button_id).addClass('level-2');
          $(button_id).attr('data-level','2');
        }
      }



      $('.mod-link-ban').click(function(){
        var stage = $(this).attr('data-level');
        var comment_id = $(this).attr('data-id');
        var owner = $(this).attr('owner-id');
        mod_ban(stage,comment_id,owner)
      });

      function mod_ban(val,val2,val3){
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
          $(button_id).attr('data-level','3');
        }
        if (stage == 1) {
          $(button_id).addClass('level-2');
          $(button_id).attr('data-level','2');
        }

      }

  <?php endif; ?>
















  document.addEventListener("DOMContentLoaded", function() {
    $('.comment-submit').click( function() {
        event.preventDefault();
        $(".comment-loading").addClass("active");

        $.ajax({
              url: $('.comment-form').attr('action'),
              type: 'POST',
              data : $('.comment-form').serialize(),
              success: function(data){

                var obj = JSON.parse(data);
                var response_code = obj['response'];
                var newhtml = obj['html'];

                if(response_code==0){

                  $(".comment-loading").removeClass("active");
                }
                if(response_code==1){
                  $(".main-comment-box").val("");
                  $( ".ghost" ).replaceWith(newhtml);
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

      if(currentLength < 5){
        $('#submit').attr("disabled", true);
      }
      else if(currentLength > maxlength){
        $('.character_count').addClass('warning');
        $('#submit').attr("disabled", true);
      } else {
        $('.character_count').removeClass('warning');
        $('#submit').attr("disabled", false);
      }

    });

  });












    <?php if ($topic_poll == 1): ?>

      $('.poll-option-bar').on('click', function(){

        $('.poll-loading').addClass('active');

        var choice_id = $(this).attr('data-id');
        var choice_id_bar = ".poll-option-bar-" + choice_id;
        var choice_count = ".poll-option-count-" + choice_id;

        var theurl = "<?php echo $base_url ?>/poll-vote/<?php echo $topic_id; ?>/" + choice_id + "/";

        $('.chosen').removeClass('chosen');
        $('.just-chosen').removeClass('just-chosen');

        $.ajax({
            url: theurl,
            type: 'get',
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response){

              var status = response.response;
              var updated_total = response.updated_total;
              var already_voted = response.already_voted;
              var old_id = ".poll-option-count-" + response.old_id;
              var old_new_value = response.old_new_value;

              if(status==1){
                $(choice_id_bar).addClass('chosen');
                $(choice_id_bar).addClass('just-chosen');
                $(old_id).html(old_new_value);
                $(choice_count).html(updated_total);

                $('.poll-loading').removeClass('active');
              }
            },
            error: function(request, error){
             
            }
        });

      });
    <?php endif; ?>



  <?php endif; ?>






  <?php if ($topic_gallery == 1): ?>
  function prev_gallary_slide(){
    if (!$('.gallery-image-screen').hasClass('changing')) {

      var current_image_id = $('.gallery-image-screen').attr('data-current-id');
      if (current_image_id != 1) {
        var prev_id = current_image_id - 1;
        var next_id = +current_image_id;
        var prev_thumb = '.topic-gallery-item_' + prev_id;
        var next_thumb = '.topic-gallery-item_' + next_id;

        $('.thumb_selected').removeClass('thumb_selected');
        $(prev_thumb).addClass('thumb_selected');

        var id = $(prev_thumb).attr('data-id');
        var url = $(prev_thumb).attr('data-url');
        var width = $(prev_thumb).attr('data-width');
        var height = $(prev_thumb).attr('data-height');

        var ratio = (height/width);
        var parent_width = $('.topic-block').width();

        if (width > parent_width) {
          var new_height = parent_width*ratio;
          new_height = Math.floor(new_height);
        } else {
          new_height = height;
        }

        $('.gallery-image').addClass('hiding');
        $('.gallery-image-screen').addClass('changing');
        $('.gallery-image-screen-image-container').css('height', new_height + 'px');

        setTimeout(function(){

          if ($(next_thumb).length) {
            $('.gallery-right-nav').addClass('needed');
          } else {
            $('.gallery-right-nav').removeClass('needed');
          }

          if(id == 1){
            $('.gallery-left-nav').removeClass('needed');
          } else {
            $('.gallery-left-nav').addClass('needed');
          }

          html = '<img class="gallery-image hiding" src="' + url + '" style="max-width:'+ width +'px;" >';
          $('.gallery-image-screen-image-container').html(html);
          $('.gallery-image-screen').attr('data-current-id', id);

          setTimeout(function(){
            $('.gallery-image').removeClass('hiding');
            $('.gallery-image-screen').removeClass('changing');
          },10);

        },510);

      }

    }
  }


  function next_gallary_slide(){
    if (!$('.gallery-image-screen').hasClass('changing')) {

      var current_image_id = $('.gallery-image-screen').attr('data-current-id');
        var prev_id = current_image_id;
        var next_id = +current_image_id +1;
        var next_next_id = +current_image_id +2;
        var prev_thumb = '.topic-gallery-item_' + prev_id;
        var next_thumb = '.topic-gallery-item_' + next_id;
        var next_next_thumb = '.topic-gallery-item_' + next_next_id;

        $('.thumb_selected').removeClass('thumb_selected');
        $(next_thumb).addClass('thumb_selected');

        var id = $(next_thumb).attr('data-id');
        var url = $(next_thumb).attr('data-url');
        var width = $(next_thumb).attr('data-width');
        var height = $(next_thumb).attr('data-height');

        var ratio = (height/width);
        var parent_width = $('.topic-block').width();

        if (width > parent_width) {
          var new_height = parent_width*ratio;
          new_height = Math.floor(new_height);
        } else {
          new_height = height;
        }

        $('.gallery-image').addClass('hiding');
        $('.gallery-image-screen').addClass('changing');
        $('.gallery-image-screen-image-container').css('height', new_height + 'px');

        setTimeout(function(){
          if ($(next_next_thumb).length) {
            $('.gallery-right-nav').addClass('needed');
          } else {
            $('.gallery-right-nav').removeClass('needed');
          }

          $('.gallery-left-nav').addClass('needed');

          html = '<img class="gallery-image hiding" src="' + url + '" style="max-width:'+ width +'px;" >';
          $('.gallery-image-screen-image-container').html(html);

          $('.gallery-image-screen').attr('data-current-id', id);

          setTimeout(function(){
            $('.gallery-image').removeClass('hiding');
            $('.gallery-image-screen').removeClass('changing');
          },10);

        },510);

      }
  }


  $('.gallery-left-nav').on('click', function(){
    prev_gallary_slide();
  });

  $('.gallery-right-nav').on('click', function(){
    next_gallary_slide();
  });

  $(document).keydown(function(e){
      switch (e.which){
      case 37:    //left arrow key
          if($('.gallery-left-nav').hasClass('needed')){
            prev_gallary_slide();
          }
          break;
      case 39:    //right arrow key
          if($('.gallery-right-nav').hasClass('needed')){
            next_gallary_slide();
          }
          break;
      }
  });

  $(document).on('swipeleft', 'body', function(event){
    if($('.gallery-left-nav').hasClass('needed')){
      prev_gallary_slide();
    }
    return false;
  });

  $(document).on('swiperight', 'body', function(event){
    if($('.gallery-right-nav').hasClass('needed')){
      next_gallary_slide();
    }
    return false;
  });

  $('.topic-gallery-item').on('click', function(){

    if (!$('.gallery-image-screen').hasClass('changing')) {

      if(!$(this).hasClass('thumb_selected')){

        $('.thumb_selected').removeClass('thumb_selected');
        $(this).addClass('thumb_selected');

        var id = $(this).attr('data-id');
        var url = $(this).attr('data-url');
        var width = $(this).attr('data-width');
        var height = $(this).attr('data-height');

        var prev_id = id - 1;
        var next_id = +id + 1;
        var prev_thumb = '.topic-gallery-item_' + prev_id;
        var next_thumb = '.topic-gallery-item_' + next_id;

        var ratio = (height/width);
        var parent_width = $('.topic-block').width();

        if (width > parent_width) {
          var new_height = parent_width*ratio;
          new_height = Math.floor(new_height);
        } else {
          new_height = height;
        }

          if(id == 1){
            $('.gallery-left-nav').removeClass('needed')
          } else {
            $('.gallery-left-nav').addClass('needed')
          }

          if ($('.gallery-image-screen').hasClass('open')) {

            $('.gallery-image').addClass('hiding');
            $('.gallery-image-screen').addClass('changing');
            html = '<img class="gallery-image hiding" src="' + url + '" style="max-width:'+ width +'px;" >';
            $('.gallery-image-screen-image-container').html(html);
            $('.gallery-image-screen-image-container').css('height', new_height + 'px');

            $('.gallery-image-screen').attr('data-current-id', id);

            setTimeout(function () {
              new_pos = $("#gallery-image-screen").offset().top - 140;

                  $('html, body').animate({
                      scrollTop: new_pos
                  }, {
                      duration: 350,
                      easing: "easeOutCubic",
                      complete: function() {

                        $('.gallery-image').removeClass('hiding');
                        $('.gallery-image-screen').removeClass('changing');

                        if(id == 1){
                          $('.gallery-left-nav').removeClass('needed')
                        } else {
                          $('.gallery-left-nav').addClass('needed')
                        }

                        if ($(next_thumb).length) {
                          $('.gallery-right-nav').addClass('needed');
                        } else {
                          $('.gallery-right-nav').removeClass('needed');
                        }

                        $('.gallery-image-screen').attr('data-current-id', id);

                      }
                  });

            });

          } else {

            html = '<img class="gallery-image hiding" src="' + url + '" style="max-width:'+ width +'px;" >';
            $('.gallery-image-screen-image-container').html(html);
            $('.gallery-image-screen-image-container').css('height', new_height + 'px');

            $('.gallery-image-screen').attr('data-current-id', id);

            setTimeout(function () {
              $('.gallery-image-screen').addClass('open');
              $('.gallery-image-screen').slideDown(350, 'easeOutCubic',function(){

                  if(id == 1){
                    $('.gallery-left-nav').removeClass('needed')
                  } else {
                    $('.gallery-left-nav').addClass('needed')
                  }
                  if ($(next_thumb).length) {
                    $('.gallery-right-nav').addClass('needed');
                  } else {
                    $('.gallery-right-nav').removeClass('needed');
                  }


                  new_pos = $("#gallery-image-screen").offset().top - 140;

                  $('html, body').animate({
                      scrollTop: new_pos
                  }, {
                      duration: 350,
                      easing: "easeOutCubic",
                      complete: function() {

                        $('.gallery-image').removeClass('hiding');
                        $('.gallery-image-screen').removeClass('changing');

                      }
                  });

              });
            }, 100);

          }
        }
      }
  });
  <?php endif; ?>

});
</script>

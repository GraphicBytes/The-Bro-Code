<?php if ($logged_in_id == 1 && $moderation == 1) : ?><script>
    //moderator specific js

    function moderate_variant(id, owner_id, decision, topbar) {
      var theurl = "<?php echo $base_url ?>/moderate-code-variant/" + id + "/" + decision + "/" + owner_id + "/";

      $.ajax({
        url: theurl,
        type: 'get',
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          var status = response.status;
          var id = response.id;
          var leftovers = response.leftovers;
          var rating = response.rating;
          var do_refresh = response.refresh_page;
          var mod_bar = ".moderation-variant-bar-" + id;
          var mod_link_sfw = ".mod-link-acceptable-" + id;
          var to_delete = ".variant-box-" + id;
          var to_delete_b = ".moderation-variant-bar-" + id;

          if (do_refresh == 1) {

            location.reload();

          } else if (status == 1) {
            $(mod_bar).removeClass('warning');

            if (rating == 0) {
              $(mod_link_sfw).addClass('current');
            } else {

              if (leftovers == 0) {
                window.location.assign("<?php echo $base_url; ?>/code-suggestions/");
              }
              if (leftovers == 1) {

                if (topbar == 1) {
                  location.reload();
                } else {
                  $(to_delete).remove();
                  $(to_delete_b).remove();
                }

              }

            }
          }
        }
      });
    };

    document.addEventListener('DOMContentLoaded', function() {
      $('.mod-variant-link').click(function() {
        var comment_id = $(this).attr('data-id');
        var comment_rating = $(this).attr('data-rating');
        var owner_id = $(this).attr('owner-id');
        var topbar = $(this).attr('data-topbar');
        moderate_variant(comment_id, owner_id, comment_rating, topbar);
      });

      $('.mod-variant-warning').click(function() {
        var stage = $(this).attr('data-level');
        var owner = $(this).attr('owner-id');
        var id = $(this).attr('data-id');
        var topbar = $(this).attr('data-topbar');
        mod_variant_warn(stage, id, owner, topbar);
      });
    });

    function mod_variant_warn(val, val2, val3, topbar) {
      var remove_box = ".variant-box-" + val2;
      var button_id = ".mod-variant-warning-" + val2;

      var stage = val;
      var variant_id = val2;
      var owner = val3;

      theurl = "<?php echo $base_url; ?>/moderate-variant-warn/" + variant_id + "/" + owner + "/";

      if (stage == 3) {

        $.ajax({
          url: theurl,
          type: 'get',
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {

            var status = response.status;
            var id = response.id;
            var leftovers = response.leftovers;
            var rating = response.rating;

            var mod_bar = ".moderation-variant-bar-" + id;
            var mod_link_sfw = ".mod-link-acceptable-" + id;
            var to_delete = ".variant-box-" + id;
            var to_delete_b = ".moderation-variant-bar-" + id;

            if (status == 1) {
              $(mod_bar).removeClass('warning');

              if (rating == 0) {
                $(mod_link_sfw).addClass('current');
              } else {

                if (leftovers == 0) {
                  window.location.assign("<?php echo $base_url; ?>/code-suggestions/");
                }
                if (leftovers == 1) {

                  if (topbar == 1) {
                    location.reload();
                  } else {
                    $(to_delete).remove();
                    $(to_delete_b).remove();
                  }

                }

              }
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

      theurl = "<?php echo $base_url; ?>/moderate-variant-comment-delete/" + comment_id + "/" + owner + "/";

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
        mod_warn(stage, id, owner);
      });
    });

    function mod_warn(val, val2, val3) {
      var remove_box = ".comment-box-" + val2;
      var button_id = ".mod-link-warning-" + val2;

      var stage = val;
      var comment_id = val2;
      var owner = val3;

      theurl = "<?php echo $base_url; ?>/moderate-variant-comment-warn/" + comment_id + "/" + owner + "/";

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
        var topbar = $(this).attr('data-topbar');
        mod_ban(stage, comment_id, owner, topbar)
      });
    });

    function mod_ban(val, val2, val3, topbar) {
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


    function moderate_comment(id, decision) {
      var theurl = "<?php echo $base_url ?>/moderate-code-variant-comment/" + id + "/" + decision + "/";
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
  </script>


  <?php endif; ?><?php if ($logged_in_id > 0) : ?><script>
    // member specific js

    document.addEventListener('DOMContentLoaded', function() {
      $('.delete-variant').click(function() {
        var variant_id = $(this).attr("data-id");
        var spot = $(this).attr("data-spot");
        delete_variant(variant_id, spot);
      });
    });

    function delete_variant(val, spot) {
      var are_you_sure_id = ".variant_are-you-sure-" + val;
      var confirm_delete_id = ".confirm-variant-delete-" + val;
      $(are_you_sure_id).addClass('asking');

      $(confirm_delete_id).attr("data-spot", spot);
    }

    function cancel_delete_variant(val) {
      var are_you_sure_id = ".variant_are-you-sure-" + val;
      $(are_you_sure_id).removeClass('asking');
    }

    function confirm_delete_variant(val, spot) {
      var question_id = ".delete-variant-question-" + val;
      var loading_id = ".variant-loading-" + val;
      var are_you_sure_id = ".variant_are-you-sure-" + val;

      var spot = $(are_you_sure_id).attr('data-spot');

      $(question_id).addClass('thinking');
      $(loading_id).addClass('active');

      theurl = "<?php echo $base_url; ?>/delete-code-variant/" + val + "/";

      $.ajax({
        url: theurl,
        type: 'get',
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {

          var status = response.status;
          var ids = response.ids;
          var other_children = response.other_children;

          if (status == 0) {
            $(question_id).removeClass('thinking');
            $(loading_id).removeClass('active');
            $(are_you_sure_id).removeClass('asking');
          }
          if (status == 1) {

            if (spot == 1) {
              location.reload();
            } else {
              if (other_children == 0) {
                window.location.href = '<?php echo $base_url; ?>/code-suggestions/';
              } else {
                $.each(ids, function(index, value) {
                  remove_variant(value);
                });
              }
            }

          }
        }
      });

    }





    function remove_variant(val) {
      var variant_to_delete = ".variant-box-" + val;

      var children_to_delete = ".children-" + val;
      var reply_form_to_delete = ".reply-form-" + val;
      var children_container_to_delete = ".children-container-" + val;
      $(variant_to_delete).remove();
      $(reply_form_to_delete).slideUp('1000', "easeOutQuint", function() {});
      $(children_container_to_delete).remove();
      $(children_to_delete).remove();
    }


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
              //$('html, body').animate({scrollTop: $(".number").offset().top},{ duration:1000, easing:"easeOutQuint"});
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



      $('.variant-submit').click(function() {
        event.preventDefault();
        $(".variant-loading").addClass("active");

        $.ajax({
          url: $('.variant-form').attr('action'),
          type: 'POST',
          data: $('.variant-form').serialize(),
          success: function(data) {

            var obj = JSON.parse(data);
            var response_code = obj['response'];
            var newhtml = obj['html'];

            if (response_code == 0) {

              $(".variant-loading").removeClass("active");
            }
            if (response_code == 1) {
              $(".variant-form").remove();
              $(".main-variant-box").val("");
              $(".variant_ghost").replaceWith(newhtml);
              $('html, body').animate({
                scrollTop: $(".brand-new").offset().top - 200
              }, {
                duration: 1000,
                easing: "easeOutQuint"
              });
              $(".variant-loading").removeClass("active");
            }

          }
        });
        return false;
      });

      $('#variant').on('input', function() {
        var scroll_height = $('#variant').get(0).scrollHeight;
        scroll_height = +scroll_height + +1;
        $('#variant').css('height', scroll_height + 'px');

        minlength = 5;
        var maxlength = 1000;
        var currentLength = $('#variant').val().length;
        var newcount = currentLength + "/" + maxlength;
        $('.variant_char_count').html(newcount);

        if (currentLength < 5) {
          $('#submitvariant').attr("disabled", true);
        } else if (currentLength > maxlength) {
          $('.variant_char_count').addClass('warning');
          $('#submitvariant').attr("disabled", true);
        } else {
          $('.variant_char_count').removeClass('warning');
          $('#submitvariant').attr("disabled", false);
        }

      });



      $('.code-down').click(function() {

        var code_id = $(this).attr('data-id');
        var code_up = ".code-up-" + code_id;
        var target = ".code-down-" + code_id;
        var rating_meta_id = ".code-meta-rating-" + code_id;
        var code_rating = ".code-rating-" + code_id;

        if ($(target).hasClass("on")) {
          var theurl = "<?php echo $base_url ?>/rate-variant/" + code_id + "/2/";
        } else {
          var theurl = "<?php echo $base_url ?>/rate-variant/" + code_id + "/0/";
        }

        $(rating_meta_id).addClass("blocked");
        $.ajax({
          url: theurl,
          type: 'get',
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {

            var new_rating = response.rating;
            $(code_rating).html(new_rating);

            if ($(target).hasClass("on")) {
              $(target).removeClass("on");
              $(rating_meta_id).removeClass("blocked");
            } else {
              $(target).addClass("on");
              $(code_up).removeClass("on");
              $(rating_meta_id).removeClass("blocked");
            }

          }
        });

      });

      $('.code-up').click(function() {

        var code_id = $(this).attr('data-id');
        var code_down = ".code-down-" + code_id;
        var target = ".code-up-" + code_id;
        var rating_meta_id = ".code-meta-rating-" + code_id;
        var code_rating = ".code-rating-" + code_id;

        if ($(target).hasClass("on")) {
          var theurl = "<?php echo $base_url ?>/rate-variant/" + code_id + "/2/";
        } else {
          var theurl = "<?php echo $base_url ?>/rate-variant/" + code_id + "/1/";
        }

        $(rating_meta_id).addClass("blocked");
        $.ajax({
          url: theurl,
          type: 'get',
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {

            var new_rating = response.rating;
            $(code_rating).html(new_rating);

            if ($(target).hasClass("on")) {
              $(target).removeClass("on");
              $(rating_meta_id).removeClass("blocked");
            } else {
              $(code_down).removeClass("on");
              $(target).addClass("on");
              $(rating_meta_id).removeClass("blocked");
            }
          }
        });

      });

    });



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

      theurl = "<?php echo $base_url; ?>/delete-code-variant-comment/" + val + "/";

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

      var theurl = "<?php echo $base_url ?>/fetch-variant-reply-form/" + <?php echo $code_id ?> + "/" + sceneario_id + "/";

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
        var theurl = "<?php echo $base_url ?>/rate-code-variant-comment/" + comment_id + "/2/";
      } else {
        var theurl = "<?php echo $base_url ?>/rate-code-variant-comment/" + comment_id + "/0/";
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
        var theurl = "<?php echo $base_url ?>/rate-code-variant-comment/" + comment_id + "/2/";
      } else {
        var theurl = "<?php echo $base_url ?>/rate-code-variant-comment/" + comment_id + "/1/";
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









  <?php endif; ?><?php if ($logged_in_id < 1) : ?><script>
    //logged out specific js
  </script>










<?php endif; ?><script>
  //global js

  function fetch_next_comments(val, val2, val3) {
    var theurl = "<?php echo $base_url ?>/fetch-next-variant-comment-chunk/" + val + "/" + val2 + "/";
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


  function fetch_children(val) {
    var children_id = val;
    var children_to_trigger = ".children-" + children_id;
    var children_button = ".children-button-" + children_id;
    var loading_id = ".comment-loading-" + children_id;
    var theurl = "<?php echo $base_url; ?>/fetch-variant-comment-children/<?php echo $code_id; ?>/" + children_id + "/";

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
    var theurl = "<?php echo $base_url; ?>/fetch-variant-comment-infants/<?php echo $code_id; ?>/" + infant_id + "/";

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
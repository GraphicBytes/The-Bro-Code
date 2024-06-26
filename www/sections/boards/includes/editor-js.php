<script>
$("#new-topic-form").submit(function(e){
  e.preventDefault();

    $('.topic-submit-loading').addClass('active');

    var formData = new FormData();

    //members only
    if ($('#membersonly').prop('checked')) {
      formData.append('membersonly', 1);
    }else{
      formData.append('membersonly', 0);
    }

    //topic header
    topicheader = $('#newtopicheader').val();
    formData.append('newtopicheader', topicheader);

    //video
    if ($('#video').prop('checked')) {
      formData.append('video', 1);
      var video_type = $('#video_type').val();
      var video_id = $('#video_id').val();
      formData.append('video_type', video_type);
      formData.append('video_id', video_id);
    }else{
      formData.append('video', 0);
    }

    //image gallery
    if ($('#imagegallery').prop('checked')) {
      formData.append('imagegallery', 1);
      var images = {};
      gallery_item_count = 1;
      $('.gallery-preview').children().each((index, element) => {
        gallery_item_name = 'gallery_item_' + gallery_item_count;
        gallery_item_name_id = $(element).attr('data-id');

        gallery_item_type_name = 'gallery_item_type_name_' + gallery_item_count;
        gallery_item_type = $(element).attr('data-type');

        formData.append(gallery_item_type_name, gallery_item_type);
        formData.append(gallery_item_name, gallery_item_name_id);
        gallery_item_count = +gallery_item_count + 1;
      });
    }else{
      formData.append('imagegallery', 0);
    }

    //content
    var new_topic_content = $('#new-topic-content').val();
    formData.append('new_topic_content', new_topic_content);

    //POLL
    if ($('#poll').prop('checked')) {
      formData.append('poll', 1);

      if (document.getElementById("poll_option_1")) {
        poll_option_1 = $('#poll_option_1').val();
        formData.append('poll_option_1', poll_option_1);
      }
      if (document.getElementById("poll_option_2")) {
        poll_option_2 = $('#poll_option_2').val();
        formData.append('poll_option_2', poll_option_2);
      }
      if (document.getElementById("poll_option_3")) {
        poll_option_3 = $('#poll_option_3').val();
        formData.append('poll_option_3', poll_option_3);
      }
      if (document.getElementById("poll_option_4")) {
        poll_option_4 = $('#poll_option_4').val();
        formData.append('poll_option_4', poll_option_4);
      }
      if (document.getElementById("poll_option_5")) {
        poll_option_5 = $('#poll_option_5').val();
        formData.append('poll_option_5', poll_option_5);
      }
      if (document.getElementById("poll_option_6")) {
        poll_option_6 = $('#poll_option_6').val();
        formData.append('poll_option_6', poll_option_6);
      }
      if (document.getElementById("poll_option_7")) {
        poll_option_7 = $('#poll_option_7').val();
        formData.append('poll_option_7', poll_option_7);
      }
      if (document.getElementById("poll_option_8")) {
        poll_option_8 = $('#poll_option_8').val();
        formData.append('poll_option_8', poll_option_8);
      }
      if (document.getElementById("poll_option_9")) {
        poll_option_9 = $('#poll_option_9').val();
        formData.append('poll_option_9', poll_option_9);
      }
      if (document.getElementById("poll_option_10")) {
        poll_option_10 = $('#poll_option_10').val();
        formData.append('poll_option_10', poll_option_10);
      }
      if (document.getElementById("poll_option_11")) {
        poll_option_11 = $('#poll_option_11').val();
        formData.append('poll_option_11', poll_option_11);
      }
      if (document.getElementById("poll_option_12")) {
        poll_option_12 = $('#poll_option_12').val();
        formData.append('poll_option_12', poll_option_12);
      }
      if (document.getElementById("poll_option_13")) {
        poll_option_13 = $('#poll_option_13').val();
        formData.append('poll_option_13', poll_option_13);
      }
      if (document.getElementById("poll_option_14")) {
        poll_option_14 = $('#poll_option_14').val();
        formData.append('poll_option_14', poll_option_14);
      }
      if (document.getElementById("poll_option_15")) {
        poll_option_15 = $('#poll_option_15').val();
        formData.append('poll_option_15', poll_option_15);
      }
      if (document.getElementById("poll_option_16")) {
        poll_option_16 = $('#poll_option_16').val();
        formData.append('poll_option_16', poll_option_16);
      }
      if (document.getElementById("poll_option_17")) {
        poll_option_17 = $('#poll_option_17').val();
        formData.append('poll_option_17', poll_option_17);
      }
      if (document.getElementById("poll_option_18")) {
        poll_option_18 = $('#poll_option_18').val();
        formData.append('poll_option_18', poll_option_18);
      }
      if (document.getElementById("poll_option_19")) {
        poll_option_19 = $('#poll_option_19').val();
        formData.append('poll_option_19', poll_option_19);
      }
      if (document.getElementById("poll_option_20")) {
        poll_option_20 = $('#poll_option_20').val();
        formData.append('poll_option_20', poll_option_20);
      }
    } else {
      formData.append('poll', 0);
    }


    //LINKS
    if ($('#links').prop('checked')) {
      formData.append('links', 1);

      if (document.getElementById("link_1")) {
        link_1 = $('#link_1').val();
        formData.append('link_1', link_1);
      }
      if (document.getElementById("link_2")) {
        link_2 = $('#link_2').val();
        formData.append('link_2', link_2);
      }
      if (document.getElementById("link_3")) {
        link_3 = $('#link_3').val();
        formData.append('link_3', link_3);
      }
      if (document.getElementById("link_4")) {
        link_4 = $('#link_4').val();
        formData.append('link_4', link_4);
      }
      if (document.getElementById("link_5")) {
        link_5 = $('#link_5').val();
        formData.append('link_5', link_5);
      }
    } else {
      formData.append('links', 0);
    }


    $.ajax({
      type: "POST",
      url: "<?php echo $base_url; ?>/new-topic/<?php echo $board_id; ?>/",
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
          var objJSON = JSON.parse(response);
          topic_slug = objJSON.slug;
          window.location = '<?php echo $base_url; ?>/topic/' + topic_slug + "/";
          $('.topic-submit-loading').removeClass('active');
      },
    });

});

function delete_gallery_item(id){
  var to_remove = "." + id;
  $(to_remove).remove();
  image_count = $('.gallery-preview').attr('data-images');
  image_count = +image_count - 1;
  $('.gallery-preview').attr('data-images', image_count);
  if (image_count < 25) {
    $(".gallery-upload-area").removeClass('disabled');
  }

  if (image_count == 0) {
    $(".gallery-preview-container").slideUp(350, 'easeOutQuart');
  }
}


$( document ).ready(function() {

    // Drag enter
    $('.gallery-upload-area').on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
    });

    // Drag over
    $('.gallery-upload-area').on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
    });

    // Drop
    $('.gallery-upload-area').on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();

        var file = e.originalEvent.dataTransfer.files;
        var fd = new FormData();

        var image_count = $('.gallery-preview').attr('data-images');
        if (image_count < 25) {
          $.each( file, function(i, file) {
           fd.append('file[]', file);
         });

          uploadgalleryData(fd);
        }
    });

    // Open file selector on div click
    $(".gallery-upload-area").click(function(){
        var image_count = $('.gallery-preview').attr('data-images');
        if (image_count < 25) {
          $("#upload_gallery").click();
        }
    });

    // file selected
    $("#upload_gallery").change(function(){
      $(".gallery-photo-loading").addClass('active');
        var current_count = $('.gallery-preview').attr('data-images');
        var fd = new FormData();
        var files = $('#upload_gallery').prop('files');
        $.each( files, function(i, file) {
          current_count = +current_count +1;
          if (current_count < 25) {
            fd.append('file[]', file);
          }

        });
        fd.append('file',files);
        uploadgalleryData(fd);
    });

    // Sending AJAX request and upload file
    function uploadgalleryData(formdata){
        $(".gallery-photo-loading").addClass('active');
        $(".gallery-preview-container").slideUp(350, 'easeOutQuart');

        $.ajax({
            url: '<?php echo $base_url ?>/uploadtopicgallery/',
            type: 'post',
            data: formdata,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response){
                galleryThumbnail(response);

            }
        });
    }

    // Added thumbnail
    function galleryThumbnail(response){

      var total_images=0;
      $.each(response, function( key, value ) {
        total_images=total_images+1;
      });

      if (total_images > 0) {
        $('.gallery-preview').addClass('updated');
      } else {
        $('.gallery-preview').removeClass('updated');
      }

      $.each(response, function( key, value ) {

        $.each(value, function( a, b ) {
          if (a == "url") {
            url = b;
          }
          if (a == "thumb") {
            thumb = b;
          }
          if (a == "id") {
            image_id = b;
          }

          if (a == "type") {
            image_type = b;
          }
        });

        image_count = $('.gallery-preview').attr('data-images');
        image_count = +image_count + 1;


        if (image_count < 25) {
          $('.gallery-preview').attr('data-images', image_count);
          var gallery_item = '<div data-type="' + image_type + '" data-id="' + image_id + '" class="gallery_preview_box ' + image_id + '"><img src="<?php echo $temp_url; ?>/' + thumb + '" data-url="<?php echo $temp_url; ?>/' + url + '" class="gallery_preview_thumb" /><div class="delete-gallery-image" onclick="delete_gallery_item(\'' + image_id + '\')"></div></div>';
          $( ".gallery-preview" ).prepend( gallery_item );
        }
        if (image_count > 23) {
          $(".gallery-upload-area").addClass('disabled');
        }

      });

      setTimeout(function(){
        $(".gallery-photo-loading").removeClass('active');
        $(".gallery-preview-container").slideDown(350, 'easeOutQuart');
      }, 250);

    }

    $("#new-topic-content").wysibb();

    $('#newtopicheader').on('input', function() {
      var scroll_height = $('#newtopicheader').get(0).scrollHeight;
      scroll_height = +scroll_height + +1;
      $('#newtopicheader').css('height', scroll_height + 'px');

      var minlength = 5;
      var maxlength = 300;
      var currentLength = $('#newtopicheader').val().length;
      var newcount = currentLength + "/" + maxlength;
      $('.header_count').html(newcount);

      if(currentLength < minlength){
        $('.header_count').addClass('warning');
        $('#submittopic').attr("disabled", true);
      } else {
        $('.header_count').removeClass('warning');
        $('#submittopic').attr("disabled", false);
      }

    });

    $(".add-poll-option-button").on('click', function() {
      var current_count = $('.poll-container').attr('data-options');
      var new_id = +current_count +1;

      var html = '<input maxlength="500" type="text" id="poll_option_' + new_id + '" name="poll_option_' + new_id + '" class="text-field border-top text-left" placeholder="Option ' + new_id + '"><div class="option-ghost"></div>';

      if(new_id < 21){
        $('.poll-container').attr('data-options', new_id);
        $(".option-ghost").replaceWith(html);
      }

      if(new_id == 20){
        $('.add-poll-option-button').addClass('disabled');
      }
    });

    $(".add-link-option-button").on('click', function() {
      var current_count = $('.link-container').attr('data-options');
      var new_id = +current_count +1;

      var html = '<input maxlength="500" type="text" id="link_' + new_id + '" name="link_' + new_id + '" class="text-field border-top text-left" placeholder="Link ' + new_id + '"><div class="link-ghost"></div>';

      if(new_id < 6){
        $('.link-container').attr('data-options', new_id);
        $(".link-ghost").replaceWith(html);
      }

      if(new_id == 5){
        $('.add-link-option-button').addClass('disabled');
      }
    });

    $("#video").change(function() {
      if(this.checked) {
        $('.video-embed-details-container').slideDown(350, 'easeOutQuart');
      }else{
        $('.video-embed-details-container').slideUp(350, 'easeOutQuart');
      }
    });

    $("#poll").change(function() {
      if(this.checked) {
        $('.poll-container').slideDown(350, 'easeOutQuart');
      }else{
        $('.poll-container').slideUp(350, 'easeOutQuart');
      }
    });

    $("#imagegallery").change(function() {
      if(this.checked) {
        $('.gallery-upload-section').slideDown(350, 'easeOutQuart');
      }else{
        $('.gallery-upload-section').slideUp(350, 'easeOutQuart');
      }
    });

    $("#links").change(function() {
      if(this.checked) {
        $('.link-container').slideDown(350, 'easeOutQuart');
      }else{
        $('.link-container').slideUp(350, 'easeOutQuart');
      }
    });

    $('#video_id').on('input propertychange paste', function() {
        var vid_id = $('#video_id').val();
        var type = $('#video_type').val();
        if (type=='youtube') {
          var vid = '<iframe class="video-preview" src="https://www.youtube.com/embed/' + vid_id + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
          $('.video-container').html(vid);
          $('.video-container-wrap').slideDown(350, 'easeOutQuart');
        }
        if (type=='vimeo') {
          var vid = '<iframe src="https://player.vimeo.com/video/' + vid_id + '" class="video-preview" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
          $('.video-container').html(vid);
          $('.video-container-wrap').slideDown(350, 'easeOutQuart');
        }
    });

    $('.video_type').each(function() {
      var $this = $(this),
          numberOfOptions = $(this).children('option').length;
      $this.addClass('s-hidden');
      $this.wrap('<div class="select"></div>');
      $this.after('<div class="styledSelect"></div>');
      var $styledSelect = $this.next('div.styledSelect');
      $styledSelect.text($this.children('option').eq(0).text());
      var $list = $('<ul />', {
          'class': 'options'
      }).insertAfter($styledSelect);
      for (var i = 0; i < numberOfOptions; i++) {
          $('<li  />', {
            'rel': $this.children('option').eq(i).val(),
              html: $this.children('option').eq(i).text()
          }).appendTo($list);
      }
      var $listItems = $list.children('li');

      $styledSelect.click(function(e) {
          e.stopPropagation();
          $('div.styledSelect.active').each(function() {
              $(this).removeClass('active').next('ul.options').hide();
          });
          $(this).toggleClass('active').next('ul.options').toggle();
      });

      $listItems.click(function(e) {
          e.stopPropagation();
          $styledSelect.text($(this).text()).removeClass('active');
          $this.val($(this).attr('rel'));
          $list.hide();
          if ($this.val() == '0') {
            $("#video_type option[selected]").removeAttr("selected");
            $("#video_type option[value=0]").attr('selected', 'selected');
            $("#video_id").prop('disabled', true);
            $('.video-container-wrap').slideUp(350, 'easeOutQuart');
            $('#video_id').val("");
          }
          if ($this.val() == 'youtube') {
            $("#video_type option[selected]").removeAttr("selected");
            $("#video_type option[value=youtube]").attr('selected', 'selected');
            $("#video_id").prop('disabled', false);
          }
          if ($this.val() == 'vimeo') {
            $("#video_type option[selected]").removeAttr("selected");
            $("#video_type option[value=vimeo]").attr('selected', 'selected');
            $("#video_id").prop('disabled', false);
          }
      });

      // Hides the unordered list when clicking outside of it
      $(document).click(function() {
          $styledSelect.removeClass('active');
          $list.hide();
      });

    });

    $('#new-topic-content').on('input', function() {

      var scroll_height = $('#new-topic-content').get(0).scrollHeight;

      if ($('#new-topic-content').hasClass('altered')) {
        scroll_height = +scroll_height;
      } else {
        scroll_height = +scroll_height + +1;
      }

      $('#new-topic-content').css('height', scroll_height + 'px');
      $('#new-topic-content').addClass('altered');


      minlength = 5;
      var maxlength = 10000;
      var currentLength = $('#new-topic-content').val().length;
      var newcount = currentLength + "/" + maxlength;
      $('.body_count').html(newcount);


    });

});
</script>

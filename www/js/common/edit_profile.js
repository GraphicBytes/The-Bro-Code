document.addEventListener("DOMContentLoaded", function() {

  var edit_profile_close = document.querySelector('.edit-profile-close');
  var edit_profile_link = document.querySelector('.edit-profile-link');
  var edit_profile_takeover = document.querySelector('.edit-profile-takeover');
  edit_profile_close.addEventListener('click', function (event) {
    edit_profile_takeover.classList.remove('active');
  });
  edit_profile_link.addEventListener('click', function (event) {
    edit_profile_takeover.classList.add('active');
  });


  var update_profile_form = document.getElementById('update-profile');
  const update_profile_form_constant = document.getElementById("update-profile");
  var profile_update_loading = document.querySelector('.profile-update-loading');
  var profile_full_screen_takeover = document.querySelector('.full-screen-takeover');
  var profile_messages = document.querySelectorAll('.message');
  var profile_field_box_headers = document.querySelectorAll('.profile-field-box-header');

  function process_update_profile(e) {
    if (e.preventDefault) e.preventDefault();
    profile_update_loading.classList.add('active');

    //clear previous messages
    profile_full_screen_takeover.classList.remove('success');
    profile_full_screen_takeover.classList.remove('fail');

    profile_messages.forEach(function(profile_message) {
      profile_message.classList.remove('active');
    });
    profile_field_box_headers.forEach(function(profile_field_box_header) {
      profile_field_box_header.classList.remove('error');
      profile_field_box_header.classList.remove('success');
    });

    var url = update_profile_form.action;
    serialized = serialize(update_profile_form);

    function reqListener () {
      var obj = JSON.parse(this.response);

      var status = obj['status'];

      var name_taken = obj['name_taken'];
      var name_updated = obj['name_updated'];
      var email_valid = obj['email_valid'];
      var email_taken = obj['email_taken'];
      var email_updated = obj['email_updated'];
      var bioupdated = obj['bioupdated'];
      var biotoolong = obj['biotoolong'];
      var passwordupdated = obj['passwordupdated'];
      var passwordtooshort = obj['passwordtooshort'];
      var passwordmissmatch = obj['passwordmissmatch'];
      var avatarupdated = obj['avatarupdated'];



      //avatar updated
      if(avatarupdated==1){
        document.getElementById("newfileprofile").value = 1;
        var avatar = document.querySelector('.avatar');
        var avatarupdated = document.querySelector('.avatarupdated');
        avatar.classList.add('success');
        setTimeout(function(){
          avatarupdated.classList.add('active');
        }, 1500);
      }

      //PW updated
      var pw = document.querySelector('.pw');
      var pw2 = document.querySelector('.pw2');
      var pwupdated = document.querySelector('.pwupdated');
      var passwordtooshortmsg = document.querySelector('.passwordtooshort');
      var passwordmissmatchmsg = document.querySelector('.passwordmissmatch');

      if(passwordupdated==1){
        pw.classList.add('success');
        pw2.classList.add('success');
        setTimeout(function(){
          pwupdated.classList.add('active');
        }, 1500);
      }
      if(passwordtooshort==1){
        pw.classList.add('error');
        setTimeout(function(){
          passwordtooshortmsg.classList.add('active');
        }, 1500);
      }

      if(passwordmissmatch==1){
        pw.classList.add('error');
        pw2.classList.add('error');
        setTimeout(function(){
          passwordmissmatchmsg.classList.add('active');
        }, 1500);
      }

      //bio updated
      var bio = document.querySelector('.bio');
      var bioupdated = document.querySelector('.bioupdated');
      var biotoolong = document.querySelector('.biotoolong');

      if(bioupdated==1){
        bio.classList.add('success');
        setTimeout(function(){
          bioupdated.classList.add('active');
        }, 1500);
      }
      if(biotoolong==1){
        bio.classList.add('error');
        setTimeout(function(){
          biotoolong.classList.add('active');
        }, 1500);
      }

      //email update
      var email = document.querySelector('.email');
      var invalidemail = document.querySelector('.invalidemail');
      var emailtaken = document.querySelector('.emailtaken');
      var emailupdated = document.querySelector('.emailupdated');

      if(email_valid==0){
        email.classList.add('error');
        setTimeout(function(){
          invalidemail.classList.add('active');
        }, 1500);
      }
      if(email_taken==1){
        email.classList.add('error');
        setTimeout(function(){
          emailtaken.classList.add('active');
        }, 1500);
      }
      if(email_updated==1){
        email.classList.add('success');
        setTimeout(function(){
          emailupdated.classList.add('active');
        }, 1500);
      }

      //display name updated
      var displayname = document.querySelector('.displayname');
      var displaynameupdated = document.querySelector('.displaynameupdated');
      var nametaken = document.querySelector('.nametaken');

      if(name_updated==1){
        displayname.classList.add('success');
        setTimeout(function(){
          displaynameupdated.classList.add('active');
        }, 1500);
      }
      if(name_taken==1){
        displayname.classList.add('error');
        setTimeout(function(){
          nametaken.classList.add('active');
        }, 1500);
      }

      //profile update

      if(status==1){
        setTimeout(function(){
          profile_update_loading.classList.remove('active');
          setTimeout(function(){
            profile_full_screen_takeover.classList.add('success');
          }, 1000);
        }, 350);
      }
      if(status==2){
        setTimeout(function(){
          profile_update_loading.classList.remove('active');
          setTimeout(function(){
            profile_full_screen_takeover.classList.add('fail');
          }, 1000);
        }, 350);
      }

    }

    var newXHR = new XMLHttpRequest();
    newXHR.addEventListener( 'load', reqListener );
    newXHR.open( 'POST', url );
    newXHR.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
    var formData = serialized;
    newXHR.send( formData );

    return false;
  }

  if (update_profile_form.attachEvent) {
    update_profile_form.attachEvent("submit", process_update_profile);
  } else {
    update_profile_form.addEventListener("submit", process_update_profile);
  }














  document.ondragstart = function () { return false; };
  $(function() {

      // preventing page from redirecting
      $("html").on("dragover", function(e) {
          e.preventDefault();
          e.stopPropagation();
      });

      $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });

      // Drag enter
      $('.upload-area').on('dragenter', function (e) {
          e.stopPropagation();
          e.preventDefault();
      });

      // Drag over
      $('.upload-area').on('dragover', function (e) {
          e.stopPropagation();
          e.preventDefault();
      });

      // Drop
      $('.upload-area').on('drop', function (e) {
          e.stopPropagation();
          e.preventDefault();

          var file = e.originalEvent.dataTransfer.files;
          var fd = new FormData();

          fd.append('file', file[0]);

          uploadData(fd);
      });

      // Open file selector on div click
      $("#uploadfile").click(function(){
          $("#file").click();
      });

      // file selected
      $("#file").change(function(){
          var fd = new FormData();
          var files = $('#file')[0].files[0];
          fd.append('file',files);
          uploadData(fd);
      });
  });


  var upload_profile_temp_url = document.getElementById('upload_profile_temp_url').value
  var upload_profile_base_url = document.getElementById('upload_profile_base_url').value


  // Sending AJAX request and upload file
  function uploadData(formdata){
      $(".profile-photo-loading").addClass('active');
      $.ajax({
          url: upload_profile_base_url + '/updateprofilephoto/',
          type: 'post',
          data: formdata,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response){
              addThumbnail(response);
          }
      });
  }

  // Added thumbnail
  function addThumbnail(data){

      var len = $("#uploadfile div.avatar-edit-container").length;

      var num = Number(len);
      num = num + 1;

      var status = data.status;
      var src = data.src;
      var srcfull = upload_profile_temp_url + "/" + data.src;

      if (status == 1) {
        $(".invalid_file").removeClass('active');
        $(".file_too_large").removeClass('active');
        $(".failed_update").removeClass("active");
        $(".update_succeed").removeClass("active");
        setTimeout(function(){ $(".invalid_file").addClass('active'); }, 250);
        setTimeout(function(){ $(".profile-photo-loading").removeClass('active'); }, 500);

      }
      else if (status == 2) {
        $(".invalid_file").removeClass('active');
        $(".file_too_large").removeClass('active');
        $(".failed_update").removeClass("active");
        $(".update_succeed").removeClass("active");
        setTimeout(function(){ $(".file_too_large").addClass('active'); }, 250);
        setTimeout(function(){ $(".profile-photo-loading").removeClass('active'); }, 500);

      }
      else if (status == 3) {
        $(".invalid_file").removeClass('active');
        $(".file_too_large").removeClass('active');
        $(".failed_update").removeClass("active");
        $(".update_succeed").removeClass("active");
        $('#newfileprofile').val(src);
        $(".avatar-edit-container").html('<img src="' + srcfull + '" class="avatar-edit">');
        setTimeout(function(){ $(".profile-photo-loading").removeClass('active'); }, 500);
      }
      else{
        $(".invalid_file").removeClass('active');
        $(".file_too_large").removeClass('active');
        $(".profile-photo-loading").removeClass('active');

        $(".failed_update").removeClass("active");
        setTimeout(function(){ $(".failed_update").addClass("active"); }, 500);

      }

  }



});

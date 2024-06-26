document.addEventListener('DOMContentLoaded', function() { 

  $('.moderation-trigger').click(function() {

    var base_url = $('#base-data').attr('data-base_url');

    var mode_change_url = base_url + "/moderation-trigger/";

    $.ajax({
        url: mode_change_url,
        type: 'get',
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response){
          location.reload();
        }
    });
  });
  $('.next-moderate').click(function() {

    var base_url = $('#base-data').attr('data-base_url');
    var mode_next_url = base_url + "/next-moderate/";

    $.ajax({
        url: mode_next_url,
        type: 'get',
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response){
          if(response.status == 0) {
            $('.next-moderate').addClass('nothing-to-mod');
          } else if(response.status == 1){
            window.location.href = response.url;
          }
        }
    });
  });
});

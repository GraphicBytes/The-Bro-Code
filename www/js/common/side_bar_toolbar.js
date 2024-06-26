document.addEventListener('DOMContentLoaded', function() { 

  $('.user-view-order-1').click(function(){
    var base_url = document.getElementById("base-data").dataset.base_url;
    var view_order = document.getElementById("base-data").dataset.view_order;

    var current_choice = view_order;
    var new_choice = document.querySelector('.user-view-order-1').dataset.order;
    if (current_choice != new_choice) {
      $('.tools-loading').addClass('active');
      var theurl = base_url + "/change-view-order/" + new_choice + "/";
      $.ajax({
          url: theurl,
          type: 'get',
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response){
            if(response.status == 1){
              $('.tools-loading').removeClass('active');
              location.reload();
            }else{
              $('.tools-loading').removeClass('active');
            };

          }
      });
    }
  });


  $('.user-view-order-2').click(function(){
    var base_url = document.getElementById("base-data").dataset.base_url;
    var view_order = document.getElementById("base-data").dataset.view_order;

    var current_choice = view_order;
    var new_choice = document.querySelector('.user-view-order-2').dataset.order;
    if (current_choice != new_choice) {
      $('.tools-loading').addClass('active');
      var theurl = base_url + "/change-view-order/" + new_choice + "/";
      $.ajax({
          url: theurl,
          type: 'get',
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response){
            if(response.status == 1){
              $('.tools-loading').removeClass('active');
              location.reload();
            }else{
              $('.tools-loading').removeClass('active');
            };

          }
      });
    }
  });



  $('.user-view-order-3').click(function(){
    var base_url = document.getElementById("base-data").dataset.base_url;
    var view_order = document.getElementById("base-data").dataset.view_order;

    var current_choice = view_order;
    var new_choice = document.querySelector('.user-view-order-3').dataset.order;
    if (current_choice != new_choice) {
      $('.tools-loading').addClass('active');
      var theurl = base_url + "/change-view-order/" + new_choice + "/";
      $.ajax({
          url: theurl,
          type: 'get',
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response){
            if(response.status == 1){
              $('.tools-loading').removeClass('active');
              location.reload();
            }else{
              $('.tools-loading').removeClass('active');
            };

          }
      });
    }
  });


  $('.hide-shit').click(function(){
    var base_url = document.getElementById("base-data").dataset.base_url;
    var hide_shit = document.getElementById("base-data").dataset.hide_shit;

    var current_choice = hide_shit;
    if (hide_shit == 0) {
      var new_choice = 1;
    } else {
      var new_choice = 0;
    }

      $('.tools-loading').addClass('active');
      var theurl = base_url + "/hide-shit/" + new_choice + "/";

      $.ajax({
          url: theurl,
          type: 'get',
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response){
            if(response.status == 1){
              $('.tools-loading').removeClass('active');
              location.reload();
            }else{
              $('.tools-loading').removeClass('active');
            };

          }
      });
  });





});

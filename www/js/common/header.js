document.addEventListener("DOMContentLoaded", function() {



  $(".hamburger").on("click", function(e) {

    if ($(".hamburger").hasClass('is-active')) {
      $(".hamburger").removeClass("is-active");
      $(".sidebar").removeClass("active");
      $("body").removeClass("mobile-menu-open");
    } else {
      $(".hamburger").addClass("is-active");
      $(".sidebar").addClass("active");
      $("body").addClass("mobile-menu-open");
    }

  });

  let touchstartX = 0;
  let touchendX = 0;
  const gestureZone = document.getElementById('sidebar');

  gestureZone.addEventListener('touchstart', function(event) {
      touchstartX = event.changedTouches[0].screenX;
  }, false);

  gestureZone.addEventListener('touchend', function(event) {
      touchendX = event.changedTouches[0].screenX;
      handleGesture();
  }, false);

  function handleGesture() {
      if ((touchendX - 75) >= touchstartX) {
        $(".hamburger").removeClass("is-active");
        $(".sidebar").removeClass("active");

        setTimeout(function(){ $("body").removeClass("mobile-menu-open"); }, 250);
      }
  }

});

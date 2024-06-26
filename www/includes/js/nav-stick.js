function moveScroller() {
    var $anchor = $("#scroller-anchor");

    var move = function() {
        var st = $(window).scrollTop();
        var ot = $anchor.offset().top;
        if(st > ot) {
                  $( "#header-fill" ).addClass( "fixed" );
                  $( "header" ).addClass( "fixed" );
        } else {
            if(st <= ot) {
                  $( "#header-fill" ).removeClass( "fixed" );
                  $( "header" ).removeClass( "fixed" );
            }
        }
    };
    $(window).scroll(move);
    move();
}

  $(function() {
    moveScroller();
  });

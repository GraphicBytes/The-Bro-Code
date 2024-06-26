document.addEventListener("DOMContentLoaded", function() {

  const login_prompts = document.querySelectorAll('.login-prompt');
  var login_form_holder = document.querySelector('.login-form-holder');

  for (const login_prompt of login_prompts) {

    login_prompt.addEventListener('click', function (event) {
      var screen_width = $( window ).width();
      if (screen_width < 950) {

        var hamburger_trig = document.querySelector('.hamburger');
        var sidebar_trig = document.querySelector('.sidebar');
        var body_trig = document.querySelector('.body');

        hamburger_trig.classList.add('is-active');
        sidebar_trig.classList.add('active');
        body_trig.classList.add('mobile-menu-open');

      } else {

        login_form_holder.classList.add('bounce');
        setTimeout(function(){
          login_form_holder.classList.remove('bounce');
        }, 750);

      }
    });

  }

});

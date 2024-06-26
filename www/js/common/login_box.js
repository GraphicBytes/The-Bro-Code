document.addEventListener("DOMContentLoaded", function() {

  if(document.body.contains(document.getElementById('login-container'))){


    var login_loading = document.querySelector('.login-loading');
    var signup_message = document.querySelector('.signup-message');
    var signup_form = document.getElementById('signup');

    // var fb_login = document.querySelector('.fb_login_button');
    // var button_bg = document.querySelector('.button_bg');
    // fb_login.addEventListener("mouseover", function( event ) {
    //   button_bg.classList.add('hover');
    // }, false);
    // fb_login.addEventListener("mouseleave", function( event ) {
    //   button_bg.classList.remove('hover');
    // }, false);


    var remember_me = document.querySelector('.remember-me');
    remember_me.addEventListener('click', function (event) {
      if (this.classList.contains('active')) {
        this.classList.remove('active');
        document.getElementById("remember_me").value = 0;
      } else {
        this.classList.add('active');
        document.getElementById("remember_me").value = 1;
      }
    });

    var sign_up = document.querySelector('.sign-up-select');
    var log_in = document.querySelector('.log-in-select');
    var log_in2 = document.querySelector('.log-in-select2');
    var lost_password = document.querySelector('.lost-password-select');

    sign_up.addEventListener('click', function (event) {
      slideUp(document.getElementById("login-container"), 350);
      slideDown(document.getElementById("signup-container"), 350);
      slideUp(document.getElementById("lost-pw-container"), 350);
    });

    log_in.addEventListener('click', function (event) {
      slideDown(document.getElementById("login-container"), 350);
      slideUp(document.getElementById("signup-container"), 350);
      slideUp(document.getElementById("lost-pw-container"), 350);
    });

    log_in2.addEventListener('click', function (event) {
      slideDown(document.getElementById("login-container"), 350);
      slideUp(document.getElementById("signup-container"), 350);
      slideUp(document.getElementById("lost-pw-container"), 350);
    });

    lost_password.addEventListener('click', function (event) {
      slideUp(document.getElementById("login-container"), 350);
      slideUp(document.getElementById("signup-container"), 350);
      slideDown(document.getElementById("lost-pw-container"), 350);
    });








    const signup_form_constant = document.getElementById("signup");


    function process_signup(e) {
      if (e.preventDefault) e.preventDefault();
      login_loading.classList.add('active');

        var token = document.getElementById("base-data").dataset.token;

        var url = signup_form.action + token + '/';

        serialized = serialize(signup_form);

        function reqListener () {
          var obj = JSON.parse(this.response);

          var response_code = obj['response_code'];
          var response_message = obj['response_message'];

          if(response_code==1){
            signup_message.innerHTML = response_message;
            login_loading.classList.remove('active');
            signup_form_constant.remove();
          }
          if(response_code==0){
            signup_message.innerHTML = response_message;
            login_loading.classList.remove('active');
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

    if (signup_form.attachEvent) {
      signup_form.attachEvent("submit", process_signup);
    } else {
      signup_form.addEventListener("submit", process_signup);
    }








    var lost_pw_message = document.querySelector('.lost-pw-message');
    var lostpw_form = document.getElementById('lostpw');
    const lostpw_form_constant = document.getElementById("lostpw");

    function process_forgot_pw(e) {
      if (e.preventDefault) e.preventDefault();
      login_loading.classList.add('active');

        var url = lostpw_form.action;
        serialized = serialize(lostpw_form);

        function reqListener () {
          var obj = JSON.parse(this.response);

          var response_code = obj['response_code'];
          var response_message = obj['response_message'];

          if(response_code==1){
            lost_pw_message.innerHTML = response_message;
            login_loading.classList.remove('active');
            lostpw_form_constant.remove();
          }
          if(response_code==0){
            lost_pw_message.innerHTML = response_message;
            login_loading.classList.remove('active');
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

    if (lostpw_form.attachEvent) {
      lostpw_form.attachEvent("submit", process_forgot_pw);
    } else {
      lostpw_form.addEventListener("submit", process_forgot_pw);
    }








    var login_message = document.querySelector('.log-in-message');
    var login_form = document.getElementById('login');
    const login_form_constant = document.getElementById("login");

    function process_login(e) {
      if (e.preventDefault) e.preventDefault();
      login_loading.classList.add('active');

        var url = login_form.action;
        serialized = serialize(login_form);

        function reqListener () {
          var obj = JSON.parse(this.response);

          var response_code = obj['response_code'];
          var response_message = obj['response_message'];

          if(response_code==3){
            login_message.innerHTML = response_message;
            login_loading.classList.remove('active');
          }
          if(response_code==2){
            login_message.innerHTML = response_message;
            login_loading.classList.remove('active');
          }
          if(response_code==1){
            location.reload();
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

    if (login_form.attachEvent) {
      login_form.attachEvent("submit", process_login);
    } else {
      login_form.addEventListener("submit", process_login);
    }



  }

});




window.fbAsyncInit = function() {
  var fb_appId = document.getElementById("base-data").dataset.fb_app_id;
  var fb_version = document.getElementById("base-data").dataset.fb_graph_version;


  FB.init({
    appId      : fb_appId,
    cookie     : false,
    xfbml      : true,
    version    : fb_version
  });

  FB.AppEvents.logPageView();

};

(function(d, s, id){
   var js, fjs = d.getElementsByTagName(s)[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement(s); js.id = id;
   js.src = "https://connect.facebook.net/en_US/sdk.js";
   fjs.parentNode.insertBefore(js, fjs);
 }(document, 'script', 'facebook-jssdk'));


 function checkLoginState() {
   FB.getLoginStatus(function(response) {
     var accessToken = response.authResponse.accessToken;
     statusChangeCallback(response, accessToken);
   });
 }

 function statusChangeCallback(response, accessToken) {
   if (response.status === 'connected') {
     FB.api('/me?fields=id,name,email', function (response) {

       var fb_base_url = document.getElementById("base-data").dataset.base_url;
       fb_base_url = fb_base_url + "/logincheck/facebook/";

        function reqListener () {
          var obj = JSON.parse(this.response);
          var response_code = obj['response_code'];
          var response_message = obj['response_message'];

          if(response_code==1){location.reload();}
          if(response_code==2){location.reload();}
          if(response_code==4){login_message.innerHTML = response_message;}

        }
        var newXHR = new XMLHttpRequest();
        newXHR.addEventListener( 'load', reqListener );
        newXHR.open( 'POST', fb_base_url );

        var form_data = new FormData();
        form_data.append('id' , response.id);
        form_data.append('accessToken' , accessToken);
        form_data.append('name' , response.name);
        form_data.append('email' , response.email);
        newXHR.send( form_data );
     });
   } else {
     login_message.innerHTML = "UNKNOWN ERROR";
   }

 }

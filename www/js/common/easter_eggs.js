document.addEventListener("DOMContentLoaded", function() {

  //stupid_message on member header
  let member_header_user = document.getElementById("member-header-user");
  member_header_user.addEventListener("mouseover", member_header_user_mOver, false);
  member_header_user.addEventListener("mouseout", member_header_user_mOut, false);

  function member_header_user_mOver() {
    mytimer = setTimeout(function(){
      member_header_user.innerHTML = "Fuck all happens Bro, Sorry!";
    }, 20000);
  }

  function member_header_user_mOut() {
    clearTimeout(mytimer);
  }

});

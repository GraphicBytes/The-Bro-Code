
document.addEventListener("DOMContentLoaded", function(){

  var hamburger = document.querySelector(".hamburger");
  var nav = document.querySelector("#nav");
  var body = document.querySelector("body");
  hamburger.addEventListener("click", function() {
    hamburger.classList.toggle("is-active");
    nav.classList.toggle("active");
    body.classList.toggle("menu-on");
  });

});

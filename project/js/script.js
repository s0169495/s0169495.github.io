$(document).ready(function () {
  console.log("ready!");
  $(".reviewSlide").slick({
      prevArrow: ".arrow-left",
      nextArrow: ".arrow-right",
      adaptiveHeight: true,
      dots: false,
      infinite: true,
      mobileFirst: true,
      slidesToScroll: 1,
      slidesToShow: 1,
      fade: true,
  });
});

function showDropdown(navbarDropdown, list){
  $(navbarDropdown).addClass("show");
  $(navbarDropdown).prop("aria-expanded", true);
  $(list).addClass("show");
}

function hideDropdown(navbarDropdown, list){
  let windowInnerWidth = window.innerWidth;
  if(windowInnerWidth >= 993) {
      $(navbarDropdown).removeClass("show");
      $(navbarDropdown).prop("aria-expanded", false);
      $(list).removeClass("show");
  }
}

function moveNavbar(){
  let windowInnerWidth = window.innerWidth;
  let navbar = $("#navbar");
  if(windowInnerWidth <= 993) {
      navbar.addClass("fixed-bottom");
      navbar.addClass("bg-dark");
      $(".video_back").remove();
  }
  if(windowInnerWidth >= 993){
      navbar.removeClass("fixed-bottom");
      navbar.removeClass("bg-dark");
  }
}

$(document).ready(function (){
  moveNavbar();
  $(window).resize((event)=>{
      moveNavbar();
  });

  $("#check").change(function () {
      if ($("#check").is(":checked")) {
          $("#submitButton").prop("disabled", false);
      } else {
          $("#submitButton").prop("disabled", true);
      }
  });
});

$(document).ready(function() {
let oldelem=null;
$(".accordion-content").hide();
$(".accordion-header").click(function () {
  if($(this).next().is(":animated")) return;
  $(this).next().slideToggle();
  $(this).toggleClass("active");
  $(this).parent().toggleClass("toggle");
  if(oldelem===this) return;
  $(oldelem).next().slideUp();
  $(oldelem).removeClass("active");
  $(oldelem).parent().removeClass("toggle");
  oldelem=this;
});
});

function persistInput(input)
{
  var key = "input-" + input.id;

  var storedValue = localStorage.getItem(key);

  if (storedValue)
      input.value = storedValue;

  input.addEventListener('input', function ()
  {
      localStorage.setItem(key, input.value);
  });
}

window.onload = function(){

    var a = document.getElementById("name");
    persistInput(a);
    var b = document.getElementById("post");
    persistInput(b);
    var c = document.getElementById("text");
    persistInput(c);
    var d = document.getElementById("number");
    persistInput(d);
}



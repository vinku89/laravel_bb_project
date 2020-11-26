window.onload = function () {
  $(".menu_wrp_scroll").mCustomScrollbar({
    theme: "dark",
    mouseWheelPixels: 80,
    scrollInertia: 0
  });
}
//show hide password
$(".toggle-password").click(function () {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

//Toggle Side bar Menu
$(document).ready(function () {
  $('#nav-icon2').click(function (e) {
    $('.navbar-primary').toggleClass('collapsed');
    $(this).toggleClass('open');
    $('.img').toggle();
  });
  $('.small_resNav_toggle').click(function (e) {
    $('.navbar-primary').toggleClass('collapsed');
    $('#nav-icon2').toggleClass('open');
    $('.img').show();
  });
  //drop down menu
  $('.kumar').on('click', function (e) {
    e.preventDefault();
    $this = $(this);
    $parent = $this.next();
    $tar = $('.child-menu-ul');
    if (!$parent.hasClass('active')) {
      $this.addClass('active');
      $parent.addClass('active').slideDown('fast');
      $('.toggle-right').addClass('rotate');
    } else {
      $this.removeClass('active');
      $parent.removeClass('active').slideUp('fast');
      $('.toggle-right').removeClass('rotate');
    }
  });

   // Backdrop color
   $('.small_resNav_toggle').click(function (e) {
    if (($(window).width() <= 1200)) {
      $('.backdrop').addClass('backdrop_color');
    } else {
      $('.backdrop').removeClass('backdrop_color');
    }
  });
  $('#nav-icon2').click(function (e) {
    if (($(window).width() <= 1200)) {
      $('.backdrop').removeClass('backdrop_color');
    } else {
      
    }
  });

  // Responsive Navigation document load
  $(function () {
    if (($(window).width() <= 1199)) {
      $('.navbar-primary').addClass('collapsed');
    } else {
      $('.navbar-primary').removeClass('collapsed');
    }
  });
});
// Responsive Navigation window resize load
$(function () {
  $(window).resize(function () {
    if (($(window).width() <= 1199)) {
      $('.navbar-primary').addClass('collapsed');
    }  else {
      $('.navbar-primary').removeClass('collapsed');
    }
  });
});




//Sales Drop Down
$(function () {
  $(".normal_select").dropkick({
    mobile: true
  });
  $("#normal_select1").dropkick({
    mobile: true
  });
  $("#select_country").dropkick({
    mobile: true
  });
  $("#select_country2").dropkick({
    mobile: true
  });
  $("#shipping_country").dropkick({
    mobile: true
  });
  $("#shipping_country2").dropkick({
    mobile: true
  });
  $("#subscribe_gender").dropkick({
    mobile: true
  });
  
  $(".gist-container").each(function (index, gist) {
    if (gist.offsetHeight > 160) {
      $(".btn", gist).css('display', 'inline-block').on('click', function () {
        var $gistWrapper = $(".gist-wrapper", gist);
        if ($gistWrapper.css('maxHeight') == "100%") {
          $gistWrapper.css('maxHeight', "");
          $gistWrapper.css('overflow', "");
          this.innerHTML = "Show Full Code";
          return false;
        } else {
          $gistWrapper.css('maxHeight', "100%");
          $gistWrapper.css('overflow', "visible");
          this.innerHTML = "Hide Code";
          return false;
        }
      })
    }
  });
});
//top header profile dropdown and Notification
document.getElementById('wrapper2').onclick = function () {
  var className = '' + wrapper2.className + '';
  this.className = ~className.indexOf('active') ?
    className.replace(' active', '') :
    this.className + ' active';
}
//   $('#notification_btn').click(function(){
//       $('.notify-drop-wrp').slideToggle(300);
//       $(this).toggleClass('notify_active');
//   });
//   $('.close_notify').click(function(){
//     $('.notify-drop-wrp').css('display, none');
// });
//closer drop down
// $(document).mouseup(function(){
//   $(".notify-drop-wrp").hide(); 
//   $(".notification_wrp").removeClass('notify_active'); 
//   $("#wrapper2").removeClass('active'); 
//  });

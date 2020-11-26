
//show hide password
$(".toggle-password").click(function() {

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

  $(function() {
    $( "#normal_select" ).dropkick({
      mobile: true
    });
    $( "#normal_select1" ).dropkick({
      mobile: true
    });
    $( "#select_country" ).dropkick({
      mobile: true
    });
    $( "#shipping_country" ).dropkick({
      mobile: true
    });


    $(".gist-container").each(function(index, gist) {
      if (gist.offsetHeight > 160) {
        $(".btn", gist).css('display', 'inline-block').on('click', function() {
          var $gistWrapper = $(".gist-wrapper", gist);

          if($gistWrapper.css('maxHeight') == "100%"){
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


  //date picker

  $(function () {
    $("#datepicker").datepicker({ 
          autoclose: true, 
          todayHighlight: true
    }).datepicker('update', new Date());
  });



  $(function() {
    var croppie = null;
    var el = document.getElementById('resizer');

    $.base64ImageToBlob = function(str) {
        // extract content type and base64 payload from original string
        var pos = str.indexOf(';base64,');
        var type = str.substring(5, pos);
        var b64 = str.substr(pos + 8);
      
        // decode base64
        var imageContent = atob(b64);
      
        // create an ArrayBuffer and a view (as unsigned 8-bit)
        var buffer = new ArrayBuffer(imageContent.length);
        var view = new Uint8Array(buffer);
      
        // fill the view, using the decoded base64
        for (var n = 0; n < imageContent.length; n++) {
          view[n] = imageContent.charCodeAt(n);
        }
      
        // convert ArrayBuffer to Blob
        var blob = new Blob([buffer], { type: type });
      
        return blob;
    }

    $.getImage = function(input, croppie) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {  
                croppie.bind({
                    url: e.target.result,
                });
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#file-upload").on("change", function(event) {
        $("#myModal").modal();
        // Initailize croppie instance and assign it to global variable
        croppie = new Croppie(el, {
                viewport: {
                    width: 200,
                    height: 200,
                    type: 'circle'
                },
                boundary: {
                    width: 250,
                    height: 250
                },
                enableOrientation: true
            });
        $.getImage(event.target, croppie); 
    });

    $("#upload").on("click", function() {
        croppie.result('base64').then(function(base64) {
            $("#myModal").modal("hide"); 
            $("#profile-pic").attr("src","/images/ajax-loader.gif");

            var url = "{{ url('/demos/jquery-image-upload') }}";
            var formData = new FormData();
            formData.append("profile_picture", $.base64ImageToBlob(base64));

            // This step is only needed if you are using Laravel
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data == "uploaded") {
                        $("#profile-pic").attr("src", base64); 
                    } else {
                        $("#profile-pic").attr("src","../app/images/icon-cam.png"); 
                        console.log(data['profile_picture']);
                    }
                },
                error: function(error) {
                    console.log(error);
                    $("#profile-pic").attr("src","../app/images/icon-cam.png"); 
                }
            });
        });
    });

    // To Rotate Image Left or Right
    $(".rotate").on("click", function() {
        croppie.rotate(parseInt($(this).data('deg'))); 
    });

    $('#myModal').on('hidden.bs.modal', function (e) {
        // This function will call immediately after model close
        // To ensure that old croppie instance is destroyed on every model close
        setTimeout(function() { croppie.destroy(); }, 100);
    })

});

//top header profile dropdown and Notification


document.getElementById('wrapper2').onclick = function () { 
  var className = '' + wrapper2.className + '';
  this.className = ~className.indexOf('active') ?
  className.replace(' active', '') :
  this.className + ' active';
}
$('#notification_btn').click(function(){
  $('.notify-drop-wrp').slideToggle(300);
  $(this).toggleClass('notify_active');
});
$('.close_notify').click(function(){
$('.notify-drop-wrp').css('display, none');
});


//closer drop down
$(document).mouseup(function(){
  $(".notify-drop-wrp").hide(); 
  $(".notification_wrp").removeClass('notify_active'); 
  $(".wrapper2").removeClass('active'); 
 });
 
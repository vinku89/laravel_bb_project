<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>BestBOX - Customer Login</title>
<link rel="shortcut icon" href="<?php echo url('/');?>/public/images/favicon.png" type="image/png" sizes="32x32" />

<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
<link rel="stylesheet" href="<?php echo url('/');?>/public/css/style.css">
<link rel="stylesheet" href="<?php echo url('/');?>/public/css/common.css">
<!-- for slider captcha -->
<link href="<?php echo url('/');?>/public/css/slidercaptcha.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo url('/');?>/public/css/login.css">
<!-- for slider captcha -->
<style>
    body { background-color: #fafafa; }
    .container { margin: 150px auto; }
    .slidercaptcha {
        margin: 0 auto;
        width: 314px;
        height: 300px;
        border-radius: 4px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.125);
        margin-top: 40px;
    }

    .slidercaptcha .card-body {
        padding: 1rem;
    }

    .slidercaptcha canvas:first-child {
        border-radius: 4px;
        border: 1px solid #e6e8eb;
    }

    .slidercaptcha.card .card-header {
        background-image: none;
        background-color: rgba(0, 0, 0, 0.03);
    }

    .refreshIcon {
        top: -54px;
    }
    .form-check-input {
         width: auto !important;
        }
    .puzzle_close{
        position: absolute;
    right: -7px;
    top: -13px;
    background-color: #fff !important;
    opacity: 1;
    width: 25px;
    height: 25px;
    border-radius: 30px;
    box-shadow: 0 0 6px #6b6b6b;
    }

    ul{
      text-align: left;
        line-height: 25px;
        font-size: 16px;
    }
    .showHide_icon{
      top:-6px !important;
    }
</style>


</head>
<body class="template_bg">
    <div class="box innerBox">
                <div class="login_box ">
                    <div class="login-logo">
                        <a href="<?php echo url('/');?>"><img src="<?php echo url('/');?>/public/images/login_logo.png"></a>
                    </div>
                    <div class="log_page_wrapper_title row m-auto text-center py-5">
                       <div class="log_page_wrapper_title_signup col-6">
                          <a href="<?php echo url('/customerSignup');?>" class=""> SIGNUP </a>
                       </div>
                       <div class="log_page_wrapper_title_signin col-6">
                          <a href="<?php echo url('/customerLogin');?>" class="active">SIGNIN </a>
                       </div>
                    </div>

                    <!-- title -->

                    <div class="f14 text-center color-black pb-4"><strong>WELCOME</strong>, PLEASE SIGN IN TO CUSTOMER</div>

                    <!-- title end -->
                    <div class="text-center">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ strip_tags(str_replace("'",'',$errors->first())) }}
                            </div>
                        @endif
                        @if(Session::has('message') && Session::has('force_login') )
                            @if(Session::get('force_login') == 0)
                                <div class=" {{ (Session::get('alert') == 'Success') ? 'badge-success' : 'badge-danger' }} badge my-2" >
                                    {{ Session::get('message') }}
                                </div>
                            @endIf
                        @endIf
                    </div>
                    <?php if(isset($_POST) && !empty($_POST)) {
                        echo '<prE>';print_r($_POST);exit;
                        }
                        ?>
                    
                    <div class="col-12 mb-2">
                            <form method="post" id="loginForm" action="<?php echo url('/');?>/custLogin" class="needs-validation" novalidate>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="mb-2">

                                 <div class="position-relative input-wrap is-required">
                                    <input type="text" id="useremail" name="email" placeholder="Email / User Id *" required autocomplete="off" autocorrect="off" autocapitalize="off" class="form-control" value="<?php if(Session::has('email')) { echo Session::get('email');}?>">
                                    <div class="invalid-feedback" id="email_val">
                                        Please Enter Your Valid Email Id / User Id.
                                     </div>
                                 </div>
                                </div>
                                <div>
                                 <div class="relative input-wrap is-required">
                                  <div class="inputHeight">
                                     <input type="password" id="password" name="password" placeholder="Password *" required autocomplete="off" autocorrect="off" autocapitalize="off" class="form-control" value="<?php if(Session::has('password')) { echo Session::get('password');}?>">
                                       <span class="icon validation small" style="color:black;">
                                            <i class="fa fa-fw field-icon toggle-password fa-eye-slash" toggle="#password" ></i>
                                    </span>
                                  </div>

                                    <div class="invalid-feedback" id="err_msg_customer">
                                        Please Enter Your Password
                                     </div>


                                   </div>

                                </div>
                              <input type="hidden" name="force_logout" value="0" id="force_logout" />  
                              <button type="submit" class="btn button-primary d-block w-100 mt-4 lgin_sign_btn" id="lgin_sign_btn" >SIGNIN</button>
                            </form>
                              <div class="f12 mt-4 mb-5 clearfix">
                                  <!-- <div class="form-check float-left ">
                                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
                                        <label class="form-check-label black_txt" for="exampleCheck1">Remember me</label>
                                    </div> -->
                                    <a class="color-black float-right black_txt" href="<?php echo url('/');?>/forgotPassword/customer">Forgot password?</a>
                                </div>
                            <div class="login_footer_txt">
                                <p class="font12 black_txt text-center">
                                    <a href="<?php echo url('/terms_of_use'); ?>" class="black_txt">Terms & Conditions</a> | <a href="<?php echo url('/privacy_policy'); ?>" class="black_txt">Privacy Policy</a>  </br>
                                    Copyright © <?php echo date('Y');?> BestBOX. All rights reserved.
                                </p>
                                <p class="mt-3 font12 black_txt text-center">
                                    This site is fully compatible with 
                                    <span class="mx-1"><img src="<?php echo url('/');?>/public/website/assets/images/google-chrome.png" class="img-fluid" style="width: 22px; height: auto;"></span> Google Chrome and 
                                    <span class="mx-1"><img src="<?php echo url('/');?>/public/website/assets/images/firefox.png" class="img-fluid"></span> Mozilla Firefox browsers
                                </p>
                            </div>

                           </div>
                </div>
    </div>




<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="background-color: transparent;border: none;">


                <div class="slidercaptcha card">
                    <button type="button" class="close puzzle_close" data-dismiss="modal">&times;</button>
                    <div class="card-header">
                        <span>Drag To Verify</span>
                    </div>
                    <div class="card-body">
                        <div id="captcha"></div>
                    </div>
                </div>

      </div>
    </div>
</div>

<!-- Alert Modal -->
<div class="modal" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" data-backdrop="static" data-keyboard="false" data-toggle="modal">
  <div class="modal-dialog">
    <div class="modal-content" style="box-shadow: 0px 5px 20px #ccc; border: 0 !important; border-radius: 10px;">
      <!-- Modal Header -->
        <div class="modal-header">
            <!-- <h4 class="modal-title font-bold {{ (Session::get('alert') == 'Success') ? 'green_txt' : 'red_txt' }}"><span><img src="<?php echo url('/');?>/public/images/notif_new.png" style="width: 30px; height: auto"></span>@if(Session::has('message')) {{ Session::get('alert') }} @endIf</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button> -->
            <div class="row w-100 m-auto">
                <div class="col-md-6 text-md-left text-center d-none d-md-block align-self-center">
                    <span><img src="<?php echo url('/');?>/public/images/notif_new.png" style="width: 30px; height: auto;"></span>
                    <span class="alert-head-text">Notification</span>
                </div>
                <div class="col-md-6 text-md-right text-center align-self-center">
                    <img src="<?php echo url('/');?>/public/images/notification_bestbox.png" style="width: 120px; height: auto">
                </div>
            </div>
        </div>
      <!-- Modal body -->
      <!-- <div class="modal-body text-center py-5 my-3 {{ (Session::get('alert') == 'Success') ? 'green_txt' : 'red_txt' }}">
            @if(Session::has('message')) {{ Session::get('message') }} @endIf
      </div> -->
        <div class="modal-body noti-body text-center py-5 my-3">
                @if(Session::has('message')) {{ Session::get('message') }} @endIf
        </div>
     <!-- Modal footer -->
     <!-- Modal footer -->
        <div class="inline-buttons text-center">
            <button type="button" class="btn inline-buttons-center btn-secondary btn-sm w-50 d-table-cell" style="border-radius: 0 0 0 10px;"
                data-dismiss="modal" id="cancel_btn">CANCEL</button>
            <button type="button" class="btn inline-buttons-center btn-yellow btn-sm w-50 d-table-cell" style="border-radius: 0 0 10px 0;"
                id="force_login">CONTINUE</button>
        </div>
    </div>
  </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- <script src="<?php echo url('/');?>/public/js/form_validations.js"></script> -->
<script src="<?php echo url('/');?>/public/js/common.js" type=""></script>
<!-- for slider captcha -->
<script src="<?php echo url('/');?>/public/js/longbow.slidercaptcha.js"></script>
<!-- for slider captcha -->
<script type="text/javascript">

  $(document).ready(function(){

      $("#useremail").blur(function(){
        checkUserNameVal();
      });

      $("#password").keyup(function(){
        //$(".toggle-password").removeClass('showHide_icon');
        $("#err_msg_customer").css('display','none');
      });

  });
    function checkUserNameVal(){
          var email = $("#useremail").val();
          if(email){
              var token = "<?php echo csrf_token(); ?>";
              $.ajax({
                  url: "<?php echo url('/');?>/checkCustomerUsername",
                  method: 'POST',
                  dataType: "json",
                  data: {'login_type':'Customer','email':email,'_token':token},
                  success: function(data){
                     if(data.status == "Success"){
                          $("#email_val").css('display','none');
                          return true;
                     }else{
                          $("#useremail").val('');
                          $("#email_val").html(data.message);
                          $("#email_val").css('display','block');
                          return false;
                     }
                  }
              });
          }
      }
    function checkPwdValidation(){
        var email = $("#useremail").val().trim();
        var password = $("#password").val().trim();
        if(password && email){
            var token = "<?php echo csrf_token(); ?>";
            $.ajax({
                url: "<?php echo url('/');?>/checkPassword",
                method: 'POST',
                dataType: "json",
                data: {'login_type':'Customer','email':email,'password':password,'_token':token},
                success: function(data){
                   if(data.status == "Success" && email){
                        $('#loginForm').submit();
                        //$("#myModal").modal("show");
                        return true;
                   }else{
                        $("#password").val('');
                        //$(".toggle-password").addClass('showHide_icon');
                        $("#err_msg_customer").html(data.message);
                        $("#err_msg_customer").css('display','block');
                        return false;
                   }
                }
            });
        }
    }

(function() {
    window.addEventListener('load', function() {
      var forms = document.getElementsByClassName('needs-validation');

      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          //console.log('hi');
            event.preventDefault();
            //$(".toggle-password").addClass('showHide_icon');
          if (form.checkValidity() === false) {
            event.stopPropagation();
          }else{
            $("#err_msg_customer").css('display','none');
            checkUserNameVal();
            checkPwdValidation();
          }

          form.classList.add('was-validated');

        }, false);

      });
    }, false);
  })();

var url = "<?php echo url('/').'/public/captchaImages/';?>";
var loginURL = "<?php echo url('/');?>/login";
/*$("#lgin_sign_btn").click(function(e){
    //$("#myModal").show();
    e.preventDefault();
    console.log('hi');

});*/

$("#force_login").click(function(){
    $("#force_logout").val(1);
    $('#loginForm').submit();
});
$("#cancel_btn").click(function(){
    $("#alertModal").hide();
});

$('#captcha').sliderCaptcha({
    loadingText: 'Loading...',
    failedText: 'Try It Again',
    barText: 'Slide the Puzzle',
//   repeatIcon: 'fa fa-repeat',
//   maxLoadCount: 3,
//   localImages: function () { // uses local images instead
//     return url+'Pic' + Math.round(Math.random() * 4) + '.jpg';
//   }
    repeatIcon: 'fa fa-redo',
    onSuccess: function () {
        var email = $("#useremail").val().trim();
        var password = $("#password").val().trim();
        if(email!='' && password!='') {
            $('#loginForm').submit();
        }
    }
});
$(function(){
    <?php if(Session::has('message') && Session::has('force_login')){
        if(Session::get('force_login') == 1) {?>
            $("#alertModal").show();
    <?php }
    }?>
});

var idleTime = 0;
$(document).ready(function () {
    //Increment the idle time counter every minute.
    var idleInterval = setInterval(timerIncrement, 60000); // 1 minute

    //Zero the idle timer on mouse movement.
    $(this).mousemove(function (e) {
        idleTime = 0;
    });
    $(this).keypress(function (e) {
        idleTime = 0;
    });
});

function timerIncrement() {
    idleTime = idleTime + 1;
    if (idleTime > 10) { // 20 minutes
        window.location.reload();
    }
}
</script>
</body>
</html>

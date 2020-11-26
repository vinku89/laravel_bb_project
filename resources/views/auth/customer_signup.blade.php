<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php

      if($referralId!=""){
        //echo "sridhar";exit;
     ?>
     <title> <?php echo "Here is your referral link: \n ".url('/customerSignup/')."/".$referralId.".\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy.";?></title>
     <?php
      }else{
    ?>
    <title>BestBOX - Customer Signup</title>
    <?php
      }
    ?>

    <link rel="shortcut icon" href="<?php echo url('/');?>/public/images/favicon.png" type="image/png" sizes="32x32" />
    <link rel="stylesheet" href="<?php echo url('/');?>/public/css/login.css">
   @include("inc.styles.all-styles")

  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>

  <style>
      body,
      html {
         overflow-y: auto !important;
      }
      .was-validated .form-control:valid {
         background: #FFFFFF;
         /* border: 2px solid #9B9B9B; */
         border-radius: 5px;
         min-height: 50px;
      }
      .note_text{
          width: 100%;
          margin-top: .25rem;
          font-size: 80%;
          color: #dc3545;
      }
      ul{
        text-decoration: none;
        text-align: left;
        line-height: 25px;
        font-size: 16px;
    }
    .infoDiv{
      position: absolute;
      background: #FAE9A3;
      border-radius: 6px;
      padding: 15px 10px;
      border: solid 1px #DCC265;
      color: #000;
      z-index: 9;
   }
.infoDiv:before{
   content: '';
    width: 0;
    height: 0;
    border-left: 9px solid transparent;
    border-right: 9px solid transparent;
    border-bottom: 11px solid #DCC265;
    position: absolute;
    top: -11px;
    left: calc(100% - 51.9%);
}
.infoDiv2:before{
   content: '';
    width: 0;
    height: 0;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    border-bottom: 15px solid #FAE9A3;
    position: absolute;
    top: -10px;
    left: calc(100% - 52%);
}
.close_infoDiv{
   position: absolute;
    right: 10px;
    top: 7px;
    cursor: pointer;
}
  </style>
</head>

<body>
   <div class="log_page body_bg">

      <div class="container" style="min-height: 100vh;">
         <div class="log_page_wrapper">
            <div class="log_page_wrapper_logo text-center">
               <a href="<?php echo url('/');?>"><img src="<?php echo url('/');?>/public/images/login_logo.png" /></a>
            </div>

            <div class="log_page_wrapper_title row m-auto text-center pt-5 pb-4">
               <div class="log_page_wrapper_title_signup col-6">
                  <a href="<?php echo url('/customerSignup');?>" class="active"> SIGNUP </a>
               </div>
               <div class="log_page_wrapper_title_signin col-6">
                  <a href="<?php echo url('/customerLogin');?>" class="">SIGNIN </a>
               </div>
            </div>

            <div class="f14 text-center color-black pb-4">PLEASE SIGN UP</div>

            <div class="log_page_wrapper_form">
               <form class="needs-validation" id="signupForm" novalidate action="<?php echo url('/');?>/saveReferralUser">

                  <div class="form-group">

                     <input type="text" class="form-control" id="first_name"  name="first_name" inputmode="text" pattern="[ a-zA-Z][a-zA-Z ]+[a-zA-Z ]$" placeholder="First Name" required
                        minlength="3">
                     <!-- <div class="valid-feedback">
                        Great!
                     </div> -->
                     <div class="invalid-feedback">
                       First Name required with atleast 3 characters.
                     </div>
                  </div>

                  <div class="form-group">

                     <input type="text" class="form-control" id="last_name"  name="last_name" pattern="[ a-zA-Z][a-zA-Z ]+[a-zA-Z ]$" placeholder="Last Name" required
                        minlength="3">
                     <!-- <div class="valid-feedback">
                        Great!
                     </div> -->
                     <div class="invalid-feedback">
                        Last Name required with atleast 3 characters.
                     </div>
                  </div>

                  <div class="form-group position-relative">

                     <input type="text" class="form-control txtShowDiv" id="referralId" name="referralId" value="{{ !empty($referralId) ? $referralId : '' }}" placeholder="Referral Code" required>
                     <div class="infoDiv " style="display:none;">
                        <span class="infoDiv2"></span>
                        <a class="close_infoDiv"><i class="fa fa-times" aria-hidden="true"></i></a>
                              <p class="text-center font-weight-bold mb-4 mt-2">Fill in your referral code here and get $10 Reward!</p>
                              <p class="mb-4">If you do not have a referral code, please contact your local sales agent.</p>
                              <p>If you were not recommended by a BestBOX sales agent, kindly contact BestBOX directly on <a href="mailto:sales@bestbox.net" style="color:#A02C72">sales@bestbox.net</a> to obtain a referral code.</p>
                     </div>

					  <div class="invalid-feedback">
                        Please enter referral Id
                     </div>

                  </div>

                  <div class="font-bold f14 color-black pb-3 pt-2">
                     Login Credentials
                  </div>

                  <div class="form-group">
                     <input type="text" name="email"style="display:none;">
                     <input type="email" class="form-control" pattern="[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})" id="email" name="email" placeholder="Email ID" autocomplete="off" autocorrect="off" autocapitalize="off" required readonly="readonly">
                     <!-- <div class="valid-feedback">
                        Looks good!
                     </div> -->
                     <div class="invalid-feedback">
                        Please Provide Valid Email Id.
                     </div>
                     <span class="f14" id="emailErr"></span>
                  </div>

                  <div class="form-group">
                     <input type="text" name="password"style="display:none;">
                     <input type="password" class="form-control" pattern="(?=.*\d)(?=.*[a-z]).{8,}" id="password" name="password" placeholder="Password" autocomplete="off" autocorrect="off" autocapitalize="off" required readonly="readonly">
                     <!-- <div class="valid-feedback">
                        Looks good!
                     </div> -->
                     <div class="invalid-feedback">
                        Password should be minimum 8 characters with alphanumeric
                     </div>
                     <div class="position-relative note_text" id="pwd_val">
                          <div>Password should be minimum 8 characters with alphanumeric</div>
                      </div>
                  </div>

                  <div class="form-group">

                     <input type="password" class="form-control" pattern="(?=.*\d)(?=.*[a-z]).{8,}" id="confirm_password" name="password_confirmation" placeholder="Confirm Password" required>
                     <!-- <div class="valid-feedback">
                        Looks good!
                     </div> -->
                     <div class="invalid-feedback" id="err_msg_customer">
                        Please Confirm Password.
                     </div>
                  </div>

                  <div class="form-group mt-4">
                     <button class="btn btn-primary d-block h50 btn-log w-100" type="submit">SIGNUP</button>
                  </div>
               </form>
            </div>

            <div class="log_page_footer mb-3">
               <div class="m-auto text-center">
                  <div class="d-inline mx-2">
                     <a class="color-link-dark" href="<?php echo url('/terms_of_use'); ?>">Terms and Conditions</a>
                  </div>
                  <div class="d-inline">
                    |
                  </div>
                  <div class="d-inline mx-2">
                     <a class="color-link-dark" href="<?php echo url('/privacy_policy'); ?>">Privacy Policy</a>
                  </div>
               </div>

               <div class="m-auto text-center color-dark">
                  Copyright © <?php echo date('Y');?> BestBox. All rights reserved.
               </div>
               <p class="mt-3 font12 black_txt text-center">
                  This site is fully compatible with 
                  <span class="mx-1"><img src="<?php echo url('/');?>/public/website/assets/images/google-chrome.png" class="img-fluid" style="width: 22px; height: auto;"></span> Google Chrome and 
                  <span class="mx-1"><img src="<?php echo url('/');?>/public/website/assets/images/firefox.png" class="img-fluid"></span> Mozilla Firefox browsers
               </p>

            </div>
         </div>
      </div>
   </div>

<?php
        if(Session::has('error')){
    ?>
        <script type="text/javascript">
            swal(
                'Failure',
                '<?php echo Session::get('error');?>',
                'error'
            )
        </script>
    <?php
        }
    ?>

    <?php
        if(Session::has('message')){
    ?>
        <script type="text/javascript">
            setTimeout(function() {
                swal({
                    title: "Success",
                    text: "<?php echo Session::get('message');?>",
                    type: "success"
                }).then(function() {
                    location.href="<?php echo url('/customerLogin');?>";
                });
            }, 50);
        </script>
    <?php
        }
    ?>
<!-- All scripts include -->

   <script>

$(document).ready(function(){
   $('.txtShowDiv').focus(function(){
       $('.infoDiv, .close_infoDiv').fadeIn('');
   }).focusout(function(){
       $('.infoDiv, .close_infoDiv').fadeOut('');
   });
});

    $(document).ready(function(){

        $("#email").focus(function(){
          this.removeAttribute('readonly');
        });
        $("#password").focus(function(){
          this.removeAttribute('readonly');
        });

        $("#email").blur(function(){
          var email = $(this).val();
          var csrf_Value= "<?php echo csrf_token(); ?>";
          $.ajax({
              url: "<?php echo url('/');?>/checkEmailExist",
              method: 'POST',
              dataType: "json",
              data: {'email': email,"_token": csrf_Value},
              success: function(data){

                  if(data.status == "Success"){
                      $("#emailErr").html(data.Result);
                      $("#emailErr").addClass("green_txt").removeClass("red_txt");
                 }else{
                      $("#emailErr").html(data.Result);
                      $("#email").val("");
                      $("#emailErr").addClass("red_txt").removeClass("green_txt");
                 }

              }
          });
      });
    });

    function checkPwdValidation(){
        var password = $("#password").val();
        var confirm_password = $("#confirm_password").val();
        if(password == confirm_password){
            $('#signupForm').submit();
            return true;
        }else{
          $("#confirm_password").val('');
          $("#err_msg_customer").html('The password confirmation does not match.');
          $("#err_msg_customer").css('display','block');
          return false;
        }
    }

  (function() {
    window.addEventListener('load', function() {
      var forms = document.getElementsByClassName('needs-validation');

      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          event.preventDefault();
          if (form.checkValidity() === false) {
            event.stopPropagation();
          }else{
            $("#err_msg_customer").css('display','none');
            checkPwdValidation();
          }

          form.classList.add('was-validated');
          $('#emailErr').html("");
          $('#pwd_val').html("");
        }, false);
      });
    }, false);
  })();

  $("#first_name").on("keypress keyup blur",function (event) {

        var key = event.keyCode || event.which;
        if((key >= 65 && key <= 90) || (key >= 97 && key <= 123) || key == 32)
        {
          //true
        }else{
          event.preventDefault();
        }
  });

  $("#last_name").on("keypress keyup blur",function (event) {

        var key = event.keyCode || event.which;
        if((key >= 65 && key <= 90) || (key >= 97 && key <= 123) || key == 32)
        {
          //true
        }else{
          event.preventDefault();
        }
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

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>BestBOX</title>
<link rel="shortcut icon" href="<?php echo url('/');?>/public/images/favicon.png" type="image/png" sizes="32x32" />


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
<link rel="stylesheet" href="<?php echo url('/');?>/public/css/style.css">
<link rel="stylesheet" href="<?php echo url('/');?>/public/css/common.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
<style>
.swal2-content ul{

  text-align: left;
    line-height: 25px;
    font-size: 16px;
}
.note_text{

        font-size: 13px;
        color: red;
        text-align: left;
        line-height: 16px;

    }
    @media (max-width:470px){
        .note_text{
            width:50%;
        }
        .mbl-margin{
            margin-bottom: 50px;
        }
    }
</style>
</head>
<body class="template_bg">
    <div class="box innerBox">
          <div class="login_box ">
              <div class="login-logo">
                  <a href="<?php echo url('/');?>"><img src="<?php echo url('/');?>/public/images/login_logo.png"></a>
              </div>
              <h4 class="font16 text-uppercase text-center mb-5 black_txt">Reset Your Password</h4>

              <div class="col-12 mb-2">
                    <form method="post" action="<?php echo url('/resetNewPassword');?>">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="mb-2">
                         <div class="position-relative input-wrap is-required">
                            <input type="password" id="new_password" name="password" placeholder="New Password *" required  autocomplete="off" autocorrect="off" autocapitalize="off">
                            <div class="invalid-feedback">
                              Please Provide Correct Email Id.
                           </div>
                            <span class="icon validation small" style="color:black;">
                                    <i class="fa fa-fw field-icon toggle-password fa-eye-slash" toggle="#new_password" ></i>
                            </span>

                         </div>
                         <div class="is-helpful" data-helper="Enter New Password" data-error="Please enter New Password"></div>
                         <div class="text-right f14 w-100 position-relative">
                              <div class="note_text">Password should be minimum 8 characters with alphanumeric</div>
                          </div>
                        </div>
                        <div>
                         <div class="relative input-wrap is-required">
                            <input type="password" id="confirm_password" name="password_confirmation" placeholder="Confirm Password *" required  autocomplete="off" autocorrect="off" autocapitalize="off">

                            <span class="icon validation small" style="color:black;">
                                    <i class="fa fa-fw field-icon toggle-password fa-eye-slash" toggle="#confirm_password" ></i>
                            </span>
                           </div>
                        <div class="is-helpful" data-helper="Enter Confirm password" data-error="Please enter Confirm password"></div>

                        </div>
                        <input type="hidden" value="{{ $encryptedString }}" name="encrypted_string" />
                      <button type="submit" class="btn button-primary d-block w-100 mt-4 lgin_sign_btn" >Reset Password</button>
                    </form>

                    <div class="login_footer_txt  mt-4 mb-5 clearfix">
                        <p class="font12 black_txt text-center">
                        <a href="#" class="black_txt">Terms & Conditions</a> | <a href="#" class="black_txt">Privacy Policy</a>  <br>
                        Copyright © <?php echo date('Y');?> BestBOX. All rights reserved.
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
                  <?php
                    if(Session::get('role') == 4){
                      ?>
                      location.href="<?php echo url('/customerLogin');?>";
                    <?php }else{ ?>
                      location.href="<?php echo url('/login');?>";
                    <?php }
                    ?>

                });
            }, 50);
        </script>
    <?php
        }
    ?>

</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="<?php echo url('/');?>/public/js/form_validations.js"></script>
<script src="<?php echo url('/');?>/public/js/common.js" type=""></script>

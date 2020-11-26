<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>BestBOX - Forgot Password</title>
<link rel="shortcut icon" href="<?php echo url('/');?>/public/images/favicon.png" type="image/png" sizes="32x32" />


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
<link rel="stylesheet" href="<?php echo url('/');?>/public/css/style.css">
<link rel="stylesheet" href="<?php echo url('/');?>/public/css/common.css">

<style>
input {
    background: #FFFFFF;
    border: 2px solid #9B9B9B;
    border-radius: 5px;
    min-height: 50px; }
</style>


</head>
<body class="template_bg">
    <div class="box innerBox">
                <div class="login_box ">
                    <div class="login-logo">
                        <a href="<?php echo url('/');?>"><img src="<?php echo url('/');?>/public/images/login_logo.png"></a>
                    </div>
                    <div class="text-center f14">
                        @if(Session::has('message'))
                            <div class="error-wrapper {{ (Session::get('alert') == 'Success') ? 'badge-success' : 'badge-danger' }} badge my-2">
                                {{ Session::get('message') }}
                            </div>
                        @endIf
                    </div>
                    <div class="col-12 mb-2 clearfix">
                        <h3 class="font16 black_txt text-center mb-4 font-bold">FORGOT PASSWORD</h3>

                        <p class="font14 black_txt text-center dark-grey_txt mb-4">Enter your email address to receive an email with a reset link</p>
                        <form method="post" action="<?php echo url('/sendForgotPasswordEmail');?>">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="mb-4">
                                 <div class="position-relative input-wrap is-required">
                                    <input id="email" type="email" name="email" placeholder="Email *"  autocomplete="off" autocorrect="off" autocapitalize="off" >
                                    <span class="icon validation small success hide">
                                       <i class="fas fa-check"></i>
                                    </span>
                                    <span class="icon validation small error hide">
                                       <!-- <span class="far fa-remove"></span> -->
                                       <i class="fas fa-times"></i>
                                    </span>
                                 </div>
                                 <div class="is-helpful" data-helper="Enter Email" data-error="Please enter your email"></div>
                              </div>

                        <div class="col-12 mb-5">
                            <div class="row">
                                <div class="col-6 pl-0"><a href="<?php echo $back;?>" class="btn back_btn">BACK</a></div>
                                <div class="col-6 pr-0"><button class="btn submit_btn">SEND</button></div>
                            </div>

                        </div>

                        <div class="login_footer_txt">
                                <p class="font12 black_txt text-center">
                                <a href="#" class="black_txt">Terms & Conditions</a> | <a href="#" class="black_txt">Privacy Policy</a>  </br>
                                Copyright © <?php echo date('Y');?> BestBOX. All rights reserved.
                                </p>
                            </div>


                        </form>
                    </div>
                </div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="<?php echo url('/');?>/public/js/form_validations.js"></script>
<script src="<?php echo url('/');?>/public/js/common.js" type=""></script>

</body>
</html>

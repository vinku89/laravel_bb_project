<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>BestBOX</title>
<link rel="shortcut icon" href="favicon.png" type="image/png" sizes="32x32" />


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
<link rel="stylesheet" href="<?php echo url('/');?>/public/css/style.css">
<link rel="stylesheet" href="<?php echo url('/');?>/public/css/common.css">


</head>
<body class="template_bg">
    <div class="box innerBox">
                <div class="login_box ">
                    <div class="login-logo">
                        <img src="<?php echo url('/');?>/public/images/login_logo.png">
                    </div>
                    <div class="text-center">
                        <?php if(Session::has('message')){ ?>   
                            <div class="error-wrapper badge-danger my-2">
                            <?php echo Session::get('message');?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="login_inner_div clearfix">
                        <form method="post" action="<?php echo url('/checkLogin');?>">
                            {{ csrf_field() }}
                        <div class="input-group mb-4">
                            <input type="text" id="useremail" name="email" class="form-control input_height" placeholder="Email Id">
                        </div>
                        <div class="input-group mb-1 position-relative">
                            <input type="password" class="form-control input_height"  id="exampleInputPassword1" name="password" placeholder="Password" id="password-field">
                            <i class="fa fa-fw field-icon toggle-password fa-eye" toggle="#password-field" ></i>
                        </div>
                        <a href="#" class="font12 mb-4">Forgot password?</a>

                        <div class="clearfix">
                                <button type="submit" class="btn btn-primary btn-block">LOGIN</button>
                        </div>
                      
                            
                        </form>
                    </div> 
                </div>
    </div>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.slim.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script src="<?php echo url('/');?>/public/js/common.js" type=""></script>
</body>
</html>
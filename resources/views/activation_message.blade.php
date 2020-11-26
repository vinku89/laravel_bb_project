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
<style>
.swal2-content ul{
	
	text-align: left;
    line-height: 25px;
    font-size: 16px;
}	
</style>
</head>
<body class="template_bg">
    <div class="box innerBox">
        <div class="login_box ">
            <div class="login-logo">
                <a href="<?php echo url('/');?>"><img src="<?php echo url('/');?>/public/images/login_logo.png"></a>
            </div>
            <h4 class="font16 text-uppercase text-center mb-5 black_txt">Account Verification</h4>
            <div class="text-center">
                   
                    <div class="error-wrapper badge-success badge my-2">
                        {{ !empty($message) ? $message : '' }}
                    </div>
                
            </div>
            
        </div>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://dev.bestbox.net/public/js/form_validations.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
<script src="<?php echo url('/');?>/public/js/common.js" type=""></script>

</body>
</html>
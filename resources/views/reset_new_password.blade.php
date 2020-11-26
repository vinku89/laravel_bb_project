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
            <h4 class="font16 text-uppercase text-center mb-5 black_txt">Set New Password</h4>
            <div class="text-center">
                @if(Session::has('message'))   
                    <div class="error-wrapper {{ (Session::get('alert') == 'Success') ? 'badge-success' : 'badge-danger' }} badge my-2">
                        {{ Session::get('message') }}
                    </div>
                @endIf
                @if($errors->any())
                    <h4>{{$errors->first()}}</h4>
                @endif
            </div>
            <div class="login_inner_div clearfix">
                 <form id="set_pwd_form" method="post">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="input-group mb-4">
                        <input type="hidden" name="rec_id" value="<?php echo encrypt($rec_id);?>">
                        <input type="password" class="form-control input_height" placeholder="Password" id="password" name="password" required>
                        <p class="f11 text-left mb-0" style="color: red;">Password should be minimum 8 characters with alphanumeric</p>
                        <i class="fa fa-fw field-icon toggle-password fa-eye" toggle="#password" ></i>
                    </div>
                    <div class="input-group mb-1 position-relative">
                        <input type="password" class="form-control input_height" placeholder="Confirm Password" id="password_confirmation" name="password_confirmation" required>
                        <i class="fa fa-fw field-icon toggle-password fa-eye" toggle="#password_confirmation" ></i>
                    </div>

                    <div class="clearfix">
                            <button type="submit" class="btn submit_btn">Update</button>
                    </div>
                </form>
            </div> 
        </div>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://dev.bestbox.net/public/js/form_validations.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
<script src="<?php echo url('/');?>/public/js/common.js" type=""></script>
<script type="text/javascript">

  $("#set_pwd_form").submit(function(e){
    e.preventDefault();
    $.ajax({
            type: 'POST',
            url: "<?php echo url('/');?>/restnewpwd",
            data: $( this ).serialize(),
            dataType: "json",
            success: function (data) {
              console.log(data);
                if (data.status == "Success") {
                    setTimeout(function() {
                        swal({
                            title: "Success",
                            text: data.message,
                            type: "success"
                        }).then(function() {
                            if(data.role == 4){
                              location.href="<?php echo url('customerLogin'); ?>";
                            }else{
                              location.href="<?php echo url('login'); ?>";
                            }
                        });
                    }, 50);
                } else {
                    swal({
                      title: "Failure",
                      text: "",
                      type: "error",
					  html: data.message,
                    });
                }
            }
        });
    }); 
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Change Password</title>
    <link rel="shortcut icon" href="<?php echo url('/');?>/public/images/favicon.png" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @if($userInfo['user_role'] == 4)
        @include("customer.inc.all-styles")
    @else
        @include("inc.styles.all-styles")
    @endIf
    <style>
    .swal2-content ul{

        text-align: left;
        line-height: 25px;
        font-size: 16px;
    }
    .note_text{
        position: absolute;
        width: 70%;
        top: 0;
        font-size: 13px;
        color: red;
        text-align: left;
        line-height: 16px;
        top: 10px;
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

<body>
    <!-- <div class="overlay-bg"></div> -->
    <!-- Side bar include -->
    @include("inc.sidebar.sidebar")
    <div class="main-content commission_report_details">
        <!-- Header Section Start Here -->
         @include("inc.header.header")
        <!-- Header Section End Here -->
        <section class="main_body_section scroll_div">
            <h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3 pl-3">Change Password</h5>


            <div class="col-lg-7 col-xl-5 col-md-10">

                <div class="clearfix">
                        <form method="post" id="changePwdForm" action="<?php echo url('/updateNewPassword');?>">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                                <div class="input-group mb-3">
                                    <input id="password-field" name="current_password"  type="password" class="form-control border-bottom-only with_addon_icon body_bg" placeholder="Enter Current Password" aria-label="Name" aria-describedby="basic-addon2" value="{{ old('current_password') }}" required>
                                    <span toggle="#password-field" class="fas fa-eye-slash field-icon toggle-password"></span>
                                    <div class="text-left f14 w-100 pt-2"><span id="curpwdErr"></span></div>
                                    <div class="text-right f14 w-100 pt-2">
                                        <span class="text-danger">*</span>
                                        <span id="emailHelp" class="text-muted f14 black_txt">Current Password</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mbl-margin">
                                <div class="input-group mb-3">
                                    <input id="password-field2" name="password" type="password" class="form-control border-bottom-only with_addon_icon body_bg" placeholder="Enter New Password" aria-label="Name" aria-describedby="basic-addon2" value="{{ old('password') }}" required>
                                    <span toggle="#password-field2" class="fas fa-eye-slash field-icon toggle-password"></span>

                                    <div class="text-right f14 w-100 pt-2 position-relative">
                                        <div class="note_text">Password should be minimum 8 characters with alphanumeric</div>
                                        <span class="text-danger">*</span>
                                        <span id="emailHelp" class="text-muted f14 black_txt">New Password</span>
                                    </div>



                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input id="password-field3" name="password_confirmation" type="password" class="form-control border-bottom-only with_addon_icon body_bg" placeholder="Enter Confirm Password" aria-label="Name" aria-describedby="basic-addon2" value="{{ old('password_confirmation') }}" required>
                                    <span toggle="#password-field3" class="fas fa-eye-slash field-icon toggle-password"></span>
                                    <div class="text-left f14 w-100 pt-2"><span id="confpwdErr"></span></div>
                                    <!-- <div class="text-right f14 w-100 pt-2">
                                        <span class="text-danger">*</span>
                                        <span id="emailHelp" class="text-muted f14 black_txt">Confirm Password</span>
                                    </div> -->
                                    <div class="text-right f14 w-100 pt-2 position-relative">
                                        <span class="text-danger">*</span>
                                        <span id="emailHelp" class="text-muted f14 black_txt">Confirm Password</span>
                                    </div>
                                </div>
                            </div>

                            <div class="my-4">
                            <div class="display_inline">
                                <a href="{{ url('/').'/dashboard' }}" class="btn_cancel">
                                    CANCEL
                                </a>
                            </div>

                            <div class="display_inline">
                                <button type="submit" class="btn btn_primary d-block w-100 mt-4" id="change_password">Save</button>
                            </div>
                        </div>
                        </form>
                </div>
            </div>


        </section>
    </div>

<!-- Alert Modal -->
<div class="modal" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title font-bold {{ (Session::get('alert') == 'Success') ? 'green_txt' : 'red_txt' }}">@if(Session::has('message')) {{ Session::get('alert') }} @endIf</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body text-center {{ (Session::get('alert') == 'Success') ? 'green_txt' : 'red_txt' }}">
            @if(Session::has('message')) {{ Session::get('message') }} @endIf
      </div>
     <!-- Modal footer -->
      <div class="inline-buttons">
            <button type="button" class="btn inline-buttons-center btn_primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<script>
    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    $("#change_password").click(function(e){
        e.preventDefault();
        var current_password = $("#password-field").value;
        var new_password = $("#password-field2").value;
        var confirm_password = $("#password-field3").value;
        var error = false; $("#curpwdErr #newpwdErr #confpwdErr").html('');
        if(current_password == ''){
            $("#curpwdErr").html('Current Password Field Required');
            error = true;
        }
        if(new_password == ''){
            $("#newpwdErr").html('New Password Field Required');
            error = true;
        }
        if(confirm_password == ''){
            $("#confpwdErr").html('Confirm Password Field Required');
            error = true;
        }
        if(!error){
            $('#changePwdForm').submit();
        }
    });

</script>
    <!-- All scripts include -->
     @include("inc.scripts.all-scripts")

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
                    location.href="<?php echo url('/logout');?>";
                });
            }, 50);
        </script>
    <?php
        }
    ?>
</body>

</html>

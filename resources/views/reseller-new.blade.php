<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX</title>
    <link rel="shortcut icon" href="{{ url('/').'/public/favicon.png' }}" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include("inc.styles.all-styles")
    <style>
         .select2-container--default .select2-selection--single{
            background-color:transparent !important;
            border:none !important;
            border-bottom: solid 3px #7f868b !important;
            border-radius: 0;
        }
        .select2-container .select2-selection--single{
            height:33px !important;
        }
        .select2-selection__rendered[title="Select Country"]{
            font-size:14px !important;
            color: #737a82 !important;
        }
        .fa-angle-left{
            font-size: 20px;
            line-height: 25px;
            margin-right: 5px;
            color: #0091d6;
        }
    </style>
</head>
<body>
    <!-- Side bar include -->
    @include("inc.sidebar.sidebar")
    <div class="main-content">
        <!-- Header Section Start Here -->
        @include("inc.header.header")
        <!-- Header Section End Here -->
        <section class="main_body_section scroll_div">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb pl-0">
                    <i class="fas fa-angle-left"></i>
                <li class="breadcrumb-item f16"><a href="{{ url('/').'/resellers' }}" class="f16">Reseller</a></li>
                    <li class="breadcrumb-item active f16" aria-current="page" class="f16">Add New Reseller</li>
                </ol>
            </nav>

            <h5 class="font16 font-bold text-uppercase black_txt pt-4 mb-5">Add New Reseller</h5>
            <div class="row">
                <div class="col-md-6">

                </div>
            </div>
            <div class="text-center f14">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ strip_tags(str_replace("'",'',$errors->first())) }}
                        </div>
                    @endif
                    @if(Session::has('message'))
                        <div class="error-wrapper {{ (Session::get('alert') == 'Success') ? 'badge-success' : 'badge-danger' }} badge my-2">
                            {{ Session::get('message') }}
                        </div>
                    @endIf
                </div>
            <div class="clearfix row">
                <div class="col-12">
                    <div class="form-width">
                        <!-- <table class="rwd-table body_bg">

                        </table> -->
                        <form method="post" id="create_form" name="create_form" action="<?php echo url('/').'/createReseller';?>" class="needs-validation" novalidate>
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <!-- Agent Email -->
                        <div class="form-group">
                            <input type="email" pattern="[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})" class="form-control border-bottom-only body_bg" id="email" name="email" aria-describedby="email" placeholder="Email" value="{{ old('email') }}" required>
                            <div class="text-right f14">
                                <span class="text-danger">*</span><span id="email" class="text-muted f14 black_txt">Reseller Email</span>
                            </div>
                            <div class="invalid-feedback">
                                Please Provide Valid Email Id.
                            </div>
                            <span class="f14 red_txt" id="emailErr"></span>
                         </div>

                         <div class="form-group position-relative">
                            <input type="text" name="password" style="display:none;">
                            <input type="password" class="form-control border-bottom-only body_bg" pattern="(?=.*\d)(?=.*[a-z]).{8,}" id="password" name="password" placeholder="Password" autocomplete="off" autocorrect="off" autocapitalize="off" required>
                            <span class="icon validation small" style="color:black;">
                                <i class="fa fa-fw field-icon toggle-password fa-eye-slash" toggle="#password" style="top:-5px" ></i>
                            </span>
                            <div class="text-right f14"><span class="text-danger">*</span><span id="password" class="text-muted f14 black_txt">Password</span></div>
                            <!-- <div class="valid-feedback">
                               Looks good!
                            </div> -->
                            <div class="invalid-feedback">
                               Password should be minimum 8 characters with alphanumeric
                            </div>
                            
                         </div>

                         <div class="form-group position-relative">

                            <input type="password" class="form-control border-bottom-only body_bg" pattern="(?=.*\d)(?=.*[a-z]).{8,}" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                            <span class="icon validation small" style="color:black;">
                                <i class="fa fa-fw field-icon toggle-password fa-eye-slash" toggle="#confirm_password" style="top:-5px"></i>
                            </span>
                            <div class="text-right f14"><span class="text-danger">*</span><span id="confirm_password" class="text-muted f14 black_txt">Confirm Password</span></div>
                            <!-- <div class="valid-feedback">
                               Looks good!
                            </div> -->
                            <div class="invalid-feedback">
                               Password and Confirm password should be same
                            </div>
                            <span class="f12 red_txt" id="pwdErr"></span>
                         </div>

                        <!-- First Name -->
                        <div class="form-group">
                            <input type="text" class="form-control border-bottom-only body_bg" id="first_name"  name="first_name" aria-describedby="first_name" placeholder="First Name" value="{{ old('first_name') }}" pattern="[ a-zA-Z][a-zA-Z ]+[a-zA-Z ]$" minlength="3" maxlength="255" required>
                            <div class="text-right f14"><span class="text-danger">*</span><span id="first_name" class="text-muted f14 black_txt">First Name</span></div>
                            <div class="invalid-feedback">
                               First Name required with atleast 3 characters.
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="form-group">
                            <input type="text" class="form-control border-bottom-only body_bg"  id="last_name"  name="last_name" aria-describedby="last_name" placeholder="Last Name" value="{{ old('last_name') }}" pattern="[ a-zA-Z][a-zA-Z ]+[a-zA-Z ]$" minlength="3" maxlength="255" required>
                            <div class="text-right f14"><span class="text-danger">*</span><span id="last_name" class="text-muted f14 black_txt">Last Name</span></div>
                             <div class="invalid-feedback">
                                Last Name required with atleast 3 characters.
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="mobile_menu_section body_bg form-group">
                            <select class="normal_select" name="gender" id="gender">
                                <option value="" class="dk_placeholder">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <div class="text-right f14"><span id="emailHelp" class="text-muted f14 black_txt">Gender</span></div>
                             <div id="gender_err" class="f14 red_txt"></div>
                        </div>

                        <!-- Address -->
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="font-bold black_txt">Address</label>
                            <textarea id="shipping_address" name="shipping_address" rows="10" data-sample-short></textarea>
                            <div class="f12 mt-3 red_txt" id="shipAddrErr"></div>
                        </div>

                        <!-- Country -->
                        <div class="mobile_menu_section body_bg form-group">
                            <select id="select_country" name="country">
                                <option value="" data-id="" class="font14">Select Country</option>
                                <?php
                                    foreach ($country_data as $val) {
                                        echo "<option value='".$val->countryid."' data-id='".$val->currencycode."'>".$val->country_name."</option>";
                                    }
                                ?>
                            </select>
                            <div class="text-right f14"><span id="emailHelp" class="text-muted f14 black_txt">Country</span></div>
                            <div id="country_err" class="f14 red_txt"></div>
                        </div>

                        <!-- Mobile Number -->
                        <div class="form-group row">
                            <div class="col-3">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control border-bottom-only  body_bg"
                                        placeholder="Code" aria-label="Mobile number"
                                        aria-describedby="basic-addon2" value="{{ old('country_code') }}" name="country_code" id="country_code" readOnly>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="input-group mb-3">
                                    <input type="text" class="border-bottom-only  body_bg" placeholder="Mobile Number" aria-label="Mobile number" aria-describedby="basic-addon2" id="mobile" name="mobile" value="{{ old('mobile') }}" pattern="[0-9]{8,14}">
                                    <div class="text-right f14 w-100 pt-2">
                                        <span id="telErrorMsg" class="f14 error_txt"></span>
                                        <span id="emailHelp" class="text-muted f14 black_txt">Mobile number</span>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please Provide Correct Mobile Number.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Agent Commission Percentage -->
                        <div class="form-group">
                            <div class="input-group mb-3 text-green">
                                <input type="number" class="form-control border-bottom-only with_addon_icon text-green body_bg" placeholder="00" id="commission_perc" name="commission_perc" aria-label="Agent Commission Percentage" aria-describedby="basic-addon2" value="{{ old('commission_perc') }}" max="<?php echo $userInfo->commission_perc;?>" min="0" required>
                                <span class="input-group-text no-border no-bg text-success addon_icon">%</span>
                               <div class="text-right f14 w-100 pt-2"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Commission Percentage</span></div>
                               <div class="invalid-feedback">
                                    Commission percentage required and max percentage is {{ $userInfo->commission_perc }} %.
                                </div>
                            </div>
                        </div>

                        <div class="my-4">
                            <div class="display_inline">
                                <a href="{{ url('/').'/resellers' }}" class="btn_cancel">CANCEL</a>
                            </div>
                            <div class="display_inline">
                                <button type="submit" class="btn btn_primary d-block w-100 mt-4 " >CREATE</button>
                            </div>
                        </div>

                    </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")

     <?php
        if(Session::has('result')){
    ?>
        <script type="text/javascript">
            setTimeout(function() {
                swal({
                    title: "Success",
                    text: "<?php echo Session::get('result');?>",
                    type: "success"
                });
            }, 50);
        </script>
    <?php
        }
    ?>

    <script type="text/javascript">

    CKEDITOR.replace('shipping_address', {
        height: 150
    });

    $("#select_country").change(function(e) {
            var country_code =  $('option:selected', this).attr('data-id');
            if(country_code != ""){
                $("#country_code").val('+'+country_code);
                $("#mobile").removeClass('form-control').addClass('form-control');
                $("#mobile").prop('required',true);
            }else{
                $("#country_code").val('');
                $("#mobile").val('');
                $("#mobile").removeClass('form-control');
                $("#mobile").prop('required',false);
            }
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
                if(data.status == "Not valid"){
                    $("#emailErr").html("");
               }
               else if(data.status == "Success"){
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

    $("#mobile").on("keypress keyup blur",function (event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
    $('#select_country').select2();

      (function() {
            window.addEventListener('load', function() {
              var forms = document.getElementsByClassName('needs-validation');

              var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {

                  if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                  }
                  var password = $('#password').val();
                  var confirm_password = $('#confirm_password').val();
                  console.log(confirm_password);
                  if((password !='' && confirm_password != '') && (password != confirm_password)){
                    $("#pwdErr").html('Password and Confirm password should be same');
                    $("#pwdErr").addClass("red_txt");
                    event.preventDefault();
                    event.stopPropagation();
                   }else{
                    $("#pwdErr").html('');
                    $("#pwdErr").removeClass("red_txt");
                   }
                form.classList.add('was-validated');
                  

                  $('#emailErr').html("");
                  

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
</script>
</body>
</html>

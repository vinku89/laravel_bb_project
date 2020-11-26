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
                <li class="breadcrumb-item f16"><a href="{{ url('/').'/resellers' }}" class="f16">Admin User</a></li>
                    <li class="breadcrumb-item active f16" aria-current="page" class="f16">Edit Admin User</li>
                </ol>
            </nav>

            <h5 class="font16 font-bold text-uppercase black_txt pt-4 mb-5">Edit Admin User</h5>
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
                        <form method="post" id="create_form" name="create_form" action="<?php echo url('/').'/updateAdminUser';?>" class="needs-validation" novalidate>
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <!-- Agent Email -->
                        <div class="form-group">
                            <input type="email" pattern="[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})" class="form-control border-bottom-only body_bg" id="email" name="email" aria-describedby="email" placeholder="Email" required value="<?php echo $admin_user['email'];?>" readonly>
                            <span class="f14 red_txt" id="emailErr"></span>
                            <div class="text-right f14">
                                <span class="text-danger">*</span><span id="email" class="text-muted f14 black_txt">Email</span>
                            </div>
                            <div class="invalid-feedback">
                                Please Provide Valid Email Id.
                            </div> 
                         </div>

                        <!-- First Name -->
                        <div class="form-group">
                            <input type="text" class="form-control border-bottom-only body_bg" id="first_name"  name="first_name" aria-describedby="first_name" placeholder="First Name" minlength="3" maxlength="255" required value="<?php echo $admin_user['first_name'];?>">
                            <div class="text-right f14"><span class="text-danger">*</span><span id="first_name" class="text-muted f14 black_txt">First Name</span></div>
                            <div class="invalid-feedback">
                               First Name id required and atleast 3 characters.
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="form-group">
                            <input type="text" class="form-control border-bottom-only body_bg"  id="last_name"  name="last_name" aria-describedby="last_name" placeholder="Last Name" minlength="3" maxlength="255" required value="<?php echo $admin_user['last_name'];?>">
                            <div class="text-right f14"><span class="text-danger">*</span><span id="last_name" class="text-muted f14 black_txt">Last Name</span></div>
                             <div class="invalid-feedback">
                                Last Name id required and atleast 3 characters.
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="mobile_menu_section body_bg form-group">
                            <select class="normal_select" name="gender" id="gender">
                                <option value="" class="dk_placeholder">Select Gender</option>
                                <option value="Male" <?php if($admin_user['gender']=='Male'){ echo "selected";} ?>>Male</option>
                                <option value="Female" <?php if($admin_user['gender']=='Female'){ echo "selected";} ?>>Female</option>
                            </select>
                            <div class="text-right f14"><span id="emailHelp"
                                    class="text-muted f14 black_txt">Gender</span></div>
                             <div id="gender_err" class="f14 red_txt"></div>
                        </div>

                        

                        <!-- Address -->
                        <div class="text-center my-2 f14 font-bold color-black">ADDRESS</div>

                        <!-- Address Line 1 -->
                        <div class="form-group">
                            <input type="name" class="form-control border-bottom-only body_bg" id="address" name="address" aria-describedby="emailHelp" placeholder="Address Line 1" value="<?php echo $admin_user['address'];?>" >
                            <div class="text-right f14"><span id="emailHelp" class="text-muted f14 black_txt">Address Line 1</span></div>
                             <div class="invalid-feedback">
                                Please Provide Address LIne 1.
                            </div>
                        </div>
                        <!-- Address Line 2 -->
                        <div class="form-group">
                            <input type="address" class="form-control border-bottom-only body_bg" id="address2" name="address2" aria-describedby="emailHelp" placeholder="Address Line 2" value="<?php echo $admin_user['address2'];?>" >
                            <div class="text-right f14"><span id="emailHelp" class="text-muted f14 black_txt">Address Line 2</span></div>
                             <div class="invalid-feedback">
                                Please Provide Address LIne 2.
                            </div>
                        </div>
                        <!-- Pin code -->
                        <div class="form-group">
                            <input type="text" class="form-control border-bottom-only body_bg" id="zipcode" name="zipcode" aria-describedby="zipcode" placeholder="ZIP/Postal" value="<?php echo $admin_user['zipcode'];?>" >
                            <div class="text-right f14"><span id="zipcode" class="text-muted f14 black_txt">ZIP code</span></div>
                            <div class="invalid-feedback">
                                Please Provide ZIP Code.
                            </div>
                        </div>

                        <!-- Country -->
                        <div class="mobile_menu_section body_bg form-group">
                            <select id="select_country" name="country" required>
                                <option value="" class="font14">Select Country</option>
                                <?php
                                    foreach ($country_data as $val) {
                                        $cselected="";
                                        if($admin_user['country_id']==$val->countryid){
                                            $cselected="selected";
                                        }
                                        echo "<option value='".$val->countryid."' data-id='".$val->currencycode."' ".$cselected.">".$val->country_name."</option>";
                                    }
                                ?>
                            </select>
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Country</span></div>
                            <div id="country_err" class="f14 red_txt"></div>
                        </div>
                        <?php
                            $phnArr=explode("-",$admin_user['telephone']);
                        ?>
                        <!-- Mobile Number -->
                        <div class="form-group row">
                            <div class="col-3">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control border-bottom-only  body_bg"
                                        placeholder="Code" aria-label="Mobile number"
                                        aria-describedby="basic-addon2" value="<?php echo $phnArr[0];?>" name="country_code" id="country_code" readOnly>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control border-bottom-only  body_bg" placeholder="Mobile Number" aria-label="Mobile number"
                                        aria-describedby="basic-addon2" id="mobile" name="mobile" value="<?php echo $phnArr[1];?>" pattern="[0-9]{8,14}" required>
                                    <div class="text-right f14 w-100 pt-2">
                                        <span id="telErrorMsg" class="f14 error_txt"></span>
                                        <span class="text-danger">*</span><span id="emailHelp"
                                            class="text-muted f14 black_txt">Mobile number</span>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please Provide Correct Mobile Number.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Roles -->
                        <div class="mobile_menu_section body_bg form-group">
                            <select id="select_role" name="role" required>
                                <option value="" class="font14">Select Role</option>
                                <?php
                                    foreach ($user_roles as $r) {
                                        $rselected="";
                                        if($admin_user['user_role']==$r['id']){
                                            $rselected="selected";
                                        }
                                        echo "<option value='".$r['id']."' data-id='".$r['role_name']."' ".$rselected.">".$r['role_name']."</option>";
                                    }
                                ?>
                            </select>
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Admin Role</span></div>
                            <div id="role_err" class="f14 red_txt"></div>
                        </div>
                        <div class="mobile_menu_section body_bg form-group">
                            <select id="select_status" name="status" required>
                                <option value="1" <?php if($admin_user['status']==1){ echo "selected";} ?>>Active</option>
                                <option value="0" <?php if($admin_user['status']==0){ echo "selected";} ?>>Inactive</option>
                                

                            </select>
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Status</span></div>
                            <div id="status_err" class="f14 red_txt"></div>
                        </div>
                        
                        <div class="my-4">
                            <div class="display_inline">
                                <a href="{{ url('/').'/adminUsersList' }}" class="btn_cancel">CANCEL</a>
                            </div>
                            <div class="display_inline">
                                <button type="submit" class="btn btn_primary d-block w-100 mt-4 " >UPDATE</button>
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
    $("#select_country").change(function(e) {
        var country_code =  $('option:selected', this).attr('data-id');
        $("#country_code").val('+'+country_code);
    });
    /*$("#email").blur(function(){
        var email = $(this).val();
        var csrf_Value= "<?php //echo csrf_token(); ?>";
        $.ajax({
            url: "<?php //echo url('/');?>/checkEmailExist",
            method: 'POST',
            dataType: "json",
            data: {'email': email,"_token": csrf_Value},
            success: function(data){
                if(data.status == "Failure" ){
                    $("#email").val("");
                }
                $('#emailErr').html(data.Result);
            }
        });
    });*/

    $("#mobile").on("keypress keyup blur",function (event) {    
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
    $('#select_country').select2();
    $('#select_role').select2();

    </script>
    <script>
      (function() {
        window.addEventListener('load', function() { 
          var forms = document.getElementsByClassName('needs-validation');
            
          var validation = Array.prototype.filter.call(forms, function(form) { 
            form.addEventListener('submit', function(event) {
            
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
              var gender = $("#gender").val();
              if(gender == ""){
                $("#gender_err").html("Please select gender");
              }else{
                $("#gender_err").html("");
              }
              var country = $("#select_country").val();
               if(country == ""){
                $("#country_err").html("Please select country");
              }else{
                $("#country_err").html("");
              }
              var role = $("#select_role").val();
              if(role == ""){
                $("#role_err").html("Please select role");
              }else{
                $("#role_err").html("");
              }
              $('#emailErr').html("");

            }, false);
          });
        }, false);
      })();
</script>
</body>
</html>
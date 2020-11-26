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
        .form-control,
        .mobile_menu_section .dk-selected,
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            font-weight:bold !important;
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
                    <li class="breadcrumb-item f16"><a href="{{ url('/').'/resellers' }}" class="f16">Resellers</a></li>
                    <li class="breadcrumb-item active f16" aria-current="page" class="f16">Edit Reseller</li>
                </ol>
            </nav>

            <h5 class="font16 font-bold text-uppercase black_txt pt-4 mb-5">Edit Reseller</h5>
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
                        <form method="post" id="create_form" name="create_form" action="<?php echo url('/').'/updateResellerData';?>" class="needs-validation" novalidate>
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <!-- User ID -->
                        <div class="form-group">
                            <input type="text" class="form-control border-bottom-only body_bg readonly_input" id="userID" name="userID"
                                aria-describedby="User ID" placeholder="User ID" value="<?php echo $resellerData->user_id;?>" readonly>
                            <div class="text-right f14"><span class="text-danger">*</span><span id="email"
                                    class="text-muted f14 black_txt">User ID</span></div>
                        </div>
                        <!-- Reseller Email -->
                        <div class="form-group">
                            <input type="email" class="form-control border-bottom-only body_bg readonly_input" id="email" name="email"
                                aria-describedby="email" placeholder="Email" value="<?php echo $resellerData->email;?>" readonly>
                            <div class="text-right f14"><span class="text-danger">*</span><span id="email"
                                    class="text-muted f14 black_txt">Reseller Email</span></div>
                        </div>

                        <!-- First Name -->
                        <div class="form-group">
                            <input type="text" class="form-control border-bottom-only body_bg" id="first_name"  name="first_name" 
                                aria-describedby="first_name" placeholder="First Name" value="<?php echo $resellerData->first_name;?>" pattern="[ a-zA-Z][a-zA-Z ]+[a-zA-Z ]$"  minlength="3" maxlength="255" required>
                            <div class="text-right f14"><span class="text-danger">*</span><span id="first_name"
                                    class="text-muted f14 black_txt">First Name</span></div>
                             <div class="invalid-feedback">
                                First Name required with atleast 3 characters.
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="form-group">
                            <input type="text" class="form-control border-bottom-only body_bg"  id="last_name"  name="last_name"
                                aria-describedby="last_name" placeholder="Last Name" value="<?php echo $resellerData->last_name;?>" pattern="[ a-zA-Z][a-zA-Z ]+[a-zA-Z ]$" minlength="3" maxlength="255" required>
                            <div class="text-right f14"><span class="text-danger">*</span><span id="last_name"
                                    class="text-muted f14 black_txt">Last Name</span></div>
                            <div class="invalid-feedback">
                                Last Name required with atleast 3 characters.
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="mobile_menu_section body_bg form-group">
                            <select class="normal_select" name="gender">
                                <option value="">Select Gender</option>
                                <option value="Male" <?php if($resellerData->gender == "Male") echo 'selected';?>>Male</option>
                                <option value="Female" <?php if($resellerData->gender == "Female") echo 'selected';?>>Female</option>
                            </select>
                            <div class="text-right f14"><span id="emailHelp" class="text-muted f14 black_txt">Gender</span></div>
                        </div>

                        <!-- Address -->
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="font-bold black_txt">Address</label>
                            <textarea id="shipping_address" name="shipping_address" rows="10" data-sample-short>{{ $resellerData->shipping_address }}</textarea>                      
                            <div class="f12" style="color:red" id="shipAddrErr"></div>
                        </div>

                        <!-- Country -->
                        <div class="mobile_menu_section body_bg form-group">
                            <select id="select_country" name="country">
                                <option value="" data-id="">Select Country</option>
                                <?php
                                    foreach ($country_data as $val) {?>
                                        <option value='<?php echo $val->countryid;?>' data-id='<?php echo $val->currencycode;?>' <?php if($val->countryid == $resellerData->country_id) {echo 'selected';} ;?>><?php echo $val->country_name;?></option>;
                                <?php }?>
                            </select>
                            <div class="text-right f14"><span id="emailHelp" class="text-muted f14 black_txt">Country</span></div>
                        </div>

                        <!-- Mobile Number -->
                        <div class="form-group row">
                            <div class="col-3">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control border-bottom-only with_addon_icon body_bg" placeholder="Code" aria-label="Mobile number" aria-describedby="basic-addon2" value="<?php echo $resellerData->country_code;?>" name="country_code" id="country_code" readOnly>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="input-group mb-3">
                                    <input type="text" class="border-bottom-only with_addon_icon body_bg"
                                        placeholder="Mobile Number" aria-label="Mobile number"
                                        aria-describedby="basic-addon2" id="mobile" name="mobile" value="<?php echo $resellerData->telephone;?>" pattern="[0-9]{8,14}">
                                    <div class="invalid-feedback">
                                        Please Provide Correct Mobile Number.
                                    </div>
                                    <div class="text-right f14 w-100 pt-2">
                                        <span id="telErrorMsg" class="f14 error_txt"></span>
                                        <span id="emailHelp" class="text-muted f14 black_txt">Mobile number</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Agent Commission Percentage -->
                        <div class="form-group">
                            <div class="input-group mb-3 text-green">
                                <input type="number" class="form-control border-bottom-only with_addon_icon text-green body_bg"
                                    placeholder="00" id="commission_perc" name="commission_perc" aria-label="Agent Commission Percentage"
                                    aria-describedby="basic-addon2" value="<?php echo $resellerData->commission_perc;?>" max="<?php echo $userInfo->commission_perc;?>">
                                <span class="input-group-text no-border no-bg text-success addon_icon">%</span>
                               <div class="text-right f14 w-100 pt-2"><span class="text-danger">*</span><span
                                        id="emailHelp" class="text-muted f14 black_txt">Agent Commission
                                        Percentage</span></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="name" class="form-control border-bottom-only body_bg readonly_input" id="refferallink_text" name="refferallink_text"
                                aria-describedby="emailHelp" placeholder="Refferal Code" value="<?php echo $resellerData->refferallink_text;?>" readonly>
                            
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp"
                                    class="text-muted f14 black_txt">Refferal Code</span></div>
                        </div>
                        
                        <div class="my-4">
                            <div class="display_inline">
                            <a href="{{ url('/').'/resellers' }}" class="btn_cancel">CANCEL</a>
                            </div>
                            <div class="display_inline">
                                <input type="hidden" name="reseller_id" id="reseller_id" value="<?php echo base64_encode($resellerData->rec_id);?>" />
                                <button type="submit" class="btn btn_primary d-block w-100 mt-4 " >SAVE</button>
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

        $(document).ready(function(){
            var country_id = "<?php echo $resellerData->country_id;?>";
            if(country_id!=''){
                $("#mobile").removeClass('form-control').addClass('form-control');
                $("#mobile").prop('required',true);
            }
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
                  form.classList.add('was-validated');

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
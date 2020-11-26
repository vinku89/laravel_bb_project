<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Customer Update</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include("inc.styles.all-styles")
    <style>
    .fa-angle-left{
            font-size: 20px;
            line-height: 25px;
            margin-right: 5px;
            color: #0091d6;
        }
         .body_bg .dk-select-options {
            color: #495057;
            font-size: 13px;
            min-height: 100px;
            max-height: 300px;
            overflow-y: auto;
        }
        .dk-option {
            padding: 5px 0.5em;
            border-bottom: solid 1px #E3ECFB;
            font-size: 16px;
        }
        .form-control{
            font-weight:bold;
        }
        .pswview-icon{
            position: absolute;
            z-index: 2;
            right: 0;
            top: -10px;
            cursor: pointer;
            font-size: 15px;
        }
        .form-control,
        .mobile_menu_section .dk-selected,
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            font-weight:bold !important;
        }
        .select2-container--default .select2-selection--single{
            background-color:transparent !important;
            border:none !important;
            border-bottom: solid 3px #7f868b !important;
            border-radius: 0;
        }
        .select2-container .select2-selection--single{
            height:33px !important;
        }
        ul{
            text-align: left;
            line-height: 25px;
            font-size: 16px;
            text-decoration: none;
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
                    <li class="breadcrumb-item f16"><a href="{{  url('/').'/customers' }}" class="f16">Customers</a></li>
                    <li class="breadcrumb-item active f16" aria-current="page" class="f16">Edit Customer</li>
                </ol>
            </nav>

            <h5 class="font16 font-bold text-uppercase black_txt pt-4 mb-5">Edit Customer</h5>
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
            <div class="clearfix ">
                <div class="row">
                    <div class="col-lg-7 col-xl-5 col-md-10">
                        <!-- <table class="rwd-table body_bg">

                        </table> -->
                        <form method="post" id="create_form" name="create_form" action="<?php echo url('/').'/updateCustomerData';?>">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="customer_id" value="<?php echo base64_encode($customerData->rec_id);?>" />
                             <!-- Create Customer ID -->
                             <div class="form-group">
                                    <input type="text" class="form-control border-bottom-only body_bg readonly_input"
                                aria-describedby="customerId" id="customer_userid" placeholder="customerId" value="{{ $customerData->user_id }}" readonly>
                                    <div class="text-right f14"><span class="text-danger">*</span><span id="customerId"
                                            class="text-muted f14 black_txt">Customer ID</span></div>
                                </div>
                             <!-- Email -->
                            <div class="form-group">
                                <input type="email" class="form-control border-bottom-only body_bg readonly_input" id="email" name="email"
                            aria-describedby="email" placeholder="Email" value="{{ $customerData->email }}" readonly>
                                <div class="text-right f14"><span class="text-danger">*</span><span id="email"
                                        class="text-muted f14 black_txt">Email</span></div>
                            </div>

                            <!-- First Name -->
                            <div class="form-group">
                                <input type="text" class="form-control border-bottom-only body_bg lettersOnly" id="firstName" name="first_name"
                                    aria-describedby="firstName" placeholder="First Name" value="{{ $customerData->first_name }}">
                                <div class="text-right f14"><span class="text-danger">*</span><span id="firstName"
                                        class="text-muted f14 black_txt">First Name</span></div>
                                <div class="error" id="first_name_err"></div>
                            </div>

                            <!-- Last Name -->
                            <div class="form-group">
                                <input type="text" class="form-control border-bottom-only body_bg lettersOnly" id="lastName" name="last_name"
                                    aria-describedby="lastName" placeholder="Last Name" value="{{ $customerData->last_name }}">
                                <div class="text-right f14"><span class="text-danger">*</span><span id="lastName"
                                        class="text-muted f14 black_txt">Last Name</span></div>
                                <div class="error" id="last_name_err"></div>
                            </div>

                            <!-- Gender -->
                            <!-- <div class="mobile_menu_section body_bg form-group">
                                <select class="normal_select" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="Male" <?php //if($customerData->gender == "Male") echo 'selected';?>>Male</option>
                                    <option value="Female" <?php //if($customerData->gender == "Female") echo 'selected';?>>Female</option>
                                </select>
                                <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp"
                                        class="text-muted f14 black_txt">Gender</span></div>
                            </div> -->

                            <!-- Status -->
                            <!-- <div class="mobile_menu_section body_bg form-group">
                                <select id="normal_select1" name="married_status">
                                    <option value="">Martial Status</option>
                                    <option value="Married" <?php //if($customerData->married_status == "Married") echo 'selected';?>>Married</option>
                                    <option value="Single" <?php //if($customerData->married_status == "Single") echo 'selected';?>>Single</option>
                                </select>
                                <div class="text-right f14"><span id="emailHelp"
                                        class="text-muted f14 black_txt">Status</span></div>
                            </div> -->

                            <!-- Shipping Address -->
                            <div class="text-center my-2 f14 font-bold color-black">Shipping Address</div>

                            <div class="form-group">
                                <label for="exampleInputEmail1" class="font-bold black_txt">* Address</label>
                                <textarea id="shipping_address" name="shipping_address" rows="10" data-sample-short>{{ $customerData->shipping_address }}</textarea>
                                <div class="f12" style="color:red" id="shipAddrErr"></div>
                            </div>

                            <!-- Country -->
                            <div class="mobile_menu_section body_bg form-group">
                                <select id="select_country" name="shipping_country">
                                    <option value="" data-id="">Select Country</option>
                                    <?php
                                    foreach ($country_data as $val) {?>
                                        <option value='<?php echo $val->countryid;?>' data-id='<?php echo $val->currencycode;?>' <?php if($val->countryid == $customerData->shipping_country) {echo 'selected';} ;?>><?php echo $val->country_name;?></option>;
                                <?php }?>
                                </select>
                                <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Country</span></div>
                                <div id="country_err" class="f14 red_txt"></div>
                            </div>

                            <!-- Mobile Number -->
                            <!-- Mobile Number -->
                            <div class="form-group row">
                                <div class="col-3">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control border-bottom-only with_addon_icon body_bg"
                                            placeholder="+0" aria-label="Mobile number"
                                            aria-describedby="basic-addon2" value="{{ $customerData->country_code }}" name="shipping_country_code" id="shipping_country_code" readOnly>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control border-bottom-only with_addon_icon body_bg"
                                            placeholder="Mobile Number" aria-label="Mobile number"
                                            aria-describedby="basic-addon2" id="shipping_user_mobile_no" name="shipping_user_mobile_no" value="{{ $customerData->telephone }}" >
                                        <div class="text-right f14 w-100 pt-2">
                                            <span id="telErrorMsg" class="f14 error_txt"></span>
                                            <span class="text-danger">*</span><span id="emailHelp"
                                                class="text-muted f14 black_txt">Mobile number</span>
                                        </div>
                                        <div id="mobile_no_err" class="f14 red_txt"></div>
                                    </div>
                                </div>
                            </div>
                            @If($userInfo['admin_login'] == 1)
                            <!-- CMS Details -->
                            <div class="text-center my-2 f14 font-bold color-black">CMS Details</div>
                             <!-- Address Line 1 -->
                            <div class="form-group" style="margin-bottom: 30px;">
                                <?php
                                    //$cms_username=safe_decrypt($customerData->cms_username,config('constants.encrypt_key'));
                                    $cms_password=safe_decrypt($customerData->cms_password,config('constants.encrypt_key'));
                                ?>
                                <input type="name" class="form-control border-bottom-only body_bg" value="{{ $customerData->user_id }}" id="cms_username" name="cms_username" aria-describedby="emailHelp" placeholder="CMS Username" readonly="readonly">
                                <div class="f14 clearfix">
                                <!-- <span style="position:relative">
                                <input type="checkbox" name="copy_det" id="copy_det" class="form-check-input" style=" width: inherit;margin-left: 0; z-index: 99;">
                                    <label class="form-check-label payfor_friend font-bold" for="exampleCheck1" id="emailHelp" style="padding-left: 15px; top:0;">Same as Bestbox</label>
                                </span> -->
                                    <span id="emailHelp" class="text-muted f14 black_txt float-right"><span class="text-danger">*</span>Username</span>
                                </div>
                            </div>

                            <!-- Address Line 2 -->
                            <div class="form-group" style="position:relative;">
                                <input type="password" class="form-control border-bottom-only body_bg" value="{{ $cms_password }}" id="cms_password" name="cms_password" aria-describedby="emailHelp" placeholder="CMS Password" readonly="readonly">
                                <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Password</span></div>
                                <div id="cms_password_err" class="f14 red_txt"></div>
                                <span class="icon validation small" style="color:black;">
                                            <i class="fa fa-fw pswview-icon toggle-password fa-eye-slash" toggle="#cms_password" ></i>
                                    </span>
                            </div>
                            @endIf
                            <!-- Package Details -->
                            <div class="text-center my-2 f14 font-bold color-black">Package Details</div>

                            @if($customerData->package_id != "")
                            <div class="form-group">
                                <div class="select-test" >
                                    <button class="h50">
                                        <span>Select</span>
                                    </button>
                                    <ul class="f16 package_list">
                                        @foreach ($package_data as $val)
                                            @if($val->id == $customerData->package_id)
                                                <li value="{{ $val->id }}" data-package="{{ $val->id }}" data-amt="{{ $val->effective_amount }}" i
                                                    <?php if($val->id == $customerData->package_id) echo 'selected';?> class="text-left" style="display: table; width: 100%;">
                                                    <div class="border-right-blue p-3" style="display: table-cell; width: 70%;">
                                                        <div class="" style="font-weight: 700;">BestBOX</div>
                                                    <div> {{ $val->package_name }}</div>
                                                    </div>
                                                    <div class="p-3 font-bold" style="display: table-cell; width: 30%;">{{ $val->effective_amount }} USD</div>
                                                </li>
                                            @endIf
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endIf
                            <!-- Post Buy -->
                            @If(!empty($packData))
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="text-center">
                                            <div class="f16 color-black p-2">
                                                <div class="font-bold mb-2">Activation Period</div>
                                                <div class="mb-2">{{ date('d/m/Y',strtotime($packData->subscription_date)) }} - {{ date('d/m/Y',strtotime($packData->expiry_date)) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="text-center">
                                            <div class="f16 font-bold grey-bordered">
                                                <div class="color-black mb-3">Status</div>
                                                <div class="label_active mx-auto mb-2 {{ $packData->id == 11 ? 'label_active' : ($packData->expiry_date < NOW() ? 'label_expired' : 'label_active') }}"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endIf
                            <div class="my-4">
                                <div class="display_inline">
                                    <a href="<?php echo url('/customers');?>" class="btn_cancel">Back</a>
                                </div>
                                <div class="display_inline">
                                    <input type="hidden" name="package" id="package" value="{{ $customerData->package_id }}">
                                    <button type="submit" class="btn btn_primary  d-block w-100 mt-4 " id="update_customer">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")

    <?php
        if(Session::has('alert') && Session::get('alert') == 'Failure'){
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
        if(Session::has('alert') && Session::get('alert') == 'Success'){
    ?>
        <script type="text/javascript">
            swal(
                'Success',
                '<?php echo Session::get('result');?>',
                'success'
            )
        </script>
    <?php
        }
    ?>

    <!-- Delete User -->
    <div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="deleteUser" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <h5 class="modal-title font-bold black_txt text-uppercase f20" id="exampleModalLongTitle">
                        Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body add_edit_user pb-4">
                    <div class="text-center f20 black_txt py-5 mb-5">
                        Are you sure you want to delete this item?
                    </div>
                </div>
                <!-- footer buttons -->
                <div class="inline-buttons">
                    <button type="button" class="btn inline-buttons-left cancel-btn"
                        data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn inline-buttons-right create-btn">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete User end -->

    <script>
			$(function () {
				var select = $(".select-test");
				select.select({
					selected: 0,
					animate: "slide"
				});
            });
            /* select box*/
            $(document).ready(function()
            {
                /*$("#cms_username").focus(function(){
                   this.removeAttribute('readonly');
                });*/
                $("#cms_password").focus(function(){
                   this.removeAttribute('readonly');
                });

               /* $("#copy_det").click(function(){
                    if($(this).prop("checked") == true){
                        var customer_userid = $("#customer_userid").val();
                        $("#cms_username").val(customer_userid);
                    }
                    else if($(this).prop("checked") == false){
                        $("#cms_username").val("");
                    }
                });*/

                $('ul.package_list li').click(function(e)
                {
                    var amount = $(this).attr('data-amt');
                    var package_id = $(this).attr('data-package');
                    $("#package").val(package_id);
                });


                $("#password").keyup(function(){
                        $(".toggle-password").removeClass('showHide_icon');
                });

            });

            $("#shipping_user_mobile_no").on("keypress keyup blur",function (event) {
                $(this).val($(this).val().replace(/[^\d].+/, ""));
                if ((event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
            });

            $("#select_country").change(function(e) {
                var country_code =  $('option:selected', this).attr('data-id');

                if(country_code != ""){
                    $("#shipping_country_code").val('+'+country_code);
                }else{
                    $("#shipping_country_code").val('');
                    $("#shipping_user_mobile_no").val('');
                }
            });

            $('#select_country').select2();

		</script>
        <script>
            CKEDITOR.replace('shipping_address', {
                height: 150
            });

            $(".lettersOnly").on("keypress keyup blur",function (event) {
                var charCode = event.keyCode;

                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 8 || charCode == 32)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            });

            $("#update_customer").click(function(e){
                e.preventDefault();
                var first_name = $("#firstName").val();
                var last_name = $("#lastName").val();
                var letters = /^[A-Za-z\s]+$/;
                if(first_name == ""){
                    $("#first_name_err").html("First Name required with atleast 3 characters.");
                    return false;
                }else if(!first_name.match(letters)){
                    $("#first_name_err").html("First Name allow characters only.");
                    return false;
                }
                else{
                    $("#first_name_err").html("");
                }
                if(last_name == ""){
                    $("#last_name_err").html("Last Name required with atleast 3 characters.");
                    return false;
                }else if(!last_name.match(letters)){
                    $("#last_name_err").html("Last Name allow characters only.");
                    return false;
                }else{
                    $("#last_name_err").html("");
                }

                var shipping_address = $.trim(CKEDITOR.instances['shipping_address'].getData());

                  if (shipping_address == '') {
                        $("#shipAddrErr").html('Shipping Address Required');
                        return false;
                    } else {
                        $("#shipAddrErr").html('');
                    }
                  var country = $("#select_country").val();
                   if(country == ""){
                    $("#country_err").html("Please select country");
                    return false;
                  }else{
                    $("#country_err").html("");
                  }
                  var shipping_user_mobile_no = $("#shipping_user_mobile_no").val();
                  var phoneRGEX = /^[0-9]{8,14}$/;
                  var phoneResult = phoneRGEX.test(shipping_user_mobile_no);

                    if(shipping_user_mobile_no == ""){
                        $("#mobile_no_err").html("Please provide Mobile No");
                        return false;
                    }else if(phoneResult == false){
                        $("#mobile_no_err").html("Please provide correct Mobile No");
                        return false;
                    }
                    else{
                        $("#mobile_no_err").html("");
                    }

                    var cms_password = $("#cms_password").val();
                    if(cms_password == ""){
                        $("#cms_password_err").html("CMS Password is required");
                        return false;
                    }
                    else{
                        $("#cms_password_err").html("");
                    }

                    $("#create_form").submit();

            });
        </script>
</body>
</html>

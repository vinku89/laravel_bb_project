<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Customer New</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
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

        .select2-container[dir="ltr"]{
            width:100% !important;
        }


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
        /* .form-control{
            font-weight:bold;
        } */
        .select-x ul li{
            border-bottom: solid 1px #0096da;
        }
        .select-x ul li:last-child{
            border-bottom: none;
        }
        .select-x ul.open{
            margin-bottom:50px;
        }
        .package_selection{
            min-height:50px;
            max-height:100px;
        }

        ul{
            text-align: left;
            line-height: 25px;
            font-size: 16px;
            text-decoration: none;
        }
        .form_bg5{
            background-color:#B8D0E9;
            padding: 25px 20px;
        }
        .form_bg6{
            background-color:#ffffff;
            padding:10px;
            border:solid 1px #0096DA;
            border-radius:5px;
        }
        .select-x button{
            border:solid 1px #0096DA !important;
            border-radius:5px;
        }
        .list-type-none{
            list-style-type: none;
        }
        .sp_address p{
          margin-bottom: 2px;
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
                    <li class="breadcrumb-item f16"><a href="{{ url('/').'/customers' }}" class="f16">Customers</a></li>
                    <li class="breadcrumb-item active f16" aria-current="page" class="f16">Add New Customer</li>
                </ol>
            </nav>

            <h5 class="f22 font-bold text-uppercase black_txt pt-4 mb-5 text-center text-sm-left">Add New Customer</h5>
            <div class="row">
                <div class="col-md-6"></div>
            </div>
            <div class="text-center f14">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <span style="color: #721c24;">Please fill below mandatory fields</span><br/>
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
                        <div id="step1">
                            <form method="post" id="create_form" name="create_form" action="<?php echo url('/').'/createCustomer';?>" class="needs-validation" novalidate>
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="form_type" id="form_type" value="{{ $customer_info['form_type'] }}">
                             <!-- Create Customer ID -->
                             <!-- Email -->
                            <div class="form-group">
                                <input type="email" pattern="[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})" class="form-control border-bottom-only body_bg" id="email" name="email" aria-describedby="email" placeholder="Email" value="{{ $customer_info['email'] }}" required>

                                <div class="text-right f14"><span class="text-danger">*</span><span id="email" class="text-muted f14 black_txt">Email</span></div>
                                <!-- <div class="invalid-feedback">
                                    Please Provide Valid Email Id.
                                </div> -->
                                <span class="f14" id="email_error"></span>
                            </div>

                            <div class="form-group position-relative">
                                 <input type="text" name="password"style="display:none;">
                                 <input type="password" class="form-control border-bottom-only body_bg" pattern="(?=.*\d)(?=.*[a-z]).{8,}" id="password" name="password" placeholder="Password" autocomplete="off" autocorrect="off" autocapitalize="off" required>
                                 <span class="icon validation small" style="color:black;">
                                    <i class="fa fa-fw field-icon toggle-password fa-eye-slash" toggle="#password" style="top:-5px" ></i>
                                </span>
                                <div class="text-right f14"><span class="text-danger">*</span><span id="password2" class="text-muted f14 black_txt">Password</span></div>
                                 <!-- <div class="valid-feedback">
                                    Looks good!
                                 </div> -->
                                  <!--<div class="invalid-feedback">
                                    Password should be minimum 8 characters with alphanumeric
                                 </div>-->
                                 <span class="f14" id="pwd_error"></span>

                              </div>

                              <div class="form-group position-relative">

                                 <input type="password" class="form-control border-bottom-only body_bg" pattern="(?=.*\d)(?=.*[a-z]).{8,}" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                                 <span class="icon validation small" style="color:black;">
                                    <i class="fa fa-fw field-icon toggle-password fa-eye-slash" toggle="#confirm_password" style="top:-5px"></i>
                                </span>
                                <div class="text-right f14"><span class="text-danger">*</span><span id="confirm_password2" class="text-muted f14 black_txt">Confirm Password</span></div>
                                 <!-- <div class="valid-feedback">
                                    Looks good!
                                 </div> -->
                                 <!--<div class="invalid-feedback" id="err_msg_customer">
                                    Please Confirm Password.
                                 </div> -->
                                 <span class="f14" id="cnfpwd_error2"></span>
                              </div>
                            <!-- First Name -->
                            <div class="form-group">
                                <input type="text" class="form-control border-bottom-only body_bg lettersOnly" id="firstName" name="first_name" aria-describedby="firstName" placeholder="First Name" value="{{ $customer_info['first_name'] }}" minlength="3" maxlength="255" required>
                                <div class="text-right f14"><span class="text-danger">*</span><span id="firstName" class="text-muted f14 black_txt">First Name</span></div>
                                <div class="error" id="first_name_err"></div>
                            </div>

                            <!-- Last Name -->
                            <div class="form-group">
                                <input type="text" class="form-control border-bottom-only body_bg lettersOnly" id="lastName" name="last_name" aria-describedby="lastName" placeholder="Last Name" value="{{ $customer_info['last_name'] }}" minlength="3" maxlength="255" required>
                                <div class="text-right f14"><span class="text-danger">*</span><span id="lastName" class="text-muted f14 black_txt">Last Name</span></div>
                                <div class="error" id="last_name_err"></div>
                            </div>

                        <div class="form_bg5">
                             <div class="form-group">
                                <div class="select-test">
                                    <label for="exampleInputEmail1" class="font-bold black_txt">BestBOX Package</label>
                                    <input type="hidden" name="package" id="package" value="">
                                    <input type="hidden" name="package_amount" id="package_amount" value="">
                                    <input type="hidden" name="check_setupbox_status" id="check_setupbox_status" value="">
                                    <input type="hidden" name="payment_method" id="payment_method" value="">
                                    <button class="package_selection">
                                        <span>Select</span>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="f16 package_list">
                                        <li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">
                                            Select Package
                                        </li>
                                        @foreach ($package_data as $val)
                                            <li value="{{ $val->id }}" data-box="{{ $val->setupbox_status }}" data-package="{{ $val->id }}" data-amt="{{ $val->effective_amount }}" data-actualamt="{{ $val->package_value }}" data-discountamt="{{ $val->discount }}" data-name="{{ $val->package_name }}" data-desc="{{ $val->description }}" class="text-left" style="display: table; width: 100%;">
                                                <div class="border-right-blue p-3" style="display: table-cell; width: 70%;">
                                                    <div class="" style="font-weight: 700;">{{ $val->package_name }}</div>
                                                <div> {{ $val->description }}</div>
                                                </div>
                                                <div class="p-3 font-bold" style="display: table-cell; width: 30%;">{{ $val->effective_amount }} USD</div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="f12" style="color:red" id="packageErr"></div>
                                </div>
                            </div>

                            <!-- Pre Buy -->
                            <div class="form_bg6">
                                <label for="exampleInputEmail1" class="font-bold black_txt">Payment Method</label>
                                    <div class="col-12 mt-3 pl-0">
                                        <div class="form-group form-check">
                                            <input type="radio" name="pay" id="pay" value="WALLET" class="form-check-input payment_type" style="width: inherit;" disabled>
                                            <label class="form-check-label payfor_friend" for="exampleCheck1">Pay From My BestBOX Wallet</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="text-center">
                                            <div class="f16 font-bold blue-bordered">
                                                <div class="color-black mb-2">Wallet Balance</div>
                                                <div class="blue_txt mb-2">{{ number_format($wallet_balance->amount,2) }} USD</div>
                                                <input type="hidden" value="{{ $wallet_balance->amount }}" id="user_wallet_amt" name="user_wallet_amt">
                                            </div>
                                        </div>
                                    </div>
                                    <!--<div class="col-12 mt-4 pl-0">
                                        <div class="form-group form-check">
                                            <input type="radio" name="pay" id="pay" value="EVERUSPAY" class="form-check-input payment_type" style=" width: inherit;">
                                            <label class="form-check-label payfor_friend" for="exampleCheck1">CRYPTO PAYMENT<!--<span class="pl-3"><img src="{{ url('/') }}/public/customer/images/evr-pay-logo.png?q=<?php echo rand();?>"
                                                    style="width:100px;"></span></label>
                                        </div>
                                    </div>-->
                                    <div class="f12" style="color:red" id="paymethodErr"></div>
                            </div>

                        </div>

                            <!-- Shipping Address -->
                        <div id="shipping_addr" style="display: none;">
                            <div class="text-center my-2 f14 font-bold color-black">Shipping Address</div>

                            <div class="form-group">
                                <label for="exampleInputEmail1" class="font-bold black_txt">* Address</label>
                                <textarea id="shipping_address" name="shipping_address" rows="10" data-sample-short></textarea>
                                <div class="f12 mt-3 red_txt" id="shipAddrErr"></div>
                            </div>

                            <!-- Country -->
                            <div class="mobile_menu_section body_bg form-group">
                                <select id="select_country" name="shipping_country">
                                    <option value="" data-id="" class="font14">Select Country</option>
                                    <?php
                                        foreach ($country_data as $val) {
                                            echo "<option value='".$val->countryid."' data-id='".$val->currencycode."' data-countryname='".$val->country_name."'>".$val->country_name."</option>";
                                        }
                                    ?>
                                </select>
                                <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Country</span></div>
                                <div id="country_err" class="f14 red_txt"></div>
                            </div>

                            <!-- Mobile Number -->
                            <!-- Mobile Number -->
                            <div class="form-group row">
                                <div class="col-3">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control border-bottom-only  body_bg"
                                            placeholder="code" aria-label="Mobile number"
                                            aria-describedby="basic-addon2" value="{{ old('shipping_country_code') }}" name="shipping_country_code" id="shipping_country_code" readonly>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control border-bottom-only  body_bg" placeholder="Mobile Number" aria-label="Mobile number"  aria-describedby="basic-addon2" id="shipping_user_mobile_no" name="shipping_user_mobile_no" value="{{ old('shipping_user_mobile_no') }}" pattern="[0-9]{8,14}">
                                        <div class="text-right f14 w-100 pt-2">
                                            <span id="telErrorMsg" class="f14 error_txt"></span>
                                            <span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Mobile number</span>
                                        </div>
                                        <div class="invalid-feedback">
                                             Please Provide Correct Mobile Number.
                                        </div>
                                        <div id="mobile_no_err" class="f14 red_txt"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="chkboxvalue" id="chkboxvalue">
                            <div class="my-4">
                                <div class="display_inline">
                                    <a href="<?php echo url('/customers'); ?>" class="btn_cancel">CANCEL</a>
                                </div>
                                <div class="display_inline">
                                    <button class="btn btn_primary d-block w-100 mt-4 " id="create_customer">CREATE</button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>

                    <div id="step2" class="d-none">
                        <ul class="p-0">
                            <li class="list-type-none pb-2">Email: <span class="font-weight-bold" id="disp_email">abctest@gmail.com</span></li>
                            <li class="list-type-none pb-2">First Name: <span class="font-weight-bold" id="disp_first_name">abc</span></li>
                            <li class="list-type-none">Last Name: <span class="font-weight-bold" id="disp_last_name">test</span></li>
                        </ul>

                        <div class="mb-5">
                            <p class="font-weight-bold black_txt font-bold text-uppercase">Confirm Your Purchase</p>

                            <div class="col-12 mb-5">
                                <div class="row add-newcustomer">
                                    <table class="m_table ">
                                        <tbody>
                                            <tr class="tableHeader">
                                                <td style="font-weight:bold; background-color:white;" width="40%">Discription</td>
                                                <td align="right" style="font-weight:bold; background-color:white;">Unit price</td>
                                                <td align="right" style="font-weight:bold; background-color:white;">Quantity</td>
                                                <td align="right" style="font-weight:bold; background-color:white;">Amount</td>
                                            </tr>
                                            <tr class="m_bgwhite">
                                                <td id="disp_package_desc">BestBOX + 1 Month Subscription
                                                    Includes pre - installed app & 1 month subscription + door to door delivery</td>
                                                <td align="right" class="disp_actual_amt">$34.99 USD</td>
                                                <td align="right">1</td>
                                                <td align="right" class="disp_actual_amt">$34.99 USD</td>
                                            </tr>
                                            <tr class="m_row">
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td align="right">Subtotal</td>
                                                <td align="right" class="disp_actual_amt">$34.99 USD</td>
                                            </tr>
                                            <tr class="m_row2">
                                                <td class="border-top-0">&nbsp;</td>
                                                <td class="border-top-0">&nbsp;</td>
                                                <td align="right" class="border-top-0">Discount</td>
                                                <td align="right" class="border-top-0" id="disp_discount_amt">$0.00 USD</td>
                                            </tr>
                                            <tr class="m_row4">
                                                <td class="border-top-0 border-bottom">&nbsp;</td>
                                                <td class="border-top-0 border-bottom">&nbsp;</td>
                                                <td align="right" style="font-weight:bold; width:145px;" class=" border-bottom">Amount payable</td>
                                                <td align="right" style="font-weight:bold" class=" border-bottom disp_package_amt">$34.99 USD</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <p class="font-weight-bold black_txt font-bold text-uppercase">Payment Method</p>
                                <div class="form-width mb-5">
                                <div class="form_bg6 mb-5">
                                    <div class="d-none" id="wallet_pay">
                                        <div class="col-12 mt-3 pl-0">
                                            <div class="form-group form-check">
                                                <label class="form-check-label payfor_friend" for="exampleCheck1">Pay From My BestBOX Wallet</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="text-center">
                                                <div class="f16 font-bold blue-bordered">
                                                    <div class="color-black mb-2">Wallet Balance</div>
                                                    <div class="blue_txt mb-2">{{ number_format($wallet_balance->amount,2) }} USD</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-none" id="everuspay_pay">
                                        <div class="col-12 mt-4 pl-0">
                                            <div class="form-group form-check">
                                                <label class="form-check-label payfor_friend" for="exampleCheck1">CRYPTO PAYMENT<!--<span
                                                        class="pl-3"><img src="{{ url('/') }}/public/customer/images/evr-pay-logo.png?q=<?php echo rand();?>" style="width:100px;"></span>-->
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="disp_shipping_addr" class="d-none">
                                    <p class="font-weight-bold black_txt font-bold text-uppercase">Shipping Address</p>
                                    <div class="form_bg6 mb-5 sp_address" id="disp_shipping_address">
                                        CRYPTO PAYMENT
                                    </div>
                                </div>

                                <div class="my-4">
                                    <div class="display_inline">
                                        <button class="btn_cancel" id="back_btn">Back</button>
                                    </div>
                                    <div class="display_inline">
                                        <button class="btn btn_primary d-block w-100 mt-4 " id="pay_now">Pay Now</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>


    <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="deleteUser"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <h5 class="modal-title font-bold black_txt text-uppercase f20" id="exampleModalLongTitle">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body add_edit_user pb-4">
                    <div class="text-center f20 black_txt py-5 mb-5">
                        Insufficient Balance In Your Wallet.
                        You can reload your wallet and try to create customer or you can save data to click continue.
                    </div>
                </div>
                <input type="hidden" name="delete_user_id" id="delete_user_id">
                <!-- footer buttons -->
                <div class="inline-buttons">
                    <button type="button" class="btn inline-buttons-left cancel-btn" id="cls_modal">Cancel</button>
                    <button type="button" class="btn inline-buttons-right create-btn" data-dismiss="modal">Continue</button>
                </div>
            </div>
        </div>
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

    <script>
        $(function () {
            var select = $(".select-test");
            select.select({
                selected: 0,
                animate: "slide"
            });
        });
        /* select box*/
        $(document).ready(function() {
            $('ul.package_list li').click(function(e)
            {
                var amount = $(this).attr('data-amt');
                var package_id = $(this).attr('data-package');
                if(package_id == ""){
                    setTimeout(function() {
                        $(".select-test span:first").html('<li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">Select Package</li>');
                    }, 50);
                    $("#package").val('');
                    $("#package_amount").val('');
                }else{
                    $(".payment_type").attr('disabled',false);
                    var actual_amount = $(this).attr('data-actualamt');
                    var discountamt = $(this).attr('data-discountamt');
                    var setupbox_status = $(this).attr('data-box');
                    $("#check_setupbox_status").val(setupbox_status);
                    if(setupbox_status == 1){
                        $("#disp_shipping_addr").removeClass('d-none');
                        $("#shipping_user_mobile_no").prop('required',true);
                        $("#shipping_addr").css('display','block');
                    }else{
                        $("#disp_shipping_addr").addClass('d-none');
                        $("#shipping_user_mobile_no").prop('required',false);
                        $("#shipping_addr").css('display','none');
                    }

                    $("#package").val(package_id);
                    $("#package_amount").val(amount);
                    var package_name = $(this).attr('data-name');
                    var package_desc = $(this).attr('data-desc');
                    $("#disp_package_desc").html(package_desc);
                    $(".disp_package_amt").html("$"+amount+" USD");
                    $(".disp_actual_amt").html("$"+actual_amount+" USD");
                    $("#disp_discount_amt").html("-$"+discountamt+" USD");
                    setTimeout(function() {
                        $(".select-test span:first").html("<div class='p-1' style='width: 100%;background-color:#fff;'><div class='float-left' style='width:75%'><div style='font-weight: 700;'>"+package_name+"</div><div>"+package_desc+"</div></div><div class='float-right font-bold pr-2 pt-3'>"+amount+" USD</div></div>");
                    }, 50);
                }

            });
        });

        $('#select_country').select2();

        $("#select_country").change(function(e) {
            var country_code =  $('option:selected', this).attr('data-id');
            if(country_code != ""){
                $("#shipping_country_code").val('+'+country_code);
            }else{
                $("#shipping_country_code").val('');
                $("#shipping_user_mobile_no").val('');
            }
        });

        $("#shipping_user_mobile_no").on("keypress keyup blur",function (event) {
            $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
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

        $("#email").blur(function(){
            var email = $(this).val();
            if(email){
                var token = "<?php echo csrf_token(); ?>";
                $.ajax({
                        url: "<?php echo url('/');?>/checkReferralUser",
                        method: 'POST',
                        dataType: "json",
                        data: {'email':email,'_token':token},
                        success: function(data){
                           if(data.message == "Not valid"){
                                $("#email_error").html("");
                           }
                           else if(data.message == "Email Id available"){
                                $("#email_error").html(data.message);
                                $("#email_error").addClass("green_txt").removeClass("error");
                           }else{
                                $("#email_error").html(data.message);
                                $("#email").val("");
                                $("#email_error").addClass("error").removeClass("green_txt");
                           }
                           $("#form_type").val(data.form_type);
                        }
                    });
            }
        });

    </script>
    <script>
        CKEDITOR.replace('shipping_address', {
            height: 150
        });
    </script>

    <script>

      $("#create_customer").click(function(e){

            e.preventDefault();
            var first_name = $("#firstName").val();
            var last_name = $("#lastName").val();
            var letters = /^[A-Za-z\s]+$/;
            var pwdvalidate = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!$%@#£€*?&]{8,}$/;
            //var pwdvalidate = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;
            var email = $("#email").val();
            var validate_error = 0;
            var password = $("#password").val().trim();
            var confirm_password = $("#confirm_password").val().trim();
            //console.log(confirm_password);
            if(email == ""){
                $("#email_error").addClass('error');
                $("#email_error").html("Email Id required.");
                validate_error = 1;
            }else{
                $("#email_error").removeClass('error');
                $("#email_error").html("");
            }
            if(password == "") {
               $("#pwd_error").addClass('error');
               $("#pwd_error").html("Password required");
               validate_error = 1;
            }else if(!password.match(pwdvalidate)){
                $("#pwd_error").addClass('error');
                $("#pwd_error").html("Password should be minimum 8 characters with alphanumeric");
                validate_error = 1;
            }else{
                $("#pwd_error").removeClass('error');
                $("#pwd_error").html("");
            }
            // if(confirm_password=="") {
            //    $("#cnfpwd_error2").addClass('error');
            //    $("#cnfpwd_error2").html("Confirm Password required.");
            //    validate_error = 1;
            // }else{
            //     $("#cnfpwd_error2").removeClass('error');
            //     $("#cnfpwd_error2").html("");
            // }
            if(password != confirm_password)
            {
                $("#cnfpwd_error2").addClass('error');
                $("#cnfpwd_error2").html("Password and Confirmation password does not match.");
                validate_error = 1;
            }else{
                $("#cnfpwd_error2").removeClass('error');
                $("#cnfpwd_error2").html("");
            }
            if(first_name == ""){
                $("#first_name_err").html("First Name required with atleast 3 characters.");
                validate_error = 1;
            }else if(!first_name.match(letters)){
            	$("#first_name_err").html("First Name allow characters only.");
                validate_error = 1;
            }
            else{
                $("#first_name_err").html("");
            }
            if(last_name == ""){
                $("#last_name_err").html("Last Name required with atleast 3 characters.");
                validate_error = 1;
            }else if(!last_name.match(letters)){
            	$("#last_name_err").html("Last Name allow characters only.");
                validate_error = 1;
            }else{
                $("#last_name_err").html("");
            }
            if(validate_error) {
                return false;
            }

            var package = $("#package").val();
            if (package != '') {
                $("#packageErr").html("");
                if(!$("input[name='pay']:checked").val()){
                    $("#paymethodErr").html('Select payment method');
                    validate_error = 1;
                }
                else{
                    $("#paymethodErr").html('');
                }
                var shipping_address = $.trim(CKEDITOR.instances['shipping_address'].getData());
                  if($("#check_setupbox_status").val() == 1){
                      if (shipping_address == '') {
                            $("#shipAddrErr").html('Shipping Address Required');
                            validate_error = 1;
                        } else {
                            $("#shipAddrErr").html('');
                        }
                      var country = $("#select_country").val();
                       if(country == ""){
                        $("#country_err").html("Please select country");
                        validate_error = 1;
                      }else{
                        $("#country_err").html("");
                      }
                      var shipping_user_mobile_no = $("#shipping_user_mobile_no").val();
                      var phoneRGEX = /^[0-9]{8,14}$/;
                      var phoneResult = phoneRGEX.test(shipping_user_mobile_no);

                        if(shipping_user_mobile_no == ""){
                            $("#mobile_no_err").html("Please provide Mobile No");
                            validate_error = 1;
                        }else if(phoneResult == false){
                            $("#mobile_no_err").html("Please provide correct Mobile No");
                            validate_error = 1;
                        }
                        else{
                            var country_name = $('option:selected', '#select_country').attr('data-countryname');
                            var country_code = $("#shipping_country_code").val();
                            $("#disp_shipping_address").html(shipping_address+'<p>'+country_name+'</p>'+'<p>'+country_code+'-'+shipping_user_mobile_no+'</p>');
                            $("#mobile_no_err").html("");
                        }
                  }

                $("#disp_email").html(email);
                $("#disp_first_name").html(first_name);
                $("#disp_last_name").html(last_name);

                $("#step1").addClass('d-none');
                $("#step2").removeClass("d-none");

            }else if($("input[name='pay']:checked").val()){
                var package = $("#package").val();
                if(package == ""){
                    $("#packageErr").html("Please select package");
                    validate_error = 1;
                }else{
                    $("#packageErr").html("");
                }
            }
            else{
                $("#paymethodErr").html('');
                if(validate_error == 0) {
                    $("#create_form").submit();
                }else{
                    return false;
                }
            }

        });

      $(".payment_type").click(function(){
            var payment = $("input[name='pay']:checked").val();
            $("#payment_method").val(payment);
            if(payment == 'EVERUSPAY') {
                $("#everuspay_pay").removeClass("d-none");
                $("#wallet_pay").addClass("d-none");
            }else if(payment == 'WALLET') {
                $("#everuspay_pay").addClass("d-none");
                $("#wallet_pay").removeClass("d-none");
            }

            var package_id = $("#package").val();
            var amount = $("#package_amount").val();
            var user_wallet_amt = $("#user_wallet_amt").val();
            var package_name = $("#package_name").val();
            var package_desc = $("#package_desc").val();
            if(payment == 'WALLET'){
                if(parseFloat(amount) > parseFloat(user_wallet_amt)){
                        $(this).prop('checked', false);
                        $('#pay').attr('checked', false);
                        swal({
                            title: 'Insufficient Balance In Your Wallet',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#4FC550',
                            cancelButtonColor: '#D0D0D0',
                            confirmButtonText: 'Continue',
                            closeOnConfirm: false,
                            html: "You can reload your wallet and try to create customer or you can save data to click continue."
                        }).then(function (result) {
                            if (!result.value) {
                                location.href="<?php echo url('/customer-new'); ?>"
                            }else{
                                $(".select-test span:first").html("<li value='' data-package='' data-amt='' class='text-left' style='display: table; width: 100%;'>Select Package</li>");
                            }
                        }).catch(swal.noop);
                }
            }
        });

      $("#back_btn").click(function(){
            $("#step1").removeClass('d-none');
            $("#step2").addClass("d-none");
      });

      $("#pay_now").click(function(){
         $("#create_form").submit();
      });

</script>

</body>
</html>

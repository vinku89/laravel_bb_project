<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <title>BestBOX - Renewal</title>
    <!-- Styles -->
    <link href="<?php echo url('/');?>/public/css/customer/app.css" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/bsnav.css" rel="stylesheet">
    <!-- All old styles include -->
    <link rel="stylesheet" href="<?php echo url('/');?>/public/customer/css/customer-style.css?q=<?php echo rand();?>">
    <link rel="stylesheet" href="<?php echo url('/');?>/public/customer/css/global.css?q=<?php echo rand();?>">
    <link rel="stylesheet" href="<?php echo url('/');?>/public/css/share.css?q=<?php echo rand();?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <!-- Mobile Responsive styles -->
    <link rel="stylesheet" href="<?php echo url('/');?>/public/customer/css/customer_resoponsive.css?q=<?php echo rand();?>">
    <!-- for tracking -->
    <script src="https://www.datadoghq-browser-agent.com/datadog-rum-eu.js" type="text/javascript">
    </script>
    <script>
      window.DD_RUM && window.DD_RUM.init({
        clientToken: 'pub36cb304d6b4093ef35d15e60b03c3772',
        applicationId: '04797c6b-7265-4dc6-802a-1e896506548b',
        trackInteractions: true,
      });
    </script>
    <!-- for tracking -->
    <style type="text/css">
        .cust_name{
            float: left;
        }
        .cust_status{
            float: right;
        }
        .select2-container .select2-selection--single{
            height:44px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height:42px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow{
            top:10px !important;
            right:10px !important;
        }

        .cust_status_active {
            float: right;
            background-color: #38B586;
            color: #fff;
            padding: 2px 10px;
            border-radius:2px;
        }
        .cust_status_expiry {
            float: right;
            background-color: #D0021B;
            color: #fff;
            padding: 2px 10px;
            border-radius:2px;
        }
        .package_list{
            overflow:hidden;
            overflow-y:auto;
            height:300px;
        }
        .caret{
            top: 24px !important;
            right: 15px;
        }
        .select_package_drop:focus{
            outline:none;
            box-shadow:none;
        }
    </style>
</head>

<body>
    @include('inc.v2.sidenav')

    <div class="main-wrap w-100">
        <div class="container-fluid">
            @include('inc.v2.headernav')

            <div class="row">

                <section class="main_body_section scroll_div col-12">
                    <!-- border -->
                    <hr class="grey-dark">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb pl-0">
                            <li class="breadcrumb-item f16">
                                <a href="<?php echo url('/transactions');?>" class="f16 position-relative pl-3">
                                <i class="fas fa-angle-left"></i>
                                Transactions
                            </a></li>
                            <li class="breadcrumb-item active f16" aria-current="page" class="f16">Renewal</li>
                        </ol>
                    </nav>

                    <h5 class="font20 font-bold text-uppercase text-white pt-4 mb-3">Renewal</h5>

                    <!-- Renewal Screen -->
                    <div id="step1" class="renewal_payment_steps">
                        <h6 class="font16 text-white">Please choose below package to renewal /reactivate your subscription.</h6>

                        <div class="clearfix ">
                            <div class="row">
                                <div class="col-lg-7 col-xl-5 col-md-10">
                                    <form method="post" id="create_form" name="create_form" action="<?php echo url('/').'/saveRenewal';?>">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" value="{{ $rec_id }}" id="renewal_id" name="renewal_id">
                                    <input type="hidden" id="subscription_type" name="subscription_type" value="Renewal">

                                    <h3 class="font16 font-bold text-uppercase text-white pt-4 mb-4">BestBOX Package</h3>

                                    <div class="form-group">
                                        <div class="select-test">
                                            <input type="hidden" name="package" id="package" value="">
                                            <input type="hidden" name="package_amount" id="package_amount" value="">
                                            <input type="hidden" name="package_name" id="package_name" value="">
                                            <input type="hidden" name="package_desc" id="package_desc" value="">
                                            <input type="hidden" name="package_discount" id="package_discount" value="">
                                            <input type="hidden" name="package_value" id="package_value" value="">
                                            <input type="hidden" name="payment_method" id="payment_method" value="">
                                            <input type="hidden" name="aliexpress_url" id="aliexpress_url" value="">
                                            <button class="select_package_drop " style="border: 1px solid #A02C72;border-radius: 5px;">
                                                <span>Select</span>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="f16 package_list">
                                                <li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">
                                                    Select Package
                                                </li>
                                                @foreach ($package_data as $val)
                                                    <li value="{{ $val->id }}" data-name="{{ $val->package_name }}" data-desc="{{ $val->description }}" data-package="{{ $val->id }}" data-amt="{{ $val->effective_amount }}" data-url="{{ $val->aliexpress_url }}" data-value="{{ $val->package_value }}" data-discount="{{ $val->discount }}" class="text-left border-top-purple" style="display: table; width: 100%;">
                                                        <div class="border-right-purple p-3" style="display: table-cell; width: 70%;">
                                                            <div class="" style="font-weight: 700;">{{ $val->package_name }}</div>
                                                        <div> {{ $val->description }}</div>
                                                        </div>
                                                        <div class="p-3 font-bold" style="display: table-cell; width: 30%;">${{ $val->effective_amount }}</div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="f12" style="color:red" id="packageErr"></div>

                                        </div>
                                    </div>

                                    <div class="col-12 mb-4 px-0">
                                            <h5 class="font20 font-bold text-uppercase text-white pt-4 mb-3">Payment Method</h5>
                                            <div class="select_payment col-xl-12">
                                                <div class="form-check mb-4">
                                                    <input class="form-check-input payment_type" type="radio" name="pay" id="exampleRadios1" value="WALLET">
                                                    <label class="form-check-label text-white" for="exampleRadios1">
                                                        Pay From My BestBOX Wallet
                                                    </label>
                                                </div>

                                                <!-- Wallet Balance -->
                                                <div class="col-lg-12 mb-4">
                                                    <div class="text-center">
                                                        <div class="f16 font-bold purple-bordered">
                                                            <div class="color-black mb-2">Wallet Balance</div>
                                                            <div class="purple_txt mb-2">${{ number_format($wallet_balance->amount,2) }}</div>
                                                            <input type="hidden" value="{{ $wallet_balance->amount }}" id="user_wallet_amt" name="user_wallet_amt">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-check mb-4">
                                                    <input class="form-check-input payment_type" type="radio" name="pay" id="exampleRadios2" value="ALIEXPRESS">
                                                    <label class="form-check-label text-white" for="exampleRadios2">
                                                        VISA / MASTERCARD <span class="pl-3"><img src="{{ url('/') }}/public/customer/images/cards.png?q=<?php echo rand();?>" style="width:90px;"></span>
                                                    </label>
                                                </div>
                                                <div class="form-check mb-4">
                                                    <input class="form-check-input payment_type" type="radio" name="pay" id="exampleRadios3" value="BANKPAYMENT">
                                                    <label class="form-check-label text-white" for="exampleRadios3">
                                                        Nigeria or Ghana based bank payments
                                                    </label>
                                                </div>
                                                <!--<div class="form-check">
                                                    <input class="form-check-input payment_type" type="radio" name="pay" id="exampleRadios3" value="EVERUSPAY">
                                                    <label class="form-check-label" for="exampleRadios3">
                                                        CRYPTO PAYMENT<!--<span class="pl-3"><img src="{{ url('/') }}/public/customer/images/evr-pay-logo.png?q=<?php echo rand();?>"
                                                                style="width:100px;"></span>
                                                    </label>
                                                </div>-->
                                                <div class="form-check">
                                                    <input class="form-check-input payment_type" type="radio" name="pay" id="exampleRadios4" value="Crypto Currency">
                                                    <label class="form-check-label" for="exampleRadios4" style="color:#fff !important">
                                                        Crypto Currency Payments <!--<span class="pl-3"><img src="{{ url('/') }}/public/customer/images/bit-pay-logo.png?q=<?php //echo rand();?>"
                                                                style="width:70px;"></span>-->
                                                    </label>
                                                </div>
                                                <div class="f12" style="color:red" id="paymethodErr"></div>
                                            </div>
                                        </div>
                                        <div class="f12" style="color:red" id="paymethodErr"></div>

                                    <div id="subsErr" class="error"></div>
                                    <input type="hidden" name="chkboxvalue" id="chkboxvalue">
                                    <div class="mt-4 mb-5">
                                        <div class="display_inline">
                                            <button class="btn btn_primary btn_cancel d-block w-100 mt-4" id="checkout_btn" >CHECKOUT</button>
                                        </div>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Confirm Purchase - Payment Method   -->
                    <div class="d-none" id="step2">
                        <div class="mb-5">
                            <p class="font-weight-bold text-white">Confirm Your Purchase</p>
                            <div class="col-12 mb-5">
                                <div class="row add-newcustomer">
                                    <table class="m_table ">
                                        <tbody>
                                            <tr class="tableHeader">
                                                <td style="font-weight:bold; background-color: #303030;" width="40%" class="text-white">Description</td>
                                                <td align="right" style="font-weight:bold; background-color:#303030;" class="text-white">Unit price</td>
                                                <td align="right" style="font-weight:bold; background-color:#303030;" class="text-white">Quantity</td>
                                                <td align="right" style="font-weight:bold; background-color:#303030;" class="text-white">Amount</td>
                                            </tr>
                                            <tr class="m_bgwhite">
                                                <td id="conf_desc" class="text-white">BestBOX + 1 Month Subscription
                                                    Includes pre - installed app & 1 month subscription + door to door delivery</td>
                                                <td align="right" class="disp_package_amt text-white" id="conf_amt">$34.99 USD</td>
                                                <td align="right" id="conf_qty" class="text-white">1</td>
                                                <td align="right" class="disp_package_amt text-white"  id="conf_price">$34.99 USD</td>
                                            </tr>
                                            <tr class="m_row">
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td align="right" class="text-white">Subtotal</td>
                                                <td align="right" class="disp_package_amt text-white" id="conf_sub_total">$34.99 USD</td>
                                            </tr>
                                            <tr class="m_row2">
                                                <td class="border-top-0 text-white">&nbsp;</td>
                                                <td class="border-top-0 text-white">&nbsp;</td>
                                                <td align="right" class="border-top-0 text-white">Discount</td>
                                                <td align="right" class="border-top-0 text-white" id="conf_discount">$0.00 USD</td>
                                            </tr>
                                            <tr class="m_row4">
                                                <td class="border-top-0 border-bottom text-white">&nbsp;</td>
                                                <td class="border-top-0 border-bottom text-white">&nbsp;</td>
                                                <td align="right" style="font-weight:bold; width:160px;" class="text-white border-bottom">Amount payable</td>
                                                <td align="right" style="font-weight:bold" class="text-white border-bottom disp_package_amt" id="conf_amt_pay">$34.99 USD</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="d-none" id="conf_paymethod">
                            <p class="font-weight-bold text-white">Payment Method</p>
                            <div class="d-none" id="wallet_pay">
                                <p class="text-white">Payment From My BestBOX Wallet</p>
                                    <!-- Wallet Balance- BestBOX Wallet -->
                                <div class="col-lg-5 col-xl-4 col-sm-8 col-12 mb-4 pl-0">
                                    <div class="text-center">
                                        <div class="f16 font-bold purple-bordered">
                                            <div class="color-black mb-2">Wallet Balance</div>
                                            <div class="purple_txt mb-2">${{ number_format($wallet_balance->amount,2) }}</div>
                                            <input type="hidden" value="{{ $wallet_balance->amount }}" id="user_wallet_amt" name="user_wallet_amt">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Wallet Balance- EverusPay Wallet -->
                            <div class="d-none" id="everuspay_pay">
                                <p>CRYPTO PAYMENT</p>
                                <div class="col-lg-5 col-xl-4 col-sm-8 col-12 mb-4 pl-0">
                                    <div class="text-center">
                                        <!--<div class="f16 font-bold purple-bordered">
                                            <div class="purple_txt mb-2"><img src="{{ url('/') }}/public/customer/images/evr-pay-logo.png?q=<?php echo rand();?>" style="width:148px;"></div>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                            <div class="d-none" id="bankpay_pay">
                                <p class="text-white">Nigeria or Ghana based bank payment</p>
                                <div class="col-lg-5 col-xl-4 col-sm-8 col-12 mb-4 pl-0">
                                    <div class="text-center">
                                        <!--<div class="f16 font-bold purple-bordered">
                                            <div class="purple_txt mb-2"><img src="{{ url('/') }}/public/customer/images/evr-pay-logo.png?q=<?php echo rand();?>" style="width:148px;"></div>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                            <div class="d-none" id="bitpay_pay">
                                <p class="text-white">Crypto Currency Payment</p>
                                <div class="col-lg-5 col-xl-4 col-sm-8 col-12 mb-4 pl-0">
                                    <div class="text-center">
                                        <!--<div class="f16 font-bold purple-bordered">
                                            <div class="purple_txt mb-2"><img src="{{ url('/') }}/public/customer/images/bit-pay-logo.png?q=<?php //echo rand();?>" style="width:148px;"></div>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 mb-5">
                                <div class="display_inline">
                                    <a href="" class="btn_cancel">
                                        Back
                                    </a>
                                </div>

                                <div class="display_inline">
                                    <button class="btn btn_primary btn_cancel d-block w-100 mt-4" id="proceed_btn">PAY NOW</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- confirm payment -->
    <div class="modal fade" id="confirm_payment" role="dialog">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Confirm your Subscription</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form method="post" id="create_user" name="create_user" action="<?php echo url('/').'/';?>"
                class="needs-validation" novalidate>
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div id="confirm_data"></div>

              <div class="row modal_footer_btn">
                  <div class="col modal_cancel_btn" id="conf_cancel">
                    Cancel
                  </div>
                  <div class="col modal_proceed_btn">
                    <button class="btn" id="confirm_btn">Proceed</button>
                  </div>
              </div>
          </form>
            </div>
          </div>
        </div>
      </div>
     <!-- The Modal -->

      <!-- Order User -->
    <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="orderNotify"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <h5 class="modal-title font-bold black_txt text-uppercase f20" id="exampleModalLongTitle">
                        Notification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body add_edit_user pb-4">
                    <div class="text-left f16 black_txt">
                        <p>Now for the last lap. 2 final steps:</p>

                        <p>1. You will be redirected to the Aliexpress App or Site. If you do not have an account with Aliexpress, please sign up for an account.</p>

                        <p>2. Please finalize the purchase of your desired service and product. You will receive a confirmation email summarizing your purchase. If you purchased a TV box, you will also receive your tracking number.</p>
                    </div>
                </div>
                <!-- footer buttons -->
                <div class="inline-buttons">
                   <a href="" class="btn inline-buttons-center btn_primary" target="_blank"
                            id="purchaseUrl" style="color:#fff !important;">Proceed</a>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal fade" id="bankpaymentAlertModal" tabindex="-1" role="dialog" aria-labelledby="orderNotify" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <h5 class="modal-title font-bold text-black text-uppercase f20" id="exampleModalLongTitle">
                    Payment Instruction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body add_edit_user pb-4">
                    <div class="text-left f16 text-black">
                    
                    <p>For Nigeria or Ghana based bank payments, please WhatsApp or email us for instructions.</p>
                    <p>Click <a href="https://api.whatsapp.com/send?phone=2347081808391&text=Hello, I would like to subscribe/renewal to your BVOD1 (1 month Subscription) and $9.99 USD, please send me banking instructions. Thank you&source=&data=&app_absent=" class="whatsapp_txt" target="_blank">here</a> to WhatsApp us </p>
                    <p>OR</p>
                    <p>Click <a href="mailto:help@bestbox.net?subject=Package in Bestbox&body=Hello, I would like to subscribe/renewal to your BVOD1 (1 month Subscription) and $9.99 USD, please send me banking instructions. Thank you" class="mail_txt" target="_blank">here</a> to email us </p>
                    </div>
                </div>
                <!-- footer buttons -->
                <div class="inline-buttons">
                    <a href="javascript:void(0);" class="btn inline-buttons-center btn_primary" id="bankpaymentAlertClose" style="color:#fff !important;">OK</a>
                </div>
            </div>
        </div>
    </div>
        <!-- The Modal -->
        <div class="modal fade" id="cryptoPaymentAlertModal" tabindex="-1" role="dialog" aria-labelledby="orderNotify"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header no-border">
                        <h5 class="modal-title font-bold text-black text-uppercase f20" id="exampleModalLongTitle">
                        Payment Instruction</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body add_edit_user pb-4">
                        <div class="text-left f16 text-black">
                        <p>For crypto currency payments, please WhatsApp or email us for instructions.</p>
                        <p>Click <a href="https://api.whatsapp.com/send?phone=00971527925634&text=Hello, I would like to subscribe/renewal to your BVOD1 (1 month Subscription) and $9.99 USD using crypto,please send me the instructions. Thank you&source=&data=&app_absent=" class="whatsapp_txt" target="_blank">here</a> to WhatsApp us </p>
                        <p>OR</p>
                        <p>Click <a href="mailto:help@bestbox.net?subject=Package in Bestbox&body=Hello, I would like to subscribe/renewal to your BVOD1 (1 month Subscription) and $9.99 USD using crypto,please send me the instructions." class="mail_txt" target="_blank">here</a> to email us </p>
                        </div>
                    </div>
                    <!-- footer buttons -->
                    <div class="inline-buttons">
                        <a href="javascript:void(0);" class="btn inline-buttons-center btn_primary" id="cryptoPaymentAlertClose"
                            style="color:#fff !important;">OK</a>
                    </div>
                </div>
            </div>
        </div>
    <!-- The Modal -->
     @include('inc.v2.footer')
     <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
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
            swal(
                'Success',
                '<?php echo Session::get('message');?>',
                'success'
            )
        </script>
    <?php
        }
    ?>

</body>

</html>

<script>
    $("#conf_cancel").click(function(){
        $("#confirm_payment").modal('hide');
    });

    $("#confirm_btn").click(function(e){
        e.preventDefault();
        $("#confirm_payment").modal('hide');
        $("#create_form").submit();
    });

    $('.menucheck').on('change', function() {
        $("#chkboxvalue").val($(this).attr('id'));
        if ($(this).is(":checked")) {
            $('.menucheck').not(this).prop('checked', false);
        }
        else{
            $('.menucheck').not(this).prop('checked', true);
        }
    });

        $(function () {
            $("#bankpaymentAlertClose").click(function (e) {
                e.preventDefault();
                $("#bankpaymentAlertModal").modal("hide");
            });
            $("#cryptoPaymentAlertClose").click(function (e) {
                e.preventDefault();
                $("#cryptoPaymentAlertModal").modal("hide");
            });
            var select = $(".select-test");
            select.select({
                selected: 0,
                //animate: "slide"
            });
        });

        //step1

        $("#checkout_btn").click(function(e){
            e.preventDefault();
            var payment_method = $("input[name='pay']:checked").val();
            $("#payment_method").val(payment_method);
            var package = $("#package").val();
            if (package == '') {
                $("#packageErr").html('Package is Required');
                return false;
            } else {
                $("#packageErr").html('');
            }
            if(!$("input[name='pay']:checked").val()){
                $("#paymethodErr").html('Select payment method');
                return false;
            }
            $("#step1").addClass('d-none');
            $(".conf_purchase").html('');
            $("#everuspay_pay, #wallet_pay").addClass('d-none');
            $("#step2, #conf_paymethod").removeClass("d-none");
            if(payment_method == 'EVERUSPAY') {
                $("#everuspay_pay").removeClass("d-none");
            }else if(payment_method == 'Crypto Currency') {
                $("#bitpay_pay").removeClass("d-none");
            }else if(payment_method == 'WALLET') {
                $("#wallet_pay").removeClass("d-none");
            }else if(payment_method == 'BANKPAYMENT') {
                $("#bankpay_pay").removeClass("d-none");
            }
            var amount = $("#package_amount").val();
            var package_name = $("#package_name").val();
            var package_desc = $("#package_desc").val();
            var package_discount = $("#package_discount").val();
            var package_value = $("#package_value").val();
            $("#conf_desc").html(package_name+'<br/>'+package_desc);
            $("#conf_amt").html('$'+ package_value+' USD');
            var bankpayHtml = package_name+' '+package_desc+' and $'+ package_value+' USD';
            $("#bankpayHtml").html(bankpayHtml);
            $("#conf_qty").html(1);
            $("#conf_price").html('$'+ package_value+' USD');
            $("#conf_sub_total").html('$'+ package_value+' USD');
            $("#conf_discount").html('-$'+ package_discount+' USD');
            $("#conf_amt_pay").html('$'+ amount+' USD');
            if(payment_method == 'Crypto Currency') {
                var whatsapp_txt = 'https://api.whatsapp.com/send?phone=00971527925634&text=Hello, I would like to subscribe/renewal to your '+package_name+' ('+ package_desc +') and $'+amount+' USD using Crypto, please send me the instructions. Thank you&source=&data=&app_absent=';
                var email_txt = 'mailto:help@bestbox.net?subject=Package in Bestbox&body=Hello, I would like to subscribe/renewal to your '+package_name+' ('+ package_desc +') and $'+amount+' USD using Crypto, please send me the instructions. Thank you';
            }else{
                var whatsapp_txt = 'https://api.whatsapp.com/send?phone=2347081808391&text=Hello, I would like to subscribe/renewal to your '+package_name+' ('+ package_desc +') and $'+amount+' USD, please send me banking instructions. Thank you&source=&data=&app_absent=';
                var email_txt = 'mailto:help@bestbox.net?subject=Package in Bestbox&body=Hello, I would like to subscribe/renewal to your '+package_name+' ('+ package_desc +') and $'+amount+' USD, please send me banking instructions. Thank you';
            
            }
            $(".whatsapp_txt").attr('href',whatsapp_txt);
            $(".mail_txt").attr('href',email_txt);
        });

        //step2

        $("#proceed_btn").click(function(e){

            var imageurl = "<?php echo url('/').'/public/customer/images/evr-pay-logo.png';?>";
            e.preventDefault();
            var payment_method = $("input[name='pay']:checked").val();
            $("#payment_method").val(payment_method);
            var package = $("#package").val();
            if (package == '') {
                $("#packageErr").html('Package is Required');
                return false;
            } else {
                $("#packageErr").html('');
            }
            var package_name = $("#package_name").val();
            var package_desc = $("#package_desc").val();
            var package_value = $("#package_value").val();

            if(!$("input[name='pay']:checked").val()){
                $("#paymethodErr").html('Select payment method');
                return false;
            }else if(payment_method == "WALLET" || payment_method == "EVERUSPAY" ){
                $("#create_form").submit();
            }else if(payment_method == "ALIEXPRESS"){
                var aliexpress_url = $("#aliexpress_url").val();
                var url = "https://www.aliexpress.com/item/"+aliexpress_url;
                $("#purchaseUrl").attr('href', url);
                $("#alertModal").modal("show");
            }else if (payment_method == "Crypto Currency") {
                $("#cryptoPaymentAlertModal").modal("show");
            }else if (payment_method == "BANKPAYMENT") {
                $("#bankpaymentAlertModal").modal("show");
            }else{
                swal({
                title: 'Are you sure?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4FC550',
                cancelButtonColor: '#D0D0D0',
                confirmButtonText: 'Yes, proceed it!',
                closeOnConfirm: false,
                html: "Renewal subscription"
                }).then(function (result) {
                    if (result.value) {
                        $("#create_form").submit();
                    }
                }).catch(swal.noop);
            }
        });


        /* select box*/
        $(document).ready(function()
        {
            var package_id = "<?php echo $renewal_package['id'];?>";
            var package_name = "<?php echo $renewal_package['package_name'];?>";
            var package_desc = "<?php echo $renewal_package['description'];?>";
            var amount = "<?php echo $renewal_package['effective_amount'];?>";
            var discount = "<?php echo $renewal_package['discount'];?>";
            var package_value = "<?php echo $renewal_package['package_value'];?>";

            var aliexpress_url = "<?php echo $renewal_package['aliexpress_url'];?>";
            console.log(aliexpress_url);
            $("#package").val(package_id);
            $("#package_amount").val(amount);
            $("#package_name").val(package_name);
            $("#package_desc").val(package_desc);
            $("#package_discount").val(discount);
            $("#package_value").val(package_value);
            $("#aliexpress_url").val(aliexpress_url);
            setTimeout(function() {
                $(".select-test span:first").html('<div class="p-1" style=><div class="float-left" style="width:75%"><div style="font-weight: 700;">'+package_name+'</div><div>'+package_desc+'</div></div><div class="float-right font-bold pr-2 pt-3">$'+amount+'</div></div>');
            }, 50);

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
                    $("#package_name").val('');
                    $("#package_desc").val('');
                    $("#package_discount").val('');
                    $("#package_value").val('');
                }else{
                    var package_name = $(this).attr('data-name');
                    var package_desc = $(this).attr('data-desc');
                    var aliexpress_url = $(this).attr('data-url');
                    var discount = $(this).attr('data-discount');
                    var package_value = $(this).attr('data-value');
                    $("#package").val(package_id);
                    $("#package_amount").val(amount);
                    $("#package_name").val(package_name);
                    $("#package_desc").val(package_desc);
                    $("#aliexpress_url").val(aliexpress_url);
                    $("#package_discount").val(discount);
                    $("#package_value").val(package_value);
                    setTimeout(function() {
                        $(".select-test span:first").html('<div class="p-1" style=><div class="float-left" style="width:75%"><div style="font-weight: 700;">'+package_name+'</div><div>'+package_desc+'</div></div><div class="float-right font-bold pr-2 pt-3">$'+amount+'</div></div>');
                    }, 50);
                }
            });
        });

        $(".payment_type").click(function(){
            var payment = $("input[name='pay']:checked").val();
            $("#payment_method").val(payment);
            var package_id = $("#package").val();
            var amount = $("#package_amount").val();
            var user_wallet_amt = $("#user_wallet_amt").val();
            var package_name = $("#package_name").val();
            var package_desc = $("#package_desc").val();
            if(payment == 'WALLET'){
                if(parseFloat(amount) > parseFloat(user_wallet_amt)){
                    $("#package").val('');
                    $("#package_amount").val('');
                    $("#package_name").val('');
                    $("#package_desc").val('');
                    $("#package_discount").val();
                    $("#package_value").val();
                    $("#aliexpress_url").val('');
                    swal(
                        'Failure',
                        'Insufficient Balance In Your Wallet',
                        'error'
                    )
                    setTimeout(function() {
                        $(".select-test span:first").html('<li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">Select Package</li>');
                    }, 50);
                }
                else{
                    if(package_id == ""){
                        setTimeout(function() {
                            $(".select-test span:first").html('<li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">Select Package</li>');
                        }, 50);
                    }else{
                        setTimeout(function() {
                            $(".select-test span:first").html('<div class="p-1" style=><div class="float-left" style="width:75%"><div style="font-weight: 700;">'+package_name+'</div><div>'+package_desc+'</div></div><div class="float-right font-bold pr-2 pt-3">$'+amount+'</div></div>');
                        }, 50);
                    }
                }
            }
        });
</script>

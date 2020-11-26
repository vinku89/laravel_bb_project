<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Renewal Subscription</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @if($userInfo['user_role'] == 4)
       @include("customer.inc.all-styles")
    @else
        @include("inc.styles.all-styles")
    @endIf
    <style type="text/css">
        .cust_name{
            float: left;
        }
        .cust_status{
            float: right;
        }
        label[for="file-upload"] {
            padding: 0.5em;
            display: inline-block;
            cursor: pointer;
            max-width: 120px;
            text-align: center;
            background: #7B7B7B;
            border: 1px solid #979797;
            border-radius: 5px;
            color: #fff;
            vertical-align: middle;
            line-height: 0;
            margin-right: 20px;
        }
        #filename {
            padding: 0.5em;
            float: none;
            max-width: 305px;
            white-space: nowrap;
            overflow: hidden;
            background: #fff;
            margin-left: 20px;
            background: #FFFFFF;
            border: 1px solid #979797;
            border-radius: 5px;
        }
        .order-upload {
            position: absolute;
            left: -9999px;
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

        .cust_status_active {
            float: right;
            background-color: #38B586;
            color: #fff;
            padding: 2px 10px;
            border-radius:2px;
             font-size: 13px;
        }
        .cust_status_expiry {
            float: right;
            background-color: #D0021B;
            color: #fff;
            padding: 2px 10px;
            border-radius:2px;
            font-size: 13px;

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
                <ol class="breadcrumb pl-0 pb-0">
                    <li class="breadcrumb-item f16">
                        <a href="<?php echo url('/customers');?>" class="f16 position-relative breadcrumb_pd">
                            <i class="fas fa-angle-left"></i>
                            Customers List
                         </a>
                </li>
                    <li class="breadcrumb-item active f16" aria-current="page" class="f16">Renewal</li>
                </ol>
            </nav>

            <h5 class="font20 font-bold text-uppercase black_txt pt-4 mb-3">Renewal</h5>

            <div class="clearfix col-12">
                <div class="row">
                    <div class="form-width2">
                        <div id="step1">
                        <form method="post" id="create_form" name="create_form" action="<?php echo url('/').'/saveRenewalSubscription';?>" class="needs-validation" novalidate enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                         <!-- Create Customer ID -->
                         <h3 class="font16 font-bold text-uppercase black_txt pt-4 mb-1">Enter Name or User ID</h3>
                         <div class="pt-3 pb-2 mb-3">
                              <select class="js-example-basic-single h50 border-bottom-only body_bg" id="username" name="username" style="width:100%;">
                                <option value="">Choose Name</option>

                              </select>
                              <div id="err_msg_customer" class="error"></div>
                        </div>

                        <div class="col-12 subcribe_wrp mb-3" id="subscribe_options">
                                <div class="col-12">
                                    <div class="row border-bottom-blue py-2">
                                        <div class="col-9 orange_txt font-weight-bold">
                                                New Subscription
                                            </div>
                                            <div class="col-3 text-right">
                                                <label class="switch">
                                                    <input type="checkbox" name="subscription_type" class="menucheck" id="new" value="New" disabled="disabled">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                    </div>

                                </div>
                                <div class="col-12">
                                <div class=" row py-2">
                                        <div class="col-9 orange_txt font-weight-bold">
                                            Renewal Subscription
                                        </div>
                                        <div class="col-3 text-right">
                                            <label class="switch">
                                                <input type="checkbox" name="subscription_type" class="menucheck" id="renew" value="Renewal">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                </div>
                                </div>
                            </div>
                            <div id="subsErr" class="error"></div>
                            <input type="hidden" name="chkboxvalue" id="chkboxvalue">
                            <div class="form_bg5">
                                <div class="form-group">
                                   <div class="select-test">
                                       <label for="exampleInputEmail1" class="font-bold black_txt">BestBOX Package</label>
                                       <input type="hidden" name="package" id="package" value="">
                                       <input type="hidden" name="package_amount" id="package_amount" value="">
                                       <input type="hidden" name="check_setupbox_status" id="check_setupbox_status" value="">
                                       <input type="hidden" name="payment_method" id="payment_method" value="">
                                       <input type="hidden" name="type" id="type" value="2">
                                       <button class="package_selection" disabled>
                                           <span>Select</span>
                                           <span class="caret"></span>
                                       </button>
                                       <ul class="f16 package_list">
                                           <li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">
                                               Select Package
                                           </li>
                                       </ul>
                                   </div>
                                    <div class="f12" style="color:red" id="packageErr"></div>
                               </div>

                               <!-- Pre Buy -->
                               <div class="form_bg6">
                                   <label for="exampleInputEmail1" class="font-bold black_txt">Payment Method</label>
                                       <div class="col-12 mt-3 pl-0">
                                           <div class="form-group form-check">
                                               <input type="checkbox" name="pay" id="pay" data-value='wallet' value="WALLET" class="payment form-check-input" style="width: inherit;">
                                               <label class="form-check-label payfor_friend" for="exampleCheck1">Pay From My Wallet</label>
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
                                               <input type="checkbox" name="pay" id="pay" data-value='everuspay' value="EVERUSPAY" class="payment form-check-input" style=" width: inherit;">
                                               <label class="form-check-label payfor_friend" for="exampleCheck1">CRYPTO PAYMENT<!--<span class="pl-3"><img src="{{ url('/') }}/public/customer/images/evr-pay-logo.png?q=<?php echo rand();?>"
                                                       style="width:100px;"></span></label>
                                           </div>
                                       </div> -->
                                       <div class="col-12 mt-4 pl-0 {{ $userInfo['admin_login'] == 1 ? '' : 'd-none'}}">
                                           <div class="form-group form-check">
                                               <input type="checkbox" name="pay" id="exampleCheck1" data-value='aliexpress' class="payment form-check-input" style=" width: inherit;" value="ALIEXPRESS">
                                               <label class="form-check-label payfor_friend" for="exampleCheck1">VISA / MASTERCARD<span class="pl-3"><img src="{{ url('/') }}/public/customer/images/cards.png?q=<?php echo rand();?>"
                                                       style="width:100px;"></span></label>
                                           </div>
                                       </div>
                                       <div class="col-12 mt-4 pl-0 {{ $userInfo['admin_login'] == 1 ? '' : 'd-none'}}">
                                           <div class="form-group form-check">
                                               <input type="checkbox" name="pay" id="exampleCheck2" data-value='bankpayment' class="payment form-check-input" style=" width: inherit;" value="BANKPAYMENT">
                                               <label class="form-check-label payfor_friend" for="exampleCheck2">Nigeria or Ghana based bank payments</label>
                                           </div>
                                       </div>
                                       <div class="col-12 mt-4 pl-0 {{ $userInfo['admin_login'] == 1 ? '' : 'd-none'}}">
                                           <div class="form-group form-check">
                                               <input type="checkbox" name="pay" id="exampleCheck3" data-value='bitpay' class="payment form-check-input" style=" width: inherit;" value="BITPAY">
                                               <label class="form-check-label payfor_friend" for="exampleCheck3">Crypto Currency Payment</label>
                                           </div>
                                       </div>
                                       <div class="f12" style="color:red" id="paymethodErr"></div>
                               </div>

                           </div>
                           <!-- if payment type is visa card show this div -->
                           <div id="aliexpress_payment_div" style="display: none;">
                            <div class="form-group">
                                    <label for="exampleInputEmail1" class="font-bold black_txt">* Enter Payment ID /
                                        Reference</label>
                                    <input type="text" class="form-control border-bottom-only body_bg mt-3" id="order_id"
                                        name="order_id" aria-describedby="Payment ID" placeholder="Payment ID / Reference"
                                        value="">
                                    <div class="f12" style="color:red" id="paymentIdErr"></div>
                                </div>
                                <div class="font-bold black_txt mt-5">Upload attachment</div>
                                <div class=" d-table w-100 my-3">
                                    <label for="file-upload" class="d-table-cell w30">Choose file<input type="file" id="file-upload"
                                            name="invoice_attachment" accept="image/*,application/pdf"
                                            class="order-upload "></label>
                                    <div class="d-table-cell w5"></div>
                                    <span id="filename" class="d-table-cell w65">No file choosen</span><div>&nbsp;</div>

                                </div>
                                <div class="f12" style="color:red" id="attachmentErr"></div>
                                <div class="text-center f12 black_txt mt-3">Allowed file type : jpg, jpeg, png and PDF. maximum file
                                    size : 2MB</div>
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
                            <select id="select_country3" name="shipping_country">
                                <option value="" class="font14">Select Country</option>
                                <?php
                                    foreach ($country_data as $val) {
                                        echo "<option value='".$val->countryid."' data-id='".$val->currencycode."'>".$val->country_name."</option>";
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
                                </div>
                                <div id="mobile_no_err" class="f14 red_txt"></div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="subs_type" name="subs_type" value="1">
                        <input type="hidden" name="selected_wal" id="selected_wal">
                        <div class="my-4">
                            <div class="display_inline">
                                <a href="<?php echo url('/transactions');?>" class="btn_cancel">
                                    CANCEL
                                </a>
                            </div>

                            <div class="display_inline">
                                 <button class="btn btn_primary btn_cancel d-block w-100 mt-4" id="proceed_btn" type="submit">PROCEED</button>
                            </div>
                        </div>

                    </form>
                </div>

                    </div>
                    <div id="step2" class="d-none col-12 pl-0">
                        <ul class="p-0">
                            <li class="list-type-none pb-2">Email: <span class="font-weight-bold black_txt" id="disp_email">abctest@gmail.com</span></li>
                            <li class="list-type-none pb-2">First Name: <span class="font-weight-bold black_txt" id="disp_first_name">abc</span></li>
                            <li class="list-type-none">Last Name: <span class="font-weight-bold black_txt" id="disp_last_name">test</span></li>
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
                                                <td align="right" style="font-weight:bold; width:160px;" class=" border-bottom">Amount payable</td>
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
                                                <label class="form-check-label payfor_friend" for="exampleCheck1">Everus Pay<span
                                                        class="pl-3"><img src="{{ url('/') }}/public/customer/images/evr-pay-logo.png?q=<?php echo rand();?>" style="width:100px;"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-none" id="bank_pay">
                                        <div class="col-12 mt-4 pl-0">
                                            <div class="form-group form-check">
                                                <label class="form-check-label payfor_friend" for="exampleCheck2">Nigeria or Ghana based bank payments
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-none" id="crypto_pay">
                                        <div class="col-12 mt-4 pl-0">
                                            <div class="form-group form-check">
                                                <label class="form-check-label payfor_friend" for="exampleCheck3">Crypto Currency Payment
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div id="disp_shipping_addr" class="d-none">
                                    <p class="font-weight-bold black_txt font-bold text-uppercase">Shipping Address</p>
                                    <div class="form_bg6 mb-5" id="disp_shipping_address">
                                        <p> Jack Reacher <br>Rue Perdtemps 3,<br>
                                        Nyon Street,<br>
                                        1260 Switzeland.<br>
                                        +423234234234</p>
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
    <!-- All scripts include -->
   @include("inc.scripts.all-scripts")

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
                    <div class="text-center f18 black_txt py-5 font-bold red_txt">
                        Insufficient Balance In Your Wallet.
                    </div>
                </div>
                <input type="hidden" name="delete_user_id" id="delete_user_id">
                <!-- footer buttons -->
                <div class="inline-buttons">
                    <button type="button" class="btn inline-buttons-right create-btn" style="width:100%;" data-dismiss="modal"><strong>CLOSE</strong></button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
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
<script>
    /* select box*/
    var html = '';var html2 =''; var html3='';
    $(document).ready(function()
        {
            html += '<li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">Select Package</li>';
            html2 += '<li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">Select Package</li>';
            <?php foreach ($package_data as $val) {?>
                var id = '<?php echo $val->id;?>';
                var setupbox_status = '<?php echo $val->setupbox_status;?>';
                var amount = '<?php echo $val->effective_amount;?>';
                var package_name = '<?php echo $val->package_name;?>';
                var description = '<?php echo $val->description;?>';
                var package_value = '<?php echo $val->package_value;?>';
                var discount = '<?php echo $val->discount;?>';
                html += '<li value="'+id+'" data-box="'+setupbox_status+'" data-package="'+id+'" data-actualamt="'+package_value+'" data-discountamt="'+discount+'" data-amt="'+amount+'" data-name="'+package_name+'" data-desc="'+description+'" class="text-left" style="display: table; width: 100%;">';
                    html += '<div class="border-right-blue p-3" style="display: table-cell; width: 70%;">';
                        html += '<div class="" style="font-weight: 700;">'+package_name+'</div>';
                        html += '<div>'+description+'</div>';
                    html += '</div>';
                    html += '<div class="p-3 font-bold" style="display: table-cell; width: 30%;">'+amount+' USD</div>';
                html += '</li>';
            <?php }?>
            <?php foreach ($package_data as $val) {?>
                var id = '<?php echo $val->id;?>';
                var setupbox_status = '<?php echo $val->setupbox_status;?>';
                var amount = '<?php echo $val->effective_amount;?>';
                var package_name = '<?php echo $val->package_name;?>';
                var description = '<?php echo $val->description;?>';
                var package_value = '<?php echo $val->package_value;?>';
                var discount = '<?php echo $val->discount;?>';
                <?php if($val->setupbox_status == 2) {?>
                    html2 += '<li value="'+id+'" data-box="'+setupbox_status+'" data-package="'+id+'" data-actualamt="'+package_value+'" data-discountamt="'+discount+'" data-amt="'+amount+'" data-name="'+package_name+'" data-desc="'+description+'" class="text-left" style="display: table; width: 100%;">';
                            html2 += '<div class="border-right-blue p-3" style="display: table-cell; width: 70%;">';
                                    html2 += '<div class="" style="font-weight: 700;">'+package_name+'</div>';
                                    html2 += '<div>'+description+'</div>';
                            html2 += '</div>';
                            html2 += '<div class="p-3 font-bold" style="display: table-cell; width: 30%;">'+amount+' USD</div>';
                    html2 += '</li>';
                <?php }
            }?>

            $('body').on('click', 'ul.package_list li', function(){

                var amount = $(this).attr('data-amt');
                var actual_amount = $(this).attr('data-actualamt');
                var discountamt = $(this).attr('data-discountamt');
                var setupbox_status = $(this).attr('data-box');
                $("#check_setupbox_status").val(setupbox_status);
                if(setupbox_status == 1){
                    $("#shipping_user_mobile_no").prop('required',true);
                    $("#shipping_addr").css('display','block');
                }else{
                    $("#shipping_user_mobile_no").prop('required',false);
                    $("#shipping_addr").css('display','none');
                }

                $(".select_package_drop").addClass('sel_pack');
                var package_id = $(this).attr('data-package');
                $("#package").val(package_id);
                $("#package_amount").val(amount);
                var package_name = $(this).attr('data-name');
                var package_desc = $(this).attr('data-desc');
                $("#disp_package_desc").html(package_desc);
                $(".disp_package_amt").html("$"+amount+" USD");
                $(".disp_actual_amt").html("$"+actual_amount+" USD");
                $("#disp_discount_amt").html("-$"+discountamt+" USD");
                setTimeout(function() {
                    $(".select-test span:first").html("<div class='p-1 clearfix' style='width: 100%;background-color:#fff;'><div class='float-left' style='width:75%'><div style='font-weight: 700;'>"+package_name+"</div><div>"+package_desc+"</div></div><div class='float-right font-bold pr-4 pt-2'>$ "+amount+"</div></div>");
                }, 50);

            });
        });

        $(".payment").click(function(){

            if ($(this).is(":checked")) {
                var payment_type = $(this).attr('data-value');
                 $("#payment_method").val(payment_type);
                $('.payment').each(function(){
                    if($(this).attr('data-value') != payment_type){
                       $(this).prop('checked', false);
                    }
                });
                if(payment_type == 'everuspay') {
                    $("#everuspay_pay").removeClass("d-none");
                    $("#wallet_pay").addClass("d-none");
                    $("#aliexpress_payment_div").css('display','none');
                }else if(payment_type == 'wallet') {
                    $("#everuspay_pay").addClass("d-none");
                    $("#wallet_pay").removeClass("d-none");
                    $("#aliexpress_payment_div").css('display','none');
                }else if(payment_type == 'aliexpress' || payment_type == 'bankpayment' || payment_type == 'bitpay'){
                    $("#aliexpress_payment_div").css('display','block');
                }

                if(payment_type == 'wallet'){
                    var user_wallet_amt = $("#user_wallet_amt").val();
                    var amount = $("#package_amount").val();
                    if(parseFloat(amount) > parseFloat(user_wallet_amt)){
                        $(this).prop('checked', false);
                        swal(
                            'Failure',
                            'Insufficient Balance In Your Wallet',
                            'error'
                        )
                        setTimeout(function(){
                            $(".select-test span:first").html("<li value='' data-package='' data-amt='' class='text-left' style='display: table; width: 100%;'>Select Package</li>");
                        }, 50);
                    }
                }

            }else{
                $('.payment').each(function(){
                    if($(this).attr('data-value') != payment_type){
                        $(this).prop('checked', false);
                    }
                });
                $("#aliexpress_payment_div").css('display','none');
                $("#paymentIdErr").html('');
                $("#attachmentErr").html('');
                $("#aliexpressemailIdErr").html('');
            }
        });

        $("#file-upload").change(function () {
            var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'pdf'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                $("#attachmentErr").html('Please Upload only JPEG,JPG,PNG or PDF formats only');
                return false;
            } else if (this.files[0].size > 2097152) {
                $("#attachmentErr").html('File size is larger than 2MB!');
                return false;
            }
        });

        $(document).ready(function()  {
            var select = $(".select-test");
            select.select({
                selected: 0,
                //animate: "slide"
            });
        });

        var data = <?php echo $customers_data;?>;

        function template(data) {
            return data.html;
        }

        $("#username").select2({
            placeholder: 'Search Name',
            data: data,
            templateResult: template,
            escapeMarkup: function(m) {
              return m;
           }
        });
        data.forEach(function(data) {
            if (data.name) {
                var $newOption = $("<option selected='selected'></option>").val(data.id).text(data.text)
                $("#username").append($newOption).trigger('change');
            }
        });

        //when loading the document called this function

        $(document).ready(function(){
            var id = $("#username").val();
            var csrf_Value = "<?php echo csrf_token(); ?>";
            $.ajax({
                    type: 'POST',
                    url: "<?php echo url('/');?>/checkPackagePurchase",
                    data: {'_token':csrf_Value,'id':id},
                    dataType: "json",
                    success: function (data) {
                        $("#disp_email").html(data.email);
                        $("#disp_first_name").html(data.first_name);
                        $("#disp_last_name").html(data.last_name);
                    }
                });
            var name = $("#username").children("option:selected").text();
            $("#selected_wal").val(name);
            $("#subsErr").html('');
            $(".package_list").html(html2);
            $(".select-test span:first").html("<li value='' data-package='' data-amt='' class='text-left' style='display: table; width: 100%;'>Select Package</li>");

            $("#new").attr("disabled", true);
            $("#renew").attr("disabled", true);
            $("#renew").prop('checked', true);
            $("#new").prop('checked', false);
            $(".package_selection").prop("disabled", false);
        });

        $("#proceed_btn").click(function(e){
            e.preventDefault();
            var package = $("#package").val();
            var customer_id = $("#username").val();
            var user_name = $("#selected_wal").val();
            error = false;
            if(customer_id == ""){
                $("#err_msg_customer").html("Please select customer");
                error = true;
            }else{
                $("#err_msg_customer").html("");
            }
            if (package == '') {
                $("#packageErr").html('Package is Required');
                error = true;
            } else {
                $("#packageErr").html('');
            }
           var subs_type = $("#subs_type").val();

            var html = "Renewal subscription for customer (<b>"+user_name+"</b>)";
            var payment_type = '';
            $('.payment').each(function(){
                if ($(this).is(":checked")) {
                    payment_type = $(this).attr('data-value');
                }
            });

            if(payment_type == 'aliexpress' || payment_type == 'bankpayment' || payment_type == 'bitpay'){
                var order_id = $("#order_id").val().trim();
                if (order_id == '') {
                    $("#paymentIdErr").html('Payment ID Required');
                    error = true;
                } else {
                    $("#paymentIdErr").html('');
                }
                var fileName = $("#file-upload").val();
                if(fileName!='') {
                    var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
                    if ($.inArray(fileName.split('.').pop().toLowerCase(), fileExtension) == -1) {
                        $("#attachmentErr").html('Please Upload only JPEG,JPG,PNG or PDF formats only');
                        error = true;
                    } else {
                        $("#attachmentErr").html('');
                    }
                }
            }else{
                $("#paymentIdErr").html('');
                $("#attachmentErr").html('');
                $("#aliexpressemailIdErr").html('');
            }

             if(!$("input[name='pay']:checked").val()){
                    $("#paymethodErr").html('Select payment method');
                    return false;
            }
            else{
                $("#paymethodErr").html('');
            }

            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            var shipping_address = $.trim(CKEDITOR.instances['shipping_address'].getData());
            if($("#check_setupbox_status").val() == 1){
                if (shipping_address == '') {
                    $("#shipAddrErr").html('Shipping Address Required');
                    error = true;
                } else {
                    $("#shipAddrErr").html('');
                }
                var country = $("#select_country3").val();
                if(country == ""){
                    $("#country_err").html("Please select country");
                    error = true;
                }else{
                    $("#country_err").html("");
                }
                var shipping_user_mobile_no = $("#shipping_user_mobile_no").val();
                if(country == ""){
                    $("#mobile_no_err").html("Please select Mobile No");
                    error = true;
                }else if(/^\d{8,14}$/.test(shipping_user_mobile_no) == false){
                    $("#mobile_no_err").html("Please enter valid mobile number");
                    error = true;
                }else{
                    $("#mobile_no_err").html("");
                }

            }
            if(error) return false;

            /*$("#disp_email").html(email);
            $("#disp_first_name").html(first_name);
            $("#disp_last_name").html(last_name);*/
            if(payment_type == 'aliexpress' || payment_type == 'bankpayment' || payment_type == 'bitpay'){
                $("#create_form").submit();
            }else{
                $("#step1").addClass('d-none');
                $("#step2").removeClass("d-none");
            }

            /*swal({
                title: 'Are you sure?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4FC550',
                cancelButtonColor: '#D0D0D0',
                confirmButtonText: 'Yes, proceed!',
                closeOnConfirm: false,
                html: html
            }).then(function (result) {
                 if (result.value) {
                    $("#create_form").submit();
                }
            }).catch(swal.noop);*/
        });

        $("#username").change(function(){
            var name = $(this).children("option:selected").text();
            $("#selected_wal").val(name);
            var id = $(this).children("option:selected").val();
            var csrf_Value = "<?php echo csrf_token(); ?>";
            $.ajax({
                    type: 'POST',
                    url: "<?php echo url('/');?>/checkPackagePurchase",
                    data: {'_token':csrf_Value,'id':id},
                    dataType: "json",
                    success: function (data) {
                        $("#disp_email").html(data.email);
                        $("#disp_first_name").html(data.first_name);
                        $("#disp_last_name").html(data.last_name);
                    }
                });
        });

        $('#select_country3').select2();

        $("#select_country3").change(function(e) {
            var country_code =  $('option:selected', this).attr('data-id');
            $("#shipping_country_code").val('+'+country_code);
        });
        $("#shipping_user_mobile_no").on("keypress keyup blur",function (event) {
            $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

        </script>

        <script>
            $('#file-upload').change(function () {
                var filepath = this.value;
                var m = filepath.match(/([^\/\\]+)$/);
                var filename = m[1];
                $('#filename').html(filename);
            });
        </script>
        <script>
            CKEDITOR.replace('shipping_address', {
                height: 150
            });
        </script>

        <script>

      (function() {
        window.addEventListener('load', function() {
          var forms = document.getElementsByClassName('needs-validation');

          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');

              var shipping_address = $.trim(CKEDITOR.instances['shipping_address'].getData());
              if($("#check_setupbox_status").val() == 1){
                  if (shipping_address == '') {
                        $("#shipAddrErr").html('Shipping Address Required');
                        error = true;
                    } else {
                        $("#shipAddrErr").html('');
                    }
                  var country = $("#select_country3").val();
                   if(country == ""){
                    $("#country_err").html("Please select country");
                  }else{
                    $("#country_err").html("");
                  }
              }
              $("#email_error").html("");

            }, false);
          });
        }, false);
      })();

      $("#back_btn").click(function(){
            $("#step1").removeClass('d-none');
            $("#step2").addClass("d-none");
      });

      $("#pay_now").click(function(){
         $("#create_form").submit();
      });

</script>

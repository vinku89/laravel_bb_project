<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - New Box</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- Styles -->
    <link href="<?php echo url('/');?>/public/css/customer/app.css" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/bsnav.css" rel="stylesheet">
    <!-- All old styles include -->
    @include("customer.inc.v2.all-styles")
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
        #delivery_addr p {
            margin-bottom: 0;
        }
        .cust_name {
            float: left;
        }
        .cust_status {
            float: right;
        }
        .select2-container .select2-selection--single {
            height: 44px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 42px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 10px !important;
            right: 10px !important;
        }
        .select2-container--default .select2-selection--single {
            background-color: transparent !important;
            border: none !important;
            border-bottom: solid 3px #7f868b !important;
            border-radius: 0;
        }
        .select2-container .select2-selection--single {
            height: 33px !important;
        }
        .select2-selection__rendered[title="Select Country"] {
            font-size: 14px !important;
            color: #737a82 !important;
        }
        .select2-container[dir="ltr"] {
            width: 100% !important;
        }
        .cust_status_active {
            float: right;
            background-color: #38B586;
            color: #fff;
            padding: 2px 10px;
            border-radius: 2px;
        }
        .cust_status_expiry {
            float: right;
            background-color: #D0021B;
            color: #fff;
            padding: 2px 10px;
            border-radius: 2px;
        }
        .package_list {
            overflow: hidden;
            overflow-y: auto;
            height: 300px;
        }
        .caret {
            top: 24px !important;
            right: 15px;
        }
        .select_package_drop:focus {
            outline: none;
            box-shadow: none;
        }
        .select-x ul {
            box-shadow: 0 3px 6px #9a9a9a;
        }
    </style>
</head>
<body>
    @include('inc.v2.sidenav')
    <div class="main-wrap w-100">
        <div class="container-fluid">
            @include('inc.v2.headernav')
            
            <div class="row">
                <section class="main_body_section scroll_div col-12" id="main_section">
                    <!-- border -->
                    <hr class="grey-dark">
                    <h5 class="font22 font-bold text-white py-4">Buy/Subscribe</h5>
                    <div id="checkOut_div">
                        <div class="col-12 mb-4 pl-0">
                            <div class="row">
                                <div class="col-xl-3 col-lg-4 col-md-5">
                                    <div class="iptv_box_wrp white_bg iptv_box box-100">
                                        <div class="box_header">
                                            <i class="fas fa-info-circle info_btn info_white" data-toggle="modal"
                                                data-target="#imp-note"></i>
                                            <img src="{{ url('/') }}/public/customer/images/white-logo.png?q=<?php echo rand(); ?>"
                                                style="width: 130px;">
                                            @if($sel_package_det->duration !=0 && $sel_package_det->duration != '')
                                            <p class="m-0 pt-2 font-bold">{{ $sel_package_det->duration }}
                                                MONTH{{ $sel_package_det->duration >1 ? 'S' : ''}} SUBSCRIPTION</p>
                                            @endIf
                                        </div>
                                        <div class="box-middle mb-0">
                                            <img src="{{ url('/') }}/public/customer/images/iptv-box.png?q=<?php echo rand(); ?>"
                                                class="img-fluid">
                                            @if($sel_package_det->duration !=0 && $sel_package_det->duration != '')
                                            <p>{{ $sel_package_det->duration }}
                                                MONTH{{ $sel_package_det->duration >1 ? 'S' : ''}} SUBSCRIPTION<br><br>
                                            </p>
                                            @endIf
                                            <h1 class="price_tag my-3">${{ $sel_package_det->effective_amount }}</h1>
                                            <p>{{ $sel_package_det->description }}<br><br></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-8 col-md-7 align-self-center">
                                    <ul class="ul_text clearfix text-white">
                                        <li>Package</li>
                                        <li>: {{ $sel_package_det->package_name }}</li>
                                        @if($sel_package_det->duration !=0 && $sel_package_det->duration != '')
                                        <li>Duration</li>
                                        <li>: {{ $sel_package_det->duration }}
                                            MONTH{{ $sel_package_det->duration >1 ? 'S' : ''}} SUBSCRIPTION</li>
                                        @endIf
                                        <li>Total Payment</li>
                                        <li class="amount_txt2">: {{ $sel_package_det->effective_amount }} USD</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="initial_package_name" id="initial_package_name"
                            value="{{ $sel_package_det->package_name }}">
                        <input type="hidden" name="initial_package_amount" id="initial_package_amount"
                            value="{{ $sel_package_det->effective_amount }}">
                        <input type="hidden" name="initial_package_desc" id="initial_package_desc"
                            value="{{ $sel_package_det->description }}">
                        <input type="hidden" name="initial_package_setupbox" id="initial_package_setupbox"
                            value="{{ $sel_package_det->setupbox_status }}">
                        <input type="hidden" name="initial_package_value" id="initial_package_value"
                            value="{{ $sel_package_det->package_value }}">
                        <input type="hidden" name="initial_package_discount" id="initial_package_discount"
                            value="{{ $sel_package_det->discount }}">
                        <div class="col-12 mb-4 pl-0">
                            <h5 class="font16 font-bold text-white pt-4 mb-3">Payment Method</h5>
                            <div class="select_payment col-xl-5 col-lg-6 col-md-7">
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="radio" name="pay" id="exampleRadios1"
                                        value="WALLET">
                                    <label class="form-check-label text-white" for="exampleRadios1">
                                        Pay From My BestBOX Wallet
                                    </label>
                                </div>
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="radio" name="pay" id="exampleRadios2"
                                        value="ALIEXPRESS">
                                    <label class="form-check-label text-white" for="exampleRadios2">
                                        VISA / MASTERCARD <span class="pl-3"><img
                                                src="{{ url('/') }}/public/customer/images/cards.png?q=<?php echo rand();?>" style="width:85px;"></span>
                                    </label>
                                </div>
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="radio" name="pay" id="exampleRadios3"
                                        value="BANKPAYMENT">
                                    <label class="form-check-label text-white" for="exampleRadios3">
                                        Nigeria or Ghana based bank payments
                                    </label>
                                </div>
                                <!--<div class="form-check">
                        <input class="form-check-input" type="radio" name="pay" id="exampleRadios3" value="EVERUSPAY">
                        <label class="form-check-label" for="exampleRadios3">
                            CRYPTO PAYMENT<!--<span class="pl-3"><img src="{{ url('/') }}/public/customer/images/evr-pay-logo.png?q=<?php echo rand();?>"
                                    style="width:100px;"></span>
                        </label>
                    </div>-->
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pay" id="exampleRadios4" value="Crypto Currency">
                                    <label class="form-check-label" for="exampleRadios4" style="color:#fff !important;">
                                        Crypto Currency Payments
                                        <!--<span class="pl-3"><img src="{{ url('/') }}/public/customer/images/bit-pay-logo.png?q=<?php //echo rand();?>"
                                                style="width:70px;"></span>-->
                                    </label>
                                </div>
                                <div class="f12" style="color:red" id="paymethodErr"></div>
                            </div>
                        </div>
                        <div class="col-12 pl-0 mb-5">
                            <a class="check_out_btn col-xl-5 col-lg-6 col-md-7" id="check_out">Check out</a>
                        </div>
                    </div>
                    <!-- Payment method -->
                    <div id="payment_method_div" style="display:none">
                        <form method="post" id="buyorsubscribe_form" action="{{ url('/saveBuyOrSubscribe') }}">
                            @csrf
                            <div class="col-12 pl-0">
                                <h5 class="font18 font-bold text-white purple_txt">Payment Method</h5>
                            </div>
                            <div class="col-xl-5 col-md-8 pl-0">
                                <div id="wallet_div" class="d-none">
                                    <h5 class="font16 font-bold text-white pt-3 mb-3">Pay From My BestBOX Wallet</h5>
                                    <div class="col-12 px-0 mb-4">
                                        <div class="f16 font-bold purple-bordered text-center">
                                            <div class="color-black mb-2">Wallet Balance</div>
                                            <div class="purple_txt  mb-2">${{ $wallet_balance->amount }}</div>
                                            <input type="hidden" value="{{ $wallet_balance->amount }}"
                                                id="user_wallet_amt" name="user_wallet_amt">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-none" id="bitpay_div">
                                    <h5 class="font16 font-bold text-white pt-3 mb-3">CRYPTO PAYMENT</h5>
                                    <div class="col-12 mb-4 pl-0">
                                        <div class="text-center">
                                            <div class="f16 font-bold purple-bordered">
                                                <div class="purple_txt mb-2"><img src="{{ url('/') }}/public/customer/images/bit-pay-logo.png?q=<?php echo rand();?>" style="width:145px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-none" id="everuspay_div">
                                    <p>CRYPTO PAYMENT</p>
                                    <div class="col-12 mb-4 pl-0">
                                        <div class="text-center">
                                            <!--<div class="f16 font-bold purple-bordered d-none">
                            <div class="purple_txt mb-2"><img src="{{ url('/') }}/public/customer/images/evr-pay-logo.png?q=<?php echo rand();?>" style="width:148px;"></div>
                        </div>-->
                                        </div>
                                    </div>
                                </div>
                                <h5 class="font16 font-bold text-white mt-4 mb-3">BestBOX Package</h5>
                                <div class="col-12 px-0 mb-4">
                                    <div class="select-test">
                                        <input type="hidden" name="package" id="package"
                                            value="{{ $sel_package_det->id }}">
                                        <input type="hidden" name="package_amount" id="package_amount"
                                            value="{{ $sel_package_det->effective_amount }}">
                                        <input type="hidden" name="package_name" id="package_name"
                                            value="{{ $sel_package_det->package_name }}">
                                        <input type="hidden" name="package_desc" id="package_desc"
                                            value="{{ $sel_package_det->description }}">
                                        <input type="hidden" name="setupbox_status" id="setupbox_status"
                                            value="{{ $sel_package_det->setupbox_status }}">
                                        <input type="hidden" name="package_discount" id="package_discount"
                                            value="{{ $sel_package_det->discount }}">
                                        <input type="hidden" name="package_value" id="package_value"
                                            value="{{ $sel_package_det->package_value }}">
                                        <input type="hidden" name="payment_method" id="payment_method" value="">
                                        <button class="select_package_drop"
                                            style="border:1px solid #A02C72; border-radius:5px;">
                                            <span>
                                                <div class="" style="width: 100%;background-color:#fff;">
                                                    <div class="float-left" style="width:75%">
                                                        <div style="font-weight: 700;">
                                                            {{ $sel_package_det->package_name }}</div>
                                                        <div>{{ $sel_package_det->description }}</div>
                                                    </div>
                                                    <div class="float-right font-bold pr-2 pt-3">
                                                        ${{ $sel_package_det->effective_amount }}</div>
                                                </div>
                                            </span>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="f16 package_list">
                                            @foreach ($package_data as $val)
                                            <li value="{{ $val->id }}" data-name="{{ $val->package_name }}"
                                                data-duration="{{ $val->duration }}" data-desc="{{ $val->description }}"
                                                data-package="{{ $val->id }}" data-amt="{{ $val->effective_amount }}"
                                                data-setupbox="{{ $val->setupbox_status }}"
                                                data-value="{{ $val->package_value }}"
                                                data-discount="{{ $val->discount }}"
                                                <?php if($val->id == $sel_package_det->id) echo 'selected';?>
                                                class="text-left border-top-purple"
                                                style="display: table; width: 100%;">
                                                <div class="border-right-purple p-3"
                                                    style="display: table-cell; width: 70%;">
                                                    <div class="" style="font-weight: 700;">{{ $val->package_name }}
                                                    </div>
                                                    <div> {{ $val->description }}</div>
                                                </div>
                                                <div class="p-3 font-bold" style="display: table-cell; width: 30%;">
                                                    ${{ $val->effective_amount }}</div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="d-none" id="delevery_addr">
                                    <h5 class="font16 font-bold text-white mt-4 mb-3">Delivery Address</h5>
                                    <!-- Default Address -->
                                    <div class="purple-bordered p-4" id="select_address">
                                        <div class="address_wrp_scroll ">
                                            <div class="bottom-purple-bordered pb-2 mb-4 userSelect_address">
                                                <h5 class="font16 font-bold text-black mb-3">Default Address</h5>
                                                <?php
                                if(!empty($default_address)){
                                    echo "<h5 class='font16 font-bold text-black'>".$default_address->name."</h5>";
                                    echo $default_address->shipping_address;
                                    echo "<p>".$default_address->country_name."</p><p>".$default_address->shipping_mobile_no."</p>";
                                }else{
                                    echo "<p>No Default Address Found</p>";
                                }
                            ?>
                                                <input type="hidden" name="default_addr" id="default_addr"
                                                    value="<?php echo (!empty($default_address)? 1 : 0)?>">
                                            </div>
                                            <div class=" pb-2 mb-4 userSelect_address">
                                                <h5 class="font16 font-bold text-black mb-3 select_addr_hd {{ count($all_address) > 0 ? '' : 'd-none' }}">
                                                    Select Address</h5>
                                                <?php
                                if(count($all_address) > 0){
                                foreach ($all_address as $key => $value) {
                                    ?>
                                                <div class="bottom-purple-bordered position-relative pb-4 pl-3 mb-3">
                                                    <input class="form-check-input ml-1 shiping_address_radio"
                                                        type="radio" name="sel_shipping_address"
                                                        value="<?php echo $value->rec_id;?>">
                                                    <?php
                                            echo "<p>".$value->name."</p>";
                                            echo $value->shipping_address;
                                            echo "<p>".$value->country_name."</p><p>".$value->shipping_mobile_no."</p>";
                                        ?>
                                                    <div class="form-check mt-4">
                                                        <input class="form-check-input set_default_addr" type="checkbox"
                                                            name="set_default_addr" id="set_default_addr"
                                                            value="<?php echo $value->rec_id;?>">
                                                        <label class="form-check-label" for="exampleRadios5">
                                                            Set As Default Address
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php
                                    }
                                }
                            ?>
                                                <div id="appendAddr"></div>
                                            </div>
                                        </div>
                                        <a href="#" class="check_out_btn col-xl-12" id="add_address">Add new address</a>
                                    </div>
                                </div>
                                <!-- Add a new address -->
                                <div class="purple-bordered p-4" id="newAddress_div" style="display:none">
                                    <h5 class="font16 font-bold text-white mb-3">New Address</h5>
                                    <form method="post" id="addnewAddressForm">
                                        <div class="form-group">
                                            <input type="name" class="form-control border-bottom-only"
                                                value="{{ $userInfo->first_name.' '.$userInfo->last_name }}"
                                                id="sh_name" name="sh_name" aria-describedby="name" placeholder="Name">
                                            <div class="text-right f14 w-100 pt-2">
                                                <span class="text-danger">*</span>
                                                <span id="emailHelp" class="text-muted f14 text-white">Set Name</span>
                                                <div class="f12" style="color:red" id="nameErr"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="font-bold text-white">*
                                                Address</label>
                                            <textarea id="shipping_address" name="shipping_address" rows="10"
                                                data-sample-short></textarea>
                                            <div class="f12" style="color:red" id="shipAddrErr"></div>
                                        </div>
                                        <div class="form-group">
                                            <select id="shipping_country" name="shipping_country">
                                                <option value="">Select Country</option>
                                                <?php
                            foreach ($country_data as $val) {
                                ?>
                                                <option value='<?php echo $val->countryid;?>'
                                                    data-id='<?php echo $val->currencycode;?>'>
                                                    <?php echo $val->country_name;?></option>
                                                <?php   }
                        ?>
                                            </select>
                                            <div class="text-right f14 w-100 pt-2">
                                                <span class="text-danger">*</span>
                                                <span id="emailHelp" class="text-muted f14 text-white">Country</span>
                                            </div>
                                            <div class="f12" style="color:red" id="countryErr"></div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <input type="text"
                                                    class="form-control border-bottom-only with_addon_icon body_bg"
                                                    placeholder="+0" aria-label="Mobile number"
                                                    aria-describedby="basic-addon2" name="shipping_country_code"
                                                    id="shipping_country_code" readonly>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="name" class="form-control border-bottom-only"
                                                    id="shipping_mobile_no" name="shipping_mobile_no"
                                                    aria-describedby="name" placeholder="Mobile Number">
                                                <div class="text-right f14 w-100 pt-2">
                                                    <span class="text-danger">*</span>
                                                    <span id="emailHelp" class="text-muted f14 text-white">Set Phone
                                                        Number</span>
                                                </div>
                                                <div class="f12" style="color:red" id="mobileErr"></div>
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="set_default"
                                                id="set_default" value="1">
                                            <label class="form-check-label" for="exampleRadios1">
                                                Set as Default Address
                                            </label>
                                        </div>
                                        <div class="mt-4 mb-5">
                                            <div class="row">
                                                <div class="col-6"> <a href="#" id="cancel_newaddress"
                                                        class="backBtn col-xl-12">Cancel</a></div>
                                                <div class="col-6"> <a href="#" id="add_newaddress"
                                                        class="check_out_btn col-xl-12">Create</a></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="mt-4 mb-5">
                                    <div class="row">
                                        <div class="col-6"> <a href="#" id="back_pm" class="backBtn col-xl-12">Back</a>
                                        </div>
                                        <div class="col-6"> <a href="#" id="place_order"
                                                class="check_out_btn col-xl-12">Place Order</a></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
                <section class="main_body_section scroll_div col-12" id="confirm_section">
                    <h5 class="font22 font-bold text-white py-4">Confirmation</h5>
                    <div class="mb-5">
                        <p class="font-weight-bold text-white">Confirm Your Purchase</p>
                        <div class="mb-5">
                            <div class="add-newcustomer bg-white">
                                <table class="m_table ">
                                    <tbody>
                                        <tr class="tableHeader">
                                            <td style="font-weight:bold; background-color:white;" width="40%">
                                                Discription</td>
                                            <td align="right" style="font-weight:bold; background-color:white;">Unit
                                                price</td>
                                            <td align="right" style="font-weight:bold; background-color:white;">Quantity
                                            </td>
                                            <td align="right" style="font-weight:bold; background-color:white;">Amount
                                            </td>
                                        </tr>
                                        <tr class="m_bgwhite">
                                            <td id="conf_desc">BestBOX + 1 Month Subscription
                                                Includes pre - installed app & 1 month subscription + door to door
                                                delivery</td>
                                            <td align="right" class="disp_package_amt" id="conf_amt">$34.99 USD</td>
                                            <td align="right" id="conf_qty">1</td>
                                            <td align="right" class="disp_package_amt" id="conf_price">$34.99 USD</td>
                                        </tr>
                                        <tr class="m_row">
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td align="right">Subtotal</td>
                                            <td align="right" class="disp_package_amt" id="conf_sub_total">$34.99 USD
                                            </td>
                                        </tr>
                                        <tr class="m_row2">
                                            <td class="border-top-0">&nbsp;</td>
                                            <td class="border-top-0">&nbsp;</td>
                                            <td align="right" class="border-top-0">Discount</td>
                                            <td align="right" class="border-top-0" id="conf_discount">$0.00 USD</td>
                                        </tr>
                                        <tr class="m_row4">
                                            <td class="border-top-0 border-bottom">&nbsp;</td>
                                            <td class="border-top-0 border-bottom">&nbsp;</td>
                                            <td align="right" style="font-weight:bold; width:160px;"
                                                class=" border-bottom">Amount payable</td>
                                            <td align="right" style="font-weight:bold"
                                                class=" border-bottom disp_package_amt" id="conf_amt_pay">$34.99 USD
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-md-8 pl-0">
                        <h5 class="font16 font-bold text-white pt-4 mb-3">Payment Method:-</h5>
                        <div id="step3_wallet_div" class="d-none">
                            <h5 class="font16 font-bold text-white pt-3 mb-3">Pay From My BestBOX Wallet</h5>
                            <div class="col-12 px-0 mb-4">
                                <div class="f16 font-bold purple-bordered text-center">
                                    <div class="color-black mb-2">Wallet Balance</div>
                                    <div class="purple_txt  mb-2">${{ $wallet_balance->amount }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="d-none" id="step3_bitpay_div" style="color:#fff !important;">
                            <p>CRYPTO PAYMENT</p>
                            <div class="col-12 mb-4 pl-0">
                                <div class="text-center">
                                    <div class="f16 font-bold purple-bordered">
                                        <div class="purple_txt mb-2"><img src="{{ url('/') }}/public/customer/images/bit-pay-logo.png?q=<?php echo rand();?>" style="width:148px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-none" id="step3_everuspay_div">
                            <p>Crypto Currency Payment</p>
                            <div class="col-12 mb-4 pl-0">
                                <div class="text-center">
                                    <!--<div class="f16 font-bold purple-bordered">
                                <div class="purple_txt mb-2"><img src="{{ url('/') }}/public/customer/images/evr-pay-logo.png?q=<?php echo rand();?>" style="width:148px;"></div>
                            </div>-->
                                </div>
                            </div>
                        </div>
                        <div class="d-none" id="step3_delivery_addr">
                            <h5 class="font16 font-bold text-white pt-4 mb-3">Delivery Address:-</h5>
                            <div id="delivery_addr" class="text-white">
                                <?php
                                if(!empty($default_address)){
                                    echo "<h5 class='font16 font-bold text-white' style='color:#fff !important;'>".$default_address->name."</h5>";
                                    echo $default_address->shipping_address;
                                    echo "<p>".$default_address->country_name."</p><p>".$default_address->shipping_mobile_no."</p>";
                                }
                            ?>
                            </div>
                        </div>
                        <div class="mt-4 col-md-8 pl-0 mb-5">
                            <div class="row">
                                <div class="col-6"> <a href="#" id="back_main" class="backBtn col-xl-12">Back</a></div>
                                <div class="col-6"> <a href="#" id="pay_now" class="check_out_btn col-xl-12">Pay Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    @include('inc.v2.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <!-- Order User -->
    <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="orderNotify"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <h5 class="modal-title font-bold text-black text-uppercase f20" id="exampleModalLongTitle">
                        Notification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body add_edit_user pb-4">
                    <div class="text-left f16 text-black">
                        <p>Now for the last lap. 2 final steps:</p>
                        <p>1. You will be redirected to the Aliexpress App or Site. If you do not have an account with
                            Aliexpress, please sign up for an account.</p>
                        <p>2. Please finalize the purchase of your desired service and product. You will receive a
                            confirmation email summarizing your purchase. If you purchased a TV box, you will also
                            receive your tracking number.</p>
                    </div>
                </div>
                <!-- footer buttons -->
                <div class="inline-buttons">
                    <a href="" class="btn inline-buttons-center btn_primary" target="_blank" id="purchaseUrl"
                        style="color:#fff !important;">Proceed</a>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal fade" id="bankpaymentAlertModal" tabindex="-1" role="dialog" aria-labelledby="orderNotify"
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
                    <p>For Nigeria or Ghana based bank payments, please WhatsApp or email us for instructions.</p>
                    <p>Click <a href="https://api.whatsapp.com/send?phone=2347081808391&text=Hello, I would like to subscribe/renewal to your BVOD1 (1 month Subscription) and $9.99 USD, please send me banking instructions. Thank you&source=&data=&app_absent=" class="whatsapp_txt" target="_blank">here</a> to WhatsApp us </p>
                    <p>OR</p>
                    <p>Click <a href="mailto:help@bestbox.net?subject=Package in Bestbox&body=Hello, I would like to subscribe/renewal to your BVOD1 (1 month Subscription) and $9.99 USD, please send me banking instructions. Thank you" class="mail_txt" target="_blank">here</a> to email us </p>
                    </div>
                </div>
                <!-- footer buttons -->
                <div class="inline-buttons">
                    <a href="javascript:void(0);" class="btn inline-buttons-center btn_primary" id="bankpaymentAlertClose"
                        style="color:#fff !important;">OK</a>
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
                        <p>Click <a href="https://api.whatsapp.com/send?phone=00971527925634&text=Hello, I would like to subscribe/renewal to your BVOD1 (1 month Subscription) and $9.99 USD using Crypto,please send me the instructions. Thank you&source=&data=&app_absent=" class="whatsapp_txt" target="_blank">here</a> to WhatsApp us </p>
                        <p>OR</p>
                        <p>Click <a href="mailto:help@bestbox.net?subject=Package in Bestbox&body=Hello, I would like to subscribe/renewal to your BVOD1 (1 month Subscription) and $9.99 USD using Crypto,please send me the instructions." class="mail_txt" target="_blank">here</a> to email us </p>
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
    <div class="modal fade imp-note" id="imp-note">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal_bg">
                <!-- Modal Header -->
                <div class="modal-header" style="padding:15px 50px;    border-bottom-color: #ff903f;">
                    <h4 class="modal-title font-primary-book" style="font-weight:bold;">Important Note</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body font-primary-book" style="padding:30px 50px 50px 50px">
                    <p>Please note as AliExpress only sells products and not services. When buying a subscription it may
                        appear at first that you are purchasing a product,
                        in fact you are purchasing the BESTBOX streaming service, which you will receive access to
                        shortly after your transaction has been completed.
                        When you purchase the subscription with a BESTBOX TV box, the item will be shipped to your
                        shipping address and you will receive a
                        tracking number within 1-2 days upon purchase.</p>
                    <p>
                        During the purchase you will be asked to open an AliExpress account, just requires your email
                        address and a password
                        of your choice and will be valid for future purchases. After purchase you will receive an email
                        with your code details,
                        generally this will take a couple of hours so hold tight you will be up and running in no time.
                        All of this may seem heavy
                        but have a go, it is very easy and secure for card payment.
                    </p>
                    <p>
                        If you have any questions please dont hesitate to contact us.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php
        if(Session::has('error')){
    ?>
    <script type="text/javascript">
        swal(
            'Failure',
            '<?php echo Session::get('
            error ');?>',
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
            '<?php echo Session::get('
            message ');?>',
            'success'
        )
    </script>
    <?php
        }
    ?>
</body>
</html>
<script>
    $('.menucheck').on('change', function () {
        $("#chkboxvalue").val($(this).attr('id'));
        if ($(this).is(":checked")) {
            $('.menucheck').not(this).prop('checked', false);
        } else {
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
            //selected: 0,
            //animate: "slide"
        });
    });
    $("#proceed_btn").click(function (e) {
        e.preventDefault();
        var package = $("#package").val();
        if (package == '') {
            $("#packageErr").html('Package is Required');
            return false;
        } else {
            $("#packageErr").html('');
        }
        swal({
            title: 'Are you sure?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4FC550',
            cancelButtonColor: '#D0D0D0',
            confirmButtonText: 'Yes, proceed it!',
            closeOnConfirm: false,
            html: "New subscription with new account creation."
        }).then(function (result) {
            if (result.value) {
                $("#create_form").submit();
            }
        }).catch(swal.noop);
    });
    /* select box*/
    $(document).ready(function () {
        $("#confirm_section").hide();
        $('ul.package_list li').click(function (e) {
            var amount = $(this).attr('data-amt');
            var user_wallet_amt = $("#user_wallet_amt").val();
            var setupbox_status = $(this).attr('data-setupbox');
            var payment_method = $("input[name='pay']:checked").val();
            if (payment_method == 'WALLET') {
                if (parseFloat(amount) > parseFloat(user_wallet_amt)) {
                    swal(
                        'Failure',
                        'Insufficient Balance In Your Wallet',
                        'error'
                    )
                    var initial_package_name = $("#initial_package_name").val();
                    var initial_package_amount = $("#initial_package_amount").val();
                    var initial_package_desc = $("#initial_package_desc").val();
                    var initial_package_setupbox = $("#initial_package_setupbox").val();
                    var initial_package_value = $("#initial_package_value").val();
                    var initial_package_discount = $("#initial_package_discount").val();
                    setTimeout(function () {
                        $(".select-test span:first").html(
                            '<div class="p-1" style="width: 100%;background-color:#fff;"><div class="float-left" style="width:75%"><div style="font-weight: 700;">' +
                            initial_package_name + '</div><div>' + initial_package_desc +
                            '</div></div><div class="float-right font-bold pr-2 pt-3">$' +
                            initial_package_amount + '</div></div>');
                        if (initial_package_setupbox == 1) {
                            $("#delevery_addr").removeClass('d-none');
                        } else {
                            $("#delevery_addr").removeClass('d-none').addClass('d-none');
                        }
                    }, 50);
                } else {
                    $("#package").val(package_id);
                    $("#package_amount").val(amount);
                    var package_name = $(this).attr('data-name');
                    var package_desc = $(this).attr('data-desc');
                    var duration = $(this).attr('data-duration');
                    var discount = $(this).attr('data-discount');
                    var package_value = $(this).attr('data-value');
                    $("#package_name").val(package_name);
                    $("#package_desc").val(package_desc);
                    $(".package_name_dsp").html(package_name);
                    $(".package_amount_dsp").html(amount);
                    $(".package_desc_dsp").html(package_desc);
                    $("#package_discount").val(discount);
                    $("#package_value").val(package_value);
                    $("#setupbox_status").val(setupbox_status);
                    if (duration == 0) {
                        $(".package_duration_dsp").html("");
                        $(".dur").hide();
                    } else if (duration == 1) {
                        $(".package_duration_dsp").html("1 Month Subscription");
                        $(".dur").show();
                    } else {
                        $(".package_duration_dsp").html(duration + " Months Subscription");
                        $(".dur").show();
                    }
                    setTimeout(function () {
                        $(".select-test span:first").html(
                            '<div class="p-1" style="width: 100%;background-color:#fff;"><div class="float-left" style="width:75%"><div style="font-weight: 700;">' +
                            package_name + '</div><div>' + package_desc +
                            '</div></div><div class="float-right font-bold pr-2 pt-3">$' +
                            amount + '</div></div>');
                        if (setupbox_status == 1) {
                            $("#delevery_addr").removeClass('d-none');
                        } else {
                            $("#delevery_addr").removeClass('d-none').addClass('d-none');
                        }
                    }, 50);
                }
            } else if (payment_method == 'EVERUSPAY') {
                var package_id = $(this).attr('data-package');
                if (package_id == "") {
                    setTimeout(function () {
                        $(".select-test span:first").html(
                            '<li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">Select Package</li>'
                            );
                        $("#delevery_addr").removeClass('d-none').addClass('d-none');
                    }, 50);
                } else {
                    $("#package").val(package_id);
                    $("#package_amount").val(amount);
                    var package_name = $(this).attr('data-name');
                    var package_desc = $(this).attr('data-desc');
                    var duration = $(this).attr('data-duration');
                    var discount = $(this).attr('data-discount');
                    var package_value = $(this).attr('data-value');
                    $("#package_name").val(package_name);
                    $("#package_desc").val(package_desc);
                    $(".package_name_dsp").html(package_name);
                    $(".package_amount_dsp").html(amount);
                    $(".package_desc_dsp").html(package_desc);
                    $("#package_discount").val(discount);
                    $("#package_value").val(package_value);
                    $("#setupbox_status").val(setupbox_status);
                    if (duration == 0) {
                        $(".package_duration_dsp").html("");
                        $(".dur").hide();
                    } else if (duration == 1) {
                        $(".package_duration_dsp").html("1 Month Subscription");
                        $(".dur").show();
                    } else {
                        $(".package_duration_dsp").html(duration + " Months Subscription");
                        $(".dur").show();
                    }
                    setTimeout(function () {
                        $(".select-test span:first").html(
                            '<div class="p-1" style="width: 100%;background-color:#fff;"><div class="float-left" style="width:75%"><div style="font-weight: 700;">' +
                            package_name + '</div><div>' + package_desc +
                            '</div></div><div class="float-right font-bold pr-2 pt-3">$' +
                            amount + '</div></div>');
                        if (setupbox_status == 1) {
                            $("#delevery_addr").removeClass('d-none');
                        } else {
                            $("#delevery_addr").removeClass('d-none').addClass('d-none');
                        }
                    }, 50);
                }
            }else if (payment_method == 'Crypto Currency') {
                var package_id = $(this).attr('data-package');
                if (package_id == "") {
                    setTimeout(function () {
                        $(".select-test span:first").html(
                            '<li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">Select Package</li>'
                            );
                        $("#delevery_addr").removeClass('d-none').addClass('d-none');
                    }, 50);
                } else {
                    var package_name = $("#initial_package_name").val();
                    var package_desc = $("#initial_package_amount").val();
                    var amount = $("#initial_package_desc").val();
                    var whatsapp_txt = 'https://api.whatsapp.com/send?phone=00971527925634&text=Hello, I would like to subscribe/renewal to your '+package_name+' ('+ package_desc +') and $'+amount+' USD using crypto, please send me the instructions. Thank you&source=&data=&app_absent=';
                    var email_txt = 'mailto:help@bestbox.net?subject=Package in Bestbox&body=Hello, I would like to subscribe/renewal to your '+package_name+' ('+ package_desc +') and $'+amount+' USD using crypto, please send me the instructions. Thank you';
                    $(".whatsapp_txt").attr('href',whatsapp_txt);
                    $(".mail_txt").attr('href',email_txt);
                    setTimeout(function () {
                        $(".select-test span:first").html(
                            '<div class="p-1" style="width: 100%;background-color:#fff;"><div class="float-left" style="width:75%"><div style="font-weight: 700;">' +
                            package_name + '</div><div>' + package_desc +
                            '</div></div><div class="float-right font-bold pr-2 pt-3">$' +
                            amount + '</div></div>');
                        if (setupbox_status == 1) {
                            $("#delevery_addr").removeClass('d-none');
                        } else {
                            $("#delevery_addr").removeClass('d-none').addClass('d-none');
                        }
                    }, 50);
                }
            }else if (payment_method == 'BANKPAYMENT') {
                var package_id = $(this).attr('data-package');
                if (package_id == "") {
                    setTimeout(function () {
                        $(".select-test span:first").html(
                            '<li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">Select Package</li>'
                            );
                        $("#delevery_addr").removeClass('d-none').addClass('d-none');
                    }, 50);
                } else {
                    $("#package").val(package_id);
                    $("#package_amount").val(amount);
                    var package_name = $(this).attr('data-name');
                    var package_desc = $(this).attr('data-desc');
                    var duration = $(this).attr('data-duration');
                    var discount = $(this).attr('data-discount');
                    var package_value = $(this).attr('data-value');
                    $("#package_name").val(package_name);
                    $("#package_desc").val(package_desc);
                    $(".package_name_dsp").html(package_name);
                    $(".package_amount_dsp").html(amount);
                    $(".package_desc_dsp").html(package_desc);
                    $("#package_discount").val(discount);
                    $("#package_value").val(package_value);
                    $("#setupbox_status").val(setupbox_status);
                    if (duration == 0) {
                        $(".package_duration_dsp").html("");
                        $(".dur").hide();
                    } else if (duration == 1) {
                        $(".package_duration_dsp").html("1 Month Subscription");
                        $(".dur").show();
                    } else {
                        $(".package_duration_dsp").html(duration + " Months Subscription");
                        $(".dur").show();
                    }
                    var amount = $("#initial_package_amount").val();
                    var package_name = $("#initial_package_name").val();
                    var package_desc = $("#initial_package_desc").val();

                    var whatsapp_txt = 'https://api.whatsapp.com/send?phone=2347081808391&text=Hello, I would like to subscribe/renewal to your '+package_name+' ('+ package_desc +') and $'+amount+' USD, please send me banking instructions. Thank you&source=&data=&app_absent=';
                    var email_txt = 'mailto:help@bestbox.net?subject=Package in Bestbox&body=Hello, I would like to subscribe/renewal to your '+package_name+' ('+ package_desc +') and $'+amount+' USD, please send me banking instructions. Thank you';
                    $(".whatsapp_txt").attr('href',whatsapp_txt);
                    $(".mail_txt").attr('href',email_txt);
                    setTimeout(function () {
                        $(".select-test span:first").html(
                            '<div class="p-1" style="width: 100%;background-color:#fff;"><div class="float-left" style="width:75%"><div style="font-weight: 700;">' +
                            package_name + '</div><div>' + package_desc +
                            '</div></div><div class="float-right font-bold pr-2 pt-3">$' +
                            amount + '</div></div>');
                        if (setupbox_status == 1) {
                            $("#delevery_addr").removeClass('d-none');
                        } else {
                            $("#delevery_addr").removeClass('d-none').addClass('d-none');
                        }
                    }, 50);
                }
            }
        });
    });
    $(document).ready(function () {
        $("#check_out").click(function () {
            var amount = $("#initial_package_amount").val();
            var payment_method = $("input[name='pay']:checked").val();
            $("#payment_method").val(payment_method);
            var setupbox_status = $("#setupbox_status").val()
            if (!$("input[name='pay']:checked").val()) {
                $("#paymethodErr").html('Select payment method');
                return false;
            } else if (payment_method == "ALIEXPRESS") {
                var url =
                    "https://www.aliexpress.com/item/<?php echo $sel_package_det->aliexpress_url; ?>";
                $("#purchaseUrl").attr('href', url);
                $("#alertModal").modal("show");
            }else if (payment_method == "BANKPAYMENT") {
                var amount = $("#initial_package_amount").val();
                var package_name = $("#initial_package_name").val();
                var package_desc = $("#initial_package_desc").val();
                var whatsapp_txt = 'https://api.whatsapp.com/send?phone=2347081808391&text=Hello, I would like to subscribe/renewal to your '+package_name+' ('+ package_desc +') and $'+amount+' USD, please send me banking instructions. Thank you&source=&data=&app_absent=';
                var email_txt = 'mailto:help@bestbox.net?subject=Package in Bestbox&body=Hello, I would like to subscribe/renewal to your '+package_name+' ('+ package_desc +') and $'+amount+' USD, please send me banking instructions. Thank you';
                $(".whatsapp_txt").attr('href',whatsapp_txt);
                $(".mail_txt").attr('href',email_txt);
                $("#bankpaymentAlertModal").modal("show");
            }else if (payment_method == "Crypto Currency") {
                var amount = $("#initial_package_amount").val();
                var package_name = $("#initial_package_name").val();
                var package_desc = $("#initial_package_desc").val();
                var whatsapp_txt = 'https://api.whatsapp.com/send?phone=00971527925634&text=Hello, I would like to subscribe/renewal to your '+package_name+' ('+ package_desc +') and $'+amount+' USD using Crypto, please send me the instructions. Thank you&source=&data=&app_absent=';
                var email_txt = 'mailto:help@bestbox.net?subject=Package in Bestbox&body=Hello, I would like to subscribe/renewal to your '+package_name+' ('+ package_desc +') and $'+amount+' USD using Crypto, please send me the instructions. Thank you';
                $(".whatsapp_txt").attr('href',whatsapp_txt);
                $(".mail_txt").attr('href',email_txt);
                $("#cryptoPaymentAlertModal").modal("show");
            } else if (payment_method == "WALLET") {
                var amount = $("#initial_package_amount").val();
                var user_wallet_amt = $("#user_wallet_amt").val();
                if (parseFloat(amount) > parseFloat(user_wallet_amt)) {
                    swal(
                        'Failure',
                        'Insufficient Balance In Your Wallet',
                        'error'
                    )
                } else {
                    $("#payment_method_div").show();
                    $("#checkOut_div").hide();
                    $("#everuspay_div").removeClass('d-none').addClass('d-none');
                    $("#bitpay_div").removeClass('d-none').addClass('d-none');
                    $("#wallet_div").removeClass('d-none');
                }
            } else if (payment_method == "EVERUSPAY") {
                $("#payment_method_div").show();
                $("#wallet_div").removeClass('d-none').addClass('d-none');
                $("#bitpay_div").removeClass('d-none').addClass('d-none');
                $("#everuspay_div").removeClass('d-none');
                $("#checkOut_div").hide();
            } else if (payment_method == "Crypto Currency") {
                $("#payment_method_div").show();
                $("#wallet_div").removeClass('d-none').addClass('d-none');
                $("#bitpay_div").removeClass('d-none');
                $("#everuspay_div").removeClass('d-none').addClass('d-none');
                $("#checkOut_div").hide();
            }
            if (setupbox_status == 1) {
                $("#delevery_addr").removeClass('d-none');
            } else {
                $("#delevery_addr").removeClass('d-none').addClass('d-none');
            }
        });
        $("#back_pm").click(function () {
            $("#payment_method_div").hide();
            $("#checkOut_div").show();
        });
        $("#add_address").click(function () {
            CKEDITOR.instances['shipping_address'].setData('');
            $('#shipping_country').val('').trigger('change');
            $("#shipping_mobile_no").val('');
            $("#shipping_country_code").val('');
            $('#set_default').prop("checked", false);
            $("#newAddress_div").show();
            $("#select_address").hide();
        });
        $("#cancel_newaddress").click(function () {
            $("#newAddress_div").hide();
            $("#select_address").show();
        });
        $("#shipping_mobile_no").on("keypress keyup blur", function (event) {
            $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
        $("#add_newaddress").click(function (e) {
            e.preventDefault();
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            var shipping_address = $.trim(CKEDITOR.instances['shipping_address'].getData());
            var country = $("#shipping_country").val();
            var mobile = $("#shipping_mobile_no").val();
            var country_code = $("#shipping_country_code").val();
            var sh_name = $("#sh_name").val();
            var set_default = $("input[name='set_default']:checked").val();
            if (sh_name == '') {
                $("#nameErr").html('Name is Required');
                return false;
            } else {
                $("#nameErr").html('');
            }
            if (shipping_address == '') {
                $("#shipAddrErr").html('Shipping Address Required');
                return false;
            } else {
                $("#shipAddrErr").html('');
            }
            if (country == '') {
                $("#countryErr").html('Country is Required');
                return false;
            } else {
                $("#countryErr").html('');
            }
            if (mobile == '') {
                $("#mobileErr").html('Mobile Number is Required');
                return false;
            } else {
                $("#mobileErr").html('');
            }
            var token = "<?php echo csrf_token(); ?>";
            $.ajax({
                type: 'POST',
                url: "<?php echo url('/');?>/addnewAddress",
                data: {
                    'set_default': set_default,
                    'name': sh_name,
                    'shipping_address': shipping_address,
                    'shipping_country': country,
                    'shipping_country_code': country_code,
                    'shipping_mobile_no': mobile,
                    '_token': token
                }, //$('#addnewAddressForm').serialize(),
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    if (data.status == "Success") {
                        $("#newAddress_div").hide();
                        $("#select_address").show();
                        $(".select_addr_hd").removeClass('d-none');
                        $("#appendAddr").append(data.append_addr);
                        swal(
                            'Success',
                            'New Address Added Successfully',
                            'success'
                        )
                    } else {
                        swal(
                            'Failure',
                            data.message,
                            'error'
                        )
                    }
                }
            });
        });
        $("#place_order").click(function (e) {
            var setupbox_status = $("#setupbox_status").val();
            var default_addr = $('#default_addr').val();
            if (setupbox_status == 1) {
                if ($("input:radio[name=sel_shipping_address]:checked").length == 0 && default_addr ==
                    0) {
                    swal(
                        'Failure',
                        'Select address or Add new shipping address',
                        'error'
                    )
                    return false;
                }
            }
            $("#confirm_section").show();
            var amount = $("#package_amount").val();
            var package_name = $("#package_name").val();
            var package_desc = $("#package_desc").val();
            var payment_method = $("#payment_method").val();
            var package_discount = $("#package_discount").val();
            var package_value = $("#package_value").val();
            $("#conf_desc").html(package_name + '<br/>' + package_desc);
            $("#conf_amt").html('$' + package_value + ' USD');
            $("#conf_qty").html(1);
            $("#conf_price").html('$' + package_value + ' USD');
            $("#conf_sub_total").html('$' + package_value + ' USD');
            $("#conf_discount").html('-$' + package_discount + ' USD');
            $("#conf_amt_pay").html('$' + amount + ' USD');
            if (payment_method == 'WALLET') {
                $("#step3_everuspay_div").removeClass('d-none').addClass('d-none');
                $("#step3_wallet_div").removeClass('d-none');
                $("#step3_bitpay_div").removeClass('d-none').addClass('d-none');
            } else if (payment_method == 'EVERUSPAY') {
                $("#step3_wallet_div").removeClass('d-none').addClass('d-none');
                $("#step3_everuspay_div").removeClass('d-none');
                $("#step3_bitpay_div").removeClass('d-none').addClass('d-none');
            } else if (payment_method == 'Crypto Currency') {
                $("#step3_wallet_div").removeClass('d-none').addClass('d-none');
                $("#step3_everuspay_div").removeClass('d-none').addClass('d-none');
                $("#step3_bitpay_div").removeClass('d-none');
            }
            if (setupbox_status == 1) {
                $("#step3_delivery_addr").removeClass('d-none');
            } else {
                $("#step3_delivery_addr").removeClass('d-none').addClass('d-none');
            }
            $("#main_section").hide();
        });
        $("#pay_now").click(function (e) {
            $("#buyorsubscribe_form").submit();
        });
        $("#back_main").click(function (e) {
            $("#confirm_section").hide();
            $("#main_section").show();
        });
    });
    CKEDITOR.replace('shipping_address', {
        height: 150
    });
    $('#shipping_country').select2();
    $("#shipping_country").change(function (e) {
        var country_code = $('option:selected', this).attr('data-id');
        $("#shipping_country_code").val('+' + country_code);
    });
    $('body').on('click', '.shiping_address_radio', function () {
        var ship_id = $(this).val();
        var token = "<?php echo csrf_token(); ?>";
        $.ajax({
            type: 'POST',
            url: "<?php echo url('/');?>/getShipAddress",
            data: {
                'ship_id': ship_id,
                '_token': token
            }, //$('#addnewAddressForm').serialize(),
            dataType: "json",
            success: function (data) {
                console.log(data);
                if (data.status == "Success") {
                    $("#delivery_addr").html(data.result);
                } else {}
            }
        });
    });
    $('body').on('change', '.set_default_addr', function () {
        $('.set_default_addr').not(this).prop('checked', false);
        var vl = $("input[name='set_default_addr']:checked").val();
        if (vl) {
            var check_status = 1;
        } else {
            var check_status = 0;
        }
        var ship_id = $(this).val();
        var token = "<?php echo csrf_token(); ?>";
        $.ajax({
            type: 'POST',
            url: "<?php echo url('/');?>/updateDefaultAddress",
            data: {
                'ship_id': ship_id,
                'check_status': check_status,
                '_token': token
            }, //$('#addnewAddressForm').serialize(),
            dataType: "json",
            success: function (data) {
                console.log(data);
                if (data.status == "Success") {
                    swal(
                        'Success',
                        data.result,
                        'success'
                    )
                } else {}
            }
        });
    });
</script>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Pay for my Friend</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- Styles -->
    <link href="<?php echo url('/');?>/public/css/customer/app.css" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/bsnav.css" rel="stylesheet">

    <!-- All styles include -->
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
            /* border: none !important; */
            /* border-bottom: solid 3px #7f868b !important; */
            border-radius: 5;
            border: 1px solid #6c757d !important;
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
            font-size: 13px;
        }
        .cust_status_expiry {
            float: right;
            background-color: #D0021B;
            color: #fff;
            padding: 2px 10px;
            border-radius: 2px;
            font-size: 13px;
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
        .fa-angle-left {
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
        .select-x ul li {
            border-bottom: solid 1px #0096da;
        }
        .select-x ul li:last-child {
            border-bottom: none;
        }
        .select-x ul.open {
            margin-bottom: 50px;
        }
        .package_selection {
            min-height: 50px;
            max-height: 100px;
        }
        ul {
            text-align: left;
            line-height: 25px;
            font-size: 16px;
            text-decoration: none;
        }
        .form_bg5 {
            background-color: #303032;
            padding: 25px 20px;
        }
        .form_bg6 {
            background-color: #ffffff;
            padding: 10px;
            border: solid 1px #0096DA;
            border-radius: 5px;
        }
        .select-x button {
            border: 1px solid #6c757d !important;
            border-radius: 5px;
            min-height: 50px;
            max-height: 150px;

            position: relative;
            padding: 5px;
            cursor: pointer;
            background-color: #30302E;
            width: 100%;
            text-align: left;
            color: #fff;
        }
        .list-type-none {
            list-style-type: none;
        }
        .sp_address p {
            margin-bottom: 2px;
        }
    </style>
</head>
<body>
    @include('inc.v2.sidenav')
    <div class="main-wrap w-100">
        <div class="container-fluid">
            @include('inc.v2.headernav')
            <!-- border -->
            
            <div class="row">
                <section class="main_body_section scroll_div col-12">
                    <hr class="grey-dark">
                    <nav aria-label="">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item f16">
                                <a href="<?php echo url('/transactions');?>"
                                    class="f16 position-relative breadcrumb_pd">
                                    <i class="fas fa-angle-left"></i>
                                    Transactions
                                </a>
                            </li>
                            <li class="breadcrumb-item active f16" aria-current="page" class="f16">Pay For My Friend
                            </li>
                        </ol>
                    </nav>
                    <h5 class="f20 font-bold text-uppercase text-white py-3">PAY FOR MY FRIEND</h5>
                    <div class="">
                        <div class="form-width2">
                            <div id="step1">
                                <form method="post" id="create_form" name="create_form"
                                    action="<?php echo url('/').'/savePayForMyFriend';?>" class="needs-validation"
                                    novalidate>
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <!-- Create Customer ID -->
                                    <h3 class="font16 font-bold text-uppercase text-white pt-4 mb-1">Enter Name or
                                        User ID</h3>
                                    <div class="pt-3 pb-2 mb-3">
                                        <select class="js-example-basic-single h50 border-bottom-only body_bg"
                                            id="username" name="username" style="width:100%;">
                                            <option value="">Choose Name</option>
                                        </select>
                                        <div id="err_msg_customer" class="error"></div>
                                    </div>
                                    <div class="col-12 subcribe_wrp mb-3" id="subscribe_options"
                                        style="display: none;">
                                        <div class="col-12">
                                            <div class="row border-bottom-blue py-2">
                                                <div class="col-9 orange_txt font-weight-bold">
                                                    New Subscription
                                                </div>
                                                <div class="col-3 text-right">
                                                    <label class="switch">
                                                        <input type="checkbox" name="subscription_type"
                                                            class="menucheck" id="new" value="New">
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
                                                        <input type="checkbox" name="subscription_type"
                                                            class="menucheck" id="renew" value="Renewal">
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
                                                <label for="exampleInputEmail1" class="font-bold text-white ">BestBOX
                                                    Package</label>
                                                <input type="hidden" name="package" id="package" value="">
                                                <input type="hidden" name="package_amount" id="package_amount"
                                                    value="">
                                                <input type="hidden" name="check_setupbox_status"
                                                    id="check_setupbox_status" value="">
                                                <button class="package_selection" disabled>
                                                    <span>Select</span>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="f16 package_list">
                                                    <li value="" data-package="" data-amt="" class="text-left"
                                                        style="display: table; width: 100%;">
                                                        Select Package
                                                    </li>
                                                    <?php /*@foreach ($package_data as $val)
                                                    <li value="{{ $val->id }}" data-box="{{ $val->setupbox_status }}" data-package="{{ $val->id }}" data-amt="{{ $val->effective_amount }}" data-name="{{ $val->package_name }}" data-desc="{{ $val->description }}" class="text-left" style="display: table; width: 100%;">
                                                        <div class="border-right-blue p-3" style="display: table-cell; width: 70%;">
                                                            <div class="" style="font-weight: 700;">{{ $val->package_name }}</div>
                                                        <div> {{ $val->description }}</div>
                                                        </div>
                                                        <div class="p-3 font-bold" style="display: table-cell; width: 30%;">{{ $val->effective_amount }} USD</div>
                                                    </li>
                                                    @endforeach
                                                    <?php */?>
                                                </ul>
                                            </div>
                                            <div class="f12" style="color:red" id="packageErr"></div>
                                        </div>
                                        <!-- Pre Buy -->
                                        <div class="">
                                            <label for="exampleInputEmail1" class="font-bold text-white">Payment
                                                Method</label>
                                            <div class="col-12 mt-3 pl-0">
                                                <div class="form-group form-check">
                                                    <input type="checkbox" name="pay" id="exampleCheck1" data-value='wallet'
                                                        value="WALLET" class="payment form-check-input"
                                                        style="width: inherit;">
                                                    <label class="form-check-label payfor_friend text-white" style="color: #fff !important; "
                                                        for="exampleCheck1">Pay From My Wallet</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="text-center">
                                                    <div class="f16 font-bold">
                                                        <div class="text-white mb-2">Wallet Balance</div>
                                                        <div class="text-purple mb-2">
                                                            {{ number_format($wallet_balance->amount,2) }} USD</div>
                                                        <input type="hidden" value="{{ $wallet_balance->amount }}"
                                                            id="user_wallet_amt" class="text-white" name="user_wallet_amt">
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
                                            <div class="f12" style="color:red" id="paymethodErr"></div>
                                        </div>
                                    </div>
                                    <!-- Shipping Address -->
                                    <div id="shipping_addr" style="display: none;">
                                        <div class="text-center my-2 f14 font-bold color-black">Shipping Address
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="font-bold text-white">*
                                                Address</label>
                                            <textarea id="shipping_address" name="shipping_address" rows="10"
                                                data-sample-short></textarea>
                                            <div class="f12 mt-3 red_txt" id="shipAddrErr"></div>
                                        </div>
                                        <!-- Country -->
                                        <div class="mobile_menu_section body_bg form-group">
                                            <select id="select_country3" name="shipping_country">
                                                <option value="" data-id="" class="font14">Select Country</option>
                                                <?php
                                                    foreach ($country_data as $val) {
                                                        echo "<option value='".$val->countryid."' data-id='".$val->currencycode."' data-countryname='".$val->country_name."'>".$val->country_name."</option>";
                                                    }
                                                ?>
                                            </select>
                                            <div class="text-right f14"><span class="text-danger">*</span><span
                                                    id="emailHelp" class="text-muted f14 text-white">Country</span>
                                            </div>
                                            <div id="country_err" class="f14 red_txt"></div>
                                        </div>
                                        <!-- Mobile Number -->
                                        <!-- Mobile Number -->
                                        <div class="form-group row">
                                            <div class="col-3">
                                                <div class="input-group mb-3">
                                                    <input type="text"
                                                        class="form-control border-bottom-only  body_bg"
                                                        placeholder="code" aria-label="Mobile number"
                                                        aria-describedby="basic-addon2"
                                                        value="{{ old('shipping_country_code') }}"
                                                        name="shipping_country_code" id="shipping_country_code"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                <div class="input-group mb-3">
                                                    <input type="text"
                                                        class="form-control border-bottom-only  body_bg"
                                                        placeholder="Mobile Number" aria-label="Mobile number"
                                                        aria-describedby="basic-addon2" id="shipping_user_mobile_no"
                                                        name="shipping_user_mobile_no"
                                                        value="{{ old('shipping_user_mobile_no') }}"
                                                        pattern="[0-9]{8,14}">
                                                    <div class="text-right f14 w-100 pt-2">
                                                        <span id="telErrorMsg" class="f14 error_txt"></span>
                                                        <span class="text-danger">*</span><span id="emailHelp"
                                                            class="text-muted f14 text-white">Mobile number</span>
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        Please Provide Correct Mobile Number.
                                                    </div>
                                                </div>
                                                <div id="mobile_no_err" class="f14 red_txt"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="subs_type" name="subs_type">
                                    <!--<h3 class="font16 font-bold text-uppercase text-white pt-4 mb-4">BestBOX Package</h3>
                                        <div class="form-group">
                                            <div class="select-test">
                                                <input type="hidden" name="package" id="package" value="">
                                                <input type="hidden" name="package_amount" id="package_amount" value="">
                                                <button class="select_package_drop">
                                                    <span>Select</span>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="f16 package_list">
                                                    <li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">
                                                        Select Package
                                                    </li>
                                                    @foreach ($package_data as $val)
                                                        <li value="{{ $val->id }}" data-name="{{ $val->package_name }}" data-desc="{{ $val->description }}" data-package="{{ $val->id }}" data-amt="{{ $val->effective_amount }}" class="text-left border-top-purple" style="display: table; width: 100%;">
                                                            <div class="border-right-purple  p-3" style="display: table-cell; width: 70%;">
                                                                <div class="" style="font-weight: 700;">{{ $val->package_name }}</div>
                                                            <div> {{ $val->description }}</div>
                                                            </div>
                                                            <div class="p-3 font-bold" style="display: table-cell; width: 30%;">${{ $val->effective_amount }}</div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <div id="packageErr" class="error"></div>
                                            </div>
                                        </div>-->
                                                        <!-- Pre Buy -->
                                                        <!--<div class="row">
                                            <div class="col-lg-6">
                                                <div class="text-center">
                                                    <div class="f16 font-bold color-black p-2">
                                                        <div class="mb-2">Activation Period</div>
                                                        <div class="mb-2">{{ date("d/m/Y") }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="text-center">
                                                    <div class="f16 font-bold purple-bordered">
                                                        <div class="color-black mb-2">Wallet Balance</div>
                                                        <div class="purple_txt  mb-2">${{ number_format($wallet_balance->amount,2) }}</div>
                                                        <input type="hidden" value="{{ $wallet_balance->amount }}" id="user_wallet_amt" name="user_wallet_amt">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="col-12 mt-3">
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" name="pay" id="pay" class="form-check-input" style=" width: inherit;" disabled>
                                                        <label class="form-check-label payfor_friend" for="exampleCheck1">Proceed payment from my BestBOX wallet</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
                                                        <!-- Post Buy -->
                                                        <!--<div class="row d-none">
                                            <div class="col-lg-6">
                                                <div class="text-center">
                                                    <div class="f16 color-black p-2">
                                                        <div class="font-bold mb-2">Activation Period</div>
                                                        <div class="mb-2">5/4/2019 - 5/7/2019</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="text-center">
                                                    <div class="f16 font-bold grey-bordered">
                                                        <div class="color-black mb-3">Status</div>
                                                        <div class="label_active mx-auto mb-2">Active</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
                                                        <!-- Auto complete -->
                                                        <!--<div class="d-none">
                                            <div class="autocomplete-drop-down mt-4">
                                                <div class="countries-input-container">
                                                <input class="countries-input" placeholder="Enter Name" type="text">
                                                <div class="input-underline"></div>
                                                <span class="input-arrow">&#9662;</div>
                                            </div>
                                            <div class="countries-list-container">
                                                <ul class="countries-list">
                                                    <li>&nbsp;</li>
                                                </ul>
                                            </div>
                                        </div>-->
                                    <input type="hidden" name="selected_wal" id="selected_wal">
                                    <div class="my-4">
                                        <div class="display_inline">
                                            <a href="<?php echo url('/transactions');?>" class="btn_cancel">
                                                CANCEL
                                            </a>
                                        </div>
                                        <div class="display_inline">
                                            <button class="btn btn_primary btn_cancel d-block w-100 mt-4"
                                                id="proceed_btn" type="submit">PROCEED</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="step2" class="d-none">
                            <ul class="p-0">
                                <li class="list-type-none pb-2 text-white">Email: <span class="font-weight-bold text-white"
                                        id="disp_email">abctest@gmail.com</span></li>
                                <li class="list-type-none pb-2 text-white">First Name: <span class="font-weight-bold text-white"
                                        id="disp_first_name">abc</span></li>
                                <li class="list-type-none text-white">Last Name: <span class="font-weight-bold text-white"
                                        id="disp_last_name">test</span></li>
                            </ul>
                            <div class="mb-5">
                                <p class="font-weight-bold text-white font-bold text-uppercase">Confirm Your Purchase
                                </p>
                                <div class="col-12 mb-5">
                                    <div class="row add-newcustomer">
                                        <table class="m_table ">
                                            <tbody>
                                                <tr class="tableHeader" style="background-color:#303030;">
                                                    <td style="font-weight:bold; background-color:#303030; color: #fff;"
                                                        width="40%">Description</td>
                                                    <td align="right"
                                                        style="font-weight:bold; background-color:#303030; color: #fff;">Unit price
                                                    </td>
                                                    <td align="right"
                                                        style="font-weight:bold; background-color::#303030; color: #fff;">Quantity
                                                    </td>
                                                    <td align="right"
                                                        style="font-weight:bold; background-color::#303030; color: #fff;">Amount
                                                    </td>
                                                </tr>
                                                <tr class="m_bgwhite">
                                                    <td id="disp_package_desc" class="text-white" style="color: #fff;">BestBOX + 1 Month Subscription
                                                        Includes pre - installed app & 1 month subscription + door
                                                        to door delivery</td>
                                                    <td align="right" class="disp_actual_amt text-white">$34.99 USD</td>
                                                    <td align="right" class="text-white">1</td>
                                                    <td align="right" class="disp_actual_amt text-white">$34.99 USD</td>
                                                </tr>
                                                <tr class="m_row">
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td align="right" class="text-white">Subtotal</td>
                                                    <td align="right" class="text-white disp_actual_amt">$34.99 USD</td>
                                                </tr>
                                                <tr class="m_row2">
                                                    <td class="border-top-0">&nbsp;</td>
                                                    <td class="border-top-0">&nbsp;</td>
                                                    <td align="right" class="border-top-0 text-white">Discount</td>
                                                    <td align="right" class="border-top-0 text-white" id="disp_discount_amt">
                                                        $0.00 USD</td>
                                                </tr>
                                                <tr class="m_row4">
                                                    <td class="border-top-0 text-white border-bottom">&nbsp;</td>
                                                    <td class="border-top-0 text-white border-bottom">&nbsp;</td>
                                                    <td align="right" style="font-weight:bold; width:160px;"
                                                        class=" border-bottom text-white">Amount payable</td>
                                                    <td align="right" style="font-weight:bold"
                                                        class=" border-bottom disp_package_amt text-white">$34.99 USD</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <p class="font-weight-bold text-white font-bold text-uppercase">Payment Method</p>
                                <div class="form-width mb-5">
                                    <div class="">
                                        <div class="d-none" id="wallet_pay">
                                            <div class="mt-3">
                                                <div class="form-group form-check p-0">
                                                    <label class="form-check-label payfor_friend text-white" style="color: #fff !important;"
                                                        for="exampleCheck1">Pay From My BestBOX Wallet</label>
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="text-center">
                                                    <div class="f16 fo  nt-bold blue-bordered">
                                                        <div class="color-black mb-2">Wallet Balance</div>
                                                        <div class="text-purple mb-2">
                                                            {{ number_format($wallet_balance->amount,2) }} USD</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-none" id="everuspay_pay">
                                            <div class="col-12 mt-4 pl-0">
                                                <div class="form-group form-check">
                                                    <label class="form-check-label payfor_friend" style="color: #fff !important;"
                                                        for="exampleCheck1">CRYPTO PAYMENT
                                                        <!--<span
                                                    class="pl-3"><img src="{{ url('/') }}/public/customer/images/evr-pay-logo.png?q=<?php echo rand();?>" style="width:100px;"></span>-->
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="disp_shipping_addr" class="d-none">
                                        <p class="font-weight-bold text-white font-bold text-uppercase">Shipping
                                            Address</p>
                                        <div class="form_bg6 mb-5 sp_address" id="disp_shipping_address">
                                        </div>
                                    </div>
                                    <div class="my-4">
                                        <div class="display_inline">
                                            <button class="btn_cancel" id="back_btn">Back</button>
                                        </div>
                                        <div class="display_inline">
                                            <button class="btn btn_primary d-block w-100 mt-4 " id="pay_now">Pay
                                                Now</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="deleteUser" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <h5 class="modal-title font-bold text-white text-uppercase f20" id="exampleModalLongTitle">
                        Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body add_edit_user pb-4">
                    <div class="text-center f18 text-white py-5 font-bold red_txt">
                        Insufficient Balance In Your Wallet.
                    </div>
                </div>
                <input type="hidden" name="delete_user_id" id="delete_user_id">
                <!-- footer buttons -->
                <div class="inline-buttons">
                    <button type="button" class="btn inline-buttons-right create-btn" style="width:100%;"
                        data-dismiss="modal"><strong>CLOSE</strong></button>
                </div>
            </div>
        </div>
    </div>
    @include('inc.v2.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
</body>
</html>
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
<script>
    /* select box*/
    var html = '';
    var html2 = '';
    var html3 = '';
    $(document).ready(function () {
        html +=
            '<li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">Select Package</li>';
        html2 +=
            '<li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">Select Package</li>';
            <?php foreach($package_data as $val) {?>
                var id = '<?php echo $val->id;?>';
                var setupbox_status = '<?php echo $val->setupbox_status;?>';
                var amount = '<?php echo $val->effective_amount;?>';
                var package_name = '<?php echo $val->package_name;?>';
                var description = '<?php echo $val->description;?>';
                var package_value = '<?php echo $val->package_value;?>';
                var discount = '<?php echo $val->discount;?>';
                html += '<li value="' + id + '" data-box="' + setupbox_status + '" data-package="' + id +
                    '" data-actualamt="' + package_value + '" data-discountamt="' + discount + '" data-amt="' +
                    amount + '" data-name="' + package_name + '" data-desc="' + description +
                    '" class="text-left" style="display: table; width: 100%;">';
                html += '<div class="border-right-blue p-3" style="display: table-cell; width: 70%;">';
                html += '<div class="" style="font-weight: 700;">' + package_name + '</div>';
                html += '<div>' + description + '</div>';
                html += '</div>';
                html += '<div class="p-3 font-bold" style="display: table-cell; width: 30%;">' + amount +
                    ' USD</div>';
                html += '</li>';
                <?php
            } ?>
            <?php foreach($package_data as $val) {?>
                var id = '<?php echo $val->id;?>';
                var setupbox_status = '<?php echo $val->setupbox_status;?>';
                var amount = '<?php echo $val->effective_amount;?>';
                var package_name = '<?php echo $val->package_name;?>';
                var description = '<?php echo $val->description;?>';
                var package_value = '<?php echo $val->package_value;?>';
                var discount = '<?php echo $val->discount;?>';
                <?php
                if ($val->setupbox_status == 2) {?>
                    html2 += '<li value="' + id + '" data-box="' + setupbox_status + '" data-package="' + id +
                        '" data-actualamt="' + package_value + '" data-discountamt="' + discount +
                        '" data-amt="' + amount + '" data-name="' + package_name + '" data-desc="' +
                        description + '" class="text-left" style="display: table; width: 100%;">';
                    html2 += '<div class="border-right-blue p-3" style="display: table-cell; width: 70%;">';
                    html2 += '<div class="" style="font-weight: 700;">' + package_name + '</div>';
                    html2 += '<div>' + description + '</div>';
                    html2 += '</div>';
                    html2 += '<div class="p-3 font-bold" style="display: table-cell; width: 30%;">' + amount +
                        ' USD</div>';
                    html2 += '</li>';
                    <?php
                }
            } ?>
            $('body').on('click', 'ul.package_list li', function () {
                var amount = $(this).attr('data-amt');
                var package_id = $(this).attr('data-package');
                if (package_id == "") {
                    setTimeout(function () {
                        $(".select-test span:first").html(
                            '<li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">Select Package</li>'
                            );
                    }, 50);
                    $("#package").val('');
                    $("#package_amount").val('');
                } else {
                    var actual_amount = $(this).attr('data-actualamt');
                    var discountamt = $(this).attr('data-discountamt');
                    var setupbox_status = $(this).attr('data-box');
                    var setupbox_status = $(this).attr('data-box');
                    $("#check_setupbox_status").val(setupbox_status);
                    if (setupbox_status == 1) {
                        $("#disp_shipping_addr").removeClass('d-none');
                        $("#shipping_user_mobile_no").prop('required', true);
                        $("#shipping_addr").css('display', 'block');
                    } else {
                        $("#disp_shipping_addr").addClass('d-none');
                        $("#shipping_user_mobile_no").prop('required', false);
                        $("#shipping_addr").css('display', 'none');
                    }
                    $(".select_package_drop").addClass('sel_pack');
                    $("#package").val(package_id);
                    $("#package_amount").val(amount);
                    var package_name = $(this).attr('data-name');
                    var package_desc = $(this).attr('data-desc');
                    $("#disp_package_desc").html(package_desc);
                    $(".disp_package_amt").html("$" + amount + " USD");
                    $(".disp_actual_amt").html("$" + actual_amount + " USD");
                    $("#disp_discount_amt").html("-$" + discountamt + " USD");
                    setTimeout(function () {
                        $(".select-test span:first").html(
                            "<div class='p-2 clearfix' style='width: 100%;'><div class='float-left' style='width:75%'><div style='font-weight: 700;'>" +
                            package_name + "</div><div>" + package_desc +
                            "</div></div><div class='float-right font-bold pr-4'>$ " +
                            amount + "</div></div>");
                    }, 50);
                }
            });
    });
    $('.menucheck').on('change', function () {
        $("#chkboxvalue").val($(this).attr('id'));
        if ($(this).is(":checked")) {
            $(".package_selection").prop("disabled", false);
            var subscription_type = $(this).attr('id');
            $('.menucheck').not(this).prop('checked', false);
            if (subscription_type == 'new') {
                $(".package_list").html(html);
            } else {
                $(".package_list").html(html2);
            }
        } else {
            $('.menucheck').not(this).prop('checked', true);
        }
        $(".select-test span:first").html(
            "<li value='' data-package='' data-amt='' class='text-left' style='display: table; width: 100%;'>Select Package</li>"
            );
    });
    $(document).ready(function () {
        var select = $(".select-test");
        select.select({
            selected: 0,
            //animate: "slide"
        });
    });
    var data = <?php echo $customers_data; ?>;
    function template(data) {
        return data.html;
    }
    $("#username").select2({
        placeholder: 'Search Name',
        data: data,
        templateResult: template,
        escapeMarkup: function (m) {
            return m;
        }
    });
    data.forEach(function (data) {
        if (data.name) {
            var $newOption = $("<option selected='selected'></option>").val(data.id).text(data.text)
            $("#username").append($newOption).trigger('change');
        }
    });
    $("#username").change(function () {
        var id = $(this).val();
        $("#subsErr").html('');
        var csrf_Value = "<?php echo csrf_token(); ?>";
        $.ajax({
            type: 'POST',
            url: "<?php echo url('/');?>/checkPackagePurchase",
            data: {
                '_token': csrf_Value,
                'id': id
            },
            dataType: "json",
            success: function (data) {
                $("#disp_email").html(data.email);
                $("#disp_first_name").html(data.first_name);
                $("#disp_last_name").html(data.last_name);
                if (data.status == 'Success') {
                    $("#subscribe_options").css('display', 'block');
                    $("#subs_type").val('2');
                    $(".package_list").html('');
                    $(".package_selection").prop("disabled", true);
                    if ($(".menucheck").is(":checked")) {
                        var subscription_type = $("input:checked").attr('id');
                        $(".package_selection").prop("disabled", false);
                        if (subscription_type == 'new') {
                            $(".package_list").html(html);
                        } else if (subscription_type == 'renew') {
                            $(".package_list").html(html2);
                        }
                    }
                } else {
                    $("#subscribe_options").css('display', 'none');
                    $("#subs_type").val('1');
                    $(".package_list").html(html);
                    $(".select-test span:first").html(
                        "<li value='' data-package='' data-amt='' class='text-left' style='display: table; width: 100%;'>Select Package</li>"
                        );
                    $(".package_selection").prop("disabled", false);
                }
                if (data.sub_user == 1) {
                    $("#new").attr("disabled", true);
                    $("#renew").attr("disabled", true);
                    $("#renew").prop('checked', true);
                    $("#new").prop('checked', false);
                    $(".package_selection").prop("disabled", false);
                    $(".package_list").html(html2);
                    $(".select-test span:first").html(
                        "<li value='' data-package='' data-amt='' class='text-left' style='display: table; width: 100%;'>Select Package</li>"
                        );
                } else {
                    $("#new").removeAttr("disabled");
                    $("#renew").removeAttr("disabled");
                }
            }
        });
    });
    //when loading the document called this function
    $(document).ready(function () {
        var id = $("#username").val();
        var name = $("#username").children("option:selected").text();
        $("#selected_wal").val(name);
        $("#subsErr").html('');
        var csrf_Value = "<?php echo csrf_token(); ?>";
        $.ajax({
            type: 'POST',
            url: "<?php echo url('/');?>/checkPackagePurchase",
            data: {
                '_token': csrf_Value,
                'id': id
            },
            dataType: "json",
            success: function (data) {
                if (data.status == 'Success') {
                    $("#subscribe_options").css('display', 'block');
                    $("#subs_type").val('2');
                    $(".package_list").html('');
                    $(".package_selection").prop("disabled", true);
                    if ($(".menucheck").is(":checked")) {
                        var subscription_type = $("input:checked").attr('id');
                        $(".package_selection").prop("disabled", false);
                        if (subscription_type == 'new') {
                            $(".package_list").html(html);
                        } else if (subscription_type == 'renew') {
                            $(".package_list").html(html2);
                        }
                    }
                } else {
                    $("#subscribe_options").css('display', 'none');
                    $("#subs_type").val('1');
                    $(".package_list").html(html);
                    $(".select-test span:first").html(
                        "<li value='' data-package='' data-amt='' class='text-left' style='display: table; width: 100%;'>Select Package</li>"
                        );
                    $(".package_selection").prop("disabled", false);
                }
                if (data.sub_user == 1) {
                    $("#new").attr("disabled", true);
                    $("#renew").attr("disabled", true);
                    $("#renew").prop('checked', true);
                    $("#new").prop('checked', false);
                    $(".package_selection").prop("disabled", false);
                    $(".package_list").html(html2);
                    $(".select-test span:first").html(
                        "<li value='' data-package='' data-amt='' class='text-left' style='display: table; width: 100%;'>Select Package</li>"
                        );
                } else {
                    $("#new").removeAttr("disabled");
                    $("#renew").removeAttr("disabled");
                }
            }
        });
    });
    $("#proceed_btn").click(function (e) {
        e.preventDefault();
        var package = $("#package").val();
        var customer_id = $("#username").val();
        var user_name = $("#selected_wal").val();
        error = false;
        if (customer_id == "") {
            $("#err_msg_customer").html("Please select customer");
            error = true;
        } else {
            $("#err_msg_customer").html("");
        }
        if (package == '') {
            $("#packageErr").html('Package is Required');
            error = true;
        } else {
            $("#packageErr").html('');
        }
        if (!$("input[name='pay']:checked").val()) {
            $("#paymethodErr").html('Select payment method');
            return false;
        } else {
            $("#paymethodErr").html('');
        }
        var subs_type = $("#subs_type").val();
        if (subs_type == 2) {
            if ($('.menucheck').is(":checked")) {
                $("#subsErr").html('');
            } else {
                $("#subsErr").html('Select subscription type');
                error = true;
            }
            var chkboxvalue = $("#chkboxvalue").val();
            if (chkboxvalue == 'new') {
                var html = "New subscription with sub user creation for customer (<b>" + user_name + "</b>)";
            } else {
                var html = "Renewal subscription for customer (<b>" + user_name + "</b>)";
            }
        } else {
            var html = "New subscription for customer (<b>" + user_name + "</b>)";
        }
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        var shipping_address = $.trim(CKEDITOR.instances['shipping_address'].getData());
        if ($("#check_setupbox_status").val() == 1) {
            if (shipping_address == '') {
                $("#shipAddrErr").html('Shipping Address Required');
                error = true;
            } else {
                $("#shipAddrErr").html('');
            }
            var country = $("#select_country3").val();
            if (country == "") {
                $("#country_err").html("Please select country");
                error = true;
            } else {
                $("#country_err").html("");
            }
            var shipping_user_mobile_no = $("#shipping_user_mobile_no").val();
            var phoneRGEX = /^[0-9]{8,14}$/;
            var phoneResult = phoneRGEX.test(shipping_user_mobile_no);
            if (shipping_user_mobile_no == "") {
                $("#mobile_no_err").html("Please select Mobile No");
                error = true;
            } else if (phoneResult == false) {
                $("#mobile_no_err").html("Please provide correct Mobile No");
                return false;
            } else {
                var country_name = $('option:selected', '#select_country3').attr('data-countryname');
                var country_code = $("#shipping_country_code").val();
                $("#disp_shipping_address").html(shipping_address + '<p>' + country_name + '</p>' + '<p>' +
                    country_code + '-' + shipping_user_mobile_no + '</p>');
                $("#mobile_no_err").html("");
            }
        }
        if (error) return false;
        $("#step1").addClass('d-none');
        $("#step2").removeClass("d-none");
    });
    $("#back_btn").click(function () {
        $("#step1").removeClass('d-none');
        $("#step2").addClass("d-none");
    });
    $("#pay_now").click(function () {
        $("#create_form").submit();
    });
    $("#username").change(function () {
        var name = $(this).children("option:selected").text();
        $("#selected_wal").val(name);
    });
    $('#select_country3').select2();
    $("#select_country3").change(function (e) {
        var country_code = $('option:selected', this).attr('data-id');
        if (country_code != "") {
            $("#shipping_country_code").val('+' + country_code);
        } else {
            $("#shipping_country_code").val('');
            $("#shipping_user_mobile_no").val('');
        }
    });
    $("#shipping_user_mobile_no").on("keypress keyup blur", function (event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
</script>
<script>
    CKEDITOR.replace('shipping_address', {
        height: 150
    });
</script>
<script>
    (function () {
        window.addEventListener('load', function () {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    for (instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                    var shipping_address = $.trim(CKEDITOR.instances['shipping_address']
                        .getData());
                    if ($("#check_setupbox_status").val() == 1) {
                        if (shipping_address == '') {
                            $("#shipAddrErr").html('Shipping Address Required');
                            error = true;
                        } else {
                            $("#shipAddrErr").html('');
                        }
                        var country = $("#select_country3").val();
                        if (country == "") {
                            $("#country_err").html("Please select country");
                        } else {
                            $("#country_err").html("");
                        }
                    }
                    $("#email_error").html("");
                }, false);
            });
        }, false);
    })();
    $(".payment").click(function () {
        if ($(this).is(":checked")) {
            var payment_type = $(this).attr('data-value');
            $("#payment_method").val(payment_type);
            $('.payment').each(function () {
                if ($(this).attr('data-value') != payment_type) {
                    $(this).prop('checked', false);
                }
            });
            if (payment_type == 'everuspay') {
                $("#everuspay_pay").removeClass("d-none");
                $("#wallet_pay").addClass("d-none");
            } else if (payment_type == 'wallet') {
                $("#everuspay_pay").addClass("d-none");
                $("#wallet_pay").removeClass("d-none");
            }
            if (payment_type == 'wallet') {
                var user_wallet_amt = $("#user_wallet_amt").val();
                var amount = $("#package_amount").val();
                if (parseFloat(amount) > parseFloat(user_wallet_amt)) {
                    $(this).prop('checked', false);
                    swal(
                        'Failure',
                        'Insufficient Balance In Your Wallet',
                        'error'
                    )
                    setTimeout(function () {
                        $(".select-test span:first").html(
                            "<li value='' data-package='' data-amt='' class='text-left' style='display: table; width: 100%;'>Select Package</li>"
                            );
                    }, 50);
                }
            }
        } else {
            $('.payment').each(function () {
                if ($(this).attr('data-value') != payment_type) {
                    $(this).prop('checked', false);
                }
            });
        }
    });
</script>

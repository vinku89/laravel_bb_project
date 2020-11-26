<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Payment Status</title>
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
                    <h5 class="font20 font-bold text-uppercase text-white pt-4 mb-5">Payment Success</h5>
                    <div class="col-lg-6 text-white">
                        <img src="../public/customer/images/success-tickmark.png">
                        <h5 class="font20 font-bold text-uppercase text-white pt-3">Thank You!</h5>
                        <p class="mb-4">Your payment transfer is successful for:-</p>

                        <ul class="user_purchase_info">
                            <li>Date</li>
                            <li class="font-weight-bold">:
                                @php
                                    echo \App\Http\Controllers\home\ReportController::convertTimezone($payment_det['purchased_date']);
                                @endphp
                            </li>
                            <li>Package</li>
                            <li class="font-weight-bold">: {{ $payment_det['package_name'] }} </li>
                            @If($payment_det['duration'] != 0)
                            <li>Duration</li>
                            <li class="font-weight-bold">: {{ $payment_det['duration'] }} MONTH{{ $payment_det['duration'] >1 ? 'S' : ''}}
                            </li>
                            @endIf
                            <li>Payment Method</li>
                            <li class="font-weight-bold">: {{ $payment_det['payment_method'] }}</li>
                            <li>Payment ID</li>
                            <li class="font-weight-bold">: {{ $payment_det['payment_id'] }}</li>

                            <div class="div_wrp col-xl-7 mt-5">
                                <p class="m-0">Amount Paid</p>
                                <p class="font-weight-bold f24 m-0">{{ $payment_det['package_amount'] }} USD</p>
                            </div>
                        </ul>

                        <div class=" col-xl-7 mt-5">
                            <div class="row">
                            <a href="{{ url('/transactions') }}" class="check_out_btn col-xl-12 ">View Transactions</a>
                            </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

     @include('inc.v2.footer')
     <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

</body>

</html>

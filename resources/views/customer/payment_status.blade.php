<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX Payment status</title>
    <link rel="shortcut icon" href="favicon.png" type="image/png" sizes="32x32" />
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
    <!-- Side bar include -->
   @include("inc.sidebar.sidebar")
    <div class="main-content">
        <!-- Header Section Start Here -->
         @include("inc.header.header")
        <!-- Header Section End Here -->
        <section class="main_body_section scroll_div">
           
            <h5 class="font20 font-bold text-uppercase black_txt pt-4 mb-5">Payment Success</h5>

            <div class="col-xl-6 pl-0">
                <img src="../public/customer/images/success-tickmark.png">
                <h5 class="font20 font-bold text-uppercase black_txt pt-3">Thank You!</h5>
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
    <!-- All scripts include -->
   @include("inc.scripts.all-scripts")
  
</body>
</html>
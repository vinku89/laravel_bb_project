<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Notifications</title>
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
                    <div class="clearfix">
                        <a href="<?php echo url('/').'/notifications';?>" class="btn btn-primary ">Transaction Notifications</a>
                        <a href="<?php echo url('/').'/announcements';?>" class="btn btn-secondary mx-2">General Notifications</a>
                    </div>
                    <h5 class="font16 text-white font-bold text-uppercase pt-4 pb-3">Transaction Notifications</h5>

                    <!-- Filter section -->
                    <div class="filter_wrp col-12">
                        <div class="row">
                            <div class="col-lg-6 col-md-8 xsmall-pad">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-3 col-form-label font16 text-white small_resolution"
                                                style="line-height: 36px;">From</label>
                                            <div class="col-sm-9">
                                                <div id="fromDate" class="input-group date  m-0"
                                                    data-date-format="mm-dd-yyyy">
                                                    <input class="form-control datepicker_input" type="text" readonly id="from_date" value="<?php echo $from_date;?>"/>
                                                    <span class="input-group-addon calender_icon"><i
                                                            class="far fa-calendar-alt"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-3 col-form-label font16 text-white small_resolution"
                                                style="line-height: 36px;text-align:center">To</label>
                                            <div class="col-sm-9 pl-0">
                                                <div id="toDate" class="input-group date  m-0"
                                                    data-date-format="mm-dd-yyyy">
                                                    <input class="form-control datepicker_input" type="text" readonly id="to_date" value="<?php echo $to_date;?>" />
                                                    <span class="input-group-addon calender_icon"><i
                                                            class="far fa-calendar-alt"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-4 xsmall-pad">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6 mb-3">
                                        <a href="javascript::void(0);" class="print_btn" id="filter_data">
                                            Filter
                                        </a>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <a href="javascript::void(0);" class="print_btn" id="clear_filter_data">
                                            Clear
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Filter section End-->
                    <div class="grid_wrp">
                        <div class="grid_header clearfix pt-3 pb-3 res_mobileView">
                            <div class="w20 float-left font16 font-bold text-white">Date</div>
                            <div class="w60 float-left font16 font-bold text-white pl-2 d-none d-lg-block">Action & Descriptions</div>
                            <div class="w15 float-left font16 font-bold text-white d-none d-lg-block">Status</div>
                            <div class="w5 float-left font16 font-bold text-white text-right pr-3">&nbsp;</div>
                        </div>
                    </div>

                    <div class="middle_box clearfix">
                        <div class="grid_wrp">
                            <div id="accordion">
                                <div class="grid_body clearfix">
                                    <!-- Row 1 -->
                                    <?php
                                        $total_in_amt = 0;
                                        $total_out_amt = 0;
                                    ?>
                                    @if($transactions->count())
                                    @foreach($transactions as $key=>$item)

                                    <?php
                                        $total_in_amt += $item['credit'];
                                        $total_out_amt += $item['debit'];
                                        $wd_res = \App\Withdraw_request::where(array('withdraw_id' => $item['rec_id']))->first();
                                        $payment_history = \App\PaymentsHistory::where(['transaction_no' => $item['transaction_no']])->first();
                                        $status = ($item['status']==1) ? 'Success' : 'Failure';
                                        $class = ($item['status']==1) ? 'green_btn' : 'red_btn';
                                        if(!empty($payment_history)){
                                            if( $payment_history->transaction_status == 'waiting') {
                                                $status = 'Waiting';$class = 'orange_btn';
                                            }else if($payment_history->transaction_status == 'failed' || $payment_history->transaction_status == ''){
                                                $status = 'Failure';$class = 'red_btn';
                                            }
                                        }
                                    ?>

                                    <div class="card res_mobileView">
                                        <div class="mb-0">
                                            <a class="collapsed grid_row clearfix"  data-toggle="collapse" href="#collapse-{{ $key }}" aria-expanded="false" aria-controls="collapse-{{ $key }}">
                                                <div class="w20 float-left font16 text-white position-relative">
                                                    @php
                                                        echo \App\Http\Controllers\home\ReportController::convertTimezone($item['received_date']);
                                                    @endphp
                                                </div>
                                                <div class="w60 float-left font16 text-white pl-2 d-none d-lg-block"><?php echo (empty($payment_history)) ? $item['ttype'] : 'EverusPay';?></div>
                                                <div class="w15 float-left d-none d-lg-block">
                                                    <div class="{{ $class }}">{{ $status }}</div>
                                                </div>
                                                <div class="w5 float-left font16 blue_txt text-right ">
                                                    <i class="fas fa-chevron-down text-white"></i>
                                                    <i class="fas fa-chevron-up text-white"></i>
                                                </div>
                                            </a>
                                        </div>

                                        <div id="collapse-{{ $key }}" class="collapse content_div" data-parent="#accordion" aria-labelledby="heading-2">
                                            <div class="card-body">
                                                @if(empty($payment_history))
                                                <div class="row">
                                                    <div class="col-md-12 col-lg-6 border-right responsive_brdr">

                                                        <ul>
                                                            <li class="li_width float-left">User ID</li>
                                                            <li class="dark-grey_txt">{{ $item['sender_id'] == $item['user_id'] && $item['user_id'] == $userInfo['rec_id'] ?  $item['receiver'] : $item['sender'] }}</li>
                                                            <li class="li_width float-left">Name</li>
                                                            <li class="dark-grey_txt">{{ $item['sender_id'] == $item['user_id'] && $item['user_id'] == $userInfo['rec_id'] ?  $item['receiver_name'] : $item['sender_name'] }}</li>
                                                            @If(!empty($item['package_name']))
                                                            <li class="li_width float-left">BestBOX Package</li>
                                                            <li class="dark-grey_txt">{{ $item['package_name'] != '' ? $item['package_name'] : '-' }}</li>
                                                            @endIf
                                                            <li class="li_width float-left">Payment ID</li>
                                                            <li class="dark-grey_txt">{{ $item['transaction_no'] }}</li>
                                                            <li class="li_width float-left">Description</li>
                                                            <li class="dark-grey_txt ml-200">{{ $item['description'] }}</li>
                                                        </ul>
                                                    </div>
                                                    @If(!empty($wd_res))
                                                    <div class="col-md-12 col-lg-6">
                                                        <ul>
                                                            <li class="li_width float-left">Transaction No.</li>
                                                            <li class="dark-grey_txt">{{ !empty($wd_res['transaction_no']) ? $wd_res['transaction_no'] : '-' }}</li>
                                                            <li class="li_width float-left">Admin Response Date</li>
                                                            <li class="dark-grey_txt">{{ $wd_res['admin_response_date'] != '0000-00-00 00:00:00' ? \App\Http\Controllers\home\ReportController::convertTimezone($wd_res['admin_response_date']) : '-' }}</li>
                                                            <li class="li_width float-left">Credit Crypto Amount</li>
                                                            <li class="dark-grey_txt">{{ $wd_res['credit_crypto_amt'] }}</li>
                                                            <li class="li_width float-left">Wallet Address</li>
                                                            <li class="dark-grey_txt">{{ !empty($wd_res['wallet_address']) ? $wd_res['wallet_address'] : '-' }}</li>
                                                            <li class="li_width float-left">Transaction Hash</li>
                                                            <li class="dark-grey_txt word-break-all">{{ !empty($wd_res['transaction_hash']) ? $wd_res['transaction_hash'] : '-' }}</li>
                                                        </ul>
                                                    </div>
                                                    @endIf
                                                </div>
                                                @else
                                                <div class="row">
                                                    <div class="col-md-12 col-lg-6 border-right responsive_brdr">
                                                        <ul>
                                                            @If(!empty($item['package_name']))
                                                            <li class="li_width float-left">BestBOX Package</li>
                                                            <li class="dark-grey_txt">{{ $item['package_name'] != '' ? $item['package_name'] : '-' }}</li>
                                                            @endIf
                                                            <li class="li_width float-left">Merchant ID</li>
                                                            <li class="dark-grey_txt">{{ $payment_history['merchant_id'] != '' ? $payment_history['merchant_id'] : '-' }}</li>
                                                            <li class="li_width float-left">Email</li>
                                                            <li class="dark-grey_txt">{{ $item['sender_id'] == $item['user_id'] && $item['user_id'] == $userInfo['rec_id'] ?  $item['receiver_email'] : $item['sender_email'] }}</li>
                                                            <li class="li_width float-left">Payment Ref.</li>
                                                            <li class="dark-grey_txt">{{ $payment_history['payment_reference'] != '' ? $payment_history['payment_reference'] : '-' }}</li>
                                                            <li class="li_width float-left">EverusPay ID</li>
                                                            <li class="dark-grey_txt ml-200">{{ $payment_history['RefNo'] != '' ? $payment_history['RefNo'] : '-' }}</li>

                                                            @If( $payment_history->transaction_status != 'failed' && $payment_history->transaction_status != '')
                                                            <li class="li_width float-left">Payor Wallet</li>
                                                            <li class="dark-grey_txt ml-200">{{ $payment_history['wallet_address'] != '' ? $payment_history['wallet_address'] : '-' }}</li>
                                                            <li class="li_width float-left">Transaction Hash</li>
                                                            <li class="dark-grey_txt ml-200">{{ $payment_history['transaction_hash'] != '' ? $payment_history['transaction_hash'] : '-' }}</li>
                                                            <li class="li_width float-left">Payment Remarks</li>
                                                            <li class="dark-grey_txt ml-200">{{ $payment_history['paid_status'] != '' ? $payment_history['paid_status'] : '-' }}</li>
                                                            @endIf

                                                            <li class="li_width float-left">Transaction Amount</li>
                                                            @If( $payment_history->transaction_status != 'failed' && $payment_history->transaction_status != '')
                                                            <li class="dark-grey_txt ml-200">{{ $payment_history['amount_in_usd'] != '' ? $payment_history['amount_in_usd'] : '-' }} USD | {{ $payment_history['amount_in_crypto'] != '' ? $payment_history['amount_in_crypto'] : '-' }} {{ $payment_history['crypto'] }}</li>
                                                            @else
                                                            <li class="dark-grey_txt ml-200">{{ $item['effective_amount'] }} USD</li>
                                                            @endIf

                                                            @If( $payment_history->transaction_status != 'failed' && $payment_history->transaction_status != '')
                                                            <li class="li_width float-left">Blockchain fee</li>
                                                            <li class="dark-grey_txt ml-200">{{ $payment_history['processing_fee_usd'] != '' ? $payment_history['processing_fee_usd'] : '-' }} USD | {{ $payment_history['processing_fee'] != '' ? $payment_history['processing_fee'] : '-' }} {{ $payment_history['crypto'] }}</li>
                                                            <li class="li_width float-left font-bold">Total</li>
                                                            <li class="dark-grey_txt ml-200 font-bold">{{ $payment_history['amount_in_usd'] != '' ? $payment_history['amount_in_usd'] : '-' }} USD | {{ $payment_history['amount_in_crypto'] != '' ? $payment_history['amount_in_crypto'] : '-' }} {{ $payment_history['crypto'] }}</li>
                                                            @endIf
                                                        </ul>
                                                    </div>
                                                </div>
                                                @endIf
                                            </div>
                                        </div>
                                    </div>

                                    @endforeach
                                    @else
                                    <div class="w100 norecord_txt">No Records Found</div>
                                    @endif
                                    <div class="total_calc_wrp clearfix bal_md_view">
                                        <div class="w35 float-left bal_md_txt black_txt font-bold">Total Transaction</div>
                                        <div class="w30 float-left bal_md_txt text-right blue_txt font-bold">$ <?php echo number_format($total_in_amt,2); ?></div>
                                        <div class="w30 float-left bal_md_txt text-right red_txt font-bold">$ <?php echo number_format($total_out_amt,2); ?></div>
                                    </div>

                                    @if($transactions->total()>0)
                                    <?php echo $transactions->appends(['from_date' => '', 'to_date' => ''])->links(); ?>
                                    @endIf

                                </div>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div>

     @include('inc.v2.footer')

    <script type="text/javascript">
     var url = "<?php echo url('/notifications'); ?>";

     /* filter data */
     $("#filter_data").click(function(e){
        e.preventDefault();
        var from_date = $("#from_date").val().trim();
        var to_date = $("#to_date").val().trim();
        if(from_date == '' || to_date == '') {
            alert('Please select both from and to date');
            return false;
        }else if(to_date < from_date ) {
            alert('To date should be grater than From Date');
            return false;
        }else{
            var searchUrl = url+'?from_date='+from_date+'&to_date='+to_date+'&page=0';
            location.href=searchUrl;
        }

    });

    /* clear filter data */
    $("#clear_filter_data").click(function(e){
        e.preventDefault();
        $("#from_date").val('');
        $("#to_date").val('');
        var searchUrl = url+'?from_date=&to_date=&page=0';
        location.href=searchUrl;
    });

    $(document).ready(function(){
        $("#fromDate").datepicker({
          autoclose: true,
          todayHighlight: true,
          endDate: "today"
        });

        $("#toDate").datepicker({
            autoclose: true,
            todayHighlight: true,
            endDate: "today"
        });
    });
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX Transaction</title>
    <link rel="shortcut icon" href="favicon.png" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include('customer.inc.all-styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    <!-- Side bar include -->
    @include('inc.sidebar.sidebar')
    <div class="main-content customer_pannel">
        <!-- Header Section Start Here -->
        @include('inc.header.header')
        <!-- Header Section End Here -->
        <section class="customer_main_body_section scroll_div container-fluid">
            <h5 class="font16 text-white font-bold text-uppercase pt-4 pb-3">Transactions</h5>
            <!-- Agent Info section here -->
            <div class="middle_box clearfix mb-3">
                <div class="wallet-balance_bg col-12 p-3">
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-12 bb_div1">
                            <div class="row">
                                <div class="mr-auto tran_balance_wrap mobile_tran_balance_wrap">
                                    <div class="display-inline-block">
                                        <img src="<?php echo  url('/');?>/public/customer/images/wallet2.png" class="wallet-icon">
                                        <h5 class="wallet-title font16 black_txt font-bold text-uppercase float-left mb-0">My wallet balance</h5>
                                    </div>
                                </div>
                                <div class="ml-auto text-right amount_wrp">
                                    <span> <h1 class="bigFont">$ {{ number_format($wallet_balance->amount,2) }}</h1> </span>   
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-12 bb_div2 dashboard_main_btns p-0">
                            <a href="{{ url('/').'/payForMyFriend' }}" class="btn_wrap" style="border-radius: 5px;">Pay For My Friend</a>
                            <!-- <a href="{{ url('/').'/renewal' }}" class="btn_wrap">Renewal</a> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Agent Info section End -->
            <!-- Filter section -->
            <div class="row">
                <div class="filter_wrp col-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-8 xsmall-pad">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-sm-3 col-form-label font16 dark-grey_txt small_resolution"
                                            style="line-height: 36px;">From</label>
                                        <div class="col-sm-9 pl-md-0">
                                            <div id="fromDate" class="input-group date  m-0"
                                                data-date-format="mm-dd-yyyy">
                                                <input class="form-control datepicker_input" type="text" readonly
                                                    id="from_date" value="<?php echo $from_date;?>" />
                                                <span class="input-group-addon calender_icon"><i
                                                        class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-sm-3 col-form-label font16 dark-grey_txt small_resolution"
                                            style="line-height: 36px;text-align:center">To</label>
                                        <div class="col-sm-9 pl-md-0">
                                            <div id="toDate" class="input-group date  m-0"
                                                data-date-format="mm-dd-yyyy">
                                                <input class="form-control datepicker_input" type="text" readonly
                                                    id="to_date" value="<?php echo $to_date;?>" />
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
                                <div class="col-lg-3 col-sm-6">
                                    <a href="javascript::void(0);" id="filter_data" class="print_btn mb-2">
                                        Filter
                                    </a>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <a href="javascript::void(0);" class="print_btn mb-2" id="clear_filter_data">
                                        Clear
                                    </a>
                                </div>
                            </div>
                            <!-- <select id="normal_select" class="select-wrp">
                            <option value="This Week">All Transactions</option>
                            <option value="Commission">Transactions</option>
                            <option value="Commission">Transactions</option>
                            <option value="Commission">Transactions</option>
                            <option value="Commission">Transactions</option>
                        </select>
                        <a href="" class="print_btn float-right">Print
                            <i class="fas fa-print"></i>
                        </a> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Filter section End-->
            <div class="grid_wrp">
                <div class="grid_header clearfix p-3 res_mobileView">
                    <div class="w20 float-left font16 font-bold purple_txt">Date</div>
                    <div class="w20 float-left font16 font-bold purple_txt pl-2 d-none d-lg-block">Transaction Details</div>
                    <div class="w10 float-left font16 font-bold purple_txt d-none d-lg-block">Status</div>
                    <div class="w15 float-left font16 font-bold purple_txt text-right sm_view">Transaction In<br>(USD)</div>
                    <div class="w15 float-left font16 font-bold purple_txt text-right sm_view">Transaction Out<br>(USD)</div>
                    <div class="xs_view w15 float-left font16 font-bold blue_txt text-right">TXN In</div>
                    <div class="xs_view w15 float-left font16 font-bold blue_txt text-right">TXN Out</div>
                    <div class="w15 float-left font16 font-bold purple_txt text-right d-none d-lg-block">Wallet Balance<br>(USD)</div>
                    <div class="w5 float-left font16 font-bold purple_txt text-right pr-3">&nbsp;</div>
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
                            @if($commissionReports->count())
                            @foreach($commissionReports as $key=>$item)
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
                                <div class="" id="heading-1">
                                    <div class="mb-0">
                                            <a class="collapsed grid_row clearfix"  data-toggle="collapse" href="#collapse-{{ $key }}" aria-expanded="false" aria-controls="collapse-{{ $key }}">
                                                <div class="w20 float-left font16 dark-grey_txt position-relative">
                                                    @php
                                                        echo \App\Http\Controllers\home\ReportController::convertTimezone($item['received_date']);
                                                    @endphp
                                                </div>
                                                <div class="w20 float-left font16 dark-grey_txt pl-2 d-none d-lg-block"><?php echo (empty($payment_history)) ? $item['ttype'] : 'EverusPay';?></div>
                                                <div class="w10 float-left d-none d-lg-block">
                                                    <div class="{{ $class }}">{{ $status }}</div>
                                                </div>
                                                <div class="w15 float-left font16 text-right green_txt">{{ number_format($item['credit'],2) }}</div>
                                                <div class="w15 float-left font16 red_txt text-right ">{{ number_format($item['debit'],2) }}</div>
                                                <div class="w15 float-left font16 blue_txt text-right d-none d-lg-block">{{ number_format($item['balance'],2) }}</div>
                                                <div class="w5 float-left font16 blue_txt text-right ">
                                                    <i class="fas fa-chevron-down"></i>
                                                    <i class="fas fa-chevron-up"></i>
                                                </div>
                                            </a>
                                    </div>
                                </div>
                                <div id="collapse-{{ $key }}" class="collapse content_div" data-parent="#accordion" aria-labelledby="heading-2">
                                    <div class="card-body">
                                        @if(empty($payment_history))
                                        <div class="row">
                                            <div class="col-lg-6 border-right">
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
                                                    <li class="dark-grey_txt">{{ $item['description'] }}</li>
                                                </ul>  
                                            </div>
                                            @If(!empty($wd_res))
                                            <div class="col-lg-6">
                                                <ul>
                                                    <li class="li_width float-left">Transaction No.</li>
                                                    <li class="dark-grey_txt">{{ !empty($wd_res['transaction_no']) ? $wd_res['transaction_no'] : '-' }}</li>
                                                    <li class="li_width float-left">Admin Response Date</li>
                                                    <li class="dark-grey_txt">{{ $wd_res['admin_response_date'] != '0000-00-00 00:00:00' ? date("d/m/Y, h:i a", strtotime($wd_res['admin_response_date'])) : '-' }}</li>
                                                    <li class="li_width float-left">Credit Crypto Amount</li>
                                                    <li class="dark-grey_txt">{{ $wd_res['credit_crypto_amt'] }}</li>
                                                    <li class="li_width float-left">Wallet Address</li>
                                                    <li class="dark-grey_txt">{{ $wd_res['wallet_address'] }}</li>
                                                    <li class="li_width float-left">Transaction Hash</li>
                                                    <li class="dark-grey_txt">{{ !empty($wd_res['transaction_hash']) ? $wd_res['transaction_hash'] : '-' }}</li>
                                                </ul>
                                            </div>
                                            @endIf
                                        </div>
                                        @else
                                    <div class="row">
                                        <div class="col-md-12 col-lg-12 border-right responsive_brdr">
                                            <ul>

                                                @If(!empty($item['package_name']))
                                                <li class="li_width float-left">BestBOX Package</li>
                                                <li class="dark-grey_txt">{{ $item['package_name'] != '' ? $item['package_name'] : '-' }}</li>
                                                @endIf
                                                <li class="li_width float-left">Merchant ID</li>
                                                <li class="dark-grey_txt">{{ $payment_history['merchant_id'] != '' ? $payment_history['merchant_id'] : '-' }}</li>
                                                <li class="li_width float-left">Email</li>
                                                <li class="dark-grey_txt">{{ $payment_history['buyer_email'] != '' ? $payment_history['buyer_email'] : '-' }}</li>
                                                <li class="li_width float-left">Payment Ref.</li>
                                                <li class="dark-grey_txt">{{ $payment_history['order_id'] != '' ? $payment_history['order_id'] : '-' }}</li>
                                                <li class="li_width float-left">EverusPay ID</li>
                                                <li class="dark-grey_txt ml-200">{{ $payment_history['payment_reference'] != '' ? $payment_history['payment_reference'] : '-' }}</li>
                                                @If( $payment_history->transaction_status != 'failed' && $payment_history->transaction_status != '')
                                                <li class="li_width float-left">Payor Wallet</li>
                                                <li class="dark-grey_txt ml-200">{{ $payment_history['wallet_address'] != '' ? $payment_history['wallet_address'] : '-' }}</li>
                                                <li class="li_width float-left">Transaction Hash</li>
                                                <li class="dark-grey_txt ml-200">{{ $payment_history['transaction_hash'] != '' ? $payment_history['transaction_hash'] : '-' }}</li>
                                                <li class="li_width float-left">Payment Remarks</li>
                                                <li class="dark-grey_txt ml-200">{{ $payment_history['paid_status'] != '' ? ucwords($payment_history['paid_status']) : '-' }}</li>
                                                @endIf
                                                <?php 
                                                    $total_amount = $payment_history['amount_in_usd']+$payment_history['processing_fee_usd'];
                                                    $amount_crypto = $payment_history['amount_in_crypto']-$payment_history['processing_fee'];
                                                ?>
                                                <li class="li_width float-left">Transaction Amount</li>
                                                @If( $payment_history->transaction_status != 'failed' && $payment_history->transaction_status != '')
                                                <li class="dark-grey_txt ml-200">{{ $payment_history['amount_in_usd'] != '' ? number_format_eight_dec_currency($payment_history['amount_in_usd']) : '-' }} USD | {{ $amount_crypto != '' ? number_format_eight_dec($amount_crypto) : '-' }} {{ $payment_history['crypto'] }}</li>
                                                @else
                                                <li class="dark-grey_txt ml-200">{{ $item['effective_amount'] }} USD</li>
                                                @endIf

                                                @If( $payment_history->transaction_status != 'failed' && $payment_history->transaction_status != '')
                                                <li class="li_width float-left">Blockchain fee</li>
                                                <li class="dark-grey_txt ml-200">{{ $payment_history['processing_fee_usd'] != '' ? number_format_eight_dec_currency($payment_history['processing_fee_usd']) : '0.00' }} USD | {{ $payment_history['processing_fee'] != '' ? number_format_eight_dec($payment_history['processing_fee']) : '0.00' }} {{ $payment_history['crypto'] }}</li>
                                                <li class="li_width float-left font-bold">Total</li>
                                               
                                                <li class="dark-grey_txt ml-200 font-bold">{{ $total_amount != '' ? number_format_eight_dec_currency($total_amount) : '-' }} USD | {{ $payment_history['amount_in_crypto'] != '' ? number_format_eight_dec($payment_history['amount_in_crypto']) : '-' }} {{ $payment_history['crypto'] }}</li>
                                                 @endIf
                                            </ul>  
                                        </div>
                                    </div>
                                    @endIf
                                    </div>
                                </div>
                            </div>
                           
                        @endforeach
							<div class="total_calc_wrp clearfix bal_md_view"> 
								<div class="w35 float-left bal_md_txt black_txt font-bold">Total Transaction</div>
								<div class="w30 float-left bal_md_txt text-right blue_txt font-bold">$ <?php echo number_format($total_in_amt,2); ?></div>
								<div class="w30 float-left bal_md_txt text-right red_txt font-bold">$ <?php echo number_format($total_out_amt,2); ?></div>
							</div>
						
						@else
							<div class="text-center norecord_txt">No records found!</div>
						@endif
						
						
						
                        @if($commissionReports->total()>0)
                           <?php echo $commissionReports->appends(['from_date' => '', 'to_date' => ''])->links(); ?>
                        @endIf
                          
                        </div>
                    </div>
                </div>


            </div>
        </section>
       
    </div>


    <!-- All scripts include -->
    @include('inc.scripts.all-scripts')
    
    <script type="text/javascript">
     var url = "<?php echo url('/transactions'); ?>";

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
        } else{
            var searchUrl = url+'?from_date='+from_date+'&to_date='+to_date+'&page=0';
            location.href=searchUrl;
        }
        
    });

    /* clear filter data */
    $("#clear_filter_data").click(function(e){
        e.preventDefault();
        $("#from_date").val('');
        $("#to_date").val('');
        //var searchUrl = url+'?from_date=&to_date=&page=0';
        location.href= "<?php echo url('/transactions'); ?>";
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
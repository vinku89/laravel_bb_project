<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Withdraw Requested List</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
     @include("inc.styles.all-styles")
      <style>
        .activate_btn{
            background-color: #48ab48;
            color: #fff;
            text-decoration: none;
            padding: 3px 10px;
            border-radius: 3px;
            cursor: default;
        }
        .activate_btn:hover{
            color:#fff;
            text-decoration: none;
        }
        .pending_btn{
            background-color: #007bff;
            color: #fff;
            padding: 3px 10px;
            border-radius: 3px;
        }
        .pending_btn:hover{
            background-color: #007bbb;
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <!-- Side bar include -->
    @include("inc.sidebar.sidebar")
    <div class="main-content sales_transaction">
        <!-- Header Section Start Here -->
         @include("inc.header.header")
        <!-- Header Section End Here -->
        <section class="main_body_section scroll_div">
            <h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3">Crypto Withdrawal Requests</h5>
            <!-- Filter section -->
            <div class="filter_wrp col-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label font16 dark-grey_txt small_resolution"
                                        style="line-height: 36px;">From</label>
                                    <div class="col-sm-9 pl-0">
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
                                    <label for="" class="col-sm-3 col-form-label font16 dark-grey_txt small_resolution"
                                        style="line-height: 36px;">To</label>
                                    <div class="col-sm-9 pl-0">
                                        <div id="toDate" class="input-group date  m-0"
                                            data-date-format="mm-dd-yyyy">
                                            <input class="form-control datepicker_input" type="text" readonly id="to_date" value="<?php echo $to_date;?>"/>
                                            <span class="input-group-addon calender_icon"><i
                                                    class="far fa-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3 mb-md-0">
                            <div class="col-6 col-md-3 pl-0">
                                <a href="javascript::void(0);" class="print_btn" id="filter_data">
                                    Filter
                                </a>
                            </div>
                            <div class="col-6 col-md-3 pl-0">
                                <a href="javascript::void(0);" class="print_btn" id="clear_filter_data">
                                    Clear
                                </a>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <!-- Filter section End-->
            <div class="middle_box clearfix d-lg-block d-none">
                <div class="grid_wrp">
                    <div class="grid_header clearfix pt-3 pb-3">
                        <div class="w20 float-left font16 font-bold blue_txt">Date</div>
                        <div class="w20 float-left font16 font-bold blue_txt pl-2">User ID</div>
                        <div class="w16 float-left font16 font-bold blue_txt text-right">Request Amount</br>(USD)</div>
                        <div class="w16 float-left font16 font-bold blue_txt text-center ">Wallet Type</div>
                        <div class="w18 float-left font16 font-bold blue_txt pr-3">Wallet Address</div>
                        <div class="w10 float-left font16 font-bold blue_txt text-right pr-3">Status</div>
                    </div>
                    <?php $request_amt = 0; ?>
                    <div class="grid_body clearfix">
                        @if($request_list->count())
						    @foreach($request_list as $item)
                            <!-- Row 1 -->
                            <?php
                                $request_amt += $item['request_amt']; ?>
                            <div class="grid_row clearfix border-top">
                                <div class="w20 float-left font16 dark-grey_txt position-relative">
                                    @php
                                        echo \App\Http\Controllers\home\ReportController::convertTimezone($item['request_date']);
                                    @endphp
                                </div>
                                <div class="w20 float-left font16 dark-grey_txt pl-2">{{ ucwords($item['first_name']." ".$item['last_name']) }}<br/><div class="f12 pt-0 font-bold">{{ $item['user_id'] }}</div></div>
                                <div class="w16 float-left font16 green_txt  text-right">{{ number_format($item['request_amt'],2) }}</div>
                                <div class="w16 float-left font16 text-center">
                                    <div class="comission_blue font16 font-bold">{{ $item['wallet_type'] }}</div>
                                </div>
                                <div class="w18 float-left font16 dark-grey_txt pr-3" style="word-break: break-word">{{ !empty($item['wallet_address']) ? $item['wallet_address'] : '-' }}</div>
                                <div class="w10 float-left font16 dark-grey_txt text-right pr-3">
                                    @If($item['status'] == 1)
                                        <a href="#" class="pending_btn" data-id="{{ $item['rec_id'] }}" data-toggle="modal" data-target="#pending_withdrawn">Pending</a>
                                    @else
                                        <span class="activate_btn">Success</span>
                                    @endIf
                                </div>
                            </div>
                            @endforeach
						@else
							<div class="w100 norecord_txt">No Records Found</div>
						@endif
                    </div>
                </div>
            </div>
            @if($request_list->count()>0)
            <div class="total_calc_wrp clearfix d-lg-block d-none">
                <div class="w20 float-left">&nbsp;</div>
                <div class="w20 float-left">&nbsp;</div>
                <div class="w16 green_txt font-bold text-right font16 float-left">{{ number_format($request_amt,2) }}</div>
                <div class="w16 float-left">&nbsp;</div>
                <div class="w18 grey_txt font-bold text-right font16 float-left pr-3">&nbsp;</div>
                <div class="w10 float-left">&nbsp;</div>
            </div>
            @endIf
            <div id="accordion" class="d-lg-none d-block my-3">
                @if($request_list->count())
                    @foreach($request_list as $item)
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6 col-5">
                                {{ ucwords($item['first_name']." ".$item['last_name']) }}
                            </div>

                            <div class="col-sm-4 col-5 text-right">
                                <a href="#" class="f12 attachment_btn">
                                    @If($item['status'] == 1)
                                    <a href="#" class="pending_btn f12" data-id="{{ $item['rec_id'] }}" data-toggle="modal" data-target="#pending_withdrawn">Pending</a>
                                    @else
                                    <span class="activate_btn">Success</span>
                                    @endIf
                                </a>
                            </div>

                            <div class="col-2 text-right">
                                <a class="card-link" data-toggle="collapse" href="#collapse{{ $loop->iteration }}">
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                    <div id="collapse{{ $loop->iteration }}" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row my-1">
                                <div class="col-5 text-blue">Date</div>
                                <div class="col-1">:</div>
                                <div class="col-6">
                                    @php
                                        echo \App\Http\Controllers\home\ReportController::convertTimezone($item['request_date']);
                                    @endphp
                                </div>
                            </div>

                            <div class="row my-1">
                                <div class="col-5 text-blue">Request Amount(USD)</div>
                                <div class="col-1">:</div>
                                <div class="col-6">{{ number_format($item['request_amt'],2) }}</div>
                            </div>

                            <div class="row my-1">
                                <div class="col-5 text-blue">Wallet Type</div>
                                <div class="col-1">:</div>
                                <div class="col-6"><div class="comission_blue font16 font-bold">{{ $item['wallet_type'] }}</div></div>
                            </div>
                        </div>
                    </div>
                </div>
                    @endforeach
                @else
                    <div class="w100 norecord_txt">No Records Found</div>
                @endif
            </div>

            @if($request_list->total()>0)
                {{ $request_list->appends(['from_date' => '', 'to_date' => ''])->links() }}
            @endIf
        </section>
    </div>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")

    <!-- pending withdrawn request starts -->
    <div class="modal fade" id="pending_withdrawn" tabindex="-1" role="dialog" aria-labelledby="pending_withdrawn" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <h5 class="modal-title font-bold black_txt text-uppercase f20" id="exampleModalLongTitle">Pending withdrawn request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body add_edit_user pb-4">
                    <div class="text-center font-bold f16 green_txt" id="successMsg" ></div>
                    <div class="text-center f20 black_txt py-5 mb-5">
                        <!-- Credit Crypto amount -->
                        <div class="form-group">
                            <input type="text" class="form-control border-bottom-only body_bg" id="credit_crypto_amt" name="credit_crypto_amt"
                                aria-describedby="credit_crypto_amt" placeholder="Credit Crypto amount" value="{{ old('credit_crypto_amt') }}" ><div class="text-left f14"><span class="f14" id="cryptoAmtErr"></span></div>
                            <div class="text-right f14"><span class="text-danger">*</span><span id="credit_crypto_amt"
                                    class="text-muted f14 black_txt">Credit Crypto amount</span></div>
                        </div>

                        <!-- Transaction Hash -->
                        <div class="form-group">
                            <input type="text" class="form-control border-bottom-only body_bg" id="transaction_hash"  name="transaction_hash"
                                aria-describedby="transaction_hash" placeholder="Transaction Hash" value="{{ old('transaction_hash') }}">
                            <div class="text-left f14"><span class="f14" id="transactionHashErr"></span></div>
                            <div class="text-right f14">
                            <span class="text-danger">*</span><span id="transaction_hash" class="text-muted f14 black_txt">Transaction Hash</span></div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="rec_id" id="rec_id" value="">
                <!-- footer buttons -->
                <div class="inline-buttons">
                    <button type="button" class="btn inline-buttons-left cancel-btn" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn inline-buttons-right create-btn save-withdrawn-btn" >Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- pending withdrawn request ends -->

    <script type="text/javascript">
	 var url = "<?php echo url('/withdrawRequestedList/'); ?>";

	 /* filter data */
	 $("#filter_data").click(function(e){
		e.preventDefault();
		var from_date = $("#from_date").val().trim();
		var to_date = $("#to_date").val().trim();
        if(from_date == '' || to_date == '') {
            alert('Please select both from and to date');
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

    $(".pending_btn").click(function(e) {
        e.preventDefault();
        var rec_id = $(this).attr('data-id');
        $("#rec_id").val(rec_id);
    });

    $(".save-withdrawn-btn").click(function(e) {
        e.preventDefault();
        var credit_crypto_amt = $("#credit_crypto_amt").val().trim();
        var transaction_hash = $("#transaction_hash").val().trim();
        var id = $("#rec_id").val().trim();
        var error = false;
        if(credit_crypto_amt == ''){
            $("#cryptoAmtErr").html('Credit Crypto amount Required');
            error = true;
        }else{
            $("#cryptoAmtErr").html('');
        }
        if(transaction_hash == ''){
            $("#transactionHashErr").html('Transaction Hash Required');
            error = true;
        }else{
            $("#transactionHashErr").html('');
        }
        console.log(error);
        if(!error){
            var csrf_Value= "{{  csrf_token()  }}";
            $.ajax({
                url: "{{  url('/').'/updateWithdrawPaymentRequest' }}",
                method: 'POST',
                dataType: "json",
                data: {'id': id,"_token": csrf_Value,'credit_crypto_amt': credit_crypto_amt, 'transaction_hash' : transaction_hash },
                success: function(data){
                    if(data.status == 'Success') {
                        $("#credit_crypto_amt").val('');
                        $("#transaction_hash").val('');
                        $("#pending_withdrawn").modal('hide');
                        setTimeout(function() {
                            swal({
                                title: "Success",
                                text: data.Result,
                                type: "success"
                            }).then(function() {
                                location.href="<?php echo url('/withdrawRequestedList');?>";
                            });
                        }, 50);
                    } else{
                        swal(
                            'Failure',
                            'Something went wrong',
                            'error'
                        )
                    }
                }
            });
        }
    });

    $("#credit_crypto_amt").keyup(function() {
        var $this = $(this);
        $this.val($this.val().replace(/[^\d.]/g, ''));
    });
	</script>
</body>
</html>

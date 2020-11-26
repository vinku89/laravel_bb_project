<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Customer Activation</title>
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
        .cancel_btn{
            background-color: #fb7800;
            color: #fff;
            text-decoration: none;
            padding: 3px 10px;
            border-radius: 3px;
            cursor: default;
        }
        .cancel_btn:hover{
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
            <h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3">Customer Activation</h5>
            <!-- Filter section -->
            <div class="filter_wrp col-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label font16 dark-grey_txt small_resolution" style="line-height: 36px;">From</label>
                                    <div class="col-sm-9 pl-0">
                                        <div id="fromDate" class="input-group date  m-0"
                                            data-date-format="mm-dd-yyyy">
                                            <input class="form-control datepicker_input" type="text" readonly id="from_date" value="<?php echo $from_date;?>"/>
                                            <span class="input-group-addon calender_icon"><i class="far fa-calendar-alt"></i></span>
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
                        <div class="row">
                            <div class="col-sm-3 col-6 pl-0">
                                <a href="javascript::void(0);" class="print_btn" id="filter_data">
                                    Filter
                                </a>
                            </div>
                            <div class="col-sm-3 col-6 pl-0">
                                <a href="javascript::void(0);" class="print_btn" id="clear_filter_data">
                                    Clear
                                </a>
                            </div>
                            <div class="col-sm-6 mt-3 mt-sm-0 pl-0">
                                <a href="<?php echo url('/updateOrderFromAdmin');?>" class="btn btn_primary d-block">Update Order</a>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
            <!-- Filter section End-->
            <div class="grid_wrp d-none d-lg-block">
                <div class="grid_header clearfix pt-3 pb-3">
                    <div class="w10 float-left font16 font-bold blue_txt">Date</div>
                    <div class="w26 float-left font16 font-bold blue_txt pl-2">Full Name <br> ( User Id )</div>
                    <div class="w26 float-left font16 font-bold blue_txt text-left ">Email Id</div>
                    <div class="w16 float-left font16 font-bold blue_txt text-right">Sales Amount<br>(USD)</div>
                    <div class="w12 float-left font16 font-bold blue_txt text-left pl-3">Purchased From</div>
                    <div class="w10 float-left font16 font-bold blue_txt text-right pr-3">Activate</div>
                </div>
            </div>
            <div class="middle_box clearfix d-none d-lg-block">
                <div class="grid_wrp">

                    <?php $sales = 0; ?>
                    <div class="grid_body clearfix">
                        @if($request_list->count())
                            @foreach($request_list as $item)
                            <!-- Row 1 -->
                            <?php
                                if($item['id'] == 11){
                                    continue;
                                }
                                $sales += $item['effective_amount']; ?>
                            <div class="grid_row clearfix border-bottom">
                                <div class="w10 float-left font16 dark-grey_txt position-relative">
                                    @php
                                        echo \App\Http\Controllers\home\ReportController::convertTimezone($item['purchased_date']);
                                    @endphp
                                </div>
                                <div class="w26 float-left font16 dark-grey_txt pl-2">{{ $item['first_name']." ".$item['last_name'] }}<br>( {{ $item['user_id'] }} )</div>
                                <div class="w26 float-left font16 text-left">
                                    {{ $item['email'] }}
                                </div>
                                <div class="w16 float-left font16 green_txt  text-right">{{ number_format($item['effective_amount'],2) }}</div>

                                <div class="w12 float-left font16 dark-grey_txt text-left pl-3">{{ $item['purchased_from'] }}</div>
                                <div class="w10 float-left font16 dark-grey_txt text-right pr-3">
                                    @If($item['status'] == 1)
                                    <a href="<?php echo url('/subscribePackage').'/'.base64_encode($item['rec_id']);?>" class="pending_btn">Pending</a>
                                    @elseIf($item['status'] == 3)
                                    <a href="#" class="cancel_btn">Cancelled</a>
                                    @else
                                    <a href="#" class="activate_btn">Activated</a>
                                    @endIf
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="w100 norecord_txt">No Records Found</div>
                        @endIf
                    </div>
                </div>
            </div>
            @If($request_list->count()>0)
            <div class="total_calc_wrp clearfix d-none d-lg-block">
                <div class="w10 float-left">&nbsp;</div>
                <div class="w26 float-left">&nbsp;</div>
                <div class="w26 float-left">&nbsp;</div>
                <div class="w16 green_txt font-bold text-right font16 float-left">{{ number_format($sales,2) }}</div>
                <div class="w12 float-left">&nbsp;</div>
                <div class="w10 grey_txt font-bold text-right font16 float-left pr-3">&nbsp;</div>
            </div>
            @endIf

            <div id="accordion" class="d-lg-none d-block my-3">

            @if($request_list->count())
                @foreach($request_list as $item)

                 <?php
                        if($item['id'] == 11){
                            continue;
                        }
                    ?>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6 col-5">
                                {{ $item['first_name']." ".$item['last_name'] }}
                            </div>

                            <div class="col-sm-4 col-5">
                                @If($item['status'] == 1)
                                <a href="<?php echo url('/subscribePackage').'/'.base64_encode($item['rec_id']);?>" class="pending_btn f12">Pending</a>
                                @else
                                <a href="#" class="activate_btn f12">Activated</a>
                                @endIf
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
                                        echo \App\Http\Controllers\home\ReportController::convertTimezone($item['purchased_date']);
                                    @endphp
                                </div>
                            </div>

                            <div class="row my-1">
                                <div class="col-5 text-blue">User Id</div>
                                <div class="col-1">:</div>
                                <div class="col-6">{{ $item['user_id'] }}</div>
                            </div>

                            <div class="row my-1">
                                <div class="col-5 text-blue">Email Id</div>
                                <div class="col-1">:</div>
                                <div class="col-6">{{ $item['email'] }}</div>
                            </div>

                            <div class="row my-1">
                                <div class="col-5 text-blue">Sales Amount(USD)</div>
                                <div class="col-1">:</div>
                                <div class="col-6">{{ number_format($item['effective_amount'],2) }}</div>
                            </div>

                            <div class="row my-1">
                                <div class="col-5 text-blue">Purchased From</div>
                                <div class="col-1">:</div>
                                <div class="col-6">{{ $item['purchased_from'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach
            @else
                <div class="w100 norecord_txt">No Records Found</div>
            @endIf

            </div>

            @if($request_list->total()>0)
                {{ $request_list->appends(['from_date' => '', 'to_date' => ''])->links() }}
            @endIf

        </section>
    </div>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")

    <script type="text/javascript">
     var url = "<?php echo url('/customerActivation'); ?>";

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

    </script>
</body>
</html>

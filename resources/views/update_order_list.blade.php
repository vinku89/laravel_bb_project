    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Update Order List</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @if($userInfo['user_role'] == 4)
        @include("customer.inc.all-styles")
    @else
        @include("inc.styles.all-styles")
    @endIf
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
        .attachment_btn{
        background-color: #007bff;
        display: inline-block;
        border-radius: 30px;
        padding: 5px;
        line-height: 17px;
    }

    .attachment_btn{
        width:30px !important
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
            <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item f16">
                    <a href="{{ ($userInfo->user_role == 1) ? url('/updateOrderFromAdmin') : url('/updateOrderDetails') }}" class="f16 position-relative pl-3">
                        <i class="fas fa-angle-left"></i>
                        Update Order
                     </a>
            </li>
                <li class="breadcrumb-item active f16" aria-current="page" class="f16">Orders History</li>
            </ol>
            <h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3">Orders History</h5>
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
                               <!--  @if($userInfo->user_role == 1)
                                    <a href="{{ url('/updateOrderFromAdmin') }}" class="btn btn_primary px-4 d-block">Update Order</a>
                                @else
                                    <a href="{{ url('/updateOrderFromAdmin') }}" class="btn btn_primary px-4 d-block">Update Order</a>
                                @endIf -->
                            </div>
                        </div>



                    </div>
                </div>
            </div>
            <!-- Filter section End-->
            <div class="grid_wrp d-lg-block d-none">
                <div class="grid_header clearfix pt-3 pb-3">
                    <div class="w20 float-left font16 font-bold blue_txt">Date</div>
                    <div class="w25 float-left font16 font-bold blue_txt pl-2">User Name</div>
                    <div class="w27 float-left font16 font-bold blue_txt ">Email</div>
                    <div class="w18 float-left font16 font-bold blue_txt text-left pl-3">Order/Reference Id</div>
                    <div class="w10 float-left font16 font-bold blue_txt text-right pr-3">Attachment</div>
                </div>
            </div>
            <div class="middle_box clearfix d-lg-block d-none">
                <div class="grid_wrp">

                    <div class="grid_body clearfix">
                        @if($ordersList->count())
                            @foreach($ordersList as $item)
                            <div class="grid_row clearfix border-bottom">
                                <div class="w20 float-left font16 dark-grey_txt position-relative">
                                     @php
                                        echo \App\Http\Controllers\home\ReportController::convertTimezone($item['purchased_date']);
                                    @endphp
                                </div>
                                <div class="w25 float-left font16 dark-grey_txt pl-2 word-break-all">{{ ucwords($item['first_name']." ".$item['last_name']) }}<br><span class="f12">{{ $item['user_id'] }}</span></div>
                                <div class="w27 float-left font16  dark-grey_txt word-break-all">{{ $item['email'] }}</div>
                                <div class="w18 float-left font16 dark-grey_txt text-left pl-3">{{ $item['order_id'] }}</div>
                                <div class="w10 float-left font16 dark-grey_txt pr-3 text-center">
                                    @if(!empty($item['attachment']))
                                    <a href="{{ url('/public/invoices').'/'.$item['attachment'] }}" target="_blank" class="f12 attachment_btn">
                                        <img src="{{ url('/') }}/public/customer/images/attachment.png" class="img-fluid">
                                    </a>
                                    @else
                                        {{ '-' }}
                                    @endIf

                                </div>
                            </div>
                            @endforeach
                        @else
                        <div class="text-center norecord_txt">No records found!</div>
                        @endif
                    </div>
                </div>
            </div>

            <div id="accordion" class="d-lg-none d-block my-3">

                @if($ordersList->count())
                    @foreach($ordersList as $item)
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6 col-5">
                                {{ ucwords($item['first_name']." ".$item['last_name']) }}
                            </div>

                            <div class="col-sm-4 col-5 text-right">
                                @if(!empty($item['attachment']))
                                <a href="{{ url('/public/invoices').'/'.$item['attachment'] }}" target="_blank" class="f12 attachment_btn">
                                    <img src="{{ url('/') }}/public/customer/images/attachment.png" class="img-fluid">
                                </a>
                                 @else
                                    {{ '-' }}
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
                                <div class="col-5 text-blue">Email</div>
                                <div class="col-1">:</div>
                                <div class="col-6">{{ $item['email'] }}</div>
                            </div>

                            <div class="row my-1">
                                <div class="col-5 text-blue">Order/Reference Id</div>
                                <div class="col-1">:</div>
                                <div class="col-6">{{ $item['order_id'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach
            @else
                <div class="text-center norecord_txt">No records found!</div>
            @endif

            </div>

            @if($ordersList->total()>0)
                {{ $ordersList->appends(['from_date' => '', 'to_date' => ''])->links() }}
            @endIf
        </section>
    </div>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")

    <script type="text/javascript">
        var url = "<?php echo url('/updatedOrdersList'); ?>";

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

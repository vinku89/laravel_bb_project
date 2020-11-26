<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Commission Report Details</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include("inc.styles.all-styles")
    <style>
        @media (max-width:1360px) {
            .md_resolution .font16 {
                font-size: 14px !important;
            }

            .grid_wallet_icon {
                top: 21px !important;
                left: -10px !important;
            }
        }
        .fa-angle-left{
            font-size: 20px;
            line-height: 25px;
            margin-right: 5px;
            color: #0091d6;
        }
    </style>
</head>

<body>
    <!-- <div class="overlay-bg"></div> -->
    <!-- Side bar include -->
    @include("inc.sidebar.sidebar")
    <div class="main-content commission_report_details">
        <!-- Header Section Start Here -->
        @include("inc.header.header")
        <!-- Header Section End Here -->
        <section class="main_body_section scroll_div">
            <!-- <h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3">Commission Report Details</h5> -->
            <ol class="breadcrumb pl-0">
                <i class="fas fa-angle-left"></i>
                <li class="breadcrumb-item"><a href="{{ url('/').'/commissionReport' }}">Commission Report</a></li>
                <li class="breadcrumb-item active">Commission Report Details</li>
            </ol>

            <!-- Agent Info section here -->
            <div class="middle_box clearfix py-4 px-5 mb-3 mid_box_wrp">
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <h5 class="mb-0 font-bold black_txt font16 mt-3 mb-2">{{ ucwords($userData->first_name." ".$userData->last_name) }}</h5>
                        <h5 class="mb-0 dark-grey_txt font16 res_txt_align">Agent ID: <span class="text-uppercase">{{ $userData->user_id }}</span></h5>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                            <h5 class="font-bold font16 black_txt text-right pb-3 textLeft">Total Sale Amount (USD)</h5>
                            <h3 class="font-bold font25 blue_txt text-right xsmall_txt_align">{{ number_format($userData->sales_amount,2) }}</h3>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <h5 class="font-bold font16 black_txt text-right pb-3 textLeft">Total Commission Amount (USD)</h5>
                            <h3 class="font-bold font25 green_txt text-right xsmall_txt_align">{{ number_format($userData->commission,2) }}</h3>
                    </div>
                </div>
            </div>
            <!-- Agent Info section End -->

            <!-- Filter section -->
            <div class="filter_wrp col-12">
                <div class="row">
                    <div class="col-lg-6 col-md-8 xsmall-pad">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label font16 dark-grey_txt small_resolution"
                                        style="line-height: 36px;">From</label>
                                    <div class="col-sm-9">
                                        <div id="fromDate" class="input-group date  m-0" data-date-format="mm-dd-yyyy">
                                            <input class="form-control datepicker_input" type="text" readonly  id="from_date" value="{{ $from_date }}"/>
                                            <span class="input-group-addon calender_icon"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label font16 dark-grey_txt small_resolution"
                                        style="line-height: 36px;">To</label>
                                    <div class="col-sm-9">
                                        <div id="toDate" class="input-group date  m-0" data-date-format="mm-dd-yyyy">
                                            <input class="form-control datepicker_input" type="text" readonly  id="to_date" value="{{ $to_date }}"/>
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


                        <!--<select id="normal_select" class="select-wrp">
                            <option value="This Week">All Commission %</option>
                            <option value="Commission">Commission</option>
                            <option value="Commission">Commission</option>
                            <option value="Commission">Commission</option>
                            <option value="Commission">Commission</option>
                        </select>
                         <a href="" class="print_btn float-right">Print
                            <i class="fas fa-print"></i>
                        </a> -->
                    </div>
                </div>
            </div>
            <!-- Filter section End-->
            <div class="middle_box clearfix">
                <div class="grid_wrp">
                    <div class="grid_header clearfix border-bottom pt-3 pb-3 resp_header">
                        <div class="w20 float-left font16 font-bold blue_txt">Date</div>
                        <div class="w30 float-left font16 font-bold blue_txt pl-2 d-none d-md-block">Descriptions</div>
                        <div class="w16 float-left font16 font-bold blue_txt text-right d-none d-md-block">Sale Amount<br>(USD)</div>
                        <div class="w16 float-left font16 font-bold blue_txt text-center  sm_view">Commission %</div>
                        <div class="xs_view w16 float-left font16 font-bold blue_txt text-center">Com %</div>
                        <div class="w18 float-left font16 font-bold blue_txt text-right pr-3 sm_view">Commission
                            <br>Amount(USD)
                        </div>
                        <div class="xs_view w18 float-left font16 font-bold blue_txt text-right pr-3">Com (USD)</div>
                    </div>
                    <div id="accordion">
                        <?php $total_sales_amount = 0;
                        $total_commision_amount = 0;
						$key =1;
                    ?>
                    <div class="grid_body clearfix">
                    @if($commissionReports->count())
                        @foreach($commissionReports as $item)
                        <?php
                            $total_sales_amount += $item->sales_amount;
                            $total_commision_amount += $item->commission;
                        ?>
                        <!-- Row 1 -->
                        <div class="grid_row clearfix md_resolution desktopView">
                            <div class="w20 float-left font16 dark-grey_txt position-relative">
                                @php
                                    echo \App\Http\Controllers\home\ReportController::convertTimezone($item['added_date']);
                                @endphp
                                <!-- <i class="icon-group grid_wallet_icon"></i> -->
                            </div>
                            <div class="w30 float-left font16 dark-grey_txt pl-2">{{ ($item['description']!='') ? $item['description'] : '-' }}</div>
                            <div class="w16 float-left font16 green_txt  text-right">{{ number_format($item['sales_amount'],2) }}</div>
                            <div class="w16 float-left font16 text-center">
                                <div class="comission_blue font16 font-bold">{{ $item['commission_perc'] }}</div>
                            </div>
                            <div class="w18 float-left font16 blue_txt text-right pr-3">{{ number_format($item['commission'],2) }}</div>
                        </div>
                        <!-- Mobile Responsive section -->
                            <div class="card responsive_view">
                                <div class="mb-0">
                                    <a class="collapsed grid_row clearfix" data-toggle="collapse" href="#collapse-{{ $key }}" aria-expanded="false" aria-controls="collapse-{{ $key }}">
                                        <div class="w50 float-left font16 dark-grey_txt position-relative">
                                            @php
                                            echo
                                            \App\Http\Controllers\home\ReportController::convertTimezone($item['added_date']);
                                            @endphp
                                            <!-- <i class="icon-group grid_wallet_icon"></i> -->
                                        </div>

                                        <div class="w20 float-left font16 text-center">
                                            <div class="comission_blue font16 font-bold">{{ $item['commission_perc'] }}
                                            </div>
                                        </div>
                                        <div class="w25 float-left font16 blue_txt text-right pr-3">
                                            {{ number_format($item['commission'],2) }}</div>
                                        <div class="w5 float-left font16 blue_txt text-right ">
                                            <i class="fas fa-chevron-down"></i>
                                            <i class="fas fa-chevron-up"></i>
                                        </div>
                                    </a>
                                </div>

                                <div  id="collapse-{{ $key }}" class="collapse content_div" data-parent="#accordion" aria-labelledby="heading-2">
                                    <div class="card-body">
                                        <ul>
                                            <li class="li_width float-left">Description</li>
                                            <li class="dark-grey_txt ml150">{{ ($item['description']!='') ? $item['description'] : '-' }}</li>
                                            <li class="li_width float-left">Sale Amount</li>
                                            <li class="dark-grey_txt ml150"> {{ number_format($item['sales_amount'],2) }}</li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
							<?php
							 $key++;
							?>
                             <!--ENd     Mobile Responsive section -->
                        @endforeach
                        @else
                            <div class="w100 norecord_txt">No Records Found</div>
                        @endif
                    </div>
                </div>
            </div>
            @if($commissionReports->count()>0)
            <div class="total_calc_wrp clearfix bal_responsive_view">
                <div class="w20 float-left desktopView">&nbsp;</div>
                <div class="w30 float-left desktopView">&nbsp;</div>
                <div class="w16 green_txt font-bold text-right font16 float-left desktopView">{{ number_format($total_sales_amount,2) }}</div>
                <div class="w16 float-left desktopView">&nbsp;</div>
                <div class="w18 blue_txt font-bold text-right font16 float-left pr-3">{{ number_format($total_commision_amount,2) }}</div>
            </div>
            @endIf
            @if($commissionReports->total()>0)
               {{ $commissionReports->appends(['from_date' => '', 'to_date' => ''])->links() }}
            @endIf
        </section>
    </div>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")
    <script type="text/javascript">
     var url = "<?php echo url('/commissionReportDetails/'.$userID.'/'.$referenceID); ?>";

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

    /*$(document).ready(function(){
        $("#fromDate").datepicker({
            autoclose: true,
            todayHighlight: true,
            endDate: "today"
        });

        $("#toDate").datepicker({

            autoclose: true,
            todayHighlight: true,
            startDate : $(this).datepicker('getDate'),
            endDate: "today"
        });
    });*/



   /* $(document).ready(function () {

        $("#fromDate").datepicker({
            autoclose: true,
            dateFormat: "dd-M-yy",
            minDate: 0
        }).on("changeDate", function (e) {
            var dt2 = $('#toDate');
            var startDate = $(this).datepicker('getDate');
            var minDate = $(this).datepicker('getDate');
            var dt2Date = dt2.datepicker('getDate');
            var dateDiff = (dt2Date - minDate)/(86400 * 1000);
            startDate.setDate(startDate.getDate() + 30);
            if (dt2Date == null || dateDiff < 0) {
                    dt2.datepicker('setDate', minDate);
            }
            else if (dateDiff > 30){
                    dt2.datepicker('setDate', startDate);
            }
            dt2.datepicker('option', 'maxDate', startDate);
            dt2.datepicker('option', 'minDate', minDate);

        });

        $('#toDate').datepicker({
            dateFormat: "dd-M-yy",
            minDate: 0
        });
    });*/

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

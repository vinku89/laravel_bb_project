<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Direct Sales</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
     @include("inc.styles.all-styles")
</head>
<body>
    <!-- Side bar include -->
    @include("inc.sidebar.sidebar")
    <div class="main-content sales_transaction">
        <!-- Header Section Start Here -->
         @include("inc.header.header")
        <!-- Header Section End Here -->
        <section class="main_body_section scroll_div">

            <!-- Page Title Section 1 Mobile fixed -->
            <h5 class="f22 font-bold text-uppercase black_txt py-4 text-center text-sm-left">Direct Sales</h5>
            <!-- Page Title Section 1 Mobile End -->

            <!-- Section 2 Mobile fixed -->
            <div class="row filter_wrp">

                <!-- Calender from -->
                <div class="col-6 col-sm-4 col-md-4 col-xl-4">
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-xl-3 col-form-label font16 dark-grey_txt small_resolution" style="line-height: 36px;">From</label>
                        <div class="col-12 col-sm-8 col-xl-9 pl-lg-0">
                            <div id="fromDate" class="input-group date  m-0" data-date-format="mm-dd-yyyy">
                                <input class="form-control datepicker_input" type="text" readonly id="from_date" value="<?php echo $from_date;?>"/>
                                <span class="input-group-addon calender_icon"><i
                                        class="far fa-calendar-alt"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-4 col-xl-4">
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-xl-3 col-form-label font16 dark-grey_txt small_resolution"
                            style="line-height: 36px;">To</label>
                        <div class="col-12 col-sm-8 col-xl-9 pl-lg-0">
                            <div id="toDate" class="input-group date  m-0"
                                data-date-format="mm-dd-yyyy">
                                <input class="form-control datepicker_input" type="text" readonly id="to_date" value="<?php echo $to_date;?>"/>
                                <span class="input-group-addon calender_icon"><i
                                        class="far fa-calendar-alt"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Calender to end-->

                <!-- Filter btn -->
                <div class="col-6 col-sm-2 px-md-1 mb-3 mb-sm-0">
                    <a href="javascript::void(0);" class="print_btn" id="filter_data">
                        Filter
                    </a>
                </div>

                <!-- Clear btn -->
                <div class="col-6 col-sm-2 px-md-1 mb-3 mb-sm-0">
                    <a href="javascript::void(0);" class="print_btn" id="clear_filter_data">
                        Clear
                    </a>
                </div>

            </div>
            <?php
                if($userInfo['admin_login'] != 1){
                    $w1 = 'w20';$w2 = 'w30';$w3 = 'w16';$w4 = 'w16';$w5 = 'w18';
                }else{
                    $w1 = 'w20';$w2 = 'w48';$w3 = 'w32';$w4 = '';$w5 = '';
                }
            ?>
            <!-- Filter section End-->
            <div class="grid_wrp d-none d-lg-block">
                <div class="grid_header clearfix pt-3 pb-3">
                    <div class="{{ $w1 }} float-left font16 font-bold blue_txt">Date</div>
                    <div class="{{ $w2 }} float-left font16 font-bold blue_txt pl-3">Descriptions</div>
                    <div class="{{ $w3 }} float-left font16 font-bold blue_txt text-right">Sale Amount<br>(USD)</div>
                    @If($userInfo['admin_login'] != 1)
                    <div class="{{ $w4 }} float-left font16 font-bold blue_txt text-center ">Commission %</div>
                    <div class="{{ $w5 }} float-left font16 font-bold blue_txt text-right pr-3">Commission
                        <br>Amount(USD)
                    </div>
                    @endIf
                </div>
            </div>

            <div class="middle_box clearfix d-none d-lg-block">
                <div class="grid_wrp">

                    <?php $total_sales_amount = 0;
                        $total_commision_amount = 0;?>
                    <div class="grid_body clearfix">
                        @if($directSales->count())
                        @foreach($directSales as $item)
                            <!-- Row 1 -->
                            <?php
                            $total_sales_amount += $item['sales_amount'];
                            $total_commision_amount += $item['commission'];
                            ?>
                            <div class="grid_row clearfix">
                                <div class="{{ $w1 }} float-left font16 dark-grey_txt position-relative">
                                     @php
                                        echo \App\Http\Controllers\home\ReportController::convertTimezone($item['added_date']);
                                    @endphp
                                    <!-- <i class="icon-group grid_wallet_icon"></i> -->
                                </div>
                                <div class="{{ $w2 }} float-left font16 dark-grey_txt pl-3">{{ ($item['description'] != '') ? $item['description'] : '-' }}</div>
                                <div class="{{ $w3 }} float-left font16 green_txt  text-right">{{ number_format($item['sales_amount'],2) }}</div>
                                @If($userInfo['admin_login'] != 1)
                                <div class="{{ $w4 }} float-left font16 text-center">
                                    <div class="comission_blue font16 font-bold">{{ $item['commission_per'] }}</div>
                                </div>
                                <div class="{{ $w5 }} float-left font16 dark-grey_txt text-right pr-3">{{ number_format($item['commission'],2) }}</div>
                                @endIf
                            </div>
                            @endforeach
                        @else
                            <div class="w100 norecord_txt">No Records Found</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Table details Mobile view fixed -->

            <!-- Titles -->
            <div class="grid_wrp d-block d-lg-none">
                <div class="grid_header clearfix pt-3 pb-3">
                    <div class="w33 float-left font12 font-bold blue_txt">Date</div>
                    <div class="w34 float-left font12 font-bold blue_txt text-center ">Commission %</div>
                    <div class="w33 float-left font12 font-bold blue_txt text-right pr-3">Commission
                        <br>Amount(USD)
                    </div>
                </div>
            </div>

            <div class="accordion-container d-lg-none">
				<?php
						$total_sales_amount = 0;
                        $total_commision_amount = 0;
				?>
				 @if($directSales->count())
                        @foreach($directSales as $item)
					<?php
                            $total_sales_amount += $item['sales_amount'];
                            $total_commision_amount += $item['commission'];
                            ?>
                <div class="set">
                    <a href="#">
                        <div class="row">
                            <div class="col-4">
                                <div class="set_user f12">
									@php
                                        echo \App\Http\Controllers\home\ReportController::convertTimezone($item['added_date']);
                                    @endphp
								</div>
                            </div>
                            <div class="col-4 text-center pr-5"><span class="comission_blue d-inline-block f12 mt-2 py-1">{{ $item['commission_per'] }}</span></div>
                            <div class="col-4 text-right pr-5"><span class="d-inline-block f12 mt-2 py-1">{{ number_format($item['commission'],2) }}</span></div>
                        </div>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <div class="content p-3">
                        <div class="row my-1">
                            <div class="col-4 f12 font-bold">Description</div>
                            <div class="col-1">:</div>
                            <div class="col-7 f12"> {{ ($item['description'] != '') ? $item['description'] : '-' }} </div>
                        </div>

                        <div class="row my-1">
                            <div class="col-4 f12 font-bold">Sale Amount </div>
                            <div class="col-1">:</div>
                            <div class="col-7 f12">{{ number_format($item['sales_amount'],2) }}</div>
                        </div>
                    </div>
                </div>
				@endforeach
                        @else
				<div class="w100 norecord_txt">No Records Found</div>
                        @endif

            </div>
            <!-- Table details Mobile view End -->

            @if($directSales->count()>0)
            <div class="total_calc_wrp clearfix d-none d-lg-block">
                <div class="w20 float-left">&nbsp;</div>
                <div class="w30 float-left">&nbsp;</div>
                <div class="w16 green_txt font-bold text-right font16 float-left">{{ number_format($total_sales_amount,2) }}</div>
                <div class="w16 float-left">&nbsp;</div>
                <div class="w18 grey_txt font-bold text-right font16 float-left pr-3">{{ number_format($total_commision_amount,2) }}</div>
            </div>

            <div class="total_calc_wrp clearfix d-block d-lg-none">
                <div class="w50 black_txt font-bold text-left font12 float-left">Total Commission</div>
                <div class="w50 grey_txt font-bold text-right font12 float-left pr-5">{{ number_format($total_commision_amount,2) }}</div>
            </div>
            @endIf
            @if($directSales->total()>0)
                <?php echo $directSales->appends(['from_date' => '', 'to_date' => ''])->links();?>
            @endIf
        </section>
    </div>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")
    <script type="text/javascript">
     var url = "<?php echo url('/directSales'); ?>";

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
    <script>
            $(document).ready(function() {
                $(".set > a").on("click", function() {
                    if ($(this).hasClass("active")) {
                    $(this).removeClass("active");
                    $(this)
                        .siblings(".content")
                        .slideUp(200);
                    $(".set > a i")
                        .removeClass("fa-angle-up")
                        .addClass("fa-angle-down");
                    } else {
                    $(".set > a i")
                        .removeClass("fa-angle-up")
                        .addClass("fa-angle-down");
                    $(this)
                        .find("i")
                        .removeClass("fa-angle-down")
                        .addClass("fa-angle-up");
                    $(".set > a").removeClass("active");
                    $(this).addClass("active");
                    $(".content").slideUp(200);
                    $(this)
                        .siblings(".content")
                        .slideDown(200);
                    }
                });
            });
        </script>
</body>
</html>

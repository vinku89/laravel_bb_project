<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Referral Dashboard</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- Styles -->
    <link href="<?php echo url('/');?>/public/css/customer/app.css" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/bsnav.css" rel="stylesheet">
    <!-- All old styles include -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css?q=<?php echo rand();?>">
    <link rel="stylesheet" href="<?php echo url('/');?>/public/customer/css/customer-style.css?q=<?php echo rand();?>">
    <link rel="stylesheet" href="<?php echo url('/');?>/public/customer/css/global.css?q=<?php echo rand();?>">
    <link rel="stylesheet" href="<?php echo url('/');?>/public/css/share.css?q=<?php echo rand();?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet"
        type="text/css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <!-- Mobile Responsive styles -->
    <link rel="stylesheet"
        href="<?php echo url('/');?>/public/customer/css/customer_resoponsive.css?q=<?php echo rand();?>">

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
                <section class="customer_main_body_section scroll_div col-12">
                    <!-- border -->
                    <hr class="grey-dark">

                    <!-- Summary heading -->
                    <h5 class="font22 font-bold text-white py-4">Referral</h5>

                    <div class="row">
                        <div class="col-12 referral-summary clearfix">
                            <div class="referral-summary-left">
                                <div class="f16 font-bold">Referral Earnings</div>
                                <div class=""><span
                                        class="purple_txt font32 font-bold">$<?php echo $total_referred_earnings; ?></span>
                                </div>
                            </div>
                            <div class="referral-summary-right">
                                <div class="row">
                                    <div class="col-6 col-md-12 text-left text-md-center">
                                        <div class="f16 font-bold lh-sm-45">Total Referral</div>
                                    </div>
                                    <div class="col-6 col-md-12 text-right text-md-center">
                                        <div class=""><span
                                                class="purple_txt font32 font-bold"><?php echo $total_referrals; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Summary heading End -->

                    <div class="row my-4">
                        <!-- Filter section -->
                        <div class="filter_wrp col-12">
                            <div class="row">
                                <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                    <div class="row">
                                        <div class="col-sm-4 col-lg-4 col-xl-4">
                                            <div class="mb-3 position-relative">
                                                <input type="text" class="form-control h50 pl-5"
                                                    placeholder="E-mail/Refferal ID" aria-label="E-mail"
                                                    aria-describedby="basic-addon1" id="searchKey"
                                                    value="<?php echo ($searchKey)?$searchKey:""; ?>">
                                                <span class="addon-icon"><img
                                                        src="<?php echo url('/');?>/public/images/search.png"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-lg-4 col-xl-4">
                                            <div class="form-group row">
                                                <label for=""
                                                    class="col-sm-3 d-block d-sm-none d-lg-block col-form-label font16  small_resolution text-white"
                                                    style="line-height: 36px;">From</label>
                                                <div class="col-sm-12 col-lg-9 px-3 pl-md-0">
                                                    <div id="fromDate" class="input-group date  m-0"
                                                        data-date-format="mm-dd-yyyy">
                                                        <input class="form-control datepicker_input" type="text"
                                                            readonly id="from_date"
                                                            value="<?php echo ($from_date)?$from_date:""; ?>" />
                                                        <span class="input-group-addon calender_icon"><i
                                                                class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-lg-4 col-xl-4">
                                            <div class="form-group row">
                                                <label for=""
                                                    class="col-sm-3 d-block d-sm-none d-lg-block col-form-label font16 small_resolution text-white"
                                                    style="line-height: 36px;">To</label>
                                                <div class="col-sm-12 col-lg-9 px-3 pl-md-0">
                                                    <div id="toDate" class="input-group date  m-0"
                                                        data-date-format="mm-dd-yyyy">
                                                        <input class="form-control datepicker_input" type="text"
                                                            readonly id="to_date"
                                                            value="<?php echo ($to_date)?$to_date:""; ?>" />
                                                        <span class="input-group-addon calender_icon"><i
                                                                class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 text-right">
                                    <div class="row">
                                        <div class="col-6">
                                            <a href="javascript::void(0);" class="print_btn" id="filter_data">
                                                Filter
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="javascript::void(0);" class="print_btn" id="clear_filter_data">
                                                Clear
                                            </a>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <!-- Filter section End-->
                    </div>

                    <div class="clearfix mt-2">
                        <div class="row">
                            <div class="col-12">

                                <div class="table_div clearfix">
                                    <div
                                        class="font16 purple_txt font-bold table_div_head clearfix d-none d-lg-block">
                                        <div class="font16 purple_txt font-bold w20 table_div_cell">Date</div>
                                        <div class="font16 purple_txt font-bold w25 table_div_cell">Name</div>
                                        <div class="font16 purple_txt font-bold w15 table_div_cell">Referral ID</div>
                                        <div class="font16 purple_txt font-bold w25 table_div_cell">Email</div>
                                        <div class="font16 purple_txt font-bold text-md-right w15 table_div_cell">
                                            Referral Earnings <br> (USD)</div>

                                    </div>

                                    <div class="font16 purple_txt font-bold body_bg table_div_head clearfix d-lg-none">
                                        <div class="font16 purple_txt font-bold w30 table_div_cell">Date</div>
                                        <div class="font16 purple_txt font-bold w30 table_div_cell">Name</div>
                                        <div class="font16 purple_txt font-bold text-right w40 table_div_cell">Total
                                            Referral Earnings (USD)</div>
                                    </div>

                                    <div class="d-none d-lg-block">
                                        <?php
                                $total_earned_amt = 0;
                                if(!empty($refferalsList)){
                                    foreach($refferalsList as $res){
                                        $total_earned_amt += $res->commission;
                                     ?>
                                        <div class="grid_wrp">
                                            <div class="grid_body clearfix">
                                                <!-- Row 1 -->

                                                <div class="grid_row clearfix agent_row new_cell">
                                                    <div class="w20 float-left font16  px-2">
                                                        <?php echo date('d.m.Y H:i a',strtotime($res->added_date)); ?>
                                                    </div>
                                                    <div class="w25 float-left font16 px-2">
                                                        <?php echo ucwords($res->first_name.' '.$res->last_name); ?>
                                                    </div>
                                                    <div class="w15 float-left font16 px-2 word-break-all">
                                                        <?php echo $res->refferallink_text; ?></div>
                                                    <div class="w25 float-left font16 px-2 word-break-all">
                                                        <?php echo $res->email; ?></div>
                                                    <div class="w15 float-left font16 green_txt text-right px-2">
                                                        +<?php echo number_format($res->commission,2); ?>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                        <?php  } ?>

                                        <!-- Footer -->

                                        <div class="grid_wrp">
                                            <div class="grid_body clearfix">
                                                <!-- Row 1 -->
                                                <div class="grid_row clearfix agent_row text-white">
                                                    <div class="w20 float-left font16  px-2">
                                                        &nbsp
                                                    </div>
                                                    <div class="w25 float-left font16  px-2">
                                                        &nbsp
                                                    </div>
                                                    <div class="w15 float-left font16  px-2">
                                                        &nbsp
                                                    </div>

                                                    <div class="w25 float-left font16  px-2">
                                                        TOTAL
                                                    </div>
                                                    <div
                                                        class="w15 font-bold text-right float-left font16 px-2">
                                                        <?php echo number_format($total_earned_amt,2);?>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <?php }else{ ?>

                                        <div class="text-center norecord_txt">No records found!</div>
                                        <?php    }?>
                                        <!-- pagination -->
                                        <div class="">
                                            <?php
                                        if($refferalsList->total()>0){
                                            echo $refferalsList->appends(['searchKey' =>'', 'from_date' => '', 'to_date' => '' ])->links();

                                        }
                                    ?>

                                        </div>

                                    </div>

                                    <!-- Table details Mobile view fixed -->
                                    <div class="accordion-container d-lg-none mt-2">
                                        <?php
                                $total_earned_amt = 0;
                                if(!empty($refferalsList)){
                                    foreach($refferalsList as $res){
                                        $total_earned_amt += $res->commission;
                                     ?>
                                        <div class="set">
                                            <a href="#">
                                                <div class="row">
                                                    <div class="w30 px-3">
                                                        <div class="set_user f12">
                                                            <?php echo date('d.m.Y H:i a',strtotime($res->added_date)); ?>
                                                        </div>
                                                    </div>

                                                    <div class="w30 px-3">
                                                        <div class="set_user f12">
                                                            <?php echo ucwords($res->first_name.' '.$res->last_name); ?>
                                                        </div>
                                                    </div>

                                                    <div class="w40 px-3 text-right"><span href="#"
                                                            class="blue_txt d-inline-block f14 mt-2 py-1 mr-4">+<?php echo number_format($res->commission,2); ?></span>
                                                    </div>
                                                </div>
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <div class="content p-3">
                                                <div class="row my-1">
                                                    <div class="col-4 f12 font-bold">Referral ID</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-7 f12"> <?php echo $res->refferallink_text; ?>
                                                    </div>
                                                </div>

                                                <div class="row my-1">
                                                    <div class="col-4 f12 font-bold">Email</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-7 f12"> <?php echo $res->email; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php  }  ?>
                                        <?php }else{ ?>

                                        <div class="text-center norecord_txt">No records found!</div>
                                        <?php    }?>

                                        <!-- pagination -->
                                        <div class="">
                                            <?php
                                            if($refferalsList->total()>0){
                                                echo $refferalsList->appends(['searchKey' =>'', 'from_date' => '', 'to_date' => '' ])->links();
                                                //echo $refferalsList->render();
                                            }
                                        ?>

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

    @include('inc.v2.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
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


        var url = "<?php echo url('/getReferralsList'); ?>";

        /*$("#searchKey").on('keypress',function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == 13){
                $("#from_date").val('');
                $("#to_date").val('');
                var searchKey = $("#searchKey").val();
                location.href = url+'?searchKey='+searchKey+'&from_date=&to_date=&page=0';
            }
        });*/


        /* filter data */
        $("#filter_data").click(function (e) {
            e.preventDefault();

            var from_date = $("#from_date").val().trim();
            var to_date = $("#to_date").val().trim();
            var searchKey = $("#searchKey").val().trim();
            //alert(searchKey);return false;
            if ((searchKey == '') && (from_date == '' || to_date == '')) {
                alert('Please select atleast one filter');
                return false;
            } else if (to_date < from_date) {
                alert('To date should be grater than From Date');
                return false;
            } else {
                var searchUrl = url + '?searchKey=' + searchKey + '&from_date=' + from_date + '&to_date=' +
                    to_date;
                location.href = searchUrl;
            }
        });

        /* clear filter data */
        $("#clear_filter_data").click(function (e) {
            e.preventDefault();
            //alert("test");
            $("#from_date").val('');
            $("#to_date").val('');
            var searchKey = $("#searchKey").val().trim();

            //var searchUrl = url+'?searchKey='+searchKey+'&from_date=&to_date=&page=0';
            location.href = "<?php echo url('/getReferralsList'); ?>";

        });
    </script>

    <script>
        $(document).ready(function () {
            $(".set > a").on("click", function () {
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

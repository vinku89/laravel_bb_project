<?php
$res = \App\Users_tree::where("reseller_id", $userInfo['rec_id'])->where("customer_id", "!=", 0)->where("agent_id", "=", 0)->orderBy("rec_id", "DESC")->get();
$arr = array();
foreach ($res as $val) {
    array_push($arr, $val->customer_id);
}
$cur_date = date('Y-m-d H:i:s');

$cur_date = date('Y-m-d');
$to_seven = date('Y-m-d', strtotime($cur_date . ' +7 days'));
$to_three = date('Y-m-d', strtotime($cur_date . ' +3 days'));
$to_two = date('Y-m-d', strtotime($cur_date . ' +2 days'));
$to_one = date('Y-m-d', strtotime($cur_date . ' +1 day'));

$seven_days_expire = \App\User::rightJoin(\DB::raw('(SELECT * FROM package_purchased_list WHERE rec_id IN (SELECT MAX(rec_id) AS id FROM package_purchased_list WHERE package_id != 11 AND active_package=1 GROUP BY user_id) ORDER BY user_id) AS t2'), function($join) {
        $join->on('users.rec_id', '=', 't2.user_id');
    })->leftjoin('packages', 't2.package_id', '=', 'packages.id')->where(['users.email_verify'=>1])->whereIn('users.rec_id', $arr)->select('t2.rec_id AS pRec_id','users.rec_id')->whereBetween("t2.expiry_date",[$cur_date,$to_seven])->groupBy('users.user_id')->get();

$three_days_expire = \App\User::rightJoin(\DB::raw('(SELECT * FROM package_purchased_list WHERE rec_id IN (SELECT MAX(rec_id) AS id FROM package_purchased_list WHERE package_id != 11 AND active_package=1 GROUP BY user_id) ORDER BY user_id) AS t2'), function($join) {
        $join->on('users.rec_id', '=', 't2.user_id');
    })->leftjoin('packages', 't2.package_id', '=', 'packages.id')->where(['users.email_verify'=>1])->whereIn('users.rec_id', $arr)->select('t2.rec_id AS pRec_id','users.rec_id')->whereBetween("t2.expiry_date",[$cur_date, $to_three])->groupBy('users.user_id')->get();

$two_days_expire = \App\User::rightJoin(\DB::raw('(SELECT * FROM package_purchased_list WHERE rec_id IN (SELECT MAX(rec_id) AS id FROM package_purchased_list WHERE package_id != 11 AND active_package=1 GROUP BY user_id) ORDER BY user_id) AS t2'), function($join) {
        $join->on('users.rec_id', '=', 't2.user_id');
    })->leftjoin('packages', 't2.package_id', '=', 'packages.id')->where(['users.email_verify'=>1])->whereIn('users.rec_id', $arr)->select('t2.rec_id AS pRec_id','users.rec_id')->whereBetween("t2.expiry_date",[$cur_date, $to_two])->groupBy('users.user_id')->get();

$one_days_expire = \App\User::rightJoin(\DB::raw('(SELECT * FROM package_purchased_list WHERE rec_id IN (SELECT MAX(rec_id) AS id FROM package_purchased_list WHERE package_id != 11 AND active_package=1 GROUP BY user_id) ORDER BY user_id) AS t2'), function($join) {
        $join->on('users.rec_id', '=', 't2.user_id');
    })->leftjoin('packages', 't2.package_id', '=', 'packages.id')->where(['users.email_verify'=>1])->whereIn('users.rec_id', $arr)->select('t2.rec_id AS pRec_id','users.rec_id')->whereBetween("t2.expiry_date",[$cur_date, $to_one])->groupBy('users.user_id')->get();

$expired = \App\User::rightJoin(\DB::raw('(SELECT * FROM package_purchased_list WHERE rec_id IN (SELECT MAX(rec_id) AS id FROM package_purchased_list WHERE package_id != 11 AND active_package=1 GROUP BY user_id) ORDER BY user_id) AS t2'), function($join) {
        $join->on('users.rec_id', '=', 't2.user_id');
    })->leftjoin('packages', 't2.package_id', '=', 'packages.id')->where(['users.email_verify'=>1])->whereIn('users.rec_id', $arr)->select('t2.rec_id AS pRec_id','users.rec_id')->where('t2.expiry_date','<',NOW())->groupBy('users.user_id')->get();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Dashboard</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include("inc.styles.all-styles")
    <style type="text/css">
        .highcharts-credits {
            display: none !important;
        }
        .dk-selected {
            height: 44px !important;
            line-height: 44px !important;
        }
        .dk-option {
            height: 35px !important;
            line-height: 35px !important;
        }

    </style>

 @include ("inc/google_language")
</head>
<body>
    <!-- Side bar include -->
    @include("inc.sidebar.sidebar")

    <div class="main-content">
        <!-- Header Section Start Here -->
        @include("inc.header.header")
        <!-- Header Section End Here -->
        <section class="main_body_section scroll_div">
            <div class="div_item clearfix col-12">
                <div class="row">
                    <div class="col-md-6 col-xs-12 text-center">
                    <ul>
                        <li class="pl-0">Login :</li>
                        <li class="font16 dark-grey_txt">
                            <i class="calandar_icon icon-group"></i>
                            <span id="get_cur_date">&nbsp;</span>
                        </li>
                        <li class="font16 dark-grey_txt">
                            <i class="watch_icon icon-group"></i>
                            <span id="get_cur_time">&nbsp;</span>
                        </li>
                    </ul>
                    </div>
                    <div class="col-md-6 col-xs-12 text-center">
                    <div class="float-right font12 dark-grey_txt" style="line-height:24px;">
                        <span id="last_visited"></span>
                    </div>
                    </div>
                </div>
            </div>

            <div class="middle_box clearfix">
                <div class="wallet-balance_bg col-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 bb_div1">
                            <div class="row">
                                <div class="mr-auto balance_wrap">
                                    <span>
                                        <img src="<?php echo  url('/');?>/public/images/wallet.png?q=<?php echo rand();?>" class="wallet-icon">
                                        <h5 class="wallet-title font16 black_txt font-bold text-uppercase">My wallet balance
                                        </h5>
                                    </span>
                                </div>
                                <div class="ml-auto text-right amount_wrp">
                                    <span>
                                        <h1 class="bigFont">${{ number_format($wallet['amount'],2) }}</h1>
                                        <!-- <span class="font20 font-bold display-inline">USD</span> -->
                                    <span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 bb_div2 dashboard_main_btns p-0 {{ $userInfo['user_role'] == 1 ? 'transf_btns' : '' }}">

                                @If($userInfo['user_role'] != 4 && $userInfo['user_role'] != 1)
                                    <a href="<?php echo url('/withdrawal');?>" class="btn_wrap">Transfer To Wallet</a>
                                @endIf

                                @If($userInfo['user_role'] == 1)
                                    <a href="<?php echo url('/amountTransferToWallet');?>" class="btn_wrap">Transfer To Wallet</a>
                                @endIf

                                @If($userInfo['user_role'] != 4 && $userInfo['user_role'] != 1)
                                    <a href="<?php echo url('/transferToCryptoWallet');?>" class="btn_wrap">Transfer To Crypto Wallet</a>
                                @endIf
                                <a href="<?php echo url('/payForMyFriend');?>" class="btn_wrap">Pay For My Friend</a>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="dashboard_all_values {{ $userInfo['user_role'] == 1 ? 'admin_boxes' : '' }}">
                            <div class="item_2">
                                <div class="row">
                                    <div class="col-9 ml-auto text-right font16 font-bold black_txt pt-3">Total Sales</div>
                                </div>
                                <div class="clearfix text-right my-2">
                                    <h2 class="font32 blue_txt font-bold display_inline">${{ $total_sales }}</h2>
                                    <!-- <span class="blue_txt font20 font-bold">USD</span> -->
                                </div>
                            </div>
                            <div class="item_2">
                                <div class="row">
                                    <div class="col-9 ml-auto text-right font16 font-bold black_txt pt-3">Total Commission</div>
                                </div>
                                <div class="clearfix text-right my-2">
                                    <h2 class="font32 blue_txt font-bold display_inline">${{ $total_commission }}</h2>
                                    <!-- <span class="blue_txt font20 font-bold">USD</span> -->
                                </div>
                            </div>
                                    <div class="col item_3 {{ $userInfo['user_role'] == 1 ? '' : 'd-none' }}">
                                        <div class="text-right font16 font-bold black_txt pt-3">Total Resellers</div>
                                        <h2 class="font32 blue_txt font-bold text-right my-2">{{ $resellers_cnt }}</h2>
                                    </div>
                                    <div
                                        class="col item_3 {{ $userInfo['user_role'] == 1 || $userInfo['user_role'] == 2 ? '' : 'd-none' }}">
                                        <div class="text-right font16 font-bold black_txt pt-3">Total Agents</div>
                                        <h2 class="font32 blue_txt font-bold text-right my-2">{{ $agents_cnt }}</h2>
                                    </div>
                                    <div
                                        class="col item_3 {{ $userInfo['user_role'] == 1 || $userInfo['user_role'] == 2 || $userInfo['user_role'] == 3 ? '' : 'd-none' }}">
                                        <div class="text-right font16 font-bold black_txt pt-3">Total Customers</div>
                                        <h2 class="font32 blue_txt font-bold text-right my-2">{{ $customers_cnt }}</h2>
                                    </div>
                                    <div
                                        class="col item_3 {{ $userInfo['user_role'] == 1 || $userInfo['user_role'] == 2 || $userInfo['user_role'] == 3 ? '' : 'd-none' }}">
                                        <div class="text-right font16 font-bold black_txt pt-3">Total Accounts</div>
                                        <h2 class="font32 blue_txt font-bold text-right my-2">{{ $accounts_cnt }}</h2>
                                    </div>
                        </div>
                    </div>

                    <div class="clearfix py-3">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <select id="date_search" class="normal_select">
                                        <option value="Week">This Week</option>
                                        <option value="1">1 Month</option>
                                        <option value="3">3 Months</option>
                                        <option value="6">6 Months</option>
                                        <option value="12">12 Months</option>
                                    </select>
                                </div>
                                <div class="col-6 text-right">
                                    <div class="sales_btn font16 green_txt font-bold">
                                        <img src="<?php echo url('/');?>/public/images/sales_btn_dot.png?q=<?php echo rand();?>" class="mr-2">
                                        Sales
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="svg_chart_div text-center">
                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                    </div>

                     <!-- Section 4 -->
                    <div class="row mt-3 mb-2">
                        <div class="col-xl-2 col-lg-12 Aligner">
                            <h5 class="page-main-title font-bold m-0 text-left primary-txt w-100 pl-3">Subscription Expiry</h5>
                        </div>
                        <div class="col-xl-10 col-lg-12 p-0 px-xl-2">
                            <div class="admin_dashboard_elements">
                                <div class="col-xl-cell5 col-md-4 col-sm-6 pr-2 my-2">
                                    <a href="{{ url('/activeLine') }}?days=7&page=0" class="button_item section-4-link1 w-100 Aligner">7 Days ({{ sizeof($seven_days_expire) }})</a>
                                </div>
                                <div class="col-xl-cell5 col-md-4 col-sm-6 px-2 my-2">
                                    <a href="{{ url('/activeLine') }}?days=3&page=0" class="button_item section-4-link2 Aligner">3 Days ({{ sizeof($three_days_expire) }})</a>
                                </div>
                                <div class="col-xl-cell5 col-md-4 col-sm-6 px-2 my-2">
                                <a href="{{ url('/activeLine') }}?days=2&page=0"  class="button_item section-4-link3 Aligner">2 Days ({{ sizeof($two_days_expire) }})</a>
                                </div>
                                <div class="col-xl-cell5 col-md-6 col-sm-6 px-2 my-2">
                                    <a href="{{ url('/activeLine') }}?days=1&page=0" class="button_item section-4-link4 Aligner">1 Day ({{ sizeof($one_days_expire) }})</a>
                                </div>
                                <div class="col-xl-cell5 col-md-6 col-sm-6 px-2 my-2">
                                <a  href="{{ url('/activeLine') }}?status=2&page=0" class="button_item section-4-link5 Aligner">Expired ({{ sizeof($expired) }})</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="font16 font-bold text-uppercase black_txt p-3 pt-4">Recent sale transactions</h5>
                    <div class="grid_wrp">
                        <div class="grid_header clearfix dashboard_tble_header">
                            <div class="w20 float-left font16 font-bold blue_txt">Date</div>
                            <div class="w25 float-left font16 font-bold blue_txt pl-2">Descriptions</div>
                            <div class="w20 float-left font16 font-bold blue_txt text-right">Sale Amount</br>(USD)</div>
                            <div class="w15 float-left font16 font-bold blue_txt text-right">Commission %</div>
                            <div class="w20 float-left font16 font-bold blue_txt text-right">Commission</br>Amount (USD)
                            </div>
                        </div>
                        <div class="grid_body clearfix dashboard_table">
                            <?php
                                foreach ($directSales as $val) {
                            ?>
                            <div class="grid_row clearfix">
                                <div class="w20 float-left font16 grey_txt position-relative">
                                    <p class="mobile_txt_view">Date</p>
                                    @php
                                        echo \App\Http\Controllers\home\ReportController::convertTimezone($val->added_date);
                                    @endphp
                                    <!-- <i class="icon-group grid_wallet_icon"></i> -->
                                </div>
                                <div class="w25 float-left font16 grey_txt pl-2">
                                <p class="mobile_txt_view">Descriptions</p>
                                    <?php echo $val->description; ?>
                                </div>
                                <div class="w20 float-left font16 green_txt text-right div_padding">
                                    <p class="mobile_txt_view">Sale Amount (USD)</p>
                                    <?php echo number_format($val->sales_amount,2); ?>
                                </div>
                                <div class="w15 float-left font16 grey_txt text-right">
                                <p class="mobile_txt_view">Commission %</p>
                                    <div class="comission_blue font16 font-bold">
                                        <?php echo number_format($val->commission_per); ?>%</div>
                                </div>
                                <div class="w20 float-left font16 grey_txt text-right">
                                <p class="mobile_txt_view">Commission Amount (USD)</p>
                                    <?php echo number_format($val->commission,2); ?>
                                </div>
                            </div>
                            <?php   }
                            ?>
                        </div>
                        <div class="{{ count($directSales) > 1 ? 'd-none' : '' }} text-center norecord_txt">No records found!</div>
                        <div class="clearfix my-2 text-right pr-4 {{ count($directSales) < 5 ? 'd-none' : '' }}">
                            <a href="<?php echo url('/directSales');?>" class="font16 blue_txt font-bold">Show all
                                Transactions</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.4/jstz.min.js">
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            var tz = jstz.determine(); // Determines the time zone of the browser client
            var timezone = tz.name(); //'Asia/Kolhata' for Indian Time.
            var csrf_Value = "<?php echo csrf_token(); ?>";
            $.post("check_time_zone", {
                "tz": timezone,
                "_token": csrf_Value
            }, function (data) {
                $("#get_cur_date").html(data.date);
                $("#get_cur_time").html(data.time);
                $("#last_visited").html(data.last_visited);
            });
        });

        function chartData(res) {
            console.log(res);
            Highcharts.chart('chartContainer', {
                title: {
                    text: 'Sales Chart'
                },
                xAxis: {
                    type: 'datetime',
                    dateTimeLabelFormats: {
                        day: '%d %b %Y' //ex- 01 Jan 2016
                    }
                },
                yAxis: {
                    title: {
                        text: 'Total Sales'
                    }
                },
                tooltip: {
                    formatter: function () {
                        return this.point.date +
                            '<br/>Sales: ' + Highcharts.numberFormat(this.point.y, 2) +
                            '<br/>Commission: ' + Highcharts.numberFormat(this.point.comm, 2);
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },
                series: [{
                     marker:{
                        fillColor:'#38b586'
                    },
                    name: 'Sales',
                    "data": res
                }],
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom'
                            }
                        }
                    }]
                }
            });
        }
        $("#date_search").change(function () {
            var val = $('option:selected', this).val();
            var token = "<?php echo csrf_token(); ?>";
            $.ajax({
                url: "<?php echo url('/');?>/chartData",
                method: 'POST',
                dataType: "json",
                data: {
                    'type': val,
                    '_token': token
                },
                success: function (data) {
                    chartData(data);
                }
            });
        });

        window.onload = function () {
          $(".menu_wrp_scroll").mCustomScrollbar({
          theme:"dark",
          mouseWheelPixels: 80,
          scrollInertia: 0
          });

          var data = <?php echo $dataPoints; ?> ;
            chartData(data);
        }
    </script>

</body>
</html>

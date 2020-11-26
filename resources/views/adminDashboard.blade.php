<?php
$res = \App\Users_tree::where("customer_id", "!=", 0)->orderBy("rec_id", "DESC")->get();
$arr = array();
foreach ($res as $val) {
    array_push($arr, $val->customer_id);
}
$cur_date = date('Y-m-d H:i:s');
//where(DB::raw('MAX(package_purchased_list.expiry_date) AS expiry_date',$symbol,Now()))

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
     @include("inc.styles.admin-styles")
     <style type="text/css">
         .highcharts-credits{
            display: none !important;
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
        <section class="main_body_section scroll_div admin">
            <!-- admin-page-title-section -->
            <div class="row mt-3 mb-2">
                <div class="col-12">
                    <div class="row">
                        <div class="col-xl-2 col-lg-12 Aligner">
                            <h2 class="page-main-title font-bold m-0 text-left">ADMIN DASHBOARD</h2>
                        </div>
                        <div class="col-xl-10 col-lg-12 p-0 px-xl-2">
                            <div class=" admin_dashboard_elements">
                                <div class="col-xl-cell5 col-md-4 col-sm-6 pr-2 my-2 d-none">
                                    <a href="{{ url('/pendingShipment') }}" class="button_item button_item_1 w-100 Aligner">Update Shipment Number</a>
                                </div>
                                <div class="col-xl-cell5  col-md-3 col-sm-6 px-2 my-2">
                                    <a href="{{ url('/updateOrderFromAdmin') }}" class="button_item button_item_2 Aligner" style="font-size:16px !important;">Update Aliexpress/Crypto Currency/Bank Payments Order Number</a>
                                </div>
                                <div class="col-xl-cell5  col-md-3 col-sm-6 px-2 my-2">
                                <a href="{{ url('/payForMyFriend') }}"  class="button_item button_item_3 Aligner">Pay For My Friends</a>
                                </div>
                                <div class="col-xl-cell5  col-md-3 col-sm-6 px-2 my-2">
                                    <a href="{{ url('/amountTransferToWallet') }}" class="button_item button_item_4 Aligner"> Transfer To Wallet</a>
                                </div>
                                <div class="col-xl-cell5  col-md-3 col-sm-6 px-2 my-2">
                                <a  href="{{ url('/customer-new') }}" class="button_item button_item_5 Aligner">Add New Customer</a>
                                </div>
								<?php
									$prospects_count = \App\Free_trail_requested_users::where("status","=",2)->count();
								?>
                                <div class="col-xl-cell5  col-md-3 col-sm-6 px-2 my-2">
                                <a  href="{{ url('/prospectsList') }}" class="button_item button_item_1 Aligner">Prospects <span class="ml-4"><?php echo ($prospects_count)?$prospects_count:0; ?></span></a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Total sales, Total Commission and withdrawal request -->
            <div class="row section-no-two">
                <div class="col-lg-4">
                    <div class="bg-white p-3 my-2 Aligner b-r-5">
                        <a  href="{{ url('/salesReport') }}" class="blue-txt section-no-two-title">Total <br> sales</a>
                        <div class="section-no-two-desc blue-txt"><span class="f40 font-bold">{{ $total_sales }}</span><span class="f20"> USD</span></div>
                        <!-- <div class="f12">&nbsp</div> -->
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="bg-white p-3 my-2 Aligner b-r-5">
                    	<a  href="{{ url('/commissionReport') }}" class="org-txt section-no-two-title">Total Paid Commission</a>
                        <div class="section-no-two-desc org-txt"><span class="f40 font-bold">{{ $total_commission }}</span><span class="f20"> USD</span></div>
                        <!-- <div class="f12">&nbsp</div> -->
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="bg-white p-3 my-2 Aligner b-r-5">
                    	<a  href="{{ url('/withdrawRequestedList') }}" class="grn-txt section-no-two-title">Withdrawal Request</a>
                        <div class="section-no-two-desc grn-txt"><span class="f40 font-bold">{{ $pending_withdraw_cnt }} </span><span class="f20">Pending</span></div>
                        <!-- <div class="f12">&nbsp</div> -->
                    </div>
                </div>
            </div>
            <!-- Total Customers, Total Resellers, Total Agents and chart -->
            <div class="row section-no-three">
                <div class="col-lg-4" id="left">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="px-3 py-4 mt-2 mb-3 blue-grid">
                                <div class="media">
                                    <div class="media-body">
                                        <div class="font-bold blue-grid-title">Total Customers</div>
                                        <div class="blue-grid-count"><span class="font-bold">{{ $customers_cnt }}</span></div>
                                        <div class="blue-grid-link"><a class="text-blue" href="<?php echo url('customers'); ?>">View Details</a></div>
                                    </div>
                                    <!-- <img src="<?php echo url('/'); ?>/public/admin/images/customers.png" class="ml-3 img-fluid" alt="..."> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="blue-grid px-3 py-4 mt-2 mb-3">
                                <div class="media">
                                    <div class="media-body">
                                        <div class="font-bold blue-grid-title">Total Accounts</div>
                                        <div class="blue-grid-count"><span class="font-bold">{{ $accounts_cnt }}</span></div>
                                        <div class="blue-grid-link"><a class="text-blue" href="<?php echo url('customers'); ?>">View Details</a></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="blue-grid px-3 py-4 mt-2 mb-3">
                                <div class="media">
                                    <div class="media-body">
                                        <div class="blue-grid-title font-bold">Total Resellers</div>
                                        <div class="blue-grid-count"><span class="font-bold">{{ $resellers_cnt }}</span></div>
                                        <div class="blue-grid-link"><a class="text-blue" href="<?php echo url('resellers'); ?>">View Details</a></div>
                                    </div>
                                    <!-- <img src="<?php echo url('/'); ?>/public/admin/images/resellers.png" class="ml-3 img-fluid" alt="..."> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="blue-grid px-3 py-4 mt-2 mb-3">
                                <div class="media">
                                    <div class="media-body">
                                        <div class="blue-grid-title font-bold">Total Agents</div>
                                        <div class="blue-grid-count"><span class="font-bold">{{ $agents_cnt }}</span></div>
                                        <div class="blue-grid-link"><a class="text-blue" href="<?php echo url('agents'); ?>">View Details</a></div>
                                    </div>
                                    <!-- <img src="<?php echo url('/'); ?>/public/admin/images/agents.png" class="ml-3 img-fluid" alt="..."> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="bg-white my-2" id="right">
                        <?php $cur_year = date('Y');?>
                        <div class="col-lg-2 offset-lg-10 py-3">
                            <select id="chart_year">
                                <?php for($i=$cur_year;$i>=$cur_year-1;$i--){?>
                                    <option value="<?php echo $i;?>" <?php if($i == $year) echo "selected";?>><?php echo $i;?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                       <!--  <img src="<?php echo url('/'); ?>/public/admin/images/sales_statistics.png" class="img-fluid"> -->
                    </div>
                </div>
            </div>

            <!-- Section 4 -->
            <div class="row mt-3 mb-2">
                <div class="col-12">
                    <div class="row">
                        <div class="col-xl-2 col-lg-12 Aligner">
                            <h5 class="page-main-title font-bold m-0 text-left primary-txt">Subscription Expiry</h5>
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
                                <div class="col-xl-cell5 col-md-6 col-sm-12 px-2 my-2">
                                <a  href="{{ url('/activeLine') }}?status=2&page=0" class="button_item section-4-link5 Aligner">Expired ({{ sizeof($expired) }})</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white">
                <div class="row mx-0">
                    <div class="col-md-6 bg-white py-2 text-md-left text-center">
                        <div class="admin-page-title">
                            <h5 class="page-main-title font-bold m-0 text-left primary-txt">Recent sale transactions</h5>
                        </div>
                    </div>

                    <div class="col-md-6 bg-white py-2">

                        <div class="d-flex justify-content-md-end justify-content-center" style="height: 100%; align-items: center;">
                            <a href="<?php echo url('/payForMyFriend');?>" class="button_primary d-block btn-rounded">Pay for my friend</a>
                        </div>

                    </div>
                </div>

                <div class="grid_wrp">
                    <div class="grid_header clearfix dashboard_tble_header border-bottom p-3">
                        <div class="w20 float-left font14 black_txt">Date</div>
                        <div class="w30 float-left font14 pl-2 black_txt">Descriptions</div>
                        <div class="w15 float-left font14 text-right black_txt">Sale Amount (USD)</div>
                        <div class="w15 float-left font14 text-right black_txt">Commission %</div>
                        <div class="w20 float-left font14 text-right black_txt">Commission Amount (USD)
                        </div>
                    </div>
                    <div class="grid_body clearfix dashboard_table">
                        <?php
                            foreach ($directSales as $val) {
                        ?>
                        <div class="grid_row clearfix">
                            <div class="w20 float-left font16 font-bold primary-txt position-relative">
                                <p class="mobile_txt_view">Date</p>
                                @php
                                    echo \App\Http\Controllers\home\ReportController::convertTimezone($val->added_date);
                                @endphp
                                <!-- <i class="icon-group grid_wallet_icon"></i> -->
                            </div>
                            <div class="w30 float-left font16 font-bold primary-txt pl-2">
                                <p class="mobile_txt_view">Descriptions</p>
                                <?php echo $val->description; ?>
                            </div>
                            <div class="w15 float-left font16 font-bold green_txt text-lg-right text-left div_padding">
                                <p class="mobile_txt_view">Sale Amount (USD)</p>
                                 <?php echo number_format($val->sales_amount,2); ?>
                            </div>
                            <div class="w15 float-left font16 font-bold primary-txt text-lg-right text-left">
                                <p class="mobile_txt_view">Commission %</p>
                                <div class="comission_blue font16 font-bold">
                                    <?php echo number_format($val->commission_per,2); ?>%</div>
                            </div>
                            <div class="w20 float-left font16 font-bold primary-txt text-lg-right text-left">
                                <p class="mobile_txt_view">Commission Amount (USD)</p>
                                <?php echo number_format($val->commission,2); ?>
                            </div>
                        </div>
                        <?php   }
                        ?>
                    </div>
                    <div class="{{ count($directSales) > 1 ? 'd-none' : '' }} text-center norecord_txt">No records found!</div>
                    <div class="clearfix my-3 text-right pr-4 {{ count($directSales) < 5 ? 'd-none' : '' }}">
                        <a href="<?php echo url('/directSales');?>" class="font16 font-bold d-block pb-4">Show all Transactions</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")
    <script>
        $(document).ready(function () {
            var height = Math.max($("#left").height(), $("#right").height());
            $("#left").height(height);
            $("#right").height(height);
        });

        Highcharts.setOptions({
			lang: {
				decimalPoint: '.',
	            thousandsSep: ','
			}
		});
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Sales Chart (<?php echo $year;?>)'
            },
            // subtitle: {
            //     text: 'Source: WorldClimate.com'
            // },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Sales / Commission (USD)'
                }
            },
            tooltip: {
            	yDecimals: 2,
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:,.2f} USD</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    dataLabels: {
		                enabled: true,
		                formatter: function () {
	                        return Highcharts.numberFormat(this.point.y, 2);
	                    }
		            }
                }
            },
            series: [{
                name: 'Sales',
                color: '#004a9c',
                data: <?php echo ($sales_data); ?>

            }, {
                name: 'Commission',
                color: '#65a6f0',
                data: <?php echo ($comm_data); ?>

            }]
        });

        $("#chart_year").change(function(){
            var year = $('option:selected',this).val();
            var url = "<?php echo url('/').'/dashboard/';?>";
            if(year !='') {
                location.href = url+year;
            }
        });
    </script>
</body>
</html>

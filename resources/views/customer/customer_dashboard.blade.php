<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX Dashboard</title>
    <link rel="shortcut icon" href="favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include('customer.inc.all-styles')
    <style>
        .displayNone {
            display: none !important;
        }
        .alert_icon {
            display: block;
            width: 100%;
            font-size: 40px;
            color: #fff;
        }
        .renew_btn {
            border: none;
            padding: 15px 0;
            background-color: #2d968c;
            font-weight: bold;
            color: #fff;
        }
        .renew_later_btn {
            float: left;
            border: none;
            padding: 15px 0;
            background-color: #aaaaaa;
            font-weight: bold;
        }

        .renew_later_btn {
            float: left;
            border: none;
            padding: 15px 0;
            background-color: #aaaaaa;
            font-weight: bold;
        }
        .renew_btn2 {
            border: none;
            padding: 15px 0;
            background-color: #ff5919;
            font-weight: bold;
            color: #fff
        }
        .custom_close {
            background: #fff;
            border: solid 2px red;
            font-weight: bold;
            font-size: 20px;
            border-radius: 30px;
            height: 25px;
            width: 26px;
            line-height: 19px;
            position: absolute;
            right: -10px;
            top: -10px;
        }
        .renew_btn2 a {
            color: #fff;
            display: block;
        }
        .renew_btn a {
            color: #fff;
            display: block;
        }
        .modHeader {
            background: black;
            border-radius: 30px 30px 0 0;
            background: url("../../../public/customer/images/Bestbox-popup-bg.png");
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain;
            width: 100%;
            padding: 12% !important;
            position: relative;
            top: -0.5vh;
            z-index: 0;
        }
        .modHeader h5 {
            color: #fff !important;
        }
    </style>
</head>
<body>
    <!-- Side bar include -->
    @include('inc.sidebar.sidebar')
    <div class="main-content customer_pannel customer-wr">
        <!-- Header Section Start Here -->
        @include('inc.header.header')
        <!-- Header Section End Here -->
        <section class="customer_main_body_section scroll_div p-0">
            <div class="container-fluid">
                <?php
					//echo $users_data['rec_id'];
					$subscribed_msg = session('subscribed_message');
					if(!empty($subscribed_msg))	{
						$vplayedClass = "";//"displayNone";
					}else{
						$vplayedClass = "";
					}
				?>
                <!-- Date, time and last login -->
                <div class="div_item clearfix text-center text-md-left row <?php echo $vplayedClass?>">
                    <div class="col-xl-6 col-md-7 col-sm-12">
                        <ul>
                            <li class="pl-0">Login :</li>
                            <li>
                                <i class="calandar_icon icon-group"></i>
                                <span id="get_cur_date"></span>
                            </li>
                            <li>
                                <i class="watch_icon icon-group"></i>
                                <span id="get_cur_time"></span>
                            </li>
                        </ul>
                    </div>
                    <div class="text-center text-md-right font12 black_txt col-xl-6 col-md-5 col-sm-12"
                        style="line-height:24px;">
                        <span id="last_visited"></span>
                    </div>
                </div>
                <!-- Date, time and last login End -->
                <div class="row mb-4 <?php echo $vplayedClass?>">
                    <div class="col-lg-3 mb-2">
                        <div class="middle_box ">
                            <div class="p-3 wallet-balance_bg clearfix">
                                <div class="balance_wrap pb-4">
                                    <img src="<?php echo url('/');?>/public/customer/images/my-wallet.png?q=<?php echo rand();?>"
                                        class="wallet-icon">
                                    <h5 class="wallet-title font16 black_txt font-bold text-uppercase">My wallet
                                        balance</h5>
                                </div>
                                <div class="text-right amount_wrp px-2 py-0">
                                    <h1 class="bigFont w-100">${{ $wallet->amount }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 mb-2">
                        <div class="middle_box ">
                            <div class="p-3 wallet-balance_bg clearfix">
                                <div class="balance_wrap pb-4">
                                    <img src="<?php echo url('/');?>/public/customer/images/referral-earnings.png?q=<?php echo rand();?>"
                                        class="wallet-icon">
                                    <h5 class="wallet-title font16 black_txt font-bold text-uppercase">Referral Earnings
                                    </h5>
                                </div>
                                <div class="text-right amount_wrp px-2 py-0">
                                    <h1 class="bigFont w-100"> ${{ number_format($referral_earnings,2) }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 mb-2 ">
                        <div class="middle_box ">
                            <div class="p-3 wallet-balance_bg clearfix">
                                <div class="balance_wrap pb-4">
                                    <img src="<?php echo url('/');?>/public/customer/images/total-referral.png?q=<?php echo rand();?>"
                                        class="wallet-icon">
                                    <h5 class="wallet-title font16 black_txt font-bold text-uppercase">Total Referral
                                    </h5>
                                </div>
                                <div class="text-right amount_wrp px-2 py-0">
                                    <h1 class="bigFont w-100">{{ $total_referral }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 mb-2">
                        <div class="middle_box ">
                            <div class="p-3 wallet-balance_bg clearfix">
                                <div class="balance_wrap pb-4">
                                    <img src="<?php echo url('/');?>/public/customer/images/pay-friend.png?q=<?php echo rand();?>"
                                        class="wallet-icon">
                                    <h5 class="wallet-title font16 black_txt font-bold text-uppercase">Pay for my friend
                                    </h5>
                                </div>
                                <div class="amount_wrp px-2 py-0">
                                    <a href="{{ url('/').'/payForMyFriend' }}" class="btn payFrnd_btn">Pay</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                $qry = \App\Free_trail_requested_users::where('user_id',$users_data['rec_id'])->count();
                @endphp
                @If(empty($users_data['package_name']) && ($qry == 0))
                <div class="req_trial_div col-12">
                    <div class="row">
                        <div class="col-xl-6 col-md-6">
                            <div class="div_item_wrp">
                                <div class="item_icon">
                                    <img src="<?php echo url('/');?>/public/customer/images/trial-circle-icon.png">
                                </div>
                                <div class="item_detail">
                                    <h5 class="font-weight-bold">Start Your Free Trial</h5>
                                    <h6>To start enjoying a wide range of content and channels from BestBOX</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 req_trial_btn_wrp">
                            <a href="{{ url('/freeTrailRequest') }}" class="btn req_trial_btn">Request Free Trial</a>
                        </div>
                    </div>
                </div>
                @endIf
                <?php
						$freetrial_qry = \App\Free_trail_requested_users::where('user_id',"=",$users_data['rec_id'])->first();
						if(!empty($freetrial_qry)){
							$statusMsg = $freetrial_qry->status;
							if($statusMsg == 0 || $statusMsg == 3){
								if($statusMsg == 0){
									$msgTxt = "Your Free trial request processing ... BestBOX Admin will approve soon."	;
								}else{
									$msgTxt = "Your Free Trial Request is approved, Please click on Start Now button to start the streaming";
								}
					?>
                <div class="req_trial_div col-12">
                    <div class="row">
                        <div class="col-xl-6 col-md-6">
                            <div class="div_item_wrp">
                                <div class="item_icon">
                                    <img src="<?php echo url('/');?>/public/customer/images/trial-circle-icon.png">
                                </div>
                                <div class="item_detail">
                                    <h5 class="font-weight-bold">Thank you</h5>
                                    <h6><?php echo $msgTxt; ?></h6>
                                </div>
                            </div>
                        </div>
                        <?php
								if($statusMsg == 3){
							?>
                        <div class="col-xl-6 col-md-6 req_trial_btn_wrp">
                            <a href="javascript::void(0)" class="btn req_trial_btn start_trial_btn"
                                data-id="<?php echo $users_data['rec_id']; ?>">Start Now</a>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } } ?>
                <div class="grid3 <?php echo $vplayedClass?>">
                    <div class="col-12 head_title">
                        <div class="row mb-3">
                            <div class="col-xl-cell5 col-md-cell5">
                                <h5>Registration Date</h5>
                            </div>
                            <div class="col-xl-cell5 col-md-cell5">
                                <h5>User ID</h5>
                            </div>
                            <div class="col-xl-cell5 col-md-cell5">
                                <h5>Package</h5>
                            </div>
                            <div class="col-xl-cell5 col-md-cell5">
                                <h5>Status</h5>
                            </div>
                            <div class="col-xl-cell5 col-md-cell5">
                                <h5>Renewal</h5>
                            </div>
                        </div>
                    </div>
                    <?php
                            $pkgdata = \App\Package_purchase_list::where('user_id',$users_data['rec_id'])->where('active_package',1)->where('package_id','!=',11)->orderBy('rec_id','DESC')->first();
                            if($pkgdata['expiry_date']){
                                $fdate = $pkgdata['expiry_date'];
                                $tdate = date('Y-m-d h:i:s');
                                $datetime1 = new DateTime($fdate);
                                $datetime2 = new DateTime($tdate);
                                $interval = $datetime1->diff($datetime2);
                                $days = $interval->format('%a');
                            }else{
                               $days = 8;
                            }
                            $qs = \App\Purchase_order_details::where('user_id',$users_data['rec_id'])->orderBy('rec_id','DESC')->first();
                            $pkgcnt = \App\Purchase_order_details::where('user_id',$users_data['rec_id'])->where('type',2)->count();
                        ?>
                    <div
                        class="users_info_wrp {{ ((($days < 3 || ( !empty($fdate) && $fdate < $tdate)) && $pkgdata['expiry_date'] != '') ? 'last-reminder' : (($days >= 3 && $days < 7 && $pkgdata['expiry_date'] != '') ? 'reminder' : '')) }}">
                        <div class="col-12">
                            <div class=" row">
                                <div class="col-lg-cell5 col-md-4  sm-border-bottom">
                                    <p class="small_device">Registration Date</p>
                                    <p>
                                        @php
                                        echo
                                        \App\Http\Controllers\home\ReportController::convertTimezone($users_data['registration_date']);
                                        @endphp
                                    </p>
                                </div>
                                <div class="col-lg-cell5 col-md-4 sm-pb-4 sm-border-bottom">
                                    <p class="small_device">User ID</p>
                                    <p>{{ $users_data['user_id'] }}</p>
                                </div>
                                <div class="col-lg-cell5 col-md-4 sm-pb-4 sm-border-bottom">
                                    <p class="small_device">Package</p>
                                    <p>
                                        @If(!empty($users_data['package_name']))
                                        {{ $users_data['package_name'] }}
                                        @else
                                        {{ '-' }}
                                        @endIf
                                    </p>
                                </div>
                                <div class="col-lg-cell5 col-md-6 position_relative  xs-border-bottom">
                                    <p class="small_device">Status</p>
                                    <p>
                                        @if($users_data['id'] != 11)
                                        @if(!empty($pkgdata) && $pkgdata['expiry_date'] != '')
                                        <div
                                            class="font16 inline-block {{ $pkgdata['expiry_date'] < NOW() ? 'label_expired' : 'label_active' }}">
                                        </div>
                                        <div class="text-left">Expiry :
                                            {{ date('d/m/Y',strtotime($pkgdata['expiry_date'])) }}</div>
                                        @else
                                        <div class="font16 inline-block">-</div>
                                        @endIf
                                        @else
                                        {{ '-' }}
                                        @endIf
                                    </p>
                                </div>
                                <div class="col-lg-cell5 col-md-6 position_relative ">
                                    <p class="small_device">Renewal</p>
                                    <div class=" text-left">
                                        @if($users_data['expiry_date'] != '' || (!empty($qs) && $qs->status == 3))
                                        <a href="{{ url('/').'/renewal/'.encrypt($users_data['rec_id']) }}"
                                            class="btn renewal_btn">Renew</a>
                                        @elseIf($users_data['id'] == 11)
                                        <a href="{{ url('/').'/renewal/'.encrypt($users_data['rec_id']) }}"
                                            class="btn renewal_btn">Renew</a>
                                        @elseIf(empty($users_data['id']))
                                        <p href="#" class="d-inline-block" style="color: #007bff">Not Subscribed</p>
                                        @elseIf(!empty($qs) && $qs->status == 1 && $pkgcnt >= 1 && $users_data['id'] !=
                                        11)
                                        <p href="#" class="d-inline-block text-center text_view">Renewal<br>Approval
                                            Pending</p>
                                        @elseIf(!empty($qs) && $qs->status == 1 && $pkgcnt == 0)
                                        <p href="#" class="d-inline-block text-center text_view">
                                            Subscription<br>Approval Pending</p>
                                        @else
                                        {{ '-' }}
                                        @endIf
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Expaire Soon less than 7 days -->
                    @foreach($subusers_data as $data)
                    <?php
                            $pkgdata = \App\Package_purchase_list::where('user_id',$data['rec_id'])->where('active_package',1)->where('package_id','!=',11)->orderBy('rec_id','DESC')->first();
                            if($pkgdata['expiry_date']){
                                $fdate = $pkgdata['expiry_date'];
                                $tdate = date('Y-m-d h:i:s');
                                $datetime1 = new DateTime($fdate);
                                $datetime2 = new DateTime($tdate);
                                $interval = $datetime1->diff($datetime2);
                                $days = $interval->format('%a');
                            }else{
                               $days = 8;
                            }
                            $qs = \App\Purchase_order_details::where('user_id',$data['rec_id'])->orderBy('rec_id','DESC')->first();
                            $pkgcnt = \App\Purchase_order_details::where('user_id',$data['rec_id'])->where('type',2)->count();
                        ?>
                    <div
                        class="users_info_wrp {{ ((($days < 3 || ( !empty($fdate) && $fdate < $tdate)) && $pkgdata['expiry_date'] != '') ? 'last-reminder' : (($days >= 3 && $days < 7 && $pkgdata['expiry_date'] != '') ? 'reminder' : '')) }}">
                        <div class="col-12">
                            <div class=" row">
                                <div class="col-lg-cell5 col-md-4  sm-border-bottom">
                                    <p class="small_device">Registration Date</p>
                                    <p>
                                        @php
                                        echo
                                        \App\Http\Controllers\home\ReportController::convertTimezone($data['registration_date']);
                                        @endphp
                                    </p>
                                </div>
                                <div class="col-lg-cell5 col-md-4  sm-border-bottom">
                                    <p class="small_device">User ID</p>
                                    <p>{{ $data['user_id'] }}</p>
                                </div>
                                <div class="col-lg-cell5 col-md-4  sm-border-bottom">
                                    <p class="small_device">Package</p>
                                    <p>{{ $data['package_name'] }}</p>
                                </div>
                                <div class="col-lg-cell5 col-md-6 position_relative  xs-border-bottom">
                                    <p class="small_device">Status</p>
                                    <p>
                                        @if($data['id'] != 11)
                                        @if(!empty($pkgdata) && $pkgdata['expiry_date'] != '')
                                        <div
                                            class="font16 inline-block {{ $pkgdata['expiry_date'] < NOW() ? 'label_expired' : 'label_active' }}">
                                        </div>
                                        <div class="text-left">Expiry :
                                            {{ date('d/m/Y',strtotime($pkgdata['expiry_date'])) }}</div>
                                        @else
                                        <div class="font16 inline-block">-</div>
                                        @endIf
                                        @else
                                        {{ '-' }}
                                        @endIf
                                    </p>
                                </div>
                                <div class="col-lg-cell5 col-md-6 position_relative ">
                                    <p class="small_device">Renewal</p>
                                    <div class=" text-left">
                                        @if($data['expiry_date'] != '')
                                        <a href="{{ url('/').'/renewal/'.encrypt($data['rec_id']) }}"
                                            class="btn renewal_btn">Renew</a>
                                        @elseIf($data['id'] == 11)
                                        <a href="{{ url('/').'/renewal/'.encrypt($data['rec_id']) }}"
                                            class="btn renewal_btn">Renew</a>
                                        @elseIf(!empty($qs) && $qs->status == 1 && $pkgcnt >= 1)
                                        <p href="#" class="d-inline-block text-center text_view">Renewal<br>Approval
                                            Pending</p>
                                        @elseIf(!empty($qs) && $qs->status == 1 && $pkgcnt == 0)
                                        <p href="#" class="d-inline-block text-center text_view">
                                            Subscription<br>Approval Pending</p>
                                        @else
                                        {{ '-' }}
                                        @endIf
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <br>
                <h2 class="font35 font-bold purple_txt mb-3">SUBSCRIPTION PLANS</h2>
                <!-- IPTV Box List -->
                <!-- ===============09-04-2020 =================-->
                <h3 class="font22 font-bold purple_txt mb-3 mt-4">BestBOX Package</h3>
                <!--========================== New Packages ===================-->
                <div class="col-12 p-0 row-flex mb-4">
                    @if(!empty($packages))
                    @foreach($packages as $iptv_box)
                    @if($iptv_box['setupbox_status'] == 2 && $iptv_box['vod_series_package'] == 1)
                    <!-- BVOD1 -->
                    <div class="bb_packages_wrapper">
                        <div class="bvod_priceTag">
                            <span class="info_link"><i class="fa fa-info-circle" aria-hidden="true" data-toggle="modal"
                                    data-target="#imp-note"></i></span>
                            <h2>{{ $iptv_box['package_name'] }}</h2>
                            <p> {{ $iptv_box['duration'] }}
                                MONTH{{ $iptv_box['duration'] >1 ? 'S' : ''}}</p>
                        </div>
                        <div class="bbox_inner_content_box">
                            <div class="cancel_price"></div>
                            <h2>
                                <span>$</span>{{ $iptv_box['effective_amount'] }}
                            </h2>
                            <p>( VOD + Series)</p>
                            <div class="package_btn_wrp">
                                <a href="/newbox/<?php echo encrypt($iptv_box['id']);?>"
                                    class="bbox_package_button orange">
                                    subscribe
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @endIf
                </div>
                <div class="col-12 p-0 row-flex mb-4">
                    @if(!empty($packages))
                    @foreach($packages as $iptv_box)
                    @if($iptv_box['setupbox_status'] == 2 && $iptv_box['vod_series_package'] == 0)
                    <!-- BBOX1 -->
                    <div class="bb_packages_wrapper active_box">
                        <div class="bbox_priceTag">
                            <span class="info_link"><i class="fa fa-info-circle" aria-hidden="true" data-toggle="modal"
                                    data-target="#imp-note"></i></span>
                            <?php $boxImage = 'bbox'.$iptv_box['duration'].'.png';?>
                            <img src="<?php echo url('/').'/public/customer/images/'.$boxImage;?>" alt="">
                            <ul class="bbox_include_prog">
                                <li>
                                    <i class="fa fa-stop" aria-hidden="true"></i>
                                    live
                                </li>
                                <li>
                                    <i class="fa fa-stop" aria-hidden="true"></i>
                                    vod
                                </li>
                                <li>
                                    <i class="fa fa-stop" aria-hidden="true"></i>
                                    series
                                </li>
                                <li>
                                    <i class="fa fa-stop" aria-hidden="true"></i>
                                    catch up
                                </li>
                            </ul>
                        </div>
                        <div class="bbox_inner_content_box">
                            @if($iptv_box['discount_by_amt']!=0)
                            <div class="cancel_price">
                                ${{ $iptv_box['package_value'] }}
                            </div>
                            <h2>
                                <span>$</span>{{ $iptv_box['effective_amount'] }}
                            </h2>
                            <h5>SAVE ${{ $iptv_box['discount_by_amt'] }}</h5>
                            @else
                            <h2 style="padding-top:30px;"><span>$</span>{{ $iptv_box['effective_amount'] }}</h2>
                            @endIf
                            <p class="text_puurple">{{ $iptv_box['duration'] }}
                                MONTH{{ $iptv_box['duration'] >1 ? 'S' : ''}}</p>
                            <div class="package_btn_wrp">
                                <a href="/newbox/<?php echo encrypt($iptv_box['id']);?>"
                                    class="bbox_package_button orange">
                                    subscribe
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @endIf
                </div>
                <h3 class="font22 font-bold purple_txt mb-3">IPTV Box</h3>
                <div class="col-12 p-0 row-flex ">
                    @if(!empty($packages))
                    @foreach($packages as $iptv_box)
                    @if($iptv_box['setupbox_status'] == 1)
                    <div class="new_iptvbox_wrp">
                        <div class="box_priceTag">
                            <span class="info_link"><i class="fa fa-info-circle" aria-hidden="true" data-toggle="modal"
                                    data-target="#imp-note"></i></span>
                            <h2><span>$</span>{{ $iptv_box['effective_amount'] }}</h2>
                            <ul class="include_prog">
                                <li>
                                    <i class="fa fa-stop" aria-hidden="true"></i>
                                    live
                                </li>
                                <li>
                                    <i class="fa fa-stop" aria-hidden="true"></i>
                                    vod
                                </li>
                                <li>
                                    <i class="fa fa-stop" aria-hidden="true"></i>
                                    series
                                </li>
                                <li>
                                    <i class="fa fa-stop" aria-hidden="true"></i>
                                    catch up
                                </li>
                            </ul>
                        </div>
                        <div class="inner_content_box">
                            <img src="<?php echo url('/').'/public/customer/images/iptvBox.png';?>" alt="BestBOX">
                            <p>
                                @if($iptv_box['duration'] !=0 && $iptv_box['duration'] != '')
                                <span class="sub_month">
                                    + {{ $iptv_box['duration'] }} MONTH{{ $iptv_box['duration'] >1 ? 'S' : ''}}
                                    SUBSCRIPTION
                                </span>
                                @endIf
                                {{ ucfirst($iptv_box['description']) }}
                            </p>
                            <a href="/newbox/<?php echo encrypt($iptv_box['id']);?>" class="package_button buy">
                                buy
                            </a>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @endIf
                </div>
                <!-- ===============END 09-04-2020 =================-->
            </div>
        </section>

        
    </div>
    <!-- Order User -->
    <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="orderNotify"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <h5 class="modal-title font-bold black_txt text-uppercase f20" id="exampleModalLongTitle">
                        Notification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body add_edit_user pb-4">
                    <div class="text-left f16 black_txt">
                        <p>Now for the last lap. 2 final steps:</p>
                        <p>1. You will be redirected to the Aliexpress App or Site. If you do not have an account with
                            Aliexpress, please sign up for an account.</p>
                        <p>2. Please finalize the purchase of your desired service and product. You will receive a
                            confirmation email summarizing your purchase. If you purchased a TV box, you will also
                            receive your tracking number.</p>
                    </div>
                </div>
                <!-- footer buttons -->
                <div class="inline-buttons">
                    <!-- <button type="button" class="btn inline-buttons-center btn_primary"><a href="" target="_blank"
                            id="purchaseUrl" style="color:#fff !important;">Proceed</a></button> -->
                    <a href="" class="btn inline-buttons-center btn_primary" target="_blank" id="purchaseUrl"
                        style="color:#fff !important;">Proceed</a>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal fade imp-note" id="imp-note">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal_bg">
                <!-- Modal Header -->
                <div class="modal-header" style="padding:15px 50px;    border-bottom-color: #ff903f;">
                    <h4 class="modal-title font-primary-book" style="font-weight:bold;">Important Note</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body font-primary-book" style="padding:30px 50px 50px 50px">
                    <p>Please note as AliExpress only sells products and not services. When buying a subscription it may
                        appear at first that you are purchasing a product,
                        in fact you are purchasing the BESTBOX streaming service, which you will receive access to
                        shortly after your transaction has been completed.
                        When you purchase the subscription with a BESTBOX TV box, the item will be shipped to your
                        shipping address and you will receive a
                        tracking number within 1-2 days upon purchase.</p>
                    <p>
                        During the purchase you will be asked to open an AliExpress account, just requires your email
                        address and a password
                        of your choice and will be valid for future purchases. After purchase you will receive an email
                        with your code details,
                        generally this will take a couple of hours so hold tight you will be up and running in no time.
                        All of this may seem heavy
                        but have a go, it is very easy and secure for card payment.
                    </p>
                    <p>
                        If you have any questions please dont hesitate to contact us.
                    </p>
                </div>
                <!-- Modal footer -->
                <!-- <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div> -->
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal" id="request_free_trial">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 30px !important;">
                <!-- Modal Header -->
                <div class="modal-header border-bottom-0" style="position: absolute; right: 10px;z-index:99;">
                    <button type="button" class="close" data-dismiss="modal"
                        style="color: #fff; font-size: 32px;">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body p-0">
                    <div class="text-center p-4 mb-4 modHeader">
                        <h5 class="font-weight-bold mb-0">THANK YOU FOR REQUESTING <br />YOUR FREE TRIAL</h5>
                        <!-- <h6>In order to enjoy the free trial</h6>-->
                    </div>
                    <div class="">
                        <div class="modal_row2 px-sm-5 mx-sm-5 text-center">
                            <h5 class="font-weight-bold px-0">
                                Click <a href="<?php echo url('/').'/dashboard';?>"
                                    style="text-decoration:none;color: #9E1F63 !important;">here</a> to continue through
                                our web portal
                                <!--First you need to download the <span class="red_txt">mobile & tv</span> app from the below link-->
                            </h5>
                            <p>----------------- or -----------------</p>
                            <h5 class="font-weight-bold px-0">Download the Vodrex app </h5>
                            <!--<img class="mob_tv" src="<?php echo url('/');?>/public/customer/images/mob_tv.png">-->
                            <div class="text-center mb-4 mt-5 row">
                                <a href="https://play.google.com/store/apps/details?id=net.vodrex" target="_blank"
                                    class="d-inline-block col-6">
                                    <img src="<?php echo url('/');?>/public/customer/images/android_dashboard_popup.png"
                                        class="img-fluid">
                                </a>
                                <a class="d-inline-block col-6">
                                    <img src="<?php echo url('/');?>/public/customer/images/ios_dashboard_popup.png"
                                        class="img-fluid">
                                    <div class="f12 my-2">Coming Soon</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--<p class="p-2 text-center">
                                  Thank you for downloading, you will shortly be able to access a variety of channels and content.
                                  </p>-->
                </div>
            </div>
        </div>
    </div>
    <!-- Order User end -->
    <!-- Free trail expired modal -->
    <div class="modal fade imp-note" id="freeTrailExpiredModal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header" style="padding:5px;background-color: #ef0e23;">
                    <div class="text-center alert_icon w-100 p-0 f40 text-white">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    </div>
                    <button type="button" class="close" data-dismiss="modal"
                        style="color: #fff; font-size: 32px;">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body font-primary-book text-center" style="padding:30px 50px 50px 50px">
                    <p class="FreeTrailContent"></p>
                    <?php $freetrial_qry = \App\Free_trail_requested_users::where('user_id',"=",$users_data['rec_id'])->first();
            if(!empty($freetrial_qry)){
                $statusMsg = $freetrial_qry->status;
                    if($statusMsg == 3){?>
                    <a href="javascript::void(0)" class="btn req_trial_btn start_trial_btn"
                        data-id="<?php echo $users_data['rec_id']; ?>"
                        style="padding:10px 20px !important;font-size:12px !important;">Start Now</a>
                    <?php }
                }?>
                </div>
                <!-- Modal footer -->
                <!--  <div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		  </div> -->
            </div>
        </div>
    </div>
    <!-- Package Subscribed expired modal -->
    <div class="modal fade imp-note" id="pkgSubscriptionExpiredModal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header" style="padding:5px;    background-color: #ef0e23;">
                    <div class="text-center alert_icon">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    </div>
                    <button type="button" class="custom_close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body font-primary-book" style="padding:30px 50px 50px 50px">
                    <p class="PkgSubscriptionExpired font-weight-bold">Your BESTBOX Subscription has expired</p>
                    <p class="PkgSubscriptionExpired">Renew Your Subscription to stay Connected</p>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer p-0">
                    <button type="button" class="renew_btn mx-auto my-3"><a
                            href="{{ url('/').'/renewal/'.encrypt($users_data['rec_id']) }}">Renew</a></button>
                </div>
            </div>
        </div>
    </div>
    <!-- Before SevenDays alert modal -->
    <div class="modal fade imp-note" id="pkgSubscriptionBeforeSevenDays">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header" style="padding:5px; background-color: #ef0e23;">
                    <div class="text-center alert_icon">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    </div>
                    <!-- <button type="button" class="custom_close" data-dismiss="modal">&times;</button> -->
                </div>
                <!-- Modal body -->
                <div class="modal-body font-primary-book" style="padding:30px 50px 50px 50px">
                    <p class="PkgSubscriptionText font-weight-bold "></p>
                    <p>Renew your subscription to stay connected</p>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer p-0">
                    <!--<button type="button" class="renew_btn">Renew</button>-->
                    <div class="w-100">
                        <button class="col-6 float-left renew_later_btn" data-dismiss="modal">Renew Later</button>
                        <button class="col-6 renew_btn2"><a
                                href="{{ url('/').'/renewal/'.encrypt($users_data['rec_id']) }}"
                                class="renew_btn2_anchor">Renew</a></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- All scripts include -->
    @include('inc.scripts.all-scripts')
    <?php
		$pkgdata1 = \App\Package_purchase_list::where('user_id',$users_data['rec_id'])->where('active_package',1)->where('package_id','!=',11)->orderBy('rec_id','DESC')->first();
		if(!empty($pkgdata1)){
			$package_expiry_date = $pkgdata1['expiry_date'];
			$current_date = date('Y-m-d h:i:s');
			$localDataTime = \App\Http\Controllers\home\VodController::convertTimezonePkgExpired($current_date);
			$package_localDataTime = \App\Http\Controllers\home\VodController::convertTimezonePkgExpired($package_expiry_date);
			//echo $localDataTime;
			$start_date = date('Y-m-d H:i:s',strtotime($localDataTime));
			$end_date = date('Y-m-d H:i:s',strtotime($package_localDataTime));
			$noofdays = \App\Http\Controllers\home\CronJobsController::dateDiff($start_date, $end_date);
			$is_positive = \App\Http\Controllers\home\CronJobsController::nagitive_check($noofdays);
		if( ($noofdays >=0) && ($noofdays <= 7) && ($is_positive =="positive") ) {
	?>
    <script type="text/javascript">
        $(document).ready(function () {
            var expiryDays = '<?php echo $noofdays; ?>';
            console.log(expiryDays);
            if (expiryDays == 0) {
                var expiryCnt = "Your BESTBOX subscription will expires today";
            } else if (expiryDays == 1) {
                var expiryCnt = "Your BESTBOX subscription will expire in " + expiryDays + " day";
            } else {
                var expiryCnt = "Your BESTBOX subscription will expire in " + expiryDays + " days";
            }
            $("#pkgSubscriptionBeforeSevenDays").modal("show");
            $(".PkgSubscriptionText").text(expiryCnt);
        });
    </script>
    <?php
			}else{
			  if(!empty($pkgdata1) && $pkgdata1['expiry_date'] != ''){
					if($pkgdata1['expiry_date'] < NOW()){
			?>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#pkgSubscriptionExpiredModal").modal("show");
            $('.FreeTrailContent').html();
        });
    </script>
    <?php
					}
				}
			}
		}
		?>
    <?php
        if(Session::has('alert') && Session::get('alert') == 'Failure'){
    ?>
    <script type="text/javascript">
        swal(
            'Failure',
            '<?php echo Session::get('
            error ');?>',
            'error'
        )
    </script>
    <?php
        }
    ?>
    <?php
        if(Session::has('alert') && Session::get('alert') == 'Success'){
    ?>
    <script type="text/javascript">
        swal(
            'Success',
            '<?php echo Session::get('
            message ');?>',
            'success'
        )
    </script>
    <?php
        }
    ?>
    <?php
        if(Session::has('alert') && Session::get('alert') == 'FreeTrail'){
    ?>
    <script type="text/javascript">
        $("#request_free_trial").modal("show");
    </script>
    <?php
        }
    ?>
    <!-- Free Trail Expired alert modal -->
    <?php
		$freeTrailRequestExpired = session('subscribed_message');
		if(!empty($freeTrailRequestExpired)){
	?>
    <script type="text/javascript">
        var FreeTrailContent = '<?php echo $freeTrailRequestExpired; ?>';
        $("#freeTrailExpiredModal").modal("show");
        $('.FreeTrailContent').html(FreeTrailContent);
    </script>
    <?php } ?>
    <!-- Free Trail Expired alert modal -->
    <?php
		$trail_msg = session('trail_msg');
		if(!empty($trail_msg)){
	?>
    <script type="text/javascript">
        var FreeTrailContent = '<?php echo $trail_msg; ?>';
        $("#freeTrailExpiredModal").modal("show");
        $('.FreeTrailContent').html(FreeTrailContent);
    </script>
    <?php } ?>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.4/jstz.min.js"></script>
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
        $(".start_trial_btn").click(function (e) {
            e.preventDefault();
            var rec_id = $(this).attr("data-id");
            //alert(rec_id);return false;
            var token = "<?php echo csrf_token() ?>";
            if (rec_id) {
                $.ajax({
                    url: "<?php echo url('/');?>/freeTrailStartRequestInWeb",
                    method: 'POST',
                    dataType: "json",
                    data: {
                        'rec_id': rec_id,
                        "_token": token
                    },
                    beforeSend: function () {
                        $(".loaderIcon").show();
                    },
                    complete: function () {
                        $(".loaderIcon").hide();
                    },
                    success: function (data) {
                        if (data.status == 'Success') {
                            //$('#successModel').modal('show');
                            //$('#sucessMsg').html('<p class="text-color">'+data.Result+'</p>');
                            //alert("Thank you.. Watch VOD ,Live TV and web series");
                            window.location.reload();
                            return true;
                        } else {
                            alert(data.Result);
                            return false;
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(thrownError);
                    }
                });
            } else {
                alert("rec id missing");
                return false;
            }
        });
    </script>
</body>
</html>

<?php
    $userinfo = Auth::user();
    $login_userId = $userinfo['rec_id'];

    $userpackData = \App\Package_purchase_list::leftjoin('packages', 'package_purchased_list.package_id', '=', 'packages.id')->select('packages.id', 'package_purchased_list.expiry_date','package_purchased_list.active_package','packages.package_name','packages.setupbox_status','packages.vod_series_package')->where('package_purchased_list.user_id', $login_userId)->where('package_purchased_list.package_id','!=',11)->where('package_purchased_list.active_package','=',1)->orderBy('package_purchased_list.rec_id','DESC')->first();

    $trail_period_status = \App\Free_trail_requested_users::where(['user_id' => $login_userId, 'status' => 1])->count();
    $livetv_permission = 1;$package_id = '';
    if(!empty($userpackData)){
        $package_id = $userpackData->id;
        if($userpackData->vod_series_package == 1) $livetv_permission = 0;
    }
    $livetv_class = '';
    $pageUrl = \Request::segment(1);
    if($livetv_permission == 0 && $package_id != ''){
        $livetv_class = 'd-none';
    }else if($livetv_permission == 1 && $package_id != ''){
        $livetv_class = '';
    }
    else if($trail_period_status > 0 && ($livetv_permission == 1 && $package_id == '')){
        $livetv_class = '';
    }
?>
<div class="navbar bsnav bsnav-sidebar bestbox-nav">
    <a class="navbar-brand bg-black py-3 w-100 mx-0 text-center d-none d-lg-block" href="<?php echo url('/');?>/dashboard">
        <img src="<?php echo url('/');?>/public/img/customer/logo.png" class="img-fluid">
    </a>
    <!-- <button class="navbar-toggler toggler-spring"><span class="navbar-toggler-icon"></span></button> -->
    <div class="justify-content-sm-center" style="width: 90px;">
        <ul class="navbar-nav navbar-mobile mr-0 p-0">

            <li class="nav-item d-block d-lg-none <?php echo ($pageUrl == 'dashboard') ? 'active' : '';?>"><a class="nav-link" href="<?php echo url('/').'/dashboard';?>">
                    <span class="icon-thumbnail"><img src="<?php echo url('/');?>/public/img/customer/dashboard.png" class="img-fluid"></span>
                    <div>Dashboard</div>
                </a>
            </li>
            <li class="nav-item <?php echo $livetv_class;?> <?php echo ($pageUrl == 'livetv' || $pageUrl == 'livetvDetails' || $pageUrl == 'livetvChannelView') ? 'active' : '';?>"><a class="nav-link" href="<?php echo url('/').'/livetv';?>" >
                    <span class="icon-thumbnail"><img src="<?php echo url('/');?>/public/img/customer/live.png" class="img-fluid"></span>
                    <div>Live</div>
                </a>
            </li>
            <li class="nav-item <?php echo ($pageUrl == 'vod' || $pageUrl == 'vodCategory' || $pageUrl == 'vodDetailView') ? 'active' : '';?>"><a class="nav-link" href="<?php echo url('/').'/vod';?>">
                    <span class="icon-thumbnail"><img src="<?php echo url('/');?>/public/img/customer/vod.png" class="img-fluid"></span>
                    <div>VOD</div>
                </a>
            </li>
            <li class="nav-item <?php echo ($pageUrl == 'webseries' || $pageUrl == 'webseriesDetailsList' || $pageUrl == 'webseriesEpisodeView' || $pageUrl == 'webseriesList') ? 'active' : '';?>"><a class="nav-link" href="<?php echo url('/').'/webseries';?>">
                    <span class="icon-thumbnail"><img src="<?php echo url('/');?>/public/img/customer/series.png" class="img-fluid"></span>
                    <div>Series</div>
                </a>
            </li>
            <li class="nav-item <?php echo ($pageUrl == 'catchupList' || $pageUrl == 'CatchupView') ? 'active' : '';?>"><a class="nav-link" href="<?php echo url('/').'/catchupList';?>">
                    <span class="icon-thumbnail"><img src="<?php echo url('/');?>/public/img/customer/catchup-active.png" class="img-fluid"></span>
                    <div>Catchup</div>
                </a>
            </li> 
            <li class="nav-item d-none"><a class="nav-link" href="<?php echo url('/').'/livetvDetails?page=1&country_id=&category=146';?>">
                    <span class="icon-thumbnail"><img src="<?php echo url('/');?>/public/img/customer/kids.png" class="img-fluid"></span>
                    <div>Kids</div>
                </a>
            </li>

            <div class="d-none d-lg-block">
                <hr class="" style="border-top: 1px solid #fff; width: 100%;">
            </div>
            <li class="nav-item d-none d-lg-block <?php echo ($pageUrl == 'dashboard') ? 'active' : '';?>"><a class="nav-link" href="<?php echo url('/').'/dashboard';?>">
                    <span class="icon-thumbnail"><img src="<?php echo url('/');?>/public/img/customer/dashboard.png" class="img-fluid"></span>
                    <div>Dashboard</div>
                </a>
            </li>

            <li class="nav-item d-none d-lg-block <?php echo ($pageUrl == 'getReferralsList') ? 'active' : '';?>"><a class="nav-link" href="<?php echo url('/').'/getReferralsList';?>">
                    <span class="icon-thumbnail"><img src="<?php echo url('/');?>/public/img/customer/referral.png" class="img-fluid"></span>
                    <div>Refferral</div>
                </a>
            </li>

            <li class="nav-item d-none d-lg-block <?php echo ($pageUrl == 'transactions') ? 'active' : '';?>"><a class="nav-link" href="<?php echo url('/').'/transactions';?>">
                    <span class="icon-thumbnail"><img src="<?php echo url('/');?>/public/img/customer/transaction.png" class="img-fluid"></span>
                    <div>Transaction</div>
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- <div class="bsnav-mobile">
    <div class="bsnav-mobile-overlay"></div>
    <div class="navbar"></div>
</div> -->

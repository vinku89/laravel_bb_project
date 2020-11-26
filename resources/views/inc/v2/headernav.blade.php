<link href="<?php echo url('/');?>/public/css/customer/topnav.css?q=<?php echo rand();?>" rel="stylesheet">
<link href="<?php echo url('/');?>/public/css/share.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<?php 
    $loggedUserData = Session::get('userData');
    $loggedUserData = \App\User::where(array('user_id' => $loggedUserData['user_id']))->first();
    $profile_img = ($loggedUserData['image']!='') ? url('public/profileImages/').'/'.$loggedUserData['image'] : url('public/profileImages/').'/avatar.png';
    $wallet = \App\Wallet::where(array('user_id' => $loggedUserData['rec_id']))->first();
    $transactions = \App\Transactions::where(['user_id' => $loggedUserData['rec_id']])->orWhere(['receiver_id' => $loggedUserData['rec_id']])->where(['notification'=>0])->orderBy('rec_id','DESC')->skip(0)->take(3)->get();
    $announcements = \App\Announcements::where(['announcement_type' => 2])->where('expiry_date','>=',date('Y-m-d'))->orwhereNull('expiry_date')->orderby('id','desc')->skip(0)->take(3)->get();
    $announcement_list = array();
    foreach($announcements as $an_list){
        $an_user_list = unserialize($an_list['users']);
        foreach($an_user_list as $an_data) {
            if($an_data['rec_id'] == $loggedUserData['rec_id'] && $an_data['flag'] == 1) {
                $announcement_list[] = array('created_at' => $an_list['created_at'], 'title' => $an_list['title'], 'description' => $an_list['description'],'expiry_date' => $an_list['expiry_date'], 'user_id' => $loggedUserData['rec_id']);
            }
        }
    }
?>
<style>
    .view_all_notify {
        display: block;
        background-color: #F67E51;
        padding: 12px 0;
        font-size: 16px;
        text-align: center;
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        color: #fff !important;
        text-decoration: none;
    }

    .color-purple{
        color: #7A1E4F;
    }

    .color-yellow{
        color: #F7BE00;
    }

    .purple-btn{
        display: block;
        width: 100%;
        text-align: center;
        background: #7A1E4F;
        color: #fff;
        text-decoration: none;
    }

    .purple-btn:hover{
        text-decoration: none;
        background: #7A1E4F;
        color: #fff;
    }

</style>


<div class="row mb-3 pb-5">

    <div class="col-md-12 custom--nav px-0">
        <div class="wrapper">
            <div class="custom--nav-bar">
                <div class="custom--nav-bar_left d-none d-lg-block">

                    <div class="d-inline-block addonbtn text-white mr-3 text-uppercase">My Referral ID
                    </div>
                    <div class="btn-group d-inline-block" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-outline-secondary text-white px-4"><?php echo $loggedUserData['refferallink_text'];?></button>
                        <button type="button" class="btn btn-outline-secondary text-white px-3 copyBtn" style="margin-left: -5px;" data-clipboard-text="<?php echo url("/").'/customerSignup/'.$loggedUserData['refferallink_text'];?>">
                            <i class="mr-2 d-inline-block">
                                <img src="<?php echo url('/');?>/public/img/customer/copy.png" class="img-fluid">
                            </i>
                            Copy
                        </button>
                        <button type="button" class="btn btn-outline-secondary text-white px-3" data-toggle="modal" data-target="#share_modal" style="margin-left: -5px;">
                            <i class="mr-2 d-inline-block">
                                <img src="<?php echo url('/');?>/public/img/customer/share.png" class="img-fluid">
                            </i>
                            Share
                        </button>
                    </div>
                </div>

                <div class="custom--nav-bar_left d-block d-lg-none">
                    <div class="logo">
                        <a class="navbar-brand my-2 w-100 mx-0 text-center d-block d-lg-none" href="#">
                            <img src="<?php echo url('/');?>/public/img/customer/logo.png" class="img-fluid">
                        </a>
                    </div>
                    <div class="search-button d-none">
                        <a href="# class=" search-btn-open"><img src="img/search.png" class="img-fluid"></a>
                    </div>
                </div>

                <div class="custom--nav-bar_right ml-auto">
                    <div class="wallet-balance pt-1 d-none d-lg-block">
                        <div class="d-inline-block pt-1 px-3 text-left text-white">
                            <div class="f12">Wallet Balance</div>
                            <div class="f16">$ <?php echo number_format($wallet['amount'],2);?></div>
                        </div>
                        <div class="d-xl-inline-block d-none pr-3" style="top: -15px; position: relative;"><img
                                src="<?php echo url('/');?>/public/img/customer/wallet.png" class="mt-1"></div>
                    </div>
                    <div class="notifications d-none d-lg-block" id="notify_btn">
                        <div class="icon_wrap pl-3 mt-1">
                            <img src="<?php echo url('/');?>/public/img/customer/notification.png">
                        </div>

                        <div class="notification_dd">
                            <div class="color-black px-3 pt-3 pb-2 font-bold">
                            <span><img src="<?php echo url('/');?>/public/images/notif_new.png" style="width: 30px; height: auto;"></span>
                            <span class="alert-head-text pl-2 font-bold">Notification</span>
                            </div>
                            <ul class="notification_ul pl-0 mb-0 pb-2">
                                <?php 
                                    if(count($announcement_list) > 0){
                                        foreach($announcement_list as $val){?>
                                            <li class="">
                                                <div class="w-100">
                                                    <div class="notify_data">
                                                        <div class="title f13">
                                                            <div class="dt">
                                                                <?php
                                                                echo \App\Http\Controllers\home\ReportController::convertTimezone($val['created_at']);
                                                                ?>
                                                            </div>
                                                            
                                                            <div class="payment position-relative">
                                                                <div class="payment-icon"><img src="<?php echo url('/');?>/public/images/notification.png" style="width: 30px; height: auto;"></div>
                                                                <div class="payment-msg"><?php echo $val['title'];?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php }
                                    }
                                    if(count($transactions) > 0){
                                        foreach($transactions as $val){?>
                                        <li class="">
                                            <div class="w-100">
                                                <div class="notify_data">
                                                    <?php if(!empty($val->notification_message)){?>
                                                    <div class="title f13">
                                                        <!-- <div class="dt">May 31st, 2020 6:33 am</div> -->
                                                        <div class="payment">
                                                            <div class="payment-icon"><img src="<?php echo url('/');?>/public/images/transaction.png" style="width: 30px; height: auto;"></div>    
                                                            <div class="payment-msg"><?php echo $val->notification_message;?></div>
                                                        </div>
                                                    </div>
                                                    <?php }else{?>
                                                    <div class="title f13">
                                                        
                                                        <div class="payment">
                                                        <div class="payment-icon"><img src="<?php echo url('/');?>/public/images/notification.png" style="width: 30px; height: auto;"></div>
                                                            <div class="payment-msg">
                                                                <div class="dt">
                                                                    <?php
                                                                    echo \App\Http\Controllers\home\ReportController::convertTimezone($val['received_date']);
                                                                    ?>
                                                                </div>    
                                                                <?php echo $val->description;?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </li>
                                        <?php }
                                    }else{?>
                                        <li>
                                            <div class="notify_data">
                                                <div style="color:#000;">No new notifications found!</div>
                                            </div>
                                        </li>
                                    <?php }?>
                                <li class="mx-3">
                                    <a href="<?php echo url('notifications');?>" class="purple-btn p-2" style="border-radius: 5px;">
                                        Show All Activities
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <div class="profile mt-2">
                        <div class="icon_wrap pl-3">
                            <img src="<?php echo $profile_img;?>" alt="" class="rounded-circle">
                            <span class="name text-white pr-3 f12">
                                <?php echo ucwords($loggedUserData['first_name']." ".$loggedUserData['last_name']);?>
                                <!-- <br> -->
                                <?php 
                                    if($loggedUserData['user_role']==1) { 
                                        $userRoleName = "Admin"; 
                                        $levelUser = 'Reseller';
                                    }else if($loggedUserData['user_role']==2) { 
                                        $userRoleName = "Reseller"; 
                                        $levelUser = 'Agent';
                                    }else if($loggedUserData['user_role']==3) { 
                                        $userRoleName = "Agent"; 
                                        $levelUser = 'Customer';
                                    }else if($loggedUserData['user_role']==4) { 
                                        $userRoleName = "Customer"; 
                                        $levelUser = '';
                                    }else if($loggedUserData['user_role']!=0){ 
                                        $role = \App\User::leftJoin('roles_permissions','users.user_role','=','roles_permissions.id')
                                            ->select('roles_permissions.role_name')
                                            ->where(['users.rec_id'=> $loggedUserData['rec_id']])->first();
                                        $userRoleName = $role->role_name; 
                                        $levelUser = '';
                                    }else{ 
                                        $userRoleName = '';$levelUser = '';
                                    }
                                     $userRoleName;
                                ?>
                                <small> 
                                    <?php
                                        // echo $userRoleName;
                                    ?>  
                                </small>
                            </span>
                            <i class="fas fa-chevron-down text-white"></i>
                            <div>
                                
                            </div>
                        </div>

                        <div class="profile_dd">
                            <ul class="profile_ul pl-0 mb-0">
                                <li class="profile_li">
                                    <a class="profile" href="<?php echo url('/profile');?>">
                                        <span class="picon">
                                            <i class="fas fa-user-alt"></i>
                                        </span>Profile
                                    </a>
                                </li>
                                
                                <li>
                                    <a class="logout" href="<?php echo url('/logout');?>">
                                        <span class="picon">
                                            <i class="fas fa-sign-out-alt"></i>
                                        </span>Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--share modal popup -->
<div class="modal fade share_modal" id="share_modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color:transparent; border:none;">
            <div class="modal-body referal-modal-body text-center" style=" padding-top: 45px; padding-bottom: 15px;">

                <div class="clearfix ">
                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style"
                        data-a2a-url="<?php echo url("/").'/customerSignup/'.$loggedUserData['refferallink_text'];?>"
                        data-a2a-title="BestBOX referral link">
                        <ul class="share_icons">
                            <li>
                                <a class="a2a_button_facebook fb_div div_wrap"><i
                                        class="social_icongroup  fb"></i>Facebook</a>
                            </li>
                            <li>
                                <a class="a2a_button_twitter tw_div div_wrap"><i
                                        class="social_icongroup tw"></i>Twitter</a>
                            </li>
                            <li>
                                <a class="a2a_button_google_gmail gmail_div div_wrap">
                                    <i class="social_icongroup gmail"></i>
                                    Gmail</a>
                            </li>
                            <li>
                                <a class="a2a_button_whatsapp wapp_div div_wrap"><i
                                        class="social_icongroup wapp"></i>Whatsapp</a>
                            </li>
                            <li>
                                <a class="a2a_button_skype skp_div div_wrap">
                                    <i class="social_icongroup skp"></i>Skype</a>
                            </li>
                            <li>
                                <a class="a2a_button_email email_div div_wrap">
                                    <i class="social_icongroup email"></i>Email</a>
                            </li>
                            <li>
                                <a class="a2a_button_telegram tgm_div div_wrap">
                                    <i class="social_icongroup tgm"></i>Telegram</a>
                            </li>
                            <li>
                                <a class="a2a_button_tumblr tm_div div_wrap">
                                    <i class="social_icongroup tm"></i>Tumblr</a>
                            </li>
                            <li>
                                <a class="a2a_button_outlook_com ol_div div_wrap"><i
                                        class="social_icongroup ol"></i>Outlook</a>
                            </li>
                            <li>
                                <a class="a2a_button_sms sms_div div_wrap"><i class="social_icongroup sms"></i>SMS</a>
                            </li>
                            <li>
                                <a class="a2a_button_viber vb_div div_wrap"><i class="social_icongroup vb"></i>Viber</a>
                            </li>
                            <li>
                                <a class="a2a_button_yahoo_mail ym_div div_wrap"><i
                                        class="social_icongroup ym"></i>Yahoo Mail</a>
                            </li>
                        </ul>
                    </div>


                    <script async src="https://static.addtoany.com/menu/page.js"></script>

                    <script type="text/javascript">
                        var a2a_config = a2a_config || {};
                        a2a_config.templates = a2a_config.templates || {};
                        a2a_config.templates.email = {
                            subject: "${title}",
                            body: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy.",
                            text: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy."
                        };
                        a2a_config.templates.twitter = {
                            text: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy."

                        };
                        a2a_config.templates.whatsapp = {
                            text: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy."
                        };
                        a2a_config.templates.facebook = {
                            quote: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy."
                        };
                        a2a_config.templates.skype = {
                            text: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy."
                        };
                        a2a_config.templates.telegram = {
                            text: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy."
                        };
                        a2a_config.templates.tumblr = {

                            content: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy."
                        };
                        a2a_config.templates.viber = {
                            text: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy.",


                        };
                        a2a_config.templates.sms = {
                            body: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy.",


                        };
                    </script>
                </div>
            </div>
            <div class="modal-footer referal-modal-footer"
                style="text-align: center !important; border-top:none;padding-top: 0;padding-bottom: 30px;">
                <button type="button" class="btn-buy referal-modal-btn model_close_btn" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<!--share modal popup ends-->

<?php 
    $loggedUserData = Session::get('userData');
    $loggedUserData = \App\User::where(array('user_id' => $loggedUserData['user_id']))->first();
    $profile_img = ($loggedUserData['image']!='') ? $loggedUserData['image'] : 'avatar.png';
    $wallet = \App\Wallet::where(array('user_id' => $loggedUserData['rec_id']))->first();
    $transactions = \App\Transactions::where(array('user_id' => $loggedUserData['rec_id'],'notification'=>0))->orderBy('rec_id','DESC')->skip(0)->take(5)->get();
    
?>

<style>
    /* .notify-drop-wrp{
        left:38% !important;
    } */
    .view_all_notify{
        display: block;
        background-color: #F67E51;
        padding: 12px 0;
        font-size: 16px;
        text-align: center;
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        color:#fff !important;
        text-decoration: none;
    }
</style>
<link rel="stylesheet" href="<?php echo url('/');?>/public/css/flag-icon.css">
<div class="backdrop"></div>
<div class="main_body_header user_profile_dropdown">
    <i class="fas fa-bars small_resNav_toggle"></i>
    <div class="small_res_logo">
        <img src="<?php echo url('/');?>/public/images/white-logo.png" alt="BestBOX">
    </div>
    <div class="right_div ml-auto col-8 clearfix">
        <div class="display_inline position-relative">
            <div class="total_sales_value">
                <img src="<?php echo url('/');?>/public/images/ttl-wallet.png" class="float-right">
                <div class="clearfix mr-5">
                    <h6 class="font12 dark-grey_txt">Wallet Balance</h6>
                    <h4 class="font22 dark-grey_txt font-bold">$<?php echo number_format($wallet['amount'],2);?></h4>
                </div>
                    
            </div>
            <div class="notification_wrp" id="notification_btn">
                <span id="pulse_btn" class="pulse-button {{ count($transactions) > 0 ? '' : 'd-none' }}"></span>
                <i class="icon-group notification_icon"></i>
                <div class="notify-drop-wrp d-none">
                        <h5 class="font16 white_txt text-uppercase font-bold text-left pt-4 pl-3">Notifications</h5>
                        <i class="fas fa-times close_notify"></i>
                        <ul>
                        @If(count($transactions) > 0)
                            @Foreach($transactions as $val)
                                <li>
                                    <a href="<?php echo url('notifications');?>">
                                    @If(!empty($val->notification_message))
                                    {!! $val->notification_message !!}
                                    @else
                                    <strong> 
                                            @php
                                                echo \App\Http\Controllers\home\ReportController::convertTimezone($val['received_date']);
                                            @endphp
                                    </strong>
                                    {{ $val->description }}
                                    @endIf
                                    </a>
                                </li>
                            @endForeach
                        @else
                            <li>No new notifications found!</li>
                        @endIf
                            <!-- <li>
                                <a href="">
                                <strong>May 11th, 2019 11:29 am </strong>
                                You have successfully transfer  <strong>Pay For My Friend package 
                                BBBOX3 </strong> amount  <strong>89.99 USD. </strong> The Payement ID is 762828282672htgs8272819
                                </a>
                            </li>
                            <li>
                            <a href="">
                                <strong>May 11th, 2019 11:29 am </strong>
                                You have successfully transfer  <strong>Pay For My Friend package 
                                BBBOX3 </strong> amount  <strong>89.99 USD. </strong> The Payement ID is 762828282672htgs8272819
                                </a>
                            </li>
                            <li>
                                <a href="">
                                <strong>May 9th, 2019 10:21 am</strong>
                                You received Direct Sale amount <strong>5.00 USD.</strong>
                                </a>
                            </li>
                            <li>
                            <a href="">
                                <strong>May 11th, 2019 11:29 am </strong>
                                You have successfully transfer  <strong>Pay For My Friend package 
                                BBBOX3 </strong> amount  <strong>89.99 USD. </strong> The Payement ID is 762828282672htgs8272819
                                </a>
                            </li> -->
                            
                            
                        </ul>
                        <a href="<?php echo url('notifications');?>" class="view_all_notify">See All Notifications </a>
                </div>
            </div>
                    
            <div class="dropdown float-left margin_minus ">

                <div class="wrapper wrapper2"  id="wrapper2">
                    <div class="clearfix active_bg pl-2">
                        <!-- Profile pic -->
                        <div class="profile_wrp"><img src="<?php echo url('public/profileImages/').'/'.$profile_img;?>"></div>
                        <div class="user_info">
                            <h6><?php echo ucwords($loggedUserData['first_name']." ".$loggedUserData['last_name']);?></h6>
                            <small><?php 
                                    if($loggedUserData['user_role']==1) { $userRoleName = "Admin"; $levelUser = 'Reseller';}
                                        else if($loggedUserData['user_role']==2) { $userRoleName = "Reseller"; $levelUser = 'Agent';}
                                        else if($loggedUserData['user_role']==3) { $userRoleName = "Agent"; $levelUser = 'Customer';}
                                        else if($loggedUserData['user_role']==4) { $userRoleName = "Customer"; $levelUser = '';}
                                        else if($loggedUserData['user_role']!=0){ 
                                            $role = \App\User::leftJoin('roles_permissions','users.user_role','=','roles_permissions.id')
                                                ->select('roles_permissions.role_name')
                                                ->where(['users.rec_id'=> $loggedUserData['rec_id']])->first();
                                        $userRoleName = $role->role_name; $levelUser = '';}
                                        else{ $userRoleName = '';$levelUser = '';}
                                        echo $userRoleName;?></small>
                            <span class="arrow"></span>
                        </div>
                    </div>
            
                    <ul>
                        <h6 class="white_txt text-left font-bold pt-1 pl-4">PROFILE</h6>
                        
                        <li class="small_resolution_bal">
                            <div class="clearfix mr-5">
                                <h6 class="font12 dark-grey_txt">Wallet Balance</h6>
                                <h4 class="font22 dark-grey_txt font-bold">$<?php echo number_format($wallet['amount'],2);?></h4>
                            </div>
                        </li>
                        <li>
                            <a href="<?php echo url('/profile');?>" class="profileMenu">
                                <i class="profile_menuIcons profile_icon"></i>
                                My Profile  
                            </a>
                        </li>
                        <?php 
                        if($userRoleName != "Customer"){   
                        ?>
                        <li>
                            <a href="<?php echo url('/changePassword');?>" class="profileMenu">
                                <i class="profile_menuIcons change-pwd_icon "></i>
                                Change Password 
                            </a>
                        </li>
                        <?php } ?>
                        <!-- <li>
                            <a href="#" class="profileMenu">
                                <i class="profile_menuIcons help_icon"></i>
                                Help
                            </a>
                        </li> -->
                        <li>
                            <a href="<?php echo url('/logout');?>" class="logout_btn">
                                <i class="profile_menuIcons logout_icon"></i>
                                Logout
                            </a>
                        </li>
                        <li style="text-align:center">
                        <div class="dropdown_content">
                            <p class="font-bold font14 mb-4">BestBOX Support<br>Operation Hours</p>
                            <p class="font14 mb-5">
                            Mon- Fri : 9.00am - 6.00 pm<br>
                            GMT +8 Kuala Lumpur<br>
                            Hotline : +603-7890 0049
                            </p>
                            <p class="font14 mb-5">
                                <a href="<?php echo url('/');?>/terms_of_use">Terms & Conditions</a>
                                <a href="<?php echo url('/');?>/privacy_policy">Privacy policy</a>
                            </p>
                            <p class="font12">
                                <img src="<?php echo url('/');?>/public/images/white-logo.png" width="100" class="mb-2"><br>
                                Copyright © <?php echo date('Y');?> BestBOX. All rights reserved.
                            </p>
                        </div>
                        </li>
                        
                    </ul>  
                </div>
            
            </div>
            </div>
        </div>
    </div>

     <script type="text/javascript">
     var validNavigation = 0;

function endSession() 
{
   // Browser or Broswer tab is closed
   // Write code here
   alert('Browser or Broswer tab closed');
   $.ajax({
        url: "<?php echo url('/');?>/logout",
        method: 'GET',
        dataType: "json",
        data: {"_token": token},
        success: function (data) { 
            window.location.reload();
            return true;
        },
        error:function (xhr, ajaxOptions, thrownError){
            alert(thrownError);
        }
    });
}

function bindDOMEvents() {
/*

* unload works on both closing tab and on refreshing tab.

*/
$(window).unload(function() 
{
   if (validNavigation==0) 
   {
     endSession();
   }
});

// Attach the event keypress to exclude the F5 refresh
$(document).keydown(function(e)
{
   var key=e.which || e.keyCode;
   if (key == 116)
   {
     validNavigation = 1;
   }
});

// Attach the event click for all links in the page
$("a").bind("click", function() 
{
   validNavigation = 1;
});

 // Attach the event submit for all forms in the page
 $("form").bind("submit", function() 
{
   validNavigation = 1;
});

 // Attach the event click for all inputs in the page
 $("input[type=submit]").bind("click", function() 
{
   validNavigation = 1;
});

}

// Wire up the events as soon as the DOM tree is ready
jQuery(document).ready(function() 
{
   bindDOMEvents(); 
}); 
        // window.addEventListener('beforeunload', function (e) { 
        //     e.preventDefault(); 
        //     e.returnValue = ''; 
                      
        //     var token = "<?php echo csrf_token() ?>";
            
        //     $.ajax({
        //         url: "<?php echo url('/');?>/logout",
        //         method: 'GET',
        //         dataType: "json",
        //         data: {"_token": token},
        //         success: function (data) { 
        //             window.location.reload();
        //             return true;
        //         },
        //         error:function (xhr, ajaxOptions, thrownError){
        //             alert(thrownError);
        //         }
        //     });
        // }); 
    </script>  
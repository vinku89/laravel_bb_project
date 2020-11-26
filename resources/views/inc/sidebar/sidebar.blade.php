
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
            background-color: #2d968c;
            font-weight: bold;
            color: #fff;
            display: inline-block; 
            padding: 5px 30px;
            border-radius: 5px;
            margin-top: 20px;
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

        .modHeader{
            background: black;
            border-radius: 30px 30px 0 0;
            background: url(../../../public/customer/images//Bestbox-popup-bg.png);
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain;
            width: 100%;
            padding: 12% !important;
            position: relative;
            top: -0.5vh;
            z-index: 0;
        }
        .modHeader h5{
            color: #fff !important;
        }


    </style>

<?php 
$userinfo = Auth::user();
$login_userId = $userinfo['rec_id'];

//if($userinfo['admin_login'] == 1){
	$where = array('users.status'=>1);
/*}else{
	$where = array('users.referral_userid'=>$login_userId,'users.status'=>1);
}*/

	if ($userinfo['user_role'] == 2) {
		$res = \App\Users_tree::where("reseller_id", $userinfo['rec_id'])->where("customer_id", "!=", 0)->orderBy("rec_id", "DESC")->get();
	} else if ($userinfo['user_role'] == 3) {
		$res = \App\Users_tree::where("agent_id", $userinfo['rec_id'])->where("customer_id", "!=", 0)->orderBy("rec_id", "DESC")->get();
	} else {
		$res = \App\Users_tree::where("customer_id", "!=", 0)->orderBy("rec_id", "DESC")->get();
	}
	$arr = array();
	foreach ($res as $val) {
		array_push($arr, $val->customer_id);
	}
	
	$pending_shipment_list_count = \App\Purchase_order_details::leftjoin('package_purchased_list','purchase_order_details.package_purchased_id','=','package_purchased_list.rec_id')->join('packages','packages.id','=','package_purchased_list.package_id')->join('users','purchase_order_details.user_id','=','users.rec_id')->where(['packages.setupbox_status' => 1,'users.user_role' => 4,'purchase_order_details.is_shipped' => 0])
				->where('purchase_order_details.order_id','!=','')
				->where($where)
				->whereIn('users.rec_id', $arr)
				->groupby('purchase_order_details.user_id')
				->orderBy('purchase_order_details.rec_id','DESC')
				->get();
	
	$pending_activation_list_count = \App\Purchase_order_details::join('users','users.rec_id','=','purchase_order_details.user_id')->leftjoin('package_purchased_list','purchase_order_details.package_purchased_id','=','package_purchased_list.rec_id')->leftjoin('packages','package_purchased_list.package_id','=','packages.id')->where('purchase_order_details.type',1)->where('purchase_order_details.status',1)->where('packages.id','!=',11)->select('purchase_order_details.rec_id','users.email','users.rec_id','purchase_order_details.is_shipped','packages.setupbox_status')->where($where)->whereIn('users.rec_id', $arr)->get();
	$actarr = array();
	foreach ($pending_activation_list_count as $val) {
		if($val->setupbox_status == 1 && $val->is_shipped == 0){
            continue;
        }else{
        	array_push($actarr, $val->rec_id);
        }
	}
	
	$pending_renewal_count= \App\Purchase_order_details::join('users','users.rec_id','=','purchase_order_details.user_id')->leftjoin('package_purchased_list','purchase_order_details.package_purchased_id','=','package_purchased_list.rec_id')->leftjoin('packages','package_purchased_list.package_id','=','packages.id')->where('purchase_order_details.type',2)->where('purchase_order_details.status',1)->select('purchase_order_details.rec_id','users.email')->where($where)->whereIn('users.rec_id', $arr)->orderBy('purchase_order_details.purchased_date','DESC')->orderBy('purchase_order_details.rec_id','ASC')->get();


	//$where = array('users.email_verify'=>1);

	$activeline_count = \App\User::rightJoin(\DB::raw('(SELECT * FROM package_purchased_list WHERE rec_id IN (SELECT MAX(rec_id) AS id FROM package_purchased_list WHERE package_id != 11 AND active_package=1 GROUP BY user_id) ORDER BY user_id) AS t2'), function($join) {
			        $join->on('users.rec_id', '=', 't2.user_id');
			    })->leftjoin('packages', 't2.package_id', '=', 'packages.id')->where($where)->whereIn('users.rec_id', $arr)->select('users.rec_id', 'users.user_id')->groupBy('users.user_id')->get();
		
	$userpackData = \App\Package_purchase_list::leftjoin('packages', 'package_purchased_list.package_id', '=', 'packages.id')->select('packages.id', 'package_purchased_list.expiry_date','package_purchased_list.active_package','packages.package_name','packages.setupbox_status','packages.vod_series_package')->where('package_purchased_list.user_id', $login_userId)->where('package_purchased_list.package_id','!=',11)->where('package_purchased_list.active_package','=',1)->orderBy('package_purchased_list.rec_id','DESC')->first();	

	$trail_period_status = \App\Free_trail_requested_users::where(['user_id' => $login_userId, 'status' => 1])->count();
	$live_videos_permission = 0;$package_id = '';
	if(!empty($userpackData)){
		$package_id = $userpackData->id;
		if($userpackData->vod_series_package == 1) $live_videos_permission = 1;
	} 
?>

<nav class="navbar-primary primary_bg">
        <div id="nav-icon2">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="company_logo">
            <img src="<?php echo url('/');?>/public/images/white-logo.png" alt="BestBOX" class="img">
        </div>

        <!-- Menus start-->
        <div class="menu_wrp_scroll">
        <ul class="navbar-primary-menu">
            <li>
			<?php 
				$sessid = Session::getId();
				$userinfo = Auth::user();
				$userid =$userinfo['user_id'];
				$user_role = $userinfo['user_role'];
				$admin_login = $userinfo['admin_login'];
				$res = \App\RolesPermissions::where('id', $user_role)->first();

				$parentMenus = array();
				if (!empty($res->parent_menus)) {
					$sub1 = explode(',', $res->parent_menus);
					foreach ($sub1 as $out1) {
						if($user_role == 1 && $out1 == 25) {
							continue;
						}else{
							array_push($parentMenus, $out1);
						}
						
					}
				}

				$submenus = array();
				if (!empty($res->child_menus)) {
					$sub2 = explode(',', $res->child_menus);
					foreach ($sub2 as $out1) {
						array_push($submenus, $out1);
					}
				}
				if($user_role == 4){
					$left_menu_q = \App\Left_menu::where(['status' => 1,'is_flag' => 1,'is_customer_menu' => 1])->whereIn('id', $parentMenus)->orderBy('menu_order','ASC')->get();
				}else if(in_array($user_role,[2,3])){
					$left_menu_q = \App\Left_menu::where(['status' => 1,'is_flag' => 1,'is_menu' => 1])->whereIn('id', $parentMenus)->orderBy('menu_order','ASC')->get();
				}else{
					$left_menu_q = \App\Left_menu::where(['status' => 1,'is_admin_menu' => 1, 'is_flag' => 1])->whereIn('id', $parentMenus)->orderBy('menu_order','ASC')->get();
				}
				
					if(!empty($left_menu_q)){
						foreach($left_menu_q as $res){
							$free_trail_class = '';
							
							if($live_videos_permission == 1 && $package_id != '' && $res->menu_link == 'livetvlist'){
								continue;
							}else if($live_videos_permission == 0 && $package_id != '' && $res->menu_link == 'livetvlist'){
								$free_trail_class = '';
							}
							/*else if($trail_period_status==0 && ($live_videos_permission == 0 && $package_id == '' && $res->menu_link == 'livetvlist')){
								$free_trail_class = 'data-toggle="modal" data-target="#free_trail_access_popup"';
							}*/
							else if($trail_period_status>0 && ($live_videos_permission == 0 && $package_id == '' && $res->menu_link == 'livetvlist')){
								$free_trail_class = '';
							}

														
							$menu_id = $res->id;
							/*if($login_userId != 1484 && ($menu_id == 60 || $menu_id == 61 || $menu_id == 62) ){
								continue;
								}*/

							if($res->menu_link == "#"){
								$menuURL = $res->menu_link;
							}else{
								$menuURL = url('/')."/".$res->menu_link;
							}
							
							if(trim($free_trail_class)!='') {
								$menuURL = 'javascript:void(0)';
							}
							$menuName = $res->menu;
							$menuClass = $res->class_type;
							if($user_role == 4){
								$sub_menu_q = \App\Left_menu::where(['status' => 1, 'is_flag' => 1,'is_customer_menu' => 1])->where('parent_menu_id', $menu_id)->orderBy("menu_order", "ASC")->get();
							}else if(in_array($user_role,[2,3])){
								$sub_menu_q = \App\Left_menu::where(['status' => 1, 'is_flag' => 1,'is_menu' => 1])->where('parent_menu_id', $menu_id)->orderBy("menu_order", "ASC")->get();
							}else{
								$sub_menu_q = \App\Left_menu::where(['status' => 1,'is_admin_menu' => 1, 'is_flag' => 1])->where('parent_menu_id', $menu_id)->orderBy("menu_order", "ASC")->get();
							}
							
							$total_childs_menus = count($sub_menu_q);
							if($total_childs_menus>0 && $menu_id != 1){
								$menu_righ_arrow = '<span class="fas fa-angle-right toggle-right"></span>';	
								$childClass="child-menu";
								$childActive = "kumar";
							}else{
								$menu_righ_arrow = '';
								$childClass="";
								$childActive = "";
							}
							if($userinfo['sub_user'] == 1 && $res->menu_link == 'multibox') continue;
			?>	
                <li class="<?php echo $childClass; ?>" <?php echo $free_trail_class;?>>
                    <a class="<?php echo $childActive; ?>" href="<?php echo $menuURL;?>"><i class="icon-group <?php echo $menuClass; ?>"></i><span class="nav_txt"><?php echo $menuName; ?></span>
					<?php echo $menu_righ_arrow; ?>
                    </a>
					<?php 
						if($total_childs_menus>0 && $menu_id != 1){
					?>	
						<ul class="child-menu-ul">
							<?php 
							  foreach ($sub_menu_q as $sub_data) {	
								$sub_menu_id = $sub_data->id;
								$submenuURL = url('/')."/".$sub_data->menu_link;
								$submenuName = $sub_data->menu;
								$menuClass = $sub_data->class_type;
								if (in_array($sub_menu_id, $submenus) && $sub_menu_id!='33') {
							?>							 
							<li>
								<a href="<?php echo $submenuURL;?>"><?php echo $submenuName; ?></a>
							</li>
								<?php 
									 }
								}  
								?>
						</ul>
					<?php }else{ ?>

							<?php 
							  foreach ($sub_menu_q as $sub_data) {	
								$sub_menu_id = $sub_data->id;
								$submenuURL = url('/')."/".$sub_data->menu_link;
								$submenuName = $sub_data->menu;
							?>
							<?php if(in_array($sub_menu_id, $submenus) && $sub_menu_id == 48){ ?>
							 		<li class="menu_2">
										<a class="" href="<?php echo $submenuURL;?>"><span class="nav_txt"><?php echo $submenuName; ?></span><span class="menu_badge orange_circle">{{ sizeof($pending_shipment_list_count) }}</span></a>
									</li>
							<?php   } else if(in_array($sub_menu_id, $submenus) &&  $sub_menu_id == 49){ ?>
									<li class="menu_2">
										<a class="" href="<?php echo $submenuURL;?>"><span class="nav_txt"><?php echo $submenuName; ?></span><span class="menu_badge voilet_circle">{{ sizeof($actarr) }}</span></a>
									</li>
							<?php   } else if(in_array($sub_menu_id, $submenus) &&  $sub_menu_id == 50){ ?>
									<li class="menu_2">
										<a class="" href="<?php echo $submenuURL;?>"><span class="nav_txt"><?php echo $submenuName; ?></span><span class="menu_badge yellow_circle">{{ sizeof($pending_renewal_count) }}</span></a>
									</li>
							<?php   } else if(in_array($sub_menu_id, $submenus) &&  $sub_menu_id == 51){ ?>
									<li class="menu_2">
										<a class="" href="<?php echo $submenuURL;?>"><span class="nav_txt"><?php echo $submenuName; ?></span><span class="count_activeline">{{ sizeof($activeline_count) }}</span></a>
									</li>
							<?php } 
							}
							?>

					<?php } ?>
			 </li>					 

					<?php } } ?> 
               
            </li>
        </ul>
        </div>
        <!-- Menus End-->

        
        <!-- Refral Id Section -->
        <div class="referalId_wrp">
            <div class="referalId_inner_wrp">
                <p class="white_txt font16 text-center">My Referral ID</p>
                <div class="id_bg mb-2">
                    <p class="dark-grey_txt font16 text-center"><?php 
                    $sdata = Session::get('userData');
                    echo $sdata['refferallink_text'];?></p>
                </div>
                <div class="row">
                    <div class="col-6 ">
                        <a href="#" class="copy_btn" data-clipboard-text="<?php echo url("/").'/customerSignup/'.$sdata['refferallink_text'];?>">
                            Copy
                        </a>
                    </div>

                    <div class="col-6 pl-2">
					    <!-- <div class="share_btn" data-title="Here is your referral link: <?php //echo url("/").'/customerSignup/'.$sdata['refferallink_text'];?> 3 steps to getting your BestBOX
1. Open link above and create your account.
2. Activate your account from your auto-generated email you will receive.
3. Inside your dashboard, order your preferred package.
As easy as that.
Enjoy." data-url="<?php //echo url("/").'/customerSignup/'.$sdata['refferallink_text'];?>">
					    	<span class="st-label">Share</span>
					    </div> -->
					    <div class="share_btn" style="cursor: pointer;" data-toggle="modal" data-target="#share_modal"><span class="st-label" style="float: right">Share</span></div>
						<!--<a href="#" class="share_btn">
                            Share
                        </a>-->
                    </div>
						
                </div>
            </div>
        </div>


    </nav>
<div class="modal fade share_modal" id="share_modal" role="dialog" >
		<div class="modal-dialog modal-lg">
			<div class="modal-content" style="background-color:transparent; border:none;">
				<div class="modal-body referal-modal-body text-center" style=" padding-top: 45px; padding-bottom: 15px;" >
					
					<div class="clearfix "  >
						<div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="<?php echo url("/").'/customerSignup/'.$sdata['refferallink_text'];?>" data-a2a-title="BestBOX referral link">
							

							<ul class="share_icons" >
								<li>
									<a class="a2a_button_facebook fb_div div_wrap"><i class="social_icongroup  fb"></i>Facebook</a>
								</li>
								<li>
									<a class="a2a_button_twitter tw_div div_wrap"><i class="social_icongroup tw"></i>Twitter</a>
								</li>
								
								<!-- <li>
									<a class="a2a_button_pinterest"><i class="reward_icons share_icon pin">Pinterest</i></a>
								</li> -->
								<li>
									<a class="a2a_button_google_gmail gmail_div div_wrap">
										<i class="social_icongroup gmail"></i>
									Gmail</a>
								</li>
								
								<!-- <li>
									<a class="a2a_button_google_plus"><i class="reward_icons share_icon gg"></i></a>
								</li> -->
								<li>
									<a class="a2a_button_whatsapp wapp_div div_wrap"><i class="social_icongroup wapp"></i>Whatsapp</a>
								</li>
								<!-- <li>
									<a class="a2a_button_linkedin ln_div div_wrap">
										<i class="social_icongroup ln"></i>Linkedin</a>
								</li> -->
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
								<!-- <li>
									<a class="a2a_button_line line_div div_wrap">
										<i class="social_icongroup line"></i>Line</a>
								</li> -->
								<li>
									<a class="a2a_button_outlook_com ol_div div_wrap"><i class="social_icongroup ol"></i>Outlook</a>
								</li>
								<li>
                                    <a class="a2a_button_sms sms_div div_wrap"><i class="social_icongroup sms"></i>SMS</a>
                                </li>
                                <li>
                                    <a class="a2a_button_viber vb_div div_wrap"><i class="social_icongroup vb"></i>Viber</a>
                                </li>
                                <li>
                                    <a class="a2a_button_yahoo_mail ym_div div_wrap"><i class="social_icongroup ym"></i>Yahoo Mail</a>
                                </li>

								<!-- <li>
									<a class="a2a_button_facebook_messenger"><i class="reward_icons share_icon skp">Facebook Messenger</i></a>
								</li> -->
							</ul>
						</div>


							<script async src="https://static.addtoany.com/menu/page.js"></script>
							<!-- <script async src="<?php //echo url('/');?>/public/js/share.js"></script> -->
							<!-- AddToAny END -->
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
                                /*a2a_config.templates.line = {
                                    body: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Activate your account from your auto-generated email you will receive. \n\n 3. Inside your dashboard, order your preferred package \n\n As easy as that. \n\n Enjoy.",
                                   

                                };*/
								/*a2a_config.templates.linkedin = {
								    
								    share: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Activate your account from your auto-generated email you will receive. \n\n 3. Inside your dashboard, order your preferred package \n\n As easy as that. \n\n Enjoy."

								};*/
								/*a2a_config.templates.facebook_messenger = {
								    
								    text: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Activate your account from your auto-generated email you will receive. \n\n 3. Inside your dashboard, order your preferred package \n\n As easy as that. \n\n Enjoy." 
								};*/
								
							</script>




					</div>
				</div>
				<div class="modal-footer referal-modal-footer" style="text-align: center !important; border-top:none;padding-top: 0;padding-bottom: 30px;" >
					<button type="button" class="btn-buy referal-modal-btn model_close_btn" data-dismiss="modal">
						<i class="fa fa-times" aria-hidden="true"></i>
					</button>
				</div>
			</div>
		</div>
	</div>

<!-- free trail period only access vod and series alert -->
<div class="modal fade imp-note" id="free_trail_access_popup">
        <div class="modal-dialog modal-md">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header" style="padding:5px;    background-color: #e43c4c;">
                    <div class="text-center alert_icon">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    </div>
                    <button type="button" class="custom_close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body font-primary-book text-center" style="padding:50px 50px 35px 50px">
                    <p class="PkgSubscriptionExpired font-weight-bold text-center">Its only available for Subscribed users, trial account Live channels are not accessable</p>

                     <button type="button" data-dismiss="modal" class="renew_btn">OK</button>

                </div>

                <!-- Modal footer -->
             <!--    <div class="modal-footer p-0">
                    <button type="button" data-dismiss="modal" class="renew_btn">Close</button>
                </div> -->

            </div>
        </div>
    </div>
<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;

use App\Ios_badge_count;
use Validator;
use Session;
use App\User;
use App\Country;
use App\Wallet;
use App\RolesPermissions;
use App\Left_menu;
use App\MobileLeftMenu;
use App\Announcements;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Commissions;
use App\Users_tree;
use App\Unilevel_tree;
use App\Sales;
use App\Packages;
use App\Package_purchase_list;
use App\Recent_movies_images;
use App\IptvConfigURLS;
use App\Settings;
use App\ApplicationsInfo;
use App\Free_trail_requested_users;
use App\ApplicationSettings;
use App\Visitor;
use App\UsersDevicesList;
use Illuminate\Support\Facades\Log;
class UserController extends Controller
{

	public static function convertDateToUTCForAPI($date){
        //$utctime = date($date, strtotime('-8 hours')); //converting Malaysia date to UTC date
        //$utctime =date('Y-m-d H:i:s',strtotime('-8 hours',strtotime($date))); //converting Malaysia date to UTC date
		$utctime =date('Y-m-d H:i:s',strtotime($date));
        $temp=explode(" ",$utctime);
        $today = $temp[0];
        $ttime=$temp[1];
        $new_time = $today."T".$ttime;
        return $new_time;
    }

	public static function dateDiff($date1, $date2)
	{
	  $date1_ts = strtotime($date1);
	  $date2_ts = strtotime($date2);
	  $diff = $date2_ts - $date1_ts;
	  return round($diff / 86400);
	}
	public static function expirydateDiff($date1, $date2)
	{
	  $date1_ts = strtotime($date1);
	  $date2_ts = strtotime($date2);
	  $diff = $date2_ts - $date1_ts;
	  return round($diff / 86400);
	}
	public function userDetails(Request $request)
	{
		$data = $request->user();

		$validator = Validator::make($request->all(), [
			'isTv' => 'required',
			/*'client_id' => 'required',*/
		]);

		if ($validator->fails()) {
			$res = array_combine($validator->messages()->keys(), $validator->messages()->all());
			$result = implode($res, ',');
			return response()->json(['status' => 'Failure', 'Result' => $result], 200);
		}
		$isTv = request('isTv');
		$client_id = $data['application_id']; //request('client_id');
		$app_name = request('app_name');
		$platform = request('platform');
		$device_id = request('device_id');
		if($app_name == "BESTBOX"){
			$isMobileTabTv = 1; //BESTBOX 1-tv
		}else{
			$isMobileTabTv1 = request('isMobileTabTv'); //Vodrex 1-tv 0-mobile
			if($isMobileTabTv1 == ""){
				$isMobileTabTv	= 0;
			}else{
				$isMobileTabTv = $isMobileTabTv1;
			}
		}
		//print_r($data);exit;
        /*if(request('app_name') == 'BESTBOX'){
            if(!empty($data['imei_no']))
            {
                if($data['imei_no'] != request('imei_no') )
                {
                    return response()->json(['status'=>'Failure','message'=>'Imei nuumber not same'], 200);
                }
				}
        }*/

		//$udata = User::select('*')->where('rec_id', '=',$data['rec_id'])->first();




		if(!empty($data)){

			// if IP address is different to insert visitor table
			if($platform == 1){
				$device = "android";
			}else if($platform == 2){
				$device = "ios";
			}else{
				$device = "android";
			}
			$ipaddr = \Request::getClientIp(true);
			Log::info($data['rec_id']." requested IP Address ".$ipaddr);
			$chkIpaddress = Visitor::where('user_id', $data['rec_id'])->where('application_name', $app_name)->where('req_from', $device)->where('device_type', $isMobileTabTv)->orderBy("id", "DESC")->first();
			if(!empty($chkIpaddress)){
				$id = $chkIpaddress->id;
				$dbipAddr = $chkIpaddress->ip_address;
				Log::info($data['rec_id']." Database IP Address ".$dbipAddr);
				if($dbipAddr != $ipaddr){
					$visitorData = array(
								"user_id"=>$data['rec_id'],
								"username"=>$data['user_id'],
								"ip_address"=>$ipaddr,
								"req_from"=>$device,
								"application_name"=>$app_name,
								"device_type"=>$isMobileTabTv,
								"created_at"=>date("Y-m-d H:i:s")
								);

					$res = Visitor::insert($visitorData);
				}else{

					$visitorData = array(
								"ip_address"=>$ipaddr,
								"req_from"=>$device,
								"application_name"=>$app_name,
								"device_type"=>$isMobileTabTv,
								"updated_at"=>date("Y-m-d H:i:s")
								);
					$res = Visitor::where('id', $id)->update($visitorData);

				}
			}

			//check tab/mobile version
			$settings = Settings::where('id',1)->first();
			if($platform == 1){
				$bestbox_tv_version = $settings['android_app_code']; // bestbox
				$tab_mobile_version_settings = $settings['tab_mobile_android_version']; // vodrex
			}else{
				$bestbox_tv_version = $settings['ios_app_version']; // bestbox
				$tab_mobile_version_settings = $settings['tab_mobile_ios_version']; // vodrex
			}

			/*if($isTv != 1){
				if(request('user_mobile_app_version') < $tab_mobile_version_settings){
					 return response()->json(['status'=>'Failure','message'=>'New version of VODREX  has been detected, please upgrade now','is_update'=>1], 200);
				}
			}*/
			 $requestedVodrexVersion = request('user_mobile_app_version');
			 $requestedBestBoxTvVersion = (string)request('user_tv_version');
			 $checkedVersion = "1.2.3"; 
			 $version_compare = version_compare($requestedBestBoxTvVersion,  $checkedVersion);
			//var_dump($requestedBestBoxTvVersion); exit;
			if($app_name == "BESTBOX" && $isTv == 1 && $version_compare != "-1"){
				if(request('user_tv_version') < $bestbox_tv_version){
					 return response()->json(['status'=>'Failure','message'=>'New version of BESTBOX  has been detected, please upgrade now','is_update'=>1], 200);
				}
			}else{
				if($app_name == "VODREX"){
					if(request('user_mobile_app_version') < $tab_mobile_version_settings){
						 return response()->json(['status'=>'Failure','message'=>'New version of VODREX  has been detected, please upgrade now','is_update'=>1], 200);
					}
				}

			}
			
			//update user tv version
			if(!empty($isTv)){
				//update user tv app version
				if(!empty(request('user_tv_version'))){
					User::where('rec_id', $data['rec_id'])->update(['user_tv_version' => request('user_tv_version')]);
				}
			}

			//update user mobile app version
			if(!empty(request('user_mobile_app_version'))){
				User::where('rec_id', $data['rec_id'])->update(['user_mobile_app_version' => request('user_mobile_app_version'),'user_mobile_versionname' =>request('user_mobile_versionname')]);
			}

			// wallet Balance
			$walletInfo = Wallet::where('user_id',"=",$data['rec_id'])->first();
			if(!empty($walletInfo)){
				$wallet_Balance = number_format($walletInfo->amount,2);
				$walletBalance = $wallet_Balance;
			}else{
				$walletBalance = "0.00";
			}

			// if logged user is super admin
			// 1- Super admin, 2-reseller , 3-agents, 4-customer
			if($data['user_role'] == 1){
				// get menus based on role
				$Leftmenu_display_location = 2;
				$leftMenusList = ""; //self::getAdminMenusBasedOnRoleNew($data['user_role'],$Leftmenu_display_location);
				$dashboardMenu = "";
			   $totalResellers = User::where('user_role',"=",2)->count();
			   $totalAgents = User::where('user_role',"=",3)->count();
			   $totalCustomers = User::where('user_role',"=",4)->count();

			   $tot_comm = Commissions::sum('commission');
			   $total_commission=number_format($tot_comm,2);

			   $pkgName = "";
			   $pkgValue = "";
			   $subscription_date = "";
			   $expiry_date = "";
			   $total_referrals = "";
			   $total_referred_earnings = "";
			   $is_recharge = "";
			   $subscription_present_value = "0.00";
			   $total_sales="";
			   $referral_desc = '';
			   $pkg_status = "";
			   $pkg_color = "";
			   $topBannerImages = "";
				$expiryDays = "";
				$trial_requested_status = 0;
				$trial_requested_description="";
			   $trial_expired_status = 0;
			   $trial_expired_description = "";
			}else if($data['user_role'] == 2){
				// get menus based on role
				$Leftmenu_display_location = 2;
				$leftMenusList = self::getAdminMenusBasedOnRoleNew($data['user_role'],$Leftmenu_display_location);

				$dashboard_display_location = 3;
				$dashboardMenu = self::getAdminMenusBasedOnRoleNew($data['user_role'],$dashboard_display_location);

			   $totalResellers = "";
			   $totalAgents = User::where('user_role',"=",3)->where("status","=",1)->where('referral_userid',"=",$data['rec_id'])->count();
			   $totalCustomers = Users_tree::leftjoin('users','users_tree.customer_id','=','users.rec_id')->where("users.status",'=',1)->where("users_tree.reseller_id", $data['rec_id'])->where("users_tree.customer_id", "!=", 0)->where("users_tree.agent_id", "=", 0)->count();

			   $total_commission_amt=Commissions::where("user_id",$data['rec_id'])->sum('commission');
			   $total_commission=number_format($total_commission_amt,2);

			   $res = Users_tree::where("reseller_id",$data['rec_id'])->where("agent_id","!=",0)->groupBy("agent_id")->get();

			   $total_sales_amt=Sales::where("user_id",$data['rec_id'])->sum('sales_amount');

			    $tot_sales = $total_sales_amt;
				foreach ($res as $key => $value) {

					if ($data['user_role'] == 2) {
						$qs = Sales::where("user_id", $value->agent_id)->sum('sales_amount');
					}else if ($data['user_role'] == 3){
						$qs = Sales::where("user_id", $value->customer_id)->sum('sales_amount');
					}else{
						$res = array();
					}
					$tot_sales = $tot_sales + $qs;

				}

			   $total_sales=number_format($tot_sales,2);

			   $pkgName = "";
			   $pkgValue = "";
			   $subscription_date = "";
			   $expiry_date = "";
			   $total_referrals = "";
			   $total_referred_earnings = "";
			   $is_recharge = "";
			   $subscription_present_value = "0.00";
			   $pkg_status = "";
			   $pkg_color = "";
			   $topBannerImages = "";
			   $expiryDays = "";
			   $trial_requested_status = 0;
			   $trial_requested_description="";
			   $trial_expired_status = 0;
			   $trial_expired_description = "";
			   if(!empty($data['refferallink_text'])){
					$referral_link_text = $data['refferallink_text'];
					$referral_desc = 'Hi,<br/><br/>Here is your referral link: '.url('/').'/customerSignup/'.$referral_link_text.'<br/><br/>';
					$referral_desc .= '3 steps to getting your BestBOX<br/><br/>';
					$referral_desc .= '1. Open link above and create your account<br/><br/>';
					$referral_desc .= '2. Start your free trial from the dashboard.<br/><br/>';
					$referral_desc .= '3. After successful trial, order your preferred package.<br/><br/>';
					$referral_desc .= 'As easy as that.<br/><br/>';
					$referral_desc .= 'Enjoy.';
				}else{
					$referral_desc = '';
				}
			}else if($data['user_role'] == 3){
				// get menus based on role
				$Leftmenu_display_location = 2;
				$leftMenusList = self::getAdminMenusBasedOnRoleNew($data['user_role'],$Leftmenu_display_location);

				$dashboard_display_location = 3;
				$dashboardMenu = self::getAdminMenusBasedOnRoleNew($data['user_role'],$dashboard_display_location);

			   $totalResellers = "";

			   $totalAgents = User::where('user_role','=',3)->where('status','=',1)->where('referral_userid',$data['rec_id'])->count(); //Unilevel_tree::where('upliner_id','=',$data['rec_id'])->where('user_role','=',$data['user_role'])->count();
			   //$totalCustomers = User::where('user_role',"=",4)->where('referral_userid',"=",$data['rec_id'])->count();
			   $totalCustomers = Users_tree::leftjoin('users','users_tree.customer_id','=','users.rec_id')->where("users.status",'=',1)->where("users_tree.agent_id", $data['rec_id'])->where("users_tree.customer_id", "!=", 0)->where("users_tree.agent_id", "!=", 0)->count();

			   $total_commission_amt=Commissions::where("user_id",$data['rec_id'])->sum('commission');
			   $total_commission=number_format($total_commission_amt,2);

			   $res = Users_tree::where("agent_id",$data['rec_id'])->where("customer_id","!=",0)->groupBy("customer_id")->get();

			   $total_sales_amt=Sales::where("user_id",$data['rec_id'])->sum('sales_amount');
			   $tot_sales = $total_sales_amt;
			   foreach ($res as $key => $value) {
					//$qs = Sales::where("user_id", $value->agent_id)->sum('sales_amount');
					//$tot_sales = $tot_sales + $qs;

					if ($data['user_role'] == 2) {
						$qs = Sales::where("user_id", $value->agent_id)->sum('sales_amount');
					}else if ($data['user_role'] == 3){
						$qs = Sales::where("user_id", $value->customer_id)->sum('sales_amount');
					}else{
						$res = array();
					}
					$tot_sales = $tot_sales + $qs;

				}
			   $total_sales=number_format($tot_sales,2);

			   $pkgName = "";
			   $pkgValue = "";
			   $subscription_date = "";
			   $expiry_date = "";
			   $total_referrals = "";
			   $is_recharge = "";
			   $total_referred_earnings = "";
			   $subscription_present_value = "0.00";
			   $pkg_status = "";
			   $pkg_color = "";
			   $topBannerImages = "";
			   $expiryDays = "";
			   $trial_requested_status = 0;
			   $trial_requested_description="";
			   $trial_expired_status = 0;
			   $trial_expired_description = "";
			   if(!empty($data['refferallink_text'])){
					$referral_link_text = $data['refferallink_text'];
					$referral_desc = 'Hi,<br/><br/>Here is your referral link: '.url('/').'/customerSignup/'.$referral_link_text.'<br/><br/>';
					$referral_desc .= '3 steps to getting your BestBOX<br/><br/>';
					$referral_desc .= '1. Open link above and create your account.<br/><br/>';
					$referral_desc .= '2. Start your free trial from the dashboard.<br/><br/>';
					$referral_desc .= '3. After successful trial, order your preferred package.<br/><br/>';
					$referral_desc .= 'As easy as that.<br/>';
					$referral_desc .= 'Enjoy.';
				}else{
					$referral_desc = '';
				}

			}else if($data['user_role'] == 4){
				if($isTv == 1){
					//$topBannerImages = "";
					// $vodbannerImages = "";
					// $seriesbannerImages = "";
					// $livebannerImages = "";
				}else{
					//$topBannerImages = self::getTopBannerImages();
					// $vodbannerImages = self::getBanner('Movies');
					// $seriesbannerImages = self::getBanner('Series');
					// $livebannerImages = self::getBanner('Live');
					/*$vodbannerImages = array();
					$seriesbannerImages = array();
					$livebannerImages =array();*/
					// $topBannerImages = array_merge($vodbannerImages, $seriesbannerImages, $livebannerImages);
					// shuffle($topBannerImages);
				}


			   $Leftmenu_display_location = 2;
			   $leftMenusList = ""; //self::getAdminMenusBasedOnRoleNew($data['user_role'],$Leftmenu_display_location);

			   $dashboard_display_location = 3;
			   $dashboardMenu = ""; //self::getAdminMenusBasedOnRoleNew($data['user_role'],$dashboard_display_location);


			   $totalResellers = "";
			   $totalAgents = "";
			   $is_recharge = 1;
			   // get Total Referalls , 'package_purchased_list.active_package' => 1
			   /*$total_referrals = User::join('package_purchased_list','package_purchased_list.user_id','=','users.rec_id')
									->where(['users.referral_userid' => $data['rec_id']])->count();
				*/
				$total_referrals = Commissions::where("user_id",$data['rec_id'])->where("commission_type",'=','Referral Bonus')->count();

			  // get sum Bonus(Referalls earnings)
			   $referred_earnings = Commissions::where("user_id",$data['rec_id'])->where("commission_type",'=','Referral Bonus')->sum('commission');
			   $total_referred_earnings = number_format($referred_earnings,2);

			   $totalCustomers = ""; //User::where("user_role",4)->where("referral_userid",$data['rec_id'])->count();

			   //$total_commission_amt=Commissions::where("user_id",$data['rec_id'])->sum('commission');
			   $total_commission= ""; //number_format($total_commission_amt,2);

			   //$total_sales_amt=Sales::where("user_id",$data['rec_id'])->sum('sales_amount');
			   $total_sales= ""; //number_format($total_sales_amt,2);

			   // get active package info
			   $packagesInfo = Package_purchase_list::select('*')->where('user_id','=',$data['rec_id'])->where('active_package','=',1)->orderBy("rec_id", "DESC")->first();
			   if(!empty($packagesInfo)){
				   $pkgId = $packagesInfo->package_id;
				   $res = Packages::select('*')->where('id','=',$pkgId)->first();
				   $pkgName = $res->package_name;
				   $pkgValue = number_format($res->effective_amount,2);
				   $effective_amount = $res->effective_amount;
				    if($packagesInfo->expiry_date == NULL){
					   $is_package_purchased = "no";
					}else{
						$is_package_purchased = "yes";
					}

				   $subscription_date = self::convertDateToUTCForAPI($packagesInfo->subscription_date);
				   $expiry_date = self::convertDateToUTCForAPI($packagesInfo->expiry_date);

				   $start_date = date('Y-m-d',strtotime($packagesInfo->subscription_date));
				   $end_date = date('Y-m-d',strtotime($packagesInfo->expiry_date));
				   $noofdays = self::dateDiff($start_date, $end_date);

				   if($pkgId == 11){
				   		$subscription_present_value = "0.00";
						$pkg_status = "";
						$pkg_color = "";
				   }else{

					    if($packagesInfo->expiry_date < NOW()){
							$pkg_status = "Expired";
							$pkg_color = "red";
							$subscription_present_value = "0.00";
							$expiryDays = "";
						}else{

							$singleday_amt = $effective_amount/$noofdays;

						   $current_date = date('Y-m-d');
						   $compareTodaydatedays = self::dateDiff($start_date, $current_date);
						   $currentdiffAmt = $compareTodaydatedays * $singleday_amt;

						   $subscription_present_value1 = $effective_amount - $currentdiffAmt;
						   $subscription_present_value = number_format($subscription_present_value1,2);

						   $pkg_status = "Active";
						   $pkg_color = "green";

							$current_date1 = date('Y-m-d H:i:s');
							$start_date = date('Y-m-d H:i:s',strtotime($current_date1));
							$end_date = date('Y-m-d H:i:s',strtotime($packagesInfo->expiry_date));
							$expiry_days = self::expirydateDiff($start_date, $end_date);

							if($expiry_days <= 7){
								/*if( ($expiry_days >=0) && ($expiry_days <= 7) ){
									$expiryDays = $expiry_days;
								}else{
									$expiryDays = $expiry_days;
								}*/
								$expiryDays = $expiry_days;
							}else{
								$expiryDays = "";
							}


						}

				   }



				}else{
					$pkgName = "";
					$pkgValue = "";
					$subscription_date = "";
					$expiry_date = "";
					$subscription_present_value = "0.00";
					$pkg_status = "";
					$pkg_color = "";
					$expiryDays = "";
					$is_package_purchased = "no";
				}

				if(!empty($data['refferallink_text'])){
					$referral_link_text = $data['refferallink_text'];
					$referral_desc = 'Hi,<br/><br/>Here is your referral link: '.url('/').'/customerSignup/'.$referral_link_text.'<br/><br/>';
					$referral_desc .= '3 steps to getting your BestBOX<br/><br/>';
					$referral_desc .= '1. Open link above and create your account.<br/><br/>';
					$referral_desc .= '2. Start your free trial from the dashboard.<br/><br/>';
					$referral_desc .= '3. After successful trial, order your preferred package.<br/><br/>';
					$referral_desc .= 'As easy as that.<br/><br/>';
					$referral_desc .= 'Enjoy.';
				}else{
					$referral_desc = '';
				}

				// check trial requested status
				if($is_package_purchased == "no"){
					$trial_status = Free_trail_requested_users::select('*')->where('user_id','=',$data['rec_id'])->where('status','=',3)->first();
					if(@count($trial_status) > 0){
						if(@count($trial_status) == 1){
							$trial_requested_status = 1; // Admin approved
							//get trial setting hours
							$settingTime = ApplicationSettings::select('*')->where('id','=',1)->first();
							if(!empty($settingTime)){
								$minimum_time = unserialize($settingTime->setting_value);
								$trial_duration = $minimum_time['trail_duration'];

							}else{
								$trial_duration = 0;
							}
							$trial_requested_description = 'and you can now start enjoying the latest content and channels from BestBOX';
						}else{
							$trial_requested_status = 0; // Admin not approved yet
							$trial_requested_description = "";
						}

					}else{
						$trial_requested_status = 0; // Admin not approved
						$trial_requested_description = "";
					}
				}else{
					$trial_requested_status = 0;
					$trial_requested_description = "";
				}

				//check trial expired status
				$trial_expiry_status = Free_trail_requested_users::select('*')->where('user_id','=',$data['rec_id'])->where('status','=',2)->first();
				if($is_package_purchased == "no"){
					if(@count($trial_expiry_status) > 0){

						$trial_expired_status = 1; 	 // trial period expired
						$trial_expired_description = "To continue please visit our website to purchase subscription package of your choice.";
					}else{
						$trial_expired_status = 0;  // trial period  not taken or going on
						$trial_expired_description = "";
					}
				}else{
					$trial_expired_status = 0;  // trial period  not taken or going on
					$trial_expired_description = "";
				}


			}else{
			   $totalResellers = "";
			   $totalAgents = "";
			   $totalCustomers = "";
			   $total_commission = "";
			   $total_sales = "";
			   $pkgName = "";
			   $pkgValue = "";
			   $subscription_date = "";
			   $expiry_date = "";
			   $total_referrals = "";
			   $total_referred_earnings = "";
			   $is_recharge = "";
			   $subscription_present_value = "0.00";
			   $referral_desc = '';
			   $topBannerImages = "";
			   $leftMenusList = "";
			   $expiryDays = "";
			   $trial_requested_status = 0;
			   $trial_requested_description="";
			   $trial_expired_status = 0;
			   $trial_expired_description = "";
			   // $vodbannerImages = "";
			   // $livebannerImages = "";
			   // $seriesbannerImages = "";
			   $is_package_purchased = "no";
			}



			/*$both_display_location = 1;
			$bothMenusList = self::getAdminMenusBasedOnRoleNew($data['user_role'],$both_display_location);
			*/
			// get country Name
			$countryInfo = Country::select('*')->where('countryid', '=',$data['country_id'])->first();
			if(!empty($countryInfo)){
				$countryName = 	$countryInfo->country_name;
				$nationality = 	$countryInfo->nationality;
			}else{
				$countryName = "";
				$nationality = "";
			}

			// get Referred user info
			$referredInfo = User::select('*')->where('rec_id', '=',$data['referral_userid'])->first();
			if(!empty($referredInfo)){
				$referredName = $referredInfo->first_name." ".$referredInfo->last_name;
			}else{
				$referredName = "";
			}

			if($data['commission_perc'] === NULL){
				$comminsion_per = "";
			}else{
				$comminsion_per = $data['commission_perc'];
			}

			if($data['referral_userid'] === NULL){
				$referral_userid = "";
			}else{
				$referral_userid = $data['referral_userid'];
			}

			if($data['address'] === NULL){
				$address = "";
			}else{
				$address = $data['address'];
			}

			$userName = $data['first_name']." ".$data['last_name'];
			$profileImage = $data['image'];
			if(!empty($profileImage)){
				$profile_pic = 	$profileImage;
			}else{
				$profile_pic = "avatar.png";
			}
			$iptvCountry_id = $data['iptv_country_id'];
			if($iptvCountry_id == 0){
				$iptv_country_id = 	"";
			}else{
				$iptv_country_id = $iptvCountry_id;
			}
			$iptv_country_name = $data['iptv_country_name'];
			$iptv_country_flag = $data['iptv_country_flag'];
			//$encrypted_username=safe_encrypt($data['cms_username'],config('constants.encrypt_key'));
			//$encrypted_password=safe_encrypt($data['cms_password'],config('constants.encrypt_key'));
			/*
				"iptv_live"=>"http://portal.geniptv.com:8080/live/",
				"iptv_player"=>"http://portal.geniptv.com:8080/player_api.php?",
				"iptv_vod"=>"https://info.m4g.app/get_vod.php?",
				"iptv_catchup"=>"https://info.m4g.app/catchup/get2.php?",
			*/
            // IPTV Config Info
            if($data['rec_id'] == 1914) {
                $is_package_purchased = "yes";
            }
			if(!empty($client_id)){
				$iptv_info = IptvConfigURLS::where('client_id','=',$client_id)->first();
				$config_info = array(
							"proxy_streaming"=>$iptv_info->proxy_streaming,
							"proxy_vod"=>$iptv_info->proxy_vod,
							"proxy_catchup"=>$iptv_info->proxy_catchup,
							"iptv_live"=>$iptv_info->iptv_live,
							"iptv_player"=>$iptv_info->iptv_player,
							"iptv_vod"=>$iptv_info->iptv_vod,
							"iptv_catchup"=>$iptv_info->iptv_catchup,
							"is_package_purchased"=>$is_package_purchased,
							"iptv_username"=>$data['cms_username'],
							"iptv_pw"=>$data['cms_password'],
							"trial_requested_status"=>$trial_requested_status,
							"trial_requested_description"=>$trial_requested_description,
							"trial_expired_status"=>$trial_expired_status,
							"trial_expired_description"=>$trial_expired_description
							);


			}else{
				$iptv_info = IptvConfigURLS::where('rec_id','=',1)->first();
				$config_info = array(
							"proxy_streaming"=>$iptv_info->proxy_streaming,
							"proxy_vod"=>$iptv_info->proxy_vod,
							"proxy_catchup"=>$iptv_info->proxy_catchup,
							"iptv_live"=>$iptv_info->iptv_live,
							"iptv_player"=>$iptv_info->iptv_player,
							"iptv_vod"=>$iptv_info->iptv_vod,
							"iptv_catchup"=>$iptv_info->iptv_catchup,
							"is_package_purchased"=>$is_package_purchased,
							"iptv_username"=>$data['cms_username'],
							"iptv_pw"=>$data['cms_password'],
							"trial_requested_status"=>$trial_requested_status,
							"trial_requested_description"=>$trial_requested_description,
							"trial_expired_status"=>$trial_expired_status,
							"trial_expired_description"=>$trial_expired_description
							);


			}

			$application_id = "";$application_name="";$support_email="";$web_url="";$main_logo="";
			if(!empty($client_id)){
				$info = ApplicationsInfo::where('application_id','=',$client_id)->first();
				if(!empty($info)){
					$application_id = $info->application_id;
					$application_name = $info->application_name;
					$support_email = $info->support_email;
					$web_url = $info->web_url;
					$main_logo = $info->main_logo;
				}
			}

			// mobile versions
			//$settings = Settings::where('id',1)->first();
			$is_force_logout = (int)$data['is_force_logout'];
			if(!empty($data['mbl_platform'])){
				if($data['mbl_platform'] == 'android'){
					$version_settings = (int)$settings['android_app_version'];
				}else{
					$version_settings = $settings['ios_app_version'];
				}
			}else{
				$version_settings = "";
			}



			$registred_date = self::convertDateToUTCForAPI($data['registration_date']);

			//whether vod, livetv, series data updated or not
			$is_vod_update_flag = 0; $is_livetv_update_flag = 0; $is_series_update_flag = 0;$home_update_flag = 0;$device_limit_msg = '';$is_device_limit_logout = 0;$device_limit_logout_msg = '';
			$deviceIdExistOrNot = UsersDevicesList::where(['user_id' => $data['rec_id'], 'device_id' => $device_id,'application_name' => $app_name])->first();
			if(@count($deviceIdExistOrNot) > 0){
				$is_vod_update_flag = $deviceIdExistOrNot->is_vod_update_flag;
				$is_livetv_update_flag = $deviceIdExistOrNot->is_livetv_update_flag;
				$is_series_update_flag = $deviceIdExistOrNot->is_series_update_flag;
				$home_update_flag = $deviceIdExistOrNot->home_update_flag;
				if($deviceIdExistOrNot->is_login == 0) {
					$checkedTvVersion = "1.2.1";$checkedMobileVersion = "1.0.9"; //for old users 
					if($requestedBestBoxTvVersion >= $checkedTvVersion || (string)$requestedVodrexVersion>= $checkedMobileVersion){
						$is_device_limit_logout = 1;
						$device_limit_logout_msg = 'You have been logged out as your account has reached the maximum login limit of 2 devices per account.';
					}
				}
			}

			// $logged_in_device_count = UsersDevicesList::where(['user_id' => $data['rec_id'], 'is_login' => 1])->count();
			// if($data['is_online']){
            //      $logged_in_device_count = $logged_in_device_count+1;
            // }
			// $device_limit_msg = '';
			// if($logged_in_device_count >2){
			//  	$device_limit_msg = 'You have logged in with more than 2 devices.Because, you are logged out from this Device';
			//  }

			//for live tv menu permisssion

			$userpackData = Package_purchase_list::leftjoin('packages', 'package_purchased_list.package_id', '=', 'packages.id')->select('packages.id', 'package_purchased_list.expiry_date','package_purchased_list.active_package','packages.package_name','packages.setupbox_status','packages.vod_series_package')->where('package_purchased_list.user_id', $data['rec_id'])->where('package_purchased_list.package_id','!=',11)->where('package_purchased_list.active_package','=',1)->orderBy('package_purchased_list.rec_id','DESC')->first();

			$trail_period_status = Free_trail_requested_users::where(['user_id' => $data['rec_id'], 'status' => 1])->count();
			$live_videos_permission = 0;$livetv_alert_msg = '';
			$package_id = '';$live_tv_access = 1;

			if(!empty($userpackData)){
				$package_id = $userpackData->id;
				if($userpackData->vod_series_package == 1) $live_videos_permission = 1;
			}

			if($live_videos_permission == 1 && $package_id != ''){
				$live_tv_access = 0;
				$livetv_alert_msg = "Live channels are not accessable for this package";
			}else if($live_videos_permission == 0 && $package_id != ''){
				$live_tv_access = 1;
			}else if($trail_period_status>0 && ($live_videos_permission == 0 && $package_id == '')){
				$live_tv_access = 1;
			}

			//popup announcements
			$announcement_data = array();
			$date = date('Y-m-d');
			$announcement_list = \App\Announcements::where('expiry_date','>=',$date)->orwhereNull('expiry_date')->where('announcement_type',2)->orderby('id','desc')->get();
			if(!empty($announcement_list)){
				foreach($announcement_list as $list) {
					$users_list = unserialize($list['users']);
					if(!empty($users_list)){
						foreach($users_list as $user){
							if($data['rec_id'] == $user['rec_id'] && $user['flag'] == 1){
								$announcement_data[] = array('title' => $list['title'], 'description' => $list['description'], 'created_date' => $list['created_at'], 'expiry_date' => $list['expiry_date']);
							}
						}
					}
				}
			}
			
			$user_info = array("rec_id"=>$data['rec_id'],"user_id"=>$data['user_id'],"email"=>$data['email'],"first_name"=>$data['first_name'],"last_name"=>$data['last_name'],"status"=>$data['status'],"countryName"=>$countryName,"image"=>$profile_pic,"telephone"=>$data['telephone'],"registred_date"=>$registred_date,"user_role"=>$data['user_role'],"referral_link"=>$data['refferallink_text'],"address"=>$address,"imei_no"=>$data['imei_no'],"device_id"=>$data['device_id'],"mbl_platform"=>$data['mbl_platform'],"is_installed_app"=>$data['is_installed_app'],"is_recharge"=>$is_recharge,"referral_earnings"=>$total_referred_earnings,"total_referrals"=>$total_referrals,"subscription_plan"=>$pkgName,"subscription_value"=>$pkgValue,"subscription_present_value"=>$subscription_present_value,"subscription_date"=>$subscription_date,"subscription_expiry_date"=>$expiry_date,"pkg_status"=>$pkg_status,"pkg_status_color"=>$pkg_color,"referral_desc"=>$referral_desc,"iptv_country_id"=>$iptv_country_id,"iptv_country_name"=>$iptv_country_name,"iptv_country_flag"=>$iptv_country_flag,"app_version"=>$version_settings,"download_path"=>"api/sampletest.json","application_id"=>$application_id,"application_name"=>$application_name,"expiryDays"=>$expiryDays,"web_url"=>$web_url,"main_logo"=>$main_logo,"is_force_logout"=>$is_force_logout,"is_trail"=>$data['is_trail'],'is_vod_update_flag' => $is_vod_update_flag, 'is_livetv_update_flag' => $is_livetv_update_flag, 'is_series_update_flag' => $is_series_update_flag, 'home_update_flag' => $home_update_flag, 'is_device_limit_logout' => $is_device_limit_logout, 'device_limit_msg' => $device_limit_msg, 'device_limit_logout_msg' => $device_limit_logout_msg,'live_tv_access' => $live_tv_access, 'livetv_alert_msg' => $livetv_alert_msg);


			return response()->json(['status'=>'Success','user_info'=>$user_info,'left_menu'=>$leftMenusList,'dashboard'=>$dashboardMenu,'bannerImages'=>'','config_info'=>$config_info,'totalResellers'=>$totalResellers,'totalAgents'=>$totalAgents,'totalCustomers'=>$totalCustomers,'totalSales'=>$total_sales,'currency_symbol'=>'$','walletBalance'=>$walletBalance,'currency_format'=>'USD','totalCommission'=>$total_commission, 'announcement_data' => $announcement_data , 'announcement_logo' => 'announcement.png' ], 200);
			//}

		}else{
			return response()->json(['status'=>'Failure','user_info'=>"Something went wrong in query" ], 200);
		}



	}




	// get Admin Menus Based On Role
	/*public static function getAdminMenusBasedOnRoleNew($user_role,$display_location) {

		if(!empty($user_role) && !empty($display_location) ) {

			if($user_role == 2){
				$columnName = "reseller";
			}else if($user_role == 3){
				$columnName = "agent";
			}else if($user_role == 4){
				$columnName = "customer";
			}else{

			}


			$left_menu_q = MobileLeftMenu::where('status','=',1)->whereIn('display_location', [1, $display_location])->where($columnName,'=',1)->orderBy('id','ASC')->get();

			$menu_dd = array();
			if (@count($left_menu_q) > 0) {

				foreach ($left_menu_q as $data) {
					$menu_id = $data['id'];
					$menu = $data['menu_name'];
					//$menuURL = $data['menu_link'];
					$menu_icon = $data['menu_icon'];
					$menu_dd[] = array(
						"id" => $menu_id,
						"menu_name" => $menu,
						"icon" => $menu_icon,

					);

				}

			}

			return $menu_dd;
		} else {
			//return response()->json(['status' => 'Failure', 'Result' => $res['Result']], 200);
			return "";
		}

	}*/

	// get topbanner images
	public static function getTopBannerImages()
	{
		$recent_movies_q = Recent_movies_images::where('status','=',1)->orderBy('rec_id','DESC')->get();
		$images_dd = array();
		if(!empty($recent_movies_q)){
			foreach ($recent_movies_q as $image) {
				$movie_image = $image['movie_image'];
				$movie_link = $image['movie_link'];

				$images_dd[] = array(
						"movie_image" => $movie_image,
						"movie_link" => $movie_link,
					);

			}

		}
		return $images_dd;

	}

	// get Admin Menus Based On Role
	public static function getAdminMenusBasedOnRoleNew($user_role,$display_location) {

		if(!empty($user_role) && !empty($display_location) ) {

			if($user_role == 2){
				$columnName = "reseller";
			}else if($user_role == 3){
				$columnName = "agent";
			}else if($user_role == 4){
				$columnName = "customer";
			}else{
				$columnName = "";
			}


			$left_menu_q = MobileLeftMenu::where('parent_menu_id','=',0)->where('status','=',1)->whereIn('display_location', [1, $display_location])->where($columnName,'=',1)->orderBy('menu_order','ASC')->get();

			$menu_dd = array();
			if (@count($left_menu_q) > 0) {

				foreach ($left_menu_q as $data) {
					$menu_id = $data['id'];
					$menu = $data['menu_name'];
					$menu_link = $data['menu_link'];
					$menu_icon = $data['menu_icon'];
					$dashboard_top = $data['display_dashboard_at'];
					//Get Submenus

					$sub_menu_q = MobileLeftMenu::where('status', "=", 1)->where('parent_menu_id', $menu_id)->whereIn('display_location', [1, $display_location])->where($columnName,'=',1)->orderBy('menu_order','ASC')->get();
					$children = array();
					if (@count($sub_menu_q) > 0) {

						foreach ($sub_menu_q as $sub_data) {
							$sub_menu_id = $sub_data['id'];
							$sub_menu_nm = $sub_data['menu_name'];
							$sub_menu_link = $sub_data['menu_link'];
							$sub_menu_icon = $sub_data['menu_icon'];
							$sub_dashboard_top = $sub_data['display_dashboard_at'];
							$children[] = array(
									"id" => $sub_menu_id,
									"menu_name" => $sub_menu_nm,
									"menu_link" => $sub_menu_link,
									"icon" => $sub_menu_icon,
									"dashboard_top" => $sub_dashboard_top,

								);

						}

					} else {
						$children = array();
					}

					$menu_dd[] = array(
						"id" => $menu_id,
						"menu_name" => $menu,
						"menu_link" => $menu_link,
						"icon" => $menu_icon,
						"dashboard_top" => $dashboard_top,
						"children" => $children,
					);

				}

			}

			return $menu_dd;
		} else {
			return "";
		}

	}

	//update IPTV Country Name  Country ID
	public function updateIptvCountryName(Request $request)
	{
		$userInfo = $request->user();
		$rec_id = $userInfo['rec_id'];
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
        $validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
			'iptv_country_id'=>'required',
			'iptv_country_name'=>'required',
			'iptv_country_flag'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);
        }else{

			$iptv_country_id = request('iptv_country_id');
			$iptv_country_name = request('iptv_country_name');
			$iptv_country_flag = request('iptv_country_flag');
			$data = array("iptv_country_id"=>$iptv_country_id,"iptv_country_name"=>$iptv_country_name,"iptv_country_flag"=>$iptv_country_flag);
			$res = User::where('rec_id','=',$rec_id)->update($data);
			if($res){
				return response()->json(['status'=>'Success','Result'=>"updated Successfully"], 200);
			}else{
				return response()->json(['status'=>'Failure','Result'=>"Something Went wrong update Query"], 200);
			}

        }
	}

	public function logout(Request $request){
		$userInfo = $request->user();
		$user_id = $userInfo['rec_id'];
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
        $validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
			'offline_status' => 'required',
			'device_id'  => 'required'
		]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);
        }else{
        	$offline_status = request('offline_status');
			$device_id = request('device_id');
			$app_name = request('app_name');
        	$res = UsersDevicesList::where(['user_id' => $user_id, 'device_id' => $device_id, 'application_name' => $app_name])->update(['is_online' => $offline_status, 'is_login' => 0]);
			return response()->json(['status'=>'Success','Result'=>"Logout Successfully"], 200);
        }
	}


	public function isOfflineRequest(Request $request){
		$userInfo = $request->user();
		$user_id = $userInfo['rec_id'];
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
        $validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
			'offline_status' => 'required',
			//'device_id'  => 'required'
		]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);
        }else{
			$offline_status = (int)request('offline_status');
			$device_id = request('device_id');
			$app_name = request('app_name');

			$device_limit = UsersDevicesList::where(['user_id' => $user_id, 'is_online' => 1])->count();
			if($userInfo['is_online']){
                $device_limit = $device_limit+1;
            }
			// if($offline_status == 1 && $device_limit>2) {
			// 	return response()->json(['status'=>'Failure','Result'=>"You have logged in with more than 2 devices. Please log out of another device to use this device"], 200);
			// }else{
				$res = UsersDevicesList::where(['user_id' => $user_id, 'device_id' => $device_id, 'application_name' => $app_name])->update(['is_online' => $offline_status]);

				return response()->json(['status'=>'Success','Result'=>"Offline status updated Successfully"], 200);
			//}

		}
	}

	public function subscribeUser(Request $request){
		$userInfo = $request->user();
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
        $validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
			'package'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);
        }else{
        	$iptvDB = DB::connection('iptv');
        	/*try {
			    $iptvDB->getPdo();
			} catch (\Exception $e) {
			    die("Could not connect to the database.  Please check your configuration. error:" . $e );
			}*/
			$package=request('package');
			$package_res = $iptvDB->table('packages')->where('id',$package)->first();

			$package_duration="0";
			if($package_res->is_trial==1){
				$package_duration=$package_res->trial_duration.' '.$package_res->trial_duration_in;
			}else{
				$package_duration=$package_res->official_duration.' '.$package_res->official_duration_in;
			}
			//print_r($res);exit;
        	$api_result=self::createIPTVLine($userInfo['user_id'],$package_res->bouquets,$package_duration);
        	$result=$api_result;
        	if($result->result=='true'){
        		$subject="Create User";
	            $data['useremail'] = array('name' => $userInfo['first_name']." ".$userInfo['last_name'],'toemail' => $userInfo['email']);
				$emailid = array('toemail' => $userInfo['email']);
				Mail::send(['html' => 'email_templates.create_user'], $data, function ($message) use ($emailid) {
					$message->to("sridharpendota27@gmail.com", 'Create User')->subject("Create User");
					$message->from('support@bestbox.net', 'BestBox');
				});
        	}else{
        		return response()->json(['status'=>'Failure','Result'=>$result->error], 200);
        	}
        }
	}

	public static function createIPTVLine($username,$bouquet_ids,$package_duration){
		$panel_url = config('constants.IPTV_API_LINK');
		$password = self::random_num();
		$max_connections = 1;
		$reseller = 1;
		$expire_date = strtotime( "+".$package_duration );

		###############################################################################
		$post_data = array( 'user_data' => array(
		        'username' => $username,
		        'password' => $password,
		        'max_connections﻿' => $max_connections,
		        'is_restreamer﻿' => $reseller,
				'exp_date' => $expire_date,
				'bouquet' => json_encode( $bouquet_ids )) );

		$opts = array( 'http' => array(
		        'method' => 'POST',
		        'header' => "Content-type: application/x-www-form-urlencoded\r\n"
		                . "Content-Length: " . strlen(http_build_query( $post_data )) . "\r\n",
		        'content' => http_build_query( $post_data ) ) );

		$context = stream_context_create( $opts );
		$api_result = json_decode( file_get_contents( $panel_url . "api.php?action=user&sub=create", false, $context ) );
		return $api_result;
	}
	public static function random_num($size=9) {
		$alpha_key = '';
		$keys = range('A', 'Z');

		for ($i = 0; $i < 2; $i++) {
			$alpha_key .= $keys[array_rand($keys)];
		}

		$length = $size - 2;

		$key = '';
		$keys = range(0, 9);

		for ($i = 0; $i < $length; $i++) {
			$key .= $keys[array_rand($keys)];
		}

		return $alpha_key . $key;
	}

	// Disable IOS badge count
	public function disableBadgeCount(Request $request)
    {
        $userDdata = $request->user();
        $applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
	}
	public static function getBanner($type)
	{
		if($type == 'Live'){
		$recent_movies_q  = DB::connection('mysql2')->select('select `poster_image`  as `movie_image`, `video_url` as `movie_link`, `slug`,`id`, `title` from `videos` where `is_live` = 1 and `is_active` = 1 and job_status= "Complete" and is_adult = 0 and is_archived = 0 and `poster_image` is not null order by `id` desc limit 5');
		}else if($type == 'Series'){
		$recent_movies_q  =  DB::connection('mysql2')->select('select `poster_image` as `movie_image`, `poster_image` as `movie_link`, `slug`,`id`,`title` from `video_webseries_detail` where `is_active` = 1 and `poster_image` is not null order by `id` desc limit 5');
		}else if($type == 'Movies'){
		$recent_movies_q  =  DB::connection('mysql2')->select('select `poster_image`  as `movie_image`, `video_url` as `movie_link`,`slug`,`id`, `title` from `videos` where `is_live` = 0 and `is_active` = 1 and is_adult = 0 and `is_webseries` = 0 and `poster_image` is not null order by `id` desc limit 5');
		}


		$images_dd = array();
		if(!empty($recent_movies_q)){
		foreach ($recent_movies_q as $image) {
		$movie_image = $image->movie_image;
		$movie_link = $image->movie_link;
		$slug = $image->slug;
		$id = $image->id;
		$images_dd[] = array(
			"movie_image" => $movie_image,
			"movie_link" => $movie_link,
			"slug" => $slug,
			"id" => $id
		);

		}

		}
		return $images_dd;

	}

	//update vod , live tv, series updated flag in UsersDevicesList table
	public function updateVLSChangeFlag(Request $request)
	{
		$userInfo = $request->user();
		$user_id = $userInfo['rec_id'];
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
        $validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
			'device_id'=>'required',
			'field_name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);
        }else{
        	$field_name = request('field_name');
        	$app_name = request('app_name');
        	$device_id = request('device_id');
        	Log::info('field:'.request('field_name'));
        	//Log::info('Request:'.$request->all());
        	$data = array($field_name => 0);
			$res = UsersDevicesList::where(['user_id' => $user_id,'device_id' => $device_id,'application_name' => $app_name])->update($data);
			if($res){
				return response()->json(['status'=>'Success','Result'=>"updated Successfully"], 200);
			}else{
				return response()->json(['status'=>'Failure','Result'=>"Something Went wrong update Query"], 200);
			}
		}
	}

	public function maintananceDetails(Request $request)
	{
		$userInfo = $request->user();
		$user_id = $userInfo['rec_id'];
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
        $validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
		]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);
        }else{
			$maintanance_settings=ApplicationSettings::where('setting_name','maintanance_settings')->first();
			$maintanance_mode=array();
			if(!empty($maintanance_settings)){
				$maintanance_mode=unserialize($maintanance_settings['setting_value']);
			}
			return response()->json(['status'=>'Success','Result'=> array('is_vod_maintanance_flag'=>$maintanance_mode['is_vod_maintanance_flag'],'is_livetv_maintanance_flag'=>$maintanance_mode['is_livetv_maintanance_flag'],'is_series_maintanance_flag'=>$maintanance_mode['is_series_maintanance_flag'],
			'maintenance_image' => url('/').'/public/images/maintanance_mode.JPG')], 200);

		}

	}

	public function announcementPopup_flag_update(Request $request)
	{ 
		$userInfo = $request->user();
		$user_id = $userInfo['rec_id'];
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
        $validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
		]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);
        }else{
			$flag = 0;
			$data = $date = date('Y-m-d');
			$announcement_list = Announcements::where('announcement_type',2)->orderby('id','desc')->get();
			foreach($announcement_list as $list) {
				$users_list = unserialize($list['users']);
				$datalist = array();
				if(!empty($users_list)){
					foreach($users_list as $user){
						if($user_id == $user['rec_id'] && $user['flag'] == 1){
							$datalist[] = array('rec_id' => $user['rec_id'],'flag' => 0);
						}else{
							$datalist[] = array('rec_id' => $user['rec_id'],'flag' => $user['flag'] );
						}
					}
				}
				$res = Announcements::where('id',$list['id'])->update(['users' => serialize($datalist)]);
			}
			
			return response()->json(['status' => 'Success', 'Result' => 'Flag Updated Successfully'], 200);
		}
			
	}

}

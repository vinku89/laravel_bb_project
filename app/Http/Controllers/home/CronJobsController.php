<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\API\UserController;
use Validator;
use Session;
use App\User;
use App\Country;
use App\Wallet;
use App\RolesPermissions;
use App\Left_menu;
use App\MobileLeftMenu;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Sales;
use App\Users_tree;
use Carbon\Carbon;
use App\Packages;
use App\Package_purchase_list;
use App\EPG_list;
use App\EPG_list2;
use App\Commissions;
use App\Library\Common;
use App\Free_trail_cms_accounts;
use App\Free_trail_requested_users;
use Illuminate\Support\Facades\Log;
use App\ApplicationsInfo;
use App\UsersDevicesList;
class CronJobsController extends Controller
{

	public static function testCron()
	{
		$string_to_encrypt="Test";
		$key=config('constants.encrypt_key');
		echo $encrypted_string=safe_encrypt($string_to_encrypt,$key);
		echo " ";
		echo $decrypted_string=safe_decrypt($encrypted_string,$key);
		/*echo $en= safe_b64encode("sridhar/sri+sr");
		echo " ";
		echo $dc=safe_b64decode($en);*/

	}

	public static function dateDiff($date1, $date2)
	{
	  $date1_ts = strtotime($date1);
	  $date2_ts = strtotime($date2);
	  $diff = $date2_ts - $date1_ts;
	  return round($diff / 86400);
	}

	public static function nagitive_check($value){
		if (isset($value)){
			if (substr(strval($value), 0, 1) == "-"){
				return 'negative';
			} else {
				return 'positive';
			}
		}
	}

	// package before seven days alert (FCM)

	public static function packageBeforeSevenDaysAlert()
	{
		$pkgPurchasedList = User::select('*')->where('user_role','=',4)->where('status','=',1)->get();
		if(@count($pkgPurchasedList)>0){

			foreach($pkgPurchasedList as $res){

				$rec_id = $res->rec_id;
				$user_id = $res->user_id;
				$application_id = $res->application_id;
				$email = $res->email;

				//$account_info = $user_id." ( ".$email." )";
				$account_info = $user_id;
				if(!empty($res->telephone)){
					$mobileno = $res->telephone;
				}else{
					$mobileno = "";
				}
				$pkg = Package_purchase_list::where('user_id','=',$rec_id)->where('package_id','!=',11)->where('active_package','=',1)->orderBy("rec_id", "DESC")->first();
				if(!empty($pkg)){
					$pkg_id = 	$pkg->package_id;
					$package_subscription_date = $pkg->subscription_date;
					$package_expiry_date = $pkg->expiry_date;

					$pkgDetails = Packages::where('id','=',$pkg_id)->first();
					if(!empty($pkgDetails)){
						$package_name = $pkgDetails->package_name;
						$package_image = $pkgDetails->package_image;
						$package_description = $pkgDetails->description;
						$package_amt = number_format($pkgDetails->effective_amount,2);
					}else{
						$package_name="";
						$package_image="";
						$package_description="";
						$package_amt = "";
					}


					$current_date = date('Y-m-d H:i:s');

					//$date = strtotime(date("Y-m-d", strtotime($date)) . " +1 day");
					 //$date = strtotime(date("Y-m-d", strtotime($date)) . " +30 days");

					//$before7days_date = strtotime(date("Y-m-d", strtotime($package_expiry_date)) . " -1 week");
					//$before7days = date("Y-m-d",$before7days_date);

					$start_date = date('Y-m-d H:i:s',strtotime($current_date));
					$end_date = date('Y-m-d H:i:s',strtotime($package_expiry_date));
					$noofdays = self::dateDiff($start_date, $end_date);

					Log::info($rec_id." bestbox number of days ".$noofdays);
					//echo $noofdays;
					// package will expired before 7days will send alert FCM


					$client_id="";$clientCode="";
					if(!empty($application_id)){
						$info = ApplicationsInfo::where('application_id','=',$application_id)->first();
						if(!empty($info)){
							$client_id = $info->application_id;
							$clientCode = $info->application_name;
						}
					}

					$is_positive = self::nagitive_check($noofdays);
					if( ($noofdays >=0) && ($noofdays <= 7) && ($is_positive =="positive") ) {
						//echo "tetete";exit;
						$icon = "success.png";
						$clienticon = "package-expiry.png";

						$new_time = UserController::convertDateToUTCForAPI(date("Y-m-d H:i:s"));
						if($noofdays == 0){
							$daysCount = "Today";
						}else if($noofdays == 1){
							$daysCount = $noofdays." day";
						}else{
							$daysCount = $noofdays." days";
						}
						$message = "Your account <b>".$account_info." </b> is going to expire in <b>".$daysCount." </b> please renew account to avoid interruption in service.please avoid message if already renewed.";

						$htmlMessage = "Your account <b>".$account_info." </b> is going to expire in <b>".$daysCount." </b> please renew account to avoid interruption in service.please avoid message if already renewed.";

						$htmlMessageIOS="Your account ".$account_info." is going to expire in ".$daysCount." please renew account to avoid interruption in service.please avoid message if already renewed.";


						$arr = array("Client_id" => $client_id,"ClientCode" => $clientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Account Information',"user_id" =>$rec_id,"MobileNo" =>$mobileno,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);


						$json_data["package_alert"] = json_encode($arr);



						if(!empty($res['device_id'])){

							$deviceIds = UsersDevicesList::where('user_id','=',$res['rec_id'])->get();

							if(@count($deviceIds) > 0){
								foreach ($deviceIds as $val) {
									$user_id = $val->user_id;
									$application_name = $val->application_name;
									$device_id = array($val->device_id);
									$device_id1 = $val->device_id;
									$device_type = $val->device_type;
									if(!empty($device_type)){
										if($device_type == "android"){
											$res = Common::sendFCMAndroid($device_id,$json_data,$mobileno, 'Package_Will_Expired_Soon',$application_name);
										}else{
											$res = Common::sendFCMIOS($device_id1,$json_data,$mobileno, 'Package_Will_Expired_Soon',$htmlMessageIOS,$application_name,$user_id);
										}
									}else{
										Log::info(" cronjob sevendays api not saved device type");
									}

								}
							}else{
								Log::info(" cronjob sevendays api not found device id");
							}



						}


					}else{
						//package expired FCM
						if($package_expiry_date < $current_date){
							Log::info($rec_id." bestbox package Expired ");
							$icon = "success.png";
							$clienticon = "package-expiry.png";

							$new_time = UserController::convertDateToUTCForAPI(date("Y-m-d H:i:s"));

							$message = "Your account <b>".$account_info." </b> is expired please renew account to resume your services.";

							$htmlMessage = "Your account <b>".$account_info." </b> is expired please renew account to resume your services.";

							$htmlMessageIOS="Your account ".$account_info." is expired please renew account to resume your services.";


							$arr = array("Client_id" => $client_id,"ClientCode" => $clientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Account Information',"user_id" =>$rec_id,"MobileNo" =>$mobileno,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);


							$json_data["package_alert"] = json_encode($arr);

							$device_id = array($res['device_id']);

							if(!empty($res['device_id'])){

								$deviceIds = UsersDevicesList::where('user_id','=',$res['rec_id'])->get();

								if(@count($deviceIds) > 0){
									foreach ($deviceIds as $val) {
										$user_id = $val->user_id;
										$application_name = $val->application_name;
										$device_id = array($val->device_id);

										$device_id1 = $val->device_id;
										$device_type = $val->device_type;
										if(!empty($device_type)){
											if($device_type == "android"){
												$res = Common::sendFCMAndroid($device_id,$json_data,$mobileno, 'Package_Expired',$application_name);
											}else{
												$res = Common::sendFCMIOS($device_id1,$json_data,$mobileno, 'Package_Expired',$htmlMessageIOS,$application_name,$user_id);
											}
										}else{
											Log::info(" cronjob sevendays api expired not found device type");
										}
									}
								}else{
									Log::info(" cronjob sevendays api expired not found device id");
								}



							}


						}else{
							Log::info(" bestbox package Expired else condition");
						}

					}


				}else{
					//Log::info("package not p ".$json_data["walletPriceAlert"]);
				}
			}
			//echo "send fcm";

		}


	}



	// Free trail expiry cron job
	public static function checkFreeTrailExpiryTime()
	{

		$current_date_time = date('Y-m-d H:i:s');
		$freetrailsUsers = Free_trail_requested_users::select('*')->where('status','=',1)->get();
		if(@count($freetrailsUsers) > 0){
			foreach($freetrailsUsers as $res){

				$rec_id = $res->rec_id;
				Log::info($rec_id." Trial expiry ");
				$user_id = $res->user_id;
				$userinfo = User::select('*')->where('rec_id','=',$user_id)->where('user_role','=',4)->where('status','=',1)->first();
				if(!empty($userinfo)){
					$user_rec_id = $userinfo->rec_id;
					$free_trail_user_id = $userinfo->user_id;
					$email = $userinfo->email;
					if(!empty($userinfo->telephone)){
						$mobileno = $userinfo->telephone;
					}else{
						$mobileno = "";
					}
					$device_id = $userinfo->device_id;
					$device_id_android = array($userinfo->device_id);

					$mbl_platform = $userinfo->mbl_platform;
					$application_id = $userinfo->application_id;

					$client_id="";$clientCode="";
					if(!empty($application_id)){
						$info = ApplicationsInfo::where('application_id','=',$application_id)->first();
						if(!empty($info)){
							$client_id = $info->application_id;
							$clientCode = $info->application_name;
						}
					}

				}else{
					$user_rec_id="";
					$user_id = "";
					$email = "";
					$mobileno = "";
					$device_id = "";
					$device_id_android = "";
					$mbl_platform = "";
					$client_id="";$clientCode="";$free_trail_user_id = "";
				}


				$account_info = $free_trail_user_id;

				$trail_end_time = $res->trail_end_time;
				$allocated_channel_id = $res->channel_id;

				if($trail_end_time < $current_date_time){

					Log::info($user_id." send fcm Trial expiry ");
					//change status free trails Users
					$data = array("status"=>2);
					$res = Free_trail_requested_users::where('rec_id','=',$rec_id)->update($data);

					//change status CMS accounts
					$data = array("is_available"=>1);
					$res = Free_trail_cms_accounts::where('rec_id','=',$allocated_channel_id)->update($data);

					//remove cms username and password
					$data3 = array("cms_username"=>"","cms_password"=>"","is_trail"=>0);
					$result = User::where('rec_id','=',$user_id)->update($data3);

					// send fcm trail time expired users
					$icon = "success.png";
					$clienticon = "package-expiry.png";


					$new_time = UserController::convertDateToUTCForAPI(date("Y-m-d H:i:s"));

					$message = "Your free trial has now ended. To continue please visit our website to purchase subscription package of your choice.";

					$htmlMessage = "Your free trial has now ended. To continue please visit our website to purchase subscription package of your choice.";

					$htmlMessageIOS="Your free trial has now ended. To continue please visit our website to purchase subscription package of your choice.";


					$arr = array("Client_id" => $client_id,"ClientCode" => $clientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Account Information',"user_id" =>$rec_id,"MobileNo" =>$mobileno,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);

					$json_data["trial_alert_expired"] = json_encode($arr);

					//$device_id = array($res['device_id']);

					if(!empty($device_id)){

						/*if($mbl_platform == 'ios'){
						   $res = Common::sendFCMIOS($device_id,$json_data,$mobileno, 'FreeTrail_Expired',$htmlMessageIOS);
						}else if($mbl_platform == 'android'){
							$deviceIds = UsersDevicesList::where('user_id','=',$user_rec_id)->where('device_type','=','android')->get();
							$device_id = array();
							if(@count($deviceIds) > 0){
								foreach ($deviceIds as $val) {
									$application_name = $val->application_name;
									$device_id = array($val->device_id);
									//array_push($device_id, $val->device_id);
									$res = Common::sendFCMAndroid($device_id,$json_data,$mobileno, 'FreeTrail_Expired',$application_name);
								}
							}else{
								$device_id = array($res['device_id']);
								$res = Common::sendFCMAndroid($device_id,$json_data,$mobileno, 'FreeTrail_Expired',$application_name);
							}

						}*/


						$deviceIds = UsersDevicesList::where('user_id','=',$user_rec_id)->get();

						if(@count($deviceIds) > 0){
							foreach ($deviceIds as $val) {
								$user_id = $val->user_id;
								$application_name = $val->application_name;
								$device_id = array($val->device_id);
								$device_id1 = $val->device_id;
								$device_type = $val->device_type;
								if(!empty($device_type)){
									if($device_type == "android"){
										$res = Common::sendFCMAndroid($device_id,$json_data,$mobileno, 'FreeTrail_Expired_android',$application_name);
									}else{
										$res = Common::sendFCMIOS($device_id1,$json_data,$mobileno, 'FreeTrail_Expired_ios',$htmlMessageIOS,$application_name,$user_id);
									}
								}
							}
						}else{
							Log::info(" trial expired device id is empty");
						}


					}else{

						Log::info(" trial expired device id is empty");
					}


				}else{
					Log::info($user_id." user have some expiry time");
				}

			}
		}else{
			Log::info(" No free trial users ");
		}


    }


	// United states Epglist cron job
	public static function runUSEPGlist()
	{
        $xml_url = 'http://server1.xmltv.co:80/xmltv.php?username=eEGsbXpFM1&password=4D6dh8yXk6&prev_days=0&next_days=1';
        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL,$xml_url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 5555555555);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36');
        $response = curl_exec($curl_handle);
        if (curl_errno($curl_handle)) {
            //echo 'Error:' . curl_error($ch);
            Log::info('Error:'.curl_error($curl_handle));
        }
        curl_close($curl_handle);
        $xml2 = simplexml_load_string($response);

        if(!empty($xml2)) {
            foreach($xml2->programme as $iprogrammendex => $prg) {
                $xmltv_id = trim($prg->attributes()->channel);
                $start_timezone = Common::convertIntoDate($prg->attributes()->start);
                $result = EPG_list::where(['country_id' => 237, 'xmltv_id' => $xmltv_id, 'start_timezone' => $start_timezone])->get();
                if($result->count() == 0) {
                    $data = [
                        'xmltv_id' => $xmltv_id,
                        'title' => trim($prg->title),
                        'description' => trim($prg->desc),
                        'start_time' => Common::convertDateIntoHours($prg->attributes()->start),
                        'end_time' => Common::convertDateIntoHours($prg->attributes()->stop),
                        'start_timezone' => Common::convertIntoDate($prg->attributes()->start),
                        'end_timezone' => Common::convertIntoDate($prg->attributes()->stop),
                        'stimezone' => Common::convertIntoDateTImezone($prg->attributes()->start),
                        'etimezone' => Common::convertIntoDateTImezone($prg->attributes()->stop),
                        'country_id' => 237,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    ];

                    EPG_list::insert($data);
                }
            }
        }else{
            Log::info('Error:Empty result');
        }
    }


    public static function removeOldUSEPGlist(){
        $currentDate = date("Y-m-d");
        $res=EPG_list::where(['country_id' => 237])->whereDate('created_at', '<', $currentDate)->delete();
        if($res){
            Log::info('Removed Old Epglist');
        }else{
            Log::info('Error in Removing Old Epglist');
        }
    }




}

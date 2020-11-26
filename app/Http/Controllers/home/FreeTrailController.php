<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use App\Subscribe_newsletter;
use App\Contact_users;
use Validator;
use Session;
use App\User;
use Illuminate\Support\Facades\Redirect;
use App\Settings;
use App\Free_trail_cms_accounts;
use App\Free_trail_requested_users;
use App\RolesPermissions;
use App\User_requested_movies;
use App\Recent_movies_images;
use App\Purchase_order_details;
use App\IptvConfigURLS;
use Illuminate\Support\Facades\Auth;
use App\Library\Common;
use App\Http\Controllers\API\UserController;
use App\ApplicationsInfo;
use App\ApplicationSettings;
use App\Package_purchase_list;
use App\UsersDevicesList;
class FreeTrailController extends Controller
{

	//prospects
	public function prospectsList(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		$data['userInfo'] = $userinfo;

		$data['searchKey'] = $request->query('searchKey');

		$data['prospects_count'] = Free_trail_requested_users::where("status","=",2)->count();
		$data['requested_count'] = Free_trail_requested_users::where("status","=",0)->count();
		$data['test_accounts_count'] = Free_trail_cms_accounts::where("status","=",1)->count();

		$searchKey = $request->query('searchKey');
		if(!empty($searchKey)){
			if (filter_var($searchKey, FILTER_VALIDATE_EMAIL)) {
				$udata = User::select('*')->where('email', $searchKey)->get();
				if(!empty($udata)){

					$arr = array();
					foreach ($udata as $val) {
						array_push($arr, $val->rec_id);
					}


					$data['prospects_info'] = Free_trail_requested_users::whereIn('user_id', $arr)->where("status","=",2)->orderBy('rec_id','DESC')->paginate(20);
				}else{
					$data['prospects_info'] = array();
				}
			}else{
				$udata = User::select('*')->where('user_id', $searchKey)->first();
				if(!empty($udata)){
					$rec_id = $udata->rec_id;
					$data['prospects_info'] = Free_trail_requested_users::where('user_id', $rec_id)->where("status","=",2)->orderBy('rec_id','DESC')->paginate(20);
				}else{
					$data['prospects_info'] = array();
				}
			}

		}else{
		 $data['prospects_info'] = Free_trail_requested_users::where("status","=",2)->orderBy('rec_id','DESC')->paginate(20);
		}


		return view('free_trail/prospects')->with($data);

	}

	//Test Account Status list
	public function testAccountStatusList(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		$data['userInfo'] = $userinfo;

		$data['searchKey'] = $request->query('searchKey');
		$data['prospects_count'] = Free_trail_requested_users::where("status","=",2)->count();
		$data['requested_count'] = Free_trail_requested_users::where("status","=",0)->count();
		$data['test_accounts_count'] = Free_trail_cms_accounts::where("status","=",1)->count();
		$searchKey = $request->query('searchKey');

		if(!empty($searchKey) && ($searchKey == "Busy" || $searchKey == "Free")){
			if($searchKey == "Busy"){
				$is_available = 0;
			}else{
				$is_available = 1;
			}
			/*$data['cms_info'] = DB::table('free_trail_cms_accounts')
				->leftJoin('free_trail_requested_users', 'free_trail_cms_accounts.rec_id', '=', 'free_trail_requested_users.channel_id')
				->where('free_trail_cms_accounts.status',1)
				->where('free_trail_cms_accounts.is_available',"=",$is_available)
				->select('free_trail_cms_accounts.cms_username','free_trail_cms_accounts.cms_password','free_trail_cms_accounts.is_available','free_trail_requested_users.rec_id','free_trail_requested_users.user_id','free_trail_requested_users.trail_start_time','free_trail_requested_users.trail_end_time')
				->orderBy('free_trail_cms_accounts.rec_id','ASC')
				->paginate(20);
				*/

			$data['cms_info'] =  Free_trail_cms_accounts::where("status","=",1)->where('is_available','=',$is_available)->orderBy('rec_id','ASC')->paginate(20);
		}else{



			/*$data['cms_info'] = DB::table('free_trail_cms_accounts')
				->leftJoin('free_trail_requested_users', 'free_trail_cms_accounts.rec_id', '=', 'free_trail_requested_users.channel_id')
				->where('free_trail_cms_accounts.status',1)
				->where('free_trail_requested_users.status',1)
				->select('free_trail_cms_accounts.cms_username','free_trail_cms_accounts.cms_password','free_trail_cms_accounts.is_available','free_trail_requested_users.rec_id','free_trail_requested_users.user_id','free_trail_requested_users.trail_start_time','free_trail_requested_users.trail_end_time')
				->orderBy('free_trail_cms_accounts.rec_id','ASC')
				->paginate(20);
				*/

			$data['cms_info'] =  Free_trail_cms_accounts::where("status","=",1)->orderBy('rec_id','ASC')->paginate(20);


		}



		return view('free_trail/testAccountStatus')->with($data);

	}

	//Request Trials list
	public function requestTrialsList(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		$data['userInfo'] = $userinfo;

		$data['searchKey'] = $request->query('searchKey');

		$data['prospects_count'] = Free_trail_requested_users::where("status","=",2)->count();
		$data['requested_count'] = Free_trail_requested_users::where("status","=",0)->count();
		$data['test_accounts_count'] = Free_trail_cms_accounts::where("status","=",1)->count();
		$searchKey = $request->query('searchKey');

		if(!empty($searchKey)){
			if (filter_var($searchKey, FILTER_VALIDATE_EMAIL)) {
				$udata = User::select('*')->where('email', $searchKey)->get();
				if(!empty($udata)){

					$arr = array();
					foreach ($udata as $val) {
						array_push($arr, $val->rec_id);
					}


					$data['requested_info'] = Free_trail_requested_users::whereIn('user_id', $arr)->whereIn("status",[0,1,3])->orderBy('trail_requested_time','DESC')->paginate(20);
				}else{
					$data['requested_info'] = array();
				}
			}else{
				$udata = User::select('*')->where('user_id', $searchKey)->first();
				if(!empty($udata)){
					$rec_id = $udata->rec_id;
					$data['requested_info'] = Free_trail_requested_users::where('user_id', $rec_id)->whereIn("status",[0,1,3])->orderBy('trail_requested_time','DESC')->paginate(20);
				}else{
					$data['requested_info'] = array();
				}
			}

		}else{
		 $data['requested_info'] = Free_trail_requested_users::whereIn("status",[0,1,3])->orderBy('trail_requested_time','DESC')->paginate(20);
		}



		return view('free_trail/requestTrial')->with($data);

	}

	public function trialAccountActivated(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$rec_ids = Input::get("rec_id");
		//$value = Input::get("value");
		//$action = Input::get("action");

		if(!empty($rec_ids)){

			$settingTime = ApplicationSettings::select('*')->where('id','=',1)->first();
			if(!empty($settingTime)){
				$minimum_time = unserialize($settingTime->setting_value);
				$trial_duration = $minimum_time['trail_duration'];

			}else{
				$trial_duration = 0;
			}

			$data = array("status"=>3);
			$result = Free_trail_requested_users::where('rec_id','=',$rec_ids)->update($data);

			// send mail trial requested user
			$activatedinfo = Free_trail_requested_users::where('rec_id','=',$rec_ids)->first();
			$user_id = $activatedinfo->user_id;
			$res = User::select('*')->where('rec_id','=',$user_id)->where('user_role','=',4)->where('status','=',1)->first();
			if(!empty($res)){
				$rec_id = $res->rec_id;

				$name = $res->first_name." ".$res->last_name;
				$user_id = $res->user_id;
				$application_id = $res->application_id;
				$email = $res->email;

				if(!empty($res->telephone)){
					$mobileno = $res->telephone;
				}else{
					$mobileno = "";
				}
				$data['useremail'] = array('name'=>$name,'user_id'=>$user_id,'toemail'=>$email,'trial_duration'=>$trial_duration);
				$emailid = array('toemail' => $email);
				Mail::send(['html'=>'email_templates.trialAccountActivatedEmail'], $data, function($message) use ($emailid) {
					$message->to($emailid['toemail'], 'Customer ID')->subject('Trial Account Activated');
					$message->from('support@bestbox.net','BestBox');
				});


				// send FCM
				$client_id="";$clientCode="";
				if(!empty($application_id)){
					$info = ApplicationsInfo::where('application_id','=',$application_id)->first();
					if(!empty($info)){
						$client_id = $info->application_id;
						$clientCode = $info->application_name;
					}
				}
				$icon = "success.png";
				$clienticon = "package-expiry.png";

				$new_time = UserController::convertDateToUTCForAPI(date("Y-m-d H:i:s"));

				$message = "Your BESTBOX free trial is now active and you can now start enjoying the latest content and channels from BestBOX.";

				$htmlMessage = "Your BESTBOX free trial is now active and you can now start enjoying the latest content and channels from BestBOX.";

				$htmlMessageIOS="Your BESTBOX free trial is now active and you can now start enjoying the latest content and channels from BestBOX.";


				$arr = array("Client_id" => $client_id,"ClientCode" => $clientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Account Information',"user_id" =>$rec_id,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);


				$json_data["trial_alert"] = json_encode($arr);



				if(!empty($res['device_id'])){

					/*
					if($res['mbl_platform'] == 'ios'){
					   $res = Common::sendFCMIOS($res['device_id'],$json_data,$mobileno, 'trial_Accepted',$htmlMessageIOS);
					}else if($res['mbl_platform'] == 'android'){
						$deviceIds = UsersDevicesList::where('user_id','=',$res['rec_id'])->where('device_type','=','android')->get();
						//$device_id = array();
						if(@count($deviceIds) > 0){
							foreach ($deviceIds as $val) {
								//array_push($device_id, $val->device_id);
								$application_name = $val->application_name;
								$device_id = array($val->device_id);
								$res = Common::sendFCMAndroid($device_id,$json_data,$mobileno, 'trial_Accepted',$application_name);
							}
						}else{
							$device_id = array($res['device_id']);
							$res = Common::sendFCMAndroid($device_id,$json_data,$mobileno, 'trial_Accepted',$client_id);
						}
						//$res = Common::sendFCMAndroid($device_id,$json_data,$mobileno, 'trial_Accepted',$client_id);
					}
					*/


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
									$res = Common::sendFCMAndroid($device_id,$json_data,$mobileno, 'trial_Accepted',$application_name);
								}else{
									$res = Common::sendFCMIOS($device_id1,$json_data,$mobileno, 'trial_Accepted',$htmlMessageIOS,$application_name,$user_id);
								}
							}

						}
					}

				}


			}




			if($result == TRUE){
				return response()->json(['status' => 'Success', 'Result' => 'Activated Successfully'], 200);
			}else{
				return response()->json(['status' => 'Failure', 'Result' => 'something went wrong'], 200);
			}

		}else{
			return response()->json(['status' => 'Failure', 'Result' => 'User ID is missing'], 200);
		}

	}


	//Test CMS Accounts
	public function testCMSAccounts(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		$data['userInfo'] = $userinfo;

		$data['searchKey'] = $request->query('searchKey');

		$data['prospects_count'] = Free_trail_requested_users::where("status","=",2)->count();
		$data['requested_count'] = Free_trail_requested_users::where("status","=",0)->count();
		$data['test_accounts_count'] = Free_trail_cms_accounts::where("status","=",1)->count();

		$searchKey = $request->query('searchKey');
		if(!empty($searchKey)){
			$cms_user = safe_encrypt($searchKey,config('constants.encrypt_key'));
			$data['test_accounts_info'] = Free_trail_cms_accounts::where("cms_username","=",$cms_user)->where('status','=',1)->orderBy('rec_id','DESC')->paginate(20);
		}else{
			$data['test_accounts_info'] = Free_trail_cms_accounts::where('status','=',1)->orderBy('rec_id','DESC')->paginate(20);
		}


		return view('free_trail/testAccounts')->with($data);

	}




	public function freeTrailCMSAccounts(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$data['searchKey'] = $request->query('searchKey');

		$searchKey = $request->query('searchKey');
		if(!empty($searchKey)){
			$cms_user = safe_encrypt($searchKey,config('constants.encrypt_key'));
			$data['cms_info'] = Free_trail_cms_accounts::where("cms_username","=",$cms_user)->orderBy('rec_id','ASC')->get();
		}else{
			$data['cms_info'] = Free_trail_cms_accounts::orderBy('rec_id','ASC')->get();
		}



		return view('free_trail/freeTrailCMSAccounts')->with($data);

	}

	public function checkCMSAccountExist(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$cms_username = Input::get("cms_username");
		$cms_password = Input::get("cms_password");
		if($cms_username == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'Please Enter CMS UserName'], 200);
		}else{


			$encrypted_username=safe_encrypt($cms_username,config('constants.encrypt_key'));
			$encrypted_password=safe_encrypt($cms_password,config('constants.encrypt_key'));

			// check username already exist or not

			$usernameExistorNot = Free_trail_cms_accounts::where('cms_username','=',$encrypted_username)->get();
			if(@count($usernameExistorNot) > 0){
				return response()->json(['status' => 'Failure', 'Result' => 'CMS User account already exist'], 200);
			}else{
				return response()->json(['status' => 'Success', 'Result' => 'CMS Account different.'], 200);

			}



		}

	}



	public function addNewCMSAccount(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$cms_username = Input::get("cms_username");
		$cms_password = Input::get("cms_password");
		if($cms_username == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'Please Enter CMS UserName'], 200);
		}else if($cms_password == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'Please Enter CMS Password'], 200);
		}else{
			$last_rec_id = Free_trail_cms_accounts::select('rec_id')->orderBy('rec_id','DESC')->first();
			if(!empty($last_rec_id)){
				$no = $last_rec_id->rec_id+1;
				$channel_no = "channel-".$no;
			}else{
				$channel_no = "channel-1";
			}

			$encrypted_username=safe_encrypt($cms_username,config('constants.encrypt_key'));
			$encrypted_password=safe_encrypt($cms_password,config('constants.encrypt_key'));

			// check username already exist or not

			$usernameExistorNot = Free_trail_cms_accounts::where('cms_username','=',$encrypted_username)->get();
			if(@count($usernameExistorNot) > 0){
				return response()->json(['status' => 'Failure', 'Result' => 'CMS User account already exist'], 200);
			}else{

				// get expiry date
				$cms_expiry_date = self::getTestAccountsExpiryDate($cms_username,$cms_password);
				if(!empty($cms_expiry_date)){

					$expiry_date = 	$cms_expiry_date;

					$data = [
							'channel' => $channel_no,
							'cms_username' => $encrypted_username,
							'cms_password' => $encrypted_password,
							'cms_expiry_date' => $expiry_date,
							'created_at' => date("Y-m-d H:i:s")
						];
						//print_r($data);exit;
					$res = Free_trail_cms_accounts::insert($data);
					if($res){
						return response()->json(['status' => 'Success', 'Result' => 'CMS Account Added Successfully.'], 200);
					}else{
						return response()->json(['status' => 'Failure', 'Result' => 'Something went wrong'], 200);
					}



				}else{
					return response()->json(['status' => 'Failure', 'Result' => 'Please enter valid Supplier user Id and password'], 200);
				}


			}

		}

	}

	public function getTestAccountsExpiryDate($cms_username,$cms_password){
		//$cms_username = request('username');
		//$cms_password = request('password');
		//$purchased_id = request('purchased_id');


		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'http://portal.geniptv.com:8080/player_api.php');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "username=$cms_username&password=$cms_password&autentification=");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

		$headers = array();
		$headers[] = 'Host: portal.geniptv.com:8080';
		$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36';
		$headers[] = 'Content-Type: application/x-www-form-urlencoded';
		$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3';
		//$headers[] = 'Referer: https://cms.xtream-codes.com/xcb33fe6/userpanel/add_user.php';
		$headers[] = 'Accept-Language: en-US,en;q=0.9';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			//echo 'Error:' . curl_error($ch);
			echo "fail";exit;
		}
		curl_close($ch);
		/*echo "sri ";
		echo $result;*/
		if($result!=""){
			$res=json_decode($result);
			//print_r($res);exit;
			//echo $res->user_info->exp_date;
			$startdate=date("Y-m-d",$res->user_info->created_at);
			//$utctime =date('Y-m-d H:i:s',strtotime('+8 hours',strtotime($startdate)));
			$expdate=date("Y-m-d H:i:s",$res->user_info->exp_date);
			return $expdate;

		}else{
			return "";
		}
	}




	// edit cms account
	public function editCMSAccount(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$rec_id = Input::get("rec_id");
		if(!empty($rec_id)){

			$res = Free_trail_cms_accounts::select('*')->where('rec_id','=',$rec_id)->first();
			if(!empty($res)){
				$decrypted_username = safe_decrypt($res['cms_username'],config('constants.encrypt_key'));
				$decrypted_password = safe_decrypt($res['cms_password'],config('constants.encrypt_key'));
				$result = array("rec_id"=>$res['rec_id'],"cms_username"=>$decrypted_username,"cms_password"=>$decrypted_password);
				return response()->json(['status' => 'Success', 'Result' => $result], 200);

			}else{
				$result = array();
				return response()->json(['status' => 'Failure', 'Result' => $result], 200);
			}

		}else{
			return response()->json(['status' => 'Failure', 'Result' => 'Rec id is missing'], 200);
		}

	}

	public function updateCMSAccount(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$rec_id = Input::get("rec_id");
		$cms_username = Input::get("cms_username");
		$cms_password = Input::get("cms_password");
		if($cms_username == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'Please Enter CMS UserName'], 200);
		}else if($cms_password == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'Please Enter CMS Password'], 200);
		}else if($rec_id == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'Rec id missing'], 200);
		}else{

			// get expiry date
			$cms_expiry_date = self::getTestAccountsExpiryDate($cms_username,$cms_password);
			if(!empty($cms_expiry_date)){
				$expiry_date = 	$cms_expiry_date;
			}else{
				$expiry_date = NULL;
			}

			$encrypted_username=safe_encrypt($cms_username,config('constants.encrypt_key'));
			$encrypted_password=safe_encrypt($cms_password,config('constants.encrypt_key'));

			$data = [
						'cms_username' => $encrypted_username,
						'cms_password' => $encrypted_password,
						'cms_expiry_date' => $expiry_date,
						'updated_at' => date("Y-m-d H:i:s")

					];
					//print_r($data);exit;
			$res = Free_trail_cms_accounts::where('rec_id','=',$rec_id)->update($data);
			if($res){
				return response()->json(['status' => 'Success', 'Result' => 'CMS Account Updated Successfully.'], 200);
			}else{
				return response()->json(['status' => 'Failure', 'Result' => 'Something went wrong'], 200);
			}

		}

	}


	public function disableTrailCMSAccount(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$rec_ids = Input::get("rec_id");
		$value = Input::get("value");
		$action = Input::get("action");

		if(!empty($rec_ids)){
			$data = array("status"=>$value);
			$res = Free_trail_cms_accounts::where('rec_id','=',$rec_ids)->update($data);
			if($value == 1){
				return response()->json(['status' => 'Success', 'Result' => 'CMS Account Activated Successfully'], 200);
			}else{
				return response()->json(['status' => 'Success', 'Result' => 'CMS Account Disabled Successfully'], 200);
			}

		}else{
			return response()->json(['status' => 'Failure', 'Result' => 'User ID is missing'], 200);
		}

	}


	public function deleteTrailCMSAccount(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$rec_ids = Input::get("rec_id");
		//$value = Input::get("value");
		//$action = Input::get("action");

		if(!empty($rec_ids)){
			//$data = array("status"=>$value);
			$res = Free_trail_cms_accounts::where('rec_id','=',$rec_ids)->delete();
			if($res == TRUE){
				return response()->json(['status' => 'Success', 'Result' => 'CMS Account Deleted Successfully'], 200);
			}else{
				return response()->json(['status' => 'Failure', 'Result' => 'CMS Account Deleted Successfully'], 200);
			}

		}else{
			return response()->json(['status' => 'Failure', 'Result' => 'User ID is missing'], 200);
		}

	}

	// free trail requested users list

	public function getFreeTrailRequestedUsers(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$data['searchKey'] = $request->query('searchKey');

		$searchKey = $request->query('searchKey');
		if(!empty($searchKey)){

			$data['freetrail_info'] = Free_trail_requested_users::orderBy('rec_id','ASC')->get();
		}else{
			$data['freetrail_info'] = Free_trail_requested_users::orderBy('rec_id','ASC')->get();
		}



		return view('free_trail/free_trails_requested_users')->with($data);

	}

	public function extendFreetrailHours(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$rec_ids = Input::get("rec_id");
		$extend_hours = Input::get("extend_hours");
		//$action = Input::get("action");
		if($extend_hours == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'Please Select Extend Hours'], 200);
		}else if(!empty($rec_ids)){

			$data = array("extend_hours"=>$extend_hours);
			$res = Free_trail_requested_users::where('rec_id','=',$rec_ids)->update($data);
			if($res == TRUE){
				return response()->json(['status' => 'Success', 'Result' => 'Extend Hours Successfully Completed'], 200);
			}else{
				return response()->json(['status' => 'Failure', 'Result' => 'Something went wrong in query'], 200);
			}

		}else{
			return response()->json(['status' => 'Failure', 'Result' => 'User ID is missing'], 200);
		}

	}



	public function freeTrailStartRequestInWeb(Request $request)
	{
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$rec_id = Input::get("rec_id");
		//$extend_hours = Input::get("extend_hours");
		//$action = Input::get("action");
		if($rec_id == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'Record ID is missing'], 200);
		}else{
			$trail_start_time = date('Y-m-d H:i:s');
			//get trial setting hours
			$settingTime = ApplicationSettings::select('*')->where('id','=',1)->first();
			if(!empty($settingTime)){
				$minimum_time = unserialize($settingTime->setting_value);
				$trial_duration = $minimum_time['trail_duration'];

			}else{
				$trial_duration = 3;
			}

			$expirytime = $trial_duration*60*60;

			$trail_end_time = date( "Y-m-d H:i:s", strtotime( $trail_start_time )+$expirytime );

			$data = array("trail_start_time"=>$trail_start_time,"trail_end_time"=>$trail_end_time,"status"=>1);

			$free_req_user = Free_trail_requested_users::where('user_id','=',$rec_id)->where('status',3)->first();

			if(!empty($free_req_user) && $free_req_user['status'] == 3){
				$res = Free_trail_requested_users::where('user_id','=',$rec_id)->update($data);
				User::where('rec_id','=',$rec_id)->update(['is_trail' =>1]);
			}else{
				return response()->json(['status' => 'Failure', 'Result' => 'Your trail period has been expired'], 200);
			}


			//update user table
			//$data3 = array("cms_username"=>$cms_username,"cms_password"=>$cms_password);
			//$result = User::where('rec_id','=',$rec_id)->update($data3);

			return response()->json(['status' => 'Success', 'Result' => 'Thank you ..'], 200);

		}

    }


	//addFreetrail
	public function addFreetrail(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		$data['userInfo'] = $userinfo;

		$data['searchKey'] = $request->query('searchKey');

		$data['prospects_count'] = Free_trail_requested_users::where("status","=",2)->count();
		$data['requested_count'] = Free_trail_requested_users::where("status","=",0)->count();
		$data['test_accounts_count'] = Free_trail_cms_accounts::where("status","=",1)->count();
        $data['freetrail_count'] = Free_trail_requested_users::where("status","=",1)->orWhere("status","=",2)->count();

        $searchKey = $request->query('searchKey');
        $user_email = $request->query('user_id');
        $data['user_email'] = $user_email;
        if(!empty($user_email)){
            if (filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
				$udata = User::select('*')->where('email', $user_email)->first();
				if(!empty($udata)){
                    $user_id = $udata['rec_id'];

                    $packagescount = Package_purchase_list::select('*')->where('user_id','=',$user_id)->where('active_package','=',1)->orderBy("rec_id", "DESC")->count();

                    $data['user_data']['pacakge'] = $packagescount;
                    $data['user_data']['name'] = $udata['first_name']. ' '.$udata['last_name'];

                    $user = Free_trail_requested_users::where('free_trail_requested_users.user_id', $user_id)->first();
                    // $user = Free_trail_requested_users::leftjoin('package_purchased_list','package_purchased_list.user_id','=','free_trail_requested_users.user_id')->select('free_trail_requested_users.user_id','free_trail_requested_users.trail_requested_time','free_trail_requested_users.trail_start_time','free_trail_requested_users.trail_end_time')->where('free_trail_requested_users.user_id', $user_id)->whereNull('package_purchased_list.user_id')->groupBy('package_purchased_list.user_id')->first();
                    if(!empty($user)) {
                        $data['user_data']['expiry_date'] = $user['trail_end_time'];
                        $data['user_data']['trail_requested_time'] = $user['trail_requested_time'];
                    }else{
                        $data['user_data']['expiry_date'] = '';
                        $data['user_data']['trail_requested_time'] = $user['trail_requested_time'];
                    }
                }else{
					$data['user_data'] = array();
				}
            }

        }
		if(!empty($searchKey)){
			if (filter_var($searchKey, FILTER_VALIDATE_EMAIL)) {
				$udata = User::select('*')->where('email', $searchKey)->get();
				if(!empty($udata)){

					$arr = array();
					foreach ($udata as $val) {
						array_push($arr, $val->rec_id);
                    }

                    $data['freetrail_info'] = Free_trail_requested_users::select('free_trail_requested_users.user_id','free_trail_requested_users.trail_requested_time','free_trail_requested_users.trail_start_time','free_trail_requested_users.trail_end_time')->whereIn('free_trail_requested_users.user_id',$arr)->orderBy('free_trail_requested_users.rec_id','DESC')->paginate(20);

                    // $data['freetrail_info'] = Free_trail_requested_users::leftjoin('package_purchased_list','package_purchased_list.user_id','=','free_trail_requested_users.user_id')->select('free_trail_requested_users.user_id','free_trail_requested_users.trail_requested_time','free_trail_requested_users.trail_start_time','free_trail_requested_users.trail_end_time')->whereIn('free_trail_requested_users.user_id',$arr)->whereNull('package_purchased_list.user_id')->groupBy('package_purchased_list.user_id')->orderBy('free_trail_requested_users.rec_id','DESC')->paginate(20);

				}else{
					$data['freetrail_info'] = array();
				}
			}else{
				$udata = User::select('*')->where('user_id', $searchKey)->first();
				if(!empty($udata)){
                    $rec_id = $udata->rec_id;

                    $data['freetrail_info'] = Free_trail_requested_users::select('free_trail_requested_users.user_id','free_trail_requested_users.trail_requested_time','free_trail_requested_users.trail_start_time','free_trail_requested_users.trail_end_time')->where('free_trail_requested_users.user_id', $rec_id)->orderBy('free_trail_requested_users.rec_id','DESC')->paginate(20);

                    // $data['freetrail_info'] = Free_trail_requested_users::leftjoin('package_purchased_list','package_purchased_list.user_id','=','free_trail_requested_users.user_id')->select('free_trail_requested_users.user_id','free_trail_requested_users.trail_requested_time','free_trail_requested_users.trail_start_time','free_trail_requested_users.trail_end_time')->where('free_trail_requested_users.user_id', $rec_id)->whereNull('package_purchased_list.user_id')->groupBy('package_purchased_list.user_id')->orderBy('free_trail_requested_users.rec_id','DESC')->paginate(20);

				}else{
					$data['freetrail_info'] = array();
				}
			}

		}else{
            $data['freetrail_info'] = Free_trail_requested_users::select('free_trail_requested_users.user_id','free_trail_requested_users.trail_requested_time','free_trail_requested_users.trail_start_time','free_trail_requested_users.trail_end_time')->orderBy('free_trail_requested_users.rec_id','DESC')->paginate(20);
		//  $data['freetrail_info'] = Free_trail_requested_users::leftjoin('package_purchased_list','package_purchased_list.user_id','=','free_trail_requested_users.user_id')->select('free_trail_requested_users.user_id','free_trail_requested_users.trail_requested_time','free_trail_requested_users.trail_start_time','free_trail_requested_users.trail_end_time')->whereNull('package_purchased_list.user_id')->orderBy('free_trail_requested_users.rec_id','DESC')->paginate(20);
		}

		return view('free_trail/add_free_trail')->with($data);

	}

    public function saveFreetrail(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
        $data['userInfo'] = $userinfo;

        $duration = $request->query('duration');
        $user_email = $request->query('user_id');

        if(!empty($user_email)){
            if (filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
				$udata = User::select('*')->where('email', $user_email)->first();
				if(!empty($udata)){
                    $user_id = $udata['rec_id'];
                    $expirytime = $duration*60*60*24;
                    $today = date('Y-m-d H:i:s');
                    $trail_end_time = date( "Y-m-d H:i:s", strtotime( $today )+$expirytime );

                    $result = Free_trail_requested_users::where('user_id','=',$user_id)->first();
                    if(empty($result)) {
                        $ftrail = Free_trail_requested_users::create([
                            'user_id' => $user_id,
                            'trail_requested_time' => $today,
                            "trail_start_time"=>$today,
                            "trail_end_time"=>$trail_end_time,
                            "status"=>1,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                        User::where(['rec_id' => $user_id])->update(['is_trail' => 1]);
                    }else{
                        $data = array("trail_end_time"=>$trail_end_time,"status"=>1);
                        $res = Free_trail_requested_users::where('user_id','=',$user_id)->update($data);
                        User::where(['rec_id' => $user_id])->update(['is_trail' => 1]);
                    }

                    Session::flash('message', 'Free trail Updated');
					Session::flash('alert','Success');
					return redirect('addFreetrail');
                }else{
                    Session::flash('message', 'Email not exists');
					Session::flash('alert','Failure');
					return Redirect::back();
                }
            }else{
                Session::flash('message', 'Invalid email Format');
				Session::flash('alert','Failure');
				return Redirect::back();
            }
        }else{
            Session::flash('message', 'Email not exists');
			Session::flash('alert','Failure');
			return Redirect::back();
        }
    }
}

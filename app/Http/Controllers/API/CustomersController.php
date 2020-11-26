<?php

namespace App\Http\Controllers\API;

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
use App\Commissions;
use App\Settings;
use App\Packages;
use App\Package_purchase_list;
use App\Unilevel_tree;
use App\Transactions;
use Carbon\Carbon;
use App\Purchase_order_details;
use DateTime;
use DateTimeZone;
use App\Withdraw_request;
use App\Contact_users;
use App\Library\Common;
class CustomersController extends Controller
{
	
	
	public function getCustomersListNew(Request $request)
	{
		$userInfo = $request->user(); 
		
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
        $validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
            'page' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);            
        }else{
			$limit = 20;
			$page = request('page');
			
			$from_date = request('from_date');
			$to_date = request('to_date');
			$searchKey = request('searchKey');
			$status = request('status');
			
			if (!empty($searchKey)) { 
				if ($userInfo['user_role'] == 2) {
					if (!empty($searchKey) && filter_var($searchKey, FILTER_VALIDATE_EMAIL)) {
						$res = User::join('users_tree','users.rec_id','=','users_tree.customer_id')->where("users_tree.reseller_id", $userInfo['rec_id'])->where("users_tree.agent_id", "=", 0)->where('users.email','like',$searchKey)->where("users_tree.customer_id", "!=", 0)->get();
					}else{
						$res = User::join('users_tree','users.rec_id','=','users_tree.customer_id')->where("users_tree.reseller_id", $userInfo['rec_id'])->where("users_tree.agent_id", "=", 0)->where('users.user_id','=',$searchKey)->where("users_tree.customer_id", "!=", 0)->get();
					}
				} else if ($userInfo['user_role'] == 3) {
					if (!empty($searchKey) && filter_var($searchKey, FILTER_VALIDATE_EMAIL)) {
						$res = User::join('users_tree','users.rec_id','=','users_tree.customer_id')->where("users_tree.agent_id", $userInfo['rec_id'])->where("users_tree.agent_id", "!=", 0)->where('users.email','like',$searchKey)->where("users_tree.customer_id", "!=", 0)->orderBy("users_tree.rec_id", "DESC")->get();
					}else{
						$res = User::join('users_tree','users.rec_id','=','users_tree.customer_id')->where("users_tree.agent_id", $userInfo['rec_id'])->where("users_tree.agent_id", "!=", 0)->where('users.user_id','=',$searchKey)->where("users_tree.customer_id", "!=", 0)->orderBy("users_tree.rec_id", "DESC")->get();
					}
				} else {
					if (!empty($searchKey) && filter_var($searchKey, FILTER_VALIDATE_EMAIL)) {
						$res = User::join('users_tree','users.rec_id','=','users_tree.customer_id')->where('users.email','like',$searchKey)->where("users_tree.customer_id", "!=", 0)->get();
					}else{
						$res = User::join('users_tree','users.rec_id','=','users_tree.customer_id')->where('users.user_id','=',$searchKey)->where("users_tree.customer_id", "!=", 0)->get();
					}
				}
			}else{
				
				if ($userInfo['user_role'] == 2) { 
					$res = Users_tree::where("reseller_id", $userInfo['rec_id'])->where("customer_id", "!=", 0)->where("agent_id", "=", 0)->orderBy("rec_id", "DESC")->get();
				} else if ($userInfo['user_role'] == 3) {
					$res = Users_tree::where("agent_id", $userInfo['rec_id'])->where("customer_id", "!=", 0)->where("agent_id", "!=", 0)->orderBy("rec_id", "DESC")->get();
				} else {
					$res = Users_tree::where("customer_id", "!=", 0)->orderBy("rec_id", "DESC")->get();
				}
				
				
			}
			if($userInfo['user_role'] == 1){
				$where = array('users.email_verify'=>1);
			}else{
				$where = array('users.email_verify'=>1);
			}

			$arr = array();
			foreach ($res as $val) {
				array_push($arr, $val->customer_id);
			}
			$symbol = ($status == 1)? 1 : 0;
			
			if($status == 1){
				$wr = '>';
			}else{
				$wr = '<';
			}
			
			if(!empty($status)){
				//DB::enableQueryLog();
				/*$customers = User::leftjoin('package_purchased_list', 'users.rec_id', '=', 'package_purchased_list.user_id')->leftjoin('packages', 'package_purchased_list.package_id', '=', 'packages.id')->where($where)->whereIn('users.rec_id', $arr)->select('package_purchased_list.rec_id AS pRec_id','users.rec_id', 'users.user_id', 'users.first_name','users.last_name', 'users.email', 'users.registration_date', 'users.telephone','users.gender','users.married_status','users.image', 'users.status','users.shipping_country','users.shipping_address1','users.shipping_address2','users.shipping_zipcode','users.shipping_country','users.shipping_user_mobile_no', 'packages.id','packages.effective_amount', DB::raw('MAX(package_purchased_list.expiry_date) AS expiry_date'),DB::raw('MAX(package_purchased_list.subscription_date) AS subscription_date'),'packages.package_name','packages.setupbox_status')->where(['package_purchased_list.active_package' => $symbol])->groupBy('users.user_id')->orderBy('users.rec_id', 'DESC')->skip($page * $limit)->take($limit)->get();
				*/
				
				$customers = User::leftJoin(\DB::raw('(SELECT * FROM package_purchased_list WHERE rec_id IN (SELECT MAX(rec_id) AS id FROM package_purchased_list WHERE package_id != 11 GROUP BY user_id) ORDER BY user_id) AS t2'), function($join) {
			        $join->on('users.rec_id', '=', 't2.user_id');
			    })->leftjoin('packages', 't2.package_id', '=', 'packages.id')
				  ->where($where)
				  ->whereIn('users.rec_id', $arr)
				  /*->select('t2.rec_id AS pRec_id','users.rec_id', 'users.user_id','users.email_verify', 'users.first_name','users.last_name', 'users.email', 'users.registration_date', 'users.status', 'packages.id','packages.effective_amount', 't2.expiry_date','packages.package_name','packages.setupbox_status')*/
				  ->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name', 'users.email', 'users.registration_date', 'users.telephone','users.gender','users.married_status','users.image', 'users.status','users.shipping_country','users.shipping_address1','users.shipping_address2','users.shipping_zipcode','users.shipping_country','users.shipping_user_mobile_no', 'packages.id','packages.effective_amount','packages.description', 't2.expiry_date','t2.subscription_date','packages.package_name','packages.setupbox_status')
				  ->where('t2.expiry_date',$wr,NOW())
				  ->groupBy('users.user_id')->orderBy('users.rec_id', 'DESC')->skip($page * $limit)->take($limit)->get();
				
			}else{
				
				
				/*$customers = User::leftJoin(\DB::raw('(SELECT * FROM package_purchased_list WHERE rec_id IN (SELECT MAX(rec_id) AS id FROM package_purchased_list GROUP BY user_id) ORDER BY user_id) AS t2'), function($join) {
			        $join->on('users.rec_id', '=', 't2.user_id');
			    })->leftjoin('packages', 't2.package_id', '=', 'packages.id')->where($where)->whereIn('users.rec_id', $arr)->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name', 'users.email', 'users.registration_date', 'users.telephone','users.gender','users.married_status','users.image', 'users.status','users.shipping_country','users.shipping_address1','users.shipping_address2','users.shipping_zipcode','users.shipping_country','users.shipping_user_mobile_no', 'packages.id','packages.effective_amount','packages.description', 't2.expiry_date','t2.subscription_date','packages.package_name','packages.setupbox_status')->groupBy('users.user_id')->orderBy('users.rec_id', 'DESC')->skip($page * $limit)->take($limit)->get();
				*/
				$customers = User::leftJoin(\DB::raw('(SELECT * FROM package_purchased_list WHERE rec_id IN (SELECT MAX(rec_id) AS id FROM package_purchased_list WHERE package_id != 11 GROUP BY user_id) ORDER BY user_id) AS t2'), function($join) {
			        $join->on('users.rec_id', '=', 't2.user_id');
			    })->leftjoin('packages', 't2.package_id', '=', 'packages.id')->where($where)->whereIn('users.rec_id', $arr)->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name', 'users.email', 'users.registration_date', 'users.telephone','users.gender','users.married_status','users.image', 'users.status','users.shipping_country','users.shipping_address1','users.shipping_address2','users.shipping_zipcode','users.shipping_country','users.shipping_user_mobile_no', 'packages.id','packages.effective_amount','packages.description', 't2.expiry_date','t2.subscription_date','packages.package_name','packages.setupbox_status')->groupBy('users.user_id')->orderBy('users.rec_id', 'DESC')->skip($page * $limit)->take($limit)->get();;
					
			}
			
			$package_total_value = 0;
			
			$customersList = array();
			if(@count($customers)>0){
				foreach($customers as $res){
				
					$package_total_value += $res['effective_amount'];
					
					$registratin_date = UserController::convertDateToUTCForAPI($res['registration_date']);
					$customer_id = $res['user_id'];
					$fullName = $res['first_name']." ".$res['last_name'];
					$first_name = $res['first_name'];
					$last_name = $res['last_name'];
					$email = $res['email'];
					$mobile_no = $res['telephone'];
					$gender = $res['gender'];
					$married_status = $res['married_status'];
					$user_status = $res['status'];
					
					$profileImage = $res['image'];
					if(!empty($profileImage)){
						$profile_pic = 	$profileImage;
					}else{
						$profile_pic = "";
					}
					
					$countryInfo = Country::select('*')->where('countryid', '=',$res['shipping_country'])->first();
					if(!empty($countryInfo)){
						$countryName = 	$countryInfo->country_name;
						$nationality = 	$countryInfo->nationality;
					}else{
						$countryName = "";
						$nationality = "";
					}
					
					//package info
					$package_name = ($res['package_name']!='') ? $res['package_name'] : '-';
					$package_amt = $res['effective_amount'];
					if($res['id'] != 11){
						if($res['expiry_date'] != ''){
							
							if($res['expiry_date'] < NOW()){
								$expiry_status = "Expired";
								$expiry_color = "red";
							}else{
								$expiry_status = "Active";
								$expiry_color = "green";
							}
							$subscription_date = UserController::convertDateToUTCForAPI($res['subscription_date']);
							$expiry_date = UserController::convertDateToUTCForAPI($res['expiry_date']); 
						}else{
							$expiry_status = "-";
							$subscription_date ="";
							$expiry_date = "";
						}
						
					}else{
						$expiry_status = "-";
						$expiry_date = "";
						$expiry_color = "";
						$subscription_date ="";
					}
					
					$qs = Purchase_order_details::where('user_id',$res['rec_id'])->orderBy('rec_id','DESC')->first();
					
					if($res['expiry_date'] != ''){
						if($res['expiry_date'] < NOW()){
							$renew_btn_color = "brown";
						}else{
							$renew_btn_color = "";
						}
						$renew_btn_text = "Renew";
					}else{
						if(!empty($qs) && $qs->status == 1){
							$renew_btn_text = "Activation Pending";
						}else{
							$renew_btn_text = "-";
						}
						$renew_btn_color = "";
					}
					
					
					$customersList[] = array(
									"rec_id"=>$res['rec_id'],
									"customer_id"=>$customer_id,
									"first_name"=>$first_name,
									"last_name"=>$last_name,
									"fullName"=>$fullName,
									"email"=>$email,
									"registratin_date"=>$registratin_date,
									"user_status"=>$user_status,
									"gender"=>$gender,
									"profile_pic"=>$profile_pic,
									"married_status"=>$married_status,
									"shipping_address1"=>$res['shipping_address1'],
									"shipping_address2"=>$res['shipping_address2'],
									"shipping_zipcode"=>$res['shipping_zipcode'],
									"shipping_country_id"=>$res['shipping_country'],
									"shipping_country_name"=>$countryName,
									"shipping_user_mobile_no"=>$res['shipping_user_mobile_no'],
									
									"package_name"=>$package_name,
									"package_amt"=>number_format($package_amt,2),
									"description"=>$res['description'],
									"package_status"=>$expiry_status,
									"renew_package"=>$renew_btn_text,
									"renew_btn_color"=>$renew_btn_color,
									"package_subscription_date"=>$subscription_date,
									"package_expiry_date"=>$expiry_date,
									'currency_symbol'=>'$',
									'currency_format'=>'USD'
									);
					
				
				}
				return response()->json(['status' => 'Success','package_total_value'=>number_format($package_total_value,2), 'Result' => $customersList], 200);
			}else{
				return response()->json(['status'=>'Failure','package_total_value'=>number_format($package_total_value,2),'Result'=>"No Records Found" ], 200);
			}
			
			
		}
		
		
	}
	
	
	
	public static function generateCustomerId($name)
	{
        $fname = str_replace(' ', '', $name);
        $name_str = strtoupper(substr($fname, 0, 3));
        $user_id = $name_str . rand(100, 999);
        return $user_id;
    }
	
	public static function generateUserId($type,$name)
	{
        $fname = str_replace(' ', '', $name);
        $name_str = strtoupper(substr($fname, 0, 3));
        $user_id = $type.rand(10000,99999).$name_str;
        return $user_id;
    }

    public static function generateReferralCode($name)
    {
        $fname = str_replace(' ', '', $name);
        $name_str = strtoupper(substr($fname, 0, 3));
        $referral_code = $name_str.rand(10000,99999);
        return $referral_code;
    }
	
	public static function generate_randam_string($type, $strength = 9) {

		$input = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$input_length = strlen($input);
		$random_string = '';
		for($i = 0; $i < $strength; $i++) {
			$random_character = $input[mt_rand(0, $input_length - 1)];
			$random_string .= $random_character;
		}
		 
		return $type.$random_string;
	}
	
	// Create New customer
	
	public function createNewCustomer22(Request $request)
	{
		$userInfo = $request->user();
		$login_userId = $userInfo['rec_id'];
		$user_role = $userInfo['user_role'];
		$login_user_comm_per = $userInfo['commission_perc'];
		
		
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
		$validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
			'email' => 'required',
			'first_name' => 'required',
			'last_name' => 'required',
			'gender' => 'required',
			'married_status' => 'required',
			'country_id' => 'required',
			'mobile_no' => 'required',
			'shipping_address1' => 'required',
			'shipping_address2' => 'required',
			'shipping_zipcode' => 'required',
			'shipping_country' => 'required',
			'shipping_user_mobile_no' => 'required',
			'package_id'  => 'required',
			//'pay_my_friend'  => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);            
        }else{
			$app_name = request('app_name');
			$email = request('email');
			$checkEmailExistOrNot = User::where('email', '=', $email)->first();
			if (@count($checkEmailExistOrNot)>0) {
				return response()->json(['status'=>'Failure','Result'=>"Email already exists"], 200);  
			}else{
				
				$first_name = request('first_name');
				$last_name = request('last_name');
				$gender = request('gender');
				$married_status = request('married_status');
				$country_id = request('country_id');
				$mobile_no = request('mobile_no');
				$countryInfo = Country::select('*')->where('countryid', '=',$country_id)->first();
				if(!empty($countryInfo)){
					$currencycode = 	$countryInfo->currencycode;
				}else{
					$currencycode = "";
				}
				
				$telephone = "+".$currencycode."-".$mobile_no;
				
				$shipping_address1 = request('shipping_address1');
				$shipping_address2 = request('shipping_address2');
				$shipping_zipcode = request('shipping_zipcode');
				$shipping_country = request('shipping_country');
				$shipping_mobile_no = request('shipping_user_mobile_no');
				
				$countryInfo = Country::select('*')->where('countryid', '=',$shipping_country)->first();
				if(!empty($countryInfo)){
					$currencycode = $countryInfo->currencycode;
				}else{
					$currencycode = "";
				}
				
				$shipping_user_mobile_no = "+".$currencycode."-".$shipping_mobile_no;
				
				$package_id = request('package_id');
				$pay = request('pay_my_friend'); //Input::get('pay');
					
				$form_type = Input::get('form_type');
				if($form_type == 'update'){
					$result = self::updCustomerData($email,$first_name,$last_name,$shipping_address1,$shipping_address2,$shipping_zipcode,$shipping_country,$shipping_user_mobile_no,$gender,$married_status,$package_id);
					
				}else{
					$result = self::insertCustomerData($userInfo,$login_userId,$email,$first_name,$last_name,$shipping_address1,$shipping_address2,$shipping_zipcode,$shipping_country,$shipping_user_mobile_no,$gender,$married_status,$package_id);	
				}
				$last_inserted_id = $result['last_inserted_id'];
				$referral_code = $result['referral_code'];
				$cust_user_id = $result['cust_user_id'];
				
				
				if (!empty($pay)) {
					$pack = Packages::where("id", $package_id)->first();
					$wal = Wallet::where("user_id", $login_userId)->first();

					if ($pack->effective_amount < $wal->amount) {
						//payment by reseller/agent wallet
							Wallet::where('user_id', $login_userId)->decrement('amount', $pack->effective_amount);
							//transactions table
							$bal = $wal->amount - $pack->effective_amount;
							
							$transaction_no = self::generate_randam_string('PID', $strength = 9);

							self::user_transactions($transaction_no,$package_id,$login_userId,$login_userId ,$last_inserted_id, 0, $pack->effective_amount, $bal, 'Pay For My Friend', $pack->effective_amount . ' USD paid for customer package purchase.');
						//package purchased and commission pay function
							$pack_pur_id = self::purchaseCommission($cust_user_id,$userInfo,$pack,$wal,$last_inserted_id,$package_id,$login_userId,$login_user_comm_per,$first_name,$last_name,2,"",$app_name);
							$order_id = self::generate_randam_string('ORD', $strength = 9);
							Purchase_order_details::create([
								'user_id' => $last_inserted_id,
								'order_id' => $order_id,
								'purchased_date' => date('Y-m-d H:i:s'),
								'purchased_from' => 'Wallet',
								'sender_id' => $last_inserted_id,
								'status' => 1,
								'package_purchased_id' => $pack_pur_id,
								'type' => 1
							]);
							
						// send FCM to sender
						Common::packagePurchasedFCM($userInfo,$pack->package_name,$pack->effective_amount,$transaction_no,"sender",$app_name);	
							
					} /*else {
						return response()->json(['status'=>'Failure','Result'=>"Insufficient balance in your wallet"], 200);
					}*/
				}
				
				

				$data['useremail'] = array('name' => $first_name, 'user_id' => $last_inserted_id, 'toemail' => $email, 'type'=>'Customer','referral_link' => $referral_code);
				$emailid = array('toemail' => $email);
				Mail::send(['html' => 'email_templates.verify-email'], $data, function ($message) use ($emailid) {
					$message->to($emailid['toemail'], 'Email Verify')->subject('Email Verify');
					$message->from('support@bestbox.net', 'BestBox');
				});	
					
				return response()->json(['status'=>'Success','Result'=>"Customer Created Successfully"], 200);	
					
			}	
		
		}
		
		
	}
	
	// new customer created
	
	public function createNewCustomer(Request $request)
	{
		$userInfo = $request->user();
		$lguserId = $userInfo['rec_id'];
		$application_id = $userInfo['application_id'];
		$admin_id = config('constants.ADMIN_ID');
		if($userInfo['admin_login'] == 1){
			$login_user_comm_per = 100;
			$login_userId = $admin_id;
			$login_userInfo = User::where('rec_id',$admin_id)->first();
		}else{
			$login_user_comm_per = $userInfo['commission_perc'];
			$login_userId = $userInfo['rec_id'];
			$login_userInfo = $userInfo;
		}
		
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
		$validator = Validator::make($request->all(), [
			'app_name' => 'required',
			'platform' => 'required',
			'email' => 'required|email|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$/',
			'first_name' => 'required|string|min:3|max:255',
			'last_name' => 'required|string|min:3|max:255',
			'package_id' => 'required'
		]);
		if ($validator->fails()) {
			return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);
		} else {

			$package_id = request('package_id');
			$pack = Packages::where("id", $package_id)->first();

			if(!empty($pack) && $pack->setupbox_status == 1){
				$validator = Validator::make($request->all(), [
					'shipping_address' => 'required',
					'shipping_country' => 'required',
					'shipping_user_mobile_no' => 'required|regex:/^([0-9]{8,14})$/'
				]);
				if ($validator->fails()) {
					
					$status = 0;
					return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);
				}else{
					$status = 1;
				}
			}else{
				$status = 1;
			}
			if($status == 1){
				$email = request('email'); 
				$cnt = User::where('email',$email)->where('referral_join',[0,2])->count();
				if($cnt == 1){
					return response()->json(['status'=>'Failure','Result'=>"Email Id already exist!"], 200);
				}
				$app_name = $application_id; //request('app_name');
				$first_name = request('first_name');
				$last_name = request('last_name');
				$address = request('shipping_address');
				$country_id = request('shipping_country');
				$country_code = request('shipping_country_code');

				$mb = request('shipping_user_mobile_no');
				$firstCharacter = $mb[0];
				if($firstCharacter == 0){
					$mbl = ltrim($mb, '0');
				}else{
					$mbl = $mb;
				}

				$mobile = $country_code . "-" . $mbl;
				$gender = '';//Input::get('gender');
				$married_status = '';//Input::get('married_status');
				if(!empty($pack) && $pack->setupbox_status == 1){
					$country = Country::where('countryid',$country_id)->first();
					$addr = "<p>".$first_name.''.$last_name."</p>".$address."<p>".$country->country_name."</p><p>".$mobile."</p>";
				}else{	
					$addr = "";
				}

				$form_type = request('form_type');
				if($form_type == 'update'){
					$result = self::updCustomerData($email,$first_name,$last_name,$address,$country_id,$mobile,$gender,$married_status,$package_id,"");
					$password = '';
				}else{
					$result = self::insertCustomerData($login_userInfo,$login_userId,$email,$first_name,$last_name,$address,$country_id,$mobile,$gender,$married_status,$package_id,$lguserId);	
					$password = $result['password'];
				}
				$last_inserted_id = $result['last_inserted_id'];
				$referral_code = $result['referral_code'];
				$cust_user_id = $result['cust_user_id'];
				
				$pay = request('pay_my_friend');

				if (!empty($pay)) {
					
					$wal = Wallet::where("user_id", $login_userId)->first();
					$ddwal = Wallet::where("user_id", $lguserId)->first();

					if ($pack->effective_amount <= $ddwal->amount) {
						//payment by reseller/agent wallet					
							Wallet::where('user_id', $lguserId)->decrement('amount', $pack->effective_amount);
							//transactions table
							$bal = $ddwal->amount - $pack->effective_amount;
							
							$transaction_no = self::generate_randam_string('PID', $strength = 9);

							self::user_transactions($transaction_no,$package_id,$lguserId,$lguserId ,$last_inserted_id, 0, $pack->effective_amount, $bal, 'Pay For My Friend', $pack->effective_amount . ' USD paid for customer package purchase.');

						//package purchased and commission pay function
							$pack_pur_id = self::purchaseCommission($cust_user_id,$login_userInfo,$pack,$wal,$last_inserted_id,$package_id,$login_userId,$login_user_comm_per,$first_name,$last_name,2,$lguserId,$app_name);
							$order_id = self::generate_randam_string('ORD', $strength = 9);
							Purchase_order_details::create([
								'user_id' => $last_inserted_id,
								'order_id' => $order_id,
								'purchased_date' => date('Y-m-d H:i:s'),
								'purchased_from' => 'Wallet',
								'sender_id' => $lguserId,
								'status' => 1,
								'package_purchased_id' => $pack_pur_id,
								'type' => 1,
								'shipping_address' => $addr
							]);

							if($pack->setupbox_status == 1){
									$shp = Shipping_address::create([
									'name' => $first_name." ".$last_name,
									'user_id' => $last_inserted_id,
									'shipping_country' => $country_id,
									'shipping_mobile_no' => $mobile,
									'shipping_address' => $address,
									'default_address' => 1,
									'profile_screen' => 1
								]);
							}
							
						Common::packagePurchasedFCM($userInfo,$pack->package_name,$pack->effective_amount,$transaction_no,"sender",$app_name);	
							
					} 
					/*else {
						Session::flash('message', 'Insufficient balance in your wallet');
						Session::flash('alert','Failure');
						return back()->withInput();
					}*/
				}

				$data['useremail'] = array('name' => $first_name.' '.$last_name, 'user_id' => $last_inserted_id, 'email' => $email, 'type'=>'Customer','referral_link' => $referral_code, 'password' => $password);
				$emailid = array('toemail' => $email);
				Mail::send(['html' => 'email_templates.verify-email'], $data, function ($message) use ($emailid) {
					$message->to($emailid['toemail'], 'Email Verify')->subject('Email Verify');
					$message->from('noreply@bestbox.net', 'BestBox');
				});

				return response()->json(['status'=>'Success','Result'=>"Customer Created Successfully"], 200);
			}else{
				return response()->json(['status'=>'Failure','Result'=>"Something went wrong customer creation"], 200);
				
			}
		}
	}
	
	
	
	public static function insertCustomerData($userInfo,$login_userId,$email,$first_name,$last_name,$address,$country_id,$mobile,$gender,$married_status,$package_id,$lguserId="")
	{

				$userId = self::generateCustomerId($first_name);
				$us_cnt = User::where('user_id', $userId)->count();
				if ($us_cnt == 1) {
					$user_id = self::generateCustomerId($first_name);
				} else {
					$user_id = $userId;
				}

				$ref_code = self::generateReferralCode($first_name);
				$ref_cnt = User::where('refferallink_text', $ref_code)->count();

				if ($ref_cnt == 1) {
					$referral_code = self::generateReferralCode($first_name);
				} else {
					$referral_code = $ref_code;
				}

				$input = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$input_length = strlen($input);
				$random_string = '';
				for($i = 0; $i < 9; $i++) {
					$random_character = $input[mt_rand(0, $input_length - 1)];
					$random_string .= $random_character;
				}
				$pwd = $random_string;
				$password=$pwd;
				$hashpwd = Hash::make($pwd);
				$encrypted_plain_pass=safe_encrypt($password,config('constants.encrypt_key')); 
				$user = User::create([
					'user_id' => $user_id,
					'referral_userid' => $login_userId,
					'first_name' => $first_name,
					'last_name' => $last_name,
					'email' => $email,
					'password' => $hashpwd,
					'plain_password'=>$encrypted_plain_pass,
					'gender' => $gender,
					'married_status' => $married_status,
					'registration_date' => date('Y-m-d H:i:s'),
					'shipping_country' => $country_id,
					'shipping_address' => $address,
					'shipping_user_mobile_no' => $mobile,
					'user_role' => 4,
					//'status' => 1,
					'refferallink_text' => $referral_code,
					'created_by' => $lguserId
				]);
				$last_inserted_id = $user->rec_id;

				$wallet = Wallet::create([
					'user_id' => $last_inserted_id,
					'amount' => 0
				]);

				if ($userInfo['user_role'] == 2) {
					//insert user tree 
					Users_tree::create([
						'customer_id' => $last_inserted_id,
						'reseller_id' => $login_userId
					]);
				} else if ($userInfo['user_role'] == 3) {
					//insert user tree 
					$res = Users_tree::where("agent_id", $userInfo['rec_id'])->where("reseller_id", "!=", 0)->first();
					Users_tree::create([
						'customer_id' => $last_inserted_id,
						'agent_id' => $login_userId,
						'reseller_id' => (!empty($res) ? $res->reseller_id : 0)
					]);
				} else {
					//insert user tree 
					Users_tree::create([
						'customer_id' => $last_inserted_id,
						'admin_id' => $login_userId
					]);
				}

				$l = 1;
				$nom = $login_userId;
				$user_role = 4;
				while ($nom != 999) {
					if ($nom != 999 && $l < 150) {
						Unilevel_tree::create([
							'down_id' => $last_inserted_id,
							'upliner_id' => $nom,
							'level' => $l,
							'user_role' => $user_role
						]);
						$l++;
						$results = User::where('rec_id', $nom)->select('referral_userid')->first();
						$nom = $results->referral_userid;
					}
				}

			return array('last_inserted_id'=>$last_inserted_id,'referral_code'=>$referral_code, 'cust_user_id'=>$user_id, 'password'=>$pwd);
	}
	
	public static function updCustomerData($email,$first_name,$last_name,$address,$country_id,$mobile,$gender,$married_status,$package_id,$rec_id)
	{
		$res = User::where('email', $email)->select('rec_id','user_id','refferallink_text')->first();
		$udata = array(
				'first_name' => $first_name,
				'last_name' => $last_name,
				'gender' => $gender,
				'married_status' => $married_status,
				'shipping_country' => $country_id,
				'shipping_address' => $address,
				'shipping_user_mobile_no' => $mobile,
				'referral_join' => 2
			);

		$result = User::where(array('rec_id' => $rec_id))->update($udata);

		return array('last_inserted_id'=>$res->rec_id,'referral_code'=>$res->refferallink_text,'cust_user_id'=>$res->user_id);

	}
	
	public static function purchaseCommission($cust_user_id,$userInfo,$pack,$wal,$last_inserted_id,$package_id,$login_userId,$login_user_comm_per,$first_name,$last_name,$pack_st,$lguserId,$app_name)
	{
		$admin_id = config('constants.ADMIN_ID');
		if($pack_st == 1){
			$duration = $pack->duration; //days
			$pkgres = Package_purchase_list::where(array('user_id' => $last_inserted_id))->where('package_id','!=',11)->orderBy('rec_id','DESC')->first();
			if(!empty($pkgres) && $pkgres->expiry_date > date('Y-m-d h:i:s')){
				$fdate = $pkgres->expiry_date;
				$tdate = date('Y-m-d h:i:s');
				$datetime1 = new DateTime($fdate);
				$datetime2 = new DateTime($tdate);
				$interval = $datetime1->diff($datetime2);
				$days = $interval->format('%a');//now do whatever you like with $days
				$dur = $duration*30;
				$d = round($dur+$days);
				$expiry_date = date('Y-m-d', strtotime("+" . $d . " day"));

			}else{
				$expiry_date = date('Y-m-d', strtotime("+" . $duration . " months"));
			}
			$pack_pur = Package_purchase_list::create([
				'user_id' => $last_inserted_id,
				'package_id' => $package_id,
				'subscription_date' => date('Y-m-d H:i:s'),
				'expiry_date' => $expiry_date,
				'active_package' => 1,
				'purchased_from_userid' => $login_userId
			]);
		}else{
			$pack_pur = Package_purchase_list::create([
				'user_id' => $last_inserted_id,
				'package_id' => $package_id,
				'purchased_from_userid' => $login_userId
			]);
		}
		$pack_pur_id = $pack_pur->rec_id;

			$subscription_fee = $pack->subscription_fee;

			if ($subscription_fee != 0 && $userInfo['admin_login'] != 1) {

					$aid = 0;
					$comm = $subscription_fee * $login_user_comm_per / 100;
					self::directSalesSave($cust_user_id, $login_userId, $last_inserted_id, $pack, $package_id, $pack->effective_amount, $pack->subscription_fee, $comm, $login_user_comm_per);
					
					
					$desc = $pack->package_name.' @ '.$pack->effective_amount.' USD - '.$cust_user_id;
					if($comm != 0 && $comm > 0){

						self::commissionPay($login_userId, $aid, $last_inserted_id, $pack->effective_amount, $pack->subscription_fee, $comm, $login_user_comm_per,'Referral Commission',$desc);
						
						$wal = Wallet::where("user_id", $login_userId)->first();
						$balanc = $wal->amount + $comm;
						$desc = number_format($comm,2) . ' USD received as a commision from customer ('.$first_name.' '.$last_name.')';

						$transaction_no = self::generate_randam_string('CID', $strength = 9);

						self::user_transactions($transaction_no,$package_id,$login_userId, $last_inserted_id,$login_userId, $comm, 0, $balanc, 'Commission', $desc);
						Wallet::where('user_id', $login_userId)->increment('amount', $comm);
						
						$commission_pay_fcm = true;
						
						
					}
					$down_user_comm_per = $login_user_comm_per;

				//$res = Unilevel_tree::where('down_id', $last_inserted_id)->where('upliner_id','!=',$login_userId)->orderBy('level', 'ASC')->get();
				$res = Unilevel_tree::where('down_id', $last_inserted_id)->whereNotIn('upliner_id', [$login_userId,$admin_id])->orderBy('level', 'ASC')->get();
					if (!empty($res)) {
						foreach ($res as $val) {

							$upliner_id = $val->upliner_id;

							$qs = User::where('rec_id', $upliner_id)->where('user_role', '!=', 4)->where('commission_perc', '!=', '')->select('commission_perc', 'user_role')->first();
							if (!empty($qs)) {
								$cmp = $qs->commission_perc - $down_user_comm_per;
								if($cmp != 0 && $cmp > 0){

									$comm1 = $subscription_fee * $cmp / 100;

									if ($userInfo['user_role'] == 3) {
										if ($qs->user_role == 2) {
											$aid = $login_userId;
											$desc = number_format($comm1,2) . ' USD received as a commision from agent ('.$userInfo['first_name'].' '.$userInfo['last_name'].')';
										} else if ($qs->user_role == 3) {
											$aid = $login_userId;
											$desc = number_format($comm1,2) . ' USD received as a commision from agent ('.$userInfo['first_name'].' '.$userInfo['last_name'].')';
										} else {
											$aid = 0;
											$desc = number_format($comm1,2) . ' USD received as a commision from customer ('.$first_name.' '.$last_name.')';
										}
									} else {
										$aid = 0;
										$desc = number_format($comm1,2) . ' USD received as a commision from customer ('.$first_name.' '.$last_name.')';
									}

									self::commissionPay($upliner_id, $aid, $last_inserted_id, $pack->effective_amount, $pack->subscription_fee, $comm1, $cmp,'Referral Commission',$desc);

									$wal = Wallet::where("user_id", $upliner_id)->first();
									$balanc1 = $wal->amount + $comm1;
									
									$transaction_no = self::generate_randam_string('CID', $strength = 9);
									self::user_transactions($transaction_no,$package_id,$upliner_id, $last_inserted_id,$upliner_id, $comm1, 0, $balanc1, 'Commission', $desc);
									Wallet::where('user_id', $upliner_id)->increment('amount', $comm1);

									$down_user_comm_per = $qs->commission_perc;
									
									// send commission Pay FCM 
									Common::commissionSalesFCM($upliner_id,$comm1,$app_name);
									
								}
							}
						}
					}
					
			//referral bonus to customers
				$qs = User::where('rec_id', $last_inserted_id)->select('referral_userid')->first();
				if(!empty($qs)){
					$pres = Package_purchase_list::where('user_id',$last_inserted_id)->where('package_id','!=',11)->count();
					if($pres == 1){
						self::referralBonus($qs->referral_userid,$subscription_fee,$pack->effective_amount,$first_name,$last_name,$last_inserted_id,$package_id,$app_name);
					}
				}
				
				if($commission_pay_fcm == true){
					// send commission Pay FCM 
					Common::commissionSalesFCM($login_userId,$comm,$app_name);	
				}
				
				
				// send directSaleFCM 
				Common::directSaleFCM($login_userId,$pack->effective_amount,$app_name);

			}
			else{
				self::directSalesSave($cust_user_id, $login_userId, $last_inserted_id, $pack, $package_id, $pack->effective_amount, $pack->subscription_fee, 0, $login_user_comm_per);
				
				// send directSaleFCM 
				Common::directSaleFCM($login_userId,$pack->effective_amount,$app_name);
			}
		return $pack_pur_id;
	}
	
	public static function referralBonusold($referred_userid,$subscription_fee,$effective_amount,$first_name,$last_name,$last_inserted_id,$package_id){

		$res = User::where('rec_id', $referred_userid)->where('user_role',4)->first();
		if(!empty($res)){
			$cb = Settings::where('id',1)->select('customer_bonus')->first();
			$ref_bonus = $subscription_fee * $cb->customer_bonus / 100;
			$desc = 'Referral Bonus from customer ('.$first_name.' '.$last_name.')';
			self::commissionPay($referred_userid, 0, $last_inserted_id, $effective_amount, $subscription_fee, $ref_bonus, $cb->customer_bonus,'Referral Bonus',$desc);

			$transaction_no = self::generate_randam_string('RID', $strength = 9);
			$wal = Wallet::where("user_id", $referred_userid)->first();
			$balanc1 = $wal->amount + $ref_bonus;
			self::user_transactions($transaction_no,$package_id,$referred_userid, $last_inserted_id,$referred_userid, $ref_bonus, 0, $balanc1, 'Referral Bonus', $desc);
			Wallet::where('user_id', $referred_userid)->increment('amount', $ref_bonus);
		}
	}
	
	public static function referralBonus($referred_userid,$subscription_fee,$effective_amount,$first_name,$last_name,$last_inserted_id,$package_id,$app_name){

		$res = User::where('rec_id', $referred_userid)->where('user_role',4)->first();
		$package = Packages::where('id',$package_id)->first();
		if(!empty($res) && !empty($package) && $package->id != 11){
			$vod_series_package = $package->vod_series_package;
			if($vod_series_package){
				$ref_bonus = 3;
			}else{
				$cb = Settings::where('id',1)->select('customer_bonus')->first();
				$ref_bonus = $cb->customer_bonus;
			}

			//insert joining bonus transaction table
			$transaction_no = self::generate_randam_string('JGB', $strength = 9);
			$admin_id = config('constants.ADMIN_ID');
			$ttype = "Joining Bonus";
			$wal2 = Wallet::where("user_id", $last_inserted_id)->first();
			$balanc2 = $wal2->amount + $ref_bonus;
			Wallet::where('user_id', $last_inserted_id)->increment('amount', $ref_bonus);
			$description = $ref_bonus." USD Credited for Joining Bonus";
        	self::user_transactions($transaction_no,$package_id,$last_inserted_id,$admin_id,$last_inserted_id, $ref_bonus,0, $balanc2, $ttype, $description);
        	
			$desc = 'Referral Bonus from customer ('.$first_name.' '.$last_name.')';
			self::commissionPay($referred_userid, 0, $last_inserted_id, $effective_amount, $subscription_fee, $ref_bonus, $ref_bonus,'Referral Bonus',$desc);

			$transaction_no = self::generate_randam_string('RID', $strength = 9);
			$wal = Wallet::where("user_id", $referred_userid)->first();
			$balanc1 = $wal->amount + $ref_bonus;
			self::user_transactions($transaction_no,$package_id,$referred_userid, $last_inserted_id,$referred_userid, $ref_bonus, 0, $balanc1, 'Referral Bonus', $desc);
			Wallet::where('user_id', $referred_userid)->increment('amount', $ref_bonus);
			
			// send Referral Bonus FCM
			$customer_name = $first_name.' '.$last_name;
			Common::referralBonusFCM($referred_userid,$ref_bonus,$customer_name,$app_name);
			
		}
	}

	
	// update Customer info
	public function updateCustomerInfo(Request $request)
	{
		$userInfo = $request->user();
		$user_role = $userInfo['user_role'];
		
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
        $validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
			'rec_id' => 'required',
			'first_name' => 'required',
			'last_name' => 'required',
			'gender' => 'required',
			'shipping_address' => 'required',
			'shipping_country' => 'required',
			'shipping_user_mobile_no' => 'required|alpha_dash'
			
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);            
        }else{
		
			$rec_id = request('rec_id');
			
			$first_name = request('first_name');
			$last_name = request('last_name');
			$gender = request('gender');
			$married_status = ""; //request('married_status');
			$shipping_address1 = request('shipping_address');
			
			$shipping_country = request('shipping_country');
			//$country_id = request('country_id');
			$shipping_user_mobile = request('shipping_user_mobile_no');
			$shippping = explode("-",$shipping_user_mobile);
			$shipping_user_mobile1= $shippping[1];
			
			$countryInfo = Country::select('*')->where('countryid', '=',$shipping_country)->first();
			if(!empty($countryInfo)){
				$currencycode = $countryInfo->currencycode;
			}else{
				$currencycode = "";
			}
			
			$shipping_user_mobile_no = "+".$currencycode."-".$shipping_user_mobile1;
			
			$data = [
						'first_name' => $first_name,
						'last_name' => $last_name,
						'gender' =>$gender,
						'married_status' =>$married_status,
						'shipping_address' => $shipping_address,
						'shipping_country' => $shipping_country,
						'shipping_user_mobile_no' => $shipping_user_mobile_no,
					];
					
			$res = User::where('rec_id','=',$rec_id)->update($data);		
			if($res){
				return response()->json(['status' => 'Success', 'Result' => "Customer Info Updated successfully"], 200);	
			}else{
				return response()->json(['status'=>'Failure','Result'=>"something went wrong" ], 200);
			}
		}
		
	}
	
	
	// delete Customer
	public function deleteCustomer(Request $request)
	{
		$userInfo = $request->user();
		$user_role = $userInfo['user_role'];
		
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
        $validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
            'rec_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);            
        }else{
				
			$rec_id = request('rec_id');
			$data = array("status"=>0);
			$res = User::where('rec_id','=',$rec_id)->update($data);
			if($res){
				return response()->json(['status' => 'Success', 'Result' => "Customer deleted successfully"], 200);	
			}else{
				return response()->json(['status'=>'Failure','Result'=>"something went wrong" ], 200);
			}
		}
		
	}
	

	
	public function payCustomerList(Request $request)
	{
		$userInfo = $request->user();
		$login_userId = $userInfo['rec_id'];
		//print_r($data);exit;
        
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
        $validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
            'page' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);            
        }else{
			$limit = 20;
			$page = request('page');
			
			$searchKey = request('searchKey');
			
			if(!empty($searchKey)){
				
				if (filter_var($searchKey, FILTER_VALIDATE_EMAIL)) {
				
					$customers = Unilevel_tree::join('users','unilevel_tree.down_id','=','users.rec_id')->leftjoin('package_purchased_list as ppl', 'users.rec_id', '=', 'ppl.user_id')->where('unilevel_tree.upliner_id',$login_userId)->where('unilevel_tree.user_role',4)->where('users.status','=',1)->where('users.email_verify','=',1)->where('users.email','=',$searchKey)->select('users.first_name','users.last_name','users.user_id','users.rec_id','users.image','users.email','ppl.package_id','ppl.subscription_date','ppl.expiry_date','ppl.active_package','ppl.purchased_from_userid', DB::raw('MAX(ppl.expiry_date) AS expiry_date'))->groupBy('unilevel_tree.down_id')->skip($page * $limit)->take($limit)->get();
					
				}else{
					$customers = Unilevel_tree::join('users','unilevel_tree.down_id','=','users.rec_id')->leftjoin('package_purchased_list as ppl', 'users.rec_id', '=', 'ppl.user_id')->where('unilevel_tree.upliner_id',$login_userId)->where('unilevel_tree.user_role',4)->where('users.status','=',1)->where('users.email_verify','=',1)->where(DB::raw('concat(users.first_name," ",users.last_name)'), 'LIKE', '%' . $searchKey . '%')->select('users.first_name','users.last_name','users.user_id','users.rec_id','users.image','users.email','ppl.package_id','ppl.subscription_date','ppl.expiry_date','ppl.active_package','ppl.purchased_from_userid', DB::raw('MAX(ppl.expiry_date) AS expiry_date'))->groupBy('unilevel_tree.down_id')->skip($page * $limit)->take($limit)->get();
				}
					
				
				
			}else{
			
				$customers = Unilevel_tree::join('users','unilevel_tree.down_id','=','users.rec_id')->leftjoin('package_purchased_list as ppl', 'users.rec_id', '=', 'ppl.user_id')->where('unilevel_tree.upliner_id',$login_userId)->where('unilevel_tree.user_role',4)->where('users.status','=',1)->where('users.email_verify','=',1)->select('users.first_name','users.last_name','users.user_id','users.rec_id','users.image','users.email','ppl.package_id','ppl.subscription_date','ppl.expiry_date','ppl.active_package','ppl.purchased_from_userid', DB::raw('MAX(ppl.expiry_date) AS expiry_date'))->groupBy('unilevel_tree.down_id')->skip($page * $limit)->take($limit)->get();
			
			}
			
			
			$customersList = array();
			if(@count($customers)>0){
				
				foreach($customers as $res){
					//echo "<pre>";print_r($res);exit;
					$customer_id = $res['user_id'];
					$fullName = $res['first_name']." ".$res['last_name'];
					$email = $res['email'];
					$package_id = $res['package_id'];
					$subscription_date = $res['subscription_date'];
					$expiry_date = $res['expiry_date'];
					$active_package = $res['active_package'];
					
					$profileImage = $res['image'];
					if(!empty($profileImage)){
						$profile_pic = 	$profileImage;
					}else{
						$profile_pic = "";
					}
					
					$pkgDetails = Packages::where('id','=',$package_id)->first();
					if(!empty($pkgDetails)){
						$package_name = $pkgDetails->package_name;
						$package_image = $pkgDetails->package_image;
						$package_description = $pkgDetails->description;
						$package_amt = number_format($pkgDetails->effective_amount,2);
						
						$current_date = date('Y-m-d H:i:s');
						if($expiry_date == NULL){
							$expiry_status = "Activation pending";
							$expiry_btn_color = "";
							$renew_btn_color = "";
							$subscription_status = 4;
						}else{
							if($expiry_date < $current_date){
								$expiry_status = "Expired";
								$expiry_btn_color = "Red";
								$renew_btn_color = "Orange";
								$subscription_status = 2;
							}else{
								$expiry_status = "Active";
								$expiry_btn_color = "green";
								$renew_btn_color = "";
								$subscription_status = 1;
							}
						}
						
					}else{
						$package_name = "";
						$package_amt = "";
						$expiry_status = "Not Subscribed";
						$subscription_status = 3;
					}
					
					
				
					$customersList[] = array(
									
									"customer_id"=>$customer_id,
									"email"=>$email,
									"userName"=>$fullName,
									"profile_pic"=>$profile_pic,
									"package_name"=>$package_name,
									"package_amt"=>$package_amt,
									"package_status"=>$expiry_status,
									"subscription_status"=>$subscription_status,
									'currency_symbol'=>'$',
									'currency_format'=>'USD'
									
									);
					
				}
				return response()->json(['status' => 'Success','Result' => $customersList], 200);
			}else{
				return response()->json(['status'=>'Failure','Result'=>"No Records Found" ], 200);
			}
		
		}
	
		
	}
	


	
	
	public static function commissionPay($user_id, $agent_id, $sender_id, $sales_amount, $subscription_amount, $commission, $commission_per,$commission_type,$description)
	{
		Commissions::create([
			'user_id' => $user_id,
			'agent_id' => $agent_id,
			'sender_user_id' => $sender_id,
			'sales_amount' => $sales_amount,
			'subscription_amount' => $subscription_amount,
			'commission' => $commission,
			'commission_perc' => $commission_per,
			'added_date' => date('Y-m-d H:i:s'),
			'commission_type' => $commission_type,
			'description' => $description
		]);
	}

	public static function directSalesSave($cust_user_id, $user_id, $sender_id, $pack, $package_id, $sales_amount, $subscription_amount, $commission, $commission_per)
	{
		$desc = $pack->package_name.' @ '.$pack->effective_amount.' USD - '.$cust_user_id;
		Sales::create([
			'added_date' => date('Y-m-d H:i:s'),
			'user_id' => $user_id,
			'customer_id' => $sender_id,
			'package_id' => $package_id,
			'sales_amount' => $sales_amount,
			'subscription_amount' => $subscription_amount,
			'commission' => $commission,
			'commission_per' => $commission_per,
			'description' => $desc
		]);
	}

	
	public static function user_transactions($transaction_no,$package_id,$login_userId,$sender_id,$receiver_id, $credit, $debit, $balanc, $ttype, $description)
	{
		$transactions = Transactions::create([
			'transaction_no' => $transaction_no,
			'user_id' => $login_userId,
			'sender_id' => $sender_id,
			'receiver_id' => $receiver_id,
			'received_date' => date('Y-m-d H:i:s'),
			'package_id' =>$package_id,
			'credit' => $credit,
			'debit' => $debit,
			'balance' => $balanc,
			'ttype' => $ttype,
			'description' => $description,
			'status' => 1
		]);
		return $transactions->rec_id;
	}


	
	
	public function payForMyFriendAPI(Request $request)
	{
		$userInfo = $request->user();
		$user_role = $userInfo['user_role'];
		$login_userId = $userInfo['rec_id'];
		$login_user_comm_per = $userInfo['commission_perc'];
		
		
		
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
        $validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
            'customer_id' => 'required',
			'package_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);            
        }else{
			$app_name = $userInfo['application_id']; //request('app_name');	
			$customer_id = request('customer_id'); //Input::get('customer_id');
			$package_id = request('package_id'); // Input::get('package');
			$pack = Packages::where("id", $package_id)->first();
			$wal = Wallet::where("user_id", $login_userId)->first();
			//$customer_det = User::where('rec_id',$customer_id)->first();
			$customer_det = User::where('user_id',$customer_id)->first();

			if($userInfo['user_role'] == 4){
				$uplinerInfo = Unilevel_tree::leftjoin('users','unilevel_tree.upliner_id','=','users.rec_id')->where('unilevel_tree.down_id',$login_userId)->where('users.user_role','!=',4)->select('users.*')->orderBy('unilevel_tree.level','ASC')->first();
				if(!empty($uplinerInfo)){
					$upliner_userId = $uplinerInfo['rec_id'];
					$upliner_user_comm_per = $uplinerInfo['commission_perc'];
				}
			}else{
				//$uplinerInfo = $userInfo;
				//$upliner_userId = $userInfo['rec_id'];
				//$upliner_user_comm_per = $userInfo['commission_perc'];
				
				$uplinerInfo = Unilevel_tree::leftjoin('users','unilevel_tree.upliner_id','=','users.rec_id')->where('unilevel_tree.down_id',$customer_id)->where('users.user_role','!=',4)->select('users.*')->orderBy('unilevel_tree.level','ASC')->first();
				if(!empty($uplinerInfo)){
					$upliner_userId = $uplinerInfo['rec_id'];
					$upliner_user_comm_per = $uplinerInfo['commission_perc'];
				}
				
				
			}
			
			
			
			if ($pack->effective_amount <= $wal->amount) {
				
				//payment by reseller/agent wallet
				Wallet::where('user_id', $login_userId)->decrement('amount', $pack->effective_amount);
				//transactions table
				$bal = $wal->amount - $pack->effective_amount;
				
				$transaction_no = self::generate_randam_string('PID', $strength = 9);

				$res = self::user_transactions($transaction_no,$package_id,$login_userId,$login_userId ,$customer_det->rec_id, 0, $pack->effective_amount, $bal, 'Pay For My Friend', $pack->effective_amount . ' USD paid for customer package purchase.');
				//package purchased and commission pay function
				$pack_pur_id = self::purchaseCommission($customer_det->user_id,$uplinerInfo,$pack,$wal,$customer_det->rec_id,$package_id,$upliner_userId,$upliner_user_comm_per,$customer_det->first_name,$customer_det->last_name,2,$login_userId,$app_name);

				//$cnt = Purchase_order_details::where('user_id',$customer_det->rec_id)->count();
				$cnt = Purchase_order_details::where('user_id',$customer_det->rec_id)->where('type',1)->whereIn('status', [1, 2])->count();
				if($cnt == 0){
					$type = 1;
					
				}else{
					$type = 2;
				}
				$order_id = self::generate_randam_string('ORD', $strength = 9);
				Purchase_order_details::create([
							'user_id' => $customer_det->rec_id,
							'order_id' => $order_id,
							'purchased_date' => date('Y-m-d H:i:s'),
							'purchased_from' => 'Wallet',
							'sender_id' => $login_userId,
							'status' => 1,
							'package_purchased_id' => $pack_pur_id,
							'type' => $type
						]);
				
				$logged_user_info = $userInfo;
				
				// send FCM to sender
				Common::payForMyFriendFCM($logged_user_info,$pack->package_name,$pack->effective_amount,$transaction_no,"sender",$customer_det,$app_name);
				
				// send FCM to Receiver
				//Common::payForMyFriendFCM($logged_user_info,$pack->package_name,$pack->effective_amount,$transaction_no,"receiver",$customer_det); 
				
				if($type == 1){  
				
				// send FCM to Receiver
				Common::packagePurchasedFCMToReceiver($logged_user_info,$pack->package_name,$pack->effective_amount,$transaction_no,"receiver",$customer_det,$app_name);
					
					
				}else{
					
				// send FCM to Receiver
				Common::packageRenewalFCM($logged_user_info,$pack->package_name,$pack->effective_amount,$transaction_no,"receiver",$customer_det,$app_name);
				}
				
				
				return response()->json(['status' => 'Success','Result' =>"Successfully Paid to Friend",'wallet_balance'=>number_format($bal,2)], 200);
				
			} else {
				
				return response()->json(['status'=>'Failure','Result'=>"Insufficient balance in your wallet" ], 200);
			}
		
		}
		
	}
	
	//Save Renewal API Side
	public function saveRenewalAPI(Request $request)
	{
		$admin_id = config('constants.ADMIN_ID');
		$userInfo = $request->user();
		$user_role = $userInfo['user_role'];
		$login_userId = $userInfo['rec_id'];
		$login_user_comm_per = $userInfo['commission_perc'];
		
		
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
        $validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
           'package_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);            
        }else{
			$app_name = $userInfo['application_id']; //request('app_name'); 
			$package_id = request('package_id'); 
			$pack = Packages::where("id", $package_id)->first();
			$wal = Wallet::where("user_id", $login_userId)->first();
			
			$uplinerInfo = Unilevel_tree::leftjoin('users','unilevel_tree.upliner_id','=','users.rec_id')->where('unilevel_tree.down_id',$login_userId)->where('users.user_role','!=',4)->select('users.*')->orderBy('unilevel_tree.level','ASC')->first();
			if(!empty($uplinerInfo)){
				$upliner_userId = $uplinerInfo['rec_id'];
				$upliner_user_comm_per = $uplinerInfo['commission_perc'];			

				if ($pack->effective_amount <= $wal->amount) {

					//payment by reseller/agent wallet
					Wallet::where('user_id', $login_userId)->decrement('amount', $pack->effective_amount);
					//transactions table
					$bal = $wal->amount - $pack->effective_amount;
					
					$transaction_no = self::generate_randam_string('RNID', $strength = 9);
					$desc = number_format($pack->effective_amount). ' USD paid for renewal package purchase.';
					self::user_transactions($transaction_no,$package_id,$login_userId,$login_userId ,$admin_id, 0, $pack->effective_amount, $bal, 'Renewal Package', $desc);
					//package purchased and commission pay function
					$pack_pur_id = self::purchaseCommission($userInfo['user_id'],$uplinerInfo,$pack,$wal,$login_userId,$package_id,$upliner_userId,$upliner_user_comm_per,$userInfo['first_name'],$userInfo['last_name'],2,$login_userId,$app_name);
					$order_id = self::generate_randam_string('ORD', $strength = 9);
					Purchase_order_details::create([
								'user_id' => $login_userId,
								'order_id' => $order_id,
								'purchased_date' => date('Y-m-d H:i:s'),
								'purchased_from' => 'Wallet',
								'sender_id' => $login_userId,
								'status' => 1,
								'package_purchased_id' => $pack_pur_id,
								'type' =>2
							]);
					//$arr = array('active_package'=>0);
					//Package_purchase_list::where('user_id',$login_userId)->where('rec_id','<',$pack_pur_id)->update($arr);
					
				
				// send FCM to Receiver (Cusotmer Renewal)
				Common::packageRenewalFCM($userInfo,$pack->package_name,$pack->effective_amount,$transaction_no,"receiver",$userInfo,$app_name);
					
					return response()->json(['status' => 'Success','Result' =>"Renewal Package Purchased Successfully",'wallet_balance'=>number_format($bal,2)], 200);
					
				} else {
					return response()->json(['status'=>'Failure','Result'=>"Insufficient balance in your wallet" ], 200);
					
				}
			}
			
		}
		
	}
	

	
	
	
}
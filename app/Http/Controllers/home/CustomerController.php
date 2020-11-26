<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Http\Controllers\home\AdminController;
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
use App\Wallet;
use App\Country;
use App\Visitor;
use App\Commissions;
use App\Packages;
use App\Package_purchase_list;
use App\Sales;
use App\Users_tree;
use App\Unilevel_tree;
use App\Transactions;
use App\Settings;
use App\Multiple_box_purchase;
use App\PaymentsHistory;
use App\Models\registerModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use App\Withdraw_request;
use App\Purchase_order_details;
use App\Shipping_address;
use App\Library\Common;
use App\Free_trail_requested_users;
use Illuminate\Support\Facades\Log;
use App\ApplicationsInfo;
use App\UsersDevicesList;
use App\ApplicationSettings;
use App\Http\Controllers\API\UserController;
class CustomerController extends Controller {
	//customers
	public function customers(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$data['userInfo'] = $userInfo;
		$data['from_date'] = $request->query('from_date');
		$data['to_date'] = $request->query('to_date');
		$searchKey = $request->query('searchKey');
		$status = $request->query('status');
		if (!empty($searchKey) && !empty($request->query('from_date')) && !empty($request->query('to_date'))) {

				$from_date = Carbon::createFromFormat('m-d-Y', $data['from_date'])->format('Y-m-d');
				$to_date = Carbon::createFromFormat('m-d-Y', $data['to_date'])->format('Y-m-d');
				$start = Carbon::parse($from_date)->format('Y-m-d H:i:s');
				$todate = Carbon::parse($to_date)->format('Y-m-d H:i:s');
				$to = date('Y-m-d H:i:s', strtotime($todate . ' +1 day'));
				if ($userInfo['user_role'] == 2) {
					$res = User::join('users_tree','users.rec_id','=','users_tree.customer_id')->where("users_tree.reseller_id", $userInfo['rec_id'])
					->where(function($query) use($searchKey) {
               			 return $query->where('users.user_id','LIKE', '%' . $searchKey . '%')->orWhere('users.email', 'LIKE', '%' . $searchKey . '%')->orWhereRaw("concat(users.first_name, ' ', users.last_name) like '%$searchKey%'");
            		})
					->where("users_tree.customer_id", "!=", 0)
					->whereBetween("users_tree.created_at",[$start, $to])->select('customer_id')->get();
				} else if ($userInfo['user_role'] == 3) {

					$res = User::join('users_tree','users.rec_id','=','users_tree.customer_id')->where("users_tree.agent_id", $userInfo['rec_id'])
					->where(function($query) use($searchKey){
               			 return $query->where('users.user_id','LIKE', '%' . $searchKey . '%')->orWhere('users.email', 'LIKE', '%' . $searchKey . '%')->orWhereRaw("concat(users.first_name, ' ', users.last_name) like '%$searchKey%'");
            		})
					->where("users_tree.customer_id", "!=", 0)->orderBy("users_tree.rec_id", "DESC")
					->whereBetween("users_tree.created_at",[$start, $to])->select('customer_id')->get();
				} else {
					$res = User::join('users_tree','users.rec_id','=','users_tree.customer_id')
					->where(function($query) use($searchKey) {
               			 return $query->where('users.user_id','LIKE', '%' . $searchKey . '%')->orWhere('users.email', 'LIKE', '%' . $searchKey . '%')->orWhereRaw("concat(users.first_name, ' ', users.last_name) like '%$searchKey%'");
            		})
            		->where("users_tree.customer_id", "!=", 0)
            		->whereBetween("users_tree.created_at",[$start, $to])->select('customer_id')->get();
				}
		}else if (!empty($request->query('from_date')) && !empty($request->query('to_date'))) {
			$from_date = Carbon::createFromFormat('m-d-Y', $data['from_date'])->format('Y-m-d');
			$to_date = Carbon::createFromFormat('m-d-Y', $data['to_date'])->format('Y-m-d');
			$start = Carbon::parse($from_date)->format('Y-m-d H:i:s');
			$todate = Carbon::parse($to_date)->format('Y-m-d H:i:s');
			$to = date('Y-m-d H:i:s', strtotime($todate . ' +1 day'));
			if ($userInfo['user_role'] == 2) {
				$res = Users_tree::where("reseller_id", $userInfo['rec_id'])->where("customer_id", "!=", 0)->whereBetween("created_at",[$start, $to])->select('customer_id')->orderBy("rec_id", "DESC")->get();
			} else if ($userInfo['user_role'] == 3) {
				$res = Users_tree::where("agent_id", $userInfo['rec_id'])->where("customer_id", "!=", 0)->whereBetween("created_at",[$start, $to])->select('customer_id')->orderBy("rec_id", "DESC")->get();
			} else {
				$res = Users_tree::where("customer_id", "!=", 0)->whereBetween("created_at",[$start, $to])->select('customer_id')->orderBy("rec_id", "DESC")->get();
			}

		}else if (!empty($searchKey)) {

				if ($userInfo['user_role'] == 2) {
					$res = User::join('users_tree','users.rec_id','=','users_tree.customer_id')->where("users_tree.reseller_id", $userInfo['rec_id'])
					->where(function($query) use($searchKey) {
               			 return $query->where('users.user_id','LIKE', '%' . $searchKey . '%')->orWhere('users.email', 'LIKE', '%' . $searchKey . '%')->orWhereRaw("concat(users.first_name, ' ', users.last_name) like '%$searchKey%'");
            		})
					->where("users_tree.customer_id", "!=", 0)->select('customer_id')->get();
				} else if ($userInfo['user_role'] == 3) {
					$res = User::join('users_tree','users.rec_id','=','users_tree.customer_id')->where("users_tree.agent_id", $userInfo['rec_id'])
					->where(function($query) use($searchKey){
               			 return $query->where('users.user_id','LIKE', '%' . $searchKey . '%')->orWhere('users.email', 'LIKE', '%' . $searchKey . '%')->orWhereRaw("concat(users.first_name, ' ', users.last_name) like '%$searchKey%'");
            		})
					->where("users_tree.customer_id", "!=", 0)->select('customer_id')->orderBy("users_tree.rec_id", "DESC")->get();
				} else {
					$res = User::join('users_tree','users.rec_id','=','users_tree.customer_id')
					->where(function($query) use($searchKey) {
               			 return $query->where('users.user_id','LIKE', '%' . $searchKey . '%')->orWhere('users.email', 'LIKE', '%' . $searchKey . '%')->orWhereRaw("concat(users.first_name, ' ', users.last_name) like '%$searchKey%'");
            		})
            		->where("users_tree.customer_id", "!=", 0)->select('customer_id')->get();
				}

		}else{
			if ($userInfo['user_role'] == 2) {
				$res = Users_tree::where("reseller_id", $userInfo['rec_id'])->where("customer_id", "!=", 0)->select('customer_id')->orderBy("rec_id", "DESC")->get();
			} else if ($userInfo['user_role'] == 3) {
				$res = Users_tree::where("agent_id", $userInfo['rec_id'])->where("customer_id", "!=", 0)->select('customer_id')->orderBy("rec_id", "DESC")->get();
			} else {
				$res = Users_tree::where("customer_id", "!=", 0)->orderBy("rec_id", "DESC")->select('customer_id')->get();
			}
		}
		if($userInfo['user_role'] == 1){
			$where = array('users.email_verify'=>1);
		}
		else{
			$where = array('users.email_verify'=>1);
		}

		$arr = array();
		foreach ($res as $val) {
			array_push($arr, $val->customer_id);
		}
		$cur_date = date('Y-m-d H:i:s');
		$symbol = ($status == 1)? 1 : 0;
		if($status == 1){
			$wr = '>';
		}else{
			$wr = '<';
		}
		if(!empty($status)){
			$data['customers'] = User::leftJoin(\DB::raw('(SELECT * FROM package_purchased_list WHERE rec_id IN (SELECT MAX(rec_id) AS id FROM package_purchased_list WHERE package_id != 11 GROUP BY user_id) ORDER BY user_id) AS t2'), function($join) {
			        $join->on('users.rec_id', '=', 't2.user_id');
			    })->leftjoin('packages', 't2.package_id', '=', 'packages.id')->where($where)->whereIn('users.rec_id', $arr)->select('t2.rec_id AS pRec_id','users.rec_id', 'users.user_id','users.referral_userid','users.email_verify', 'users.first_name','users.last_name', 'users.email','users.registration_date', 'users.status','users.refferallink_text', 'packages.id','packages.effective_amount', 't2.expiry_date','packages.package_name','packages.setupbox_status')->where('t2.expiry_date',$wr,NOW())->groupBy('users.user_id')->orderBy('users.rec_id', 'DESC')->paginate(50);
		}else{
			$data['customers'] = User::leftJoin(\DB::raw('(SELECT * FROM package_purchased_list WHERE rec_id IN (SELECT MAX(rec_id) AS id FROM package_purchased_list WHERE package_id != 11 GROUP BY user_id) ORDER BY user_id) AS t2'), function($join) {
			        $join->on('users.rec_id', '=', 't2.user_id');
			    })->leftjoin('packages', 't2.package_id', '=', 'packages.id')->where($where)->whereIn('users.rec_id', $arr)->select('users.rec_id', 'users.user_id','users.referral_userid','users.email_verify', 'users.first_name','users.last_name', 'users.email', 'users.registration_date', 'users.status', 'users.refferallink_text','packages.id','packages.effective_amount', 't2.expiry_date','packages.package_name','packages.setupbox_status')->groupBy('users.user_id')->orderBy('users.rec_id', 'DESC')->paginate(50);
		}


		$data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();
		$data['searchKey'] = $searchKey;
		$data['status'] = $status;

		return view('customer')->with($data);
	}

	public function customerNew($customerId="")
	{
		$customer_id = base64_decode($customerId);
		$res = User::where('rec_id',$customer_id)->where('user_role',4)->where('referral_join',1)->select('rec_id','first_name','last_name','email')->first();
		if(!empty($res)){
			$data['customer_info']= array('message' => 'Referral Email Id', 'first_name' => $res->first_name, 'last_name' => $res->last_name, 'email' => $res->email, 'form_type'=>'update');
		}else{
			$data['customer_info']= array('message' => 'Email Id available', 'first_name' => '', 'last_name' => '', 'email' => '', 'form_type'=>'insert');
		}

		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$data['userInfo'] = $userInfo;
		$data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();
		$data['package_data'] = DB::table('packages')->where('status', 1)->get();
		$data['wallet_balance'] = Wallet::where('user_id', $login_userId)->first();
		return view('customer-new')->with($data);
	}

	public function checkReferralUser(Request $request){

		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];

		$email = $request->email;
		$validator = Validator::make($request->all(), [
			'email' => 'required|email|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$/'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			$data = array('message' => 'Not valid', 'first_name' => '', 'last_name' => '', 'form_type'=>'insert');
		} else {
			/*$res = User::where('email',$email)->where('referral_userid',$login_userId)->where('user_role',4)->where('referral_join',1)->select('first_name','last_name','email','rec_id')->first();
			if(!empty($res)){
				$data = array('message' => 'Referral Email Id', 'first_name' => $res->first_name, 'last_name' => $res->last_name, 'form_type'=>'update');
			}else{*/
				$cnt = User::where('email',$email)->count();
				if($cnt > 0){
					$data = array('message' => 'Email Id already existed!', 'first_name' => '', 'last_name' => '', 'form_type'=>'insert');
				}else{
					$data = array('message' => 'Email Id available', 'first_name' => '', 'last_name' => '', 'form_type'=>'insert');
				}
			//}
		}

		return $data;
	}

	public function createCustomer(Request $request)
	{
		$userInfo = Auth::user();
		$lguserId = $userInfo['rec_id'];
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

		$validator = Validator::make($request->all(), [
			'email' => 'required|email|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$/',
			'password' => 'required|regex:/^.*(?=.{8,})(?=.*[a-z])(?=.*[0-9]).*$/|same:confirm_password',
			'confirm_password' => 'required',
			'first_name' => 'required|string|min:3|max:255',
			'last_name' => 'required|string|min:3|max:255'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			return Redirect::back()->withErrors(['<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>'])->withInput();
		} else {

			$package_id = Input::get('package');
			$pack = Packages::where("id", $package_id)->first();

			if(!empty($pack) && $pack->setupbox_status == 1){
				$validator = Validator::make($request->all(), [
					'shipping_address' => 'required',
					'shipping_country' => 'required',
					'shipping_user_mobile_no' => 'required|regex:/^([0-9]{8,14})$/'
				]);
				if ($validator->fails()) {
					$errs = $validator->messages()->all();
					$str = '';
					foreach ($errs as $arr) {
						$str = $str . '<li>' . $arr . '</li>';
					}
					return Redirect::back()->withErrors(['<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>'])->withInput();
					$status = 0;
				}else{
					$status = 1;
				}
			}else{
				$status = 1;
			}
		if($status == 1){
			$email = Input::get('email');
			$cnt = User::where('email',$email)->where('referral_join',[0,2])->count();
			if($cnt == 1){
				Session::flash('message', 'Email Id already existed!');
				Session::flash('alert','Failure');
				return back()->withInput();
			}

			$password = Input::get('password');
			$first_name = Input::get('first_name');
			$last_name = Input::get('last_name');
			$address = Input::get('shipping_address');
			$country_id = Input::get('shipping_country');
			$country_code = Input::get('shipping_country_code');

			$mb = Input::get('shipping_user_mobile_no');
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

			$form_type = Input::get('form_type');
			if($form_type == 'update'){
				$result = self::updCustomerData($email,$first_name,$last_name,$address,$country_id,$mobile,$gender,$married_status,$package_id,"");
				$password = '';
			}else{
				$result = self::insertCustomerData($login_userInfo,$login_userId,$email,$first_name,$last_name,$address,$country_id,$mobile,$gender,$married_status,$package_id,$lguserId,$password);
				$password = $result['password'];
			}
			$last_inserted_id = $result['last_inserted_id'];
			$referral_code = $result['referral_code'];
			$cust_user_id = $result['cust_user_id'];

			$pay = Input::get('pay');

			if(!empty($pay) && $pay == 'EVERUSPAY'){
				$validator = Validator::make($request->all(), [
					'package' => 'required'
				]);
				if ($validator->fails()) {
					$errs = $validator->messages()->all();
					$str = '';
					foreach ($errs as $arr) {
						$str = $str . '<li>' . $arr . '</li>';
					}
					return Redirect::back()->withErrors(['<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>'])->withInput();
					$status = 0;
				}
				$data['useremail'] = array('name' => $first_name.' '.$last_name, 'user_id' => $last_inserted_id,'customer_id' => $cust_user_id,  'email' => $email, 'type'=>'Customer','referral_link' => $referral_code, 'password' => $password,'application_id'=>1234,'user_role' => 4);
				$emailid = array('toemail' => $email);
				Mail::send(['html' => 'email_templates.verify-email'], $data, function ($message) use ($emailid) {
					$message->to($emailid['toemail'], 'Email Verification')->subject('Email Verification');
					$message->from('noreply@bestbox.net', 'BestBox');
				});

				//payment with everuspay
					$refnumber = self::generate_randam_string('ORD', $strength = 9);
					$userdata = User::where('rec_id',$login_userId)->first();

					$transaction_no = self::generate_randam_string('RNID', $strength = 9);
					//insert data into payments history table

					$payment_history = PaymentsHistory::create([
						'user_id' => $login_userId,
						'customer_id' => $last_inserted_id,
						'order_id' => $refnumber,
						'transaction_no' => $transaction_no,
						'package_id' => $package_id,
						'amount_in_usd' => $pack->effective_amount,
						'subscription_type' => 1,
						'subscription_desc' => $pack->effective_amount . ' USD paid for customer package purchase.',
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')
					])->id;

					$random_number = self::generate_randam_string('TEL', $strength = 9);

					$userContact = ($userdata->telephone!='') ? $userdata->telephone : $random_number;

					$data = array(
						'MerchantId' => config('constants.EVERUS_MERCHANT_ID'), 'RefNo' =>  $refnumber,'Amount' => $pack->effective_amount, 'Currency' => 'USD','ProdDesc' => $pack->package_name.' '.$pack->description,'UserName' => $userdata->first_name.' '.$userdata->last_name,'UserEmail' => $userdata->email,'UserContact' => $userContact, 'Remark' => $payment_history,'Lang' => 'UTF-8','TimeZone' => "America/Los_Angeles", 'BrandName' => 'BestBox',
						'CallBackUrl' => url('/').'/everusPayCallback', 'BackendURL' => url('/').'/everusPayCallback'
					);
					$html = '';
					$merchantURL = config('constants.MERCHANT_FORM_URL');
					$html .= '<form  style="display: none"  name="redirectpost" class="redirectpost"  id ="redirectpost" method="post" action="'.$merchantURL.'">';
					foreach($data as $key =>$value){
						if(!is_array($value)){
							$html .= '<input type="hidden" name="'.trim($key).'" value="'.trim($value).'"> ';
						}else if(is_array($value)){
							foreach ($value as $key1 => $value1) {
								$html .= '<input type="hidden" name="' . $key1 . '" value="' . $value1 . '"> ';
							}
						}
					}

					$html .= '<input type="submit" class="final_submit" value="submit" name="submit">';
					$html .= '</form>';
					echo $html;
					echo '<div style="text-align:center;width:100% id="loader" style="display: none"><img src="'.url('/').'/public/images/loader.gif" style="display: block; margin: auto;" /><div style="text-align:center;font-size:30px;font-weight:600;margin: 10px 0px;">Please wait...Redirect to EVERUSPAY Payment Gateway</div><div style="text-align:center;font-size:26px;font-weight:500;margin: 10px 0px;">do not refresh or press back button.</div><div>';
					?>
					<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
					<script type='text/javascript'>
						$("#loader").css('display','block');
						var interval = setInterval(function () {
							$( ".final_submit" ).trigger( "click" );
							return false;
						}, 2000);
					</script>
			<?php }
			 else if (!empty($pay) && $pay == 'WALLET') {

			 	$validator = Validator::make($request->all(), [
					'package' => 'required'
				]);
				if ($validator->fails()) {
					$errs = $validator->messages()->all();
					$str = '';
					foreach ($errs as $arr) {
						$str = $str . '<li>' . $arr . '</li>';
					}
					return Redirect::back()->withErrors(['<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>'])->withInput();
					$status = 0;
				}

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
						$pack_pur_id = self::purchaseCommission($cust_user_id,$login_userInfo,$pack,$wal,$last_inserted_id,$package_id,$login_userId,$login_user_comm_per,$first_name,$last_name,2,$lguserId);
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
					}

				$data['useremail'] = array('name' => $first_name.' '.$last_name, 'user_id' => $last_inserted_id,'customer_id' => $cust_user_id,  'email' => $email, 'type'=>'Customer','referral_link' => $referral_code, 'password' => $password,'application_id'=>1234,'user_role' => 4);
				$emailid = array('toemail' => $email);
				Mail::send(['html' => 'email_templates.verify-email'], $data, function ($message) use ($emailid) {
					$message->to($emailid['toemail'], 'Email Verification')->subject('Email Verification');
					$message->from('noreply@bestbox.net', 'BestBox');
				});

				Session::flash('result', 'Customer Created Successfully');
				Session::flash('alert','Success');
				return back()->withInput();

			}else{
				$data['useremail'] = array('name' => $first_name.' '.$last_name, 'user_id' => $last_inserted_id, 'customer_id' => $cust_user_id, 'email' => $email, 'type'=>'Customer','referral_link' => $referral_code, 'password' => $password,'application_id'=>1234,'user_role' => 4);
				$emailid = array('toemail' => $email);
				Mail::send(['html' => 'email_templates.verify-email'], $data, function ($message) use ($emailid) {
					$message->to($emailid['toemail'], 'Email Verification')->subject('Email Verification');
					$message->from('noreply@bestbox.net', 'BestBox');
				});

				Session::flash('result', 'Customer Created Successfully');
				Session::flash('alert','Success');
				return back()->withInput();
			}

		}else{
			Session::flash('result', 'Failure');
			Session::flash('alert','Failure');
			return back()->withInput();
		}
		}
	}

	public static function purchaseCommission($cust_user_id,$userInfo,$pack,$wal,$last_inserted_id,$package_id,$login_userId,$login_user_comm_per,$first_name,$last_name,$pack_st,$lguserId){
		$admin_id = config('constants.ADMIN_ID');
		$login_user_info = Auth::user();
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
				'purchased_from_userid' => $lguserId
			]);
		}else{
			$pack_pur = Package_purchase_list::create([
				'user_id' => $last_inserted_id,
				'package_id' => $package_id,
				'purchased_from_userid' => $lguserId
			]);
		}
		$pack_pur_id = $pack_pur->rec_id;
		$commission_pay_fcm = false;

			$subscription_fee = $pack->subscription_fee;

			if ($subscription_fee != 0 && $userInfo['admin_login'] != 1) {

					$aid = 0;
					$login_user_comm_per = $login_user_info['commission_perc'];
					$comm = $subscription_fee * $login_user_comm_per / 100;
					self::directSalesSave($cust_user_id, $login_userId, $last_inserted_id, $pack, $package_id, $pack->effective_amount, $pack->subscription_fee, $comm, $login_user_comm_per);
					$desc = $pack->package_name.' @ '.$pack->effective_amount.' USD - '.$cust_user_id;



					if($comm != 0 && $comm > 0){

						self::commissionPay($login_userId, $aid, $last_inserted_id, $pack->effective_amount, $pack->subscription_fee, $comm, $login_user_comm_per,'Referral Commission',$desc);

						$commission_pay_fcm = true;

						$wal = Wallet::where("user_id", $login_userId)->first();
						$balanc = $wal['amount'] + $comm;
						$desc = number_format($comm,2) . ' USD received as a commision from customer ('.$first_name.' '.$last_name.')';

						$transaction_no = self::generate_randam_string('CID', $strength = 9);

						self::user_transactions($transaction_no,$package_id,$login_userId, $last_inserted_id,$login_userId, $comm, 0, $balanc, 'Commission', $desc);
						Wallet::where('user_id', $login_userId)->increment('amount', $comm);
					}
					$down_user_comm_per = $login_user_comm_per;

				$res = Unilevel_tree::where('down_id', $last_inserted_id)->whereNotIn('upliner_id', [$login_userId,$admin_id])->orderBy('level', 'ASC')->get();

					if (!empty($res)) {
						foreach ($res as $val) {

							$upliner_id = $val->upliner_id;

							$qs = User::where('rec_id', $upliner_id)->whereIn('user_role',[2,3])->where('commission_perc', '!=', '')->select('commission_perc', 'user_role')->first();
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

									// send commission Pay FCM  (upliner id)
									Common::commissionSalesFCM($upliner_id,$comm1,'BESTBOX');

									$wal = Wallet::where("user_id", $upliner_id)->first();
									$balanc1 = $wal->amount + $comm1;

									$transaction_no = self::generate_randam_string('CID', $strength = 9);
									self::user_transactions($transaction_no,$package_id,$upliner_id, $last_inserted_id,$upliner_id, $comm1, 0, $balanc1, 'Commission', $desc);
									Wallet::where('user_id', $upliner_id)->increment('amount', $comm1);

									$down_user_comm_per = $qs->commission_perc;
								}
							}
						}
					}
			//referral bonus to customers
				$qs = User::where('rec_id', $last_inserted_id)->where('sub_user',0)->select('referral_userid')->first();
				if(!empty($qs)){
					$pres = Package_purchase_list::where('user_id',$last_inserted_id)->where('package_id','!=',11)->count();
					if($pres == 1){
						self::referralBonus($qs->referral_userid,$subscription_fee,$pack->effective_amount,$first_name,$last_name,$last_inserted_id,$package_id);
					}
				}

				if($commission_pay_fcm == true){
					// send commission Pay FCM
					Common::commissionSalesFCM($login_userId,$comm,'BESTBOX');
				}
				// send directSaleFCM
				Common::directSaleFCM($login_userId,$pack->effective_amount,'BESTBOX');

			}
			else{
				
				self::directSalesSave($cust_user_id, $login_userId, $last_inserted_id, $pack, $package_id, $pack->effective_amount, $pack->subscription_fee, 0, 100);

				// send directSaleFCM
				Common::directSaleFCM($login_userId,$pack->effective_amount,'BESTBOX');
			}
		return $pack_pur_id;
	}

	public static function referralBonus($referred_userid,$subscription_fee,$effective_amount,$first_name,$last_name,$last_inserted_id,$package_id){

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

        	//send referral bonus to the referral user

			$desc = 'Referral Bonus from customer ('.$first_name.' '.$last_name.')';
			self::commissionPay($referred_userid, 0, $last_inserted_id, $effective_amount, $subscription_fee, $ref_bonus, $ref_bonus,'Referral Bonus',$desc);

			$transaction_no = self::generate_randam_string('RID', $strength = 9);
			$wal = Wallet::where("user_id", $referred_userid)->first();
			$balanc1 = $wal->amount + $ref_bonus;
			self::user_transactions($transaction_no,$package_id,$referred_userid, $last_inserted_id,$referred_userid, $ref_bonus, 0, $balanc1, 'Referral Bonus', $desc);
			Wallet::where('user_id', $referred_userid)->increment('amount', $ref_bonus);

			// send Referral Bonus FCM
			$customer_name = $first_name.' '.$last_name;
			Common::referralBonusFCM($referred_userid,$ref_bonus,$customer_name,'BESTBOX');


		}
	}

	public static function referralBonusOld($referred_userid,$subscription_fee,$effective_amount,$first_name,$last_name,$last_inserted_id,$package_id){

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

	public static function insertCustomerData($userInfo,$login_userId,$email,$first_name,$last_name,$address,$country_id,$mobile,$gender,$married_status,$package_id,$lguserId="",$pwd=''){

				$userId = AdminController::generateCustomerId($first_name);
				$us_cnt = User::where('user_id', $userId)->count();
				if ($us_cnt == 1) {
					$user_id = AdminController::generateCustomerId($first_name);
				} else {
					$user_id = $userId;
				}

				$ref_code = AdminController::generateReferralCode($first_name);
				$ref_cnt = User::where('refferallink_text', $ref_code)->count();

				if ($ref_cnt == 1) {
					$referral_code = AdminController::generateReferralCode($first_name);
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
				//$pwd = $random_string;
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
					'status' => 1,
                    'email_verify' => 1,
					'refferallink_text' => $referral_code,
					'created_by' => $lguserId,
					'application_id' => 1234
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

			return array('last_inserted_id'=>$last_inserted_id,'referral_code'=>$referral_code, 'cust_user_id'=>$user_id, 'password'=>$pwd, 'user_role' => 4);
	}

	public static function updCustomerData($email,$first_name,$last_name,$address,$country_id,$mobile,$gender,$married_status,$package_id,$rec_id){
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

		return array('last_inserted_id'=>$res->rec_id,'referral_code'=>$res->refferallink_text,'cust_user_id'=>$res->user_id, 'user_role' => 4);

	}

	public static function commissionPay($user_id, $agent_id, $sender_id, $sales_amount, $subscription_amount, $commission, $commission_per,$commission_type,$description)
	{
		$user_info = Auth::user();
		$user_id = $user_info['rec_id'];
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
		log::info('commison per'.$commission_per);
		log::info('commison'.$commission);
		$login_user_info = Auth::user();
		$user_id = $login_user_info['rec_id'];


		$desc = $pack->package_name.' @ '.$pack->effective_amount.' USD - '.$cust_user_id;
		Sales::create([
			'added_date' => date('Y-m-d H:i:s'),
			'user_id' => $user_id,
			'customer_id' => $sender_id,
			'package_id' => $package_id,
			'sales_amount' => $sales_amount,
			'subscription_amount' => $subscription_amount,
			'commission' => $commission,
			'commission_per' => ($commission_per != '') ? $commission_per : 0,
			'description' => $desc
		]);
	}

	public static function user_transactions($transaction_no,$package_id,$login_userId,$sender_id,$receiver_id, $credit, $debit, $balanc, $ttype, $description,$notification_message="")
	{
		$user_info = Auth::user();
		$login_userId = $user_info['rec_id'];
		$receiver_id = config('constants.ADMIN_ID');
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
			'status' => 1,
			'notification_message' => $notification_message
		]);
		return $transactions->rec_id;
	}

	public function customerEdit($customerId)
	{
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$data['userInfo'] = $userInfo;
		$customer_id = base64_decode($customerId);
		//$customerInfo = User::where(array('rec_id' => $customer_id))->first();
		$customerInfo = User::leftjoin('package_purchased_list', 'users.rec_id', '=', 'package_purchased_list.user_id')->leftjoin('packages', 'package_purchased_list.package_id', '=', 'packages.id')->where('users.rec_id', $customer_id)->select(
			'users.rec_id',
			'users.user_id',
			'users.first_name',
			'users.last_name',
			'users.email',
			'users.gender',
			'users.married_status',
			'users.telephone',
			'users.country_id',
			'users.shipping_address',
			'users.shipping_country',
			'users.shipping_user_mobile_no',
			'users.registration_date',
			'users.status',
			'users.cms_username',
			'users.cms_password',
			'package_purchased_list.subscription_date AS subscription_date',
			'package_purchased_list.expiry_date AS expiry_date',
			'package_purchased_list.package_id AS package_id'
		)->orderBy('package_purchased_list.rec_id', 'DESC')->first();

		if ($customerInfo->shipping_user_mobile_no == '') {
			$customerInfo->telephone = '';
			$customerInfo->country_code = '+0';
		} else {
			$telephone = explode('-', $customerInfo->shipping_user_mobile_no);
			$customerInfo->telephone = $telephone[1];
			$customerInfo->country_code = str_replace('+', '', $telephone[0]);
		}

		$data['customerData'] = $customerInfo;
		$data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();
		$data['package_data'] = DB::table('packages')->where('status', 1)->get();
		$data['wallet_balance'] = Wallet::where('user_id', $customer_id)->first();

		$data['packData'] = Package_purchase_list::leftjoin('packages', 'package_purchased_list.package_id', '=', 'packages.id')->where('package_purchased_list.user_id', $customer_id)->where('package_purchased_list.active_package',1)->orderBy('package_purchased_list.rec_id','DESC')->first();

		$data['purchased_cnt'] = Purchase_order_details::where('user_id',$customer_id)->where('status',2)->count();
		//echo '<pre>';print_r($data['packData']);exit;
		return view('customer-edit')->with($data);
	}

	public function updateCustomerData(Request $request)
	{
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$validator = Validator::make($request->all(), [
			'first_name' => 'required|min:3|max:255|regex:/^[A-Za-z\s]+$/',
			'last_name' => 'required|min:3|max:255|regex:/^[A-Za-z\s]+$/',
			'shipping_address' => 'required',
			'shipping_country' => 'required',
			'shipping_user_mobile_no' => 'required|alpha_dash'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			return Redirect::back()->withErrors(['<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>']);
		} else {

			/*if($userInfo['admin_login'] == 1){
				$validator = Validator::make($request->all(), [
					'cms_username' => 'required',
					'cms_password' => 'required'
				]);
				if ($validator->fails()) {
					$errs = $validator->messages()->all();
					$str = '';
					foreach ($errs as $arr) {
						$str = $str . '<li>' . $arr . '</li>';
					}
					return Redirect::back()->withErrors(['<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>']);
				}
			}
			$cms_username = $request['cms_username'];
			$cms_password = $request['cms_password'];
			if($cms_password!=""){
				$cms_res=self::validatePortalCredentialsForCustomerEdit($cms_username,$cms_password);
				if($cms_res=='invalid'){
					Session::flash('error', 'CMS Password is invalid');
					Session::flash('alert','Failure');
					return Redirect::back();
				}

			}*/

			$customer_id = base64_decode($request['customer_id']);
			$country_id = Input::get('shipping_country');
			$country_code = Input::get('shipping_country_code');
			$mobile = $country_code . "-" . Input::get('shipping_user_mobile_no');

			$married_status = '';//$request['married_status'];

			User::where('rec_id', $customer_id)->update(['first_name' => $request['first_name'], 'last_name' => $request['last_name'], 'shipping_country' => $request['shipping_country'], 'shipping_user_mobile_no' => $mobile, 'shipping_address' => $request['shipping_address'], 'married_status' => $married_status ]);

			/*if(!empty($cms_username)){
				$encrypted_username=safe_encrypt($cms_username,config('constants.encrypt_key'));
				User::where('rec_id', $customer_id)->update(['cms_username' => $encrypted_username]);
			}
			if(!empty($cms_password)){

				$encrypted_password=safe_encrypt($cms_password,config('constants.encrypt_key'));
				User::where('rec_id', $customer_id)->update(['cms_password' => $encrypted_password]);
			}*/

			Session::flash('result', 'Updated Successfully');
			Session::flash('alert','Success');
			return Redirect::back();
		}
	}
	public static function validatePortalCredentialsForCustomerEdit($cms_username,$cms_password){

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
			return response("fail", 400);
		}
		curl_close($ch);
		/*echo "sri ";
		echo $result;*/
		if($result!=""){
			return 'valid';
		}else{
			return 'invalid';
		}
	}
	public function customerView($customerId)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$customerId = base64_decode($customerId);
		$data['userInfo'] = User::where(array('rec_id' => $userId))->first();

		$customerInfo = User::leftjoin('package_purchased_list', 'users.rec_id', '=', 'package_purchased_list.user_id')->leftjoin('packages', 'package_purchased_list.package_id', '=', 'packages.id')->where('users.rec_id', $customerId)->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name', 'users.email','users.gender','users.married_status','users.telephone','users.country_id','users.shipping_address','users.shipping_country','users.shipping_user_mobile_no', 'users.registration_date', 'users.status', 'packages.id','packages.effective_amount', DB::raw('MAX(package_purchased_list.expiry_date) AS expiry_date'),'packages.package_name','packages.setupbox_status')->first();

		$data['packData'] = Package_purchase_list::leftjoin('packages', 'package_purchased_list.package_id', '=', 'packages.id')->where('package_purchased_list.user_id', $customerId)->where('package_purchased_list.active_package',1)->orderBy('package_purchased_list.rec_id','DESC')->first();
		// echo "<pre>";
		// print_r($data['packData']);exit();
		$data['customerInfo'] = $customerInfo;
		//$data['pdata'] = Purchase_order_details::where('user_id', $customerId)->where('status',2)->count();
		$data['country'] = Country::select('country_name')->where('countryid', '=', $customerInfo->country_id)->first();
		$data['shipping_country'] = Country::select('country_name')->where('countryid', '=', $customerInfo->shipping_country)->first();
		return view("customer-view")->with($data);
	}

	//Direct Sales
	public function directSales(Request $request) {
		$userInfo = Auth::user();
		$admin_id = config('constants.ADMIN_ID');
		if($userInfo['admin_login'] == 1){
			$userId = $admin_id;
		}else{
			$userId = $userInfo['rec_id'];
		}
		$data['userInfo'] = $userInfo;
		$data['from_date'] = $request->query('from_date');
		$data['to_date'] = $request->query('to_date');

		if (!empty($request->query('from_date')) && !empty($request->query('to_date'))) {
			$from_date = $request->query('from_date');
			$to_date = $request->query('to_date');
			$from_date = Carbon::createFromFormat('m-d-Y', $from_date)->format('Y-m-d');
			$to_date = Carbon::createFromFormat('m-d-Y', $to_date)->format('Y-m-d');
			$start = Carbon::parse($from_date)->format('Y-m-d H:i:s');
			$todate = Carbon::parse($to_date)->format('Y-m-d H:i:s');
			$to = date('Y-m-d H:i:s', strtotime($todate . ' +1 day'));
			$data['commissions'] = User::join('sales', 'users.rec_id', '=', 'sales.user_id')
									->select('sales.commission_per')
									->where(array('sales.user_id' => $userId))
									->whereBetween('sales.added_date', [$start, $todate])
									->groupBy('sales.commission_per')
									->orderBy('sales.commission_per','ASC')
									->get();

			$data['directSales'] = User::join('sales', 'users.rec_id', '=', 'sales.user_id')
			->select('users.user_id', 'sales.sales_amount', 'sales.added_date', 'sales.commission', 'sales.commission_per', 'sales.description')
			->where(array('sales.user_id' => $userId))
			->whereBetween('sales.added_date', [$start, $to])
			->orderBy('sales.added_date','DESC')
			->paginate(100);

		}else{
			$data['commissions'] = User::join('sales', 'users.rec_id', '=', 'sales.user_id')
								->select('sales.commission_per')
								->where(array('sales.user_id' => $userId))
								->groupBy('sales.commission_per')
								->orderBy('sales.commission_per','ASC')
								->get();
			$data['directSales'] = User::join('sales', 'users.rec_id', '=', 'sales.user_id')
			->select('users.user_id', 'sales.sales_amount', 'sales.added_date', 'sales.commission', 'sales.commission_per', 'sales.description')
			->where(array('sales.user_id' => $userId))
			->orderBy('sales.added_date','DESC')
			->paginate(100);

		}

		//echo '<pre>';print_r($data);exit;
		return view('direct_sales')->with($data);
	}

	public function commissionReport(Request $request) {

		$userInfo = Auth::user();
		$admin_id = config('constants.ADMIN_ID');
		if($userInfo['admin_login'] == 1){
			$userId = $admin_id;
		}else{
			$userId = $userInfo['rec_id'];
		}

		$userRole = $userInfo['user_role'];
		$searchKey = $request->query('searchKey');
		if($userInfo['admin_login'] == 1){

			if (!empty($request->query('searchKey'))){
				$data['loginUserCommissionReports'] = array();
				$data['commissionReports'] = Commissions::join('users','commissions.user_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'users.rec_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
								->where('users.user_id', 'LIKE', '%' . $searchKey . '%')
								->where('commissions.user_id','!=',1000)
								->groupBy('commissions.user_id')
								->orderBy('commissions.rec_id','DESC')
								->paginate(25);

			}else{
				$data['loginUserCommissionReports'] = array();

				$data['commissionReports'] = Commissions::join('users','commissions.user_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'users.rec_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
								//->where(['users.user_role' => 2])
								->where('commissions.user_id','!=',1000)
								->groupBy('commissions.user_id')
								->orderBy('commissions.rec_id','DESC')
								->paginate(25);
			}
		}else if($userRole == 2){
			if (!empty($request->query('searchKey'))){
				$data['loginUserCommissionReports'] = Commissions::join('users','commissions.user_id', '=','users.rec_id')
				->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','commissions.user_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
				->where('commissions.agent_id','=',0)
				->where(['commissions.user_id' => $userId])
				->where('users.user_id', 'LIKE', '%' . $searchKey . '%')
				->groupBy('commissions.user_id')->get();
				$data['commissionReports'] = Commissions::join('users','commissions.agent_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','commissions.user_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
								->where(['commissions.user_id' => $userId])
								->where('users.user_id', 'LIKE', '%' . $searchKey . '%')
								->where('commissions.agent_id','!=',0)
								->groupBy('commissions.agent_id')
								->orderBy('commissions.rec_id','DESC')
								->paginate(25);
			}else{
				$data['loginUserCommissionReports'] = Commissions::join('users','commissions.user_id', '=','users.rec_id')
				->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','commissions.user_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
				->where('commissions.agent_id','=',0)
				->where(['commissions.user_id' => $userId])->groupBy('commissions.user_id')->get();

				$data['commissionReports'] = Commissions::join('users','commissions.agent_id', '=','users.rec_id')
				->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','commissions.user_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
				->where(['commissions.user_id' => $userId])
				->where('commissions.agent_id','!=',0)
				->groupBy('commissions.agent_id')
				->orderBy('commissions.rec_id','DESC')
				->paginate(25);
			}
		}else if($userRole == 3){

			if (!empty($request->query('searchKey'))){
				$data['loginUserCommissionReports'] = Commissions::join('users','commissions.user_id', '=','users.rec_id')
				->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','commissions.user_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
				->where('commissions.agent_id','=',0)
				->where(['commissions.user_id' => $userId])
				->where('users.user_id', 'LIKE', '%' . $searchKey . '%')
				->groupBy('commissions.user_id')->get();
				$data['commissionReports'] = Unilevel_tree::join('commissions','unilevel_tree.down_id', '=','commissions.agent_id')
								->join('users','commissions.agent_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','commissions.user_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
								->where(['unilevel_tree.upliner_id' => $userId, 'commissions.user_id' => $userId, 'unilevel_tree.user_role' => 3])
								->where('users.user_id', 'LIKE', '%' . $searchKey . '%')
								->groupBy('commissions.agent_id')
								->orderBy('commissions.rec_id','DESC')
								->paginate(25);
			}else{
				$data['loginUserCommissionReports'] = Commissions::join('users','commissions.user_id', '=','users.rec_id')
				->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','commissions.user_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
				->where('commissions.agent_id','=',0)
				->where(['commissions.user_id' => $userId])->groupBy('commissions.user_id')->get();

				$data['commissionReports'] = Unilevel_tree::join('commissions','unilevel_tree.down_id', '=','commissions.agent_id')
								->join('users','commissions.agent_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','commissions.user_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
								->where(['unilevel_tree.upliner_id' => $userId, 'commissions.user_id' => $userId, 'unilevel_tree.user_role' => 3])
								->groupBy('commissions.agent_id')
								->orderBy('commissions.rec_id','DESC')
								->paginate(25);
			}
		}else{
			if (!empty($request->query('searchKey'))){
				$data['commissionReports'] = Commissions::join('users','commissions.user_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','commissions.agent_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
								->where(['commissions.user_id' => $userId])
								->where('users.user_id', 'LIKE', '%' . $searchKey . '%')
								->where('commissions.sender_user_id', '!=' , 0)
								->groupBy('commissions.sender_user_id')
								->orderBy('commissions.rec_id','DESC')
								->paginate(25);
			}else{
				$data['commissionReports'] = Commissions::join('users','commissions.user_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','commissions.agent_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
								->where(['commissions.user_id' => $userId])
								->where('commissions.sender_user_id', '!=' , 0)
								->groupBy('commissions.sender_user_id')
								->orderBy('commissions.rec_id','DESC')
								->paginate(25);
			}

		}

		$data['searchKey'] = $searchKey;

		return view('commission_report')->with($data);
	}

	public function commissionReportDetails(Request $request, $userId,$referenceId) {
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$refereceId =  $referenceId;
		$data['test'] = array();

		//$user = User::select('user_role')->where(['rec_id'=>$userId])->first();
		$data['userID'] = $userId;
		$data['referenceID'] = $referenceId;
		$data['from_date'] = $request->query('from_date');
		$data['to_date'] = $request->query('to_date');
		if (!empty($request->query('from_date')) && !empty($request->query('to_date'))) {
			$from_date = Carbon::createFromFormat('m-d-Y', $data['from_date'])->format('Y-m-d');
			$to_date = Carbon::createFromFormat('m-d-Y', $data['to_date'])->format('Y-m-d');
			$start = Carbon::parse($from_date)->format('Y-m-d H:i:s');
			$todate = Carbon::parse($to_date)->format('Y-m-d H:i:s');
			$to = date('Y-m-d H:i:s', strtotime($todate . ' +1 day'));
		}
		if($userInfo['admin_login'] == 1){
			//DB::enableQueryLog();

			$data['userData'] = Commissions::join('users','commissions.user_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name',DB::raw('SUM(sales_amount) as sales_amount'), DB::raw('SUM(commission) as commission'))
								//->where(['users.user_role' => 2])
								->where('commissions.user_id','=',$userId)
								->groupBy('commissions.user_id')
								->first();

			if (!empty($request->query('from_date')) && !empty($request->query('to_date'))) {

				$data['commissionReports'] = Commissions::join('users','commissions.user_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount','commissions.commission_perc', 'commissions.commission','commissions.description','commissions.added_date')
								->where(['commissions.user_id' => $userId])
								->whereBetween('commissions.added_date',[$start, $to])
								->orderBy('commissions.rec_id','DESC')
								->paginate(25);
			}else{
				$data['commissionReports'] = Commissions::join('users','commissions.user_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount','commissions.commission_perc', 'commissions.commission','commissions.description','commissions.added_date')
								->where(['commissions.user_id' => $userId])
								//->groupBy('commissions.user_id')
								->orderBy('commissions.rec_id','DESC')
								->paginate(25);
			}
		}else if($userInfo['user_role'] == 2){
			if($userId == $referenceId){
				$data['userData'] = Commissions::join('users','commissions.user_id', '=','users.rec_id')
							->select('users.rec_id','users.user_id', 'users.first_name','users.last_name', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
							->where(['commissions.user_id' => $userId])
							->where('commissions.agent_id', '=' , 0)
							->groupBy('commissions.agent_id')
							->first();
			}else{
				$data['userData'] = Commissions::join('users','commissions.agent_id', '=','users.rec_id')
							->select('users.rec_id','users.user_id', 'users.first_name','users.last_name', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
							->where(['commissions.agent_id' => $userId,'commissions.user_id' => $referenceId])
							//->where('commissions.agent_id', '!=' , 0)
							->groupBy('commissions.agent_id')
							->first();
			}

			if (!empty($request->query('from_date')) && !empty($request->query('to_date'))) {

				if($userId == $referenceId){
					$data['commissionReports'] = Commissions::join('users','commissions.user_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount','commissions.commission_perc', 'commissions.commission','commissions.description','commissions.added_date')
								->where(['commissions.user_id' => $userId])
								->whereBetween('commissions.added_date',[$start, $to])
								->where('commissions.agent_id', '=' , 0)
								->orderBy('commissions.rec_id','DESC')
								->paginate(25);
				}else{
					$data['commissionReports'] = Commissions::join('users','commissions.agent_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount','commissions.commission_perc', 'commissions.commission','commissions.description','commissions.added_date')
								->where(['commissions.agent_id' => $userId,'commissions.user_id' => $referenceId])
								->whereBetween('commissions.added_date',[$start, $to])
								//->where('commissions.agent_id', '!=' , 0)
								->orderBy('commissions.rec_id','DESC')
								->paginate(25);
				}

			}else{
				if($userId == $referenceId){
					$data['commissionReports'] = Commissions::join('users','commissions.user_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount','commissions.commission_perc', 'commissions.commission','commissions.description','commissions.added_date')
								->where(['commissions.user_id' => $userId])
								->where('commissions.agent_id', '=' , 0)
								->orderBy('commissions.rec_id','DESC')
								->paginate(25);
				}else{
					$data['commissionReports'] = Commissions::join('users','commissions.agent_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount','commissions.commission_perc', 'commissions.commission','commissions.description','commissions.added_date')
								->where(['commissions.agent_id' => $userId,'commissions.user_id' => $referenceId])
								//->where('commissions.agent_id', '!=' , 0)
								->orderBy('commissions.rec_id','DESC')
								->paginate(25);
				}

			}
		}else if($userInfo['user_role'] == 3){

			if($userId == $referenceId){
				$data['userData'] = Commissions::join('users','commissions.user_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
								->where(['commissions.user_id' => $userId])
								->first();
			}else{
				$data['userData'] = Commissions::join('users','commissions.agent_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
								->where(['commissions.agent_id' => $userId,'commissions.user_id' => $referenceId])
								//->where('commissions.sender_user_id', '!=' , 0)
								->groupBy('commissions.agent_id')
								->orderBy('commissions.rec_id','DESC')
								->first();
			}

			if (!empty($request->query('from_date')) && !empty($request->query('to_date'))) {

				if($userId == $referenceId){
					$data['commissionReports'] = Commissions::join('users','commissions.user_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount', 'commissions.commission_perc','commissions.commission','commissions.description','commissions.added_date')
								->where(['commissions.user_id' => $userId])
								->where('commissions.sender_user_id', '!=' , 0)
								->whereBetween('commissions.added_date',[$start, $to])
								->groupBy('commissions.sender_user_id')
								->orderBy('commissions.rec_id','DESC')
								->paginate(25);

				}else{
					$data['commissionReports'] = Commissions::join('users','commissions.sender_user_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount', 'commissions.commission_perc','commissions.commission','commissions.description','commissions.added_date')
								->where(['commissions.agent_id' => $userId])
								->where('commissions.sender_user_id', '!=' , 0)
								->whereBetween('commissions.added_date',[$start, $to])
								->groupBy('commissions.sender_user_id')
								->orderBy('commissions.rec_id','DESC')
								->paginate(25);
				}

			}else{
				if($userId == $referenceId){
					$data['commissionReports'] = Commissions::join('users','commissions.user_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount', 'commissions.commission_perc','commissions.commission','commissions.description','commissions.added_date')
								->where(['commissions.user_id' => $userId])
								->where('commissions.sender_user_id', '!=' , 0)
								->orderBy('commissions.rec_id','DESC')
								->paginate(25);
				}else{
					$data['commissionReports'] = Commissions::join('users','commissions.sender_user_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount', 'commissions.commission_perc','commissions.commission','commissions.description','commissions.added_date')
								->where(['commissions.agent_id' => $userId])
								->where('commissions.sender_user_id', '!=' , 0)
								->groupBy('commissions.sender_user_id')
								->orderBy('commissions.rec_id','DESC')
								->paginate(25);
				}
			}
		}else{

			$data['userData'] = Commissions::join('users','commissions.sender_user_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
								->where(['commissions.sender_user_id' => $userId,'commissions.agent_id' => $refereceId])
								->first();
			if (!empty($request->query('from_date')) && !empty($request->query('to_date'))) {
				$data['commissionReports'] = Commissions::join('users','commissions.sender_user_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount', 'commissions.commission_perc','commissions.commission','commissions.description','commissions.added_date')
								->where(['commissions.sender_user_id' => $userId,'commissions.agent_id' => $refereceId])
								->whereBetween('commissions.added_date',[$start, $to])
								->orderBy('commissions.rec_id','DESC')
								->paginate(25);
			}else{
				$data['commissionReports'] = Commissions::join('users','commissions.sender_user_id', '=','users.rec_id')
								->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount', 'commissions.commission_perc','commissions.commission','commissions.description','commissions.added_date')
								->where(['commissions.sender_user_id' => $userId,'commissions.agent_id' => $refereceId])
								->orderBy('commissions.rec_id','DESC')
								->paginate(25);
			}
		}

		// if($userRole == 1){
		// 	//DB::enableQueryLog();


		// 	$data['commissionReports'] = Commissions::select('commissions.sales_amount', 'commissions.added_date', 'commissions.commission', 'commissions.commission_perc', 'commissions.description')
		// 								->where(array('commissions.user_id' => $userId))->orderBy('commissions.rec_id','DESC')->paginate(10);
		// 	// dd(DB::getQueryLog());
		// 	// exit;
		// }else{
		// 	$data['userData'] = Commissions::join('users', 'users.rec_id', '=', 'commissions.agent_id')
		// 					->select('users.rec_id','users.user_id', 'users.first_name','users.last_name',DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
		// 					->where(array('commissions.user_id' => $userId,'commissions.agent_id' => $userId))
		// 					->first();
		// 	$data['commissionReports'] = Commissions::select('commissions.sales_amount', 'commissions.added_date', 'commissions.commission', 'commissions.commission_perc', 'commissions.description')
		// 								->where(array('commissions.user_id' => $userId))->orderBy('commissions.rec_id','DESC')->paginate(10);
		// }

		//echo '<pre>';print_R($data);exit;
		return view('commission_report_details')->with($data);
	}

	public function arrayPaginator($array, $request)
	{
		$page = Input::get('page', 1);
		$perPage = 10;
		$offset = ($page * $perPage) - $perPage;

		return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
			['path' => $request->url(), 'query' => $request->query()]);
	}

	public function unileveltree(){
		$res = User::where('rec_id','!=',1000)->get();
		foreach ($res as $val) {
			$user_id = $val->rec_id;

			$l=1;
			$nom=$val->referral_userid;
			$user_role=$val->user_role;
			while($nom!=999){
				if($nom!=999 && $l < 150){
					$upl_data = array('down_id'=>$user_id, 'upliner_id'=>$nom, 'level'=>$l, 'user_role'=>$user_role);
					$query = DB::table('unilevel_tree')->insert($upl_data);
					$l++;
					$query = "SELECT  referral_userid FROM users WHERE rec_id='$nom'";
					$results = DB::select(DB::raw($query));
					$nom=$results[0]->referral_userid;
					}
				}

		}
	}

	public function customerActivation(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$data['from_date'] = $request->query('from_date');
		$data['to_date'] = $request->query('to_date');
		if (!empty($request->query('from_date')) && !empty($request->query('to_date'))) {
			$from_date = $request->query('from_date');
			$to_date = $request->query('to_date');
			$from_date = Carbon::createFromFormat('m-d-Y', $from_date)->format('Y-m-d');
			$to_date = Carbon::createFromFormat('m-d-Y', $to_date)->format('Y-m-d');
			$start = Carbon::parse($from_date)->format('Y-m-d H:i:s');
			$todate = Carbon::parse($to_date)->format('Y-m-d H:i:s');
			$to = date('Y-m-d H:i:s', strtotime($todate . ' +1 day'));

			$data['request_list'] = Purchase_order_details::join('users','users.rec_id','=','purchase_order_details.user_id')->leftjoin('package_purchased_list','purchase_order_details.package_purchased_id','=','package_purchased_list.rec_id')->leftjoin('packages','package_purchased_list.package_id','=','packages.id')->whereBetween('purchase_order_details.purchased_date', [$start, $to])->where('purchase_order_details.type',1)->select('users.first_name','users.last_name','users.user_id','users.email','purchase_order_details.order_id','purchase_order_details.purchased_date','purchase_order_details.status','purchase_order_details.purchased_from','packages.effective_amount','packages.id')->orderBy('purchase_order_details.purchased_date','DESC')->orderBy('purchase_order_details.rec_id','ASC')->paginate(25);

		}else{
			$data['request_list'] = Purchase_order_details::join('users','users.rec_id','=','purchase_order_details.user_id')->leftjoin('package_purchased_list','purchase_order_details.package_purchased_id','=','package_purchased_list.rec_id')->leftjoin('packages','package_purchased_list.package_id','=','packages.id')->where('purchase_order_details.type',1)->select('purchase_order_details.rec_id','users.first_name','users.last_name','users.user_id','users.email','purchase_order_details.order_id','purchase_order_details.purchased_date','purchase_order_details.status','purchase_order_details.purchased_from','packages.effective_amount','packages.id')->orderBy('purchase_order_details.purchased_date','DESC')->orderBy('purchase_order_details.rec_id','ASC')->paginate(25);
		}
		return view('customerActivation')->with($data);
	}

	public function subscribePackage($customerId="",$type=1)
	{
		if(!empty($type)){
			$data['type'] = $type;
		}else{
			$data['type'] = 1;
		}
		$rec_id = base64_decode($customerId);
		$pod = Purchase_order_details::where('rec_id',$rec_id)->first();
		$customer_id = $pod['user_id'];
		$res = User::where('rec_id',$customer_id)->where('user_role',4)->first();
		if(!empty($res)){
			$data['customer_info']= $res;
		}else{
			$data['customer_info']= array();
		}

		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$data['userInfo'] = $userInfo;
		$data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();
		$data['package_data'] = DB::table('packages')->where('status', 1)->get();
		$data['wallet_balance'] = Wallet::where('user_id', $login_userId)->first();
		$data['purchase_details'] = Purchase_order_details::leftjoin('package_purchased_list','purchase_order_details.package_purchased_id','=','package_purchased_list.rec_id')->where('purchase_order_details.rec_id',$rec_id)->select('purchase_order_details.purchased_from','package_purchased_list.package_id','package_purchased_list.rec_id','purchase_order_details.order_id','purchase_order_details.attachment')->first();
		$data["purchase_id"] = $rec_id;
		//echo "<pre>";
		//print_r($data['purchase_details']->package_id);exit();
		return view('subscribe_package')->with($data);
	}

	public function saveSubscribePackage(Request $request)
	{
		$userInfo = Auth::user();
		$lguserId = $userInfo['rec_id'];
		/*$validator = Validator::make($request->all(), [
			'cms_password' => 'required',
			'cms_start_date' => 'required',
			'cms_expiry_date' => 'required'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			Session::flash('error', '<ul>' . $str . '</ul>');
			Session::flash('alert','Failure');
			return Redirect::back();
		} else {*/

			$purchased_rec_id = $request->id;//Input::get('purchased_rec_id');
			$order_details = Purchase_order_details::where(['rec_id' => $purchased_rec_id])->first();
			if($order_details->status == 1){
				$ppl = Package_purchase_list::where('rec_id',$order_details['package_purchased_id'])->select('package_id')->first();
				$package_id = $ppl['package_id'];
				$customer_id = $order_details['user_id'];
				$customer_info = User::select('*')->where(['rec_id'=>$customer_id])->first();
				$first_name = $customer_info['first_name'];
				$last_name = $customer_info['last_name'];
				$email = $customer_info['email'];

				$last_inserted_id = $customer_info['rec_id'];
				$referral_code = $customer_info['referral_code'];
				$cust_user_id = $customer_info['user_id'];
				/*$cms_password = Input::get('cms_password');
				$cms_start_date = Input::get('cms_start_date');
				$cms_expiry_date = Input::get('cms_expiry_date');

				$encrypted_username=safe_encrypt($cust_user_id,config('constants.encrypt_key'));
				$encrypted_password=safe_encrypt($cms_password,config('constants.encrypt_key'));
				User::where('rec_id', $last_inserted_id)->update(['cms_username' => $encrypted_username,'cms_password' => $encrypted_password,'cms_start_date'=>$cms_start_date,'cms_expiry_date'=>$cms_expiry_date]);*/


				$pack = Packages::where("id", $package_id)->first();

				$duration = $pack->duration; //days
				$dur=$duration*30;
				$expiry_date = date('Y-m-d H:i:s', strtotime("+" . $dur . " day"));
				$exp_date = date('d/m/Y', strtotime($expiry_date));
				$bb_expiry_date=$expiry_date;
				/*$expdate=date("Y-m-d",strtotime($cms_expiry_date));
				$diffdays=self::dateDiffInDays($bb_expiry_date,$expdate);
				$pack_expiry=$cms_expiry_date;*/
				//if($diffdays>7){
					$pack_expiry=$bb_expiry_date;
				//}

				$data = array(
					'subscription_date' => date('Y-m-d H:i:s'),
					'expiry_date' => $pack_expiry,
					'active_package' => 1
				);
				$result = Package_purchase_list::where(array('rec_id' => $order_details['package_purchased_id']))->update($data);


				$exp_date = '';//date('d/m/Y', strtotime($qs->expiry_date));//pass expiry date
				$udata = array('status'=>2,'activated_by'=>$lguserId);
				Purchase_order_details::where(array('rec_id'=>$purchased_rec_id))->update($udata);

				$query = Purchase_order_details::where(array('rec_id'=>$purchased_rec_id))->first();

				$decrypted_cmspwd = safe_decrypt($customer_info['plain_password'],config('constants.encrypt_key'));

				$data['useremail'] = array('name'=>$first_name.' '.$last_name,'customer_id'=>$cust_user_id,'password'=>$decrypted_cmspwd,'user_id'=>$last_inserted_id,'toemail'=>$email,'referral_link'=>$referral_code,'package_name'=>$pack->package_name,'package_amount'=>$pack->effective_amount,'expiry_date'=>$exp_date,'order_no'=>$query->order_id,'activated_date'=>date('Y.m.d H:i',strtotime($query->updated_at)),'application_id'=>1234);
		        $emailid = array('toemail' => $email);
		        Mail::send(['html'=>'email_templates.activation'], $data, function($message) use ($emailid) {
			        $message->to($emailid['toemail'], 'Subscription Details')->subject
			        ('Subscription Details');
			        $message->from('noreply@bestbox.net','BestBox');
		        });

				Session::flash('message', 'Subscription Activated Successfully');
				Session::flash('alert','Success');
				return Redirect::back();


			}else{
				Session::flash('error', 'Already Subscribed.');
				Session::flash('alert','Failure');
				return Redirect::back();
			}

		//}
	}
	public function validatePortalCredentials(Request $request){
		$cms_username = request('username');
		$cms_password = request('password');
		$purchased_id = request('purchased_id');


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
			//$utctime =date('Y-m-d H:i:s',strtotime('+8 hours',strtotime($expdate)));
			$pack_expiry=$expdate;
			$order_details = Purchase_order_details::where(['rec_id' => $purchased_id])->first();
			if($order_details->status == 1){
				$ppl = Package_purchase_list::where('rec_id',$order_details['package_purchased_id'])->select('package_id')->first();
				$package_id = $ppl['package_id'];
				$pack = Packages::where("id", $package_id)->first();
				$duration = $pack->duration; //days
				$dur=$duration*30;
				$bb_expiry_date = date('Y-m-d H:i:s', strtotime("+" . $dur . " day"));
				//$bb_exp_date = date('d/m/Y', strtotime($bb_expiry_date));
				$diffdays=self::dateDiffInDays($bb_expiry_date,$expdate);
				$pack_expiry=$expdate;
				if($diffdays>7){
					$pack_expiry=$bb_expiry_date;
				}
				//echo "sdaf ".$bb_expiry_date." ".$expdate." ".$diffdays;exit;
			}else{

			}

			$response=array();
			$response['startdate']=$startdate;
			$response['expirydate']=$pack_expiry;
			$response['format_startdate']=date("d/m/Y",strtotime($startdate));
			$response['format_expirydate']=date("d/m/Y",strtotime($pack_expiry));;

			//send FCM subscription package activated
			$activated_userinfo = User::select('*')->where('user_id','=',$cms_username)->where('user_role','=',4)->where('status','=',1)->first();
			if(!empty($activated_userinfo)){

				$rec_id = $activated_userinfo->rec_id;
				$email = $activated_userinfo->email;
				if(!empty($activated_userinfo->telephone)){
					$mobileno = $activated_userinfo->telephone;
				}else{
					$mobileno = "";
				}
				$device_id = $activated_userinfo->device_id;
				$device_id_android = array($activated_userinfo->device_id);

				$mbl_platform = $activated_userinfo->mbl_platform;
				$application_id = $activated_userinfo->application_id;

				$client_id="";$clientCode="";
				if(!empty($application_id)){
					$info = ApplicationsInfo::where('application_id','=',$application_id)->first();
					if(!empty($info)){
						$client_id = $info->application_id;
						$clientCode = $info->application_name;
					}
				}

				$icon = "success.png";
				$clienticon = "transactions-active.png";
				$myrtime = date("Y-m-d H:i:s");
				$temp=explode(" ",$myrtime);
				$today = $temp[0];
				$ttime=$temp[1];
				$new_time = $today."T".$ttime;

				$message = "Your Subscription is now activated and you can now start enjoying the latest content and channels.";

				$htmlMessage = "Your Subscription is now activated and you can now start enjoying the latest content and channels.";

				$htmlMessageIOS="Your Subscription is now activated and you can now start enjoying the latest content and channels.";


				$arr = array("Client_id" => $client_id,"ClientCode" => $clientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Account Information',"user_id" =>$rec_id,"MobileNo" =>$mobileno,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);

				$json_data["subscription_activated"] = json_encode($arr);

				//$device_id = array($res['device_id']);

				if(!empty($device_id)){

					/*if($mbl_platform == 'ios'){
					   $res = Common::sendFCMIOS($device_id,$json_data,$mobileno, 'subscription_activated',$htmlMessageIOS);
					}else if($mbl_platform == 'android'){
						$deviceIds = UsersDevicesList::where('user_id','=',$rec_id)->where('device_type','=','android')->get();
						//$device_id = array();
						if(@count($deviceIds) > 0){
							foreach ($deviceIds as $val) {
								$application_name = $val->application_name;
								//array_push($device_id, $val->device_id);
								$device_id = array($val->device_id);
								$res = Common::sendFCMAndroid($device_id,$json_data,$mobileno, 'subscription_activated',$application_name);
							}
						}else{
							$res = Common::sendFCMAndroid($device_id_android,$json_data,$mobileno, 'subscription_activated',$client_id);
						}

					}
					*/


					$deviceIds = UsersDevicesList::where('user_id','=',$rec_id)->get();

					if(@count($deviceIds) > 0){
						foreach ($deviceIds as $val) {
							$user_id = $val->user_id;
							$application_name = $val->application_name;
							$device_id = array($val->device_id);
							$device_id1 = $val->device_id;
							$device_type = $val->device_type;
							if(!empty($device_type)){
								if($device_type == "android"){
									$res = Common::sendFCMAndroid($device_id,$json_data,$mobileno, 'subscription_activated',$application_name);
								}else{
									$res = Common::sendFCMIOS($device_id1,$json_data,$mobileno, 'subscription_activated',$htmlMessageIOS,$application_name,$user_id);
								}
							}

						}
					}


				}

			}

			echo json_encode($response);exit;
		}else{
			echo "";
		}
	}
	public function saveRenewPackage(Request $request)
	{
		$userInfo = Auth::user();
		$lguserId = $userInfo['rec_id'];
		/*$validator = Validator::make($request->all(), [
			'cms_password' => 'required',
			'cms_start_date' => 'required',
			'cms_expiry_date' => 'required'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			Session::flash('error', '<ul>' . $str . '</ul>');
			Session::flash('alert','Failure');
			return Redirect::back();
		} else {*/

			$purchased_rec_id = $request->id;//Input::get('purchased_rec_id');
			$order_details = Purchase_order_details::where(['rec_id' => $purchased_rec_id])->first();
			if($order_details->status == 1){
				$ppl = Package_purchase_list::where('rec_id',$order_details['package_purchased_id'])->select('package_id')->first();
				$existingPackge = Package_purchase_list::where('user_id',$order_details['user_id'])->where("active_package",1)->where('package_id','!=',11)->orderBy('rec_id','desc')->first();
				$package_id = $ppl['package_id'];
				$customer_id = $order_details['user_id'];
				$customer_info = User::select('*')->where(['rec_id'=>$customer_id])->first();
				$first_name = $customer_info['first_name'];
				$last_name = $customer_info['last_name'];
				$email = $customer_info['email'];

				$last_inserted_id = $customer_info['rec_id'];
				$referral_code = $customer_info['referral_code'];
				$cust_user_id = $customer_info['user_id'];
				/*$cms_password = Input::get('cms_password');
				$cms_start_date = Input::get('cms_start_date');
				$cms_expiry_date = Input::get('cms_expiry_date');*/

				$pack = Packages::where("id", $package_id)->first();

				$duration = $pack->duration; //days
				$today=date("Y-m-d H:i:s");
				$expiry_diff=self::dateDiffInDays($today,$existingPackge['expiry_date']);
				$duration=$duration*30;
				if($expiry_diff>0){
					$dur=$duration+$expiry_diff;
				}else{
					$dur=$duration;
				}
				//$dur=$duration+$expiry_diff;
				$expiry_date = date('Y-m-d H:i:s', strtotime("+" . $dur . " day"));
				$bb_expiry_date=$expiry_date;
				$pack_expiry=$bb_expiry_date;
				/*$expdate=date("Y-m-d H:i:s",strtotime($cms_expiry_date));
				$diffdays=self::dateDiffInDays($bb_expiry_date,$expdate);
				$pack_expiry=$expdate;
				if($diffdays==0){
					$pack_expiry=$expdate;
				}else if($diffdays>0){
					$pack_expiry=$bb_expiry_date;
				}
				else{
					Session::flash('error', 'Please renew Supplier account.');
					Session::flash('alert','Failure');
					return Redirect::back();
				}*/

				/*$encrypted_username=safe_encrypt($cust_user_id,config('constants.encrypt_key'));
				$encrypted_password=safe_encrypt($cms_password,config('constants.encrypt_key'));
				User::where('rec_id', $last_inserted_id)->update(['cms_username' => $encrypted_username,'cms_password' => $encrypted_password,'cms_start_date'=>$cms_start_date,'cms_expiry_date'=>$cms_expiry_date]);*/


				$data = array(
					'subscription_date' => date('Y-m-d H:i:s'),
					'expiry_date' => $pack_expiry,
					'active_package' => 1
				);
				$result = Package_purchase_list::where(array('rec_id' => $order_details['package_purchased_id']))->update($data);


				$exp_date = '';//date('d/m/Y', strtotime($qs->expiry_date));//pass expiry date
				$udata = array('status'=>2,'activated_by'=>$lguserId);
				Purchase_order_details::where(array('rec_id'=>$purchased_rec_id))->update($udata);

				$query = Purchase_order_details::where(array('rec_id'=>$purchased_rec_id))->first();
				$decrypted_cmspwd = safe_decrypt($customer_info['plain_password'],config('constants.encrypt_key'));
				$data['useremail'] = array('name'=>$first_name.' '.$last_name,'customer_id'=>$cust_user_id,'password'=>$decrypted_cmspwd,'user_id'=>$last_inserted_id,'toemail'=>$email,'referral_link'=>$referral_code,'package_name'=>$pack->package_name,'package_amount'=>$pack->effective_amount,'expiry_date'=>$exp_date,'order_no'=>$query->order_id,'activated_date'=>date('Y.m.d H:i',strtotime($query->updated_at)),'application_id'=>1234);
		        $emailid = array('toemail' => $email);
		        Mail::send(['html'=>'email_templates.activation'], $data, function($message) use ($emailid) {
			        $message->to($emailid['toemail'], 'Subscription Details')->subject
			        ('Subscription Details');
			        $message->from('noreply@bestbox.net','BestBox');
		        });

				Session::flash('message', 'Renewal Activated Successfully');
				Session::flash('alert','Success');
				return Redirect::back();


			}else{
				Session::flash('error', 'Already Subscribed.');
				Session::flash('alert','Failure');
				return Redirect::back();
			}

		//}
	}
	public function validatePortalCredentialsForRenew(Request $request){
		$cms_username = request('username');
		$cms_password = request('password');
		$purchased_id = request('purchased_id');


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
			return response("fail", 400);
		}
		curl_close($ch);
		/*echo "sri ";
		echo $result;*/
		if($result!=""){
			$res=json_decode($result);
			//print_r($res);exit;
			//echo $res->user_info->exp_date;
			$startdate=date("Y-m-d H:i:s");
			//$utctime =date('Y-m-d H:i:s',strtotime('+8 hours',strtotime($startdate)));
			$expdate=date("Y-m-d H:i:s",$res->user_info->exp_date);
			//$utctime =date('Y-m-d H:i:s',strtotime('+8 hours',strtotime($expdate)));
			$pack_expiry=$expdate;
			$order_details = Purchase_order_details::where(['rec_id' => $purchased_id])->first();
			if($order_details->status == 1){
				$ppl = Package_purchase_list::where('rec_id',$order_details['package_purchased_id'])->select('package_id')->first();
				$existingPackge = Package_purchase_list::where('user_id',$order_details['user_id'])->where("active_package",1)->where('package_id','!=',11)->orderBy('rec_id','desc')->first();
				//echo $existingPackge['expiry_date'];exit;
				$package_id = $ppl['package_id'];
				$pack = Packages::where("id", $package_id)->first();
				$duration = $pack->duration; //days
				$duration=$duration*30;
				$today=date("Y-m-d H:i:s");
				$expiry_diff=self::dateDiffInDays($today,$existingPackge['expiry_date']);
				//echo $expiry_diff;exit;
				if($expiry_diff>0){
					$dur=$duration+$expiry_diff;
				}else{
					$dur=$duration;
				}

				$bb_expiry_date = date('Y-m-d H:i:s', strtotime("+" . $dur . " day"));
				//$bb_exp_date = date('d/m/Y', strtotime($bb_expiry_date));
				$diffdays=self::dateDiffInDays($bb_expiry_date,$expdate);
				$pack_expiry=$expdate;
				//echo $bb_expiry_date." ".$expdate;exit;
				if($diffdays==0){
					$pack_expiry=$expdate;
				}else if($diffdays>0){
					$pack_expiry=$bb_expiry_date;
				}else{
					return response("renew supplier", 400);
					//echo "renew supplier";exit;
				}
				//echo "sdaf ".$bb_expiry_date." ".$expdate." ".$diffdays;exit;
			}else{

			}

			$response=array();
			$response['startdate']=$startdate;
			$response['expirydate']=$pack_expiry;
			$response['format_startdate']=date("d/m/Y",strtotime($startdate));
			$response['format_expirydate']=date("d/m/Y",strtotime($pack_expiry));
			// send FCM Renewal
			$activated_userinfo = User::select('*')->where('user_id','=',$cms_username)->where('user_role','=',4)->where('status','=',1)->first();
			if(!empty($activated_userinfo)){

				$rec_id = $activated_userinfo->rec_id;
				$email = $activated_userinfo->email;
				if(!empty($activated_userinfo->telephone)){
					$mobileno = $activated_userinfo->telephone;
				}else{
					$mobileno = "";
				}
				$device_id = $activated_userinfo->device_id;
				$device_id_android = array($activated_userinfo->device_id);

				$mbl_platform = $activated_userinfo->mbl_platform;
				$application_id = $activated_userinfo->application_id;

				$client_id="";$clientCode="";
				if(!empty($application_id)){
					$info = ApplicationsInfo::where('application_id','=',$application_id)->first();
					if(!empty($info)){
						$client_id = $info->application_id;
						$clientCode = $info->application_name;
					}
				}

				$icon = "success.png";
				$clienticon = "transactions-active.png";
				$myrtime = date("Y-m-d H:i:s");
				$temp=explode(" ",$myrtime);
				$today = $temp[0];
				$ttime=$temp[1];
				$new_time = $today."T".$ttime;

				$message = "Your Renewal Subscription is now activated and you can now start enjoying the latest content and channels.";

				$htmlMessage = "Your Renewal Subscription is now activated and you can now start enjoying the latest content and channels.";

				$htmlMessageIOS="Your Renewal Subscription is now activated and you can now start enjoying the latest content and channels.";


				$arr = array("Client_id" => $client_id,"ClientCode" => $clientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Account Information',"user_id" =>$rec_id,"MobileNo" =>$mobileno,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);

				$json_data["renewal_subscription_activated"] = json_encode($arr);

				//$device_id = array($res['device_id']);

				if(!empty($device_id)){

					/*if($mbl_platform == 'ios'){
					   $res = Common::sendFCMIOS($device_id,$json_data,$mobileno, 'Renewal_subscription_activated',$htmlMessageIOS);
					}else if($mbl_platform == 'android'){
						$deviceIds = UsersDevicesList::where('user_id','=',$rec_id)->where('device_type','=','android')->get();

						if(@count($deviceIds) > 0){
							foreach ($deviceIds as $val) {
								$application_name = $val->application_name;
								//array_push($device_id, $val->device_id);
								$device_id = array($val->device_id);

								$res = Common::sendFCMAndroid($device_id,$json_data,$mobileno, 'Renewal_subscription_activated',$application_name);
							}
						}else{
							$res = Common::sendFCMAndroid($device_id_android,$json_data,$mobileno, 'Renewal_subscription_activated',$client_id);
						}

					}*/

					$deviceIds = UsersDevicesList::where('user_id','=',$rec_id)->get();

					if(@count($deviceIds) > 0){
						foreach ($deviceIds as $val) {
							$user_id = $val->user_id;
							$application_name = $val->application_name;
							$device_id = array($val->device_id);
							$device_id1 = $val->device_id;
							$device_type = $val->device_type;
							if(!empty($device_type)){
								if($device_type == "android"){
									$res = Common::sendFCMAndroid($device_id,$json_data,$mobileno, 'Renewal_subscription_activated',$application_name);
								}else{
									 $res = Common::sendFCMIOS($device_id1,$json_data,$mobileno, 'Renewal_subscription_activated',$htmlMessageIOS,$application_name,$user_id);
								}
							}

						}
					}

				}

			}


			return response($response, 200);
			//echo json_encode($response);exit;
		}else{
			return response("", 400);
		}
	}
	public static function dateDiffInDays($date1, $date2)
	{
		// Calulating the difference in timestamps
		$diff = strtotime($date2) - strtotime($date1);

		// 1 day = 24 hours
		// 24 * 60 * 60 = 86400 seconds
		return round($diff / 86400);
	}
	public static function validateCmsCredentials($cms_username,$cms_password){
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
			return "fail";
		}
		curl_close($ch);
		return $result;
	}
	public function updateOrderFromAdmin(Request $request,$type=1){
		if(!empty($type)){
			$data['type'] = $type;
		}else{
			$data['type'] = 1;
		}
		$data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();
		$data['package_data'] = DB::table('packages')->where('status', 1)->get();
		$data['customers_data'] = User::where('user_role',4)->where('status',1)->select('first_name','last_name','email','rec_id','user_id')->get();
		return view('update_order_from_admin')->with($data);
	}

	public function getShippingAddress(Request $request) {
		$userInfo = Auth::user();
		$user_id = $request->rec_id;
		$shipping_details = User::where(['rec_id' => $user_id])->select('shipping_address')->orderBy('rec_id','desc')->first();
		$shipping_address = (!empty($shipping_details)) ? $shipping_details->shipping_address : '';
		return response()->json(['status' => 'Success', 'result' => $shipping_address], 200);
	}

	public static function saveUpdateOrder($lguserId,$fileName,$request){
		
		$package_id = $request['package'];
		$customer_rec_id = $request['username'];
		$subs_type = $request['subs_type'];
		$payment_method = $request['pay'];
		if(!empty($request['subscription_type']) && $request['subscription_type'] == 'New' && $package_id == 11){
			$customer_id = $customer_rec_id;
			$type=1;
		}else if(!empty($request['subscription_type']) && $request['subscription_type'] == 'New' && $subs_type == 2){
			$customer_det = User::where('rec_id',$customer_rec_id)->first();
			$customer_id = self::createSubUser($customer_det);
			$type=1;
			Multiple_box_purchase::create([
		        	'user_id' => $customer_rec_id,
		        	'sub_user_id' => $customer_id
		        ]);
		}else if(!empty($request['subscription_type']) && $request['subscription_type'] == 'New'){
			$customer_id = $customer_rec_id;
			$type=1;
		}
		else{
			$customer_id = $customer_rec_id;
			$type=2;
		}
		$customer_info = User::select('rec_id','first_name','last_name','email')->where(['rec_id' => $customer_id])->first();
		$first_name = $customer_info['first_name'];
		$last_name = $customer_info['last_name'];
		$cust_user_id = $customer_info['user_id'];
		$email = $customer_info['email'];

		$userInfo = Unilevel_tree::leftjoin('users','unilevel_tree.upliner_id','=','users.rec_id')->where('unilevel_tree.down_id',$customer_id)->where('users.user_role','!=',4)->orderBy('unilevel_tree.level','ASC')->first();

		$login_userId = $userInfo['rec_id'];
		$login_user_comm_per = $userInfo['commission_perc'];
		$pack = Packages::where("id", $package_id)->first();
		$wal = Wallet::where("user_id", $login_userId)->first();

		$pack_pur_id = self::purchaseCommission($cust_user_id,$userInfo,$pack,$wal=array(),$customer_id,$package_id,$login_userId,$login_user_comm_per,$first_name,$last_name,2,$customer_id);

		if(!empty($pack) && $pack->setupbox_status == 1){
			$country = Country::where('countryid',$request['shipping_country'])->first();
			$mb = $request['shipping_user_mobile_no'];
			$firstCharacter = $mb[0];
			if($firstCharacter == 0){
			    $mbl = ltrim($mb, '0');
			}else{
			    $mbl = $mb;
			}
			$mobile = $request['shipping_country_code'] . "-" . $mbl;
			$shipping_address = $request['shipping_address']."<p>".$country->country_name."</p><p>".$mobile."</p>";
		}else{
			$shipping_address="";
		}

		$data = array('attachment' => $fileName, 'order_id' => $request['order_id'], 'amount' => $pack->effective_amount,'aliexpress_email' => '','shipping_address' => $shipping_address,'purchased_from' => $payment_method,'purchased_date' => Now(),'status' => 1, 'user_id' => $customer_id, 'sender_id' => $lguserId,'updated_at' => Now(),'type'=>$type,'package_purchased_id'=>$pack_pur_id);

		$res = Purchase_order_details::create($data);

		if(!empty($pack) && $pack->setupbox_status == 1){
			$data['useremail'] = array('name' => $first_name.' '.$last_name,'order_id' => $request['order_id'], 'aliexpress_email' => '','shipping_address' => $shipping_address,'purchased_from' => $payment_method,'purchased_date' => Now(),'date' => date("d/m/Y"));
			$emailid = array('toemail' => $email);
			Mail::send(['html' => 'email_templates.order-confirmation'], $data, function ($message) use ($emailid) {
				$message->to($emailid['toemail'], 'Order Confirmation')->subject('Order Confirmation');
				$message->from('noreply@bestbox.net', 'BestBox');
			});
		}

	}

	public function checkOrderIdExistsOrNot(Request $request){
		$userInfo = Auth::user();
		$lguserId = $userInfo['rec_id'];
		$validator = Validator::make($request->all(), [
			'order_id' => 'required|unique:purchase_order_details'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str =$arr;
			}
			return response()->json(['status' => 'Failure', 'Result' => $str], 200);
		}else{
			return response()->json(['status' => 'Success', 'Result' => ''], 200);
		}
	}

	public function updateCustomerOrderFromAdmin(Request $request) {
		//echo "<pre>";print_r($request->all());exit();
		$userInfo = Auth::user();
		$lguserId = $userInfo['rec_id'];
		//echo '<pre>';print_R($request->all());exit;
		$validator = Validator::make($request->all(), [
			'username' => 'required',
			'order_id' => 'required|unique:purchase_order_details',
			//'ali_express_email' => 'required|email|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$/',
			'pay' => 'required',
			'package' => 'required'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			Session::flash('error', '<ul>' . $str . '</ul>');
			Session::flash('alert','Failure');
			return Redirect::back();
		} else {

			$package_id = $request->package;
			$pack = Packages::where("id", $package_id)->first();

			if(!empty($pack) && $pack->setupbox_status == 1){
						$validator = Validator::make($request->all(), [
							'shipping_address' => 'required',
							'shipping_country' => 'required',
							'shipping_user_mobile_no' => 'required|regex:/^([0-9]{8,14})$/'
						]);
						if ($validator->fails()) {
							$errs = $validator->messages()->all();
							$str = '';
							foreach ($errs as $arr) {
								$str = $str . '<li>' . $arr . '</li>';
							}
							Session::flash('error', '<ul>' . $str . '</ul>');
							Session::flash('alert','Failure');
							return Redirect::back();
							$status = 0;
						}else{
							$status = 1;
						}
					}else{
						$status = 1;
					}

			if($status == 1){
				if ($request->hasFile('invoice_attachment')) {
					$image = $request->file('invoice_attachment');
					$fileType = $image->guessExtension();
					$fileTyp = strtolower($fileType);
					$allowedTypes = array("jpeg", "jpg", "png", "pdf");

					if (in_array($fileTyp, $allowedTypes)) {
						// Rename image
						$fileName = 'INV-'.rand(999,9999999).time().'.'.$image->guessExtension();
						$destinationPath = base_path('/public/invoices');
						$upload_success = $image->move($destinationPath, $fileName);

						if ($upload_success){

							$res = self::saveUpdateOrder($lguserId,$fileName,$request->all());

							Session::flash('message', 'Your update order has been submitted for approval');
							Session::flash('alert','Success');
							return Redirect::back();
						} else {
							Session::flash('error', 'Something went wrong in Uploading image');
							Session::flash('alert','Failure');
							return Redirect::back();
						}
					} else {
						Session::flash('error', 'Please Upload only JPEG,JPG,PNG or PDF formats only');
						Session::flash('alert','Failure');
						return Redirect::back();
					}
				}else{

					$res = self::saveUpdateOrder($lguserId,'',$request->all());

					Session::flash('message', 'Your update order has been submitted for approval');
					Session::flash('alert','Success');
					return Redirect::back();
				}
			}
		}
	}

	public static function createSubUser($customer_det){

		$admin_id = config('constants.ADMIN_ID');
		$boxcount = Multiple_box_purchase::where('user_id',$customer_det->rec_id)->count();
        $sub_user_id = $customer_det->user_id.($boxcount+1);

		$user = User::create([
			'user_id' => $sub_user_id,
			'referral_userid' => $customer_det->rec_id,
			'first_name' => $customer_det->first_name,
			'last_name' => $customer_det->last_name,
			'email' => $customer_det->email,
			'email_verify' => 1,
			'password' => $customer_det->password,
			'plain_password'=>$customer_det->plain_password,
			'gender' => $customer_det->gender,
			'married_status' => $customer_det->married_status,
			'registration_date' => date('Y-m-d H:i:s'),
			'shipping_country' => $customer_det->shipping_country,
			'shipping_address' => $customer_det->shipping_address,
			'shipping_user_mobile_no' => $customer_det->shipping_user_mobile_no,
			'user_role' => 4,
			'status' => 1,
			'refferallink_text' => $customer_det->refferallink_text,
			'created_by' => $customer_det->rec_id,
			'sub_user' => 1,
			'application_id' => 1234
		]);
		$last_inserted_id = $user->rec_id;
		$wallet = Wallet::create([
			'user_id' => $last_inserted_id,
			'amount' => 0
		]);
		$ut = Users_tree::where('customer_id',$customer_det->rec_id)->first();

		Users_tree::create([
			'customer_id' => $last_inserted_id,
			'agent_id' => $ut->agent_id,
			'reseller_id' => $ut->reseller_id,
			'admin_id' => $ut->admin_id
		]);

		$l = 1;
		$nom = $customer_det->rec_id;
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
		return $last_inserted_id;
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

	public function renewal(Request $request){

		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$renewal_package_id = decrypt($request['id']);
		$data['renewal_package'] = User::leftJoin(\DB::raw('(SELECT * FROM package_purchased_list WHERE rec_id IN (SELECT MAX(rec_id) AS id FROM package_purchased_list WHERE package_id != 11 GROUP BY user_id) ORDER BY user_id) AS t2'), function($join) {
			$join->on('users.rec_id', '=', 't2.user_id');
		})->leftjoin('packages', 't2.package_id', '=', 'packages.id')->where('users.rec_id',$renewal_package_id)->select('users.registration_date','users.rec_id','users.user_id','users.first_name','users.last_name','packages.id','packages.effective_amount', 't2.expiry_date','packages.package_name','packages.description','packages.discount','packages.package_value','packages.setupbox_status','packages.aliexpress_url')->first();
		//echo '<pre>';print_r($data['renewal_package']);exit;
		$data['userInfo'] = $userInfo;
		$data['package_data'] = DB::table('packages')->where('status', 1)->where('setupbox_status',2)->get();
		$data['wallet_balance'] = Wallet::where('user_id', $login_userId)->first();
		$data['rec_id'] = $request['id'];
		//echo '<pre>';print_r($data['renewal_package']);exit;
		//return view('customer/renewal')->with($data);
		return view('customer/version2/renewal')->with($data);
	}

	public function multibox(Request $request){

		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$data['userInfo'] = $userInfo;
		$data['package_data'] = DB::table('packages')->where('status', 1)->get();
		$data['wallet_balance'] = Wallet::where('user_id', $login_userId)->first();
		$data['rec_id'] = $request['id'];

		//return view('customer/multibox')->with($data);
		return view('customer/version2/multibox')->with($data);
	}

	public function renewalpkg(Request $request){

		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$data['userInfo'] = $userInfo;
		$data['package_data'] = DB::table('packages')->where('status', 1)->get();
		$data['wallet_balance'] = Wallet::where('user_id', $login_userId)->first();
		$data['rec_id'] = $request['id'];

		return view('customer/renewalpkg')->with($data);
	}

	public function saveRenewal(Request $request){

		$admin_id = config('constants.ADMIN_ID');
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$renewal_id = $request['renewal_id'];
		$messages = [
			    'package.required' => 'Please select package.'
			];
		$validator = Validator::make($request->all(), [
			'package' => 'required'
		],$messages);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			Session::flash('error', '<ul>' . $str . '</ul>');
			Session::flash('alert','Failure');
			return Redirect::back();
		}else{
			$payment_method = $request->payment_method;
			$package_id = Input::get('package');
			$pack = Packages::where("id", $package_id)->first();
			$wal = Wallet::where("user_id", $login_userId)->first();

			//multi box
			$subscription_type = Input::get('subscription_type');

			if($subscription_type == 'New'){
				$customer_det = User::where('rec_id',$login_userId)->first();
				$customer_id = self::createSubUser($customer_det);
				$type=1;
				$ttype = 'New Package';
				$desc = $pack->effective_amount . ' USD paid for customer package purchase.';
			}else{
				$customer_id = decrypt($renewal_id);
				$type=2;
				$ttype = 'Renewal Package';
				$desc = $pack->effective_amount . ' USD paid for renewal package purchase.';
			}
			log::info('customer_id'.$customer_id);
			$uplinerInfo = Unilevel_tree::leftjoin('users','unilevel_tree.upliner_id','=','users.rec_id')->where('unilevel_tree.down_id',$customer_id)->where('users.user_role','!=',4)->select('users.*')->orderBy('unilevel_tree.level','ASC')->first();
			if(!empty($uplinerInfo)){
				$upliner_userId = $uplinerInfo['rec_id'];
				$upliner_user_comm_per = $uplinerInfo['commission_perc'];
				//log::info('customer_id'.$upliner_user_comm_per.'--'.$uplinerInfo);
				//payment with everuspay
				if($payment_method == 'EVERUSPAY') {
					$refnumber = self::generate_randam_string('ORD', $strength = 9);
					$userdata = User::where('rec_id',$login_userId)->first();

					$transaction_no = self::generate_randam_string('RNID', $strength = 9);
					//insert data into payments history table

					$last_inserted_id = PaymentsHistory::create([
						'user_id' => $login_userId,
						'customer_id' => $customer_id,
						'order_id' => $refnumber,
						'transaction_no' => $transaction_no,
						'package_id' => $package_id,
						'amount_in_usd' => $pack->effective_amount,
						'subscription_type' => $type,
						'subscription_desc' => $desc,
						'purchased_from' => 1,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')
					])->id;

					$random_number = self::generate_randam_string('TEL', $strength = 9);

					$userContact = ($userdata->telephone!='') ? $userdata->telephone : $random_number;

					$data = array(
						'MerchantId' => config('constants.EVERUS_MERCHANT_ID'), 'RefNo' =>  $refnumber,'Amount' => $pack->effective_amount, 'Currency' => 'USD','ProdDesc' => $request->package_name.' '.$request->package_desc,'UserName' => $userdata->first_name.' '.$userdata->last_name,'UserEmail' => $userdata->email,'UserContact' => $userContact, 'Remark' => $last_inserted_id,'Lang' => 'UTF-8','TimeZone' => "America/Los_Angeles", 'BrandName' => 'BestBox',
						'CallBackUrl' => url('/').'/everusPayCallback', 'BackendURL' => url('/').'/everusPayCallback'
					);
					$html = '';
					$merchantURL = config('constants.MERCHANT_FORM_URL');
					$html .= '<form  style="display: none"  name="redirectpost" class="redirectpost"  id ="redirectpost" method="post" action="'.$merchantURL.'">';
					foreach($data as $key =>$value){
						if(!is_array($value)){
							$html .= '<input type="hidden" name="'.trim($key).'" value="'.trim($value).'"> ';
						}else if(is_array($value)){
							foreach ($value as $key1 => $value1) {
								$html .= '<input type="hidden" name="' . $key1 . '" value="' . $value1 . '"> ';
							}
						}
					}

					$html .= '<input type="submit" class="final_submit" value="submit" name="submit">';
					$html .= '</form>';
					echo $html;
					echo '<div style="text-align:center;width:100% id="loader" style="display: none"><img src="'.url('/').'/public/images/loader.gif" style="display: block; margin: auto;" /><div style="text-align:center;font-size:30px;font-weight:600;margin: 10px 0px;">Please wait...Redirect to EVERUSPAY Payment Gateway</div><div style="text-align:center;font-size:26px;font-weight:500;margin: 10px 0px;">do not refresh or press back button.</div><div>';
					?>
					<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
					<script type='text/javascript'>
						$("#loader").css('display','block');
						var interval = setInterval(function () {
							$( ".final_submit" ).trigger( "click" );
							return false;
						}, 2000);
					</script>
				<?php }else if($payment_method == 'BITPAY') { //payment by bitpay

						//payment with bitpay
						$refnumber = self::generate_randam_string('ORD', $strength = 9);
						$userdata = User::where('rec_id',$login_userId)->first();

						$transaction_no = self::generate_randam_string('RNID', $strength = 9);
						//insert data into payments history table

						$payment_history = PaymentsHistory::create([
							'user_id' => $login_userId,
							'customer_id' => $customer_id,
							'order_id' => $refnumber,
							'transaction_no' => $transaction_no,
							'package_id' => $package_id,
							'amount_in_usd' => $pack->effective_amount,
							'subscription_type' => $type,
							'subscription_desc' => $pack->effective_amount . ' USD paid for customer package purchase.',
							'purchased_from' => 1,
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s')
						])->id;

						Session::put('order_id',$refnumber);
						$random_number = self::generate_randam_string('TEL', $strength = 9);

						$userContact = ($userdata->telephone!='') ? $userdata->telephone : $random_number;

						$html = '';
						$merchantURL = 'https://bitpay.com/checkout';

						$html .= '<form action="'.$merchantURL.'" method="post" id="bitpay_final_submit">';
							$html .= '<input type="hidden" name="action" value="checkout" />';
							$html .= '<input type="hidden" name="price" value="'.$pack->effective_amount.'" />';
							$html .= '<input type="hidden" name="currency" value="USD" />';
							$html .= '<input type="hidden" name="orderId" value="'.$refnumber.'" />';
							$html .= '<input type="hidden" name="posData" value="'.$transaction_no.'" />';
							$html .= '<input type="hidden" name="itemDesc" value="'.$pack->package_name.' '.$pack->description.'" />'; 
							$html .= '<input type="hidden" name="notificationType" value="json" />';
							$html .= '<input type="hidden" name="data" value="66k52dy+wpnAqon6R1hHUPYwZRFwDJqhhthCClAPpwYsQWYFThllSCpDBnrgQCWlUsQo4aNA2Z2ltzVUPNCgAGnlEO6LQTFbUN1hukNq7Bj8ABKBD93+CMtyra5aU4i6lblRFkT+YYcA/wjBX5ga1oi7mixgL0Hz6udPoyeqIQ2vJSDZjPFGVhzSwB3nI+Lbr50hIZiO4jpuPwV4JT86HRqT6PTaPqLlLdS7HPP2nRtnMOVWwbuhmwbDiYuV0g/29jn/WywwRA+6Ww5Tr0s+HTgUgMUa4p4nseC1SdDsAhJLjezJ2U9721zaI1Ehb7ahl8QQFFzteBKu/Qudqphe9Q3N2JcFRLDX7+I2ESWQGYU=" />';
						//$html .= '<input type="image" src="https://test.bitpay.com/cdn/en_US/bp-btn-pay-currencies.svg" name="submit" style="width: 210px" alt="BitPay, the easy way to pay with bitcoins.">';
							// $html .= '<input type="submit" class="bitpay_final_submit" value="submit" name="submit">';
						$html .= '</form>';									

						echo $html;
						echo '<div style="text-align:center;width:100% id="loader" style="display: none"><img src="'.url('/').'/public/images/loader.gif" style="display: block; margin: auto;" /><div style="text-align:center;font-size:30px;font-weight:600;margin: 10px 0px;">Please wait...Redirect to BITPAY Payment Gateway</div><div style="text-align:center;font-size:26px;font-weight:500;margin: 10px 0px;">do not refresh or press back button.</div><div>';
						?>
						<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
						<script type='text/javascript'>
							$("#loader").css('display','block');
							var interval = setInterval(function () {
								$( "#bitpay_final_submit" ).submit();
								return false;
							}, 2000);
						</script>
						<?php
						}else {
				 		if ($pack->effective_amount <= $wal->amount) {

							//payment by reseller/agent wallet
							Wallet::where('user_id', $login_userId)->decrement('amount', $pack->effective_amount);
							//transactions table
							$bal = $wal->amount - $pack->effective_amount;

							$transaction_no = self::generate_randam_string('RNID', $strength = 9);

							$transaction_id = self::user_transactions($transaction_no,$package_id,$login_userId,$login_userId ,$admin_id, 0, $pack->effective_amount, $bal, $ttype, $desc);
							//package purchased and commission pay function
							$pack_pur_id = self::purchaseCommission($userInfo['user_id'],$uplinerInfo,$pack,$wal,$customer_id,$package_id,$upliner_userId,$upliner_user_comm_per,$userInfo['first_name'],$userInfo['last_name'],2,$customer_id);
							$order_id = self::generate_randam_string('ORD', $strength = 9);
							Purchase_order_details::create([
										'user_id' => $customer_id,
										'order_id' => $order_id,
										'purchased_date' => date('Y-m-d H:i:s'),
										'purchased_from' => 'Wallet',
										'sender_id' => $login_userId,
										'status' => 1,
										'package_purchased_id' => $pack_pur_id,
										'type' =>$type
									]);
							if($subscription_type == 'New'){
								Multiple_box_purchase::create([
									'user_id' => $login_userId,
									'sub_user_id' => $customer_id,
									'package_id' => $package_id,
									'package_purchased_id' => $pack_pur_id,
								]);
							}

							$data['userInfo'] = User::where(['rec_id' => $customer_id])->first();

							$data['result'] = array(
								'date' => date('Y-m-d H:i:s'),
								'buyer_email' => $request->customer_email,
								'package' => $pack->package_name,
								'duration' => $pack->duration .' month(s)',
								'activation_period' => $pack->package_name,
								'payment_method' => 'BestBox Wallet',
								'payment_id' => $order_id,
								'status' => 1,
								'payment_reference' => $order_id,
								'amount_in_usd' => $pack->effective_amount
							);

							$data1['payment_det'] = array('name'=>$data['userInfo']['first_name'].' '.$data['userInfo']['last_name'],'transaction_id'=>$order_id,'purchased_date'=>date('Y-m-d H:i:s'),'shipping_address'=>"",'package_name'=>$pack->package_name,'package_amount'=>$pack->effective_amount);
					        $emailid = array('toemail' => $data['userInfo']['email']);
					        Mail::send(['html'=>'email_templates.payment_receipt'], $data1, function($message) use ($emailid) {
						        $message->to($emailid['toemail'], 'Payment Receipt')->subject
						        ('Payment Receipt');
						        $message->from('noreply@bestbox.net','BestBox');
					        });

							if($userInfo['user_role'] = 4){
								return view('customer/version2/payment_success')->with($data);
							}else{
								return view('payment_success')->with($data);
							}

						} else {
							Session::flash('error', 'Insufficient balance in your wallet');
							Session::flash('alert','Failure');
							return Redirect::back();
						}
					}
			}

		}

	}

	//everuspay payment callback function

	public function everusPayCallback(Request $request){
		$admin_id = config('constants.ADMIN_ID');
		$userInfo = Auth::user();
		$data['userInfo'] = $userInfo;

		$payment_id = $request->Remark;

		$payment_info = PaymentsHistory::where(['id'=> $payment_id])->first();

		$pack = Packages::where("id", $payment_info->package_id)->first();

		if($payment_info->transaction_status=='Initial'){
			$subscription_type = ($payment_info->subscription_type == 1) ? 'New Package' : 'Renewal Package';

			$update_data = array(
				'payment_reference' => trim($request->payment_reference),
				'merchant_id' => trim($request->MerchantId),
				'buyer_email' => trim($request->customer_email),
				'crypto' => trim(strtoupper($request->payment_mode)),
				'amount_in_usd' => trim($request->amount_currency),
				'amount_in_crypto' => trim($request->amount_crypto),
				'processing_fee' => trim($request->process_fee_crypto),
				'processing_fee_usd' => trim($request->process_fee_currency),
				'transaction_hash' => trim($request->transaction_hash),
				'wallet_address' => trim($request->wallet_address),
				'paid_status' => $request->paid_status,
				'transaction_status' => $request->transaction_status,
				'reason' => $request->reason,
				'response_json' => serialize($request->all()),
				'updated_at' => date('Y-m-d H:i:s')
			);
			//echo '<pre>';print_r($request->all());
			//echo '<pre>';print_r($update_data);exit;

			PaymentsHistory::where(['id'=> $payment_id])->update($update_data);
			//echo '<pre>';print_r($update_data);exit;
			if(($request->paid_status == 'normal' || $request->paid_status == 'high') && $request->transaction_hash !=''  && ($request->transaction_status == 'completed' || $request->transaction_status == 'pending')){
				$uplinerInfo = Unilevel_tree::leftjoin('users','unilevel_tree.upliner_id','=','users.rec_id')->where('unilevel_tree.down_id',$payment_info->customer_id)->where('users.user_role','!=',4)->select('users.*')->orderBy('unilevel_tree.level','ASC')->first();
				if(!empty($uplinerInfo)){
					$upliner_userId = $uplinerInfo['rec_id'];
					$upliner_user_comm_per = $uplinerInfo['commission_perc'];
				}else{
					$upliner_userId = 0;
					$upliner_user_comm_per = 0;
				}

				$transaction_no = $payment_info->transaction_no;

				//payment by reseller/agent wallet
				$wal = Wallet::where('user_id', $userInfo['rec_id'])->first();
				//transactions table
				$bal = $wal->amount;
				$notification_message = "<strong>".date("F jS, Y g:i a")."</strong> You have successfully transferred <strong>Payment Package ".$pack->package_name."</strong> amount <strong>".$pack->effective_amount."</strong> USD by EVERUSPAY. The Payment ID is ".$request->payment_reference;
				self::user_transactions($transaction_no,$payment_info->package_id,$payment_info->user_id,$payment_info->user_id ,$admin_id, 0, 0, $wal->amount, $subscription_type, $payment_info->subscription_desc, $notification_message);
				//package purchased and commission pay function
				$pack = Packages::where("id", $payment_info->package_id)->first();
				$wal = Wallet::where("user_id", $payment_info->user_id)->first();

				$pack_pur_id = self::purchaseCommission($userInfo['user_id'],$uplinerInfo,$pack,$wal,$payment_info->customer_id,$payment_info->package_id,$upliner_userId,$upliner_user_comm_per,$userInfo['first_name'],$userInfo['last_name'],2,$payment_info->customer_id);

				Purchase_order_details::create([
							'user_id' => $payment_info->customer_id,
							'order_id' => $payment_info->order_id,
							'purchased_date' => date('Y-m-d H:i:s'),
							'purchased_from' => 'EVERUSPAY',
							'sender_id' => $payment_info->user_id,
							'status' => 1,
							'package_purchased_id' => $pack_pur_id,
							'type' => $payment_info->subscription_type
						]);

				$data['result'] = array(
					'date' => date('Y-m-d H:i:s'),
					'buyer_email' => $request->customer_email,
					'package' => $pack->package_name,
					'duration' => $pack->duration .' month(s)',
					'activation_period' => $pack->package_name,
					'payment_method' => 'EVERUSPAY',
					'payment_reference' => $request->payment_reference,
					'merchant_id' => $request->MerchantId,
					'amount_in_usd' => $payment_info->amount_in_usd,
					'amount_in_crypto' => $request->total_amount_crypto,
					'payment_mode' => strtoupper($request->payment_mode),
					'status' => 1
				);

				
				if($payment_info->purchased_from==1){

					$userInfo = User::where(['rec_id' => $payment_info->customer_id])->first();
					$data1['payment_det'] = array('name'=>$userInfo['first_name'].' '.$userInfo['last_name'],'transaction_id'=>$payment_info->order_id,'purchased_date'=>date('Y-m-d H:i:s'),'shipping_address'=>"",'package_name'=>$pack->package_name,'package_amount'=>$pack->effective_amount);
					        $emailid = array('toemail' => $userInfo['email']);
			        Mail::send(['html'=>'email_templates.payment_receipt'], $data1, function($message) use ($emailid) {
				        $message->to($emailid['toemail'], 'Payment Receipt')->subject
				        ('Payment Receipt');
				        $message->from('noreply@bestbox.net','BestBox');
			        });
				}

				return view('payment_success')->with($data);
			}else if($request->transaction_status == 'waiting'){

				$transaction_no = $payment_info->transaction_no;

				//payment by reseller/agent wallet
				$wal = Wallet::where('user_id', $userInfo['rec_id'])->first();
				//transactions table
				$bal = $wal->amount;
				$notification_message = "<strong>".date("F jS, Y g:i a")."</strong> Your payment transfer is waiting, <strong>Payment Package ".$pack->package_name."</strong> amount <strong>".$pack->effective_amount."</strong> USD by EVERUSPAY. The Payment ID is ".$request->payment_reference;
				self::user_transactions($transaction_no,$payment_info->package_id,$payment_info->user_id,$payment_info->user_id ,$admin_id, 0, 0, $wal->amount, $subscription_type, $payment_info->subscription_desc,$notification_message);
				$data['result'] = array(
					'date' => date('Y-m-d H:i:s'),
					'buyer_email' => $request->customer_email,
					'package' => $pack->package_name,
					'duration' => $pack->duration .' month(s)',
					'activation_period' => $pack->package_name,
					'payment_method' => 'EVERUSPAY',
					'payment_reference' => $request->payment_reference,
					'merchant_id' => $request->MerchantId,
					'amount_in_usd' => $payment_info->amount_in_usd,
					'amount_in_crypto' => $request->total_amount_crypto,
					'payment_mode' => strtoupper($request->payment_mode),
					'status' => 2
				);

				return view('payment_success')->with($data);
			}else{
				$userInfo = User::where(['rec_id' => $payment_info->customer_id])->first();
				if($payment_info->subscription_type == 1 && $userInfo->sub_user == 1){
					Wallet::where('user_id',$userInfo->rec_id)->delete();
					Unilevel_tree::where('down_id',$userInfo->rec_id)->delete();
					Users_tree::where('customer_id',$userInfo->rec_id)->delete();
					Multiple_box_purchase::where('sub_user_id',$userInfo->rec_id)->delete();
					User::where('rec_id',$userInfo->rec_id)->delete();
				}

				$transaction_no = $payment_info->transaction_no;
				$subscription_type = ($payment_info->subscription_type == 1) ? 'New Package' : 'Renewal Package';
				$wal = Wallet::where('user_id', $payment_info->user_id)->first();
				$notification_message = "<strong>".date("F jS, Y g:i a")."</strong> Your payment transfer is failed, <strong>Payment Package ".$pack->package_name."</strong> amount <strong>".$pack->effective_amount."</strong> USD by EVERUSPAY. The Payment ID is ".$request->payment_reference;
				self::user_transactions($transaction_no,$payment_info->package_id,$payment_info->user_id,$payment_info->user_id ,$admin_id, 0, 0, $wal->amount, $subscription_type, $payment_info->subscription_desc, $notification_message);

				$data['result'] = array(
					'date' => date('Y-m-d H:i:s'),
					'package' => $pack->package_name,
					'duration' => $pack->duration .' month(s)',
					'activation_period' => $pack->package_name,
					'payment_method' => 'EVERUSPAY',
					'payment_reference' => $request->payment_reference,
					'merchant_id' => $request->MerchantId,
					'amount_in_usd' => $payment_info->amount_in_usd,
					'amount_in_crypto' => $request->total_amount_crypto,
					'payment_mode' => strtoupper($request->payment_mode),
					'status' => 0
				);

				return view('payment_success')->with($data);
			}
		}else{

			if(($payment_info->paid_status == 'normal' || $payment_info->paid_status == 'high') && $payment_info->transaction_hash !=''  && ($payment_info->transaction_status == 'completed' || $payment_info->transaction_status == 'pending')){
				$status = 1;
				if($payment_info->purchased_from==1){

					$userInfo = User::where(['rec_id' => $payment_info->customer_id])->first();
					$data1['payment_det'] = array('name'=>$userInfo['first_name'].' '.$userInfo['last_name'],'transaction_id'=>$payment_info->order_id,'purchased_date'=>date('Y-m-d H:i:s'),'shipping_address'=>"",'package_name'=>$pack->package_name,'package_amount'=>$pack->effective_amount);
					        $emailid = array('toemail' => $userInfo['email']);
			        Mail::send(['html'=>'email_templates.payment_receipt'], $data1, function($message) use ($emailid) {
				        $message->to($emailid['toemail'], 'Payment Receipt')->subject
				        ('Payment Receipt');
				        $message->from('noreply@bestbox.net','BestBox');
			        });
				}
			}else{
				$userInfo = User::where(['rec_id' => $payment_info->customer_id])->first();
				if($payment_info->subscription_type == 1 && $userInfo->sub_user == 1){
					Wallet::where('user_id',$userInfo->rec_id)->delete();
					Unilevel_tree::where('down_id',$userInfo->rec_id)->delete();
					Users_tree::where('customer_id',$userInfo->rec_id)->delete();
					Multiple_box_purchase::where('sub_user_id',$userInfo->rec_id)->delete();
					User::where('rec_id',$userInfo->rec_id)->delete();
				}

				$transaction_no = $payment_info->transaction_no;
				$subscription_type = ($payment_info->subscription_type == 1) ? 'New Package' : 'Renewal Package';
				$wal = Wallet::where('user_id', $payment_info->user_id)->first();
				$notification_message = "<strong>".date("F jS, Y g:i a")."</strong> Your payment transfer is failed, <strong>Payment Package ".$pack->package_name."</strong> amount <strong>".$pack->effective_amount."</strong> USD by EVERUSPAY. The Payment ID is ".$request->payment_reference;
				self::user_transactions($transaction_no,$payment_info->package_id,$payment_info->user_id,$payment_info->user_id ,$admin_id, 0, 0, $wal->amount, $subscription_type, $payment_info->subscription_desc, $notification_message);

				$status = 0;
			}
			$data['result'] = array(
				'date' => date('Y-m-d H:i:s'),
				'package' => $pack->package_name,
				'duration' => $pack->duration .' month(s)',
				'activation_period' => $pack->package_name,
				'payment_method' => 'EVERUSPAY',
				'payment_reference' => $payment_info->payment_reference,
				'merchant_id' => $payment_info->merchant_id,
				'amount_in_usd' => $pack->effective_amount,
				'amount_in_crypto' => $payment_info->amount_in_crypto,
				'payment_mode' => strtoupper($payment_info->crypto),
				'status' => $status
			);

			return view('payment_success')->with($data);
		}


	}

	public function renewalActivation(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$data['from_date'] = $request->query('from_date');
		$data['to_date'] = $request->query('to_date');
		if (!empty($request->query('from_date')) && !empty($request->query('to_date'))) {
			$from_date = $request->query('from_date');
			$to_date = $request->query('to_date');
			$from_date = Carbon::createFromFormat('m-d-Y', $from_date)->format('Y-m-d');
			$to_date = Carbon::createFromFormat('m-d-Y', $to_date)->format('Y-m-d');
			$start = Carbon::parse($from_date)->format('Y-m-d H:i:s');
			$todate = Carbon::parse($to_date)->format('Y-m-d H:i:s');
			$to = date('Y-m-d H:i:s', strtotime($todate . ' +1 day'));

			$data['request_list'] = Purchase_order_details::join('users','users.rec_id','=','purchase_order_details.user_id')->leftjoin('package_purchased_list','purchase_order_details.package_purchased_id','=','package_purchased_list.rec_id')->leftjoin('packages','package_purchased_list.package_id','=','packages.id')->whereBetween('purchase_order_details.purchased_date', [$start, $to])->where('purchase_order_details.type',2)->select('users.first_name','users.last_name','users.user_id','users.email','purchase_order_details.order_id','purchase_order_details.purchased_date','purchase_order_details.status','purchase_order_details.purchased_from','packages.effective_amount','packages.id')->orderBy('purchase_order_details.purchased_date','DESC')->paginate(25);

		}else{
			$data['request_list'] = Purchase_order_details::join('users','users.rec_id','=','purchase_order_details.user_id')->leftjoin('package_purchased_list','purchase_order_details.package_purchased_id','=','package_purchased_list.rec_id')->leftjoin('packages','package_purchased_list.package_id','=','packages.id')->where('purchase_order_details.type',2)->select('purchase_order_details.rec_id','users.first_name','users.last_name','users.user_id','users.email','purchase_order_details.order_id','purchase_order_details.purchased_date','purchase_order_details.status','purchase_order_details.purchased_from','packages.effective_amount','packages.id')->orderBy('purchase_order_details.purchased_date','DESC')->paginate(25);
		}
		return view('renewalActivation')->with($data);
	}

	public function updateOrderStatus(Request $request){
		$rec_id = $request['purchase_id'];
		$udata = array('status'=>3);
		Purchase_order_details::where(array('rec_id'=>$rec_id))->update($udata);
		Session::flash('message', 'Order Canceled Successfully');
		Session::flash('alert','Success');
		return Redirect::back();
	}

	public static function checkPaymentWaitingStatus(){
		//$userInfo = Auth::user();
		$admin_id = config('constants.ADMIN_ID');
		$result = PaymentsHistory::whereIn('transaction_status',['waiting'])->get();
		$everus_merchant_id = config('constants.EVERUS_MERCHANT_ID');
		$everus_username = config('constants.EVERUS_USERNAME');
		$everus_password = config('constants.EVERUS_PASSWORD');
		$merchant_url = config('constants.MERCHANT_URL');
		$client_secret_key = config('constants.CLIENT_SECRET_KEY');
		if(!empty($result)){
			foreach($result as $res){
				$user_id = $res['customer_id'];
				$userInfo = User::where(['rec_id' => $user_id])->first();
				//get access token
				$url = $merchant_url.'/login';
				$params = array("platform" => "merchant",
				"username" => $everus_username,
				"password" => $everus_password,
				"app_name" => "EVERUSPAY",
				"client_secret" => $client_secret_key);

				$options = '';
				$result = self::curlCall($params,$url,$options);
				Log::info("login api result".json_encode($result));
				//echo '<pre>';print_r($result);
				//get the session id
				if(!empty($result->access_token)){
					$url = $merchant_url.'/requestForNodeApiAuth';
					$params = array(
						"app_name" => "EVERUSPAY",
     					"email" => $everus_username
					);
					$options = 'Bearer '.$result->access_token;
					$result2 = self::curlCall($params,$url,$options);
					Log::info("session id result".json_encode($result2));
					//echo '<pre>';print_r($result2);

					//check transaction status success/not
					if($result2->status=='Success' && $result2->nodeApiAuth!=''){
						$url = $merchant_url.'/getTransactionDetailByRefId';
						$params = array(
							"txn_ref_id" => $res['order_id'],
							"app_name" => "EVERUSPAY",
							"merchant_id" => $everus_merchant_id,
							"session_id" => $result2->nodeApiAuth
						);
						$options = 'Bearer '.$result->access_token;
						$result3 = self::curlCall($params,$url,$options);
						Log::info("Payment Waiting Status order id is ".$res['order_id']." ".json_encode($result3));
						//echo '<pre>';print_r($result3);
						if(!empty($result3->message)){
							$data = $result3->message->transaction_details[0][0];

							if($data->transaction_status == 'completed' || $data->transaction_status == 'pending'){
								$update_data = array(
									'payment_reference' => trim($data->payment_reference),
									'merchant_id' => trim($data->MerchantId),
									'crypto' => trim(strtoupper($data->payment_mode)),
									'amount_in_usd' => trim($data->amount_currency),
									'amount_in_crypto' => trim($data->amount_crypto),
									'processing_fee' => trim($data->process_fee_crypto),
									'processing_fee_usd' => trim($data->process_fee_currency),
									'transaction_hash' => trim($data->transaction_hash),
									'wallet_address' => trim($data->wallet_address),
									'paid_status' => $data->paid_status,
									'transaction_status' => $data->transaction_status,
									'reason' => $data->reason,
									'response_json' => serialize($data),
									'updated_at' => date('Y-m-d H:i:s')
								);

								PaymentsHistory::where(['order_id'=> $res['order_id']])->update($update_data);

								$payment_info = PaymentsHistory::where(['order_id'=> $res['order_id']])->first();

								//package purchased and commission pay function
								$pack = Packages::where("id", $payment_info->package_id)->first();
								$wal = Wallet::where("user_id", $payment_info->user_id)->first();

								$uplinerInfo = Unilevel_tree::leftjoin('users','unilevel_tree.upliner_id','=','users.rec_id')->where('unilevel_tree.down_id',$payment_info->customer_id)->where('users.user_role','!=',4)->select('users.*')->orderBy('unilevel_tree.level','ASC')->first();
								if(!empty($uplinerInfo)){
									$upliner_userId = $uplinerInfo['rec_id'];
									$upliner_user_comm_per = $uplinerInfo['commission_perc'];
								}else{
									$upliner_userId = 0;
									$upliner_user_comm_per = 0;
								}
								$transaction_no = $payment_info->transaction_no;
								$notification_message = "<strong>".date("F jS, Y g:i a")."</strong> Your waiting transaction is successfully transferred <strong>Payment Package ".$pack->package_name."</strong> amount <strong>".$pack->effective_amount."</strong> USD by EVERUSPAY. The Payment ID is ".$data->payment_reference;
								$uparr = array('notification'=>0,'notification_message'=>$notification_message);
								Transactions::where('transaction_no',$transaction_no)->update($uparr);

								$pack_pur_id = self::purchaseCommission($userInfo['user_id'],$uplinerInfo,$pack,$wal,$payment_info->customer_id,$payment_info->package_id,$upliner_userId,$upliner_user_comm_per,$userInfo['first_name'],$userInfo['last_name'],2,$payment_info->customer_id);

								Purchase_order_details::create([
											'user_id' => $payment_info->customer_id,
											'order_id' => $payment_info->order_id,
											'purchased_date' => date('Y-m-d H:i:s'),
											'purchased_from' => 'EVERUSPAY',
											'sender_id' => $payment_info->user_id,
											'status' => 1,
											'package_purchased_id' => $pack_pur_id,
											'type' => $payment_info->subscription_type
										]);

							}else if($data->transaction_status == 'failed'){
								$update_data = array(
									'payment_reference' => trim($data->payment_reference),
									'merchant_id' => trim($data->MerchantId),
									'crypto' => trim(strtoupper($data->payment_mode)),
									'amount_in_usd' => trim($data->amount_currency),
									'amount_in_crypto' => trim($data->amount_crypto),
									'processing_fee' => trim($data->process_fee_crypto),
									'processing_fee_usd' => trim($data->process_fee_currency),
									'transaction_hash' => trim($data->transaction_hash),
									'wallet_address' => trim($data->wallet_address),
									'paid_status' => $data->paid_status,
									'transaction_status' => $data->transaction_status,
									'reason' => $data->reason,
									'response_json' => serialize($data),
									'updated_at' => date('Y-m-d H:i:s')
								);

								PaymentsHistory::where(['order_id'=> $res['order_id']])->update($update_data);

								$payment_info = PaymentsHistory::where(['order_id'=> $res['order_id']])->first();
								$pack = Packages::where("id", $payment_info->package_id)->first();
								$wal = Wallet::where("user_id", $payment_info->user_id)->first();
								$transaction_no = $payment_info->transaction_no;
								$subscription_type = ($payment_info->subscription_type == 1) ? 'New Package' : 'Renewal Package';
								$notification_message = "<strong>".date("F jS, Y g:i a")."</strong> Your payment transfer is failed, <strong>Payment Package ".$pack->package_name."</strong> amount <strong>".$pack->effective_amount."</strong> USD by EVERUSPAY. The Payment ID is ".$request->payment_reference;
								self::user_transactions($transaction_no,$payment_info->package_id,$payment_info->user_id,$payment_info->user_id ,$admin_id, 0, 0, $wal->amount, $subscription_type, $payment_info->subscription_desc, $notification_message);

								$userInfo = User::where(['rec_id' => $res['customer_id']])->first();
								if($res['subscription_type'] == 1 && $userInfo->sub_user == 1){
									Wallet::where('user_id',$userInfo->rec_id)->delete();
									Unilevel_tree::where('down_id',$userInfo->rec_id)->delete();
									Users_tree::where('customer_id',$userInfo->rec_id)->delete();
									Multiple_box_purchase::where('sub_user_id',$userInfo->rec_id)->delete();
									User::where('rec_id',$userInfo->rec_id)->delete();
								}
							}
						}
					}
				}
			}
		}
	}

	public static function curlCall($params,$url,$token){

		$post_url = $url;
		$json_data = json_encode($params);
		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, $post_url);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl_handle, CURLOPT_POST, true);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $json_data);
		curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Authorization: '. $token,
					'Content-Length: ' . strlen($json_data))
					);
		$buffer = curl_exec($curl_handle);
		if($buffer === false)
		{
		    return 'Curl error: ' . curl_error($curl_handle);
		    //return 0;
		}
		curl_close($curl_handle);
		$output = json_decode($buffer);
		return $output;
	}

	public function newbox(Request $request){

		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$data['userInfo'] = $userInfo;
		$package_id = decrypt($request->id);
		$data['sel_package_det'] = DB::table('packages')->where('id', $package_id)->first();

		$data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();
		$data['package_data'] = DB::table('packages')->where('status', 1)->get();

		$data['wallet_balance'] = Wallet::where('user_id', $login_userId)->first();
		$data['default_address'] = Shipping_address::join('country','shipping_address.shipping_country','=','country.countryid')->where('user_id', $login_userId)->where('default_address',1)->select('shipping_address.name','shipping_address.shipping_address','shipping_address.shipping_mobile_no','country.country_name')->first();

		$data['all_address'] = Shipping_address::join('country','shipping_address.shipping_country','=','country.countryid')->where('user_id', $login_userId)->where('default_address',0)->select('shipping_address.name','shipping_address.rec_id','shipping_address.shipping_address','shipping_address.shipping_mobile_no','country.country_name')->get();
		$data['rec_id'] = $request['id'];

		//return view('customer/newbox')->with($data);
		//return view('customer/version2/newbox')->with($data);
		return view('customer/version2/newbox_new')->with($data);
	}

	public function buyOrSubscribeConfirmation(Request $request){

		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$data['userInfo'] = $userInfo;
		$data['package_data'] = DB::table('packages')->where('status', 1)->get();
		$data['wallet_balance'] = Wallet::where('user_id', $login_userId)->first();
		$data['rec_id'] = $request['id'];

		return view('customer/confirmation')->with($data);
	}

	public function addnewAddress(Request $request){
		//echo "<pre>";print_r($request->all());exit();
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];

		$messages = [
			    'name.required' => 'Please provide name',
			    'shipping_address.required' => 'Please provide shipping address',
			    'shipping_country.required' => 'Please select country',
			    'shipping_mobile_no.required' => 'Please provide mobile number',
			    'shipping_mobile_no.regex' => 'Mobile number format is invalid'
			];
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'shipping_address' => 'required',
			'shipping_country' => 'required',
			'shipping_mobile_no' => 'required|regex:/^([0-9]{8,14})$/'
		],$messages);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			return array('status'=>'Failure','message'=>$str);
		} else {

			$country_code = $request->shipping_country_code;

			$mb = $request->shipping_mobile_no;
			$firstCharacter = $mb[0];
			if($firstCharacter == 0){
			    $mbl = ltrim($mb, '0');
			}else{
			    $mbl = $mb;
			}

			$mobile = $country_code . "-" . $mbl;

			if(!empty($request->set_default) && $request->set_default == 1){
				$udata = array(
					'default_address' => 0
				);
				Shipping_address::where('user_id',$login_userId)->update($udata);
				$default_address = 1;
			}else{
				$default_address = 0;
			}
			$shp = Shipping_address::create([
							'name' => $request->name,
							'user_id' => $login_userId,
							'shipping_country' => $request->shipping_country,
							'shipping_mobile_no' => $mobile,
							'shipping_address' => $request->shipping_address,
							'default_address' => $default_address
						]);
			$shipid = $shp->rec_id;
			$country = Country::where('countryid',$request->shipping_country)->first();
			$append_addr = '<div class="bottom-purple-bordered position-relative pb-4 pl-3 mb-3"><input class="form-check-input ml-1 shiping_address_radio" type="radio" name="sel_shipping_address" value='.$shipid.'><p>'.$request->name.'</p>'.$request->shipping_address.'<p>'.$country->country_name.'</p><p>'.$mobile.'</p><div class="form-check mt-4"><input class="form-check-input set_default_addr" type="checkbox" name="set_default_addr" id="set_default_addr" value='.$shipid.'><label class="form-check-label" for="exampleRadios5">Set As Default Address</label></div></div>';

			return array('status'=>'Success','message'=>'New Address Added.','append_addr'=>$append_addr);
		}
	}

	public function saveBuyOrSubscribe(Request $request){
		//echo "<pre>"; print_r($request->all());exit();
		$admin_id = config('constants.ADMIN_ID');
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$data['userInfo'] = $userInfo;

		$validator = Validator::make($request->all(), [
			'package' => 'required',
			'payment_method' => 'required'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			Session::flash('error', '<ul>' . $str . '</ul>');
			Session::flash('alert','Failure');
			return Redirect::back();
		} else {

			$payment_method = $request->payment_method;
			$package_id = Input::get('package');
			$pack = Packages::where("id", $package_id)->first();
			$wal = Wallet::where("user_id", $login_userId)->first();

			$ppcnt = Package_purchase_list::where("user_id", $login_userId)->where("package_id",'!=', 11)->count();
			//print_r($ppcnt);exit();
			if($ppcnt == 0 ){
				$customer_id = $login_userId;
				$type=1;
				$ttype = 'New Package';
				$desc = $pack->effective_amount . ' USD paid for customer package purchase.';
			}else if($package_id == 11){
				$customer_id = $login_userId;
				$type=1;
				$ttype = 'BestBox';
				$desc = $pack->effective_amount . ' USD paid for BestBox purchase.';
			}else if($pack->setupbox_status == 2 ){
				$customer_id = $login_userId;
				$type=2;
				$ttype = 'Renew Package';
				$desc = $pack->effective_amount . ' USD paid for renewal package purchase.';
			}
			else {
				$customer_det = User::where('rec_id',$login_userId)->first();
				$customer_id = self::createSubUser($customer_det);
				$type=1;
				$ttype = 'New Package';
				$desc = $pack->effective_amount . ' USD paid for customer package purchase.';

				Multiple_box_purchase::create([
									'user_id' => $login_userId,
									'sub_user_id' => $customer_id,
									'package_id' => $package_id
								]);
			}

			$uplinerInfo = Unilevel_tree::leftjoin('users','unilevel_tree.upliner_id','=','users.rec_id')->where('unilevel_tree.down_id',$customer_id)->where('users.user_role','!=',4)->select('users.*')->orderBy('unilevel_tree.level','ASC')->first();

			if(!empty($uplinerInfo)){

				$upliner_userId = $uplinerInfo['rec_id'];
				$upliner_user_comm_per = $uplinerInfo['commission_perc'];

				//payment with everuspay
				if($payment_method == 'EVERUSPAY') {

					$refnumber = self::generate_randam_string('ORD', $strength = 9);
					$userdata = User::where('rec_id',$login_userId)->first();

					$transaction_no = self::generate_randam_string('RNID', $strength = 9);
					//insert data into payments history table

					$last_inserted_id = PaymentsHistory::create([
						'user_id' => $login_userId,
						'customer_id' => $customer_id,
						'order_id' => $refnumber,
						'transaction_no' => $transaction_no,
						'package_id' => $package_id,
						'amount_in_usd' => $pack->effective_amount,
						'subscription_type' => $type,
						'subscription
						_desc' => $desc,
						'purchased_from' => 1,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')
					])->id;

					$random_number = self::generate_randam_string('TEL', $strength = 9);

					$userContact = ($userdata->telephone!='') ? $userdata->telephone : $random_number;

					$data = array(
						'MerchantId' => config('constants.EVERUS_MERCHANT_ID'), 'RefNo' =>  $refnumber,'Amount' => $pack->effective_amount, 'Currency' => 'USD','ProdDesc' => $request->package_name.' '.$request->package_desc,'UserName' => $userdata->first_name.' '.$userdata->last_name,'UserEmail' => $userdata->email,'UserContact' => $userContact, 'Remark' => $last_inserted_id,'Lang' => 'UTF-8','TimeZone' => "America/Los_Angeles", 'BrandName' => 'BestBox',
						'CallBackUrl' => url('/').'/everusPayCallback', 'BackendURL' => url('/').'/everusPayCallback'
					);
					$html = '';
					$merchantURL = config('constants.MERCHANT_FORM_URL');
					$html .= '<form  style="display: none"  name="redirectpost" class="redirectpost"  id ="redirectpost" method="post" action="'.$merchantURL.'">';
					foreach($data as $key =>$value){
						if(!is_array($value)){
							$html .= '<input type="hidden" name="'.trim($key).'" value="'.trim($value).'"> ';
						}else if(is_array($value)){
							foreach ($value as $key1 => $value1) {
								$html .= '<input type="hidden" name="' . $key1 . '" value="' . $value1 . '"> ';
							}
						}
					}

					$html .= '<input type="submit" class="final_submit" value="submit" name="submit">';
					$html .= '</form>';
					echo $html;
					echo '<div style="text-align:center;width:100% id="loader" style="display: none"><img src="'.url('/').'/public/images/loader.gif" style="display: block; margin: auto;" /><div style="text-align:center;font-size:30px;font-weight:600;margin: 10px 0px;">Please wait...Redirect to EVERUSPAY Payment Gateway</div><div style="text-align:center;font-size:26px;font-weight:500;margin: 10px 0px;">do not refresh or press back button.</div><div>';
					?>
					<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
					<script type='text/javascript'>
						$("#loader").css('display','block');
						var interval = setInterval(function () {
							$( ".final_submit" ).trigger( "click" );
							return false;
						}, 2000);
					</script>
				<?php
				}else if($payment_method == 'BITPAY') { //payment by bitpay

					//payment with bitpay
					$refnumber = self::generate_randam_string('ORD', $strength = 9);
					$userdata = User::where('rec_id',$login_userId)->first();

					$transaction_no = self::generate_randam_string('RNID', $strength = 9);
					//insert data into payments history table

					$payment_history = PaymentsHistory::create([
						'user_id' => $login_userId,
						'customer_id' => $customer_id,
						'order_id' => $refnumber,
						'transaction_no' => $transaction_no,
						'package_id' => $package_id,
						'amount_in_usd' => $pack->effective_amount,
						'subscription_type' => $type,
						'subscription_desc' => $pack->effective_amount . ' USD paid for customer package purchase.',
						'purchased_from' => 1,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')
					])->id;

					Session::put('order_id',$refnumber);
					$random_number = self::generate_randam_string('TEL', $strength = 9);

					$userContact = ($userdata->telephone!='') ? $userdata->telephone : $random_number;

					$html = '';
					$merchantURL = 'https://bitpay.com/checkout';

					$html .= '<form action="'.$merchantURL.'" method="post" id="bitpay_final_submit">';
						$html .= '<input type="hidden" name="action" value="checkout" />';
						$html .= '<input type="hidden" name="price" value="'.$pack->effective_amount.'" />';
						$html .= '<input type="hidden" name="currency" value="USD" />';
						$html .= '<input type="hidden" name="orderId" value="'.$refnumber.'" />';
						$html .= '<input type="hidden" name="posData" value="'.$transaction_no.'" />';
						$html .= '<input type="hidden" name="itemDesc" value="'.$pack->package_name.' '.$pack->description.'" />'; 
						$html .= '<input type="hidden" name="notificationType" value="json" />';
						$html .= '<input type="hidden" name="data" value="66k52dy+wpnAqon6R1hHUPYwZRFwDJqhhthCClAPpwYsQWYFThllSCpDBnrgQCWlUsQo4aNA2Z2ltzVUPNCgAGnlEO6LQTFbUN1hukNq7Bj8ABKBD93+CMtyra5aU4i6lblRFkT+YYcA/wjBX5ga1oi7mixgL0Hz6udPoyeqIQ2vJSDZjPFGVhzSwB3nI+Lbr50hIZiO4jpuPwV4JT86HRqT6PTaPqLlLdS7HPP2nRtnMOVWwbuhmwbDiYuV0g/29jn/WywwRA+6Ww5Tr0s+HTgUgMUa4p4nseC1SdDsAhJLjezJ2U9721zaI1Ehb7ahl8QQFFzteBKu/Qudqphe9Q3N2JcFRLDX7+I2ESWQGYU=" />';

					// $html .= '<form action="'.$merchantURL.'" method="post" id="bitpay_final_submit">';
					// 	$html .= '<input type="hidden" name="action" value="checkout" />';
					// 	$html .= '<input type="hidden" name="price" value="'.$pack->effective_amount.'" />';
					// 	$html .= '<input type="hidden" name="currency" value="USD" />';
					// 	$html .= '<input type="hidden" name="orderId" value="'.$refnumber.'" />';
					// 	$html .= '<input type="hidden" name="posData" value="'.$transaction_no.'" />';
					// 	$html .= '<input type="hidden" name="itemDesc" value="'.$pack->package_name.' '.$pack->description.'" />'; 
					// 	$html .= '<input type="hidden" name="notificationType" value="json" />';
					// 	$html .= '<input type="hidden" name="data" value="66k52dy+wpnAqon6R1hHUPYwZRFwDJqhhthCClAPpwYsQWYFThllSCpDBnrgQCWlUsQo4aNA2Z2ltzVUPNCgAGnlEO6LQTFbUN1hukNq7Bj8ABKBD93+CMtyra5aU4i6lblRFkT+YYcA/wjBX5ga1oi7mixgL0Hz6udPoyeqIQ2vJSDZjPFGVhzSwB3nI+Lbr50hIZiO4jpuPwV4JT86HRqT6PTaPqLlLdS7HPP2nRtnMOVWwbuhmwbDiYuV0g/29jn/WywwRA+6Ww5Tr0s+HTgUgMUa4p4nseC1SdDsAhJLjezJ2U9721zaI1Ehb7ahl8QQFFzteBKu/Qudqphe9Q3N2JcFRLDX7+I2ESWQGYU=" />';
						
					//$html .= '<input type="image" src="https://test.bitpay.com/cdn/en_US/bp-btn-pay-currencies.svg" name="submit" style="width: 210px" alt="BitPay, the easy way to pay with bitcoins.">';
						// $html .= '<input type="submit" class="bitpay_final_submit" value="submit" name="submit">';
					$html .= '</form>';									
					
					echo $html;
				echo '<div style="text-align:center;width:100% id="loader" style="display: none"><img src="'.url('/').'/public/images/loader.gif" style="display: block; margin: auto;" /><div style="text-align:center;font-size:30px;font-weight:600;margin: 10px 0px;">Please wait...Redirect to BITPAY Payment Gateway</div><div style="text-align:center;font-size:26px;font-weight:500;margin: 10px 0px;">do not refresh or press back button.</div><div>';
					?>
					<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
					<script type='text/javascript'>
						$("#loader").css('display','block');
						var interval = setInterval(function () {
							$( "#bitpay_final_submit" ).submit();
							return false;
						}, 2000);
					</script>
				<?php
				}else{
					if ($pack->effective_amount <= $wal->amount) {

						if($pack->setupbox_status == 1){
							if(!empty($request->sel_shipping_address)){
								$ship_id = $request->sel_shipping_address;
								$shpaddr = Shipping_address::where('rec_id',$ship_id)->first();
							}else{
								$shpaddr = Shipping_address::where('user_id',$login_userId)->where('default_address',1)->first();
							}

							$country = Country::where('countryid',$shpaddr->shipping_country)->first();
							$addr = "<p>".$shpaddr->name."</p>".$shpaddr->shipping_address."<p>".$country->country_name."</p><p>".$shpaddr->shipping_mobile_no."</p>";
						}else{
							$addr = "";
						}
							//payment by reseller/agent wallet
							Wallet::where('user_id', $login_userId)->decrement('amount', $pack->effective_amount);
							//transactions table
							$bal = $wal->amount - $pack->effective_amount;

							$transaction_no = self::generate_randam_string('RNID', $strength = 9);
							$notification_message = "<strong>".date("F jS, Y g:i a")."</strong> You have successfully transferred <strong>Payment Package ".$pack->package_name."</strong> amount <strong>".$pack->effective_amount."</strong> USD by BestBOX Wallet. The Payment ID is ".$transaction_no;
							$transaction_id = self::user_transactions($transaction_no,$package_id,$login_userId,$login_userId ,$admin_id, 0, $pack->effective_amount, $bal, $ttype, $desc, $notification_message);
							//package purchased and commission pay function
							$pack_pur_id = self::purchaseCommission($userInfo['user_id'],$uplinerInfo,$pack,$wal,$customer_id,$package_id,$upliner_userId,$upliner_user_comm_per,$userInfo['first_name'],$userInfo['last_name'],2,$customer_id);
							$order_id = self::generate_randam_string('ORD', $strength = 9);
							Purchase_order_details::create([
										'user_id' => $customer_id,
										'order_id' => $order_id,
										'purchased_date' => date('Y-m-d H:i:s'),
										'purchased_from' => 'Wallet',
										'sender_id' => $login_userId,
										'status' => 1,
										'package_purchased_id' => $pack_pur_id,
										'type' =>$type,
										'shipping_address' => $addr
									]);

							/*Session::flash('message', ' Package Purchased Successfully');
							Session::flash('alert','Success');
							return Redirect::back();*/
							$data1['payment_det'] = array('name'=>$userInfo['first_name'].' '.$userInfo['last_name'],'transaction_id'=>$order_id,'purchased_date'=>date('Y-m-d H:i:s'),'shipping_address'=>$addr,'package_name'=>$pack->package_name,'package_amount'=>$pack->effective_amount);
					        $emailid = array('toemail' => $userInfo['email']);
					        Mail::send(['html'=>'email_templates.payment_receipt'], $data1, function($message) use ($emailid) {
						        $message->to($emailid['toemail'], 'Payment Receipt')->subject
						        ('Payment Receipt');
						        $message->from('noreply@bestbox.net','BestBox');
					        });

							$data['payment_det'] = array('payment_method'=>$payment_method,'payment_id'=>$transaction_no,'duration'=>$pack->duration,'package_name'=>$pack->package_name,'package_amount'=>$pack->effective_amount,'purchased_date'=>date('Y-m-d H:i:s'));
							//return view('customer/payment_status')->with($data);
							return view('customer/version2/payment_status')->with($data);
						} else {
							Session::flash('error', 'Insufficient balance in your wallet');
							Session::flash('alert','Failure');
							return Redirect::back();
						}
				}

			}

		}


	}

	public function getShipAddress(Request $request) {
		$userInfo = Auth::user();
		$user_id = $userInfo['rec_id'];
		$ship_id = $request->ship_id;
		$res = Shipping_address::where('rec_id',$ship_id)->first();
		$country = Country::where('countryid',$res->shipping_country)->first();
		$class = ($userInfo['user_role'] == 4) ? 'white_txt' : 'black_txt';
		$addr = "<h5 class='font16 font-bold ".$class."'>".$res->name."</h5>".$res->shipping_address."<p>".$country->country_name."</p><p>".$res->shipping_mobile_no."</p>";
		return response()->json(['status' => 'Success', 'result' => $addr], 200);
	}

	public function updateDefaultAddress(Request $request) {
		$userInfo = Auth::user();
		$user_id = $userInfo['rec_id'];
		$check_status = $request->check_status;
		$ship_id = $request->ship_id;
		if($check_status == 1){
			$udata = array(
					'default_address' => 0
				);
			Shipping_address::where('user_id',$user_id)->update($udata);
			$udata = array(
						'default_address' => 1
					);
			Shipping_address::where('rec_id',$ship_id)->update($udata);
			$res = "Set As Default Address";
		}else{
			$udata = array(
						'default_address' => 0
					);
			Shipping_address::where('rec_id',$ship_id)->update($udata);
			$res = "Removed As A Default Address";
		}

		return response()->json(['status' => 'Success', 'result' => $res], 200);
	}

	public function renewalSubscription(Request $request){

		if($request->customerId){
			$customerId = decrypt($request->customerId);
		}else{
			$customerId = '';
		}
		$admin_id = config('constants.ADMIN_ID');
		$userInfo = Auth::user();
		$user_id = $userInfo['rec_id'];
		if($userInfo['admin_login'] == 1){
			$login_userId = $admin_id;
		}else{
			$login_userId = $userInfo['rec_id'];
		}

		$data['userInfo'] = $userInfo;
		$data['package_data'] = DB::table('packages')->where('status', 1)->get();
		$data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();
		$data['wallet_balance'] = Wallet::where('user_id', $user_id)->first();
		$res = Unilevel_tree::join('users','unilevel_tree.down_id','=','users.rec_id')->leftjoin('package_purchased_list', 'users.rec_id', '=', 'package_purchased_list.user_id')->where('users.status','=',1)->where('unilevel_tree.upliner_id',$login_userId)->where('unilevel_tree.user_role',4)->select('users.first_name','users.last_name','users.user_id','users.rec_id', DB::raw('MAX(package_purchased_list.expiry_date) AS expiry_date'))->groupBy('unilevel_tree.down_id')->get();

		$customers_data = array();
		$current_date = date("Y-m-d H:i:s");
		$i=1;
		foreach ($res as $key => $value) {

			$packData = Package_purchase_list::leftjoin('packages', 'package_purchased_list.package_id', '=', 'packages.id')->where('package_purchased_list.user_id', $value->rec_id)->where('package_purchased_list.active_package',1)->orderBy('package_purchased_list.rec_id','DESC')->first();

			//$cnt = Purchase_order_details::where('user_id',$value->rec_id)->where('status',2)->count();
			if(empty($packData)){
				continue;
				//$status = 'Not Subscribed';
                //$cls = 'cust_status_expiry';
			}
			else if($packData->id == 11){
				$status = 'Active';
                $cls = 'cust_status_active';
			}
			else if($value->expiry_date < $current_date){
				$status = 'Expired';
                $cls = 'cust_status_expiry';
			}else{
				$status = 'Active';
                $cls = 'cust_status_active';
			}

			$finalarray = '<div class="cust_name"><span>'.$value->first_name." ".$value->last_name.'</span><span> ('.$value->user_id.')</span></div><span class="'.$cls.'">'.$status.'</span><br>';

			$customers_data[] = array(
	                'id'    =>  $value->rec_id,
	                'text'  =>  $value->first_name." ".$value->last_name." (".$value->user_id.")",
	                'html' => $finalarray,
	                'name' => ($customerId == $value->rec_id) ? 'selected' : ''
	            );

				$i++;
		}
		$data['customers_data'] = json_encode($customers_data);
		return view('renewal_subscription')->with($data);
		//return view('customer/version2/renewal_subscription')->with($data);
	}

	public function saveRenewalSubscription(Request $request) {
		//echo "<pre>";print_r($request->all());exit();
		$admin_id = config('constants.ADMIN_ID');
		$userInfo = Auth::user();
		$lguserId = $userInfo['rec_id'];
		$validator = Validator::make($request->all(), [
			'username' => 'required',
			'package' => 'required',
			'payment_method' => 'required'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			Session::flash('error', '<ul>' . $str . '</ul>');
			Session::flash('alert','Failure');
			return Redirect::back();
		} else {
			$customer_id = $request->username;
			$customer_det = User::where('rec_id',$customer_id)->first();
			$package_id = $request->package;
			$pack = Packages::where("id", $package_id)->first();

			if(!empty($pack) && $pack->setupbox_status == 1){
						$validator = Validator::make($request->all(), [
							'shipping_address' => 'required',
							'shipping_country' => 'required',
							'shipping_user_mobile_no' => 'required|regex:/^([0-9]{8,14})$/'
						]);
						if ($validator->fails()) {
							$errs = $validator->messages()->all();
							$str = '';
							foreach ($errs as $arr) {
								$str = $str . '<li>' . $arr . '</li>';
							}
							Session::flash('error', '<ul>' . $str . '</ul>');
							Session::flash('alert','Failure');
							return Redirect::back();
							$status = 0;
						}else{
							$status = 1;
						}
					}else{
						$status = 1;
					}

			if($status == 1){

				$payment_method = $request->payment_method;

				//payment with everuspay
				if($payment_method == 'everuspay') {
					$refnumber = self::generate_randam_string('ORD', $strength = 9);
					$userdata = User::where('rec_id',$lguserId)->first();

					$transaction_no = self::generate_randam_string('RNID', $strength = 9);
					//insert data into payments history table

					$last_inserted_id = PaymentsHistory::create([
						'user_id' => $lguserId,
						'customer_id' => $customer_id,
						'order_id' => $refnumber,
						'transaction_no' => $transaction_no,
						'package_id' => $package_id,
						'amount_in_usd' => $pack->effective_amount,
						'subscription_type' => 2,
						'subscription_desc' => $pack->effective_amount . ' USD paid for renewal package purchase.',
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')
					])->id;

					$random_number = self::generate_randam_string('TEL', $strength = 9);

					$userContact = ($userdata->telephone!='') ? $userdata->telephone : $random_number;

					$data = array(
						'MerchantId' => config('constants.EVERUS_MERCHANT_ID'), 'RefNo' =>  $refnumber,'Amount' => $pack->effective_amount, 'Currency' => 'USD','ProdDesc' => $pack->package_name.' '.$pack->description,'UserName' => $userdata->first_name.' '.$userdata->last_name,'UserEmail' => $userdata->email,'UserContact' => $userContact, 'Remark' => $last_inserted_id,'Lang' => 'UTF-8','TimeZone' => "America/Los_Angeles", 'BrandName' => 'BestBox',
						'CallBackUrl' => url('/').'/everusPayCallback', 'BackendURL' => url('/').'/everusPayCallback'
					);
					$html = '';
					$merchantURL = config('constants.MERCHANT_FORM_URL');
					$html .= '<form  style="display: none"  name="redirectpost" class="redirectpost"  id ="redirectpost" method="post" action="'.$merchantURL.'">';
					foreach($data as $key =>$value){
						if(!is_array($value)){
							$html .= '<input type="hidden" name="'.trim($key).'" value="'.trim($value).'"> ';
						}else if(is_array($value)){
							foreach ($value as $key1 => $value1) {
								$html .= '<input type="hidden" name="' . $key1 . '" value="' . $value1 . '"> ';
							}
						}
					}

					$html .= '<input type="submit" class="final_submit" value="submit" name="submit">';
					$html .= '</form>';
					echo $html;
					echo '<div style="text-align:center;width:100% id="loader" style="display: none"><img src="'.url('/').'/public/images/loader.gif" style="display: block; margin: auto;" /><div style="text-align:center;font-size:30px;font-weight:600;margin: 10px 0px;">Please wait...Redirect to EVERUSPAY Payment Gateway</div><div style="text-align:center;font-size:26px;font-weight:500;margin: 10px 0px;">do not refresh or press back button.</div><div>';
					?>
					<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
					<script type='text/javascript'>
						$("#loader").css('display','block');
						var interval = setInterval(function () {
							$( ".final_submit" ).trigger( "click" );
							return false;
						}, 2000);
					</script>
				<?php } else if($payment_method == 'bitpay' || $payment_method == 'bankpayment'){
						if ($request->hasFile('invoice_attachment')) {
							$image = $request->file('invoice_attachment');
							$fileType = $image->guessExtension();
							$fileTyp = strtolower($fileType);
							$allowedTypes = array("jpeg", "jpg", "png", "pdf");

							if (in_array($fileTyp, $allowedTypes)) {
								// Rename image
								$fileName = 'INV-'.rand(999,9999999).time().'.'.$image->guessExtension();
								$destinationPath = base_path('/public/invoices');
								$upload_success = $image->move($destinationPath, $fileName);

								if ($upload_success){

									$res = self::saveUpdateOrder($lguserId,$fileName,$request->all());

									Session::flash('message', 'Renewal update order has been submitted for approval');
									Session::flash('alert','Success');
									return Redirect::back();
								} else {
									Session::flash('error', 'Something went wrong in Uploading image');
									Session::flash('alert','Failure');
									return Redirect::back();
								}
							} else {
								Session::flash('error', 'Please Upload only JPEG,JPG,PNG or PDF formats only');
								Session::flash('alert','Failure');
								return Redirect::back();
							}
						}else{

							$res = self::saveUpdateOrder($lguserId,'',$request->all());

							Session::flash('message', 'Renewal update order has been submitted for approval');
							Session::flash('alert','Success');
							return Redirect::back();
						}
					}else if($payment_method == 'bitpay') {
					//payment with bitpay
					$refnumber = self::generate_randam_string('ORD', $strength = 9);
					$userdata = User::where('rec_id',$login_userId)->first();

					$transaction_no = self::generate_randam_string('RNID', $strength = 9);
					//insert data into payments history table

					$payment_history = PaymentsHistory::create([
						'user_id' => $login_userId,
						'customer_id' => $customer_id,
						'order_id' => $refnumber,
						'transaction_no' => $transaction_no,
						'package_id' => $package_id,
						'amount_in_usd' => $pack->effective_amount,
						'subscription_type' => $type,
						'subscription_desc' => $pack->effective_amount . ' USD paid for customer package purchase.',
						'purchased_from' => 1,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')
					])->id;

					Session::put('order_id',$refnumber);
					$random_number = self::generate_randam_string('TEL', $strength = 9);

					$userContact = ($userdata->telephone!='') ? $userdata->telephone : $random_number;

					$html = '';
					$merchantURL = 'https://bitpay.com/checkout';

					$html .= '<form action="'.$merchantURL.'" method="post" id="bitpay_final_submit">';
						$html .= '<input type="hidden" name="action" value="checkout" />';
						$html .= '<input type="hidden" name="price" value="'.$pack->effective_amount.'" />';
						$html .= '<input type="hidden" name="currency" value="USD" />';
						$html .= '<input type="hidden" name="orderId" value="'.$refnumber.'" />';
						$html .= '<input type="hidden" name="posData" value="'.$transaction_no.'" />';
						$html .= '<input type="hidden" name="itemDesc" value="'.$pack->package_name.' '.$pack->description.'" />'; 
						$html .= '<input type="hidden" name="notificationType" value="json" />';
						$html .= '<input type="hidden" name="data" value="66k52dy+wpnAqon6R1hHUPYwZRFwDJqhhthCClAPpwYsQWYFThllSCpDBnrgQCWlUsQo4aNA2Z2ltzVUPNCgAGnlEO6LQTFbUN1hukNq7Bj8ABKBD93+CMtyra5aU4i6lblRFkT+YYcA/wjBX5ga1oi7mixgL0Hz6udPoyeqIQ2vJSDZjPFGVhzSwB3nI+Lbr50hIZiO4jpuPwV4JT86HRqT6PTaPqLlLdS7HPP2nRtnMOVWwbuhmwbDiYuV0g/29jn/WywwRA+6Ww5Tr0s+HTgUgMUa4p4nseC1SdDsAhJLjezJ2U9721zaI1Ehb7ahl8QQFFzteBKu/Qudqphe9Q3N2JcFRLDX7+I2ESWQGYU=" />';
						
					//$html .= '<input type="image" src="https://test.bitpay.com/cdn/en_US/bp-btn-pay-currencies.svg" name="submit" style="width: 210px" alt="BitPay, the easy way to pay with bitcoins.">';
						// $html .= '<input type="submit" class="bitpay_final_submit" value="submit" name="submit">';
					$html .= '</form>';									
					
					echo $html;
				
					echo '<div style="text-align:center;width:100% id="loader" style="display: none"><img src="'.url('/').'/public/images/loader.gif" style="display: block; margin: auto;" /><div style="text-align:center;font-size:30px;font-weight:600;margin: 10px 0px;">Please wait...Redirect to BITPAY Payment Gateway</div><div style="text-align:center;font-size:26px;font-weight:500;margin: 10px 0px;">do not refresh or press back button.</div><div>';
					?>
					<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
					<script type='text/javascript'>
						$("#loader").css('display','block');
						var interval = setInterval(function () {
							$( "#bitpay_final_submit" ).submit();
							return false;
						}, 2000);
					</script>
				<?php } else if($payment_method == 'wallet'){
					$wal = Wallet::where("user_id", $lguserId)->first();
					if ($pack->effective_amount <= $wal->amount) {

						Wallet::where('user_id', $lguserId)->decrement('amount', $pack->effective_amount);
						$bal = $wal->amount - $pack->effective_amount;
						$ttype = 'Renewal Package';
						$desc = $pack->effective_amount . ' USD paid for renewal package purchase.';
						$transaction_no = self::generate_randam_string('RNID', $strength = 9);
						$notification_message = "<strong>".date("F jS, Y g:i a")."</strong> You have successfully transferred <strong> Renewal Package ".$pack->package_name."</strong> amount <strong>".$pack->effective_amount."</strong> USD by BestBOX Wallet. The Payment ID is ".$transaction_no;
						$transaction_id = self::user_transactions($transaction_no,$package_id,$lguserId,$lguserId ,$admin_id, 0, $pack->effective_amount, $bal, $ttype, $desc, $notification_message);

						$uplinerInfo = Unilevel_tree::leftjoin('users','unilevel_tree.upliner_id','=','users.rec_id')->where('unilevel_tree.down_id',$customer_id)->where('users.user_role','!=',4)->select('users.*')->orderBy('unilevel_tree.level','ASC')->first();
						if(!empty($uplinerInfo)){
							$upliner_userId = $uplinerInfo['rec_id'];
							$upliner_user_comm_per = $uplinerInfo['commission_perc'];
						}
						$pack_pur_id = self::purchaseCommission($customer_det->user_id,$uplinerInfo,$pack,$wal,$customer_id,$package_id,$upliner_userId,$upliner_user_comm_per,$customer_det->first_name,$customer_det->last_name,2,$lguserId);

						$order_id = self::generate_randam_string('ORD', $strength = 9);
						Purchase_order_details::create([
										'user_id' => $customer_id,
										'order_id' => $order_id,
										'purchased_date' => date('Y-m-d H:i:s'),
										'purchased_from' => 'Wallet',
										'sender_id' => $lguserId,
										'status' => 1,
										'package_purchased_id' => $pack_pur_id,
										'type' =>2
									]);
						Session::flash('message', 'Renewal Package Purchased Successfully');
						Session::flash('alert','Success');
						return Redirect::back();

					}
					else {
						Session::flash('error', 'Insufficient balance in your wallet');
						Session::flash('alert','Failure');
						return Redirect::back();
					}
				}else if($payment_method == 'aliexpress'){

					if ($request->hasFile('invoice_attachment')) {
						$image = $request->file('invoice_attachment');
						$fileType = $image->guessExtension();
						$fileTyp = strtolower($fileType);
						$allowedTypes = array("jpeg", "jpg", "png", "pdf");

						if (in_array($fileTyp, $allowedTypes)) {
							// Rename image
							$fileName = 'INV-'.rand(999,9999999).time().'.'.$image->guessExtension();
							$destinationPath = base_path('/public/invoices');
							$upload_success = $image->move($destinationPath, $fileName);

							if ($upload_success){

								$res = self::saveUpdateOrder($lguserId,$fileName,$request->all());

								Session::flash('message', 'Renewal update order has been submitted for approval');
								Session::flash('alert','Success');
								return Redirect::back();
							} else {
								Session::flash('error', 'Something went wrong in Uploading image');
								Session::flash('alert','Failure');
								return Redirect::back();
							}
						} else {
							Session::flash('error', 'Please Upload only JPEG,JPG,PNG or PDF formats only');
							Session::flash('alert','Failure');
							return Redirect::back();
						}
					}else{

						$res = self::saveUpdateOrder($lguserId,'',$request->all());

						Session::flash('message', 'Renewal update order has been submitted for approval');
						Session::flash('alert','Success');
						return Redirect::back();
					}
				}
			}
		}
	}

	public function freeTrailRequest(Request $request){

		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$cnt = Free_trail_requested_users::where('user_id',$login_userId)->count();
		if($cnt >= 1){
			Session::flash('error', 'Already requested for free trial');
			Session::flash('alert','Failure');
			return Redirect::back();
		}else{
			$data = Free_trail_requested_users::create([
				'user_id' => $login_userId,
				'trail_requested_time' => date('Y-m-d H:i:s'),
				'status' => 3
			]);
			$rec_id = $data->id;
			$settingTime = ApplicationSettings::select('*')->where('id','=',1)->first();
			if(!empty($settingTime)){
				$minimum_time = unserialize($settingTime->setting_value);
				$trial_duration = $minimum_time['trail_duration'];

			}else{
				$trial_duration = 0;
			}

			$res = User::select('*')->where('rec_id','=',$login_userId)->where('user_role','=',4)->where('status','=',1)->first();
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
				/*Mail::send(['html'=>'email_templates.trialAccountActivatedEmail'], $data, function($message) use ($emailid) {
					$message->to($emailid['toemail'], 'Customer ID')->subject('Trial Account Activated');
					$message->from('support@bestbox.net','BestBox');
				});*/

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


				$arr = array("Client_id" => $client_id,"ClientCode" => $clientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Account Information',"user_id" =>$login_userId,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);


				$json_data["trial_alert"] = json_encode($arr);

				if(!empty($res['device_id'])){
					$deviceIds = UsersDevicesList::where('user_id','=', $login_userId)->get();

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
			Session::flash('message', 'Free Trial Request Successfully Completed');
			Session::flash('alert','FreeTrail');
			return Redirect::back();
		}

	}

}

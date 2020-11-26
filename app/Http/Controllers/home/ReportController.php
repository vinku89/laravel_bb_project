<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Http\Controllers\home\AdminController;
use App\Http\Controllers\home\CustomerController;
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
use App\Withdraw_request;
use App\Multiple_box_purchase;
use App\PaymentsHistory;
use App\Models\registerModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Purchase_order_details;
use App\Library\Common;
use \mPDF;
use App\UsersDevicesList;
use App\ApplicationsInfo;
class ReportController extends Controller
{
	public function referralProgram($referralId="")
	{
		if(!empty($referralId)){
			$res = User::where('refferallink_text',$referralId)->first();
			$data['referralId'] = (!empty($res) ? $res->refferallink_text : '');
		}else{
			$data['referralId'] = "";
		}
		return view('auth.customer_signup')->with($data);
	}

	public function saveReferralUser(Request $request)
	{
		$admin_id = config('constants.ADMIN_ID');
		$validator = Validator::make($request->all(), [
			'first_name' => 'required',
			'last_name' => 'required',
            'email' => 'required|email|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$/|unique:users',
            'password' => 'required|regex:/^.*(?=.{8,})(?=.*[a-z])(?=.*[0-9]).*$/|confirmed',
			'password_confirmation' => 'required',
			'referralId' => 'required'
            ]);
		if ($validator->fails()) {
            $errs = $validator->messages()->all();
			$str = '';
			foreach($errs as $arr){
				$str = $str.'<li>'.$arr.'</li>';
            }
            Session::flash('error', '<ul>'.$str.'</ul>');
			Session::flash('alert','Failure');
			return Redirect::back();
        }else{
        	if(!empty($request['referralId'])){
        		$referralId = $request['referralId'];
        	}else{
        		$referralId = 'SUP12345';//super admin
        	}
			$ref_userInfo = User::where('refferallink_text',$referralId)->first();
			if(!empty($ref_userInfo)){
				$referral_userid = $ref_userInfo->rec_id;
	        	$email = $request->email;
	        	$password = $request->password;
				$first_name = $request->first_name;
				$last_name = $request->last_name;

				$userId = AdminController::generateCustomerId($first_name);
				$us_cnt = User::where('user_id', $userId)->count();
		        if($us_cnt == 1){
		            $user_id = AdminController::generateCustomerId($first_name);
		        }else{
		            $user_id = $userId;
		        }
				$ref_code = AdminController::generateReferralCode($first_name);
				$ref_cnt = User::where('refferallink_text', $ref_code)->count();
		        if($ref_cnt == 1){
		            $referral_code = AdminController::generateReferralCode($first_name);
		        }else{
		            $referral_code = $ref_code;
		        }
		        $encrypted_plain_pass=safe_encrypt($password,config('constants.encrypt_key'));
		        $password = \Hash::make($password);
				$user= User::create([
					'user_id' => $user_id,
					'referral_userid' => $referral_userid,
					'first_name' => $first_name,
					'last_name' => $last_name,
					'email' => $email,
					'password' => $password,
					'plain_password'=>$encrypted_plain_pass,
					'refferallink_text' => $referral_code,
		            'user_role' => 4,
		            //'status' => 1,
		            'registration_date' =>date('Y-m-d H:i:s'),
		            'referral_join' => 1,
		            'application_id' => 1234,
		            'email_verify' => 1,
		            'status' => 1
				]);
				$last_inserted_id = $user->rec_id;
				User::where(['rec_id'=>$last_inserted_id])->update(array('created_by'=>$last_inserted_id));
				// added 0 points joining bonus for customers
				$wallet= Wallet::create([
					'user_id' => $last_inserted_id,
		  		    'amount' => 0
				]);

				if($ref_userInfo->user_role == 2){
					Users_tree::create([
						'customer_id' => $last_inserted_id,
						'reseller_id' => $referral_userid
					]);
				}else if($ref_userInfo->user_role == 3){
					$res = Users_tree::where("agent_id", $referral_userid)->where("reseller_id", "!=", 0)->first();
					Users_tree::create([
						'customer_id' => $last_inserted_id,
						'agent_id' => $referral_userid,
						'reseller_id' => (!empty($res) ? $res->reseller_id : 0)
					]);
				}else if($ref_userInfo->user_role == 4){
					$res = Users_tree::where("customer_id", $referral_userid)->first();
					Users_tree::create([
						'customer_id' => $last_inserted_id,
						'agent_id' => (!empty($res) ? $res->agent_id : 0),
						'reseller_id' => (!empty($res) ? $res->reseller_id : 0)
					]);
				}else{
					Users_tree::create([
						'customer_id' => $last_inserted_id,
						'admin_id' => $admin_id
					]);
				}

				$l=1;
				$nom=$referral_userid;
				$user_role=4;
				while($nom!=999){
					if($nom!=999 && $l < 150){
						Unilevel_tree::create([
							'down_id' => $last_inserted_id,
				            'upliner_id' => $nom,
				            'level' => $l,
				            'user_role' => $user_role
						]);
						$l++;
						$results = User::where('rec_id', $nom)->select('referral_userid')->first();
						$nom=$results->referral_userid;
					}
				}

				// insert joining bonus transaction table
				//$transaction_no = self::generate_randam_string('JGB', $strength = 9);
				// $admin_id = config('constants.ADMIN_ID');
				// $ttype = "Joining Bonus";
				// $description = "10.00 USD Credited for Joining Bonus";
	   //      	CustomerController::user_transactions($transaction_no,'',$last_inserted_id,$admin_id,$last_inserted_id, 10,0, 10, $ttype, $description);


				$data['useremail'] = array('name'=>$first_name.' '.$last_name,'customer_id'=>$user_id,'user_id'=>$last_inserted_id,'toemail'=>$email,'referral_link'=>$referral_code,'application_id'=>1234,'password'=>$request->password);
		        $emailid = array('toemail' => $email);
		        Mail::send(['html'=>'email_templates.referral-join'], $data, function($message) use ($emailid) {
			        $message->to($emailid['toemail'], 'Bestbox Signup Confirmation')->subject
			        ('Bestbox Confirmation');
			        $message->from('noreply@bestbox.net','BestBox');
		        });

		        Session::flash('message', 'Registration successful. Please check your email for Referral Code.');
				Session::flash('alert','Success');
				return Redirect::back();

			}else{
				Session::flash('error', 'Referral User Id Not Valid.');
				Session::flash('alert','Failure');
				return Redirect::back();
			}
        }
	}

	public function transactions(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];
		$data['test'] = array();

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

			$data['commissionReports'] = Transactions::leftjoin('users AS sender','transactions.sender_id','=','sender.rec_id')->leftjoin('users AS receiver','transactions.receiver_id','=','receiver.rec_id')->leftjoin('packages AS p','p.id','=','transactions.package_id')->select('transactions.rec_id','transactions.transaction_no','transactions.received_date','transactions.ttype','transactions.status','transactions.credit','transactions.debit','transactions.balance','transactions.description','sender.user_id AS sender','receiver.user_id AS receiver',DB::raw("CONCAT(sender.first_name,' ',sender.last_name) AS sender_name"),DB::raw("CONCAT(receiver.first_name,' ',receiver.last_name) AS receiver_name"),'sender.email AS sender_email','receiver.email AS receiver_email','transactions.user_id','transactions.sender_id','transactions.receiver_id','p.package_name','p.effective_amount')->where('transactions.user_id', $userId)->whereBetween('transactions.received_date', [$start, $to])->orderBy('transactions.rec_id', 'DESC')->paginate(100);
		}else{
			$data['commissionReports'] = Transactions::leftjoin('users AS sender','transactions.sender_id','=','sender.rec_id')->leftjoin('users AS receiver','transactions.receiver_id','=','receiver.rec_id')->leftjoin('packages AS p','p.id','=','transactions.package_id')->select('transactions.rec_id','transactions.transaction_no','transactions.received_date','transactions.ttype','transactions.status','transactions.credit','transactions.debit','transactions.balance','transactions.description','sender.user_id AS sender','receiver.user_id AS receiver',DB::raw("CONCAT(sender.first_name,' ',sender.last_name) AS sender_name"),DB::raw("CONCAT(receiver.first_name,' ',receiver.last_name) AS receiver_name"),'sender.email AS sender_email','receiver.email AS receiver_email','transactions.user_id','transactions.sender_id','transactions.receiver_id','p.package_name','p.effective_amount')->where('transactions.user_id', $userId)->orderBy('transactions.rec_id', 'DESC')->paginate(100);
		}

		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;

		if($userRole == 4){
			//return view('customer/customer-transactions')->with($data);
			return view('customer/version2/customer-transactions')->with($data);
		}else{
			return view('transactions')->with($data);
		}

	}

	public static function convertTimezone($request_date){

		$timezone = Session::get('timezone');
		if($timezone) {
	        $tz = new DateTimeZone($timezone);
	    } else{
	    	$tz = new DateTimeZone('Atlantic/Reykjavik');
	    }

		$date = new DateTime($request_date);
		$date->setTimezone($tz);
		return $date->format('d/m/Y, h:i a');
	}

	public static function convertTimezoneDate($request_date){

		$timezone = Session::get('timezone');
		if($timezone) {
	        $tz = new DateTimeZone($timezone);
	    } else{
	    	$tz = new DateTimeZone('Atlantic/Reykjavik');
	    }

		$date = new DateTime($request_date);
		$date->setTimezone($tz);
		return $date->format('d/m/Y');
	}

	public static function convertTimezoneTime($request_date){

		$timezone = Session::get('timezone');
		if($timezone) {
	        $tz = new DateTimeZone($timezone);
	    } else{
	    	$tz = new DateTimeZone('Atlantic/Reykjavik');
	    }

		$date = new DateTime($request_date);
		$date->setTimezone($tz);
		return $date->format('h:i a');
	}

	public function transferToCryptoWallet()
	{

		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];

		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;
		$data['customers_data'] = User::where('status','=',1)->where('rec_id','!=',$userId)->select('first_name','last_name','email','rec_id','user_id')->get();

			$ddData = array();
			if(!empty($userInfo['true_address'])){
				array_push($ddData, array(
					"text"=> "My Trullion Wallet",
					"value"=> "true",
					"selected"=> "true",
					"description"=> $userInfo['true_address'],
					"imageSrc"=> url('/public/')."/images/trullion.png"
				));
			}
			if(!empty($userInfo['evr_address'])){
				array_push($ddData, array(
					"text"=> "My Everus Wallet",
					"value"=> "evr",
					"selected"=> "false",
					"description"=> $userInfo['evr_address'],
					"imageSrc"=> url('/public/')."/images/evr.png"
				));
			}
			if(!empty($userInfo['btc_address'])){
				array_push($ddData, array(
					"text"=> "My Bitcoin Wallet",
					"value"=> "btc",
					"selected"=> "false",
					"description"=> $userInfo['btc_address'],
					"imageSrc"=> url('/public/')."/images/btc.png"
				));
			}
			if(!empty($userInfo['eth_address'])){
				array_push($ddData, array(
					"text"=> "My Ethereum Wallet",
					"value"=> "eth",
					"selected"=> "false",
					"description"=> $userInfo['eth_address'],
					"imageSrc"=> url('/public/')."/images/eth.png"
				));
			}
			$data['ddData'] = json_encode($ddData);

			return view('transferToCryptoWallet')->with($data);

	}

	public function withdrawal()
	{

		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];

		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;
		$data['customers_data'] = User::where('status','=',1)->where('rec_id','!=',$userId)->select('first_name','last_name','email','rec_id','user_id')->get();
		if($userRole == 4){
			//return view('customer/customer-withdrawal')->with($data);
			return view('customer/version2/customer-withdrawal')->with($data);
		}else{
			return view('withdrawal')->with($data);
		}

	}

	public function saveWithdrawal(Request $request){
		$admin_id = config('constants.ADMIN_ID');
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];

		$validator = Validator::make($request->all(), [
            'withdraw_amt' => 'required',
			'walletType' => 'required'
            ]);
		if ($validator->fails()) {
            $errs = $validator->messages()->all();
			$str = '';
			foreach($errs as $arr){
				$str = $str.'<li>'.$arr.'</li>';
            }
            Session::flash('error', '<ul>' . $str . '</ul>');
			Session::flash('alert','Failure');
			return Redirect::back();
        }else{
        	$withdraw_type = Input::get('walletType');
        	$walletName = Input::get('walletName');
        	$withdraw_amt = Input::get('withdraw_amt');
        	if(!empty($withdraw_amt) && $withdraw_amt >= 1){
        		$wal = Wallet::where("user_id", $login_userId)->first();
        		if ($withdraw_amt <= $wal->amount) {

	        		if($withdraw_type == 5){
	        		//transfer to agent/reseller
		        		$username = Input::get('username');
		        		if(!empty($username)){
		        			$receiver_det = User::where('rec_id',$username)->first();
		        			if(!empty($receiver_det)){

	        					Wallet::where('user_id', $login_userId)->decrement('amount', $withdraw_amt);
	        					//transactions table
								$bal = $wal->amount - $withdraw_amt;

								$transaction_no = self::generate_randam_string('WID', $strength = 9);
	        					CustomerController::user_transactions($transaction_no,'',$login_userId,$login_userId ,$receiver_det->rec_id, 0, $withdraw_amt, $bal, 'Transfer Amount', number_format($withdraw_amt,2) . ' USD transferred to '.$receiver_det->first_name." ".$receiver_det->last_name);

	        					//transactions table
	        					$wb = Wallet::where("user_id", $receiver_det->rec_id)->first();
								$balance = $wb->amount + $withdraw_amt;

								$transaction_no = self::generate_randam_string('WID', $strength = 9);
	        					CustomerController::user_transactions($transaction_no,'',$receiver_det->rec_id,$login_userId ,$receiver_det->rec_id, $withdraw_amt,0, $balance, 'Received Amount', number_format($withdraw_amt,2) . ' USD transferred from '.$userInfo['first_name']." ".$userInfo['last_name']);
	        					Wallet::where('user_id', $receiver_det->rec_id)->increment('amount', $withdraw_amt);
	        					// withdraw(wallet to wallet ) FCM to sender
									Common::senderWithdrawalFCM($userInfo,$withdraw_amt,"sender",$receiver_det,'BESTBOX');
								// withdraw (wallet to wallet) FCM to Receiver
									Common::senderWithdrawalFCM($userInfo,$withdraw_amt,"receiver",$receiver_det,'BESTBOX');
	        					//return Redirect::back()->withErrors(['Successfully Transferred.'])->withInput();
								Session::flash('message', 'Withdrawan successfully.');
								Session::flash('alert','Success');
								return Redirect::back();
		        			}else{
		        				//return Redirect::back()->withErrors(['Reseller/Agent Name Not Valid.']);
								Session::flash('error', 'User Name Not Valid.');
								Session::flash('alert','Failure');
								return Redirect::back();
		        			}
		        		}else{
		        			//return Redirect::back()->withErrors(['Please provide Reseller/Agent Name.']);
							Session::flash('error', 'Please provide User Name.');
							Session::flash('alert','Failure');
							return Redirect::back();
		        		}
		        	}else{
						$transaction_no = self::generate_randam_string('WID', $strength = 9);

						Wallet::where('user_id', $login_userId)->decrement('amount', $withdraw_amt);
    					//transactions table
						$bal = $wal->amount - $withdraw_amt;

						$transac_id = CustomerController::user_transactions($transaction_no,'',$login_userId,$login_userId ,$admin_id, 0, $withdraw_amt, $bal, 'Transfer To Crypto Wallet', number_format($withdraw_amt,2).' USD transfer requested to '.$walletName);

		        		Withdraw_request::create([
		        			'transaction_no' => $transaction_no,
		        			'withdraw_id' => $transac_id,
		        			'user_id' => $login_userId,
							'request_amt' => $withdraw_amt,
							'request_date' => NOW(),
							'wallet_type' => $withdraw_type,
							'wallet_address' => $userInfo[$withdraw_type."_address"],
							'status' => 1
		        		]);
		        		//return Redirect::back()->withErrors(['Withdraw Request Successfully, Admin Will Transfer Your Crypto Amount Soon.']);
		        		// send FCM Crypto Wallet
						Common::sendFCMWithdrawnCrypto($userInfo,$withdraw_amt,$walletName,'BESTBOX');

						Session::flash('message', 'Request has been sent Successfully, Admin Will Transfer To Your Crypto Wallet Soon.');
						Session::flash('alert','Success');
						return Redirect::back();

		        	}
	        	}else{
					//return Redirect::back()->withErrors(['Insufficient balance in your wallet'])->withInput();
					Session::flash('error', 'Insufficient balance in your wallet');
					Session::flash('alert','Failure');
					return Redirect::back();
				}
	        }else{
        			//return Redirect::back()->withErrors(['Withdrawal amount should be greater than zero.']);
					Session::flash('error', 'Amount should be greater than or equal 1 USD.');
					Session::flash('alert','Failure');
					return Redirect::back();
        		}
        }
	}

	public function amountTransferToWallet()
	{

		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];

		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;
		$data['customers_data'] = User::where('status','=',1)->where('rec_id','!=',$userId)->select('first_name','last_name','email','rec_id','user_id')->get();

		return view('transferToWallet')->with($data);
	}

	public function saveTransferToWallet(Request $request){

		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];

		$validator = Validator::make($request->all(), [
            'username' => 'required',
			'transfer_amount' => 'required'
            ]);
		if ($validator->fails()) {
            $errs = $validator->messages()->all();
			$str = '';
			foreach($errs as $arr){
				$str = $str.'<li>'.$arr.'</li>';
            }
            Session::flash('error', '<ul>' . $str . '</ul>');
			Session::flash('alert','Failure');
			return Redirect::back();
        }else{
        		//transfer to agent/reseller
        		$transfer_amount = Input::get('transfer_amount');
        		if(!empty($transfer_amount) || $transfer_amount > 0){

	        		$username = Input::get('username');
	        		if(!empty($username)){
	        			$receiver_det = User::where('rec_id',$username)->first();
	        			if(!empty($receiver_det)){
	        				$wal = Wallet::where("user_id", $login_userId)->first();
	        				if ($transfer_amount <= $wal->amount) {

	        					Wallet::where('user_id', $login_userId)->decrement('amount', $transfer_amount);
	        					//transactions table
								$bal = $wal->amount - $transfer_amount;

								$transaction_no = self::generate_randam_string('TID', $strength = 9);
	        					CustomerController::user_transactions($transaction_no,'',$login_userId,$login_userId ,$receiver_det->rec_id, 0, $transfer_amount, $bal, 'Transferred To Wallet', $transfer_amount . ' USD transferred to '.$receiver_det->first_name." ".$receiver_det->last_name);

	        					//transactions table
	        					$wb = Wallet::where("user_id", $receiver_det->rec_id)->first();
								$balance = $wb->amount + $transfer_amount;

								$transaction_no = self::generate_randam_string('TID', $strength = 9);
	        					CustomerController::user_transactions($transaction_no,'',$receiver_det->rec_id,$login_userId ,$receiver_det->rec_id, $transfer_amount,0, $balance, 'Transferred From Admin', $transfer_amount . ' USD transferred from Admin');
	        					Wallet::where('user_id', $receiver_det->rec_id)->increment('amount', $transfer_amount);

								// send FCM to Receiver
								$logged_user_info = $userInfo;
								$withdraw_amt = $transfer_amount;
								if(!empty($receiver_det->application_id)){
									$app_name = $receiver_det->application_id;
								}else{
									$app_name = 1234;
								}

								Common::senderWithdrawalFCM($logged_user_info,$withdraw_amt,"receiver",$receiver_det,$app_name);

								Session::flash('message', 'Successfully Transferred');
								Session::flash('alert','Success');
								return Redirect::back();

	        				}else{
	        					Session::flash('error', 'Insufficient balance in your wallet');
								Session::flash('alert','Failure');
								return Redirect::back();
	        				}
	        			}else{
	        				Session::flash('error', 'User Name not valid');
							Session::flash('alert','Failure');
							return Redirect::back();
	        			}
	        		}else{
	        			Session::flash('error', 'Please Provide User Name');
						Session::flash('alert','Failure');
						return Redirect::back();
	        		}
        		}else{
        			Session::flash('error', 'Transfer amount should be greater than zero.');
					Session::flash('alert','Failure');
					return Redirect::back();
        		}
        }
	}

	public function withdrawRequestedList(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$data['from_date'] = $request->query('from_date');
		$data['to_date'] = $request->query('to_date');
		//$data['user_role'] = $user_role;
		if (!empty($request->query('from_date')) && !empty($request->query('to_date'))) {
			$from_date = $request->query('from_date');
			$to_date = $request->query('to_date');
			$from_date = Carbon::createFromFormat('m-d-Y', $from_date)->format('Y-m-d');
			$to_date = Carbon::createFromFormat('m-d-Y', $to_date)->format('Y-m-d');
			$start = Carbon::parse($from_date)->format('Y-m-d H:i:s');
			$todate = Carbon::parse($to_date)->format('Y-m-d H:i:s');
			$to = date('Y-m-d H:i:s', strtotime($todate . ' +1 day'));

			$data['request_list'] = Withdraw_request::join('users','users.rec_id','=','withdraw_request.user_id')->whereBetween('withdraw_request.request_date', [$start, $to])->select('users.first_name','users.last_name','users.user_id','users.email','withdraw_request.rec_id','withdraw_request.request_amt','withdraw_request.request_date','withdraw_request.wallet_type','withdraw_request.wallet_address','withdraw_request.status')->orderBy('withdraw_request.request_date','DESC')->paginate(50);
		}else{
			$data['request_list'] = Withdraw_request::join('users','users.rec_id','=','withdraw_request.user_id')->select('users.first_name','users.last_name','users.user_id','users.email','withdraw_request.rec_id','withdraw_request.request_amt','withdraw_request.request_date','withdraw_request.wallet_type','withdraw_request.wallet_address','withdraw_request.status')->orderBy('withdraw_request.request_date','DESC')->paginate(50);
		}
		return view('withdraw_requested_list')->with($data);
	}

	public function updateWithdrawPaymentRequest(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$credit_crypto_amt = $request->credit_crypto_amt;
		$transaction_hash = $request->transaction_hash;
		$id = $request->id;
		$res = Withdraw_request::where(['rec_id'=>$id])->first();
		$receiver_info = User::where('rec_id',$res->user_id)->first();
		$data = array('credit_crypto_amt' => $credit_crypto_amt,'transaction_hash' => $transaction_hash, 'status' => 2, 'admin_response_date' => NOW(),'approved_by' => $userId);
		Withdraw_request::where(['rec_id'=>$id])->update($data);

		Common::adminApprovedCryptoFCM($receiver_info,$res->request_amt,$res->wallet_type,$credit_crypto_amt);

		return response()->json(['status' => 'Success', 'Result' => 'Updated Successfully'], 200);
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

	public function payForMyFriend(Request $request){
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
		//echo "<pre>";
		//print($res);exit();
		$customers_data = array();
		$current_date = date("Y-m-d H:i:s");
		$i=1;
		foreach ($res as $key => $value) {

			$packData = Package_purchase_list::leftjoin('packages', 'package_purchased_list.package_id', '=', 'packages.id')->where('package_purchased_list.user_id', $value->rec_id)->where('package_purchased_list.active_package',1)->orderBy('package_purchased_list.rec_id','DESC')->first();

			//$cnt = Purchase_order_details::where('user_id',$value->rec_id)->where('status',2)->count();
			if(empty($packData)){
				$status = 'Not Subscribed';
                $cls = 'cust_status_expiry';
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
		if($userInfo['user_role'] == 4){
			//return view('customer/version2/pay_for_friend')->with($data);
			return view('customer/version2/pay_for_friend_new')->with($data);
		}else{
			return view('pay_for_friend')->with($data);
		}

	}

	public function savePayForMyFriend(Request $request){

		$userInfo = Auth::user();
		$lguserId = $userInfo['rec_id'];
		$admin_id = config('constants.ADMIN_ID');
		if($userInfo['admin_login'] == 1){
			$login_userId = $admin_id;
			$login_userInfo = User::where('rec_id',$admin_id)->first();
		}else{
			$login_userId = $userInfo['rec_id'];
			$login_userInfo = $userInfo;
		}

		$messages = [
			    'username.required' => 'Please select customer name.',
			    'package.required' => 'Please select package.'
			];
		$validator = Validator::make($request->all(), [
			'username' => 'required',
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

			$customer_id = Input::get('username');
			$customer_det = User::where('rec_id',$customer_id)->first();
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
					Session::flash('error', '<ul>' . $str . '</ul>');
					Session::flash('alert','Failure');
					return Redirect::back();
					$status = 0;
				}else{
					$status = 1;
				}
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
				$country = Country::where('countryid',$country_id)->first();
				$addr = "<p>".$customer_det->first_name.''.$customer_det->last_name."</p>".$address."<p>".$country->country_name."</p><p>".$mobile."</p>";
			}else{
				$status = 1;
				$addr = "";
			}
			
			if($status == 1){

				$subscription_type = Input::get('subscription_type');
				$subs_type = Input::get('subs_type');
				$ppcnt = Package_purchase_list::where("user_id", $customer_det->rec_id)->where("package_id",'!=', 11)->count();

				if($ppcnt == 0){
					$customer_id = $customer_det->rec_id;
					$type=1;
					$desc = $pack->effective_amount . ' USD paid for customer package purchase.';
				}
				else if($package_id == 11 ){
					$customer_id = $customer_det->rec_id;
					// $customer_id = CustomerController::createSubUser($customer_det);
					// Multiple_box_purchase::create([
			        // 	'user_id' => $customer_det->rec_id,
			        // 	'sub_user_id' => $customer_id,
			        // 	'package_id' => $package_id
			        // ]);
					$type=1;
					$desc = $pack->effective_amount . ' USD paid for BestBox purchase.';
				}
				else if($subscription_type == 'New' && $subs_type == 2){
					//multiple box
					$customer_id = CustomerController::createSubUser($customer_det);
					Multiple_box_purchase::create([
			        	'user_id' => $customer_det->rec_id,
			        	'sub_user_id' => $customer_id,
			        	'package_id' => $package_id
			        ]);
			        $type=1;
			        $desc = $pack->effective_amount . ' USD paid for customer package purchase.';
				}else{
					$customer_id = $customer_det->rec_id;
					$type=2;
					$desc = $pack->effective_amount . ' USD paid for renewal package purchase.';
				}

				if($login_userInfo['user_role'] == 4){
					$uplinerInfo = Unilevel_tree::leftjoin('users','unilevel_tree.upliner_id','=','users.rec_id')->where('unilevel_tree.down_id',$login_userId)->where('users.user_role','!=',4)->select('users.*')->orderBy('unilevel_tree.level','ASC')->first();
					if(!empty($uplinerInfo)){
						$upliner_userId = $uplinerInfo['rec_id'];
						$upliner_user_comm_per = $uplinerInfo['commission_perc'];
					}
				}else{
					$uplinerInfo = Unilevel_tree::leftjoin('users','unilevel_tree.upliner_id','=','users.rec_id')->where('unilevel_tree.down_id',$customer_id)->where('users.user_role','!=',4)->select('users.*')->orderBy('unilevel_tree.level','ASC')->first();
					if(!empty($uplinerInfo)){
						$upliner_userId = $uplinerInfo['rec_id'];
						$upliner_user_comm_per = $uplinerInfo['commission_perc'];
					}
				}

				$pay = Input::get('pay');

				if(!empty($pay) && $pay == 'EVERUSPAY'){
				//payment with everuspay
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
			<?php }else if(!empty($pay) && $pay == 'BITPAY'){
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
						'shipping_address' => $addr,
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
			<?php }
			 else if (!empty($pay) && $pay == 'WALLET') {

			 		$wal = Wallet::where("user_id", $login_userId)->first();
					$ddwal = Wallet::where("user_id", $lguserId)->first();
					if ($pack->effective_amount <= $ddwal->amount) {

						//payment by reseller/agent wallet
						Wallet::where('user_id', $lguserId)->decrement('amount', $pack->effective_amount);
						//transactions table
						$bal = $ddwal->amount - $pack->effective_amount;

						$transaction_no = self::generate_randam_string('PID', $strength = 9);
						$notification_message = "<strong>".date("F jS, Y g:i a")."</strong> You have successfully transferred <strong>Pay For My Friend Package ".$pack->package_name."</strong> amount <strong>".$pack->effective_amount."</strong> USD by BestBOX Wallet. The Payment ID is ".$transaction_no;
						CustomerController::user_transactions($transaction_no,$package_id,$lguserId,$lguserId ,$customer_id, 0, $pack->effective_amount, $bal, 'Pay For My Friend', $desc, $notification_message);

						//package purchased and commission pay function
						$pack_pur_id = CustomerController::purchaseCommission($customer_det->user_id,$uplinerInfo,$pack,$wal,$customer_id,$package_id,$upliner_userId,$upliner_user_comm_per,$customer_det->first_name,$customer_det->last_name,2,$lguserId);

						$order_id = CustomerController::generate_randam_string('ORD', $strength = 9);
						Purchase_order_details::create([
									'user_id' => $customer_id,
									'order_id' => $order_id,
									'purchased_date' => date('Y-m-d H:i:s'),
									'purchased_from' => 'Wallet',
									'sender_id' => $lguserId,
                                    'status' => 1,
                                    'amount' => $pack->effective_amount,
									'package_purchased_id' => $pack_pur_id,
									'type' => $type,
									'shipping_address' => $addr
								]);

						// send FCM to sender
							Common::payForMyFriendFCM($login_userInfo,$pack->package_name,$pack->effective_amount,$transaction_no,"sender",$customer_det,'BESTBOX');
						if($type == 1){
							// send FCM to Receiver
							Common::packagePurchasedFCMToReceiver($login_userInfo,$pack->package_name,$pack->effective_amount,$transaction_no,"receiver",$customer_det,'BESTBOX');
						}else{
							// send FCM to Receiver
							//Common::packageRenewalFCM($userInfo,$pack->package_name,$pack->effective_amount,$transaction_no,"receiver",$customer_det);
						}

						Session::flash('message', 'Successfully paid for friend');
						Session::flash('alert','Success');
						return redirect('payForMyFriend');

					} else {
						Session::flash('error', 'Insufficient balance in your wallet');
						Session::flash('alert','Failure');
						return Redirect::back();
					}
			 }

			}else{
				Session::flash('error', 'Failure');
				Session::flash('alert','Failure');
				return back()->withInput();
			}

		}

	}

	public function notifications(Request $request){

		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
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

			//$data['transactions'] = Transactions::where('user_id',$login_userId)->whereBetween('received_date', [$start, $todate])->orderBy('created_at','desc')->paginate(10);
			$data['transactions'] = Transactions::leftjoin('users AS sender','transactions.sender_id','=','sender.rec_id')->leftjoin('users AS receiver','transactions.receiver_id','=','receiver.rec_id')->leftjoin('packages AS p','p.id','=','transactions.package_id')->select('transactions.rec_id','transactions.transaction_no','transactions.received_date','transactions.ttype','transactions.status','transactions.credit','transactions.debit','transactions.balance','transactions.description','sender.user_id AS sender','receiver.user_id AS receiver',DB::raw("CONCAT(sender.first_name,' ',sender.last_name) AS sender_name"),DB::raw("CONCAT(receiver.first_name,' ',receiver.last_name) AS receiver_name"),'sender.email AS sender_email','receiver.email AS receiver_email','transactions.user_id','transactions.sender_id','transactions.receiver_id','p.package_name','p.effective_amount')->where('transactions.user_id', $login_userId)->whereBetween('transactions.received_date', [$start, $to])->orderBy('transactions.rec_id', 'DESC')->paginate(100);

		}else{
			//$data['transactions'] = Transactions::where('user_id',$login_userId)->orderBy('created_at','desc')->paginate(10);

			$data['transactions'] = Transactions::leftjoin('users AS sender','transactions.sender_id','=','sender.rec_id')->leftjoin('users AS receiver','transactions.receiver_id','=','receiver.rec_id')->leftjoin('packages AS p','p.id','=','transactions.package_id')->select('transactions.rec_id','transactions.transaction_no','transactions.received_date','transactions.ttype','transactions.status','transactions.credit','transactions.debit','transactions.balance','transactions.description','sender.user_id AS sender','receiver.user_id AS receiver',DB::raw("CONCAT(sender.first_name,' ',sender.last_name) AS sender_name"),DB::raw("CONCAT(receiver.first_name,' ',receiver.last_name) AS receiver_name"),'sender.email AS sender_email','receiver.email AS receiver_email','transactions.user_id','transactions.sender_id','transactions.receiver_id','p.package_name','p.effective_amount')->where('transactions.user_id', $login_userId)->orderBy('transactions.rec_id', 'DESC')->paginate(100);
		}
		$data['userInfo'] = $userInfo;
//return view('notifications')->with($data);exit;
		if($userInfo['user_role'] == 4) {
			return view('customer/version2/notifications')->with($data);
		}else{
			return view('notifications')->with($data);
		}

	}

	public function notificationStatusUpdate(){

		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		Transactions::where('user_id',$login_userId)->update(array('notification'=>1));
		return response()->json(['status' => 'Success', 'Result' => ''], 200);
	}

	public function announcements(Request $request){

		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
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

			//$data['transactions'] = Transactions::where('user_id',$login_userId)->whereBetween('received_date', [$start, $todate])->orderBy('created_at','desc')->paginate(10);
			$data['announcements_data'] = \App\Announcements::where(['announcement_type' => 2])->whereBetween('announcements.created_at', [$start, $to])->orderBy('announcements.id', 'DESC')->paginate(100);

		}else{
			//$data['transactions'] = Transactions::where('user_id',$login_userId)->orderBy('created_at','desc')->paginate(10);

			$data['announcements_data'] = \App\Announcements::where(['announcement_type' => 2])->orderBy('announcements.id', 'DESC')->paginate(100);
		}
		$data['userInfo'] = $userInfo;
		return view('customer/version2/announcements')->with($data);
	}

	public function checkPackagePurchase(Request $request)
	{
		$cnt = Package_purchase_list::where('user_id',$request->id)->count();
		$res = User::where('rec_id',$request->id)->select('rec_id','first_name','last_name','email','user_id','sub_user')->first();
		if($cnt >= 1){
			return response()->json(['status' => 'Success', 'sub_user' => (isset($res->sub_user) && !empty($res->sub_user)) ? $res->sub_user : '','first_name' => $res->first_name,'last_name' => $res->last_name,'email' => $res->email, 'Result' => ''], 200);
		}else{
			return response()->json(['status' => 'Failure', 'sub_user' => (isset($res->sub_user) && !empty($res->sub_user)) ? $res->sub_user : '','first_name' => $res->first_name,'last_name' => $res->last_name,'email' => $res->email, 'Result' => ''], 200);
		}
	}

	public function packagePurchasedList(){

		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$data['userInfo'] = $userInfo;
		$data['ppddata'] = Multiple_box_purchase::join('package_purchased_list','multiple_box_purchase.package_purchased_id','=','package_purchased_list.rec_id')->join('users','multiple_box_purchase.sub_user_id','=','users.rec_id')->join('packages','package_purchased_list.package_id','=','packages.id')->where('multiple_box_purchase.user_id',$login_userId)->select('users.user_id','users.first_name','users.last_name','package_purchased_list.created_at','package_purchased_list.package_id','packages.package_name','packages.effective_amount')->paginate(20);
		/*echo "<pre>";
		print_r($result);exit();*/
		return view('customer/package_purchased_list')->with($data);
	}

	public function pendingShipment(){

		$userinfo = Auth::user();
		$login_userId = $userinfo['rec_id'];
		$userid = $userinfo['user_id'];
		$data['userinfo'] = $userinfo;
		if ($userinfo['user_role'] == 2) {
			$res = Users_tree::where("reseller_id", $userinfo['rec_id'])->where("customer_id", "!=", 0)->orderBy("rec_id", "DESC")->get();
		} else if ($userinfo['user_role'] == 3) {
			$res = Users_tree::where("agent_id", $userinfo['rec_id'])->where("customer_id", "!=", 0)->orderBy("rec_id", "DESC")->get();
		} else {
			$res = Users_tree::where("customer_id", "!=", 0)->orderBy("rec_id", "DESC")->get();
		}

		$arr = array();
		foreach ($res as $val) {
			array_push($arr, $val->customer_id);
		}

		/*if($userinfo['admin_login'] == 1){

			$where = array('users.status'=>1);
		}else{
			$where = array('users.referral_userid'=>$login_userId,'users.status'=>1);
		}*/
		//DB::enableQueryLog();
		$data['customers_data'] = Purchase_order_details::leftjoin('package_purchased_list','purchase_order_details.package_purchased_id','=','package_purchased_list.rec_id')->join('packages','packages.id','=','package_purchased_list.package_id')->join('users','purchase_order_details.user_id','=','users.rec_id')->select('users.email','users.first_name','users.last_name','users.user_id','packages.id as package_id','packages.package_name','purchase_order_details.order_id','purchase_order_details.shipping_address','purchase_order_details.purchased_date','purchase_order_details.rec_id','purchase_order_details.tracking_number')->where(['packages.setupbox_status' => 1,'users.user_role' => 4,'purchase_order_details.is_shipped' => 0])
				->where('purchase_order_details.order_id','!=','')
				->where('users.status',1)
				->whereIn('users.rec_id', $arr)
				//->groupby('purchase_order_details.user_id')
				->orderBy('purchase_order_details.rec_id','DESC')
				->get();
		// 		$query = DB::getQueryLog();
		// 		$lastQuery = end($query);
		// 		print_r($lastQuery);exit;
		// echo '<pre>';print_r($data['customers_data']);exit;
		$data['shipment_details'] = Purchase_order_details::leftjoin('package_purchased_list','purchase_order_details.package_purchased_id','=','package_purchased_list.rec_id')->join('packages','packages.id','=','package_purchased_list.package_id')->join('users','purchase_order_details.user_id','=','users.rec_id')->select('users.email','users.first_name','users.last_name','users.user_id','packages.id as package_id','packages.package_name','purchase_order_details.order_id','purchase_order_details.shipping_address','purchase_order_details.purchased_date','purchase_order_details.rec_id','purchase_order_details.tracking_number')->where(['packages.setupbox_status' => 1,'users.user_role' => 4,'purchase_order_details.is_shipped' => 1])
				->where('purchase_order_details.order_id','!=','')
				->where('users.status',1)
				->whereIn('users.rec_id', $arr)
				//->groupby('purchase_order_details.user_id')
				->orderBy('purchase_order_details.rec_id','DESC')
				->get();

		return view('pending_shipment')->with($data);
	}

	public function sendTrakingDetailsToCustomer(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'tracking_number' => 'required'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			Session::flash('result', '<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>');
			Session::flash('alert','Failure');
			return Redirect::back();
		} else{
			$purchased_rec_id = $request->purchased_rec_id;
			$order_details = Purchase_order_details::where(['rec_id' => $purchased_rec_id])->first();
			$customer_id = $order_details['user_id'];

			$order_id = $order_details['order_id'];
			$trackingId = $request->tracking_number;
			$customer_info = User::select('rec_id','first_name','last_name','email')->where(['rec_id'=>$customer_id])->first();

			$data['useremail'] = array('name' => $customer_info['first_name'].' '.$customer_info['last_name'], 'rec_id' => $customer_info['rec_id'], 'email' => $customer_info['email'],'order_id' => $order_id,'tracking_id' => $trackingId,'date' => date("d/m/Y"),'shipped_date' => $order_details['updated_at']);

			$emailid = array('toemail' => $customer_info['email']);
			Mail::send(['html' => 'email_templates.shipping_tracking_order'], $data, function ($message) use ($emailid) {
				$message->to($emailid['toemail'], 'Tracking Order Details')->subject('Tracking Order Details');
				$message->from('noreply@bestbox.net', 'BestBox');
			});

			Purchase_order_details::where(['rec_id' => $purchased_rec_id])->update(['tracking_number'=>$trackingId,'is_shipped' => 1]);

			Session::flash('result', 'Shipping tracking details sent to mail: '.$customer_info['email']);
			Session::flash('alert','Success');
			return Redirect::back();
		}
	}

	public function pendingActivation(){
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$login_userId = $userInfo['rec_id'];
		$data['userinfo'] = $userInfo;
		if ($userInfo['user_role'] == 2) {
			$res = Users_tree::where("reseller_id", $userInfo['rec_id'])->where("customer_id", "!=", 0)->orderBy("rec_id", "DESC")->get();
		} else if ($userInfo['user_role'] == 3) {
			$res = Users_tree::where("agent_id", $userInfo['rec_id'])->where("customer_id", "!=", 0)->orderBy("rec_id", "DESC")->get();
		} else {
			$res = Users_tree::where("customer_id", "!=", 0)->orderBy("rec_id", "DESC")->get();
		}

		$arr = array();
		foreach ($res as $val) {
			array_push($arr, $val->customer_id);
		}
		/*echo "<pre>";
print_r($res);exit();*/
		/*if($userInfo['admin_login'] == 1){
			$where = array('users.status'=>1);
		}else{
			$where = array('users.referral_userid'=>$login_userId,'users.status'=>1);
		}*/
		$data['request_list'] = Purchase_order_details::leftjoin('package_purchased_list','purchase_order_details.package_purchased_id','=','package_purchased_list.rec_id')->leftjoin('packages','package_purchased_list.package_id','=','packages.id')
			->leftjoin('users','users.rec_id','=','purchase_order_details.user_id')
			->where('purchase_order_details.type',1)
			->where('purchase_order_details.status',1)
			->where('packages.id','!=',11)
			->select('purchase_order_details.rec_id','users.email','users.first_name','users.last_name','users.user_id','users.email','purchase_order_details.order_id','purchase_order_details.purchased_date','purchase_order_details.status','purchase_order_details.purchased_from','packages.effective_amount','packages.id','packages.package_name','purchase_order_details.is_shipped','packages.setupbox_status')->where('users.status',1)->whereIn('users.rec_id', $arr)->orderBy('purchase_order_details.purchased_date','DESC')->orderBy('purchase_order_details.rec_id','DESC')->get();

		return view('pending_activation')->with($data);
	}
	public function pendingRenewal(){
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$login_userId = $userInfo['rec_id'];
		$data['userinfo'] = $userInfo;
		if ($userInfo['user_role'] == 2) {
			$res = Users_tree::where("reseller_id", $userInfo['rec_id'])->where("customer_id", "!=", 0)->orderBy("rec_id", "DESC")->get();
		} else if ($userInfo['user_role'] == 3) {
			$res = Users_tree::where("agent_id", $userInfo['rec_id'])->where("customer_id", "!=", 0)->orderBy("rec_id", "DESC")->get();
		} else {
			$res = Users_tree::where("customer_id", "!=", 0)->orderBy("rec_id", "DESC")->get();
		}

		$arr = array();
		foreach ($res as $val) {
			array_push($arr, $val->customer_id);
		}
		/*if($userInfo['admin_login'] == 1){
			$where = array('users.status'=>1);
		}else{
			$where = array('users.referral_userid'=>$login_userId,'users.status'=>1);
		}*/
		$data['request_list'] = Purchase_order_details::leftjoin('users','purchase_order_details.user_id','=','users.rec_id')->leftjoin('package_purchased_list','purchase_order_details.package_purchased_id','=','package_purchased_list.rec_id')->leftjoin('packages','package_purchased_list.package_id','=','packages.id')->where('purchase_order_details.type',2)->where('purchase_order_details.status',1)->select('purchase_order_details.rec_id','users.email','users.first_name','users.last_name','users.user_id','users.email','purchase_order_details.order_id','purchase_order_details.purchased_date','purchase_order_details.status','purchase_order_details.purchased_from','packages.effective_amount','packages.id','packages.package_name')->where('users.status',1)->whereIn('users.rec_id', $arr)->orderBy('purchase_order_details.purchased_date','DESC')->orderBy('purchase_order_details.rec_id','ASC')->get();
		return view('pending_renewal')->with($data);
	}

	public function activeLine(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$data['userInfo'] = $userInfo;
		$data['from_date'] = $request->query('from_date');
		$data['to_date'] = $request->query('to_date');

		$searchKey = $request->query('searchKey');
		$status = $request->query('status');
		$days = $request->query('days');

		if (!empty($searchKey)) {

				if ($userInfo['user_role'] == 2) {
					$res = User::join('users_tree','users.rec_id','=','users_tree.customer_id')->where("users_tree.reseller_id", $userInfo['rec_id'])->where('users.user_id', 'LIKE', '%' . $searchKey . '%')->where("users_tree.customer_id", "!=", 0)->get();

				} else if ($userInfo['user_role'] == 3) {
					$res = User::join('users_tree','users.rec_id','=','users_tree.customer_id')->where("users_tree.agent_id", $userInfo['rec_id'])->where('users.user_id', 'LIKE', '%' . $searchKey . '%')->where("users_tree.customer_id", "!=", 0)->orderBy("users_tree.rec_id", "DESC")->get();
				} else {
					$res = User::join('users_tree','users.rec_id','=','users_tree.customer_id')->where('users.user_id', 'LIKE', '%' . $searchKey . '%')->where("users_tree.customer_id", "!=", 0)->get();
				}

		}else{
			if ($userInfo['user_role'] == 2) {
				$res = Users_tree::where("reseller_id", $userInfo['rec_id'])->where("customer_id", "!=", 0)->orderBy("rec_id", "DESC")->get();
			} else if ($userInfo['user_role'] == 3) {
				$res = Users_tree::where("agent_id", $userInfo['rec_id'])->where("customer_id", "!=", 0)->orderBy("rec_id", "DESC")->get();
			} else {
				$res = Users_tree::where("customer_id", "!=", 0)->orderBy("rec_id", "DESC")->get();
			}
		}
		if($userInfo['user_role'] == 1){
			$where = array('users.status'=>1);
		}
		else{
			$where = array('users.status'=>1);
		}

		$arr = array();
		foreach ($res as $val) {
			array_push($arr, $val->customer_id);
		}
		$cur_date = date('Y-m-d H:i:s');
		//where(DB::raw('MAX(package_purchased_list.expiry_date) AS expiry_date',$symbol,Now()))
		$symbol = ($status == 1)? 1 : 0;
		if($status == 1){
			$wr = '>';
		}else{
			$wr = '<';
		}



		if(!empty($status)){
			//DB::enableQueryLog();

			$data['customers'] = User::rightJoin(\DB::raw('(SELECT * FROM package_purchased_list WHERE rec_id IN (SELECT MAX(rec_id) AS id FROM package_purchased_list WHERE package_id != 11 AND active_package=1 GROUP BY user_id) ORDER BY user_id) AS t2'), function($join) {
			        $join->on('users.rec_id', '=', 't2.user_id');
			    })->leftjoin('packages', 't2.package_id', '=', 'packages.id')->where($where)->whereIn('users.rec_id', $arr)->select('t2.rec_id AS pRec_id','users.rec_id', 'users.user_id','users.email_verify', 'users.first_name','users.last_name', 'users.email','users.plain_password', 'users.registration_date', 'users.status','users.cms_username','users.cms_password', 'packages.id','packages.effective_amount', 't2.expiry_date','packages.package_name','packages.setupbox_status')->where('t2.expiry_date',$wr,NOW())->groupBy('users.user_id')->orderBy('users.rec_id', 'DESC')->paginate(50);
			// $query = DB::getQueryLog();
			// print_r($query);exit;
		}else if(!empty($days)){

			$cur_date = date('Y-m-d');
			if($days == 7){
				$to = date('Y-m-d', strtotime($cur_date . ' +6 days'));
			}else if($days == 3){
				$to = date('Y-m-d', strtotime($cur_date . ' +2 days'));
			}else if($days == 2){
				$to = date('Y-m-d', strtotime($cur_date . ' +1 days'));
			}else{
				$to = date('Y-m-d', strtotime($cur_date . ' +0 day'));
			}
			//echo $to;
			//DB::enableQueryLog();
			$data['customers'] = User::rightJoin(\DB::raw('(SELECT * FROM package_purchased_list WHERE rec_id IN (SELECT MAX(rec_id) AS id FROM package_purchased_list WHERE package_id != 11 AND active_package=1 GROUP BY user_id) ORDER BY user_id) AS t2'), function($join) {
			        $join->on('users.rec_id', '=', 't2.user_id');
			    })->leftjoin('packages', 't2.package_id', '=', 'packages.id')->where($where)->whereIn('users.rec_id', $arr)->select('t2.rec_id AS pRec_id','users.rec_id', 'users.user_id','users.email_verify', 'users.first_name','users.last_name', 'users.email','users.plain_password', 'users.registration_date', 'users.status','users.cms_username','users.cms_password', 'packages.id','packages.effective_amount', 't2.expiry_date','packages.package_name','packages.setupbox_status')->where(DB::raw('DATE(t2.expiry_date)'),$to)->groupBy('users.user_id')->orderBy('users.rec_id', 'DESC')->paginate(50);
			//$query = DB::getQueryLog();
			//print_r($query);exit;
		}else{
			//DB::enableQueryLog();
			$data['customers'] = User::rightJoin(\DB::raw('(SELECT * FROM package_purchased_list WHERE rec_id IN (SELECT MAX(rec_id) AS id FROM package_purchased_list WHERE package_id != 11 AND active_package=1 GROUP BY user_id) ORDER BY user_id) AS t2'), function($join) {
			        $join->on('users.rec_id', '=', 't2.user_id');
			    })->leftjoin('packages', 't2.package_id', '=', 'packages.id')->where($where)->whereIn('users.rec_id', $arr)->select('users.rec_id', 'users.user_id','users.email_verify', 'users.first_name','users.last_name', 'users.email','users.plain_password', 'users.registration_date', 'users.status','users.cms_username','users.cms_password', 'packages.id','packages.effective_amount', 't2.expiry_date','packages.package_name','packages.setupbox_status')->groupBy('users.user_id')->orderBy('users.rec_id', 'DESC')->paginate(50);
			// $query = DB::getQueryLog();
			// print_r($query);exit;
		}


		$data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();
		$data['searchKey'] = $searchKey;
		$data['status'] = $status;
		$data['days'] = $days;
		//echo '<pre>';print_r($data['customers']);exit;
		return view('active_line')->with($data);
	}


	// send mail to customers for renewal package

	public function sendRenewalRemainder(Request $request){
		$userId = $request->user_id;
		$userInfo = User::where(['rec_id'=> $userId])->first();
		$expireIndays = $request->days;
		if($expireIndays <= 0) {
			$days = 'Expired';
			$emailtitle = 'PACKAGE EXPIRED';
			$sub = "Remainder : BestBox Package Expired";
		}else{
			$days = $expireIndays;
			$emailtitle = 'PACKAGE WILL BE EXPIRE';
			$sub = "Remainder : BestBox will be expire in ".$days .'Days';
		}

				$re_userid = $userInfo->user_id;
				$re_email = $userInfo->email;

				//$account_info = $re_userid." ( ".$re_email." )";
				$account_info = $re_userid;
				if(!empty($userInfo->telephone)){
					$mobileno = $userInfo->telephone;
				}else{
					$mobileno = "";
				}
		//$userInfo->email = 'vinod.kalepu@uandme.org';

		$data['useremail'] = array('username'=>$userInfo->first_name.' '.$userInfo->last_name,'rec_id'=>$userInfo->rec_id,'days'=>$days,'emailtitle' => $emailtitle,'user_id'=>$userInfo->user_id,'toemail'=>$userInfo->email);
		        $emailid = array('toemail' => $userInfo->email);
		        Mail::send(['html'=>'email_templates.package-expire-remainder'], $data, function($message) use ($emailid,$sub ) {
			        $message->to($emailid['toemail'], $sub)->subject
			        ($sub);
			        $message->from('noreply@bestbox.net','BestBox');
				});
		//send FCM
		$application_id = $userInfo->application_id;
		if(!empty($application_id)){
			$info = ApplicationsInfo::where('application_id','=',$application_id)->first();
			if(!empty($info)){
				$client_id = $info->application_id;
				$clientCode = $info->application_name;
			}else{
				$client_id = 1234;
				$clientCode = "BESTBOX";
			}
		}else{
			$client_id = 1234;
			$clientCode = "BESTBOX";
		}


		if( ($expireIndays >0) && ($expireIndays <= 7) ) {
			//echo "tetete";exit;
			$icon = "success.png";
			$clienticon = "package-expiry.png";

			$myrtime = date("Y-m-d H:i:s");
            $temp=explode(" ",$myrtime);
            $today = $temp[0];
            $ttime=$temp[1];
            $new_time = $today."T".$ttime;
			//$new_time = UserController::convertDateToUTCForAPI(date("Y-m-d H:i:s"));

			$message = "Your account <b>".$account_info." </b> is going to expire in <b>".$expireIndays." days </b> please renew account to avoid interruption in service.please avoid message if already renewed.";

			$htmlMessage = "Your account <b>".$account_info." </b> is going to expire in <b>".$expireIndays." days </b> please renew account to avoid interruption in service.please avoid message if already renewed.";

			$htmlMessageIOS="Your account ".$account_info." is going to expire in ".$expireIndays." days please renew account to avoid interruption in service.please avoid message if already renewed.";


			$arr = array("Client_id" => $client_id,"ClientCode" => $clientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Account Information',"user_id" =>$userId,"MobileNo" =>$mobileno,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);


			$json_data["package_alert"] = json_encode($arr);

			//$device_id = array($userInfo['device_id']);

			if(!empty($userInfo['device_id'])){


				$deviceIds = UsersDevicesList::where('user_id','=',$userInfo['rec_id'])->get();

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
						}

					}
				}


			}


		}else{
			//package expired FCM
			/*if($package_expiry_date < $current_date){*/

				$icon = "success.png";
				$clienticon = "package-expiry.png";

				$myrtime = date("Y-m-d H:i:s");
	            $temp=explode(" ",$myrtime);
	            $today = $temp[0];
	            $ttime=$temp[1];
	            $new_time = $today."T".$ttime;
				//$new_time = UserController::convertDateToUTCForAPI(date("Y-m-d H:i:s"));

				$message = "Your account <b>".$account_info." </b> is expired please renew account to resume your services.";

				$htmlMessage = "Your account <b>".$account_info." </b> is expired please renew account to resume your services.";

				$htmlMessageIOS="Your account ".$account_info." is expired please renew account to resume your services.";


				$arr = array("Client_id" => $client_id,"ClientCode" => $clientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Account Information',"user_id" =>$userId,"MobileNo" =>$mobileno,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);


				$json_data["package_alert"] = json_encode($arr);

				//$device_id = array($userInfo['device_id']);

				if(!empty($userInfo['device_id'])){

					$deviceIds = UsersDevicesList::where('user_id','=',$userInfo['rec_id'])->get();

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
							}

						}
					}

				}


			/*}*/

		}

		return response()->json(['status' => 'Success', 'Result' => 'Remainder mail sent to customer successfully'], 200);
		exit;
	}

	public static function calculateExpriryDate($purchaseDate, $duration){
		$timezone = Session::get('timezone');
		if($timezone) {
	        $tz = new DateTimeZone($timezone);
	    } else{
	    	$tz = new DateTimeZone('Atlantic/Reykjavik');
	    }

		$date = new DateTime($purchaseDate);
		$date->setTimezone($tz);
		if($duration !=0) {
			$date->modify('+'.$duration.' month');
		}
		return $date->format('d/m/Y, h:i a');
	}

	public function walletBalanceReport(Request $request) {
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];

		$searchTerm=$request['search'];
		$filterTerm=$request['filter'];
		$sortTerm=$request['sort'];
		$print=$request['print'];
		$data['page'] = $request['page'];
		if($searchTerm=='all'){
			$searchTerm="";
		}
		if($searchTerm=="all" || $searchTerm==""){
			$data['allUsersDet']=User::getUserInfo($filterTerm,$sortTerm);
			$data['allUsersDet2']=User::getUserInfo3($filterTerm,$sortTerm);

		}else{
			$data['allUsersDet']=User::getUserInfoBySearchTerm($searchTerm,$filterTerm,$sortTerm);
			$data['allUsersDet2']=User::getUserInfoBySearchTerm3($searchTerm,$filterTerm,$sortTerm);
		}

		$data['searchTerm']=$searchTerm;
		$data['filterTerm']=$filterTerm;
		$data['sortTerm']=$sortTerm;
		//$data['sumOfWalletAmount']=User::sumOfWalletAmount();
		$sumOfWalletAmount = 0;
		if(!empty($print) && $print == 'yes'){
		//echo '<pre>';print_R($data['allUsersDet']);exit;
			$htmltext = '<html><body>';
			$htmltext .='<div style="font-family:Arial; text-align: center;font-size:24px;margin-top: 20px;"><h2>WALLET BALANCE REPORT</h2></div>';

			if(!empty($data['allUsersDet']))
			{
				$htmltext .= '<table style="width:100%; font-size:12px; border-collapse: collapse;" border="1" cellpadding="6">';
				$htmltext .= '<thead><tr style="background-color: #ff6bc4;color: #fff;"><th style="text-align: left;padding: 8px;">S.No.</th><th style="text-align: left;padding: 8px;">User ID</th><th style="text-align: left;padding: 8px;">Email ID</th><th style="text-align: left;padding: 8px;">Name</th><th style="text-align: center;padding: 8px;">Audiences</th><th style="text-align: left;padding: 8px;">BestBox Wallet Amt</th></tr></thead>';
				$htmltext .= '<tbody>';
				$i=1;
				$tot_amt = 0;
				foreach($data['allUsersDet'] as $item)
				{
					$role = ($item['user_role']==2 ? 'Reseller' : ($item['user_role'] == 3 ? 'Agent' : ($item['user_role'] == 4 ? 'Customer' : '')));
					$tot_amt += $item['amount'];
					$htmltext .= '<tr><td style="padding-left: 10px;">'.$i.'</td><td style="padding-left: 10px;">'.$item['user_id'].'</td><td style="padding-left: 10px; text-align:left;" >'.$item['email'].'</td><td style="padding-left: 10px; text-align:left;" >'.ucwords($item['first_name']." ".$item['last_name']).'</td><td style="padding-left: 10px; text-align:center;" >'.$role.'</td><td style="padding-left: 10px; text-align:right;" >'.number_format($item['amount'],2).'</td></tr>';

					$i++;
				}
				$htmltext .= '<tr><td colspan="5" style="padding-left: 10px;text-align:right;">All Audiences Total Wallet Balance</td><td style="padding-left: 10px; text-align:right;" >'.number_format($tot_amt,2).'</td></tr>';

				$htmltext .= '</tbody>';
				$htmltext .= '</table>';

			}else{
				$htmltext .= '<p>No Records Found</p>';
			}
			$htmltext .= '</body></html>';
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->SetHTMLHeader('');
			$mpdf->SetHTMLFooter('');
			$mpdf->SetFont('arial');
			$mpdf->WriteHTML($htmltext);
			$mpdf->Output("walletBalanceReport".date('YmdHis').".pdf",'D');
			exit;

		}else{
			if(!empty($data['allUsersDet2']))
			{
				foreach($data['allUsersDet2'] as $item)
				{
					$sumOfWalletAmount += $item['amount'];
				}
			}
			$data['sumOfWalletAmount']=$sumOfWalletAmount;
			return view('wallet_balance_report')->with($data);
		}

	}

	public function userDetailsReport(Request $request) {
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];

		$searchTerm=$request['search'];
		$filterTerm=$request['filter'];
		$sortTerm=$request['sort'];
		$print=$request['print'];
		if($searchTerm=='all'){
			$searchTerm="";
		}
		if($searchTerm=="all" || $searchTerm==""){
			$data['allUsersDet']=User::getUserInfo2($filterTerm,$sortTerm);
		}else{
			$data['allUsersDet']=User::getUserInfoBySearchTerm2($searchTerm,$filterTerm,$sortTerm);
		}



		$data['searchTerm']=$searchTerm;
		$data['filterTerm']=$filterTerm;
		$data['sortTerm']= $sortTerm;
		//echo $filterTerm;exit;
		$data['sumOfWalletAmount']=User::sumOfWalletAmount();

		if(!empty($print) && $print == 'yes'){

			$htmltext = '<html><body>';
			$htmltext .='<div style="font-family:Arial; text-align: center;font-size:24px;margin-top: 20px;"><h2>User Details REPORT</h2></div>';

			if(!empty($data['allUsersDet']))
			{
				$htmltext .= '<table style="width:100%; font-size:12px; border-collapse: collapse;" border="1" cellpadding="6">';
				$htmltext .= '<thead><tr style="background-color: #ff6bc4;color: #fff;"><th style="text-align: left;padding: 8px;">SNO</th><th style="text-align: left;padding: 8px;">Date</th><th style="text-align: left;padding: 8px;">Name</th><th style="text-align: left;padding: 8px;">Email ID</th><th style="text-align: left;padding: 8px;">User Id</th><th style="text-align: left;padding: 8px;">Password</th><th style="text-align: center;padding: 8px;">Type</th><th style="text-align: left;padding: 8px;">Status</th></tr></thead>';
				$htmltext .= '<tbody>';
				$i=1;
				$tot_amt = 0;
				foreach($data['allUsersDet'] as $item)
				{
					$pkgdata = \App\Package_purchase_list::where('user_id',$item['rec_id'])->where('active_package',1)->where('package_id','!=',11)->orderBy('rec_id','DESC')->first();

					if(!empty($pkgdata) && $pkgdata->expiry_date != ''){
                        $package_status = ($pkgdata->expiry_date < NOW()) ? 'Expired' : 'Active';
					}
                    else{
                    	$package_status = 'Not Subscribed';

                    }
                    if($item['user_role']==2 || $item['user_role'] == 3){
                    	$package_status = ($item['status'] == 1) ? 'Active' : 'In-Active';
                    }


					$role = ($item['user_role']==2 ? 'Reseller' : ($item['user_role'] == 3 ? 'Agent' : ($item['user_role'] == 4 ? 'Customer' : '')));
					$bestbox_password= ($item['plain_password']!='') ? safe_decrypt($item['plain_password'],config('constants.encrypt_key')) : '---';

					$tot_amt += $item['amount'];
					$htmltext .= '<tr><td style="padding-left: 10px;">'.$i.'</td><td style="padding-left: 10px;">'.self::convertTimezone($item['registration_date']).'</td><td style="padding-left: 10px; text-align:left;" >'.ucwords($item['first_name']." ".$item['last_name']).'</td><td style="padding-left: 10px; text-align:left;" >'.$item['email'].'</td><td style="padding-left: 10px;">'.$item['user_id'].'</td><td style="padding-left: 10px;">'.$bestbox_password.'</td><td style="padding-left: 10px; text-align:center;" >'.$role.'</td><td style="padding-left: 10px; text-align:right;" >'.$package_status.'</td></tr>';

					$i++;
				}
				//$htmltext .= '<tr><td colspan="5" style="padding-left: 10px;text-align:right;">All Audiences Total Wallet Balance</td><td style="padding-left: 10px; text-align:right;" >'.number_format($tot_amt,2).'</td></tr>';

				$htmltext .= '</tbody>';
				$htmltext .= '</table>';

			}else{
				$htmltext .= '<p>No Records Found</p>';
			}
			$htmltext .= '</body></html>';
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->SetHTMLHeader('');
			$mpdf->SetHTMLFooter('');
			$mpdf->SetFont('arial');
			$mpdf->WriteHTML($htmltext);
			$mpdf->Output("userDetailsReport".date('YmdHis').".pdf",'D');
			exit;

		}else{
			return view('user_details_report')->with($data);
		}

	}

	public function salesReport(Request $request)
	{

		$userInfo = Auth::user();
		$admin_id = config('constants.ADMIN_ID');
		if($userInfo['admin_login'] == 1){
			$userId = $admin_id;
		}else{
			$userId = $userInfo['rec_id'];
		}
		$data['from_date'] = $request->query('from_date');
		$data['to_date'] = $request->query('to_date');
		$searchKey = $request->query('searchKey');
		$purchased_from = $request->query('type');
		$subs_type = $request->query('subs_type');
		$package_name = $request->query('package_name');
		$data['page'] = $request->query('page');
		if($purchased_from != ''){
			$where = array('purchase_order_details.purchased_from' => $purchased_from);
		}else{
			$where = array();
		}

		if($subs_type != ''){
			$where1 = array('purchase_order_details.type' => $subs_type);
		}else{
			$where1 = array();
		}

		if($package_name != ''){
			$where2 = array('package_purchased_list.package_id' => $package_name);
		}else{
			$where2 = array();
		}
		if (!empty($request->query('from_date')) && !empty($request->query('to_date'))) {
			$from_date = $request->query('from_date');
			$to_date = $request->query('to_date');
			$from_date = Carbon::createFromFormat('m-d-Y', $from_date)->format('Y-m-d');
			$to_date = Carbon::createFromFormat('m-d-Y', $to_date)->format('Y-m-d');
			$start = Carbon::parse($from_date)->format('Y-m-d H:i:s');
			$todate = Carbon::parse($to_date)->format('Y-m-d H:i:s');
			$to = date('Y-m-d H:i:s', strtotime($todate . ' +1 day'));

			$data['sales_report_data'] = Purchase_order_details::leftjoin('package_purchased_list','purchase_order_details.package_purchased_id','=','package_purchased_list.rec_id')->join('packages','packages.id','=','package_purchased_list.package_id')->join('users','purchase_order_details.user_id','=','users.rec_id')->select('users.email','users.first_name','users.last_name','users.user_id','packages.id as package_id','packages.package_name','packages.effective_amount','purchase_order_details.order_id','purchase_order_details.shipping_address','purchase_order_details.purchased_date','purchase_order_details.rec_id','purchase_order_details.purchased_from','purchase_order_details.type')
				->whereBetween('purchase_order_details.purchased_date', [$start, $to])
				->when(Input::has('searchKey'), function ($query) {
			        return $query->where('users.user_id', 'LIKE', '%' . Input::get('searchKey') .'%');
			    })
				->where($where)
				->where($where1)
				->where($where2)
				->orderBy('purchase_order_details.rec_id','DESC')
				->paginate(100);

		}else if (!empty($request->query('searchKey'))){

				$data['sales_report_data'] = Purchase_order_details::leftjoin('package_purchased_list','purchase_order_details.package_purchased_id','=','package_purchased_list.rec_id')->join('packages','packages.id','=','package_purchased_list.package_id')->join('users','purchase_order_details.user_id','=','users.rec_id')->select('users.email','users.first_name','users.last_name','users.user_id','packages.id as package_id','packages.package_name','packages.effective_amount','purchase_order_details.order_id','purchase_order_details.shipping_address','purchase_order_details.purchased_date','purchase_order_details.rec_id','purchase_order_details.purchased_from','purchase_order_details.type')
				->when(Input::has('searchKey'), function ($query) {
			        return $query->where('users.user_id', 'LIKE', '%' . Input::get('searchKey') .'%');
			    })
				->where($where)
				->where($where1)
				->where($where2)
				->orderBy('purchase_order_details.rec_id','DESC')
				->paginate(100);

			}
		else{
            $currentMonth = date('m');
            $currentYear = date('Y');
			$data['sales_report_data'] = Purchase_order_details::leftjoin('package_purchased_list','purchase_order_details.package_purchased_id','=','package_purchased_list.rec_id')->join('packages','packages.id','=','package_purchased_list.package_id')->join('users','purchase_order_details.user_id','=','users.rec_id')->select('users.email','users.first_name','users.last_name','users.user_id','packages.id as package_id','packages.package_name','packages.effective_amount','purchase_order_details.order_id','purchase_order_details.shipping_address','purchase_order_details.purchased_date','purchase_order_details.rec_id','purchase_order_details.purchased_from','purchase_order_details.type')
				->where($where)
				->where($where1)
				->where($where2)
                ->whereRaw('MONTH(purchase_order_details.purchased_date) = ?',[$currentMonth])
                ->whereRaw('YEAR(purchase_order_details.purchased_date) = ?',[$currentYear])
				->orderBy('purchase_order_details.rec_id','DESC')
				->paginate(100);

		}
		$package_det = Packages::where('status',1)->get();

		$pack_data = array( ['text'=>'IPTV Box/Package','selectText'=>($package_name == '') ? 'IPTV Box/Package' : '','selected'=>($package_name == '') ? true : false,'value'=>'']);
		foreach ($package_det as $pack) {
			$pack_data[] = array('text'=>$pack->package_name,'value'=>$pack->id,'selectText'=>($package_name == $pack->id) ? $pack->package_name : '','selected'=>($package_name == $pack->id) ? true : false);
		}
		$data['packages_list'] = json_encode($pack_data);

		$data['searchKey'] = $searchKey;
		$data['purchased_from'] = $purchased_from;
		$data['subs_type'] = $subs_type;
		$data['package_name'] = $package_name;


		/*$data['wallet_sum'] = Purchase_order_details::leftjoin('package_purchased_list','purchase_order_details.package_purchased_id','=','package_purchased_list.rec_id')
			->join('packages','packages.id','=','package_purchased_list.package_id')
			->join('users','purchase_order_details.user_id','=','users.rec_id')
				->where('purchase_order_details.purchased_from','Wallet')
				->when(Input::has('searchKey'), function ($query) {
			        return $query->where('users.user_id', 'LIKE', '%' . Input::get('searchKey') .'%');
			    })
				->where($where)
				->where($where1)
				->where($where2)
				->sum('packages.effective_amount');

		$data['everuspay_sum'] = Purchase_order_details::leftjoin('package_purchased_list','purchase_order_details.package_purchased_id','=','package_purchased_list.rec_id')
				->join('packages','packages.id','=','package_purchased_list.package_id')
				->join('users','purchase_order_details.user_id','=','users.rec_id')
				->where('purchase_order_details.purchased_from','EVERUSPAY')
				->when(Input::has('searchKey'), function ($query) {
			        return $query->where('users.user_id', 'LIKE', '%' . Input::get('searchKey') .'%');
			    })
				->where($where)
				->where($where1)
				->where($where2)
				->sum('packages.effective_amount');

		$data['aliexpress_sum'] = Purchase_order_details::leftjoin('package_purchased_list','purchase_order_details.package_purchased_id','=','package_purchased_list.rec_id')
				->join('packages','packages.id','=','package_purchased_list.package_id')
				->join('users','purchase_order_details.user_id','=','users.rec_id')
				->where('purchase_order_details.purchased_from','Ali Express')
				->when(Input::has('searchKey'), function ($query) {
			        return $query->where('users.user_id', 'LIKE', '%' . Input::get('searchKey') .'%');
			    })
				->where($where)
				->where($where1)
				->where($where2)
				->sum('packages.effective_amount');*/

		$print = $request->query('print');
		if(!empty($print) && $print == 'yes'){

			$htmltext = '<html><body>';
			$htmltext .='<div style="font-family:Arial; text-align: center;font-size:24px;margin-top: 20px;"><h2>Sales Report</h2></div>';

			if(!empty($data['sales_report_data']))
			{
				$htmltext .= '<table style="width:100%; font-size:12px; border-collapse: collapse;" border="1" cellpadding="6">';
				$htmltext .= '<thead><tr style="background-color: #ff6bc4;color: #fff;"><th style="text-align: left;padding: 8px;">S.No.</th><th style="text-align: left;padding: 8px;">Date</th><th style="text-align: left;padding: 8px;">User ID</th><th style="text-align: left;padding: 8px;">IPTV Box/Package</th><th style="text-align: center;padding: 8px;">Subscription Type</th><th style="text-align: right;padding: 8px;">AliExpress Amt</th><th style="text-align: right;padding: 8px;">BestBox Wallet Amt</th><th style="text-align: right;padding: 8px;">EverusPay Amt</th><th style="text-align: right;padding: 8px;">BitPay Amt</th><th style="text-align: right;padding: 8px;">Bank Payment Amt</th></tr></thead>';
				$htmltext .= '<tbody>';
				$i=1;
				$aliexpress_sum = 0;
                $wallet_sum = 0;
				$everuspay_sum = 0;
				$bitpay_sum = 0;
				$bankpay_sum = 0;
				foreach($data['sales_report_data'] as $item)
				{

					$date = \App\Http\Controllers\home\ReportController::convertTimezone($item['purchased_date']);
					$type = $item['type'] == 1 ? 'New' : 'Renewal';
					$purchased_from = $item['purchased_from'] == 'Ali Express' ? $item['effective_amount'] : '0.00';
					$purchased_from1 = $item['purchased_from'] == 'Wallet' ? $item['effective_amount'] : '0.00';
					$purchased_from2 = $item['purchased_from'] == 'EVERUSPAY' ? $item['effective_amount'] : '0.00';
					$purchased_from3 = $item['purchased_from'] == 'BITPAY' ? $item['effective_amount'] : '0.00';
					$purchased_from4 = $item['purchased_from'] == 'BANK PAYMENT' ? $item['effective_amount'] : '0.00';
					if($item['purchased_from'] == 'Ali Express') {
                        $aliexpress_sum += $item['effective_amount'];
                    }else if($item['purchased_from'] == 'Wallet'){
                        $wallet_sum += $item['effective_amount'];
                    }else if($item['purchased_from'] == 'EVERUSPAY'){
                        $everuspay_sum += $item['effective_amount'];
                    }else if($item['purchased_from'] == 'BITPAY'){
                        $bitpay_sum += $item['effective_amount'];
                    }else if($item['purchased_from'] == 'BANK PAYMENT'){
                        $bankpay_sum += $item['effective_amount'];
                    }

					$htmltext .= '<tr><td style="padding-left: 10px;">'.$i.'</td><td style="padding-left: 10px;">'.$date.'</td><td style="padding-left: 10px;">'.$item['user_id'].'</td><td style="padding-left: 10px; text-align:left;" >'.$item['package_name'].'</td><td style="padding-left: 10px; text-align:center;" >'.$type.'</td><td style="padding-left: 10px; text-align:right;" >'.number_format($purchased_from,2).'</td><td style="padding-left: 10px; text-align:right;" >'.number_format($purchased_from1,2).'</td><td style="padding-left: 10px;text-align:right;">'.number_format($purchased_from2,2).'</td><td style="padding-left: 10px;text-align:right;">'.number_format($purchased_from3,2).'</td><td style="padding-left: 10px;text-align:right;">'.number_format($purchased_from4,2).'</td></tr>';

				$i++;
				}
				$htmltext .= '<tr><td colspan="5" style="padding-left: 10px;text-align:right;">Total(USD)</td><td style="padding-left: 10px; text-align:right;" >'.number_format($aliexpress_sum,2).'</td><td style="padding-left: 10px; text-align:right;" >'.number_format($wallet_sum,2).'</td><td style="padding-left: 10px; text-align:right;" >'.number_format($everuspay_sum,2).'</td><td style="padding-left: 10px; text-align:right;" >'.number_format($bitpay_sum,2).'</td><td style="padding-left: 10px; text-align:right;" >'.number_format($bankpay_sum,2).'</td></tr>';

				$htmltext .= '</tbody>';
				$htmltext .= '</table>';


			}else{
				$htmltext .= '<p>No Records Found</p>';
			}
			$htmltext .= '</body></html>';
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->SetHTMLHeader('');
			$mpdf->SetHTMLFooter('');
			$mpdf->SetFont('arial');
			$mpdf->WriteHTML($htmltext);
			$mpdf->Output("salesReport".date('YmdHis').".pdf",'D');
			exit;

		}else{
			return view('sales_report')->with($data);
		}

	}

}

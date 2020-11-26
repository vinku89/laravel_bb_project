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
use Carbon\Carbon;
use App\Packages;
use App\Package_purchase_list;
use App\Commissions;
use App\Withdraw_request;
use App\Http\Controllers\API\CustomersController;
use App\Library\Common;
class WithdrawalController extends Controller
{
	
	public function withdrawaloptions(Request $request)
	{
		$userInfo = $request->user();
		$rec_id = $userInfo['rec_id'];
		//print_r($data);exit;
        
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
			$limit = 20;
			$page = request('page');
			$wal = Wallet::where("user_id", $rec_id)->first();
			if(!empty($wal)){
				$wallet_balance = $wal->amount;	
			}else{
				$wallet_balance = "";
			}
			
			$res = User::select('*')->where('status','=',1)->where('email_verify','=',1)->where('rec_id','=',$rec_id)->first();
			
			
			if(@count($res)>0){
			
				if(!empty($res->evr_address)){ 
					$evrInfo = 	["crypto_name"=>"My Everus Wallet","crypto_type"=>"evr","crypto_logo"=>"everus.png","crypto_address"=>$res->evr_address];
				}else{
					$evrInfo = [];
				}
				
				if(!empty($res->btc_address)){
					$btcInfo = 	["crypto_name"=>"My Bitcoin Wallet","crypto_type"=>"btc","crypto_logo"=>"bitcoin.png","crypto_address"=>$res->btc_address];
				}else{
					$btcInfo = [];
				}
				
				if(!empty($res->eth_address)){
					$ethInfo = 	["crypto_name"=>"My Etherum Wallet","crypto_type"=>"eth","crypto_logo"=>"ethereum.png","crypto_address"=>$res->eth_address];
				}else{
					$ethInfo = [];
				}
				
				if(!empty($res->true_address)){
					$trueInfo = ["crypto_name"=>"My True-e Wallet","crypto_type"=>"true","crypto_logo"=>"trullion-e.png","crypto_address"=>$res->true_address];
				}else{
					$trueInfo = [];
				}
				
				$wallets = [$evrInfo,$btcInfo,$ethInfo,$trueInfo];
			
			/*$wallets = array(
				["crypto_name"=>"Everus","crypto_type"=>"evr","crypto_logo"=>"everus.png","crypto_address"=>$res->evr_address],
				["crypto_name"=>"Bitcoin","crypto_type"=>"btc","crypto_logo"=>"bitcoin.png","crypto_address"=>$res->btc_address],
				["crypto_name"=>"Etherum","crypto_type"=>"eth","crypto_logo"=>"ethereum.png","crypto_address"=>$res->eth_address],
				["crypto_name"=>"True-e","crypto_type"=>"true","crypto_logo"=>"trullion-e.png","crypto_address"=>$res->true_address],
				
			);*/
			
				$results = array(
							"rec_id"=>$res->rec_id,
							"wallet_balance"=>$wallet_balance,
							"wallets"=>$wallets,
							'currency_symbol'=>'$',
							'currency_format'=>'USD'
							);
				return response()->json(['status' => 'Success','Result' => $results], 200);
			}else{
				return response()->json(['status'=>'Failure','Result'=>"No Records Found" ], 200);
			}
		
		}
	
		
	}
	
	public function withdrawalOptionCustomers(Request $request)
	{
		$userInfo = $request->user();
		$rec_id = $userInfo['rec_id'];
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
			$limit = 10;
			$page = request('page');
			$searchKey = request('searchKey');
			// not send logged user info
			
			if(!empty($searchKey)){
				$results = User::where('status','=',1)->where('email_verify','=',1)->where('rec_id','!=',$rec_id)->where(DB::raw('concat(first_name," ",last_name)'), 'LIKE', '%' . $searchKey . '%')->select('first_name','last_name','email','rec_id','user_id','image','telephone')->orderBy("registration_date", "DESC")->skip($page * $limit)->take($limit)->get();
			}else{
			
				$results = User::where('status','=',1)->where('email_verify','=',1)->where('rec_id','!=',$rec_id)->select('first_name','last_name','email','rec_id','user_id','image','telephone')->orderBy("registration_date", "DESC")->skip($page * $limit)->take($limit)->get();
			}
			
			
			
			$usersList = array();
			if(@count($results)>0){
				foreach($results as $res){
				
					$profileImage = $res->image;
					if(!empty($profileImage)){
						$profile_pic = 	$profileImage;
					}else{
						$profile_pic = "";
					}
					
					$telephone = $res->telephone;
					if(!empty($telephone)){
						$mobile_no = $telephone;
					}else{
						$mobile_no = "";
					}
					
					$usersList[] = array(
							"rec_id"=>$res->rec_id,
							"user_id"=>$res->user_id,
							"userName"=>$res->first_name." ".$res->last_name,
							"email"=>$res->email,
							"mobile_no"=>$mobile_no,
							"profile_pic"=>$profile_pic,
							'currency_symbol'=>'$',
							'currency_format'=>'USD'
							);
					
				}
				
				return response()->json(['status' => 'Success','Result' => $usersList], 200);
			}else{
				return response()->json(['status'=>'Failure','Result'=>"No Records Found" ], 200);
			}
		
		}
	
		
	}
	
	 
	
	// send withdrawal amount
	public function sendWithdrawalAmt(Request $request)
	{
		//echo "test";exit;
		$userInfo = $request->user();
		$logged_user_info = $userInfo;
		$login_userId = $userInfo['rec_id'];

		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
        $validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
            'withdraw_amt' => 'required',
			'withdraw_type' => 'required',
			
			
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);            
        }else{
			$app_name = $userInfo['application_id']; //request('app_name');
			$withdraw_type = request('withdraw_type'); 
			$withdraw_amt = request('withdraw_amt');
			$withdraw_address = request('withdraw_address');
			$resellerOrAgentName = request('user_id'); 
			
			if($withdraw_type == "evr"){
				$wallet_name = "Everus";	
			}else if($withdraw_type == "btc"){
				$wallet_name = "Bitcoin";	
			}else if($withdraw_type == "eth"){
				$wallet_name = "Etherum";	
			}else if($withdraw_type == "true"){
				$wallet_name = "True-e";	
			}else{
				$wallet_name = "";
			}
			
			$wal = Wallet::where("user_id", $login_userId)->first();
			if(!empty($withdraw_type) && $withdraw_amt > 0){
				if ($withdraw_amt < $wal->amount) {
					
					if($withdraw_type == 5){
						//transfer to agent/reseller
						//$resellerOrAgentName = Input::get('resellerOrAgentName');
						if(!empty($resellerOrAgentName)){
							$receiver_det = User::where('rec_id',$resellerOrAgentName)->first();
							if(!empty($receiver_det)){
							
								Wallet::where('user_id', $login_userId)->decrement('amount', $withdraw_amt);
								//transactions table
								$bal = $wal->amount - $withdraw_amt;
								//$micro = substr(microtime(),2,4); 
								//$transaction_no = date("Ymdjis").$micro;
								$transaction_no = self::generate_randam_string('WID', $strength = 9);
								
								$des1 = number_format($withdraw_amt,2) . ' USD transferred to '.$receiver_det->first_name." ".$receiver_det->last_name;
								
								CustomersController::user_transactions($transaction_no,'',$login_userId,$login_userId ,$receiver_det->rec_id, 0, $withdraw_amt, $bal, 'Withdrawn Amount', $des1);
								
								// sender FCM to sender
								Common::senderWithdrawalFCM($logged_user_info,$withdraw_amt,"sender",$receiver_det,$app_name);
								
								$wb = Wallet::where("user_id", $receiver_det->rec_id)->first();
								$balance = $wb->amount + $withdraw_amt;
								//$micro = substr(microtime(),2,4); 
								//$transaction_no = date("Ymdjis").$micro;
								$transaction_no = self::generate_randam_string('WID', $strength = 9);
								
								$des2 = number_format($withdraw_amt,2) . ' USD received from '.$userInfo['first_name']." ".$userInfo['last_name'];
								
								CustomersController::user_transactions($transaction_no,'',$receiver_det->rec_id,$login_userId ,$receiver_det->rec_id, $withdraw_amt,0, $balance, 'Received Amount', $des2);
								
								Wallet::where('user_id', $receiver_det->rec_id)->increment('amount', $withdraw_amt);
								
								// send FCM to Receiver
								Common::senderWithdrawalFCM($logged_user_info,$withdraw_amt,"receiver",$receiver_det,$app_name);

								return response()->json(['status'=>'Success','Result'=>"Successfully Transferred."], 200);	
								
							}else{
								return response()->json(['status'=>'Failure','Result'=>"Reseller/Agent/Customer Name Not Valid."], 200);
							}
						}else{
							
							return response()->json(['status'=>'Failure','Result'=>"Please provide Reseller/Agent/Customer Name."], 200);
						}
					}else{
					
						//$micro = substr(microtime(),2,4); 
						//$transaction_no = date("Ymdjis").$micro;
						$transaction_no = self::generate_randam_string('WID', $strength = 9);
						
						Wallet::where('user_id', $login_userId)->decrement('amount', $withdraw_amt);
						//transactions table
						$bal = $wal->amount - $withdraw_amt;
						
						$des = number_format($withdraw_amt,2).' USD transfer requested to my '.$wallet_name.' Wallet.';
						
						$last_inserted_id = CustomersController::user_transactions($transaction_no,'',$login_userId,$login_userId ,1000, 0, $withdraw_amt, $bal, 'Transfer To Crypto Wallet', $des);
						
						//$last_inserted_id = $result['last_inserted_id'];
						$transaction_no = self::generate_randam_string('WID', $strength = 9);
						Withdraw_request::create([
							'withdraw_id' => $last_inserted_id,
							'transaction_no' => $transaction_no,
							'user_id' => $login_userId,
							'request_amt' => $withdraw_amt,
							'request_date' => NOW(),
							'wallet_type' => $withdraw_type,
							'wallet_address' => $withdraw_address,
							'status' => 1
						]);

						// send FCM
						Common::sendFCMWithdrawnCrypto($logged_user_info,$withdraw_amt,$wallet_name,$app_name);
						
						
						return response()->json(['status'=>'Success','Result'=>"Withdrawal Request has been submitted  Successfully,will be proceed in 24 to 48 hours."], 200);	
						
					}
					
				}else{
					return response()->json(['status'=>'Failure','Result'=>"Insufficient balance in your wallet"], 200);
				}
				
					
			}else{
				return response()->json(['status'=>'Failure','Result'=>"Please Enter Withdraw Amount OR Withdraw type is missing"], 200);
			}
		
		}
		
		
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

	// withdrawal requested List
	
	public function withdrawalRequestedList(Request $request)
	{

		$userInfo = $request->user();
		$login_userId = $userInfo['rec_id'];

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
			
			$results = Withdraw_request::select('*')->where('user_id','=',$login_userId)->orderBy("rec_id", "DESC")->skip($page * $limit)->take($limit)->get();
			
			if(@count($results)>0){
				$withdrawalsList = array();
				foreach($results as $res){
					
					$request_date = UserController::convertDateToUTCForAPI($res->request_date);
					if($res->admin_response_date == "0000-00-00 00:00:00"){
						$admin_response_date = "";
					}else{
						$admin_response_date = UserController::convertDateToUTCForAPI($res->admin_response_date);
					}
					
					
					if($res->status == 1){
					    $status_msg = "In-Progress";	
					}else{
						$status_msg = "Completed";
					}
					
					if($res->credit_crypto_amt == 0.00000000){
					    $credit_crypto_amt = "";	
					}else{
						$credit_crypto_amt = number_format($res->credit_crypto_amt,8);
					}
					
					$withdrawalsList[] = array(
										"request_date"=>$request_date,
										"transaction_no"=>$res->transaction_no,
										"request_amt"=>number_format($res->request_amt,2),
										"wallet_type"=>$res->wallet_type,
										"wallet_address"=>$res->wallet_address,
										"status"=>$status_msg,
										"credit_crypto_amt"=>$credit_crypto_amt,
										"transaction_hash"=>$res->transaction_hash,
										"admin_response_date"=>$admin_response_date,
										'currency_symbol'=>'$',
										'currency_format'=>'USD'
										);
				}
				
				return response()->json(['status'=>'Success','Result'=>$withdrawalsList], 200);
				
			}else{
				return response()->json(['status'=>'Failure','Result'=>"No Records Found"], 200);   
			}
		
		}
		
		
	}
	
	
}
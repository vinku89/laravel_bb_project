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
use App\Transactions;
use App\Packages;
use App\Package_purchase_list;
use App\Withdraw_request;
use App\PaymentsHistory;
class TransactionsController extends Controller
{
	// Transactions Filters
	public function transactionsFilters(Request $request)
    {
		$udata = $request->user();
		$rec_id = $udata['rec_id'];
		$user_role = $udata['user_role'];
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
			
			/*$filtersArray = array(
							"1"=>"Transferred From Admin",
							"2"=>"Commission",
							"3"=>"Referral Bonus",
							"4"=>"Withdraw Request Amount",
							"5"=>"Withdrawn Amount",
							"6"=>"Received Amount",
							"7"=>"Pay For My Friend",
							"8"=>"Transfer To Crypto Wallet",
							"9"=>"Renewal Package",
							);
			*/	
			if($user_role == 4){
				$filtersArray = array("Transferred From Admin","Commission","Referral Bonus","Pay For My Friend","Renewal Package");	
			}else{
				$filtersArray = array("Transferred From Admin","Commission","Referral Bonus","Withdraw Request Amount","Withdrawn Amount","Received Amount","Pay For My Friend","Transfer To Crypto Wallet","Renewal Package");	
			}
						
							
			return response()->json(['status'=>'Success','Result'=>$filtersArray], 200);				
		
		}
	}
	
	public function getTransactionsList(Request $request)
	{
		$userInfo = $request->user();
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
			
			$from_date = request('from_date');
			$to_date = request('to_date');
			$commission_per = request('commission_per');
			
			$searchKey = request('searchKey');
			// wallet Balance
			$walletInfo = Wallet::where('user_id',"=",$userInfo['rec_id'])->first();
			if(!empty($walletInfo)){
				$wallet_Balance = number_format($walletInfo->amount,2);
				$walletBalance = $wallet_Balance;
			}else{
				$walletBalance = "0.00";
			}
			
			
			if( (!empty($searchKey)) && (strtoupper($searchKey) != "ALL") ){
				
				/*$start = Carbon::parse($from_date)->format('Y-m-d H:i:s');
				$todate = Carbon::parse($to_date)->format('Y-m-d H:i:s');
				$to = date('Y-m-d H:i:s', strtotime($todate . ' +1 day'));
				->whereBetween('transactions.received_date', [$start, $to])
				*/
				if($searchKey == "Transferred From Admin"){
					$search_term = "Transferred From Admin";
				}else if($searchKey == "Commission"){
					$search_term = "Commission";
				}else if($searchKey == "Referral Bonus"){
					$search_term = "Referral Bonus";
				}else if($searchKey == "Withdraw Request Amount"){
					$search_term = "Withdraw Request Amount";
				}else if($searchKey == "Withdrawn Amount"){
					$search_term = "Withdrawn Amount";
				}else if($searchKey == "Received Amount"){
					$search_term = "Received Amount";
				}else if($searchKey == "Pay For My Friend"){
					$search_term = "Pay For My Friend";
				}else if($searchKey == "Transfer To Crypto Wallet"){
					$search_term = "Transfer To Crypto Wallet";
				}else if($searchKey == "Renewal Package"){
					$search_term = "Renewal Package";
				}else{
					$search_term = "";
				} 
				
				$transactionsList = Transactions::leftjoin('users AS sender','transactions.sender_id','=','sender.rec_id')->leftjoin('users AS receiver','transactions.receiver_id','=','receiver.rec_id')->leftjoin('packages AS p','p.id','=','transactions.package_id')->select('transactions.rec_id','transactions.transaction_no','transactions.received_date','transactions.ttype','transactions.package_id','transactions.status','transactions.credit','transactions.debit','transactions.balance','transactions.description','sender.user_id AS sender','receiver.user_id AS receiver',DB::raw("CONCAT(sender.first_name,' ',sender.last_name) AS sender_name"),DB::raw("CONCAT(receiver.first_name,' ',receiver.last_name) AS receiver_name"),'transactions.user_id','transactions.sender_id','transactions.receiver_id','p.package_name')->where('transactions.user_id', $userInfo['rec_id'])->where('transactions.ttype','=',$search_term )->orderBy('transactions.rec_id', 'DESC')->skip($page * $limit)->take($limit)->get();
				
			}else{
				
				
				$transactionsList = Transactions::leftjoin('users AS sender','transactions.sender_id','=','sender.rec_id')->leftjoin('users AS receiver','transactions.receiver_id','=','receiver.rec_id')->leftjoin('packages AS p','p.id','=','transactions.package_id')->select('transactions.rec_id','transactions.transaction_no','transactions.received_date','transactions.ttype','transactions.package_id','transactions.status','transactions.credit','transactions.debit','transactions.balance','transactions.description','sender.user_id AS sender','receiver.user_id AS receiver',DB::raw("CONCAT(sender.first_name,' ',sender.last_name) AS sender_name"),DB::raw("CONCAT(receiver.first_name,' ',receiver.last_name) AS receiver_name"),'transactions.user_id','transactions.sender_id','transactions.receiver_id','p.package_name')->where('transactions.user_id', $userInfo['rec_id'])->orderBy('transactions.rec_id', 'DESC')->skip($page * $limit)->take($limit)->get();
				
			}
			
			
			if(@count($transactionsList)>0){
				$transactions = array();
				
				foreach($transactionsList as $res){
					
					$withdraw_id = $res['rec_id'];
					$cryptoInfo = Withdraw_request::select('*')->where('withdraw_id','=',$withdraw_id)->first();
					if(!empty($cryptoInfo)){
						$withdraw_trans_no = $cryptoInfo->transaction_no;
						$wallet_type = $cryptoInfo->wallet_type;
						$wallet_address = $cryptoInfo->wallet_address;
						$transaction_hash = $cryptoInfo->transaction_hash;
						
						if($cryptoInfo->status == 1){
							$wall_status_msg = "In-Progress";	
						}else{
							$wall_status_msg = "Completed";
						}
						
						if($cryptoInfo->admin_response_date == "0000-00-00 00:00:00"){
							$admin_approved_date = "";
						}else{
							$admin_approved_date = UserController::convertDateToUTCForAPI($cryptoInfo->admin_response_date);
						}
						if($cryptoInfo->credit_crypto_amt == 0.00000000){
							$credit_crypto_amt = "";	
						}else{
							$credit_crypto_amt = number_format($cryptoInfo->credit_crypto_amt,8);
						}
						
						
						
					}else{
						$withdraw_trans_no = "";
						$wallet_type = "";
						$wallet_address = "";
						$transaction_hash = "";
						$wall_status_msg = "";
						$admin_approved_date = "";
						$credit_crypto_amt = "";
					}
					
						
					$date = UserController::convertDateToUTCForAPI($res['received_date']); 
					$type = $res['ttype'];
					$package_id = $res['package_id'];
					$pack = Packages::where("id",$package_id)->first();
					if(!empty($pack)){
						$package_name = $pack->package_name;	
					}else{
						$package_name = "";
					}
					if($res['status'] == 1){
						$status_msg = "Success";
					}else{
						$status_msg = "Failure";
					}
					
					if($res['credit'] == 0.00){
						$credit_amt = "";
						$bg_color1 = "red";
						//$transaction_in_image = "";
						$transaction_image = "transaction-out.png";
					}else{
						$credit_amt = "+ $".number_format($res['credit'],2);
						$bg_color1 = "green";
						$transaction_image = "transaction-in.png";
					}
					
					if($res['debit'] == 0.00){
						$debit_amt = "";
						//$bg_color1 = "red";
						//$transaction_out_image = "";
					}else{
						$debit_amt = "- $".number_format($res['debit'],2);
						//$bg_color1 = "red";
						//$transaction_out_image = "transaction-out.png";
					}
					
					
					$balance = "$".number_format($res['balance'],2);
					
					/*if($res['ttype'] == 'Pay For My Friend'){
						$user_id = $res['receiver'];
						$name = $res['receiver_name'];
					}else{
						$user_id = $res['sender'];
						$name = $res['sender_name'];
					}*/
					
					if( ($res['sender_id'] == $res['user_id']) && ($res['user_id'] == $userInfo['rec_id']) ){
						$user_id = $res['receiver'];
						$name = $res['receiver_name'];
					}else{
						$user_id = $res['sender'];
						$name = $res['sender_name'];
					}
					
					
					//$BestBOX_Package = "";
					$Payment_ID = $res['transaction_no'];
					$description = $res['description'];
					
					$payment_history = PaymentsHistory::where(['transaction_no' => $res['transaction_no']])->first();
					$class = 'green_btn';
					if(!empty($payment_history)){
						$is_paytype = 1; // 1- everus pay ,0 - others
						if( $payment_history->transaction_status == 'waiting') {
							$status_msg = 'Waiting';$class = 'orange_btn';
						}
						
						$merchant_id = $payment_history['merchant_id'] != '' ? $payment_history['merchant_id'] : '';
						
						$email = $payment_history['buyer_email'] != '' ? $payment_history['buyer_email'] : '';
						
						$payment_ref = $payment_history['order_id'] != '' ? $payment_history['order_id'] : '';
						
						$everuspay_id = $payment_history['payment_reference'] != '' ? $payment_history['payment_reference'] : '';
						
						$payer_wallet_address = $payment_history['wallet_address'] != '' ? $payment_history['wallet_address'] : '';
						
						$transaction_hash = $payment_history['transaction_hash'] != '' ? $payment_history['transaction_hash'] : '';
						
						$payment_remarks = $payment_history['paid_status'] != '' ? ucwords($payment_history['paid_status']) : '';
						
						$transaction_amount = $payment_history['amount_in_usd'] != '' ? $payment_history['amount_in_usd'] : '-'." USD | ".$payment_history['amount_in_crypto'] != '' ? $payment_history['amount_in_crypto'] : '-'." ".$payment_history['crypto'];
						
						$blockChain_fee = $payment_history['processing_fee_usd'] != '' ? number_format($payment_history['processing_fee_usd'],2) : '0.00'." USD ".$payment_history['processing_fee'] != '' ? $payment_history['processing_fee'] : '0.00'." ".$payment_history['crypto'];
						
						$total_amount = $payment_history['amount_in_usd']+$payment_history['processing_fee_usd'];
                        $total_amount_crypto = $payment_history['amount_in_crypto']+$payment_history['processing_fee'];
						
						$total = $total_amount." USD | ".$total_amount_crypto." ".$payment_history['crypto'];
						
						
					}else{
						$is_paytype = 0;
						$merchant_id = "";
						$email = "";
						$payment_ref = "";
						$everuspay_id = "";
						$payer_wallet_address = "";
						$payment_remarks = "";
						$transaction_amount = "";
						$blockChain_fee = "";
						$total = "";
					}
					
					if($is_paytype == 1){
						$type = "Everus pay";	
					}
					
					$transactions[] = array(
									"date"=>$date,
									"transaction_details"=>$type,
									"status"=>$status_msg,
									"transaction_image"=>$transaction_image,
									"bg_color"=>$bg_color1,
									"transaction_in_USD"=>$credit_amt,
									"transaction_out_USD"=>$debit_amt,
									"credit_balance"=>$balance,
									"user_id"=>$user_id,
									"name"=>$name,
									"bestbox_package"=>$package_name,
									"payment_ID"=>$Payment_ID,
									"description"=>$description,
									"crypto_trans_id"=>$withdraw_trans_no,
									"wallet_type"=>strtoupper($wallet_type),
									"wallet_address"=>$wallet_address,
									"crypto_status_msg"=>$wall_status_msg,
									"credit_crypto_amt"=>$credit_crypto_amt,
									"transaction_hash"=>$transaction_hash,
									"admin_approved_date"=>$admin_approved_date,
									"is_paytype"=>$is_paytype,
									"merchant_id"=>$merchant_id,
									"email"=>$email,
									"payment_ref"=>$payment_ref,
									"everuspay_id"=>$everuspay_id,
									"payer_wallet_address"=>$payer_wallet_address,
									"transaction_amount"=>$transaction_amount,
									"blockChain_fee"=>$blockChain_fee,
									"total"=>$total,
									
									'currency_symbol'=>'$',
									'currency_format'=>'USD'
									);
					
				}
				return response()->json(['status' => 'Success','total_wallet_balance'=>$walletBalance,'Result' => $transactions], 200);
			}else{
				return response()->json(['status'=>'Failure','total_wallet_balance'=>$walletBalance,'Result'=>"No Records Found" ], 200);
			}
		
		}
	
		
	}
	

	
	
	
}
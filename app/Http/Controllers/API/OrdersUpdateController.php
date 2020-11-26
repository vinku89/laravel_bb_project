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
use App\Purchase_order_details;
use Illuminate\Support\Facades\Log;
class OrdersUpdateController extends Controller
{
	
	public function getOrdersList(Request $request)
	{
		$userInfo = $request->user();
		$login_userid = $userInfo['rec_id'];
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
			
			
			if (!empty($from_date) && !empty($to_date)) {
				
				$start = Carbon::parse($from_date)->format('Y-m-d H:i:s');
				$todate = Carbon::parse($to_date)->format('Y-m-d H:i:s');
				$to = date('Y-m-d H:i:s', strtotime($todate . ' +1 day'));
				
				$orders = Purchase_order_details::leftJoin('users','purchase_order_details.user_id','=','users.rec_id')
							->select('users.rec_id','users.user_id','users.email','users.first_name','users.last_name','purchase_order_details.order_id','purchase_order_details.attachment','purchase_order_details.purchased_date')
							->where(['purchase_order_details.user_id' => $login_userid])
							->whereBetween('purchase_order_details.purchased_date',[$start, $to])
							->orderBy('purchase_order_details.purchased_date','DESC')
							->skip($page * $limit)->take($limit)->get();
				
			}else{
				$orders = Purchase_order_details::leftJoin('users','purchase_order_details.user_id','=','users.rec_id')
							->select('users.rec_id','users.user_id','users.email','users.first_name','users.last_name','purchase_order_details.order_id','purchase_order_details.attachment','purchase_order_details.purchased_date')
							->where(['purchase_order_details.user_id' => $login_userid])
							->orderBy('purchase_order_details.purchased_date','DESC')
							->skip($page * $limit)->take($limit)->get();
				
			}
			
			
			if(@count($orders)>0){
				$ordersList = array();
				
				foreach($orders as $res){
					$ordered_date = UserController::convertDateToUTCForAPI($res['purchased_date']); //date("d/m/Y, h:i a", strtotime($res['added_date']));
					$fullName = ucwords($res['first_name']." ".$res['last_name']);
					$user_id = $res['user_id'];
					if(!empty($res['attachment'])){
						$attachement_path = url('/public/invoices').'/'.$res['attachment'];	
					}else{
						$attachement_path = "";
					}
					
					
					$ordersList[] = array(
									"rec_id"=>$res['rec_id'],
									"date"=>$ordered_date,
									"user_name"=>$fullName,
									"user_id"=>$user_id,
									"email"=>$res['email'],
									"order_id"=>$res['order_id'],
									"order_icon"=>url('/').'/public/mobile_menu_icons/updateorder-inactive.png',
									"attachement_path"=>$attachement_path,
									'currency_symbol'=>'$',
									'currency_format'=>'USD'
									);
					
				}
				return response()->json(['status' => 'Success', 'Result' => $ordersList], 200);
			}else{
				return response()->json(['status'=>'Failure','Result'=>"No Records Found" ], 200);
			}
		
		}
	
		
	}
	
	// Update Orders List
	public function updateOrderInfo(Request $request)
	{ 
		//print_r($request->all());exit;
		//echo request('app_name');exit;
		$userInfo = $request->user();
		$login_userid = $userInfo['rec_id'];
		
		$response = array();
		
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
		$validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
            'payment_id' => 'required',
			'attached_status' => 'required',
        ]);
		if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);            
        }else{
			$payment_id = request('payment_id');
			$attached_status = request('attached_status');
			
			
			
			if ($attached_status == "yes") 
			{
				if ($request->has('invoice_attachment')) 
				{
					//echo "teste";exit;
					$image = $request->file('invoice_attachment');
					Log::info("attachecd_image_name = " . $request->file('invoice_attachment')->getClientOriginalName());
					$org_name = $image->getClientOriginalName();
					//Log::info("attachecd_image_name = " . $org_name );
					$exts = explode('.', $org_name);
					if (count($exts) == 2) {
						$fileType = $image->getClientOriginalExtension();
						$fileTyp = strtolower($fileType);
						$fileData = array('image' => $image);
						$allowedTypes = array("jpeg", "jpg", "png");
						if (in_array($fileTyp, $allowedTypes)) {
							$rules = array('image' => 'required|max:200000|mimes:png,jpg,jpeg');
							$validator = Validator::make($fileData, $rules);
							if ($validator->fails()) {
								return response()->json(['status'=>'Failure','Result'=>'Upload only JPEG,JPG,PNG images only with lessthan 20MB.'], 200);
								
							}else{
								
								$fileName = 'INV-'.rand(999,9999999).time().'.'.$image->getClientOriginalExtension();
								$destinationPath = base_path('/public/invoices');
								$upload_success = $image->move($destinationPath, $fileName);
								
								if ($upload_success) {
									$data = array('attachment' => $fileName, 'order_id' => $payment_id, 'purchased_from' => 'Ali Express','purchased_date' =>date('Y-m-d H:i:s'),'status' => 1, 'user_id' => $login_userid, 'sender_id' => $login_userid,'updated_at' => date('Y-m-d H:i:s'));
									
									$res = Purchase_order_details::create($data);
									return response()->json(['status' => 'Success', 'Result' => 'Thank you for your purchase. We shall endeavour to action this at the earliest. Please feel free to try our numerous chains of support media, Email, WhatsApp, in Site chat box.However, please note that the activation / response can take between 30 mins to 8 hours.Thank you for choosing BestBOX'], 200);
								} else {
									return response()->json(['status' => 'Failure', 'Result' => 'Something went wrong in Uploading image'], 200);
								}
								
							} 
						}else{
							return response()->json(['status'=>'Failure','Result'=>'Invalid image file'], 200);
						}
					}else{
						return response()->json(['status'=>'Failure','Result'=>'Invalid image file'], 200);
					}
				}else{
					return response()->json(['status'=>'Failure','Result'=>'Image name missing'], 200);
				}
			}else{
				
				$data = array('attachment' => '', 'order_id' => $payment_id, 'purchased_from' => 'Ali Express','purchased_date' =>date('Y-m-d H:i:s'),'status' => 1, 'user_id' => $login_userid, 'sender_id' => $login_userid,'updated_at' => date('Y-m-d H:i:s'));
					
				$res = Purchase_order_details::create($data);
				return response()->json(['status' => 'Success', 'Result' => 'Thank you for your purchase. We shall endeavour to action this at the earliest. Please feel free to try our numerous chains of support media, Email, WhatsApp, in Site chat box.However, please note that the activation / response can take between 30 mins to 8 hours.Thank you for choosing BestBOX'], 200);
				
				
			}
		}
		
	}
	
	

	
	
	
}
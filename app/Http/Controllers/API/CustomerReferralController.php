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
class CustomerReferralController extends Controller
{
	public function getCustomerReferralsList(Request $request)
	{
		$userInfo = $request->user();
		$user_role = $userInfo['user_role'];
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
			$searchKey = request('searchKey');
			
			// get sum Bonus(Referalls earnings)
		   $referred_earnings = Commissions::where("user_id",$userInfo['rec_id'])->where("commission_type",'=','Referral Bonus')->sum('commission');
		   $total_referred_earnings = number_format($referred_earnings,2);
			
			if(!empty($searchKey)){
			
				if (!empty($searchKey) && filter_var($searchKey, FILTER_VALIDATE_EMAIL)) {
					
					$refferalsList = Commissions::leftjoin('users','commissions.sender_user_id','=','users.rec_id')->where('commissions.user_id',$userInfo['rec_id'])->where('commissions.commission_type','Referral Bonus')->where('users.email',$searchKey)->select('users.rec_id','users.registration_date','users.first_name','users.last_name','users.email','users.user_id','users.refferallink_text','users.telephone','users.image','commissions.commission','commissions.description','commissions.commission_type','commissions.added_date')->orderBy("commissions.rec_id", "DESC")->skip($page * $limit)->take($limit)->get();
					
				}else{
					
					$refferalsList = Commissions::leftjoin('users','commissions.sender_user_id','=','users.rec_id')
									->where('commissions.user_id',$userInfo['rec_id'])
									->where('commissions.commission_type','Referral Bonus')
									//->where('users.refferallink_text',$searchKey)
									->where(DB::raw('concat(users.first_name," ",users.last_name)'), 'LIKE', '%' . $searchKey . '%')
									->select('users.rec_id','users.registration_date','users.first_name','users.last_name','users.email','users.user_id','users.refferallink_text','users.telephone','users.image','commissions.commission','commissions.description','commissions.commission_type','commissions.added_date')
									->orderBy("commissions.rec_id", "DESC")
									->skip($page * $limit)->take($limit)->get();
				}
				
				
			}else{
			
				$refferalsList = Commissions::leftjoin('users','commissions.sender_user_id','=','users.rec_id')->where('commissions.user_id',$userInfo['rec_id'])->where('commissions.commission_type','Referral Bonus')->select('users.rec_id','users.registration_date','users.first_name','users.last_name','users.email','users.user_id','users.refferallink_text','users.telephone','users.image','commissions.commission','commissions.description','commissions.commission_type','commissions.added_date')->orderBy("commissions.rec_id", "DESC")->skip($page * $limit)->take($limit)->get();
				
			}
				
			
				
			
			$total_earned_amt = 0;
			//$total_commision_amount = 0;
			if(@count($refferalsList)>0){
				$referredUsers = array();
				
				foreach($refferalsList as $res){
					$rec_id = $res['rec_id'];
					
					$registration_date = UserController::convertDateToUTCForAPI($res['added_date']);
					$fullName = $res['first_name']." ".$res['last_name'];
					$customerID = $res['user_id'];
					$email = $res['email'];
					$telephone = $res['telephone'];
					$profileImage = $res['image'];
					if(!empty($profileImage)){
						$profile_pic = 	$profileImage;
					}else{
						$profile_pic = "";
					}
					
					$pkg = Package_purchase_list::where('user_id','=',$rec_id)->where('active_package','=',1)->first();
					if(!empty($pkg)){
						$package_id =$pkg->package_id; 
						$pkgDetails = Packages::where("id",$package_id)->first();
						$package_amt = number_format($pkgDetails->effective_amount,2);
						$is_pkg_purchased = TRUE;
					}else{
						$package_amt = "";
						$is_pkg_purchased = FALSE;
					}
					
					$reffed_amt = $res['commission'];
					$transaction_details = $res['commission_type'];
					$description = $res['description'];
					
					$referredUsers[] = array(
								
								"registration_date"=>$registration_date,
								"customer_name"=>$fullName,
								"customer_id"=>$customerID,
								"email"=>$email,
								"mobile_no"=>$telephone,
								"profile_pic"=>$profile_pic,
								"package_amt"=>$package_amt,
								"earned_amt"=>number_format($reffed_amt,2),
								"transaction_details"=>$transaction_details,
								"description"=>$description,
								'currency_symbol'=>'$',
								'currency_format'=>'USD'
								);
					
					
					
				}
				return response()->json(['status' => 'Success','total_earned_amt'=>$total_referred_earnings, 'Result' => $referredUsers], 200);
			}else{
				return response()->json(['status'=>'Failure','total_earned_amt'=>$total_referred_earnings,'Result'=>"No Records Found" ], 200);
			}
		
		}
	
		
	}
	

	
	
	
}
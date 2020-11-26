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
use App\Unilevel_tree;
use App\Http\Controllers\API\CustomersController;
use App\Settings;


class RegistrationController extends Controller
{
	
	
	public function customerSignup(Request $request)
	{
		//$userInfo = $request->user();
		//print_r($data);exit;
        
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
        $validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
            'email' => 'required|email|unique:users',
			'first_name' => 'required',
			'last_name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);            
        }else{
			
			$email = request('email');
			$first_name = request('first_name');
			$last_name = request('last_name');
			$referral_Id = request('referral_Id');
			
			if(!empty($referral_Id)){
        		$referralId = $referral_Id;
        	}else{
        		$referralId = 'SUP12345';//super admin
        	}
			$ref_userInfo = User::where('refferallink_text',$referralId)->first();
			
			if(!empty($ref_userInfo)){
				$referral_userid = $ref_userInfo->rec_id;
	        	

				$userId = CustomersController::generateCustomerId($first_name);
				$us_cnt = User::where('user_id', $userId)->count();
		        if($us_cnt == 1){
		            $user_id = CustomersController::generateCustomerId($first_name);
		        }else{
		            $user_id = $userId;
		        }
				$ref_code = CustomersController::generateReferralCode($first_name);
				$ref_cnt = User::where('refferallink_text', $ref_code)->count();
		        if($ref_cnt == 1){
		            $referral_code = CustomersController::generateReferralCode($first_name);
		        }else{
		            $referral_code = $ref_code;
		        }
				
				$user= User::create([
					'user_id' => $user_id,
					'referral_userid' => $referral_userid,
					'first_name' => $first_name,
					'last_name' => $last_name,
					'email' => $email,
					'refferallink_text' => $referral_code,
		            'user_role' => 4,
		            'status' => 1,
		            'registration_date' =>date('Y-m-d H:i:s'),
		            'referral_join' => 1
				]);
				$last_inserted_id = $user->rec_id;

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
						'admin_id' => 1000
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

				$data['useremail'] = array('name'=>$first_name.' '.$last_name,'customer_id'=>$user_id,'user_id'=>$last_inserted_id,'toemail'=>$email,'referral_link'=>$referral_code);   
		        $emailid = array('toemail' => $email);
		        Mail::send(['html'=>'email_templates.referral-join'], $data, function($message) use ($emailid) {
			        $message->to($emailid['toemail'], 'Email Verify')->subject
			        ('Email Verify');
			        $message->from('support@bestbox.net','BestBox');
		        });

				return response()->json(['status'=>'Success','Result'=>"Thanks for registering with us , we have sent verification email to register email id please check and proceed ."], 200);
				
			}else{
				 
				return response()->json(['status'=>'Failure','Result'=>"Referral User Id Not Valid."], 200);
			}
			
		
		}
	
		
	}
	
	public function checkEmailExistOrNot(Request $request)
	{
		
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		} 
        $validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
            'email' => 'required|email|unique:users',
		]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);            
        }else{ 
			return response()->json(['status'=>'Success','Result'=>"Email available"], 200); 
		}
		
	}
	
	public function sampleTest(Request $request)
	{
		$version_info = Settings::where('id','=',1)->orderBy('id','DESC')->first(); 
		$apkurl = url('/').'/tvapp';
		$data = array(
					"newVersion"=>"$version_info->android_app_code",
					"apkUrl"=>$apkurl,
					"versionNotes"=>["- Issues fix"]
					);
		return response()->json($data, 200); 
		
	}
	
	public function apkVersion(Request $request)
	{
		$version_info = Settings::where('id','=',1)->orderBy('id','DESC')->first(); 
		if(!empty($version_info)){
			$version = $version_info->android_app_version;	
		}else{
			$version = "0";
		}
		$data = array(
					"apk_version"=>"$version"
					);
		return response()->json($data, 200); 
		
	}
	
	public function appDownload(Request $request)
	{
		//"http://staging.bestbox.net/tvapp"
		$apkurl = url('/').'/tvapp';
		$data = array(
					"latestVersion"=>"1.1",
					"latestVersionCode"=>"2",
					"apkUrl"=>$apkurl, 
					"releaseNotes"=>["Issues fix","Second evolution","Bug fixes"]
					);
		return response()->json($data, 200); 
		
	}
	

	
	
	
}
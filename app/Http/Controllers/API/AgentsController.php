<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;


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
use App\Unilevel_tree;
class AgentsController extends Controller
{
	// get all agents list based on reseller
	public function getAgentsList(Request $request)
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
            'page' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);            
        }else{
			$limit = 20;
			$page = request('page');
			$searchKey = request('searchKey');
			
			if(!empty($searchKey)){
			
				if (!empty($searchKey) && filter_var($searchKey, FILTER_VALIDATE_EMAIL)) {
					
				$agentsList = User::where('user_role','=',3)->where('status','=',1)->where('email','=',$searchKey)->where('referral_userid',$userInfo['rec_id'])->orderBy("rec_id", "DESC")->skip($page * $limit)->take($limit)->get();
				
				}else{
				
					$agentsList = User::where('user_role','=',3)->where('status','=',1)->where(DB::raw('concat(first_name," ",last_name)'), 'LIKE', '%' . $searchKey . '%')->where('referral_userid',$userInfo['rec_id'])->orderBy("rec_id", "DESC")->skip($page * $limit)->take($limit)->get();
				}
				
			}else{
				$agentsList = User::where('user_role','=',3)->where('status','=',1)->where('referral_userid',$userInfo['rec_id'])->orderBy("rec_id", "DESC")->skip($page * $limit)->take($limit)->get();
			}
			
			
			
			if(@count($agentsList)>0){
				$agaents = array();
				foreach($agentsList as $res){
					$username = $res['first_name']." ".$res['last_name'];
					
					if(!empty($res['commission_perc'])){
						$commision_per = $res['commission_perc'];
					}else{
						$commision_per = 0;
					}
					$profileImage = $res['image'];
					if(!empty($profileImage)){
						$profile_pic = 	$profileImage;
					}else{
						$profile_pic = "";
					}
					
					$countryInfo = Country::select('*')->where('countryid', '=',$res['country_id'])->first();
					if(!empty($countryInfo)){
						$countryName = 	$countryInfo->country_name;
						$nationality = 	$countryInfo->nationality;
					}else{
						$countryName = "";
						$nationality = "";
					}
					$agaents[] = array(
									"rec_id"=>$res['rec_id'],
									"agent_id"=>$res['user_id'],
									"referral_userid"=>$res['referral_userid'],
									"first_name"=>$res['first_name'],
									"last_name"=>$res['last_name'],
									"email"=>$res['email'],
									"status"=>$res['status'],
									"mobile_no"=>$res['telephone'],
									"gender"=>$res['gender'],
									"profile_pic"=>$profile_pic,
									"married_status"=>$res['married_status'],
									"zipcode"=>$res['zipcode'],
									"country_id"=>$res['country_id'],
									"countryName"=>$countryName,
									"address"=>$res['address'],
									"address2"=>$res['address2'],
									"commission"=>$commision_per,
									"commission_symbol"=>"%",
									'refferallink_text' => $res['refferallink_text'],
									'currency_symbol'=>'$',
									'currency_format'=>'USD'
									);
					
				}
				return response()->json(['status' => 'Success', 'Result' => $agaents], 200);
			}else{
				return response()->json(['status'=>'Failure','Result'=>"No Agents Found" ], 200);
			}
		
		}
		
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

	
	// Create New Agent 
	public function creatNewAgent(Request $request)
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
            'email' => 'required',
			'first_name' => 'required',
			'last_name' => 'required',
			'gender' => 'required',
			'married_status' => 'required',
			'address' => 'required',
			'address2' => 'required',
			'country_id' => 'required',
			'mobile_no' => 'required',
			'commision_per' => 'required',
			'zipcode' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);            
        }else{
			
			$email = request('email');
			$checkEmailExistOrNot = User::where('email', '=', $email)->first();
			if (@count($checkEmailExistOrNot)>0) {
				return response()->json(['status'=>'Failure','Result'=>"Email already exists"], 200);  
			}else{
				$first_name = request('first_name');
				$last_name = request('last_name');
				$gender = request('gender');
				$married_status = request('married_status');
				$address = request('address');
				$address2 = request('address2');
				$country_id = request('country_id');
				$mobile_no = request('mobile_no');
				
				$countryInfo = Country::select('*')->where('countryid', '=',$country_id)->first();
				if(!empty($countryInfo)){
					$currencycode = 	$countryInfo->currencycode;
					
				}else{
					$currencycode = "";
					
				}
				
				//$telephone = "+".$currencycode."-".$mobile_no;
				$telephone = $mobile_no;
				$commision_per = request('commision_per');
				$zipcode = request('zipcode');
				
				$name=$first_name."".$last_name;
				$userId = self::generateUserId('AGT',$name);
				$us_cnt = User::where('user_id', $userId)->count();
				if($us_cnt == 1){
					$user_id = self::generateUserId('AGT',$name);
				}else{
					$user_id = $userId;
				}
				
				$ref_code = self::generateReferralCode($name);
				$ref_cnt = User::where('refferallink_text', $ref_code)->count();
				if($ref_cnt == 1){
					$referral_code = self::generateReferralCode($name);
				}else{
					$referral_code = $ref_code;
				}
				
				$user= User::create([
					'user_id' => $user_id,
					'referral_userid' => $userInfo['rec_id'],
					'first_name' => $first_name,
					'last_name' => $last_name,
					'email' => $email,
					'country_id' =>$country_id,
					'gender' =>$gender,
					'married_status' =>$married_status,
					'registration_date' => date('Y-m-d H:i:s'),
					'address' => $address,
					'address2' => $address2,
					'zipcode' => $zipcode,
					'telephone' => $telephone,
					'user_role' => 3,
					'status' => 1,
					'refferallink_text' => $referral_code,
					'commission_perc' => $commision_per
				]);
				$last_inserted_id = $user->rec_id;

				$wallet= Wallet::create([
					'user_id' => $last_inserted_id,
					'amount' => 0
				]);
				Users_tree::create([
					'agent_id' => $last_inserted_id,
					'reseller_id' => $userInfo['rec_id']
				]);
				
				$l=1;
				$nom=$userInfo['rec_id'];
				$user_role=3;
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
				
				$data['useremail'] = array('name'=>$name,'user_id'=>$last_inserted_id,'toemail'=>$email,'type'=>"Agent",'referral_link'=>$referral_code);   
				$emailid = array('toemail' => $email);
				Mail::send(['html'=>'email_templates.verify-email'], $data, function($message) use ($emailid) {
					$message->to($emailid['toemail'], 'Email Verify')->subject
					('Email Verify');
					$message->from('support@bestbox.net','BestBox');
				});
			
				return response()->json(['status' => 'Success', 'Result' => "We sent verify link your registered email,please verify."], 200);
			
			}
			
		
		}
		
	}
	
	// update Agent info
	public function updateAgentInfo(Request $request)
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
			'married_status' => 'required',
			'address' => 'required',
			'address2' => 'required',
			'commision_per' => 'required',
			'country_id' => 'required',
			'mobile_no' => 'required',
			'zipcode' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);            
        }else{
		
			$rec_id = request('rec_id');
			
			$first_name = request('first_name');
			$last_name = request('last_name');
			$gender = request('gender');
			$married_status = request('married_status');
			$address = request('address');
			$address2 = request('address2');
			$country_id = request('country_id');
			$mobile_no = request('mobile_no');
			
			$countryInfo = Country::select('*')->where('countryid', '=',$country_id)->first();
			if(!empty($countryInfo)){
				$currencycode = 	$countryInfo->currencycode;
			}else{
				$currencycode = "";
			}
			
			$telephone = "+".$currencycode."-".$mobile_no;
			
			$commision_per = request('commision_per');
			$zipcode = request('zipcode');
			
			$data = [
						'first_name' => $first_name,
						'last_name' => $last_name,
						'gender' =>$gender,
						'married_status' =>$married_status,
						'address' => $address,
						'address2' => $address2,
						'commission_perc' => $commision_per,
						'zipcode' => $zipcode,
						'telephone' => $telephone
					];
					
			$res = User::where('rec_id','=',$rec_id)->update($data);		
			if($res){
				return response()->json(['status' => 'Success', 'Result' => "Agent Info Updated successfully"], 200);	
			}else{
				return response()->json(['status'=>'Failure','Result'=>"something went wrong" ], 200);
			}
		}
		
	}
	
	// delete Agent
	public function deleteAgent(Request $request)
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
				return response()->json(['status' => 'Success', 'Result' => "Agent deleted successfully"], 200);	
			}else{
				return response()->json(['status'=>'Failure','Result'=>"something went wrong" ], 200);
			}
		}
		
	}
	
	// get Countries List
	public function getCountriesList(Request $request)
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
            
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);            
        }else{
				
			$results = Country::where('country_status','=',1)->orderBy("country_name", "ASC")->get();
			$cntrylist = array();
			if(!empty($results)){
				foreach($results as $res){
					$cntrylist[] = array(
									"countryid"=>$res->countryid,
									"country_name"=>$res->country_name,
									"currencycode"=>$res->currencycode,
									);	
				}	
				
				return response()->json(['status' => 'Success', 'Result' =>$cntrylist], 200);
				
			}else{
				return response()->json(['status'=>'Failure','Result'=>$cntrylist ], 200);
			}
		}
		
	}
	
	
}
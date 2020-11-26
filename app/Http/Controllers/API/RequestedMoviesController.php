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
use App\User_requested_movies;
use App\Free_trail_cms_accounts;
use App\Free_trail_requested_users;
use App\ApplicationSettings;
use App\Packages;
use App\Package_purchase_list;
class RequestedMoviesController extends Controller
{
	
	public function saveRequestedMovies(Request $request)
	{
		$userInfo = $request->user();
		$rec_id = $userInfo['rec_id'];
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
        $validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
			'movie_names' => 'required'
			]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);            
        }else{
			$app_name = request('app_name');
        	$movie_names = request('movie_names');
			$requested_date = date('Y-m-d H:i:s');
			$moviesList = explode(",", $movie_names);
			foreach($moviesList as $movie_name){
				$res = User_requested_movies::create([
					'user_id' => $rec_id,
					'requested_movies' => $movie_name,
					'requested_date' => $requested_date,
				]);
				$last_inserted_id = $res->rec_id;
			}
			
			
			
			return response()->json(['status' => 'Success', 'Result' => "Thanks, Your requested movie is available  soon",'user_id'=>$rec_id,'last_inserted_id'=>$last_inserted_id], 200);
			
        }
    }
	
	// Free trail requested API
	
	public function freeTrailRequestedAPI(Request $request)
	{
		$userInfo = $request->user();
		$rec_id = $userInfo['rec_id'];
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
        	//check trail period already taken or not
			//$checkTrailsCount = Free_trail_cms_accounts::where("request_status","=",1)->where("user_id","=",$rec_id)->count();
			//if()
			$requested_date = date('Y-m-d H:i:s');
			$res = Free_trail_requested_users::create([
					'user_id' => $rec_id,
					'trail_requested_time' => $requested_date,
				]);
				
			
			return response()->json(['status' => 'Success', 'Result' => 'Thank you for requesting free trial'], 200);
			
        }
    }
	
	// check channel available or not
	public function freeTrailThankyouRequest(Request $request)
	{
		$userInfo = $request->user();
		$rec_id = $userInfo['rec_id'];
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
        	//check available channels count
			$available_channels_count = Free_trail_cms_accounts::where("is_available","=",1)->where("status","=",1)->count();
			if($available_channels_count > 0)
			{
				
				return response()->json(['status' => 'Success', 'Result' => 'Your BestBox free trial is now Active','is_available'=>1 ], 200);
			}else{
			
				$data = array("is_pending"=>1 );
				$res = Free_trail_requested_users::where('user_id','=',$rec_id)->update($data);
				return response()->json(['status' => 'Failure', 'Result' => 'Free Trial Activation Pending','is_available'=>0 ], 200);
			}
			
        }
    }
	
	// check channel available or not
	public function freeTrailStartRequest(Request $request)
	{
		$userInfo = $request->user();
		$rec_id = $userInfo['rec_id'];
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
        	
			//$available_channels_count = Free_trail_cms_accounts::where("is_available","=",1)->count();
			
			$available_channels_info = Free_trail_cms_accounts::where("status","=",1)->orderBy("rec_id", "DESC")->first();
			if(!empty($available_channels_info)){
			
				$channel_id = $available_channels_info->rec_id;
				$cms_username = $available_channels_info->cms_username;
				$cms_password = $available_channels_info->cms_password;
				
				// update cms account is_available status
				$data2 = array("is_available"=>0);
				$res = Free_trail_cms_accounts::where('rec_id','=',$channel_id)->update($data2);
				
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
								
				//update user table
				$data3 = array("cms_username"=>$cms_username,"cms_password"=>$cms_password,"is_trail"=>1);
				
				$free_req_user = Free_trail_requested_users::where('user_id','=',$rec_id)->where('status',3)->first();
				
				if(!empty($free_req_user) && $free_req_user['status'] == 3){
					$result = User::where('rec_id','=',$rec_id)->update($data3);
					$data = array("trail_start_time"=>$trail_start_time,"trail_end_time"=>$trail_end_time,"channel_id"=>$channel_id,"status"=>1 );
				
					$res = Free_trail_requested_users::where('user_id','=',$rec_id)->update($data);
					return response()->json(['status' => 'Success', "cms_username"=>$cms_username,"cms_password"=>$cms_password,"is_trail"=>1], 200);
					
				}else{
					return response()->json(['status' => 'Failure', 'Result' => 'Your trial period has been expired'], 200);
				}
				
			}else{
				return response()->json(['status' => 'Failure', 'Result' => 'Opps! All lines are busy right now please try again after some time.Sorry for inconvenience.','is_available'=>0 ], 200);
			}
			
        }
		
		
    }
	
	// extend request

	public function freeTrailExtendRequest(Request $request)
	{
		$userInfo = $request->user();
		$rec_id = $userInfo['rec_id'];
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
			
			$checkUserExits =Free_trail_requested_users::where('user_id','=',$rec_id)->count();
			if($checkUserExits > 0){
				$extend_requested_date = date('Y-m-d H:i:s');
				$data = array("extend"=>1,"extend_requested_date"=>$extend_requested_date);
				
				$res = Free_trail_requested_users::where('user_id','=',$rec_id)->update($data);
				
				if($res)
				{
					return response()->json(['status' => 'Success', 'Result' => 'Thank you for raise extend request' ], 200);
				}else{
					return response()->json(['status' => 'Failure', 'Result' => 'Something went wrong' ], 200);
				}
				
			}else{
				return response()->json(['status' => 'Failure', 'Result' => 'User dose not exist' ], 200);
			}
        	
			
        }
    }
	
	
	
	
}
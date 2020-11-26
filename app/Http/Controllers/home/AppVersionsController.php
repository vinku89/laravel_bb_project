<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
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
use Illuminate\Support\Facades\Redirect;
use App\Settings;
use App\Free_trail_cms_accounts;
use App\Free_trail_requested_users;
use App\RolesPermissions;
use App\User_requested_movies;
use App\Recent_movies_images;
use App\Purchase_order_details;
use App\IptvConfigURLS;
use Illuminate\Support\Facades\Auth;
use App\Library\Common;
use App\Http\Controllers\API\UserController;
use App\ApplicationsInfo;
use App\ApplicationSettings;
use App\UsersDevicesList;
class AppVersionsController extends Controller
{
	
	//get Installed Versions
	public function getInstalledVersionsList(Request $request)
	{ 
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		$data['userInfo'] = $userinfo;
		
		$data['searchKey'] = $request->query('searchKey');
		
		
		
		$searchKey = $request->query('searchKey');
		if(!empty($searchKey)){
			if (filter_var($searchKey, FILTER_VALIDATE_EMAIL)) {
				$data['versions_info'] = User::where("user_role","=",4)->where("status","=",1)->where('email', $searchKey)->orderBy('rec_id','DESC')->paginate(20);
			}else{
				$data['versions_info'] = User::where("user_role","=",4)->where("status","=",1)->where('user_id', $searchKey)->orderBy('rec_id','DESC')->paginate(20);
			}
			
		}else{
			$data['versions_info'] = User::where("user_role","=",4)->where("status","=",1)->orderBy('rec_id','DESC')->paginate(20);
		}
		
		
		return view('versions_list/usersInstalledVersions')->with($data);
		
	}
	
	//forceLogout
	public function forceLogout(Request $request)
	{ 
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		$data['userInfo'] = $userinfo;
		
		$data['searchKey'] = $request->query('searchKey');
		$searchKey = $request->query('searchKey');
		
		if(!empty($searchKey)){
			if (filter_var($searchKey, FILTER_VALIDATE_EMAIL)) {
				$data['versions_info'] = User::where("user_role","=",4)->where("status","=",1)->where('email', $searchKey)->orderBy('rec_id','DESC')->paginate(30);
			}else{
				$data['versions_info'] = User::where("user_role","=",4)->where("status","=",1)->where('user_id', $searchKey)->orderBy('rec_id','DESC')->paginate(30);
			}
		}else{
			$data['versions_info'] = User::where("user_role","=",4)->where("status","=",1)->orderBy('rec_id','DESC')->paginate(30);
		}
		
		return view('versions_list/forceLogout')->with($data);
		
	}

	
	public function sendFCMForceLogout(Request $request)
	{ 
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		
		$rec_ids = Input::get("rec_ids");
		
		$usersList1 = explode(",", $rec_ids);
		foreach($usersList1 as $rec_id){
			Common::sendFCMForceLogout($rec_id);	
			User::where('rec_id', $rec_id)->update(['is_force_logout' => 1]);
		}	
		
		return response()->json(['status' => 'Success', 'Result' => 'Force logout Success'], 200);
	
	
	
	}
	
	
	
	


	

	
	

	
	

	
	


	

	
	
	
	
	
}
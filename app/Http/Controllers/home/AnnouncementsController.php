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
use App\Announcements;
use Illuminate\Support\Facades\Auth;
use App\Library\Common;
use App\ApplicationsInfo;
use App\UsersDevicesList;
class AnnouncementsController extends Controller
{
	//get all announcements
	public function getAnnouncementsList(Request $request)
	{ 
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		
		$data['searchKey'] = $request->query('searchKey');
		
		$searchKey = $request->query('searchKey');
		
		$data['announcements_info'] = Announcements::orderBy('id','DESC')->paginate(20);
		
		return view('announcements/announcementsList')->with($data);
		
	}

	// resend general announcements to users
	public function resendGeneralAnnouncement(Request $request)
	{ 
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		
		$rec_id = Input::get("rec_id");
		//$value = Input::get("value");
		$action = Input::get("action");
		$announcement_list = Announcements::where('id','=',$rec_id)->first();
		if(!empty($announcement_list)){
				$users_list = unserialize($announcement_list['users']);
				$datalist = array();
				if(!empty($users_list)){
					foreach($users_list as $user){
						$datalist[] = array('rec_id' => $user['rec_id'],'flag' => 1 );
					}
				}
				$res = Announcements::where('id',$announcement_list['id'])->update(['users' => serialize($datalist)]);
			
			return response()->json(['status' => 'Success', 'Result' => 'Announcement resent Successfully'], 200);
		}else{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid record ID'], 200);
		}

	}
	
	// send announcements to multiple users
	public function sendAnnouncmentsToAll(Request $request)
	{ 
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		
		$rec_ids = Input::get("rec_id");
		//$value = Input::get("value");
		$action = Input::get("action");
		$res = Announcements::where('id','=',$rec_ids)->first();
		if(!empty($res)){
			
			$platformtype = $res['platform_type'];
			$description = $res['description'];
			if(!empty($res['title'])){
				$title = $res['title'];
			}else{
				$title = "";
			}
			$popup = $res['popup'];
	
			if($platformtype == 'ios'){
				$condition = "ios"; 
				
			}else if($platformtype == 'android'){
				$condition = "android"; 
			}else{
				$condition = "web"; 
			}
			
			$userslist = User::select('*')->where('status','=',1)->where('mbl_platform','=',$condition)->get();
			if(@count($userslist)>0){
				foreach($userslist as $user_info){
					$user_rec_id = $user_info['rec_id'];
					$user_id = $user_info['user_id'];
					$application_id = $user_info['application_id'];
					if(!empty($user_info['telephone'])){
						$mobile = $user_info['telephone'];	
					}else{
						$mobile = "";
					}
					$platform = $user_info['mbl_platform'];
					$device_id1 = $user_info['device_id'];
					$device_id = array($user_info['device_id']);	
					
					$icon = "success.png";
					$clienticon = 'announcement.png';
					
					
					$myrtime = date("Y-m-d H:i:s");
					$temp=explode(" ",$myrtime);
					$today = $temp[0];
					$ttime=$temp[1];
					$new_time = $today."T".$ttime;
					
					$htmlMessage = $description; 
					
					
					$client_id="";$clientCode="";$htmlMessageIOS="";$MessageType="";
					if(!empty($application_id)){
						$info = ApplicationsInfo::where('application_id','=',$application_id)->first();
						if(!empty($info)){
							$client_id = $info->application_id;
							$clientCode = $info->application_name;
							$htmlMessageIOS= $clientCode.' New Announcement';
							$MessageType = $clientCode."_New_Announcement";
							
						}else{
							$client_id = 1234;
							$htmlMessageIOS='BESTBOX New Announcement';
							$MessageType = "BESTBOX_New_Announcement";
							$clientCode = "BESTBOX";
						}
					}
					
					$arr = array("Client_id" => $client_id,"ClientCode" => $clientCode,"Title" =>$title,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Announcements',"MobileNo" =>$mobile,"popup" =>$popup,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon );
					
					$json_data["AnnouncementFCM"] = json_encode($arr,JSON_UNESCAPED_SLASHES);
					
					if(!empty($user_info['device_id'])){
						/*if($platform == 'ios'){
							$res = Common::sendFCMIOS($device_id1,$json_data,$mobile, $MessageType,$htmlMessageIOS);
						}else if($platform == 'android'){
							$getAppNames = UsersDevicesList::where('user_id','=',$user_rec_id)->where('device_type','=','android')->get();
				
							if(@count($getAppNames) > 0){
								foreach ($getAppNames as $res) {
									$application_name = $res->application_name;
									$device_id = array($res->device_id); 
									$res = Common::sendFCMAndroid($device_id,$json_data,$mobile, $MessageType,$application_name);
									
								}
								
							}else{
								$res = Common::sendFCMAndroid($device_id,$json_data,$mobile, $MessageType,$client_id);
							}
							
						}*/
						
						$getAppNames = UsersDevicesList::where('user_id','=',$user_rec_id)->get();
				
						if(@count($getAppNames) > 0){
							foreach ($getAppNames as $res) {
								$user_id = $res->user_id;
								$application_name = $res->application_name;
								$device_id = array($res->device_id); 
								$device_id1 = $res->device_id;
								$device_type = $res->device_type;
								if(!empty($device_type)){
									if($device_type == "android"){
										$res = Common::sendFCMAndroid($device_id,$json_data,$mobile, $MessageType,$application_name);	
									}else{
										$res = Common::sendFCMIOS($device_id1,$json_data,$mobile, $MessageType,$htmlMessageIOS,$application_name,$user_id);
									}	
								}
							}
							
						}
						
					}
					
				}
				
				return response()->json(['status' => 'Success', 'Result' => 'Announcement send Successfully'], 200);
				/*if($res == TRUE){
					return response()->json(['status' => 'Success', 'Result' => 'Announcement send Successfully'], 200);
				}else{
					return response()->json(['status' => 'Failure', 'Result' => 'Something went wrong'], 200);
				}*/
			
			}else{
				return response()->json(['status' => 'Failure', 'Result' => 'something went wrong in FCM'], 200);	
			}
			
			
		}else{
			return response()->json(['status' => 'Failure', 'Result' => 'User ID is missing'], 200);	
		}
	
	}
	

	
	public function addNewAnnouncment(Request $request)
	{ 
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$data['userInfo'] = $userInfo;
		$data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();
		$data['userList'] = User::select('rec_id','user_id','first_name','last_name')->where(['user_role' => 4, 'status' => 1])->orderBy('rec_id','DESC')->get();
		return view('announcements/announcement-new')->with($data);
		
	}
	
	
	public function saveAnnouncmentData(Request $request)
	{ 
	
		//echo "testest 345";exit;
		
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		
		$created_at = date('Y-m-d H:i:s');
		
		//$platformtype = Input::get("platformtype");
		$title = Input::get("title");
		$description = Input::get("description");
		//$popupstatus = Input::get("popupstatus");
		$announcement_type = 2;//Input::get("announcement_type");
		$expiry_date = Input::get("expiry_date");
		$user_data =  Input::get("users_list");
		// if($expiry_date == ''){
		// 	$expiry_date = date("Y-m-d");
			
		// }else{
			if($expiry_date!=''){
				$expiry_date = date("Y-m-d", strtotime($expiry_date));
			}
			if(!empty($user_data)){
				foreach($user_data as $rec) {
					$user_list[] = array('rec_id' => $rec, 'flag' => 1); 
				}
				$user_list = serialize($user_list);
			}
		//}
		
		//$platformtypeList =explode(",",$platformtype);
		//if(count($platformtypeList)>0){
			// foreach($platformtypeList as $key=>$value){
			// 	$platformtype = $value;
			// 	if($platformtype == "ios"){
			// 		$des = $description; //str_replace('"', "#$#", $description);	
			// 	}else{
			// 		$des = $description;
			// 	}
				
				$data = [
						//'platform_type' => $platformtype,
						'title' => $title,
						'description' => $description,
						//'popup' => $popupstatus,
						'announcement_type' => $announcement_type,
						'expiry_date' => $expiry_date,
						'users' => $user_list,
						'created_at' => date("Y-m-d H:i:s")
						
					];
					//print_r($data);exit;
					$result = Announcements::insert($data);
				
				
				
			//}	
			if($result){
				return response()->json(['status' => 'Success', 'Result' => 'Announcement Sent Successfully'], 200);
			}else{
				
				return response()->json(['status' => 'Failure', 'Result' => 'something went wrong'], 200);
			}
			
		// }else{
			
		// 	return response()->json(['status' => 'Failure', 'Result' => 'Please Select Atleast one platform Type'], 200);
		// }
		
		
		
	}
	
	// edit announcement
	public function editAnnouncment(Request $request)
	{ 
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$data['userInfo'] = $userInfo;
		$data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();
		
		$recid = request()->segment(2);
		
		$rec_id = base64_decode($recid);
		//echo $rec_id;exit;
		$data['edit_info'] = Announcements::where('id','=',$rec_id)->orderBy('id','ASC')->first();
		
		return view('announcements/announcement-edit')->with($data);
		
	}
	
	public function updateAnnouncmentData(Request $request)
	{ 
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		
		$rec_id = Input::get("editid");
		
		
		//$platformtype = Input::get("platformtype");
		$title = Input::get("title");
		$description = Input::get("description");
		//$popupstatus = Input::get("popupstatus");
		$announcement_type = 2;//Input::get("announcement_type");
		$expiry_date = Input::get("expiry_date");
		$user_data =  Input::get("users_list");

		if($expiry_date == ''){
			$expiry_date = date("Y-m-d");
			$user_list = array();
		}else{
			$expiry_date = date("Y-m-d", strtotime($expiry_date));
			//$user_data = User::select('rec_id')->where(['user_role'=> 4, 'status' => 1])->get();
			if(!empty($user_data)){
				foreach($user_data as $rec) {
					$user_list[] = array('rec_id' => $rec, 'flag' => 1); 
				}
				$user_list = serialize($user_list);
			}
		}

		if($platformtype == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'Please select platform type'], 200);
		}else if($description == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'Please Enter description'], 200);
		}else if($rec_id == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'Rec id missing'], 200);
		}else{
		
			$data = [
						//'platform_type' => $platformtype,
						'title' => $title,
						'description' => $description,
						//'popup' => $popupstatus,
						'announcement_type' => $announcement_type,
						'expiry_date' => $expiry_date,
						'users' => $user_list,
						'updated_at' => date("Y-m-d H:i:s")
						
					];		
					//print_r($data);exit;
			$res = Announcements::where('id','=',$rec_id)->update($data);
			if($res){
				return response()->json(['status' => 'Success', 'Result' => 'Announcement Updated Successfully'], 200);	
			}else{
				return response()->json(['status' => 'Failure', 'Result' => 'Something went wrong'], 200);
			}	
				
		}
		
	}
	
	public function deleteAnnouncment(Request $request)
	{ 
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		
		$rec_id = Input::get("rec_id");
		
		if(!empty($rec_id)){
			//$data = array("status"=>$value);
			$res = Announcements::where('id','=',$rec_id)->delete();
			if($res == TRUE){
				return response()->json(['status' => 'Success', 'Result' => 'Deleted Successfully'], 200);
			}else{
				return response()->json(['status' => 'Failure', 'Result' => 'Something went wrong'], 200);
			}
				
		}else{
			return response()->json(['status' => 'Failure', 'Result' => 'User ID is missing'], 200);	
		}
		
	}

	public function announcementPopup_flag_update(Request $request)
	{ 
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		
		$flag = 0;
		$data = $date = date('Y-m-d');
		$announcement_list = Announcements::where('announcement_type',2)->orderby('id','desc')->get();
		foreach($announcement_list as $list) {
			$users_list = unserialize($list['users']);
			$datalist = array();
			if(!empty($users_list)){
				foreach($users_list as $user){
					if($userinfo['rec_id'] == $user['rec_id'] && $user['flag'] == 1){
						$datalist[] = array('rec_id' => $user['rec_id'],'flag' => 0);
					}else{
						$datalist[] = array('rec_id' => $user['rec_id'],'flag' => $user['flag'] );
					}
				}
			}
			$res = Announcements::where('id',$list['id'])->update(['users' => serialize($datalist)]);
		}
		
		return response()->json(['status' => 'Success', 'Result' => 'Flag Updated Successfully'], 200);
			
	}


	
	public function addNewAlert(Request $request)
	{ 
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$data['userInfo'] = $userInfo;
		$data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();
		return view('alerts/alert-new')->with($data);
		
	}
	
	
}
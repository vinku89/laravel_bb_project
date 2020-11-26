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
use App\MobileLeftMenu;
use Illuminate\Support\Facades\Auth;
class MobileMenuSettingsController extends Controller
{
	
	
	public function mobile_menu_settings()
	{ 
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		$data['parent_menus'] = MobileLeftMenu::select('*')->where('status','=',1)->where('parent_menu_id','=',0)->orderBy("menu_order", "ASC")->get();
		$data['menusList'] = MobileLeftMenu::select('*')->where('parent_menu_id','=',0)->orderBy("menu_order", "ASC")->paginate(40);
		return view('mobile_menu_settings')->with($data);
		
	}
	
	// Add New mobile Menu
	public function addNewMobileMenu(Request $request) 
	{ 
		
		//get packages
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		
		$menuName = Input::get("menuName");
		$menuLink = Input::get("menuLink");
		$uploads = Input::get("uploads");
		$parent_menu = Input::get("parent_menu");
		$menuLocation = Input::get("normal_select");
		$action = Input::get("action");
		$created_at = date('Y-m-d H:i:s');
		
		if($menuName == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'Please Enter Menu Name'], 200);
		}else if($menuLink == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'Please Enter Menu Link'], 200);
		}else if($menuLocation == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'Please Enter Menu Location'], 200);
		}else{
			
			if ($request->has('uploads')) { 
				$org_name = $request->file('uploads')->getClientOriginalName();
				$exts = explode('.', $org_name);
				if (count($exts) == 2) {
					$image = $request->file('uploads');
					//return response()->json(['status' => 'Failure', 'Result' => $image,'org_name'=>$org_name], 200);
					$fileType = $image->getClientOriginalExtension();
					$fileTyp = strtolower($fileType);
					$allowedTypes = array("jpeg", "jpg", "png");
					if (in_array($fileTyp, $allowedTypes)) {

						$destinationPath = base_path('/public/mobile_menu_icons');
						$result = $image->move($destinationPath, $org_name);
						if ($result) {
		
							$data = [
								'parent_menu_id' => $parent_menu,
								'menu_name' => $menuName,
								'menu_icon' => $org_name,
								'menu_link' => $menuLink,
								'display_location' => $menuLocation,
								'created_at' => $created_at,
							];
							//print_r($data);exit;
							$res = MobileLeftMenu::insert($data);
							
							return response()->json(['status' => 'Success', 'Result' => 'Menu Created Successfully.'], 200);

						} else {
							
							return response()->json(['status' => 'Failure', 'Result' => 'Something went wrong in Uploading image'], 200);
						}

					} else {
						return response()->json(['status' => 'Failure', 'Result' => 'Please Upload only JPEG,JPG,PNG images only'], 200);
					}
				} else {
					return response()->json(['status' => 'Failure', 'Result' => 'Multy extension is not allowed'], 200);
				}
			} else {
			
				$data = [
							'parent_menu_id' => $parent_menu,
							'menu_name' => $menuName,
							'menu_link' => $menuLink,
							'display_location' => $menuLocation,
							'created_at' => $created_at,
							
						];
							//print_r($data);exit;
						$res = MobileLeftMenu::insert($data);
				
				return response()->json(['status' => 'Success', 'Result' => 'Menu Created Successfully.'], 200);
			}
			
			
		}
		
	}
	
	//change menu location
	public function changeMenuLocation()
	{ 
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		
		$rec_id = Input::get("rec_id");
		$locationID = Input::get("locationID");
		$action = Input::get("action");
		
		if($rec_id == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'menu id missing'], 200);
		}else{
		
			$data = array("display_location"=>$locationID);
			$res = MobileLeftMenu::where('id','=',$rec_id)->update($data);
			if($res){
				return response()->json(['status' => 'Success', 'Result' => 'Display Menu Updated Successfully.'], 200);	
			}else{
				return response()->json(['status' => 'Failure', 'Result' => 'Something went wrong'], 200);
			}	
			
		}
		
	}
	
	//Dashboard at location
	public function displayDashboardAt()
	{ 
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		
		$rec_id = Input::get("rec_id");
		$locationID = Input::get("locationID");
		$action = Input::get("action");
		
		if($rec_id == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'menu id missing'], 200);
		}else{
		
			$data = array("display_dashboard_at"=>$locationID);
			$res = MobileLeftMenu::where('id','=',$rec_id)->update($data);
			if($res){
				return response()->json(['status' => 'Success', 'Result' => 'Dashboard Location Updated Successfully.'], 200);	
			}else{
				return response()->json(['status' => 'Failure', 'Result' => 'Something went wrong'], 200);
			}	
			
		}
		
	}
	
	//Dashboard at location
	public function deleteMenuStatus()
	{ 
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		
		$rec_id = Input::get("rec_id");
		$statusID = Input::get("status");
		$action = Input::get("action");
		
		if($rec_id == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'menu id missing'], 200);
		}else{
			if($statusID == 1 ){
				$msg = "Menu Activated Successfully";	
			}else{
				$msg = "Menu In-activated Successfully";
			}
			$data = array("status"=>$statusID);
			$res = MobileLeftMenu::where('id','=',$rec_id)->update($data);
			if($res){
			
				return response()->json(['status' => 'Success', 'Result' => $msg], 200);	
			}else{
				return response()->json(['status' => 'Failure', 'Result' => 'Something went wrong'], 200);
			}	
			
		}
		
	}
	
	
	// delete Package
	/*public function deleteMenuStatus()
	{ 
		//get packages
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		
		$rec_id = Input::get("rec_id");
		$action = Input::get("action");
		
		if (!empty($rec_id)) {
			$updata = array("status"=>0); 
			$res = MobileLeftMenu::where('id', '=', $rec_id)->update($updata);
			if ($res) {
				return response()->json(['status' => 'Success', 'Result' => "Updated"], 200);
			} else {
				return response()->json(['status' => 'Failure', 'Result' => "Something Went wrong"], 200);
			}
		} else {
			return response()->json(['status' => 'Failure', 'Result' => "Record ID missing"], 200);
		}
	}*/
	
	public function updateMenuPermissions()
	{ 
		//get packages
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		
		$resellersList = Input::get("resellersList");
		$agentsList = Input::get("agentsList");
		$customersList = Input::get("customersList");
		$columnName1 = Input::get("columnName1");
		
		$columnName2 = Input::get("columnName2");
		$columnName3 = Input::get("columnName3");
		
		$action = Input::get("action");
		
		if (!empty($action)) {
			
			$query = "UPDATE mobile_left_menu SET reseller=0,agent=0,customer=0";

			$results = DB::select(DB::raw($query));
			// Resellers list update
			if (!empty($resellersList)) {
				$resellersList1 = explode(",", $resellersList);
				foreach ($resellersList1 as $menuid) {

					$data = array("reseller" => 1);
					$results = DB::table('mobile_left_menu')->where("id", "=", $menuid)->update($data);
				}
			}
			
			// Agents list update
			if (!empty($agentsList)) {
				$agentsList1 = explode(",", $agentsList);
				foreach ($agentsList1 as $menuid) {

					$data = array("agent" => 1);
					$results = DB::table('mobile_left_menu')->where("id", "=", $menuid)->update($data);
				}
			}
			
			// Customers list update
			if (!empty($customersList)) {
				$customersList1 = explode(",", $customersList);
				foreach ($customersList1 as $menuid) {

					$data = array("customer" => 1);
					$results = DB::table('mobile_left_menu')->where("id", "=", $menuid)->update($data);
				}
			}
			
			return response()->json(['status' => 'Success', 'Result' => 'Updated Successfully'], 200);
			
		} else {
			return response()->json(['status' => 'Failure', 'Result' => "Something went wrong"], 200);
		}
	}
	
	public function updateMenuOrders()
	{ 
		//get packages
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		
		$ordersList = Input::get("ordersList");
		
		$action = Input::get("action");
		
		if (!empty($action)) {
			
			//$query = "UPDATE mobile_left_menu SET menu_order=0";

			//$results = DB::select(DB::raw($query));
			
			//print_r($ordersList);exit;
			
			// Resellers list update
			if (!empty($ordersList)) {
				//$ordersList1 = explode(",", $ordersList);
				//print_r($ordersList1);exit;
				//$ordersList2 =  (array) $ordersList;
				foreach ($ordersList as $value) {
					//echo '<pre>';print_R($value);
					//echo $value['id'].'-'.$value['value'];
					$data = array("menu_order" => $value['value']);
					$results = DB::table('mobile_left_menu')->where("id", "=", $value['id'])->update($data);
				}
			}
			
			return response()->json(['status' => 'Success', 'Result' => 'Menu Order Updated Successfully'], 200);
			
		} else {
			return response()->json(['status' => 'Failure', 'Result' => "Something went wrong"], 200);
		}
	}

	
}
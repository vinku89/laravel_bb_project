<?php
namespace App\Http\Controllers\home;

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
use App\Wallet;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\RolesPermissions;
use App\Http\Controllers\home\AdminController;
use App\Left_menu;
class AdminUserController extends Controller {

	
	public function addUser()
	{
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$data['userInfo'] = $userInfo;
		$data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();
		$data['user_roles'] = RolesPermissions::where('status',1)->whereNotIn('id', [2,3,4])->get()->toArray();
		return view('addAdminUser')->with($data);
	}
	public function editAdminUser(Request $request,$uid="")
	{

		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		Session::forget("admin_user_id");
		Session::put("admin_user_id",$uid);
		$admin_user_id=decrypt($uid);
		$data['userInfo'] = $userInfo;
		$data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();
		$data['user_roles'] = RolesPermissions::where('status',1)->whereNotIn('id', [2,3,4])->get()->toArray();
		$data['admin_user']=User::where('user_id',$admin_user_id)->first();
		return view('editAdminUser')->with($data);
	}
	public function createAdminUser(Request $request)
	{
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		
		$validator = Validator::make($request->all(), [
			'email' => 'required|email|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$/|unique:users',
			'first_name' => 'required|string|min:3|max:255',
			'last_name' => 'required|string|min:3|max:255',
			'country' => 'required',
			'role' => 'required',
			'mobile' => 'required|regex:/^([0-9]{8,12})$/'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			return Redirect::back()->withErrors(['<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>']);
		}else {

			$email = $request->email;
			$first_name = $request->first_name;
			$last_name = $request->last_name;
			$gender = $request->gender;
			
			$address = $request->address;
			$address2 = $request->address2;
			$zipcode = $request->zipcode;
			if(empty($zipcode)){
				$zipcode=0;
			}
			$country = $request->country;
			$role = $request->role;
			$country_code = $request->country_code;

			$firstCharacter = $request->mobile[0];
			if($firstCharacter == 0){
			    $mbl = ltrim($request->mobile, '0');
			}else{
			    $mbl = $request->mobile;
			}

			$mobile = $country_code . "-" . $mbl;
						
			
			$userId = AdminController::generateUserId('ADM', $first_name);
			$us_cnt = User::where('user_id', $userId)->count();
			if ($us_cnt == 1) {
				$user_id = AdminController::generateUserId('ADM', $first_name);
			} else {
				$user_id = $userId;
			}

			$ref_code = AdminController::generateReferralCode($first_name);
			$ref_cnt = User::where('refferallink_text', $ref_code)->count();
			if ($ref_cnt == 1) {
				$referral_code = AdminController::generateReferralCode($first_name);
			} else {
				$referral_code = $ref_code;
			}

			$user = User::create([
				'user_id' => $user_id,
				'referral_userid' => $login_userId,
				'first_name' => $first_name,
				'last_name' => $last_name,
				'email' => $email,
				'gender' => $gender,
				'address' => $address,
				'address2' => $address2,
				'zipcode' => $zipcode,
				'country_id' => $country,
				'telephone' => $mobile,
				'refferallink_text' => $referral_code,
				'user_role' => $role,
				'status' => 1,
				'admin_login'=>1,
				'registration_date' => date('Y-m-d H:i:s')
			]);

			$last_inserted_id = $user->rec_id;

			Wallet::create([
				'user_id' => $last_inserted_id,
				'amount' => 0
			]);


			$data['useremail'] = array('name' => $first_name.' '.$last_name, 'user_id' => $last_inserted_id, 'toemail' => $email,'type'=>'Admin User', 'referral_link' => $referral_code);
			$emailid = array('toemail' => $email);
			Mail::send(['html' => 'email_templates.verify-email'], $data, function ($message) use ($emailid) {
				$message->to($emailid['toemail'], 'Email Verify')->subject('Email Verify');
				$message->from('noreply@bestbox.net', 'BestBox');
			});

			Session::flash('result', 'Admin User Created Successfully');
			Session::flash('alert','Success');
			return Redirect::back();
		}
	}
	public function updateAdminUser(Request $request)
	{
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		
		$validator = Validator::make($request->all(), [
			'first_name' => 'required|string|min:3|max:255',
			'last_name' => 'required|string|min:3|max:255',
			'country' => 'required',
			'role' => 'required',
			'mobile' => 'required|regex:/^([0-9]{8,12})$/',
			'status'=>'required'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			return Redirect::back()->withErrors(['<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>']);
		}else {
			$admin_user_id=Session::get("admin_user_id");
			$admin_user_id=decrypt($admin_user_id);
			Session::forget("admin_user_id");
			$first_name = $request->first_name;
			$last_name = $request->last_name;
			$gender = $request->gender;
			$status=$request->status;
			$address = $request->address;
			$address2 = $request->address2;
			$zipcode = $request->zipcode;
			if(empty($zipcode)){
				$zipcode=0;
			}
			$country = $request->country;
			$role = $request->role;
			$country_code = $request->country_code;

			$firstCharacter = $request->mobile[0];
			if($firstCharacter == 0){
			    $mbl = ltrim($request->mobile, '0');
			}else{
			    $mbl = $request->mobile;
			}

			$mobile = $country_code . "-" . $mbl;
			
			$user = User::where("user_id",$admin_user_id)->update([
				'first_name' => $first_name,
				'last_name' => $last_name,
				'gender' => $gender,
				'address' => $address,
				'address2' => $address2,
				'zipcode' => $zipcode,
				'country_id' => $country,
				'telephone' => $mobile,
				'user_role' => $role,
				'status'=>$status,
				'updated_at' => date('Y-m-d H:i:s')
			]);

			Session::flash('result', 'Admin User Updated Successfully');
			Session::flash('alert','Success');
			return redirect('adminUsersList');
		}
	}
	public function adminUsersList(Request $request){
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		//$data['admin_users']=User::join('roles_permissions','users.user_role','=','roles_permissions.id')->where('admin_login',1)->get()->toArray();
		$data['admin_users']=User::leftJoin('roles_permissions','users.user_role','=','roles_permissions.id')
									->select('users.rec_id','users.first_name','users.last_name','users.email','roles_permissions.role_name','users.status')
									->where('admin_login',1)
									->where('users.user_role','!=',1)->get()->toArray();
		$data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();
		return view('admin_users_list')->with($data);
	}

	
	public function rolePermissions(Request $request){
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$data['user_roles'] = RolesPermissions::whereNotIn('id',[1,2,3,4])->get()->toArray();
		$mcount_arr=array();
		foreach ($data['user_roles'] as $ur) {
			$ucount=User::where('user_role',$ur['id'])->count();
			$mcount_arr[$ur['id']]=$ucount;
		}
		$data['ucount']=$mcount_arr;
		return view('role_permissions')->with($data);
	}

	public function addRole(){
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$parent_menu=Left_menu::where(['parent_menu_id' => 0,'status' => 1, 'is_admin_menu' => 1])->orderBy('menu_order','ASC')->get()->toArray();
		$data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();
		$menu_arr=array();
		foreach ($parent_menu as $p) {
			$menu_arr[]=array("level"=>'parent',"id"=>$p['id'],"name"=>$p['menu'],"parent_id"=>$p['id']);
			$child_menu=Left_menu::where(['parent_menu_id' => $p['id'],'status' => 1, 'is_admin_menu' => 1])->orderBy('menu_order','ASC')->get()->toArray();
			foreach ($child_menu as $c) {
				$menu_arr[]=array("level"=>'child',"id"=>$c['id'],"name"=>$c['menu'],"parent_id"=>$p['id']);
			}
		}
		$data['menu_arr']=$menu_arr;
		return view('add_role')->with($data);
	}
	public function createRole(Request $request){
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$validator = Validator::make($request->all(), [
			'roleTitle' => 'required|string|min:3|max:255',
			'roleDesc' => 'required|string|min:3|max:255'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			return Redirect::back()->withErrors(['<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>']);
		}else {
			$roleTitle = $request->roleTitle;
			$roleDesc = $request->roleDesc;
			$menuname = $request->input('menuname');
			$parent_menus_arr=array();
			$child_menus_arr=array();
			$parent_menus = '';$child_menus ='';
			$role = trim(strtolower($roleTitle));
			$role_cnt = RolesPermissions::whereRaw('LOWER(role_name) = ?', [$role])->count();
			
			if($role_cnt >0){
				Session::flash('result', 'Role Name Already Exists');
				Session::flash('alert','Error');
				return Redirect::back();
			}
			if($menuname!=''){
				foreach($menuname as $m){
					$msplit=explode("_",$m);
					if (strpos($m, 'parent') !== false) {
						
						$parent_menus_arr[]=$msplit[1];
					}else{
						$child_menus_arr[]=$msplit[1];
					}
				}
				$parent_menus=implode(",", $parent_menus_arr);
				$child_menus=implode(",", $child_menus_arr);
			}
			
			$roles = RolesPermissions::create([
				"role_name"=>$roleTitle,
				"description"=>$roleDesc,
				"parent_menus"=>$parent_menus,
				"child_menus"=>$child_menus,
				"status"=>1,
				"created_at"=>date("Y-m-d H:i:s")
			]);

			$role_id = $roles->id;

			$usersList = $request->users;
			$roleAssignedUsers = explode(',',$usersList);
			if(count($roleAssignedUsers)>0){
				foreach($roleAssignedUsers as $user){
					User::where(['rec_id' => $user])->update(['user_role' => $role_id,'admin_login' => 1, 'status' => 1]);
				}
			}
			Session::flash('result', 'Role Created Successfully');
			Session::flash('alert','Success');
			return Redirect::back();
		}
	}
	public function editRole(Request $request,$rid=""){
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		Session::forget("role_id");
		Session::put("role_id",$rid);
		$role_id=decrypt($rid);
		$data['usersList'] = User::select('rec_id',DB::raw('concat(first_name," ",last_name) as name'),'email')->where(['user_role' => $role_id])->get();
		$data['user_role'] = RolesPermissions::where('id', $role_id)->first();
		if($role_id == 4){
			$parent_menu=Left_menu::where(['parent_menu_id' => 0, 'status' => 1, 'is_customer_menu' => 1])->orderBy('menu_order','ASC')->get()->toArray();
			$menu_arr=array();
			foreach ($parent_menu as $p) {
				$menu_arr[]=array("level"=>'parent',"id"=>$p['id'],"name"=>$p['menu'],"parent_id"=>$p['id']);
				$child_menu=Left_menu::where(['parent_menu_id' => $p['id'], 'status' => 1, 'is_customer_menu' => 1])->orderBy('menu_order','ASC')->get()->toArray();
				foreach ($child_menu as $c) {
					$menu_arr[]=array("level"=>'child',"id"=>$c['id'],"name"=>$c['menu'],"parent_id"=>$p['id']);
				}
			}
		}else{
			if($role_id == 2 || $role_id == 3) {
				$parent_menu=Left_menu::where(['parent_menu_id' => 0, 'status' => 1, 'is_menu' => 1])->orderBy('menu_order','ASC')->get()->toArray();
			}else{
				$parent_menu=Left_menu::where(['parent_menu_id' => 0, 'status' => 1, 'is_admin_menu' => 1])->orderBy('menu_order','ASC')->get()->toArray();
			}
			$menu_arr=array();
			foreach ($parent_menu as $p) {
				$menu_arr[]=array("level"=>'parent',"id"=>$p['id'],"name"=>$p['menu'],"parent_id"=>$p['id']);
				$child_menu=Left_menu::where(['parent_menu_id' => $p['id'], 'status' => 1, 'is_admin_menu' => 1])->orderBy('menu_order','ASC')->get()->toArray();
				foreach ($child_menu as $c) {
					$menu_arr[]=array("level"=>'child',"id"=>$c['id'],"name"=>$c['menu'],"parent_id"=>$p['id']);
				}
			}
		}
		
		
		
		$data['menu_arr']=$menu_arr;
		$data['role_id'] = $rid;
		return view('edit_role')->with($data);
	}
	public function updateRole(Request $request){
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$validator = Validator::make($request->all(), [
			'roleTitle' => 'required|string|min:3|max:255',
			'roleDesc' => 'required|string|min:3|max:255'
		]);
		
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			return Redirect::back()->withErrors(['<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>']);
		}else {
			//echo 'hi';exit;
			$role_id = $request->role_id;
			//$role_id=Session::get("role_id");
			//Session::forget("role_id");
			$role_id=decrypt($role_id);
			
			$roleTitle = $request->roleTitle;
			$roleDesc = $request->roleDesc;
			//$status = $request->status;
			$menuname = $request->input('menuname');
			$parent_menus_arr=array();
			$child_menus_arr=array();
			$parent_menus='';$child_menus='';
			$role = trim(strtolower($roleTitle));
			$role_cnt = RolesPermissions::whereRaw('LOWER(role_name) = ?', [$role])->first();
			if(!empty($role_cnt)){
				if($role_cnt['id'] != $role_id){
					Session::flash('result', 'Role Name Already Exists');
					Session::flash('alert','Error');
					return Redirect::back();
				}
			}
			
			if($menuname!=''){
				foreach($menuname as $m){
					$msplit=explode("_",$m);
					if (strpos($m, 'parent') !== false) {
						
						$parent_menus_arr[]=$msplit[1];
					}else{
						$child_menus_arr[]=$msplit[1];
					}
				}
				$parent_menus=implode(",", $parent_menus_arr);
				$child_menus=implode(",", $child_menus_arr);
			}
			
			RolesPermissions::where('id',$role_id)->update([
				"role_name"=>$roleTitle,
				"description"=>$roleDesc,
				"parent_menus"=>$parent_menus,
				"child_menus"=>$child_menus,
				//"status"=>$status,
				"updated_at"=>date("Y-m-d H:i:s")
			]);
			$deletedUsersList = $request->deletedUsersList;
			$addedUsersList = $request->addUsersList;

			$usersList = explode(',',$deletedUsersList);

			if(count($usersList)>0){
				foreach($usersList as $user){
					User::where(['rec_id' => $user])->update(['user_role' => 0,'admin_login' => 1,'status' => 1]);
				}
			}

			$addusersList = explode(',',$addedUsersList);
			if(count($addusersList)>0){
				foreach($addusersList as $user){
					User::where(['rec_id' => $user])->update(['user_role' => $role_id]);
				}
			}
			
			Session::flash('result', 'Role Updated Successfully');
			Session::flash('alert','Success');
			return Redirect::back();
		}
	}

	public function getUserData(Request $request) {
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$rec_id = $request->rec_id;
		$data = User::select('rec_id','first_name','last_name','email','status','admin_login')->where('rec_id', $rec_id)->first();
		return response()->json(['status' => 'Success','Result'=> $data]);
	}

	public function updateUserStatus(Request $request) {
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$status = $request->status;
		$rec_id = $request->rec_id;
		$data = array('status' => $status);
		$result = User::where(['rec_id' => $rec_id])->update($data);
		return response()->json(['status' => 'Success','Result'=> $result]);
	}
	//add user

	public function createUser(Request $request) {
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$validator = Validator::make($request->all(), [
			'email' => 'required|email|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$/|unique:users',
			'first_name' => 'required|string|min:3|max:255',
			'last_name' => 'required|string|min:3|max:255',
			'country' => 'required',
			'mobile' => 'required|regex:/^([0-9]{8,14})$/'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			return response()->json(['status' => 'Failure','Result'=> '<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>']);
			//return Redirect::back()->withErrors(['<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>']);
		} else {
			$email = $request->email;
			$email_cnt = User::where('email', $email)->count();
			if ($email_cnt >0) {
				return response()->json(['status' => 'Failure','Result'=> 'Email Already Exists.']);
			}
			$first_name = $request->first_name;
			$last_name = $request->last_name;
			$country = $request->country;
			$country_code = $request->country_code;
			$firstCharacter = $request->mobile;
			if($firstCharacter == 0){
			    $mbl = ltrim($request->mobile, '0');
			}else{
			    $mbl = $request->mobile;
			}

			$mobile = $country_code . "-" . $mbl;

			$userId = AdminController::generateUserId('ADM', $first_name);
			$us_cnt = User::where('user_id', $userId)->count();
			if ($us_cnt == 1) {
				$user_id = AdminController::generateUserId('ADM', $first_name);
			} else {
				$user_id = $userId;
			}

			$ref_code = AdminController::generateReferralCode($first_name);
			$ref_cnt = User::where('refferallink_text', $ref_code)->count();
			if ($ref_cnt == 1) {
				$referral_code = AdminController::generateReferralCode($first_name);
			} else {
				$referral_code = $ref_code;
			}

			$input = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$input_length = strlen($input);
			$random_string = '';
			for($i = 0; $i < 9; $i++) {
				$random_character = $input[mt_rand(0, $input_length - 1)];
				$random_string .= $random_character;
			}
			$pwd = $random_string;
			$hashpwd = Hash::make($pwd);

			$user = User::create([
				'first_name' => $first_name,
				'last_name' => $last_name,
				'user_id' => $user_id,
				'email' => $email,
				'password' => $hashpwd,
				'country_id' => $country,
				'telephone' => $mobile,
				'user_role' => 0,
				'status' => 0,
				'admin_login' => 1,
				'refferallink_text' => $referral_code,
				'referral_userid' => $login_userId,
				'registration_date' => date('Y-m-d H:i:s')
			]);

			$last_inserted_id = $user->rec_id;

			Wallet::create([
				'user_id' => $last_inserted_id,
				'amount' => 0
			]);

			


			$data['useremail'] = array('name' => $first_name.' '.$last_name, 'user_id' => $last_inserted_id, 'email' => $email,'type'=>'Admin User', 'referral_link' => $referral_code, 'password' => $pwd);
			$emailid = array('toemail' => $email);
			Mail::send(['html' => 'email_templates.verify-email'], $data, function ($message) use ($emailid) {
				$message->to($emailid['toemail'], 'Email Verify')->subject('Email Verify');
				$message->from('noreply@bestbox.net', 'BestBox');
			});

			$data = array('name' => $first_name.' '.$last_name,'email' => $email, 'rec_id' => $last_inserted_id);

			return response()->json(['status' => 'Success','Result'=> 'User Added Successfully']);
			
		}
	}

	public function checkEmailForRoleAssign(Request $request) {
		$email = trim($request->email);
		$user_role = trim($request->user_role);
		$validator = Validator::make($request->all(), [
			'email' => 'required|email|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$/'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			return response()->json(['status' => 'Failure', 'Result' => 'Not Valid email','flag' => 0], 200);
		} else {
			$count = User::where(['email'=> $email,'admin_login' => 1])->count();
			if($count==0) {
				return response()->json(['status' => 'Failure', 'Result' => 'Email Not Added to the Admin List','flag' => 0], 200);
			}else{
				$userInfo = User::select('rec_id','first_name','last_name','email','user_role')->where(['email'=> $email])->first();
				if($userInfo->user_role == 0) {
					return response()->json(['status' => 'Success', 'Result' => $userInfo], 200);
				}else if($userInfo->user_role == $user_role){
					return response()->json(['status' => 'Failure', 'Result' => 'Already Added this User','flag' => 0], 200);
				}else if($userInfo->user_role != 0){
					$result = user::join('roles_permissions','users.user_role','=','roles_permissions.id')
					->select('role_name')
					->where(['roles_permissions.id' => $userInfo->user_role])
					->get();
					
					$role_name = '';
					if(!empty($result)>0){
						foreach($result as $res){
							$role_name = $res->role_name;
						}
					}
					return response()->json(['status' => 'Failure', 'Result' => $userInfo, 'rolename' => $role_name,'flag' => 1], 200);
				}
			}
		}
	}
}
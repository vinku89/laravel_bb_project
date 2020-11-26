<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Http\Controllers\home\CustomerController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use Session;
use App\User;
use App\Country;
use App\Bank_details;
use App\Commissions;
use App\Unilevel_tree;
use App\Shipping_address;
use App\Packages;
use App\Wallet;
use App\Package_purchase_list;
use App\Purchase_order_details;
use Validator;
use App\library\Common;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller {

	public function profile() {
		$userInfo = Auth::user();
		$userId = $userInfo['user_id'];
		$user = User::where(array('user_id' => $userId))->first();
		$data['userInfo'] = $user;
		$data['countries'] = country::select('countryid','country_name','currencycode')
									//->where(array('country_status'=>1))
									->orderBy('country_name','ASC')->get();
		$data['userInfo']['country_code'] = '';
		$data['userInfo']['telephone'] = $user['telephone'];
		$mobileno = explode('-', $user['telephone']);
		if(count($mobileno)>1){
			$data['userInfo']['country_code'] =  $mobileno[0];
			$data['userInfo']['telephone'] =  str_replace('-', '', $mobileno[1]);
		}
		
		$data['userInfo']['profile_image'] = ($data['userInfo']['image']!='') ? $data['userInfo']['image'] : 'avatar.png';
		if($user['user_role'] == 4) {
			$data['userInfo']['shipping_country_code'] = '';
			$data['userInfo']['shipping_telephone'] = '';
			if($user['shipping_user_mobile_no'] != ''){
				$shipping_mobileno = explode('-', $user['shipping_user_mobile_no']);
				$data['userInfo']['shipping_country_code'] =  $shipping_mobileno[0];
				$data['userInfo']['shipping_telephone'] =  str_replace('-', '', $shipping_mobileno[1]);
			}
		}
		$data['bankDetails'] = Bank_details::where(array('user_rec_id' => $userInfo['rec_id']))->first();
		if($user['user_role'] == 4) {
			return view('customer/version2/profile')->with($data);
		} else{
			return view('profile')->with($data);
		}
	}

	public function updateProfileImage(Request $request) {
		$userInfo = Auth::user();
		$userId = $userInfo['user_id'];
		
		if ($request->hasFile('profile_picture')) { 
			$image = $request->file('profile_picture');
			$fileType = $image->guessExtension();
			$fileTyp = strtolower($fileType);
			$allowedTypes = array("jpeg", "jpg", "png");
			if (in_array($fileTyp, $allowedTypes)) {
				// Rename image
				$fileName = rand(999,9999999).time().'.'.$image->guessExtension();
				$destinationPath = base_path('/public/profileImages');
				$upload_success = $image->move($destinationPath, $fileName); 
				if ($upload_success) {
					$data = array('image' => $fileName);
					$res = User::where(['user_id' => $userId])->update($data);
					return response()->json(['status' => 'Success', 'Result' => 'Profile Image Updated Successfully.'], 200);
				} else {
					return response()->json(['status' => 'Failure', 'Result' => 'Something went wrong in Uploading image'], 200);
				}
			} else {
				return response()->json(['status' => 'Failure', 'Result' => 'Please Upload only JPEG,JPG,PNG images only'], 200);
			}
		}
	}
	
	public function updateProfile(Request $request) {
		$userInfo = Auth::user();
		$userId = $userInfo['user_id'];
		$login_userId = $userInfo['rec_id'];
		$user_role = $userInfo['user_role'];
		if($user_role == 4) {
			$validator = Validator::make($request->all(), [
				//'telephone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
				'first_name' => 'required',
				'last_name' => 'required',
				/*'address' => 'required',
				'address2' => 'required',
				'zipcode' => 'required',
				'country' => 'required'*/
				/*'shipping_address1' => 'required',
				'shipping_address2' => 'required',
				'shipping_zipcode' => 'required',
				'shipping_country' => 'required',
				'shipping_user_mobile_no' => 'required|regex:/^((?!(0))[0-9]{8,12})$/'*/
				]);
		}else{
			$validator = Validator::make($request->all(), [
				//'telephone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
				'first_name' => 'required',
				'last_name' => 'required',
				/*'address' => 'required',
				'address2' => 'required',
				'zipcode' => 'required',
				'country' => 'required',*/
			]);
		}
		if ($validator->fails()) {
            $errs = $validator->messages()->all();
			$str = '';
			foreach($errs as $arr){
				$str = $str.'<li>'.$arr.'</li>';
			}
			return Redirect::back()->withErrors(['<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>']);      
		}else{
			$first_name = trim(Input::get("first_name"));
			$last_name = trim(Input::get("last_name"));
			$telephone = trim(Input::get("telephone"));
			$gender = trim(Input::get("gender"));
			$married_status = '';//trim(Input::get("married_status"));

			$address = trim(Input::get("address"));
			$address2 = trim(Input::get("address2"));
			$zipcode = trim(Input::get("zipcode"));
			$country_id = trim(Input::get("country"));
			$country_code = trim(Input::get("country_code"));

			if($user_role == 4) {
				$shipping_address = Input::get('shipping_address');
				$shipping_address1 = trim(Input::get('shipping_address1'));
				$shipping_address2 = trim(Input::get('shipping_address2'));
				$shipping_zipcode = trim(Input::get('shipping_zipcode'));
				$shipping_country = trim(Input::get('shipping_country'));
				$shipping_country_code = trim(Input::get('shipping_country_code'));
				$shipping_user_mobile_no = $shipping_country_code . "-" . trim(Input::get('shipping_user_mobile_no'));
			}
			$bank_name = trim($request->bank_name);
			$bank_holder = trim($request->bank_holder);
			$account_number = trim($request->account_number);
			$swift_code = trim($request->swift_code);
			$bank_address_one = trim($request->bank_address_one);
			$bank_address_two = trim($request->bank_address_two);
			$country = trim($request->bank_country);
			$state = trim($request->state);
			$zip_code = trim($request->bank_zip_code);
			
			$evr_address = trim(Input::get("evr_address"));
			$btc_address = trim(Input::get("btc_address"));
			$eth_address = trim(Input::get("eth_address"));
			$true_address = trim(Input::get("true_address"));

			$userData = User::where('user_id', $userId)->first();

			$mobile_number = $country_code . '-' . $telephone;
			
			$data = array('first_name' => $first_name,'last_name' => $last_name,'address' => $address,'address2' => $address2, 'zipcode' => $zipcode,'telephone' => $mobile_number,
						'country_id' => $country_id,'gender' => $gender, 'married_status' => $married_status, 'evr_address' => $evr_address,
						'btc_address' => $btc_address,'eth_address' => $eth_address,'true_address' => $true_address
					);
			$res = User::where(['user_id' => $userId])->update($data);
			if($user_role == 4) {
				$shippingData = array('shipping_country' => $shipping_country, 'shipping_user_mobile_no' => $shipping_user_mobile_no,'shipping_address' => $shipping_address, 'shipping_address1' => $shipping_address1, 'shipping_address2' => $shipping_address2,'shipping_zipcode' => $shipping_zipcode);
				User::where(['user_id' => $userId])->update($shippingData);

				/*$udata = array(
					'default_address' => 0
				);
				Shipping_address::where('user_id',$login_userId)->update($udata);

				$shcnt = Shipping_address::where('user_id',$login_userId)->where('profile_screen',1)->count();
				if($shcnt == 1){
					$udata = array(
						'name' => $first_name." ".$last_name,
						'user_id' => $login_userId,
						'shipping_country' => $country_id,
						'shipping_mobile_no' => $mobile_number,
						'shipping_address' => $shipping_address,
						'default_address' => 1
					);
					Shipping_address::where('user_id',$login_userId)->where('profile_screen',1)->update($udata);
				}else{
					$shp = Shipping_address::create([
							'name' => $first_name." ".$last_name,
							'user_id' => $login_userId,
							'shipping_country' => $country_id,
							'shipping_mobile_no' => $mobile_number,
							'shipping_address' => $shipping_address,
							'default_address' => 1,
							'profile_screen' => 1
						]);
				}*/
				
			}

			$bank_details = Bank_details::where(array('user_rec_id' => $userData->rec_id))->first();
			$bankData = array('bank_name' => $bank_name,'bank_holder' => $bank_holder, 'account_number' => $account_number,'swift_code' => $swift_code,'bank_address_one' => $bank_address_one,'bank_address_two' => $bank_address_two,'country' => $country,
						'state' => $state,'zip_code' => $zip_code, 'user_rec_id' => $userData->rec_id);

			if(empty($bank_details)){
				Bank_details::create($bankData);
			}else{
				Bank_details::where(array('user_rec_id' => $userData->rec_id))->update($bankData);
			}
			Session::flash('message','Profile Updated Successfully');
			Session::flash('alert','Success');
			return Redirect::back();
		}
	}
		
	public function changePassword(){
		$data['userInfo'] = Auth::user();
		return view('auth.changePassword')->with($data);
	}
	
	public function updateNewPassword(Request $request)
    {
		$userId = Auth::user()->rec_id;
		$data['userInfo'] = Auth::user();
		$messages = [
			    'password.regex' => 'Password should be minimum 8 characters with alphanumeric'
			];
    	$validator = Validator::make($request->all(), [
			'current_password' => 'required',
            'password' => 'required|regex:/^.*(?=.{8,})(?=.*[a-z])(?=.*[0-9]).*$/|confirmed',
			'password_confirmation' => 'required'
        ],$messages);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
            $str = '';
            foreach ($errs as $arr) {
                $str = $str . '<li>' . $arr . '</li>';
            }
            Session::flash('error', '<ul>' . $str . '</ul>');
            Session::flash('alert','Failure');
            return Redirect::back();
		}else{
			$current_password = trim($request->current_password);
			$new_password = trim($request->password);
			$confirm_password = trim($request->password_confirmation);
			$hash_password = User::select('password')->where(['rec_id' => $userId])->first();
			if (!Hash::check($current_password, $hash_password->password)) {
				Session::flash('error','Current Password does not match');
				Session::flash('alert','Failure');
				return Redirect::back();
			}
			
			$userInfo = User::select('rec_id')->where("rec_id", "=", $userId)->first();
            $password = "password";
                        
			/*if (strlen($confirm_password) < 8) {
				Session::flash('error', 'Password Length minimum 8 characters');
				Session::flash('alert','Failure');
				return Redirect::back();
			} else if (!preg_match("#.*^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $confirm_password)) {
				Session::flash('error', 'Password should include lowercase, uppercase, numbers and special characters(?!@)');
				Session::flash('alert','Failure');
				return Redirect::back();
			} else if ($confirm_password != $new_password) {
				Session::flash('error', 'Confirm Password should be equal to New Password');
				Session::flash('alert','Failure');
				return Redirect::back();
			} else if ($new_password == $confirm_password) {*/
				$userInfo->password = \Hash::make($confirm_password);
				$userInfo->save();
				$device_id = $userInfo->device_id;
				$mobile = $userInfo->telephone;
				$name = ucwords($userInfo->first_name.' '.$userInfo->last_name);

				// // //send fcm to Mobile Team
				// $clientLogopath = "login_icon.png"; //url('/public/fcmIcons/login_icon.png');
				// $title = "Change Password";
				// // // Close request to clear up some resources
				// $arr = array("ClientCode" => "BESTBOX","clientLogopath" => $clientLogopath,"title" => $title, "Message" => 'Welcome', "MessageType"=>'BESTBOX_CHANGE_PASSWORD', "MobileNo" => $mobile, "UserName" => $name);
			
				// $json_data["changePasswordFCM"] = json_encode($arr);
				// $android_device_id = array($device_id);
				
				// if($platform == 'ios'){
				// 	$res = Common::sendFCMIOS($device_id,$json_data,$mobile, 'BESTBOX_CHANGE_PASSWORD');
				// }else if($platform == 'android'){
				// 	$res = Common::sendFCMAndroid($android_device_id,$json_data,$mobile, 'BESTBOX_CHANGE_PASSWORD');
				// }

				Session::flash('message', 'Password has been updated successfully');
				Session::flash('alert','Success');
				return Redirect::back();
			/*} else {
				Session::flash('error', 'Confirm Password do not match');
				Session::flash('alert','Failure');
				return Redirect::back();
			}*/
			
	    }
	}

	public function loadCommissionReportsById(Request $request) {
		$userInfo = Auth::user();
		$userId = $request->rec_id;
		$userRole = $request->user_role;
		if($userRole == 2){
			//DB::enableQueryLog();
			$data['commissionReports'] = Commissions::join('users','commissions.agent_id', '=','users.rec_id')
										->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','users.rec_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
										->where(['commissions.user_id' => $userId])
										->where('commissions.agent_id','!=',0)
										->groupBy('commissions.agent_id')
										->orderBy('commissions.rec_id','DESC')
										->paginate(25);
			
			 //dd(DB::getQueryLog());
			 //exit;
		}else if($userRole == 3){
			$data['commissionReports'] = Commissions::join('users','commissions.agent_id', '=','users.rec_id')
										->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.agent_id as referenceId', 'commissions.sales_amount', 'commissions.commission_perc','commissions.commission','commissions.description','commissions.added_date')
										->where(['commissions.agent_id' => $userId])
										->where('commissions.sender_user_id', '!=' , 0)
										->groupBy('commissions.sender_user_id')
										->paginate(25);
		}else{
			$data['commissionReports'] = Commissions::join('users','commissions.sender_user_id', '=','users.rec_id')
										->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sender_user_id as referenceId','commissions.sales_amount', 'commissions.commission_perc','commissions.commission','commissions.description','commissions.added_date')
										->where(['commissions.sender_user_id' => $userId,'commissions.agent_id' => $login_userId])
										->groupBy('commissions.sender_user_id')
										->paginate(25);
			
		}
		$html = '';
		if(count($data['commissionReports'])>0) {
			foreach($data['commissionReports'] as $item) {
				$html .= '<div class="grid_row clearfix border-top agent_row">';
					$html .= '<div class="w20 float-left font14 dark-grey_txt text-left">'.ucwords($item->first_name." ".$item->last_name).'</div>';
					$html .= '<div class="w15 float-left font14 dark-grey_txt pl-2 text-left">'.$item->user_id.'</div>';
					$html .= '<div class="w25 float-left font14 blue_txt  text-right">'.number_format($item->sales_amount,2).'</div>';
					$html .= '<div class="w25 float-left font14 text-right">'.number_format($item->commission,2).'</div>';
					$html .= '<div class="w15 float-left font14 text-right"><a href="'.url('/').'/commissionReportDetails/'.$item->rec_id.'/'.$item->referenceId.'">View</a></div>';
				$html .= '</div>';
			}
		}else{
			$html = '<div class="grid_row clearfix border-top agent_row">No Records Found</div>';
		}
		return response()->json(['status' => 'Success', 'Result' => $html], 200);
		//return view('commission_report')->with($data);
	}

}

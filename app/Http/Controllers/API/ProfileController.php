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
use App\Bank_details;
use App\Packages;
use App\Package_purchase_list;
use App\Http\Controllers\API\UserController;

class ProfileController extends Controller
{
	
	public static function passwordDecrypt($email,$pwd){
		$arr = explode('@',$email);
		$enc_mail = $arr[0];
        //base64_encode($enc_mail.$pwd.'8965424321'); //encryption
		$enc = base64_decode($pwd);

		if (strstr($enc, $enc_mail) && strstr($enc, '8965424321')) {
			$arr = explode($enc_mail,$enc);
			$arr1 = explode('8965424321',$arr[1]);
            return $decrypted_PIN = $arr1[0];
		}else{
            return "wrong_pwd";
		}
	}
	
	
	// change new password after login
	public function changeNewPassword(Request $request)
	{
		$data = $request->user();
		$userId = $data['rec_id'];
		$email = $data['email'];
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
        $validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
			'current_password' => 'required',
			'new_password' => 'required',
			'confirm_password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);            
        }else{
        	
			$current_password = trim(request('current_password'));
			$new_password = trim(request('new_password'));
			/*$new_password = self::passwordDecrypt($email,$newpassword);
			if($new_password == "wrong_pwd"){
				return response()->json(['status'=>'Failure','Result'=>'Wrong Password'], 200);
			}
			*/
			
			$confirm_password = trim(request('confirm_password'));
			
			/*$confirm_password = self::passwordDecrypt($email,$confirmpassword);
			if($confirm_password == "wrong_pwd"){
				return response()->json(['status'=>'Failure','Result'=>'Wrong Password'], 200);
			}
			*/
			$hash_password = User::select('password')->where(['rec_id' => $userId])->first();
			if (!Hash::check($current_password, $hash_password->password)) {
				return response()->json(['status'=>'Failure','Result'=>"Current Password does not match"], 200); 
			}
			
			$userInfo = User::select('*')->where("rec_id", "=", $userId)->first();
            //$password = "password";
                        
			if (strlen($confirm_password) < 8) {
				return response()->json(['status'=>'Failure','Result'=>"Password Length minimum 8 characters"], 200); 
			} else if (!preg_match("#.*^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $confirm_password)) {
				return response()->json(['status'=>'Failure','Result'=>"Password should include lowercase, uppercase, numbers and special characters(?!@)"], 200); 
			} else if ($confirm_password != $new_password) {
				return response()->json(['status'=>'Failure','Result'=>"Confirm Password should be equal to New Password"], 200);
			} else if ($new_password == $confirm_password) {
				$encrypted_plain_pass=safe_encrypt($confirm_password,config('constants.encrypt_key')); 
				$userInfo->plain_password = $encrypted_plain_pass;
				$userInfo->password = \Hash::make($confirm_password);
				$userInfo->save();
				
				//$device_id = $userInfo->device_id;
				//$mobile = $userInfo->telephone;
				//$name = ucwords($userInfo->first_name.' '.$userInfo->last_name);

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

				return response()->json(['status' => 'Success', 'Result' =>"Password has been updated successfully"], 200);
				
			} else {
				return response()->json(['status'=>'Failure','Result'=>"Confirm Password do not match"], 200); 
			}
		
        	
        }
    }
	
	
	/**
     * api/getProfile
     * Get user profile details
     * @bodyParam app_name string required
	 * @response {"status":"Success","Result":{"user_id":"RES82929ODD","email":"test@gmail.com","telephone":"+91-93243306789","first_name":"test","last_name":"test","address":"madhapur","address2":"hyderabad","country_name":"India","country_id":56,"gender":"male","married_status":"married","image_path":"UkVTODI5MjlPREQ=1559040599.jpeg","status":1,"refferallink_text":"ODD86217","commission_perc":10,"zipcode":500008,"evr_address":"adfdsf443242342","btc_address":"","eth_address":"","true_address":"","shipping_address1":"","shipping_address2":"","shipping_zipcode":0,"shipping_country":0,"shipping_user_mobile_no":"","registration_date":"01\/06\/2019"}}
 	 * 
	 */
	public function getProfile(Request $request)
	{
		$userInfo = $request->user();
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
        $validator = Validator::make($request->all(), [
            'app_name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);            
        }else{
        	$user_info = self::buildUserProfileArray($userInfo);
        	return response()->json(['status' => 'Success', 'Result' => $user_info], 200);
        	
        }
    }
    public static function buildUserProfileArray($userInfo){
    	$countryDet=self::getCountryById($userInfo['country_id']);
		
		$registration_date = UserController::convertDateToUTCForAPI($userInfo['registration_date']);
		
		$bankinfo = Bank_details::where('user_rec_id','=',$userInfo['rec_id'])->first();
		
		$bank_name = $bankinfo['bank_name'] != '' ? $bankinfo['bank_name'] : '';
		$bank_holder = $bankinfo['bank_holder'] != '' ? $bankinfo['bank_holder'] : '';
		$account_number = $bankinfo['account_number'] != '' ? $bankinfo['account_number'] : '';
		$bank_swift_code = $bankinfo['swift_code'] != '' ? $bankinfo['swift_code'] : '';
		$bank_address_one = $bankinfo['bank_address_one'] != '' ? $bankinfo['bank_address_one'] : '';
		$bank_address_two = $bankinfo['bank_address_two'] != '' ? $bankinfo['bank_address_two'] : '';
		$bank_country = $bankinfo['country'] != '' ? $bankinfo['country'] : '';
		$bank_state = $bankinfo['state'] != '' ? $bankinfo['state'] : '';
		$bank_zip_code = $bankinfo['zip_code'] != '' ? $bankinfo['zip_code'] : '';
		
		
		$profileImage = $userInfo['image'];
		if(!empty($profileImage)){
			$profile_pic = 	$profileImage;
		}else{
			$profile_pic = "avatar.png";
		}
		
		if(!empty($userInfo['zipcode'])){
			$zipcode = 	$userInfo['zipcode'];
		}else{
			$zipcode = "";
		}
		
		$country_name = $countryDet['country_name'] != '' ? $countryDet['country_name'] : '';
		$cntry_id = $countryDet['countryid'] != '' ? $countryDet['countryid'] : '';
		$address = $userInfo['address'] != '' ? $userInfo['address'] : '';
		$address2 = $userInfo['address2'] != '' ? $userInfo['address2'] : '';
		
		$pkg = Package_purchase_list::where('user_id','=',$userInfo['rec_id'])->where('active_package','=',1)->orderBy("rec_id", "DESC")->first();
		if(!empty($pkg)){
			$package_id = $pkg->package_id;
			$res = Packages::select('*')->where('id','=',$package_id)->first();
			if(!empty($res)){
				$pkgName = $res->package_name;
				$pkgValue = number_format($res->effective_amount,2);
				$subscription_date = UserController::convertDateToUTCForAPI($pkg->subscription_date);
				$expiry_date = UserController::convertDateToUTCForAPI($pkg->expiry_date);
				
				$current_date = date('Y-m-d H:i:s');
				if($pkg->expiry_date < $current_date){
					$expiry_status = "Expired";
					$expiry_btn_color = "Red";
					$renew_btn_color = "Orange";
				}else{
					$expiry_status = "Active";
					$expiry_btn_color = "";
					$renew_btn_color = "";
				}
				
			}else{
				$pkgName = "";
				$pkgValue = "";
				$subscription_date = "";
				$expiry_date = "";
				$expiry_status = "";
			}
			
			
		}else{
			$pkgName = "";
			$pkgValue = "";
			$package_amt = "";
			$subscription_date = "";
			$expiry_date = "";
			$expiry_status = "";
		}
		
		if(!empty($userInfo['telephone'])){ 
			$full_mobile = explode("-", $userInfo['telephone']);
			$mobile_ctry_code = $full_mobile[0];
			$mobile_no = $full_mobile[1];
		}else{
				$mobile_ctry_code ="";
				$mobile_no = "";
			}
		
    	$user_info = array('user_id'=>$userInfo['user_id'],'email'=>$userInfo['email'],'mobile_ctry_code'=>$mobile_ctry_code,'telephone'=>$mobile_no,'first_name'=>$userInfo['first_name'],'last_name'=>$userInfo['last_name'],'address'=>$address,'address2'=>$address2,'country_name'=>$country_name,'country_id'=>$cntry_id,'gender'=>$userInfo['gender'],'married_status'=>$userInfo['married_status'],'profile_pic'=>$profile_pic,'status'=>$userInfo['status'],'user_role'=>$userInfo['user_role'],'refferallink_text'=>$userInfo['refferallink_text'],'commission_perc'=>$userInfo['commission_perc'],'zipcode'=>$zipcode,'evr_address'=>$userInfo['evr_address'],"btc_address"=>$userInfo['btc_address'],"eth_address"=>$userInfo['eth_address'],"true_address"=>$userInfo['true_address'],'is_shipping_address_same'=>$userInfo['is_shipping_address_same'],'shipping_address1'=>$userInfo['shipping_address1'],'shipping_address2'=>$userInfo['shipping_address2'],'shipping_zipcode'=>$userInfo['shipping_zipcode'],'shipping_country'=>$userInfo['shipping_country'],'shipping_user_mobile_no'=>$userInfo['shipping_user_mobile_no'],'registration_date'=>$registration_date,'bank_name'=>$bank_name,'bank_holder'=>$bank_holder,'account_number'=>$account_number,'swift_code'=>$bank_swift_code,'bank_address_one'=>$bank_address_one,'bank_address_two'=>$bank_address_two,'bank_country'=>$bank_country,'bank_state'=>$bank_state,'bank_zipcode'=>$bank_zip_code,'package_name'=>$pkgName,'package_value'=>$pkgValue,'subscription_date'=>$subscription_date,'expiry_date'=>$expiry_date,'package_status'=>$expiry_status,'currency_symbol'=>'$','currency_format'=>'USD' );
		
    	return $user_info;
    }
    public static function getCountryById($country_id){
    	$countrydet=Country::where('countryid',$country_id)->first();
    	return $countrydet;
    }

    /**
     * api/updateProfile
     * Update user profile details
     * @bodyParam app_name string required
     * @bodyParam address_line1 string required
     * @bodyParam address_line2 string required
     * @bodyParam zip_code string required
     * @bodyParam country integer required
     * @bodyParam bank_name string required
     * @bodyParam bank_holder string required
     * @bodyParam account_number string required
     * @bodyParam swift_code string required
     * @bodyParam bank_address_line1 string required
     * @bodyParam bank_address_line2 string required
     * @bodyParam bank_country integer required
     * @bodyParam bank_state string required
     * @bodyParam bank_zipcode string required
     * @bodyParam gender string
	 * @bodyParam married_status string
	 * @bodyParam evr_address string
	 * @bodyParam btc_address string
	 * @bodyParam eth_address string
	 * @bodyParam true_address string
	 * @response {"status":"Success","message":"User Profile Updated Successfully"}
 	 * 
	 */
    public function updateProfile(Request $request)
	{
		$userInfo = $request->user();
		$response = array();
		
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
		
		$validator = Validator::make($request->all(), [
    		'app_name' => 'required',
			'first_name' => 'required',
			'last_name' => 'required',
			'mobile_no' => 'required',
			'gender' => 'required',
			'address_line1' => 'required',
    		'address_line2' => 'required',
    		'zip_code' => 'required',
    		'country' => 'required',
    		
    			
    	]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);            
        }
		
		$userInfo->first_name = request('first_name');
		$userInfo->last_name = request('last_name');
		$userInfo->telephone = request('mobile_no');
        $userInfo->address = request('address_line1');
		$userInfo->address2 = request('address_line2');
		$userInfo->zipcode = request('zip_code');
		$userInfo->country_id = request('country');
		
		if($request->has("gender")){
			$userInfo->gender = request('gender');
		}
		if($request->has("married_status")){
			$userInfo->married_status = request('married_status');
		}
		if($request->has("evr_address")){
			$userInfo->evr_address = request('evr_address');
		}
		if($request->has("btc_address")){
			$userInfo->btc_address = request('btc_address');
		}
		if($request->has("eth_address")){
			$userInfo->eth_address = request('eth_address');
		}
		if($request->has("true_address")){
			$userInfo->true_address = request('true_address');
		}
		if($request->has("is_shipping_address_same")){
			$userInfo->is_shipping_address_same = request('is_shipping_address_same');
		}
		if($request->has("shipping_address1")){
			$userInfo->shipping_address1 = request('shipping_address1');
		}
		if($request->has("shipping_address2")){
			$userInfo->shipping_address2 = request('shipping_address2');
		}
		if($request->has("shipping_zipcode")){
			$userInfo->shipping_zipcode = request('shipping_zipcode');
		}
		if($request->has("shipping_country")){
			$userInfo->shipping_country = request('shipping_country');
		}
		if($request->has("shipping_user_mobile_no")){
			$userInfo->shipping_user_mobile_no = request('shipping_user_mobile_no');
		}
		
		$userInfo->save();
		
		$bank_name = request('bank_name') != '' ? request('bank_name') : '';
		$bank_holder = request('bank_holder') != '' ? request('bank_holder') : '';
		$account_number = request('account_number') != '' ? request('account_number') : '';
		$swift_code = request('swift_code') != '' ? request('swift_code') : '';
		$bank_address_line1 = request('bank_address_line1') != '' ? request('bank_address_line1') : '';
		$bank_address_line2 = request('bank_address_line2') != '' ? request('bank_address_line2') : '';
		$bank_country = request('bank_country') != '' ? request('bank_country') : 0;
		$bank_state = request('bank_state') != '' ? request('bank_state') : '';
		$zip_code = request('zip_code') != '' ? request('zip_code') : '';
		
		$bank_data=array("user_rec_id"=>$userInfo['rec_id'],"bank_name"=>$bank_name,"bank_holder"=>$bank_holder,"account_number"=>$account_number,"swift_code"=>$swift_code,"bank_address_one"=>$bank_address_line1,"bank_address_two"=>$bank_address_line2,"country"=>$bank_country,"state"=>$bank_state,"zip_code"=>$zip_code,"updated_at"=>date("Y-m-d H:i:s"));
		
		Bank_details::updateOrCreate(["user_rec_id" => $userInfo['rec_id']], $bank_data);
		
		$response["status"] = "Success";
		$response["Result"] = "Profile Info Updated Successfully";
		
		return response()->json($response, 200);
	}

	/**
     * api/updateProfilepic
     * Update user profile picture
     * @bodyParam app_name string required
	 * @bodyParam image bytes required
	 * @response { "status":"Success",	"name":"1548047959.png"	}
 	 * 
	 */
	public function updateProfilepic(Request $request)
	{ 
		$userInfo = $request->user();
		$response = array();
		
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}

		if ($request->has('image')) {
			$image = $request->file('image');
			$org_name = $image->getClientOriginalName();
            $exts = explode('.', $org_name);
            if (count($exts) == 2) {
                $fileType = $image->getClientOriginalExtension();
                $fileTyp = strtolower($fileType);
                $fileData = array('image' => $image);
                $allowedTypes = array("jpeg", "jpg", "png");
                if (in_array($fileTyp, $allowedTypes)) {
                    $rules = array('image' => 'required|max:20000|mimes:png,jpg,jpeg');
                    $validator = Validator::make($fileData, $rules);
                    if ($validator->fails()) {
                    	return response()->json(['status'=>'Failure','Result'=>'Upload only JPEG,JPG,PNG images only with lessthan 2mb.'], 200);
                        
                    }else{
                    	$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
						$destinationPath = base_path('/public/profileImages');
						$image->move($destinationPath, $input['imagename']);
						$updat = array('image'=>$input['imagename']);
						$userInfo->image = $input['imagename'];
						$userInfo->save();
						
						$response["status"] = "Success";
						$response["Result"] = "Image Uploaded Successfully";
						$response["name"] = $input['imagename'];
						
                    } 
                }else{
	            	return response()->json(['status'=>'Failure','Result'=>'Invalid image file'], 200);
	            }
            }else{
            	return response()->json(['status'=>'Failure','Result'=>'Invalid image file'], 200);
            }
			
		}
		else
		{
			$response["status"] = "Failure";
			$response["Result"] = "No image found";
		}
		
		return response()->json($response, 200);
	}
	
	
}
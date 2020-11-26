<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\home\CustomerController;
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
use App\Multiple_box_purchase;
use Illuminate\Support\Facades\Log;
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
use App\Settings;
use App\Transactions;
use App\PaymentsHistory;
use App\Purchase_order_details;
use App\Free_trail_requested_users;
use App\Library\Common;

class BestBoxThirdpartyController extends Controller
{
    //sign up user

    public function bbCustomerSignupAPI(Request $request)
	{
        $applications = config('constants.applications');
        if (!in_array(request('app_name'), $applications))
        {
            return response()->json(['status' => 'Failure', 'Code' => 400, 'message' => ['Invalid request'], 'Result' => []], 400);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:4|regex:/^[a-zA-Z ]{4,20}$/',
			'last_name' => 'required|min:4|regex:/^[a-zA-Z ]{4,26}$/',
            'email' => 'required|email|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/|unique:users',
            'bbpassword' => 'required|',
            'referralId' => 'required',
            'trail_period_duration' => 'required'
        ]);
        if ($validator->fails()) {
            $errs = $validator->messages()->all();
            $str = array();
            foreach($errs as $arr){
                //$str = $str.'<li>'.$arr.'</li>';
                $str[] = $arr;
            }
            return response()->json(['status' => 'Failure', 'Code' => 301, 'message' => $str, 'Result' => []], 200);
        }
        //trigger exception in a "try" block
        try {
            $email = trim($request->email);
            $first_name = trim($request->first_name);
            $last_name = trim($request->last_name);
            $referral_Id = trim($request->referralId);
            $trial_duration = trim($request->trail_period_duration);
            $bbpassword = trim($request->bbpassword);
            //$bbpassword = str_replace(' ', '+', $bbpassword);
            //decrypt encryption password
            //Log::info('enpassword'.$bbpassword);
            $password = self::decryption($bbpassword);
            //Log::info('password'.$password);
            if($password==''){
                return response()->json(['status' => 'Failure', 'Code' => 301, 'message' => array('Password required'), 'Result' => []], 200);
            }else if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $password) === 0){
                $errPass = 'Password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit';
                return response()->json(['status' => 'Failure', 'Code' => 301, 'message' => array($errPass), 'Result' => []], 200);
            }
            //password check
            // Password must be strong
            // if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $password) === 0){
            //     $errPass = 'Password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit';
            //     return response()->json(['status' => 'Failure', 'Code' => 301, 'message' => array($errPass), 'Result' => []], 200);
            // }

            $ref_userInfo = User::where('refferallink_text', $referral_Id)->first();

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
                $encrypted_plain_pass=safe_encrypt($password,config('constants.encrypt_key'));
                $password = \Hash::make($password);
                $user= User::create([
                    'user_id' => $user_id,
                    'referral_userid' => $referral_userid,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'password' => $password,
                    'plain_password'=>$encrypted_plain_pass,
                    'refferallink_text' => $referral_code,
                    'user_role' => 4,
                    'registration_date' =>date('Y-m-d H:i:s'),
                    'referral_join' => 1,
                    'application_id' => 1234,
                    'email_verify' => 1,
                    'status' => 1
                ]);

                $last_inserted_id = $user->rec_id;
                User::where(['rec_id'=>$last_inserted_id])->update(array('created_by'=>$last_inserted_id));
                // added 0 points joining bonus for customers
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
                        'admin_id' => $admin_id
                    ]);
                }

                $i=1;
                $num=$referral_userid;
                $user_role=4;
                while($num!=999){
                    if($num!=999 && $i < 150){
                        Unilevel_tree::create([
                            'down_id' => $last_inserted_id,
                            'upliner_id' => $num,
                            'level' => $i,
                            'user_role' => $user_role
                        ]);
                        $i++;
                        $results = User::where('rec_id', $num)->select('referral_userid')->first();
                        $num=$results->referral_userid;
                    }
                }

                //decrypt encryption password
                $decrypted_password = self::decryption($bbpassword);

                $data['useremail'] = array('name'=>$first_name.' '.$last_name,'customer_id'=>$user_id,'user_id'=>$last_inserted_id,'toemail'=>$email,'referral_link'=>$referral_code,'application_id'=>1234,'password'=>$decrypted_password);
                $emailid = array('toemail' => $email);
                Mail::send(['html'=>'email_templates.referral-join'], $data, function($message) use ($emailid) {
                    $message->to($emailid['toemail'], 'Bestbox Signup Confirmation')->subject
                    ('Bestbox Confirmation');
                    $message->from('noreply@bestbox.net','BestBox');
                });

                //free trail request

                //convert from day to minutes
                $expirytime = 60*60*24*$trial_duration;
                $trail_start_time = date('Y-m-d H:i:s');
                $trail_end_time = date( "Y-m-d H:i:s", strtotime( $trail_start_time )+$expirytime );
                $ftrail = Free_trail_requested_users::create([
                    'user_id' => $last_inserted_id,
                    'trail_requested_time' => date('Y-m-d H:i:s'),
                    "trail_start_time"=>$trail_start_time,
                    "trail_end_time"=>$trail_end_time,
                    "status"=>1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                $data['useremail'] = array('name'=>$first_name.' '.$last_name,'user_id'=>$user_id,'toemail'=>$email,'trial_duration'=>$trial_duration);
                $emailid = array('toemail' => $email);
                Mail::send(['html'=>'email_templates.trialAccountActivatedEmail'], $data, function($message) use ($emailid) {
                    $message->to($emailid['toemail'], 'Customer ID')->subject('Trial Account Activated');
                    $message->from('support@bestbox.net','BestBox');
                });

                return response()->json(['status'=>'Success', 'Code' => 200 , 'message' => ["Registration successful. Please check your email for Referral Code.."],'Result'=> array('name'=>$first_name.' '.$last_name, 'user_id'=> $user_id, 'email'=>$email)], 200);

            }else{
                return response()->json(['status'=> 'Failure' , 'Code' => 302 , 'message' => ['Referral User Id Not Valid'],'Result'=> []], 200);
            }
        }
        //catch exception
        catch(Exception $e){
            return response()->json(['status'=> 'Failure' , 'Code' => 303 , 'message' => [$e->getMessage()],'Result'=> []], 200);
        }

    }

    public function bbPackagePurchaseAPI(Request $request)
    {
        $applications = config('constants.applications');
        if (!in_array($request->app_name, $applications))
        {
            return response()->json(['status' => 'Failure', 'Code' => 400, 'message' => ['Invalid request'], 'Result' => []], 400);
        }

        $admin_id = config('constants.ADMIN_ID');

        $validator = Validator::make($request->all(), [
            'agentUserID' => 'required',
            'bbpassword' => 'required',
            'customerUserId' => 'required',
            'package' => 'required',
        ]);
        if ($validator->fails()) {
            $errs = $validator->messages()->all();
            $str = array();
            foreach($errs as $arr){
                //$str = $str.'<li>'.$arr.'</li>';
                $str[] = $arr;
            }
            return response()->json(['status' => 'Failure', 'Code' => 301, 'message' => $str, 'Result' => []], 200);
        }

        $agentUserID = $request->agentUserID;
        $bbpassword = $request->bbpassword;
        $customerUserId = $request->customerUserId;
        $packageId = $request->package;
        //decrypt encryption password
        $password = self::decryption($bbpassword);

        $agent_userInfo = User::where('email', $agentUserID)->first();
        $customer_userInfo = User::where('email', $customerUserId)->first();

        if(empty($agent_userInfo)) {
            return response()->json(['status' => 'Failure','Code' => 304, 'message' => ['Invalid Agent User ID'] ,'Result' => []], 200);
        }

        if(empty($customer_userInfo)) {
            return response()->json(['status' => 'Failure', 'Code' => 305, 'message' => ['Invalid Customer User ID'], 'Result' =>[]], 200);
        }

        if (!Hash::check($password, $agent_userInfo['password']))
        {
            return response()->json(['status' => 'Failure',  'Code' => 306, 'message' => ['Agent Username and Password Not matched'], 'Result' => []], 200);
        }

        $agentId = $agent_userInfo['rec_id'];
        $customerId = $customer_userInfo['rec_id'];

        //decrypt encryption password
        $packageId = str_replace(' ', '+', $packageId);
        $packageId = (int)self::my_simple_crypt($packageId,'d');

        $packageInfo = Packages::where("id", $packageId)->first();
        $BOXpackageId = array(11,12,20,23,24);
        $box_purchased = Package_purchase_list::where("user_id", $customerId)->whereIn("package_id",$BOXpackageId)->count();

        $status = 0;$addr=0;
        if(!empty($packageInfo)) {
            if($packageInfo->setupbox_status == 1) {
                if($box_purchased >0){
                    return response()->json(['status' => 'Failure',  'Code' => 307, 'message' => ['User Already purchased BestBOX'], 'Result' => []], 200);
                }

                $status = 1;
                $addr = "";

            }else if($box_purchased >0){
                $status = 1;
                $addr = "";
            }else{
                return response()->json(['status' => 'Failure',  'Code' => 308, 'message' => ['Please Purchase BestBOX First'], 'Result' => []], 200);
            }
        }else{
            return response()->json(['status' => 'Failure', 'Code' => 309, 'message' => ['Invalid Package'], 'Result' => []], 200);
        }

        $previous_packages_count = Package_purchase_list::where("user_id", $customerId)->where("package_id",'!=',11)->count();

        if($previous_packages_count > 0){
            $subscription_type = 'Renewal';
            $subs_type = 2;
        }else{
            $subscription_type = 'New';
            $subs_type = 1;
        }
        $desc = '';

        if($status == 1){

            if($subs_type == 2 && $previous_packages_count>0){
                $customer_id = $customerId;
                $type=2;
                $desc = $packageInfo->effective_amount . ' USD paid for renewal package purchase.';
            }else if(in_array($packageId, $BOXpackageId)){
                $customer_id = $customerId;
                $type=1;
                if($packageId == 11) {
                    $desc = $packageInfo->effective_amount . ' USD paid for BestBox purchase.';
                }else{
                    $desc = $packageInfo->effective_amount . ' USD paid for BestBox + package purchase.';
                }
            }else if($previous_packages_count == 0 && $subs_type == 1){
                $customer_id = $customerId;
                $type=1;
                $desc = $packageInfo->effective_amount . ' USD paid for customer package purchase.';
            }
            // else if($subscription_type == 'New' && $subs_type == 1){
            //     //multiple box
            //     $customer_id = CustomerController::createSubUser($customer_userInfo);
            //     Multiple_box_purchase::create([
            //         'user_id' => $customerId,
            //         'sub_user_id' => $customer_id,
            //         'package_id' => $packageId
            //     ]);
            //     $type=1;
            //     $desc = $packageInfo->effective_amount . ' USD paid for customer package purchase.';
            // }


            if($agent_userInfo->user_role == 4){
                $uplinerInfo = Unilevel_tree::leftjoin('users','unilevel_tree.upliner_id','=','users.rec_id')->where('unilevel_tree.down_id', $agentId)->where('users.user_role','!=',4)->select('users.*')->orderBy('unilevel_tree.level','ASC')->first();
                if(!empty($uplinerInfo)){
                    $upliner_userId = $uplinerInfo->rec_id;
                    $upliner_user_comm_per = $uplinerInfo->commission_perc;
                }
            }else{
                $uplinerInfo = Unilevel_tree::leftjoin('users','unilevel_tree.upliner_id','=','users.rec_id')->where('unilevel_tree.down_id', $customer_id)->where('users.user_role','!=',4)->select('users.*')->orderBy('unilevel_tree.level','ASC')->first();
                if(!empty($uplinerInfo)){
                    $upliner_userId = $uplinerInfo->rec_id;
                    $upliner_user_comm_per = $uplinerInfo->commission_perc;
                }
            }

            $wal = Wallet::where("user_id", $agentId)->first();

            if ($packageInfo->effective_amount <= $wal->amount) {
                //payment by reseller/agent wallet
                Wallet::where('user_id', $agentId)->decrement('amount', $packageInfo->effective_amount);
                //transactions table
                $bal = $wal->amount - $packageInfo->effective_amount;

                $transaction_no = self::generate_randam_string('PID', $strength = 9);
                $notification_message = "<strong>".date("F jS, Y g:i a")."</strong> You have successfully transferred <strong>Pay For My Friend Package ".$packageInfo->package_name."</strong> amount <strong>".$packageInfo->effective_amount."</strong> USD by BestBOX Wallet. The Payment ID is ".$transaction_no;
                CustomerController::user_transactions($transaction_no,$packageId,$agentId,$agentId ,$customer_id, 0, $packageInfo->effective_amount, $bal, 'Pay For My Friend', $desc, $notification_message);

                //package purchased and commission pay function
                $pack_pur_id = CustomerController::purchaseCommission($customer_id,$uplinerInfo,$packageInfo,$wal,$customer_id,$packageId,$upliner_userId,$upliner_user_comm_per,$customer_userInfo->first_name,$customer_userInfo->last_name,2,$agentId);

                $order_id = CustomerController::generate_randam_string('ORD', $strength = 9);
                Purchase_order_details::create([
                            'user_id' => $customer_id,
                            'order_id' => $order_id,
                            'purchased_date' => date('Y-m-d H:i:s'),
                            'purchased_from' => 'Wallet',
                            'sender_id' => $agentId,
                            'status' => 1,
                            'amount' => $packageInfo->effective_amount,
                            'package_purchased_id' => $pack_pur_id,
                            'type' => $type,
                            'shipping_address' => $addr
                        ]);

                // send FCM to sender
                Common::payForMyFriendFCM($agent_userInfo, $packageInfo->package_name,$packageInfo->effective_amount, $transaction_no, "sender", $customer_userInfo, 'BESTBOX');

                if($type == 1){
                    // send FCM to Receiver
                    Common::packagePurchasedFCMToReceiver($agent_userInfo, $packageInfo->package_name,$packageInfo->effective_amount, $transaction_no, "receiver", $customer_userInfo, 'BESTBOX');
                }else{
                    // send FCM to Receiver
                    //Common::packageRenewalFCM($userInfo,$pack->package_name,$pack->effective_amount,$transaction_no,"receiver",$customer_det);
                }
                $data = array('package' => $packageInfo->package_name, 'amount' => $packageInfo->effective_amount, 'transaction_no' => $transaction_no,'description' => $desc);
                return response()->json(['status' => 'Success', 'Code' => 200, 'message' => ['Package Purchased Successfully'], 'Result' => $data], 200);
            } else {
                return response()->json(['status' => 'Failure', 'Code' => 310, 'message' => ['Insufficient Balance In your Wallet'], 'Result' => []], 200);
            }

        }
    }

    public function bbCountryListAPI(Request $request) {
        $applications = config('constants.applications');
        if (!in_array(request('app_name'), $applications))
        {
            return response()->json(['status' => 'Failure', 'Code' => 400, 'message' => ['Invalid request'], 'Result' => []], 400);
        }

        $data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();

        return response()->json(['status' => 'Success', 'Result' => $data['country_data']], 200);

    }

    public function bbPackageListAPI(Request $request) {
        $applications = config('constants.applications');
        if (!in_array(request('app_name'), $applications))
        {
            return response()->json(['status' => 'Failure', 'Code' => 400, 'message' => ['Invalid request'], 'Result' => []], 400);
        }

        $data['packageList'] = array();

        $packageList = DB::table('packages')->where('status', 1)->orderBy('id', 'ASC')->get();

        if(!empty($packageList)){
            foreach($packageList as $package){
                //decrypt encryption password
                $package_id = self::my_simple_crypt($package->id, 'e' );
                $data['pacakge_list'][] = array(
                    'id' => $package_id,
                    'package_name' => $package->package_name,
                    'description' => $package->description,
                    'amount' => $package->effective_amount,
                    'duration' => $package->duration,
                );
            }
        }

        return response()->json(['status' => 'Success', 'Result' => $data['pacakge_list']], 200);

    }

    public static function encryption($string_to_encrypt) {
        //$string_to_encrypt="BBBOX";
        $password="BBBOX";
        $encrypted_string=openssl_encrypt($string_to_encrypt,"AES-128-ECB",$password);

        return $encrypted_string;
        // Store a string into the variable which
        // need to be Encrypted
        //$simple_string = "BESTBOX2020";

        // Store cipher method
        // $ciphering = "BF-CBC";

        // // Use OpenSSl encryption method
        // $iv_length = openssl_cipher_iv_length($ciphering);
        // $options = 0;

        // // Use random_bytes() function which gives
        // // randomly 16 digit values
        // $encryption_iv = random_bytes($iv_length);

        // // Alternatively, we can use any 16 digit
        // // characters or numeric for iv
        // $encryption_key = openssl_digest(php_uname(), 'MD5', TRUE);

        // // Encryption of string process starts
        // $encryption = openssl_encrypt($simple_string, $ciphering,
        //         $encryption_key, $options, $encryption_iv);

        // // Display the encrypted string
        // return $encryption;
    }

    public static function decryption ($encrypted_string) {
       // $string_to_encrypt="BBBOX";
        $password="BBBOX";

        $decrypted_string=openssl_decrypt($encrypted_string,"AES-128-ECB",$password);
        return $decrypted_string;
        // // Store cipher method
        // $ciphering = "BF-CBC";

        // // Use OpenSSl encryption method
        // $iv_length = openssl_cipher_iv_length($ciphering);
        // $options = 0;

        // // Decryption of string process starts
        // // Used random_bytes() which gives randomly
        // // 16 digit values
        // $decryption_iv = random_bytes($iv_length);

        // // Store the decryption key
        // $decryption_key = openssl_digest(php_uname(), 'MD5', TRUE);

        // // Descrypt the string
        // $decryption = openssl_decrypt ($encryption, $ciphering,
        //             $decryption_key, $options, $decryption_iv);

        // // Display the decrypted string
        // return $decryption;
    }

    public static function generate_randam_string($type, $strength = 9) {

		$input = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$input_length = strlen($input);
		$random_string = '';
		for($i = 0; $i < $strength; $i++) {
			$random_character = $input[mt_rand(0, $input_length - 1)];
			$random_string .= $random_character;
		}

		return $type.$random_string;
    }

    public static function my_simple_crypt( $string, $action = 'e' ) {
        // you may change these values to your own
        $secret_key = 'my_simple_secret_key';
        $secret_iv = 'my_simple_secret_iv';

        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $secret_key );
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

        if( $action == 'e' ) {
            $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
        }
        else if( $action == 'd' ){
            $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
        }

        return $output;
    }
}

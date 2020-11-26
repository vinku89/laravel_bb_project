<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\home\BtcController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use App\Http\Requests;
use App\Models\registerModel;
use App\Models\packageModel;
use App\Country;
use App\RolesPermissions;
use App\Library\Common;
use Session;
use DateTime;
use App\User;
use Auth;
use DB;
use App\UsersDevicesList;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected function validator(array $data)
    {
        $emailid=$data['email'];
        return Validator::make($data, [
            'email' => 'required', 
            'password' => 'required',
            // new rules here
        ]);
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm(){

        return view ('auth.login');
    }

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
			'password' => 'required'
        ]);
        
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach($errs as $arr){
				$str = $str.'<li>'.$arr.'</li>';
            }
            return Redirect::back()->withErrors(['<ul>'.$str.'</ul>', '<ul>'.$str.'</ul>']);
        }

        $email=$request['email'];
        $password=$request['password'];
        $userinfo=User::where('email',$email)->whereIn('user_role',[2,3])->first();        
        
        if($userinfo!==null){
            $checkRole = RolesPermissions::where('id',$userinfo->user_role)->select('status')->first();
            /*if ($userinfo->email_verify == 0) {
                Session::flash('message', 'Your account not verified, please check your mail and verify. <br> <a href="'.url('/resendEmailVerification').'" style="color: #fd0000;font-weight: 400;text-decoration: underline;">Resend Verification Email</a>');
                Session::flash('alert','Failure');
                return redirect('login');
            }
            else */
            if($userinfo->email_verify == 0){
                Session::flash('message', 'Please verify your email and login.');
                Session::flash('alert','Failure');
                return redirect('login');
            }
            else if($userinfo->email_verify == 1 && $userinfo->status == 0){
                Session::flash('message', 'Your account has been deactivated. Please contact support on support@bestbox.net');
                Session::flash('alert','Failure');
                return redirect('login');
            }
            else if($userinfo->user_role == 0){
                Session::flash('message', 'Your account not yet activated. Please contact support on support@bestbox.net');
                Session::flash('alert','Failure');
                return redirect('login');
            }
            else if($checkRole->status == 0){
                Session::flash('message', 'Your account has been deactivated. Please contact support on support@bestbox.net');
                Session::flash('alert','Failure');
                return redirect('login');
            }
            else{
                
                $remember_me = $request->has('remember_me') ? true : false; 
                $credentials = $request->only('email', 'password');
                if (Auth::attempt($credentials) == "") {
                    // Authentication passed...
                    Session::flash('message', 'Invalid Password');
                    Session::flash('alert','Failure');
                    return redirect('login');
                }
                else{
                    $userData = ['rec_id' => $userinfo->rec_id,'user_id' => $userinfo->user_id, 'first_name' => $userinfo->first_name, 'last_name' => $userinfo->last_name, 'user_role' => $userinfo->user_role, 'admin_login' => $userinfo->admin_login,'mobile' => $userinfo->telephone, 'email'=>$userinfo->email,'registration_date'=>$userinfo->registration_date,'refferallink_text'=>$userinfo->refferallink_text];
                             \Session::put('userData', $userData);

                    if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
                                    $ipaddr = $_SERVER['HTTP_X_FORWARDED_FOR'];
                                } else {
                                    $ipaddr = $_SERVER['REMOTE_ADDR'];
                                }
                    $daraIns = ['user_id' => $userinfo->rec_id, 'username' => $userinfo->user_id, 'ip_address'=>$ipaddr,'browser_type'=>'','req_from'=>'Web','created_at'=>NOW()];
                    $value = registerModel::insert('visitor', $daraIns);
                    //return redirect('dashboard#googtrans('.$userinfo->language.')');
                    $this->loginNotification($userinfo->first_name, $userinfo->telephone, $userinfo->country_id, $userinfo->rec_id,$userinfo->device_id, $userinfo->mbl_platform,'Web',0,$ipaddr,$userinfo->user_role);

                    return redirect('dashboard');
                }
            }
        }else{
            Session::flash('message', 'Invalid Username');
            Session::flash('alert','Failure');
            return redirect('login');
        }

    }

    public function loginNotification($name, $telephone, $country, $user_id,$device_id1, $platform,$req_from="",$visitorId="",$ipaddr='',$user_role)
    {
        
            $client_code = "BESTBOX";
            
            if($user_role == 1){
                $user_role_name = "Super Admin";    
            }else if($user_role == 2){
                $user_role_name = "Reseller";   
            }else if($user_role == 3){
                $user_role_name = "Agent";  
            }else if($user_role == 4){
                $user_role_name = "Customer";   
            }else {
                $user_role_name = "";   
            }
            
            
            if(!empty($telephone)){
                $full_mobile = explode("-", $telephone);
                $mobile = $full_mobile[1];
            }else{
                $mobile = "";
            }
            
            
            $date = date('d-m-Y');
            $time = date("h.i A");
            
           
           $countryInfo = Country::select('*')->where('countryid', '=',$country)->first();
            if(!empty($countryInfo)){
                $location =     $countryInfo->country_name;
                $nationality =  $countryInfo->nationality;
            }else{
                $location = "";
                $nationality = "";
            }
           
            //used to know whether the user login from mobile or from web
            if($req_from == 'Mobile_app'){
                $dev = "Mobile App";
            }else{
                //$device=isMobileDevice();
                //used to know user browser
                //$browser = getBrowser();
                $dev = ""; //$device . "(" . $browser . ")";
            }
            //$myrtime = date("Y-m-d H:i", strtotime('-8 hours'));
            $myrtime = date("Y-m-d H:i");
            $temp=explode(" ",$myrtime);
            $today = $temp[0];
            $ttime=$temp[1];
            $new_time = $today."T".$ttime;
            $clientLogopath = "login_icon.png"; //url('/public/fcmIcons/login_icon.png');
            $title = "Login Confirmation";
            // Close request to clear up some resources
            $arr = array("ClientCode" => $client_code,"clientLogopath" => $clientLogopath,"title" => $title, "Message" => 'Welcome', "MessageType"=>'BESTBOX_LOGIN_NOTIFICATION', "MobileNo" => $mobile, "UserName" => $name, "Date" => $date, "Time" => $time, "Device" => $dev, "Location" => $location, "IPAddress" => $ipaddr,'DateTime'=>$new_time,'CustomerCare'=>'+603-78900049','user_role'=>$user_role_name,'user_id'=>$user_id);
            $iosloginheading = "we detected a login into your account ".$name;
            $json_data["LoginNotificationFCM"] = json_encode($arr);
        
            $device_id = array($device_id1);  
            //Log::info("mobile platform ".$platform);
            if($platform == 'ios'){
                //$res = Common::sendFCMIOS($device_id1,$json_data,$mobile, 'EVR_LOGIN_NOTIFICATION');
                //$res = Common::sendFCMIOSLoginNotification($device_id1,$json_data,$telephone, 'BESTBOX_LOGIN_NOTIFICATION',$iosloginheading,$user_id);
            }else if($platform == 'android'){
                //Log::info("mobile platform2 ".$platform);
                $res = Common::sendFCMAndroid($device_id,$json_data,$telephone, 'BESTBOX_LOGIN_NOTIFICATION');
                //print_r($res);exit();
            }
        
    }

    public function logout() {
        $data = Session::get('userData');
        $role = $data['user_role'];
        $user_id = $data['rec_id'];
        $admin_login = (!empty($data['admin_login'])) ? $data['admin_login'] : '';
        Session::flush('userData');
        if($admin_login == 1){
            return redirect('Admin');
        }elseif($role == 4){
            $userData = User::where('rec_id',$user_id)->first();
            $login_count = $userData['web_login_count'];
            if($login_count == 0) {
                $login_count = 1;
            }else{
                $login_count = $login_count-1;
            }
            $is_online = ($login_count == 0) ? 0 : 1;
            User::where(['rec_id' => $user_id])->update(['is_online' => $is_online, 'web_login_count' => $login_count]);
            $user_logged_device_rec_id = $data['user_logged_device_rec_id'];
            if(isset($data['user_logged_device_rec_id']) && !empty($data['user_logged_device_rec_id'])){
                UsersDevicesList::where('user_id','=',$user_id)->where('rec_id', '=', $data['user_logged_device_rec_id'])->update(['is_online' => 0, 'is_login' => 0]); 
            }
            return redirect('customerLogin');
        }else{
            return redirect('login');
        }
        
    }

    public function customerLoginForm(){

        return view ('auth.customer_login');
    }

    public function customerLogin(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'force_logout' => 'required'
        ]);
        
        if ($validator->fails()) {
            $errs = $validator->messages()->all();
            $str = '';
            foreach($errs as $arr){
                $str = $str.'<li>'.$arr.'</li>';
            }
            return Redirect::back()->withErrors(['<ul>'.$str.'</ul>', '<ul>'.$str.'</ul>']);
        }
        $rq_email = request('email');
        $udata = User::select('*')->where('user_role','=',4)->where(function ($query) use ($rq_email) {
                    $query->where('user_id', '=', $rq_email)
                          ->orWhere('email', '=', $rq_email);
                })->first();
        $email = $udata['email'];
        $user_id = $udata['user_id'];

        //$email=$request['email'];
        $password=$request['password'];
        $force_logout = $request['force_logout'];
        $userinfo=User::where('user_id',$user_id)->first();
        $checkRole = RolesPermissions::where('id',$userinfo->user_role)->select('status')->first();
        
        if($userinfo!==null){
            /*if ($userinfo->email_verify == 0) {
                    Session::flash('message', 'Your account not verified, please check your mail and verify. <br> <a href="'.url('/resendEmailVerification').'" style="color: #fd0000;font-weight: 400;text-decoration: underline;">Resend Verification Email</a>');
                    Session::flash('alert','Failure');
                    return redirect('customerLogin');
            }
            else*/ 
            $login_removed_device_id = "";
            if($force_logout) {
                $device_data = UsersDevicesList::where(['user_id' => $udata['rec_id'], 'is_login' => 1])->orderBy('login_time','ASC')->first();
                $login_removed_device_id = $device_data['rec_id'];
                UsersDevicesList::where('rec_id',$device_data['rec_id'])->update(['is_login' => 0, 'is_online' => 0]);
            }
            $app_name = 'BESTBOX';
            //DB::enableQueryLog();
            $logged_in_device_count = UsersDevicesList::where(['user_id' => $udata['rec_id'], 'is_login' => 1])->count();
            //$query = DB::getQueryLog();
            //print_r($query);exit;
            //Log::info('count'.$logged_in_device_count);
            // if($userinfo->is_online){
            //     $logged_in_device_count = $logged_in_device_count+($userinfo->web_login_count+1);
            // }else{
            //     $logged_in_device_count = $logged_in_device_count+1;
            // }

            if($userinfo->email_verify == 0){
                Session::flash('message', 'Please verify your email before trying to log in, check your spam folder if you have not received the email yet');
                Session::flash('force_login',0);
                Session::flash('alert','Failure');
                return redirect('customerLogin');
            }
            else if($userinfo->email_verify == 1 && $userinfo->status == 0){
                Session::flash('message', 'Your account has been deactivated. Please contact support on support@bestbox.net');
                Session::flash('force_login',0);
                Session::flash('alert','Failure');
                return redirect('customerLogin');
            }
            else if($checkRole->status == 0){
                Session::flash('message', 'Your account has been deactivated. Please contact support on support@bestbox.net');
                Session::flash('force_login',0);
                Session::flash('alert','Failure');
                return redirect('customerLogin');
            }
            else if($logged_in_device_count >=2) {
                 Session::flash('message', 'You have reached the maximum login limit of 2 devices per account. Click “continue” to log out one other device or click “cancel” to cancel this login.');
                 Session::flash('force_login',1);
                 Session::flash('alert','Alert');
                 Session::flash('email',$email);
                 Session::flash('password',$password);
                 return Redirect::to('customerLogin')->withInput();
            }
            else{

                $remember_me = $request->has('remember_me') ? true : false; 
                $credentials = $request->only('email', 'password');

                if (Auth::attempt(['user_id' => $user_id, 'password' => $password]) == "") {
                    // Authentication passed...
                    Session::flash('message', 'Invalid Password');
                    Session::flash('alert','Failure');
                    return redirect('customerLogin');
                }
                else{
                    $encrypted_plain_pass=safe_encrypt($password,config('constants.encrypt_key'));   
                    $web_login_count = $userinfo->web_login_count+1;
                    $upddata=array("plain_password"=>$encrypted_plain_pass,'is_online' => 1, 'web_login_count' => $web_login_count);   
                    User::where('rec_id' , $userinfo->rec_id)->update($upddata);   
                    //insert data
                    $app_name = 'BESTBOX';
                    $data = [
                        'user_id' => $udata['rec_id'],
                        'application_name' => $app_name,
                        'device_id' => '',
                        'device_type' => 'web',
                        'created_at' => date("Y-m-d H:i:s"),
                        'login_time' => date("Y-m-d H:i:s"),
                        'is_online' => 1,
                        'is_login' => 1
                    ];
                    //print_r($data);exit;
                    $result = UsersDevicesList::insert($data);
                    $user_logged_device_rec_id = DB::getPdo()->lastInsertId();
                    //Log::info('inserted_id'.$user_logged_device_rec_id);
                    $userData = ['rec_id' => $userinfo->rec_id,'user_id' => $userinfo->user_id, 'first_name' => $userinfo->first_name, 'last_name' => $userinfo->last_name, 'user_role' => $userinfo->user_role,'admin_login' => $userinfo->admin_login, 'mobile' => $userinfo->telephone, 'email'=>$userinfo->email,'registration_date'=>$userinfo->registration_date,'refferallink_text'=>$userinfo->refferallink_text, 'user_logged_device_rec_id' => $user_logged_device_rec_id];
                    \Session::put('userData', $userData);

                    if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
                                    $ipaddr = $_SERVER['HTTP_X_FORWARDED_FOR'];
                                } else {
                                    $ipaddr = $_SERVER['REMOTE_ADDR'];
                                }
                    $daraIns = ['user_id' => $userinfo->rec_id, 'username' => $userinfo->user_id, 'ip_address'=>$ipaddr,'browser_type'=>'','req_from'=>'Web','created_at'=>NOW()];
                    $value = registerModel::insert('visitor', $daraIns);
                    //return redirect('dashboard#googtrans('.$userinfo->language.')');
                    
                    if($login_removed_device_id!='') {
                        
                        $logged_in_device = UsersDevicesList::where(['rec_id' => $login_removed_device_id, 'user_id' => $userinfo->rec_id])->orderBy('login_time','ASC')->first();
                        $arr = array(
                            'status'=>'Success',
                            'logout'=>'logout',
                            'desc' => 'You have been logged out as your account has reached the maximum login limit of 2 devices per account.'
                        );
                
                        $json_data["LogoutNotificationFCM"] = json_encode($arr);
                        $mobile = $udata['telephone'];
                        $device_id = array($logged_in_device['device_id']);
                        $application_name = $logged_in_device['application_name'];
                        $MessageType = 'BESTBOX_LOGOUT_NOTIFICATION';		
                        if($logged_in_device['device_type'] == 'ios'){
                            //$res = Common::sendFCMIOSLogoutNotification($oldDevice_id,$json_data,$mobile,'BESTBOX_LOGOUT_NOTIFICATION');
                            
                        }else if($logged_in_device['device_type'] == 'android'){
                            Log::info('send Logout fcm to mobile');
                            $res = Common::sendFCMAndroid($device_id,$json_data,$mobile, $MessageType,$application_name);
                            if($res){
                                Log::info('sent');
                            }
                        }
                    }
                    

                    $this->loginNotification($userinfo->first_name, $userinfo->telephone, $userinfo->country_id, $userinfo->rec_id,$userinfo->device_id, $userinfo->mbl_platform,'Web',0,$ipaddr,$userinfo->user_role);
                    
                    return redirect('dashboard');
                }
            }

        }else{
            Session::flash('message', 'Invalid Username');
            Session::flash('alert','Failure');
            return redirect('customerLogin');
        }

    }

    public function checkUsername(Request $request){

        $email = $request->email;
        $type = $request->login_type;
        if($type == "Admin"){
        	$cnt=User::where('email',$email)->where('admin_login','=',1)->first();
        }else{
        	$cnt=User::where('email',$email)->whereIn('user_role',[2,3])->first();
        }
 
        if(!empty($cnt) && $cnt->status == 1){
            $data = array('status' => 'Success','message' => 'Valid Email Id');
        }
        else if(!empty($cnt) && $cnt->email_verify == 0){
            $data = array('status' => 'Failure','message' => 'Please verify your email before trying to log in, check your spam folder if you have not received the email yet');
        }
        else if(!empty($cnt) && $cnt->email_verify == 1 && $cnt->status == 0){
            $data = array('status' => 'Failure','message' => 'Your account has been deactivated. Please contact support on support@bestbox.net');
        }
        else{
            $data = array('status' => 'Failure','message' => 'We can not find with that e-mail address.');
        }

        return $data;
    }


    public function checkCustomerUsername(Request $request){

        $email = $request->email;
        $cnt = User::select('*')->where('user_role','=',4)->where(function ($query) use ($email) {
                    $query->where('user_id', '=', $email)
                          ->orWhere('email', '=', $email);
                })->first();

        if(!empty($cnt) && $cnt->status == 1){
            $data = array('status' => 'Success','message' => 'Valid Email / User Id');
        }
        else if(!empty($cnt) && $cnt->email_verify == 0){
            $data = array('status' => 'Failure','message' => 'Please verify your email before trying to log in, check your spam folder if you have not received the email yet');
        }
        else if(!empty($cnt) && $cnt->email_verify == 1 && $cnt->status == 0){
            $data = array('status' => 'Failure','message' => 'Your account has been deactivated. Please contact support on support@bestbox.net');
        }
        else{
            $data = array('status' => 'Failure','message' => 'We can not find with that Email / User Id.');
        }

        return $data;
    }

    public function checkPassword(Request $request){

        $email = $request->email;
        $password = trim($request->password);
        $login_type = $request->login_type;
        if($login_type == "Customer"){
            $hash_password = User::select('password')->where(function ($query) use ($email) {
                    $query->where('user_id', '=', $email)
                          ->orWhere('email', '=', $email);
                })->where('user_role',4)->first();
        }else if($login_type == "Admin"){
            $hash_password = User::select('password')->where(['email' => $email,'admin_login' => 1])->first();
        }
        else{
            $hash_password = User::select('password')->where(['email' => $email])->whereIn('user_role',[2,3])->first();
        }
        //print_r($hash_password);exit();
        if($hash_password){
            if (Hash::check($password, $hash_password->password)) {
                    $data = array('status' => 'Success','message' => 'Valid Password');
            }else{
                $data = array('status' => 'Failure','message' => 'Invalid Password');
            }
        }else{
            $data = array('status' => 'Failure','message' => 'Invalid Username / Password');
        }

        return $data;
    }

    public function adminLoginForm(){

        return view ('auth.admin_login');
    }

    public function adminLogin(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if ($validator->fails()) {
            $errs = $validator->messages()->all();
            $str = '';
            foreach($errs as $arr){
                $str = $str.'<li>'.$arr.'</li>';
            }
            return Redirect::back()->withErrors(['<ul>'.$str.'</ul>', '<ul>'.$str.'</ul>']);
        }

        $email=$request['email'];
        $password=$request['password'];
        $userinfo=User::where('email',$email)->where('admin_login','=',1)->first();
        
        if($userinfo!==null){
            $checkRole = RolesPermissions::where('id',$userinfo->user_role)->select('status')->first();
            if($userinfo->email_verify == 0){
                Session::flash('message', 'Please verify your email before trying to log in, check your spam folder if you have not received the email yet');
                Session::flash('alert','Failure');
                return redirect('Admin');
            }
            else if($userinfo->email_verify == 1 && $userinfo->status == 0){
                Session::flash('message', 'Your account has been deactivated. Please contact support on support@bestbox.net');
                Session::flash('alert','Failure');
                return redirect('Admin');
            }
            else if($userinfo->user_role == 0){
                Session::flash('message', 'OOPs! Role is not assigned to your account. Please contact admin');
                Session::flash('alert','Failure');
                return redirect('Admin');
            }
            else if($checkRole->status == 0){
                Session::flash('message', 'Your account has been deactivated. Please contact support on support@bestbox.net');
                Session::flash('alert','Failure');
                return redirect('Admin');
            }
            else{
                
                $remember_me = $request->has('remember_me') ? true : false; 
                $credentials = $request->only('email', 'password');
                if (Auth::attempt($credentials) == "") {
                    // Authentication passed...
                    Session::flash('message', 'Invalid Password');
                    Session::flash('alert','Failure');
                    return redirect('Admin');
                }
                else{
                    $userData = ['rec_id' => $userinfo->rec_id,'user_id' => $userinfo->user_id, 'first_name' => $userinfo->first_name, 'last_name' => $userinfo->last_name, 'user_role' => $userinfo->user_role,'admin_login' => $userinfo->admin_login, 'mobile' => $userinfo->telephone, 'email'=>$userinfo->email,'registration_date'=>$userinfo->registration_date,'refferallink_text'=>$userinfo->refferallink_text];
                             \Session::put('userData', $userData);

                    if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
                                    $ipaddr = $_SERVER['HTTP_X_FORWARDED_FOR'];
                                } else {
                                    $ipaddr = $_SERVER['REMOTE_ADDR'];
                                }
                    $daraIns = ['user_id' => $userinfo->rec_id, 'username' => $userinfo->user_id, 'ip_address'=>$ipaddr,'browser_type'=>'','req_from'=>'Web','created_at'=>NOW()];
                    $value = registerModel::insert('visitor', $daraIns);
                    //return redirect('dashboard#googtrans('.$userinfo->language.')');
                    $this->loginNotification($userinfo->first_name, $userinfo->telephone, $userinfo->country_id, $userinfo->rec_id,$userinfo->device_id, $userinfo->mbl_platform,'Web',0,$ipaddr,$userinfo->user_role);

                    return redirect('dashboard');
                }
            }
        }else{
            Session::flash('message', 'Invalid Username');
            Session::flash('alert','Failure');
            return redirect('Admin');
        }

    }

}

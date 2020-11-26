<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DateTime;
use App\User;
use App\ResetPasswordHistory;
use Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Session;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function forgotPassword(Request $request) {
        $type = \Request::segment(2);
        if($type){
            $data['back'] = url('customerLogin');
        }else{
            $data['back'] = url('login');
        }
        return view ('auth.forgot-password')->with($data);
    }

    public function sendForgotPasswordEmail(Request $request) {
        //echo $request->email;exit;
        $email = $request->email;
        $userInfo = User::where('email',$email)->first();
        if($email == ''){
            Session::flash('message', 'Please enter Email Address');
            Session::flash('alert','Failure');
            return Redirect::back();
        }else{
            if($userInfo!==null){
                if ($userInfo->email_verify == 0) {
                    Session::flash('message', 'Please verify your email before trying to log in, check your spam folder if you have not received the email yet');
                    Session::flash('alert','Failure');
                    return Redirect::back();
                }
                else if($userInfo->status == 0){
                    Session::flash('message', 'Your account has been deactivated. Please contact support on support@bestbox.net');
                    Session::flash('alert','Failure');
                    return Redirect::back();
                }else{
                    $password = "password";
                    // $encrypted_string = openssl_encrypt($userInfo->rec_id, "AES-128-ECB", $password);
                    // $url = url('/') . '/reset-password/' . $encrypted_string;
                    $url = url('/') . '/reset-password/' . encrypt($userInfo->rec_id);
                    $data['user'] = array('name'=> ucwords($userInfo->first_name.' '.$userInfo->last_name), 'toemail'=> $email,'url' => $url);   
                    $emailid = array('toemail' => $email);
                    Mail::send(['html'=>'email_templates.forgot-password-email'], $data, function($message) use ($emailid) {
                        $message->to($emailid['toemail'], 'Forgot Password Email')->subject
                        ('Forgot Password Email');
                        $message->from('support@bestbox.net','BestBox');
                    });
                    ResetPasswordHistory::create([
                        'user_id' => $userInfo->rec_id,
                        'status' => 0,
                        'timestamp' => date('Y-m-d H:i:s'),
                        'req_from' => 'web'
                    ]);
                    Session::flash('message', 'Dear user we sent reset password link to your registered E-mail. Please verify');
                    Session::flash('alert','Success');
                    return Redirect::back();
                }
            }else{
                Session::flash('message', 'Invalid Email Address');
                Session::flash('alert','Failure');
                return Redirect::back();
            }
        }
    }

    public function resetPassword($encryptedString)
    {
        $data['encryptedString'] = $encryptedString;
        return view('auth.reset-password')->with($data);
    }

    public function resetNewPassword(Request $request)
    {
       $messages = [
                'password.regex' => 'Password should be minimum 8 characters with alphanumeric'
            ];
    	$validator = Validator::make($request->all(), [
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
            $encrypted_string = $request->encrypted_string;
			$new_password = $request->password;
			$confirm_password = $request->password_confirmation;
            $password = "password";
            
            $redirectUrl = 'reset-password/'.$encrypted_string;

            //$decrypted_string = openssl_decrypt($encrypted_string, "AES-128-ECB", $password);
            $decrypted_string = decrypt($encrypted_string);
            $userInfo = User::select('user_id','rec_id','user_role','email')->where("rec_id", "=", $decrypted_string)->first();
            
            if ($userInfo != null) {
                $userid = $userInfo->user_id;
                $qs = ResetPasswordHistory::where('user_id', $userid)->orderBy('rec_id', 'desc')->first();
                if($qs!=null) {
                    $expirelinkStatus = $qs->status;
                }else{
                    $expirelinkStatus = 0;
                }
			                    
                /*if (strlen($confirm_password) < 8) {
                    Session::flash('error', 'Password Length minimum 8 characters');
                    Session::flash('alert','Failure');
                    return redirect($redirectUrl);
				} else if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $confirm_password)) {
                    Session::flash('error', 'Password should include lowercase, uppercase, numbers and special characters(?!@)');
                    Session::flash('alert','Failure');
                    return redirect($redirectUrl);
				} else if ($confirm_password != $new_password) {
                    Session::flash('error', 'Confirm Password should be equal to New Password');
                    Session::flash('alert','Failure');
                    return redirect($redirectUrl);
                } else if ($new_password == $confirm_password) {*/

                if ($expirelinkStatus == 1) {
                    Session::flash('error', 'Reset Password Link Expired');
                    Session::flash('alert','Failure');
                    return redirect($redirectUrl);
                }else{
                    /*if($userInfo->user_role==4){*/
                        $encrypted_plain_pass=safe_encrypt($confirm_password,config('constants.encrypt_key')); 
                        $upddata=array(
                            "plain_password"=>$encrypted_plain_pass,
                            "password"=>\Hash::make($confirm_password)
                        );
                        User::where("email",$userInfo->email)->update($upddata);
                    /*}else{
                        $userInfo->password = \Hash::make($confirm_password);
                        $userInfo->save();
                    }*/
                    
                    // update ResetPasswordHistory table status column
                    if ($qs !== null) {
                        $qs->status = 1;
                        $qs->save();
                    }
                    Session::flash('message', 'Password has been updated successfully');
                    Session::flash('alert','Success');
                    Session::flash('role',$userInfo->user_role);
                    return redirect($redirectUrl);
                }
                /*} else {
                    Session::flash('error', 'Confirm Password do not match');
                    Session::flash('alert','Failure');
                    return redirect($redirectUrl);
                }*/
			}
	    }
    }
}

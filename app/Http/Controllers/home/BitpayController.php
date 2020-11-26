<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AppController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use DB;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use App\Subscribe_newsletter;
use App\Contact_users;
use Validator;
use Session;
use App\User;
use App\Packages;
use App\PaymentsHistory;
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
use App\Library\VodCommon;
use App\Http\Controllers\API\UserController;
use App\ApplicationsInfo;
use App\ApplicationSettings;
use App\UsersDevicesList;
use Memcached;
use App\Library\Memcache;
class BitpayController extends AppController
{
    public function __construct()
    {
      $this->mem=Memcache::memcached();
    }
    //get Installed Versions
	public function bitpay(Request $request)
	{
        $sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
        $data['userInfo'] = $userinfo;
        $url = url('/').'/public/test.json';
        $str = file_get_contents($url);
        $json = json_decode($str, true);
        echo $json['exchangeRates']['BUSD']['BTC'];exit;

        return view('customer/version2/bitpay')->with($data); 
    }

    //get Installed Versions
	public function bitpaySuccess(Request $request)
	{
        $sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
        $data['userInfo'] = $userinfo;
        
        $order_id = Session::get('order_id');
        Log::info('order id'.$order_id);
        
        $payment_info = PaymentsHistory::where(['order_id'=> $order_id])->first();
        if(!empty($payment_info)){
            $pack = Packages::where("id", $payment_info['package_id'])->first();

            if($payment_info['payment_reference'] != '') {
                $data['result'] = array(
                    'date' => date('Y-m-d H:i:s'),
                    'buyer_email' => '',
                    'package' => $pack['package_name'],
                    'duration' => $pack['duration'] .' month(s)',
                    'activation_period' => $pack['package_name'],
                    'payment_method' => 'BITPAY',
                    'payment_reference' => $payment_info['payment_reference'],
                    'merchant_id' => '',
                    'amount_in_usd' => $payment_info['amount_in_usd'],
                    'amount_in_crypto' => $payment_info['amount_in_crypto'],
                    'payment_mode' => strtoupper($payment_info['crypto']),
                    'status' => 1
                );
                
            }else{
                $data['result'] = array(
                    'date' => date('Y-m-d H:i:s'),
                    'buyer_email' => '',
                    'package' => $pack['package_name'],
                    'duration' => $pack['duration'] .' month(s)',
                    'activation_period' => $pack['package_name'],
                    'payment_method' => 'BITPAY',
                    'payment_reference' => $payment_info['payment_reference'],
                    'merchant_id' => '',
                    'amount_in_usd' => $payment_info['amount_in_usd'],
                    'amount_in_crypto' => $payment_info['amount_in_crypto'],
                    'payment_mode' => strtoupper($payment_info['crypto']),
                    'status' => 0
                );
            }
        }
        
        
        if($userinfo['user_role'] == 4){
            return view('customer/version2/payment_success')->with($data);
        }else{
            return view('payment_success')->with($data);
        }
    }
}
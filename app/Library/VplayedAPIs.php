<?php 
namespace App\library;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use DB;
use App\User;
class VplayedAPIs{
	
	public static function register($name,$email,$password){

        $post_url = "https://vplayed-bestbox-uat.contus.us/api/v2/auth/register";
        $data = array("email"=>$email,"name" => $name,"password"=>$password,"acesstype"=>'web',"login_type"=>'normal');
        
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $post_url);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl_handle, CURLOPT_POST, true);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array(                                                                  
                    'accept: application/json',
                    "User-Agent: example:mozilla")
                    );                                                          
        $buffer = curl_exec($curl_handle);
        if($buffer === false)
        {
            return 'Curl error: ' . curl_error($curl_handle);
        }
        curl_close($curl_handle);
        
        return $buffer; 
    }
}
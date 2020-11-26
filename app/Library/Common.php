<?php
namespace App\library;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use DB;
use App\FcmpushNotifications;
use App\Ios_badge_count;
use App\User_requested_movies;
use App\User;
use App\ApplicationsInfo;
use App\UsersDevicesList;
class Common{

	public static function dateToUTCForAPI($date){

		$utctime =date('Y-m-d H:i:s',strtotime($date));
        $temp=explode(" ",$utctime);
        $today = $temp[0];
        $ttime=$temp[1];
        $new_time = $today."T".$ttime;
        return $new_time;
    }

	public static function sendFCMWithdrawnCrypto($logged_user_info,$withdraw_amt,$wallet_name,$app_name)
	{

		$icon = "success.png";
		$clienticon = "transactions-active.png";
		if(!empty($logged_user_info['telephone'])){
			$mobileno = $logged_user_info['telephone'];
		}else{
			$mobileno = "";
		}
		$rec_id = $logged_user_info['rec_id'];
		$new_time = self::dateToUTCForAPI(date("Y-m-d H:i:s"));

		$message = 'Your withdrawal request of <b>'.number_format($withdraw_amt,2).' USD </b> has been successful to your '.$wallet_name.' wallet and it is in-process.';

		$htmlMessage = 'Your withdrawal request of <b>'.number_format($withdraw_amt,2).' USD </b> has been successful to your '.$wallet_name.' Wallet and it is in-process.';

		$htmlMessageIOS = 'Your withdrawal request of '.number_format($withdraw_amt,2).' USD  has been successful to your '.$wallet_name.' Wallet and it is in-process.';

		if(!empty($app_name)){
			$info = ApplicationsInfo::where('application_id','=',$app_name)->first();
			if(!empty($info)){
				$client_id = $info->application_id;
				$ClientCode = $info->application_name;
			}else{
				$client_id = 1234;
				$ClientCode = "BESTBOX";
			}
		}


		$arr = array("Client_id" => $client_id,"ClientCode" => $ClientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Transactions',"MobileNo" =>$mobileno,"user_id"=>$rec_id,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);


		$json_data["transactions"] = json_encode($arr);



		if(!empty($logged_user_info['device_id'])){

			$deviceIds = UsersDevicesList::where('user_id','=',$logged_user_info['rec_id'])->get();

			if(@count($deviceIds) > 0){
				foreach ($deviceIds as $val) {
					$application_name = $val->application_name;
					$device_id = array($val->device_id);
					$device_id1 = $val->device_id;
					$device_type = $val->device_type;
					if(!empty($device_type)){
						if($device_type == "android"){
							$res = self::sendFCMAndroid($device_id,$json_data,$mobileno, 'Request_Withdrawn_Crypto_Amt',$application_name);
						}else{
							$res = self::sendFCMIOS($device_id1,$json_data,$mobileno, 'Request_Withdrawn_Crypto_Amt',$htmlMessageIOS,$application_name,$logged_user_info['rec_id']);
						}
					}else{
						Log::info("device type is empty");
					}

				}
			}else{
				Log::info("sendFCMWithdrawnCrypto API UsersDevicesList table not saved user_id= ".$logged_user_info['rec_id']);
			}

		}

	}


	public static function adminApprovedCryptoFCM($user_info,$withdraw_amt,$wallet_name,$crypto_amt)
	{

		$icon = "success.png";
		$clienticon = "transactions-active.png";
		if(!empty($user_info['telephone'])){
			$mobileno = $user_info['telephone'];
		}else{
		$mobileno = "";
		}
		$rec_id = $user_info['rec_id'];
		$new_time = self::dateToUTCForAPI(date("Y-m-d H:i:s"));

		$crypto_info = $crypto_amt.' '.$wallet_name;

		$message = 'Your withdrawal request of <b>'.number_format($withdraw_amt,2).' USD </b> has been Approved and '.$crypto_info.'  credited to your wallet ';

		$htmlMessage = 'Your withdrawal request of <b>'.number_format($withdraw_amt,2).' USD </b> has been Approved and '.$crypto_info.'  credited to your wallet ';

		$htmlMessageIOS = 'Your withdrawal request of '.number_format($withdraw_amt,2).' USD has been Approved and '.$crypto_info.'  credited to your wallet ';


		$arr = array("ClientCode" => "BESTBOX","Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Transactions',"MobileNo" =>$mobileno,"user_id"=>$rec_id,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);


		$json_data["transactions"] = json_encode($arr);



		if(!empty($user_info['device_id'])){

			$deviceIds = UsersDevicesList::where('user_id','=',$user_info['rec_id'])->get();

			if(@count($deviceIds) > 0){
				foreach ($deviceIds as $val) {
					$application_name = $val->application_name;
					$device_id = array($val->device_id);
					$device_id1 = $val->device_id;
					$device_type = $val->device_type;
					if(!empty($device_type)){
						if($device_type == "android"){
							$res = self::sendFCMAndroid($device_id,$json_data,$mobileno, 'Approved_Withdrawn_Crypto_Amt',$application_name);
						}else{
							$res = self::sendFCMIOS($device_id1,$json_data,$mobileno, 'Approved_Withdrawn_Crypto_Amt',$htmlMessageIOS,$application_name,$user_info['rec_id']);
						}
					}else{
						Log::info("device type is empty");
					}

				}
			}else{
				Log::info("adminApprovedCryptoFCM API UsersDevicesList table not saved user_id= ".$logged_user_info['rec_id']);
			}

		}

	}


	public static function senderWithdrawalFCM($logged_user_info="",$withdraw_amt=0,$action="",$receiver_det="",$app_name)
	{

		$icon = "success.png";
		$clienticon = "transactions-active.png";
		$new_time = self::dateToUTCForAPI(date("Y-m-d H:i:s"));

		if($action =="sender")
		{
			//echo "sender "; echo $logged_user_info['first_name']." ".$logged_user_info['last_name'];exit;
			$message =  'You have transferred <b>'.number_format($withdraw_amt,2) . ' USD </b> to <b>'.$receiver_det->first_name." ".$receiver_det->last_name.'</b>';

			$htmlMessage = 'You have transferred <b>'.number_format($withdraw_amt,2) . ' USD </b> to <b>'.$receiver_det->first_name." ".$receiver_det->last_name.'</b>';

			$htmlMessageIOS = 'You have transferred '.number_format($withdraw_amt,2) . ' USD to '.$receiver_det->first_name." ".$receiver_det->last_name;

			if(!empty($logged_user_info['telephone'])){
				$mobileno = $logged_user_info['telephone'];
			}else{
				$mobileno = "";
			}

			$rec_id = $logged_user_info['rec_id'];
			if(!empty($app_name)){
				$info = ApplicationsInfo::where('application_id','=',$app_name)->first();
				if(!empty($info)){
					$client_id = $info->application_id;
					$ClientCode = $info->application_name;
				}else{
					$client_id = 1234;
					$ClientCode = "BESTBOX";
				}
			}
			$arr = array("Client_id" => $client_id,"ClientCode" => $ClientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Transactions',"MobileNo" =>$mobileno,"user_id"=>$rec_id,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);

			$json_data["transactions"] = json_encode($arr);



			if(!empty($logged_user_info['device_id'])){

				$deviceIds = UsersDevicesList::where('user_id','=',$logged_user_info['rec_id'])->get();

				if(@count($deviceIds) > 0){
					foreach ($deviceIds as $val) {
						$application_name = $val->application_name;
						$device_id = array($val->device_id);
						$device_id1 = $val->device_id;
						$device_type = $val->device_type;
						if(!empty($device_type)){
							if($device_type == "android"){
								$res = self::sendFCMAndroid($device_id,$json_data,$mobileno, 'Transfered_Wallet_To_Wallet',$application_name);
							}else{
								$res = Common::sendFCMIOS($device_id1,$json_data,$mobileno,'Transfered_Wallet_To_Wallet',$htmlMessageIOS,$application_name,$logged_user_info['rec_id']);
							}
						}else{
							Log::info("device type is empty");
						}

					}
				}else{
					Log::info("senderWithdrawalFCM API UsersDevicesList table not saved user_id= ".$logged_user_info['rec_id']);
				}

			}


		}else{
			//echo "sender "; echo $logged_user_info['first_name']." ".$logged_user_info['last_name'];
			//echo "<br/>";
			//echo "receiver "; echo $receiver_det['first_name']." ".$receiver_det['last_name'];
			//exit;
			$message = 'You have received <b>'.number_format($withdraw_amt,2) . ' USD </b> from <b>'.$logged_user_info['first_name']." ".$logged_user_info['last_name'].' </b>';

			$htmlMessage = 'You have received <b>'.number_format($withdraw_amt,2) . ' USD </b> from <b>'.$logged_user_info['first_name']." ".$logged_user_info['last_name'].'</b>';

			$htmlMessageIOS = 'You have received '.number_format($withdraw_amt,2) . ' USD from '.$logged_user_info['first_name']." ".$logged_user_info['last_name'];

			if(!empty($receiver_det->telephone)){
				$mobileno = $receiver_det->telephone;
			}else{
				$mobileno = "";
			}

			$rec_id = $receiver_det->rec_id;


			if(!empty($app_name)){
				$info = ApplicationsInfo::where('application_id','=',$app_name)->first();
				if(!empty($info)){
					$client_id = $info->application_id;
					$ClientCode = $info->application_name;
				}else{
					$client_id = 1234;
					$ClientCode = "BESTBOX";
				}
			}

			$arr = array("Client_id" => $client_id,"ClientCode" => $ClientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Transactions',"MobileNo" =>$mobileno,"user_id"=>$rec_id,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);

			$json_data["transactions"] = json_encode($arr);



			if(!empty($receiver_det->device_id)){

				$getAppNames = UsersDevicesList::where('user_id','=',$receiver_det->rec_id)->get();

				if(@count($getAppNames) > 0){
					foreach ($getAppNames as $res) {
						$user_id = $res->user_id;
						$application_name = $res->application_name;
						$device_id = array($res->device_id);
						$device_id1 = $res->device_id;
						$device_type = $res->device_type;
						if(!empty($device_type)){
							if($device_type == "android"){
								$res = Common::sendFCMAndroid($device_id,$json_data,$mobileno,'Transfered_Wallet_To_Wallet',$application_name);
							}else{
								$res = self::sendFCMIOS($device_id1,$json_data,$mobileno, 'Transfered_Wallet_To_Wallet',$htmlMessageIOS,$application_name,$user_id);
							}
						}else{
							Log::info("device type is empty");
						}
					}
				}else{
					Log::info("UsersDevicesList table not saved user_id=".$receiver_det->rec_id);
				}

			}

		}


	}


	// Package Purchased FCM
	public static function packagePurchasedFCM($logged_user_info,$package_name="",$package_amt="",$transaction_id="",$action="",$app_name)
	{

		$icon = "success.png";
		$clienticon = "transactions-active.png";
		$new_time = self::dateToUTCForAPI(date("Y-m-d H:i:s"));

		if($action =="sender"){
			//echo "sender "; echo $logged_user_info['first_name']." ".$logged_user_info['last_name'];exit;
			$message =  'You have successfully transfer <b>Payment Package '.$package_name.' </b> amount <b>'.number_format($package_amt,2) . ' USD.</b> The Payment ID is '.$transaction_id;

			$htmlMessage = 'You have successfully transfer <b>Payment Package '.$package_name.' </b> amount <b>'.number_format($package_amt,2) . ' USD.</b> The Payment ID is '.$transaction_id;

			$htmlMessageIOS = 'You have successfully transfer Payment Package '.$package_name.'  amount '.number_format($package_amt,2) . ' USD. The Payment ID is '.$transaction_id;

			if(!empty($logged_user_info['telephone'])){
				$mobileno = $logged_user_info['telephone'];
			}else{
				$mobileno = "";
			}
			$rec_id = $logged_user_info['rec_id'];
			if(!empty($app_name)){
				$info = ApplicationsInfo::where('application_id','=',$app_name)->first();
				if(!empty($info)){
					$client_id = $info->application_id;
					$ClientCode = $info->application_name;
				}else{
					$client_id = 1234;
					$ClientCode = "BESTBOX";
				}
			}

			$arr = array("Client_id" => $client_id,"ClientCode" => $ClientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Transactions',"user_id"=>$rec_id,"MobileNo" =>$mobileno,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);

			$json_data["transactions"] = json_encode($arr);



			if(!empty($logged_user_info['device_id'])){

				$deviceIds = UsersDevicesList::where('user_id','=',$logged_user_info['rec_id'])->get();

				if(@count($deviceIds) > 0){
					foreach ($deviceIds as $val) {
						$user_id = $val->user_id;
						$application_name = $val->application_name;
						$device_id = array($val->device_id);
						$device_id1 = $val->device_id;
					    $device_type = $val->device_type;
						if(!empty($device_type)){
							if($device_type == "android"){
								$res = self::sendFCMAndroid($device_id,$json_data,$mobileno, 'Package_Purchase',$application_name);
							}else{
								$res = self::sendFCMIOS($device_id1,$json_data,$mobileno, 'Package_Purchase',$htmlMessageIOS,$application_name,$user_id);
							}
						}else{
							Log::info("device type is empty");
						}

					}
				}else{
					Log::info("device id is empty");
				}

			}


		}


	}

	// Package Purchased FCM Receiver
	public static function packagePurchasedFCMToReceiver($logged_user_info,$package_name="",$package_amt="",$transaction_id="",$action="",$receiver_det="",$app_name)
	{

		$icon = "success.png";
		$clienticon = "transactions-active.png";
		$new_time = self::dateToUTCForAPI(date("Y-m-d H:i:s"));

		if($action =="receiver"){
			$message = 'You have successfully received from <b>Pay For My Friend '.$package_name.' </b> amount <b>'.number_format($package_amt,2) . ' USD.</b> The Payment ID is '.$transaction_id;

			$htmlMessage = 'You have successfully received from <b>Pay For My Friend '.$package_name.' </b> amount <b>'.number_format($package_amt,2) . ' USD.</b> The Payment ID is '.$transaction_id;

			$htmlMessageIOS = 'You have successfully received from Pay For My Friend '.$package_name.' amount '.number_format($package_amt,2) . ' USD. The Payment ID is '.$transaction_id;

			if(!empty($receiver_det->telephone)){
				$mobileno = $receiver_det->telephone;
			}else{
				$mobileno = "";
			}
			$rec_id = $receiver_det->rec_id;
			if(!empty($app_name)){
				$info = ApplicationsInfo::where('application_id','=',$app_name)->first();
				if(!empty($info)){
					$client_id = $info->application_id;
					$ClientCode = $info->application_name;
				}else{
					$client_id = 1234;
					$ClientCode = "BESTBOX";
				}
			}
			$arr = array("Client_id" => $client_id,"ClientCode" => $ClientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Transactions',"user_id"=>$rec_id,"MobileNo" =>$mobileno,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);

			$json_data["transactions"] = json_encode($arr);



			if(!empty($receiver_det->device_id )){

				$deviceIds = UsersDevicesList::where('user_id','=',$receiver_det->rec_id)->get();

				if(@count($deviceIds) > 0){
					foreach ($deviceIds as $val) {
						$user_id = $val->user_id;
						$application_name = $val->application_name;
						$device_id = array($val->device_id);
						$device_id1 = $val->device_id;
						$device_type = $val->device_type;
						if(!empty($device_type)){
							if($device_type == "android"){
								$res = self::sendFCMAndroid($device_id,$json_data,$mobileno, 'Pay_For_My_Friend',$application_name);
							}else{
								$res = self::sendFCMIOS($device_id1,$json_data,$mobileno, 'Pay_For_My_Friend',$htmlMessageIOS,$application_name,$user_id);
							}
						}else{
							Log::info("device type is empty");
						}

					}
				}else{
					Log::info("device type is empty");
				}

			}

		}


	}

	// Package Renewal
	public static function packageRenewalFCM($logged_user_info,$package_name="",$package_amt="",$transaction_id="",$action="",$receiver_det="",$app_name)
	{

		$icon = "success.png";
		$clienticon = "transactions-active.png";
		$new_time = self::dateToUTCForAPI(date("Y-m-d H:i:s"));

		if($action =="receiver"){
			$message = 'You have successfully renewal <b> '.$package_name.' </b> amount <b>'.number_format($package_amt,2) . ' USD.</b> The Payment ID is '.$transaction_id;

			$htmlMessage = 'You have successfully renewal <b> '.$package_name.' </b> amount <b>'.number_format($package_amt,2) . ' USD.</b> The Payment ID is '.$transaction_id;

			$htmlMessageIOS = 'You have successfully renewal  '.$package_name.'  amount '.number_format($package_amt,2) . ' USD. The Payment ID is '.$transaction_id;

			if(!empty($receiver_det->telephone)){
				$mobileno = $receiver_det->telephone;
			}else{
				$mobileno = "";
			}
			$rec_id = $receiver_det->rec_id;

			if(!empty($app_name)){
				$info = ApplicationsInfo::where('application_id','=',$app_name)->first();
				if(!empty($info)){
					$client_id = $info->application_id;
					$ClientCode = $info->application_name;
				}else{
					$client_id = 1234;
					$ClientCode = "BESTBOX";
				}
			}

			$arr = array("Client_id" => $client_id,"ClientCode" => $ClientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Transactions',"user_id"=>$rec_id,"MobileNo" =>$mobileno,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);

					$json_data["transactions"] = json_encode($arr);



			if(!empty($receiver_det->device_id)){

				$deviceIds = UsersDevicesList::where('user_id','=',$receiver_det->rec_id)->get();

				if(@count($deviceIds) > 0){
					foreach ($deviceIds as $val) {
						$user_id = $val->user_id;
						$application_name = $val->application_name;
						$device_id = array($val->device_id);
						$device_id1 = $val->device_id;
						$device_type = $val->device_type;
						if(!empty($device_type)){
							if($device_type == "android"){
								$res = self::sendFCMAndroid($device_id,$json_data,$mobileno, 'Package_Renewal',$application_name);
							}else{
								$res = self::sendFCMIOS($device_id1,$json_data,$mobileno, 'Package_Renewal',$htmlMessageIOS,$application_name,$user_id);
							}
						}else{
							Log::info("device type is empty");
						}

					}
				}else{
					Log::info("device type is empty");
				}


			}

		}


	}

	// pay for my friend FCM
	public static function payForMyFriendFCM($logged_user_info="",$package_name="",$package_amt=0,$transaction_id=0,$action="",$receiver_det="",$app_name)
	{

		$icon = "success.png";
		$clienticon = "transactions-active.png";
		$new_time = self::dateToUTCForAPI(date("Y-m-d H:i:s"));

		if($action =="sender"){
			//echo "sender "; echo $logged_user_info['first_name']." ".$logged_user_info['last_name'];exit;
			$message =  'You have successfully transfer <b>Pay For My Friend '.$package_name.' </b> amount <b>'.number_format($package_amt,2) . ' USD.</b> The Payment ID is '.$transaction_id;

			$htmlMessage = 'You have successfully transfer <b>Pay For My Friend '.$package_name.' </b> amount <b>'.number_format($package_amt,2) . ' USD.</b> The Payment ID is '.$transaction_id;

			$htmlMessageIOS = 'You have successfully transfer Pay For My Friend '.$package_name.' amount '.number_format($package_amt,2) . ' USD. The Payment ID is '.$transaction_id;

			if(!empty($logged_user_info['telephone'])){
				$mobileno = $logged_user_info['telephone'];
			}else{
				$mobileno = "";
			}

			$rec_id = $logged_user_info['rec_id'];
			if(!empty($app_name)){
				$info = ApplicationsInfo::where('application_id','=',$app_name)->first();
				if(!empty($info)){
					$client_id = $info->application_id;
					$ClientCode = $info->application_name;
				}else{
					$client_id = 1234;
					$ClientCode = "BESTBOX";
				}
			}
			$arr = array("Client_id" => $client_id,"ClientCode" => $ClientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Transactions',"user_id"=>$rec_id,"MobileNo" =>$mobileno,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);

			$json_data["transactions"] = json_encode($arr);

			if(!empty($logged_user_info['device_id'])){

				$deviceIds = UsersDevicesList::where('user_id','=',$logged_user_info['rec_id'])->get();

				if(@count($deviceIds) > 0){
					foreach ($deviceIds as $val) {
						$user_id = $val->user_id;
						$application_name = $val->application_name;
						$device_id = array($val->device_id);
						$device_id1 = $val->device_id;
						$device_type = $val->device_type;
						if(!empty($device_type)){
							if($device_type == "android"){
								$res = self::sendFCMAndroid($device_id,$json_data,$mobileno, 'Pay_For_My_Friend',$application_name);
							}else{
								$res = self::sendFCMIOS($device_id1,$json_data,$mobileno, 'Pay_For_My_Friend',$htmlMessageIOS,$application_name,$user_id);
							}
						}else{
							Log::info("device type is empty");
						}
					}
				}else{
					Log::info("device type is empty");
				}

			}


		}else{
			//echo "sender "; echo $logged_user_info['first_name']." ".$logged_user_info['last_name'];
			//echo "<br/>";
			//echo "receiver "; echo $receiver_det['first_name']." ".$receiver_det['last_name'];
			//exit;
			$message = 'You have successfully received from <b>Pay For My Friend '.$package_name.' </b> amount <b>'.number_format($package_amt,2) . ' USD.</b> The Payment ID is '.$transaction_id;

			$htmlMessage = 'You have successfully received from <b>Pay For My Friend '.$package_name.' </b> amount <b>'.number_format($package_amt,2) . ' USD.</b> The Payment ID is '.$transaction_id;

			$htmlMessageIOS = 'You have successfully received from Pay For My Friend '.$package_name.' amount '.number_format($package_amt,2) . ' USD. The Payment ID is '.$transaction_id;

			if(!empty($receiver_det['telephone'])){
				$mobileno = $receiver_det['telephone'];
			}else{
				$mobileno = "";
			}
			$rec_id = $receiver_det['rec_id'];

			if(!empty($app_name)){
				$info = ApplicationsInfo::where('application_id','=',$app_name)->first();
				if(!empty($info)){
					$client_id = $info->application_id;
					$ClientCode = $info->application_name;
				}else{
					$client_id = 1234;
					$ClientCode = "BESTBOX";
				}
			}

			$arr = array("Client_id" => $client_id,"ClientCode" => $ClientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Transactions',"user_id"=>$rec_id,"MobileNo" =>$mobileno,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);

			$json_data["transactions"] = json_encode($arr);



			if(!empty($receiver_det['device_id'])){


				$deviceIds = UsersDevicesList::where('user_id','=',$receiver_det['rec_id'])->get();

				if(@count($deviceIds) > 0){
					foreach ($deviceIds as $val) {
						$user_id = $val->user_id;
						$application_name = $val->application_name;
						$device_id = array($val->device_id);
						$device_id1 = $val->device_id;
						$device_type = $val->device_type;
						if(!empty($device_type)){
							if($device_type == "android"){
								$res = self::sendFCMAndroid($device_id,$json_data,$mobileno, 'Pay_For_My_Friend',$application_name);
							}else{
								$res = self::sendFCMIOS($device_id1,$json_data,$mobileno, 'Pay_For_My_Friend',$htmlMessageIOS,$application_name,$user_id);
							}
						}else{
							Log::info("device type is empty");
						}

					}
				}else{
					Log::info("device type is empty");
				}


			}

		}


	}

	// Direct sales FCM
	public static function directSaleFCM($user_id,$amt=0,$app_name)
	{

		$icon = "success.png";
		$clienticon = "transactions-active.png";
		$user_info = User::select('*')->where('rec_id','=',$user_id)->first();

		if(!empty($user_info['telephone'])){
			$mobileno = $user_info['telephone'];
		}else{
			$mobileno = "";
		}
		$rec_id = $user_info['rec_id'];
		$new_time = self::dateToUTCForAPI(date("Y-m-d H:i:s"));

		$message = 'You received <b>Direct Sale</b> amount <b> '.number_format($amt,2).' USD.</b>';

		$htmlMessage = 'You received <b>Direct Sale</b> amount <b> '.number_format($amt,2).' USD.</b>';

		$htmlMessageIOS = 'You received Direct Sale amount  '.number_format($amt,2).' USD.';

		if(!empty($app_name)){
			$info = ApplicationsInfo::where('application_id','=',$app_name)->first();
			if(!empty($info)){
				$client_id = $info->application_id;
				$ClientCode = $info->application_name;
			}else{
				$client_id = 1234;
				$ClientCode = "BESTBOX";
			}
		}

		$arr = array("Client_id" => $client_id,"ClientCode" => $ClientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Transactions',"MobileNo" =>$mobileno,"user_id"=>$rec_id,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);


		$json_data["transactions"] = json_encode($arr);



		if(!empty($user_info['device_id'])){

			$deviceIds = UsersDevicesList::where('user_id','=',$user_info['rec_id'])->get();

			if(@count($deviceIds) > 0){
				foreach ($deviceIds as $val) {
					$user_id = $val->user_id;
					$application_name = $val->application_name;
					$device_id = array($val->device_id);
					$device_id1 = $val->device_id;
					$device_type = $val->device_type;
					if(!empty($device_type)){
						if($device_type == "android"){
							$res = self::sendFCMAndroid($device_id,$json_data,$mobileno, 'Direct_Sales_FCM',$application_name);
						}else{
							$res = self::sendFCMIOS($device_id1,$json_data,$mobileno, 'Direct_Sales_FCM',$htmlMessageIOS,$application_name,$user_id);
						}
					}else{
						Log::info("device type is empty");
					}

				}
			}else{
				Log::info("device type is empty");
			}


		}

	}

	// Commission sales FCM
	public static function commissionSalesFCM($user_id,$amt=0,$app_name)
	{

		$icon = "success.png";
		$clienticon = "transactions-active.png";
		$user_info = User::select('*')->where('rec_id','=',$user_id)->first();
		if(!empty($user_info['telephone'])){
			$mobileno = $user_info['telephone'];
		}else{
			$mobileno = "";
		}
		$rec_id = $user_info['rec_id'];
		$new_time = self::dateToUTCForAPI(date("Y-m-d H:i:s"));

		$message = 'You received <b>Commission</b> amount <b> '.number_format($amt,2).' USD.</b>';

		$htmlMessage = 'You received <b>Commission</b> amount <b> '.number_format($amt,2).' USD.</b>';

		$htmlMessageIOS = 'You received Commission amount  '.number_format($amt,2).' USD.';

		if(!empty($app_name)){
			$info = ApplicationsInfo::where('application_id','=',$app_name)->first();
			if(!empty($info)){
				$client_id = $info->application_id;
				$ClientCode = $info->application_name;
			}else{
				$client_id = 1234;
				$ClientCode = "BESTBOX";
			}
		}
		$arr = array("Client_id" => $client_id,"ClientCode" => $ClientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Transactions',"MobileNo" =>$mobileno,"user_id"=>$rec_id,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);


		$json_data["transactions"] = json_encode($arr);

		if(!empty($user_info['device_id'])){

			$deviceIds = UsersDevicesList::where('user_id','=',$user_info['rec_id'])->get();

			if(@count($deviceIds) > 0){
				foreach ($deviceIds as $val) {
					$user_id = $val->user_id;
					$application_name = $val->application_name;
					$device_id = array($val->device_id);
					$device_id1 = $val->device_id;
					$device_type = $val->device_type;
					if(!empty($device_type)){
						if($device_type == "android"){
							$res = self::sendFCMAndroid($device_id,$json_data,$mobileno, 'Commission_Sales_FCM',$application_name);
						}else{
							$res = self::sendFCMIOS($device_id1,$json_data,$mobileno, 'Commission_Sales_FCM',$htmlMessageIOS,$application_name,$user_id);
						}
					}else{
						Log::info("device type is empty");
					}

				}
			}else{
				Log::info("device type is empty");
			}

		}

	}

	// referral Bonus FCM
	public static function referralBonusFCM($user_id,$amt=0,$customer_name="",$app_name)
	{

		$icon = "success.png";
		$clienticon = "transactions-active.png";
		$user_info = User::select('*')->where('rec_id','=',$user_id)->first();
		if(!empty($user_info['telephone'])){
			$mobileno = $user_info['telephone'];
		}else{
			$mobileno = "";
		}
		$rec_id = $user_info['rec_id'];
		$new_time = self::dateToUTCForAPI(date("Y-m-d H:i:s"));

		$message = 'You have received <b> '.number_format($amt,2).' USD.</b> as referral bonus for <b> '.$customer_name.'</b>';

		$htmlMessage = 'You have received <b> '.number_format($amt,2).' USD.</b> as referral bonus for <b> '.$customer_name.'</b>';

		$htmlMessageIOS = 'You have received '.number_format($amt,2).' USD. as referral bonus for  '.$customer_name;
		if(!empty($app_name)){
			$info = ApplicationsInfo::where('application_id','=',$app_name)->first();
			if(!empty($info)){
				$client_id = $info->application_id;
				$ClientCode = $info->application_name;
			}else{
				$client_id = 1234;
				$ClientCode = "BESTBOX";
			}
		}

		$arr = array("Client_id" => $client_id,"ClientCode" => $ClientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Transactions',"MobileNo" =>$mobileno,"user_id"=>$rec_id,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);


		$json_data["transactions"] = json_encode($arr);


		if(!empty($user_info['device_id'])){


			$deviceIds = UsersDevicesList::where('user_id','=',$user_info['rec_id'])->get();

			if(@count($deviceIds) > 0){
				foreach ($deviceIds as $val) {
					$user_id = $val->user_id;
					$application_name = $val->application_name;
					$device_id = array($val->device_id);
					$device_id1 = $val->device_id;
					$device_type = $val->device_type;
					if(!empty($device_type)){
						if($device_type == "android"){
							$res = self::sendFCMAndroid($device_id,$json_data,$mobileno, 'Referral_Bonus_FCM',$application_name);
						}else{
							$res = self::sendFCMIOS($device_id1,$json_data,$mobileno, 'Referral_Bonus_FCM',$htmlMessageIOS,$application_name,$user_id);
						}
					}else{
						Log::info("device type is empty");
					}

				}
			}else{
				Log::info("device type is empty");
			}



		}

	}

	// send fcm uploaded movie info

	public static function sendFCMUploadedMovie($rec_id)
	{

		$icon = "success.png";
		$clienticon = "transactions-active.png";

		$res = User_requested_movies::where('rec_id','=',$rec_id)->first();
		if(!empty($res)){
			$id = $res->rec_id;
			$user_id = 	$res->user_id;
			$movie_name = $res->requested_movies;
			$user_info = User::select('*')->where('rec_id','=',$user_id)->first();
			if(!empty($user_info)){

				$userName = $user_info->first_name." ".$user_info->last_name;
				if(!empty($user_info['telephone'])){
					$mobileno = $user_info['telephone'];
					$application_id = $user_info['application_id'];
				}else{
					$mobileno = "";
				}


				if(!empty($application_id)){
					$info = ApplicationsInfo::where('application_id','=',$application_id)->first();
					if(!empty($info)){
						$client_id = $info->application_id;
						$ClientCode = $info->application_name;
					}else{
						$client_id = 1234;
						$ClientCode = "BESTBOX";
					}
				}else{
						$client_id = 1234;
						$ClientCode = "BESTBOX";
					}

				$new_time = self::dateToUTCForAPI(date("Y-m-d H:i:s"));

				$message = 'Dear <b>'.ucwords($userName).',</b> we uploaded your requested movie <b>'.$movie_name.'</b>. Visit VOD now watch and enjoy.';

				$htmlMessage = 'Dear <b>'.ucwords($userName).',</b> we uploaded your requested movie <b>'.$movie_name.'</b>. Visit VOD now watch and enjoy.';

				$htmlMessageIOS = 'Dear '.ucwords($userName).', we uploaded your requested movie '.$movie_name.'. Visit VOD now watch and enjoy.';


				$arr = array("Client_id" => $client_id,"ClientCode" => $ClientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"PaymentType"=>'Announcement',"MobileNo" =>$mobileno,"user_id"=>$user_id,"rec_id"=>$id,"movie_name"=>$movie_name,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);


				$json_data["announcement"] = json_encode($arr);



				if(!empty($user_info['device_id'])){

					$deviceIds = UsersDevicesList::where('user_id','=',$user_info['rec_id'])->get();

					if(@count($deviceIds) > 0){
						foreach ($deviceIds as $val) {
							$user_id = $val->user_id;
							$application_name = $val->application_name;
							$device_id = array($val->device_id);
							$device_id1 = $val->device_id;
							$device_type = $val->device_type;
							if(!empty($device_type)){
								if($device_type == "android"){
									$res = self::sendFCMAndroid($device_id,$json_data,$mobileno, 'Requested_Movie_Announcement',$application_name);
								}else{
									$res = self::sendFCMIOS($device_id1,$json_data,$mobileno, 'Requested_Movie_Announcement',$htmlMessageIOS,$application_name,$user_id);
								}
							}else{
								Log::info("device type is empty");
							}

						}
					}else{
						Log::info("device type is empty");
					}

				}

			}

		}

	}


	// send fcm force Logout

	public static function sendFCMForceLogout($user_id)
	{

		$icon = "success.png";
		$clienticon = "transactions-active.png";



			$user_info = User::select('*')->where('rec_id','=',$user_id)->first();
			if(!empty($user_info)){

				$userName = $user_info->first_name." ".$user_info->last_name;
				if(!empty($user_info['telephone'])){
					$mobileno = $user_info['telephone'];
					$application_id = $user_info['application_id'];
				}else{
					$mobileno = "";
				}


				if(!empty($application_id)){
					$info = ApplicationsInfo::where('application_id','=',$application_id)->first();
					if(!empty($info)){
						$client_id = $info->application_id;
						$ClientCode = $info->application_name;
					}else{
						$client_id = 1234;
						$ClientCode = "BESTBOX";
					}
				}else{
						$client_id = 1234;
						$ClientCode = "BESTBOX";
					}

				$new_time = self::dateToUTCForAPI(date("Y-m-d H:i:s"));

				$message = $ClientCode.'Force Logout';

				$htmlMessage = $ClientCode.'Force Logout';

				$htmlMessageIOS = $ClientCode.'Force Logout';


				$arr = array("Client_id" => $client_id,"ClientCode" => $ClientCode,"Message" =>$message,"HtmlMessage"=>$htmlMessage,"MobileNo" =>$mobileno,"user_id"=>$user_id,"is_force_logout"=>1,'DateTime'=>$new_time,'icon'=>$icon,'clienticon'=>$clienticon);


				$json_data["isForceLogout"] = json_encode($arr);



				if(!empty($user_info['device_id'])){

					$deviceIds = UsersDevicesList::where('user_id','=',$user_info['rec_id'])->get();

					if(@count($deviceIds) > 0){
						foreach ($deviceIds as $val) {
							$user_id = $val->user_id;
							$application_name = $val->application_name;
							$device_id = array($val->device_id);
							$device_id1 = $val->device_id;
							$device_type = $val->device_type;
							if(!empty($device_type)){
								if($device_type == "android"){
									$res = self::sendFCMAndroid($device_id,$json_data,$mobileno, 'Force_Logout',$application_name);
								}else{
									$res = self::sendFCMIOS($device_id1,$json_data,$mobileno, 'Force_Logout',$htmlMessageIOS,$application_name,$user_id);
								}
							}else{
								Log::info("device type is empty");
							}

						}
					}else{
						Log::info("device type is empty");
					}


				}

			}

	}




	public static function sendFCMAndroid($device_id,$json_data,$mobile_no,$messageType,$app_name="")
	{
		//Log::info("fcm data ".$device_id[0]." ".json_encode($json_data)." ".$mobile_no." ".$messageType);

		//$url = 'https://android.googleapis.com/gcm/send';
		$url = 'https://fcm.googleapis.com/fcm/send';
		 // Android
        $fields = array(
            'registration_ids' => $device_id,
            'data' => $json_data,
            'priority'=>'high'
        );

        // Update your Google Cloud Messaging API Key

		if($app_name == "BESTBOX"){
			//bestbox FCM Key

			$apiKey = "AAAA0Fc2hng:APA91bEUyAg6M0qgzUZR4rt4jbIngjqV_7u53npOn8YqynkUnJcbw5Dm4hbw0wjTWILF9qAKSO39ud-h11Xcs3SsPqevGgA0OAJpKDJdbsB77a-wN6UpBHZL5RN2wbpnY-XuV7J1T6Sn";
			//vodrex fcm key
			//$apiKey = "AAAAiF3CKt0:APA91bE8mYQcWrsve-jsNVs_7j_hbSkbS2S-Bd2hPzl3ultVR2Z_8zI7ZlY4Cj0dli3Vj3fl8fiakbAo2mAFhu-r0yiTqc731sV3OENjTZjk9fgLtv3tPYDf8zAevsSRaLE-PK_lBc0R";
		}else if($app_name == 1234){

			//bestbox
			//$apiKey = "AAAA0Fc2hng:APA91bEUyAg6M0qgzUZR4rt4jbIngjqV_7u53npOn8YqynkUnJcbw5Dm4hbw0wjTWILF9qAKSO39ud-h11Xcs3SsPqevGgA0OAJpKDJdbsB77a-wN6UpBHZL5RN2wbpnY-XuV7J1T6Sn";

			//vodrex fcm key
			$apiKey = "AAAAiF3CKt0:APA91bE8mYQcWrsve-jsNVs_7j_hbSkbS2S-Bd2hPzl3ultVR2Z_8zI7ZlY4Cj0dli3Vj3fl8fiakbAo2mAFhu-r0yiTqc731sV3OENjTZjk9fgLtv3tPYDf8zAevsSRaLE-PK_lBc0R";
		}else if($app_name == 1235){
			// FCM VODREX Key
			$apiKey = "AAAAiF3CKt0:APA91bE8mYQcWrsve-jsNVs_7j_hbSkbS2S-Bd2hPzl3ultVR2Z_8zI7ZlY4Cj0dli3Vj3fl8fiakbAo2mAFhu-r0yiTqc731sV3OENjTZjk9fgLtv3tPYDf8zAevsSRaLE-PK_lBc0R";
		}else if($app_name == "VODREX"){
			// FCM VODREX Key
			$apiKey = "AAAAiF3CKt0:APA91bE8mYQcWrsve-jsNVs_7j_hbSkbS2S-Bd2hPzl3ultVR2Z_8zI7ZlY4Cj0dli3Vj3fl8fiakbAo2mAFhu-r0yiTqc731sV3OENjTZjk9fgLtv3tPYDf8zAevsSRaLE-PK_lBc0R";
		}else{
			//bestbox FCM Key
			//$apiKey = "AAAA0Fc2hng:APA91bEUyAg6M0qgzUZR4rt4jbIngjqV_7u53npOn8YqynkUnJcbw5Dm4hbw0wjTWILF9qAKSO39ud-h11Xcs3SsPqevGgA0OAJpKDJdbsB77a-wN6UpBHZL5RN2wbpnY-XuV7J1T6Sn";
			// FCM VODREX Key
			$apiKey = "AAAAiF3CKt0:APA91bE8mYQcWrsve-jsNVs_7j_hbSkbS2S-Bd2hPzl3ultVR2Z_8zI7ZlY4Cj0dli3Vj3fl8fiakbAo2mAFhu-r0yiTqc731sV3OENjTZjk9fgLtv3tPYDf8zAevsSRaLE-PK_lBc0R";
		}



        $headers = array(
            'Authorization: key=' . $apiKey,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        //print_r($result); exit;
        Log::info("android fcm response ".json_encode($result). " request params ".json_encode($fields));
			if ($result === FALSE) {
				die('Curl failed: ' . curl_error($ch));
			}else{
				$fcminfo = json_decode($result);
				if(!empty($fcminfo)){
					$success = $fcminfo->success;
					$failure = $fcminfo->failure;

					if($failure == 1){
						$message = $fcminfo->results[0]->error;
					}else{
						$message = $fcminfo->results[0]->message_id;
					}
					$created_date = date('Y-m-d H:i:s');
					$fcmpushNotifications=new FcmpushNotifications();
					$fcmpushNotifications->device_id=$device_id[0];
					$fcmpushNotifications->telephone=$mobile_no;
					$fcmpushNotifications->success_status=$success;
					$fcmpushNotifications->failure_status=$failure;
					$fcmpushNotifications->message=$message;
					$fcmpushNotifications->message_type=$messageType;
					$fcmpushNotifications->created_at=$created_date;
					$fcmpushNotifications->save();
				}
			}
			curl_close($ch);
			return $result;

	}

	public static function sendFCMIOS($device_id,$data,$mobile_no,$messageType,$htmlMessageIOS="",$application_name,$user_id)
	{

		if(!empty($device_id)){
			//$user_id = User::where('device_id',$device_id)->first()->rec_id;
			$badgecount = Ios_badge_count::where('user_id',$user_id)->where('badge_count',1)->sum('badge_count');
			if(!empty($badgecount))
			{
				$totalCount = $badgecount+1;
			}else{
				$totalCount = 1;
			}
		}else{
			$totalCount = 1;
		}



		$ch = curl_init("https://fcm.googleapis.com/fcm/send");

		$notification = array('body' =>$htmlMessageIOS,'sound'=>'notification.caf', 'badge' =>$totalCount,'click_action'=>'CustomSamplePush');

		//This array contains, the token and the notification. The 'to' attribute stores the token.
		$arrayToSend = array('to' => $device_id,'notification' => $notification,'data'=>$data,'priority'=>'high','content_available'=>true,'mutable_content'=>true);

		//Generating JSON encoded string form the above array.
		$json = json_encode($arrayToSend);
		//Setup headers:
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: key= AAAAXQifTjI:APA91bEACgDLmal6e8_NlgeqLUcxpBHr1yfxjvsWLfIhp9JVYV7lRTvXOilu0XiqAoXXn50scIHUz4EGmHG7TQdW3jkQ1xeADfyP2LIiRu7nJakfyUKBUvlvL_8_0zHG23HLXOm83Fc6'; // IOS VODREX FCM key here

		curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

		//Send the request
		$response = curl_exec($ch);
		Log::info("ios fcm response ".json_encode($response). " request params ".$json);
		if ($response === FALSE) {
				//die('Curl failed: ' . curl_error($ch));
		}else{
				$fcminfo = json_decode($response);
				if(!empty($fcminfo)){
					$success = $fcminfo->success;
					$failure = $fcminfo->failure;

					if($failure == 1){
						$message = $fcminfo->results[0]->error;
					}else{
						$message = $fcminfo->results[0]->message_id;
					}
					$created_date = date('Y-m-d H:i:s');
					$fcmpushNotifications=new FcmpushNotifications();
					$fcmpushNotifications->device_id=$device_id;
					$fcmpushNotifications->telephone=$mobile_no;
					$fcmpushNotifications->success_status=$success;
					$fcmpushNotifications->failure_status=$failure;
					$fcmpushNotifications->message=$message;
					$fcmpushNotifications->message_type=$messageType;
					$fcmpushNotifications->created_at=$created_date;
					$fcmpushNotifications->save();

					//save badgecount table
					if($success == 1){
						$ios_badge_count = new Ios_badge_count();
						$ios_badge_count->user_id=$user_id;
						$ios_badge_count->badge_count=1;
						$ios_badge_count->created_date=$created_date;
						$ios_badge_count->save();
					}


				}
			}

		//Close request
		curl_close($ch);
		return $response;

	}

	// LogOUT Notification FCM Same user login another device

	public static function sendFCMIOSLogoutNotification($device_id,$data,$mobile_no,$messageType)
	{

		$ch = curl_init("https://fcm.googleapis.com/fcm/send");

		$notification = array('body' =>'Some one login another device','sound'=>'default','click_action'=>'CustomSamplePush');

		//This array contains, the token and the notification. The 'to' attribute stores the token.
		$arrayToSend = array('to' => $device_id,'notification' => $notification,'data'=>$data,'priority'=>'high','content_available'=>true,'mutable_content'=>true);

		//Generating JSON encoded string form the above array.
		$json = json_encode($arrayToSend);
		//Setup headers:
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: key= AAAAvCqjVek:APA91bHq-rUJJQmOlsye9j-NIJ5SDyDX24jPADSB1mTcw4BhbGEHgUVHpN2BotLe9hMeBGa227HLqHl3D1-bI9iEKXLl-aR0N2hSyfAeuESX2gyfYTYQQ2QOrtvZa0V45vZTnnQ9BNsv'; // key here

		curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

		//Send the request
		$response = curl_exec($ch);
		if ($response === FALSE) {
				die('Curl failed: ' . curl_error($ch));
		}else{
				$fcminfo = json_decode($response);
				$success = $fcminfo->success;
				$failure = $fcminfo->failure;

				if($failure == 1){
					$message = $fcminfo->results[0]->error;
				}else{
					$message = $fcminfo->results[0]->message_id;
				}
				$created_date = date('Y-m-d H:i:s');
				$fcmpushNotifications=new FcmpushNotifications();
				$fcmpushNotifications->device_id=$device_id;
				$fcmpushNotifications->telephone=$mobile_no;
				$fcmpushNotifications->success_status=$success;
				$fcmpushNotifications->failure_status=$failure;
				$fcmpushNotifications->message=$message;
				$fcmpushNotifications->message_type=$messageType;
				$fcmpushNotifications->created_at=$created_date;
				$fcmpushNotifications->save();


			}

		//Close request
		curl_close($ch);
		return $response;
	}




	public static function sendFCMIOSLoginNotification($device_id,$data,$mobile_no, $messageType,$application_name,$iosloginheading,$user_id)
	{

		$ch = curl_init("https://fcm.googleapis.com/fcm/send");
		// get badge count
		$badgecount = Ios_badge_count::where('user_id',$user_id)->where('badge_count',1)->sum('badge_count');

		if(!empty($badgecount))
		{
			$totalCount = $badgecount+1;
		}else{
			$totalCount = 1;
		}

		$notification = array('body' =>$iosloginheading,'sound'=>'notification.caf', 'badge' =>$totalCount,'click_action'=>'CustomSamplePush');

		//This array contains, the token and the notification. The 'to' attribute stores the token.
		$arrayToSend = array('to' => $device_id,'notification' => $notification,'data'=>$data,'priority'=>'high','content_available'=>true,'mutable_content'=>true);

		//Generating JSON encoded string form the above array.
		$json = json_encode($arrayToSend);
		//Setup headers:
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: key= AAAAXQifTjI:APA91bEACgDLmal6e8_NlgeqLUcxpBHr1yfxjvsWLfIhp9JVYV7lRTvXOilu0XiqAoXXn50scIHUz4EGmHG7TQdW3jkQ1xeADfyP2LIiRu7nJakfyUKBUvlvL_8_0zHG23HLXOm83Fc6'; // IOS VODREX FCM key here

		curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

		//Send the request
		$response = curl_exec($ch);
		Log::info("ios fcm login notification  ".json_encode($response). " request params ".$json);
		if ($response === FALSE) {
				//die('Curl failed: ' . curl_error($ch));
		}else{
				$fcminfo = json_decode($response);
				$success = $fcminfo->success;
				$failure = $fcminfo->failure;

				if($failure == 1){
					$message = $fcminfo->results[0]->error;
				}else{
					$message = $fcminfo->results[0]->message_id;
				}
				$created_date = date('Y-m-d H:i:s');
				$fcmpushNotifications=new FcmpushNotifications();
				$fcmpushNotifications->device_id=$device_id;
				$fcmpushNotifications->telephone=$mobile_no;
				$fcmpushNotifications->success_status=$success;
				$fcmpushNotifications->failure_status=$failure;
				$fcmpushNotifications->message=$message;
				$fcmpushNotifications->message_type=$messageType;
				$fcmpushNotifications->created_at=$created_date;
				$fcmpushNotifications->save();

				//save badgecount table
				if($success == 1){
					$ios_badge_count = new Ios_badge_count();
					$ios_badge_count->user_id=$user_id;
					$ios_badge_count->badge_count=1;
					$ios_badge_count->created_date=$created_date;
					$ios_badge_count->save();
				}


			}

		//Close request
		curl_close($ch);
		return $response;
	}

    //epg time conversion

    public static function convertIntoDateTImezone($date){
		$yy = substr($date,0,4);
		$mm = substr($date,4,2);
		$dd = substr($date,6,2);
		$h = substr($date,8,2);
		$m = substr($date,10,2);
        $s = substr($date,12,2);
        $th = substr($date,15,3);
        $tm = substr($date,18,3);
		$originalDate = strtotime($yy.'-'.$mm.'-'.$dd.' '.$h.':'.$m.':'.$s);
		$newDate = date("Y-m-d H:i:s", $originalDate);
		return $newDate.' '.$th.':'.$tm;
	}

	public static function convertIntoDate($date){
		$yy = substr($date,0,4);
		$mm = substr($date,4,2);
		$dd = substr($date,6,2);
		$h = substr($date,8,2);
		$m = substr($date,10,2);
		$s = substr($date,12,2);

		$originalDate = strtotime($yy.'-'.$mm.'-'.$dd.' '.$h.':'.$m.':'.$s);
		$newDate = date("Y-m-d H:i:s", $originalDate);
		return $newDate;
	}

	public static function convertDateIntoHours($date){
		$to = substr($date,0,8);
		$hh = substr($date,8,2);
		$mm = substr($date,10,2);
		$ss = substr($date,12,2);
		return $hh.':'.$mm;
	}

	//curl for post data using api
	public static function getPostDataFromAPI($url,$data){
		$postRequest = array(
			
		);

		$cURLConnection = curl_init($API_URL);
		curl_setopt($cURLConnection, CURLOPT_POST, 1);
		curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);
		curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
						'x-request-type: web',
						'Referer:https://vplayed-bestbox-uat.contus.us'
					));
		$apiResponse = curl_exec($cURLConnection);
		curl_close($cURLConnection);


	}

	//curl for get data using api
	public static function getDataFromAPI($url){
		$cURLConnection = curl_init($API_URL);

		curl_setopt($cURLConnection, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($cURLConnection, CURLOPT_POST, 0);
		curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
						'x-request-type: web',
						'Referer:https://vplayed-bestbox-uat.contus.us'
					));
		$apiResponse = curl_exec($cURLConnection);

		curl_close($cURLConnection);

		// $apiResponse - available data from the API request
		$jsonArrayResponse = json_decode($apiResponse,true);

		return $jsonArrayResponse;

	}


}
?>

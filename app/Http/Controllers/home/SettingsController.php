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
use Illuminate\Support\Facades\Redirect;
use App\EPG_list;
use App\EPG_list2;
use App\Settings;
use App\RolesPermissions;
use App\User_requested_movies;
use App\Recent_movies_images;
use App\Purchase_order_details;
use App\IptvConfigURLS;
use Illuminate\Support\Facades\Auth;
use App\Library\Common;
use App\ApplicationSettings;
use App\UsersDevicesList;
class SettingsController extends Controller
{


	public function customer_bonus()
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$data['bonusList'] = Settings::select('*')->where('status','=',1)->where('id','=',1)->orderBy("id", "DESC")->get();
		return view('customer_bonus')->with($data);

	}

	public function addCustomerBonus(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$customerBonus = Input::get("customerBonus");
		$description = Input::get("description");
		if($customerBonus == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'Please Enter Customer Bonus'], 200);
		}else if($description == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'Please Enter Description'], 200);
		}else{
			$data = [
						'customer_bonus' => $customerBonus,
						'bonus_description' => $description,
						'updated_at' => date("Y-m-d H:i:s")

					];
					//print_r($data);exit;
			$res = Settings::where('id','=',1)->update($data);
			if($res){
				return response()->json(['status' => 'Success', 'Result' => 'Bonus Updated Successfully.'], 200);
			}else{
				return response()->json(['status' => 'Failure', 'Result' => 'Something went wrong'], 200);
			}

		}

	}


	public function resendVerifyEmail(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$data['searchKey'] = $request->query('searchKey');

		$searchKey = $request->query('searchKey');

		if(!empty($searchKey)){

			$data['resendEmailsList'] = User::select('*')->where('email_verify','=',0)->where('status','!=',2)
			->where(function($query) use($searchKey) {
           			 return $query->where('user_id','LIKE', '%' . $searchKey . '%')->orWhere('email', 'LIKE', '%' . $searchKey . '%');
        		})
			->orderBy("rec_id", "DESC")->paginate(20);


		}else{
			$data['resendEmailsList'] = User::select('*')->where('email_verify','=',0)->where('status','!=',2)->orderBy("rec_id", "DESC")->paginate(20);

		}


		return view('resendVerifyEmail')->with($data);

	}

	public function resendVerifyEmailToUser()
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$rec_id =Input::get("rec_id");
		if(!empty($rec_id)){
			$verifyEmailInfo = User::select('*')->where('rec_id','=',$rec_id)->first();
			if(!empty($verifyEmailInfo)){
				$user_id = $verifyEmailInfo->rec_id;
				$first_name = $verifyEmailInfo->first_name;
				$last_name = $verifyEmailInfo->last_name;
				$email = $verifyEmailInfo->email;
				$referral_code = $verifyEmailInfo->refferallink_text;
				$user_role = $verifyEmailInfo->user_role;

				/*$type = "";
				if($user_role == 1){
					$type ="Super Admin";
				}else if($user_role == 2){
					$type ="Reseller";
				}else if($user_role == 3){
					$type ="Agent";
				}else if($user_role == 4){
					$type ="Customer";
				}*/

				$res = RolesPermissions::where('id', $user_role)->first();
				if(!empty($res)){
					$type = $res->role_name;
				}else{
					 $type = "";
				}

				$data['useremail'] = array('name' => $first_name.' '.$last_name, 'user_id' => $user_id, 'email' => $email,'type'=>$type, 'referral_link' => $referral_code);
				$emailid = array('toemail' => $email);
				Mail::send(['html' => 'email_templates.resend_email_verify'], $data, function ($message) use ($emailid) {
					$message->to($emailid['toemail'], 'Email Verify')->subject('Email Verify');
					$message->from('noreply@bestbox.net', 'BestBox');
				});
				return response()->json(['status' => 'Success', 'Result' => 'We sent verification email again to your registered email. Please Verify'], 200);
			}else{
				return response()->json(['status' => 'Failure', 'Result' => 'verify Info not found'], 200);
			}
		}else{
			return response()->json(['status' => 'Failure', 'Result' => 'Selected rec id is missing'], 200);
		}



	}

	public function deleteInvalidEmail()
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$rec_id =Input::get("rec_id");
		if(!empty($rec_id)){

			//$data = array("status"=>2);
			//$res = User::where('rec_id','=',$rec_id)->update($data);



			$deleteuserinfo = User::where('rec_id','=',$rec_id)->first();
			if(!empty($deleteuserinfo)){

				// delete user table
				$res = DB::table('users')->where('rec_id', $rec_id)->delete();

				// delete wallet table
				$res = DB::table('wallet')->where('user_id', $rec_id)->delete();

				// delete unilevel_tree table
				$deleteCount = DB::table('unilevel_tree')->where('down_id', $rec_id)->count();
				if($deleteCount >0){
					$res = DB::table('unilevel_tree')->where('down_id', $rec_id)->delete();
				}


				$user_role = $deleteuserinfo->user_role;

				// delete user_tree table
				if($user_role == 4){
					$res = DB::table('users_tree')->where('customer_id', $rec_id)->delete();
				}else if($user_role == 3){
					$res = DB::table('users_tree')->where('agent_id', $rec_id)->delete();
				}else if($user_role == 2){
					$res = DB::table('users_tree')->where('reseller_id', $rec_id)->delete();
				}

			}

			if($res){
					return response()->json(['status' => 'Success', 'Result' => 'Deleted Successfully.'], 200);
			}else{
				return response()->json(['status' => 'Failure', 'Result' => 'Something went wrong in update query'], 200);
			}


		}else{
			return response()->json(['status' => 'Failure', 'Result' => 'Selected rec id is missing'], 200);
		}



	}



	public function requestedMovies(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$data['searchKey'] = $request->query('searchKey');

		$searchKey = $request->query('searchKey');

		if(!empty($searchKey)){

			$data['movieslist'] = User_requested_movies::join('users','users.rec_id','=','user_requested_movies.user_id')->select('users.first_name','users.last_name','users.user_id','users.email','user_requested_movies.rec_id','user_requested_movies.requested_movies','user_requested_movies.requested_date','user_requested_movies.status')->where('user_requested_movies.requested_movies','like','%' .$searchKey. '%')->orderBy('user_requested_movies.rec_id','DESC')->paginate(30);

		}else{

			$data['movieslist'] = User_requested_movies::join('users','users.rec_id','=','user_requested_movies.user_id')->select('users.first_name','users.last_name','users.user_id','users.email','user_requested_movies.rec_id','user_requested_movies.requested_movies','user_requested_movies.requested_date','user_requested_movies.status')->orderBy('user_requested_movies.rec_id','DESC')->paginate(30);

		}



		return view('requested_movies_list')->with($data);

	}

	// send fcm uploaded movie

	public function sendFCMUploadedMovie(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$rec_ids = Input::get("rec_ids");
		$action = Input::get("action");

		if(!empty($rec_ids)){
			if($action == "singleuser"){

				Common::sendFCMUploadedMovie($rec_ids);
				$data = array("status"=>1);
				$res = User_requested_movies::where('rec_id','=',$rec_ids)->update($data);
				return response()->json(['status' => 'Success', 'Result' => 'We sent FCM Successfully.'], 200);

			}else if($action == "pending"){

				//Common::sendFCMUploadedMovie($rec_ids);
				$data = array("status"=>0);
				$res = User_requested_movies::where('rec_id','=',$rec_ids)->update($data);
				return response()->json(['status' => 'Success', 'Result' => 'Status Updated Successfully'], 200);

			}else{

				$usersList1 = explode(",", $rec_ids);
				foreach($usersList1 as $rec_id){
					Common::sendFCMUploadedMovie($rec_id);
					$data = array("status"=>1);
					$res = User_requested_movies::where('rec_id','=',$rec_id)->update($data);
				}
				return response()->json(['status' => 'Success', 'Result' => 'We sent FCM Successfully.'], 200);

			}
		}else{
			return response()->json(['status' => 'Failure', 'Result' => 'User ID is missing'], 200);
		}

	}

	public function recentMoviesImages(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		$data['userInfo'] = $userinfo;
		$data['searchKey'] = $request->query('searchKey');

		$searchKey = $request->query('searchKey');

		$data['moviesImages'] = Recent_movies_images::where('status','=',1)->orderBy('rec_id','DESC')->paginate(20);

		//return view('recent_movies_images')->with($data);
		return view('versions_list/mobileBannersUploads')->with($data);

	}

	// Add New Package
	public function addNewMovieImage(Request $request)
	{

		//get packages
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$title = Input::get("title");
		$uploads = Input::get("uploads");
		$movie_link = Input::get("movie_link");
		$cat_list = Input::get("cat_list");

		$action = Input::get("action");
		$created_at = date('Y-m-d H:i:s');

		if(!empty($movie_link)){
			$movie_link = $movie_link;
		}else{
			$movie_link = "";
		}

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
					$org_name1 = time().'_'.$org_name;
					$destinationPath = base_path('/public/recent_movies_images');
					$result = $image->move($destinationPath, $org_name1);
					if ($result) {

						$data = [
							'title' => $title,
							'movie_image' => $org_name1,
							'movie_link' => $movie_link,
							'created_at' => $created_at,
							'cat_list' => $cat_list,

						];
						//print_r($data);exit;
						$res = Recent_movies_images::insert($data);

						return response()->json(['status' => 'Success', 'Result' => 'Movie Image Created Successfully.'], 200);

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
			return response()->json(['status' => 'Failure', 'Result' => 'Please Upload Image'], 200);
		}




	}

	// delete image
	public function deleteMovieStatus()
	{
		//get packages
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$rec_ids = Input::get("rec_ids");
		$action = Input::get("action");

		if (!empty($rec_ids)) {
			if($action == "singleImage"){
				$updata = array("status"=>0);
				$res = Recent_movies_images::where('rec_id', '=', $rec_ids)->update($updata);
				if ($res) {
					return response()->json(['status' => 'Success', 'Result' => "Deleted Successfully."], 200);
				} else {
					return response()->json(['status' => 'Failure', 'Result' => "Something Went wrong"], 200);
				}
			}else{
				$usersList1 = explode(",", $rec_ids);
				foreach($usersList1 as $rec_id){
					$data = array("status"=>0);
					$res = Recent_movies_images::where('rec_id','=',$rec_id)->update($data);
				}
				return response()->json(['status' => 'Success', 'Result' => 'Successfully Deleted selected images..'], 200);
			}

		} else {
			return response()->json(['status' => 'Failure', 'Result' => "Record ID missing"], 200);
		}
	}

	// IPTV Streaming URL
	public function iptvStreamingURLs(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		//$data['searchKey'] = $request->query('searchKey');

		//$searchKey = $request->query('searchKey');

		$data['iptv_info'] = IptvConfigURLS::where('rec_id','=',1)->orderBy('rec_id','DESC')->first();

		return view('iptvConfigURLS')->with($data);

	}

	// delete image
	public function updateIPTVStreamingInfo()
	{
		//get packages
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$rec_ids = 1; //Input::get("rec_ids");

		$iptv_live = Input::get("iptv_live");
		$iptv_player = Input::get("iptv_player");
		$iptv_vod = Input::get("iptv_vod");
		$iptv_catchup = Input::get("iptv_catchup");

		$action = Input::get("action");

		if (!empty($rec_ids)) {
			$updata = array("iptv_live"=>$iptv_live,"iptv_player"=>$iptv_player,"iptv_vod"=>$iptv_vod,"iptv_catchup"=>$iptv_catchup);
			$res = IptvConfigURLS::where('rec_id', '=', 1)->update($updata);
			if ($res) {
				return response()->json(['status' => 'Success', 'Result' => "Updated Successfully."], 200);
			} else {
				return response()->json(['status' => 'Failure', 'Result' => "Something Went wrong"], 200);
			}

		} else {
			return response()->json(['status' => 'Failure', 'Result' => "Record ID missing"], 200);
		}
	}

	public function getMobileVersions(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		$data['userInfo'] = $userinfo;
		//$data['searchKey'] = $request->query('searchKey');

		//$searchKey = $request->query('searchKey');

		$data['version_info'] = Settings::where('id','=',1)->orderBy('id','DESC')->first();

		//return view('mobileVersionCodes')->with($data);
		return view('versions_list/bestboxTvVersionupdates')->with($data);

	}


	// update Mobile app versions

	public function updateMobileAppVersions()
	{
		//get packages
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$rec_ids = 1; //Input::get("rec_ids");
		$android_app_code = Input::get("android_app_code");
		$android_app_version = Input::get("android_app_version");
		$ios_app_version = Input::get("ios_app_version");

		$action = Input::get("action");

		if (!empty($rec_ids)) {
			$updata = array("android_app_code"=>$android_app_code,"android_app_version"=>$android_app_version,"ios_app_version"=>$ios_app_version);
			$res = Settings::where('id', '=', 1)->update($updata);
			if ($res) {
				return response()->json(['status' => 'Success', 'Result' => "Updated Successfully."], 200);
			} else {
				return response()->json(['status' => 'Failure', 'Result' => "Something Went wrong"], 200);
			}

		} else {
			return response()->json(['status' => 'Failure', 'Result' => "Record ID missing"], 200);
		}
	}




	//Tracking order

	public function trackingOrder()
	{
		//get packages
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$data['customers_data'] = User::join('purchase_order_details','users.rec_id','=','purchase_order_details.user_id')
				->join('package_purchased_list','users.rec_id','=','package_purchased_list.user_id')
				->join('packages','packages.id','=','package_purchased_list.package_id')
				->select('users.rec_id','users.first_name','users.last_name','users.user_id','packages.id as package_id','purchase_order_details.order_id')
				->where(['packages.setupbox_status' => 1,'users.user_role' => 4,'purchase_order_details.status' => 2,'purchase_order_details.is_shipped' => 0])
				->where('purchase_order_details.order_id','!=','')
				->groupby('purchase_order_details.user_id')
				->orderBy('users.first_name','ASC','')
				->get();

		return view('tracking_order')->with($data);
	}

	//send Traking Details To Customer mail

	public function sendTrakingDetailsToCustomer(Request $request)
	{
		//get packages
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$validator = Validator::make($request->all(), [
			'username' => 'required',
			'order_id' => 'required|string|min:3',
			'trackingId' => 'required|string|min:3',
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			Session::flash('result', '<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>');
			Session::flash('alert','Failure');
			return Redirect::back();
		}

		$customer_id = $request->username;
		$order_id = $request->order_id;
		$trackingId = $request->trackingId;
		$customer_info = User::select('rec_id','first_name','last_name','email')->where(['rec_id'=>$customer_id])->first();
		$order_details = Purchase_order_details::select('updated_at')->where(['order_id' => $request->order_id])->first();

		$data['useremail'] = array('name' => $customer_info['first_name'].' '.$customer_info['last_name'], 'rec_id' => $customer_info['rec_id'], 'email' => $customer_info['email'],'order_id' => $order_id,'tracking_id' => $trackingId,'date' => date("d/m/Y"),'shipped_date' => $order_details['updated_at']);

		$emailid = array('toemail' => $customer_info['email']);
		Mail::send(['html' => 'email_templates.shipping_tracking_order'], $data, function ($message) use ($emailid) {
			$message->to($emailid['toemail'], 'Tracking Order Details')->subject('Tracking Order Details');
			$message->from('noreply@bestbox.net', 'BestBox');
		});

		Purchase_order_details::where(['order_id' => $request->order_id])->update(['is_shipped' => 1]);

		Session::flash('result', 'Shipping Tracking Details sent to mail Successfully');
		Session::flash('alert','Success');
		return Redirect::back();
	}

	public function importEpgList(Request $request){
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		$data['countryList'] = DB::connection('mysql2')->select('SELECT id,name from countries where is_active = 1 ORDER By name');
		return view('import_epglist')->with($data);
	}

	public function saveEpgList(Request $request){
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$validator = Validator::make($request->all(), [
            'epg_list_file' => 'required|mimes:application/xml,xml',
            'country_id' => 'required'
        ]);

        if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			Session::flash('error', '<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>');
			Session::flash('alert','Failure');
			return Redirect::back();
		}

		$country_id = $request->country_id;
		if ($request->hasFile('epg_list_file')) {
			$image = $request->file('epg_list_file');
			$fileType = $image->guessExtension();
			$fileTyp = strtolower($fileType);
			$allowedTypes = array("xml");
			if (in_array($fileTyp, $allowedTypes)) {
				// Rename image
				$fileName = date('Ymd').'_'.rand(999,9999999).time().'.'.$image->guessExtension();
				$destinationPath = public_path('/epgFiles');
				$upload_success = $image->move($destinationPath, $fileName);

				if ($upload_success) {
					$xml_url = url('/').'/public/epgFiles/'.$fileName;
                    //$xml2=simplexml_load_file($xml_url) or die("Error: Cannot create object");
                    $curl_handle=curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL,$xml_url);
                    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 5555555555);
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36');
                    $response = curl_exec($curl_handle);
                    if (curl_errno($curl_handle)) {
                        //echo 'Error:' . curl_error($ch);
                        echo "fail";exit;
                    }
                    curl_close($curl_handle);

                    $xml2 = simplexml_load_string($response);
                    foreach($xml2->programme as $iprogrammendex => $prg) {
                        $xmltv_id = trim($prg->attributes()->channel);
                        $start_timezone = Common::convertIntoDate($prg->attributes()->start);
                        $result = EPG_list::where(['country_id' => $country_id, 'xmltv_id' => $xmltv_id, 'start_timezone' => $start_timezone])->get();
                        if($result->count() == 0) {
                            $data = [
                                'xmltv_id' => $xmltv_id,
                                'title' => trim($prg->title),
                                'description' => trim($prg->desc),
                                'start_time' => Common::convertDateIntoHours($prg->attributes()->start),
                                'end_time' => Common::convertDateIntoHours($prg->attributes()->stop),
                                'start_timezone' => Common::convertIntoDate($prg->attributes()->start),
                                'end_timezone' => Common::convertIntoDate($prg->attributes()->stop),
                                'stimezone' => Common::convertIntoDateTImezone($prg->attributes()->start),
                                'etimezone' => Common::convertIntoDateTImezone($prg->attributes()->stop),
                                'country_id' => $country_id,
                                'created_at' => date("Y-m-d H:i:s"),
                                'updated_at' => date("Y-m-d H:i:s")
                            ];

                            EPG_list::insert($data);
                        }

					}

					Session::flash('message', 'Epg List Updated Successfully ');
					Session::flash('alert','Success');
					return Redirect::back();
				} else {
					Session::flash('message', 'Something went wrong in Uploading Epg List');
					Session::flash('alert','Failure');
					return Redirect::back();
				}
			} else {
				Session::flash('message', 'Please Upload only xml only');
				Session::flash('alert','Failure');
				return Redirect::back();
			}
        }
        return redirect('importEpgList');
    }

    public static function compareDate($date){
		$date1 = substr($date,0,8);
		$date2 = date('Ymd');
		if(strval($date1) == strval($date2)){
			return true;
		}else{
			return false;
		}
    }

    public function readUSFile(Request $request){
        $xml_url = 'http://server1.xmltv.co:80/xmltv.php?username=eEGsbXpFM1&password=4D6dh8yXk6&prev_days=0&next_days=1';
        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL,$xml_url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 5555555555);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36');
        $response = curl_exec($curl_handle);
        if (curl_errno($curl_handle)) {
            //echo 'Error:' . curl_error($ch);
            echo "fail";exit;
        }
        curl_close($curl_handle);
        $xml2 = simplexml_load_string($response);
        if(!empty($xml2)) {
            echo '<pre>';print_R($xml2);exit;
        }

        // foreach($xml2->programme as $iprogrammendex => $prg) {
        //     $xmltv_id = trim($prg->attributes()->channel);
        //     $start_timezone = self::convertIntoDate($prg->attributes()->start);
        //     $result = EPG_list::where(['country_id' => $country_id, 'xmltv_id' => $xmltv_id, 'start_timezone' => $start_timezone])->get();
        //     if($result->count() == 0) {
        //         $data = [
        //             'xmltv_id' => $xmltv_id,
        //             'title' => trim($prg->title),
        //             'description' => trim($prg->desc),
        //             'start_time' => self::convertDateIntoHours($prg->attributes()->start),
        //             'end_time' => self::convertDateIntoHours($prg->attributes()->stop),
        //             'start_timezone' => self::convertIntoDate($prg->attributes()->start),
        //             'end_timezone' => self::convertIntoDate($prg->attributes()->stop),
        //             'stimezone' => self::convertIntoDateTImezone($prg->attributes()->start),
        //             'etimezone' => self::convertIntoDateTImezone($prg->attributes()->stop),
        //             'country_id' => $country_id,
        //             'created_at' => date("Y-m-d H:i:s"),
        //             'updated_at' => date("Y-m-d H:i:s")
        //         ];

        //         EPG_list::insert($data);
        //     }

        // }
    }

	public function applicationSettings(){
		$data['proxySettings']=IptvConfigURLS::where('status',1)->first();
		$appsettings=ApplicationSettings::where('setting_name','trail_earning_notification')->first();
		$trail_earnings=array();
		if($appsettings!==null){
			$setting_value=unserialize($appsettings['setting_value']);
            $trail_earnings =$setting_value;
        }
		$data['trail_earnings']=$trail_earnings;
		$multisettings=ApplicationSettings::where('setting_name','multi_account_discount')->first();
		$multi_acc_disc=array();
		if($multisettings!==null){
			$multi_setting_value=unserialize($multisettings['setting_value']);
            $multi_acc_disc =$multi_setting_value;
        }
		$data['multi_acc_disc']=$multi_acc_disc;
		$maintanance_settings=ApplicationSettings::where('setting_name','maintanance_settings')->first();
		$maintanance_mode=array();
		if($maintanance_settings!==null){
			$maintanance_value=unserialize($maintanance_settings['setting_value']);
            $maintanance_mode =$maintanance_value;
		}
		$data['maintanance_mode'] = $maintanance_mode;
		//echo '<pre>';print_R($data);exit;
		return view('application_settings')->with($data);
	}

	public function save_proxy_settings(Request $request){
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$validator = Validator::make($request->all(), [
			'client_code' => 'required',
			'proxy_line_streaming' => 'required',
			'proxy_vod' => 'required',
			'proxy_catchup' => 'required',
			'live_streaming' => 'required',
			'vod_link' => 'required',
			'catchup_link' => 'required',
			'player_link' => 'required',

		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			Session::flash('error', '<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>');
			Session::flash('alert','Failure');
			return Redirect::back();
		}
		$client_code = $request->client_code;
		$proxy_line_streaming = $request->proxy_line_streaming;
		$proxy_vod = $request->proxy_vod;
		$proxy_catchup = $request->proxy_catchup;
		$live_streaming = $request->live_streaming;
		$vod_link = $request->vod_link;
		$catchup_link = $request->catchup_link;
		$player_link = $request->player_link;
		DB::table('iptv_config_urls')->update(array("status"=>0));
		$data = array("client_id" => $client_code, "proxy_streaming" => $proxy_line_streaming, "proxy_vod" => $proxy_vod,"proxy_catchup" => $proxy_catchup,"iptv_live" => $live_streaming,"iptv_vod" => $vod_link,"iptv_catchup" => $catchup_link,"iptv_player" => $player_link,'status'=>1);
		$res = IptvConfigURLS::updateOrCreate(["client_id" => $client_code], $data);
		Session::flash('message', 'Proxy settings saved successfully');
		Session::flash('alert','Success');
		return Redirect::back();
	}
	public function save_trail_earning(Request $request){
		$validator = Validator::make($request->all(), [
			'trail_duration' => 'required'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			//Session::flash('error', '<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>');
			//Session::flash('alert','Failure');
			return response('<ul>' . $str . '</ul>',400);
		}
		$trail_duration = request('trail_duration');
		$dailyearning = request('dailyearning');
		$monthlyearning = request('monthlyearning');
		$ser_data=serialize(array('trail_duration'=>$trail_duration,'dailyearning'=>$dailyearning,'monthlyearning'=>$monthlyearning));
		$data=array('setting_value'=>$ser_data);
		ApplicationSettings::where('setting_name','trail_earning_notification')->update($data);
		return response("Trail & Earning Notification Updated Successfully.",200);
	}

	public function save_vplayed_data_update(Request $request){
		$is_vod_update_flag = request('is_vod_update_flag');
		$is_livetv_update_flag = request('is_livetv_update_flag');
		$is_series_update_flag = request('is_series_update_flag');
		$home_update_flag = 0;
		if($is_vod_update_flag == 1 || $is_livetv_update_flag == 1 || $is_series_update_flag == 1) {
            $home_update_flag = 1;
            UsersDevicesList::where('device_id','!=','')->update(['home_update_flag' => $home_update_flag]);
        }
        if($is_vod_update_flag) {
            UsersDevicesList::where('device_id','!=','')->update(['is_vod_update_flag'=>$is_vod_update_flag]);
            User::where('user_id','!=','')->update(['is_vod_update_flag'=>$is_vod_update_flag]);
        }
        if($is_vod_update_flag) {
            UsersDevicesList::where('device_id','!=','')->update(['is_livetv_update_flag'=>$is_livetv_update_flag]);
            User::where('user_id','!=','')->update(['is_livetv_update_flag'=>$is_livetv_update_flag]);
        }
        if($is_series_update_flag) {
            UsersDevicesList::where('device_id','!=','')->update(['is_series_update_flag'=>$is_series_update_flag]);
            User::where('user_id','!=','')->update(['is_series_update_flag'=>$is_series_update_flag]);
        }
		// $data=array('is_livetv_update_flag'=>$is_livetv_update_flag,'is_series_update_flag'=>$is_series_update_flag);
		// UsersDevicesList::where('device_id','!=','')->update($data);

		//User::where('user_id','!=','')->update($data);
		return response("Vplayed Data Update Notification Updated Successfully.",200);
	}
	//save maintanance mode settings (vod/series/livetv)
	public function save_maintanance_update(Request $request){
		$validator = Validator::make($request->all(), [
			'is_vod_maintanance_flag' => 'required',
			'is_livetv_maintanance_flag' => 'required',
			'is_series_maintanance_flag' => 'required'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			//Session::flash('error', '<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>');
			//Session::flash('alert','Failure');
			return response('<ul>' . $str . '</ul>',400);
		}
		$is_vod_maintanance_flag = request('is_vod_maintanance_flag');
		$is_livetv_maintanance_flag = request('is_livetv_maintanance_flag');
		$is_series_maintanance_flag = request('is_series_maintanance_flag');
		$ser_data=serialize(array('is_vod_maintanance_flag'=>$is_vod_maintanance_flag,'is_livetv_maintanance_flag'=>$is_livetv_maintanance_flag,'is_series_maintanance_flag'=>$is_series_maintanance_flag));
		$data=array('setting_value'=>$ser_data);
		ApplicationSettings::where('setting_name','maintanance_settings')->update($data);
		return response("Maintanance Mode Updated Successfully.",200);
	}

	public function save_multi_acc_discount(Request $request){
		$validator = Validator::make($request->all(), [
			'second_acc' => 'required',
			'third_acc' => 'required'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			//Session::flash('error', '<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>');
			//Session::flash('alert','Failure');
			return response('<ul>' . $str . '</ul>',400);
		}
		$second_acc = request('second_acc');
		$third_acc = request('third_acc');
		$ser_data=serialize(array('second_acc'=>$second_acc,'third_acc'=>$third_acc));
		$data=array('setting_value'=>$ser_data);
		ApplicationSettings::where('setting_name','multi_account_discount')->update($data);
		return response("Multiple Account Discount Updated Successfully.",200);
	}

	public function getTabMobileVersions(Request $request)
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		$data['userInfo'] = $userinfo;
		//$data['searchKey'] = $request->query('searchKey');

		//$searchKey = $request->query('searchKey');

		$data['version_info'] = Settings::where('id','=',1)->orderBy('id','DESC')->first();

		//return view('tabMobileVersionUpdates')->with($data);
		return view('versions_list/vodrexTabMobileVersionupdates')->with($data);

	}

	public function updateTabMobileAppVersions()
	{
		//get packages
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$rec_ids = 1; //Input::get("rec_ids");
		$tab_mobile_android_version = Input::get("tab_mobile_android_version");
		$tab_mobile_android_version_name = Input::get("tab_mobile_android_name");
		$tab_mobile_ios_version = Input::get("tab_mobile_ios_version");

		$action = Input::get("action");

		if (!empty($rec_ids)) {
			$updata = array("tab_mobile_android_version"=>$tab_mobile_android_version,"tab_mobile_android_version_name"=>$tab_mobile_android_version_name,"tab_mobile_ios_version"=>$tab_mobile_ios_version);
			$res = Settings::where('id', '=', 1)->update($updata);
			if ($res) {
				return response()->json(['status' => 'Success', 'Result' => "Updated Successfully."], 200);
			} else {
				return response()->json(['status' => 'Failure', 'Result' => "Something Went wrong"], 200);
			}

		} else {
			return response()->json(['status' => 'Failure', 'Result' => "Record ID missing"], 200);
		}
	}




}

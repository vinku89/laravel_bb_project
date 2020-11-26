<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AppController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\home\VodController;
use App\Http\Controllers\API\UserController;
use Validator;
use Session;
use App\User;
use App\Country;
use App\Countries;
use App\Wallet;
use App\RolesPermissions;
use App\Left_menu;
use App\MobileLeftMenu;
use App\EPG_list;
use App\ApplicationSettings;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Sales;
use App\Users_tree;
use Carbon\Carbon;
use App\Packages;
use App\Package_purchase_list;
use App\Commissions;
use App\Library\VodCommon;
use Memcached;
use App\Library\Memcache;
use DateTime;
use DateTimeZone;
use DateInterval;
class LivetvController extends AppController {

	public function __construct()
    {
      $this->mem=Memcache::memcached();
    }

	//get the live tv list
	public function livetvDashboard(Request $request)
	{

		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];

		$isPermissionForLiveTV = self::isPermissionForLiveTV($userId, $userRole);
	    //if(!$isPermissionForLiveTV) { return redirect('dashboard'); }

		$category = '';$country_id = '';
		$page = $request->query('page');
		$country_id = $request->query('country_id');
		$country_id = (!empty($country_id) && $country_id != 0) ? $country_id : '';
		$category = $request->query('category');
		$category = (!empty($category) && $category != 0) ? $category : '';
		$searchKey = $request->query('search');
		$searchKey = (!empty($searchKey)) ? $searchKey : '';
		$data['searchKey'] = $searchKey;

		$live_redirectURL = url('/').'/livetv?page=1&country_id='.$country_id.'&category='.$category.'&search='.$searchKey;
		Session::put('live_redirectURL',$live_redirectURL);

		$istakenFreeTrail = VodController::getUserTakeTrailRequestStatus($userId);
		$isPackageBuyed = VodController::isPackagePurchasedOrNot($userId);

		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;

		if( ($istakenFreeTrail == "trailgoingon") || ($isPackageBuyed == "package_goingon" ) && $isPermissionForLiveTV){
			if(!empty($page)){
				$page = $page;
			}else{
				$page = 1;
			}

			$data['livetv_videos'] = array();
			$data['livetv_categories'] = array();
			$is_livetv_update_flag = $userInfo['is_livetv_update_flag'];

			$livetv_videos = $this->mem->get("livetv_videos_".$userId);
			$live_country_id = $this->mem->get("live_country_id_".$userId);
            $live_cat_id = $this->mem->get("live_cat_id_".$userId);
            $livetv_categories = $this->mem->get("livetv_categories_".$userId);
			$data['livetv_countries'] = $this->mem->get("livetv_countries_".$userId);

			if(empty($data['livetv_countries']) || $is_livetv_update_flag == 1){
				
				$data['livetv_countries'] =DB::connection('mysql2')->select('SELECT c.id as country_id,c.name as country_name,c.code,count(v.id) as counts FROM country_categories cc JOIN categories cat ON cc.category_id=cat .id JOIN videos v ON cc.video_id=v.id LEFT JOIN countries c ON cc.country_id= c.id where c.is_active = 1 and v.is_live = 1 and v.is_active = 1 and v.job_status="Complete" and v.is_archived = 0 and v.liveStatus != "complete" and cc.video_id != 0 group by c.id ORDER By c.name');
				$this->mem->set("livetv_countries_".$userId, $data['livetv_countries'], 30*24*60*60);
				User::where('rec_id',$userId)->update(['is_livetv_update_flag' => 0]);
			}

	        if(empty($livetv_categories) || $is_livetv_update_flag == 1){
				$livetv_categories = VodCommon::getLivetvCategories('',1);
				$this->mem->set("livetv_categories_".$userId, $livetv_categories, 30*24*60*60);
				User::where('rec_id',$userId)->update(['is_livetv_update_flag' => 0]);
			}

			if(!empty($searchKey)){
				$livetv_videos = VodCommon::getLivetvVideos($country_id,$category,$searchKey,$page);
				if($livetv_videos["statusCode"]== 200 && $livetv_videos["status"] =="success"){
					if(!empty($livetv_videos["response"])){
						$data['livetv_videos'] = $livetv_videos["response"];
					}
				}
            }
            else if(empty($livetv_videos) || ($live_country_id != $country_id) || ($live_cat_id != $category) || $is_livetv_update_flag == 1) {

                $livetv_videos = VodCommon::getLivetvVideos($country_id,$category,$searchKey,$page);
	            $this->mem->set("livetv_videos_".$userId, $livetv_videos, 30*24*60*60);
				$this->mem->set("live_country_id_".$userId, $country_id, 30*24*60*60);
                $this->mem->set("live_cat_id_".$userId, $category, 30*24*60*60);
				User::where('rec_id',$userId)->update(['is_livetv_update_flag' => 0]);
			}

			if($livetv_videos["statusCode"]== 200 && $livetv_videos["status"] =="success"){
				if(!empty($livetv_videos["response"])){
					$data['livetv_videos'] = $livetv_videos["response"];
				}
			}

			if($livetv_categories["statusCode"]== 200 && $livetv_categories["status"] =="success"){
				if(!empty($livetv_categories["response"])){
					$el = $livetv_categories["response"][0]['data'];
				  	array_multisort(array_map(function($el ) {
						  return $el['title'];
					  }, $el), SORT_ASC, $el);
					$livetv_categories = $el;
				}
				$data['livetv_categories'] = $livetv_categories;
			}

			$data['total_records'] = @count($data['livetv_videos']);
			$data['page'] = ++$page;
			$country_name = '';

			$data['country_id'] = $country_id;
			$data['category'] = $category;
			//echo '<pre>';print_R($data);exit;
			$maintanance_settings=ApplicationSettings::where('setting_name','maintanance_settings')->first();
			$data['maintanance_mode']=array();
			if($maintanance_settings!==null){
				$data['maintanance_mode']=unserialize($maintanance_settings['setting_value']);
			}
			return view('customer/vplayed_v2/liveTvDashboard')->with($data);
			//return view('customer/vplayed/livetv-dashboard')->with($data);
		}else if( $isPackageBuyed == "package_expired"){
			$package_msg = "your purchased package expired.";
			return redirect('dashboard')->with('subscribed_message1',$package_msg);
		}else if($istakenFreeTrail == "expired"){
			$package_msg = "Your free trial has expired. Please subscribe to a package";
			return redirect('dashboard')->with('subscribed_message',$package_msg);
		}else if( $istakenFreeTrail == "adminApproved"){
			$trail_msg = "Your Free Trial Request is approved, Please click on Start Now button to start the streaming";
			return redirect('dashboard')->with('trail_msg',$trail_msg);
		}else{
			$package_msg = "You have not subscribed to any package";
			return redirect('dashboard')->with('subscribed_message',$package_msg);
		}
	}


	//get the live tv details
	public function livetvDetails(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];

		$isPermissionForLiveTV = self::isPermissionForLiveTV($userId, $userRole);
	    //if(!$isPermissionForLiveTV) { return redirect('dashboard'); }

		$category = '';$country_id = '';
		$page = $request->query('page');
		$country_id = $request->query('country_id');
		$country_id = (!empty($country_id) && $country_id != 0) ? $country_id : '';
		$category = $request->query('category');
		$category = (!empty($category) && $category != 0) ? $category : '';
		$searchKey = $request->query('search');
		$searchKey = (!empty($searchKey)) ? $searchKey : '';
		$data['searchKey'] = $searchKey;
		$istakenFreeTrail = VodController::getUserTakeTrailRequestStatus($userId);
		$isPackageBuyed = VodController::isPackagePurchasedOrNot($userId);
		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;

		$live_redirectURL = url('/').'/livetvDetails?page=1&country_id='.$country_id.'&category='.$category.'&search='.$searchKey;
		Session::put('live_redirectURL',$live_redirectURL);

		if( ($istakenFreeTrail == "trailgoingon") || ($isPackageBuyed == "package_goingon" ) && $isPermissionForLiveTV){
			if(!empty($page)){
				$page = $page;
			}else{
				$page = 1;
			}

			$data['livetv_videos'] = array();
			$data['livetv_categories'] = array();
			$is_livetv_update_flag = $userInfo['is_livetv_update_flag'];

			$livetv_videos = $this->mem->get("livetv_videos_".$userId);
			$live_country_id = $this->mem->get("live_country_id_".$userId);
            $live_cat_id = $this->mem->get("live_cat_id_".$userId);
			$livetv_categories = $this->mem->get("livetv_categories_".$userId);
	        $data['livetv_countries'] = $this->mem->get("livetv_countries_".$userId);

			if(empty($data['livetv_countries']) || $is_livetv_update_flag == 1){
				$data['livetv_countries'] =DB::connection('mysql2')->select('SELECT c.id as country_id,c.name as country_name,c.code,count(v.id) as counts FROM country_categories cc JOIN categories cat ON cc.category_id=cat .id JOIN videos v ON cc.video_id=v.id LEFT JOIN countries c ON cc.country_id= c.id where c.is_active = 1 and v.is_live = 1 and v.is_active = 1 and v.job_status="Complete" and v.is_archived = 0 and v.liveStatus != "complete" and cc.video_id != 0 group by c.id ORDER By c.name');
				$this->mem->set("livetv_countries_".$userId, $data['livetv_countries'], 30*24*60*60);
				User::where('rec_id',$userId)->update(['is_livetv_update_flag' => 0]);
			}

			if(empty($livetv_categories) || $is_livetv_update_flag == 1){
				$livetv_categories = VodCommon::getLivetvCategories('',1);
				$this->mem->set("livetv_categories_".$userId, $livetv_categories, 30*24*60*60);
				User::where('rec_id',$userId)->update(['is_livetv_update_flag' => 0]);
			}

	        if(!empty($searchKey)){
				$livetv_videos = VodCommon::getLivetvVideos($country_id,$category,$searchKey,$page);
				if($livetv_videos["statusCode"]== 200 && $livetv_videos["status"] =="success"){
					if(!empty($livetv_videos["response"])){
						$data['livetv_videos'] = $livetv_videos["response"];
					}
				}
			}else if(empty($livetv_videos) || ($live_country_id != $country_id) || ($live_cat_id != $category) || $is_livetv_update_flag == 1) {
	            $livetv_videos = VodCommon::getLivetvVideos($country_id,$category,$searchKey,$page);
	            $this->mem->set("livetv_videos_".$userId, $livetv_videos, 30*24*60*60);
                $this->mem->set("live_country_id_".$userId, $country_id, 30*24*60*60);
                $this->mem->set("live_cat_id_".$userId, $category, 30*24*60*60);
	            User::where('rec_id',$userId)->update(['is_livetv_update_flag' => 0]);
			}

			if($livetv_videos["statusCode"]== 200 && $livetv_videos["status"] =="success"){
				if(!empty($livetv_videos["response"])){
					$data['livetv_videos'] = $livetv_videos["response"];
				}
			}

			if($livetv_categories["statusCode"]== 200 && $livetv_categories["status"] =="success"){
				if(!empty($livetv_categories["response"])){
					$el = $livetv_categories["response"][0]['data'];
				  	array_multisort(array_map(function($el ) {
						  return $el['title'];
					  }, $el), SORT_ASC, $el);
					$livetv_categories = $el;
				}
				$data['livetv_categories'] = $livetv_categories;
			}

			$data['total_records'] = @count($data['livetv_videos']);
			$data['page'] = ++$page;
			$country_name = '';

			$data['country_id'] = $country_id;
			$data['category'] = $category;

			$maintanance_settings=ApplicationSettings::where('setting_name','maintanance_settings')->first();
			$data['maintanance_mode']=array();
			if($maintanance_settings!==null){
				$data['maintanance_mode']=unserialize($maintanance_settings['setting_value']);
			}
			return view('customer/vplayed_v2/liveTvDetails')->with($data);
			//return view('customer/vplayed/livetv-dashboard')->with($data);
		}else if( $isPackageBuyed == "package_expired"){
			$package_msg = "your purchased package expired.";
			return redirect('dashboard')->with('subscribed_message1',$package_msg);
		}else if($istakenFreeTrail == "expired"){
			$package_msg = "Your free trial has expired. Please subscribe to a package";
			return redirect('dashboard')->with('subscribed_message',$package_msg);
		}else if( $istakenFreeTrail == "adminApproved"){
			$trail_msg = "Your Free Trial Request is approved, Please click on Start Now button to start the streaming";
			return redirect('dashboard')->with('trail_msg',$trail_msg);
		}else{
			$package_msg = "You have not subscribed to any package";
			return redirect('dashboard')->with('subscribed_message',$package_msg);
		}	}



	//get the live tv list
	public function livetvChannelsLoadmore(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];

		$category = '';$country_id = '';

		$page = request('page');
		$country_id = request('country_id');
		$country_id = (!empty($country_id) && $country_id != 0) ? $country_id : '';
		$category = request('category');
		$category = (!empty($category) && $category != 0) ? $category : '';
		$searchKey = request('search');
		$searchKey = (!empty($searchKey)) ? $searchKey : '';
		$data['searchKey'] = $searchKey;

		$istakenFreeTrail = VodController::getUserTakeTrailRequestStatus($userId);
		$isPackageBuyed = VodController::isPackagePurchasedOrNot($userId);

		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;
		if( ($istakenFreeTrail == "trailgoingon") || ($isPackageBuyed == "package_goingon" )  && $isPermissionForLiveTV){

			if(!empty($page)){
				$page = $page;
			}else{
				$page = 1;
			}
			$data['livetv_videos'] = array();
			$is_livetv_update_flag = $userInfo['is_livetv_update_flag'];

	        $livetv_videos = $this->mem->get("livetv_videos_".$userId);
			$live_country_id = $this->mem->get("live_country_id_".$userId);
            $live_cat_id = $this->mem->get("live_cat_id_".$userId);
			$livetv_categories = $this->mem->get("livetv_categories_".$userId);
	        $data['livetv_countries'] = $this->mem->get("livetv_countries_".$userId);

			if(empty($data['livetv_countries']) || $is_livetv_update_flag == 1){
				$data['livetv_countries'] =DB::connection('mysql2')->select('SELECT c.id as country_id,c.name as country_name,c.code,count(v.id) as counts FROM country_categories cc JOIN categories cat ON cc.category_id=cat .id JOIN videos v ON cc.video_id=v.id LEFT JOIN countries c ON cc.country_id= c.id where c.is_active = 1 and v.is_live = 1 and v.is_active = 1 and v.job_status="Complete" and v.is_archived = 0 and v.liveStatus != "complete" and cc.video_id != 0 group by c.id ORDER By c.name');
				$this->mem->set("livetv_countries_".$userId, $data['livetv_countries'], 30*24*60*60);
				User::where('rec_id',$userId)->update(['is_livetv_update_flag' => 0]);
			}

			if(empty($livetv_categories) || $is_livetv_update_flag == 1){
				$livetv_categories = VodCommon::getLivetvCategories('',1);
				$this->mem->set("livetv_categories_".$userId, $livetv_categories, 30*24*60*60);
				User::where('rec_id',$userId)->update(['is_livetv_update_flag' => 0]);
			}

			if(!empty($searchKey)){
				$livetv_videos = VodCommon::getLivetvVideos($country_id,$category,$searchKey,$page);
			}else if(empty($livetv_videos) || ($live_category_id != $category) || $is_livetv_update_flag == 1) {
	            $livetv_videos = VodCommon::getLivetvVideos($country_id,$category,$searchKey,$page);
	            $this->mem->set("livetv_videos_".$userId, $livetv_videos, 30*24*60*60);
                $this->mem->set("live_country_id_".$userId, $country_id, 30*24*60*60);
                $this->mem->set("live_cat_id_".$userId, $category, 30*24*60*60);
	            User::where('rec_id',$userId)->update(['is_livetv_update_flag' => 0]);
			}

			if($livetv_videos["statusCode"]== 200 && $livetv_videos["status"] =="success"){
				if(!empty($livetv_videos["response"])){
					$data['livetv_videos'] = $livetv_videos["response"];
				}
			}

			$data['total_records'] = @count($data['livetv_videos']);
			$data['page'] = ++$page;
			$country_name = '';

			if($country_id!=''){
				if(!empty($data['livetv_countries'])){
					foreach($data['livetv_countries'] as $key => $value){
						if($value->country_id == $country_id){
							$country_name = $value->country_name;
							break;
						}
					}
				}
			}
			$data['country_id'] = $country_id;
			$data['country_name'] = $country_name;
			return view('customer/vplayed_v2/liveTvDashboard')->with($data);
		}else if( $isPackageBuyed == "package_expired"){
			$package_msg = "your purchased package expired.";
			return response()->json(['status' => 'Failure', 'result' => $html, 'message' => $package_msg,'page' => $page, 'class' => 'd-none'], 200);
		}else{
			$package_msg = "You have not subscribed to any package";
			return response()->json(['status' => 'Failure', 'result' => $html, 'message' => $package_msg, 'page' => $page, 'class' => 'd-none'], 200);
		}
	}

	//play the live tv channel
	public function livetvChannelView(Request $request)
	{

        // DB::delete('DELETE t FROM `epg_list` t INNER JOIN `epg_list` t2 WHERE t.rec_id < t2.rec_id AND t.start_timezone = t2.start_timezone AND t.xmltv_id = t2.xmltv_id AND t.country_id = t2.country_id');

		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];

		$isPermissionForLiveTV = self::isPermissionForLiveTV($userId, $userRole);

		//if(!$isPermissionForLiveTV) { return redirect('dashboard'); }

		$videoSlug = \Request::segment(2);
		$data['videoSlug'] = $videoSlug;
		$country_id = request('country_id');
		$country_id = (!empty($country_id) && $country_id != 0) ? $country_id : '';
		$category = $request->query('category');
		$category = (!empty($category) && $category != 0) ? $category : '';

		$data['category'] = $category;
		$istakenFreeTrail = VodController::getUserTakeTrailRequestStatus($userId);
		$isPackageBuyed = VodController::isPackagePurchasedOrNot($userId);

		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;


		if( ($istakenFreeTrail == "trailgoingon") || ($isPackageBuyed == "package_goingon" )  && $isPermissionForLiveTV){

			if(!empty($videoSlug)){
                $data['livetv_info'] = VodCommon::getLivetvView($videoSlug);
                $xmltv_id = $data['livetv_info']['response']['video_info']['xmltv_id'];
                $data['livetv_info']['response']['video_info']['hls_playlist_url'] = VodCommon::url_encryptor('decrypt', $data['livetv_info']['response']['video_info']['hls_playlist_url']);

                $country_id = $data['livetv_info']['country_id'];
				if($xmltv_id != '') {
                    $src_country = Countries::where(['id' => $country_id])->first();
					$src_country_code = $src_country->code;

		        	if(isset($_SESSION['country']) && $_SESSION['country'] != '') {
		        		$country = $_SESSION['country'];
		        	}else{
                        //$country = findLocationByIp();
                        $country = findTimeZoneByIp();
		        		$_SESSION['country'] = $country;
                    }

                    $expt_country_code = ($country != '') ? $country : 'Asia/Kolkata';

                    $currentDate = self::getCurrentDateByCountry($expt_country_code);
                    //DB::enableQueryLog();
                    $epg_data = EPG_list::where(['xmltv_id' => $xmltv_id,'country_id' => $country_id])->whereDate('start_timezone', '=', $currentDate)->orderBy('start_timezone', 'ASC')->get();
                    //$query = DB::getQueryLog();
                    //print_r($query);exit;
		        	$currentTime = self::getCurrentTimeByCountry($expt_country_code);
                    $data['epg_info'] = array();
                    //Log::info('ptime'.$currentTime);
		        	if(!empty($epg_data)) {
		        		foreach($epg_data as $list) {
                             $expt_start_time = self::adjustTime($list['stimezone'],$list['start_timezone'], $expt_country_code,2);
		        			 $expt_end_time = self::adjustTime($list['etimezone'], $list['end_timezone'],$expt_country_code,2);

		        			 $start_timezone = self::adjustTime($list['stimezone'],$list['start_timezone'], $expt_country_code,1);
		        			 $end_timezone = self::adjustTime($list['etimezone'],$list['end_timezone'],$expt_country_code,1);

		        			// $expt_start_time = self::get_country_time($list['start_timezone'],$src_country_code, $expt_country_code);
		        			// $expt_end_time = self::get_country_time($list['end_timezone'],$src_country_code, $expt_country_code);

		        			// $start_timezone = self::get_country_time2($list['start_timezone'],$src_country_code, $expt_country_code);
		        			// $end_timezone = self::get_country_time2($list['end_timezone'],$src_country_code, $expt_country_code);
                            //adjustTime($list['stimezone'],'2020-06-29 23:15:00',$destinationTimeZone);
                            //self::getAdjustedTime($date, $source, $destination){
                            // $expt_start_time = self::getAdjustedTime($list['start_timezone'],$src_country_code, $expt_country_code,2);
		        			// $expt_end_time = self::getAdjustedTime($list['end_timezone'],$src_country_code, $expt_country_code,2);

		        			// $start_timezone = self::getAdjustedTime($list['start_timezone'],$src_country_code, $expt_country_code,1);
		        			// $end_timezone = self::getAdjustedTime($list['end_timezone'],$src_country_code, $expt_country_code,1);

		        			$cur_time = strtotime($currentTime);
                            $start_time = strtotime($start_timezone);
							$end_time = strtotime($end_timezone);
                            //Log::info('st'.$start_time);
                            //Log::info('et'.$end_time);
		        			if($start_time == $cur_time || $start_time >= $cur_time || $end_time >= $cur_time) {

			        			$data['epg_info'][] = array(
				        			'rec_id' => $list['rec_id'],
				        			'title' => $list['title'],
				        			'desc' => $list['description'],
				        			'xmltv_id' => $list['xmltv_id'],
				        			'start' => $expt_start_time,
				        			'end' => $expt_end_time,
				        			'start_date' => $start_timezone,
				        			'end_date' => $end_timezone,
				        			'country_id' => $list['country_id']
				        		);
		        			}
						}
		        	}

				}else{
					$data['epg_info'] = array();
				}

			}else{
				$data['livetv_info'] = array();
				$data['epg_info'] = array();
			}
			$maintanance_settings=ApplicationSettings::where('setting_name','maintanance_settings')->first();
			$data['maintanance_mode']=array();
			if($maintanance_settings!==null){
				$data['maintanance_mode']=unserialize($maintanance_settings['setting_value']);
			}
            //echo '<pre>';print_r($data['epg_info']);exit;
			return view('customer/vplayed_v2/liveTvPlay')->with($data);
			//return view('customer/vplayed/livetv-play')->with($data);
		}else if( $isPackageBuyed == "package_expired"){
			$package_msg = "your purchased package expired.";
			return redirect('dashboard')->with('subscribed_message1',$package_msg);
		}else if( $istakenFreeTrail == "expired"){
			$package_msg = "Your free trial has expired. Please subscribe to a package";
			return redirect('dashboard')->with('subscribed_message',$package_msg);
		}else if( $istakenFreeTrail == "adminApproved"){
			$trail_msg = "Your Free Trial Request is approved, Please click on Start Now button to start the streaming";
			return redirect('dashboard')->with('trail_msg',$trail_msg);
		}else{
			$package_msg = "You have not subscribed to any package";
			return redirect('dashboard')->with('subscribed_message',$package_msg);
		}
	}



	public static function isPermissionForLiveTV($userId, $userRole){

		//check package purchased or not
	$userpackData = \App\Package_purchase_list::leftjoin('packages', 'package_purchased_list.package_id', '=', 'packages.id')->select('packages.id', 'package_purchased_list.expiry_date','package_purchased_list.active_package','packages.package_name','packages.setupbox_status','packages.vod_series_package')->where('package_purchased_list.user_id', $userId)->where('package_purchased_list.package_id','!=',11)->where('package_purchased_list.active_package','=',1)->orderBy('package_purchased_list.rec_id','DESC')->first();

	$trail_period_status = \App\Free_trail_requested_users::where(['user_id' => $userId, 'status' => 1])->count();

		if($trail_period_status > 0 && empty($userpackData)) {
			return true;
		}else{
			if(!empty($userpackData) && $userpackData->vod_series_package == 1){
				return false;
			}else if(empty($userpackData)){
				return false;
			}else{
				return true;
			}
		}

	}

	// public static function addMinutesToTime( $time, $plusMinutes) {
    //     if($plusMinutes > 0){
	//         $time = Carbon::createFromFormat('Y-m-d H:i:s', $time);
	//         $time->add(new DateInterval('PT'.((integer)$plusMinutes).'M'));
	//         $newTime = $time->format( 'Y-m-d H:i:s' );
	//         return $newTime;
    // 	}else{
	//         return date("Y-m-d H:i:s", strtotime($plusMinutes ." minutes", strtotime($time)));
	//    }
    // }

    // public static function get_offset($req){
    //     $timezone = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $req);
    //     if($timezone && is_array($timezone) && isset($timezone[0])) {
    //     	$timezone_id = $timezone[0];
    //     	$target_time_zone = new DateTimeZone($timezone_id);
    //     	$kolkata_date_time = new \DateTime('now', $target_time_zone);
	//         $offset = $kolkata_date_time->format('P');
	//         if(substr($offset, 0, 1) == '+'){
	//         	$type  =   "-";
	//        	}else{
	//             $type =   '+';
	//         }

	//         $a = explode(':', $offset);
	//         $min = (int) $a[0] * 60 + $a[1];
	//         return $type . $min;
    //     }else{
    //     	return 0;
    //     }
    // }

	// public static function get_country_time($source_date,$source_zone,$expected_zone){
	//     $offset = self::get_offset($source_zone);
	//     $adjustedTime = self::addMinutesToTime( $source_date, $offset);
	// 	$offset = self::get_offset($expected_zone);
	// 	$adjustedTime = self::addMinutesToTime( $adjustedTime, -$offset);
	// 	//return $adjustedTime;
	// 	$finaltime = date("H:i", strtotime($adjustedTime));
	// 	return $finaltime;
	// }

	// public static function get_country_time2($source_date,$source_zone,$expected_zone){
	//     $offset = self::get_offset($source_zone);
	//     $adjustedTime = self::addMinutesToTime( $source_date, $offset);
	// 	$offset = self::get_offset($expected_zone);
	// 	$adjustedTime = self::addMinutesToTime( $adjustedTime, -$offset);
	// 	return $adjustedTime;
	// }

	public static function getCurrentTimeByCountry($country_code){
		// $timezone = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code);
		// if($timezone && is_array($timezone) && isset($timezone[0])) {
		//     $timezone_id = $timezone[0];
		    $target_time_zone = new DateTimeZone($country_code);
		    $kolkata_date_time = new \DateTime('now', $target_time_zone);
		    $newTime = $kolkata_date_time->format( 'Y-m-d H:i:s' );
		    return $newTime;
		//}
    }


    public static function getCurrentDateByCountry($timezone_id){
		// $timezone = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code);
		// if($timezone && is_array($timezone) && isset($timezone[0])) {
		//     $timezone_id = $timezone[0];
		    $target_time_zone = new DateTimeZone($timezone_id);
		    $kolkata_date_time = new \DateTime('now', $target_time_zone);
		    $newTime = $kolkata_date_time->format( 'Y-m-d' );
		    return $newTime;
		//}
    }



    /*********New for time conversion**************/

    // public static function get_timezone_offset($remote_tz, $origin_tz = null) {
    //     if($origin_tz === null) {
    //         if(!is_string($origin_tz = date_default_timezone_get())) {
    //             return false; // A UTC timestamp was returned -- bail out!
    //         }
    //     }
    //     $origin_dtz = new DateTimeZone($origin_tz);
    //     $remote_dtz = new DateTimeZone($remote_tz);
    //     $origin_dt = new DateTime("now", $origin_dtz);
    //     $remote_dt = new DateTime("now", $remote_dtz);
    //     $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);
    //     return $offset/60;
    // }
    // public static function getTimeZone($country_code){
    //     $timezone = \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, $country_code);
    //     $target_time_zone = $timezone[0];
    //     return $target_time_zone;
    // }

    // public static function getAdjustedTime($date, $source, $destination,$flag){
    //     $source_zone = self::getTimeZone($source);
    //     $destination_zone = self::getTimeZone($destination);
    //     $offset_diff = self::get_timezone_offset($source_zone,$destination_zone);
    //     $adjustedTime = self::addMinutesToTime($date, $offset_diff);
	// 	if($flag == 1){
	// 		return $adjustedTime;
	// 	}else{
	// 		$finaltime = date("H:i", strtotime($adjustedTime));
	// 		return $finaltime;
	// 	}
    // }


    /*new code */


        // public static function getTimeZoneBasedOnOffset($offset){
        //     // Calculate seconds from offset
        //     list($hours, $minutes) = explode(':', $offset);
        //     $seconds = $hours * 60 * 60 + $minutes * 60;
        //     // Get timezone name from seconds
        //     $tz = timezone_name_from_abbr('', $seconds, 1);
        //     // Workaround for bug #44780
        //     if($tz === false) $tz = timezone_name_from_abbr('', $seconds, 0);
        //     // Set timezone
        //     date_default_timezone_set($tz);

        //     return $tz;
        // }

        // public static function getOffsetFromDate($date) {
        //     $tdate = explode(' ',$date);
        //     return $tdate[2];
        // }

        // public static function adjustTime($fulldate, $sdate, $destinationTimeZone,$flag) {
        //     $src_offset = self::getOffsetFromDate($fulldate);
        //     $sourceTimeZone = self::getTimeZoneBasedOnOffset($src_offset);
        //     date_default_timezone_set($sourceTimeZone);
        //     $datetime = new DateTime($sdate);
        //     $la_time = new DateTimeZone($destinationTimeZone);
        //     $datetime->setTimezone($la_time);
        //     $adjustedTime = $datetime->format('Y-m-d H:i:s');
        //     if($flag == 1){
        //         return $adjustedTime;
        //     }else{
        //         $finaltime = date("H:i", strtotime($adjustedTime));
        //         return $finaltime;
        //     }
        // }


        // $date = '2020-06-29 23:15:00 -03:00';
        // self::getOffsetFromDate($date);


        // $src_offset = getOffsetFromDate($date);
        // $sourceTimeZone = getTimeZoneBasedOnOffset($src_offset);
        // $destinationTimeZone = 'Asia/Kolkata';


        public static  function getTimeZoneBasedOnOffset($offset){
            // Calculate seconds from offset
            $tdate = explode(' ',$offset);
            return $tdate[2];
        }


// date_default_timezone_set('Asia/Kolkata');
// $datetime = new DateTime();
// $dt = $datetime->format('Y-m-d H:i:s');
// //$dt->add( new DateInterval( 'PT' . ( (integer) 150 ) . 'M' ) );
// ///$newTime = $dt->format( 'Y-m-d H:i:s' );
// //return $newTime;
// //echo date("Y-m-d H:i:s", strtotime(-150 ." minutes", strtotime($dt)));
// $date = '2020-06-29 23:15:00 +08:00';
// $src_offset = self::getTimeZoneBasedOnOffset($date);
// $src_offset = self::getOffsetInMinutes($src_offset);
        public static function getRemoteOffset($dst_timezone){
            $target_time_zone = new DateTimeZone($dst_timezone);
            $kolkata_date_time = new \DateTime('now', $target_time_zone);
            $dst_offset = $kolkata_date_time->format('P');
            $dst_offset = self::getOffsetInMinutes($dst_offset);
            return $dst_offset;
        }

    //echo getOffsetInMinutes('+05:30');
    public static function getOffsetInMinutes($offset){
        if(substr($offset, 0, 1) == '+'){
            $type  =   "+";
        }else{
            $type =   '-';
        }
        $offset = substr($offset, 1);
        $a = explode(':', $offset);
        $minutes = $a[0]*60+$a[1];
        return $type.$minutes;
    }
    public static function adjustTime($date, $st_date, $remote_timezone, $flag){
        $src_offset = self::getTimeZoneBasedOnOffset($date);
        $src_offset = self::getOffsetInMinutes($src_offset);
        $dst_offset = self::getRemoteOffset($remote_timezone);
        if($src_offset>$dst_offset){
        $diff = $src_offset-$dst_offset;
        $diff = -$diff;
        }else{
        $diff = -$src_offset+$dst_offset;
        }
        // date_default_timezone_set($remote_timezone);
        // $datetime = new DateTime();
        // $dt = $datetime->format('Y-m-d H:i:s');
        $adjustedTime = date("Y-m-d H:i:s", strtotime($diff ." minutes", strtotime($st_date)));
        if($flag == 1){
            return $adjustedTime;
        }else{
            $finaltime = date("H:i", strtotime($adjustedTime));
            return $finaltime;
        }
    }

}

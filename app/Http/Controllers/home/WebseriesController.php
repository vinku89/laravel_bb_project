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
use App\Http\Controllers\home\VodController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\API\UserController;
use Validator;
use Session;
use App\User;
use App\Country;
use App\Wallet;
use App\RolesPermissions;
use App\Left_menu;
use App\MobileLeftMenu;
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

class WebseriesController extends AppController {
	public function __construct()
    {
      $this->mem=Memcache::memcached();
    }

	//get the live tv list
	public function webseriesDashboard(Request $request)
	{

		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];
		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;

		$data['searchKey'] = $request->query('searchKey');
        $searchKey = $request->query('searchKey');
        $is_home = \Request::segment(2);
        $data['is_home'] = ($is_home) ? 1 : 0;

		$istakenFreeTrail = VodController::getUserTakeTrailRequestStatus($userId);
		$isPackageBuyed = VodController::isPackagePurchasedOrNot($userId);

		if( ($istakenFreeTrail == "trailgoingon") || ($isPackageBuyed == "package_goingon" ) ){
			$is_series_update_flag = $userInfo['is_series_update_flag'];
			$page=1;
			$data["webseries"] = $this->mem->get("webseries_".$userId);
			if(!empty($searchKey)) {
				$webseries = VodCommon::getWebSeriesList($page,$searchKey);
				if($webseries["statusCode"]== 200 && $webseries["status"] =="success"){
					if(!empty($webseries["response"])){
						$data['webseries'] = $webseries["response"];
					}
				}
			}else if(empty($data["webseries"]) || $is_series_update_flag == 1) {
	            $webseries = VodCommon::getWebSeriesList($page,$searchKey);
	            if($webseries["statusCode"]== 200 && $webseries["status"] =="success"){
					if(!empty($webseries["response"])){
						$data['webseries'] = $webseries["response"];
					}
				}
	            $this->mem->set("webseries_".$userId, $data['webseries'], 30*24*60*60);
	            User::where('rec_id',$userId)->update(['is_series_update_flag' => 0]);
            }
            //continue watch list
            $data['continue_watch_list'] = [];
            $continue_watch_list = VodCommon::getContinueWatchList($userId,1,$searchKey);
            if($continue_watch_list["statusCode"]== 200 && $continue_watch_list["status"] =="success"){
                if(!empty($continue_watch_list["response"][0])){
                    $data['continue_watch_list'] = $continue_watch_list["response"];
                }
            }
			$this->mem->set("series_page_".$userId, url('/').'/webseries', 30*24*60*60);
			//$data['continue_watch_list'] = array();
			$maintanance_settings=ApplicationSettings::where('setting_name','maintanance_settings')->first();
			$data['maintanance_mode']=array();
			if($maintanance_settings!==null){
				$data['maintanance_mode']=unserialize($maintanance_settings['setting_value']);
			}
			//return view('customer/vplayed/webseries-dashboard')->with($data);
			return view('customer/vplayed_v3/webseries-dashboard')->with($data);
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


	public function webseriesList(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];

		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;
		$page_no = $request->query('page');


		$data['searchKey'] = $request->query('searchKey');
		$searchKey = $request->query('searchKey');

		$istakenFreeTrail = VodController::getUserTakeTrailRequestStatus($userId);
		$isPackageBuyed = VodController::isPackagePurchasedOrNot($userId);
		if( ($istakenFreeTrail == "trailgoingon") || ($isPackageBuyed == "package_goingon" ) ){
			if(!empty($page_no)){
				$page=$page_no;
			}else{
				$page=1;
			}
			$data['page'] = $page;

			$webseries = VodCommon::getWebSeriesList($page,$searchKey);

			if($webseries["statusCode"]== 200 && $webseries["status"] =="success"){
				if(!empty($webseries["response"])){
					$data['webseries'] = $webseries["response"];
				}
            }
            //continue watch list
            $data['continue_watch_list'] = [];
            // if(!empty($searchKey)) {
            //     $continue_watch_list = VodCommon::getContinueWatchList($userId,1,$searchKey);
            //     if($continue_watch_list["statusCode"]== 200 && $continue_watch_list["status"] =="success"){
            //         if(!empty($continue_watch_list["response"][0])){
            //             $data['continue_watch_list'] = $continue_watch_list["response"];
            //         }
            //     }
            // }
			//echo '<pre>';print_r($data['webseries']);exit;

			$maintanance_settings=ApplicationSettings::where('setting_name','maintanance_settings')->first();
			$data['maintanance_mode']=array();
			if($maintanance_settings!==null){
				$data['maintanance_mode']=unserialize($maintanance_settings['setting_value']);
			}
			return view('customer/vplayed_v3/webseries-list')->with($data);
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


	public function webserieslistLoadMore(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];

		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;
		$page_no = request('page');

		$istakenFreeTrail = VodController::getUserTakeTrailRequestStatus($userId);
		$isPackageBuyed = VodController::isPackagePurchasedOrNot($userId);
		if( ($istakenFreeTrail == "trailgoingon") || ($isPackageBuyed == "package_goingon" ) ){

			if(!empty($page_no)){
				$page=$page_no;
			}else{
				$page=1;
			}

			$webseries = VodCommon::getWebSeriesList($page);
			$htmlText = '';
			//Log::info($webseries);
			if($webseries["statusCode"]== 200 && $webseries["status"] =="success"){
				$current_page = $webseries["response"]["web_series_detail"]["current_page"];
				$totalWebSeries = @count($webseries["response"]["web_series_detail"]["data"]);
				if(@count($webseries["response"]["web_series_detail"]["data"]) > 0){
					$episodes_data = $webseries["response"]["web_series_detail"]['episodes'];
					foreach($webseries["response"]["web_series_detail"]["data"] as $res){

						$webseries_title = $res['title'];
						$short_name = $res["slug"];
						if(!empty($res["thumbnail_image"])){
                            $substring = 'https://';
                            $thumbnail_img = $res["thumbnail_image"];
                            if(strpos($thumbnail_img, $substring) === false){
                                $url = url('/');
                                if($url == 'https://bestbox.net' || $url == 'https://bb3778.com/') {
									$urlpath = 'https://prodstore.bb3778.com/bestbox/';
								}else if($url == 'https://staging.bestbox.net' || $url == 'https://staging.bb3778.com/') {
									$urlpath = 'https://stgstore.bb3778.com/bestbox/';
								}else{
									$urlpath = 'https://stgstore.bb3778.com/bestbox/';
								}
                               $thumbnail_img = $urlpath.$thumbnail_img;
                            }
                        }else{
                            $thumbnail_img = url('/')."/public/vplayed/images/default-thumbnail.png";
                        }
                        $videoSrc = url('/').'/webseriesDetailsList/'.$res['slug'];

                        $episode = '0 Episode';
						if(!empty($episodes_data) && @count($episodes_data)){
							foreach($episodes_data as $key => $item) {
								if($item['slug'] == $res["slug"]) {
                                    $epi_count = $item['episode_count'];
                                    $episode = ($epi_count>1) ? $epi_count.' Episodes' : $epi_count.' Episode';
                                }
							}
                        }
						$htmlText .= '<li class="cards cards-portrait cards-portrait--grid cards-portrait--grid-large">';
                            $htmlText .= '<a class="all-ite d-block" href="'.$videoSrc.'">';
                                $htmlText .= '<img src="'.$thumbnail_img.'" alt="" class="title img-fluid"/>';
                            $htmlText .= '</a>';
                            $htmlText .= '<div class="text-white vodcat-title f12 pt-1">'.$webseries_title.'</div>';
                            $htmlText .= '<div class="text-white vodcat-title f11">'.$episode.'</div>';
                        $htmlText .= '</li>';

					}
					$data['page'] = $current_page+1;
					return response()->json(['status' => 'Success', 'result' => $htmlText, 'page' => $data['page'],'webSeriesCnt'=>$totalWebSeries], 200);

				}else{
					$htmlText .= '';
					$data['page'] = $current_page;
					return response()->json(['status' => 'Failure', 'result' => $htmlText, 'page' => $data['page'],'webSeriesCnt'=>0], 200);
				}

			}else{
				$htmlText .= '';

				return response()->json(['status' => 'Failure', 'result' => $htmlText, 'page' => 1], 200);

			}


			//return view('customer/vplayed/vod-nowonvplayedmore')->with($data);

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



	//get the live tv list
	public function webseriesDetailsList(Request $request)
	{

		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];
		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;

		$videoSlug = \Request::segment(2);
		$season_id = \Request::segment(3);

		$season_id = !(empty($season_id)) ? $season_id : 0;
		$data['video_slug'] = $videoSlug;
		$data['season_id'] = \Request::segment(3);
		$istakenFreeTrail = VodController::getUserTakeTrailRequestStatus($userId);
		$isPackageBuyed = VodController::isPackagePurchasedOrNot($userId);
		$data['season_title'] = 'Season1';

		if( ($istakenFreeTrail == "trailgoingon") || ($isPackageBuyed == "package_goingon" ) ){

			if(!empty($videoSlug)){
                $webseries = VodCommon::webseriesDetailsList($videoSlug, $season_id, $userId);
				if($webseries["statusCode"]== 200 && $webseries["status"] =="success"){
					if(!empty($webseries["response"])){
						$data['webseries'] = $webseries["response"];
					}
				}

			}else{
				$data['webseries'] = array();
            }
			//echo '<pre>';print_r($data['webseries']);exit;
			
			$maintanance_settings=ApplicationSettings::where('setting_name','maintanance_settings')->first();
			$data['maintanance_mode']=array();
			if($maintanance_settings!==null){
				$data['maintanance_mode']=unserialize($maintanance_settings['setting_value']);
			}
			//return view('customer/vplayed/webseries-details-list')->with($data);
			return view('customer/vplayed_v3/webseries-details-list')->with($data);
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

	//get the live tv list
	public function webseriesEpisodeView(Request $request)
	{

		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];
		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;
        $data['user_id'] = $userId;
        $videoSlug = \Request::segment(2);
        $is_home = \Request::segment(3);

		$istakenFreeTrail = VodController::getUserTakeTrailRequestStatus($userId);
		$isPackageBuyed = VodController::isPackagePurchasedOrNot($userId);

		if( ($istakenFreeTrail == "trailgoingon") || ($isPackageBuyed == "package_goingon" ) ){

			if(!empty($videoSlug)){
                $data['series_info'] = VodCommon::webseriesEpisodeView($videoSlug, $userId);
                $data['series_info']["response"]["videos"]['hls_playlist_url'] = VodCommon::url_encryptor('decrypt', $data['series_info']["response"]["videos"]['hls_playlist_url']);
            }else{
				$data['series_info'] = array();
            }
			$data['is_home'] = ($is_home) ? url('/').'/webseries/is_home' : url('/').'/webseries/is_home';//$_SERVER['HTTP_REFERER'];
			
			$maintanance_settings=ApplicationSettings::where('setting_name','maintanance_settings')->first();
			$data['maintanance_mode']=array();
			if($maintanance_settings!==null){
				$data['maintanance_mode']=unserialize($maintanance_settings['setting_value']);
			}
			//return view('customer/vplayed/webseries-play')->with($data);
			return view('customer/vplayed_v3/webseries-play')->with($data);
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




	//play the webseries
	public function webseriesPlay(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];

		$packagesInfo = Package_purchase_list::select('*')->where('user_id','=',$userId)->where('active_package','=',1)->orderBy("rec_id", "DESC")->first();
		if(!empty($packagesInfo)){
			$is_package_purchased = true;
			if($packagesInfo->expiry_date == NULL){
			   $is_package_purchased = true;
			}
			if($is_package_purchased){
				$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
				$data['userInfo'] = $userInfo;

				$data['vod_movies_info'] = VodCommon::getVodMoviesList();

				$page=1;
				$data['livetv_banners_info'] = VodCommon::getVodhomepageBanners($page);

				$data['livetv_categories'] = VodCommon::getVodhomepageCategoreis();

				//return view('customer/vplayed/webseries-play')->with($data);
				return view('customer/vplayed_v3/webseries-play')->with($data);
			}else{
				$data["package_msg"] = "Package not activated yet.Please visit after some time";
				return view('customer/vplayed/subscribedmodel')->with($data);
			}
		}else{
			$data["package_msg"] = "You have not subscribed to any package";
			return view('customer/vplayed/subscribedmodel')->with($data);
		}
	}
}

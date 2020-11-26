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
use DateTime;
use DateTimeZone;
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
use App\Free_trail_cms_accounts;
use App\Free_trail_requested_users;
use Memcached;
use App\Library\Memcache;
class VodController extends AppController
{
	public function __construct()
    {
      $this->mem=Memcache::memcached();
    }

	public static function getUserTakeTrailRequestStatus($user_id){

		$res = Free_trail_requested_users::where('user_id',"=",$user_id)->first();
		if(!empty($res)){
			$trail_status = $res->status;
			$current_date_time = date('Y-m-d H:i:s');
			$trail_end_time = $res->trail_end_time;
			if($trail_status == 0){
				$result = "raiseRequest";
			}else if($trail_status == 3){
				$result = "adminApproved";
			}else{
				if($trail_end_time != NULL){
					if($trail_end_time < $current_date_time){
						$result = "expired";
					}else{
						$result = "trailgoingon";
					}
				}else{
					$result = "customerNotStartNow";
				}
			}

		}else{
			$result = "nottaken";
		}

		return $result;
	}


	public static function isPackagePurchasedOrNot($userId){

		$packagesInfo = Package_purchase_list::select('*')->where('user_id','=',$userId)->where('active_package','=',1)->orderBy("rec_id", "DESC")->first();
		if(!empty($packagesInfo)){
			$expiry_date = $packagesInfo->expiry_date;
			if($packagesInfo->expiry_date == NULL){
			   $is_package_purchased = "no";
			}else{
				$is_package_purchased = "yes";
			}

			if($is_package_purchased == "yes"){
				if($expiry_date < NOW()){
					$package_msg = "package_expired";
					return $package_msg;
				}else{
					$package_msg = "package_goingon";
					return $package_msg;
				}
			}else{
				$package_msg = "package_not_activated";
				return $package_msg;
			}

		}else{
			$package_msg = "package_not_subscribed";
			return $package_msg;
		}
		return $package_msg;
	}

	//test player
	public function test_player(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];

		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;

		return view('customer/vplayed/vod-test-player')->with($data);

	}

	public function vodDashboard(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];

		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;

		$data['searchKey'] = $request->query('search');
        $searchKey = $request->query('search');

        $data['is_home'] = \Request::segment(2);
		$page = $request->query('page');
		$filterCatName = "movies";
		$data['filterCatName'] = $request->query('filterCatName');
		$filterCatName = $request->query('filterCatName');

		if(empty($filterCatName)) $filterCatName = "movies";

		$istakenFreeTrail = self::getUserTakeTrailRequestStatus($userId);
		$isPackageBuyed = self::isPackagePurchasedOrNot($userId);

		$vod_redirectURL = url('/').'/vod?type=category&category='.$filterCatName;
		Session::put('vod_redirectURL',$vod_redirectURL);

		if( ($istakenFreeTrail == "trailgoingon") || ($isPackageBuyed == "package_goingon" ) ){
			if(!empty($page)){
				$page = $page;
			}else{
				$page = 1;
			}
			$is_vod_update_flag = $userInfo['is_vod_update_flag'];
			$data['vod_categories'] = $this->mem->get("vod_categories_".$userId);
			$data["vod_latest_popular_category"] = $this->mem->get("vod_latest_popular_category_".$userId);
			$data["vod_category_wise"] = $this->mem->get("vod_category_wise_".$userId);
			if(!empty($searchKey)) {
				$vod_search = VodCommon::vodCategoryFilterSearch($filterCatName,$page,$searchKey);
				if($vod_search["statusCode"]== 200 && $vod_search["status"] =="success"){
					if(!empty($vod_search["response"]["main"])){
						$data['vod_search'] = $vod_search["response"];
					}
				}
			}else{
				if(empty($data["vod_latest_popular_category"]) || $is_vod_update_flag == 1){
                    $vod_latest_popular_category = VodCommon::vodCategoryFilterSearch($filterCatName,$page,$searchKey);

					if($vod_latest_popular_category["statusCode"]== 200 && $vod_latest_popular_category["status"] =="success")
					{
						if(!empty($vod_latest_popular_category["response"]["main"])){
							$data['vod_latest_popular_category'] = $vod_latest_popular_category["response"]["main"];
						}
					}
					$this->mem->set("vod_latest_popular_category_".$userId, $data["vod_latest_popular_category"], 30*24*60*60);
					User::where('rec_id',$userId)->update(['is_vod_update_flag' => 0]);
				}
				if(empty($data["vod_category_wise"]) || $is_vod_update_flag == 1){
					$vod_category_wise = VodCommon::vodCategoryWise($filterCatName,$page,$searchKey);
					if($vod_category_wise["statusCode"]== 200 && $vod_category_wise["status"] =="success"){
						if(!empty($vod_category_wise["response"])){
							$data['vod_category_wise'] = $vod_category_wise["response"];
						}
					}
					$this->mem->set("vod_category_wise_".$userId, $data["vod_category_wise"], 30*24*60*60);
					User::where('rec_id',$userId)->update(['is_vod_update_flag' => 0]);
                }

				if(empty($data["vod_categories"]) || $is_vod_update_flag == 1){
					$vod_categories = VodCommon::getLivetvCategories('',2);
					if($vod_categories["statusCode"]== 200 && $vod_categories["status"] =="success"){
						if(!empty($vod_categories["response"])){
							$data['vod_categories'] = $vod_categories["response"][0]['data'];
						}
					}
					$this->mem->set("vod_categories_".$userId, $data['vod_categories'], 30*24*60*60);
					User::where('rec_id',$userId)->update(['is_vod_update_flag' => 0]);
				}
			}
            //continue watch list
            $data['continue_watch_list'] = [];

            $continue_watch_list = VodCommon::getContinueWatchList($userId,0,$searchKey);
            if($continue_watch_list["statusCode"]== 200 && $continue_watch_list["status"] =="success"){
                if(!empty($continue_watch_list["response"][0])){
                    $data['continue_watch_list'] = $continue_watch_list["response"];
                }
			}
			$maintanance_settings=ApplicationSettings::where('setting_name','maintanance_settings')->first();
			$data['maintanance_mode']=array();
			if($maintanance_settings!==null){
				$data['maintanance_mode']=unserialize($maintanance_settings['setting_value']);
			}
			//return view('customer/vplayed/vod-dashboard')->with($data);
			return view('customer/vplayed_v3/vod-dashboard')->with($data);

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


	public function vodOnVplayedMore(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];

		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;
		$page_no = \Request::segment(2);

		$istakenFreeTrail = self::getUserTakeTrailRequestStatus($userId);
		$isPackageBuyed = self::isPackagePurchasedOrNot($userId);
		if( ($istakenFreeTrail == "trailgoingon") || ($isPackageBuyed == "package_goingon" ) ){

			if(!empty($page_no)){
				$page=$page_no;
			}else{
				$page=1;
			}

			$data['vod_banners_info'] = VodCommon::getVodhomepageBanners($page);

			//return view('customer/vplayed/vod-nowonvplayedmore')->with($data);
			return view('customer/vplayed_v2/vod-nowonvplayedmore')->with($data);
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


	public function vodOnVplayedShowMoreAjax(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];

		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;
		$page_no = request('page');

		$istakenFreeTrail = self::getUserTakeTrailRequestStatus($userId);
		$isPackageBuyed = self::isPackagePurchasedOrNot($userId);
		if( ($istakenFreeTrail == "trailgoingon") || ($isPackageBuyed == "package_goingon" ) ){

			if(!empty($page_no)){
				$page=$page_no;
			}else{
				$page=1;
			}

			$vod_banners_info = VodCommon::getVodhomepageBanners($page);
			$htmlText = '';
			if($vod_banners_info["statusCode"]== 200 && $vod_banners_info["status"] =="success"){
				$current_page = $vod_banners_info["response"]["new"]["current_page"];
				$totalCount = @count($vod_banners_info["response"]["new"]["data"]);
				if($totalCount > 0 ){
					foreach($vod_banners_info["response"]["new"]["data"] as $res){

						$short_name = $res["slug"];
						if(!empty($res["thumbnail_image"])){
							$thumbnail_img = $res["thumbnail_image"];
						}else{
							$thumbnail_img = url('/')."/public/vplayed/images/vod_thumbnail.png";
						}
						$videoSrc = url('/').'/vodDetailView/'.$res['slug'];

						$htmlText .= '<div class="movie_list_wrap_it">';
						$htmlText .='<a href="'.$videoSrc.'" class="movie_list_wrap_item">
										<img src="'.$thumbnail_img.'" class="img-fluid">
									</a>
									<div class="text-center movie_list_wrap_item_title">'.$res["title"].'</div>';
						$htmlText .= '</div>';


					}
					$data['page'] = $current_page+1;
					return response()->json(['status' => 'Success', 'result' => $htmlText, 'page' => $data['page']], 200);

				}else{
					$htmlText .= '';
					$data['page'] = $current_page;
					return response()->json(['status' => 'Failure', 'result' => $htmlText, 'page' => $data['page']], 200);
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




	public function vodMovieDetailsView(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];

		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;
        $videoSlug = \Request::segment(2);
        $is_contiuewatch = \Request::segment(3);

        $istakenFreeTrail = self::getUserTakeTrailRequestStatus($userId);
        $isPackageBuyed = self::isPackagePurchasedOrNot($userId);


		if( ($istakenFreeTrail == "trailgoingon") || ($isPackageBuyed == "package_goingon" ) ){

			if(!empty($videoSlug)){
                $data['vod_info'] = VodCommon::getVodDetailsView($videoSlug, $userId);

                $data['vod_info']["response"]["video_info"]['hls_playlist_url'] = VodCommon::url_encryptor('decrypt', $data['vod_info']["response"]["video_info"]['hls_playlist_url']);
            }else{
				$data['vod_info'] = array();
            }
            $data['is_home'] = ($is_contiuewatch) ? url('/').'/vod/is_home' : url('/').'/vod/is_home';//$_SERVER['HTTP_REFERER'];
            $data['user_id'] = $userId;
			$data['slug'] = $videoSlug;

			$maintanance_settings=ApplicationSettings::where('setting_name','maintanance_settings')->first();
			$data['maintanance_mode']=array();
			if($maintanance_settings!==null){
				$data['maintanance_mode']=unserialize($maintanance_settings['setting_value']);
			}
            //return view('customer/vplayed/vod-details')->with($data);
			return view('customer/vplayed_v3/vodplay')->with($data);

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

    public function getContinueWatchList(Request $request) {

        $userInfo = Auth::user();
        $userId = $userInfo['rec_id'];

        $is_series = request('is_series');
        $searchKey = request('search');
        $data['continue_watch_list'] = [];
        $html = '';
        $continue_watch_list = VodCommon::getContinueWatchList($userId,0,$searchKey);
        if($continue_watch_list["statusCode"]== 200 && $continue_watch_list["status"] =="success"){
            if(!empty($continue_watch_list["response"][0])){
                $continue_watch_list = $continue_watch_list["response"];

    $cj=1;
    if(!empty($continue_watch_list)){
        foreach($continue_watch_list as $res){
            $totalCount_movies = @count($res["data"]);
            $category_name = $res["title"];
            $category_slug = $res["slug"];
            $type = $category_slug;
            if($totalCount_movies){
                        $html .= '<div class="cont_watch_bg">';
                            $html .= '<div class="position-relative">';
                                $html .= '<div class="row">';
                                    $html .= '<div class="col-12">';
                                        $html .= '<div class="row-title d-inline-block pr-4" style="background-color: #000 !important;">';
                                        $html .= 'Continue Watching for '.$userInfo['first_name'].' '.$userInfo['last_name'] .'</div>';
                                    $html .= '</div>';
                                $html .=  '</div>';
                            $html .=   '</div>';
                            if(!empty($res["data"])){ $i=0;
                            $html .= '<div class="my-4 watch__list">';
                                $html .= '<ul class="owl-carousel carousel-main p-0 m-auto watchprog no-view-btn">';
                                    foreach($res["data"] as $item) {
                                        $title = $item["title"];
                                        $slug = $item["slug"];
                                        $percentage = $item['percentage'].'%';
                                        if($i == 20) continue;
                                        if(!empty($item["poster_image"])){
                                            $substring = 'https://';
                                            $thumbnail_img = $item["poster_image"];
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
                                            $thumbnail_img = url('/')."/public/vplayed/images/continue_watch_thumbnail.jpeg";
                                        }
                                        $play_btn_img = url('/')."/public/img/customer/play_btn_new.png";
                                        $url = url('/').'/vodDetailView/'.$slug.'/is_home';
                                    $html .= '<li class="text-center d-inline-block" style="height: 280px !important">';
                                        $html .= '<a class="carousel-tile d-block" href="'.$url.'" style="border-radius: 7px 7px 0 0 !important;">';
                                            $html .= '<img src="'.$thumbnail_img.'" alt="" class="title img-fluid"/>';
                                            $html .= '<div class="ply-btn"><img src="'.$play_btn_img.'" class="img-fluid"></div>';
                                        $html .= '</a>';
                                        $html .= '<div class="text-white py-3 movietitle_new">'.$title.'</div>';
                                        $html .= '<div class="progress-container">';
                                            $html .= "<div class='progress' style='width:'".$percentage."'></div>";
                                        $html .= '</div>';
                                    $html .= '</li>';
                                }
                            $html .= '</ul>';
                            $html .= '</div>';
                            $i++; }
                        $html .= '</div>';
                }
            }
    $cj++;}
            }
        }

        return response()->json(['status' => 'Success', 'result' => $html], 200);
    }

    public function updateDuration(Request $request) {
        //Log::info('started00');
        $userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
        $userRole = $userInfo['user_role'];

        $duration = request('current_time');
		$user_id = request('user_id');
        $video_slug = request('video_slug');
        $episode_title = request('episode_title');
        $is_series = request('is_series');
        $series_title= request('series_title');
        $episode_name= request('episode_name');

        $update = VodCommon::updateDuration($duration,$user_id,$video_slug,$episode_title,$is_series,$series_title, $episode_name);
        return response()->json(['status' => 'Success', 'result' => 'Success'], 200);
    }

	public function vodCategoryShowmore(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];

		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;

		$page = $request->query('page');
		$category = $request->query('category');
		$category = (!empty($category)) ? $category : '';
		$data['category'] = $category;

		$data['searchKey'] = $request->query('search');
		$searchKey = $request->query('search');

		$type = $request->query('type');
		$type = (!empty($type)) ? $type : 'category';
		$data['type'] = $type;

		$vod_redirectURL = url('/').'/vodCategory?type='.$type.'&category='.$category.'&search='.$searchKey;
		Session::put('vod_redirectURL',$vod_redirectURL);

		$istakenFreeTrail = self::getUserTakeTrailRequestStatus($userId);
		$isPackageBuyed = self::isPackagePurchasedOrNot($userId);

		if( ($istakenFreeTrail == "trailgoingon") || ($isPackageBuyed == "package_goingon" ) ){
			$data['vod_categories'] = $this->mem->get("vod_categories_".$userId);
			if(!empty($category)){
				if(!empty($page_no)){
					$page = $page_no;
				}else{
					$page = 1;
				}
				$is_vod_update_flag = $userInfo['is_vod_update_flag'];

				$cat_slug = $this->mem->get("cache_video_slug_".$userId);
				$data["vod_cat"] = $this->mem->get("vod_cat_".$userId);
				if(!empty($searchKey)) {
					if($type== 'new' || $type == 'popular') $category = 'movies';
					$vod_cat = VodCommon::vodCategoryShowmore($type,$category,$page,$searchKey);
					if($vod_cat["statusCode"]== 200 && $vod_cat["status"] =="success"){
						if(!empty($vod_cat["response"])){
							$data['vod_cat'] = $vod_cat["response"];
						}
					}
				}else if(empty($data["vod_cat"]) || ($cat_slug != $category)  || $is_vod_update_flag == 1) {
					if($type== 'new' || $type == 'popular') $category = 'movies';
					$vod_cat = VodCommon::vodCategoryShowmore($type,$category,$page,$searchKey);
					if($vod_cat["statusCode"]== 200 && $vod_cat["status"] =="success"){
						if(!empty($vod_cat["response"])){
							$data['vod_cat'] = $vod_cat["response"];
						}
					}

		            $this->mem->set("vod_cat_".$userId, $data["vod_cat"], 30*24*60*60);
		            $this->mem->set("cache_video_slug_".$userId, $category, 30*24*60*60);
		            User::where('rec_id',$userId)->update(['is_vod_update_flag' => 0]);
		        }
		        if(empty($data["vod_categories"]) || $is_vod_update_flag == 1){
					$vod_categories = VodCommon::getLivetvCategories('',2);
					if($vod_categories["statusCode"]== 200 && $vod_categories["status"] =="success"){
						if(!empty($vod_categories["response"])){
							$data['vod_categories'] = $vod_categories["response"][0]['data'];
						}
					}
					$this->mem->set("vod_categories_".$userId, $data['vod_categories'], 30*24*60*60);
					User::where('rec_id',$userId)->update(['is_vod_update_flag' => 0]);
				}

			}else{
				$data['vod_cat'] = array();
			}
			$maintanance_settings=ApplicationSettings::where('setting_name','maintanance_settings')->first();
			$data['maintanance_mode']=array();
			if($maintanance_settings!==null){
				$data['maintanance_mode']=unserialize($maintanance_settings['setting_value']);
			}
            //return view('customer/vplayed/vod-category-showmore')->with($data);
	        return view('customer/vplayed_v2/vod-category')->with($data);
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


	public function vodCategoryShowmoreAjax(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];

		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;
		$videoSlug = request('category'); //\Request::segment(2);
		$page_no = request('page'); //\Request::segment(3);
		$type = request('type');
		$search = request('search');

		$istakenFreeTrail = self::getUserTakeTrailRequestStatus($userId);
		$isPackageBuyed = self::isPackagePurchasedOrNot($userId);

		if( ($istakenFreeTrail == "trailgoingon") || ($isPackageBuyed == "package_goingon" ) ){

			if(!empty($videoSlug)){
				if(!empty($page_no)){
					$page = $page_no;
				}else{
					$page = 1;
				}
				if($type== 'new' || $type == 'popular') $videoSlug = 'movies';
				$vod_cat_more = VodCommon::vodCategoryShowmore($type, $videoSlug, $page, $search);
				$htmlText = '';
				if($vod_cat_more["statusCode"]== 200 && $vod_cat_more["status"] =="success"){
					//$cate_name = $vod_cat_more["response"]["more_category_videos"]["id"];
					$current_page = $vod_cat_more["response"]["more_category_videos"]["video_list"]["current_page"];
					$totalCount = @count($vod_cat_more["response"]["more_category_videos"]["video_list"]["data"]);
					$total_records = $vod_cat_more["response"]["more_category_videos"]["video_list"]['total'];
					$page = $vod_cat_more["response"]["more_category_videos"]["video_list"]['current_page'];
					$records = $vod_cat_more["response"]["more_category_videos"]["video_list"]['to'];
					$records = ($records == null) ? $total_records : $records;
					$show_more = ($records < $total_records) ? 'd-block': 'd-none';

					if($totalCount > 0){

						foreach($vod_cat_more["response"]["more_category_videos"]["video_list"]["data"] as $res){
							$title = $res["title"];
							if(!empty($res["thumbnail_image"])){
								$substring = 'https://';
								if(strpos($res["thumbnail_image"], $substring) === false){
								 	$url = url('/');
									if($url == 'https://bestbox.net') {
								 		$urlpath = 'https://prodstore.bestbox.net/bestbox/';
								 	}else if($url == 'https://staging.bestbox.net') {
								 		$urlpath = 'https://stgstore.bestbox.net/bestbox/';
								 	}else if($url == 'https://local.bestbox.net') {
								 		$urlpath = 'https://stgstore.bestbox.net/bestbox/';
								 	}else{
								 		$urlpath = '';
								 	}

								   $thumbnail_img = $urlpath.$res["thumbnail_image"];
								}else{
									$thumbnail_img = $res["thumbnail_image"];
								}

							}else{
								$thumbnail_img = url('/')."/public/vplayed/images/vod_thumbnail.png";
							}

							$videoSrc = url('/').'/vodDetailView/'.$res['slug'];

							// $htmlText .= '<li class="text-center col-6 col-md-4 col-lg-3 col-xl-2 mb-4 vodcat">';
		                    //     $htmlText .= '<a class="all-ite carousel-tile" href="'.$videoSrc.'">';
		                    //         $htmlText .= '<img src="'.$thumbnail_img.'" alt="" class="title img-fluid" />';
		                    //     $htmlText .= '</a>';
		                    //     $htmlText .= '<div class="text-white vodcat-title f12 pt-1">'.$title.'</div>';
							// $htmlText .= '</li>';

							$htmlText .= '<li class="vod-grid cards cards-portrait cards-portrait--grid cards-portrait--grid-large">';
		                        $htmlText .= '<a class="all-ite d-block" href="'.$videoSrc.'">';
		                            $htmlText .= '<img src="'.$thumbnail_img.'" alt="" class="title img-fluid" />';
		                        $htmlText .= '</a>';
		                        $htmlText .= '<div class="text-white vodcat-title f12 pt-1">'.$title.'</div>';
		                    $htmlText .= '</li>';
						}
						$data['page'] = $current_page+1;
						return response()->json(['status' => 'Success', 'result' => $htmlText, 'page' => $data['page'], 'class' => $show_more], 200);

					}else{
						$htmlText .= '';
						$data['page'] = $current_page;
						return response()->json(['status' => 'Failure', 'result' => $htmlText, 'page' => $data['page'], 'class' => 'd-none'], 200);
					}
				}else{
					$htmlText .= '';
					return response()->json(['status' => 'Failure', 'result' => $htmlText, 'page' => 1, 'class' => 'd-none'], 200);
				}


			}
			//return view('customer/vplayed/vod-category-showmore')->with($data);

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

	public static function convertTimezonePkgExpired($request_date){

		$timezone = Session::get('timezone');
		if($timezone) {
	        $tz = new DateTimeZone($timezone);
	    } else{
	    	$tz = new DateTimeZone('Atlantic/Reykjavik');
	    }

		$date = new DateTime($request_date);
		$date->setTimezone($tz);
		return $date->format('Y-m-d H:i:s');
	}
	public static function check_otp(Request $request){

		$otp_code = $request->query('otp_code') ;

		if($otp_code =='201901'){
			echo "success";
		}else{
			echo "fail";
		}
	}
}

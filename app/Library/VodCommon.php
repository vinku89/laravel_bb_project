<?php
namespace App\library;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use DB;
use App\FcmpushNotifications;
use App\User_requested_movies;
use App\User;
use App\ApplicationsInfo;
use App\UsersDevicesList;
class VodCommon{

	// get vod homepage movies
	public static function getVodMoviesList()
	{
		/*$postRequest = array(
			'firstFieldData' => 'foo',
			'secondFieldData' => 'bar'
		);*/

		$API_URL_lINK = config('constants.VOD_API_LINK');
		$API_URL = $API_URL_lINK."home_page";
		$cURLConnection = curl_init($API_URL);
		//curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);
		curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
						'x-request-type: web'
					));
		$apiResponse = curl_exec($cURLConnection);
		curl_close($cURLConnection);

		// $apiResponse - available data from the API request
		$jsonArrayResponse = json_decode($apiResponse,true);
		return $jsonArrayResponse;

	}

	public static function getVodhomepageBanners($page)
	{
		/*$postRequest = array(
			'page' => $page
		);*/

		$API_URL_lINK = config('constants.VOD_API_LINK');
		$API_URL = $API_URL_lINK."home_page_banner?page=".$page;
		$cURLConnection = curl_init($API_URL);

		//$cURLConnection = curl_init('https://vplayed-bestbox-uat.contus.us/api/v2/home_page_banner?page=1');
		//curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);
		curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
						'x-request-type: web'
					));
		$apiResponse = curl_exec($cURLConnection);
		curl_close($cURLConnection);

		// $apiResponse - available data from the API request
		$jsonArrayResponse = json_decode($apiResponse,true);
		return $jsonArrayResponse;

	}

	// VOD Search
	public static function getVodSearchMovies($searchKey)
	{
		/*$postRequest = array(
			'page' => $page
		);*/
		$search = str_replace(" ", '%20', $searchKey);
		$API_URL_lINK = config('constants.VOD_API_LINK');
		$API_URL = $API_URL_lINK."search/videos?q=".$search;
		$cURLConnection = curl_init($API_URL);
		curl_setopt($cURLConnection, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
						'x-request-type: web'
					));
		$apiResponse = curl_exec($cURLConnection);
		//echo $apiResponse;exit;
		curl_close($cURLConnection);

		// $apiResponse - available data from the API request
		$jsonArrayResponse = json_decode($apiResponse,true);
		//print_r($jsonArrayResponse);exit;
		return $jsonArrayResponse;

	}



	public static function getVodhomepageCategoreis()
	{
		/*$postRequest = array(
			'page' => $page
		);*/
		$API_URL_lINK = config('constants.VOD_API_LINK');
		$API_URL = $API_URL_lINK."category_list";
		$cURLConnection = curl_init($API_URL);
		//$cURLConnection = curl_init('https://vplayed-bestbox-uat.contus.us/api/v2/category_list');
		//curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);
		curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
						'x-request-type: web'
					));
		$apiResponse = curl_exec($cURLConnection);
		curl_close($cURLConnection);

		// $apiResponse - available data from the API request
		$jsonArrayResponse = json_decode($apiResponse,true);
		return $jsonArrayResponse;

	}

	public static function getVodDetailsView($slug, $user_id = 0)
	{
		$postRequest = array(
            'user_id' => $user_id,
            'is_newversion' => 1
		);
		$API_URL_lINK = config('constants.VOD_API_LINK');
		$API_URL = $API_URL_lINK."videos/".$slug;
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

		// $apiResponse - available data from the API request
		$jsonArrayResponse = json_decode($apiResponse,true);
		return $jsonArrayResponse;

	}

	// get category movies list
	public static function vodCategoryShowmore($type, $slug, $page, $search='')
	{

		$search = str_replace(" ",'%20', $search);
		if(empty($slug)) $slug = 'movies';
		$API_URL_lINK = config('constants.VOD_API_LINK');
		if($type == 'genre'){
			$API_URL = $API_URL_lINK."more_category_videos?type=".$type."&section=2&genre=".$slug."&page=".$page."&is_web_series=0&category=movies&search=".$search;
		}else if($type == 'category'){
			$API_URL = $API_URL_lINK."more_category_videos?type=".$type."&section=2&page=".$page."&is_web_series=0&category=".$slug."&search=".$search;
		}else if($type == 'popular'){
			$API_URL = $API_URL_lINK."more_category_videos?type=".$type."&section=1&page=".$page."&is_web_series=0&category=".$slug."&search=".$search;
		}else if($type == 'new'){
			$API_URL = $API_URL_lINK."more_category_videos?type=".$type."&section=1&page=".$page."&is_web_series=0&category=".$slug."&search=".$search;
		}

		$cURLConnection = curl_init($API_URL);

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


	// get category filter
	public static function vodCategoryFilterSearch($filterCatName,$page,$search='')
	{
		$search = str_replace(" ",'%20', $search);
		$API_URL_lINK = config('constants.VOD_API_LINK');
		$API_URL = $API_URL_lINK."home_category_videos?section=1&page=".$page."&is_web_series=0&category=".$filterCatName.'&search='.$search;

		$cURLConnection = curl_init($API_URL);
		//curl_setopt($cURLConnection, CURLOPT_POST, 1);
		//curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);
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

	// get category filter
	public static function vodCategoryWise($filterCatName,$page, $search ='')
	{

		/*$postRequest = array(
			'type' => 'new',
			'page' => $page,
			'is_web_series'=>0,
			'category'=>$slug
		);
		*/
		// https://stgapi.bestbox.net/api/v2/category_videos?section=1&page =1&is_web_series =0&category=1

		$API_URL_lINK = config('constants.VOD_API_LINK');
		$API_URL = $API_URL_lINK."home_category_videos?section=2&page=".$page."&is_web_series=0&category=".$filterCatName;
		//echo $API_URL;exit;
		$cURLConnection = curl_init($API_URL);
		//curl_setopt($cURLConnection, CURLOPT_POST, 1);
		//curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);
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
		//echo "<pre>";print_r($jsonArrayResponse);exit;
		return $jsonArrayResponse;

	}



	// Get Web series

	public static function getWebSeriesList($page,$searchKey="")
	{
		/*$postRequest = array(
			'page' => $page
		);*/
		$search = str_replace(" ",'%20', $searchKey);

		$API_URL_lINK = config('constants.VOD_API_LINK');
		if(!empty($search)){
			$API_URL = $API_URL_lINK."childWebseries/web-series/30/".$search;
		}else{
			$API_URL = $API_URL_lINK."childWebseriesMobile/web-series/30/".$search."?page=".$page;
		}

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

	// Get web series Details List

	public static function webseriesEpisodeView($videoSlug, $user_id = 0)
	{

		$API_URL_lINK = config('constants.VOD_API_LINK');
		$API_URL = $API_URL_lINK."watchvideo/".$videoSlug."/".$user_id."/1";
		$cURLConnection = curl_init($API_URL);

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


	// Get web series Details List

	public static function webseriesDetailsList($slug, $season_id = 0, $user_id)
	{
        $API_URL_lINK = config('constants.VOD_API_LINK');
		$API_URL = $API_URL_lINK."webseries/".$slug."/".$season_id."/".$user_id;
		$cURLConnection = curl_init($API_URL);
		curl_setopt($cURLConnection, CURLOPT_FOLLOWLOCATION, true);
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



	public static function getLivetvCountryList()
	{
		/*$postRequest = array(
			'page' => $page
		);*/

		$API_URL_lINK = config('constants.VOD_API_LINK');
		$API_URL = $API_URL_lINK."countries_list";
		$cURLConnection = curl_init($API_URL);
		curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
						'x-request-type: web'
					));
		$apiResponse = curl_exec($cURLConnection);
		curl_close($cURLConnection);

		// $apiResponse - available data from the API request
		$jsonArrayResponse = json_decode($apiResponse,true);
		//print_r($jsonArrayResponse);exit;
		return $jsonArrayResponse;

	}

	//get live tv category list

	public static function getLivetvCategories($country_id='', $is_live=1)
	{

		$API_URL_lINK = config('constants.VOD_API_LINK');
		$API_URL = $API_URL_lINK."getCategoriesCountryWise?country_id=".$country_id."&type=".$is_live;
		$cURLConnection = curl_init($API_URL);

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


	//get live tv channels

	public static function getLivetvVideos($country_id,$category,$search_key,$page)
	{
		$search = str_replace(" ",'%20', $search_key);

		$API_URL_lINK = config('constants.VOD_API_LINK');
		$API_URL = $API_URL_lINK."getCountryWisefilterTV?country_id=".$country_id."&category=".$category."&search=".$search."&page=".$page."&is_newversion=1&perpage=30&web=web";
		//echo $API_URL;exit;

		$cURLConnection = curl_init($API_URL);
		curl_setopt($cURLConnection, CURLOPT_FOLLOWLOCATION, true);
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
		//echo '<pre>';print_r($jsonArrayResponse);exit;
		return $jsonArrayResponse;

	}

	//play live channel

	public static function getLivetvView($slug)
	{
		/*$postRequest = array(
			'page' => $page
		);*/
		$API_URL_lINK = config('constants.VOD_API_LINK');
		$API_URL = $API_URL_lINK."liveVideoSlug/".$slug;
    	$cURLConnection = curl_init($API_URL);
		//curl_setopt($cURLConnection, CURLOPT_POST, 1);
		//curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);
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
		//echo '<prE>';print_r($jsonArrayResponse);exit;
		return $jsonArrayResponse;

    }



    //get continue watch list

    public static function getContinueWatchList($user_id,$is_series = 0, $search=''){
        $search = str_replace(" ",'%20', $search);
        $API_URL_lINK = config('constants.VOD_API_LINK');
		$API_URL = $API_URL_lINK."getContinuewatchList?user_id=".$user_id."&is_series=".$is_series."&search=".$search;
		$cURLConnection = curl_init($API_URL);
        //Log::info('url'.$API_URL);
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

    //update video Duration

    public static function updateDuration($duration, $user_id, $video_slug, $episode_title='',$is_series = 0, $series_title, $episode_name){
        $API_URL_lINK = config('constants.VOD_API_LINK');
		$API_URL = $API_URL_lINK."update_video_duration";

        $postRequest = array(
			'user_id' => $user_id,
			'duration' => $duration,
            'video_slug'=> $video_slug,
            'episode_title'=> $episode_title,
            'is_series' => $is_series,
            'series_title' => $series_title,
            'episode_name' => $episode_name
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

		// $apiResponse - available data from the API request
		$jsonArrayResponse = json_decode($apiResponse,true);

		return $jsonArrayResponse;
	}
	
	//get catchuplist
	
    public static function getCatchupChannelList(){
        
        $API_URL = 'https://info.m4g.app/catchup/get2.php?username=null&password=null&list=1&get_catchup';
		$cURLConnection = curl_init($API_URL);
        
		curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
			'Content-type: application/x-www-form-urlencoded'
					));
		$apiResponse = curl_exec($cURLConnection);
		curl_close($cURLConnection);

		// $apiResponse - available data from the API request
		$jsonArrayResponse = json_decode($apiResponse,true);

		return $jsonArrayResponse;
	}
	
	//get catchuplist
	
    public static function getCatchupChannelData($channnel){
        $channnel = str_replace(" ",'%20', $channnel);
        $API_URL = "https://info.m4g.app/catchup/get2.php?username=null&password=null&list=1&sublist=".$channnel."&hls=1&get_catchup";
		$cURLConnection = curl_init($API_URL);
        
		curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
			'Content-type: application/x-www-form-urlencoded'
					));
		$apiResponse = curl_exec($cURLConnection);
		curl_close($cURLConnection);

		// $apiResponse - available data from the API request
		$jsonArrayResponse = json_decode($apiResponse,true);

		return $jsonArrayResponse;
    }

    //encrypt hls video url
    public static function url_encryptor($action, $string) {
		$key = "BestBoxVplayed20";
        return openssl_decrypt(base64_decode($string), "aes-128-ecb", $key, OPENSSL_RAW_DATA);
        // $output = false;

        // $encrypt_method = "AES-256-CBC";
        // //pls set your unique hashing key
        // $secret_key = 'BestBOX_Vplayed';
        // $secret_iv = 'uandme';

        // // hash
        // $key = hash('sha256', $secret_key);

        // // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        // $iv = substr(hash('sha256', $secret_iv), 0, 16);

        // //do the encyption given text/string/number
        // if( $action == 'encrypt' ) {
        //     $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        //     $output = base64_encode($output);
        // }
        // else if( $action == 'decrypt' ){
        //   //decrypt the given text/string/number
        //     $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        // }

        // return $output;
	  }
	  
	public static function getBitpayToken()
	{
		$resourceUrl = 'https://test.bitpay.com/tokens';

		$postData = json_encode([
		   'id' => 'TfALHhgU5duM4PAtFWgNqNgYZkLhfwnf2Tj',
		   'facade' => 'merchant'
		]);
		
		$curlCli = curl_init($resourceUrl);
		
		curl_setopt($curlCli, CURLOPT_HTTPHEADER, [
		   'x-accept-version: 2.0.0',
		   'Content-Type: application/json'
		]);
		
		curl_setopt($curlCli, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($curlCli, CURLOPT_POSTFIELDS, stripslashes($postData));
		
		$result = curl_exec($curlCli);
		$resultData = json_decode($result, TRUE);
		curl_close($curlCli);
  
		// $apiResponse - available data from the API request
		$jsonArrayResponse = json_decode($apiResponse,true);
		return $jsonArrayResponse;
  
	}
}
?>

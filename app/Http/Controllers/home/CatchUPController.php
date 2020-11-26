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
//use Excel;

class CatchUPController extends AppController {
    public function __construct()
    {
      $this->mem=Memcache::memcached();
    }

    //get Catuplist

	public function getCatchupList(Request $request){
        $userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];
		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
        $data['userInfo'] = $userInfo;

        $istakenFreeTrail = VodController::getUserTakeTrailRequestStatus($userId);
		$isPackageBuyed = VodController::isPackagePurchasedOrNot($userId);

		if( ($istakenFreeTrail == "trailgoingon") || ($isPackageBuyed == "package_goingon" ) ){
            $data['channelData'] = array();
            $data['catchupChannelList'] = VodCommon::getCatchupChannelList();
            if(!empty($data['catchupChannelList']) && $data['catchupChannelList']['status'] == 'ok'){
                if(!empty($data['catchupChannelList']['result'])) {
                    $channel = $data['catchupChannelList']['result'][0];
                    $data['channelData'] = VodCommon::getCatchupChannelData($channel);
                }
            }
            
            //echo '<prE>';print_r($data['catchupChannelList']);exit;
            return view('customer/vplayed_v3/catchuplist')->with($data);
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

    //get Catuplist

	public function getAjaxchannelList(Request $request){
        $userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];
		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
        $data['userInfo'] = $userInfo;
        $channel_name = request('channel_name');
        $istakenFreeTrail = VodController::getUserTakeTrailRequestStatus($userId);
		$isPackageBuyed = VodController::isPackagePurchasedOrNot($userId);

		if( ($istakenFreeTrail == "trailgoingon") || ($isPackageBuyed == "package_goingon" ) ){
            $html = '';
            $catchupChannelList = VodCommon::getCatchupChannelList();
            if(!empty($catchupChannelList) && $catchupChannelList['status'] == 'ok'){
                if($channel_name == ''){
                    if(!empty($catchupChannelList['result'])) {
                        foreach($catchupChannelList['result'] as $channel) {
                            $html .= '<li channel_name="'.$channel.'">'.$channel.'</li>';
                        }
                    }
                }else{
                    if(!empty($catchupChannelList['result'])) {
                        foreach($catchupChannelList['result'] as $channel) {
                            $search_string = strtolower($channel_name);
                            $string = strtolower($channel);
                            if (strpos($string, $search_string) !== false) {
                                $html .= '<li channel_name="'.$channel.'">'.$channel.'</li>';
                            }
                        }
                    }else{
                        $html .= '<li channel_name="">No Channels Found<li>';
                    }
                }
            }
            if($html == ''){
                $html .= '<li channel_name="">No Channels Found<li>';
            }
            return response()->json(['status' => 'Success', 'result' => $html], 200);
            //return view('customer/vplayed_v3/catchuplist')->with($data);
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

    public function getCatchupChannelData(Request $request){
        $userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];
		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
        $data['userInfo'] = $userInfo;
        $channel = request('channel_name');
        $istakenFreeTrail = VodController::getUserTakeTrailRequestStatus($userId);
		$isPackageBuyed = VodController::isPackagePurchasedOrNot($userId);

		if( ($istakenFreeTrail == "trailgoingon") || ($isPackageBuyed == "package_goingon" ) ){
            
            $channelData = VodCommon::getCatchupChannelData($channel);
            $html = '';
            if(!empty($channelData)) {
                foreach($channelData['result'] as $key => $channel) {
                    $url = url('/').'/CatchupView/'.$channel['channel_name'].'/'.$channel['p2p_id'];
                    $url_image = url("/").'/public/images/play.png';

                    $html .='<a href="'.$url.'">';
                        $html .= '<div class="grid_row clearfix agent_row new_cell">';
                            $html .= '<div class="w15 float-left f14 px-2">';
                                $html .= date('d/m/Y', strtotime($channel['start']));
                            $html .= '</div>';
                            $html .= '<div class="w15 float-left f14 px-2">';
                            $html .= date('h:i A', strtotime($channel['start']));
                            $html .= '</div>';
                            $html .= '<div class="w60 float-left px-2 word-break-all">';
                                $html .= '<h5 class="f16">'.$channel["title"].'</h5>';
                                $html .= '<div class="f12">'.$channel["description"].'</div>';
                            $html .= '</div>';
                            $html .= '<div class="w10 float-left f14 green_txt text-right px-2">';
                                $html .= '<img src="'.$url_image.'" style="width: 30px; height: auto;">';
                            $html .= '</div>';
                        $html .= '</div>';
                    $html .='</a>';
                }
            }
            return response()->json(['status' => 'Success', 'result' => $html], 200);
            
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

    //catchup player view
    public function CatchupView(Request $request){
        $userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];
		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
        $data['userInfo'] = $userInfo;
        $channel = \Request::segment(2);
        $p2p_id = \Request::segment(3);
        if($channel == '' || $p2p_id == ''){
            return redirect('catupList'); 
        }
        $istakenFreeTrail = VodController::getUserTakeTrailRequestStatus($userId);
		$isPackageBuyed = VodController::isPackagePurchasedOrNot($userId);
		if(($istakenFreeTrail == "trailgoingon") || ($isPackageBuyed == "package_goingon" )){
            
            $data['channelDetails'] = array();
            $channelData = VodCommon::getCatchupChannelData($channel);
            if(!empty($channelData)) {
                foreach($channelData['result'] as $key => $channel) {
                    if($channel['p2p_id'] == $p2p_id) {
                        $data['channelDetails'] = $channel;
                        break;
                    }
                }
            }
            return view('customer/vplayed_v3/catchup-play')->with($data);
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
}
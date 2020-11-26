<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use DB;
use Session;
use App\Packages;
class WebsiteController extends Controller {

	public function index(){

        if(Session::has('lang')){
			$lang=Session::get('lang');
			if($lang=='english'){
				$data['lang']='english';
				return view('website/index')->with($data);
			}else if($lang=='danish'){
				$data['lang']='english';
				return view('website/index')->with($data);
			}else if($lang=='french'){
				$data['lang']='french';
				return view('website_french/index')->with($data);
			}else if($lang=='arabic'){
				$data['lang']='english';
				return view('website/index')->with($data);
			}
		}else{
			Session::forget('lang');
			$country= findLocationByIp();
			if($country=='DK' || $country=='FO' || $country=='GL'){
				//$data['lang']='danish';
				$data['lang']='english';
				\Session::put('lang',$data['lang']);
				return view('website/index')->with($data);
			}else if($country=='CA' || $country=='MG' || $country=='CM' || $country=='CI' || $country=='NE'|| $country=='BF' || $country=='ML' || $country=='SN' || $country=='TD' || $country=='GN' || $country=='RW' || $country=='BE' || $country=='BI' || $country=='BJ' || $country=='HT' || $country=='CH' || $country=='TG' || $country=='CF' || $country=='CG' || $country=='GA' || $country=='GQ' || $country=='DJ' || $country=='KM' || $country=='LU' || $country=='VU' || $country=='SC' || $country=='MC' ){
				$data['lang']='french';
				\Session::put('lang',$data['lang']);
				return view('website_french/index')->with($data);
			}else if($country=='DZ' || $country=='TD' || $country=='KM' || $country=='DJ' || $country=='EG'|| $country=='ER' || $country=='IQ' || $country=='JO' || $country=='KW' || $country=='LB' || $country=='LY' || $country=='MR' || $country=='MA' || $country=='OM' || $country=='PS' || $country=='QA' || $country=='SA' || $country=='SO' || $country=='SD' || $country=='SY' || $country=='TZ' || $country=='TN' || $country=='AE' || $country=='YE'){
				//$data['lang']='arabic';
				$data['lang']='english';
				\Session::put('lang',$data['lang']);
				return view('website/index')->with($data);
			}else{
				$data['lang']='english';
				\Session::put('lang',$data['lang']);
				return view('website/index')->with($data);
			}
		}


	}
	public function change_lang(Request $request){
		$lang=$request->lang;
		Session::forget('lang');
		\Session::put('lang',$lang);
		echo "1";
	}
	public function privacy_policy(){
		if(Session::has('lang')){
			$data['lang']=Session::get('lang');
		}else{
			$data['lang'] = 'english';
		}
		return view('website/privacy_policy')->with($data);
	}

	public function terms_of_use(){
		if(Session::has('lang')){
			$data['lang']=Session::get('lang');
		}else{
			$data['lang'] = 'english';
		}
		return view('website/terms_of_use')->with($data);
	}

	public function purchasing_terms(){
		if(Session::has('lang')){
			$data['lang']=Session::get('lang');
		}else{
			$data['lang'] = 'english';
		}
		return view('website/purchasing_terms')->with($data);
	}

	public function socialmedia(){
		return view('socialmedia');
	}

	public function downloadTvApp(){
		return view('downloadTvApp');
	}

	public function downloadVodrexApp(){
		return view('downloadVodrexApp');
	}

	public function iosApp(){
		return view('website/bestbox-ios');
	}

	public function downloadVodrexIOSApp(){
		return view('downloadVodrexIosApp');
	}

}

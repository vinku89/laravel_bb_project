<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use Validator;
use Session;
use App\User;
use App\Country;
use App\Wallet;
use App\RolesPermissions;
use App\Left_menu;
use App\MobileLeftMenu;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Packages;
use App\ApplicationsInfo;
class PackagesController extends Controller
{
	/**
     * api/packagesList
     * Get packages list
     * @bodyParam app_name string required
     * @bodyParam platform string required
	 * @response {"status":"Success","Result":[{"id":11,"package_name":"BestBOX","package_image":"box.png","subscription_fee":"0.00","setupbox_fee":"79.00","package_value":"79.00","discount":0,"discount_by_amt":0,"effective_amount":"79.00","description":"Includes pre-installed app + door to door delivery","status":1,"setupbox_status":"","duration":0},{"id":12,"package_name":"BestBOX + Subscription","package_image":"box.png","subscription_fee":"34.99","setupbox_fee":"65.00","package_value":"99.99","discount":0,"discount_by_amt":"0.00","effective_amount":"99.99","description":"include pre - installed app & 1 Month subscription + door to door delivery","status":1,"setupbox_status":"1","duration":0},{"id":13,"package_name":"Free Trail","package_image":"free_trial.png","subscription_fee":"0.00","setupbox_fee":"0.00","package_value":"0.00","discount":0,"discount_by_amt":0,"effective_amount":"0.00","description":"Trai Version","status":1,"setupbox_status":"","duration":0},{"id":14,"package_name":"BBox1","package_image":"1month_subscribe.jpg","subscription_fee":"34.99","setupbox_fee":0,"package_value":"34.99","discount":0,"discount_by_amt":0,"effective_amount":"34.99","description":"1 month Subscription","status":1,"setupbox_status":"2","duration":1}]}
 	 *
	 */
	public function getPackagesList(Request $request)
	{
		$userInfo = $request->user();
		$client_id = $userInfo['application_id'];
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
        $validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);
        }else{
        	//$packages=Packages::where("status",1)->get()->toArray();
			$new_version = $request->new_version;
			$application_id = "";$application_name="";$payformyfriend_black="";$payformyfriend_bvod_black="bvod_black.png";$payformyfriend_white="";$payformyfriend_bvod_white="bvod_white.png";
			if(!empty($client_id)){
				$info = ApplicationsInfo::where('application_id','=',$client_id)->first();
				if(!empty($info)){
					$application_id = $info->application_id;
					$application_name = $info->application_name;
					$payformyfriend_black = $info->payformyfriend_black;
					$payformyfriend_white = $info->payformyfriend_white;

				}
			}

			if($new_version!='' && $new_version == 1){
                $packages_bbox=Packages::where(["status" => 1, 'setupbox_status' =>2])->orderBy('package_order', 'ASC')->get();
                $packages_iptv=Packages::where(["status" => 1, 'setupbox_status' =>1])->orderBy('package_order', 'ASC')->get();
                $pkglist['packages']['title'] = 'BestBox Packages';
                if(@count($packages_bbox) >0){
                    foreach($packages_bbox as $pkg){
                        if($pkg->discount == NULL){
                            $discount = 0;
                        }else{
                            $discount = $pkg->discount;
                        }

                        if($pkg->discount_by_amt == NULL){
                            $discount_by_amt = 0;
                        }else{
                            $discount_by_amt = $pkg->discount_by_amt;
                        }

                        if($pkg->setupbox_fee == NULL){
                            $setupbox_fee = 0;
                        }else{
                            $setupbox_fee = $pkg->setupbox_fee;
                        }

                            //$package['data'][] = 'IPTV Box';
                            $pkglist['packages']['data'][] = array(
                                    "id"=>$pkg->id,
                                    "package_name"=>$pkg->package_name,
                                    "package_image"=>$pkg->package_image,
                                    "subscription_fee"=>$pkg->subscription_fee,
                                    "setupbox_fee"=>$setupbox_fee,
                                    "package_value"=>number_format($pkg->package_value,2),
                                    "discount"=>$discount,
                                    "discount_by_amt"=>$discount_by_amt,
                                    "effective_amount"=>number_format($pkg->effective_amount,2),
                                    "description"=>$pkg->description,
                                    "status"=>$pkg->status,
                                    "setupbox_status"=>$pkg->setupbox_status,
                                    'vod_series_package'=>$pkg->vod_series_package,
                                    "duration"=>$pkg->duration,
                                    "payformyfriend_black"=> ($pkg->vod_series_package==1) ? $payformyfriend_bvod_black : $payformyfriend_black,
                                    "payformyfriend_bvod_black"=>$payformyfriend_bvod_black,
                                    "payformyfriend_white"=> ($pkg->vod_series_package==1) ? $payformyfriend_bvod_white : $payformyfriend_white,
                                    "payformyfriend_bvod_white"=>$payformyfriend_bvod_white,
                                    'currency_symbol'=>'$',
                                    'currency_format'=>'USD'
                            );
                    }
                }

                $i = 2;
                $pkglist['iptv']['title'] = 'IPTV Box';
                if(@count($packages_iptv)>0){
                    foreach($packages_iptv as $pkg){
                        if($pkg->discount == NULL){
                            $discount = 0;
                        }else{
                            $discount = $pkg->discount;
                        }

                        if($pkg->discount_by_amt == NULL){
                            $discount_by_amt = 0;
                        }else{
                            $discount_by_amt = $pkg->discount_by_amt;
                        }

                        if($pkg->setupbox_fee == NULL){
                            $setupbox_fee = 0;
                        }else{
                            $setupbox_fee = $pkg->setupbox_fee;
                        }

                            $pkglist['iptv']['data'][] = array(
                                    "id"=>$pkg->id,
                                    "package_name"=>$pkg->package_name,
                                    "package_image"=>$pkg->package_image,
                                    "subscription_fee"=>$pkg->subscription_fee,
                                    "setupbox_fee"=>$setupbox_fee,
                                    "package_value"=>number_format($pkg->package_value,2),
                                    "discount"=>$discount,
                                    "discount_by_amt"=>$discount_by_amt,
                                    "effective_amount"=>number_format($pkg->effective_amount,2),
                                    "description"=>$pkg->description,
                                    "status"=>$pkg->status,
                                    "setupbox_status"=>$pkg->setupbox_status,
                                    'vod_series_package'=>$pkg->vod_series_package,
                                    "duration"=>$pkg->duration,
                                    "payformyfriend_black"=> ($pkg->vod_series_package==1) ? $payformyfriend_bvod_black : $payformyfriend_black,
                                    "payformyfriend_bvod_black"=>$payformyfriend_bvod_black,
                                    "payformyfriend_white"=> ($pkg->vod_series_package==1) ? $payformyfriend_bvod_white : $payformyfriend_white,
                                    "payformyfriend_bvod_white"=>$payformyfriend_bvod_white,
                                    'currency_symbol'=>'$',
                                    'currency_format'=>'USD'
                            );
                    }
                }
            }else{
                $packages=Packages::where("status",1)->orderBy('package_order', 'ASC')->get();
			    $pkglist = array();
                foreach($packages as $pkg){

                    if($pkg->discount == NULL){
                        $discount = 0;
                    }else{
                        $discount = $pkg->discount;
                    }

                    if($pkg->discount_by_amt == NULL){
                        $discount_by_amt = 0;
                    }else{
                        $discount_by_amt = $pkg->discount_by_amt;
                    }

                    if($pkg->setupbox_fee == NULL){
                        $setupbox_fee = 0;
                    }else{
                        $setupbox_fee = $pkg->setupbox_fee;
                    }

                    $pkglist[]= array(
                                "id"=>$pkg->id,
                                "package_name"=>$pkg->package_name,
                                "package_image"=>$pkg->package_image,
                                "subscription_fee"=>$pkg->subscription_fee,
                                "setupbox_fee"=>$setupbox_fee,
                                "package_value"=>number_format($pkg->package_value,2),
                                "discount"=>$discount,
                                "discount_by_amt"=>$discount_by_amt,
                                "effective_amount"=>number_format($pkg->effective_amount,2),
                                "description"=>$pkg->description,
                                "status"=>$pkg->status,
                                "setupbox_status"=>$pkg->setupbox_status,
                                'vod_series_package'=>$pkg->vod_series_package,
                                "duration"=>$pkg->duration,
                                "payformyfriend_black"=> ($pkg->vod_series_package==1) ? $payformyfriend_bvod_black : $payformyfriend_black,
                                "payformyfriend_bvod_black"=>$payformyfriend_bvod_black,
                                "payformyfriend_white"=> ($pkg->vod_series_package==1) ? $payformyfriend_bvod_white : $payformyfriend_white,
                                "payformyfriend_bvod_white"=>$payformyfriend_bvod_white,
                                'currency_symbol'=>'$',
                                'currency_format'=>'USD'
                                );
                }
            }
            if(@count($pkglist)>0){
                return response()->json(['status' => 'Success', 'Result' => $pkglist], 200);
            }else{
				return response()->json(['status' => 'Failure', 'Result' =>"No Packages Found"], 200);
			}
        }
    }
}

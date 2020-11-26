<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\API\UserController;
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
use App\Sales;
use App\Users_tree;
use Carbon\Carbon;
use App\Packages;
use App\Package_purchase_list;
use App\Commissions;

class ReferralController extends Controller
{
	public function getReferralsList(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];
		
		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;
		
		$referred_earnings = Commissions::where("user_id",$userInfo['rec_id'])->where("commission_type",'=','Referral Bonus')->sum('commission');
		$data["total_referred_earnings"] = number_format($referred_earnings,2);
		$data['total_referrals'] = Commissions::where("user_id",$userInfo['rec_id'])->where("commission_type",'=','Referral Bonus')->count();
		//$data['total_referrals'] = User::where(['users.referral_userid' => $userInfo['rec_id']])->count();
		
		$data['from_date'] = $request->query('from_date');	
		$data['to_date'] = $request->query('to_date');
		$data['searchKey'] = $request->query('searchKey');
		
		$searchKey = $request->query('searchKey');
		
		if (!empty($searchKey) && !empty($request->query('from_date')) && !empty($request->query('to_date'))) {
		
			$from_date = Carbon::createFromFormat('m-d-Y', $data['from_date'])->format('Y-m-d');
			$to_date = Carbon::createFromFormat('m-d-Y', $data['to_date'])->format('Y-m-d');
			$start = Carbon::parse($from_date)->format('Y-m-d H:i:s');
			$todate = Carbon::parse($to_date)->format('Y-m-d H:i:s');
			$to = date('Y-m-d H:i:s', strtotime($todate . ' +1 day'));
			
			$data["refferalsList"] = Commissions::leftjoin('users','commissions.sender_user_id','=','users.rec_id')->where('commissions.user_id',$userInfo['rec_id'])->where('commissions.commission_type','Referral Bonus')->whereBetween("commissions.added_date",[$start, $to])
			->where(function($query) use($searchKey) {
               			 return $query->where('users.refferallink_text','LIKE', '%' . $searchKey . '%')->orWhere('users.email', 'LIKE', '%' . $searchKey . '%');
            		})
			->select('users.rec_id','commissions.added_date','users.first_name','users.last_name','users.email','users.refferallink_text','commissions.commission')->orderBy("commissions.rec_id", "DESC")->paginate(20);
			
		}else if (!empty($request->query('from_date')) && !empty($request->query('to_date'))) {
			
			$from_date = Carbon::createFromFormat('m-d-Y', $data['from_date'])->format('Y-m-d');
			$to_date = Carbon::createFromFormat('m-d-Y', $data['to_date'])->format('Y-m-d');
			$start = Carbon::parse($from_date)->format('Y-m-d H:i:s');
			$todate = Carbon::parse($to_date)->format('Y-m-d H:i:s');
			$to = date('Y-m-d H:i:s', strtotime($todate . ' +1 day'));
			
									
			$data["refferalsList"] = Commissions::leftjoin('users','commissions.sender_user_id','=','users.rec_id')->where('commissions.user_id',$userInfo['rec_id'])->where('commissions.commission_type','Referral Bonus')->whereBetween("commissions.added_date",[$start, $to])->select('users.rec_id','commissions.added_date','users.first_name','users.last_name','users.email','users.refferallink_text','commissions.commission')->orderBy("commissions.rec_id", "DESC")->paginate(20);
			
		}else if(!empty($searchKey)){
				
			$data["refferalsList"] = Commissions::leftjoin('users','commissions.sender_user_id','=','users.rec_id')->where('commissions.user_id',$userInfo['rec_id'])->where('commissions.commission_type','Referral Bonus')
			->where(function($query) use($searchKey) {
           			 return $query->where('users.refferallink_text','LIKE', '%' . $searchKey . '%')->orWhere('users.email', 'LIKE', '%' . $searchKey . '%');
        		})
			->select('users.rec_id','commissions.added_date','users.first_name','users.last_name','users.email','users.refferallink_text','commissions.commission')->orderBy("commissions.rec_id", "DESC")->paginate(20);
			
			
		}else{

			$data["refferalsList"] = Commissions::leftjoin('users','commissions.sender_user_id','=','users.rec_id')->where('commissions.user_id',$userInfo['rec_id'])->where('commissions.commission_type','Referral Bonus')->select('users.rec_id','commissions.added_date','users.first_name','users.last_name','users.email','users.refferallink_text','commissions.commission')->orderBy("commissions.rec_id", "DESC")->paginate(20);
			
		}
		
		
		//return view('customer/customer-referral-dashboard')->with($data);
		return view('customer/version2/customer-referral-dashboard')->with($data);
	}
	
	// Customer Transactions list
	
	public function getCustomerTransactionsList(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];
		
		$data['wallet_balance'] = Wallet::where('user_id', $userId)->first();
		$data['userInfo'] = $userInfo;
		
		
		
		return view('customer/customer-transactions')->with($data);
	
		
	}
	
	
	
}
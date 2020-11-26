<?php

namespace App\Http\Controllers\API;

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
class DirectSalesController extends Controller
{
	public function getDirectSalesList(Request $request)
	{
		$userInfo = $request->user();
		//print_r($data);exit;
        
		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
        $validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
            'page' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);            
        }else{
			$limit = 20;
			$page = request('page');
			
			$from_date = request('from_date');
			$to_date = request('to_date');
			$commission_per = request('commission_per');
			$filter_type = request('filter_type');
			$searchKey = request('searchKey');
			
			if (!empty($from_date) && !empty($to_date)) {
				
				$start = Carbon::parse($from_date)->format('Y-m-d H:i:s');
				$todate = Carbon::parse($to_date)->format('Y-m-d H:i:s');
				//$to = date('Y-m-d H:i:s', strtotime($todate . ' +1 day'));

				$directSalesList = Sales::where('user_id',$userInfo['rec_id'])->whereBetween('added_date', [$start, $todate])->orderBy("rec_id", "DESC")->skip($page * $limit)->take($limit)->get(); 
				
			}/*else if (!empty($commission_per) ) {
				$directSalesList = Sales::where('user_id',$userInfo['rec_id'])->where('commission_per','=',$commission_per)->orderBy("rec_id", "DESC")->skip($page * $limit)->take($limit)->get(); 
				
			}*/else if (!empty($filter_type) ) {
				if($filter_type == "sales" && $searchKey == "low"){
					$directSalesList = Sales::where('user_id',$userInfo['rec_id'])->orderBy("sales_amount", "ASC")->skip($page * $limit)->take($limit)->get();
				}else if($filter_type == "sales" && $searchKey == "high"){
					$directSalesList = Sales::where('user_id',$userInfo['rec_id'])->orderBy("sales_amount", "DESC")->skip($page * $limit)->take($limit)->get();
				}else if($filter_type == "commission" && $searchKey == "low"){
					$directSalesList = Sales::where('user_id',$userInfo['rec_id'])->orderBy("commission", "ASC")->skip($page * $limit)->take($limit)->get();
				}else if($filter_type == "commission" && $searchKey == "high"){
					$directSalesList = Sales::where('user_id',$userInfo['rec_id'])->orderBy("commission", "DESC")->skip($page * $limit)->take($limit)->get();
				}else{
					$directSalesList = array();
				}
				
				
			}else{
				$directSalesList = Sales::where('user_id',$userInfo['rec_id'])->orderBy("rec_id", "DESC")->skip($page * $limit)->take($limit)->get();
			}
			
			$total_sales_amount = 0;
			$total_commision_amount = 0;
			if(@count($directSalesList)>0){
				$directSales = array();
				
				foreach($directSalesList as $res){
					$added_date = UserController::convertDateToUTCForAPI($res['added_date']); //date("d/m/Y, h:i a", strtotime($res['added_date']));
					$total_sales_amount += $res['sales_amount'];
					$total_commision_amount += $res['commission'];
					$directSales[] = array(
									"rec_id"=>$res['rec_id'],
									"date"=>$added_date,
									"description"=>$res['description'],
									"sale_amount"=>number_format($res['sales_amount'],2),
									"commission"=>$res['commission_per'],
									"commission_symbol"=>"%",
									"commission_amount"=>number_format($res['commission'],2),
									'currency_symbol'=>'$',
									'currency_format'=>'USD'
									);
					
				}
				return response()->json(['status' => 'Success','total_sales_amount'=>number_format($total_sales_amount,2),'total_commision_amount'=>number_format($total_commision_amount,2), 'Result' => $directSales], 200);
			}else{
				return response()->json(['status'=>'Failure','total_sales_amount'=>number_format($total_sales_amount,2),'total_commision_amount'=>number_format($total_commision_amount,2),'Result'=>"No Records Found" ], 200);
			}
		
		}
	
		
	}
	

	
	
	
}
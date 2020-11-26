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
use App\Sales;
use App\Users_tree;
use App\Commissions;
use Carbon\Carbon;
use App\Unilevel_tree;
class CommissionReportController extends Controller
{
	
	// commission report list
	public function getCommissionReport(Request $request)
	{
		$userInfo = $request->user();
		$userId = $userInfo['rec_id'];
		$user_role = $userInfo['user_role'];
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
			$searchKey = request('searchKey');
			
			if($user_role == 1){
				
				if (!empty($searchKey)){

					$commissionReports = Commissions::join('users','commissions.user_id', '=','users.rec_id')
									->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','users.image', 'users.rec_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
									->where(['users.user_id' => $searchKey])
									->where('commissions.user_id','!=',1000)
									->groupBy('commissions.user_id')
									->orderBy('commissions.rec_id','DESC')
									->paginate(25);
					
				}else{
					$loginUserCommissionReports = array();

					$commissionReports = Commissions::join('users','commissions.user_id', '=','users.rec_id')
									->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','users.image', 'users.rec_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
									//->where(['users.user_role' => 2])
									->where('commissions.user_id','!=',1000)
									->groupBy('commissions.user_id')
									->orderBy('commissions.rec_id','DESC')
									->skip($page * $limit)->take($limit)->get();
				}
				
			}else if($user_role == 2){
				 
				if (!empty($searchKey)){
						
						$loginUserCommissionReports = Commissions::join('users','commissions.user_id', '=','users.rec_id')
							->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','users.image','commissions.user_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
							->where('commissions.agent_id','=',0)
							->where(['commissions.user_id' => $userId, 'users.user_id' => $searchKey])
							//->where(['commissions.user_id' => $userId])
							//->where(DB::raw('concat(users.first_name," ",users.last_name)'), 'LIKE', '%' . $searchKey . '%')
							->get();
							
						$commissionReports = Commissions::join('users','commissions.agent_id', '=','users.rec_id')
									->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','users.image','commissions.user_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
									->where(['commissions.user_id' => $userId, 'users.user_id' => $searchKey])
									->where('commissions.agent_id','!=',0)
									->groupBy('commissions.agent_id')
									->orderBy('commissions.rec_id','DESC')
									->skip($page * $limit)->take($limit)->get();	
				}else{
				
					$loginUserCommissionReports = Commissions::join('users','commissions.user_id', '=','users.rec_id')
					->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','users.image','commissions.user_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
					->where('commissions.agent_id','=',0)
					->where(['commissions.user_id' => $userId])->get();
					// echo "<pre>";
					// print_r($data['loginUserCommissionReports']);exit();
					$commissionReports = Commissions::join('users','commissions.agent_id', '=','users.rec_id')
					->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','users.image','commissions.user_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
					->where(['commissions.user_id' => $userId])
					->where('commissions.agent_id','!=',0)
					->groupBy('commissions.agent_id')
					->orderBy('commissions.rec_id','DESC')
					->skip($page * $limit)->take($limit)->get();
				} 
				 
				 
				 				
			}else if($user_role == 3){
				
				if (!empty($searchKey)){
				
					$loginUserCommissionReports = Commissions::join('users','commissions.user_id', '=','users.rec_id')
					->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','users.image','commissions.user_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
					->where('commissions.agent_id','=',0)
					->where(['commissions.user_id' => $userId, 'users.user_id' => $searchKey])->get();
					
					
					$commissionReports = Unilevel_tree::join('commissions','unilevel_tree.down_id', '=','commissions.agent_id')
									->join('users','commissions.agent_id', '=','users.rec_id')
									->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','users.image','commissions.user_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
									->where(['unilevel_tree.upliner_id' => $userId, 'commissions.user_id' => $userId, 'unilevel_tree.user_role' => 3, 'users.user_id' => $searchKey])
									->groupBy('commissions.agent_id')
									->orderBy('commissions.rec_id','DESC')
									->skip($page * $limit)->take($limit)->get();
				}else{
					$loginUserCommissionReports = Commissions::join('users','commissions.user_id', '=','users.rec_id')
					->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','users.image','commissions.user_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
					->where('commissions.agent_id','=',0)
					->where(['commissions.user_id' => $userId])->get();

					$commissionReports = Unilevel_tree::join('commissions','unilevel_tree.down_id', '=','commissions.agent_id')
									->join('users','commissions.agent_id', '=','users.rec_id')
									->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','users.image','commissions.user_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
									->where(['unilevel_tree.upliner_id' => $userId, 'commissions.user_id' => $userId, 'unilevel_tree.user_role' => 3])
									->groupBy('commissions.agent_id')
									->orderBy('commissions.rec_id','DESC')
									->skip($page * $limit)->take($limit)->get();
				}
								
				
			}else{
				
				if (!empty($searchKey)){
					$commissionReports = Commissions::join('users','commissions.user_id', '=','users.rec_id')
									->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','users.image','commissions.agent_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
									->where(['commissions.user_id' => $userId, 'users.user_id' => $searchKey])
									->where('commissions.sender_user_id', '!=' , 0)
									->groupBy('commissions.sender_user_id')
									->orderBy('commissions.rec_id','DESC')
									->skip($page * $limit)->take($limit)->get();
				}else{
					$commissionReports = Commissions::join('users','commissions.user_id', '=','users.rec_id')
									->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role','users.image','commissions.agent_id as referenceId', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
									->where(['commissions.user_id' => $userId])
									->where('commissions.sender_user_id', '!=' , 0)
									->groupBy('commissions.sender_user_id')
									->orderBy('commissions.rec_id','DESC')
									->skip($page * $limit)->take($limit)->get();
				}
				
			}
			
			
			
			$total_sales_amount = 0;
			$total_commision_amount = 0;
			if( (@count($commissionReports)>0 ) || (@count($loginUserCommissionReports)>0 ) ) {
				$comm_report = array();
				foreach($loginUserCommissionReports as $res){
					$rec_id = 	$res->rec_id;
					if(!empty($rec_id)){
						$userFullName = $res->first_name." ".$res->last_name;
						$user_id = $res->user_id;
						$userAgentId = $res->referenceId;
						$profileImage = $res->image;
						if(!empty($profileImage)){
							$profile_pic = 	$profileImage;
						}else{
							$profile_pic = "";
						}	
							
						//$added_date = date("d/m/Y, h:i a", strtotime($res['added_date']));
						$total_sales_amount += $res->sales_amount;
						$total_commision_amount += $res->commission;
						$comm_report[] = array(
										"rec_id"=>$rec_id,
										"user_id"=>$user_id,
										"full_name"=>$userFullName,
										"profile_pic"=>$profile_pic,
										"agent_id"=>$userAgentId,
										"sale_amount"=>number_format($res->sales_amount,2),
										"commission_amount"=>number_format($res->commission,2),
										'currency_symbol'=>'$',
										'currency_format'=>'USD'
										);
					}				
					
					
				}
				foreach($commissionReports as $res){
					$rec_id = 	$res->rec_id;
					$user_id = $res->user_id;
					$userFullName = $res->first_name." ".$res->last_name;
					$userAgentId = $res->referenceId;
					$profileImage = $res->image;
					if(!empty($profileImage)){
						$profile_pic = 	$profileImage;
					}else{
						$profile_pic = "";
					}	
						
					//$added_date = date("d/m/Y, h:i a", strtotime($res['added_date']));
					$total_sales_amount += $res->sales_amount;
					$total_commision_amount += $res->commission;
					$comm_report[] = array(
									"rec_id"=>$rec_id,
									"user_id"=>$user_id,
									"full_name"=>$userFullName,
									"profile_pic"=>$profile_pic,
									"agent_id"=>$userAgentId,
									"sale_amount"=>number_format($res->sales_amount,2),
									"commission_amount"=>number_format($res->commission,2),
									'currency_symbol'=>'$',
									'currency_format'=>'USD'
									);
					
					
				}
				return response()->json(['status' => 'Success','total_sales_amount'=>number_format($total_sales_amount,2),'total_commision_amount'=>number_format($total_commision_amount,2), 'Result' => $comm_report], 200);
			}else{
				return response()->json(['status'=>'Failure','total_sales_amount'=>number_format($total_sales_amount,2),'total_commision_amount'=>number_format($total_commision_amount,2),'Result'=>"No Records Found" ], 200);
			}
		
		}
	
		
	}
	
	
	// commission report detail view
	public function getCommissionDetailview(Request $request)
	{
		
		$userInfo = $request->user();
		$user_id = $userInfo['rec_id'];
		$user_role = $userInfo['user_role'];
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
			'rec_id' => 'required',
			'agent_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'Failure','Result'=>$validator->errors()], 200);            
        }else{
			$limit = 20;
			$page = request('page');
			$userId = request('rec_id');
			$referenceId =  request('agent_id'); 
			$from_date = request('from_date');
			$to_date = request('to_date');
			$commission_per = request('commission_per');
			
			if($userInfo['user_role'] == 1){
				//DB::enableQueryLog();
				
				$userData = Commissions::join('users','commissions.user_id', '=','users.rec_id')
									->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name',DB::raw('SUM(sales_amount) as sales_amount'), DB::raw('SUM(commission) as commission'))
									//->where(['users.user_role' => 2])
									->where('commissions.user_id','=',$userId)
									->groupBy('commissions.user_id')
									->first();

				if (!empty($from_date) && !empty($to_date)) {
					$start = Carbon::parse($from_date)->format('Y-m-d H:i:s');
					$todate = Carbon::parse($to_date)->format('Y-m-d H:i:s');
					$to = date('Y-m-d H:i:s', strtotime($todate . ' +1 day'));

					$commissionReports = Commissions::join('users','commissions.user_id', '=','users.rec_id')
									->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount','commissions.commission_perc', 'commissions.commission','commissions.description','commissions.added_date')
									->where(['commissions.user_id' => $userId])
									->whereBetween('commissions.added_date',[$start, $to])
									->orderBy('commissions.rec_id','DESC')
									->skip($page * $limit)->take($limit)->get();
				}else{
					$commissionReports = Commissions::join('users','commissions.user_id', '=','users.rec_id')
									->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount','commissions.commission_perc', 'commissions.commission','commissions.description','commissions.added_date')
									->where(['commissions.user_id' => $userId])
									//->groupBy('commissions.user_id')
									->orderBy('commissions.rec_id','DESC')
									->skip($page * $limit)->take($limit)->get();
				}
			}else if($userInfo['user_role'] == 2){
				
				if($userId == $referenceId){
					
					$userData = Commissions::join('users','commissions.user_id', '=','users.rec_id')
								->select('users.rec_id','users.user_id', 'users.first_name','users.last_name', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
								->where(['commissions.user_id' => $userId])
								->where('commissions.agent_id', '=' , 0)
								->groupBy('commissions.agent_id')
								->first();
				}else{
					
					$userData = Commissions::join('users','commissions.agent_id', '=','users.rec_id')
								->select('users.rec_id','users.user_id', 'users.first_name','users.last_name', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
								->where(['commissions.agent_id' => $userId,'commissions.user_id' => $referenceId])
								//->where('commissions.agent_id', '!=' , 0)
								->groupBy('commissions.agent_id')
								->first();
				}
				
				if (!empty($from_date) && !empty($to_date)) {
				
					$start = Carbon::parse($from_date)->format('Y-m-d H:i:s');
					$todate = Carbon::parse($to_date)->format('Y-m-d H:i:s');
					$to = date('Y-m-d H:i:s', strtotime($todate . ' +1 day'));

					$commissionReports = Commissions::join('users','commissions.agent_id', '=','users.rec_id')
									->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount','commissions.commission_perc', 'commissions.commission','commissions.description','commissions.added_date')
									->where(['commissions.agent_id' => $userId,'commissions.user_id' => $referenceId])
									->whereBetween('commissions.added_date',[$start, $to])
									//->where('commissions.agent_id', '!=' , 0)
									->orderBy('commissions.rec_id','DESC')
									->skip($page * $limit)->take($limit)->get();
				}else{
					if($userId == $referenceId){
						$commissionReports = Commissions::join('users','commissions.user_id', '=','users.rec_id')
									->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount','commissions.commission_perc', 'commissions.commission','commissions.description','commissions.added_date')
									->where(['commissions.user_id' => $userId])
									->where('commissions.agent_id', '=' , 0)
									->orderBy('commissions.rec_id','DESC')
									->skip($page * $limit)->take($limit)->get();
					}else{
						$commissionReports = Commissions::join('users','commissions.agent_id', '=','users.rec_id')
									->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount','commissions.commission_perc', 'commissions.commission','commissions.description','commissions.added_date')
									->where(['commissions.agent_id' => $userId,'commissions.user_id' => $referenceId])
									//->where('commissions.agent_id', '!=' , 0)
									->orderBy('commissions.rec_id','DESC')
									->skip($page * $limit)->take($limit)->get();
					}
					
				}
			}else if($userInfo['user_role'] == 3){
				
				if($userId == $referenceId){
					$userData = Commissions::join('users','commissions.user_id', '=','users.rec_id')
									->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
									->where(['commissions.user_id' => $userId])
									->first();
				}else{
					$userData = Commissions::join('users','commissions.agent_id', '=','users.rec_id')
									->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
									->where(['commissions.agent_id' => $userId,'commissions.user_id' => $referenceId])
									//->where('commissions.sender_user_id', '!=' , 0)
									->groupBy('commissions.agent_id')
									->orderBy('commissions.rec_id','DESC')
									->first();
				}
				
				if (!empty($from_date) && !empty($to_date)) {
				
					$start = Carbon::parse($from_date)->format('Y-m-d H:i:s');
					$todate = Carbon::parse($to_date)->format('Y-m-d H:i:s');
					$to = date('Y-m-d H:i:s', strtotime($todate . ' +1 day'));
					
					$commissionReports = Commissions::join('users','commissions.sender_user_id', '=','users.rec_id')
									->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount', 'commissions.commission_perc','commissions.commission','commissions.description','commissions.added_date')
									->where(['commissions.agent_id' => $userId])
									->where('commissions.sender_user_id', '!=' , 0)
									->whereBetween('commissions.added_date',[$start, $to])
									->groupBy('commissions.sender_user_id')
									->orderBy('commissions.rec_id','DESC')
									->skip($page * $limit)->take($limit)->get();
				}else{
					if($userId == $referenceId){
						$commissionReports = Commissions::join('users','commissions.sender_user_id', '=','users.rec_id')
									->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount', 'commissions.commission_perc','commissions.commission','commissions.description','commissions.added_date')
									->where(['commissions.user_id' => $userId])
									->where('commissions.sender_user_id', '!=' , 0)
									->orderBy('commissions.rec_id','DESC')
									->skip($page * $limit)->take($limit)->get();
					}else{
						$commissionReports = Commissions::join('users','commissions.sender_user_id', '=','users.rec_id')
									->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount', 'commissions.commission_perc','commissions.commission','commissions.description','commissions.added_date')
									->where(['commissions.agent_id' => $userId])
									->where('commissions.sender_user_id', '!=' , 0)
									->groupBy('commissions.sender_user_id')
									->orderBy('commissions.rec_id','DESC')
									->skip($page * $limit)->take($limit)->get();
					}
				}
			}else{
				
				$userData = Commissions::join('users','commissions.sender_user_id', '=','users.rec_id')
									->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', DB::raw('SUM(sales_amount) as sales_amount, SUM(commission) as commission'))
									->where(['commissions.sender_user_id' => $userId,'commissions.agent_id' => $refereceId])
									->first();
									
				if (!empty($from_date) && !empty($to_date)) {
				
					$start = Carbon::parse($from_date)->format('Y-m-d H:i:s');
					$todate = Carbon::parse($to_date)->format('Y-m-d H:i:s');
					$to = date('Y-m-d H:i:s', strtotime($todate . ' +1 day'));
					
					$commissionReports = Commissions::join('users','commissions.sender_user_id', '=','users.rec_id')
									->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount', 'commissions.commission_perc','commissions.commission','commissions.description','commissions.added_date')
									->where(['commissions.sender_user_id' => $userId,'commissions.agent_id' => $refereceId])
									->whereBetween('commissions.added_date',[$start, $to])
									->orderBy('commissions.rec_id','DESC')
									->skip($page * $limit)->take($limit)->get();	
				}else{
					$commissionReports = Commissions::join('users','commissions.sender_user_id', '=','users.rec_id')
									->select('users.rec_id', 'users.user_id', 'users.first_name','users.last_name','users.user_role', 'commissions.sales_amount', 'commissions.commission_perc','commissions.commission','commissions.description','commissions.added_date')
									->where(['commissions.sender_user_id' => $userId,'commissions.agent_id' => $refereceId])
									->orderBy('commissions.rec_id','DESC')
									->skip($page * $limit)->take($limit)->get();
				}
			}
				
			
			if(!empty($userData)){ 
				$fullName = $userData['first_name']." ".$userData['last_name'];
				$topbarinfo = array(
								"userName"=>$fullName,
								"agent_id"=>$userData['user_id'],
								"total_sales_amount"=>number_format($userData['sales_amount'],2),
								"total_commision_amount"=>number_format($userData['commission'],2),
								);
			}else{
				$topbarinfo = array();
			}	
			
		    
			$total_sales_amount = 0;
			$total_commision_amount = 0;
			if(@count($commissionReports)>0){
				$comm_report = array();
				
				foreach($commissionReports as $res){
						
						$sales_amt = $res['sales_amount'];
						$commission_amt = $res['commission'];
						$commission_per = $res['commission_perc'];
						$description = $res['description'];
						$match = "from";
						if(strpos($description, $match) !== false){
							$findposition = strpos($description,$match);
							$description_new = substr($description, 0, $findposition).".";
							
						}else{
							$description_new = $description;
						}
						
					$added_date = UserController::convertDateToUTCForAPI($res['added_date']);//date("d/m/Y, h:i a", strtotime($res['added_date']));
					$total_sales_amount += $sales_amt;
					$total_commision_amount += $commission_amt;
					
					$comm_report[] = array(
									"added_date"=>$added_date,
									"description"=>$description_new,
									"sale_amount"=>number_format($sales_amt,2),
									"commission_per"=>$commission_per,
									"commission_per_symbol"=>"%",
									"commission_amount"=>number_format($commission_amt,2),
									'currency_symbol'=>'$',
									'currency_format'=>'USD'
									);
					
				}
				return response()->json(['status' => 'Success','topbarInfo'=>$topbarinfo,'Result' => $comm_report], 200);
			}else{
				return response()->json(['status'=>'Failure','topbarInfo'=>$topbarinfo,'Result'=>"No Records Found" ], 200);
			}
		
		}
	
		
	}
	
	
	
}
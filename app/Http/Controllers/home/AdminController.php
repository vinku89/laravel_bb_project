<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use App\Subscribe_newsletter;
use App\Contact_users;
use Validator;
use Session;
use App\User;
use App\Wallet;
use App\Country;
use App\Visitor;
use App\Commissions;
use App\Packages;
use App\Package_purchase_list;
use App\Purchase_order_details;
use App\Sales;
use App\Users_tree;
use App\Unilevel_tree;
use App\Transactions;
use App\Withdraw_request;
use App\Multiple_box_purchase;
use App\Models\registerModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class AdminController extends Controller
{
	public function index(){
		return view('website/website');
	}
	public function dashboard($year="")
	{

		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$userRole = $userInfo['user_role'];
		$adminLogin = $userInfo['admin_login'];
		$user = User::where(array('rec_id' => $userId))->first();
		$data['userInfo'] = $user;
		$profile_image = ($data['userInfo']['image'] != '') ? $data['userInfo']['image'] : 'profile_pic.png';
		$data['userInfo']['profile_image'] = $profile_image;
		$data['directSales'] = User::join('sales', 'users.rec_id', '=', 'sales.user_id')
				->select('users.user_id', 'sales.sales_amount', 'sales.added_date', 'sales.commission', 'sales.commission_per', 'sales.description')
				->where(array('sales.user_id' => $userId))
				->orderBy('added_date', 'DESC')
				->limit(5)->get();
		$data['visitor'] = Visitor::where("user_id", $userId)->orderBy('id', 'DESC')->first();
		$data['wallet'] = Wallet::where(array('user_id' => $userId))->first();
		if($year == '') {
			$year = date("Y");
		}

		if ($adminLogin == 1) {

			$tot_comm = Commissions::where('user_id','!=',$userId)->sum('commission');
			$data['total_commission'] = number_format($tot_comm, 2);
			$tot_sales = Sales::sum('sales_amount');
			$data['total_sales'] = number_format($tot_sales, 2);
			$data['resellers_cnt'] = User::where("user_role", 2)->where('status',1)->count();
			$data['agents_cnt'] = User::where("user_role", 3)->where('status',1)->count();
			$data['customers_cnt'] = User::where("user_role", 4)->where("sub_user", 0)->where('status',1)->count();
			$data['accounts_cnt'] = User::where("user_role", 4)->where('status',1)->count();

			$data['pending_withdraw_cnt'] = Withdraw_request::where('status',1)->count();
			$res = User::join('sales', 'users.rec_id', '=', 'sales.user_id')
				->select(DB::raw("YEAR(added_date) AS y, MONTHNAME(added_date) AS m"),DB::raw("SUM(sales.sales_amount) AS sales_amount"),DB::raw("SUM(sales.commission) AS commission"))
				->whereYear('sales.added_date', $year)
				->groupBy('y','m')
				->orderBy('m', 'ASC')
				->get();

			$month_arr2 = array('January'=>0,'February'=>0,'March'=>0,'April'=>0,'May'=>0,'June'=>0,'July'=>0,'August'=>0,'September'=>0,'October'=>0,'November'=>0,'December'=>0);

			if($year == '' || $year == date('Y')) {
				foreach($month_arr2 as $key => $value) {
					$month_arr[$key] = 0;
					if($key == date('F')) break;
				}
			}else{
				$month_arr = array('January'=>0,'February'=>0,'March'=>0,'April'=>0,'May'=>0,'June'=>0,'July'=>0,'August'=>0,'September'=>0,'October'=>0,'November'=>0,'December'=>0);
			}

			$tot_sales = array();
			foreach ($res as $key => $value) {
				$tot_sales[$value->m] = $value->sales_amount;
			}

			$qs = Commissions::select(DB::raw("YEAR(added_date) AS y, MONTHNAME(added_date) AS m"),DB::raw("SUM(commissions.commission) AS commission"))
				->whereYear('commissions.added_date', $year)
				->groupBy('y','m')
				->orderBy('m', 'ASC')
				->get();
			$tot_comm = array();
			foreach ($qs as $key => $value) {
				$tot_comm[$value->m] = $value->commission;
			}

			$sd=array_merge($month_arr,$tot_sales);
			$cd=array_merge($month_arr,$tot_comm);
			$data['sales_data']=json_encode(array_values($sd));
			$data['comm_data']=json_encode(array_values($cd));
			$data['year'] = $year;
			return view('adminDashboard')->with($data);
		}
		else if($userRole == 4){

			$data['referral_earnings'] = Commissions::where(['user_id' => $userId, 'commission_type' => 'Referral Bonus'])->sum('commission');
			$data['total_referral'] = Commissions::where("user_id",$userId)->where("commission_type",'=','Referral Bonus')->count();

			$data['packData'] = Package_purchase_list::leftjoin('packages', 'package_purchased_list.package_id', '=', 'packages.id')->where('package_purchased_list.user_id', $userId)->where('package_purchased_list.package_id','!=',11)->where('package_purchased_list.active_package','=',1)->orderBy('package_purchased_list.rec_id','DESC')->first();


			$data['pp_cnt'] = Package_purchase_list::where('user_id',$userId)->count();
			$data['pp_det'] = Package_purchase_list::where('user_id',$userId)->orderBy('rec_id','ASC')->first();
			$data['packages'] = Packages::where(['status' => 1])->get();
			$data['pod'] = Purchase_order_details::where('user_id',$userId)->orderBy('rec_id','DESC')->first();

			$data['subusers_data'] = Multiple_box_purchase::join('users','multiple_box_purchase.sub_user_id','=','users.rec_id')->leftJoin(\DB::raw('(SELECT * FROM package_purchased_list WHERE rec_id IN (SELECT MAX(rec_id) AS id FROM package_purchased_list GROUP BY user_id) ORDER BY user_id) AS t2'), function($join) {
			        $join->on('users.rec_id', '=', 't2.user_id');
			    })->leftjoin('packages', 't2.package_id', '=', 'packages.id')->where('multiple_box_purchase.user_id',$userId)->select('users.registration_date','users.rec_id','users.user_id','users.first_name','users.last_name','packages.id','packages.effective_amount', 't2.expiry_date','packages.package_name','packages.setupbox_status')->orderBy('users.rec_id', 'DESC')->paginate(10);

			$data['users_data'] = User::leftJoin(\DB::raw('(SELECT * FROM package_purchased_list WHERE rec_id IN (SELECT MAX(rec_id) AS id FROM package_purchased_list WHERE package_id != 11 GROUP BY user_id) ORDER BY user_id) AS t2'), function($join) {
			        $join->on('users.rec_id', '=', 't2.user_id');
			    })->leftjoin('packages', 't2.package_id', '=', 'packages.id')->where('users.rec_id',$userId)->select('users.registration_date','users.rec_id','users.user_id','users.first_name','users.last_name','packages.id','packages.effective_amount', 't2.expiry_date','packages.package_name','packages.setupbox_status')->first();



			// echo "<pre>";
			// print_r($data['ppddata']);exit();

			//return view('customer/customer_dashboard')->with($data);
			return view('customer/version2/customer_dashboard')->with($data);
		}
		else {

			$total_commission_amt = Commissions::where("user_id", $userId)->sum('commission');
			if ($userRole == 2) {
				$res = Users_tree::where("reseller_id",$userId)->where("agent_id","!=",0)->groupBy("agent_id")->get();
			}else if ($userRole == 3){
				$res = Users_tree::where("agent_id",$userId)->where("customer_id","!=",0)->groupBy("customer_id")->get();
			}

			$total_sales_amt = Sales::where("user_id", $userId)->sum('sales_amount');
			$tot_sales = $total_sales_amt;
			foreach ($res as $key => $value) {
				if ($userRole == 2) {
					$qs = Sales::where("user_id", $value->agent_id)->sum('sales_amount');
				}else if ($userRole == 3){
					$qs = Sales::where("user_id", $value->customer_id)->sum('sales_amount');
				}
				$tot_sales = $tot_sales + $qs;
			}
			$data['total_sales'] = number_format($tot_sales, 2);
			$data['total_commission'] = number_format($total_commission_amt, 2);
			$data['resellers_cnt'] = User::where("user_role", 2)->where("status",1)->where("referral_userid", $userId)->count();
			$data['agents_cnt'] = User::where("user_role", 3)->where("status",1)->where("referral_userid", $userId)->count();

			if ($userRole == 2) {
				$data['customers_cnt'] = Users_tree::leftjoin('users','users_tree.customer_id','=','users.rec_id')->where("users.status",'=',1)->where("users_tree.reseller_id", $userId)->where("users_tree.customer_id", "!=", 0)->where("users_tree.agent_id", "=", 0)->count();
				$data['accounts_cnt'] = Users_tree::leftjoin('users','users_tree.customer_id','=','users.rec_id')->where("users.status",'=',1)->where("users_tree.reseller_id", $userId)->where("users_tree.customer_id", "!=", 0)->where("users_tree.agent_id", "=", 0)->where("users.sub_user", 0)->count();
			} else if ($userRole == 3) {
				$data['customers_cnt'] = Users_tree::leftjoin('users','users_tree.customer_id','=','users.rec_id')->where("users.status",'=',1)->where("users_tree.agent_id", $userId)->where("users_tree.customer_id", "!=", 0)->where("users_tree.agent_id", "!=", 0)->count();
				$data['accounts_cnt'] = Users_tree::leftjoin('users','users_tree.customer_id','=','users.rec_id')->where("users.status",'=',1)->where("users_tree.agent_id", $userId)->where("users_tree.customer_id", "!=", 0)->where("users_tree.agent_id", "!=", 0)->where("users.sub_user", 0)->count();
			} else {
				$data['customers_cnt'] = User::where("user_role", 4)->where("status",'=',1)->where("referral_userid", $userId)->count();
				$data['accounts_cnt'] = User::where("user_role", 4)->where("status",'=',1)->where("referral_userid", $userId)->where("sub_user", 0)->count();
			}

			$res = User::join('sales', 'users.rec_id', '=', 'sales.user_id')
				->select(DB::raw("SUM(sales.sales_amount) AS sales_amount"),'sales.added_date', DB::raw("SUM(sales.commission) AS commission"))
				->where(array('sales.user_id' => $userId))
				->where('sales.added_date', '>=', Carbon::now()->startOfWeek())
             	->where('sales.added_date', '<=', Carbon::now()->endOfWeek())
				->groupBy(DB::raw("DATE(sales.added_date)"))
				->orderBy('added_date', 'DESC')
				->get();

			$mnarr = array();
	            foreach ($res as $val) {
	            	$dt = date('Y-m-d', strtotime($val->added_date));
	            	$timestamp = strtotime($dt);
	            	$num = $timestamp.'000';
	            	$mnarr[] = array('x'=>(int)$num,'y'=>$val->sales_amount,'comm'=>$val->commission,'date'=>date('l, d M Y',strtotime($val->added_date)));
	      		}
		    $data['dataPoints'] = json_encode($mnarr);

		    return view('dashboard')->with($data);
		}

	}

	public function updatedOrdersList(Request $request,$type=1){
		if(!empty($type)){
			$type = $type;
		}else{
			$type = 1;
		}
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$data['userInfo'] = $userInfo;
		$data['from_date'] = $request->query('from_date');
		$data['to_date'] = $request->query('to_date');
		if (!empty($request->query('from_date')) && !empty($request->query('to_date'))) {
			$from_date = $request->query('from_date');
			$to_date = $request->query('to_date');
			$from_date = Carbon::createFromFormat('m-d-Y', $from_date)->format('Y-m-d');
			$to_date = Carbon::createFromFormat('m-d-Y', $to_date)->format('Y-m-d');
			$start = Carbon::parse($from_date)->format('Y-m-d H:i:s');
			$todate = Carbon::parse($to_date)->format('Y-m-d H:i:s');
			$to = date('Y-m-d H:i:s', strtotime($todate . ' +1 day'));
		}

		if (!empty($request->query('from_date')) && !empty($request->query('to_date'))) {
			if($userInfo->admin_login == 1){
				$res = Purchase_order_details::leftJoin('users','purchase_order_details.user_id','=','users.rec_id')
											->select('users.rec_id','users.user_id','users.email','users.first_name','users.last_name','purchase_order_details.order_id','purchase_order_details.order_id','purchase_order_details.attachment','purchase_order_details.purchased_date')
											//->where(['purchase_order_details.type'=>$type])
											->whereBetween('purchase_order_details.purchased_date',[$start, $to])
											->orderBy('purchase_order_details.purchased_date','DESC')
											->paginate(25);
			}else{
				$res = Purchase_order_details::leftJoin('users','purchase_order_details.user_id','=','users.rec_id')
											->select('users.rec_id','users.user_id','users.email','users.first_name','users.last_name','purchase_order_details.order_id','purchase_order_details.order_id','purchase_order_details.attachment','purchase_order_details.purchased_date')
											->where(['purchase_order_details.user_id' => $userId])
											->whereBetween('purchase_order_details.purchased_date',[$start, $to])
											->orderBy('purchase_order_details.purchased_date','DESC')
											->paginate(25);
			}
		}else{
			if($userInfo->admin_login == 1){
				$res = Purchase_order_details::leftJoin('users','purchase_order_details.user_id','=','users.rec_id')
											->select('users.rec_id','users.user_id','users.email','users.first_name','users.last_name','purchase_order_details.order_id','purchase_order_details.order_id','purchase_order_details.attachment','purchase_order_details.purchased_date')
											//->where(['purchase_order_details.type'=>$type])
											->orderBy('purchase_order_details.purchased_date','DESC')
											->paginate(25);
			}else{
				$res = Purchase_order_details::leftJoin('users','purchase_order_details.user_id','=','users.rec_id')
											->select('users.rec_id','users.user_id','users.email','users.first_name','users.last_name','purchase_order_details.order_id','purchase_order_details.order_id','purchase_order_details.attachment','purchase_order_details.purchased_date')
											->where(['purchase_order_details.user_id' => $userId])
											->orderBy('purchase_order_details.purchased_date','DESC')
											->paginate(25);
			}

		}

		$data['ordersList'] = $res;
		return view('update_order_list')->with($data);
	}

	public function updateOrderDetailsPage(Request $request){
		//return view('customer/update_order');
		return view('customer/version2/update_order');
	}

	//update order details

	public function updateCustomerOrderDetails(Request $request) {
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$validator = Validator::make($request->all(), [
			'order_id' => 'required|unique:purchase_order_details'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			return response()->json(['status' => 'Failure','message'=> '<ul>' . $str . '</ul>']);
		} else {

			$cnt = Purchase_order_details::where('user_id',$userId)->count();
			if($cnt == 0){
				$type = 1;
			}else{
				$type = 2;
			}

			if ($request->hasFile('invoice_attachment') && $request->file('invoice_attachment')!='') {
				$image = $request->file('invoice_attachment');
				$fileType = $image->guessExtension();
				$fileTyp = strtolower($fileType);
				$allowedTypes = array("jpeg", "jpg", "png", "pdf");
				if (in_array($fileTyp, $allowedTypes)) {
					// Rename image
					$fileName = 'INV-'.rand(999,9999999).time().'.'.$image->guessExtension();
					$destinationPath = base_path('/public/invoices');
					$upload_success = $image->move($destinationPath, $fileName);

					if ($upload_success) {
						$data = array('attachment' => $fileName, 'order_id' => $request->order_id, 'purchased_from' => 'Ali Express','purchased_date' => Now(),'status' => 1, 'user_id' => $userId, 'sender_id' => $userId,'updated_at' => Now(),'type'=>$type);

						$res = Purchase_order_details::create($data);
						return response()->json(['status' => 'Success', 'message' => 'Your update order has been submitted for approval'], 200);
					} else {
						return response()->json(['status' => 'Failure', 'message' => 'Something went wrong in Uploading image'], 200);
					}
				} else {
					return response()->json(['status' => 'Failure', 'message' => 'Please Upload only JPEG,JPG,PNG or PDF formats only'], 200);
				}
			}else{
				$data = array('attachment' => '', 'order_id' => $request->order_id, 'purchased_from' => 'Ali Express','purchased_date' => Now(),'status' => 1, 'user_id' => $userId, 'sender_id' => $userId,'updated_at' => Now(),'type'=>$type);

				$res = Purchase_order_details::create($data);
				return response()->json(['status' => 'Success', 'message' => 'Your update order has been submitted for approval'], 200);
			}
		}
	}

	public function chartData(Request $request){

		$type = $request->type;
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];

		if($type == 'Week'){
			$todayMinusOneWeekAgo = \Carbon\Carbon::today()->subWeek();
			$res = User::join('sales', 'users.rec_id', '=', 'sales.user_id')
				->select(DB::raw("SUM(sales.sales_amount) AS sales_amount"),'sales.added_date', DB::raw("SUM(sales.commission) AS commission"))
				->where(array('sales.user_id' => $userId))
				//->where(DB::raw('DATE(sales.added_date)'),">=",$todayMinusOneWeekAgo)
				->where('sales.added_date', '>=', Carbon::now()->startOfWeek())
             	->where('sales.added_date', '<=', Carbon::now()->endOfWeek())
				->groupBy(DB::raw("DATE(sales.added_date)"))
				->orderBy('added_date', 'DESC')
				->get();
		}else{
			$res = User::join('sales', 'users.rec_id', '=', 'sales.user_id')
				->select(DB::raw("SUM(sales.sales_amount) AS sales_amount"),'sales.added_date', DB::raw("SUM(sales.commission) AS commission"))
				->where(array('sales.user_id' => $userId))
				->where(DB::raw('DATE(sales.added_date)'),">",DB::raw('CURDATE() - INTERVAL '.$type.' MONTH'))
				->groupBy(DB::raw("DATE(sales.added_date)"))
				->orderBy('added_date', 'DESC')
				->get();
		}

		$mnarr = array();
	            foreach ($res as $val) {
	            	$dt = date('Y-m-d', strtotime($val->added_date));
	            	$timestamp = strtotime($dt);
	            	$num = $timestamp.'000';
	            	$mnarr[] = array('x'=>(int)$num,'y'=>$val->sales_amount,'comm'=>$val->commission,'date'=>date('l, d M Y',strtotime($val->added_date)));
	      		}
	    echo json_encode($mnarr);

	}

	public function check_time_zone(Request $request)
	{
		$sess_data = Auth::user();
		Log::info("check time zone ".json_encode($sess_data));
		if($request['tz']) {
	        $gdt = $request['tz'];
	    } else{
	    	$gdt = 'Atlantic/Reykjavik';
	    }
		\Session::put('timezone', $gdt);
		$res = Visitor::where("user_id", $sess_data['rec_id'])->orderBy('id', 'DESC')->first();
		$dt = $res['created_at']; //new DateTime();
		$tz = new DateTimeZone($gdt); // or whatever zone you're after
		$dt->setTimezone($tz);
		$ndt = $dt->format('l, d M Y');
		$nt = $dt->format("h:ia");

		$last_visited = '';
		$visitor = Visitor::where("user_id", $sess_data['rec_id'])->orderBy('id', 'DESC')->skip(1)->take(1)->get();
		if(count($visitor)>0){

			$lv = $visitor[0]['created_at'];
			$tz1 = new DateTimeZone($gdt); // or whatever zone you're after
			$lv->setTimezone($tz1);
			$last_visited = "Last login : ".$lv->format('l, d M Y h:ia');

		}

		return array('date' => $ndt, 'time' => $nt, 'last_visited' => $last_visited);
	}

	public function resellers(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['user_id'];
		$data['userInfo'] = $userInfo;
		$user = User::where(array('user_id' => $userId))->first();
		$searchKey = $request->query('searchKey');
		$where = array('user_role'=>2,'status'=> 1,);
		if (!empty($request->query('searchKey'))){

			$data['resellers_data'] = User::where(['user_role'=>2])
			->where(function($query) use($searchKey) {
               			 return $query->where(DB::raw('concat(first_name," ",last_name)'), 'LIKE', '%' . $searchKey . '%')->orWhere('email', 'LIKE', '%' . $searchKey . '%');
            		})
			->orderBy("rec_id", "DESC")->paginate(50);

		}else{
			$data['resellers_data'] = User::where(['user_role'=>2])->orderBy("rec_id", "DESC")->paginate(30);
		}

		$data['searchKey'] = $searchKey;
		$data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();
		return view("resellers")->with($data);
	}

	public function getResellerData()
	{
		$rec_id = Input::get('id');
		$resellers_data = DB::table('users')->where('rec_id', $rec_id)->orWhere('email', $rec_id)->get();
		$res = DB::table('country')->where('countryid', $resellers_data[0]->country_id)->first();
		return response()->json(['status' => 'Success', 'message' => $resellers_data, 'country' => $res->country_name], 200);
	}

	public function resellerView($resellerId)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$resellerId = base64_decode($resellerId);
		$resellerInfo = User::where(array('rec_id' => $resellerId))->first();
		$data['resellerInfo'] = $resellerInfo;
		$data['country'] = Country::select('country_name')->where('countryid', '=', $resellerInfo->country_id)->first();
		return view("reseller-view")->with($data);
	}

	public function resellerNew()
	{
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$data['userInfo'] = $userInfo;
		$data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();
		if($userInfo['admin_login'] == 1){
			$userInfo['commission_perc'] = 100;
		}else{
			$userInfo['commission_perc'] = ($userInfo->commission_perc == 0 ? 0 : $userInfo->commission_perc-1);
		}

		return view('reseller-new')->with($data);
	}

	public function createReseller(Request $request)
	{
		$admin_id = config('constants.ADMIN_ID');
		$userInfo = Auth::user();
		$lguserId = $userInfo['rec_id'];
		if($userInfo['admin_login'] == 1){
			$userInfo['commission_perc'] = 100;
			$login_userId = $admin_id;
		}else{
			$userInfo['commission_perc'] = ($userInfo->commission_perc == 0 ? 0 : $userInfo->commission_perc-1);
			$login_userId = $userInfo['rec_id'];
		}
		$validator = Validator::make($request->all(), [
            'email' => 'required|email|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$/|unique:users',
            'password' => 'required|regex:/^.*(?=.{8,})(?=.*[a-z])(?=.*[0-9]).*$/|same:confirm_password',
			'confirm_password' => 'required',
			'first_name' => 'required|string|min:3|max:255',
			'last_name' => 'required|string|min:3|max:255',
			'commission_perc' => 'required'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			return Redirect::back()->withErrors(['<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>']);
		}else {

            $password = $request->password;
			$email = $request->email;
			$first_name = $request->first_name;
			$last_name = $request->last_name;
			$gender = $request->gender;
			$address = $request->shipping_address;
			$country = $request->country;
			$country_code = $request->country_code;

			$firstCharacter = $request->mobile[0];
			if($firstCharacter == 0){
			    $mbl = ltrim($request->mobile, '0');
			}else{
			    $mbl = $request->mobile;
			}

			$mobile = $country_code . "-" . $mbl;
			$commission_perc = $request->commission_perc;

			if ($commission_perc > $userInfo['commission_perc']) {
				Session::flash('message', 'Commission must be less than ' . $userInfo['commission_perc']);
				Session::flash('alert','Failure');
				return back()->withInput();
			}

			$userId = self::generateUserId('RES', $first_name);
			$us_cnt = User::where('user_id', $userId)->count();
			if ($us_cnt == 1) {
				$user_id = self::generateUserId('RES', $first_name);
			} else {
				$user_id = $userId;
			}

			$ref_code = self::generateReferralCode($first_name);
			$ref_cnt = User::where('refferallink_text', $ref_code)->count();
			if ($ref_cnt == 1) {
				$referral_code = self::generateReferralCode($first_name);
			} else {
				$referral_code = $ref_code;
			}

			$input = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$input_length = strlen($input);
			$random_string = '';
			for($i = 0; $i < 9; $i++) {
				$random_character = $input[mt_rand(0, $input_length - 1)];
				$random_string .= $random_character;
			}
            //$pwd = $random_string;
            $pwd = $password;
			$hashpwd = Hash::make($pwd);
            $encrypted_plain_pass=safe_encrypt($password,config('constants.encrypt_key'));

			$user = User::create([
				'user_id' => $user_id,
				'referral_userid' => $login_userId,
				'first_name' => $first_name,
				'last_name' => $last_name,
				'email' => $email,
                'password' => $hashpwd,
                'plain_password'=>$encrypted_plain_pass,
				'gender' => $gender,
				'shipping_address' => $address,
				'country_id' => $country,
				'telephone' => $mobile,
				'commission_perc' => $commission_perc,
				'refferallink_text' => $referral_code,
				'user_role' => 2,
				'registration_date' => date('Y-m-d H:i:s'),
                'created_by' => $lguserId,
                'email_verify' => 1,
                'status' => 1
			]);

            $last_inserted_id = $user->rec_id;
            //User::where('rec_id',$last_inserted_id)->update(['email_verify' => 1,'status' => 1]);

			Wallet::create([
				'user_id' => $last_inserted_id,
				'amount' => 0
			]);

			Users_tree::create([
				'reseller_id' => $last_inserted_id,
				'admin_id' => $login_userId
			]);

			$l = 1;
			$nom = $login_userId;
			$user_role = 2;
			while ($nom != 999) {
				if ($nom != 999 && $l < 150) {
					Unilevel_tree::create([
						'down_id' => $last_inserted_id,
						'upliner_id' => $nom,
						'level' => $l,
						'user_role' => $user_role
					]);
					$l++;
					$results = User::where('rec_id', $nom)->select('referral_userid')->first();
					$nom = $results->referral_userid;
				}
			}

			$data['useremail'] = array('name' => $first_name.' '.$last_name, 'user_id' => $last_inserted_id, 'email' => $email,'type'=>'Reseller', 'referral_link' => $referral_code, 'password' => $pwd,'user_role' => 2);
			$emailid = array('toemail' => $email);
			Mail::send(['html' => 'email_templates.verify-email'], $data, function ($message) use ($emailid) {
				$message->to($emailid['toemail'], 'Email Verification')->subject('Email Verification');
				$message->from('noreply@bestbox.net', 'BestBox');
			});

			Session::flash('result', 'Reseller Created Successfully');
			Session::flash('alert','Success');
			return Redirect::back();
		}
	}

	public static function generateCustomerId($name)
	{
		$fname = str_replace(' ', '', $name);
		$name_str = strtoupper(substr($fname, 0, 3));
		//$user_id = $name_str . rand(100000, 999999);
		$user_id = $name_str . rand(100, 999);
		return $user_id;
	}

	public static function generateUserId($type, $name)
	{
		$fname = str_replace(' ', '', $name);
		$name_str = strtoupper(substr($fname, 0, 3));
		$user_id = $type . rand(10000, 99999) . $name_str;
		return $user_id;
	}

	public static function generateReferralCode($name)
	{
		$fname = str_replace(' ', '', $name);
		$name_str = strtoupper(substr($fname, 0, 3));
		$referral_code = $name_str . rand(10000, 99999);
		return $referral_code;
	}

	public function resellerEdit($resellerId)
	{
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$data['userInfo'] = $userInfo;
		if($userInfo['admin_login'] == 1){
			$userInfo['commission_perc'] = 100;
		}else{
			$userInfo['commission_perc'] = $userInfo->commission_perc-1;
		}
		$reseller_id = base64_decode($resellerId);
		$reseller_Info = User::where(array('rec_id' => $reseller_id))->first();
		$telephone = explode('-', $reseller_Info->telephone);
		$reseller_Info->telephone = $telephone[1];
		$reseller_Info->country_code = $telephone[0];
		$data['resellerData'] = $reseller_Info;
		$data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();

		return view('reseller-edit')->with($data);
	}

	public function updateResellerData(Request $request)
	{
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		if($userInfo['admin_login'] == 1){
			$userInfo['commission_perc'] = 100;
		}else{
			$userInfo['commission_perc'] = $userInfo->commission_perc-1;
		}
		$validator = Validator::make($request->all(), [
			'first_name' => 'required|string|min:2|max:255',
			'last_name' => 'required|string|min:2|max:255',
			'commission_perc' => 'required',
			'reseller_id' => 'required'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			return Redirect::back()->withErrors(['<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>']);
		}else {
			$first_name = $request->first_name;
			$last_name = $request->last_name;
			$gender = $request->gender;
			$address = $request->shipping_address;
			$country = $request->country;
			$country_code = $request->country_code;

			$firstCharacter = $request->mobile[0];
			if($firstCharacter == 0){
			    $mbl = ltrim($request->mobile, '0');
			}else{
			    $mbl = $request->mobile;
			}

			$mobile = $country_code . "-" . $mbl;
			$commission_perc = $request->commission_perc;
			$reseller_id = base64_decode($request->reseller_id);

			if ($commission_perc > $userInfo['commission_perc']) {
				Session::flash('message', 'Commision must be less than ' . $userInfo['commission_perc']);
				Session::flash('alert','Failure');
				return back()->withInput();
			}
			$resellerData = array(
				'first_name' => $first_name,
				'last_name' => $last_name,
				'gender' => $gender,
				'shipping_address' => $address,
				'country_id' => $country,
				'telephone' => $mobile,
				'commission_perc' => $commission_perc
			);

			$result = User::where(array('rec_id' => $reseller_id))->update($resellerData);
			Session::flash('result', 'Updated Successfully');
			Session::flash('alert','Success');
			return Redirect::back();
		}
	}

	public function deleteResellerData(Request $request)
	{
		$res = User::where('rec_id', $request['id'])->update(['status' => 0]);
		return response()->json(['status' => 'Success','Result' =>"Deleted Agent Successfully"], 200);
	}

	//
	public function deleteResellerAgentStatus()
	{
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];

		$rec_id = Input::get("rec_id");
		$statusID = Input::get("status");
		$action = Input::get("action");

		if($rec_id == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'user id missing'], 200);
		}else{
			if($statusID == 1 ){
				$msg = "Activated Successfully";
			}else{
				$msg = "In-activated Successfully";
			}
			$data = array("status"=>$statusID);
			$res = User::where('rec_id','=',$rec_id)->update($data);
			if($res){

				return response()->json(['status' => 'Success', 'Result' => $msg], 200);
			}else{
				return response()->json(['status' => 'Failure', 'Result' => 'Something went wrong'], 200);
			}

		}

	}

	public function verifyEmail()
	{
		Auth::logout();
		$id = \Request::segment(2);
		$reflink = \Request::segment(3);
		$user_id = decrypt($id);
		$reflnk = decrypt($reflink);

		$userDetails = User::where('rec_id',$user_id)->where('refferallink_text',$reflnk)->first();
		if(!empty($userDetails)){
			if ($userDetails->email_verify == 0) {

				User::where('rec_id',$user_id)->update(['email_verify' => 1,'status' => 1]);

				$data['rec_id'] = $user_id;

				Session::flash('message', 'Your account has been activated successfully, Please Sign In!');
				Session::flash('alert','Success');
				if($userDetails->user_role == 4){
					return redirect('customerLogin');
				}else if($userDetails->admin_login == 1){
					return redirect('Admin');
				}else{
					return redirect('login');
				}

			}else{
				Session::flash('message', 'Email Already Verified, Please Sign In!');
				Session::flash('alert','Failure');
				if($userDetails->user_role == 4){
					return redirect('customerLogin');
				}else if($userDetails->admin_login == 1){
					return redirect('Admin');
				}else{
					return redirect('login');
				}
			}
		}else{
			return redirect('login');
		}
	}

	public function resetNewPassword(Request $request)
	{
		$messages = [
			    'password.regex' => 'Password should be minimum 8 characters with alphanumeric'
			];
		$validator = Validator::make($request->all(), [
			'password' => 'required|regex:/^.*(?=.{8,})(?=.*[a-z])(?=.*[0-9]).*$/|confirmed',
			//'password' => 'required|min:8|confirmed|regex:/^.*(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*?[#?!@$%^&*-]).*$/',
			'password_confirmation' => 'required'
		],$messages);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			return response()->json(['status' => 'Failure', 'message' => '<ul>' . $str . '</ul>'], 200);
		} else {
			$recid = Input::get('rec_id');
			$rec_id = Crypt::decrypt($recid);
			$res = User::where('rec_id',$rec_id)->first();
			$new_pwd = Input::get('password');
			$pwd = Hash::make($new_pwd);
			$datas = array('password' => $pwd);
			User::where('rec_id',$rec_id)->update(['password' => $pwd]);

			return response()->json(['status' => 'Success', 'message' => 'Password updated successfully, Please Sign In!', 'role' => $res['user_role']], 200);
		}
	}

	public function agents(Request $request)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['user_id'];
		$user = User::where(array('user_id' => $userId))->first();
		$data['userInfo'] = $user;
		$searchKey = $request->query('searchKey');
		if ($userInfo['admin_login'] == 1) {
			if (!empty($request->query('searchKey'))){

				$data['resellers_data'] = User::where(['user_role'=>3])
				->where(function($query) use($searchKey) {
               			 return $query->where(DB::raw('concat(first_name," ",last_name)'), 'LIKE', '%' . $searchKey . '%')->orWhere('email', 'LIKE', '%' . $searchKey . '%');
            		})
				->orderBy("rec_id", "DESC")->paginate(50);

			}else{
				$data['resellers_data'] = User::where(['user_role'=>3])->orderBy("rec_id", "DESC")->paginate(50);
			}

		} else {
			if (!empty($request->query('searchKey'))){

				$data['resellers_data'] = User::where(['user_role'=>3,'status'=> 1,'referral_userid' => $userInfo['rec_id']])
				->where(function($query) use($searchKey) {
               			 return $query->where(DB::raw('concat(first_name," ",last_name)'), 'LIKE', '%' . $searchKey . '%')->orWhere('email', 'LIKE', '%' . $searchKey . '%');
            		})
				->orderBy("rec_id", "DESC")->paginate(50);

			}else{
				$data['resellers_data'] = User::where(['user_role'=>3,'status'=> 1,'referral_userid' => $userInfo['rec_id']])->orderBy("rec_id", "DESC")->paginate(50);
			}
		}
		$data['searchKey'] = $searchKey;
		$data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();
		$profile_image = ($data['userInfo']['image'] != '') ? $data['userInfo']['image'] : 'profile_pic.png';
		$data['userInfo']['profile_image'] = $profile_image;
		return view("agents")->with($data);
	}

	public function agentView($agentId)
	{
		$userInfo = Auth::user();
		$userId = $userInfo['rec_id'];
		$agentId = base64_decode($agentId);
		$data['userInfo'] = User::where(array('rec_id' => $userId))->first();
		$agentInfo = User::where(array('rec_id' => $agentId))->first();
		$data['agentInfo'] = $agentInfo;
		$data['country'] = Country::select('country_name')->where('countryid', '=', $agentInfo->country_id)->first();
		return view("agent-view")->with($data);
	}

	public function agentNew()
	{
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$data['userInfo'] = $userInfo;
		$data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();
		if($userInfo['admin_login'] == 1){
			$userInfo['commission_perc'] = 100;
		}else{
			$userInfo['commission_perc'] = ($userInfo->commission_perc == 0 ? 0 : $userInfo->commission_perc-1);
		}
		return view('agent-new')->with($data);
	}

	public function createAgent(Request $request)
	{
		$admin_id = config('constants.ADMIN_ID');
		$userInfo = Auth::user();
		$lguserId = $userInfo['rec_id'];
		if($userInfo['admin_login'] == 1){
			$userInfo['commission_perc'] = 100;
			$login_userId = $admin_id;
		}else{
			$userInfo['commission_perc'] = ($userInfo->commission_perc == 0 ? 0 : $userInfo->commission_perc-1);
			$login_userId = $userInfo['rec_id'];
		}
		//echo '<pre>';print_R($request->all());exit;
		$validator = Validator::make($request->all(), [
            'email' => 'required|email|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$/|unique:users',
            'password' => 'required|regex:/^.*(?=.{8,})(?=.*[a-z])(?=.*[0-9]).*$/|same:confirm_password',
			'confirm_password' => 'required',
			'first_name' => 'required|string|min:3|max:255',
			'last_name' => 'required|string|min:3|max:255',
			'commission_perc' => 'required'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			return Redirect::back()->withErrors(['<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>']);
		} else {
            $password = $request->password;
			$email = $request->email;
			$first_name = $request->first_name;
			$last_name = $request->last_name;
			$gender = $request->gender;
			$address = $request->shipping_address;
			$country = $request->country;
			$country_code = $request->country_code;

			$firstCharacter = $request->mobile[0];
			if($firstCharacter == 0){
			    $mbl = ltrim($request->mobile, '0');
			}else{
			    $mbl = $request->mobile;
			}

			$mobile = $country_code . "-" . $mbl;
			$commission_perc = $request->commission_perc;

			if ($commission_perc > $userInfo['commission_perc']) {
				Session::flash('message', 'Commision must be less than ' . $userInfo['commission_perc']);
				Session::flash('alert','Failure');
				return back()->withInput();
			}

			$userId = self::generateUserId('AGT', $first_name);
			$us_cnt = User::where('user_id', $userId)->count();
			if ($us_cnt == 1) {
				$user_id = self::generateUserId('AGT', $first_name);
			} else {
				$user_id = $userId;
			}
			$ref_code = self::generateReferralCode($first_name);
			$ref_cnt = User::where('refferallink_text', $ref_code)->count();
			if ($ref_cnt == 1) {
				$referral_code = self::generateReferralCode($first_name);
			} else {
				$referral_code = $ref_code;
			}

			$input = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$input_length = strlen($input);
			$random_string = '';
			for($i = 0; $i < 9; $i++) {
				$random_character = $input[mt_rand(0, $input_length - 1)];
				$random_string .= $random_character;
			}
            //$pwd = $random_string;
            $pwd = $password;
			$hashpwd = Hash::make($pwd);
            $encrypted_plain_pass=safe_encrypt($password,config('constants.encrypt_key'));
			$user = User::create([
				'user_id' => $user_id,
				'referral_userid' => $login_userId,
				'first_name' => $first_name,
				'last_name' => $last_name,
				'email' => $email,
                'password' => $hashpwd,
                'plain_password'=>$encrypted_plain_pass,
				'gender' => $gender,
				'shipping_address' => $address,
				'country_id' => $country,
				'telephone' => $mobile,
				'commission_perc' => $commission_perc,
				'refferallink_text' => $referral_code,
				'user_role' => 3,
				'registration_date' => date('Y-m-d H:i:s'),
                'created_by' => $lguserId,
                'email_verify' => 1,
                'status' => 1
			]);
			$last_inserted_id = $user->rec_id;

            //User::where('rec_id',$last_inserted_id)->update(['email_verify' => 1,'status' => 1]);

			$wallet = Wallet::create([
				'user_id' => $last_inserted_id,
				'amount' => 0
			]);

			Users_tree::create([
				'agent_id' => $last_inserted_id,
				'reseller_id' => $login_userId
			]);

			$l = 1;
			$nom = $login_userId;
			$user_role = 3;
			while ($nom != 999) {
				if ($nom != 999 && $l < 150) {
					Unilevel_tree::create([
						'down_id' => $last_inserted_id,
						'upliner_id' => $nom,
						'level' => $l,
						'user_role' => $user_role
					]);
					$l++;
					$results = User::where('rec_id', $nom)->select('referral_userid')->first();
					$nom = $results->referral_userid;
				}
			}

			$data['useremail'] = array('name' => $first_name . ' ' . $last_name, 'user_id' => $last_inserted_id, 'email' => $email,'type'=>'Agent', 'referral_link' => $referral_code, 'password' => $pwd,'user_role' => 3);
			$emailid = array('toemail' => $email);
			Mail::send(['html' => 'email_templates.verify-email'], $data, function ($message) use ($emailid) {
				$message->to($emailid['toemail'], 'Email Verification')->subject('Email Verification');
				$message->from('noreply@bestbox.net', 'BestBox');
			});

			Session::flash('result', 'Agent Created Successfully');
			Session::flash('alert','Success');
			return Redirect::back();
		}
	}

	public function agentEdit($agentId)
	{
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		$data['userInfo'] = $userInfo;
		if($userInfo['admin_login'] == 1){
			$userInfo['commission_perc'] = 100;
		}else{
			$userInfo['commission_perc'] = $userInfo->commission_perc-1;
		}
		$agent_id = base64_decode($agentId);
		$agentInfo = User::where(array('rec_id' => $agent_id))->first();
		$telephone = explode('-', $agentInfo->telephone);
		$agentInfo->telephone = $telephone[1];
		$agentInfo->country_code = $telephone[0];
		$data['agentData'] = $agentInfo;
		$data['country_data'] = DB::table('country')->orderBy('country_name', 'ASC')->get();
		return view('agent-edit')->with($data);
	}

	public function updateAgentData(Request $request)
	{
		$userInfo = Auth::user();
		$login_userId = $userInfo['rec_id'];
		if($userInfo['admin_login'] == 1){
			$userInfo['commission_perc'] = 100;
		}else{
			$userInfo['commission_perc'] = $userInfo->commission_perc-1;
		}

		$validator = Validator::make($request->all(), [
			'first_name' => 'required|string|min:2|max:255',
			'last_name' => 'required|string|min:2|max:255',
			'commission_perc' => 'required',
			'agent_id' => 'required'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			return Redirect::back()->withErrors(['<ul>' . $str . '</ul>', '<ul>' . $str . '</ul>']);
		} else {
			$first_name = $request->first_name;
			$last_name = $request->last_name;
			$gender = $request->gender;
			$address = $request->shipping_address;
			$country = $request->country;
			$country_code = $request->country_code;

			$firstCharacter = $request->mobile[0];
			if($firstCharacter == 0){
			    $mbl = ltrim($request->mobile, '0');
			}else{
			    $mbl = $request->mobile;
			}

			$mobile = $country_code . "-" . $mbl;
			$commission_perc = $request->commission_perc;
			$agent_id = base64_decode($request->agent_id);

			if ($commission_perc > $userInfo['commission_perc']) {
				Session::flash('message', 'Commision must be less than ' . $userInfo['commission_perc']);
				Session::flash('alert','Failure');
				return back()->withInput();
			}
			$agentData = array(
				'first_name' => $first_name,
				'last_name' => $last_name,
				'gender' => $gender,
				'shipping_address' => $address,
				'country_id' => $country,
				'telephone' => $mobile,
				'commission_perc' => $commission_perc
			);

			$result = User::where(array('rec_id' => $agent_id))->update($agentData);
			Session::flash('result', 'Agent Data Updated Successfully');
			Session::flash('alert','Success');
			return back()->withInput();
		}
	}

	public function mobile_menu_settings()
	{
		return view("mobile_menu_settings");
	}

	public function checkEmailExist(Request $request){
		$email = trim($request->email);
		$validator = Validator::make($request->all(), [
			'email' => 'required|email|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$/'
		]);
		if ($validator->fails()) {
			$errs = $validator->messages()->all();
			$str = '';
			foreach ($errs as $arr) {
				$str = $str . '<li>' . $arr . '</li>';
			}
			return response()->json(['status' => 'Not valid', 'Result' => ''], 200);
		} else {
			$count = User::where(['email'=> $email])->count();
			if($count>0) {
				return response()->json(['status' => 'Failure', 'Result' => 'Email Already Exists'], 200);
			}else{
				return response()->json(['status' => 'Success', 'Result' => 'Email Id available'], 200);
			}
		}
	}
}

<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use Validator;
use Session;
use App\User;
use App\Wallet;
use App\Unilevel_tree;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class TreeViewController extends Controller
{
	public function tree_view(Request $request)
	{ 
		$sessid = Session::getId();
		$userinfo = Auth::user();
		//$data['userInfo'] = $userinfo;
		$admin_id = config('constants.ADMIN_ID');
		$searchKey = $request->query('searchKey');
		if($userinfo['admin_login'] == 1){
			$userId = $admin_id;
		}else{
			$userId = $userinfo['rec_id'];
		}
		if (!empty($request->query('searchKey'))){
			if (!empty($searchKey) && filter_var($searchKey, FILTER_VALIDATE_EMAIL)) {
				$res = User::where('users.email','LIKE',$searchKey)->first();
			}else{
				$res = User::where('users.user_id','=',$searchKey)->orWhereRaw("concat(users.first_name, ' ', users.last_name) like '%$searchKey%' ")->first();
			}	
					
			if(!empty($res) && $res->rec_id == $userId){
				$data['userInfo'] = $userinfo;
				$data['wallet'] = Wallet::where(array('user_id' => $userId))->first();
				$data['treeview'] = Unilevel_tree::where('upliner_id',$userId)->where('level',1)->get()->toArray();
			}
			else if(!empty($res)){
				$data['wallet'] = Wallet::where(array('user_id' => $res->rec_id))->first();
				$cnt = Unilevel_tree::where('down_id',$res->rec_id)->where('upliner_id',$userId)->count();
				if($cnt == 1){
					$data['userInfo'] = $res;
					$data['treeview'] = Unilevel_tree::where('upliner_id',$res->rec_id)->where('level',1)->get()->toArray();					
				}else{
					$data['userInfo'] = array();
				}				
			}
			else{
					$data['userInfo'] = array();
				}
			
		}else{
			$data['userInfo'] = $userinfo;
			$data['wallet'] = Wallet::where(array('user_id' => $userId))->first();
			$data['treeview'] = Unilevel_tree::where('upliner_id',$userId)->where('level',1)->get()->toArray();
		}
		
		$data['searchKey'] = $searchKey;
		return view('tree_view')->with($data);
	}
	public function getunilevelData(Request $request){
		$rec_id = Input::get('user_id');
		$first_level_users = Unilevel_tree::where('upliner_id',$rec_id)->where('level',1)->get()->toArray();
		$arr = array();
		
		foreach ($first_level_users as $val) {
			$downuser=\App\User::where("rec_id",$val['down_id'])->where('status',1)->first();
			if($downuser!==null){

				$downuserscount = Unilevel_tree::join('users', 'users.rec_id', '=', 'unilevel_tree.down_id')->where('unilevel_tree.upliner_id',$downuser['rec_id'])->where('unilevel_tree.level',1)->where('users.status',1)->count();
				$display="none";
				$no_display="block";
				if($downuserscount>0){
					$display="block";
					$no_display="none";
				}
				$role="Customer";
				if($downuser['user_role']==1){
					$role= "Super Admin";
				}else if($downuser['user_role']==2){
					$role= "Reseller";
				}else if($downuser['user_role']==3){
					$role= "Agent";
				}else{
					$role= "Customer";
				}
				$arr[] = array("name"=>$downuser['first_name']." ".$downuser['last_name'],"email"=>$downuser['email'],"down_user_id"=>$downuser['rec_id'],"level_display"=>$display,"no_child"=>$no_display,"user_role"=>$role,"user_id"=>$downuser['user_id']);
			}
			
		}
			
		return $arr;
	
	}

}
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
use App\Packages;
use App\Purchase_order_details;
use App\Package_purchase_list;
use App\Models\registerModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PackagesController extends Controller
{
	
	
	public function plans()
	{ 
		//get packages
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		$data['packages'] = Packages::select('*')->where('status','=',1)->orderBy("id", "DESC")->paginate(20);
		return view('plans')->with($data);
	}
	
	// Add New Package
	public function addNewPackageInfo(Request $request) 
	{ 
		
		//get packages
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		
		$packageName = Input::get("packageName");
		$uploads = Input::get("uploads");
		$amount = Input::get("amount");
		$discount = Input::get("discount");
		$effective_amount = Input::get("effective_amount");
		$description = Input::get("description");
		$subscription_fee = Input::get("subscription_fee");
		$setupbox_fee = Input::get("setupbox_fee");
		$duration_months = Input::get("duration");
		$action = Input::get("action");
		$created_at = date('Y-m-d H:i:s');
		
		$pgkdiscountAmt = Input::get("pgkdiscountAmt");
		
		if($packageName == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'Please Enter Package Name'], 200);
		}else if($amount == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'Please Enter Package Value'], 200);
		}else{
			
			if(empty($setupbox_fee)){
				$setupbox_status=2;	
			}else{
				$setupbox_status=1;
			}
			
			if(empty($duration_months)){
				$duration=0;	
			}else{
				$duration=$duration_months;
			}
			
			if ($request->has('uploads')) { 
				$org_name = $request->file('uploads')->getClientOriginalName();
				$exts = explode('.', $org_name);
				if (count($exts) == 2) {
					$image = $request->file('uploads');
					//return response()->json(['status' => 'Failure', 'Result' => $image,'org_name'=>$org_name], 200);
					$fileType = $image->getClientOriginalExtension();
					$fileTyp = strtolower($fileType);
					$allowedTypes = array("jpeg", "jpg", "png");
					if (in_array($fileTyp, $allowedTypes)) {

						$destinationPath = base_path('/public/packages');
						$result = $image->move($destinationPath, $org_name);
						if ($result) {
		
							$data = [
								'package_name' => $packageName,
								'package_image' => $org_name,
								'subscription_fee' => $subscription_fee,
								'setupbox_fee' => $setupbox_fee,
								'package_value' => $amount,
								'discount' => $discount,
								'effective_amount' => $effective_amount,
								'description' => $description,
								'duration' => $duration,
								'setupbox_status' => $setupbox_status,
								'discount_by_amt' => $pgkdiscountAmt,
								'created_at' => $created_at,
								
							];
							//print_r($data);exit;
							$res = Packages::insert($data);
							
							return response()->json(['status' => 'Success', 'Result' => 'Package Created Successfully.'], 200);

						} else {
							
							return response()->json(['status' => 'Failure', 'Result' => 'Something went wrong in Uploading image'], 200);
						}

					} else {
						return response()->json(['status' => 'Failure', 'Result' => 'Please Upload only JPEG,JPG,PNG images only'], 200);
					}
				} else {
					return response()->json(['status' => 'Failure', 'Result' => 'Multy extension is not allowed'], 200);
				}
			} else {
			
				$data = [
							'package_name' => $packageName,
							'subscription_fee' => $subscription_fee,
							'setupbox_fee' => $setupbox_fee,
							'package_value' => $amount,
							'discount' => $discount,
							'effective_amount' => $effective_amount,
							'description' => $description,
							'duration' => $duration,
							'setupbox_status' => $setupbox_status,
							'discount_by_amt' => $pgkdiscountAmt,
							'created_at' => $created_at,
								
						];
							//print_r($data);exit;
						$res = Packages::insert($data);
				
				return response()->json(['status' => 'Success', 'Result' => 'Package Created Successfully.'], 200);
			}
			
			
		}
		
	}
	
	// Edit Package Info
	public function getEditPackageInfo()
	{ 
		//get packages
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		
		$rec_id = Input::get("rec_id");
		$action = Input::get("action");
		if(!empty($rec_id)){
			$pkg = Packages::select('*')->where('id','=',$rec_id)->where('status','=',1)->first();
			if(!empty($pkg)){
				$data = array(
								'id' => $pkg->id,
								'package_name' => $pkg->package_name,
								'package_image' => $pkg->package_image,
								'subscription_fee' => $pkg->subscription_fee,
								'setupbox_fee' => $pkg->setupbox_fee,
								'package_value' => $pkg->package_value,
								'discount' => $pkg->discount,
								'discount_by_amt' => $pkg->discount_by_amt,
								'effective_amount' => $pkg->effective_amount,
								'duration' => $pkg->duration,
								'description' => $pkg->description,
							);
				return response()->json(['status' => 'Success', 'Result' => $data], 200);
							
			}else{
				return response()->json(['status' => 'Failure', 'Result' => "Something Went wrong"], 200);
			}
		}else{
			return response()->json(['status' => 'Failure', 'Result' => "Something Went wrong"], 200);
		
		}
		
	}
	// Update Package 
	
	public function updatePackageInfo(Request $request) 
	{ 
		
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		
		$packageName = Input::get("editpackageName");
		$uploads = Input::get("uploads");
		$amount = Input::get("editamount");
		$discount = Input::get("editdiscount");
		$effective_amount = Input::get("edieffective_amount");
		$description = Input::get("editdescription");
		$duration_months = Input::get("editduration");
		
		$subscription_fee = Input::get("editsubscription_fee");
		$setupbox_fee = Input::get("editsetupbox_fee");
		//$setupbox_fee = Input::get("editsetupbox_fee");
		
		$edit_rec_id = Input::get("edit_rec_id");
		$editpkgdiscountAmt = Input::get("editpkgdiscountAmt");
		
		$action = Input::get("action");
		$created_at = date('Y-m-d H:i:s');
		
		if($packageName == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'Please Enter Package Name'], 200);
		}else if($edit_rec_id == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'Record ID Missing'], 200);
		}else if($amount == ""){
			return response()->json(['status' => 'Failure', 'Result' => 'Please Enter Package Value'], 200);
		}else{
			if(empty($setupbox_fee)){
				$setupbox_status=2;	
			}else{
				$setupbox_status=1;
			}
			if(empty($duration_months)){
				$duration=0;	
			}else{
				$duration=$duration_months;
			}
			if ($request->has('uploads_edit')) { 
				$org_name = $request->file('uploads_edit')->getClientOriginalName();
				$exts = explode('.', $org_name);
				if (count($exts) == 2) {
					$image = $request->file('uploads_edit');
					//return response()->json(['status' => 'Failure', 'Result' => $image,'org_name'=>$org_name], 200);
					$fileType = $image->getClientOriginalExtension();
					$fileTyp = strtolower($fileType);
					$allowedTypes = array("jpeg", "jpg", "png");
					if (in_array($fileTyp, $allowedTypes)) {

						$destinationPath = base_path('/public/packages');
						$result = $image->move($destinationPath, $org_name);
						if ($result) {
		
							$data = [
								'package_name' => $packageName,
								'package_image' => $org_name,
								'subscription_fee' => $subscription_fee,
								'setupbox_fee' => $setupbox_fee,
								'package_value' => $amount,
								'discount' => $discount,
								'effective_amount' => $effective_amount,
								'description' => $description,
								'duration' => $duration,
								'setupbox_status' => $setupbox_status,
								'discount_by_amt' => $editpkgdiscountAmt,
								'updated_at' => $created_at,
								
							];
							//print_r($data);exit;
							$res = Packages::where('id','=',$edit_rec_id)->update($data);
							
							return response()->json(['status' => 'Success', 'Result' => 'Package Updated Successfully.'], 200);

						} else {
							
							return response()->json(['status' => 'Failure', 'Result' => 'Something went wrong in Uploading image'], 200);
						}

					} else {
						return response()->json(['status' => 'Failure', 'Result' => 'Please Upload only JPEG,JPG,PNG images only'], 200);
					}
				} else {
					return response()->json(['status' => 'Failure', 'Result' => 'Multy extension is not allowed'], 200);
				}
			} else {
			
				$data = [
								'package_name' => $packageName,
								'subscription_fee' => $subscription_fee,
								'setupbox_fee' => $setupbox_fee,
								'package_value' => $amount,
								'discount' => $discount,
								'effective_amount' => $effective_amount,
								'description' => $description,
								'duration' => $duration,
								'setupbox_status' => $setupbox_status,
								'discount_by_amt' => $editpkgdiscountAmt,
								'updated_at' => $created_at,
								
							];
							//print_r($data);exit;
							$res = Packages::where('id','=',$edit_rec_id)->update($data);
				
				return response()->json(['status' => 'Success', 'Result' => 'Package Updated Successfully.'], 200);
			}
			
			
		}
		
	}
	
	
	
	// delete Package
	public function deletePackageStatus()
	{ 
		//get packages
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		
		$rec_id = Input::get("rec_id");
		$action = Input::get("action");
		
		if (!empty($rec_id)) {
			$updata = array("status"=>0); 
			$res = Packages::where('id', '=', $rec_id)->update($updata);
			if ($res) {
				return response()->json(['status' => 'Success', 'Result' => "Updated"], 200);
			} else {
				return response()->json(['status' => 'Failure', 'Result' => "Something Went wrong"], 200);
			}
		} else {
			return response()->json(['status' => 'Failure', 'Result' => "Record ID missing"], 200);
		}
	}
	
	// delete Package
	public function deletePackageImage()
	{ 
		//get packages
		$sessid = Session::getId();
		$userinfo = Auth::user();
		$userid = $userinfo['user_id'];
		
		$rec_id = Input::get("delete_id");
		$action = Input::get("action");
		
		if (!empty($rec_id)) {
			$updata = array("package_image"=>""); 
			$res = Packages::where('id', '=', $rec_id)->update($updata);
			if ($res) {
				return response()->json(['status' => 'Success', 'Result' => "Updated"], 200);
			} else {
				return response()->json(['status' => 'Failure', 'Result' => "Something Went wrong"], 200);
			}
		} else {
			return response()->json(['status' => 'Failure', 'Result' => "Record ID missing"], 200);
		}
	}

}
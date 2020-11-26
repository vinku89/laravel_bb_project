<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'rec_id';

    protected $fillable = [
        'user_id','referral_userid','first_name','last_name', 'email', 'email_verify', 'password','user_role','refferallink_text','commission_perc','telephone','address','address2','gender','married_status','country_id','registration_date','zipcode','shipping_address','shipping_country','shipping_user_mobile_no','referral_join','status','admin_login','admin_status','cms_username','cms_password','iptv_country_id','iptv_country_name','created_by','sub_user','cms_start_date','cms_expiry_date','plain_password','application_id','user_mobile_app_version','user_tv_version','user_mobile_versionname','is_force_logout'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
	public function findForPassport($identifier) {
        return $this->orWhere('email', $identifier)->orWhere('user_id', $identifier)->first();
	}

    public static function ScopeGetUserInfo($query,$filter,$sort='desc'){
        if($sort==""){
           $sort='desc';
        }
        if($filter=="all" || $filter==""){
            return  User::leftjoin('wallet', 'users.rec_id', '=', 'wallet.user_id')
                ->where('users.status', '=', 1)
                ->where('users.user_role','!=',0)->where('admin_login',0)->where('users.rec_id','!=',1000)->select('users.rec_id','users.user_id','users.email','users.first_name','users.last_name','users.user_role','users.plain_password','wallet.amount')->orderBy('wallet.amount',$sort)->paginate(100);
        }else{
            return  User::leftjoin('wallet', 'users.rec_id', '=', 'wallet.user_id')
                ->where('users.status', '=', 1)
                ->where('users.user_role','!=',0)->where('admin_login',0)->where('users.rec_id','!=',1000)->where('users.user_role',$filter)->select('users.rec_id','users.user_id','users.email','users.first_name','users.last_name','users.user_role','users.plain_password','wallet.amount')->orderBy('wallet.amount',$sort)->paginate(100);
        }
    }

    public static function ScopeGetUserInfo2($query,$filter,$sort='desc'){
        if($sort==""){
           $sort='desc';
        }
        if($filter=="all" || $filter==""){
            return  User::leftjoin('wallet', 'users.rec_id', '=', 'wallet.user_id')
                //->where('users.status', '=', 1)
                ->where('users.user_role','!=',0)->where('admin_login',0)->where('users.rec_id','!=',1000)->select('users.rec_id','users.user_id','users.email','users.first_name','users.last_name','users.user_role','users.status','users.registration_date','users.plain_password','wallet.amount')->orderBy('users.registration_date',$sort)->paginate(100);
        }else{
            return  User::leftjoin('wallet', 'users.rec_id', '=', 'wallet.user_id')
                //->where('users.status', '=', 1)
                ->where('users.user_role','!=',0)->where('admin_login',0)->where('users.rec_id','!=',1000)->where('users.user_role',$filter)->select('users.rec_id','users.user_id','users.email','users.first_name','users.last_name','users.user_role','users.status','users.registration_date','users.plain_password','wallet.amount')->orderBy('users.registration_date',$sort)->paginate(100);
        }
    }

    public static function ScopeGetUserInfo3($query,$filter,$sort='desc'){
        if($sort==""){
           $sort='desc';
        }
        if($filter=="all" || $filter==""){
            return  User::leftjoin('wallet', 'users.rec_id', '=', 'wallet.user_id')
                ->where('users.status', '=', 1)
                ->where('users.user_role','!=',0)->where('admin_login',0)->where('users.rec_id','!=',1000)->select('users.rec_id','users.user_id','users.email','users.first_name','users.last_name','users.user_role','users.plain_password','wallet.amount')->get();
        }else{
            return  User::leftjoin('wallet', 'users.rec_id', '=', 'wallet.user_id')
                ->where('users.status', '=', 1)
                ->where('users.user_role','!=',0)->where('admin_login',0)->where('users.rec_id','!=',1000)->where('users.user_role',$filter)->select('users.rec_id','users.user_id','users.email','users.first_name','users.last_name','users.user_role','users.plain_password','wallet.amount')->get();
        }
    }

    public static function ScopeSumOfWalletAmount($query){
             
        return  User::leftjoin('wallet', 'users.rec_id', '=', 'wallet.user_id')
                ->where('users.status', '=', 1)->where('users.user_role','!=',0)->where('admin_login',0)->where('users.rec_id','!=',1000)->sum('wallet.amount');
    }

    public static function ScopeGetUserInfoBySearchTerm($query,$search,$filter,$sort='desc'){
        //DB::connection()->enableQueryLog();
        if($search=='all'){
            $search="";
        }
        if($sort==""){
            $sort='desc';
        }
        if($filter=="all" || $filter==""){
            return User::leftjoin('wallet', 'users.rec_id', '=', 'wallet.user_id')
                ->where('users.status', '=', 1)
                ->where('users.user_role','!=',0)->where('admin_login',0)->where('users.rec_id','!=',1000)
                ->where(function ($query) use ($search){ $query->where(\DB::raw('CONCAT_WS(" ", `first_name`, `last_name`)'), 'like', '%' . $search . '%')->orWhere('users.email','like','%'.$search.'%')->orWhere('users.user_id','like','%'.$search.'%');})->select('users.rec_id','users.user_id','users.email','users.first_name','users.last_name','users.user_role','users.plain_password','wallet.amount')->orderBy('wallet.amount',$sort)->paginate(100);
        }else{
            return User::leftjoin('wallet', 'users.rec_id', '=', 'wallet.user_id')
                ->where('users.status', '=', 1)
                ->where('users.user_role','!=',0)->where('admin_login',0)->where('users.rec_id','!=',1000)
                ->where(function ($query) use ($search){ $query->where(\DB::raw('CONCAT_WS(" ", `first_name`, `last_name`)'), 'like', '%' . $search . '%')->orWhere('users.email','like','%'.$search.'%')->orWhere('users.user_id','like','%'.$search.'%');})->where('users.user_role',$filter)->select('users.rec_id','users.user_id','users.email','users.first_name','users.last_name','users.user_role','users.plain_password','wallet.amount')->orderBy('wallet.amount',$sort)->paginate(100);
        }
        
        /*$queries = DB::getQueryLog();
        print_r($queries);exit;*/
    }

    public static function ScopeGetUserInfoBySearchTerm2($query,$search,$filter,$sort='desc'){
        //DB::connection()->enableQueryLog();
        if($search=='all'){
            $search="";
        }
        if($sort==""){
            $sort='desc';
        }
        if($filter=="all" || $filter==""){
            return User::leftjoin('wallet', 'users.rec_id', '=', 'wallet.user_id')
                //->where('users.status', '=', 1)
                ->where('users.user_role','!=',0)->where('admin_login',0)->where('users.rec_id','!=',1000)
                ->where(function ($query) use ($search){ $query->where(\DB::raw('CONCAT_WS(" ", `first_name`, `last_name`)'), 'like', '%' . $search . '%')->orWhere('users.email','like','%'.$search.'%')->orWhere('users.user_id','like','%'.$search.'%');})->select('users.rec_id','users.user_id','users.email','users.first_name','users.last_name','users.user_role','users.status','users.registration_date','users.plain_password','wallet.amount')->orderBy('users.registration_date',$sort)->paginate(100);
        }else{
            return User::leftjoin('wallet', 'users.rec_id', '=', 'wallet.user_id')
                //->where('users.status', '=', 1)
                ->where('users.user_role','!=',0)->where('admin_login',0)->where('users.rec_id','!=',1000)
                ->where(function ($query) use ($search){ $query->where(\DB::raw('CONCAT_WS(" ", `first_name`, `last_name`)'), 'like', '%' . $search . '%')->orWhere('users.email','like','%'.$search.'%')->orWhere('users.user_id','like','%'.$search.'%');})->where('users.user_role',$filter)->select('users.rec_id','users.user_id','users.email','users.first_name','users.last_name','users.user_role','users.status','users.plain_password','users.registration_date','wallet.amount')->orderBy('users.registration_date',$sort)->paginate(100);
        }
        
        /*$queries = DB::getQueryLog();
        print_r($queries);exit;*/
    }

    public static function ScopeGetUserInfoBySearchTerm3($query,$search,$filter,$sort='desc'){
        //DB::connection()->enableQueryLog();
        if($search=='all'){
            $search="";
        }
        if($sort==""){
            $sort='desc';
        }
        if($filter=="all" || $filter==""){
            return User::leftjoin('wallet', 'users.rec_id', '=', 'wallet.user_id')
                ->where('users.status', '=', 1)
                ->where('users.user_role','!=',0)->where('admin_login',0)->where('users.rec_id','!=',1000)
                ->where(function ($query) use ($search){ $query->where(\DB::raw('CONCAT_WS(" ", `first_name`, `last_name`)'), 'like', '%' . $search . '%')->orWhere('users.email','like','%'.$search.'%')->orWhere('users.user_id','like','%'.$search.'%');})->select('users.rec_id','users.user_id','users.email','users.first_name','users.last_name','users.user_role','users.plain_password','wallet.amount')->get();
        }else{
            return User::leftjoin('wallet', 'users.rec_id', '=', 'wallet.user_id')
                ->where('users.status', '=', 1)
                ->where('users.user_role','!=',0)->where('admin_login',0)->where('users.rec_id','!=',1000)
                ->where(function ($query) use ($search){ $query->where(\DB::raw('CONCAT_WS(" ", `first_name`, `last_name`)'), 'like', '%' . $search . '%')->orWhere('users.email','like','%'.$search.'%')->orWhere('users.user_id','like','%'.$search.'%');})->where('users.user_role',$filter)->select('users.rec_id','users.user_id','users.email','users.first_name','users.last_name','users.user_role','users.plain_password','wallet.amount')->get();
        }
        
        /*$queries = DB::getQueryLog();
        print_r($queries);exit;*/
    }
	
}

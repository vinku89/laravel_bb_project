<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Settings extends Model
{
	protected $table = 'settings';
	protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_bonus', 'bonus_description', 'android_app_code','android_app_version', 'ios_app_version', 'tab_mobile_android_version', 'tab_mobile_android_version_name','tab_mobile_ios_version'
    ];


}

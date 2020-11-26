<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class UsersDevicesList extends Model
{
	protected $table = 'users_devices_list';
	protected $primaryKey = 'rec_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','device_id','device_type','device_version','is_login','is_online'
    ];


}

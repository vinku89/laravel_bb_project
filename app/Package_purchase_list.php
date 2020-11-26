<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Package_purchase_list extends Model
{
	protected $table = 'package_purchased_list';
	protected $primaryKey = 'rec_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'package_id','subscription_date','expiry_date','active_package','purchased_from_userid'
    ];


}

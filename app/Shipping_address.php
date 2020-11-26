<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Shipping_address extends Model
{
	protected $table = 'shipping_address';
	protected $primaryKey = 'rec_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','user_id','shipping_country','shipping_mobile_no', 'shipping_address','default_address','created_at','updated_at','profile_screen'
    ];


}

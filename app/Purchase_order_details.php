<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Purchase_order_details extends Model
{
	protected $table = 'purchase_order_details';
	protected $primaryKey = 'rec_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','purchased_date','order_id','amount', 'attachment','purchased_from','aliexpress_email','shipping_address','sender_id','description','status','package_purchased_id','type','is_shipped'
    ];


}

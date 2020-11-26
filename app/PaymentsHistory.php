<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class PaymentsHistory extends Model
{
	protected $table = 'payments_history';
	protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','user_id', 'customer_id','order_id','transaction_no','package_id','crypto','amount_in_usd','amount_in_crypto','subscription_type','subscription_desc','transaction_hash','wallet_address','paid_status','reason','created_at','updated_at','purchased_from','shipping_address'
    ];


}

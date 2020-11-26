<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Sales extends Model
{
	protected $table = 'sales';
	protected $primaryKey = 'rec_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'added_date', 'user_id','customer_id','package_id','sales_amount', 'subscription_amount','commission','commission_per','description'
    ];


}

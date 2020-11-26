<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Commissions extends Model
{
	protected $table = 'commissions';
	protected $primaryKey = 'rec_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','agent_id', 'sender_user_id','sales_amount','subscription_amount','commission','commission_perc','added_date','commission_type','description'
    ];


}

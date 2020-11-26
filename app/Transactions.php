<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Transactions extends Model
{
	protected $table = 'transactions';
	protected $primaryKey = 'rec_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_no','user_id','sender_id','receiver_id', 'received_date','package_id','credit','debit','balance','ttype','description','wallet_type','status','notification','notification_message'
    ];


}

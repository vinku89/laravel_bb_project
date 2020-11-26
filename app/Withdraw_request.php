<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Withdraw_request extends Model
{
	protected $table = 'withdraw_request';
	protected $primaryKey = 'rec_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_no','withdraw_id','user_id','request_amt','request_date', 'wallet_type','wallet_address','admin_response_date','credit_crypto_amt','cryptoTousd_value','transaction_hash','status','approved_by'
    ];


}

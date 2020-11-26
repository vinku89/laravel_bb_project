<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Wallet extends Model
{
	protected $table = 'wallet';
	protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'amount'
    ];


}

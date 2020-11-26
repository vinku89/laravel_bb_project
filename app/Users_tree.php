<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Users_tree extends Model
{
	protected $table = 'users_tree';
	protected $primaryKey = 'rec_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 'agent_id','reseller_id','admin_id'
    ];


}

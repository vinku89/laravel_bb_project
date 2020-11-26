<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Unilevel_tree extends Model
{
	protected $table = 'unilevel_tree';
	protected $primaryKey = 'rec_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'down_id', 'upliner_id','level','user_role'
    ];


}

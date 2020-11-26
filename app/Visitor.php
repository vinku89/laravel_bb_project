<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Visitor extends Model
{
	protected $table = 'visitor';
	protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'username','ip_address','browser_type','req_from'
    ];


}

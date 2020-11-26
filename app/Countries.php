<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Countries extends Model
{
	protected $table = 'countries';
	protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'code','name','flag','is_active'
    ];


}

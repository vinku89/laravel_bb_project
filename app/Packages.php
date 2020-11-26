<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Packages extends Model
{
	protected $table = 'packages';
	protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'package_name', 'amount','discount','description','status'
    ];


}

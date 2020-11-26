<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Announcements extends Model
{
	protected $table = 'announcements';
	protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'platform_type','title','description','popup','status'
    ];


}

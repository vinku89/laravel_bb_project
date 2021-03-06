<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class EPG_list2 extends Model
{
	protected $table = 'epg_list2';
	protected $primaryKey = 'rec_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'xmltv_id', 'title','description','start_time','stop_time', 'start_timezone','stop_timezone','country_id'
    ];

}

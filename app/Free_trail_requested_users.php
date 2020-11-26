<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Free_trail_requested_users extends Model
{
	protected $table = 'free_trail_requested_users';
	protected $primaryKey = 'rec_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','trail_requested_time','trail_start_time','trail_end_time','status','extend','extend_requested_date', 'extend_hours','channel_id'
    ];


}

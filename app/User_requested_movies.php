<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class User_requested_movies extends Model
{
	protected $table = 'user_requested_movies';
	protected $primaryKey = 'rec_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','requested_movies','requested_date', 'status'
    ];


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Multiple_box_purchase extends Model
{
	protected $table = 'multiple_box_purchase';
	protected $primaryKey = 'rec_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','sub_user_id','package_id','package_purchased_id'
    ];


}

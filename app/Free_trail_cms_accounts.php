<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Free_trail_cms_accounts extends Model
{
	protected $table = 'free_trail_cms_accounts';
	protected $primaryKey = 'rec_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'channel','cms_username','cms_password','status'
    ];


}
